<?php

namespace OCA\ReadItLater\Controller;

use OCA\ReadItLater\Database\Entry;
use OCA\ReadItLater\Database\EntryMapper;
use OCP\AppFramework\Controller;
use OCP\IRequest;


class ReadItLaterController extends Controller {

	/**
	 * @var EntryMapper
	 */
	private $entryMapper;

	/**
	 * ReadItLaterController constructor.
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param EntryMapper $entryMapper
	 */
	public function __construct(
		$appName,
		IRequest $request,
		EntryMapper $entryMapper
	) {
		parent::__construct($appName, $request);
		$this->entryMapper = $entryMapper;
	}

	/**
	 * @NoCSRFRequired
	 * @return string
	 */
	public function index() {
		$entry = new Entry();
		$entry->setUserId("admin");
		$entry->setTitle("my entry");
		$entry->setUrl("http://awesome.tld");
		$entry->setCreatedAtAsDateTime(new \DateTime());
		$entry->setFileId(1);
		$this->entryMapper->insert($entry);

		return $this->entryMapper->findAll("admin");
	}

	public function listEntries() {
	}

	public function add() {
	}

	public function delete() {
	}
}
