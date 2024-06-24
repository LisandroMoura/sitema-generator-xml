<?php

namespace App\Class;

use DateTime;

class SiteMap
{
    private $lastmod;
    private $priority;

    public function __construct(string $lastmod = '2020-04-21T21:20:48+00:00', string $priority = '1.0')
    {
        $this->lastmod = $lastmod;
        $this->priority = $priority;
    }

    /**
     * Criando sitemap a partir de Banco de dados.
     *
     * @return void
     */
    public function buildFromDB()
    {
        $arrPosts = $this->searchFromDatabase();
        $strPost = '';
        if ($arrPosts->num_rows > 0) {
            while ($row = $arrPosts->fetch_assoc()) {
                if ($row['post_type'] != 'post' && $row['post_type'] != 'page') {
                    $loc = $row['post_type'].'/'.$row['loc'];
                } else {
                    $loc = $row['loc'];
                }

                $changefreq = $this->formatarData($row['changefreq']);
                $strPost .= '<url>
                <loc>'.$_ENV['APP_URL'].'/'.$loc.'</loc>
                <lastmod>'.$changefreq.'</lastmod>
                <changefreq>daily</changefreq>
                <priority>'.$this->priority.'</priority>
                </url>';
            }
        }
        $this->endFile($strPost);

        return '';
    }

    /**
     * Obtendo dados do banco.
     *
     * @return void
     */
    public function searchFromDatabase()
    {
        $DB_HOST = $_ENV['DB_HOST'];
        $DB_TABLE = $_ENV['DB_TABLE'];
        $DB_DATABASE = $_ENV['DB_DATABASE'];
        $DB_USERNAME = $_ENV['DB_USERNAME'];
        $DB_PASSWORD = $_ENV['DB_PASSWORD'];
        $query = "
        SELECT post_name as 'loc', post_modified as 'changefreq', post_type
        FROM ".$DB_DATABASE.'.'.$DB_TABLE."
        WHERE post_type in ('post','testes','frases','textos','page')
        AND ID not in ('8750','6350')
        AND post_status = 'publish';";
        $conn = new \mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);
        if ($conn->connect_error) {
            exit('Falha na conexão: '.$conn->connect_error);
        }

        $data = $conn->query($query);
        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    /**
     * Finalização e fechamento do arquivo.
     *
     * @param [type] $strPost
     *
     * @return void
     */
    public function endFile($strPost)
    {
        $sitemapBuild = $this->getHeader().$strPost.$this->getFooter();
        $fp = fopen('mySitemap.xml', 'w');
        fwrite($fp, $sitemapBuild);
        fclose($fp);

        return '';
    }

    /**
     * Formação de cabeçalho do sitemap.
     *
     * @return void
     */
    public function getHeader()
    {
        return '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="https://www.w3.org/1999/xhtml">';
    }

    /**
     * Formação do primeiro registro do sitemap.
     *
     * @return void
     */
    public function getHome()
    {
        return '<url>
                <loc>'.$_ENV['APP_URL'].'</loc>
                <lastmod>'.$this->lastmod.'</lastmod>
                <changefreq>daily</changefreq>
                <priority>'.$this->priority.'</priority>
            </url>';
    }

    /**
     * Formação do footer.
     *
     * @return void
     */
    public function getFooter()
    {
        return '</urlset>';
    }

    /**
     * Obtendo dados de um arquivo.
     *
     * @return void
     */
    public function buildFromFile()
    {
        $arrPosts = [];
        $strPost = '';
        $handle = $this->fileIsImported();

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $strPost .= '<url>
                <loc>'.trim($line).'</loc>
                <lastmod>'.$this->lastmod.'</lastmod>
                <changefreq>daily</changefreq>
                <priority>'.$this->priority.'</priority>
                </url>';
            }
        }

        $this->endFile($strPost);

        return '';
    }

    /**
     * Methodo para importar o arquivo pages.dat.
     *
     * @return void
     */
    public function fileIsImported()
    {
        return fopen('pages.dat', 'r');
    }

    /**
     * Funções auxiliares - formatando data.
     *
     * @param [type] $dataHora
     *
     * @return void
     */
    public function formatarData($dataHora)
    {
        // Cria um objeto DateTime a partir da string recebida
        $data = \DateTime::createFromFormat('Y-m-d H:i:s', $dataHora);

        // Verifica se a criação do objeto DateTime foi bem-sucedida
        if ($data === false) {
            return 'Formato de data inválido.';
        }

        // Retorna a data formatada no formato desejado
        return $data->format('Y-m-d\TH:i:sP');
    }
}
