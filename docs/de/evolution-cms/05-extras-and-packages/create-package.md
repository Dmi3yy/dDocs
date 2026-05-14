# Paket Erstellen

[Extras Und Pakete](README.md) / Paket Erstellen

Dieser guide beschreibt das aktuelle Evolution CMS package pattern. Nutze ihn
fuer neue Extras, modules, integration packages, editor packages, manager tools
oder frontend helper packages.

Ein minimales reference package zeigt die kleinste sinnvolle Struktur.
Production packages koennen EvoUI presets, Livewire manager panels, settings
forms, builder blocks, published assets und localized filesystem docs ergaenzen.

## Package Scaffold Erstellen

Fuer ein neues local package beginne mit dem package generator im installierten
Projekt:

```console
php artisan package:create mypackage
```

Der Befehl erstellt ein starter package im project custom packages area und
registriert den autoload entry. Das ist ein scaffold, nicht der finale Standard.
Nach generation pruefe das package gegen diesen guide:

- aktualisiere `composer.json` metadata, package type, requirements, namespace
  und service provider;
- behalte nur surfaces, die das package wirklich braucht;
- fuege package docs hinzu, bevor es release-ready ist;
- vergleiche manager packages mit aktuellen EvoUI und Livewire conventions;
- uebernimm keine legacy folders, alten locale aliases oder unused demo files in
  das finale package.

## Paketform Waehlen

Beginne mit der kleinsten Form, die zur Aufgabe passt.

| Form | Wann nutzen | Typische Dateien |
| --- | --- | --- |
| Service package | Das Paket registriert services, helpers, config, commands, routes oder parser elements. | `composer.json`, `src/*ServiceProvider.php`, `config/*.php`, `lang/<locale>/*.php` |
| Manager module | Das Paket fuegt einen manager workspace hinzu. | service package files plus `module/*.php`, `views/manager/*.blade.php`, manager translations |
| EvoUI module | Der workspace nutzt tables, forms, modals, filters, settings oder builder fields. | manager module files plus `config/*/table.php`, `config/*/modal.php`, `config/settings/form.php`, provider classes |
| Livewire module | Der workspace braucht reactive tabs oder stateful UI ohne iframe reloads. | EvoUI module files plus `src/Livewire/*`, `views/livewire/*.blade.php` |
| Frontend package | Das Paket liefert site routes, Blade templates, published assets oder snippets. | routes/controllers, `views/*`, `public/assets/*`, `resources/*`, parser elements |

Fuege keine Oberflaechen nur deshalb hinzu, weil ein anderes package sie hat.
Backend-only packages brauchen kein manager module; einfache manager modules
brauchen nicht zwingend Livewire.

## Dateistruktur

Ein modernes package sieht typischerweise so aus:

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

Behalte nur Ordner, die das package wirklich verwendet.

## Composer Contract

`composer.json` ist der discovery contract des Pakets. Es braucht package name,
package type, version constraints, PSR-4 namespace und service provider in
`extra.laravel.providers`.

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

Fuege `evolution-cms/evo-ui` nur hinzu, wenn das package EvoUI manager surfaces
nutzt.

## Service Provider

Der service provider ist der entrypoint. Er registriert config defaults,
migrations, views, translations, routes, commands, publish tags, services und
facades.

Manager-only surfaces gehoeren nur in manager mode:

- manager module file;
- manager views and translations;
- EvoUI table, modal and form presets;
- Livewire components;
- manager assets;
- menu labels and icons.

Der provider sollte declarative bleiben. Business logic gehoert in services,
controllers, table providers, models oder support classes.

## Manager Module

Das manager module blockiert direct access ausserhalb des manager mode, liest
request state defensively, baut einen kleinen context array und delegiert
query/save/delete logic an controllers, services, models oder EvoUI providers.

## EvoUI Pattern

Nutze EvoUI fuer tables, filters, row actions, modals, confirmation dialogs,
settings forms, choices fields und builder fields.

| Surface | Besitzer |
| --- | --- |
| Table columns, filters, actions, modal schema | `config/<area>/table.php` und `config/<area>/modal.php` |
| Rows, options, saves, deletes, custom actions | `src/Tables/*TableData.php` oder focused provider class |
| Package settings form | `config/settings/form.php` |
| Runtime settings defaults | package config defaults |
| Project overrides | project custom config |

## Livewire Pattern

Livewire components koordinieren UI, normalisieren active tab ueber eine
allowlist und lassen domain logic in services/provider classes. Nutze Livewire
fuer reactive tabs, stateful UI und partial updates ohne iframe reload.

## Routes, Controllers, And Facades

Package routes mit package prefix und stable route name gruppieren.

```php
Route::prefix('package-name')->name('packageName.')->group(function () {
    Route::post('action', [PackageController::class, 'action'])->name('action');
});
```

Controllers bearbeiten HTTP requests. Services oder facades halten operations,
die templates, snippets, modules oder andere packages aufrufen.

## Config And Settings

Trenne package defaults, project overrides und runtime values. Dokumentiere
jeden public config key mit type, default und effect.

## Assets And Build Output

Wenn das package browser assets hat, liegen source files in `resources/`, built
assets in `public/` oder einem klaren package asset directory. Publish tags
sollten package-specific sein.

Use package-specific publish tags: `package-config`, `package-assets`,
`package-views`, `package-migrations`, `package-images`.

## Migrations, Seeders, And Commands

Migrations gehoeren zu package-owned tables. Seeders und install commands sollen
idempotent sein und demo data nicht ohne explizite Aktion in production
installieren.

## Localization

Nutze canonical locale folders.

| Zweck | Regel |
| --- | --- |
| Ukrainian documentation | Nutze `uk`. Erstelle kein `docs/ua`. |
| Package UI translations | Nutze `lang/<locale>/`. |
| Manager labels | Labels kommen aus translations. |
| Documentation status | Unvollstaendige locales als partial markieren. |

## Package Documentation

Jedes package in dDocs sollte filesystem documentation haben:

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

`frontend-guide.md` nur fuer packages mit UI, Blade, JavaScript, CSS, assets
oder browser runtime erstellen.

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

Vor dem release pruefen:

- namespace and service provider;
- Composer constraints;
- idempotent registration;
- migrations;
- package-specific publish tags;
- manager-mode guard;
- translations;
- public config docs;
- public service/facade docs;
- `docs/uk` fuer Ukrainian docs;
- no `docs/ua`;
- no local development paths;
- package-specific docs are in the package, not in product docs.
