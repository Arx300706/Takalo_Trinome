<?php

use app\controllers\ApiController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->get('/', [ ApiController::class, 'getImages' ]);

	$router->get('/uploader', function() use ($app) {
		$app->render('upload', null);
	});

	$router->group('/api', function() use ($router) {
		$router->get('/images', [ ApiController::class, 'getImages' ]);
		$router->get('/images/@id:[0-9]', [ ApiController::class, 'getImage' ]);
		$router->post('/images/@id:[0-9]', [ ApiController::class, 'update' ]);
		$router->post('/save', [ ApiController::class, 'save' ]);
	});
	
}, [ SecurityHeadersMiddleware::class ]);