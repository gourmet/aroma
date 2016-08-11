<?php
namespace Gourmet\Aroma\Core\Configure\Engine;

use Cake\Core\Configure\ConfigEngineInterface;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Gourmet\Aroma\Model\Table\ConfigurationsTableInterface;
use InvalidArgumentException;

class DbConfig implements ConfigEngineInterface
{
    const TABLE = 'Gourmet/Aroma.Configurations';

    /**
     * Cache configuration key.
     *
     * @var string
     */
    protected $_cacheConfig;

    /**
     * Instance of the configurations table.
     *
     * @var \Gourmet\Aroma\Model\Table\ConfigurationsTableInterface
     */
    protected $_table;

    /**
     * Constructor to inject the table and define the cache configuration to use.
     *
     * @param \Gourmet\Aroma\Model\Table\ConfigurationsTableInterface|string|null $table Table alias or instance.
     * @param string $cacheConfig Cache config alias.
     */
    public function __construct($table = null, $cacheConfig = 'default')
    {
        if (empty($table)) {
            $table = self::TABLE;
        }

        if (is_string($table)) {
            $table = TableRegistry::get($table);
        }

        if (!($table instanceof ConfigurationsTableInterface)) {
            throw new InvalidArgumentException(__(
                'Custom table should implement the `Gourmet\Aroma\Model\Table\ConfigurationsTableInterface`.'
            ));
        }

        $this->_cacheConfig = $cacheConfig;
        $this->_table = $table;
    }

    /**
     * Read method is used for reading configuration information from sources.
     * These sources can either be static resources like files, or dynamic ones like
     * a database, or other datasource.
     *
     * @param string $key Key to read.
     * @return array An array of data to merge into the runtime configuration
     */
    public function read($key)
    {
        $query = $this->_table->find('kv');

        if ($key !== '*') {
            $query->where([
                $this->_table->aliasField('namespace') . ' IS' => $key
            ]);
        }

        return $query
            ->cache(function ($q) {
                return md5(serialize($q->clause('where')));
            }, $this->_cacheConfig)
            ->toArray();
    }

    /**
     * {@inheritdoc}
     *
     * @param string $key The identifier to write to.
     * @param array $data The data to dump.
     * @return bool True on success or false on failure.
     */
    public function dump($key, array $data)
    {
        $data = Hash::flatten($data);
        array_walk($data, [$this, '_persist'], $key);
        array_filter($data);
        return (bool)$data;
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $value Value.
     * @param string $path Key path.
     * @param string $namespace Namespace.
     * @return bool
     */
    protected function _persist($value, $path, $namespace)
    {
        $table = $this->_table;
        $entity = $table->newEntity();
        $conditions = [
            $table->aliasField('namespace') => $namespace,
            $table->aliasField('path') => $path,
        ];

        if ($table->exists($conditions)) {
            $entity = $table->find()
                ->where($conditions)
                ->first();
        }

        return $table->patchEntity($entity, compact('namespace', 'path', 'value'))
            && $table->save($entity);
    }
}
