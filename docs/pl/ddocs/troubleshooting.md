# Troubleshooting

## Dokument nie jest widoczny

1. Odśwież index.
2. Sprawdź, czy package ma `docs/`, `Docs/`, `README.md` albo `index.md`.
3. Sprawdź `allowed_extensions`.
4. Sprawdź `max_file_size_kb`.

## Brakuje ukraińskiej dokumentacji

1. Sprawdź `docs/uk`.
2. Przenieś legacy `docs/ua` do `docs/uk`.
3. Odśwież index.
4. Sprawdź `default_language`.

## Search jest wolny

Current search is filesystem live search. Metadata matches are fast, but content
matches can read Markdown files from disk.

1. Włącz `cache_index`.
2. Zmniejsz oversized Markdown files.
3. Trzymaj generated static-site output poza `docs/`.
4. Dla dużych docs sets zaplanuj file-based `FileSearchIndexCache`.

## Search nie znajduje document content

1. Sprawdź `allowed_extensions`.
2. Sprawdź `max_file_size_kb`.
3. Sprawdź, czy PHP może przeczytać plik.
4. Sprawdź, czy plik jest inside indexed docs root.
5. Odśwież index po move albo rename.

## Folder pojawia się w search results

Folder może pojawić się dlatego, że matched child document jest wewnątrz niego.
Folder nie musi sam zawierać query; dDocs zachowuje parent folders jako tree
context.

## Dokument projektu nie zapisuje się

1. Sprawdź, czy source to Project Documentation.
2. Sprawdź writable safe root.
3. Sprawdź filesystem permissions.
