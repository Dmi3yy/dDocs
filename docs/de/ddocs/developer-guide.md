# Entwicklerhandbuch

dDocs ist file-first. Paketdokumentation lebt als Markdown im filesystem; die
database ist kein canonical storage.

```text
DocsSourceRegistry -> DocsIndexer -> FileIndexCache
                                  -> FileDocumentRepository
ModulePanel        -> raw Markdown payload
Browser viewer     -> dTui/TOAST UI + Prism
LinkResolver       -> link, image, and UML maps
DocumentPath       -> path safety checks
FileSearch         -> title, path, source, and content search
```

## Services

| Service | Responsibility |
| --- | --- |
| `DocsSourceRegistry` | Findet package docs, project docs, configured roots und source metadata. |
| `DocsIndexer` | Baut folder/document nodes mit stable ids, language metadata, timestamps und checksums. |
| `FileIndexCache` | Speichert und aktualisiert generated PHP metadata cache. |
| `FileDocumentRepository` | Liest Markdown files nach safety checks. |
| `LanguageResolver` | Normalisiert legacy `ua` input zu `uk`, wendet fallback an und findet neutral docs. |
| `LinkResolver` | Verarbeitet internal links, local images, safe HTML, code languages und UML image URLs. |

## Runtime Lookup

- Routes und node metadata: [Reference](reference.md).
- Config keys und defaults: [Konfiguration](configuration.md).
- Viewer payload und breaking changes: [Frontend Guide](frontend-guide.md).

## Search Runtime Model

dDocs verwendet filesystem live search: einen live filter über den file index,
keinen separaten search engine und keinen full-text index.

`DocsIndexer` baut navigation metadata nodes. `FileIndexCache` speichert diese
nodes als generated PHP metadata für den Baum. Der Cache enthält keinen
normalized document text, keine tokens, headings oder snippets.

`ModulePanel` liest nodes aus `FileIndexCache` und übergibt sie an `FileSearch`.
`FileSearch` prüft zuerst metadata fields: title, relative path, source name und
package name. Für document nodes kann es danach Markdown über
`FileDocumentRepository` lesen.

Content search liest nur indexed document nodes, allowed extensions, safe docs
roots und Dateien unter `max_file_size_kb`. Parent folders werden nur als tree
context für matched child documents zurückgegeben.

## Search Roadmap

Der nächste Schritt sollte filesystem-first bleiben: ein generated file-based
`FileSearchIndexCache`, keine database table und kein external search service.

Roadmap: navigation index und search index trennen, incremental rebuild über
checksum/mtime, normalized text, headings, tokens und snippets speichern,
scoring, snippets, client-side highlight, einfache filters `source:`, `path:`,
`type:`, `lang:` und search modes hinzufügen.

## Safety

Jeder file read/write muss normalized paths und safe-root checks durchlaufen.
Writable actions sind auf Project Documentation begrenzt. Vendor docs werden
indiziert und gerendert, aber nicht im manager UI geschrieben.
