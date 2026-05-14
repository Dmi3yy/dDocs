# Installation

[Zurück](requirements.md) / [Nach oben](README.md) / [Weiter](core-concepts.md)

Der derzeit empfohlene Installationspfad ist der eigenständige Installationspfad Evolution CMS
Installationspaket. Der alte Web-Installer ist weiterhin im Core-Checkout vorhanden.
Die moderne Dokumentation sollte jedoch zuerst den eigenständigen `evo`-Workflow lehren.

## Installieren Sie das Installationsprogramm

Installieren Sie das Installationsprogramm global mit Composer:

```bash
composer global require evolution-cms/installer
```

Stellen Sie sicher, dass das globale bin-Verzeichnis Composer in `PATH` verfügbar ist, und überprüfen Sie dann Folgendes:

```bash
evo version
```

Beim ersten Start installiert der Bootstrapper PHP die passende Go-Binärdatei von GitHub
Gibt Prüfsummen frei, überprüft sie, speichert die Binärdatei neben dem Bootstrapper und
delegiert den Befehl an ihn.

Sie können die Binärdatei explizit vorinstallieren:

```bash
evo self-install
```

Aktualisieren Sie die Binärdatei des Installationsprogramms mit:

```bash
evo self-update
```

Führen Sie Folgendes aus, um die lokale Umgebung vor einer Installation zu überprüfen:

```bash
evo system-status
```

Der Statusbefehl gibt JSON für den Installationsadapter zurück. Es überprüft die
Betriebssystem, PHP-Version, Composer, PDO und Datenbanktreiber, JSON, MySQLi,
mbstring, cURL, Bildunterstützung, Speicherplatz und Speicherlimit.

## Erstellen Sie ein Projekt

Führen Sie das interaktive Installationsprogramm aus:

```bash
evo install
```

Das Installationsprogramm führt den Benutzer durch:

- Zielverzeichnis;
- Datenbankverbindung;
- Administratorkonto;
- Managerverzeichnis;
- Installationssprache;
- Projektvoreinstellung;
- optionale Extras-Auswahl.

Verwenden Sie den interaktiven Modus, wenn ein Mensch den Projektpfad, die Voreinstellung usw. auswählt.
Datenbank, Sprache und optional Extras. Verwenden Sie den CLI-Modus, wenn diese Antworten vorliegen
Dies ist im Voraus bekannt und die Installation sollte ohne TUI-Eingabeaufforderungen ausgeführt werden.

Für eine Skriptinstallation:

```bash
evo install demo \
  --cli \
  --branch=3.5.x \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-username=admin \
  --admin-email=admin@example.com \
  --admin-password=change-me \
  --admin-directory=manager \
  --language=uk \
  --preset=evolution-cms-presets/default
```

Für den CLI-Modus sind ein Datenbanktyp, ein Datenbankname, eine Administrator-E-Mail-Adresse und ein Administrator erforderlich
Passwort. Der Administrator-Benutzername lautet standardmäßig `admin`, das Manager-Verzeichnis lautet
`manager`, die Sprache auf `en` und die Voreinstellung auf `evolution`, wenn diese Werte vorliegen
sind nicht vorgesehen.

Die vollständige Optionsliste finden Sie in der [CLI-Referenz](../10-reference/cli-reference.md).

## Datenbankoptionen

Das Installationsprogramm unterstützt diese Datenbanktreiber mit der passenden Erweiterung PHP
ist verfügbar:

| Fahrer | Notizen |
| --- | --- |
| `sqlite` | Erfordert einen Datenbankdateinamen. Das Installationsprogramm speichert normalisierte SQLite-Namen im Projektdatenbankverzeichnis. |
| `mysql` | Erfordert Host, Datenbanknamen, Benutzer und Passwort im CLI-Modus, sofern die Standardeinstellungen nicht akzeptabel sind. |
| `pgsql` | Erfordert den Treiber PostgreSQL PDO und Verbindungsanmeldeinformationen. |
| `sqlsrv` | Erfordert den Treiber SQL Server PDO und Verbindungsanmeldeinformationen. |

Das Installationsprogramm testet die Datenbankverbindung, bevor es fortfährt. Interaktiv
Im Modus kann eine fehlgeschlagene Verbindung erneut versucht werden. Im CLI-Modus wird eine fehlgeschlagene Verbindung unterbrochen
die Installation.

## Voreinstellungen

Das Installationsprogramm trennt den Evolution CMS-Kern von der Projektschicht.

| Voreingestellter Eingang | Bedeutung |
| --- | --- |
| Wird im TUI-Modus weggelassen | Voreinstellungsoptionen aus dem öffentlichen Voreinstellungskatalog anzeigen. |
| `evolution` | Installieren Sie nur den Evolution-Kern. |
| `default` | Zum standardmäßigen öffentlichen Voreinstellungs-Repository auflösen. |
| `evolution-cms-presets/default` | Kopieren Sie die Standardprojektebene nach der Kerninstallation. |
| `owner/repository` | In ein GitHub-Repository auflösen. |
| Git URL oder lokaler Pfad | Verwenden Sie eine benutzerdefinierte voreingestellte Quelle. |

Die Voreinstellung definiert nicht die zukünftige Git-Identität der erstellten Site. Die
Das Zielverzeichnis kann zu einem eigenen Projekt-Repository werden.

Eine Voreinstellung kann ein Ref-Suffix enthalten, wenn ein nicht standardmäßiger Zweig oder Tag benötigt wird:

```bash
evo install demo --preset=evolution-cms-presets/default@dev
```

Voreinstellungen werden über den „core/artisan“ des installierten Projekts angewendet
Befehl „preset:install“, nachdem der Evolution CMS-Kern bereit ist, dann voreingestellt
Migrationen werden ausgeführt.

## Extras Während der Installation

Das Installationsprogramm kann Extras installieren, nachdem das Kernprojekt fertig ist:

```bash
evo install demo --extras=sTask,sSeo
```

Legacy Store-Pakete können bei Bedarf nach ID ausgewählt werden:

```bash
evo install demo --extras=legacy-store:84@1.12.2
```

Dokumentieren Sie die Installation alter Komponenten nicht als Standardpfad für die aktuelle
Projekte. Behalten Sie die Informationen zu Legacy-Komponenten im Legacy-Archiv, es sei denn, a
Das aktuelle Paket ersetzt es explizit.

Installierte Extras sollten ihre eigene Paketdokumentation bereitstellen. dDocs entdeckt
Diese Dokumente werden aus den installierten Paketquellen heruntergeladen und neben dem Produkt angezeigt
Dokumentation.

## Fehlerbehebung

| Problem | Prüfen |
| --- | --- |
| GitHub API Ratenbegrenzung | Legen Sie `GITHUB_TOKEN` fest oder übergeben Sie `--github-pat`. |
| Composer ist ein Shell-Alias ​​| Setzen Sie `EVO_COMPOSER_BIN` auf die echte ausführbare Datei Composer. |
| Binärdatei kann nicht installiert werden | Überprüfen Sie die Schreibberechtigungen für das Verzeichnis des Installationspakets `bin`. |
| Datenbankoption schlägt fehl | Führen Sie `evo system-status` aus und überprüfen Sie den passenden PDO-Treiber. |
| CLI-Modus wird vor der Installation beendet | Geben Sie `--db-type`, `--db-name`, `--admin-email` und `--admin-password` an. |
| Vorhandenes Projekt wurde erkannt | Verwenden Sie `--force` nur, wenn Sie absichtlich in ein vorhandenes Verzeichnis installieren möchten. |

## Legacy Web Installer-Grenze

Der Core-Checkout enthält weiterhin einen Web-Installer und ein CLI-Installationsskript. Behalten
diese Dokumente für Wartung, Kompatibilität und Installations-Debugging. Neuer Benutzer
Die Dokumentation sollte mit dem eigenständigen Installationsprogramm beginnen, es sei denn, es handelt sich um eine Aufgabe
insbesondere zum Verhalten älterer Webinstallationen.
