<?php

namespace OCA\ReadItLater\Controller;

use OCA\ReadItLater\ReadItLaterService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class ReadItLaterController extends Controller {

	/**
	 * @var ReadItLaterService
	 */
	private $readItLaterService;

	/**
	 * @var int
	 */
	private $userId;


	/**
	 * ReadItLaterController constructor.
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param string $userId
	 * @param ReadItLaterService $readItLaterService
	 */
	public function __construct(
		$appName,
		IRequest $request,
		string $userId,
		ReadItLaterService $readItLaterService
	) {
		parent::__construct($appName, $request);
		$this->readItLaterService = $readItLaterService;
		$this->userId = $userId;
	}

	/**
	 * @NoCSRFRequired
	 * @return TemplateResponse
	 */
	public function index() {
		return new TemplateResponse($this->appName, 'index', []);
	}

	/**
	 * @NoCSRFRequired
	 * @return DataResponse
	 */
	public function listEntries() {
		return new DataResponse($this->readItLaterService->listEntries($this->userId));
	}

	/**
	 * @NoCSRFRequired
	 * @return DataResponse
	 */
	public function add() {
		$this->readItLaterService->add($this->userId, $this->request->getParam('url'));
		return new DataResponse([], Http::STATUS_CREATED);
	}

	/**
	 * @NoCSRFRequired
	 * @return DataResponse
	 */
	public function delete() {
		$this->readItLaterService->delete($this->userId, $this->request->getParam('id'));
		return new DataResponse([], Http::STATUS_NO_CONTENT);
	}
}
