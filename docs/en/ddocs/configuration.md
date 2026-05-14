# Configuration

dDocs settings live in:

```text
custom/config/dmi3yy/settings/dDocs.php
```

The package default is:

```text
config/dDocsSettings.php
```

The manager settings screen writes the project config file. Keep production
defaults conservative and only add roots that the project explicitly trusts.

The effective project configuration root is `dmi3yy.settings.dDocs`. The manager
settings UI is described by `config/settings/form.php` and exposed through the
package `settings.form` config surface for the evo-ui form
`evo-ui.forms.ddocs.settings`.

## General Settings

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `enabled` | boolean-like `0`/`1` | `1` | Enables the module. If disabled, the manager page should not expose the docs workspace. |
| `language_fallback` | locale string | `en` | Language used to fill missing localized documentation branches and files. |
| `default_language` | locale string or empty | empty | Optional forced language. Leave empty to use the manager language. Legacy `ua` input is normalized to `uk`. |
| `allowed_extensions` | CSV string | `md,mdx` | Markdown file extensions indexed by dDocs. |
| `allowed_image_extensions` | CSV string | `png,jpg,jpeg,gif,webp` | Local image extensions that can be rendered. |
| `max_file_size_kb` | integer | `512` | Maximum Markdown file size for reading/rendering/search. |

## Source Settings

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `scan_vendor_packages` | boolean-like `0`/`1` | `1` | Discover installed Composer/Evolution packages that expose docs. |
| `scan_project_docs` | boolean-like `0`/`1` | `1` | Discover explicitly configured project docs roots. |
| `safe_roots` | multiline paths | empty | Trusted filesystem roots. One absolute path per line. |
| `extra_docs_roots` | multiline paths | empty | Additional trusted docs roots. One absolute path per line. |
| `show_internal_task_docs` | boolean-like `0`/`1` | `0` | Show internal task artifacts under docs trees. Keep disabled for normal reading. |
| `show_evolution_docs` | boolean-like `0`/`1` | `0` | Reserved switch for explicitly added Evolution platform docs. |

`safe_roots` and `extra_docs_roots` must stay empty in package defaults. They are
project configuration, not package configuration.

## Cache Settings

| Key | Type | Default | Purpose |
| --- | --- | --- | --- |
| `cache_index` | boolean-like `0`/`1` | `1` | Store the generated docs index in a PHP cache file. |
| `index_cache_path` | path string or empty | empty | Optional explicit cache file path. Leave empty to use the safe default cache location. |

The index cache stores metadata only: source nodes, folder nodes, document paths,
language metadata, timestamps, and checksums. It does not store canonical content
in the database.

Refresh the index after changing package docs manually, changing roots, or
switching documentation structure. Creating, saving, or deleting project docs
from the dDocs UI refreshes the index automatically.

## Search Behavior

Search-related behavior is mostly current runtime behavior, not configurable
surface yet.

| Behavior | Current value |
| --- | --- |
| Sidebar debounce | `300ms` in the Livewire search input. |
| Search source | Nodes returned by `FileIndexCache`. |
| Content search | Enabled for document nodes by current runtime behavior. |
| Allowed document extensions | Controlled by `allowed_extensions`. |
| Maximum searchable document size | Controlled by `max_file_size_kb`. |
| Vendor docs | Included when their source is indexed. |
| Active-source-only search | Not configurable yet. |
| Search mode | Not configurable yet. |
| Search cache | Not implemented yet. |

Future configuration may add default search mode, content-search toggle,
vendor-doc inclusion, active-source-only search, debounce delay, and generated
`FileSearchIndexCache` settings. Until those keys exist in runtime code, keep
them documented as roadmap, not as available configuration.

## Discovery Rules

dDocs discovers only trusted package/project roots. It does not scan the whole
disk.

A package is discoverable when it is an installed/local Evolution package and has
one of these:

```text
docs/
Docs/          legacy compatibility only
README.md     fallback for packages without docs/
index.md      fallback for packages without docs/
```

The preferred root is lowercase `docs/`.

## Language Rules

dDocs builds one effective language tree for the current manager user.

Order:

1. Manager language or `default_language`.
2. Legacy manager value `ua` is normalized to documentation locale `uk`.
3. `language_fallback`, usually `en`.
4. Neutral docs: `docs/pages/`, `docs/README.md`, or `docs/index.md`.

The UI should not show every language folder at once. It shows the effective
language tree and keeps available language metadata for future language switching.
Localized files override fallback files with the same relative path. Missing
localized branches are filled from `language_fallback`, so a partial `docs/uk`
tree can still show validated English branches from `docs/en`.
Indexed documentation folders must use `uk` for Ukrainian content.
