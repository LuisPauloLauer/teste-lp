# Desafio Programador PHP
rodar os seguintes comandos

php bin/console doctrine:database:create

php bin/console doctrine:migrations:migrate

symfony serve

Foi desenvolvido rota index com template para execução do teste:

rota exemplo: https://127.0.0.1:8000

Demais rotas:

https://127.0.0.1:8000/dohash

Esta rota é chamada pelo formulario (Generate Hash code)

https://127.0.0.1:8000/api/dohash/{text}

Esta rota pode ser executada pelo método get passando como parâmetro na rota a string para gerar a hash.

