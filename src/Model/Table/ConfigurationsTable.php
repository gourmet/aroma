<?php
namespace Gourmet\Aroma\Model\Table;

use Cake\Collection\Collection;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ConfigurationsTable extends Table
{
    public function initialize(array $config)
    {
        $this->table('aroma_configurations');
        $this->displayField('value');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator->requirePresence('namespace', 'create')
            ->add('namespace', 'valid-namespace', ['rule' => '@[a-z0-9\\\.]+@'])

            ->requirePresence('path')
            ->notEmpty('path')

            ->requirePresence('value');

        return $validator;
    }

    public function findKv(Query $query, array $options)
    {
        return $query
            ->find('list', [
                'keyField' => 'path',
                'valueField' => 'value',
                'groupField' => 'namespace',
            ])
            ->formatResults(function ($results) {
                $resultset = $results->toArray();
                $resultset += $resultset[''];
                unset($resultset['']);
                return $resultset;
            });
    }
}
