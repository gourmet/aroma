<?php
namespace Gourmet\Aroma\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;

abstract class AbstractConfigurationsTable extends Table implements ConfigurationsTableInterface
{

    /**
     * {@inheritdoc}
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
                $resultSet += $resultSet[''];
                unset($resultSet['']);
                return $resultSet;
            });
    }
}
