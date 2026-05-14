# Troubleshooting

## Dokument erscheint nicht

1. Aktualisiere den Index.
2. Prüfe, ob das package `docs/`, `Docs/`, `README.md` oder `index.md` hat.
3. Prüfe `allowed_extensions`.
4. Prüfe `max_file_size_kb`.

## Ukrainische Dokumentation fehlt

1. Prüfe `docs/uk`.
2. Verschiebe legacy `docs/ua` nach `docs/uk`.
3. Aktualisiere den Index.
4. Prüfe `default_language`.

## Search ist langsam

Current search is filesystem live search. Metadata matches are fast, but content
matches can read Markdown files from disk.

1. Aktiviere `cache_index`.
2. Reduziere oversized Markdown files.
3. Halte generated static-site output außerhalb von `docs/`.
4. Für große docs sets plane einen file-based `FileSearchIndexCache`.

## Search findet document content nicht

1. Prüfe `allowed_extensions`.
2. Prüfe `max_file_size_kb`.
3. Prüfe, ob PHP die Datei lesen kann.
4. Prüfe, ob die Datei inside indexed docs root liegt.
5. Aktualisiere den Index nach move oder rename.

## Folder erscheint in search results

Ein folder kann erscheinen, weil ein matched child document darin liegt. Der
folder muss die query nicht selbst enthalten; dDocs behält parent folders als
tree context.

## Projektdokument wird nicht gespeichert

1. Prüfe, ob die Quelle Project Documentation ist.
2. Prüfe writable safe root.
3. Prüfe filesystem permissions.
