# Roles And Permissions Reference

[Back](system-settings.md) / [Up](../README.md) / [Next](blade-and-template-rendering.md)

Evolution CMS separates manager permissions, document-group access, web-user
access, element locks, and file permissions. This page documents the current
core permission surfaces for product documentation. Package-specific permission
screens belong to each package's own dDocs source.

## Manager Role Model

Manager roles are represented by the `UserRole` model. Manager users receive a
role through user attributes, and permission checks read the active session
permission array for the current context.

| Surface | Purpose |
| --- | --- |
| `UserRole` | Role name, description, and manager permission flags. |
| `UserAttribute.role` | Role assigned to a manager or web user account. |
| `RolePermissions` | Additional permission records linked by role. |
| `Permissions` and `PermissionsGroups` | Permission definitions and grouping. |
| `UserRoleVar` | Template Variable access/rank by role. |
| `ActiveUserLock` | Lock state for elements and resources currently being edited. |

The core permission helper is `hasPermission($permission, $context = '')`.
`hasAnyPermissions([...], $context = '')` returns true when any listed
permission is available.

## Role Permission Flags

| Area | Permission Flags |
| --- | --- |
| Manager shell | `frames`, `home`, `logout`, `help`, `messages`, `about`, `credits`, `action_ok`, `error_dialog` |
| Resources | `view_document`, `new_document`, `edit_document`, `save_document`, `publish_document`, `delete_document`, `empty_trash`, `view_unpublished`, `change_resourcetype` |
| Templates | `new_template`, `edit_template`, `save_template`, `delete_template` |
| Template Variables | TV access is handled through role-TV relations and permissions such as `manage_tv_permissions` when present. |
| Chunks | `new_chunk`, `edit_chunk`, `save_chunk`, `delete_chunk` |
| Snippets | `new_snippet`, `edit_snippet`, `save_snippet`, `delete_snippet` |
| Plugins | `new_plugin`, `edit_plugin`, `save_plugin`, `delete_plugin` |
| Modules | `new_module`, `edit_module`, `save_module`, `delete_module`, `exec_module` |
| Users | `new_user`, `edit_user`, `save_user`, `delete_user`, `change_password`, `save_password` |
| Roles | `new_role`, `edit_role`, `save_role`, `delete_role` |
| Permissions | `access_permissions`, `web_access_permissions` |
| Files | `file_manager`, `assets_files`, `assets_images`, `bk_manager` |
| Logs and locks | `logs`, `view_eventlog`, `delete_eventlog`, `remove_locks`, `display_locks` |
| Static import/export | `import_static`, `export_static` |
| Web users | `new_web_user`, `edit_web_user`, `save_web_user`, `delete_web_user` |

Some current code paths also check newer named permissions such as
`manage_groups`, `manage_document_permissions`, `manage_tv_permissions`,
`manage_metatags`, `system_tasks.view`, `system_tasks.site_update`, and
`system_tasks.manage_packages`. Document those permissions with the feature that
uses them, because they are capability names rather than core role columns.

## Document Access Permissions

Document access permissions use document groups and member groups.

| Model/Table Surface | Purpose |
| --- | --- |
| `DocumentgroupName` | Named document groups. |
| `DocumentGroup` | Links resources to document groups. |
| `MemberGroup` | Links users to member groups. |
| `membergroup_access` | Links member groups to document groups. |
| `use_udperms` | Enables user/document permission checks. |
| `udperms_allowroot` | Controls root behavior for document permissions. |

When `use_udperms` is enabled, non-admin manager users are checked against the
groups they can access. Resource save and tree/query flows must keep those
checks intact.

## Web Access Permissions

Web access permissions protect frontend resources for authenticated web users.
They are separate from manager role permissions.

| Surface | Purpose |
| --- | --- |
| Web users | Users who authenticate on the site frontend. |
| Web user roles | Optional role assignment on user attributes. |
| Web user groups | Groups used for frontend access decisions. |
| Document groups | Resource groups that can be connected to member groups. |
| `web_access_permissions` | Manager permission for web access management. |

Use this layer when site visitors should see only selected protected resources.
Do not use manager roles as a frontend authorization model.

## Locks

Evolution CMS tracks locked elements to prevent unsafe concurrent editing.
Lockable types include:

| Type ID | Element |
| ---: | --- |
| `1` | Template |
| `2` | Template Variable |
| `3` | Chunk |
| `4` | Snippet |
| `5` | Plugin |
| `6` | Module |
| `7` | Resource |
| `8` | Role |

Controllers and models expose lock state through methods such as
`getLockedElements()`, `isAlreadyEdit`, and `alreadyEditInfo`.

## File Permissions

File creation behavior is controlled by system settings:

| Setting | Default | Meaning |
| --- | --- | --- |
| `new_file_permissions` | `0644` | Permissions applied to new files where the file manager sets them. |
| `new_folder_permissions` | `0755` | Permissions applied to new folders where the file manager sets them. |
| `filemanager_path` | `[(base_path)]` | Root for file manager operations. |
| `rb_base_dir` | `[(base_path)]assets/` | Resource browser base directory. |

File permissions are not a replacement for manager permissions. A user needs
both manager capability and filesystem access for a write to succeed.

## Documentation Rule

When documenting a permission, name the exact permission key and the manager
surface that checks it. If the feature belongs to an installed package, keep the
permission documentation in that package's docs and link to this page only for
the core permission model.
