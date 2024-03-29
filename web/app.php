<?php

    use Symfony\Component\ClassLoader\ApcClassLoader;
    use Symfony\Component\HttpFoundation\Request;

/** @var \Composer\Autoload\ClassLoader $loader */
//$loader = require __DIR__.'/../app/autoload.php';
    $loader = require_once __DIR__.'/../app/bootstrap.php.cache';
    $loader = new ApcClassLoader('sf', $loader);
    $loader->register(true);
include_once __DIR__.'/../var/bootstrap.php.cache';

    $kernel = new AppKernel('prod', true);
    Request::setTrustedProxies(['192.0.0.1', '10.0.0.0/8'], Request::HEADER_X_FORWARDED_ALL);
    $request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
