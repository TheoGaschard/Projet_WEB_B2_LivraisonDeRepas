# Projet WEB B2 Livraison de depas

Projet WEB B2  - Livraison de repas - Théo GASCHARD et Steven LY

Instructions de mise en place du projet:

  - Télécharger le projet
  
  A la racine du projet, lancer les commandes suivantes:
  - composer install
  - Dans le fichier .env, ajoutez vos identifiants pour la connexion à votre base de données, modifiez aussi le MAILER_URL pour le fonctionnement de SwiftMailler en entrant une adresse mail et son mot de passe. (Lors de l'envoie de mail en local l'expéditeur est toujours l'adresse mail de la configuration du fichier .env mais lorsque le site sera mis en production l'expéditeur sera bien celui configuré dans le new Swift Message. Il faut cependant aussi faire des configurations selon le type d'adresse mail: gmail,hotmail...)
  - Pour les envois de mail vous, devez changer l'adresse mail du destinataire pour pouvoir recevoir les mails (Il est configuré par défaut pour recevoir dans ma boite mail) : Il y a 3 envois de mails dans le ClientController.php.
  - php bin/console make:migration
  - php bin/console doctrine:schema:update --force (pour créer les tables)
  
  Les données de test (datafixtures) ont été créées manuellement depuis le site en local. Vous pouvez télécharger l'export de données de php ou créer vous même vos datafixtures en créeant un utilisateur restaurateur et ajouter les restaurants et plats que vous voulez. Vous pouvez ensuite voir les restaurants en tant que client et commander les différents plats que vous voulez. Pour valider la commande, il n'est pas nécessaire de rentrer des valeurs (système de paiement fictif). Vous pouvez juste valider et la commande sera validée.

   3 mails seront envoyés:
  
   - Pour le client: il recevra la facture de la commande et il pourra si il veut noter et commenter le restaurant via un lien reçu par un mail (Il était demandé de noter les plats mais en tant que client, si je commandais une dizaine de plats, je ne prendrai pas le temps de noter chaque plats tandis que si je devais noter le restaurant en lui même, je prendrais le temps de donner une note globale pour les plats du restaurant)
    
   - Pour le restaurateur : il recevra la commande à réaliser et devra appuyer sur le lien pour finaliser la commande et changer le statut de la commande pour que le livreur puisse venir chercher les plats.
    
   - Pour le livreur : le mail serait plutôt envoyé à la section de l'entreprise spécialisé en livraison. Il séléctionnera ensuite le livreur le plus proche du restaurant et lui enverra ce mail. Lors du changement de statut de la commande en "en livraison", le livreur pourra aller chercher la commande sans attendre et lorsqu'il aura bien livré la commande au client il pourra valider et terminer la commande via le lien du mail qu'il a reçu.
    
Au niveau administrateur:

  Vous pouvez créer l'utilisateur "admin" dans les datafixtures ou le créer depuis PHPmyadmin en lui attribuant le rôle ['ROLE_ADMIN'] :
   - php bin/console doctrine:fixtures:load
   
  Vous pouvez ensuite vous connecter dans la page de login avec les identifiants d'admin et accéder au Dashboard de l'administrateur et effectuer les modifications des différentes entités si nécessaire.
  
