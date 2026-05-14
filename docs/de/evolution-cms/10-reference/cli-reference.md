# CLI Referenz

[Zurück](../07-security-updates-operations/troubleshooting.md) / [Nach oben](../README.md) / [Weiter](source-inventory.md)

Diese Seite ist eine kompakte Referenz für die aktuelle Befehlszeile Evolution CMS
Montageflächen. Verwenden Sie [Installation](../01-getting-started/installation.md)
für den geführten Installationsablauf.

## Installer-Befehle

| Befehl | Zweck |
| --- | --- |
| `evo install [dir] [flags]` | Installieren Sie ein Projekt. Lassen Sie `dir` im TUI-Modus weg, um es interaktiv auszuwählen. |
| `evo self-install` | Laden Sie die Installationsbinärdatei neben dem Bootstrapper PHP herunter und installieren Sie sie. |
| `evo self-update` | Aktualisieren Sie die Binärdatei des Installationsprogramms von der neuesten verfügbaren Version. |
| `evo system-status` | Drucken Sie den Systemstatus JSON für die Installationsdiagnose aus. |
| `evo version` | Drucken Sie die Installationsversion aus. |

## Flags installieren

| Flagge | Bedeutung |
| --- | --- |
| `-f`, `--force` | Installieren Sie es auch dann, wenn das Zielverzeichnis bereits existiert oder wie ein bestehendes Projekt aussieht. |
| `--branch=<name>` | Installieren Sie Evolution CMS von einem bestimmten Git-Zweig anstelle der neuesten kompatiblen Version. |
| `--preset=<spec>` | Wenden Sie nach der Kerninstallation eine Voreinstellung auf Projektebene an. |
| `--db-type=<driver>` | Datenbanktreiber: `mysql`, `pgsql`, `sqlite` oder `sqlsrv`. |
| `--db-host=<host>` | Datenbankhost für Nicht-SQLite-Installationen. |
| `--db-port=<port>` | Datenbankport. Wenn es weggelassen wird, verwendet das Installationsprogramm nach Möglichkeit die Treiberstandardeinstellung. |
| `--db-name=<name>` | Datenbankname oder SQLite-Datenbankdateiname. |
| `--db-user=<user>` | Datenbankbenutzername für Nicht-SQLite-Installationen. |
| `--db-password=<password>` | Datenbankkennwort für Nicht-SQLite-Installationen. |
| `--admin-username=<name>` | Ursprünglicher Benutzername des Manager-Administrators. |
| `--admin-email=<email>` | Erste E-Mail des Manager-Administrators. |
| `--admin-password=<password>` | Ursprüngliches Manager-Administratorkennwort. Im CLI-Modus muss es mindestens 6 Zeichen lang sein. |
| `--admin-directory=<dir>` | Manager Verzeichnisname. Standardmäßig ist `manager` im CLI-Modus. |
| `--language=<locale>` | Installationssprache, zum Beispiel `en` oder `uk`. |
| `--github-pat=<token>` | GitHub-Token für API-Anfragen und Vermeidung von Ratenbegrenzungen. |
| `--github_pat=<token>` | Alternative Schreibweise für die Token-Option GitHub. |
| `--extras=<list>` | Durch Kommas getrenntes Extras zur Installation nach dem Setup. |
| `--log` | Schreiben Sie die Protokollausgabe des Installationsprogramms in `log.md`. |
| `--cli` | Im nicht interaktiven CLI-Modus ausführen. |
| `--quiet` | Reduzieren Sie die Ausgabe von CLI auf Warnungen und Fehler. |
| `--composer-clear-cache` | Löschen Sie den Composer-Cache vor der Installation der Abhängigkeit. |
| `--composer-update` | Verwenden Sie beim Setup `composer update` anstelle von `composer install`. |

## CLI Modus Erforderliche Werte

CLI-Modus stellt keine Fragen. Geben Sie mindestens Folgendes an:

```bash
evo install demo \
  --cli \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-email=admin@example.com \
  --admin-password=change-me
```

Wenn es im CLI-Modus weggelassen wird, verwendet das Installationsprogramm standardmäßig Folgendes:

| Wert | Standard |
| --- | --- |
| Admin-Benutzername | `admin` |
| Manager-Verzeichnis | `manager` |
| Sprache | `en` |
| Voreinstellung | `evolution` |
| Nicht-SQLite-Host | `localhost` |
| Nicht-SQLite-Benutzer | `root` |

## Voreingestellte Spezifikationen

| Spezifikation | Auflösung |
| --- | --- |
| `evolution` | Nur-Core-Installation; Keine Voreinstellung auf Projektebene. |
| `default` | Öffentliches Standard-Preset-Repository. |
| `evolution-cms-presets/default` | GitHub-Repository unter der öffentlichen Preset-Organisation. |
| `owner/repository` | GitHub-Repository. |
| Git URL | Verwenden Sie direkt die bereitgestellte Repository-URL. |
| Lokaler Pfad | Verwenden Sie den lokalen voreingestellten Checkout und behalten Sie ihn als Quelle bei. |
| `spec@ref` oder `spec#ref` | Verwenden Sie einen bestimmten Zweig, ein bestimmtes Tag oder eine bestimmte Referenz. |

## Extras Syntax

| Syntax | Bedeutung |
| --- | --- |
| `--extras=sTask,sSeo` | Installieren Sie das verwaltete Extras nach Paketnamen. |
| `--extras=sTask@dev-main` | Installieren Sie ein verwaltetes Extra mit einer expliziten Versions- oder Zweigeinschränkung. |
| `--extras=legacy-store:84@1.12.2` | Installieren Sie ein Legacy Store-Paket nach Katalog-ID und Version. |

Die Extras-Dokumentation ist Eigentum des Pakets. Nach der Installation sollte dDocs erkennen
Sehen Sie sich die Dateisystemdokumentation jedes Pakets an und zeigen Sie sie im Dokumentationsbaum an.

## Systemstatusfelder

`evo system-status` gibt JSON mit einem Gesamtstatus und einzelnen Prüfungen zurück.
Zu den aktuellen Kontrollen gehören:

- Betriebssystem;
- PHP-Version;
- Composer Verfügbarkeit;
- PDO und Datenbanktreiber;
- JSON, MySQLi, mbstring, cURL;
- GD- oder Imagick-Bildunterstützung;
- Speicherplatz;
- Speicherlimit.

Warnungen bedeuten, dass die Installation je nach ausgewählter Datenbank möglicherweise trotzdem fortgesetzt wird
oder Funktion. Fehler bedeuten, dass in der Umgebung eine erforderliche Baseline fehlt.
