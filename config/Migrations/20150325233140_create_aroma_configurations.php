<?php
use Phinx\Migration\AbstractMigration;

class CreateAromaConfigurations extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('aroma_configurations');

		$table->addColumn('namespace', 'string', [
			'default' => null,
			'limit' => 255,
			'null' => true,
		]);

		$table->addColumn('path', 'string', [
			'default' => null,
			'limit' => 255,
			'null' => false
		]);

		$table->addColumn('value', 'string', [
			'default' => null,
			'limit' => 255,
			'null' => true
		]);

		$table->addColumn('created', 'datetime', [
			'default' => null,
			'null' => false
		]);

		$table->addColumn('modified', 'datetime', [
			'default' => null,
			'null' => false
		]);

		$table->create();
	}
}