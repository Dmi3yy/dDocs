# Modellreferenz

[Zurück](parser-tags.md) / [Nach oben](../README.md) / [Weiter](events.md)

Diese Referenz bildet die aktuelle Eloquent-Modelloberfläche ab. Es ist eine Suchseite für
Dokumentationsautoren und -entwickler; Es handelt sich nicht um eine vollständige Schemareferenz.

## Inhalts- und Baummodelle

| Modell | Verantwortung |
| --- | --- |
| `SiteContent` | Resource/Dokumentbaumknoten, Inhaltsfelder, Veröffentlichungs-/Lösch-/Cache-/Suchflags, übergeordnete/untergeordnete Beziehungen, Dokumentgruppen, Vorlagenwerte und Verhalten des Abschlusstabellenbaums. |
| `ClosureTable` | Baum-Vorfahren/Nachkommen/Tiefenspeicher für Ressourcenhierarchieoperationen. |
| `DocumentGroup` | Resource-zu-Dokumentgruppen-Beziehungszeilen. |
| `DocumentgroupName` | Benannte Dokumentgruppen, die von Web- und Manager-Zugriffsregeln verwendet werden. |
| `FileGroup` | Dateizugriffsgruppenzeilen, die mit Dokumentgruppen verbunden sind. |

## Elementmodelle

| Modell | Verantwortung |
| --- | --- |
| `SiteTemplate` | Vorlagen, die Ressourcen zugewiesen und mit Template Variables verbunden sind. |
| `SiteTmplvar` | Template Variable-Definitionen: Typ, Name, Beschriftung, Kategorie, Elemente, Anzeige, Standardeinstellungen und Eigenschaften. |
| `SiteTmplvarTemplate` | Beziehung und Rang von Vorlage zu TV. |
| `SiteTmplvarContentvalue` | TV-Werte für einzelne Ressourcen gespeichert. |
| `SiteTmplvarAccess` | TV Zugriffsregeln. |
| `SiteHtmlsnippet` | Chunks. Der historische Modellname bleibt `SiteHtmlsnippet`. |
| `SiteSnippet` | Snippets und modulverknüpfte Snippet-Metadaten. |
| `SitePlugin` | Plugins, Plugin-Code, Eigenschaften, Modulverknüpfung, aktivierter/deaktivierter Status und alternative Plugin-Suchen. |
| `SitePluginEvent` | Plugin-zu-Ereignis-Beziehung und -Priorität. |
| `SiteModule` | Manager-Module, Modulcode-/Ressourcendateien, gemeinsam genutzte Parameter und Aktionen zum Ausführen/Bearbeiten/Abhängigkeit. |
| `SiteModuleAccess` | Module Zugriffsregeln. |
| `SiteModuleDepobj` | Module Abhängigkeitsobjektzeilen. |
| `Category` | Kategoriegruppierung für Elemente und Managerorganisation. |

## Einstellungen, Ereignisse und Protokolle

| Modell | Verantwortung |
| --- | --- |
| `SystemSetting` | Systemeinstellungen, die von der Laufzeit und dem Manager geladen werden. |
| `SystemEventname` | Benannte Ereignisregistrierung, die mit Plugins verbunden ist. |
| `EventLog` | Ereignisprotokollaufzeichnungen. |
| `ManagerLog` | Manager-Aktivitätsprotokolleinträge. |

## Benutzer und Berechtigungen

| Modell | Verantwortung |
| --- | --- |
| `User` | Manager/Web-Benutzerkontomodell. |
| `UserAttribute` | Benutzerprofil- und Attributdaten. |
| `UserSetting` | Einstellungen pro Benutzer. |
| `UserValue` | Speicherung von Benutzerwerten. |
| `UserRole` | Manager Vorbild. |
| `UserRoleVar` | Rolle-zu-TV-Zugriffsbeziehung. |
| `Permissions` | Manager-Berechtigungsdatensätze. |
| `PermissionsGroups` | Berechtigungsgruppendatensätze. |
| `RolePermissions` | Rollenberechtigungsbeziehungszeilen. |
| `MemberGroup` | Beziehungszeilen für Webbenutzergruppen. |
| `MembergroupAccess` | Zugriffsbeziehungszeilen für Mitgliedergruppen. |
| `MembergroupName` | Benannte Webbenutzergruppen. |

## Laufzeitzustandsmodelle

| Modell | Verantwortung |
| --- | --- |
| `ActiveUser` | Aktive Manager-Benutzerverfolgung. |
| `ActiveUserLock` | Aktive Bearbeitungssperren. |
| `ActiveUserSession` | Aktive Manager-Sitzungsaufzeichnungen. |
| `SystemCliTask` | Gespeicherte Systemaufgabenzeilen für CLI/Worker-Flows. |
| `SystemCliTaskLog` | Aufgabenprotokollzeilen. |
| `SystemSchedulerHealth` | Gesundheitsakten des Planers. |
| `SystemWorkerHealth` | Gesundheitsakten der Arbeitnehmer. |

## Dokumentationsregel

Validieren Sie beim Schreiben detaillierter Modelldokumente die Modelldatei, die Beziehungen usw.
Migrationen und Tests gemeinsam. Leiten Sie Felder nicht nur aus der alten Dokumentation ab
oder von UI-Beschriftungen.
