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

    protected $_cacheConfig;
    protected $_table;

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
                'Custom table should implement the `{0}`.',
                [ConfigrationsTableInterface::class]
            ));
        }

        $this->_cacheConfig = $cacheConfig;
        $this->_table = $table;
    }

    public function read($key)
    {
        return $this->_table
            ->find('kv')
            ->where([
                $this->_table->aliasField('namespace') => $key
            ])
            ->cache(function ($q) {
                return md5(serialize($q->clause('where')), $this->_cacheConfig);
            })
            ->toArray();
    }

    public function dump($key, array $data)
    {
        $data = Hash::flatten($data);
        array_walk($data, [$this, '_persist'], $key);
        array_filter($data);
        return (bool)$data;
    }

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
