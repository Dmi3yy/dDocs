# Ereignisreferenz

[Zurück](parser-tags.md) / [Nach oben](../README.md) / [Weiter](models.md)

Evolution CMS-Plugins überwachen benannte Ereignisse. Aktueller Code ruft Ereignisse von auf
die Kernlaufzeit, Manager-Controller/Ansichten/Prozessoren, Dateibrowser, Cache
Layer, Dokument-/Benutzerdienste und Kompatibilitätsoberflächen. Neue Installationen
Wenn dies der Fall ist, werden die Standardereignisnamen in die Tabelle `system_eventnames` eingefügt
leer.

## Veranstaltungsdienste

| Dienst-ID | Bereich |
| ---: | --- |
| `1` | Parser, Dokumente, Elemente, Einstellungen, Dateibrowser und allgemeine Systemereignisse. |
| `2` | Manager Shell- und Manager-Authentifizierungsereignisse. |
| `3` | Webbenutzerauthentifizierung und Webbenutzerlebenszyklusereignisse. |
| `4` | Cache- und Seiten-Cache-Ereignisse. |
| `5` | Web-Laufzeit, Seitenrendering, URLs, Parser-Eigenschaften und Ausgabeereignisse. |

## Laufzeit- und Parser-Ereignisse

| Veranstaltung | Typischer Bereich |
| --- | --- |
| `OnWebPageInit` | Initialisierung der Webanforderung. |
| `OnBeforeLoadDocumentObject` | Vor dem Laden des Dokumentobjekts. |
| `OnLoadDocumentObject` | Laden von Dokumentobjekten. |
| `OnAfterLoadDocumentObject` | Nach dem Laden des Dokumentobjekts. |
| `OnLoadWebDocument` | Dokumentlastfluss. |
| `OnWebPagePrerender` | Vor dem Rendern der Webseitenausgabe. |
| `OnLoadWebPageCache` | Auslastung des Seiten-Cache. |
| `OnBeforeSaveWebPageCache` | Vor dem Speichern des Seitencaches. |
| `OnWebPageComplete` | Ende der Webseitenverarbeitung. |
| `OnParseDocument` | Hook zum Parsen von Dokumenten. |
| `OnBeforeParseParams` | Vor dem Parsen der Parameter. |
| `OnParseProperties` | Parsen von Eigenschaften. |
| `OnMakeDocUrl` | URL-Generierung. |
| `OnStripAlias` | Alias-Normalisierung. |
| `OnPageNotFound` | Nicht gefundene Handhabung. |
| `OnPageUnauthorized` | Unbefugter Umgang mit Seiten. |
| `OnLogPageHit` | Protokollierung von Seitenzugriffen. |
| `OnLogEvent` | Schreiben von Ereignisprotokollen. |
| `OnLoadSettings` | Laufzeiteinstellungen werden geladen. |
| `OnBeforeLoadExtension` | Erweiterung wird geladen. |
| `OnMakePageCacheKey` | Generierung des Seiten-Cache-Schlüssels. |

## Cache- und Site-Ereignisse

| Veranstaltung | Typischer Bereich |
| --- | --- |
| `OnBeforeCacheUpdate` | Vor dem Cache-Neuaufbau. |
| `OnCacheUpdate` | Nach dem Cache-Neuaufbau. |
| `OnSiteRefresh` | Manager Site-Aktualisierungsaktion. |

## Manager Shell-Ereignisse

| Veranstaltung | Typischer Bereich |
| --- | --- |
| `OnBeforeManagerPageInit` | Vor der Initialisierung der Managerseite. |
| `OnManagerPageInit` | Manager Seiteninitialisierung. |
| `OnManagerLoginFormPrerender` | Vor dem Rendern des Manager-Anmeldeformulars. |
| `OnManagerLoginFormRender` | Manager-Anmeldeformular rendern. |
| `OnManagerMenuPrerender` | Manager Menügenerierung. |
| `OnManagerMainFrameHeaderHTMLBlock` | Manager Main-Frame-Header-Injektion. |
| `OnManagerTopPrerender` | Oberer Rahmenputz. |
| `OnManagerFrameLoader` | Manager Rahmenlader. |
| `OnManagerWelcomePrerender` | Vorab-Rendering der Willkommensseite. |
| `OnManagerWelcomeHome` | Widgets/Inhalte der Willkommensseite. |
| `OnManagerWelcomeRender` | Rendern der Begrüßungsseite. |
| `OnManagerPreFrameLoader` | Vor der Ausgabe des Manager-Frameloaders. |
| `OnBeforeMinifyCss` | Manager CSS Minimierung. |

## Baum- und Resource-Ereignisse

| Veranstaltung | Typischer Bereich |
| --- | --- |
| `OnManagerTreeInit` | Manager-Bauminitialisierung. |
| `OnManagerTreePrerender` | Baum-Vorrenderer. |
| `OnManagerTreeRender` | Baum-Rendering. |
| `OnManagerNodePrerender` | Einzelner Knoten-Prerender. |
| `OnManagerNodeRender` | Individuelles Knoten-Rendering. |
| `OnDocFormPrerender` | Resource Formular-Prerender. |
| `OnDocFormRender` | Resource Formular-Rendering. |
| `OnDocFormTemplateRender` | Resource Formularvorlage rendern. |
| `OnBeforeDocFormSave` | Vor dem Ressourcensparen. |
| `OnDocFormSave` | Nach Ressourcenspeicherung. |
| `OnBeforeDocFormDelete` | Vor dem Löschen der Ressource. |
| `OnDocFormDelete` | Nach dem Löschen der Ressource. |
| `OnDocFormUnDelete` | Resource Wiederherstellung. |
| `OnDocPublished` | Resource veröffentlicht. |
| `OnDocUnPublished` | Resource unveröffentlicht. |
| `OnBeforeDocDuplicate` | Vor dem Duplizieren der Ressource. |
| `OnDocDuplicate` | Nach der Ressourcenduplizierung. |
| `onBeforeMoveDocument` | Vor der Ressourcenverschiebung. |
| `onAfterMoveDocument` | Nach Ressourcenverschiebung. |
| `OnBeforeEmptyTrash` | Vor leerem Müll. |
| `OnEmptyTrash` | Nach leerem Müll. |

## Elementereignisse| Veranstaltungsgruppe | Veranstaltungen |
| --- | --- |
| Vorlagen | `OnTempFormPrerender`, `OnTempFormRender`, `OnBeforeTempFormSave`, `OnTempFormSave`, `OnBeforeTempFormDelete`, `OnTempFormDelete` |
| Template Variables | `OnTVFormPrerender`, `OnTVFormRender`, `OnBeforeTVFormSave`, `OnTVFormSave`, `OnBeforeTVFormDelete`, `OnTVFormDelete` |
| Chunks | `OnChunkFormPrerender`, `OnChunkFormRender`, `OnBeforeChunkFormSave`, `OnChunkFormSave`, `OnBeforeChunkFormDelete`, `OnChunkFormDelete` |
| Snippets | `OnSnipFormPrerender`, `OnSnipFormRender`, `OnBeforeSnipFormSave`, `OnSnipFormSave`, `OnBeforeSnipFormDelete`, `OnSnipFormDelete` |
| Plugins | `OnPluginFormPrerender`, `OnPluginFormRender`, `OnBeforePluginFormSave`, `OnPluginFormSave`, `OnBeforePluginFormDelete`, `OnPluginFormDelete` |
| Modules | `OnBeforeModFormSave`, `OnModFormSave`, `OnModFormPrerender`, `OnModFormRender`, `OnBeforeModFormDelete`, `OnModFormDelete` |
| Rich-Text-Editor | `OnRichTextEditorRegister`, `OnRichTextEditorInit` |

## Benutzer- und Berechtigungsereignisse

| Veranstaltung | Typischer Bereich |
| --- | --- |
| `OnBeforeManagerLogin` | Vor der Manager-Anmeldung. |
| `OnManagerAuthentication` | Manager-Authentifizierung. |
| `OnManagerLogin` | Manager-Anmeldung abgeschlossen. |
| `OnBeforeManagerLogout` | Vor der Abmeldung des Managers. |
| `OnManagerLogout` | Manager-Abmeldung abgeschlossen. |
| `OnManagerSaveUser` | Manager Benutzer gespeichert. |
| `OnManagerDeleteUser` | Manager-Benutzer gelöscht. |
| `OnManagerChangePassword` | Manager Passwortänderung. |
| `OnManagerCreateGroup` | Manager-Gruppe erstellt. |
| `OnBeforeWebLogin` | Vor der Webbenutzeranmeldung. |
| `OnWebAuthentication` | Authentifizierung von Webbenutzern. |
| `OnWebLogin` | Die Anmeldung des Webbenutzers ist abgeschlossen. |
| `OnBeforeWebLogout` | Vor der Abmeldung des Webbenutzers. |
| `OnWebLogout` | Die Abmeldung des Webbenutzers ist abgeschlossen. |
| `OnWebSaveUser` | Webbenutzer gespeichert. |
| `OnWebChangePassword` | Änderung des Webbenutzer-Passworts. |
| `OnUserFormPrerender` | Vorabrendern des Benutzerformulars. |
| `OnUserFormRender` | Rendern des Benutzerformulars. |
| `OnBeforeUserSave` | Vor dem Speichern durch den Benutzer. |
| `OnUserSave` | Nach dem Speichern durch den Benutzer. |
| `OnUserChangePassword` | Änderung des Benutzerpassworts. |
| `OnBeforeUserDelete` | Vor dem Löschen durch den Benutzer. |
| `OnUserDelete` | Nach dem Löschen durch den Benutzer. |
| `OnBeforeWUsrFormDelete` | Vor dem Löschen des Webbenutzers. |
| `OnWUsrFormDelete` | Nach dem Löschen des Webbenutzers. |
| `OnWebDeleteUser` | Webbenutzer gelöscht. |
| `OnWebCreateGroup` | Webgruppe erstellt. |
| `OnCreateDocGroup` | Dokumentengruppe erstellt. |

## Systemeinstellungsereignisse

| Veranstaltung | Einstellungsbereich |
| --- | --- |
| `OnSiteSettingsRender` | Registerkarte „Allgemeine Einstellungen“. |
| `OnFriendlyURLSettingsRender` | Registerkarte „Freundliche URLs“. |
| `OnUserSettingsRender` | Registerkarte „Einstellungen für E-Mail-/Benutzervorlagen“. |
| `OnInterfaceSettingsRender` | Registerkarte „Schnittstelleneinstellungen“. |
| `OnSecuritySettingsRender` | Registerkarte „Sicherheitseinstellungen“. |
| `OnFileManagerSettingsRender` | Registerkarte „Datei Manager-Einstellungen“. |
| `OnMiscSettingsRender` | Registerkarte „Dateibrowser/Verschiedene Einstellungen“. |

## Dateibrowser-Ereignisse

| Veranstaltungsgruppe | Veranstaltungen |
| --- | --- |
| Dateibrowser-Init | `OnFileBrowserInit` |
| Hochladen | `OnBeforeFileBrowserUpload`, `OnFileBrowserUpload`, `OnFileManagerUpload` |
| Umbenennen | `OnBeforeFileBrowserRename`, `OnFileBrowserRename` |
| Löschen | `OnBeforeFileBrowserDelete`, `OnFileBrowserDelete` |
| Kopieren | `OnBeforeFileBrowserCopy`, `OnFileBrowserCopy` |
| Verschieben | `OnBeforeFileBrowserMove`, `OnFileBrowserMove` |

## Dokumentationsregel

Ereignisdokumente sollten die aufrufende Quelle und Nutzlast erst nach Überprüfung enthalten
die aktuelle Anrufstelle. Diese Seite benennt die Ereignisoberfläche; detaillierte Nutzlast
Verträge gehören in Folgereferenzseiten.
