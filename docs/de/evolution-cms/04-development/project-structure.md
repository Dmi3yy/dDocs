# Projektstruktur

[Zurück](README.md) / [Nach oben](README.md) / [Weiter](../10-reference/cli-reference.md)

Diese Seite ordnet das aktuelle Evolution CMS-Repository der Dokumentation zu
Grenzen. Es wird erklärt, wo man suchen muss, bevor man Deeper Manager, API, Modell, schreibt.
oder Betriebsseiten.

## Top-Level-Layout

| Pfad | Verantwortung |
| --- | --- |
| `composer.json` | Composer-Metadaten auf Projektebene und grundlegende PHP-Anforderungen. |
| `index.php` | Öffentlicher Einstiegspunkt für Webanfragen. |
| `core/` | Hauptlaufzeit, Framework-Integration, Konfiguration, Datenbank, Konsole, Tests, Speicher und Quellcode. |
| `manager/` | Manager-Einstiegspunkt, Aktionen, Prozessoren, Ansichten, Includes und Manager-Medien. |
| `assets/` | Öffentliche Assets, hochgeladene Dateien, gebündelte Snippets/Plugins/Module/Templates/TV-Platzhalter, Cache, Backup-, Import- und Exportspeicherorte. |
| `views/` | Platzhalter für Projektansichtsebenen. |
| `install/` | Die veraltete Web-/CLI-Installationsoberfläche wird aus Kompatibilitäts- und Debugginggründen beibehalten. Neue Dokumente sollten zuerst den Standalone-Installer erlernen. |

## Kernlaufzeit

`core/` ist die Hauptlaufzeitgrenze.

| Pfad | Verantwortung |
| --- | --- |
| `core/composer.json` | Haupt-Laufzeitabhängigkeitssatz, einschließlich Illuminate-Komponenten, Datenbank, Routing, Ansicht, Cache, Warteschlange, E-Mail, Dateisystem, Tracy, Composer-Integration und Paketzusammenführungsverhalten. |
| `core/bootstrap.php` | Laufzeit-Bootstrap: Composer-Autoload, `.env`-Cache-Laden, benutzerdefinierte Definitionen, Kerndefinitionen, Sitzungen, Legacy-Includes und Schutz-Includes. |
| `core/config/` | Laufzeitkonfiguration für App, Cache, Datenbank, Dateisysteme, Protokollierung, Sitzung, Tracy, Ansichten, Symbole, Migrationen und Beobachterverkabelung. |
| `core/custom/` | Projektüberschreibungsschicht für Umgebungsbeispiele, benutzerdefinierte Composer-Anforderungen, Middleware, Definitionen und Routen. |
| `core/database/` | Migrationen, Seeder und Datenbankartefakte. |
| `core/factory/` | Laufzeitlisten auf Factory-Ebene wie Einstellungen und Manageraktionen. |
| `core/functions/` | Gemeinsam genutzte Funktionshelfer. |
| `core/includes/` | Kompatibilitäts-Includes und Laufzeit-Include-Dateien. |
| `core/lang/` | Kernsprachdateien. |
| `core/modifiers/` | Parser-/Modifikatorunterstützung. |
| `core/storage/` | Generierter Laufzeitspeicher und Cache. |
| `core/tests/` | Aktuelle Pest/PHPUnit-Testabdeckung für Installation, Manager, Kern, Support-Dienstprogramme, Paket/Laufzeit und Kompatibilitätsverhalten. |

## Quellebenen

`core/src/` ist die aktuelle Quellebene PHP.

| Schicht | Verantwortung |
| --- | --- |
| `Core.php` | Zentrales Laufzeitobjekt für Konfiguration, Parserausführung, Cache, Ereignisse, Laden von Dokumenten und Kompatibilitäts-APIs. |
| `Parser.php` | Parser-orientierte Dokumentwiedergabe und Kompatibilitätsablauf. |
| `UrlProcessor.php` | URL-Generierung und benutzerfreundliche URL-Auflösung. |
| `Bootstrap/` | Umgebungs- und Bootstrap-Helfer. |
| `Console/` | Artisan-Befehle für Cache, Ansichten, Pakete, Voreinstellungen, Routen, Planung, Site-Updates, Übersetzungen, Baumaktualisierungen und Systemaufgaben. |
| `Controllers/` | Manager Seiten-Controller und Ressourcen-/Benutzer-/Systembildschirme. |
| `Events/` | Kurse zur Veranstaltungsunterstützung. |
| `Exceptions/` | Laufzeitausnahmeklassen. |
| `Extensions/` | Kurse zur Erweiterungsunterstützung. |
| `Facades/` | Zugriffsfunktionen im Laravel-Stil für gemeinsam genutzte Dienste. |
| `Interfaces/` | Verträge für Manager-Theme- und Laufzeitabstraktionen. |
| `Legacy/` | Kompatibilitätsebene für ältere APIs und Parserverhalten. |
| `Middleware/` | HTTP- und Manager-Middleware. |
| `Models/` | Aussagekräftige Modelle für Ressourcen, Elemente, Benutzer, Berechtigungen, Einstellungen, Ereignisse, Planer-/Arbeiterstatus und Baumdaten. |
| `Observers/` | Modellbeobachterverkabelung. |
| `Providers/` | Dienstanbieter für Authentifizierung, Blade, Composer, Konfiguration, Datenbank, Ereignisse, Dateisystem, Manager-Theme, Pakete, Routing, Sitzungen, Aufgaben, Tracy, URL-Verarbeitung und mehr. |
| `Services/` | Serviceabläufe auf höherer Ebene, einschließlich Store-/Paket- und Systemtask-Services. |
| `Support/` | Utility-Klassen und Support-Helfer. |
| `Tracy/` | Integration des Debug-Panels. |
| `Traits/` | Gemeinsame Merkmale für Modelle und Laufzeitverhalten. |

## Manager Laufzeit

`manager/` ist die Manager-Benutzeroberfläche und Aktionsoberfläche.| Pfad | Verantwortung |
| --- | --- |
| `manager/actions/` | Legacy- und dynamische Manager-Aktionshandler. |
| `manager/processors/` | Speichern/Löschen/Veröffentlichen/Cache/Einstellungsprozessoren, die Managerdaten verändern. |
| `manager/views/` | Blade-Ansichten für Managerseiten, Teilseiten, Einstellungsbildschirme, Ressourcen, Module, Benutzer und Frames. |
| `manager/includes/` | Manager-Zugriffskontrolle, Konfigurationsprüfungen, Parser-Includes, Header, Debug-Helper und Legacy-Include-Grenzen. |
| `manager/media/` | Manager CSS, JS, Bilder, Browser-Assets und Themenmedien. |

Validieren Sie beim Dokumentieren des Managerverhaltens sowohl die Controller-/Quellklasse als auch
die Manageransicht oder der Prozessor, der die Aktion tatsächlich ausführt.

## Modelle und Elemente

Kerninhalte und Elementkonzepte werden Eloquent-Modellen zugeordnet:

| Konzept | Modell |
| --- | --- |
| Resource / Dokumentbaumknoten | `SiteContent` |
| Vorlage | `SiteTemplate` |
| Template Variable | `SiteTmplvar` |
| TV-Vorlagenbeziehung | `SiteTmplvarTemplate` |
| TV-Wert für eine Ressource | `SiteTmplvarContentvalue` |
| Chunk | `SiteHtmlsnippet` |
| Snippet | `SiteSnippet` |
| Plugin | `SitePlugin` |
| Plugin-Ereignisbeziehung | `SitePluginEvent` |
| Veranstaltungsname | `SystemEventname` |
| Module | `SiteModule` |
| Einstellungen | `SystemSetting` |
| Manager-Benutzer | `User` und `UserAttribute` |
| Berechtigungen und Gruppen | `Permissions`, `UserRole`, `DocumentGroup`, `DocumentgroupName` und verwandte Gruppenmodelle |

Eine ausführliche Dokumentation des feldweisen Modells gehört nicht zu API/Referenzseiten
in dieser Strukturübersicht.

## Paket- und Extra-Grenzen

Evolution CMS-Produktdokumente beschreiben die gemeinsam genutzten Laufzeit- und Erweiterungsverträge.
Installierte Extras besitzen eigene Funktionshandbücher. In dDocs befindet sich die Paketdokumentation
Aus dem Dateisystem-Dokumentenstammverzeichnis jedes installierten Pakets gelesen und daneben angezeigt
Produktbaum.

Dokumentieren Sie in diesem Produktbaum nur dann ein Extra, wenn die Seite eine Freigabe erklärt
Evolution CMS-Paketvertrag, Installationsprogrammverhalten oder Manager-Integrationsregel.

## Installer-Grenze

Das eigenständige Installationsprogramm ist der primäre aktuelle Installationsablauf. Es besitzt `evo
install`, `evo self-install`, `evo self-update`, and `evo system-status`.

Der Ordner `install/` des Repositorys bleibt aus Kompatibilitätsgründen wichtig.
Wartung, Installations-Stubs und Debugging, aber neue benutzerorientierte Installationsdokumente
sollte mit dem eigenständigen Installationsprogramm beginnen.

## Oberflächen testen

Aktuelle Tests live unter `core/tests/` und umfassen:

- Installations- und Migrationsverhalten;
- Manager-UI-Verträge und Zugriffsverhalten;
- Cache- und Site-Update-Befehle;
- Unterstützung von Dienstprogrammen und Pfadnormalisierung;
- Kompatibilitätsverhalten für ältere APIs;
- Paket-/Speicher-/System-Taskflows.

Wenn eine Dokumentationsseite das Laufzeitverhalten beschreibt, bevorzugen Sie einen aktuellen Code
Pfad plus einen vorhandenen Test als Validierung. Wenn kein Test vorliegt, dokumentieren Sie den Anspruch
Gehen Sie konservativ vor und kennzeichnen Sie eine tiefere Validierung als Folgearbeit.
