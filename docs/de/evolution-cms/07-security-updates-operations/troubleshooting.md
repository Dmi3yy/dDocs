# Fehlerbehebung

[Zurück](../01-getting-started/core-concepts.md) / [Nach oben](README.md) / [Weiter](../10-reference/source-inventory.md)

Verwenden Sie diese Seite für Erstprüfungen, bevor Sie tiefergehenden Code öffnen oder hosten
Diagnostik. Der Schwerpunkt liegt auf dem aktuellen Evolution CMS- und Installationsverhalten.

## Schnelle Überprüfungen

| Symptom | Zuerst prüfen |
| --- | --- |
| Das Installationsprogramm startet nicht | Bestätigen Sie PHP 8.3 oder höher, die Verfügbarkeit von Composer und ein beschreibbares Installationsbinärverzeichnis. Führen Sie `evo system-status` aus, sofern verfügbar. |
| Das Installationsprogramm kann die Binärdatei nicht herunterladen oder aktualisieren Überprüfen Sie den Netzwerkzugriff auf GitHub-Releases. Wenn die Rate begrenzt ist, legen Sie `GITHUB_TOKEN` fest oder übergeben Sie die Tokenoption GitHub des Installationsprogramms. |
| Composer wurde nicht gefunden | Stellen Sie sicher, dass Composer eine ausführbare Datei auf `PATH` ist und nicht nur ein Shell-Alias. Legen Sie `EVO_COMPOSER_BIN` fest, wenn der Host einen expliziten Composer-Pfad benötigt. |
| Datenbankeinrichtung schlägt fehl | Stellen Sie sicher, dass der ausgewählte Datenbanktreiber für PHP installiert ist, Host/Port/Name/Benutzer/Passwort korrekt sind und SQLite-Namen für das Projektdatenbankverzeichnis gültig sind. |
| Die Installation ist abgeschlossen, aber die Manager-Anmeldung schlägt fehl | Überprüfen Sie das während der Installation ausgewählte Manager-Verzeichnis, das Sitzungs-/Cookie-Verhalten, die Datenbankbenutzerdatensätze und ob der Installationsbefehl Fallback-Warnungen für Administrator-Benutzer gemeldet hat. |
| Eine Seite ist leer oder gibt einen Serverfehler zurück | Überprüfen Sie PHP-Fehlerprotokolle, Anwendungsprotokolle, fehlende Composer-Abhängigkeiten und ob generierte Caches eine vollständige Aktualisierung benötigen. |
| Änderungen sind auf der Website nicht sichtbar | Leeren Sie den gesamten Cache oder führen Sie die Site-Aktualisierungsaktion aus. Resource-Caching, View-Cache, Env-Cache und Browser-Cache können alle aktuelle Änderungen verbergen. |
| Freundliche URLs funktionieren nicht | Bestätigen Sie, dass `friendly_urls` aktiviert ist, Umschreiberegeln im Webserver konfiguriert sind, Aliase gültig sind und der Cache aktualisiert wurde. |
| Dateibrowser oder Uploads schlagen fehl | Überprüfen Sie `filemanager_path`, `rb_base_dir`, Upload-Erweiterungseinstellungen, maximale Upload-Größe und Dateisystemberechtigungen für die Zielverzeichnisse. |
| Ein Managerbenutzer kann ein Dokument nicht sehen | Überprüfen Sie Managerberechtigungen, Dokumentgruppen, Benutzergruppen, Datenschutzflags für Ressourcen und ob der Benutzer Zugriff auf die Manageraktion hat. |
| Die Paketdokumentation fehlt in dDocs | Stellen Sie sicher, dass das Paket über einen Dateisystemordner `docs/` verfügt, das Paket im Projekt installiert ist, dDocs aktualisiert wurde und die aktuelle Managersprache einem verfügbaren Dokumentgebietsschema zugeordnet ist. |
| Eine Extra-spezifische Funktion ist hier nicht dokumentiert | Öffnen Sie Extra in dDocs. Produktdokumente beschreiben das gemeinsame Verhalten von Evolution CMS; Installierte Extras besitzen eigene Funktionshandbücher. |

## Zwischenspeichern und aktualisieren

Der allgemeine vollständige Aktualisierungspfad ruft `evo()->clearCache('full')` auf. Die Managerseite
Bei der Aktualisierung werden auch geplante Ressourcen veröffentlicht und die Veröffentlichung aufgehoben, der gesamte Cache wird gelöscht.
Entfernt den generierten Umgebungscache, sofern vorhanden, und ruft das Site-Refresh-Ereignis auf.

Verwenden Sie nach der Änderung eine Cache-Aktualisierung:

- Vorlagen, Chunks, Snippets, Plugins, Module oder Template Variables;
- Systemeinstellungen, die sich auf Routing, Pfade, Uploads, Cache oder Manager-Ausgabe auswirken;
- Paketdienstanbieter, Assets, Ansichten oder generierte Konfigurationen;
- Ressourcenaliase, Veröffentlichungsstatus, Berechtigungen oder benutzerfreundliche URL-Einstellungen.

## Checkliste für benutzerfreundliche URLs

Probleme mit freundlichen URLs betreffen normalerweise sowohl die Evolution CMS-Einstellungen als auch den Webserver
Konfiguration.

| Bereich | Was zu überprüfen ist |
| --- | --- |
| Manager-Einstellungen | `friendly_urls`, Suffix-/Präfixeinstellungen, Ordnerverhalten, strenge URL-Einstellungen und Aliase. |
| Webserver | Für das Projekt sind Apache-Rewrite-Regeln oder entsprechendes Nginx-Routing aktiv. |
| Resources | Aliase sind bei Bedarf eindeutig und Ressourcen werden veröffentlicht, sichtbar und nicht gelöscht. |
| Cache | Aktualisieren Sie die Website, nachdem Sie Aliase, URL-Einstellungen oder das Umschreibverhalten geändert haben. |

## Checkliste für Dateien und Uploads

Dateimanager- und Upload-Probleme sind in der Regel auf Pfade, Zulassungslisten für Erweiterungen usw. zurückzuführen
Berechtigungen.| Einstellungsbereich | Was zu überprüfen ist |
| --- | --- |
| Dateimanagerpfad | Der konfigurierte Pfad zeigt innerhalb des Projekts und ist für PHP lesbar. |
| Resource Browser-Basisverzeichnis | Das Basisverzeichnis des Browsers verweist auf den vorgesehenen Asset-Speicherort. |
| Erweiterungen hochladen | Dateien, Bilder und Medienerweiterungslisten ermöglichen den erwarteten Dateityp. |
| Uploadgröße | Das Upload-Limit Evolution CMS und das Upload-Limit PHP/Webserver sind hoch genug. |
| Berechtigungen | PHP kann Dateien im Zielverzeichnis erstellen, schreiben, umbenennen und löschen. |

## Paketdokumentationsgrenze

dDocs ist die Paketdokumentationsoberfläche für installiertes Extras. Wenn ein Paket
erscheint im dDocs-Baum nur mit einem Paketnamen oder ohne lokalisierte Seiten,
Korrigieren Sie die Paketdokumentationsquelle, anstatt das Handbuch hinein zu kopieren
Evolution CMS Produktdokumente.

Überprüfen Sie bei Problemen mit Paketdokumenten Folgendes:

– das Paket enthält `docs/en/README.md` oder einen anderen unterstützten Locale-Eintrag;
- Ukrainische Paketdokumente verwenden den Gebietsschemaordner `uk`; altes ukrainisches Gebietsschema
  Ordner sollten vor der Veröffentlichung migriert werden;
- Die Paketdokumente haben stabile Titel und ein H1 pro Seite;
- Relative Links werden im Stammverzeichnis der Paketdokumente aufgelöst;
- dDocs-Index/Cache wurde nach Dateiänderungen aktualisiert.

## Unterstützen Sie die zu sammelnden Daten

Wenn ein Problem einer eingehenderen Prüfung bedarf, sammeln Sie Folgendes:

- PHP-Version und aktivierte Datenbanktreiber;
- Evolution CMS-Version oder -Zweig;
- Version des Installationsprogramms und verwendeter Befehl;
- Datenbanktyp und ob das Problem vor oder nach Migrationen auftritt;
- Managersprache;
- geänderte Systemeinstellungen in Bezug auf Cache, URLs, Pfade, Uploads oder Berechtigungen;
– die genaue Manager-Aktion oder URL, die fehlschlägt;
- Aktuelle Paketinstallationen oder -aktualisierungen.
