# Noyau Composer Référence

[Retour](configuration-runtime.md) / [Haut](../README.md) / [Suivant](legacy-compatibility.md)

Evolution CMS utilise un fichier Composer au niveau du projet et un fichier Composer principal. Le
Le fichier principal Composer est la principale limite de dépendance d'exécution pour un
Projet Evolution CMS.

## Composer Fichiers

| Fichier | Responsabilité |
| --- | --- |
| `composer.json` | Métadonnées du projet/package racine, référence PHP, extensions de plate-forme minimales et script d'analyse de projet. |
| `core/composer.json` | Principales dépendances d'exécution, règles de chargement automatique, configuration du plugin Composer, scripts de découverte de packages et outils de test. |
| `core/custom/composer.json` | Point d'extension spécifique au projet fusionné par le plugin de fusion principal Composer lorsqu'il est présent. |

Le fichier racine Composer décrit le package du projet. La dépendance d'exécution
le graphique se trouve sous `core/composer.json`.

## Métadonnées du package d'exécution

| Champ | Valeur actuelle |
| --- | --- |
| Forfait | `evolution-cms/evolution` |
| Tapez | `project` |
| Version | `3.5.7` |
| Licence | `GPL-3.0-or-later` |
| PHP référence | `^8.3` |
| Annuaire des fournisseurs | `vendor` à l'intérieur de `core/` |
| Stabilité minimale | `dev` |
| Préférez stable | `true` |

## Groupes de dépendances d'exécution

| Groupe | Forfaits |
| --- | --- |
| Composer/environnement d'exécution | `composer/composer`, `wikimedia/composer-merge-plugin` |
| Composants du cadre | Illuminez le cache, la configuration, la console, le conteneur, la base de données, les événements, le système de fichiers, HTTP, le journal, la pagination, la file d'attente, Redis, le routage, le support, la traduction, la validation, la vue |
| Base de données et migrations | Rallonges `doctrine/dbal`, PDO |
| HTTP et intégration | `guzzlehttp/guzzle`, `symfony/process` |
| Environnement et configuration | `vlucas/phpdotenv`, `phpoption/phpoption` |
| Courrier | `phpmailer/phpmailer` |
| Sessions et Redis | `predis/predis`, `dmitry-suffi/redis-session-handler` |
| Médias et flux | `james-heinrich/phpthumb`, `rosell-dk/webp-convert`, `simplepie/simplepie` |
| Système de fichiers | `league/flysystem` |
| Débogage | `tracy/tracy` |
| Planification | `dragonmantank/cron-expression` |
| Icônes | `secondnetwork/blade-tabler-icons` |
| Prestations d'évolution | `evolutioncms-services/document-manager`, `evolutioncms-services/user-manager` |

Les exigences d'extension de plate-forme incluent les extensions PHP courantes telles que `ctype`,
`dom`, `fileinfo`, `filter`, `hash`, `iconv`, `json`, `libxml`, `mbstring`,
`openssl`, `pcre`, `pdo`, `session`, `simplexml`, `tokenizer`, `xml`,
`xmlreader` et `zip`.

## Composer Fusionner Plugin

La configuration principale de Composer utilise `wikimedia/composer-merge-plugin` pour inclure :

```text
custom/composer.json
```

Comportement de fusion :

| Options | Valeur |
| --- | --- |
| `recurse` | `true` |
| `replace` | `true` |
| `merge-dev` | `false` |
| `merge-extra` | `true` |
| `merge-scripts` | `false` |

Utilisez `core/custom/composer.json` pour les packages au niveau du projet au lieu de les modifier
directement le fichier d'exécution principal Composer.

## Règles de chargement automatique

| Type de chargement automatique | Entrées |
| --- | --- |
| PSR-4 | `EvolutionCMS\\` à `src/`, `Database\\Seeders\\` à `database/seeders/` |
| Plan de classe | `database/migrations/` |
| Fichiers | Assistants d'action de base, fonctions d'assistance, fonctions de pont Laravel, assistants de nœuds, assistants de préchargement, assistants de processeur et utilitaires. |
| Développeur PSR-4 | `Tests\\` à `tests/` |

La liste de chargement automatique des fichiers conserve les fonctions d'assistance/d'action héritées disponibles dans le
exécution moderne.

## ComposerScripts

| Scénario | Objectif |
| --- | --- |
| `sync-replace` | Exécute l'assistant de synchronisation de remplacement de version. |
| `test` | Exécute des tests Pest. |
| `optimize` | Installe les dépendances de production et vide le chargement automatique faisant autorité optimisé. |
| `optimize-dev` | Installe les dépendances de développement et vide le chargement automatique faisant autorité optimisé. |
| `upd` | Synchronise les versions de remplacement et met à jour le fichier de verrouillage. |
| `pre-install-cmd` | Exécute la synchronisation de remplacement avant l'installation. |
| `pre-update-cmd` | Exécute la synchronisation de remplacement avant la mise à jour. |
| `post-autoload-dump` | Exécute `php artisan package:discover`. |

La découverte de packages fait partie de la génération de chargement automatique. Si les prestataires de services ou
les métadonnées du package ne sont pas actualisées, exécutez le dump de chargement automatique Composer et vérifiez le package
sortie de découverte.

## Outils de développement

Les dépendances de développement principales incluent :

| Forfait | Objectif |
| --- | --- |
| `pestphp/pest` | Testeur. |
| `mockery/mockery` | Testez en double. |
| `roave/security-advisories` | Bloque les versions de dépendances vulnérables connues. |

Le fichier Composer du projet racine expose également un script d'analyse PHPStan pour le
couche de projet.

## Règle de documentation

Lors de la documentation de l'installation du package, des exigences Composer ou du service
découverte du fournisseur, indiquez quelle limite Composer est utilisée : projet racine,
environnement d'exécution principal, ou `core/custom/composer.json`.
