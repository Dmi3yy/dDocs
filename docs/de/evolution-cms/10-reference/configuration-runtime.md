# Referenz zur Konfigurationslaufzeit

[Zurück](source-inventory.md) / [Nach oben](../README.md) / [Weiter](core-composer.md)

Evolution CMS verfügt über zwei Konfigurationsebenen: Projekt-/Laufzeitdateien und Datenbank
Systemeinstellungen. Zuerst wird die Laufzeitkonfiguration gestartet, dann die Systemeinstellungen
wird von den Core- und Manager-Flows geladen.

## Ablauf der Initialisierung

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

## Projektkonfiguration

Die sechs Beispiele unten finden Sie im Quellcode von Evolution CMS im Branch `3.6.x`. Das Installationspaket enthält sie nicht. Öffnen Sie das passende Beispiel, kopieren Sie den Inhalt in die angegebene Datei relativ zum Projektstamm und ersetzen Sie die Beispielwerte. Wenn die Datei schon vorhanden ist, ergänzen Sie nur die benötigten Einstellungen oder den benötigten Code.

| Beispiel im Branch `3.6.x` | Datei im Projekt | Was Sie ändern |
| --- | --- | --- |
| [`.env.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.example) | `core/custom/.env` | Tragen Sie die Verbindungsdaten Ihrer Datenbank ein. Ergänzen Sie bei Bedarf Einstellungen für die Domain oder den Manager. Wenn Ihr Projekt bereits eine `.env` im Projektstamm verwendet, ergänzen Sie die Einstellungen dort. |
| [`.env.docker.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.docker.example) | Zum Beispiel `core/custom/.env.docker` | Ersetzen Sie die Beispielwerte für `DB_USERNAME`, `DB_PASSWORD` und `DB_DATABASE`. Binden Sie die Datei in Docker Compose über `env_file` in den CMS-Dienst ein. Läuft die Datenbank in einem eigenen Dienst, verwenden Sie dessen Namen als `DB_HOST`. Das CMS lädt `.env.docker` nicht automatisch. |
| [`define.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/define.php.example) | `core/custom/define.php` | Ein Kommentar im Beispiel listet die verfügbaren Konstanten auf. Überschreiben Sie die benötigten Konstanten mit `define()`, zum Beispiel `define('EVO_SITE_HOSTNAMES', 'example.com,www.example.com');`, und setzen Sie die Domains Ihrer Website ein. |
| [`routes.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/routes.php.example) | `core/custom/routes.php` | Ersetzen Sie die Beispielroute `/helloworld` durch Ihren eigenen Pfad und Handler. Die Anleitung zeigt, wie Sie eine Route für ein Formular anlegen. [Formulare mit eigenen Routen](../08-tutorials-recipes/forms-with-custom-routes.md) |
| [`ControllerNamespace.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings/ControllerNamespace.php.example) | `core/custom/config/cms/settings/ControllerNamespace.php` | Geben Sie den Namespace Ihrer Controller als Zeichenkette mit einem abschließenden Backslash zurück. Verwenden Sie den Namespace, in dem Ihr `BaseController` automatisch geladen wird. |
| [`settings.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings.php.example) | `core/custom/config/cms/settings.php` | Geben Sie ein Array zurück, das nur die zu überschreibenden Einstellungen enthält. Setzen Sie beispielsweise `site_name` auf den Namen Ihrer Website. |

Speichern Sie echte Passwörter in lokalen Umgebungsdateien oder übergeben Sie sie über die Laufzeitumgebung. Nehmen Sie sie nicht in Git auf.

Weitere Beispiele unter `core/custom/` sind `composer.json.example` für Projektabhängigkeiten und `config/middleware.php.sample` für eigene Middleware-Aliase und -Gruppen.

### Dateien über die Konsole anlegen

Führen Sie den gewünschten Befehl in Bash im Projektstamm aus. Jeder Block funktioniert eigenständig und überspringt eine vorhandene Datei. Passen Sie nach dem Download die Beispielwerte anhand der Tabelle an. Wenn das Projekt bereits eine `.env` im Projektstamm verwendet, ergänzen Sie die benötigten Variablen dort.

`.env`

```bash
(
  target=core/custom/.env
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/.env.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`.env.docker`

```bash
(
  target=core/custom/.env.docker
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/.env.docker.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`define.php`

```bash
(
  target=core/custom/define.php
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/define.php.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`routes.php`

```bash
(
  target=core/custom/routes.php
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/routes.php.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`ControllerNamespace.php`

```bash
(
  target=core/custom/config/cms/settings/ControllerNamespace.php
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/config/cms/settings/ControllerNamespace.php.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`settings.php`

```bash
(
  target=core/custom/config/cms/settings.php
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/config/cms/settings.php.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

Für die Arbeit mit einem Agenten können Sie auch `AGENTS.md` in den Projektstamm herunterladen und Ihre eigenen Projektregeln ergänzen. Die PHP-Modelle des Kerns sind bereits im Installationspaket unter `core/src/Models/` enthalten. [Modellreferenz](models.md) · [Quellcode der Modelle](https://github.com/evolution-cms/evolution/tree/3.6.x/core/src/Models)

```bash
(
  target=AGENTS.md
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/AGENTS.md' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

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
