# Project Structure

[Back](README.md) / [Up](README.md) / [Next](../10-reference/cli-reference.md)

This page maps the current Evolution CMS repository into documentation
boundaries. It explains where to look before writing deeper manager, API, model,
or operations pages.

## Top-Level Layout

| Path | Responsibility |
| --- | --- |
| `composer.json` | Project-level Composer metadata and baseline PHP requirements. |
| `index.php` | Public entrypoint for web requests. |
| `core/` | Main runtime, framework integration, config, database, console, tests, storage, and source code. |
| `manager/` | Manager entrypoint, actions, processors, views, includes, and manager media. |
| `assets/` | Public assets, uploaded files, bundled snippets/plugins/modules/templates/TV placeholders, cache, backup, import, and export locations. |
| `views/` | Project view layer placeholders. |
| `install/` | Legacy web/CLI installer surface kept for compatibility and debugging. New docs should teach the standalone installer first. |

## Core Runtime

`core/` is the main runtime boundary.

| Path | Responsibility |
| --- | --- |
| `core/composer.json` | Main runtime dependency set, including Illuminate components, database, routing, view, cache, queue, mail, filesystem, Tracy, Composer integration, and package merge behavior. |
| `core/bootstrap.php` | Runtime bootstrap: Composer autoload, `.env` cache loading, custom definitions, core definitions, sessions, legacy includes, and protection includes. |
| `core/config/` | Runtime configuration for app, cache, database, filesystems, logging, session, Tracy, views, icons, migrations, and observer wiring. |
| `core/custom/` | Project override layer for environment examples, custom Composer requirements, middleware, definitions, and routes. |
| `core/database/` | Migrations, seeders, and database artifacts. |
| `core/factory/` | Factory-level runtime lists such as settings and manager actions. |
| `core/functions/` | Shared function helpers. |
| `core/includes/` | Compatibility includes and runtime include files. |
| `core/lang/` | Core language files. |
| `core/modifiers/` | Parser/modifier support. |
| `core/storage/` | Generated runtime storage and cache. |
| `core/tests/` | Current Pest/PHPUnit test coverage for install, manager, core, support utilities, package/runtime, and compatibility behavior. |

## Source Layers

`core/src/` is the current PHP source layer.

| Layer | Responsibility |
| --- | --- |
| `Core.php` | Central runtime object for config, parser execution, cache, events, document loading, and compatibility APIs. |
| `Parser.php` | Parser-oriented document rendering and compatibility flow. |
| `UrlProcessor.php` | URL generation and friendly URL resolution. |
| `Bootstrap/` | Environment and bootstrap helpers. |
| `Console/` | Artisan commands for cache, views, packages, presets, routes, scheduling, site updates, translations, tree updates, and system tasks. |
| `Controllers/` | Manager page controllers and resource/user/system screens. |
| `Events/` | Event support classes. |
| `Exceptions/` | Runtime exception classes. |
| `Extensions/` | Extension support classes. |
| `Facades/` | Laravel-style accessors for shared services. |
| `Interfaces/` | Contracts for manager theme and runtime abstractions. |
| `Legacy/` | Compatibility layer for older APIs and parser behavior. |
| `Middleware/` | HTTP and manager middleware. |
| `Models/` | Eloquent models for resources, elements, users, permissions, settings, events, scheduler/worker state, and tree data. |
| `Observers/` | Model observer wiring. |
| `Providers/` | Service providers for auth, Blade, Composer, config, database, events, filesystem, manager theme, packages, routing, sessions, tasks, Tracy, URL handling, and more. |
| `Services/` | Higher-level service flows, including store/package and system task services. |
| `Support/` | Utility classes and support helpers. |
| `Tracy/` | Debug panel integration. |
| `Traits/` | Shared traits for models and runtime behavior. |

## Manager Runtime

`manager/` is the manager UI and action surface.

| Path | Responsibility |
| --- | --- |
| `manager/actions/` | Legacy and dynamic manager action handlers. |
| `manager/processors/` | Save/delete/publish/cache/settings processors that mutate manager data. |
| `manager/views/` | Blade views for manager pages, partials, settings screens, resources, modules, users, and frames. |
| `manager/includes/` | Manager access control, config checks, parser includes, headers, debug helpers, and legacy include boundaries. |
| `manager/media/` | Manager CSS, JS, images, browser assets, and theme media. |

When documenting manager behavior, validate both the controller/source class and
the manager view or processor that actually performs the action.

## Models And Elements

Core content and element concepts map to Eloquent models:

| Concept | Model |
| --- | --- |
| Resource / document tree node | `SiteContent` |
| Template | `SiteTemplate` |
| Template Variable | `SiteTmplvar` |
| TV-template relation | `SiteTmplvarTemplate` |
| TV value on a resource | `SiteTmplvarContentvalue` |
| Chunk | `SiteHtmlsnippet` |
| Snippet | `SiteSnippet` |
| Plugin | `SitePlugin` |
| Plugin-event relation | `SitePluginEvent` |
| Event name | `SystemEventname` |
| Module | `SiteModule` |
| Settings | `SystemSetting` |
| Manager user | `User` and `UserAttribute` |
| Permissions and groups | `Permissions`, `UserRole`, `DocumentGroup`, `DocumentgroupName`, and related group models |

Detailed field-by-field model documentation belongs in API/reference pages, not
in this structure overview.

## Package And Extra Boundaries

Evolution CMS product docs describe the shared runtime and extension contracts.
Installed Extras own their feature manuals. In dDocs, package documentation is
read from each installed package's filesystem docs root and shown beside this
product tree.

Document an Extra in this product tree only when the page explains a shared
Evolution CMS package contract, installer behavior, or manager integration rule.

## Installer Boundary

The standalone installer is the primary current install flow. It owns `evo
install`, `evo self-install`, `evo self-update`, and `evo system-status`.

The repository's `install/` folder remains important for compatibility,
maintenance, install stubs, and debugging, but new user-facing install docs
should start with the standalone installer.

## Test Surfaces

Current tests live under `core/tests/` and cover:

- install and migration behavior;
- manager UI contracts and access behavior;
- cache and site update commands;
- support utilities and path normalization;
- compatibility behavior for legacy APIs;
- package/store/system task flows.

When a documentation page describes runtime behavior, prefer a current code
path plus an existing test as validation. If no test exists, document the claim
conservatively and mark deeper validation as follow-up work.
