<div style="display: flex; align-items: center; border: none;">
  <img src="https://tools4devs.rodrigorchagas.com.br/img/logo-tools4devs.png" alt="Tools4Devs Logo" width="180" style="pointer-events: none;">
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

> ⚠️ **Atenção**
>
> **Seja Consciente**: A ferramenta **Tools4Devs** foi criada com o propósito de auxiliar desenvolvedores, analistas de sistemas, DBAs, testadores de software e estudantes na geração de números de documentos válidos e outros dados fictícios necessários para o teste de softwares em desenvolvimento. Todas as informações fornecidas por esta ferramenta são geradas  aleatoriamente e não possuem qualquer vínculo com pessoas ou entidades reais. Esses dados são puramente fictícios e não devem ser usados como informações autênticas ou em cenários do mundo real.
>
> **Use de forma responsável**: Embora nos esforcemos para garantir a precisão dos dados gerados, incluindo cálculos e validações, é importante salientar que podem ocorrer imprecisões ou erros. Por isso, recomendamos que você não utilize esses dados para finalidades críticas, decisões importantes ou cenários que exijam total confiabilidade.
>
> **Respeite as normas e a ética**: É expressamente proibido o uso de nossas ferramentas para fins ilegais, antiéticos ou que violem qualquer legislação vigente. Exemplos incluem, mas não se limitam a: hacking, invasão de privacidade, falsificação de identidade, fraudes ou qualquer outra atividade criminosa. Encorajamos o uso ético e responsável da ferramenta, alinhado aos propósitos de desenvolvimento e aprendizado.
>
> **Responsabilidade do Usuário**: Todo uso inadequado ou ilegal dos dados gerados pela **Tools4Devs** é de total responsabilidade do usuário. Nós nos isentamos de qualquer responsabilidade por danos ou prejuízos causados pelo uso indevido das informações fornecidas.
>
> **Importante**: Use esta ferramenta como um apoio para o desenvolvimento de soluções tecnológicas, mas sempre respeite os limites éticos e legais.

---

Se precisar de ajuda ou encontrar problemas, não hesite em abrir uma issue no repositório! 🚀
