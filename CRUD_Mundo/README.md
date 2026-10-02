# CRUD Mundo

## Sobre o projeto

O CRUD Mundo é uma aplicação web destinada ao cadastro e gerenciamento de informações relacionadas a continentes, governantes, países e cidades.

O sistema permite realizar operações de cadastro, consulta, edição e exclusão de registros, utilizando um banco de dados MySQL com relacionamentos entre as tabelas.

O projeto também possui um sistema de autenticação de usuários para controlar o acesso às páginas da aplicação.

## Funcionalidades

- Cadastro, consulta, edição e exclusão de continentes
- Cadastro, consulta, edição e exclusão de governantes
- Cadastro, consulta, edição e exclusão de países
- Cadastro, consulta, edição e exclusão de cidades
- Relacionamento entre as informações cadastradas
- Login de usuários
- Proteção das páginas do sistema
- Bloqueio do usuário após três tentativas incorretas de senha
- Registro de logs de acesso
- Alteração obrigatória da senha no primeiro acesso
- Alteração da senha pelo usuário

## Tecnologias utilizadas

- PHP
- HTML
- CSS
- MySQL
- Git
- GitHub

## Estrutura do projeto

- `banco/` - arquivos SQL utilizados para criação e configuração do banco de dados
- `css/` - arquivos responsáveis pela estilização das páginas
- `autenticacao.php` - funções relacionadas à autenticação e proteção das páginas
- `conexao_exemplo.php` - exemplo de configuração da conexão com o banco de dados
- `login.php` - tela de acesso ao sistema
- `index.php` - menu principal da aplicação
- `continente.php` - gerenciamento de continentes
- `governante.php` - gerenciamento de governantes
- `pais.php` - gerenciamento de países
- `cidade.php` - gerenciamento de cidades
- `trocar_senha.php` - manutenção da senha do usuário
- `sair.php` - encerramento da sessão do usuário
- `.gitignore` - arquivos locais que não devem ser enviados ao repositório

## Como executar

1. Instale e inicie um servidor local com PHP e MySQL, como o XAMPP.
2. Coloque a pasta `CRUD_Mundo` no diretório utilizado pelo servidor.
3. Crie o banco de dados utilizando os arquivos SQL disponíveis na pasta `banco`.
4. Copie o arquivo `conexao_exemplo.php` e renomeie a cópia para `conexao.php`.
5. Configure o usuário e a senha do banco de dados no arquivo `conexao.php`.
6. Acesse o projeto pelo navegador.
7. Cadastre o primeiro usuário.
8. Faça login para utilizar o sistema.

## Requisitos

- PHP
- MySQL
- Servidor local, como XAMPP
- Navegador web

## Autor

Miguel Faria