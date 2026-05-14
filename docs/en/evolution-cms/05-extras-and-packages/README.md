# Extras And Packages

[Evolution CMS](../README.md) / Extras And Packages

Extras extend Evolution CMS with manager modules, frontend integrations,
commands, migrations, parser elements, services, or documentation. Installed
Extras expose their own package documentation in dDocs, so the product docs only
describe package conventions and integration rules.

## Pages

| Page | Purpose |
| --- | --- |
| [Create a package](create-package.md) | Build a modern Evolution CMS package with a service provider, manager module, EvoUI/Livewire surfaces, config, localization, docs, and release checks. |
| [Create a preset](create-preset.md) | Build a ready-site scaffold for the installer with views, themes, custom project code, config, required Extras, and validation checks. |

## Package Documentation Boundary

Evolution CMS product documentation should not duplicate every installed Extra.
Each package should ship its own `docs/<locale>/` tree, and dDocs indexes those
package docs from the filesystem.

Use this section for shared package standards:

- package layout;
- preset layout;
- Composer and service provider contracts;
- manager module wiring;
- EvoUI and Livewire conventions;
- config and settings conventions;
- package documentation requirements;
- release checklist.

Use the package's own docs for package-specific workflows, API methods, field
lists, screenshots, troubleshooting, and migration notes.
