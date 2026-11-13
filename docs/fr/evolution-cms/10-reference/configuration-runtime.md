# Référence d'exécution de configuration

[Retour](source-inventory.md) / [Haut](../README.md) / [Suivant](core-composer.md)

Evolution CMS comporte deux couches de configuration : fichiers de projet/d'exécution et base de données
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

Ordre de recherche d'environnement :

1. `core/custom/.env`
2. `.env` à la racine du projet

Le fichier de cache d'environnement est :

```text
core/storage/cache/env.php
```Le cache est valide lorsque son heure de modification est plus récente ou égale à celle
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

## Configuration du projet

Les six exemples ci-dessous se trouvent dans le code source d’Evolution CMS sur la branche `3.6.x`. Le paquet d’installation ne les contient pas. Ouvrez l’exemple dont vous avez besoin, copiez son contenu dans le fichier indiqué à partir de la racine du projet et remplacez les valeurs d’exemple. Si le fichier existe déjà, ajoutez uniquement les paramètres ou le code nécessaires en conservant la configuration existante.

| Exemple dans la branche `3.6.x` | Fichier du projet | Modifications à apporter |
| --- | --- | --- |
| [`.env.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.example) | `core/custom/.env` | Renseignez les paramètres de connexion à votre base de données. Ajoutez au besoin les paramètres du domaine ou du Manager. Si votre projet utilise déjà un fichier `.env` à la racine, ajoutez-y les paramètres. |
| [`.env.docker.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.docker.example) | Par exemple `core/custom/.env.docker` | Remplacez les valeurs d’exemple de `DB_USERNAME`, `DB_PASSWORD` et `DB_DATABASE`. Dans Docker Compose, rattachez le fichier au service CMS avec `env_file`. Si la base de données tourne dans un autre service, utilisez le nom de ce service comme `DB_HOST`. Le CMS ne charge pas automatiquement `.env.docker`. |
| [`define.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/define.php.example) | `core/custom/define.php` | Un commentaire dans l’exemple énumère les constantes disponibles. Utilisez `define()` pour redéfinir celles dont vous avez besoin, par exemple `define('EVO_SITE_HOSTNAMES', 'example.com,www.example.com');`, en indiquant les domaines de votre site. |
| [`routes.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/routes.php.example) | `core/custom/routes.php` | Remplacez la route d’exemple `/helloworld` par votre propre chemin et son gestionnaire. Le guide explique comment ajouter une route pour un formulaire. [Formulaires avec des routes personnalisées](../08-tutorials-recipes/forms-with-custom-routes.md) |
| [`ControllerNamespace.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings/ControllerNamespace.php.example) | `core/custom/config/cms/settings/ControllerNamespace.php` | Renvoyez l’espace de noms de vos contrôleurs sous forme de chaîne terminée par une barre oblique inverse. Indiquez l’espace de noms dans lequel votre `BaseController` est chargé automatiquement. |
| [`settings.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings.php.example) | `core/custom/config/cms/settings.php` | Renvoyez un tableau contenant uniquement les paramètres à redéfinir. Par exemple, attribuez à `site_name` le nom de votre site. |

Conservez les mots de passe réels dans des fichiers d’environnement locaux ou transmettez-les via l’environnement d’exécution. Ne les ajoutez pas à Git.

Dans `core/custom/`, vous trouverez aussi `composer.json.example` pour les dépendances du projet et `config/middleware.php.sample` pour les alias et groupes de middleware personnalisés.

### Créer les fichiers en ligne de commande

Exécutez ce bloc dans Bash depuis la racine du projet. À la fin, gardez uniquement les commandes correspondant aux exemples souhaités. Chaque commande ignore le fichier de destination s’il existe déjà. Adaptez ensuite les valeurs d’exemple en suivant le tableau.

```bash
copy_evo_file() (
    source_path=$1
    target=$2
    [ ! -e "$target" ] && [ ! -L "$target" ] || exit 0
    mkdir -p "$(dirname "$target")" || exit 1
    sample=$(mktemp) || exit 1
    trap 'rm -f "$sample"' EXIT
    curl -fsSL "https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/$source_path" -o "$sample" || exit 1
    set -o noclobber
    cat "$sample" > "$target"
)

install_example() {
    copy_evo_file "core/custom/$1.example" "core/custom/$1"
}

install_example .env
install_example .env.docker
install_example define.php
install_example routes.php
install_example config/cms/settings/ControllerNamespace.php
install_example config/cms/settings.php
```

Pour travailler avec un agent, vous pouvez aussi télécharger `AGENTS.md` à la racine du projet et y ajouter vos propres règles. Le paquet d’installation contient déjà les modèles PHP du cœur dans `core/src/Models/`. [Référence des modèles](models.md) · [Code source des modèles](https://github.com/evolution-cms/evolution/tree/3.6.x/core/src/Models)

```bash
copy_evo_file AGENTS.md AGENTS.md
```

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

Utilisez [Référence des paramètres système] (system-settings.md) pour le CMS basé sur une base de données
paramètres et cette page pour les fichiers de configuration d'exécution, l'environnement, les fournisseurs, les alias,
et middleware.
