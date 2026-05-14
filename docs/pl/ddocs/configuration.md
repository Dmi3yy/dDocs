# Konfiguracja

Project config:

```text
custom/config/dmi3yy/settings/dDocs.php
```

Package defaults:

```text
config/dDocsSettings.php
```

## Główne ustawienia

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `enabled` | boolean-like `0`/`1` | `1` | Włącza moduł. |
| `language_fallback` | locale string | `en` | Język fallback. |
| `default_language` | locale string lub empty | empty | Wymuszony język. Legacy `ua` normalizuje się do `uk`. |
| `allowed_extensions` | CSV string | `md,mdx` | Indeksowane Markdown extensions. |
| `max_file_size_kb` | integer | `512` | Maksymalny rozmiar Markdown file. |

## Źródła

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `scan_vendor_packages` | boolean-like `0`/`1` | `1` | Szuka docs w zainstalowanych packages. |
| `scan_project_docs` | boolean-like `0`/`1` | `1` | Szuka configured project docs roots. |
| `safe_roots` | multiline paths | empty | Trusted filesystem roots. |
| `extra_docs_roots` | multiline paths | empty | Dodatkowe docs roots. |
| `show_internal_task_docs` | boolean-like `0`/`1` | `0` | Pokazuje internal task artifacts. |

## Search Behavior

Search behavior jest głównie runtime behavior, nie stabilną configuration
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

Ukraińska dokumentacja używa tylko `uk`. Legacy manager value `ua` jest
normalizowany do `uk`; nie twórz `docs/ua`.
