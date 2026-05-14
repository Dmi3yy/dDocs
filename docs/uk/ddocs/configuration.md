# Конфігурація

Налаштування dDocs живуть тут:

```text
custom/config/dmi3yy/settings/dDocs.php
```

Дефолти пакета:

```text
config/dDocsSettings.php
```

Екран налаштувань у manager пише project config. Production defaults мають
лишатися консервативними: додавайте тільки roots, яким проєкт явно довіряє.

Effective project configuration root - `dmi3yy.settings.dDocs`. Manager settings
UI описаний у `config/settings/form.php` і відкривається через package
`settings.form` config surface для evo-ui form `evo-ui.forms.ddocs.settings`.

## Основні налаштування

| Ключ | Тип | Дефолт | Для чого |
| --- | --- | --- | --- |
| `enabled` | boolean-like `0`/`1` | `1` | Вмикає модуль. |
| `language_fallback` | locale string | `en` | Мова fallback, якщо для manager language немає docs. |
| `default_language` | locale string або empty | empty | Примусова мова. Legacy `ua` input нормалізується до `uk`. |
| `allowed_extensions` | CSV string | `md,mdx` | Markdown extensions, які dDocs індексує. |
| `allowed_image_extensions` | CSV string | `png,jpg,jpeg,gif,webp` | Extensions локальних images, які можна показувати. |
| `max_file_size_kb` | integer | `512` | Максимальний Markdown file size для читання, rendering і search. |

## Джерела

| Ключ | Тип | Дефолт | Для чого |
| --- | --- | --- | --- |
| `scan_vendor_packages` | boolean-like `0`/`1` | `1` | Шукати docs встановлених Composer/Evolution packages. |
| `scan_project_docs` | boolean-like `0`/`1` | `1` | Шукати явно configured project docs roots. |
| `safe_roots` | multiline paths | empty | Trusted filesystem roots. Один absolute path на рядок. |
| `extra_docs_roots` | multiline paths | empty | Додаткові docs roots. Один absolute path на рядок. |
| `show_internal_task_docs` | boolean-like `0`/`1` | `0` | Показувати internal task artifacts у docs tree. Для читання вимкнено. |
| `show_evolution_docs` | boolean-like `0`/`1` | `0` | Reserved switch для явно доданих Evolution platform docs. |

`safe_roots` і `extra_docs_roots` не мають бути заповнені в package defaults.
Це налаштування конкретного проєкту.

## Cache

| Ключ | Тип | Дефолт | Для чого |
| --- | --- | --- | --- |
| `cache_index` | boolean-like `0`/`1` | `1` | Зберігати generated docs index у PHP cache file. |
| `index_cache_path` | path string або empty | empty | Явний cache path. Зазвичай лишаємо empty і використовуємо safe default. |

Індекс містить metadata: source nodes, folder nodes, document paths, language
metadata, timestamps і checksums. Він не переносить canonical content у DB.

## Search Behavior

Search-related behavior зараз є runtime behavior, а не повністю configurable
surface.

| Behavior | Current value |
| --- | --- |
| Sidebar debounce | `300ms` у Livewire search input. |
| Search source | Nodes із `FileIndexCache`. |
| Content search | Enabled для document nodes поточною runtime behavior. |
| Allowed document extensions | Контролює `allowed_extensions`. |
| Maximum searchable document size | Контролює `max_file_size_kb`. |
| Vendor docs | Включені, якщо source indexed. |
| Active-source-only search | Ще не configurable. |
| Search mode | Ще не configurable. |
| Search cache | Ще не implemented. |

Майбутні config keys можуть керувати default search mode, content-search toggle,
vendor-doc inclusion, active-source-only search, debounce delay і generated
`FileSearchIndexCache`. Поки цих keys немає в runtime code, це roadmap, не
available configuration.

## Discovery Rules

dDocs читає тільки trusted package/project roots. Він не сканує весь диск.

Package є discoverable, якщо це installed/local Evolution package і в ньому є:

```text
docs/
Docs/          legacy compatibility only
README.md     fallback для packages без docs/
index.md      fallback для packages без docs/
```

Бажаний стандарт - lowercase `docs/`.

## Language Rules

dDocs показує одну effective language version для поточного manager user.

Порядок:

1. Manager language або `default_language`.
2. Legacy manager value `ua` нормалізується до documentation locale `uk`.
3. `language_fallback`, зазвичай `en`.
4. Neutral docs: `docs/pages/`, `docs/README.md` або `docs/index.md`.

UI не має дублювати всі мовні папки одним списком. Indexed documentation
folders мають використовувати `uk` для українського контенту.
