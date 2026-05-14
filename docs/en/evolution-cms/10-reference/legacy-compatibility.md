# Legacy Compatibility Reference

[Back](core-composer.md) / [Up](../README.md) / [Next](artisan-commands.md)

Evolution CMS keeps a legacy compatibility layer so current code can support
classic Evolution APIs, parser behavior, manager actions, and older extension
patterns while the runtime uses modern PHP and Illuminate components.

## Legacy Source Layer

| File Or Class | Responsibility |
| --- | --- |
| `core/includes/legacy.inc.php` | Bootstrap include for legacy compatibility. |
| `Legacy/DeprecatedCore.php` | Deprecated core compatibility behavior. |
| `Legacy/ManagerApi.php` | Manager action/API compatibility surface. |
| `Legacy/TemplateParser.php` | Template parser compatibility. |
| `Legacy/Modifiers.php` | Parser modifier and conditional modifier support. |
| `Legacy/Phx.php` | PHx-style placeholder/modifier compatibility. |
| `Legacy/Cache.php` | Legacy cache rebuild/update behavior. |
| `Legacy/Permissions.php` | User/document permission compatibility behavior. |
| `Legacy/ErrorHandler.php` | Legacy error handling. |
| `Legacy/LogHandler.php` | Legacy logging behavior. |
| `Legacy/PasswordHash.php` | Legacy password hashing compatibility. |
| `Legacy/PhpCompat.php` | PHP compatibility helpers. |
| `Legacy/Categories.php` | Category compatibility behavior. |
| `Legacy/ModuleCategoriesManager.php` | Module category compatibility behavior. |
| `Legacy/mgrResources.php` | Manager resource/element helper compatibility. |

## Legacy Providers

The application provider list registers compatibility providers for deprecated
core behavior, DB API, manager API, modifiers, password hashing, PHx,
DLTemplate, ModResource, ModUsers, filesystem helpers, and related support.

These providers keep classic APIs available while newer code uses current
services, models, controllers, and facades.

## Legacy Includes And Helpers

Core Composer autoloads helper/action files that preserve older function-based
surfaces:

| Area | Autoloaded Files |
| --- | --- |
| Manager action helpers | `functions/actions/*.php` for file manager, settings, content mutation, plugins, logging, help, and backup manager behavior. |
| Runtime helpers | `functions/helper.php`, `functions/laravel.php`, `functions/utils.php` |
| Tree and nodes | `functions/nodes.php` |
| Preload and processors | `functions/preload.php`, `functions/processors.php` |

New code should prefer current services and models, but documentation must
recognize that these function surfaces still exist.

## Legacy Manager Actions

The manager still contains action handlers and processors:

| Surface | Purpose |
| --- | --- |
| `core/factory/actionlist.php` | Legacy action ID map. |
| `manager/actions/` | Legacy and dynamic page/action handlers. |
| `manager/processors/` | Mutating processors for save, delete, publish, cache, settings, roles, modules, users, and elements. |
| `ManagerTheme` | Resolves active action/controller and manager theme behavior. |
| Model action maps | Provide edit/new/save/delete/run action IDs for model-backed screens. |

When documenting a manager feature, validate the action ID, controller/action
file, processor, and Blade view together.

## Parser Compatibility

Classic parser features remain part of the current runtime:

| Feature | Notes |
| --- | --- |
| Resource tags | `[*field*]` and TV field syntax. |
| Settings tags | `[(setting)]`. |
| Chunks and snippets | `{{chunk}}`, `[[snippet]]`, and `[!snippet!]`. |
| Placeholders | `[+placeholder+]` with PHx/modifier behavior. |
| URL tags | `[~id~]`. |
| Conditional tags | `<@IF:...>`, `<@ELSEIF:...>`, `<@ELSE>`, `<@ENDIF>`. |
| Template modes | `@CODE`, `@FILE`, `@DOCUMENT`, `@B_FILE`, and `@B_CODE`. |

Use [Parser Tags Reference](parser-tags.md) for syntax details.

## What Not To Migrate Blindly

Do not copy old component manuals into product documentation just because the
legacy layer still exists. Old components, old snippets, and older site-building
patterns should stay in the legacy archive unless they are validated against the
current code and still represent recommended usage.

Installed Extras expose their own docs as separate dDocs sources.

## Documentation Rule

When documenting legacy behavior, label it as compatibility unless it is the
recommended current path. Pair legacy claims with current code references and
avoid turning old APIs into new best-practice examples.
