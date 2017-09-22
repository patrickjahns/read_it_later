<?php


namespace OCA\ReadItLater;

use Dompdf\Dompdf;
use Graby\Graby;
use OCA\ReadItLater\Database\Entry;
use OCA\ReadItLater\Database\EntryMapper;
use OCA\ReadItLater\Storage\ReadItLaterStorage;

class ReadItLaterService {

	/**
	 * @var EntryMapper
	 */
	private $mapper;

	/**
	 * @var Dompdf
	 */
	private $dompdf;

	/**
	 * @var Graby
	 */
	private $graby;

	/**
	 * @var ReadItLaterStorage
	 */
	private $readItLaterStorage;

	/**
	 * ReadItLaterService constructor.
	 *
	 * @param EntryMapper $mapper
	 */
	public function __construct(
		Graby $graby,
		Dompdf $dompdf,
		ReadItLaterStorage $readItLaterStorage,
		EntryMapper $mapper
	) {
		$this->mapper = $mapper;
		$this->graby = $graby;
		$this->dompdf = $dompdf;
		$this->readItLaterStorage = $readItLaterStorage;
	}


	/**
	 * @param string $userId
	 * @param string $url
	 */
	public function add(string $userId, string $url) {

		$content = $this->contentGrabber->fetchContent($url);
		$contentToRender = '<html><body>' . $content['html'] . '</body></html>';
		$sanitizedContentTile = $this->sanitize($content['title']);

		$this->dompdf->loadHtml($contentToRender);
		$this->dompdf->render();
		$renderedContent = $this->dompdf->output();
		$fileId = $this->readItLaterStorage->save($renderedContent, $sanitizedContentTile . '.pdf');

		$entry = new Entry();
		$entry->setUserId($userId);
		$entry->setTitle($content['title']);
		$entry->setUrl($url);
		$entry->setCreatedAtAsDateTime(new \DateTime());
		$entry->setFileId($fileId);
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
		$entry = $this->mapper->find($entryId, $userId);
		$this->storage->delete($entry->getFileId());
		$this->mapper->delete($entry);
	}

	/**
	 * @param $title
	 * @return string
	 */
	private function sanitize ($title) {
		return filter_var($title, FILTER_SANITIZE_URL);
	}

}
