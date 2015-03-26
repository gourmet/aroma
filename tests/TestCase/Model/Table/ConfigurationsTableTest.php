<?php
namespace Gourmet\Aroma\Test\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class ConfigurationsTableTest extends TestCase
{
    public $dropTables = true;

    public $fixtures = ['plugin.Gourmet/Aroma.configurations'];

    public function setUp()
    {
        parent::setUp();
        $this->Configurations = TableRegistry::get('Gourmet/Aroma.Configurations');
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->Configurations);
    }

    public function testFindKv()
    {
        $result = $this->Configurations->find('kv')->toArray();
        $expected = [
            'some' => 'thing',
            'Aroma' => [
                'some' => 'thing'
            ]
        ];
        $this->assertEquals($expected, $result);
    }
}
