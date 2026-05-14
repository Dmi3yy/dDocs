# System Settings Reference

[Back](artisan-and-manager-actions.md) / [Up](../README.md) / [Next](roles-and-permissions.md)

Evolution CMS stores runtime and manager settings in the system settings layer.
The default values for a fresh install are defined by the core settings factory
and can be changed through the manager System Settings screen when the current
manager user has permission to edit settings.

## Manager Tabs

| Tab | Settings Area |
| --- | --- |
| General | Site defaults, publishing, cache defaults, tree behavior, templates, logging, dates, and visitor tracking. |
| Friendly URLs | Friendly URL mode, suffixes, aliases, strict URL behavior, and folder URL behavior. |
| Interface | Manager language, theme, menu layout, tree sizing, editors, login appearance, and UI buttons. |
| Security | Login attempts, session lifetime, captcha, referer validation, password hashing, eval policy, and site availability. |
| File Manager | File manager root, upload extension allowlists, upload size, file permissions, and folder permissions. |
| File Browser | Resource browser root, image resize settings, hidden files, thumbnails, filename cleanup, and browser mode. |
| Mail Templates | Sender, mail transport, SMTP settings, signup and password reminder templates. |

Plugins can add HTML to settings tabs through the system settings render
events listed in [Events Reference](events.md).

## Critical Defaults

| Setting | Default | Meaning |
| --- | --- | --- |
| `site_name` | `My Evolution CMS Site` | Public site name used by default templates and manager labels. |
| `site_start` | `1` | Resource used as the site start page. |
| `error_page` | `1` | Resource used for not-found errors unless overridden. |
| `unauthorized_page` | `1` | Resource used when a visitor cannot access a protected page. |
| `site_unavailable_page` | empty | Optional resource for maintenance/unavailable state. |
| `base_url` | `/` | Base URL used by runtime URL generation. |
| `valid_hostnames` | empty | Host allowlist. Empty means no explicit hostname list. |
| `server_protocol` | `http` | Default protocol used in generated URLs. |
| `server_offset_time` | `0` | Server time offset in seconds. |
| `datetime_format` | `dd-mm-YYYY` | Manager date/time display format. |

## Resource Defaults

| Setting | Default | Meaning |
| --- | --- | --- |
| `default_template` | `0` | Default template for new resources. |
| `publish_default` | `0` | Whether new resources are published by default. |
| `cache_default` | `1` | Whether new resources are cacheable by default. |
| `search_default` | `1` | Whether new resources are searchable by default. |
| `auto_menuindex` | `1` | Automatically assign menu index values. |
| `resource_tree_node_name` | `pagetitle` | Resource field used as the tree node label. |
| `tree_page_click` | `27` | Manager action opened when clicking a resource tree node. |
| `tree_show_protected` | `0` | Whether protected resources are visible in the tree. |
| `show_meta` | `0` | Whether metadata fields are shown by default. |
| `show_newresource_btn` | `1` | Whether the new resource button is shown. |

## Friendly URL Defaults

| Setting | Default | Meaning |
| --- | --- | --- |
| `friendly_urls` | `0` | Friendly URLs are disabled by default. |
| `friendly_url_prefix` | empty | Prefix added to friendly URLs. |
| `friendly_url_suffix` | `/` | Suffix added to friendly URLs. |
| `friendly_alias_urls` | `1` | Alias-based URLs are enabled. |
| `use_alias_path` | `1` | Parent aliases are included in generated paths. |
| `make_folders` | `0` | Folder-like URL behavior is disabled by default. |
| `seostrict` | `0` | Strict SEO URL handling is disabled by default. |
| `aliaslistingfolder` | `0` | Alias listing folder behavior is disabled by default. |
| `allow_duplicate_alias` | `0` | Duplicate aliases are blocked by default. |
| `automatic_alias` | `1` | Automatic alias generation is enabled. |
| `xhtml_urls` | `1` | XHTML-style escaped URLs are enabled. |

## Parser And Cache Defaults

| Setting | Default | Meaning |
| --- | --- | --- |
| `enable_cache` | `1` | Runtime cache is enabled by default. |
| `cache_type` | `1` | Default cache backend mode. |
| `chunk_processor` | `DLTemplate` | Chunk processor used by default. |
| `enable_bindings` | `1` | Binding syntax is enabled. |
| `enable_at_syntax` | `0` | Conditional `@` syntax is disabled by default. |
| `allow_eval` | `with_scan` | Eval behavior is allowed with scanning. |
| `safe_functions_at_eval` | `time,date,strtotime,strftime` | Safe functions for eval-related parsing. |
| `minifyphp_incache` | `0` | PHP minification in cache is disabled. |
| `html_comment` | empty | Optional parser debug comments. |

See [Parser Tags Reference](parser-tags.md) before documenting template syntax
or parser behavior.

## Manager Interface Defaults

| Setting | Default | Meaning |
| --- | --- | --- |
| `use_editor` | `1` | Rich text editing is enabled. |
| `which_editor` | `TinyMCE4` | Default rich text editor key. |
| `tinymce4_theme` | `custom` | Default TinyMCE theme setting. |
| `tinymce4_skin` | `lightgray` | Default TinyMCE skin. |
| `manager_theme_mode` | `3` | Default manager theme mode. |
| `manager_menu_position` | `top` | Manager menu position. |
| `manager_menu_height` | `2.2` | Manager menu height in `rem`. |
| `manager_tree_width` | `20` | Manager tree width in `rem`. |
| `login_form_position` | `left` | Login form layout position. |
| `login_form_style` | `dark` | Login form style. |
| `manager_login_startup` | `0` | Default manager startup behavior after login. |
| `use_breadcrumbs` | `0` | Breadcrumbs disabled by default. |
| `remember_last_tab` | `0` | Manager does not remember last tab by default. |
| `global_tabs` | `1` | Global tabs enabled. |
| `group_tvs` | `0` | Template Variables are not grouped by default. |
| `show_picker` | `0` | Picker UI disabled by default. |
| `show_fullscreen_btn` | `0` | Fullscreen button hidden by default. |

## File And Upload Defaults

| Setting | Default | Meaning |
| --- | --- | --- |
| `filemanager_path` | `[(base_path)]` | File manager base path. |
| `rb_base_dir` | `[(base_path)]assets/` | Resource browser base directory. |
| `rb_base_url` | `assets/` | Resource browser base URL. |
| `use_browser` | `1` | Resource browser enabled. |
| `which_browser` | `mcpuk` | Default resource browser implementation. |
| `rb_webuser` | `0` | Web user browser mode disabled. |
| `upload_maxsize` | `5000000` | Upload size limit in bytes. |
| `new_file_permissions` | `0644` | Permissions for newly created files. |
| `new_folder_permissions` | `0755` | Permissions for newly created folders. |
| `clean_uploaded_filename` | `1` | Uploaded filenames are cleaned. |
| `strip_image_paths` | `1` | Image paths are stripped in selected outputs. |
| `denyZipDownload` | `0` | ZIP download is allowed by default. |
| `denyExtensionRename` | `0` | Extension rename blocking is disabled by default. |
| `showHiddenFiles` | `0` | Hidden files are not shown by default. |
| `snapshot_path` | `[(base_path)]assets/backup/` | Default snapshot/backup path. |

Default upload allowlists are intentionally broad for legacy compatibility.
Projects should tighten them for production policy.

## Security And Access Defaults

| Setting | Default | Meaning |
| --- | --- | --- |
| `use_udperms` | `1` | User/document permissions are enabled. |
| `udperms_allowroot` | `0` | Root access through document permissions is disabled. |
| `failed_login_attempts` | `3` | Failed login attempts before blocking behavior applies. |
| `blocked_minutes` | `10` | Login block duration in minutes. |
| `session_timeout` | `15` | Manager session timeout in minutes. |
| `validate_referer` | `1` | Referer validation enabled. |
| `use_captcha` | `0` | Captcha disabled by default. |
| `pwd_hash_algo` | `0` | Default password hash algorithm setting. |
| `check_files_onlogin` | core file list | Files checked on manager login. |
| `warning_visibility` | `1` | Manager warnings visible. |
| `send_errormail` | `0` | Error email sending disabled. |
| `error_reporting` | `1` | Default error reporting setting. |

## Mail Defaults

| Setting | Default | Meaning |
| --- | --- | --- |
| `emailsender` | `you@example.com` | Default sender address. |
| `email_sender_method` | `1` | Sender method setting. |
| `email_method` | `mail` | Default mail transport. |
| `smtp_host` | `smtp.example.com` | Default SMTP host placeholder. |
| `smtp_port` | `25` | Default SMTP port. |
| `smtp_auth` | `0` | SMTP authentication disabled. |
| `smtp_username` | `emailsender` | Default SMTP username placeholder. |
| `smtp_secure` | empty | No SMTP encryption mode by default. |

## Documentation Rule

When documenting a setting, include the current default only after checking the
settings factory or install seed path. If a project overrides a setting through
the database or environment, document the override in project documentation, not
in this product reference.
