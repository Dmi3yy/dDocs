# Reference

[Evolution CMS](../README.md) / Reference

This section is a lookup surface for current Evolution CMS runtime contracts.
It is written from current code first and avoids package manuals for installed
Extras.

## Core References

| Page | Purpose |
| --- | --- |
| [Configuration Runtime Reference](configuration-runtime.md) | Bootstrap flow, `.env` cache, core config files, custom overrides, providers, aliases, and middleware. |
| [Core Composer Reference](core-composer.md) | Root/core Composer boundaries, dependencies, merge plugin, autoload, and scripts. |
| [Legacy Compatibility Reference](legacy-compatibility.md) | Legacy classes, providers, helpers, manager actions, and compatibility rules. |
| [Artisan Commands Reference](artisan-commands.md) | Installed-project Artisan commands registered by the core runtime. |
| [System Settings Reference](system-settings.md) | Default settings, manager settings tabs, and production notes. |
| [Roles And Permissions Reference](roles-and-permissions.md) | Manager roles, permission keys, document groups, web access, locks, and file permissions. |
| [Blade And Template Rendering Reference](blade-and-template-rendering.md) | Blade templates, manager Blade views, directives, icons, and template resolution. |
| [Parser Tags Reference](parser-tags.md) | Classic Evolution parser tags, chunks, snippets, settings, placeholders, URLs, and conditionals. |
| [Models Reference](models.md) | Eloquent model map for resources, elements, settings, users, permissions, and runtime state. |
| [Events Reference](events.md) | Seeded event names and current event surfaces grouped by runtime area. |
| [Artisan And Manager Actions](artisan-and-manager-actions.md) | Short manager-action and command map. |
| [CLI Reference](cli-reference.md) | Standalone installer `evo` commands. |
| [Create a package](../05-extras-and-packages/create-package.md) | Shared package creation contract for modern Extras. |
| [Create a preset](../05-extras-and-packages/create-preset.md) | Shared preset creation contract for ready-site installer scaffolds. |
| [Source Inventory](source-inventory.md) | Source surfaces that feed product documentation. |
| [Documentation Navigation](documentation-navigation.md) | Public documentation linking and navigation rules. |
| [Documentation Source Policy](documentation-source-policy.md) | Which sources are allowed for public documentation. |

## Boundary

This reference describes Evolution CMS itself: runtime, manager, parser,
settings, permissions, events, models, and install/operation surfaces.
Installed Extras appear as separate dDocs sources and should keep their own
user and developer manuals.
