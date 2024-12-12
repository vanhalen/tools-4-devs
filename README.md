# tools-4-devs

## Requisitos

* PHP 8.2 ou superior
* MySQL 8 ou superior
* Composer


* Caso utilize MySQL ou MariaDB inferior altere as configurações do database.php  para:

    'charset' => env('DB_CHARSET', 'utf8'),
    'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),


## Como rodar o projeto

Duplicar o arquivo ".env.example" e renomear para ".env"<br>
Alterar no arquivo .env as credenciais do banco de dados<br>


Instalar as dependências do PHP
```
compsoer install
```
Gerar a chave no arquivo .env
```
php artisan key:generate
```

Criar o arquivo de rotas para API
```
php artisan install:api
```

