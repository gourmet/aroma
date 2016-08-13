<?php
namespace Gourmet\Aroma\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

abstract class AbstractConfigurationsTable extends Table implements ConfigurationsTableInterface
{

    /**
     * {@inheritdoc}
     *
     * @param \Cake\ORM\Query $query Query.
     * @param array $options Options.
     * @return \Cake\ORM\Query
     */
    public function findKv(Query $query, array $options)
    {
        return $query
            ->find('list', [
                'keyField' => 'path',
                'valueField' => 'value',
                'groupField' => 'namespace',
            ])
            ->formatResults(function ($results) {
                $resultSet = $results->toArray();
                if (isset($resultSet[''])) {
                    $resultSet += $resultSet[''];
                    unset($resultSet['']);
                }
                return $resultSet;
            });
    }
}
