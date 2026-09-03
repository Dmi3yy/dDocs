# Developer Guide

This guide explains how dDocs is wired, how it discovers documentation, and how
developers should extend it safely.

## Canonical Package Names

Declare a locale-independent display name in the package's `composer.json`:

```json
{"name": "seiger/scommerce-api", "extra": {"ddocs": {"name": "sCommerceApi"}}}
```

`extra.ddocs.name` takes precedence over translated module titles, Laravel aliases,
and generated names. Empty or non-string values use the existing fallbacks.
Keep Composer's technical `name` lowercase. After changing metadata or adding
package documentation, refresh the dDocs index when index caching is enabled.

Set the card and tree icon with `extra.ddocs.icon`, for example
`"icon": "tabler-building-store"` for sCommerce. Use a name from the installed
Tabler set. It overrides translated icons; empty or invalid values keep the
existing fallbacks. SVG markup and file paths are not accepted in `icon`.

Tabler remains the default. A package can explicitly opt into its own icon with
`extra.ddocs.icon_svg`, e.g. `"icon_svg": "images/scommerce.svg"`. This package-relative
SVG path (up to 64 KiB) takes precedence over `icon`. Paths outside the package,
remote URLs and invalid files fall back to Tabler. The SVG is rendered as an image,
not inline markup, preserving its shape and colors. Other packages are unchanged
when `icon_svg` is absent.

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

The filesystem is the source of truth. dDocs does not use database tables for
package documentation.

## Services

| Service | Responsibility |
| --- | --- |
| `DocsSourceRegistry` | Finds package docs, project docs, configured roots, and source metadata. |
| `DocsIndexer` | Builds folder and document nodes with stable ids, language metadata, fallback branch merging, timestamps, and checksums. |
| `FileIndexCache` | Stores and refreshes the generated PHP metadata cache. |
| `FileDocumentRepository` | Reads selected Markdown files after safety checks. |
| `LanguageResolver` | Resolves manager language, normalizes legacy `ua` input to `uk`, returns ordered locale roots, and finds neutral docs. |
| `ManagerText` | Loads manager UI labels from `lang/<locale>/global.php` with fallback to English labels. |
| `LinkResolver` | Resolves internal links, local images, safe HTML, code languages, and UML image URLs. |
| `FileSearch` | Filters nodes by title, path, package name, and Markdown content. |
| `MarkdownExport` | Builds one downloadable Markdown file from readable documents in the current file index. |
| `Diagnostics` | Reports read-only source, cache, language, and path-safety state for manager/debug use. |

## Runtime Lookup

Keep exact lookup data out of this guide so the documentation stays
maintainable.

- Routes, supported Markdown features, UML behavior, and document node metadata
  live in [Reference](reference.md).
- Config keys, defaults, value types, and safety notes live in
  [Configuration](configuration.md).
- Frontend payload and viewer-breaking changes live in
  [Frontend Guide](frontend-guide.md).

Diagnostics include filesystem metadata, so diagnostic routes must stay behind
the manager/debug guard described in [Reference](reference.md).

## Search Runtime Model

dDocs currently uses filesystem live search: a live filter over the file index,
not a dedicated search engine, full-text index, or indexed search service.

`DocsIndexer` builds navigation metadata nodes. `FileIndexCache` stores those
nodes as generated PHP metadata so the tree can open quickly. That cache stores
titles, paths, source metadata, language metadata, timestamps, and checksums; it
does not store normalized document text, tokens, headings, snippets, or a search
posting list.

`ModulePanel` loads all nodes from `FileIndexCache` and passes them to
`FileSearch`. `FileSearch` first matches metadata fields such as title,
relative path, source name, and package name. When the node is a document and
metadata does not match, it reads the Markdown file through
`FileDocumentRepository` and checks the raw content.

Content search still respects the filesystem safety model. It only reads indexed
document nodes, allowed extensions, safe docs roots, and files below
`max_file_size_kb`.

When a document matches, `FileSearch` also returns its parent folders. Those
folders are UI context, not search matches. This keeps the tree readable while a
search is active.

Checksums currently belong to metadata and cache invalidation. They are not yet
used for search-index invalidation because no separate search index exists.

## Search Roadmap

Keep the search filesystem-first. The next step should be a generated
file-based `FileSearchIndexCache`, not a database table or external search
service.

Recommended roadmap:

1. Add `FileSearchIndexCache` as a generated PHP or JSON cache for searchable
   text.
2. Keep navigation index and search index as separate responsibilities.
3. Rebuild incrementally by checksum and mtime, so unchanged documents are not
   reread.
4. Store normalized searchable text, headings, tokens, and snippet source.
5. Add simple scoring: title above heading, heading above path, path above
   source/package, and source/package above body content.
6. Rank exact phrase matches above token matches, and token matches above prefix
   matches.
7. Add snippets so generic titles still show useful result context.
8. Highlight matches on the client after rendering, without changing Markdown
   source.
9. Add small query filters such as `source:ddocs`, `path:configuration`,
   `type:reference`, and `lang:uk`.
10. Add search modes: quick metadata search, full-text search, and current
    source search.

Avoid Elasticsearch, Meilisearch, Typesense, SQLite FTS, database-backed search
content, and vector search for the first release. They add infrastructure that
does not fit the current file-as-source-of-truth model.

## Source Discovery Contract

dDocs discovers docs from:

- the dDocs package itself;
- installed Composer packages that look like Evolution packages;
- package roots with `docs/`, legacy `Docs/`, `README.md`, or `index.md`;
- Project Documentation in `ProjectDocs/`;
- configured safe roots and extra docs roots.

New packages should expose lowercase `docs/`. Legacy `Docs/` is accepted for
compatibility only.

## Language Contract

dDocs resolves documentation roots in priority order for the manager user:

1. `default_language`, when configured.
2. Evolution manager language.
3. Legacy manager value `ua` normalized to documentation locale `uk`.
4. `language_fallback`, usually `en`.
5. Neutral docs such as `docs/pages`, `docs/README.md`, or `index.md`.

The tree is a merged logical view, not a raw list of locale folders. Localized
files win for the same relative path, and missing localized branches are filled
from the fallback locale. For example, if `docs/uk/ddocs` exists but
`docs/uk/evolution-cms` does not, dDocs keeps the Ukrainian `ddocs` branch and
fills `evolution-cms` from `docs/en/evolution-cms`.

The tree should not show every locale at once or expose fallback branches as a
separate language root.

Documentation locale folders must use `uk` for Ukrainian content. A legacy
`docs/ua` folder may be read only as a migration alias and is exposed as `uk` in
the index.

## Extension Points

| Surface | Status | Rule |
| --- | --- | --- |
| Source discovery | Internal service | Add package roots through `DocsSourceRegistry`, not by bypassing safe roots. |
| Renderer post-processing | Internal frontend runtime | Preserve viewer payload shape, link maps, image maps, UML maps, and code-copy behavior. |
| Safe roots | Project configuration | Add trusted roots through settings, not package defaults. |
| Manager labels | Internal helper | Use `ManagerText` for module labels and settings labels. |
| Diagnostics | Guarded manager/debug route | Keep filesystem metadata behind the diagnostics guard. |
| Search indexing | Internal service | Keep file-size limits and safe reads intact. |

## Path Safety

All file reads and writes must use normalized paths and safe-root checks. A raw
path from a request must never be trusted.

Writable actions are limited to Project Documentation. Vendor package docs are
indexed and rendered but not written by the manager UI.

## Cache Behavior

When `cache_index` is enabled, dDocs writes a generated PHP file that contains
metadata only. It stores source nodes, folder nodes, document paths, language
metadata, timestamps, and checksums. It does not store canonical Markdown in the
database.

Refresh the index after manual package-doc changes, root configuration changes,
or language structure changes.

## Frontend Boundary

dDocs has a real frontend surface: Blade shell, Livewire DOM, dTui/TOAST UI
viewer, Prism, and browser post-processing. Keep documentation-specific
tree/viewer behavior local to dDocs until another package needs the same
primitive. Promote shared primitives through evo-ui instead of copying them.

## Verification Commands

Run these checks before release:

```bash
find . -path './vendor' -prune -o -name '*.php' -print0 | xargs -0 -n1 php -l
composer validate --no-check-publish
```

Run dDocs documentation checks:

```bash
php docs/checks/docs-check.php
```

Run the demo runtime smoke from the installed manager demo when available.
