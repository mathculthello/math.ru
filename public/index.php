<?php
require_once 'set_env.inc.php';

/* 
 * ROUTING
 */

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Config\FileLocator; 
use Symfony\Component\Routing\Loader\YamlFileLoader;

$fileLocator = new FileLocator([APP_ROOT]); 
$loader = new YamlFileLoader($fileLocator); 
$routes = $loader->load('etc/routes.yaml');

$context = new RequestContext('/');
$matcher = new UrlMatcher($routes, $context);
$current_uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

try {
	$parameters = $matcher->match($current_uri);
}
catch(Exception $e) {
	include '404.php';
	die();
}

include ('controllers/'.$parameters['_controller']);
