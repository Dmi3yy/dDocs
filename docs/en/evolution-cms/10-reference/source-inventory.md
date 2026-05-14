# Source Inventory

[Back](../01-getting-started/installation.md) / [Up](../README.md) / [Next](documentation-navigation.md)

This reference records the current source surfaces that should feed Evolution
CMS product documentation.

## Current Code Sources

| Surface | Documentation use |
| --- | --- |
| Evolution root | Project entry files, root Composer metadata, public `index.php`, sample config, and project-level README. |
| `core/` | Runtime bootstrap, Composer runtime, config, environment cache, database migrations, seeders, tests, storage, and Artisan entrypoint. |
| `core/src/` | Core services, parser, providers, models, controllers, middleware, facades, legacy adapters, support classes, and console commands. |
| `manager/` | Manager entrypoint, action routing, views, processors, includes, media, and manager UI behavior. |
| `install/` | Legacy web installer, CLI install script, install assets, setup functions, and install stubs. |
| `assets/` | Bundled modules, plugins, snippets, manager assets, and install-time assets. |
| `views/` | Public project view layer placeholders. |
| Standalone installer package | Current recommended installation flow and `evo` command behavior. |
| Installed Extras | Package-level docs are discovered separately by dDocs and should not be duplicated here. |
| Old docs archive | Legacy reference material only, after validation against current code. |
| Validated best-practice notes | Future recipes only after current-code review. |

## Current Runtime Signals

| Signal | Notes |
| --- | --- |
| PHP baseline | Current core and installer require PHP `^8.3`. |
| Framework layer | Core uses Illuminate 12 components and Symfony Console/Process surfaces. |
| Manager routing | Manager requests route through a single action handler and action IDs. |
| Console layer | Core exposes Artisan commands for cache, views, packages, presets, routes, scheduling, site updates, translations, tree updates, migrations, seeders, Tailwind, and system tasks. |
| Data layer | Core has Eloquent models for resources, elements, users, permissions, settings, event logs, scheduler/worker state, and closure-table tree data. |
| Tests | Current core has Pest tests for install, manager, updater, system tasks, support utilities, and compatibility behavior. |

## Documentation Coverage Backlog

The English baseline covers requirements, installer-first installation,
installer CLI reference, core concepts, core manager workflows, project
structure, developer reference maps, configuration/runtime bootstrap, core
Composer, legacy compatibility, installed-project Artisan commands, system
settings/defaults, roles and permissions, Blade/template rendering, classic
parser tags, two validated recipes, source policy, navigation rules, and
first-line troubleshooting.

| Gap | Planned public page |
| --- | --- |
| Full classic API and DB API | `06-api-and-integrations/` and `10-reference/` after method-level validation |
| Field-by-field settings UI help | Extend [System Settings Reference](system-settings.md) after checking each manager tab label and save processor |
| Event payload contracts | Extend [Events Reference](events.md) after validating each `invokeEvent` call site |
| Documentation navigation | [Documentation Navigation](documentation-navigation.md) |
| More best-practice recipes | `08-tutorials-recipes/` after current-code validation |
| Locale translations | Keep localized mirrors synchronized with the reviewed English baseline |
