# sitema-generator-xml

> Rápido e fácil gerador de sitemap.xml, com duas opções de uso:

 - Gerar sitemap via conexão com o banco de dados
 - Ou gerar o sitemap com base em um arquivo de texto


# install

> Jogo rápido...

## 1) instalar o composer

```bash
cd sitema-generator-xml
composer install
```

## 2) crie o seu .env 

> crie o seu arquivo .env e informe as configurações de banco de dados.
> PS: tem um .env_exemple na pasta raiz
> PS: se for rodar com base em um arquivo texto não precisa parametrizar seu .env

## 3) Pronto só executar...


```bash

php index.php
```


# Informações:

- Caso queira editar a sua Query, edite o metodo **searchFromDatabase()** da classe **\App\Class\SiteMap.php** 
- No exemplo, usei um banco com wordpress
- Foi gerado um arquivo **mySitemap.xml** na pasta raiz 