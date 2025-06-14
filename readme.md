# GitHub Info Logger

Este é um projeto fullstack que utiliza **Laravel 8** no backend e **Angular 20** no frontend para consumir dados públicos da API do GitHub e registrar logs dessas interações em um banco de dados **PostgreSQL**.

A aplicação é executada via **Docker Compose**, garantindo um ambiente padronizado e fácil de configurar.

---

## 📦 Tecnologias Utilizadas

### Backend (Laravel 8)

- PHP ^8.2
- Laravel Framework ^8.75
- PostgreSQL
- PHPUnit (testes)
- RestFull
- Xdebug

### Frontend (Angular 20)

- Angular CLI 20
- Bootstrap 5
- Express (SSR)
- Prettier + ESLint

### Infraestrutura

- Docker Compose
- Nginx
- PostgreSQL 14
- Adminer (gerenciador de banco de dados)

---

## 📌 Funcionalidades

### 🔁 Backend (Laravel)

- Endpoint para buscar **detalhes do usuário do GitHub** (`/api/user/{username}`)
- Endpoint para listar os **seguidores de um usuário** (`/api/following/{username}`)
- Endpoint para **listar os logs registrados** (`/api/logs`)
- Endpoint para **detalhes do log registrado** (`/api/logs/{id}`)
- Middleware de log que registra automaticamente cada requisição relevante no banco
- Estrutura de API RESTful

### 💻 Frontend (Angular)

- Interface para buscar usuários do GitHub
- Visualização de seguidores do usuário
- Página para listar os logs das interações
- Paginação e tratamento de erros de forma amigável

---

## 🚀 Como Executar o Projeto

### 1. Pré-requisitos

- Docker
- Docker Compose

### 2. Clonar o repositório

```bash
git clone https://github.com/MarkusLima/docker_laravel_angular_postgres_adminer
cd docker_laravel_angular_postgres_adminer
```

## Estrutura organizacional do projeto

docker_laravel_angular_postgres_adminer/

├── laravel-app/       # Código-fonte Laravel<br/>
├── angular-app/       # Código-fonte Angular<br/>
├── nginx/             # Configurações do Nginx<br/>
├── docker-compose.yml # Executor docker<br/>
├── docs               # Documentos do projeto<br/>

### 3. Execute para instanciar o container
```bash 
docker compose -f 'docker-compose.yml' up -d --build
```

## Urls de acesso

Laravel: http://localhost
![BackEnd](docs/back.png)

Adminer: http://localhost:8081 (login: postgres / postgres)
![Banco de dados](docs/adminer.png)

Angular: http://localhost:4200
![FrontEnd](docs/frontUser.png)
![FrontEnd](docs/following.png)
![FrontEnd](docs/log.png)
![FrontEnd](docs/logId.png)

## Para remover o container execute
```bash
docker compose -f 'docker-compose.yml' down
```

### Executar o Xdebug
- Verifique se tem algum serviço na porta 9003 e finalize ele
```bash
sudo kill -9 $(lsof -t -i :9003)
```

### Para criar as tabelas no banco de dados
```bash
docker exec -it laravel sh
php artisan migrate
```

### Para rodar os testes no laravel
```bash
docker exec -it laravel sh
php artisan test
```

### Para rodar o eslint angular
```bash
docker exec -it angular sh
ng lint
```

### 🔄 Integração Contínua (CI) com GitHub Actions
Este repositório utiliza um workflow de Integração Contínua (CI) via GitHub Actions, localizado em .github/workflows/ci.yml. Ele é executado automaticamente nos seguintes eventos:

Push na branch master

Pull Request direcionado à branch master

✅ O que este workflow faz:
Faz checkout do repositório

Clona o código da branch para o ambiente de execução.

Configura o ambiente PHP

Instala o PHP 8.2 com as extensões sqlite e pdo_sqlite.

Instala o Composer.

Instala e configura o Laravel

Acessa a pasta laravel-app.

Instala as dependências do Laravel.

Copia o arquivo .env.example para .env.

Gera a chave da aplicação e limpa o cache de configuração.

Executa os testes do Laravel

Roda os testes automatizados com SQLite em memória, ideal para ambientes de CI rápidos e isolados.

Instala dependências do Angular

Acessa a pasta angular-app.

Instala os pacotes com npm ci (modo mais rápido e estável para CI).

Executa análise de código com ESLint

Roda o linter do Angular para garantir padrões de código.

Build da aplicação Angular

Gera a build de produção da aplicação Angular.

Este processo garante que ambas as aplicações (Laravel e Angular) estejam corretamente instaladas, testadas e construídas antes de qualquer mudança ser aceita na branch master.


## 📄 Licença
Este projeto está licenciado sob a licença [MIT](LICENSE).

---

## ❓ Dúvidas ou Sugestões
Caso tenha alguma dúvida na execução do projeto, por favor, abra uma [issue](https://github.com/MarkusLima/docker_laravel_angular_postgres_adminer/issues) ou envie um e-mail(markuamk@gmail.com) para que possamos melhorar o projeto.