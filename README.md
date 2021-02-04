
***Projet SGBD S7 INFO***


# Architecture

- `requetes/MySQL/` : dossier contenant les scripts des requetes demandées

  - `creation.sql` : script de création de BDD avec les requêtes de supressions

  - `remplissage.sql` : script de peuplement

  - `vues.sql` :cotient les différentes vues/triggers/procédures

  - `consultation.sql` : contient les requêtes de consultation 

  - `statistiques.sql` : contient les requêtes de statistiques 

  - `mise_a_jours.sql` :  contient les requêtes de mise à jour 

- `Interface/` : dossier contenant les fichiers de l'interface

- `README.md`

- `rapport.pdf`

# Pré-requis

Afin de faire marcher notre interface vous devez avoir :

- `php7` ou supérieur

- `MySQL 8`

- `phpMyAdmin`

# Lancement

Vous pouvez utiliser le site web directemet sur http://www.ffhandball.live/


Sinon vous devrez effectuer les étapes suivantes:

- Créer une base de données en utilisant `phpMyAdmin`

- Executer les scripts `creation.sql`, `remplissage.sql` et `vues.sql`

- utiliser un serveur web local en utilisant par exemple **Wamp** et d'extraire le 
contenu du dossier `Interface/` dans celui-ci.

- Modifier les identifiants de connexion à la base dans le fichier `connect.php`

# Pages et site

Le fonctionnement du site web est décrit dans le rapport ci-joint
