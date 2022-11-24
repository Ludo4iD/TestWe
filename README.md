Bundle symfony utilisés : 
- maker-bundle en dev
- orm doctrine
- serializer-pack
- param converter
- security
- lexik/jwt-authentication-bundle pour token JWT
- http-client pour récupérer l'url du poster du film

# Users

J'ai utilisé les migrations doctrine pour créer la table user à partir de l'entité. J'y ai créé un utilisateur via la requête suivante :
INSERT INTO `user` (`id`, `email`, `roles`, `password`)
VALUES (1,  'userTest@test.fr', '["ROLE_EDIT"]', 'password');

# Authentification via token JWT pour appels autres que GET
La création ou suppression de données nécessite une authentification préalable via user / mot de passe sur l'url suivante
localhost:8000/api/login_check afin de récupérer un token que l'on passe ensuite en "Bearer Token" sur l'appel (ou les 
appels) POST suivants.

Je n'ai réalisé la récupération du poster que lors de la récupération d'un seul film.

# Structure du projet
J'ai utilisé 3 contrôleurs dans lesquels, on trouve le routing en annontations.

## Les appels GET
.../api/movies revoie la liste des films (/people pour les personnes, /types pour les types de film)
.../api/movies/{id} renvoie un film dans l'id est donné en paramètre (/people pour les personnes, /types pour les types de film)

## Les appels POST/DELETE
.../api/movies en methode POST permet de mettre en base un film donné au format JSON dans le body (/people pour les personnes)

## Les entités et Repositories correspondants
Des entités Movies / People / Type / User puis aussi MovieHasPeople afin de pouvoir garder les données role et significance 
sur les relations entre entités.

## Un dossier DBAl 
dans lequel on trouve le type EnumSignificance.

## Un dossier EventSubscriber
avec un ExceptionSubscriber qui permet de gérer les exceptions au format Json.

## Un dossier Service
qui contient une classe qui permet de récupérer le poster d'un film via appel à une API
