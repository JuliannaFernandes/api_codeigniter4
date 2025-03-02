# API RESTful com CodeIgniter 4

Este repositório contém uma API RESTful desenvolvida com **CodeIgniter 4** e **MySQL**.

## Tecnologias Utilizadas
- **PHP 8.1+**
- **CodeIgniter 4**
- **MySQL**
- **JWT Authentication**

## Requisitos
Antes de rodar a API, certifique-se de ter:
- PHP 8.1 ou superior instalado
- Composer instalado
- MySQL configurado

## Instalação e Configuração

1. Clone o repositório:
   ```bash
   git clone https://github.com/JuliannaFernandes/api_codeigniter4.git
   ```

2. Na pasta do projeto, instale as dependências:
   ```bash
   composer install
   ```

3. Configure o banco de dados no arquivo **.env** (caso não exista, copie de .env.example):
   ```bash
   cp .env.example .env
   ```
   Edite as seguintes configurações:
   ```ini
   database.default.hostname = localhost
   database.default.database = api_ci4
   database.default.username = usuario
   database.default.password = senha
   database.default.DBDriver = MySQLi
   ```

4. Execute as migrations para criar as tabelas:
   ```bash
   php spark migrate
   ```

5. Inicie o servidor local:
   ```bash
   php spark serve
   ```
   
## Endpoints

**Clientes**

- GET /cliente → Lista clientes (com paginação e filtros)
- POST /cliente → Cria um novo cliente
- PUT /cliente/{id} → Atualiza um cliente existente
- DELETE /cliente/{id} → Remove um cliente  

**Produtos**

- GET /produto → Lista produtos (com paginação e filtros)
- POST /produto → Cria um novo produto
- PUT /produto/{id} → Atualiza um produto existente
- DELETE /produto/{id} → Remove um produto
- 
**Pedidos**

- GET /pedido → Lista pedidos de compra (com paginação e filtros)
- POST /pedido → Cria um novo pedido de compra
- PUT /pedido/{id} → Atualiza um pedido existente
- DELETE /pedido/{id} → Remove um pedido

**Usuários e Autenticação**

POST /registro → Registra um novo usuário

POST /login → Realiza login e gera token JWT

GET /usuario → Retorna dados do usuário autenticado

## Filtros e Paginação

Todos os endpoints GET aceitam filtros dinâmicos baseados nos campos da entidade correspondente.

**Uso de Filtros**

Os filtros podem ser passados como parâmetros na URL. Exemplo:

```
/cliente?nome_razao_social=João&cpf_cnpj=12345678900
```
Isso retornará apenas os clientes que possuem nome_razao_social contendo "João" e cpf_cnpj exatamente igual a "12345678900".

**Paginação**

A API suporta paginação utilizando o parâmetro page. Por padrão, retorna 10 registros por página.
```
/cliente?page=2
```

## Autenticação JWT

A API usa JWT para autenticação. Para acessar endpoints protegidos:
```
Gere um token em /login com suas credenciais.
```
Use o token no cabeçalho:
```
Authorization: Bearer SEU_TOKEN_JWT
```

Agora sua API está pronta para ser usada! 
