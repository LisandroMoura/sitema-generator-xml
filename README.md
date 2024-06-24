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

## crie o seu .env (caso queira gerar o sitemap de um banco de dados)

> crie o seu arquivo .env e informe as configurações de banco de dados.
> PS: tem um .env_exemple na pasta raiz

## 2) Pronto só executar...


```bash

php index.php
```


# Informações:

- Caso queira editar a sua Query, edite o metodo **searchFromDatabase()** da classe **\App\Class\SiteMap.php** 
- No exemplo, usei um banco com wordpress