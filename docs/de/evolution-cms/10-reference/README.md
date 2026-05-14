# Referenz

[Evolution CMS](../README.md) / Referenz

Dieser Abschnitt ist eine Suchoberfläche für aktuelle Evolution CMS-Laufzeitverträge.
Es wird zuerst aus dem aktuellen Code geschrieben und vermeidet die Installation von Pakethandbüchern
Extras.

## Kernreferenzen

| Seite | Zweck |
| --- | --- |
| [Konfigurationslaufzeitreferenz](configuration-runtime.md) | Bootstrap-Flow, `.env`-Cache, Kernkonfigurationsdateien, benutzerdefinierte Überschreibungen, Anbieter, Aliase und Middleware. |
| [Kern-Composer-Referenz](core-composer.md) | Root-/Kern-Composer-Grenzen, Abhängigkeiten, Merge-Plugin, Autoload und Skripte. |
| [Legacy-Kompatibilitätsreferenz](legacy-compatibility.md) | Legacy-Klassen, Anbieter, Helfer, Manageraktionen und Kompatibilitätsregeln. |
| [Artisan Befehlsreferenz](artisan-commands.md) | Von der Kernlaufzeit registrierte Artisan-Befehle des installierten Projekts. |
| [Referenz zu Systemeinstellungen](system-settings.md) | Standardeinstellungen, Registerkarten für Managereinstellungen und Produktionshinweise. |
| [Referenz zu Rollen und Berechtigungen](roles-and-permissions.md) | Manager Rollen, Berechtigungsschlüssel, Dokumentgruppen, Webzugriff, Sperren und Dateiberechtigungen. |
| [Blade und Referenz zum Rendern von Vorlagen](blade-and-template-rendering.md) | Blade-Vorlagen, Manager-Blade-Ansichten, Anweisungen, Symbole und Vorlagenauflösung. |
| [Parser-Tags-Referenz](parser-tags.md) | Klassische Evolution-Parser-Tags, Chunks, Snippets, Einstellungen, Platzhalter, URLs und Bedingungen. |
| [Modellreferenz](models.md) | Eloquente Modellkarte für Ressourcen, Elemente, Einstellungen, Benutzer, Berechtigungen und Laufzeitstatus. |
| [Ereignisreferenz](events.md) | Vordefinierte Ereignisnamen und aktuelle Ereignisoberflächen, gruppiert nach Laufzeitbereich. |
| [Artisan- und Manager-Aktionen](artisan-and-manager-actions.md) | Kurze Manager-Aktions- und Befehlskarte. |
| [CLI Referenz](cli-reference.md) | Befehle des eigenständigen Installationsprogramms `evo`. |
| [Paket erstellen](../05-extras-and-packages/create-package.md) | Gemeinsamer package creation contract fuer moderne Extras. |
| [Preset erstellen](../05-extras-and-packages/create-preset.md) | Gemeinsamer preset creation contract fuer ready-site installer scaffolds. |
| [Quellinventar](source-inventory.md) | Quelloberflächen, die die Produktdokumentation speisen. |
| [Dokumentationsnavigation](documentation-navigation.md) | Verlinkungs- und Navigationsregeln für öffentliche Dokumentationen. |
| [Dokumentationsquellenrichtlinie](documentation-source-policy.md) | Welche Quellen sind für die öffentliche Dokumentation zugelassen? |

## Grenze

Diese Referenz beschreibt Evolution CMS selbst: Laufzeit, Manager, Parser,
Einstellungen, Berechtigungen, Ereignisse, Modelle und Installations-/Bedienoberflächen.
Installierte Extras erscheinen als separate dDocs-Quellen und sollten ihre eigenen behalten
Benutzer- und Entwicklerhandbücher.
