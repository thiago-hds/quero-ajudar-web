# Quero Ajudar

## 💻 Sobre

O Quero Ajudar! é um sistema que tem o objetivo de intermediar a comunicação entre instituições que oferecem vagas de trabalho voluntário e possíveis candidatos a essas vagas.

O sistema é composto por:

-   [Painel administrativo web](https://github.com/thiago-hds/quero-ajudar-web/) no qual o administrador do sistema e as instituições podem inserir e gerenciar informações relacionadas às vagas e candidaturas dos voluntários
-   [Aplicativo móvel](https://github.com/thiago-hds/quero-ajudar-app) no qual os voluntários podem consultar as oportunidades disponíveis e se inscrever nas que tem interesse

Aplicação desenvolvida durante a disciplina Monografia em Sistemas de Informação do Departamento de Ciências da Computação (UFMG).

## ✨ Features do Painel Administrativo

-   [x] CRUD de usuários do sistema
-   [x] CRUD de instituições
-   [x] CRUD de vagas
-   [x] CRUD de voluntários
-   [x] CRUD de inscrições

## 🚀 Tecnologias

-   [Laravel 8.0](https://laravel.com/)
-   [MySQL](https://www.mysql.com/)

## ⛏️ Como Executar

Para executar o projeto é preciso ter instalado o PHP 7.3+.

1. Crie o arquivo .env

```bash
cp .env.example .env
```

2. Insira as configurações do banco de dados no arquivo `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quero_ajudar
DB_USERNAME=root
DB_PASSWORD=root
```

3. Execute os comandos:

```bash
# gerar key
php artisan key:generate

#limpar caches
php artisan cache:clear
php artisan config:clear

# instalar templates do Laravel-AdminLTE
php artisan adminlte:install

#executar migrations e seeder
php artisan migrate
php artisan db:seed
```

4. Execute o projeto com o comando:

```bash
php artisan serve
```

5. O projeto estará executando por padrão em http://localhost:8000
