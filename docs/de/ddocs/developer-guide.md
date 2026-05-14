# Entwicklerguide

Dieser Guide erklärt, wie dDocs verdrahtet ist, wie es Dokumentation findet und
wie Entwickler es sicher erweitern sollten.

## Runtime-Modell

```text
DocsSourceRegistry -> DocsIndexer -> FileIndexCache
                                  -> FileDocumentRepository
ModulePanel        -> raw Markdown payload
Browser viewer     -> dTui/TOAST UI + Prism
LinkResolver       -> link, image, and UML maps
DocumentPath       -> path safety checks
FileSearch         -> title, path, source, and content search
```

Das Dateisystem ist die Quelle der Wahrheit. dDocs verwendet keine
Datenbanktabellen für Paketdokumentation.

## Services

| Service | Verantwortung |
| --- | --- |
| `DocsSourceRegistry` | Findet Paketdokumentation, Projektdokumentation, konfigurierte Roots und Source-Metadaten. |
| `DocsIndexer` | Baut Folder- und Document-Nodes mit stabilen IDs, Sprachmetadaten, Fallback-Branch-Merging, Timestamps und Checksums. |
| `FileIndexCache` | Speichert und aktualisiert den generierten PHP-Metadaten-Cache. |
| `FileDocumentRepository` | Liest ausgewählte Markdown-Dateien nach Sicherheitsprüfungen. |
| `LanguageResolver` | Löst Manager-Sprache auf, normalisiert legacy `ua` zu `uk`, liefert geordnete Locale-Roots und findet neutrale Docs. |
| `ManagerText` | Lädt Manager-UI-Labels aus `lang/<locale>/global.php` mit Fallback auf englische Labels. |
| `LinkResolver` | Löst interne Links, lokale Bilder, sicheres HTML, Code-Sprachen und UML-Image-URLs auf. |
| `FileSearch` | Filtert Nodes nach Titel, Pfad, Paketname und Markdown-Inhalt. |
| `MarkdownExport` | Baut eine herunterladbare Markdown-Datei aus lesbaren Dokumenten im aktuellen Dateiindex. |
| `Diagnostics` | Meldet read-only Source, Cache, Sprache und Path-Safety-Status für Manager/Debug. |

## Runtime Lookup

Halte exakte Lookup-Daten aus diesem Guide heraus, damit die Dokumentation
wartbar bleibt.

- Routes, unterstützte Markdown-Funktionen, UML-Verhalten und Document-Node-
  Metadaten stehen in der [Referenz](reference.md).
- Config Keys, Defaults, Werttypen und Sicherheitsnotizen stehen in der
  [Konfiguration](configuration.md).
- Frontend Payload und Viewer-breaking Changes stehen im [Frontend guide](frontend-guide.md).

Diagnostics enthalten Dateisystemmetadaten, daher müssen diagnostische Routes
hinter dem Manager/Debug Guard bleiben, der in der [Referenz](reference.md)
beschrieben ist.

## Search Runtime Model

dDocs verwendet aktuell filesystem live search: einen Live-Filter über dem
Dateiindex, keine dedizierte Search Engine, keinen Full-text Index und keinen
indizierten Suchdienst.

`DocsIndexer` baut Navigationsmetadaten-Nodes. `FileIndexCache` speichert diese
Nodes als generierte PHP-Metadaten, damit der Baum schnell geöffnet wird. Dieser
Cache speichert Titel, Pfade, Source-Metadaten, Sprachmetadaten, Timestamps und
Checksums; er speichert keinen normalisierten Dokumenttext, keine Tokens, keine
Headings, keine Snippets und keine Posting List für Suche.

`ModulePanel` lädt alle Nodes aus `FileIndexCache` und übergibt sie an
`FileSearch`. `FileSearch` matcht zuerst Metadatenfelder wie Titel, relativer
Pfad, Source-Name und Paketname. Wenn der Node ein Dokument ist und Metadaten
nicht matchen, liest es die Markdown-Datei über `FileDocumentRepository` und
prüft den rohen Inhalt.

Content Search respektiert weiterhin das Dateisystem-Sicherheitsmodell. Es liest
nur indizierte Dokument-Nodes, erlaubte Erweiterungen, sichere Docs-Roots und
Dateien unter `max_file_size_kb`.

Wenn ein Dokument matcht, gibt `FileSearch` auch seine Parent-Folders zurück.
Diese Ordner sind UI-Kontext, keine Search Matches. So bleibt der Baum lesbar,
während eine Suche aktiv ist.

Checksums gehören aktuell zu Metadaten und Cache-Invalidation. Sie werden noch
nicht für Search-Index-Invalidation genutzt, weil es noch keinen separaten
Search Index gibt.

## Search Roadmap

Die Suche soll filesystem-first bleiben. Der nächste Schritt sollte ein
generierter file-based `FileSearchIndexCache` sein, keine Datenbanktabelle und
kein externer Search Service.

Empfohlene Roadmap:

1. `FileSearchIndexCache` als generierten PHP- oder JSON-Cache für suchbaren Text hinzufügen.
2. Navigationsindex und Search Index als getrennte Verantwortlichkeiten halten.
3. Inkrementell per Checksum und mtime rebuilden, damit unveränderte Dokumente nicht erneut gelesen werden.
4. Normalisierten Suchtext, Headings, Tokens und Snippet-Quelle speichern.
5. Einfaches Scoring hinzufügen: Titel über Heading, Heading über Pfad, Pfad über Source/Package, Source/Package über Body Content.
6. Exact phrase matches über Token Matches ranken, Token Matches über Prefix Matches.
7. Snippets hinzufügen, damit generische Titel nützlichen Ergebnis-Kontext zeigen.
8. Matches clientseitig nach dem Rendern highlighten, ohne Markdown-Source zu ändern.
9. Kleine Query-Filter wie `source:ddocs`, `path:configuration`, `type:reference` und `lang:uk` hinzufügen.
10. Search Modes hinzufügen: quick metadata search, full-text search und current source search.

Vermeide Elasticsearch, Meilisearch, Typesense, SQLite FTS, database-backed
search content und vector search für den ersten Release. Sie bringen
Infrastruktur, die nicht zum aktuellen file-as-source-of-truth Modell passt.

## Source Discovery Contract

dDocs findet Dokumentation aus:

- dem dDocs-Paket selbst;
- installierten Composer-Paketen, die wie Evolution-Pakete aussehen;
- Paket-Roots mit `docs/`, legacy `Docs/`, `README.md` oder `index.md`;
- Project Documentation in `ProjectDocs/`;
- konfigurierten safe roots und extra docs roots.

Neue Pakete sollen lowercase `docs/` ausliefern. Legacy `Docs/` wird nur für
Kompatibilität akzeptiert.

## Sprachkontrakt

dDocs löst Dokumentationsroots für den Manager-Benutzer in Prioritätsreihenfolge auf:

1. `default_language`, wenn konfiguriert.
2. Evolution Manager Sprache.
3. Legacy Manager-Wert `ua`, normalisiert zur Dokumentationslocale `uk`.
4. `language_fallback`, normalerweise `en`.
5. Neutrale Docs wie `docs/pages`, `docs/README.md` oder `index.md`.

Der Baum ist eine gemergte logische Ansicht, keine rohe Liste von Locale-Ordnern.
Lokalisierte Dateien gewinnen für denselben relativen Pfad, und fehlende
lokalisierte Branches werden aus der Fallback-Locale gefüllt. Wenn zum Beispiel
`docs/uk/ddocs` existiert, aber `docs/uk/evolution-cms` nicht, behält dDocs den
ukrainischen `ddocs` Branch und füllt `evolution-cms` aus `docs/en/evolution-cms`.

Der Baum soll nicht alle Locales gleichzeitig anzeigen und Fallback-Branches
nicht als separaten Sprachroot exponieren.

Dokumentations-Locale-Ordner müssen `uk` für ukrainischen Inhalt verwenden. Ein
legacy `docs/ua` Ordner darf nur als Migrationsalias gelesen werden und wird im
Index als `uk` exponiert.

## Erweiterungspunkte

| Oberfläche | Status | Regel |
| --- | --- | --- |
| Source Discovery | Interner Service | Paket-Roots über `DocsSourceRegistry` hinzufügen, nicht durch Umgehen von safe roots. |
| Renderer Post-Processing | Interner Frontend Runtime | Viewer Payload Shape, Link Maps, Image Maps, UML Maps und Code-Copy Verhalten erhalten. |
| Safe roots | Projektkonfiguration | Vertrauenswürdige Roots über Settings hinzufügen, nicht über Paketdefaults. |
| Manager Labels | Internal helper | `ManagerText` für Modul- und Settings-Labels verwenden. |
| Diagnostics | Guarded manager/debug route | Dateisystemmetadaten hinter dem diagnostics guard halten. |
| Search Indexing | Interner Service | Dateigrößenlimits und sichere Reads erhalten. |

## Pfadsicherheit

Alle Datei-Lese- und Schreibvorgänge müssen normalisierte Pfade und
safe-root-Prüfungen verwenden. Ein roher Pfad aus einem Request darf nie vertraut
werden.

Beschreibbare Aktionen sind auf Project Documentation beschränkt. Vendor-
Paketdokumentation wird indiziert und gerendert, aber nicht von der Manager-UI
geschrieben.

## Cache-Verhalten

Wenn `cache_index` aktiv ist, schreibt dDocs eine generierte PHP-Datei, die nur
Metadaten enthält. Sie speichert Source Nodes, Folder Nodes, Dokumentpfade,
Sprachmetadaten, Timestamps und Checksums. Sie speichert kein kanonisches Markdown
in der Datenbank.

Aktualisiere den Index nach manuellen Package-Doc-Änderungen, Root-
Konfigurationsänderungen oder Änderungen der Sprachstruktur.

## Frontend-Grenze

dDocs hat eine echte Frontend-Oberfläche: Blade shell, Livewire DOM, dTui/TOAST UI
Viewer, Prism und Browser Post-Processing. Dokumentationsspezifisches Tree/Viewer-
Verhalten bleibt lokal in dDocs, bis ein anderes Paket dasselbe Primitive braucht.
Gemeinsame Primitives werden über evo-ui promoted, statt kopiert.

## Verifikationskommandos

Führe diese Checks vor dem Release aus:

```bash
find . -path './vendor' -prune -o -name '*.php' -print0 | xargs -0 -n1 php -l
composer validate --no-check-publish
```

Führe dDocs Dokumentationschecks aus:

```bash
php docs/checks/docs-check.php
```

Führe den Demo Runtime Smoke aus dem installierten Manager-Demo aus, wenn verfügbar.
