<?php

return [
	'routes' => [
		['name' => 'readItLater#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'readItLater#listEntries', 'url' => '/list', 'verb' => 'GET'],
		['name' => 'readItLater#add', 'url' => '/add', 'verb' => 'POST'],
		['name' => 'readItLater#delete', 'url' => '/delete/{id}', 'verb' => 'DELETE'],
	]
];
