# Nom de Projet et description

Webtv est une plate-forme de difusion de vidéo dédiée au monde professionnel.

## Pour commencer

Ces instructions vous fourniront une copie du projet opérationnel et des instructions qui vont vous aider ou vous guider sur la façon de déployer le projet sur un système actif.

## Installation

Pour que le projet soit opérationnel sur votre serveur, procédez comme suit.

## Déployez le code source

Déployez le code source sur votre serveur dans le document root de votre vhost.

## dupliquer le UsersTableSeeder.php
```
cp ./database/seeds/UsersTableSeeder.php.example ./database/seeds/UsersTableSeeder.php
```

## Installez les dépendances

Installez les dépendances grâce à la commande

```
composer install
```

## Configurez le projet

Copiez le fichier .env.example et collez le dans le même répertoire en le renommant .env

```
cp .env.example .env
```

Editez le fichier .env pour configurer l'application. Modifiez la valeur des clés suivantes (remplacer par la valeur entre crochet []):

```
APP_NAME=[Nom du client ou de l'application]
APP_DEBUG=[true ou false]
APP_URL=[URL du site]

DB_DATABASE=[Nom de la base de données]
DB_USERNAME=[Nom d'utilisateur de la base de données]
DB_PASSWORD=[Mot de passe de la base de données]

MAIL_HOST=[Serveur d'envoi de mail]
MAIL_USERNAME=[Utilisateur du compte de mail]
MAIL_PASSWORD=[Mot de passe du compte de mail]

REQUIRE_LOGIN=Restreindre l'accès à l'application aux utilisateurs connectés ([true]) ou pas ([false])
REQUIRE_PAYMENT=Restreindre l'accès à l'application aux utilisateurs abonnés ([true]) ou pas ([false])

VIMEO_ID=[A récupérer dans l'interface de Vimeo]
VIMEO_SECRET=[A récupérer dans l'interface de Vimeo]
VIMEO_TOKEN=[A récupérer dans l'interface de Vimeo]
VIMEO_DOMAIN=[Nom de domaine de l'application]

BRAINTREE_ENV=[production]
BRAINTREE_MERCHANT_ID=[A récupérer dans l'interface de Braintree]
BRAINTREE_PUBLIC_KEY=[A récupérer dans l'interface de Braintree]
BRAINTREE_PRIVATE_KEY=[A récupérer dans l'interface de Braintree]
```
 Modifier les informations des mails envoyés lors des inscriptions:
 app/Mail/NewUser.php => subject ligne33
  app/Mail/NewUsersNotification.php => subject ligne33






### Generez une nouvelle clé pour le projet

```
php artisan key:generate
```

### Exécutez toutes les migrations

```
php artisan migrate
```
### Création du superAdmin



Pour créer un superadmin avec pour login "Admin_1" et pour mot de passe "modify", exécuter la commande suivante :
et  modifier cette utilisateur .
 puis 
```
php artisan db:seed
```

### Initialisez l'accès au CMS

Copiez le fichier parameters.php.example dans le dossier /config et collez le dans le même répertoire en le renommant parameters.php

```
cp ./config/parameters.php.example ./config/parameters.php
```

### Initialisez le module de paiement

Créez un compte sur https://www.braintreepayments.com. Connectez vous à votre dashboard, et générer des clés API. Dans le fichier .env, insérez ces valeurs aux clés BRAINTREE_MERCHANT_ID, BRAINTREE_PUBLIC_KEY et BRAINTREE_PRIVATE_KEY.

Créez ensuite des plans, qui correspondent aux différentes formules. La valeur saisie pour "Billing Cycle Every [] Month(s)", ("Billing details") correspond au nombre de mois d'abonnement.

Une fois tous les plans créés, exécutez la commande suivante afin de synchroniser les formules dans la base de données :

```
php artisan braintree:sync-plans
```

Pour utiliser PayPal en moyen de paiement, allez dans la partie "Processing" (engrenage en haut à droite de l'interface), cochez l'option correspondant à PayPal et modifiez les options. Des informations relatives à votre compte PayPal vous seront demandées.

### Changez votre logo

Remplacez le fichier logo.png sous public/images par votre logo. L'image doit avoir une taille de 150x50.
# web_t
