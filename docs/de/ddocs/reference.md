# Reference

## Routes

| Method | Path | Name | Description |
| --- | --- | --- | --- |
| `GET` | `/ddocs/health` | `dDocs.health` | Minimaler health response. |
| `GET` | `/ddocs/diagnostics` | `dDocs.diagnostics` | Guarded diagnostics. |
| `GET` | `/ddocs/plantuml` | `dDocs.plantuml` | Redirect encoded UML. |
| `GET` | `/dtui-plantuml` | `dDocs.plantuml.compat` | Compatibility route. |

## Supported Files

| Item | Supported |
| --- | --- |
| Markdown extensions | `md`, `mdx`. |
| Preferred docs folder | `docs/`. |
| Legacy docs folder | `Docs/`, compatibility only. |
| Ukrainian docs folder | `uk` only. |

## Search Reference

Current search is filesystem live search over indexed nodes.

| Area | Current behavior |
| --- | --- |
| Search type | Live filter over `FileIndexCache` nodes. |
| Metadata fields | `title`, `relative_path`, `source_name`, `package_name`. |
| Content search | Document nodes only, read through `FileDocumentRepository`. |
| Allowed extensions | Same as `allowed_extensions`. |
| File size limit | Same as `max_file_size_kb`, default `512`. |
| Safe roots | Reads only indexed docs roots that pass path safety checks. |
| Result ordering | Unscored tree order. |
| Parent folders | Included only as tree context for matching children. |
| Search cache | None yet; `FileIndexCache` is navigation metadata. |

## Document Node Metadata

| Field | Meaning |
| --- | --- |
| `id` | Stable hash. |
| `source_key` | Source identifier. |
| `title` | First H1 oder filename title. |
| `language` | Effective indexed language. |
| `relative_path` | Path relative to docs root. |
| `readonly` | Whether manager write actions are blocked. |
