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

## Project Configuration

The six samples below are available in the Evolution CMS `3.6.x` source branch. The installation package omits them. Open the sample you need, copy its contents to the path shown relative to your project root, and replace the sample values. If the file already exists, add only the settings or code you need and keep the existing configuration.

| Sample in `3.6.x` | Project file | What to change |
| --- | --- | --- |
| [`.env.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.example) | `core/custom/.env` | Set the connection details for your database. Add domain or Manager settings if needed. If your project already uses a root `.env`, add the settings there. |
| [`.env.docker.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.docker.example) | For example, `core/custom/.env.docker` | Replace the sample `DB_USERNAME`, `DB_PASSWORD`, and `DB_DATABASE`. In Docker Compose, attach the file to the CMS service with `env_file`. If the database runs in a separate service, use its service name for `DB_HOST`. The CMS does not load `.env.docker` automatically. |
| [`define.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/define.php.example) | `core/custom/define.php` | The sample lists available constants in a comment. Add `define()` calls for the constants you need to override, for example `define('EVO_SITE_HOSTNAMES', 'example.com,www.example.com');`, using your site's domains. |
| [`routes.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/routes.php.example) | `core/custom/routes.php` | Replace the sample `/helloworld` route with your own path and handler. The guide shows how to add a route for a form. [Forms with custom routes](../08-tutorials-recipes/forms-with-custom-routes.md) |
| [`ControllerNamespace.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings/ControllerNamespace.php.example) | `core/custom/config/cms/settings/ControllerNamespace.php` | Return your controllers' namespace as a string with a trailing backslash. Use the namespace where your `BaseController` is autoloaded. |
| [`settings.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings.php.example) | `core/custom/config/cms/settings.php` | Return an array containing only the settings you want to override. For example, set `site_name` to your site's name. |

Keep real passwords in local environment files or pass them through the runtime environment. Keep them out of Git.

Other samples under `core/custom/` include `composer.json.example` for project dependencies and `config/middleware.php.sample` for custom middleware aliases and groups.

### Create the files from the command line

Run this block in Bash from your project root. Keep only the commands for the samples you need at the end. Each command skips an existing destination file. Then replace the sample values as described in the table.

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

To work with an agent, you can also download `AGENTS.md` into your project root and add your own project rules. The installation package already includes the core PHP models in `core/src/Models/`. [Models reference](models.md) · [Model source files](https://github.com/evolution-cms/evolution/tree/3.6.x/core/src/Models)

```bash
copy_evo_file AGENTS.md AGENTS.md
```

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
