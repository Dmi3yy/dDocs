# Artisan-Befehlsreferenz

[Zurück](legacy-compatibility.md) / [Nach oben](../README.md) / [Weiter](models.md)

Auf dieser Seite wird die Befehlsoberfläche des installierten Projekts Artisan dokumentiert, die von registriert wurde
der aktuelle Evolution CMS-Kern. Es ist vom eigenständigen Installationsprogramm getrennt
`evo`-Befehl dokumentiert in [CLI-Referenz](cli-reference.md).

## Konsolenlaufzeit

Evolution CMS verwendet eine benutzerdefinierte Konsolenanwendung, die:

- verwendet die Versionsdaten Evolution CMS als Namen der Konsolenanwendung;
– deaktiviert den automatischen Exit und das Abfangen von Ausnahmen;
– erstellt ein Anforderungsobjekt aus der konfigurierten Site-URL für den Konsolenkontext;
- löst das Startereignis Artisan aus;
– Lädt verzögerte Anbieter und Bootstraps-Befehle.

Führen Sie diese Befehle im `core/`-Laufzeitkontext eines installierten Projekts aus, es sei denn, a
Der Befehl akzeptiert explizit einen Zielpfad.

## Cache und Ansichten

| Befehl | Zweck |
| --- | --- |
| `cache:clear` | Löschen Sie den konfigurierten Illuminate-Cache-Speicher. |
| `cache:forget` | Entfernen Sie einen Schlüssel aus dem konfigurierten Cache-Speicher. |
| `cache:clear-full` | Kompilierten Blade/View-Cache plus Evolution-Cache-Oberflächen löschen. |
| `clear-compiled` | Entfernen Sie die kompilierte Klassendatei. |
| `view:clear` | Kompilierte Blade-Ansichtsdateien löschen. |

## Datenbank und Seeder

| Befehl | Zweck |
| --- | --- |
| `migrate` | Führen Sie Datenbankmigrationen durch. |
| `migrate:fresh` | Löschen Sie alle Tabellen und führen Sie die Migrationen erneut aus. |
| `migrate:install` | Erstellen Sie das Migrations-Repository. |
| `migrate:refresh` | Migrationen zurücksetzen und erneut ausführen. |
| `migrate:reset` | Machen Sie alle Migrationen rückgängig. |
| `migrate:rollback` | Setzen Sie den letzten Migrationsbatch zurück. |
| `migrate:status` | Migrationsstatus anzeigen. |
| `make:migration` | Erstellen Sie eine Migrationsdatei. Entwicklungskommando. |
| `db:seed` | Führen Sie Sämaschinen aus. |

Behandeln Sie destruktive Migrationsbefehle als Betriebsaufgaben. Sie können Daten zerstören
wenn es mit der falschen Datenbank ausgeführt wird.

## Listen und Diagnose

| Befehl | Zweck |
| --- | --- |
| `doc:list` | Listen Sie Dokumente/Ressourcen von `site_content` auf. |
| `tpl:list` | Listenvorlagen von `site_templates`. |
| `tv:list` | Liste Template Variables. |
| `deprecated:list` | Listen Sie veraltete Markierungen und optionale Entfernungs-/Versions-Tags auf. Entwicklungskommando. |
| `route:list` | Registrierte Routen auflisten. |

Diese Befehle sind für die Dokumentationsvalidierung nützlich, da sie offenlegen
aktuelle Laufzeitobjekte, ohne auf alte Handbücher angewiesen zu sein.

## Pakete und Extras

| Befehl | Unterschrift | Zweck |
| --- | --- | --- |
| `package:discover` | `package:discover` | Generieren Sie Dienstanbieter-Erkennungsdaten für benutzerdefinierte Pakete. |
| `package:create` | `package:create {packagename?}` | Erstellen Sie ein Paketgerüst. |
| `package:runconsoles` | `package:runconsoles` | Führen Sie Konsolenbefehle aus benutzerdefinierten Paketen aus. |
| `package:installrequire` | `package:installrequire {key} {value} {composer_run=1}` | Fügen Sie den benutzerdefinierten Paketanforderungen eine Composer-Anforderung hinzu. |
| `package:removerequire` | `package:removerequire {key} {composer_run=1}` | Entfernen Sie eine Composer-Anforderung aus den benutzerdefinierten Paketanforderungen. |
| `package:installautoload` | `package:installautoload {key} {value} {composer_run=1}` | Fügen Sie den benutzerdefinierten Paketanforderungen einen Autoload-Eintrag hinzu. |
| `extras` | `extras {typePackage?} {packageName?} {versionPackage?} {namePackage?} {--list} {--json}` | Durchsuchen oder installieren Sie Extras/packages je nach Argumenten. |

Installierte Extras sollten ihre paketspezifischen Befehle in ihrem Dokument dokumentieren
eigene Paketdokumente. Diese Seite dokumentiert die Kernbefehlsoberfläche, die erkennt
und verwaltet Pakete.

## Voreinstellungen

| Befehl | Zweck |
| --- | --- |
| `preset:install` | Installieren Sie eine Voreinstellung aus einem Git-Repository oder einem lokalen Pfad. |
| `preset:apply` | Wenden Sie eine voreingestellte Projektebene auf eine Evolution CMS-Installation an. |

`preset:apply` unterstützt Optionen für Zielpfad, Quellpfad, Git Quelle/Referenz,
Beibehalten geklonter Quellen, voreingestellter Name, Löschen von Dateien, die in der Voreinstellung fehlen,
Trockenlaufmodus, erzwungene Sämaschinen und Überspringen von Composer Dump-Autoload.

## Planung und Systemaufgaben| Befehl | Zweck |
| --- | --- |
| `schedule:list` | Geplante Befehle auflisten. |
| `schedule:run` | Führen Sie fällige geplante Befehle aus. |
| `schedule:work` | Führen Sie die Scheduler-Worker-Schleife aus. |
| `schedule:finish` | Markieren Sie eine geplante Veranstaltung als abgeschlossen. |
| `schedule:clear-cache` | Mutex-/Cache-Status des Schedulers löschen. |
| `schedule:test` | Testen Sie einen geplanten Befehl. |
| `system:scheduler-heartbeat` | Zeichnen Sie den Heartbeat-Status des Planers auf. |
| `system:task-worker` | Zeichnen Sie die Aktivität von Systemaufgabenarbeitern auf und bereiten Sie die Ausführung von Aufgaben in der Warteschlange vor. |

Systemtaskbefehle sind Befehle für Laufzeitoperationen. Produktionsdokumente sollten
Schließen Sie Prozessüberwachungs- und Protokollierungsrichtlinien ein, bevor Sie Always-On empfehlen
Arbeiter.

## Website- und Projektwartung

| Befehl | Zweck |
| --- | --- |
| `make:site` | Site-Objekte aus konfigurierten Quellen aktualisieren/erstellen. |
| `closuretable:rebuild` | Erstellen Sie die Abschlusstabelle des Ressourcenbaums neu. |
| `translations:sync` | Synchronisieren Sie Übersetzungsschlüssel mit der Standardsprachdatei. |
| `tailwind:build {package?} {--force}` | Kompilieren Sie Tailwind CSS für ein Paket, alle Pakete oder erzwingen Sie den Neuaufbau. |
| `vendor:publish` | Veröffentlichen Sie veröffentlichungsfähige Anbieter-Assets. Entwicklungskommando. |

`make:site` und `closuretable:rebuild` wirken sich auf den Laufzeitstatus aus. Verwenden Sie Backups und a
Informieren Sie sich über den bekannten Bereitstellungsablauf, bevor Sie sie in der Produktion ausführen.

## Entwicklungsbefehle

Zu den Entwicklungsbefehlen gehören `vendor:publish`, `deprecated:list` und
`make:migration`. Sie sind vom selben Dienstanbieter registriert, sollten es aber sein
als Entwicklungs-/Wartungstools dokumentiert, nicht als normale Manager-Workflows.

## Dokumentationsregel

Wenn Sie einen Befehl dokumentieren, schließen Sie Folgendes ein:

- Befehlsname/Signatur;
- Laufzeitkontext;
– ob es den Projektstatus liest oder ändert;
- ob es für die Produktion sicher ist;
- Zugehörige Konfiguration oder Composer-Grenze.

Dokumentieren Sie in dieser Produktreferenz kein paketspezifisches Befehlsverhalten
es sei denn, der Befehl wird vom Evolution CMS-Kern registriert.
