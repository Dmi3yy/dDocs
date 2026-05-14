# Referenz zu Rollen und Berechtigungen

[Zurück](system-settings.md) / [Nach oben](../README.md) / [Weiter](blade-and-template-rendering.md)

Evolution CMS trennt Managerberechtigungen, Zugriff auf Dokumentgruppen und Webbenutzer
Zugriff, Elementsperren und Dateiberechtigungen. Diese Seite dokumentiert den aktuellen
Kernberechtigungsoberflächen für die Produktdokumentation. Paketspezifische Berechtigung
Bildschirme gehören zur eigenen dDocs-Quelle jedes Pakets.

## Manager Vorbild

Manager-Rollen werden durch das Modell `UserRole` dargestellt. Manager-Benutzer erhalten eine
Rolle durch Benutzerattribute und Berechtigungsprüfungen lesen die aktive Sitzung
Berechtigungsarray für den aktuellen Kontext.

| Oberfläche | Zweck |
| --- | --- |
| `UserRole` | Rollenname, Beschreibung und Manager-Berechtigungsflags. |
| `UserAttribute.role` | Einem Manager- oder Webbenutzerkonto zugewiesene Rolle. |
| `RolePermissions` | Zusätzliche Berechtigungsdatensätze, verknüpft nach Rolle. |
| `Permissions` und `PermissionsGroups` | Berechtigungsdefinitionen und Gruppierung. |
| `UserRoleVar` | Template Variable Zugriff/Rang nach Rolle. |
| `ActiveUserLock` | Sperrstatus für Elemente und Ressourcen, die gerade bearbeitet werden. |

Der zentrale Berechtigungshelfer ist `hasPermission($permission, $context = '')`.
`hasAnyPermissions([...], $context = '')` gibt „true“ zurück, wenn einer aufgeführt ist
Erlaubnis liegt vor.

## Rollenberechtigungsflags

| Bereich | Berechtigungsflags |
| --- | --- |
| Manager-Shell | `frames`, `home`, `logout`, `help`, `messages`, `about`, `credits`, `action_ok`, `error_dialog` |
| Resources | `view_document`, `new_document`, `edit_document`, `save_document`, `publish_document`, `delete_document`, `empty_trash`, `view_unpublished`, `change_resourcetype` |
| Vorlagen | `new_template`, `edit_template`, `save_template`, `delete_template` |
| Template Variables | Der TV-Zugriff wird über Rollen-TV-Beziehungen und Berechtigungen wie `manage_tv_permissions`, sofern vorhanden, gehandhabt. |
| Chunks | `new_chunk`, `edit_chunk`, `save_chunk`, `delete_chunk` |
| Snippets | `new_snippet`, `edit_snippet`, `save_snippet`, `delete_snippet` |
| Plugins | `new_plugin`, `edit_plugin`, `save_plugin`, `delete_plugin` |
| Modules | `new_module`, `edit_module`, `save_module`, `delete_module`, `exec_module` |
| Benutzer | `new_user`, `edit_user`, `save_user`, `delete_user`, `change_password`, `save_password` |
| Rollen | `new_role`, `edit_role`, `save_role`, `delete_role` |
| Berechtigungen | `access_permissions`, `web_access_permissions` |
| Dateien | `file_manager`, `assets_files`, `assets_images`, `bk_manager` |
| Protokolle und Sperren | `logs`, `view_eventlog`, `delete_eventlog`, `remove_locks`, `display_locks` |
| Statischer Import/Export | `import_static`, `export_static` |
| Webbenutzer | `new_web_user`, `edit_web_user`, `save_web_user`, `delete_web_user` |

Einige aktuelle Codepfade überprüfen auch neuere benannte Berechtigungen, z
`manage_groups`, `manage_document_permissions`, `manage_tv_permissions`,
`manage_metatags`, `system_tasks.view`, `system_tasks.site_update` und
`system_tasks.manage_packages`. Dokumentieren Sie diese Berechtigungen mit der Funktion that
verwendet sie, da es sich dabei um Funktionsnamen und nicht um Kernrollenspalten handelt.

## Zugriffsberechtigungen für Dokumente

Dokumentzugriffsberechtigungen verwenden Dokumentgruppen und Mitgliedergruppen.

| Modell/Tischoberfläche | Zweck |
| --- | --- |
| `DocumentgroupName` | Benannte Dokumentgruppen. |
| `DocumentGroup` | Verknüpft Ressourcen mit Dokumentgruppen. |
| `MemberGroup` | Verknüpft Benutzer mit Mitgliedsgruppen. |
| `membergroup_access` | Verknüpft Mitgliedsgruppen mit Dokumentgruppen. |
| `use_udperms` | Ermöglicht Überprüfungen von Benutzer-/Dokumentberechtigungen. |
| `udperms_allowroot` | Steuert das Root-Verhalten für Dokumentberechtigungen. |

Wenn `use_udperms` aktiviert ist, werden Benutzer, die keine Administrator-Manager sind, anhand der überprüft
Gruppen, auf die sie zugreifen können. Resource Speicher- und Baum-/Abfrageabläufe müssen diese beibehalten
Schecks intakt.

## Webzugriffsberechtigungen

Webzugriffsberechtigungen schützen Frontend-Ressourcen für authentifizierte Webbenutzer.
Sie sind von den Managerrollenberechtigungen getrennt.| Oberfläche | Zweck |
| --- | --- |
| Webbenutzer | Benutzer, die sich am Frontend der Website authentifizieren. |
| Webbenutzerrollen | Optionale Rollenzuweisung für Benutzerattribute. |
| Webbenutzergruppen | Gruppen, die für Frontend-Zugriffsentscheidungen verwendet werden. |
| Dokumentgruppen | Resource-Gruppen, die mit Mitgliedsgruppen verbunden werden können. |
| `web_access_permissions` | Manager-Berechtigung für die Webzugriffsverwaltung. |

Verwenden Sie diese Ebene, wenn Website-Besucher nur ausgewählte geschützte Ressourcen sehen sollen.
Verwenden Sie keine Managerrollen als Frontend-Autorisierungsmodell.

## Schlösser

Evolution CMS verfolgt gesperrte Elemente, um unsichere gleichzeitige Bearbeitung zu verhindern.
Zu den abschließbaren Typen gehören:

| Typ-ID | Element |
| ---: | --- |
| `1` | Vorlage |
| `2` | Template Variable |
| `3` | Chunk |
| `4` | Snippet |
| `5` | Plugin |
| `6` | Module |
| `7` | Resource |
| `8` | Rolle |

Controller und Modelle legen den Sperrstatus durch Methoden offen wie
`getLockedElements()`, `isAlreadyEdit` und `alreadyEditInfo`.

## Dateiberechtigungen

Das Verhalten bei der Dateierstellung wird durch die Systemeinstellungen gesteuert:

| Einstellung | Standard | Bedeutung |
| --- | --- | --- |
| `new_file_permissions` | `0644` | Berechtigungen, die auf neue Dateien angewendet werden, wenn der Dateimanager sie festlegt. |
| `new_folder_permissions` | `0755` | Berechtigungen werden auf neue Ordner angewendet, in denen der Dateimanager sie festlegt. |
| `filemanager_path` | `[(base_path)]` | Root für Dateimanageroperationen. |
| `rb_base_dir` | `[(base_path)]assets/` | Resource Browser-Basisverzeichnis. |

Dateiberechtigungen sind kein Ersatz für Managerberechtigungen. Ein Benutzer braucht
sowohl Managerfähigkeit als auch Dateisystemzugriff, damit ein Schreibvorgang erfolgreich ist.

## Dokumentationsregel

Geben Sie bei der Dokumentation einer Berechtigung den genauen Berechtigungsschlüssel und den Manager an
Oberfläche, die es überprüft. Wenn die Funktion zu einem installierten Paket gehört, behalten Sie sie bei
Berechtigungsdokumentation in den Dokumenten dieses Pakets und Link zu dieser Seite nur für
das Kernberechtigungsmodell.
