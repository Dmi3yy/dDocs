# Artisan- und Manager-Aktionen

[Zurück](events.md) / [Nach oben](../README.md) / [Weiter](source-inventory.md)

Diese Seite bildet aktuelle Befehls- und Manager-Aktionsoberflächen ab. Es ist ein Anfang
Punkt für ausführlichere Befehlsreferenzen und Manager-Workflow-Dokumentation.

## Artisan-Befehle

| Bereich | Befehle |
| --- | --- |
| Cache und Ansichten | `cache:clear-full`, kompilierten Cache löschen, Ansichten löschen. |
| Pakete | `package:discover`, `package:create`, `package:installrequire`, `package:removerequire`, `package:installautoload`, `package:runconsoles`, `extras`. |
| Voreinstellungen | `preset:apply`, `preset:install`. |
| Listen und Diagnose | `doc:list`, `template:list`, `tv:list`, `deprecated:list`, Routenliste. |
| Terminplanung | Zeitplanliste und Zeitplanausführungsbefehle. |
| Systemaufgaben | Scheduler-Heartbeat- und Task-Worker-Befehle. |
| Site/Laufzeit | Site-Update, Baum-Update, Übersetzungssynchronisierung, Anbieterveröffentlichung, Tailwind-Build. |

Verwenden Sie [CLI Reference](cli-reference.md) für den eigenständigen Installationsbefehl `evo`
Oberfläche und [Artisan Befehlsreferenz](artisan-commands.md) für die vollständige Beschreibung
Befehlsoberfläche für installiertes Projekt. Diese Seite ist eine kompakte Karte, die verbindet
Befehle mit Manager-Aktionsoberflächen.

## Manager Aktionsquellen

Manager-Aktionen sind keine einzelne moderne Routendatei. Aktuelles Managerverhalten ist
aus mehreren Oberflächen gelöst:

| Oberfläche | Verantwortung |
| --- | --- |
| `ManagerTheme` | Löst die aktive Manageraktion und den Controller auf. |
| `core/factory/actionlist.php` | Legacy-Aktions-ID-Karte und Aktionsmetadaten. |
| `core/src/Controllers/` | Aktuelle Managerseiten-Controller. |
| `manager/actions/` | Legacy- und dynamische Aktionshandler. |
| `manager/processors/` | Mutierende Speicher-/Lösch-/Veröffentlichungs-/Einstellungen-/Cache-Prozessoren. |
| `manager/views/` | Blade-Ansichten und Aktionsschaltflächen. |
| Modellieren Sie `managerActionsMap`-Arrays | Allgemeine Aktions-IDs für Bearbeiten, Speichern, Löschen, Duplizieren, Aktivieren, Deaktivieren, Sortieren, Ausführen und verwandte Modellaktionen. |

## Allgemeine Modellaktionen

| Modellbereich | Gemeinsame Aktionen |
| --- | --- |
| Vorlagen | neu, bearbeiten, speichern, löschen, duplizieren. |
| Template Variables | Neu, Bearbeiten, Speichern, Löschen, Duplizieren, Sortieren. |
| Chunks | Neu, Bearbeiten, Speichern, Aktivieren, Deaktivieren, Löschen, Duplizieren. |
| Snippets | Neu, Bearbeiten, Speichern, Aktivieren, Deaktivieren, Löschen, Duplizieren. |
| Plugins | Neu, Bearbeiten, Speichern, Aktivieren, Deaktivieren, Löschen, Duplizieren, Sortieren, Bereinigen. |
| Modules | Neu, Bearbeiten, Speichern, Aktivieren, Deaktivieren, Löschen, Duplizieren, Ausführen, Abhängigkeit. |
| Resources | Erstellen, Bearbeiten, Speichern, Verschieben, Duplizieren, Veröffentlichen, Veröffentlichung aufheben, Löschen, Wiederherstellen, Papierkorb leeren. |

## Dokumentationsregel

Validieren Sie beim Dokumentieren einer Manageraktion alle drei Ebenen:

- die Aktions-ID oder Modell-Aktionskarte;
- der Verantwortliche/Aktion/Auftragsverarbeiter, der die Anfrage bearbeitet;
– die Manageransicht, die dem Benutzer die Aktion zugänglich macht.

Behandeln Sie alte Aktionsnamen nicht als aktuelles Verhalten, es sei denn, sie werden noch aufgelöst
die aktuelle Manager-Laufzeit.
