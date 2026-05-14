# Reference

This reference lists the dDocs runtime surfaces that developers and agents need
to look up quickly.

## Routes

| Method | Path | Name | Description |
| --- | --- | --- | --- |
| `GET` | `/ddocs/health` | `dDocs.health` | Returns `{ "ok": true, "mode": "file-only" }`. |
| `GET` | `/ddocs/diagnostics` | `dDocs.diagnostics` | Returns source, cache, language, and path-safety metadata. Guarded by manager settings permission or debug mode. |
| `GET` | `/ddocs/export-markdown` | `dDocs.exportMarkdown` | Downloads one generated Markdown file from readable documents in the current index. Guarded by manager settings permission or debug mode. |
| `GET` | `/ddocs/plantuml` | `dDocs.plantuml` | Redirects encoded PlantUML to the configured renderer. |
| `GET` | `/dtui-plantuml` | `dDocs.plantuml.compat` | Compatibility route for dTui PlantUML rendering. |

## Supported Document Files

| Item | Supported |
| --- | --- |
| Markdown extensions | `md`, `mdx` by default. |
| Local image extensions | `png`, `jpg`, `jpeg`, `gif`, `webp` by default. |
| Maximum file size | `max_file_size_kb`, default `512`. |
| Legacy docs folder | `Docs/`, read for compatibility only. |
| Preferred docs folder | `docs/`. |
| Ukrainian docs folder | `uk` only. Legacy `ua` input is normalized to `uk`. |

## Config Reference

Configuration keys are documented in [Configuration](configuration.md).

## Integration Signals

| Signal | Runtime surface |
| --- | --- |
| `dDocsAlias` | Package facade alias config that maps `dDocs` to `Dmi3yy\dDocs\Facades\dDocs`. |
| `dmi3yy.settings.dDocs` | Project configuration root used by the manager settings form. |
| `settings.form` | Package settings form config file that declares editable manager settings. |
| `evo-ui.forms.ddocs.settings` | evo-ui settings form integration surface used by the manager settings workspace. |
| `ManagerText` | Locale-aware manager label helper for UI text and settings labels. |
| `MarkdownExport` | File-first exporter used by the settings Download Markdown action. |

## Source Metadata Reference

dDocs resolves package source labels from `lang/<locale>/global.php`.

| Key | Meaning | Fallback |
| --- | --- | --- |
| `module_title` | Localized source name shown in the dDocs tree. | Composer alias, canonical package name, package basename. |
| `module_description` | Short localized source description. | Composer description or dDocs package fallback text. |
| `module_icon` | Source icon name, usually a `tabler-*` icon. | dDocs package fallback icon or `tabler-package`. |

Legacy package-specific keys such as `docs`, `issues`, `articles`,
`slang`, `docs_icon`, and `issues_icon` are read only as compatibility aliases.
New packages should use the `module_*` keys.

## Search Reference

Current search is filesystem live search over indexed nodes.

| Area | Current behavior |
| --- | --- |
| Search type | Live filter over `FileIndexCache` nodes. |
| Metadata fields | `title`, `relative_path`, `source_name`, `package_name`. |
| Content search | Document nodes only, read through `FileDocumentRepository`. |
| Allowed extensions | Same as `allowed_extensions`, `md` and `mdx` by default. |
| File size limit | Same as `max_file_size_kb`, default `512`. |
| Safe roots | Reads only indexed docs roots that pass path safety checks. |
| Result ordering | Unscored tree order. |
| Parent folders | Included only to restore tree context for matching children. |
| Search cache | None yet. `FileIndexCache` is navigation metadata, not a search index. |

Node metadata includes language and type, but the current free-text query does
not treat them as dedicated filters. Use the roadmap in
[Developer Guide](developer-guide.md) before documenting query syntax as a
runtime feature.

## Document Node Metadata

| Field | Meaning |
| --- | --- |
| `id` | Stable hash built from source key, language, type, and relative path. |
| `source_key` | Source identifier from the source registry. |
| `source_name` | Human-readable source label. |
| `source_type` | Source category such as package or project docs. |
| `title` | First H1 or filename-derived title. |
| `language` | Effective indexed language, such as `en`, `uk`, or `neutral`. |
| `fallback_language` | Language used when the requested language fell back. |
| `logical_path` | Path shown in breadcrumbs/tree. |
| `relative_path` | Markdown path relative to the indexed docs root. |
| `absolute_path` | Normalized local filesystem path. |
| `docs_path` | Indexed docs root. |
| `mtime` | File or folder modification timestamp. |
| `checksum` | Document checksum for Markdown files. |
| `available_languages` | Available locale folders after normalization. |
| `readonly` | Whether manager UI write actions are blocked. |

When a localized tree is partial, nodes can have different indexed languages
inside the same source tree. The relative path is the merge key: the first
localized file wins, and later fallback roots only add missing relative paths.

## Markdown Features

| Feature | Status |
| --- | --- |
| Headings, lists, blockquotes, tables | Supported by dTui/TOAST UI. |
| Fenced code blocks | Supported, with Prism highlighting when language is known. |
| Copy per code block | Supported in the viewer. |
| Relative document links | Resolved to dDocs document actions when indexed. |
| Missing relative links | Kept inert. |
| Local images | Converted only when inside safe docs roots. |
| External images | Rendered as external images. |
| Raw unsafe HTML | Sanitized or removed by viewer post-processing. |
| UML blocks | Supported through `$$uml` blocks and PlantUML route. |

## Prism Language Aliases

Common aliases include:

```text
php
blade
javascript
typescript
json
yaml
bash
sql
markdown
markup
css
scss
uml
plantuml
```

## UML Format

Use a custom UML block:

```text
$$uml
@startuml
Alice -> Bob: Hello
@enduml
$$
```

dDocs normalizes the source, encodes it with PlantUML encoding, and uses the
configured dTui renderer URL.

## Writable And Read-Only Roots

| Source | Writable | Notes |
| --- | --- | --- |
| Vendor package docs | No | Edit in the package repository. |
| dDocs package docs | No in manager UI | Edit as package source. |
| Project Documentation | Yes | Stored in `ProjectDocs/`. |
| Configured project roots | Yes only when not vendor and inside safe roots | Must pass path checks. |

## Cache File

The cache file is a generated PHP return file with:

```php
return [
    'generated_at' => '2026-05-13T00:00:00+00:00',
    'language' => 'en',
    'nodes' => [],
];
```

It is metadata only. Markdown content stays in source files.
