# Legacy-Kompatibilitätsreferenz

[Zurück](core-composer.md) / [Nach oben](../README.md) / [Weiter](artisan-commands.md)

Evolution CMS behält eine Legacy-Kompatibilitätsebene bei, damit der aktuelle Code sie unterstützen kann
klassische Evolution-APIs, Parserverhalten, Manageraktionen und ältere Erweiterungen
Muster, während die Laufzeit moderne PHP- und Illuminate-Komponenten verwendet.

## Legacy-Quellebene

| Datei oder Klasse | Verantwortung |
| --- | --- |
| `core/includes/legacy.inc.php` | Bootstrap-Integration für Legacy-Kompatibilität. |
| `Legacy/DeprecatedCore.php` | Veraltetes Kernkompatibilitätsverhalten. |
| `Legacy/ManagerApi.php` | Manager-Aktion/API-Kompatibilitätsoberfläche. |
| `Legacy/TemplateParser.php` | Kompatibilität mit Vorlagenparsern. |
| `Legacy/Modifiers.php` | Unterstützung für Parser-Modifikatoren und bedingte Modifikatoren. |
| `Legacy/Phx.php` | Platzhalter-/Modifikatorkompatibilität im PHx-Stil. |
| `Legacy/Cache.php` | Verhalten beim Wiederherstellen/Aktualisieren des alten Caches. |
| `Legacy/Permissions.php` | Verhalten bei der Benutzer-/Dokumentberechtigungskompatibilität. |
| `Legacy/ErrorHandler.php` | Legacy-Fehlerbehandlung. |
| `Legacy/LogHandler.php` | Legacy-Protokollierungsverhalten. |
| `Legacy/PasswordHash.php` | Kompatibilität mit Legacy-Passwort-Hashing. |
| `Legacy/PhpCompat.php` | PHP-Kompatibilitätshilfen. |
| `Legacy/Categories.php` | Verhalten bei der Kategoriekompatibilität. |
| `Legacy/ModuleCategoriesManager.php` | Module-Kategoriekompatibilitätsverhalten. |
| `Legacy/mgrResources.php` | Manager Ressourcen-/Element-Helper-Kompatibilität. |

## Legacy-Anbieter

Die Anwendungsanbieterliste registriert Kompatibilitätsanbieter für veraltete Anwendungen
Kernverhalten, DB API, Manager API, Modifikatoren, Passwort-Hashing, PHx,
DLTemplate, ModResource, ModUsers, Dateisystem-Helfer und zugehörige Unterstützung.

Diese Anbieter halten klassische APIs verfügbar, während neuerer Code aktuelle verwendet
Dienste, Modelle, Controller und Fassaden.

## Legacy-Includes und -Helfer

Core Composer lädt automatisch Hilfs-/Aktionsdateien, die ältere funktionsbasierte Dateien beibehalten
Oberflächen:

| Bereich | Automatisch geladene Dateien |
| --- | --- |
| Manager Aktionshelfer | `functions/actions/*.php` für Dateimanager, Einstellungen, Inhaltsänderung, Plugins, Protokollierung, Hilfe und Verhalten des Backup-Managers. |
| Laufzeithelfer | `functions/helper.php`, `functions/laravel.php`, `functions/utils.php` |
| Baum und Knoten | `functions/nodes.php` |
| Vorspannung und Prozessoren | `functions/preload.php`, `functions/processors.php` |

Neuer Code sollte aktuelle Dienste und Modelle bevorzugen, die Dokumentation jedoch muss
erkennen, dass diese Funktionsflächen noch existieren.

## Legacy-Manager-Aktionen

Der Manager enthält weiterhin Aktionshandler und Prozessoren:

| Oberfläche | Zweck |
| --- | --- |
| `core/factory/actionlist.php` | Legacy-Aktions-ID-Karte. |
| `manager/actions/` | Legacy- und dynamische Seiten-/Aktionshandler. |
| `manager/processors/` | Mutierende Prozessoren zum Speichern, Löschen, Veröffentlichen, Zwischenspeichern, Einstellungen, Rollen, Modulen, Benutzern und Elementen. |
| `ManagerTheme` | Behebt das Verhalten aktiver Aktionen/Controller und Manager-Designs. |
| Modellaktionskarten | Stellen Sie Aktions-IDs zum Bearbeiten/Neuen/Speichern/Löschen/Ausführen für modellgestützte Bildschirme bereit. |

Validieren Sie beim Dokumentieren einer Managerfunktion die Aktions-ID, den Controller/die Aktion
Datei, Prozessor und Blade-Ansicht zusammen.

## Parser-Kompatibilität

Klassische Parserfunktionen bleiben Teil der aktuellen Laufzeit:

| Funktion | Notizen |
| --- | --- |
| Resource-Tags | Syntax der Felder `[*field*]` und TV. |
| Einstellungs-Tags | `[(setting)]`. |
| Chunks und Schnipsel | `{{chunk}}`, `[[snippet]]` und `[!snippet!]`. |
| Platzhalter | `[+placeholder+]` mit PHx/Modifikatorverhalten. |
| URL-Tags | `[~id~]`. |
| Bedingte Tags | `<@IF:...>`, `<@ELSEIF:...>`, `<@ELSE>`, `<@ENDIF>`. |
| Vorlagenmodi | `@CODE`, `@FILE`, `@DOCUMENT`, `@B_FILE` und `@B_CODE`. |

Verwenden Sie [Parser-Tags-Referenz](parser-tags.md) für Syntaxdetails.

## Was man nicht blind migrieren sollte

Kopieren Sie keine alten Komponentenhandbücher in die Produktdokumentation, nur weil die
Die Legacy-Schicht ist noch vorhanden. Alte Komponenten, alte Snippets und ältere Site-Building
Muster sollten im Legacy-Archiv verbleiben, es sei denn, sie werden anhand des validiert
aktuellen Code und stellen weiterhin eine empfohlene Verwendung dar.

Installierte Extras stellen ihre eigenen Dokumente als separate dDocs-Quellen bereit.

## DokumentationsregelWenn Sie Legacy-Verhalten dokumentieren, kennzeichnen Sie es als Kompatibilität, es sei denn, dies ist der Fall
Empfohlener aktueller Pfad. Kombinieren Sie Legacy-Ansprüche mit aktuellen Code-Referenzen und
Vermeiden Sie es, alte APIs in neue Best-Practice-Beispiele umzuwandeln.
