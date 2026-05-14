# Actions Artisan et Manager

[Retour](events.md) / [Haut](../README.md) / [Suivant](source-inventory.md)

Cette page cartographie les surfaces de commande et d'action du gestionnaire actuelles. C'est un début
point pour une référence plus approfondie sur les commandes et une documentation sur le flux de travail du gestionnaire.

## Artisan Commandes

| Zone | Commandes |
| --- | --- |
| Cache et vues | `cache:clear-full`, vider le cache compilé, effacer les vues. |
| Forfaits | `package:discover`, `package:create`, `package:installrequire`, `package:removerequire`, `package:installautoload`, `package:runconsoles`, `extras`. |
| Préréglages | `preset:apply`, `preset:install`. |
| Listes et diagnostics | `doc:list`, `template:list`, `tv:list`, `deprecated:list`, liste d'itinéraires. |
| Planification | liste de planification et commandes d'exécution de planification. |
| Tâches système | Commandes de battement de coeur du planificateur et de travailleur de tâche. |
| Site/environnement d'exécution | mise à jour du site, mise à jour de l'arborescence, synchronisation des traductions, publication du fournisseur, build Tailwind. |

Utilisez [Référence CLI] (cli-reference.md) pour la commande d'installation autonome `evo`
surface et [Référence des commandes Artisan](artisan-commands.md) pour l'intégralité
surface de commande du projet installé. Cette page est une carte compacte qui relie
commandes avec les surfaces d'action du gestionnaire.

## Manager Sources d'actions

Les actions Manager ne constituent pas un seul fichier de route moderne. Le comportement actuel du manager est
résolu à partir de plusieurs surfaces :

| Surfaces | Responsabilité |
| --- | --- |
| `ManagerTheme` | Résout l’action du gestionnaire actif et du contrôleur. |
| `core/factory/actionlist.php` | Carte d’ID d’action héritée et métadonnées d’action. |
| `core/src/Controllers/` | Contrôleurs de page du gestionnaire actuel. |
| `manager/actions/` | Gestionnaires d’actions hérités et dynamiques. |
| `manager/processors/` | Mutation des processeurs de sauvegarde/suppression/publication/paramètres/cache. |
| `manager/views/` | Vues Blade et boutons d'action. |
| Baies modèle `managerActionsMap` | ID d'action courants pour la modification, l'enregistrement, la suppression, la duplication, l'activation, la désactivation, le tri, l'exécution et les actions de modèle associées. |

## Actions de modèle courantes

| Zone modèle | Actions communes |
| --- | --- |
| Modèles | nouveau, modifier, enregistrer, supprimer, dupliquer. |
| Template Variables | nouveau, modifier, enregistrer, supprimer, dupliquer, trier. |
| Chunks | nouveau, modifier, enregistrer, activer, désactiver, supprimer, dupliquer. |
| Snippets | nouveau, modifier, enregistrer, activer, désactiver, supprimer, dupliquer. |
| Plugins | nouveau, modifier, enregistrer, activer, désactiver, supprimer, dupliquer, trier, purger. |
| Modules | nouveau, modifier, enregistrer, activer, désactiver, supprimer, dupliquer, exécuter, dépendance. |
| Resources | créer, modifier, enregistrer, déplacer, dupliquer, publier, dépublier, supprimer, restaurer, vider la corbeille. |

## Règle de documentation

Lorsque vous documentez une action de responsable, validez les trois niveaux :

- l'identifiant de l'action ou la carte d'action du modèle ;
- le contrôleur/action/processeur qui gère la demande ;
- la vue gestionnaire qui expose l'action à l'utilisateur.

Ne traitez pas les anciens noms d'action comme un comportement actuel à moins qu'ils ne soient toujours résolus dans
le runtime actuel du gestionnaire.
