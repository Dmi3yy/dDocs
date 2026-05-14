# dDocs

dDocs ist ein file-first Dokumentationsbrowser für den Evolution CMS Manager. Es
findet Markdown-Dokumentation in installierten Evolution-Paketen, zeigt
Paketquellen im linken Baum, rendert das ausgewählte Dokument im rechten Panel
und erlaubt dem Projekt, eine eigene lokale Markdown-Wissensbasis zu pflegen.

Die Quelle der Wahrheit ist das Dateisystem. dDocs benötigt keine Datenbanktabellen
für Paketdokumentation.

## Fähigkeiten

- Dokumentation aus installierten Evolution-Paketen erkennen.
- Einen Paket-/Modulbaum mit Ordnern und Markdown-Dokumenten anzeigen.
- Die aktuelle Manager-Sprache mit Fallback auf Englisch oder neutrale Docs beachten.
- Nach Titel, Pfad, Paketname und Markdown-Inhalt suchen.
- GitHub-flavored Markdown sicher im Manager rendern.
- Relative Links zwischen indizierten Dokumenten auflösen.
- Lokale Bilder nur aus sicheren Docs-Roots rendern.
- Projekteigene Dokumentation in `ProjectDocs/` halten.
- Den generierten Dateiindex für schnellere Manager-Navigation cachen.

## Guides

- [Benutzerguide](user-guide.md)
- [Entwicklerguide](developer-guide.md)
- [Frontend guide](frontend-guide.md)
- [Konfiguration](configuration.md)
- [Referenz](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Dokumentationsstandards](documentation-standards.md)

## Markdown-Rendering

dDocs sendet rohes Markdown an die Manager-Seite und rendert es im Browser mit
lokalen dTui/TOAST UI Assets. Code-Highlighting nutzt lokale Prism Assets,
einschließlich der Evolution Blade Grammatik.

dDocs besitzt weiterhin die Sicherheitsschicht rund um den Viewer:

- script-ähnliche HTML-Blöcke werden entfernt, bevor Markdown an den Viewer geht;
- relative Dokumentationslinks werden auf indizierte dDocs Dokument-IDs gemappt;
- lokale Bilder werden nur konvertiert, wenn sie sichere Docs-Root-Prüfungen bestehen;
- fehlende relative Docs-Links bleiben inert, statt das Manager-iframe zu navigieren.

## Runtime-Modell

```text
Composer-Pakete / lokale Evolution-Pakete
        |
        v
DocsSourceRegistry
        |
        v
DocsIndexer
        |
        v
FileIndexCache
        |
        v
Livewire ModulePanel -> raw Markdown payload -> dTui/TOAST UI Viewer
                                           -> link/image post-processing
```

## Projektdokumentation

Dokumente, die über die dDocs UI erstellt werden, liegen in `ProjectDocs/`
innerhalb des dDocs-Pakets. Projektdokumentation ist beschreibbar, während
Vendor-Paketdokumentation read-only bleibt.

Nutze Projektdokumentation für lokale Wissensbestände des aktuellen Projekts:

- Architekturnotizen;
- Umgebungsnotizen;
- Deployment-Notizen;
- projektspezifische Entscheidungen;
- AI/Codex-Arbeitskontext.
