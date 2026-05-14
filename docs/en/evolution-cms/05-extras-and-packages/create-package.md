# Create A Package

[Extras And Packages](README.md) / Create A Package

This guide describes the current Evolution CMS package pattern. Use it when you
create a new Extra, module, integration package, editor package, manager tool, or
frontend helper package.

The minimal reference package shows the smallest useful structure. Current
production packages add richer surfaces such as EvoUI presets, Livewire manager
panels, settings forms, builder blocks, published assets, and localized
filesystem documentation.

## Scaffold The Package

For a new local package, start from the package generator inside the installed
project:

```console
php artisan package:create mypackage
```

The command creates a starter package under the project's custom packages area
and registers its autoload entry. Treat the generated files as a scaffold, not
as the final standard. After generation, review the package against this guide:

- update `composer.json` metadata, package type, requirements, namespace, and
  service provider;
- keep only the surfaces the package really needs;
- add package docs before the package is considered release-ready;
- compare manager packages against current EvoUI and Livewire conventions;
- avoid carrying legacy folders, old locale aliases, or unused demo files into
  the final package.

## Choose The Package Shape

Start with the smallest package shape that matches the job.

| Package shape | Use when | Typical files |
| --- | --- | --- |
| Service package | The package registers services, helpers, config, commands, routes, or parser elements. | `composer.json`, `src/*ServiceProvider.php`, `config/*.php`, `lang/<locale>/*.php` |
| Manager module | The package adds a manager workspace. | service package files plus `module/*.php`, `views/manager/*.blade.php`, manager translations |
| EvoUI module | The manager workspace uses tables, forms, modals, filters, settings, or builder fields. | manager module files plus `config/*/table.php`, `config/*/modal.php`, `config/settings/form.php`, provider classes |
| Livewire module | The manager workspace needs reactive tabs or stateful UI without iframe reloads. | EvoUI module files plus `src/Livewire/*`, `views/livewire/*.blade.php` |
| Frontend package | The package exposes site routes, Blade templates, published assets, or snippets. | routes/controllers, `views/*`, `public/assets/*`, `resources/*`, parser elements |

Avoid adding surfaces only because another package has them. A backend-only
package does not need a manager module. A simple manager module does not need
Livewire. A package without browser runtime does not need a frontend guide.

## File Layout

A modern package usually follows this layout:

```text
package/
  composer.json
  README.md
  config/
  database/
    migrations/
  docs/
    README.md
    en/
      README.md
      user-guide.md
      developer-guide.md
      configuration.md
      reference.md
      troubleshooting.md
    uk/
  lang/
    en/
    uk/
  module/
  plugins/
  chunks/
  snippets/
  src/
    Console/
    Controllers/
    Facades/
    Http/
    Livewire/
    Models/
    Support/
    Tables/
    PackageServiceProvider.php
  views/
    livewire/
    manager/
  public/
    assets/
  resources/
    css/
    js/
  tests/
```

Only keep folders that the package actually uses. Empty placeholder folders are
acceptable only when the installer or package loader needs them.

## Composer Contract

`composer.json` is the package discovery contract.

Required parts:

- package name;
- package type used by the Evolution package installer;
- PHP and Evolution CMS version constraints;
- PSR-4 namespace;
- service provider in `extra.laravel.providers`.

Example:

```json
{
  "name": "vendor/package-name",
  "type": "evolution-cms-module",
  "require": {
    "php": "^8.3",
    "evolution-cms/evolution": "^3.5",
    "evolution-cms/evo-ui": "^1.0"
  },
  "autoload": {
    "psr-4": {
      "Vendor\\PackageName\\": "src/"
    }
  },
  "extra": {
    "laravel": {
      "providers": [
        "Vendor\\PackageName\\PackageServiceProvider"
      ]
    }
  }
}
```

Add `evolution-cms/evo-ui` only when the package uses EvoUI manager surfaces.
Add frontend build dependencies only when the package ships browser assets that
must be rebuilt.

## Service Provider

The service provider is the package entrypoint. It should keep package
registration explicit and separated by runtime area.

Register common surfaces:

- config defaults with `mergeConfigFrom`;
- migrations with `loadMigrationsFrom`;
- Blade views with `loadViewsFrom`;
- translations with `loadTranslationsFrom`;
- routes by including a package route file;
- commands through the provider's command list;
- published config, views, migrations, assets, and images;
- package services and facades in the container.

Register manager-only surfaces only in manager mode:

- manager module file;
- manager views;
- manager translations;
- EvoUI table, modal, and form presets;
- Livewire components;
- manager assets;
- manager menu labels and icons.

Keep the provider declarative. Business logic belongs in service classes,
controllers, table providers, model classes, or support classes.

## Manager Module

A manager module has two responsibilities:

- register an Evolution manager entry;
- render the manager workspace safely inside the manager runtime.

The module registration should provide:

- localized title;
- stable icon;
- module file path;
- menu placement configuration when the package supports it.

The module file should:

- block direct access outside manager mode;
- read request state defensively;
- build a small context array;
- render Blade or Livewire views;
- redirect old module tabs only when needed for compatibility;
- set session action/name values when legacy manager logging expects them.

Do not put large query, save, delete, or rendering logic directly in the module
file. Move that logic to controllers, services, models, or EvoUI providers.

## EvoUI Pattern

Use EvoUI when the manager UI has repeatable data surfaces:

- tables;
- filters;
- row actions;
- modals;
- confirmation dialogs;
- settings forms;
- choices fields;
- builder fields.

Keep UI shape in config and behavior in provider classes.

| Surface | Recommended owner |
| --- | --- |
| Table columns, filters, actions, modal schema | `config/<area>/table.php` and `config/<area>/modal.php` |
| Rows, options, saves, deletes, custom actions | `src/Tables/*TableData.php` or a focused provider class |
| Package settings form | `config/settings/form.php` |
| Runtime settings defaults | package config defaults |
| Project overrides | project custom config |

Settings forms should define source, defaults, validation rules, labels, help
text, and actions. This keeps package configuration editable in the manager
without hiding where the config is stored.

## Livewire Pattern

Use Livewire when the manager workspace needs reactive state, tab switching, or
partial updates without reloading the full manager iframe.

A typical Livewire manager panel should:

- accept raw tabs and context through `mount`;
- normalize active tab values against an allowlist;
- render a namespaced package view;
- expose small public methods for UI actions;
- map active tabs to EvoUI presets or view fragments;
- keep all query and persistence logic outside the component when possible.

The component is a coordinator, not the domain service.

## Routes, Controllers, And Facades

Package routes should be grouped with a package prefix and a stable route name.

```php
Route::prefix('package-name')->name('packageName.')->group(function () {
    Route::post('action', [PackageController::class, 'action'])->name('action');
});
```

Use controllers for HTTP request handling. Use services or facades for package
operations that templates, snippets, modules, or other packages call directly.

Document public facade methods in the package reference. Mark internal helper
methods as internal by convention and keep them out of public docs.

## Config And Settings

A package should separate three layers:

| Layer | Purpose |
| --- | --- |
| Package defaults | Versioned defaults shipped with the package. |
| Project overrides | Editable project config stored outside vendor/package source. |
| Runtime values | Values read through helper methods, facade methods, or Evolution config. |

Rules:

- keep defaults safe for a fresh installation;
- document every public config key with type, default, and effect;
- do not scan or write outside expected project paths;
- make destructive or externally visible behavior opt-in;
- prefer settings forms for manager-editable package settings.

## Assets And Build Output

Packages may ship prebuilt assets when the runtime must work without Node.js.
If a package has build sources, keep the contract clear:

- source files live under `resources/`;
- built package assets live under `public/` or another explicit package asset
  directory;
- publish tags copy assets into the project public path;
- build commands are documented in the developer guide;
- generated assets are not edited by hand unless the package explicitly treats
  them as source.

Use package-specific publish tags so users can publish only what they need:

- `package-config`;
- `package-assets`;
- `package-views`;
- `package-migrations`;
- `package-images`.

## Migrations, Seeders, And Commands

Use migrations for package-owned tables. Use seeders or install commands only
for demo data, default records, or idempotent setup.

Commands should be safe to rerun:

- copy assets idempotently;
- run optional migrations only when requested;
- create or update demo records instead of duplicating them;
- show clear output for each action;
- avoid production demo data unless the user explicitly installs it.

## Localization

Use canonical locale folders.

| Purpose | Rule |
| --- | --- |
| Ukrainian documentation | Use `uk`. Do not create `docs/ua`. |
| Package UI translations | Use the package's `lang/<locale>/` files. |
| Manager labels | Read labels from translations, not hardcoded strings. |
| Documentation status | Mark incomplete locales as partial instead of pretending they are complete. |

Legacy manager language values may be normalized by runtime code, but new
package documentation must not publish `ua` as a documentation locale.

## Package Documentation

Every package visible in dDocs should ship filesystem documentation.

Recommended docs contract:

```text
docs/
  README.md
  en/
    README.md
    user-guide.md
    developer-guide.md
    configuration.md
    reference.md
    troubleshooting.md
  uk/
  pl/
  de/
  fr/
```

Required files depend on the package:

| File | Required when |
| --- | --- |
| `docs/README.md` | Always. |
| `docs/<locale>/README.md` | Always for supported locales. |
| `user-guide.md` | The package has manager or user workflows. |
| `developer-guide.md` | The package has runtime, integration, or extension surfaces. |
| `configuration.md` | The package has config or settings. |
| `reference.md` | The package exposes routes, events, services, facade methods, models, parser elements, or stable UI contracts. |
| `frontend-guide.md` | The package exposes UI, Blade, JavaScript, CSS, assets, or browser runtime. |
| `troubleshooting.md` | Recommended for all runtime packages. |

Do not create placeholder `frontend-guide.md` files for backend-only packages.

## Tests And Verification

At minimum, run:

```console
composer validate
composer dump-autoload
find src config lang database -name "*.php" -print0 | xargs -0 -n1 php -l
php artisan package:discover
php artisan migrate --pretend
```

For packages with manager UI, also verify:

- module opens in the manager;
- menu label and icon are localized;
- EvoUI tables/forms load;
- Livewire tabs switch without losing state;
- published assets are available;
- package docs appear in dDocs;
- internal Markdown links resolve.

## Release Checklist

Before release, confirm:

- package namespace and provider are correct;
- Composer constraints match the supported Evolution CMS version;
- service provider registration is idempotent;
- migrations are safe and reversible where possible;
- publish tags are package-specific;
- manager-only code is guarded by manager mode;
- UI labels are translated;
- public config keys are documented;
- public facade/service methods are documented;
- package docs use `docs/uk` for Ukrainian documentation;
- no `docs/ua` folder is published as a new standard;
- no local development paths appear in docs;
- package-specific docs live in the package, not in Evolution CMS product docs.
