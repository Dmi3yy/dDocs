# Przewodnik dewelopera

dDocs jest file-first. Dokumentacja pakietów jest Markdownem na filesystem;
database nie jest canonical storage.

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
| `DocsSourceRegistry` | Znajduje package docs, project docs, configured roots i source metadata. |
| `DocsIndexer` | Buduje folder/document nodes ze stable ids, language metadata, timestamps i checksums. |
| `FileIndexCache` | Zapisuje i odświeża generated PHP metadata cache. |
| `FileDocumentRepository` | Czyta Markdown files po safety checks. |
| `LanguageResolver` | Normalizuje legacy `ua` input do `uk`, obsługuje fallback i neutral docs. |
| `LinkResolver` | Obsługuje internal links, local images, safe HTML, code languages i UML image URLs. |

## Runtime Lookup

- Routes i node metadata: [Reference](reference.md).
- Config keys i defaults: [Konfiguracja](configuration.md).
- Viewer payload i breaking changes: [Frontend Guide](frontend-guide.md).

## Search Runtime Model

dDocs używa filesystem live search: live filter nad file index, nie osobnego
search engine ani full-text index.

`DocsIndexer` buduje navigation metadata nodes. `FileIndexCache` zapisuje nodes
jako generated PHP metadata dla drzewa. Cache nie zawiera normalized document
text, tokens, headings ani snippets.

`ModulePanel` pobiera nodes z `FileIndexCache` i przekazuje je do `FileSearch`.
`FileSearch` najpierw sprawdza metadata fields: title, relative path, source
name i package name. Dla document nodes może potem przeczytać Markdown przez
`FileDocumentRepository`.

Content search czyta tylko indexed document nodes, allowed extensions, safe docs
roots i pliki poniżej `max_file_size_kb`. Parent folders są dodawane tylko jako
tree context dla matched child documents.

## Search Roadmap

Następny etap powinien pozostać filesystem-first: generated file-based
`FileSearchIndexCache`, bez database table i bez external search service.

Roadmap: oddzielić navigation index od search index, robić incremental rebuild
po checksum/mtime, zapisać normalized text, headings, tokens i snippets, dodać
scoring, snippets, client-side highlight, proste filters `source:`, `path:`,
`type:`, `lang:` oraz search modes.

## Safety

Każdy file read/write musi przejść przez normalized paths i safe-root checks.
Writable actions są ograniczone do Project Documentation. Vendor docs są
indeksowane i renderowane, ale manager UI ich nie zapisuje.
