Bundle symfony utilisés : 
- maker-bundle en dev
- orm doctrine
- serializer-pack
- param converter
- security
- lexik/jwt-authentication-bundle pour token JWT
- http-client pour récupérer l'url du poster du film

J'ai utilisé les migrations doctrine pour créer la table user à partir de l'entité. J'y ai créé un utilisateur via la requête suivante :
INSERT INTO `user` (`id`, `email`, `roles`, `password`)
VALUES (1,  'userTest@test.fr', '["ROLE_EDIT"]', 'password');

La création ou suppression de données nécessite une authentification préalable via user / mot de passe sur l'url suivante
localhost:8000/api/login_check afin de récupérer un token que l'on passe ensuite en "Bearer Token" sur l'appel (ou les 
appels) POST suivants.

Je n'ai réalisé la récupération du poster que lors de la récupération d'un seul film.
