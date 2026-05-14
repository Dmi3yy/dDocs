# Documentation Standards

This document is the canonical documentation standard for Evolution packages
indexed by dDocs. It uses Diataxis as the information architecture model and
keeps package documentation focused on reader needs.

## Primary Documentation Types

Every page must have one primary type.

| Type | Reader need | Typical files |
| --- | --- | --- |
| Tutorial | Learn by following a guided path. | `tutorials/*.md` |
| How-to guide | Complete a task. | `user-guide.md`, task pages |
| Reference | Look up exact facts. | `configuration.md`, `reference.md` |
| Explanation | Understand concepts and boundaries. | `developer-guide.md`, architecture notes |

Do not organize package docs around internal team names such as frontend or
backend unless the package really exposes that surface.

## Required And Conditional Files

| File | Rule | Primary type | Audience |
| --- | --- | --- | --- |
| `docs/README.md` | Required. | Explanation | Everyone |
| `docs/<locale>/README.md` | Required for supported locales. | Explanation | Everyone |
| `docs/<locale>/user-guide.md` | Required when the package is user-facing. | How-to guide | Manager users |
| `docs/<locale>/developer-guide.md` | Required when the package has runtime or integration logic. | Explanation | Developers and agents |
| `docs/<locale>/configuration.md` | Required when the package has settings or config. | Reference | Integrators |
| `docs/<locale>/reference.md` | Required when routes, events, APIs, services, CLI commands, permissions, or formats need lookup. | Reference | Developers and agents |
| `docs/<locale>/frontend-guide.md` | Conditional. Use only when the package exposes UI, Blade, JS, CSS, assets, Livewire, or browser runtime. | How-to or explanation | Frontend/theme developers |
| `docs/<locale>/backend-guide.md` | Conditional. Use only when backend integration is large enough to overload `developer-guide.md`. | How-to or explanation | Backend developers |
| `docs/<locale>/troubleshooting.md` | Recommended for runtime packages. | How-to guide | Users and developers |
| `docs/contributing.md` | Recommended for shared packages. | How-to guide | Authors and agents |
| `docs/glossary.md` | Recommended when terms need stable definitions. | Reference | Everyone |
| `docs/docs.json` | Optional manifest for package docs inventory. | Reference | Tools and agents |

If a package has no frontend surface, do not create a placeholder
`frontend-guide.md`. State the boundary in `developer-guide.md` instead.

## Folder Layout

Use lowercase `docs/`.

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

Do not create new `Docs/` folders. dDocs may read `Docs/` for legacy packages,
but new work must use `docs/`. Move old generated documentation sites to
`docs_old/`.

## Language Policy

English and Ukrainian are the minimum release-quality locales for shared Extras
packages. Polish, German, and French are expected for user-facing shared manager
surfaces, but they may be marked as partial while translation quality is still
being improved.

| Status | Meaning |
| --- | --- |
| `complete` | Reviewed, accurate, and current. |
| `partial` | Main entrypoints exist, but not every canonical page is translated. |
| `stub` | Navigation exists only to explain that translation is missing. |
| `machine-draft` | Machine translated and not yet reviewed. |
| `needs-review` | Human text exists but needs product or language review. |

Use `uk` as the only Ukrainian documentation locale. Legacy Evolution manager
input `ua` is normalized internally to `uk`; it must not appear as a docs
folder, docs manifest locale, language index entry, or release checklist target.

## Package Metadata Contract

Every package shown in dDocs must expose localized manager metadata in
`lang/<locale>/global.php`.

```php
return [
    'module_title' => 'Publications',
    'module_description' => 'Manage site publications from Evolution Manager.',
    'module_icon' => 'tabler-rss',
];
```

Rules:

- `module_title` is the reader-facing package source name in the dDocs tree.
- `module_description` is a short package summary for source cards and tools.
- `module_icon` is the package icon name, preferably a Tabler icon.
- Brand names may stay untranslated when the brand is the actual product name.
- User-facing generic names should be localized, for example `Publications` to
  `Публікації` in Ukrainian.
- dDocs reads the current manager language, normalizes legacy `ua` input to
  `uk`, and falls back to English.
- If metadata is missing, dDocs falls back to Composer aliases or package names;
  that fallback is acceptable for legacy packages only.

## Page Rules

- Use one H1 per page.
- Do not skip heading levels.
- Task headings should start with an action verb when the page is a how-to.
- Concept and reference headings should use noun phrases.
- Put the reader's goal in the first paragraph.
- Keep user guides free of architecture details.
- Keep developer guides free of step-by-step user training.
- Prefer tables for reference data.
- Use short paragraphs and scannable lists.

## Link Rules

Use relative links inside package docs.

```md
[User Guide](user-guide.md)
[Reference](reference.md)
```

Do not use local absolute paths.

```md
/Users/name/project/docs/file.md
```

Do not link to generated HTML files when a Markdown source exists.

## Image And Diagram Rules

Put screenshots and diagrams inside `docs/assets/`.

```text
docs/assets/images/en/settings-screen.png
docs/assets/diagrams/source-registry-flow.puml
```

Rules:

- Use current manager UI screenshots only.
- Add meaningful alt text.
- Do not include personal data, tokens, private URLs, or customer content.
- Update screenshots when a visible workflow changes.
- Keep diagram source files when possible.
- Keep images inside the docs root; dDocs blocks paths that escape safe roots.

## Code Block Rules

Always set the fence language.

```php
return [
    'module_icon' => 'tabler-book-2',
];
```

Use `text` for file trees and command output.

```text
docs/
  en/
  uk/
```

## Task Artifact Rules

Do not mix implementation task artifacts with public package documentation.
dIssues task artifacts belong in the configured dIssues artifact store, not in
package `docs/tasks/`.

`docs/tasks/` is allowed only for legacy material or explicit migration work and
is hidden by default through `show_internal_task_docs = 0`.

## Quality Gates

Documentation is release-ready only when these checks pass:

- Markdown lint.
- Broken internal link check.
- Broken external link check or explicit skip list.
- Code fence language check.
- Heading order check.
- One H1 per document.
- No absolute local filesystem paths.
- No generated static-site files inside `docs/`.
- No public task artifacts in package docs.
- Locale coverage report.
- Extras documentation coverage report for shared package releases.
- EvoUI documentation coverage report when the package defines or depends on
  shared EvoUI primitives.
- EvoUI consumer conformance report when the package owns a manager UI surface.
- Manual review against the reader's task.

Recommended tools:

```bash
npx markdownlint-cli2 "docs/**/*.md"
vale docs
lychee docs
```

Release-gate helpers:

```bash
php path/to/extras-doc-coverage.php --extras=path/to/extras --modules=dDocs --format=md --output=path/to/ddocs-doc-coverage.md
php path/to/evo-ui-doc-coverage.php --evo-ui=path/to/evo-ui --format=md --output=path/to/evo-ui-doc-coverage.md
php path/to/evo-ui-consumer-conformance.php --extras=path/to/extras --modules=dDocs --format=md --output=path/to/evo-ui-consumer-conformance.md
```

For dDocs release readiness, `extras-doc-coverage` should report `100%`
structure and signal coverage. EvoUI conformance may include the documented
dDocs tree/viewer exception, but it must not report unscoped global evo-ui
primitive overrides.

Packages may also provide local PHP checks when Node or external link tools are
not available.

## Definition Of Done

A package documentation set is done when:

- `docs/README.md` explains what to read first.
- Each page has one audience and one primary documentation type.
- User guides describe real tasks.
- Developer guides document routes, config, services, tests, and boundaries.
- Config is described with defaults, allowed values, and safety notes.
- Frontend or backend guides exist only when the package has that surface.
- Internal links and code fences pass checks.
- Locales are marked honestly as complete, partial, stub, machine-draft, or
  needs-review.
- No `docs/ua` folder exists and no docs manifest lists `ua` as a locale.
- Glossary, asset, migration, and manifest rules are followed when the package
  needs those surfaces.
