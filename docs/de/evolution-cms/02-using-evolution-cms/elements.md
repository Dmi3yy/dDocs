# Elemente

[Zurück](resources-and-document-tree.md) / [Nach oben](README.md) / [Weiter](settings-permissions-and-files.md)

Element Management ist der Managerbereich für Vorlagen, Template Variables,
Chunks, Snippets, Plugins und Module. Der aktuelle Managercode organisiert diese als
Registerkarten im Resources-Controller.

## Elementtypen

| Element | Verwenden Sie es für |
| --- | --- |
| Vorlage | Seitenlayout und Ressourcenausgabestruktur. |
| Template Variable | Benutzerdefinierte Felder, die an Vorlagen angehängt und pro Ressource gespeichert werden. |
| Chunk | Wiederverwendbare Markups oder Textfragmente. |
| Snippet | PHP-gestützte Logik, die eine Ausgabe zurückgibt. |
| Plugin | Ereignisgesteuerter Erweiterungscode. |
| Module | Manager-seitiger Tool- oder Anwendungsbildschirm. |

## Mit Vorlagen arbeiten

Erstellen oder bearbeiten Sie Vorlagen, wenn eine Ressource ein Layout oder einen anderen Satz davon benötigt
Template Variables. Eine Vorlage kann auswählbar, gesperrt, kategorisiert und verknüpft sein
zu TVs.

Beim Ändern einer Vorlage:

1. Speichern Sie die Vorlage.
2. Überprüfen Sie die zugewiesene Template Variables.
3. Aktualisieren Sie den Cache, wenn sich die Ausgabe nicht ändert.
4. Testen Sie Ressourcen, die die Vorlage verwenden.

## Arbeiten mit Template Variables

Template Variables Definieren Sie strukturierte Felder, die auf Ressourcen angezeigt werden, indem Sie die verwenden
zugewiesene Vorlagen. TVs haben einen Typ, eine Beschriftung, eine Kategorie, Elemente/Optionen,
Anzeigemodus, Standardtext und Rollen-/Vorlagenzugriffsregeln.

Verwenden Sie TVs für Inhaltsdaten, die Redakteure getrennt von den Hauptdaten verwalten sollten
Ressourceninhaltsfeld.

## Arbeiten mit Chunks und Snippets

Chunks sind wiederverwendbare Text- oder Markup-Blöcke. Snippets sind PHP-gestützte Logikblöcke.
Beide können aktiviert, deaktiviert, dupliziert, gelöscht, gesperrt und kategorisiert werden
der Manager.

Verwenden Sie Chunks für wiederholtes Markup. Verwenden Sie Snippets, wenn die Ausgabe Laufzeitlogik benötigt.

## Arbeiten mit Plugins und Ereignissen

Plugins sind mit benannten Ereignissen verbunden und werden ausgeführt, wenn die Laufzeit diese aufruft
Ereignisse. Plugin-Reihenfolge wird durch die Ereignispriorität gesteuert. Verwenden Sie Plugins für den Lebenszyklus
Hooks wie Dokumentspeicherung, Parser, Manager, Cache, Dateibrowser und Benutzer
Ereignisse.

Lesen Sie die [Ereignisreferenz](../10-reference/events.md), bevor Sie ein hinzufügen oder ändern
Plugin-Ereignisverbindung.

## Arbeiten mit Modules

Modules sind managerseitige Tools. Sie können Modulcode, Ressourcendateien usw. enthalten.
Gemeinsame Parameter, Abhängigkeiten und Ausführungs-/Bearbeitungsaktionen. Installierte Paketmodule können sein
verfügen außerdem über eine paketeigene Dokumentation in dDocs.

Kopieren Sie kein Paketmodulhandbuch in diesen Produktdokumentbaum. Öffnen Sie die
Paketquelle in dDocs, wenn die Funktion zu einem installierten Extra gehört.
