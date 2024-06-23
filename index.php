<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

use App\Class\SiteMap;


$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

$sitemap = new SiteMap;
$sitemap->build();





