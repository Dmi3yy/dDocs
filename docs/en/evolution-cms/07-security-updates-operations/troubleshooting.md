# Troubleshooting

[Back](../01-getting-started/core-concepts.md) / [Up](README.md) / [Next](../10-reference/source-inventory.md)

Use this page for first-line checks before opening deeper code or hosting
diagnostics. It focuses on current Evolution CMS and installer behavior.

## Quick Checks

| Symptom | Check First |
| --- | --- |
| The installer does not start | Confirm PHP 8.3 or newer, Composer availability, and a writable installer binary directory. Run `evo system-status` when available. |
| The installer cannot download or update the binary | Check network access to GitHub Releases. If rate-limited, set `GITHUB_TOKEN` or pass the installer GitHub token option. |
| Composer is not found | Make sure Composer is an executable on `PATH`, not only a shell alias. Set `EVO_COMPOSER_BIN` when the host needs an explicit Composer path. |
| Database setup fails | Verify the selected database driver is installed for PHP, the host/port/name/user/password are correct, and SQLite names are valid for the project database directory. |
| Installation completes but manager login fails | Check the manager directory chosen during install, session/cookie behavior, database user records, and whether the install command reported admin-user fallback warnings. |
| A page is blank or returns a server error | Check PHP error logs, application logs, missing Composer dependencies, and whether generated caches need a full refresh. |
| Changes are not visible on the site | Clear the full cache or run the site refresh action. Resource caching, view cache, env cache, and browser cache can all hide recent changes. |
| Friendly URLs do not work | Confirm `friendly_urls` is enabled, rewrite rules are configured in the web server, aliases are valid, and cache has been refreshed. |
| File browser or uploads fail | Check `filemanager_path`, `rb_base_dir`, upload extension settings, maximum upload size, and filesystem permissions for the target directories. |
| A manager user cannot see a document | Check manager permissions, document groups, user groups, resource privacy flags, and whether the user has access to the manager action. |
| Package documentation is missing from dDocs | Confirm the package has a filesystem `docs/` folder, the package is installed in the project, dDocs was refreshed, and the current manager language maps to an available docs locale. |
| An Extra-specific feature is undocumented here | Open that Extra in dDocs. Product docs describe shared Evolution CMS behavior; installed Extras own their feature manuals. |

## Cache And Refresh

The common full refresh path calls `evo()->clearCache('full')`. The manager site
refresh also publishes and unpublishes scheduled resources, clears full cache,
removes the generated env cache when present, and invokes the site refresh event.

Use a cache refresh after changing:

- templates, chunks, snippets, plugins, modules, or Template Variables;
- system settings that affect routing, paths, uploads, cache, or manager output;
- package service providers, assets, views, or generated config;
- resource aliases, published state, permissions, or friendly URL settings.

## Friendly URL Checklist

Friendly URL problems usually involve both Evolution CMS settings and web-server
configuration.

| Area | What To Verify |
| --- | --- |
| Manager settings | `friendly_urls`, suffix/prefix settings, folder behavior, strict URL settings, and aliases. |
| Web server | Apache rewrite rules or equivalent Nginx routing are active for the project. |
| Resources | Aliases are unique where needed and resources are published, visible, and not deleted. |
| Cache | Refresh the site after changing aliases, URL settings, or rewrite behavior. |

## File And Upload Checklist

File manager and upload issues usually come from paths, extension allowlists, or
permissions.

| Setting Area | What To Verify |
| --- | --- |
| File manager path | The configured path points inside the project and is readable by PHP. |
| Resource browser base directory | The browser base directory points at the intended assets location. |
| Upload extensions | Files, images, and media extension lists allow the expected file type. |
| Upload size | The Evolution CMS upload limit and PHP/web-server upload limits are high enough. |
| Permissions | PHP can create, write, rename, and delete files in the target directory. |

## Package Documentation Boundary

dDocs is the package documentation surface for installed Extras. If a package
appears in the dDocs tree with only a package name or without localized pages,
fix the package documentation source rather than copying its manual into
Evolution CMS product docs.

For package docs issues, verify:

- the package contains `docs/en/README.md` or another supported locale entry;
- Ukrainian package docs use the `uk` locale folder; legacy Ukrainian locale
  folders should be migrated before release;
- the package docs have stable titles and one H1 per page;
- relative links resolve inside the package docs root;
- dDocs index/cache has been refreshed after file changes.

## Support Data To Collect

When a problem needs deeper review, collect:

- PHP version and enabled database drivers;
- Evolution CMS version or branch;
- installer version and command used;
- database type and whether the issue happens before or after migrations;
- manager language;
- changed system settings related to cache, URLs, paths, uploads, or permissions;
- the exact manager action or URL that fails;
- recent package installs or updates.
