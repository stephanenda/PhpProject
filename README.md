# PhpProject
Formulaire avis client

Cloner le projet

composer install

cd ./src

php -S localhost:8000 


# Créér la bdd
vendor/bin/doctrine orm:schema-tool:create

# Mettre à jour la bdd
vendor/bin/doctrine orm:schema-tool:update --force --dump-sql

# Supprimer la bdd 
vendor/bin/doctrine orm:schema-tool:drop --force
