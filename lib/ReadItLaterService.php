<?php


namespace OCA\ReadItLater;

use Dompdf\Dompdf;
use Graby\Graby;
use OCA\ReadItLater\Database\Entry;
use OCA\ReadItLater\Database\EntryMapper;

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
	 * ReadItLaterService constructor.
	 *
	 * @param EntryMapper $mapper
	 */
	public function __construct(
		Graby $graby,
		Dompdf $dompdf,
		EntryMapper $mapper
	) {
		$this->mapper = $mapper;
		$this->graby = $graby;
		$this->dompdf = $dompdf;
	}


	/**
	 * @param string $userId
	 * @param string $url
	 */
	public function add(string $userId, string $url) {

		$content = $this->contentGrabber->fetchContent($url);
		$contentToRender = '<html><body>' . $content['html'] . '</body></html>';

		$this->dompdf->loadHtml($contentToRender);
		$this->dompdf->render();
		$renderedContent = $this->dompdf->output();

		$entry = new Entry();
		$entry->setUserId($userId);
		$entry->setTitle($content['title']);
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
