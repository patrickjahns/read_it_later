<?php

namespace OCA\ReadItLater\Storage;

use OCP\Files\File;
use OCP\Files\Folder;
use OCP\Files\NotFoundException;

/**
 * Class ReadItLaterStorage
 *
 * @package OCA\ReadItLater\Storage
 */
class ReadItLaterStorage {

	/**
	 * @var Folder
	 */
	private $userStorageFolder;

	/**
	 * @param Folder $storageFolder
	 */
	public function __construct(Folder $storageFolder) {
		$this->userStorageFolder = $storageFolder;
	}


	/**
	 * @param string $content
	 * @param string $fileName
	 * @return int
	 */
	public function save($content, $fileName) {
		try {
			$file = $this->getRilStorageFolder()->get($fileName);
		} catch(NotFoundException $e) {
			$file = $this->getRilStorageFolder()->newFile($fileName);
		}

		$file->putContent($content);
		return $file->getId();
	}

	/**
	 * @param integer $fileId
	 * @return string
	 */
	public function get($fileId) {
		/** @var File $file */
		$file = $this->userStorageFolder->getById($fileId);
		return $file->getContent();
	}

	/**
	 * @param integer $fileId
	 * @return string
	 */
	public function getPath($fileId) {
		/** @var File $file */
		$file = $this->userStorageFolder->getById($fileId);
		return $file->getPath();
	}

	/**
	 * @param integer $fileId
	 */
	public function delete($fileId) {
		$result = $this->userStorageFolder->getById($fileId);
		foreach ($result as $file) {
			$file->delete();
		}
	}

	/**
	 * @return string
	 */
	private function getStorageFolderName() {
		return "/RIL";
	}

	/**
	 * @return Folder|\OCP\Files\Node
	 */
	private function getRilStorageFolder() {
		try {
			return $this->userStorageFolder->get($this->getStorageFolderName());
		} catch(NotFoundException $e) {
			return $this->userStorageFolder->newFolder($this->getStorageFolderName());
		}
	}

}
