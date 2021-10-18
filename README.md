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

## ✔️ Requisitos

Para executar o projeto é preciso ter instalado:

-   PHP 7.3+
-   Composer

## ⛏️ Como Executar

1. Clone o reposiório

```bash
git clone https://github.com/thiago-hds/quero-ajudar-web .
```

2. Crie o arquivo .env

```bash
cp .env.example .env
```

3. Insira as configurações do banco de dados no arquivo `.env`:

    Exemplo:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=quero_ajudar
    DB_USERNAME=root
    DB_PASSWORD=root
    ```

4. Instale as dependências

```bash
composer install
```

5. Execute os comandos:

```bash
# instalar dependências
composer install

# gerar key
php artisan key:generate

#executar migrations e seeder
php artisan migrate
php artisan db:seed
```

6. Execute o projeto com o comando:

```bash
php artisan serve
```

7. O projeto estará executando por padrão em http://localhost:8000

    Login padrão: root@root.com / root1234
