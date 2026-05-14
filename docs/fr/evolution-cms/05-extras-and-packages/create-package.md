# Creer Un Package

[Extras Et Packages](README.md) / Creer Un Package

Ce guide decrit le package pattern actuel d'Evolution CMS. Utilisez-le pour un
nouvel Extra, module, integration package, editor package, manager tool ou
frontend helper package.

Un reference package minimal montre la plus petite structure utile. Les
production packages peuvent ajouter EvoUI presets, Livewire manager panels,
settings forms, builder blocks, published assets et localized filesystem docs.

## Creer Le Scaffold Du Package

Pour un nouveau local package, commencez avec le package generator du projet
installe:

```console
php artisan package:create mypackage
```

La commande cree un starter package dans la project custom packages area et
enregistre son autoload entry. C'est un scaffold, pas le standard final. Apres
generation, verifiez le package avec ce guide:

- mettez a jour `composer.json` metadata, package type, requirements, namespace
  et service provider;
- gardez seulement les surfaces dont le package a vraiment besoin;
- ajoutez package docs avant l'etat release-ready;
- comparez les manager packages aux conventions EvoUI et Livewire actuelles;
- ne gardez pas de legacy folders, anciens locale aliases ou unused demo files
  dans le package final.

## Choisir La Forme Du Package

Commencez par la plus petite forme qui repond au besoin.

| Forme | Quand l'utiliser | Fichiers typiques |
| --- | --- | --- |
| Service package | Le package enregistre services, helpers, config, commands, routes ou parser elements. | `composer.json`, `src/*ServiceProvider.php`, `config/*.php`, `lang/<locale>/*.php` |
| Manager module | Le package ajoute un manager workspace. | service package files plus `module/*.php`, `views/manager/*.blade.php`, manager translations |
| EvoUI module | Le workspace utilise tables, forms, modals, filters, settings ou builder fields. | manager module files plus `config/*/table.php`, `config/*/modal.php`, `config/settings/form.php`, provider classes |
| Livewire module | Le workspace a besoin de reactive tabs ou stateful UI sans iframe reloads. | EvoUI module files plus `src/Livewire/*`, `views/livewire/*.blade.php` |
| Frontend package | Le package expose site routes, Blade templates, published assets ou snippets. | routes/controllers, `views/*`, `public/assets/*`, `resources/*`, parser elements |

N'ajoutez pas une surface seulement parce qu'un autre package l'a. Un
backend-only package n'a pas besoin de manager module, et un simple manager
module n'a pas toujours besoin de Livewire.

## Structure Des Fichiers

Un package moderne suit souvent cette structure:

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

Gardez seulement les dossiers que le package utilise vraiment.

## Composer Contract

`composer.json` est le discovery contract du package. Il doit contenir package
name, package type, version constraints, PSR-4 namespace et service provider
dans `extra.laravel.providers`.

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

Ajoutez `evolution-cms/evo-ui` uniquement si le package utilise EvoUI manager
surfaces.

## Service Provider

Le service provider est l'entrypoint. Il enregistre config defaults, migrations,
views, translations, routes, commands, publish tags, services et facades.

Les manager-only surfaces doivent etre enregistrees seulement en manager mode:

- manager module file;
- manager views and translations;
- EvoUI table, modal and form presets;
- Livewire components;
- manager assets;
- menu labels and icons.

Le provider doit rester declarative. Business logic va dans services,
controllers, table providers, models ou support classes.

## Manager Module

Le manager module bloque direct access hors manager mode, lit request state
defensively, construit un petit context array et delegue query/save/delete logic
a controllers, services, models ou EvoUI providers.

## EvoUI Pattern

Utilisez EvoUI pour tables, filters, row actions, modals, confirmation dialogs,
settings forms, choices fields et builder fields.

| Surface | Proprietaire recommande |
| --- | --- |
| Table columns, filters, actions, modal schema | `config/<area>/table.php` et `config/<area>/modal.php` |
| Rows, options, saves, deletes, custom actions | `src/Tables/*TableData.php` ou focused provider class |
| Package settings form | `config/settings/form.php` |
| Runtime settings defaults | package config defaults |
| Project overrides | project custom config |

## Livewire Pattern

Un Livewire component coordonne l'UI, normalise active tab avec une allowlist et
laisse la domain logic aux services/provider classes. Utilisez Livewire pour
reactive tabs, stateful UI et partial updates sans iframe reload.

## Routes, Controllers, And Facades

Groupez package routes avec package prefix et stable route name.

```php
Route::prefix('package-name')->name('packageName.')->group(function () {
    Route::post('action', [PackageController::class, 'action'])->name('action');
});
```

Controllers traitent HTTP requests. Services ou facades gardent les operations
appelees par templates, snippets, modules ou autres packages.

## Config And Settings

Separez package defaults, project overrides et runtime values. Documentez chaque
public config key avec type, default et effect.

## Assets And Build Output

Si le package a des browser assets, gardez source files dans `resources/`, built
assets dans `public/` ou un package asset directory explicite, et utilisez des
publish tags package-specific.

Use package-specific publish tags: `package-config`, `package-assets`,
`package-views`, `package-migrations`, `package-images`.

## Migrations, Seeders, And Commands

Les migrations gerent les package-owned tables. Les seeders et install commands
doivent etre idempotent et ne pas installer de demo data en production sans
action explicite de l'utilisateur.

## Localization

Utilisez des canonical locale folders.

| Objectif | Regle |
| --- | --- |
| Ukrainian documentation | Utilisez `uk`. Ne creez pas `docs/ua`. |
| Package UI translations | Utilisez `lang/<locale>/`. |
| Manager labels | Les labels viennent des translations. |
| Documentation status | Marquez les locales incompletes comme partial. |

## Package Documentation

Chaque package visible dans dDocs doit avoir filesystem documentation:

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

Creez `frontend-guide.md` seulement pour les packages avec UI, Blade,
JavaScript, CSS, assets ou browser runtime.

## Tests And Verification

Minimum:

```console
composer validate
composer dump-autoload
find src config lang database -name "*.php" -print0 | xargs -0 -n1 php -l
php artisan package:discover
php artisan migrate --pretend
```

For manager UI verify module opening, localized menu label/icon, EvoUI
tables/forms, Livewire tabs, published assets, dDocs visibility and internal
Markdown links.

## Release Checklist

Avant release, verifiez:

- namespace and service provider;
- Composer constraints;
- idempotent registration;
- migrations;
- package-specific publish tags;
- manager-mode guard;
- translations;
- public config docs;
- public service/facade docs;
- `docs/uk` for Ukrainian docs;
- no `docs/ua`;
- no local development paths;
- package-specific docs are in the package, not in product docs.
