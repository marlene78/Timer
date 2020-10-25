# TIMER

[![forthebadge](http://forthebadge.com/images/badges/built-with-love.svg)](http://forthebadge.com)  

Application collaboratif, intuitif qui vous aide
à optimiser la gestion de tous vos projets et de respecter les délais.

## Pour commencer

Cloner le repository 
git clone git@github.com:marlene78/Timer.git

### Pré-requis

- PHP 7.4.1 maximun 
- Composer
- Docker

### Installation

Executez la commande docker-compose up pour commencer 
ensuite : 
- composer install (*Permet de mettre à jour les dépendances*)
- Créer un fichier .env contenant :

  APP_ENV="Renseignez l'environnement de travail , dev ou prod"
  DATABASE_URL=mysql://root:root@127.0.0.1:3306/Projet_timer
  DATABASE_URL=mysql://root:root@data/Projet_timer
  MAILER_DSN="Renseignez vos informations smtp"

 *Mettre en commentaire la ligne suivante (utiliser "#" pour mettre en commentaire)* 

 #DATABASE_URL=mysql://root:root@data/Projet_timer
 
 *Décommenter la ligne suivante (retirer "#" pour décommenter)* 
  
  DATABASE_URL=mysql://root:root@127.0.0.1:3306/Projet_timer
 

- php bin/console doctrine:migrations:migrate (*migration des data dans la base de donnée*) 

  Puis 
  *Commenter la ligne suivante
  #DATABASE_URL=mysql://root:root@127.0.0.1:3306/Projet_timer
 
  *Décommenter la ligne suivante
  DATABASE_URL=mysql://root:root@data/Projet_timer
 



## Démarrage

- Accédez à l'application : http://localhost:80 
- phpMyAdmin : http://localhost:8081/
  utilisateur : root 
  mot de passe: root

## Test Unitaire

- Effectué avec phpUnit:
  *Test unitaire*
  *Test fonctionnel*
  *Test web*

- Tapez la commande **./bin/phpunit** pour tester l'ensemble des tests
- Tapes la commande **./bin/phpunit --filter nonDeLeFonctionTest** pour tester une fonction


## Fabriqué avec

* [Docker](https://www.docker.com/) - logiciel libre permettant de lancer des applications dans des conteneurs logiciels
* [Symfony](https://symfony.com/) - Framework back-end PHP

## Mise en production

* [Heroku](https://www.heroku.com/)
* Voir l'application : https://timer-ipssi.herokuapp.com/

## Auteurs
Liste de(s) auteur(s) du projet!
* **Marlène Lingisi** _alias_ [@marlene78](https://github.com/marlene78)
* **Anta Ndoye** _alias_ [@Anta221](https://github.com/Anta22)


## License

Ce projet est sous licence ``GNU GENERAL PUBLIC LICENSE`` - voir le fichier [LICENSE.md](LICENSE.md) pour plus d'informations

