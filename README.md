# Clutch One

Projeto de e-commerce desenvolvido com PHP, MySQL, HTML, CSS e JavaScript.


## Funcionalidades

- catálogo de produtos;
- carrinho de compras;
- cálculo de frete;
- cupons de desconto;
- simulação de pagamento;
- painel administrativo;
- controle de pedidos e estoque.

## Tecnologias

PHP, MySQL, HTML, CSS e JavaScript.

## Página Inicial

![Home](screenshots/home.png)

---

## Menu Lateral e Navegação

![Menu](screenshots/menu-lateral.png)

---

## Página Institucional

![Sobre](screenshots/sobre.png)

---

## Carrinho de Compras

![Carrinho](screenshots/carrinho.png)

---

## Checkout

![Checkout](screenshots/checkout.png)

---

## Pagamento via Pix

![Pix](screenshots/pagamento-pix.png)

---

## Processamento de Pagamento

![Processando](screenshots/processando.png)

---

## Pagamento Aprovado

![Sucesso](screenshots/pagamento-aprovado.png)

---

## Painel Administrativo

![Admin](screenshots/admin-home.png)

---

## Gerenciamento de Produtos

![Produtos](screenshots/admin-produtos.png)

---

## Gerenciamento de Cupons

![Cupons](screenshots/admin-cupons.png)

---

## Gerenciamento de Pedidos

![Pedidos](screenshots/admin-pedidos.png)

---

# Como executar o projeto

## Opção 1 — Docker (recomendado)

### Requisitos

* Docker Desktop;
* Git.

### Passos

Clone o repositório:

```bash
git clone URL_DO_REPOSITORIO
```

Entre na pasta do projeto:

```bash
cd Projetofinal
```

Inicie os containers:

```bash
docker compose up -d
```

Acesse:

```text
http://localhost:8080
```

O banco de dados será criado automaticamente a partir do arquivo `produtos.sql`.

---

## Opção 2 — Linux

### Requisitos

* PHP 8 ou superior;
* MySQL ou MariaDB;
* Git.

### Instalação dos pacotes (Ubuntu/Debian)

```bash
sudo apt update
sudo apt install php php-mysql mysql-server git
```

Clone o repositório:

```bash
git clone URL_DO_REPOSITORIO
```

Entre na pasta:

```bash
cd Projetofinal
```

Crie o banco de dados:

```sql
CREATE DATABASE produtos;
```

Importe o arquivo:

```bash
mysql -u root -p produtos < produtos.sql
```

Verifique as configurações do arquivo `conexao.php`:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db = "produtos";
```

Inicie o servidor PHP:

```bash
php -S localhost:8000
```

Acesse:

```text
http://localhost:8000
```
