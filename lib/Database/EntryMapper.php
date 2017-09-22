<?php


namespace OCA\ReadItLater\Database;

use OCP\AppFramework\Db\Mapper;
use OCP\IDb;

class EntryMapper extends Mapper {

	/**
	 * EntryMapper constructor.
	 *
	 * @param IDb $db
	 */
	public function __construct(IDb $db) {
		parent::__construct($db, 'read_it_later_entries', 'OCA\ReadItLater\Database\Entry');
	}

	/**
	 * @param $id
	 * @param $userId
	 * @return Entry
	 */
	public function find($id, $userId) {
		$sql = 'SELECT * FROM *PREFIX*read_it_later_entries WHERE id = ? AND user_id = ?';
		return $this->findEntity($sql, [$id, $userId]);
	}

	/**
	 * @param $userId
	 * @return Entry[]
	 */
	public function findAll($userId) {
		$sql = 'SELECT * FROM *PREFIX*read_it_later_entries WHERE user_id = ?';
		return $this->findEntities($sql, [$userId]);
	}

}
