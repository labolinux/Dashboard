# Dashboard

L’objectif de ce projet est la création et la mise en place d’un dashboard à l’accueil afin de donner des indications sur les transports du quartier (horaire des bus, métro et trains...).


## Configuration requise
- PHP7
- Mysql
- Symfony 4.0.3
- Yarn => [Installer Yarn](https://yarnpkg.com/lang/en/docs/install/#mac-tab)

## Installation :

Pour ceux qui sont sous windows installer git core pour windows

[Télécharger git](https://git-scm.com/downloads)

Cloner le projet 

`git clone git@github.com:labolinux/Dashboard.git`

`cd Dashbord/`

`composer install`

`yarn install`

## Configuration de la base de donnée

Ouvrez le fichier .env et adaptez la configuration.
 
`DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/dashbord`

Puis faites:

`php bin/console doctrine:database:create`

et 

`php bin/console doctrine:schema:update --force`


## Pour finir
Lancez le serveur

`php bin/console server:run` 

rendez vous depuis votre navigateur à l'url indiqué.