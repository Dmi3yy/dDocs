# Create A Preset

[Extras And Packages](README.md) / Create A Preset

Presets are ready-site scaffolds for Evolution CMS projects. A package adds a
component to a project; a preset creates the starting shape of the project
itself.

Use a preset when you want to ship a repeatable site baseline: views, theme
assets, controllers, starter config, required Extras, and optional seeders that
prepare the first usable site.

## Preset Or Package

| Need | Use |
| --- | --- |
| Add a reusable manager module, editor, integration, parser element, or service. | Package |
| Add a reusable frontend or backend capability to any project. | Package |
| Start a new project with a known layout, theme, views, config, and required Extras. | Preset |
| Create a blog starter, landing-page starter, shop starter, intranet starter, or agency baseline. | Preset |

A preset may contain a small custom package for site-specific controllers,
routes, seeders, or service provider wiring. That does not make the preset a
component package. The preset is still the project-layer scaffold.

## Install A Preset

Presets are applied by the standalone installer during project creation.

Interactive install:

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

Use a local preset checkout while developing a preset:

```console
evo install preset-check \
  --branch=3.5.x \
  --preset=path/to/preset
```

Use a branch or tag when the installer supports remote preset references:

```console
evo install my-site \
  --branch=3.5.x \
  --preset=evolution-cms-presets/blog-daisyui@dev
```

## Preset Layout

A modern preset should contain only the project layer that the installer copies
into the generated site.

```text
preset-name/
  README.md
  LICENSE
  .gitignore
  robots.txt
  core/
    custom/
      .gitignore
      composer.json
      config/
        cms/
          settings/
            ControllerNamespace.php
        presets/
          preset-name.php
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
    layouts/
      base.blade.php
    partials/
  themes/
    preset-name/
      css/
      js/
```

Do not commit Evolution core, manager files, runtime cache, local databases,
local secrets, or IDE workspace files into a preset.

## Project Composer

`core/custom/composer.json` describes the project-layer autoloading and required
Composer Extras.

Minimal preset:

```json
{
  "name": "evolution-cms-presets/example-project-layer",
  "type": "project",
  "autoload": {
    "psr-4": {
      "EvolutionCMS\\ExamplePreset\\": "packages/example-preset/src/"
    }
  }
}
```

Preset with required Extras:

```json
{
  "name": "evolution-cms-presets/blog-project-layer",
  "type": "project",
  "require": {
    "evolution-cms/etinymce": "*",
    "seiger/sseo": "*"
  },
  "autoload": {
    "psr-4": {
      "EvolutionCMS\\BlogPreset\\": "packages/blog-preset/src/"
    }
  }
}
```

Required Extras should be reserved for functionality the starter site cannot
work without. Optional Extras should stay optional in the installer.

## Custom Package Layer

Most presets include a small custom package inside `core/custom/packages`. Use
it for site-layer PHP, not reusable package features.

Typical responsibilities:

- service provider registration;
- frontend routes;
- controllers;
- seeders for templates or starter resources;
- view namespace registration when needed;
- tiny support classes for the starter site.

Keep manager modules, reusable tables, public package APIs, and generic
integration logic in real packages instead.

## Service Provider

The preset service provider should stay small.

Recommended responsibilities:

- include a local route file only if it exists;
- load package/site views if the preset uses a view namespace;
- register seeders or commands only when the installer or project flow needs
  them;
- avoid side effects during every request.

Example shape:

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

Preset views define the starting frontend:

- `views/layouts/base.blade.php` for the base layout;
- `views/home.blade.php` for the first homepage;
- `views/partials/*` for starter header, footer, forms, and repeated pieces;
- additional views such as `blog.blade.php`, `post.blade.php`, or
  `contact.blade.php` only when the preset is intentionally site-type specific.

Controllers should stay close to the starter use case. A default preset normally
needs only `HomeController`. A blog preset can add blog, post, and contact
controllers because those are part of the site baseline.

## Theme Assets

Theme assets belong under `themes/<preset-name>/`.

Recommended structure:

```text
themes/
  preset-name/
    css/
      app.css
      themes.css
    js/
      theme.js
```

Presets should work immediately after install. If a preset depends on a Node
build, document the build step clearly and do not require it for the first page
to render.

DaisyUI presets can use CDN-loaded DaisyUI/Tailwind browser assets and a small
theme controller script for light/dark/theme switching. Custom DaisyUI theme
tokens belong in a preset theme CSS file.

## Preset Config

Preset-specific settings belong in `core/custom/config/presets/<preset>.php`.

Use config for starter-site behavior that project owners are expected to edit:

- theme enablement;
- light/dark defaults;
- visible theme lists;
- localStorage key names;
- starter feature flags;
- route or page defaults.

Keep secrets out of preset config. Secrets belong in environment files or
project-specific deployment configuration.

## Seeders

Use seeders only for starter state that the site needs after install.

Good seeder use:

- create the default site template;
- assign a template alias that maps to the starter Blade view;
- create starter resources only when the preset is intentionally content-rich;
- keep operations idempotent.

Avoid:

- large demo content that every real site must delete;
- package-specific seed data that belongs to an installed Extra;
- irreversible database writes during normal requests.

## README Contract

Every preset should ship a README that explains:

- what kind of site the preset starts;
- what files are included;
- how to install it with the installer;
- whether required Extras are declared;
- whether frontend assets need a build step;
- where views, theme assets, config, and PHP site logic live;
- what the next project step should be after install.

## Validation

Before release, create a fresh project from the preset.

Minimum checks:

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

Then verify:

- first page renders;
- manager login works;
- required Extras are installed;
- Composer autoload resolves the preset namespace;
- routes and controllers work;
- theme assets load;
- seeders do not duplicate data when rerun;
- generated project `.gitignore` keeps core, manager, cache, databases, local
  secrets, and IDE files out of the project repository.

## Release Checklist

Before publishing a preset, confirm:

- preset name is lowercase kebab-case;
- README describes the site purpose and install flow;
- project-layer files only are committed;
- `core/custom/composer.json` has the correct namespace and required Extras;
- preset custom package has a small service provider;
- controllers and routes are site-specific, not generic package logic;
- views render without manual post-install edits;
- theme assets are present and referenced through the preset theme path;
- preset config is editable and contains no secrets;
- seeders are idempotent;
- installer can install from the remote preset reference;
- installed project can be committed as its own site repository.
