# Artisan Commands Reference

[Back](legacy-compatibility.md) / [Up](../README.md) / [Next](models.md)

This page documents the installed-project Artisan command surface registered by
the current Evolution CMS core. It is separate from the standalone installer
`evo` command documented in [CLI Reference](cli-reference.md).

## Console Runtime

Evolution CMS uses a custom console application that:

- uses the Evolution CMS version data as the console application name;
- disables auto-exit and exception catching;
- creates a request object from the configured site URL for console context;
- dispatches the Artisan starting event;
- loads deferred providers and bootstraps commands.

Run these commands from an installed project's `core/` runtime context unless a
command explicitly accepts a target path.

## Cache And Views

| Command | Purpose |
| --- | --- |
| `cache:clear` | Clear the configured Illuminate cache store. |
| `cache:forget` | Remove one key from the configured cache store. |
| `cache:clear-full` | Clear compiled Blade/view cache plus Evolution cache surfaces. |
| `clear-compiled` | Remove the compiled class file. |
| `view:clear` | Clear compiled Blade view files. |

## Database And Seeders

| Command | Purpose |
| --- | --- |
| `migrate` | Run database migrations. |
| `migrate:fresh` | Drop all tables and rerun migrations. |
| `migrate:install` | Create the migration repository. |
| `migrate:refresh` | Reset and rerun migrations. |
| `migrate:reset` | Roll back all migrations. |
| `migrate:rollback` | Roll back the last migration batch. |
| `migrate:status` | Show migration status. |
| `make:migration` | Create a migration file. Development command. |
| `db:seed` | Run seeders. |

Treat destructive migration commands as operations tasks. They can destroy data
when run against the wrong database.

## Lists And Diagnostics

| Command | Purpose |
| --- | --- |
| `doc:list` | List documents/resources from `site_content`. |
| `tpl:list` | List templates from `site_templates`. |
| `tv:list` | List Template Variables. |
| `deprecated:list` | List deprecated markers and optional removal/version tags. Development command. |
| `route:list` | List registered routes. |

These commands are useful for documentation validation because they expose
current runtime objects without relying on old manuals.

## Packages And Extras

| Command | Signature | Purpose |
| --- | --- | --- |
| `package:discover` | `package:discover` | Generate service provider discovery data for custom packages. |
| `package:create` | `package:create {packagename?}` | Create a package scaffold. |
| `package:runconsoles` | `package:runconsoles` | Run console commands from custom packages. |
| `package:installrequire` | `package:installrequire {key} {value} {composer_run=1}` | Add a Composer requirement to custom package requirements. |
| `package:removerequire` | `package:removerequire {key} {composer_run=1}` | Remove a Composer requirement from custom package requirements. |
| `package:installautoload` | `package:installautoload {key} {value} {composer_run=1}` | Add an autoload entry to custom package requirements. |
| `extras` | `extras {typePackage?} {packageName?} {versionPackage?} {namePackage?} {--list} {--json}` | Browse or install Extras/packages depending on arguments. |

Installed Extras should document their package-specific commands inside their
own package docs. This page documents the core command surface that discovers
and manages packages.

## Presets

| Command | Purpose |
| --- | --- |
| `preset:install` | Install a preset from a Git repository or local path. |
| `preset:apply` | Apply a preset project layer to an Evolution CMS install. |

`preset:apply` supports options for target path, source path, Git source/ref,
keeping cloned sources, preset name, deleting files missing from the preset,
dry-run mode, forced seeders, and skipping Composer dump-autoload.

## Scheduling And System Tasks

| Command | Purpose |
| --- | --- |
| `schedule:list` | List scheduled commands. |
| `schedule:run` | Run due scheduled commands. |
| `schedule:work` | Run the scheduler worker loop. |
| `schedule:finish` | Mark a scheduled event as finished. |
| `schedule:clear-cache` | Clear scheduler mutex/cache state. |
| `schedule:test` | Test a scheduled command. |
| `system:scheduler-heartbeat` | Record scheduler heartbeat state. |
| `system:task-worker` | Record system task worker activity and prepare queued task execution. |

System task commands are runtime operations commands. Production docs should
include process supervision and logging policy before recommending always-on
workers.

## Site And Project Maintenance

| Command | Purpose |
| --- | --- |
| `make:site` | Update/build site objects from configured sources. |
| `closuretable:rebuild` | Rebuild the resource tree closure table. |
| `translations:sync` | Sync translation keys with the default language file. |
| `tailwind:build {package?} {--force}` | Compile Tailwind CSS for one package, all packages, or forced rebuild. |
| `vendor:publish` | Publish publishable vendor assets. Development command. |

`make:site` and `closuretable:rebuild` affect runtime state. Use backups and a
known deployment flow before running them in production.

## Development Commands

Development commands include `vendor:publish`, `deprecated:list`, and
`make:migration`. They are registered by the same service provider but should be
documented as development/maintenance tools, not normal manager workflows.

## Documentation Rule

When documenting a command, include:

- command name/signature;
- runtime context;
- whether it reads or mutates project state;
- whether it is safe for production;
- related config or Composer boundary.

Do not document package-specific command behavior in this product reference
unless the command is registered by Evolution CMS core.
