<?php

namespace OCA\ReadItLater\AppInfo;

use OCA\ReadItLater\Controller\ReadItLaterController;
use OCA\ReadItLater\Database\EntryMapper;
use OCA\ReadItLater\ReadItLaterService;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

class Application extends App {

	/**
	 * @param array $urlParams
	 */
	public function __construct(array $urlParams = array()) {
		parent::__construct('read_it_later', $urlParams);

		$container = $this->getContainer();

		$container->registerService('EntryMapper', function(IAppContainer $container) {
			return new EntryMapper(
				$container->query('OCP\\IDb')
			);
		});

		$container->registerService('ReadItLaterController', function(IAppContainer $container) {
			return new ReadItLaterController(
				$container->query('AppName'),
				$container->query('Request'),
				$container->query('userId'),
				$container->query('ReadItLaterService')
			);
		});

		$container->registerService('ReadItLaterService', function(IAppContainer $container) {
			return new ReadItLaterService(
				$container->query('Graby'),
				$container->query('DomPDF'),
				$container->query('EntryMapper')
			);
		});

		$container->registerService('Graby', function() {
			return new Graby();
		});

		$container->registerService('DomPDF', function() {
			return new DomPDF();
		});
	}
}
