# Reference

Ця сторінка містить швидкий lookup для runtime surfaces dDocs.

## Routes

| Method | Path | Name | Description |
| --- | --- | --- | --- |
| `GET` | `/ddocs/health` | `dDocs.health` | Повертає `{ "ok": true, "mode": "file-only" }`. |
| `GET` | `/ddocs/diagnostics` | `dDocs.diagnostics` | Повертає source/cache/language/path-safety metadata. Guarded by manager settings permission або debug mode. |
| `GET` | `/ddocs/export-markdown` | `dDocs.exportMarkdown` | Завантажує один generated Markdown file з readable documents у поточному index. Guarded by manager settings permission або debug mode. |
| `GET` | `/ddocs/plantuml` | `dDocs.plantuml` | Redirect encoded UML до configured renderer. |
| `GET` | `/dtui-plantuml` | `dDocs.plantuml.compat` | Compatibility route для dTui PlantUML rendering. |

## Supported Files

| Item | Supported |
| --- | --- |
| Markdown extensions | `md`, `mdx` by default. |
| Local image extensions | `png`, `jpg`, `jpeg`, `gif`, `webp` by default. |
| Maximum file size | `max_file_size_kb`, default `512`. |
| Legacy docs folder | `Docs/`, compatibility only. |
| Preferred docs folder | `docs/`. |
| Ukrainian docs folder | `uk` only. Legacy `ua` input is normalized to `uk`. |

## Config Reference

Configuration keys documented in [Configuration](configuration.md).

## Integration Signals

| Signal | Runtime surface |
| --- | --- |
| `dDocsAlias` | Package facade alias config для `dDocs` -> `Dmi3yy\dDocs\Facades\dDocs`. |
| `dmi3yy.settings.dDocs` | Project configuration root для manager settings form. |
| `settings.form` | Package settings form config file для editable manager settings. |
| `evo-ui.forms.ddocs.settings` | evo-ui settings form integration surface у manager settings workspace. |
| `ManagerText` | Locale-aware manager label helper для UI text і settings labels. |
| `MarkdownExport` | File-first exporter для settings action Download Markdown. |

## Source Metadata Reference

dDocs бере package source labels із `lang/<locale>/global.php`.

| Key | Meaning | Fallback |
| --- | --- | --- |
| `module_title` | Localized source name у dDocs tree. | Composer alias, canonical package name або package basename. |
| `module_description` | Короткий localized source description. | Composer description або dDocs fallback text. |
| `module_icon` | Source icon name, зазвичай `tabler-*` icon. | dDocs fallback icon або `tabler-package`. |

Legacy package-specific keys типу `docs`, `issues`, `articles`, `slang`,
`docs_icon` і `issues_icon` читаються тільки як compatibility aliases. Нові
packages мають використовувати `module_*` keys.

## Search Reference

Поточний пошук - filesystem live search поверх indexed nodes.

| Area | Current behavior |
| --- | --- |
| Search type | Live filter over `FileIndexCache` nodes. |
| Metadata fields | `title`, `relative_path`, `source_name`, `package_name`. |
| Content search | Тільки document nodes, через `FileDocumentRepository`. |
| Allowed extensions | Як `allowed_extensions`, default `md` і `mdx`. |
| File size limit | Як `max_file_size_kb`, default `512`. |
| Safe roots | Читає тільки indexed docs roots, які проходять path safety checks. |
| Result ordering | Без scoring, у tree order. |
| Parent folders | Додаються тільки як tree context для matched children. |
| Search cache | Поки немає. `FileIndexCache` - navigation metadata, не search index. |

Node metadata містить language і type, але current free-text query ще не має
окремих filters для цих полів.

## Document Node Metadata

| Field | Meaning |
| --- | --- |
| `id` | Stable hash із source key, language, type і relative path. |
| `source_key` | Source identifier from source registry. |
| `source_name` | Human-readable source label. |
| `source_type` | Source category such as package або project docs. |
| `title` | First H1 або filename-derived title. |
| `language` | Effective indexed language, наприклад `en`, `uk` або `neutral`. |
| `fallback_language` | Language used when requested language fell back. |
| `logical_path` | Path shown in breadcrumbs/tree. |
| `relative_path` | Markdown path relative to indexed docs root. |
| `absolute_path` | Normalized local filesystem path. |
| `docs_path` | Indexed docs root. |
| `mtime` | File або folder modification timestamp. |
| `checksum` | Document checksum для Markdown files. |
| `available_languages` | Available locale folders after normalization. |
| `readonly` | Whether manager UI write actions are blocked. |

## Markdown Features

| Feature | Status |
| --- | --- |
| Headings, lists, blockquotes, tables | Supported by dTui/TOAST UI. |
| Fenced code blocks | Supported with Prism highlighting. |
| Copy per code block | Supported. |
| Relative document links | Resolved to dDocs document actions. |
| Missing relative links | Kept inert. |
| Local images | Converted only inside safe docs roots. |
| External images | Rendered as external images. |
| Unsafe HTML | Sanitized or removed. |
| UML blocks | Supported through `$$uml` blocks. |

## UML Format

```text
$$uml
@startuml
Alice -> Bob: Hello
@enduml
$$
```

## Writable And Read-Only Roots

| Source | Writable | Notes |
| --- | --- | --- |
| Vendor package docs | No | Edit in package repository. |
| dDocs package docs | No in manager UI | Edit as package source. |
| Project Documentation | Yes | Stored in `ProjectDocs/`. |
| Configured project roots | Conditional | Must pass safe-root checks. |
