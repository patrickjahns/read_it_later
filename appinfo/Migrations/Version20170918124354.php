<?php

// NOTE: migrations do not respect the namespace defined in `info.xml` yet
namespace OCA\read_it_later\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use OCP\Migration\ISchemaMigration;

/**
 * Create initial database tables for Read It Later application
 */
class Version20170918124354 implements ISchemaMigration {

	/** @var  string */
	private $prefix;

	/**
	 * @param Schema $schema
	 * @param array $options
	 */
	public function changeSchema(Schema $schema, array $options) {
		$this->prefix = $options['tablePrefix'];
		$this->createReadItLaterEntriesTable($schema);
    }

	/**
	 * @param Schema $schema
	 */
    private function createReadItLaterEntriesTable(Schema $schema) {
		$tableName = "{$this->prefix}read_it_later_entries";
		if (!$schema->hasTable($tableName)) {
			$table = $schema->createTable($tableName);

			$table->addColumn('id', Type::INTEGER, [
				'autoincrement' => true
			]);
			$table->addColumn('user_id', Type::STRING, [
				'length' => 255
			]);
			$table->addColumn('title', Type::STRING, [
				'length' => 255
			]);
			$table->addColumn('url', Type::STRING, [
				'length' => 2000
			]);
			$table->addColumn('created_at', Type::STRING);
			$table->addColumn('file_id', Type::INTEGER);
		}
	}
}
