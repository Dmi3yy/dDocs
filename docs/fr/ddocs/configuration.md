# Configuration

Project config:

```text
custom/config/dmi3yy/settings/dDocs.php
```

Package defaults:

```text
config/dDocsSettings.php
```

## Paramètres

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `enabled` | boolean-like `0`/`1` | `1` | Active le module. |
| `language_fallback` | locale string | `en` | Langue fallback. |
| `default_language` | locale string ou empty | empty | Langue forcée. Legacy `ua` est normalisé vers `uk`. |
| `allowed_extensions` | CSV string | `md,mdx` | Markdown extensions indexées. |
| `max_file_size_kb` | integer | `512` | Taille maximale d'un Markdown file. |

## Sources

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `scan_vendor_packages` | boolean-like `0`/`1` | `1` | Cherche docs dans les packages installés. |
| `scan_project_docs` | boolean-like `0`/`1` | `1` | Cherche configured project docs roots. |
| `safe_roots` | multiline paths | empty | Trusted filesystem roots. |
| `extra_docs_roots` | multiline paths | empty | Docs roots supplémentaires. |

## Search Behavior

Search behavior est surtout un runtime behavior, pas encore une configuration
surface stable.

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

La documentation ukrainienne utilise uniquement `uk`. Legacy manager value `ua`
est normalisé vers `uk`; ne créez pas `docs/ua`.
