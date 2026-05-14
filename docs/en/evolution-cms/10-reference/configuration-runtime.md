# Configuration Runtime Reference

[Back](source-inventory.md) / [Up](../README.md) / [Next](core-composer.md)

Evolution CMS has two configuration layers: project/runtime files and database
system settings. Runtime configuration boots first, then system settings are
loaded by the core and manager flows.

## Bootstrap Flow

| Step | Runtime Behavior |
| --- | --- |
| Composer autoload | `core/bootstrap.php` loads `core/vendor/autoload.php`. |
| Install timestamp | `EVO_INSTALL_TIME` is read from `core.install` when present. |
| Environment loader | The environment cache loader tries to load `.env` values with a generated PHP cache. |
| Custom definitions | `core/custom/define.php` is loaded when present. |
| Core definitions | `core/includes/define.inc.php` defines core paths and constants. |
| Session flag | `EVO_SESSION` is read from env and defaults to enabled. |
| Session proxy | `core/functions/session_proxy.php` wires session compatibility. |
| Legacy includes | `core/includes/legacy.inc.php` loads compatibility behavior. |
| Protection | `core/includes/protect.inc.php` hardens direct access. |
| Session start | Manager/parser requests start the CMS session unless disabled by context. |

The bootstrap must remain tolerant. If environment cache loading fails, the
runtime falls back to direct Dotenv loading.

## Environment Files

Environment lookup order:

1. `core/custom/.env`
2. `.env` at the project root

The environment cache file is:

```text
core/storage/cache/env.php
```

The cache is valid when its modification time is newer than or equal to the
selected `.env` file. If it is stale, the loader parses `.env`, applies values,
and writes a new PHP array cache atomically.

## Environment Cache Rules

| Rule | Behavior |
| --- | --- |
| Immutable load | Existing values in `$_ENV` or `$_SERVER` are not overwritten. |
| Legacy `getenv()` support | `putenv()` is called only when the OS/env value is absent. |
| Null values | Dropped from the generated cache. |
| Empty strings | Preserved as real values. |
| Cache write | Writes to a temp file with a lock, then renames into place. |
| Failure behavior | Failures are swallowed and direct Dotenv loading is used where possible. |

Clear the cache after changing `.env` or runtime config values that are cached
by the project.

## Core Config Files

| File | Responsibility |
| --- | --- |
| `core/config/app.php` | Providers, aliases, middleware groups, application locale, fallback locale. |
| `core/config/cache.php` | Cache stores and cache behavior. |
| `core/config/database.php` | Database manager and Redis baseline. |
| `core/config/database/default.php` | Default database connection configuration. |
| `core/config/database/migrations.php` | Migration repository configuration. |
| `core/config/filesystems.php` | Filesystem disks and storage roots. |
| `core/config/logging.php` | Logging channels and log behavior. |
| `core/config/session.php` | Session driver and session options. |
| `core/config/tracy.php` | Tracy/debug integration. |
| `core/config/view.php` | View paths, compiled Blade path, and legacy directive callback config. |
| `core/config/blade-icons.php` | Blade Icons configuration. |
| `core/config/cms/observers.php` | Model observer wiring. |

## Custom Project Layer

Project overrides live under `core/custom/`. Current examples include:

| File | Purpose |
| --- | --- |
| `.env.example` | Project environment template. |
| `.env.docker.example` | Docker-oriented environment template. |
| `define.php.example` | Custom constant definitions loaded before core definitions. |
| `composer.json.example` | Project Composer extension point merged by the core Composer setup. |
| `config/cms/settings.php.example` | Project CMS settings override example. |
| `config/middleware.php.sample` | Custom middleware aliases/groups example. |
| `routes.php.example` | Project route registration example. |

Do not edit core config files for project-only behavior when a `core/custom`
override exists.

## Providers And Aliases

The application provider list includes Illuminate services, Evolution services,
legacy compatibility providers, manager/theme providers, routing/session/system
task providers, Blade providers, and document/user manager service providers.

Core aliases expose common Illuminate facades such as `Artisan`, `Cache`, `DB`,
`Event`, `File`, `Log`, `Route`, `Session`, `Storage`, `View`, and Evolution
facades such as `ManagerTheme`, `UrlProcessor`, `TemplateProcessor`,
`DocumentManager`, `UserManager`, and `Tailwind`.

## Middleware Groups

| Group | Behavior |
| --- | --- |
| `mgr` | Session, session proxy, CSRF, manager auth, route bindings, shared view errors. |
| `global` | Session, session proxy, route bindings, shared view errors. |
| `aliases` | `csrf`, `authtoken`, `managerauth`, and `bindings`. |

Add custom middleware through the project custom middleware config instead of
changing the core middleware list.

## System Settings Boundary

Runtime config files define framework and bootstrap behavior. CMS system
settings define site behavior stored in the database, such as friendly URLs,
templates, file manager paths, cache defaults, and manager UI preferences.

Use [System Settings Reference](system-settings.md) for database-backed CMS
settings and this page for runtime config files, environment, providers, aliases,
and middleware.
