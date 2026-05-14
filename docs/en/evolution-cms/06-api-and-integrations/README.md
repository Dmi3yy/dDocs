# API And Integrations

[Evolution CMS](../README.md) / API And Integrations

This section collects developer-facing integration surfaces for current
Evolution CMS: core runtime APIs, models, events, manager actions, Artisan
commands, package boundaries, and compatibility layers.

## Pages

| Page | Purpose |
| --- | --- |
| [Models Reference](../10-reference/models.md) | Current Eloquent model map and responsibility groups. |
| [Events Reference](../10-reference/events.md) | Current event/plugin surfaces grouped by runtime area. |
| [System Settings Reference](../10-reference/system-settings.md) | Current factory defaults and manager settings tabs. |
| [Roles And Permissions Reference](../10-reference/roles-and-permissions.md) | Manager roles, permission keys, document groups, web access, locks, and file permissions. |
| [Configuration Runtime Reference](../10-reference/configuration-runtime.md) | Bootstrap, environment cache, config files, custom overrides, providers, aliases, and middleware. |
| [Core Composer Reference](../10-reference/core-composer.md) | Composer dependency and autoload boundaries. |
| [Legacy Compatibility Reference](../10-reference/legacy-compatibility.md) | Legacy services, helpers, parser compatibility, and manager action compatibility. |
| [Artisan Commands Reference](../10-reference/artisan-commands.md) | Full installed-project command surface registered by the core runtime. |
| [Blade And Template Rendering Reference](../10-reference/blade-and-template-rendering.md) | Blade rendering, manager views, directives, and icon directives. |
| [Parser Tags Reference](../10-reference/parser-tags.md) | Classic Evolution parser tags and parser order. |
| [Artisan And Manager Actions](../10-reference/artisan-and-manager-actions.md) | Current command and manager-action lookup surface. |
| [Create a package](../05-extras-and-packages/create-package.md) | Modern package structure, service provider wiring, manager module pattern, EvoUI/Livewire surfaces, docs, and release checks. |
| [Create a preset](../05-extras-and-packages/create-preset.md) | Ready-site scaffold structure for installer presets, required Extras, theme assets, custom project code, and validation checks. |
| [Project Structure](../04-development/project-structure.md) | Source layout behind the reference pages. |

## Scope

This section is a validated map of current integration surfaces. Method-level
classic Core API, DB API, routing, and field-by-field database references should
be added as separate reference pages only after each claim is checked against
current code.
