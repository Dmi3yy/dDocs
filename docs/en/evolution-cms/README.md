# Evolution CMS Documentation

[Documentation Hub](../README.md) / Evolution CMS

This is the canonical English product documentation surface for current
Evolution CMS work in dDocs. It documents the current codebase first, then uses
older material only after current-code validation.

## Start Here

| Need | Open |
| --- | --- |
| Install a new project | [Installation](01-getting-started/installation.md) |
| Check runtime requirements | [Requirements](01-getting-started/requirements.md) |
| Learn core vocabulary | [Core Concepts](01-getting-started/core-concepts.md) |
| Use core manager workflows | [Using Evolution CMS](02-using-evolution-cms/README.md) |
| Understand the runtime layout | [Project Structure](04-development/project-structure.md) |
| Create a modern package | [Create a package](05-extras-and-packages/create-package.md) |
| Create a site preset | [Create a preset](05-extras-and-packages/create-preset.md) |
| Find developer reference maps | [API And Integrations](06-api-and-integrations/README.md) |
| Diagnose common project issues | [Troubleshooting](07-security-updates-operations/troubleshooting.md) |
| Review core defaults and settings | [System Settings Reference](10-reference/system-settings.md) |
| Review roles and permissions | [Roles And Permissions Reference](10-reference/roles-and-permissions.md) |
| Understand config and `.env` loading | [Configuration Runtime Reference](10-reference/configuration-runtime.md) |
| Understand core Composer wiring | [Core Composer Reference](10-reference/core-composer.md) |
| Understand legacy compatibility | [Legacy Compatibility Reference](10-reference/legacy-compatibility.md) |
| Use Blade templates and directives | [Blade And Template Rendering Reference](10-reference/blade-and-template-rendering.md) |
| Look up classic parser tags | [Parser Tags Reference](10-reference/parser-tags.md) |
| Look up installed-project Artisan commands | [Artisan Commands Reference](10-reference/artisan-commands.md) |
| Look up installer commands | [CLI Reference](10-reference/cli-reference.md) |
| Follow validated recipes | [Tutorials And Recipes](08-tutorials-recipes/README.md) |
| Review package conventions | [Extras And Packages](05-extras-and-packages/README.md) |
| Browse all reference pages | [Reference](10-reference/README.md) |
| Understand the source map | [Source Inventory](10-reference/source-inventory.md) |
| Follow page linking rules | [Documentation Navigation](10-reference/documentation-navigation.md) |
| See allowed content sources | [Documentation Source Policy](10-reference/documentation-source-policy.md) |

## Documentation Shape

Evolution CMS product docs are organized by reader task, not by old repository
folders.

```text
evolution-cms/
  01-getting-started/
  02-using-evolution-cms/
  03-site-building/
  04-development/
  05-extras-and-packages/
  06-api-and-integrations/
  07-security-updates-operations/
  08-tutorials-recipes/
  09-community-support/
  10-reference/
```

This baseline contains the first release-ready product documentation pages.
Deep method-level references, route payloads, and field-level manager help are
tracked as follow-up documentation tasks and should be added only after current
code validation.

## Source Policy

- Current Evolution CMS code is the source of truth for runtime behavior.
- The standalone `evolution-cms/installer` package is the source of truth for
  the current install flow.
- The old documentation archive remains a legacy archive.
- Old component manuals are not migrated into this product-docs tree because
  installed Extras expose their own package documentation in dDocs.
- Best-practice notes can become public pages only after current-code review.

## Navigation Rule

Pages should use stable relative links. When a section grows, add a small
navigation line with `Back`, `Up`, and `Next` links so readers can traverse the
docs without relying only on the tree.
