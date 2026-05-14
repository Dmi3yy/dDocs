# Гайд розробника

Цей гайд пояснює, як dDocs підключений, як він знаходить документацію і як його
безпечно розширювати.

## Runtime Model

```text
DocsSourceRegistry -> DocsIndexer -> FileIndexCache
                                  -> FileDocumentRepository
ModulePanel        -> raw Markdown payload
Browser viewer     -> dTui/TOAST UI + Prism
LinkResolver       -> link, image, and UML maps
DocumentPath       -> path safety checks
FileSearch         -> title, path, source, and content search
```

Filesystem є source of truth. dDocs не використовує database tables для package
documentation.

## Services

| Service | Responsibility |
| --- | --- |
| `DocsSourceRegistry` | Знаходить package docs, project docs, configured roots і source metadata. |
| `DocsIndexer` | Будує folder/document nodes зі stable ids, language metadata, timestamps і checksums. |
| `FileIndexCache` | Зберігає і оновлює generated PHP metadata cache. |
| `FileDocumentRepository` | Читає selected Markdown files після safety checks. |
| `LanguageResolver` | Визначає manager language, нормалізує legacy `ua` input до `uk`, застосовує fallback і знаходить neutral docs. |
| `ManagerText` | Завантажує manager UI labels із `lang/<locale>/global.php` із fallback to English labels. |
| `LinkResolver` | Обробляє internal links, local images, safe HTML, code languages і UML image URLs. |
| `FileSearch` | Фільтрує nodes за title, path, package name і Markdown content. |
| `MarkdownExport` | Збирає один downloadable Markdown file з readable documents у поточному file index. |
| `Diagnostics` | Повертає read-only source/cache/language/path-safety state для manager/debug. |

## Runtime Lookup

Точні lookup-таблиці живуть на reference-сторінках, щоб цей guide не дублював
довідник:

- routes, Markdown features, UML behavior і document node metadata:
  [Reference](reference.md);
- config keys, defaults, value types і safety notes:
  [Configuration](configuration.md);
- frontend payload і viewer-breaking changes:
  [Frontend Guide](frontend-guide.md).

Diagnostics містить filesystem metadata, тому diagnostic routes мають лишатися
за manager/debug guard.

## Search Runtime Model

dDocs зараз використовує filesystem live search: live filter поверх file index,
а не окремий search engine, full-text index або indexed search service.

`DocsIndexer` будує navigation metadata nodes. `FileIndexCache` зберігає ці
nodes як generated PHP metadata, щоб дерево відкривалось швидко. Cache містить
title, path, source metadata, language metadata, timestamps і checksums; він не
зберігає normalized document text, tokens, headings, snippets або search posting
list.

`ModulePanel` бере всі nodes із `FileIndexCache` і передає їх у `FileSearch`.
`FileSearch` спочатку match-ить metadata fields: title, relative path, source
name і package name. Якщо node є document і metadata не збіглась, search читає
Markdown через `FileDocumentRepository` і перевіряє raw content.

Content search не обходить safety model. Він читає тільки indexed document
nodes, allowed extensions, safe docs roots і файли нижче `max_file_size_kb`.

Коли document match-иться, `FileSearch` також повертає parent folders. Ці folders
є UI context, а не search matches. Так дерево лишається зрозумілим під час
пошуку.

Checksums зараз належать metadata/cache invalidation. Вони ще не є
search-index invalidation, бо окремого search index немає.

## Search Roadmap

Пошук має лишатися filesystem-first. Наступний крок - generated file-based
`FileSearchIndexCache`, не database table і не external search service.

Рекомендований roadmap:

1. Додати `FileSearchIndexCache` як generated PHP або JSON cache для searchable
   text.
2. Тримати navigation index і search index як різні responsibilities.
3. Робити incremental rebuild по checksum і mtime.
4. Зберігати normalized searchable text, headings, tokens і snippet source.
5. Додати scoring: title вище heading, heading вище path, path вище
   source/package, source/package вище body content.
6. Exact phrase має бути вище token match, token match вище prefix match.
7. Додати snippets для контексту результатів.
8. Робити highlight на client side після render, не змінюючи Markdown source.
9. Додати прості filters: `source:ddocs`, `path:configuration`,
   `type:reference`, `lang:uk`.
10. Додати search modes: quick metadata search, full-text search і current
    source search.

Не додавайте Elasticsearch, Meilisearch, Typesense, SQLite FTS, database-backed
search content або vector search для першого релізу. Це зайва інфраструктура
для поточної моделі file-as-source-of-truth.

## Source Discovery Contract

dDocs знаходить docs із:

- самого package dDocs;
- installed Composer packages, які схожі на Evolution packages;
- package roots із `docs/`, legacy `Docs/`, `README.md` або `index.md`;
- Project Documentation у `ProjectDocs/`;
- configured safe roots і extra docs roots.

Нові пакети мають використовувати lowercase `docs/`. Legacy `Docs/` лишається
тільки для compatibility.

## Language Contract

dDocs вибирає одне effective language tree:

1. `default_language`, якщо заданий.
2. Evolution manager language.
3. Legacy manager value `ua` нормалізується до documentation locale `uk`.
4. `language_fallback`, зазвичай `en`.
5. Neutral docs: `docs/pages`, `docs/README.md` або `index.md`.

Tree не має показувати всі локалі одночасно. Documentation locale folders мають
використовувати `uk` для українського контенту. Legacy `docs/ua` може читатись
тільки як migration alias і в індексі показується як `uk`.

## Extension Points

| Surface | Status | Rule |
| --- | --- | --- |
| Source discovery | Internal service | Додавайте package roots через `DocsSourceRegistry`, не обходячи safe roots. |
| Renderer post-processing | Internal frontend runtime | Зберігайте viewer payload shape, link maps, image maps, UML maps і code-copy behavior. |
| Safe roots | Project configuration | Додавайте trusted roots через settings, не через package defaults. |
| Manager labels | Internal helper | Використовуйте `ManagerText` для module labels і settings labels. |
| Diagnostics | Guarded manager/debug route | Не відкривайте filesystem metadata без diagnostics guard. |
| Search indexing | Internal service | Не прибирайте file-size limits і safe reads. |

## Path Safety

Усі reads/writes мають проходити через normalized paths і safe-root checks. Raw
path із request не можна trust.

Writable actions обмежені Project Documentation. Vendor docs індексуються і
рендеряться, але manager UI їх не записує.

## Cache Behavior

Коли `cache_index` enabled, dDocs пише generated PHP file тільки з metadata:
source nodes, folder nodes, document paths, language metadata, timestamps і
checksums. Canonical Markdown лишається у source files.

Оновлюйте індекс після ручних змін package docs, змін root configuration або
language structure.

## Frontend Boundary

dDocs має реальний frontend surface: Blade shell, Livewire DOM, dTui/TOAST UI
viewer, Prism і browser post-processing. Documentation-specific tree/viewer
behavior тримаємо локально в dDocs, поки ще один package не потребує такого
primitive. Shared primitive треба переносити через evo-ui.

## Verification Commands

```bash
find . -path './vendor' -prune -o -name '*.php' -print0 | xargs -0 -n1 php -l
composer validate --no-check-publish
php docs/checks/docs-check.php
```
