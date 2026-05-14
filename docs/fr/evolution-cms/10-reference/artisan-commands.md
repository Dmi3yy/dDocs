# Artisan Référence des commandes

[Retour](legacy-compatibility.md) / [Haut](../README.md) / [Suivant](models.md)

Cette page documente la surface de commande Artisan du projet installé enregistrée par
le noyau Evolution CMS actuel. Il est distinct du programme d'installation autonome
Commande `evo` documentée dans [Référence CLI](cli-reference.md).

## Exécution de la console

Evolution CMS utilise une application console personnalisée qui :

- utilise les données de version Evolution CMS comme nom d'application console ;
- désactive la sortie automatique et la capture d'exceptions ;
- crée un objet de requête à partir de l'URL du site configuré pour le contexte de la console ;
- distribue l'événement de départ Artisan ;
- charge les fournisseurs différés et les commandes d'amorçage.

Exécutez ces commandes à partir du contexte d'exécution `core/` d'un projet installé, sauf si un
La commande accepte explicitement un chemin cible.

## Cache et vues

| Commande | Objectif |
| --- | --- |
| `cache:clear` | Effacez le magasin de cache Illuminate configuré. |
| `cache:forget` | Supprimez une clé du magasin de cache configuré. |
| `cache:clear-full` | Effacez le cache Blade/view compilé ainsi que les surfaces du cache Evolution. |
| `clear-compiled` | Supprimez le fichier de classe compilé. |
| `view:clear` | Effacez les fichiers de vue Blade compilés. |

## Base de données et semoirs

| Commande | Objectif |
| --- | --- |
| `migrate` | Exécutez des migrations de bases de données. |
| `migrate:fresh` | Supprimez toutes les tables et réexécutez les migrations. |
| `migrate:install` | Créez le référentiel de migration. |
| `migrate:refresh` | Réinitialisez et réexécutez les migrations. |
| `migrate:reset` | Annulez toutes les migrations. |
| `migrate:rollback` | Annulez le dernier lot de migration. |
| `migrate:status` | Afficher le statut de migration. |
| `make:migration` | Créez un fichier de migration. Commande de développement. |
| `db:seed` | Exécutez des semoirs. |

Traitez les commandes de migration destructrices comme des tâches opérationnelles. Ils peuvent détruire des données
lorsqu'il est exécuté sur la mauvaise base de données.

## Listes et diagnostics

| Commande | Objectif |
| --- | --- |
| `doc:list` | Répertoriez les documents/ressources de `site_content`. |
| `tpl:list` | Répertoriez les modèles de `site_templates`. |
| `tv:list` | Liste Template Variables. |
| `deprecated:list` | Répertoriez les marqueurs obsolètes et les balises de suppression/version facultatives. Commande de développement. |
| `route:list` | Répertoriez les itinéraires enregistrés. |

Ces commandes sont utiles pour la validation de la documentation car elles exposent
objets d'exécution actuels sans s'appuyer sur d'anciens manuels.

## Forfaits et Extras

| Commande | Signature | Objectif |
| --- | --- | --- |
| `package:discover` | `package:discover` | Générez des données de découverte de fournisseur de services pour les packages personnalisés. |
| `package:create` | `package:create {packagename?}` | Créez un échafaudage de packages. |
| `package:runconsoles` | `package:runconsoles` | Exécutez les commandes de console à partir de packages personnalisés. |
| `package:installrequire` | `package:installrequire {key} {value} {composer_run=1}` | Ajoutez une exigence Composer aux exigences du package personnalisé. |
| `package:removerequire` | `package:removerequire {key} {composer_run=1}` | Supprimez une exigence Composer des exigences du package personnalisé. |
| `package:installautoload` | `package:installautoload {key} {value} {composer_run=1}` | Ajoutez une entrée de chargement automatique aux exigences du package personnalisé. |
| `extras` | `extras {typePackage?} {packageName?} {versionPackage?} {namePackage?} {--list} {--json}` | Parcourez ou installez Extras/packages en fonction des arguments. |

Le Extras installé doit documenter ses commandes spécifiques au package dans son
propres documents de package. Cette page documente la surface de commande principale qui découvre
et gère les colis.

## Préréglages

| Commande | Objectif |
| --- | --- |
| `preset:install` | Installez un préréglage à partir d'un référentiel Git ou d'un chemin local. |
| `preset:apply` | Appliquez une couche de projet prédéfinie à une installation Evolution CMS. |

`preset:apply` prend en charge les options de chemin cible, de chemin source, de source/réf. Git,
conserver les sources clonées, le nom du préréglage, supprimer les fichiers manquants du préréglage,
mode de fonctionnement à sec, semoirs forcés et saut du chargement automatique du vidage Composer.

## Planification et tâches système| Commande | Objectif |
| --- | --- |
| `schedule:list` | Répertoriez les commandes planifiées. |
| `schedule:run` | Exécutez les commandes planifiées. |
| `schedule:work` | Exécutez la boucle de travail du planificateur. |
| `schedule:finish` | Marquer un événement planifié comme terminé. |
| `schedule:clear-cache` | Effacer l’état mutex/cache du planificateur. |
| `schedule:test` | Testez une commande planifiée. |
| `system:scheduler-heartbeat` | Enregistrez l’état du rythme cardiaque du planificateur. |
| `system:task-worker` | Enregistrez l’activité des tâches système et préparez l’exécution des tâches en file d’attente. |

Les commandes de tâches système sont des commandes d’opérations d’exécution. Les documents de production doivent
inclure la supervision des processus et la politique de journalisation avant de recommander une connexion permanente
travailleurs.

## Maintenance du site et du projet

| Commande | Objectif |
| --- | --- |
| `make:site` | Mettre à jour/créer des objets de site à partir de sources configurées. |
| `closuretable:rebuild` | Reconstruisez la table de fermeture de l'arborescence des ressources. |
| `translations:sync` | Synchronisez les clés de traduction avec le fichier de langue par défaut. |
| `tailwind:build {package?} {--force}` | Compilez Tailwind CSS pour un package, tous les packages ou une reconstruction forcée. |
| `vendor:publish` | Publiez les actifs du fournisseur publiables. Commande de développement. |

`make:site` et `closuretable:rebuild` affectent l'état d'exécution. Utilisez des sauvegardes et un
flux de déploiement connu avant de les exécuter en production.

## Commandes de développement

Les commandes de développement incluent `vendor:publish`, `deprecated:list` et
`make:migration`. Ils sont enregistrés auprès du même prestataire de services mais doivent être
documentés comme des outils de développement/maintenance, et non comme des flux de travail normaux du gestionnaire.

## Règle de documentation

Lorsque vous documentez une commande, incluez :

- nom/signature de la commande ;
- contexte d'exécution ;
- s'il lit ou mute l'état du projet ;
- s'il est sans danger pour la production ;
- configuration associée ou limite Composer.

Ne documentez pas le comportement des commandes spécifiques au package dans cette référence de produit.
sauf si la commande est enregistrée par le noyau Evolution CMS.
