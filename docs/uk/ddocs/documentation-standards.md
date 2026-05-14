# Стандарти документації

Цей документ є canonical standard для Evolution packages, які індексує dDocs.
Стандарт базується на Diataxis і організовує документацію навколо потреб
читача, а не навколо внутрішньої структури команди.

## Primary Documentation Types

Кожна сторінка має мати один primary type.

| Type | Reader need | Typical files |
| --- | --- | --- |
| Tutorial | Навчитись через guided path. | `tutorials/*.md` |
| How-to guide | Виконати конкретну задачу. | `user-guide.md`, task pages |
| Reference | Швидко знайти точні факти. | `configuration.md`, `reference.md` |
| Explanation | Зрозуміти concepts і boundaries. | `developer-guide.md`, architecture notes |

Не організовуйте package docs навколо назв команд типу frontend/backend, якщо
package реально не має такого surface.

## Required And Conditional Files

| File | Rule | Primary type | Audience |
| --- | --- | --- | --- |
| `docs/README.md` | Required. | Explanation | Everyone |
| `docs/<locale>/README.md` | Required для supported locales. | Explanation | Everyone |
| `docs/<locale>/user-guide.md` | Required, якщо package user-facing. | How-to guide | Manager users |
| `docs/<locale>/developer-guide.md` | Required, якщо package має runtime або integration logic. | Explanation | Developers and agents |
| `docs/<locale>/configuration.md` | Required, якщо package має settings/config. | Reference | Integrators |
| `docs/<locale>/reference.md` | Required, якщо є routes, events, APIs, services, CLI, permissions або formats. | Reference | Developers and agents |
| `docs/<locale>/frontend-guide.md` | Conditional. Тільки якщо package має UI, Blade, JS, CSS, assets, Livewire або browser runtime. | How-to або explanation | Frontend/theme developers |
| `docs/<locale>/backend-guide.md` | Conditional. Тільки якщо backend integration перевантажує `developer-guide.md`. | How-to або explanation | Backend developers |
| `docs/<locale>/troubleshooting.md` | Recommended для runtime packages. | How-to guide | Users and developers |
| `docs/contributing.md` | Recommended для shared packages. | How-to guide | Authors and agents |
| `docs/glossary.md` | Recommended, коли terms потребують stable definitions. | Reference | Everyone |
| `docs/docs.json` | Optional manifest for package docs inventory. | Reference | Tools and agents |

Якщо package не має frontend surface, не створюйте placeholder
`frontend-guide.md`. Опишіть boundary у `developer-guide.md`.

## Folder Layout

Використовуйте lowercase `docs/`.

```text
docs/
  README.md
  contributing.md
  glossary.md
  assets/
    images/
    diagrams/
  en/
    README.md
    user-guide.md
    developer-guide.md
    configuration.md
    reference.md
    troubleshooting.md
  uk/
    README.md
    user-guide.md
    developer-guide.md
    configuration.md
    reference.md
    troubleshooting.md
```

Нові `Docs/` не створюємо. dDocs може читати `Docs/` для legacy packages, але
нова документація має жити у `docs/`. Generated docsite переносимо в
`docs_old/`.

## Language Policy

English і Ukrainian - minimum release-quality locales для shared Extras
packages. Polish, German і French очікуються для user-facing shared manager
surfaces, але можуть бути `partial`, поки переклад не доведений до якості.

| Status | Meaning |
| --- | --- |
| `complete` | Reviewed, accurate, current. |
| `partial` | Main entrypoints існують, але не всі canonical pages перекладені. |
| `stub` | Є тільки navigation із поясненням, що перекладу немає. |
| `machine-draft` | Machine translated і ще не reviewed. |
| `needs-review` | Human text є, але потребує product/language review. |

`uk` - єдина Ukrainian documentation locale. Legacy Evolution manager input
`ua` нормалізується runtime-ом до `uk`; він не має бути docs folder, docs
manifest locale, language index entry або release checklist target.

## Package Metadata Contract

Кожен package, який показується в dDocs, має мати localized manager metadata у
`lang/<locale>/global.php`.

```php
return [
    'module_title' => 'Публікації',
    'module_description' => 'Керування публікаціями сайту з Evolution Manager.',
    'module_icon' => 'tabler-rss',
];
```

Rules:

- `module_title` - reader-facing назва package source у dDocs tree.
- `module_description` - короткий summary для source cards і tooling.
- `module_icon` - icon name package, бажано Tabler icon.
- Brand names можна не перекладати, якщо brand є реальною назвою продукту.
- Generic user-facing names треба локалізувати, наприклад `Publications` ->
  `Публікації`.
- dDocs читає current manager language, нормалізує legacy `ua` input до `uk` і
  fallback-иться до English.
- Якщо metadata відсутня, dDocs fallback-иться до Composer aliases або package
  names; це прийнятно тільки для legacy packages.

## Page Rules

- One H1 per page.
- Не пропускайте heading levels.
- Task headings мають починатися з дії, якщо це how-to.
- Concept/reference headings мають бути noun phrases.
- Goal читача має бути в першому paragraph.
- User guide не має містити architecture details.
- Developer guide не має дублювати user training.
- Reference data краще оформлювати таблицями.
- Paragraphs мають бути короткими і scannable.

## Link Rules

Використовуйте relative links.

```md
[Гайд користувача](user-guide.md)
[Reference](reference.md)
```

Не використовуйте local absolute paths.

```md
/Users/name/project/docs/file.md
```

Не лінкуйте generated HTML, якщо є Markdown source.

## Image And Diagram Rules

Screenshots і diagrams кладемо в `docs/assets/`.

```text
docs/assets/images/uk/settings-screen.png
docs/assets/diagrams/source-registry-flow.puml
```

Rules:

- Тільки актуальний manager UI.
- Meaningful alt text обов'язковий.
- Без personal data, tokens, private URLs або customer content.
- Screenshots оновлюються при visible workflow changes.
- Diagram source files треба зберігати, коли це можливо.
- Images мають лишатися всередині docs root.

## Code Block Rules

Кожен fenced code block має language.

```php
return [
    'module_icon' => 'tabler-book-2',
];
```

Для file trees і command output використовуйте `text`.

```text
docs/
  en/
  uk/
```

## Task Artifact Rules

Не змішуйте implementation task artifacts із public package documentation.
dIssues artifacts мають жити у configured artifact store, не в package
`docs/tasks/`.

`docs/tasks/` дозволений тільки для legacy material або explicit migration work
і прихований за замовчуванням через `show_internal_task_docs = 0`.

## Quality Gates

Documentation release-ready тільки коли проходять:

- Markdown lint.
- Broken internal link check.
- Broken external link check або explicit skip list.
- Code fence language check.
- Heading order check.
- One H1 per document.
- No absolute local filesystem paths.
- No generated static-site files inside `docs/`.
- No public task artifacts in package docs.
- Locale coverage report.
- Manual review against reader task.

Recommended tools:

```bash
npx markdownlint-cli2 "docs/**/*.md"
vale docs
lychee docs
```

Local fallback для dDocs:

```bash
php docs/checks/docs-check.php
```

## Definition Of Done

Package documentation done, якщо:

- `docs/README.md` пояснює, що читати першим.
- Кожна сторінка має одну audience і один primary documentation type.
- User guides описують реальні tasks.
- Developer guides документують routes, config, services, tests і boundaries.
- Config описаний із defaults, allowed values і safety notes.
- Frontend/backend guides існують тільки коли package має такий surface.
- Internal links і code fences проходять checks.
- Locales чесно позначені як complete, partial, stub, machine-draft або
  needs-review.
- Немає `docs/ua` folder і жоден docs manifest не вказує `ua` як locale.
- Glossary, asset, migration і manifest rules виконані, коли package потребує
  ці surfaces.
