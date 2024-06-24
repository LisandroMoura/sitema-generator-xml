<?php

require __DIR__.'/vendor/autoload.php';

use App\Class\SiteMap;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

$sitemap = new SiteMap('2024-06-24T08:00:01+00:00', '0.1');
/* $sitemap->buildFromDB(); */

$sitemap->buildFromFile();

echo 'Done!';
