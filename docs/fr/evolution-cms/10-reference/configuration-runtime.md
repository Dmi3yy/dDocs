# Référence d'exécution de configuration

[Retour](source-inventory.md) / [Haut](../README.md) / [Suivant](core-composer.md)

Evolution CMS comporte deux couches de configuration : fichiers de projet/d'exécution et base de données
paramètres du système. La configuration d'exécution démarre d'abord, puis les paramètres système sont
chargé par les flux principaux et gestionnaires.

## Flux d'amorçage

| Étape | Comportement d'exécution |
| --- | --- |
| Composer chargement automatique | `core/bootstrap.php` charge `core/vendor/autoload.php`. |
| Installer l'horodatage | `EVO_INSTALL_TIME` est lu à partir de `core.install` lorsqu'il est présent. |
| Chargeur d'environnement | Le chargeur de cache d'environnement tente de charger les valeurs `.env` avec un cache PHP généré. |
| Définitions personnalisées | `core/custom/define.php` est chargé lorsqu'il est présent. |
| Définitions de base | `core/includes/define.inc.php` définit les chemins et constantes principaux. |
| Drapeau de session | `EVO_SESSION` est lu depuis env et est activé par défaut. |
| Mandataire de session | Compatibilité des sessions de fils `core/functions/session_proxy.php`. |
| L'héritage comprend | `core/includes/legacy.inc.php` charge le comportement de compatibilité. |
| Protection | `core/includes/protect.inc.php` renforce l’accès direct. |
| Début de séance | Les requêtes Manager/parser démarrent la session CMS sauf si elles sont désactivées par le contexte. |

Le bootstrap doit rester tolérant. Si le chargement du cache d'environnement échoue, le
le runtime revient au chargement direct de Dotenv.

## Fichiers d'environnement

Ordre de recherche d'environnement :

1. `core/custom/.env`
2. `.env` à la racine du projet

Le fichier de cache d'environnement est :

```text
core/storage/cache/env.php
```

Le cache est valide lorsque son heure de modification est plus récente ou égale à celle
fichier `.env` sélectionné. S'il est obsolète, le chargeur analyse `.env`, applique les valeurs,
et écrit un nouveau cache de tableau PHP de manière atomique.

## Règles de cache d'environnement

| Règle | Comportement |
| --- | --- |
| Charge immuable | Les valeurs existantes dans `$_ENV` ou `$_SERVER` ne sont pas écrasées. |
| Prise en charge de l'ancienne version `getenv()` | `putenv()` est appelé uniquement lorsque la valeur OS/env est absente. |
| Valeurs nulles | Supprimé du cache généré. |
| Chaînes vides | Préservées comme de vraies valeurs. |
| Écriture en cache | Écrit dans un fichier temporaire avec un verrou, puis renomme en place. |
| Comportement d'échec | Les échecs sont avalés et le chargement direct de Dotenv est utilisé lorsque cela est possible. |

Videz le cache après avoir modifié `.env` ou les valeurs de configuration d'exécution mises en cache
par le projet.

## Fichiers de configuration de base

| Fichier | Responsabilité |
| --- | --- |
| `core/config/app.php` | Fournisseurs, alias, groupes de middleware, paramètres régionaux de l'application, paramètres régionaux de secours. |
| `core/config/cache.php` | Magasins de cache et comportement du cache. |
| `core/config/database.php` | Gestionnaire de base de données et référence Redis. |
| `core/config/database/default.php` | Configuration de connexion à la base de données par défaut. |
| `core/config/database/migrations.php` | Configuration du référentiel de migration. |
| `core/config/filesystems.php` | Disques du système de fichiers et racines de stockage. |
| `core/config/logging.php` | Canaux de journalisation et comportement des journaux. |
| `core/config/session.php` | Pilote de session et options de session. |
| `core/config/tracy.php` | Intégration Tracy/débogage. |
| `core/config/view.php` | Affichez les chemins, le chemin Blade compilé et la configuration de rappel de directive héritée. |
| `core/config/blade-icons.php` | Blade Configuration des icônes. |
| `core/config/cms/observers.php` | Câblage de l'observateur du modèle. |

## Couche de projet personnalisée

Les remplacements de projet sont disponibles sous `core/custom/`. Les exemples actuels incluent :

| Fichier | Objectif |
| --- | --- |
| `.env.example` | Modèle d'environnement de projet. |
| `.env.docker.example` | Modèle d'environnement orienté Docker. |
| `define.php.example` | Définitions de constantes personnalisées chargées avant les définitions principales. |
| `composer.json.example` | Point d'extension du projet Composer fusionné par la configuration principale Composer. |
| `config/cms/settings.php.example` | Exemple de remplacement des paramètres du projet CMS. |
| `config/middleware.php.sample` | Exemple d'alias/groupes de middleware personnalisés. |
| `routes.php.example` | Exemple d'enregistrement d'itinéraire de projet. |

Ne modifiez pas les fichiers de configuration principaux pour un comportement de projet uniquement lorsqu'un `core/custom`
le remplacement existe.

## Fournisseurs et alias

La liste des fournisseurs d'applications comprend les services Illuminate, les services Evolution,
fournisseurs de compatibilité existants, gestionnaires/fournisseurs de thèmes, routage/session/système
fournisseurs de tâches, fournisseurs Blade et fournisseurs de services de gestion de documents/utilisateurs.

Les alias principaux exposent les façades Illuminate courantes telles que `Artisan`, `Cache`, `DB`,
`Event`, `File`, `Log`, `Route`, `Session`, `Storage`, `View` et évolution
façades telles que `ManagerTheme`, `UrlProcessor`, `TemplateProcessor`,
`DocumentManager`, `UserManager` et `Tailwind`.

## Groupes de middleware

| Groupe | Comportement |
| --- | --- |
| `mgr` | Session, proxy de session, CSRF, authentification du gestionnaire, liaisons de route, erreurs de vue partagée. |
| `global` | Session, proxy de session, liaisons de route, erreurs de vue partagée. |
| `aliases` | `csrf`, `authtoken`, `managerauth` et `bindings`. |

Ajoutez un middleware personnalisé via la configuration du middleware personnalisé du projet au lieu de
modifier la liste des middlewares de base.

## Limite des paramètres système

Les fichiers de configuration d'exécution définissent le comportement du framework et du bootstrap. Système CMS
les paramètres définissent le comportement du site stocké dans la base de données, comme les URL conviviales,
modèles, chemins d'accès au gestionnaire de fichiers, valeurs par défaut du cache et préférences de l'interface utilisateur du gestionnaire.

Utilisez [Référence des paramètres système](system-settings.md) pour le CMS basé sur une base de données
paramètres et cette page pour les fichiers de configuration d'exécution, l'environnement, les fournisseurs, les alias,
et middleware.
