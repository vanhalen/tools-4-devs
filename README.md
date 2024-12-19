<div style="display: flex; align-items: center; border: none;">
  <img src="https://tools4devs.rodrigorchagas.com.br/img/logo-tools4devs.png" alt="Tools4Devs Logo" width="180">
  <h1 style="position: relative; top: -10px; margin: 0; font-size: 1.5rem;">Tools4Devs</h1>
</div>

## Sobre o Tools4Devs

**Tools4Devs** é uma API e uma coleção de ferramentas voltadas para devs e profissionais da web. Inclui funcionalidades como geração e validação de documentos, manipulação de dados, busca de CEP, informações de rede e geração de textos como lorem ipsum. O objetivo do **Tools4Devs** é facilitar a integração e otimizar o fluxo de trabalho em projetos de desenvolvimento.


### 🌐 Acesse a API

[https://tools4devs.rodrigorchagas.com.br/](https://tools4devs.rodrigorchagas.com.br/)

---

## 🛠️ Exemplo de Uso

O **Tools4Devs** é uma API gratuita, acesse o link abaixo (GET) para ver o retorno:

[Gerador de CPF](https://tools4devs.rodrigorchagas.com.br/api/generator/cpf)

Exemplo de retorno JSON:
```json
{
  "status": true,
  "data": {
    "cpf": "674.920.231-46"
  }
}
```

---

## 🌟 Exemplo de Página que Faz Uso da API Tools4Devs

Acesse uma demonstração prática de como as ferramentas do **Tools4Devs** são utilizadas:

🔗 **[Ferramentas - Rodrigo Chagas](https://rodrigorchagas.com.br/ferramentas)**

Nessa página, você encontrará exemplos reais e dinâmicos do uso da API.

---

## Requisitos

- **PHP 8.2** ou superior (Laravel 11)
- **MySQL 8** ou superior
- **Composer**

> **Nota:** Caso utilize **MySQL** ou **MariaDB** inferior, altere as configurações do arquivo `config/database.php` para:

```php
'charset' => env('DB_CHARSET', 'utf8'),
'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
```

---

## Como Rodar o Projeto

1. **Duplique o arquivo `.env.example` e renomeie para `.env`:**

   ```bash
   cp .env.example .env
   ```

2. **Configure as credenciais do banco de dados** no arquivo `.env`.

3. **Instale as dependências do PHP:**

   ```bash
   composer install
   ```

4. **Gere a chave da aplicação:**

   ```bash
   php artisan key:generate
   ```

5. **Migre o banco de dados:**

   ```bash
   php artisan migrate
   ```

---

Se precisar de ajuda ou encontrar problemas, não hesite em abrir uma issue no repositório! 🚀
