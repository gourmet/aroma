<?php
namespace Gourmet\Aroma\Model\Table;

use Cake\ORM\Query;

interface ConfigurationsTableInterface
{

    /**
     * Custom `find('list')`.
     *
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findKv(Query $query, array $options);
}