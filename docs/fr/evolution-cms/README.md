# Evolution CMS Documentation

[Centre de documentation](../README.md) / Evolution CMS

Il s'agit de la documentation produit canonique en français pour Evolution CMS
dans dDocs. Elle documente d'abord la base de code actuelle et n'utilise les
anciens contenus qu'après validation avec le code courant.

## Commencez ici

| Besoin | Ouvrir |
| --- | --- |
| Installer un nouveau projet | [Installation](01-getting-started/installation.md) |
| Vérifier les exigences d'exécution | [Exigences](01-getting-started/requirements.md) |
| Apprendre le vocabulaire de base | [Concepts de base](01-getting-started/core-concepts.md) |
| Utiliser les flux de travail du gestionnaire principal | [Utilisation de Evolution CMS](02-using-evolution-cms/README.md) |
| Comprendre la disposition du runtime | [Structure du projet](04-development/project-structure.md) |
| Creer un package moderne | [Creer un package](05-extras-and-packages/create-package.md) |
| Creer un site preset | [Creer un preset](05-extras-and-packages/create-preset.md) |
| Trouver des cartes de référence pour les développeurs | [API et intégrations](06-api-and-integrations/README.md) |
| Diagnostiquer les problèmes courants du projet | [Dépannage](07-security-updates-operations/troubleshooting.md) |
| Vérifier les principaux paramètres et valeurs par défaut | [Référence des paramètres système](10-reference/system-settings.md) |
| Examiner les rôles et les autorisations | [Référence sur les rôles et les autorisations](10-reference/roles-and-permissions.md) |
| Comprendre la configuration et le chargement de `.env` | [Référence d'exécution de configuration](10-reference/configuration-runtime.md) |
| Comprendre le câblage principal du Composer | [Référence de base Composer](10-reference/core-composer.md) |
| Comprendre la compatibilité héritée | [Référence de compatibilité héritée](10-reference/legacy-compatibility.md) |
| Utiliser les modèles et directives Blade | [Blade et référence de rendu de modèle](10-reference/blade-and-template-rendering.md) |
| Rechercher des balises d'analyseur classiques | [Référence des balises de l'analyseur](10-reference/parser-tags.md) |
| Rechercher les commandes Artisan du projet installé | [Référence des commandes Artisan](10-reference/artisan-commands.md) |
| Rechercher les commandes du programme d'installation | [Référence CLI](10-reference/cli-reference.md) |
| Suivre des recettes validées | [Tutoriels et recettes](08-tutorials-recipes/README.md) |
| Verifier les conventions de package | [Extras et packages](05-extras-and-packages/README.md) |
| Parcourir toutes les pages de référence | [Référence](10-reference/README.md) |
| Comprendre la carte source | [Inventaire source](10-reference/source-inventory.md) |
| Suivre les règles de liaison des pages | [Navigation dans la documentation](10-reference/documentation-navigation.md) |
| Voir les sources de contenu autorisées | [Politique relative aux sources de documentation](10-reference/documentation-source-policy.md) |

## Forme de la documentation

Les documents du produit Evolution CMS sont organisés par tâche de lecteur, et non par ancien référentiel
dossiers.

```text
evolution-cms/
  01-getting-started/
  02-using-evolution-cms/
  03-site-building/
  04-development/
  05-extras-and-packages/
  06-api-and-integrations/
  07-security-updates-operations/
  08-tutorials-recipes/
  09-community-support/
  10-reference/
```

Cette baseline contient les premières pages de documentation produit prêtes
pour la review de release. Les references method-level, les route payloads et
la field-level help du Manager sont suivis dans des tâches séparées et doivent
être ajoutés seulement après validation du code actuel.

## Politique source

- Le code Evolution CMS actuel est la source de vérité pour le comportement d'exécution.
- Le package autonome `evolution-cms/installer` est la source de vérité pour
  le flux d'installation actuel.
- L'ancienne archive de documentation reste une archive héritée.
- Les anciens manuels de composants ne sont pas migrés dans cette arborescence de documentation produit car
  Extras installé expose sa propre documentation de package dans dDocs.
- Les notes de bonnes pratiques ne peuvent devenir des pages publiques qu'après révision du code actuel.

## Règle de navigation

Les pages doivent utiliser des liens relatifs stables. Lorsqu'une section s'agrandit, ajoutez un petit
ligne de navigation avec des liens `Back`, `Up` et `Next` afin que les lecteurs puissent parcourir le
docs sans compter uniquement sur l’arborescence.
