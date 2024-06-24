<?php

require __DIR__.'/vendor/autoload.php';

use App\Class\SiteMap;
use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__.'/.env');

/**
 * PS: parâmetros fixos (construtor) data e prioridade são usados
 * apenas quando geramos o sitemap com base em arquivo texto.
 * Pois quando geramos via Banco de dados esses valores vem do banco.
 */
$sitemap = new SiteMap('2024-06-24T08:00:01+00:00', '0.1');

/*
 * Caso queira gerar o sitemap com base em seu banco de dados: descomente o metodo abaixo:
 */

/* $sitemap->buildFromDB(); */

/*
 * Gerar o sitemap com base em arquivo.
 */

$sitemap->buildFromFile();

echo 'feito!';
