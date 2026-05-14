# Anforderungen

[Zurück](README.md) / [Nach oben](README.md) / [Weiter](installation.md)

Die aktuelle Evolution CMS-Dokumentation muss die jetzt vorhandene Laufzeit beschreiben.
nicht die älteren Evo 1.x-Annahmen aus dem Legacy-Docs-Archiv.

## Kernlaufzeit

| Anforderung | Aktuelle Basislinie |
| --- | --- |
| PHP | `^8.3` |
| Composer | Composer 2.x für Projekt- und Paketinstallation. |
| Datenbankzugriff | PDO ist erforderlich. MySQL, PostgreSQL, SQLite und SQL Server werden von den aktuellen Installationsoptionen unterstützt, wenn der passende PHP-Treiber verfügbar ist. |
| PHP-Erweiterungen | Core erfordert JSON, PDO, ZIP, mbstring, XML-bezogene Erweiterungen, Sitzung, Tokenizer, OpenSSL, Ctype, Dateiinfo, Filter, Hash, Iconv und PCRE. |
| Optionale Bildunterstützung | Für die Bildbearbeitung wird GD oder Imagick empfohlen. |

Das Root-Projekt `composer.json` ist minimal, während `core/composer.json` Eigentümer ist
größerer Laufzeitabhängigkeitssatz: Illuminate 12 Components, Flysystem, PHPMailer,
Tracy, Symfony Process, Composer-Integration und unterstützende Pakete.

## Installer-Laufzeit

Das eigenständige Installationsprogramm erfordert:

| Anforderung | Notizen |
| --- | --- |
| PHP | `^8.3` |
| Composer | Wird für die globale Installation des Installationsprogramms und die Projekteinrichtung benötigt. |
| JSON, PDO, MySQLi, ZIP | Erforderlich für das Installationspaket. |
| GitHub Zugriff | Wird benötigt, wenn der Bootstrapper die Go-Installer-Binärdatei von GitHub-Releases herunterlädt oder aktualisiert. |
| Beschreibbares Bin-Verzeichnis des Installationsprogramms | Wird für `evo self-install` und die erste Binärinstallation benötigt. |

Der Installationsbefehl `system-status` überprüft das Betriebssystem, die PHP-Version,
Composer, PDO Treiber, JSON, MySQLi, mbstring, cURL, Bildunterstützung, Speicherplatz,
und Speicherlimit.

## Dokumentationsregel

Wenn eine Anforderung aus der alten Dokumentation kopiert wird, überprüfen Sie sie anhand der aktuellen
Composer-Dateien, Installationscode und Installationsprüfungen, bevor Sie sie hier veröffentlichen.
