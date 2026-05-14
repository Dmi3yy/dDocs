# Referenz zur Konfigurationslaufzeit

[Zurück](source-inventory.md) / [Nach oben](../README.md) / [Weiter](core-composer.md)

Evolution CMS verfügt über zwei Konfigurationsebenen: Projekt-/Laufzeitdateien und Datenbank
Systemeinstellungen. Zuerst wird die Laufzeitkonfiguration gestartet, dann die Systemeinstellungen
wird von den Core- und Manager-Flows geladen.

## Bootstrap-Flow

| Schritt | Laufzeitverhalten |
| --- | --- |
| Composer Autoload | `core/bootstrap.php` lädt `core/vendor/autoload.php`. |
| Zeitstempel installieren | `EVO_INSTALL_TIME` wird aus `core.install` gelesen, sofern vorhanden. |
| Umgebungslader | Der Umgebungs-Cache-Loader versucht, `.env`-Werte mit einem generierten PHP-Cache zu laden. |
| Benutzerdefinierte Definitionen | `core/custom/define.php` wird geladen, sofern vorhanden. |
| Kerndefinitionen | `core/includes/define.inc.php` definiert Kernpfade und Konstanten. |
| Sitzungsflag | `EVO_SESSION` wird aus der Umgebung gelesen und ist standardmäßig aktiviert. |
| Sitzungsproxy | `core/functions/session_proxy.php` verbindet Sitzungskompatibilität. |
| Legacy umfasst | `core/includes/legacy.inc.php` lädt das Kompatibilitätsverhalten. |
| Schutz | `core/includes/protect.inc.php` verschärft den direkten Zugriff. |
| Sitzungsstart | Manager/Parser-Anfragen starten die CMS-Sitzung, sofern sie nicht durch den Kontext deaktiviert sind. |

Der Bootstrap muss tolerant bleiben. Wenn das Laden des Umgebungscache fehlschlägt, wird der
Die Laufzeit greift auf das direkte Laden von Dotenv zurück.

## Umgebungsdateien

Reihenfolge der Umgebungssuche:

1. `core/custom/.env`
2. `.env` im Projektstammverzeichnis

Die Umgebungs-Cache-Datei lautet:

```text
core/storage/cache/env.php
```

Der Cache ist gültig, wenn seine Änderungszeit neuer oder gleich dem ist
ausgewählte `.env`-Datei. Wenn es veraltet ist, analysiert der Loader `.env`, wendet Werte an,
und schreibt atomar einen neuen PHP-Array-Cache.

## Umgebungs-Cache-Regeln

| Regel | Verhalten |
| --- | --- |
| Unveränderliche Last | Vorhandene Werte in `$_ENV` oder `$_SERVER` werden nicht überschrieben. |
| Legacy-`getenv()`-Unterstützung | `putenv()` wird nur aufgerufen, wenn der OS/Env-Wert fehlt. |
| Nullwerte | Aus dem generierten Cache gelöscht. |
| Leere Zeichenfolgen | Als reale Werte erhalten. |
| Cache schreiben | Schreibt mit einer Sperre in eine temporäre Datei und benennt sie dann an der entsprechenden Stelle um. |
| Fehlerverhalten | Ausfälle werden verschluckt und wenn möglich wird die direkte Dotenv-Belastung verwendet. |

Leeren Sie den Cache, nachdem Sie zwischengespeicherte `.env`- oder Laufzeitkonfigurationswerte geändert haben
durch das Projekt.

## Kernkonfigurationsdateien

| Datei | Verantwortung |
| --- | --- |
| `core/config/app.php` | Anbieter, Aliase, Middleware-Gruppen, Anwendungsgebietsschema, Fallback-Gebietsschema. |
| `core/config/cache.php` | Cache-Speicher und Cache-Verhalten. |
| `core/config/database.php` | Datenbankmanager und Redis-Baseline. |
| `core/config/database/default.php` | Standardkonfiguration der Datenbankverbindung. |
| `core/config/database/migrations.php` | Konfiguration des Migrations-Repositorys. |
| `core/config/filesystems.php` | Dateisystemfestplatten und Speicherwurzeln. |
| `core/config/logging.php` | Protokollierungskanäle und Protokollverhalten. |
| `core/config/session.php` | Sitzungstreiber und Sitzungsoptionen. |
| `core/config/tracy.php` | Tracy/Debug-Integration. |
| `core/config/view.php` | Pfade anzeigen, kompilierter Blade-Pfad und Callback-Konfiguration für Legacy-Anweisungen. |
| `core/config/blade-icons.php` | Blade-Symbolkonfiguration. |
| `core/config/cms/observers.php` | Modellbeobachterverkabelung. |

## Benutzerdefinierte Projektebene

Projektüberschreibungen live unter `core/custom/`. Aktuelle Beispiele sind:

| Datei | Zweck |
| --- | --- |
| `.env.example` | Projektumgebungsvorlage. |
| `.env.docker.example` | Docker-orientierte Umgebungsvorlage. |
| `define.php.example` | Benutzerdefinierte Konstantendefinitionen werden vor den Kerndefinitionen geladen. |
| `composer.json.example` | Der Erweiterungspunkt des Projekts Composer wurde durch das Kern-Setup Composer zusammengeführt. |
| `config/cms/settings.php.example` | Beispiel: Projekt-CMS-Einstellungen überschreiben. |
| `config/middleware.php.sample` | Beispiel für benutzerdefinierte Middleware-Aliase/Gruppen. |
| `routes.php.example` | Beispiel für die Registrierung einer Projektroute. |

Bearbeiten Sie keine Kernkonfigurationsdateien für ein reines Projektverhalten, wenn ein `core/custom`
Überschreibung vorhanden.

## Anbieter und Aliase

Die Liste der Anwendungsanbieter umfasst Illuminate-Dienste, Evolution-Dienste,
Legacy-Kompatibilitätsanbieter, Manager/Theme-Anbieter, Routing/Sitzung/System
Aufgabenanbieter, Blade-Anbieter und Dokument-/Benutzermanager-Dienstanbieter.

Kern-Aliase machen gängige Illuminate-Fassaden wie `Artisan`, `Cache`, `DB` verfügbar.
`Event`, `File`, `Log`, `Route`, `Session`, `Storage`, `View` und Evolution
Fassaden wie `ManagerTheme`, `UrlProcessor`, `TemplateProcessor`,
`DocumentManager`, `UserManager` und `Tailwind`.

## Middleware-Gruppen

| Gruppe | Verhalten |
| --- | --- |
| `mgr` | Sitzung, Sitzungsproxy, CSRF, Managerauthentifizierung, Routenbindungen, Fehler bei der gemeinsamen Ansicht. |
| `global` | Sitzung, Sitzungsproxy, Routenbindungen, Fehler bei gemeinsamer Ansicht. |
| `aliases` | `csrf`, `authtoken`, `managerauth` und `bindings`. |

Fügen Sie stattdessen benutzerdefinierte Middleware über die benutzerdefinierte Middleware-Konfiguration des Projekts hinzu
Ändern der Kern-Middleware-Liste.

## Systemeinstellungsgrenze

Laufzeitkonfigurationsdateien definieren das Framework- und Bootstrap-Verhalten. CMS-System
Einstellungen definieren das in der Datenbank gespeicherte Website-Verhalten, z. B. benutzerfreundliche URLs,
Vorlagen, Dateimanagerpfade, Cache-Standardeinstellungen und Manager-Benutzeroberflächeneinstellungen.

Verwenden Sie [Referenz zu Systemeinstellungen](system-settings.md) für datenbankgestütztes CMS
Einstellungen und diese Seite für Laufzeitkonfigurationsdateien, Umgebung, Anbieter, Aliase,
und Middleware.
