# Core Composer-Referenz

[Zurück](configuration-runtime.md) / [Nach oben](../README.md) / [Weiter](legacy-compatibility.md)

Evolution CMS verwendet eine Composer-Datei auf Projektebene und eine Composer-Kerndatei. Die
Die Kerndatei Composer ist die Hauptlaufzeitabhängigkeitsgrenze für eine installierte Datei
Evolution CMS-Projekt.

## Composer-Dateien

| Datei | Verantwortung |
| --- | --- |
| `composer.json` | Projekt-/Root-Paket-Metadaten, PHP-Basislinie, minimale Plattformerweiterungen und Projektanalyseskript. |
| `core/composer.json` | Hauptlaufzeitabhängigkeiten, Autoload-Regeln, Composer-Plugin-Konfiguration, Paketerkennungsskripte und Testtools. |
| `core/custom/composer.json` | Projektspezifischer Erweiterungspunkt, der vom Kern-Merge-Plugin Composer zusammengeführt wird, sofern vorhanden. |

Die Stammdatei Composer beschreibt das Projektpaket. Die Laufzeitabhängigkeit
Graph steht unter `core/composer.json`.

## Metadaten des Laufzeitpakets

| Feld | Aktueller Wert |
| --- | --- |
| Paket | `evolution-cms/evolution` |
| Geben Sie | ein `project` |
| Version | `3.5.7` |
| Lizenz | `GPL-3.0-or-later` |
| PHP-Basislinie | `^8.3` |
| Anbieterverzeichnis | `vendor` innerhalb von `core/` |
| Mindeststabilität | `dev` |
| Bevorzugen Sie stabile | `true` |

## Laufzeitabhängigkeitsgruppen

| Gruppe | Pakete |
| --- | --- |
| Composer/runtime | `composer/composer`, `wikimedia/composer-merge-plugin` |
| Framework-Komponenten | Beleuchten Sie Cache, Konfiguration, Konsole, Container, Datenbank, Ereignisse, Dateisystem, HTTP, Protokoll, Paginierung, Warteschlange, Redis, Routing, Unterstützung, Übersetzung, Validierung, Ansicht |
| Datenbank und Migrationen | `doctrine/dbal`, PDO Erweiterungen |
| HTTP und Integration | `guzzlehttp/guzzle`, `symfony/process` |
| Umgebung und Konfiguration | `vlucas/phpdotenv`, `phpoption/phpoption` |
| E-Mail | `phpmailer/phpmailer` |
| Sitzungen und Redis | `predis/predis`, `dmitry-suffi/redis-session-handler` |
| Medien und Feeds | `james-heinrich/phpthumb`, `rosell-dk/webp-convert`, `simplepie/simplepie` |
| Dateisystem | `league/flysystem` |
| Debuggen | `tracy/tracy` |
| Terminplanung | `dragonmantank/cron-expression` |
| Symbole | `secondnetwork/blade-tabler-icons` |
| Evolutionsdienste | `evolutioncms-services/document-manager`, `evolutioncms-services/user-manager` |

Zu den Plattformerweiterungsanforderungen gehören gängige PHP-Erweiterungen wie `ctype`,
`dom`, `fileinfo`, `filter`, `hash`, `iconv`, `json`, `libxml`, `mbstring`,
`openssl`, `pcre`, `pdo`, `session`, `simplexml`, `tokenizer`, `xml`,
`xmlreader` und `zip`.

## Composer Zusammenführen Plugin

Die Kernkonfiguration Composer verwendet `wikimedia/composer-merge-plugin`, um Folgendes einzuschließen:

```text
custom/composer.json
```

Zusammenführungsverhalten:

| Option | Wert |
| --- | --- |
| `recurse` | `true` |
| `replace` | `true` |
| `merge-dev` | `false` |
| `merge-extra` | `true` |
| `merge-scripts` | `false` |

Verwenden Sie `core/custom/composer.json` für Pakete auf Projektebene, anstatt sie zu bearbeiten
direkt die Kernlaufzeitdatei Composer.

## Autoload-Regeln

| Autoload-Typ | Einträge |
| --- | --- |
| PSR-4 | `EvolutionCMS\\` bis `src/`, `Database\\Seeders\\` bis `database/seeders/` |
| Klassenplan | `database/migrations/` |
| Dateien | Kernaktionshelfer, Hilfsfunktionen, Laravel-Bridge-Funktionen, Knotenhelfer, Preload-Helfer, Prozessorhelfer und Dienstprogramme. |
| Entwickler PSR-4 | `Tests\\` bis `tests/` |

Die Datei-Autoload-Liste hält ältere Hilfs-/Aktionsfunktionen in der Datei verfügbar
moderne Laufzeit.

## Composer-Skripte

| Skript | Zweck |
| --- | --- |
| `sync-replace` | Führt den Versionsersetzungs-Synchronisierungshelfer aus. |
| `test` | Führt Schädlingstests durch. |
| `optimize` | Installiert Produktionsabhängigkeiten und erstellt optimierte autorisierende Autoload-Dumps. |
| `optimize-dev` | Installiert Entwicklungsabhängigkeiten und erstellt optimierte autorisierende Autoload-Dumps. |
| `upd` | Synchronisiert Ersatzversionen und aktualisiert die Sperrdatei. |
| `pre-install-cmd` | Führt vor der Installation eine Ersatzsynchronisierung durch. |
| `pre-update-cmd` | Führt vor dem Update eine Ersatzsynchronisierung durch. |
| `post-autoload-dump` | Führt `php artisan package:discover` aus. |

Die Paketerkennung ist Teil der Autoload-Generierung. Wenn Dienstleister bzw
Paketmetadaten werden nicht aktualisiert. Führen Sie Composer Autoload Dump aus und überprüfen Sie das Paket
Discovery-Ausgabe.

## Entwicklungstools

Zu den wichtigsten Entwicklungsabhängigkeiten gehören:

| Paket | Zweck |
| --- | --- |
| `pestphp/pest` | Testläufer. |
| `mockery/mockery` | Test verdoppelt. |
| `roave/security-advisories` | Blockiert bekanntermaßen anfällige Abhängigkeitsversionen. |

Die Root-Projektdatei Composer stellt auch ein PHPStan-Analyseskript für bereit
Projektebene.

## Dokumentationsregel

Bei der Dokumentation der Paketinstallation, der Composer-Anforderungen oder des Dienstes
Anbietererkennung, geben Sie an, welche Composer-Grenze verwendet wird: Root-Projekt,
Kernlaufzeit oder `core/custom/composer.json`.
