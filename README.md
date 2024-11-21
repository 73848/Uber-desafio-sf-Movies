# Desafio Uber

Implementação do desafio proposto pela empresa Perfect-pay - desafio número 02

## Descrição

O projeto consiste em uma interface onde é possível pesquisar por um filme gravado em São Francisco e coletar a localização  e informações como diretor, atores e distribuidores do filme. 

## Funcionalidades 

- `Live Search de filmes`: Funcionalidade que permite a pesquisa baseado no nome do filme. 


### Pré-requisitos
- Para rodar esse projeto em sua máquina, você precisar ter instalado:

```
PHP versão > 8.2
Composer
```

###  Instalação

- Instalar o php versão > 8.2;
- Instalar o gerenciador de pacotes Composer;
- Rodar o comando 

``` 
composer install
```

- Rodar os comandos no terminal da  pasta 

``` 
copy .env.example .env
```

``` 
php artisan key:generate
``` 

- Configurar o .env mudando para a conexão com db de sua escolha e rode o comando

``` 
 php artisan migrate
``` 

- Criar alguns dados falsos para testes utilizando o comando 

``` 
php artisan db:seed --class = DatabaseSeeder
``` 

- Por fim, basta rodar o comando 

``` 
php artisan server
``` 

e utilizar a aplicação.

## 


## ⚙️ Executando os testes

- Basta o rodar o comando:

``` 
php artisan test
``` 
  

###  Analise os testes de ponta a ponta

- Como já foi dito, execulte o comando 

``` 
php artisan db:seed
``` 
para criar alguns dados falsos a fim de testar a aplicação localmente com alguns dados criados pelo Faker PHP. 

##  Construído com

Ferramentas utilizadas no projeto

* [PHP](https://www.php.net/) - Linguagem de programção 
* [MySql](https://www.mysql.com/) - Banco de Dados  
* [Laravel](https://laravel.com/) - O framework web usado
* [DataSF](https://data.sfgov.org) - API para informações de filmes
* [Geocodign Google](https://developers.google.com/maps/documentation/geocoding/start?hl=pt-br) - API para coletar geolocalização



