# Models Reference

[Back](parser-tags.md) / [Up](../README.md) / [Next](events.md)

This reference maps the current Eloquent model surface. It is a lookup page for
documentation authors and developers; it is not a full schema reference.

## Content And Tree Models

| Model | Responsibility |
| --- | --- |
| `SiteContent` | Resource/document tree nodes, content fields, publish/delete/cache/search flags, parent/child relations, document groups, template values, and closure-table tree behavior. |
| `ClosureTable` | Tree ancestor/descendant/depth storage for resource hierarchy operations. |
| `DocumentGroup` | Resource-to-document-group relation rows. |
| `DocumentgroupName` | Named document groups used by web and manager access rules. |
| `FileGroup` | File access group rows connected to document groups. |

## Element Models

| Model | Responsibility |
| --- | --- |
| `SiteTemplate` | Templates assigned to resources and connected to Template Variables. |
| `SiteTmplvar` | Template Variable definitions: type, name, caption, category, elements, display, defaults, and properties. |
| `SiteTmplvarTemplate` | Template-to-TV relation and rank. |
| `SiteTmplvarContentvalue` | TV values saved for individual resources. |
| `SiteTmplvarAccess` | TV access rules. |
| `SiteHtmlsnippet` | Chunks. The historical model name remains `SiteHtmlsnippet`. |
| `SiteSnippet` | Snippets and module-linked snippet metadata. |
| `SitePlugin` | Plugins, plugin code, properties, module linkage, enabled/disabled state, and alternative plugin lookups. |
| `SitePluginEvent` | Plugin-to-event relation and priority. |
| `SiteModule` | Manager modules, module code/resource files, shared params, and run/edit/dependency actions. |
| `SiteModuleAccess` | Module access rules. |
| `SiteModuleDepobj` | Module dependency object rows. |
| `Category` | Category grouping for elements and manager organization. |

## Settings, Events, And Logs

| Model | Responsibility |
| --- | --- |
| `SystemSetting` | System settings loaded by the runtime and manager. |
| `SystemEventname` | Named event registry connected to plugins. |
| `EventLog` | Event log records. |
| `ManagerLog` | Manager activity log records. |

## Users And Permissions

| Model | Responsibility |
| --- | --- |
| `User` | Manager/web user account model. |
| `UserAttribute` | User profile and attribute data. |
| `UserSetting` | Per-user settings. |
| `UserValue` | User value storage. |
| `UserRole` | Manager role model. |
| `UserRoleVar` | Role-to-TV access relation. |
| `Permissions` | Manager permission records. |
| `PermissionsGroups` | Permission group records. |
| `RolePermissions` | Role permission relation rows. |
| `MemberGroup` | Web user group relation rows. |
| `MembergroupAccess` | Member group access relation rows. |
| `MembergroupName` | Named web user groups. |

## Runtime State Models

| Model | Responsibility |
| --- | --- |
| `ActiveUser` | Active manager user tracking. |
| `ActiveUserLock` | Active editing locks. |
| `ActiveUserSession` | Active manager session records. |
| `SystemCliTask` | Stored system task rows for CLI/worker flows. |
| `SystemCliTaskLog` | Task log rows. |
| `SystemSchedulerHealth` | Scheduler health records. |
| `SystemWorkerHealth` | Worker health records. |

## Documentation Rule

When writing detailed model docs, validate the model file, relationships,
migrations, and tests together. Do not infer fields only from old documentation
or from UI labels.
