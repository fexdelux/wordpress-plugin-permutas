# Plugin Wordpress 5.4.2 para o banco de Permutas
Este plugin foi criado para atender o controle de cadastros das pesssoas para permutarem entre os Orgãos públicos.

## Ambiente de desenvolvimento
 - Docker
 - Docker-compose
 - VS Code

## Usando o Docker para desenvolver o plugin
Para comessar a desenvolver, inicie os serviços que esta no docker-compose:
```
docker-compose up -d 
```
ao executar abrirá 2 conteiners:
 - wp-database(Mysql)
 - wp-server (wordpress + Apache).

O servidor esta usando o PHP 7.2 como modulo no apache.

## Acesso ao wordpress 
para acessa o wordpress, acesso no seu browser o endereço: http://localhost:8080.

### Primeiro acesso
No primeiro acesso, você deverá efetuar as configurações do wordpress e criar um usuario administrativo.


