# Utwórz Pakiet

[Extras I Pakiety](README.md) / Utwórz Pakiet

Ten guide opisuje aktualny Evolution CMS package pattern. Używaj go przy
tworzeniu nowego Extra, module, integration package, editor package, manager
tool albo frontend helper package.

Minimalny reference package pokazuje najmniejszą użyteczną strukturę. Pakiety
produkcyjne mogą dodać EvoUI presets, Livewire manager panels, settings forms,
builder blocks, published assets i localized filesystem docs.

## Utwórz Scaffold Pakietu

Dla nowego local package zacznij od package generator w zainstalowanym projekcie:

```console
php artisan package:create mypackage
```

Komenda tworzy starter package w project custom packages area i rejestruje
autoload entry. To scaffold, nie finalny standard. Po generation sprawdź package
względem tego guide:

- zaktualizuj `composer.json` metadata, package type, requirements, namespace i
  service provider;
- zostaw tylko surfaces, których package naprawdę potrzebuje;
- dodaj package docs przed release-ready;
- porównaj manager package z aktualnymi EvoUI i Livewire conventions;
- nie przenoś legacy folders, starych locale aliases ani unused demo files do
  finalnego package.

## Wybierz Kształt Pakietu

Zacznij od najmniejszego kształtu, który pasuje do zadania.

| Kształt | Kiedy używać | Typowe pliki |
| --- | --- | --- |
| Service package | Pakiet rejestruje services, helpers, config, commands, routes albo parser elements. | `composer.json`, `src/*ServiceProvider.php`, `config/*.php`, `lang/<locale>/*.php` |
| Manager module | Pakiet dodaje manager workspace. | pliki service package plus `module/*.php`, `views/manager/*.blade.php`, manager translations |
| EvoUI module | Workspace używa tables, forms, modals, filters, settings albo builder fields. | manager module files plus `config/*/table.php`, `config/*/modal.php`, `config/settings/form.php`, provider classes |
| Livewire module | Workspace wymaga reactive tabs lub stateful UI bez iframe reloads. | EvoUI module files plus `src/Livewire/*`, `views/livewire/*.blade.php` |
| Frontend package | Pakiet udostępnia site routes, Blade templates, published assets albo snippets. | routes/controllers, `views/*`, `public/assets/*`, `resources/*`, parser elements |

Nie dodawaj powierzchni tylko dlatego, że są w innym package. Backend-only
package nie potrzebuje manager module, a prosty manager module nie musi używać
Livewire.

## Układ Plików

Typowy nowoczesny package:

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

Zostaw tylko foldery, których package naprawdę używa.

## Composer Contract

`composer.json` jest discovery contract pakietu. Powinien zawierać package
name, package type, version constraints, PSR-4 namespace oraz service provider w
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

Dodaj `evolution-cms/evo-ui` tylko wtedy, gdy package używa EvoUI manager
surfaces.

## Service Provider

Service provider jest entrypoint pakietu. Rejestruje config defaults,
migrations, views, translations, routes, commands, publish tags, services i
facades.

Manager-only surfaces rejestruj tylko w manager mode:

- manager module file;
- manager views and translations;
- EvoUI table, modal and form presets;
- Livewire components;
- manager assets;
- menu labels and icons.

Provider powinien być declarative. Business logic należy do services,
controllers, table providers, models albo support classes.

## Manager Module

Manager module powinien blokować direct access poza manager mode, czytać request
state defensively, budować mały context array i przekazywać query/save/delete
logic do controllers, services, models albo EvoUI providers.

## EvoUI Pattern

Używaj EvoUI dla tables, filters, row actions, modals, confirmation dialogs,
settings forms, choices fields i builder fields.

| Surface | Właściciel |
| --- | --- |
| Table columns, filters, actions, modal schema | `config/<area>/table.php` i `config/<area>/modal.php` |
| Rows, options, saves, deletes, custom actions | `src/Tables/*TableData.php` albo focused provider class |
| Package settings form | `config/settings/form.php` |
| Runtime settings defaults | package config defaults |
| Project overrides | project custom config |

## Livewire Pattern

Livewire component powinien koordynować UI, normalizować active tab przez
allowlist i zostawiać domain logic w services/provider classes. Use it for
reactive tabs, stateful UI and partial updates without iframe reloads.

## Routes, Controllers, And Facades

Package routes grupuj z package prefix i stable route name.

```php
Route::prefix('package-name')->name('packageName.')->group(function () {
    Route::post('action', [PackageController::class, 'action'])->name('action');
});
```

Controllers obsługują HTTP requests. Services albo facades trzymają operations
wołane przez templates, snippets, modules albo inne packages.

## Config And Settings

Oddziel package defaults, project overrides i runtime values. Każdy public config
key dokumentuj z type, default i effect.

## Assets And Build Output

Jeśli package ma browser assets, trzymaj source files w `resources/`, built
assets w `public/` albo jawnej package asset directory, a publish tags nazywaj
package-specific.

Use package-specific publish tags: `package-config`, `package-assets`,
`package-views`, `package-migrations`, `package-images`.

## Migrations, Seeders, And Commands

Migrations obsługują package-owned tables. Seeders i install commands muszą być
idempotent i nie powinny instalować demo data w production bez wyraźnej decyzji
użytkownika.

## Localization

Używaj canonical locale folders.

| Cel | Reguła |
| --- | --- |
| Ukrainian documentation | Używaj `uk`. Nie twórz `docs/ua`. |
| Package UI translations | Używaj `lang/<locale>/`. |
| Manager labels | Czytaj labels z translations. |
| Documentation status | Niepełne locale oznaczaj jako partial. |

## Package Documentation

Każdy package widoczny w dDocs powinien mieć filesystem documentation:

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

`frontend-guide.md` twórz tylko dla package z UI, Blade, JavaScript, CSS, assets
albo browser runtime.

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

Przed release sprawdź:

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
