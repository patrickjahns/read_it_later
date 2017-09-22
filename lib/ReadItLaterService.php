<?php


namespace OCA\ReadItLater;

use OCA\ReadItLater\Database\Entry;
use OCA\ReadItLater\Database\EntryMapper;

class ReadItLaterService {

	/**
	 * @var EntryMapper
	 */
	private $mapper;

	/**
	 * ReadItLaterService constructor.
	 *
	 * @param EntryMapper $mapper
	 */
	public function __construct(
		EntryMapper $mapper
	) {
		$this->mapper = $mapper;
	}


	/**
	 * @param string $userId
	 * @param string $url
	 */
	public function add(string $userId, string $url) {
		$entry = new Entry();
		$entry->setUserId($userId);
		$entry->setTitle("my entry");
		$entry->setUrl($url);
		$entry->setCreatedAtAsDateTime(new \DateTime());
		$entry->setFileId(1);
		$this->entryMapper->insert($entry);
	}


	/**
	 * @param string $userId
	 * @return Entry[]
	 */
	public function listEntries(string $userId) {
		return $this->entryMapper->findAll($userId);
	}

	/**
	 * @param string $userId
	 * @param int $entryId
	 */
	public function delete(string $userId, int $entryId) {
	}

}
