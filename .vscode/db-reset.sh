# Supprime la BDD
php bin/console doctrine:database:drop --force 

# Supprime le répertoire de migrations
rm -r migrations

# Creation du répertoire de migrations
mkdir migrations

# Re-créer la BDD
php bin/console doctrine:database:create

# Création des migration
php bin/console make:migration

# Execution des migrations
php bin/console doctrine:migrations:migrate --no-interaction

# Execution des fixtures
php bin/console doctrine:fixtures:load --no-interaction
