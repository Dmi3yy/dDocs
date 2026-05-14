# Settings, Permissions, And Files

[Back](elements.md) / [Up](README.md) / [Next](../04-development/project-structure.md)

This guide covers core manager configuration surfaces: system settings, friendly
URLs, file access, uploads, search, roles, permissions, and web access groups.

## System Settings

The System Settings manager page is permission-protected and can be locked while
another manager user edits it. Current setting tabs include:

| Tab | Common Use |
| --- | --- |
| General | Site defaults, publishing defaults, cache defaults, search defaults, menu index behavior, templates, and time settings. |
| Friendly URLs | URL mode, suffix/prefix, folder behavior, strict URLs, and alias behavior. |
| Interface | Manager language, theme, editor choices, and interface options. |
| Security | Password and manager security settings. |
| File Browser | Resource browser base path and uploaded filename cleanup. |
| File Manager | File manager path, upload allowlists, image/media allowlists, and upload size. |
| Mail Templates | Manager mail template settings. |

After changing settings that affect output, paths, URLs, uploads, cache, or
manager behavior, refresh cache and test the affected workflow.

## Friendly URLs

Friendly URLs require:

1. Evolution CMS friendly URL settings enabled.
2. Valid aliases on resources.
3. Web-server rewrite rules for the project.
4. Cache refresh after changes.

If exact URLs do not resolve, use manager search by URL and verify the resource
is published, not deleted, and not blocked by access rules.

## Files And Uploads

File browser and upload behavior depends on both Evolution CMS settings and
filesystem permissions.

Check:

- file manager path;
- resource browser base directory;
- allowed file/image/media extensions;
- upload size setting;
- PHP and web-server upload limits;
- directory read/write permissions.

## Roles And Manager Permissions

Manager roles and permissions control what manager users can access. When a user
cannot open a screen, check:

1. The user's role.
2. The permission required by the manager page.
3. Whether the resource or element is locked.
4. Whether the action is hidden by manager access rules.

## Web Access Permissions

Web access permissions use user groups and document groups. The manager page can
create, rename, delete, and connect these groups.

Use web access permissions when site visitors should see only specific protected
resources. If the feature is disabled, the manager page shows a warning before
group management.

## Search

Manager search can find resources by ID, text fields, exact URL, template, and
Template Variable values. Use it for support cases where the tree location is
unknown or a resource is hidden, deleted, unpublished, or protected.

## Package Documentation Boundary

Core manager docs describe built-in Evolution CMS behavior. Installed Extras
appear as separate documentation sources in dDocs. If a manager screen belongs
to a package, open that package's docs instead of expecting the product docs to
duplicate its manual.
