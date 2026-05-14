# API und Integrationen

[Evolution CMS](../README.md) / API und Integrationen

In diesem Abschnitt werden aktuelle Integrationsoberflächen für Entwickler zusammengestellt
Evolution CMS: Kernlaufzeit-APIs, Modelle, Ereignisse, Manageraktionen, Artisan
Befehle, Paketgrenzen und Kompatibilitätsebenen.

## Seiten

| Seite | Zweck |
| --- | --- |
| [Modellreferenz](../10-reference/models.md) | Aktuelle Eloquent-Modellkarte und Verantwortungsgruppen. |
| [Ereignisreferenz](../10-reference/events.md) | Aktuelle Event-/Plugin-Oberflächen gruppiert nach Laufzeitbereich. |
| [Referenz zu Systemeinstellungen](../10-reference/system-settings.md) | Registerkarten „Aktuelle Werkseinstellungen“ und „Managereinstellungen“. |
| [Referenz zu Rollen und Berechtigungen](../10-reference/roles-and-permissions.md) | Manager Rollen, Berechtigungsschlüssel, Dokumentgruppen, Webzugriff, Sperren und Dateiberechtigungen. |
| [Konfigurationslaufzeitreferenz](../10-reference/configuration-runtime.md) | Bootstrap, Umgebungscache, Konfigurationsdateien, benutzerdefinierte Überschreibungen, Anbieter, Aliase und Middleware. |
| [Kern-Composer-Referenz](../10-reference/core-composer.md) | Composer-Abhängigkeits- und Autoload-Grenzen. |
| [Legacy-Kompatibilitätsreferenz](../10-reference/legacy-compatibility.md) | Legacy-Dienste, Hilfsprogramme, Parser-Kompatibilität und Manager-Aktionskompatibilität. |
| [Artisan-Befehlsreferenz](../10-reference/artisan-commands.md) | Vollständige Befehlsoberfläche für installierte Projekte, die von der Kernlaufzeit registriert wird. |
| [Blade und Referenz zum Rendern von Vorlagen](../10-reference/blade-and-template-rendering.md) | Blade-Rendering, Manageransichten, Anweisungen und Symbolanweisungen. |
| [Parser-Tags-Referenz](../10-reference/parser-tags.md) | Klassische Evolution-Parser-Tags und Parser-Reihenfolge. |
| [Artisan- und Manager-Aktionen](../10-reference/artisan-and-manager-actions.md) | Aktuelle Suchoberfläche für Befehle und Manageraktionen. |
| [Paket erstellen](../05-extras-and-packages/create-package.md) | Moderne package structure, service provider wiring, manager module pattern, EvoUI/Livewire surfaces, docs und release checks. |
| [Preset erstellen](../05-extras-and-packages/create-preset.md) | Ready-site scaffold structure fuer installer presets, required Extras, theme assets, custom project code und validation checks. |
| [Projektstruktur](../04-development/project-structure.md) | Quellenlayout hinter den Referenzseiten. |

## Geltungsbereich

Dieser Abschnitt ist eine validierte Karte der aktuellen Integrationsflächen. Methodenebene
klassische Core API-, DB API-, Routing- und feldweise Datenbankreferenzen sollten dies tun
können erst dann als separate Referenzseiten hinzugefügt werden, nachdem jeder Anspruch geprüft wurde
aktueller Code.
