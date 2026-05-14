# Core Composer Reference

[Back](configuration-runtime.md) / [Up](../README.md) / [Next](legacy-compatibility.md)

Evolution CMS uses a project-level Composer file and a core Composer file. The
core Composer file is the main runtime dependency boundary for an installed
Evolution CMS project.

## Composer Files

| File | Responsibility |
| --- | --- |
| `composer.json` | Project/root package metadata, PHP baseline, minimal platform extensions, and project analysis script. |
| `core/composer.json` | Main runtime dependencies, autoload rules, Composer plugin config, package discovery scripts, and test tooling. |
| `core/custom/composer.json` | Project-specific extension point merged by the core Composer merge plugin when present. |

The root Composer file describes the project package. The runtime dependency
graph lives under `core/composer.json`.

## Runtime Package Metadata

| Field | Current Value |
| --- | --- |
| Package | `evolution-cms/evolution` |
| Type | `project` |
| Version | `3.5.7` |
| License | `GPL-3.0-or-later` |
| PHP baseline | `^8.3` |
| Vendor directory | `vendor` inside `core/` |
| Minimum stability | `dev` |
| Prefer stable | `true` |

## Runtime Dependency Groups

| Group | Packages |
| --- | --- |
| Composer/runtime | `composer/composer`, `wikimedia/composer-merge-plugin` |
| Framework components | Illuminate cache, config, console, container, database, events, filesystem, HTTP, log, pagination, queue, Redis, routing, support, translation, validation, view |
| Database and migrations | `doctrine/dbal`, PDO extensions |
| HTTP and integration | `guzzlehttp/guzzle`, `symfony/process` |
| Environment and config | `vlucas/phpdotenv`, `phpoption/phpoption` |
| Mail | `phpmailer/phpmailer` |
| Sessions and Redis | `predis/predis`, `dmitry-suffi/redis-session-handler` |
| Media and feeds | `james-heinrich/phpthumb`, `rosell-dk/webp-convert`, `simplepie/simplepie` |
| Filesystem | `league/flysystem` |
| Debugging | `tracy/tracy` |
| Scheduling | `dragonmantank/cron-expression` |
| Icons | `secondnetwork/blade-tabler-icons` |
| Evolution services | `evolutioncms-services/document-manager`, `evolutioncms-services/user-manager` |

Platform extension requirements include common PHP extensions such as `ctype`,
`dom`, `fileinfo`, `filter`, `hash`, `iconv`, `json`, `libxml`, `mbstring`,
`openssl`, `pcre`, `pdo`, `session`, `simplexml`, `tokenizer`, `xml`,
`xmlreader`, and `zip`.

## Composer Merge Plugin

The core Composer config uses `wikimedia/composer-merge-plugin` to include:

```text
custom/composer.json
```

Merge behavior:

| Option | Value |
| --- | --- |
| `recurse` | `true` |
| `replace` | `true` |
| `merge-dev` | `false` |
| `merge-extra` | `true` |
| `merge-scripts` | `false` |

Use `core/custom/composer.json` for project-level packages instead of editing
the core runtime Composer file directly.

## Autoload Rules

| Autoload Type | Entries |
| --- | --- |
| PSR-4 | `EvolutionCMS\\` to `src/`, `Database\\Seeders\\` to `database/seeders/` |
| Classmap | `database/migrations/` |
| Files | Core action helpers, helper functions, Laravel bridge functions, node helpers, preload helpers, processor helpers, and utilities. |
| Dev PSR-4 | `Tests\\` to `tests/` |

The file autoload list keeps legacy helper/action functions available in the
modern runtime.

## Composer Scripts

| Script | Purpose |
| --- | --- |
| `sync-replace` | Runs the version replacement sync helper. |
| `test` | Runs Pest tests. |
| `optimize` | Installs production dependencies and dumps optimized authoritative autoload. |
| `optimize-dev` | Installs dev dependencies and dumps optimized authoritative autoload. |
| `upd` | Syncs replacement versions and updates the lock file. |
| `pre-install-cmd` | Runs replacement sync before install. |
| `pre-update-cmd` | Runs replacement sync before update. |
| `post-autoload-dump` | Runs `php artisan package:discover`. |

Package discovery is part of autoload generation. If service providers or
package metadata do not refresh, run Composer autoload dump and verify package
discovery output.

## Dev Tooling

Core dev dependencies include:

| Package | Purpose |
| --- | --- |
| `pestphp/pest` | Test runner. |
| `mockery/mockery` | Test doubles. |
| `roave/security-advisories` | Blocks known vulnerable dependency versions. |

The root project Composer file also exposes a PHPStan analysis script for the
project layer.

## Documentation Rule

When documenting package installation, Composer requirements, or service
provider discovery, state which Composer boundary is being used: root project,
core runtime, or `core/custom/composer.json`.
