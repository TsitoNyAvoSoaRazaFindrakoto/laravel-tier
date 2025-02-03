## Prérequis
Assurez-vous d'avoir installé les éléments suivants sur votre système :
- Docker
- Docker Compose

## Configuration

Avant d'exécuter le projet, mettez à jour les paramètres suivants :

1. **Modifier les identifiants PostgreSQL**
   - Mettez à jour le nom d'utilisateur et le mot de passe PostgreSQL dans le fichier `.env` :
     ```env
     DB_CONNECTION=pgsql
     DB_HOST=db
     DB_PORT=5432
     DB_DATABASE=your_database_name
     DB_USERNAME=your_new_username
     DB_PASSWORD=your_new_password
     ```
   - Mettez à jour `PGPASSWORD` dans le script `entrypoint.sh` :
     ```sh
     export PGPASSWORD='your_new_password'
     ```
   
2. **Modifier les paramètres de messagerie**
   - Mettez à jour les informations de messagerie dans le fichier `.env` :
     ```env
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.example.com
     MAIL_PORT=587
     MAIL_USERNAME=your_email@example.com
     MAIL_PASSWORD=your_email_password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS=your_email@example.com
     MAIL_FROM_NAME="Nom de votre application"
     ```

## Déploiement et Exécution du Projet

Pour construire et démarrer l'application, exécutez la commande suivante :
```sh
docker-compose up --build
```

Cette commande :
- Construit les images Docker
- Démarre les conteneurs
- Configure l'application Laravel dans l'environnement Docker

## Accéder à l'Application

- L'application Laravel est accessible à l'adresse suivante :
  ```
  http://localhost:8000
  ```
- Pour accéder à la base de données, utilisez un client PostgreSQL avec les identifiants suivants :
  - Hôte : `localhost`
  - Port : `5432`
  - Base de données : `your_database_name`
  - Nom d'utilisateur : `your_new_username`
  - Mot de passe : `your_new_password`

## Arrêter le Projet
Pour arrêter les conteneurs en cours d'exécution, utilisez :
```sh
docker-compose down
```

## Commandes Supplémentaires
- Pour entrer dans le conteneur Laravel :
  ```sh
  docker-compose exec app bash
  ```
- Pour vérifier les logs :
  ```sh
  docker-compose logs -f
  ```

