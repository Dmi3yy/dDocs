# Quellinventar

[Zurück](../01-getting-started/installation.md) / [Nach oben](../README.md) / [Weiter](documentation-navigation.md)

Diese Referenz zeichnet die aktuellen Quelloberflächen auf, die Evolution versorgen sollen
CMS-Produktdokumentation.

## Aktuelle Codequellen

| Oberfläche | Verwendung der Dokumentation |
| --- | --- |
| Evolutionswurzel | Projekteintragsdateien, Root-Composer-Metadaten, öffentliches `index.php`, Beispielkonfiguration und README auf Projektebene. |
| `core/` | Laufzeit-Bootstrap, Composer-Laufzeit, Konfiguration, Umgebungscache, Datenbankmigrationen, Seeder, Tests, Speicher und Artisan-Einstiegspunkt. |
| `core/src/` | Kerndienste, Parser, Anbieter, Modelle, Controller, Middleware, Fassaden, Legacy-Adapter, Unterstützungsklassen und Konsolenbefehle. |
| `manager/` | Manager-Einstiegspunkt, Aktionsrouting, Ansichten, Prozessoren, Includes, Medien und Verhalten der Manager-Benutzeroberfläche. |
| `install/` | Legacy-Webinstallationsprogramm, CLI-Installationsskript, Installationsressourcen, Setup-Funktionen und Installations-Stubs. |
| `assets/` | Gebündelte Module, Plugins, Snippets, Manager-Assets und Installationszeit-Assets. |
| `views/` | Platzhalter für öffentliche Projektansichtsebenen. |
| Eigenständiges Installationspaket | Derzeit empfohlener Installationsablauf und `evo`-Befehlsverhalten. |
| Installiert Extras | Dokumente auf Paketebene werden von dDocs separat erkannt und sollten hier nicht dupliziert werden. |
| Archiv alter Dokumente | Nur älteres Referenzmaterial, nach Validierung anhand des aktuellen Codes. |
| Validierte Best-Practice-Notizen | Zukünftige Rezepte nur nach Überprüfung des aktuellen Codes. |

## Aktuelle Laufzeitsignale

| Signal | Notizen |
| --- | --- |
| PHP-Basislinie | Der aktuelle Kern und das Installationsprogramm erfordern PHP `^8.3`. |
| Framework-Ebene | Core verwendet Illuminate 12-Komponenten und Symfony Console/Process-Oberflächen. |
| Manager-Routing | Manager-Anfragen werden über einen einzelnen Aktionshandler und Aktions-IDs weitergeleitet. |
| Konsolenschicht | Core stellt Artisan-Befehle für Cache, Ansichten, Pakete, Voreinstellungen, Routen, Planung, Site-Updates, Übersetzungen, Baumaktualisierungen, Migrationen, Seeder, Tailwind und Systemaufgaben bereit. |
| Datenschicht | Core verfügt über Eloquent-Modelle für Ressourcen, Elemente, Benutzer, Berechtigungen, Einstellungen, Ereignisprotokolle, Scheduler-/Worker-Status und Abschlusstabellenbaumdaten. |
| Tests | Der aktuelle Kern verfügt über Pest-Tests für Installation, Manager, Updater, Systemaufgaben, Support-Dienstprogramme und Kompatibilitätsverhalten. |

## Rückstand bei der Dokumentationsabdeckung

Die aktuelle Baseline deckt Anforderungen, installer-first Installation,
Installer CLI Reference, Kernkonzepte, Manager-Workflows, Projektstruktur,
Developer reference maps, configuration/runtime bootstrap, Core Composer,
legacy compatibility, Artisan-Befehle des installierten Projekts, system
settings/defaults, roles and permissions, Blade/template rendering, classic
parser tags, zwei validierte Rezepte, source policy, navigation rules und
first-line troubleshooting ab.

| Lücke | Geplante öffentliche Seite |
| --- | --- |
| Vollständig klassisch API und DB API | `06-api-and-integrations/` und `10-reference/` nach Validierung auf Methodenebene |
| Hilfe zur Benutzeroberfläche für feldweise Einstellungen | Erweitern Sie [Referenz zu Systemeinstellungen](system-settings.md), nachdem Sie die Beschriftung der einzelnen Manager-Registerkarten überprüft und den Prozessor gespeichert haben |
| Event-Nutzlastverträge | Erweitern Sie [Ereignisreferenz](events.md) nach der Validierung jeder `invokeEvent`-Aufrufseite |
| Dokumentationsnavigation | [Dokumentationsnavigation](documentation-navigation.md) |
| Weitere Best-Practice-Rezepte | `08-tutorials-recipes/` nach der Validierung des aktuellen Codes |
| Lokalisierungen | Lokalisierte Kopien mit der geprueften EN baseline synchron halten |
