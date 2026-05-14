# Paramètres, autorisations et fichiers

[Retour](elements.md) / [Haut](README.md) / [Suivant](../04-development/project-structure.md)

Ce guide couvre les surfaces de configuration du gestionnaire principal : paramètres système, convivialité
URL, accès aux fichiers, téléchargements, recherche, rôles, autorisations et groupes d'accès Web.

## Paramètres système

La page du gestionnaire de paramètres système est protégée par autorisation et peut être verrouillée pendant
un autre utilisateur gestionnaire le modifie. Les onglets de paramètres actuels incluent :

| Onglet | Utilisation courante |
| --- | --- |
| Général | Paramètres par défaut du site, paramètres de publication par défaut, paramètres de cache par défaut, paramètres de recherche par défaut, comportement de l'index des menus, modèles et paramètres d'heure. |
| URL conviviales | Mode URL, suffixe/préfixe, comportement des dossiers, URL strictes et comportement des alias. |
| Interfaces | Manager langue, thème, choix de l'éditeur et options d'interface. |
| Sécurité | Paramètres de sécurité du mot de passe et du gestionnaire. |
| Navigateur de fichiers | Chemin de base du navigateur Resource et nettoyage du nom de fichier téléchargé. |
| Dossier Manager | Chemin du gestionnaire de fichiers, listes d'autorisation de téléchargement, listes d'autorisation d'images/médias et taille de téléchargement. |
| Modèles de courrier | Paramètres du modèle de courrier Manager. |

Après avoir modifié les paramètres affectant la sortie, les chemins, les URL, les téléchargements, le cache ou
comportement du gestionnaire, actualisez le cache et testez le flux de travail concerné.

## URL conviviales

Les URL conviviales nécessitent :

1. Paramètres d'URL conviviaux Evolution CMS activés.
2. Alias ​​valides sur les ressources.
3. Règles de réécriture du serveur Web pour le projet.
4. Actualisation du cache après les modifications.

Si les URL exactes ne sont pas résolues, utilisez la recherche du gestionnaire par URL et vérifiez la ressource
est publié, non supprimé et non bloqué par des règles d'accès.

## Fichiers et téléchargements

Le navigateur de fichiers et le comportement de téléchargement dépendent à la fois des paramètres Evolution CMS et
autorisations du système de fichiers.

Vérifiez :

- chemin du gestionnaire de fichiers ;
- répertoire de base du navigateur de ressources ;
- extensions de fichiers/images/médias autorisées ;
- paramètre de taille de téléchargement ;
- PHP et limites de téléchargement sur le serveur Web ;
- autorisations de lecture/écriture du répertoire.

## Rôles et autorisations Manager

Les rôles et autorisations Manager contrôlent ce à quoi les utilisateurs du gestionnaire peuvent accéder. Lorsqu'un utilisateur
Impossible d'ouvrir un écran, vérifiez :

1. Le rôle de l'utilisateur.
2. L'autorisation requise par la page du gestionnaire.
3. Si la ressource ou l'élément est verrouillé.
4. Si l'action est masquée par les règles d'accès du gestionnaire.

## Autorisations d'accès au Web

Les autorisations d'accès Web utilisent des groupes d'utilisateurs et des groupes de documents. La page du gestionnaire peut
créer, renommer, supprimer et connecter ces groupes.

Utilisez les autorisations d'accès au Web lorsque les visiteurs du site ne doivent voir que des informations protégées spécifiques.
ressources. Si la fonctionnalité est désactivée, la page du gestionnaire affiche un avertissement avant
gestion de groupe.

## Recherche

La recherche Manager peut trouver des ressources par ID, champs de texte, URL exacte, modèle et
Valeurs Template Variable. Utilisez-le pour les cas de support où l'emplacement de l'arborescence est
inconnu ou une ressource est masquée, supprimée, non publiée ou protégée.

## Limite de la documentation du package

La documentation du gestionnaire principal décrit le comportement intégré de Evolution CMS. Extras installé
apparaissent comme des sources de documentation distinctes dans dDocs. Si un écran de gestionnaire appartient
à un package, ouvrez la documentation de ce package au lieu d'attendre que la documentation du produit
dupliquer son manuel.
