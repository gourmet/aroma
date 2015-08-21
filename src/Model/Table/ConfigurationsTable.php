<?php
namespace Gourmet\Aroma\Model\Table;

use Cake\Validation\Validator;

class ConfigurationsTable extends AbstractConfigurationsTable
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
}
