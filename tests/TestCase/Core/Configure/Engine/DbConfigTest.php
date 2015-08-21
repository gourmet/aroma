<?php
namespace Gourmet\Aroma\Test\Core\Configure\Engine;

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;
use Cake\TestSuite\TestCase;
use Gourmet\Aroma\Core\Configure\Engine\DbConfig;
use StdClass;

class DbConfigTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $methods = ['exists', 'find', 'patchEntity', 'save'];
        $this->tableMock = $this->getMockForModel(DbConfig::TABLE, $methods);
        Configure::config('db', new DbConfig($this->tableMock));
    }

    public function tearDown()
    {
        parent::tearDown();
        unset($this->tableMock);
        Configure::drop('db');
        $keys = array_keys($this->_config());
        array_walk($keys, ['Cake\Core\Configure', 'delete']);
    }

    protected function _config()
    {
        return [
            'Foo' => [
                'bar' => 'foobar',
            ],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentExceptionThrown()
    {
        Configure::config('bad', new DbConfig(new StdClass()));
    }

    public function testRead()
    {
        $config = $this->_config();

        $query = $this->getMock('Cake\ORM\Query', [], [$this->tableMock->connection(), $this->tableMock]);

        $query->expects($this->once())
            ->method('where')
            ->with(['Configurations.namespace' => 'Editable'])
            ->will($this->returnValue($query));

        $query->expects($this->once())
            ->method('cache')
            ->will($this->returnValue($query));

        $query->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue($config));

        $this->tableMock->expects($this->once())
            ->method('find')
            ->with('kv')
            ->will($this->returnValue($query));

        Configure::load('Editable', 'db');

        $this->assertEquals(Configure::read('Foo.bar'), 'foobar');
        $this->assertEquals(Configure::read('Foo'), $config['Foo']);
    }

    public function testDump()
    {
        $query = $this->getMock('Cake\ORM\Query', [], [$this->tableMock->connection(), $this->tableMock]);

        $this->tableMock->expects($this->once())
            ->method('exists')
            ->with(['Configurations.namespace' => 'Editable', 'Configurations.path' => 'Foo.bar'])
            ->will($this->returnValue(false));

        $this->tableMock->expects($this->once())
            ->method('patchEntity')
            ->will($this->returnValue(new Entity()));

        $this->tableMock->expects($this->once())
            ->method('save')
            ->will($this->returnValue(true));

        Configure::write($this->_config());
        $this->assertTrue(Configure::dump('Editable', 'db', ['Foo']));
    }
}
