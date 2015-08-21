<?php
namespace Gourmet\Aroma\Model\Table;

use Cake\ORM\Query;

interface ConfigurationsTableInterface
{

    /**
     * Custom `find('list')`.
     *
     * @param \Cake\ORM\Query $query Query.
     * @param array $options Options.
     * @return \Cake\ORM\Query
     */
    public function findKv(Query $query, array $options);
}
