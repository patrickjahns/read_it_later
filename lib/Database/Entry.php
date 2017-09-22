<?php

namespace OCA\ReadItLater\Database;

use OCP\AppFramework\Db\Entity;
use JsonSerializable;

class Entry extends Entity implements JsonSerializable {

	/**
	 * @var string
	 */
	protected $userId;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $createdAt;

	/**
	 * @var integer
	 */
	protected $fileId;

	/**
	 * @param \DateTime $dateTime
	 */
	public function setCreatedAtAsDateTime(\DateTime $dateTime) {
		parent::setCreatedAt($dateTime->format('Y-m-d H:i:s'));
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAtAsDateTime() {
		return \DateTime::createFromFormat('Y-m-d H:i:s', parent::getCreatedAt());
	}

	/**
	 * @return array
	 */
	public function jsonSerialize() {
		return [
			'id' 		=> $this->id,
			'title' 	=> $this->title,
			'url'		=> $this->url,
			'createdAt'	=> $this->getCreatedAtAsDateTime(),
			'fileId'	=> $this->fileId
		];
	}
}
