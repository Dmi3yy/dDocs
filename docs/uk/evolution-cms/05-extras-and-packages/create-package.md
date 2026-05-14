# Створити Пакет

[Extras Та Пакети](README.md) / Створити Пакет

Цей guide описує поточний Evolution CMS package pattern. Використовуйте його
для нового Extra, module, integration package, editor package, manager tool або
frontend helper package.

Мінімальний reference package показує найменшу корисну структуру. Production
packages додають багатші поверхні: EvoUI presets, Livewire manager panels,
settings forms, builder blocks, published assets і localized filesystem docs.

## Створити Scaffold Пакета

Для нового local package починайте з package generator у встановленому проекті:

```console
php artisan package:create mypackage
```

Команда створює starter package у project custom packages area і реєструє
autoload entry. Це scaffold, а не фінальний стандарт. Після generation перевірте
package за цим guide:

- оновіть `composer.json` metadata, package type, requirements, namespace і
  service provider;
- залиште тільки surfaces, які package реально потребує;
- додайте package docs до release-ready стану;
- звірте manager package з поточними EvoUI і Livewire conventions;
- не переносіть legacy folders, старі locale aliases або unused demo files у
  фінальний package.

## Обрати Форму Пакета

Починайте з найменшої форми, яка закриває задачу.

| Форма | Коли використовувати | Типові файли |
| --- | --- | --- |
| Service package | Пакет реєструє services, helpers, config, commands, routes або parser elements. | `composer.json`, `src/*ServiceProvider.php`, `config/*.php`, `lang/<locale>/*.php` |
| Manager module | Пакет додає manager workspace. | service package files плюс `module/*.php`, `views/manager/*.blade.php`, manager translations |
| EvoUI module | Manager workspace використовує tables, forms, modals, filters, settings або builder fields. | manager module files плюс `config/*/table.php`, `config/*/modal.php`, `config/settings/form.php`, provider classes |
| Livewire module | Workspace потребує reactive tabs або stateful UI без iframe reloads. | EvoUI module files плюс `src/Livewire/*`, `views/livewire/*.blade.php` |
| Frontend package | Пакет відкриває site routes, Blade templates, published assets або snippets. | routes/controllers, `views/*`, `public/assets/*`, `resources/*`, parser elements |

Не додавайте поверхні тільки тому, що вони є в іншому package. Backend-only
package не потребує manager module. Простий manager module не потребує Livewire.
Package без browser runtime не потребує frontend guide.

## Структура Файлів

Сучасний package зазвичай має таку структуру:

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

Залишайте тільки ті folders, які package реально використовує. Empty
placeholder folders допустимі лише тоді, коли вони потрібні installer або
package loader.

## Composer Contract

`composer.json` є discovery contract пакета.

Обов'язкові частини:

- package name;
- package type для Evolution package installer;
- PHP і Evolution CMS version constraints;
- PSR-4 namespace;
- service provider у `extra.laravel.providers`.

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

Додавайте `evolution-cms/evo-ui` тільки якщо package використовує EvoUI manager
surfaces. Frontend build dependencies потрібні лише пакетам із browser assets.

## Service Provider

Service provider є entrypoint пакета. Він має явно реєструвати surfaces і
розділяти їх за runtime area.

Спільні surfaces:

- config defaults через `mergeConfigFrom`;
- migrations через `loadMigrationsFrom`;
- Blade views через `loadViewsFrom`;
- translations через `loadTranslationsFrom`;
- routes через package route file;
- commands;
- published config, views, migrations, assets та images;
- package services і facades у container.

Manager-only surfaces реєструйте тільки в manager mode:

- manager module file;
- manager views;
- manager translations;
- EvoUI table, modal і form presets;
- Livewire components;
- manager assets;
- manager menu labels та icons.

Provider має бути declarative. Business logic належить services, controllers,
table providers, models або support classes.

## Manager Module

Manager module відповідає за дві речі:

- реєструє Evolution manager entry;
- безпечно рендерить workspace у manager runtime.

Module registration має задавати localized title, stable icon, module file path
і menu placement config, якщо package це підтримує.

Module file має блокувати direct access поза manager mode, читати request state
defensively, будувати малий context array, рендерити Blade або Livewire views і
виносити query/save/delete logic у controllers, services, models або EvoUI
providers.

## EvoUI Pattern

Використовуйте EvoUI для repeatable manager surfaces: tables, filters, row
actions, modals, confirmation dialogs, settings forms, choices fields і builder
fields.

| Surface | Рекомендований власник |
| --- | --- |
| Table columns, filters, actions, modal schema | `config/<area>/table.php` і `config/<area>/modal.php` |
| Rows, options, saves, deletes, custom actions | `src/Tables/*TableData.php` або focused provider class |
| Package settings form | `config/settings/form.php` |
| Runtime settings defaults | package config defaults |
| Project overrides | project custom config |

## Livewire Pattern

Livewire використовуйте, коли manager workspace потребує reactive state, tab
switching або partial updates без повного reload.

Typical Livewire manager panel має:

- accept raw tabs and context through `mount`;
- normalize active tab values against an allowlist;
- render namespaced package view;
- expose small public methods for UI actions;
- map active tabs to EvoUI presets or view fragments;
- keep query and persistence logic outside the component when possible.

Component координує UI, але не є domain service.

## Routes, Controllers І Facades

Package routes групуйте з package prefix і stable route name.

```php
Route::prefix('package-name')->name('packageName.')->group(function () {
    Route::post('action', [PackageController::class, 'action'])->name('action');
});
```

Controllers обробляють HTTP requests. Services або facades тримають operations,
які викликають templates, snippets, modules або інші packages. Public facade
methods описуйте у package reference; internal helpers не виносьте в public
docs.

## Config And Settings

Розділяйте три config layers:

| Layer | Призначення |
| --- | --- |
| Package defaults | Versioned defaults у package. |
| Project overrides | Editable project config поза vendor/package source. |
| Runtime values | Значення, які читаються helper/facade methods або Evolution config. |

Правила:

- defaults мають бути safe for fresh installation;
- кожен public config key має мати type, default і effect;
- не скануйте і не пишіть за межами expected project paths;
- destructive або externally visible behavior робіть opt-in;
- manager-editable settings краще відкривати через settings forms.

## Assets And Build Output

Package може постачати prebuilt assets, щоб runtime працював без Node.js.
Source files тримайте у `resources/`, built assets у `public/` або явній package
asset directory, а publish tags робіть package-specific.

Use package-specific publish tags:

- `package-config`;
- `package-assets`;
- `package-views`;
- `package-migrations`;
- `package-images`.

## Migrations, Seeders, And Commands

Migrations відповідають за package-owned tables. Seeders або install commands
мають бути idempotent, не дублювати records і не ставити demo data у production
без явної дії користувача.

## Localization

Використовуйте canonical locale folders.

| Призначення | Правило |
| --- | --- |
| Ukrainian documentation | Використовуйте `uk`. Не створюйте `docs/ua`. |
| Package UI translations | Використовуйте `lang/<locale>/`. |
| Manager labels | Беріть labels з translations, не hardcode. |
| Documentation status | Неповні локалі позначайте як partial. |

Legacy manager language values можуть нормалізуватись runtime code, але нова
package documentation не має публікувати `ua` як documentation locale.

## Package Documentation

Кожен package, видимий у dDocs, має постачати filesystem documentation.

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

`frontend-guide.md` потрібен тільки package, який має UI, Blade, JavaScript,
CSS, assets або browser runtime. Не створюйте placeholder frontend guide для
backend-only packages.

## Tests And Verification

Мінімум:

```console
composer validate
composer dump-autoload
find src config lang database -name "*.php" -print0 | xargs -0 -n1 php -l
php artisan package:discover
php artisan migrate --pretend
```

Для manager UI перевірте:

- module opens in manager;
- menu label and icon are localized;
- EvoUI tables/forms load;
- Livewire tabs switch without losing state;
- published assets are available;
- package docs appear in dDocs;
- internal Markdown links resolve.

## Release Checklist

Перед release перевірте:

- namespace і service provider правильні;
- Composer constraints відповідають підтримуваній Evolution CMS version;
- provider registration idempotent;
- migrations безпечні;
- publish tags package-specific;
- manager-only code guarded by manager mode;
- UI labels translated;
- public config keys documented;
- public facade/service methods documented;
- Ukrainian docs використовують `docs/uk`;
- `docs/ua` не публікується як новий standard;
- docs не містять local development paths;
- package-specific docs живуть у package, не в Evolution CMS product docs.
