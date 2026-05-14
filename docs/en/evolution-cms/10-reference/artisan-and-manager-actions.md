# Artisan And Manager Actions

[Back](events.md) / [Up](../README.md) / [Next](source-inventory.md)

This page maps current command and manager-action surfaces. It is a starting
point for deeper command reference and manager workflow documentation.

## Artisan Commands

| Area | Commands |
| --- | --- |
| Cache and views | `cache:clear-full`, clear compiled cache, clear views. |
| Packages | `package:discover`, `package:create`, `package:installrequire`, `package:removerequire`, `package:installautoload`, `package:runconsoles`, `extras`. |
| Presets | `preset:apply`, `preset:install`. |
| Lists and diagnostics | `doc:list`, `template:list`, `tv:list`, `deprecated:list`, route list. |
| Scheduling | schedule list and schedule run commands. |
| System tasks | scheduler heartbeat and task worker commands. |
| Site/runtime | site update, tree update, translations sync, vendor publish, Tailwind build. |

Use [CLI Reference](cli-reference.md) for the standalone `evo` installer command
surface and [Artisan Commands Reference](artisan-commands.md) for the full
installed-project command surface. This page is a compact map that connects
commands with manager action surfaces.

## Manager Action Sources

Manager actions are not a single modern route file. Current manager behavior is
resolved from several surfaces:

| Surface | Responsibility |
| --- | --- |
| `ManagerTheme` | Resolves the active manager action and controller. |
| `core/factory/actionlist.php` | Legacy action ID map and action metadata. |
| `core/src/Controllers/` | Current manager page controllers. |
| `manager/actions/` | Legacy and dynamic action handlers. |
| `manager/processors/` | Mutating save/delete/publish/settings/cache processors. |
| `manager/views/` | Blade views and action buttons. |
| Model `managerActionsMap` arrays | Common action IDs for edit, save, delete, duplicate, enable, disable, sort, run, and related model actions. |

## Common Model Actions

| Model Area | Common Actions |
| --- | --- |
| Templates | new, edit, save, delete, duplicate. |
| Template Variables | new, edit, save, delete, duplicate, sort. |
| Chunks | new, edit, save, enable, disable, delete, duplicate. |
| Snippets | new, edit, save, enable, disable, delete, duplicate. |
| Plugins | new, edit, save, enable, disable, delete, duplicate, sort, purge. |
| Modules | new, edit, save, enable, disable, delete, duplicate, run, dependency. |
| Resources | create, edit, save, move, duplicate, publish, unpublish, delete, undelete, empty trash. |

## Documentation Rule

When documenting a manager action, validate all three layers:

- the action ID or model action map;
- the controller/action/processor that handles the request;
- the manager view that exposes the action to the user.

Do not treat old action names as current behavior unless they still resolve in
the current manager runtime.
