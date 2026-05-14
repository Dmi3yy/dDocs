# Guide développeur

dDocs est file-first. La documentation des paquets vit comme Markdown dans le
filesystem; la database n'est pas le canonical storage.

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
| `DocsSourceRegistry` | Trouve package docs, project docs, configured roots et source metadata. |
| `DocsIndexer` | Construit folder/document nodes avec stable ids, language metadata, timestamps et checksums. |
| `FileIndexCache` | Stocke et rafraîchit generated PHP metadata cache. |
| `FileDocumentRepository` | Lit les Markdown files après safety checks. |
| `LanguageResolver` | Normalise legacy `ua` input vers `uk`, applique fallback et trouve neutral docs. |
| `LinkResolver` | Gère internal links, local images, safe HTML, code languages et UML image URLs. |

## Runtime Lookup

- Routes et node metadata: [Reference](reference.md).
- Config keys et defaults: [Configuration](configuration.md).
- Viewer payload et breaking changes: [Frontend Guide](frontend-guide.md).

## Search Runtime Model

dDocs utilise filesystem live search: un live filter sur le file index, pas un
search engine séparé ni un full-text index.

`DocsIndexer` construit les navigation metadata nodes. `FileIndexCache` stocke
ces nodes comme generated PHP metadata pour l'arbre. Ce cache ne contient pas de
normalized document text, tokens, headings ou snippets.

`ModulePanel` lit les nodes depuis `FileIndexCache` et les passe à `FileSearch`.
`FileSearch` vérifie d'abord les metadata fields: title, relative path, source
name et package name. Pour les document nodes, il peut ensuite lire le Markdown
via `FileDocumentRepository`.

Content search lit seulement indexed document nodes, allowed extensions, safe
docs roots et les fichiers sous `max_file_size_kb`. Parent folders sont ajoutés
seulement comme tree context pour les matched child documents.

## Search Roadmap

La prochaine étape doit rester filesystem-first: un generated file-based
`FileSearchIndexCache`, sans database table et sans external search service.

Roadmap: séparer navigation index et search index, faire incremental rebuild
avec checksum/mtime, stocker normalized text, headings, tokens et snippets,
ajouter scoring, snippets, client-side highlight, filtres simples `source:`,
`path:`, `type:`, `lang:` et search modes.

## Safety

Chaque file read/write doit passer par normalized paths et safe-root checks.
Writable actions est limité à Project Documentation. Les vendor docs sont
indexées et rendues, mais le manager UI ne les écrit pas.
