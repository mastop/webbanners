<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';

// Use APC for autoloading to improve performance
// Change 'sf2' by the prefix you want in order to prevent key conflict with another application
/*
$loader = new ApcClassLoader('sf2', $loader);
$loader->register(true);
*/

require_once __DIR__.'/../app/AppKernel.php';
//require_once __DIR__.'/../app/AppCache.php';

umask(0000);
if(strpos(@$_SERVER['REMOTE_ADDR'], '192.168.0') === false && !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
    $kernel = new AppKernel('prod', false);
}else{
    $kernel = new AppKernel('dev', true);
}
$kernel->loadClassCache();
//$kernel = new AppCache($kernel);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);