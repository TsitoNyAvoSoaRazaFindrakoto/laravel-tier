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
     DB_HOST=laravel_db
     DB_PORT=5432
     DB_DATABASE=crypto
     DB_USERNAME=postgres
     DB_PASSWORD=your_new_password
     ```

   
2. **Modifier les paramètres de messagerie**
   - Mettez à jour les informations de messagerie dans le fichier `.env` :
     ```env
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.example.com
     MAIL_PORT=587
     MAIL_USERNAME=lizkaryan626@gmail.com
     MAIL_PASSWORD=nmecuwzyienkqseg
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS="lizkaryan626@gmail.com"
     MAIL_FROM_NAME="${APP_NAME}"
     ```
NB : **Copier le fichier .env en tenant compte des modifications mentionnées ci-dessus**.


## Déploiement et Exécution du Projet

Lancer cette commande
``` sh
composer install
```


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
- GitHub : [https://github.com/TsitoNyAvoSoaRazaFindrakoto/laravel-tier]

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

