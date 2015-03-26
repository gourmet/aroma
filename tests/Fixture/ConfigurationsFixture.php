<?php
namespace Gourmet\Aroma\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class ConfigurationsFixture extends TestFixture
{
    public $table = 'aroma_configurations';
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'null' => false, 'autoIncrement' => true],
        'namespace' => ['type' => 'string', 'length' => 255, 'null' => true],
        'path' => ['type' => 'string', 'length' => 255, 'null' => false],
        'value' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null],
        'created' => ['type' => 'datetime', 'null' => true],
        'modified' => ['type' => 'datetime', 'null' => true],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []]
        ]
    ];

    public $records = [
        [
            'id' => 1,
            'namespace' => null,
            'path' => 'some',
            'value' => 'thing',
            'created' => '2015-03-26 14:16:00',
            'modified' => '2015-03-26 14:16:00',
        ],
        [
            'id' => 2,
            'namespace' => 'Aroma',
            'path' => 'some',
            'value' => 'thing',
            'created' => '2015-03-26 14:16:00',
            'modified' => '2015-03-26 14:16:00',
        ]
    ];
}
