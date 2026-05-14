# Створити Preset

[Extras Та Пакети](README.md) / Створити Preset

Presets - це ready-site scaffolds для Evolution CMS projects. Package додає
component до project; preset створює стартову форму самого project.

Використовуйте preset, коли треба повторювано створювати site baseline: views,
theme assets, controllers, starter config, required Extras і optional seeders,
які готують перший робочий сайт.

## Preset Чи Package

| Потреба | Використовуйте |
| --- | --- |
| Додати reusable manager module, editor, integration, parser element або service. | Package |
| Додати reusable frontend/backend capability у будь-який project. | Package |
| Почати новий project із відомим layout, theme, views, config і required Extras. | Preset |
| Створити blog starter, landing-page starter, shop starter або agency baseline. | Preset |

Preset може містити малий custom package для site-specific controllers, routes,
seeders або service provider wiring. Але preset все одно лишається project-layer
scaffold, а не component package.

## Встановити Preset

Presets застосовуються standalone installer під час створення project.

```console
evo install my-site \
  --branch=3.5.x \
  --preset=evolution-cms-presets/default-daisyui
```

Non-interactive install:

```console
evo install my-site \
  --cli \
  --branch=3.5.x \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-username=admin \
  --admin-email=admin@example.com \
  --admin-password=change-me \
  --admin-directory=manager \
  --language=uk \
  --preset=evolution-cms-presets/default-daisyui
```

Для preset development можна передати local preset reference:

```console
evo install preset-check \
  --branch=3.5.x \
  --preset=path/to/preset
```

## Preset Layout

Modern preset містить тільки project layer, який installer копіює у generated
site.

```text
preset-name/
  README.md
  LICENSE
  .gitignore
  robots.txt
  core/
    custom/
      composer.json
      config/
        cms/settings/ControllerNamespace.php
        presets/preset-name.php
      packages/
        preset-name/
          src/
            PresetNameServiceProvider.php
            composer.json
            Controllers/
            Http/
            Seeders/
  views/
    home.blade.php
    layouts/base.blade.php
    partials/
  themes/
    preset-name/
      css/
      js/
```

Не комітьте Evolution core, manager files, runtime cache, local databases,
local secrets або IDE workspace files у preset.

## Project Composer

`core/custom/composer.json` описує project-layer autoloading і required Composer
Extras.

```json
{
  "name": "evolution-cms-presets/example-project-layer",
  "type": "project",
  "require": {
    "evolution-cms/etinymce": "*"
  },
  "autoload": {
    "psr-4": {
      "EvolutionCMS\\ExamplePreset\\": "packages/example-preset/src/"
    }
  }
}
```

Required Extras додавайте тільки тоді, коли starter site без них не працює.
Optional Extras мають лишатися optional в installer.

## Custom Package Layer

Майже кожен preset має маленький custom package у `core/custom/packages`.

Використовуйте його для:

- service provider registration;
- frontend routes;
- controllers;
- starter seeders;
- tiny support classes для starter site.

Generic manager modules, reusable APIs, tables і integration logic мають жити в
окремих packages.

## Service Provider

Preset service provider має лишатися малим.

Рекомендовані responsibilities:

- include local route file only if it exists;
- load package/site views when preset uses a view namespace;
- register seeders or commands only when installer/project flow needs them;
- avoid side effects during every request.

```php
final class BlogPresetServiceProvider extends ServiceProvider
{
    protected $namespace = 'blog-preset';

    public function boot(): void
    {
        $routes = __DIR__ . '/Http/routes.php';
        if (is_file($routes)) {
            include $routes;
        }

        $this->loadViewsFrom(dirname(__DIR__) . '/views', 'blog-preset');
    }
}
```

## Views And Controllers

Views задають стартовий frontend:

- `views/layouts/base.blade.php`;
- `views/home.blade.php`;
- `views/partials/*`;
- site-type specific views, наприклад `blog.blade.php` або `contact.blade.php`.

Controllers мають лишатися близько до starter use case. Default preset зазвичай
потребує тільки `HomeController`. Blog preset може додати blog, post і contact
controllers, бо це частина site baseline.

## Theme Assets

Theme assets тримайте у `themes/<preset-name>/`. Preset має працювати одразу
після install. Якщо потрібен Node build, це має бути явно описано, але перша
сторінка не повинна залежати від ручного build.

DaisyUI presets можуть використовувати CDN-loaded DaisyUI/Tailwind browser
assets і small theme controller script для light/dark/theme switching. Custom
DaisyUI theme tokens тримайте у preset theme CSS file.

## Preset Config

Preset-specific settings тримайте у `core/custom/config/presets/<preset>.php`.
Там доречні theme defaults, visible theme lists, feature flags і starter route
defaults. Secrets у preset config не зберігайте.

## Seeders

Seeders використовуйте тільки для starter state:

- створити default site template;
- призначити template alias для starter Blade view;
- створити starter resources, якщо preset навмисно content-rich;
- робити operations idempotent.

Не додавайте великі demo records, які кожен реальний site мусить видаляти.

## README Contract

Кожен preset README має пояснювати:

- який site він стартує;
- які files включені;
- як встановити preset через installer;
- які required Extras оголошені;
- чи потрібен frontend build;
- де живуть views, theme assets, config і PHP site logic;
- який наступний project step після install.

## Validation

Перед release створіть fresh project із preset.

```console
evo install preset-check \
  --cli \
  --branch=3.5.x \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-username=admin \
  --admin-email=admin@example.com \
  --admin-password=change-me \
  --admin-directory=manager \
  --language=uk \
  --preset=evolution-cms-presets/preset-name
```

Після install перевірте:

- first page renders;
- manager login works;
- required Extras installed;
- Composer autoload resolves preset namespace;
- routes/controllers work;
- theme assets load;
- seeders do not duplicate data;
- generated project `.gitignore` не комітить core, manager, cache, databases,
  local secrets і IDE files.

## Release Checklist

Перед publishing перевірте:

- preset name is lowercase kebab-case;
- README describes site purpose and install flow;
- only project-layer files are committed;
- `core/custom/composer.json` has correct namespace and required Extras;
- custom package has small service provider;
- controllers/routes are site-specific;
- views render without manual post-install edits;
- theme assets are present;
- preset config contains no secrets;
- seeders are idempotent;
- installer can install from remote preset reference.
