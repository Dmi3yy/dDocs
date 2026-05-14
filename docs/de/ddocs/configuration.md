# Konfiguration

Project config:

```text
custom/config/dmi3yy/settings/dDocs.php
```

Package defaults:

```text
config/dDocsSettings.php
```

## Einstellungen

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `enabled` | boolean-like `0`/`1` | `1` | Aktiviert das Modul. |
| `language_fallback` | locale string | `en` | Fallback-Sprache. |
| `default_language` | locale string oder empty | empty | Erzwingt eine Sprache. Legacy `ua` wird zu `uk` normalisiert. |
| `allowed_extensions` | CSV string | `md,mdx` | Indizierte Markdown extensions. |
| `max_file_size_kb` | integer | `512` | Maximale Markdown file size. |

## Quellen

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `scan_vendor_packages` | boolean-like `0`/`1` | `1` | Sucht docs in installierten packages. |
| `scan_project_docs` | boolean-like `0`/`1` | `1` | Sucht configured project docs roots. |
| `safe_roots` | multiline paths | empty | Trusted filesystem roots. |
| `extra_docs_roots` | multiline paths | empty | Zusätzliche docs roots. |

## Search Behavior

Search behavior ist aktuell runtime behavior, keine stabile configuration
surface.

| Behavior | Current value |
| --- | --- |
| Sidebar debounce | `300ms` in Livewire search input. |
| Search source | Nodes from `FileIndexCache`. |
| Content search | Enabled for document nodes. |
| Allowed document extensions | Controlled by `allowed_extensions`. |
| Maximum searchable document size | Controlled by `max_file_size_kb`. |
| Vendor docs | Included when the source is indexed. |
| Active-source-only search | Not configurable yet. |
| Search cache | Not implemented yet. |

## Language Rules

Ukrainische Dokumentation verwendet nur `uk`. Legacy manager value `ua` wird zu
`uk` normalisiert; erstelle kein `docs/ua`.
