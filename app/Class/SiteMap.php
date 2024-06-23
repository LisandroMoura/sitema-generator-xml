<?php

namespace App\Class;
use mysqli;
use DateTime;

class SiteMap
{
    private $priority;
    public function __construct(String $priority = "1.0") {
        $this->priority = $priority;
    }

    public function getPriority() {
        return $this->priority;
    }

    public function setPriority($priority) {
        $this->priority = $priority;
    }

    public function build()
    {
        $header='<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="https://www.w3.org/1999/xhtml">';
        $footer="</urlset>";
        $home='<url>
                <loc>'.$_ENV["APP_URL"].'</loc>
                <lastmod>2020-04-21T21:20:48+00:00</lastmod>
                <changefreq>daily</changefreq>
                <priority>'.$this->priority.'</priority>
            </url>';

        $arrPosts=$this->searchDatabase();

        $strPost="";
        if ($arrPosts->num_rows > 0) {
            while ($row = $arrPosts->fetch_assoc()) {
                if($row["post_type"] != "post" && $row["post_type"] != "page" )
                    $loc = $row["post_type"]."/". $row["loc"];
                else
                    $loc = $row["loc"];

                $changefreq = $this->formatarData($row["changefreq"]);
                $strPost.= '<url>
                <loc>'.$_ENV["APP_URL"].'/'.$loc.'</loc>
                <lastmod>'. $changefreq.'</lastmod>
                <changefreq>daily</changefreq>
                <priority>'.$this->priority.'</priority>
                </url>';
            }
        }

        $sitemapBuild = $header.$home.$strPost.$footer;
        $fp = fopen('sitemap.xml', 'w');
        $sitemap = fwrite($fp, $sitemapBuild);
        fclose($fp);
        return "";
    }
   public function searchDatabase()
   {
        $DB_HOST=$_ENV["DB_HOST"];
        $DB_TABLE=$_ENV["DB_TABLE"];
        $DB_DATABASE=$_ENV["DB_DATABASE"];
        $DB_USERNAME=$_ENV["DB_USERNAME"];
        $DB_PASSWORD=$_ENV["DB_PASSWORD"];
        $query = "
        SELECT post_name as 'loc', post_modified as 'changefreq', post_type
        FROM ". $DB_DATABASE .".".$DB_TABLE."
        WHERE post_type in ('post','testes','frases','textos','page')
        AND ID not in ('8750','6350')
        AND post_status = 'publish';";
        $conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_DATABASE);
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Executa a consulta
        $data = $conn->query($query);
        if($data):
            return $data;
        else :
            return null;
        endif;
   }

    public function formatarData($dataHora) {
        // Cria um objeto DateTime a partir da string recebida
        $data = DateTime::createFromFormat('Y-m-d H:i:s', $dataHora);

        // Verifica se a criação do objeto DateTime foi bem-sucedida
        if ($data === false) {
            return "Formato de data inválido.";
        }

        // Retorna a data formatada no formato desejado
        return $data->format('Y-m-d\TH:i:sP');
    }
}


