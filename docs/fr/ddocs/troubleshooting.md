# Troubleshooting

## Le document n'apparaît pas

1. Rafraîchissez l'index.
2. Vérifiez que le package a `docs/`, `Docs/`, `README.md` ou `index.md`.
3. Vérifiez `allowed_extensions`.
4. Vérifiez `max_file_size_kb`.

## La documentation ukrainienne manque

1. Vérifiez `docs/uk`.
2. Déplacez legacy `docs/ua` vers `docs/uk`.
3. Rafraîchissez l'index.
4. Vérifiez `default_language`.

## Search est lent

Current search is filesystem live search. Metadata matches are fast, but content
matches can read Markdown files from disk.

1. Activez `cache_index`.
2. Réduisez les oversized Markdown files.
3. Gardez generated static-site output hors de `docs/`.
4. Pour les grands docs sets, planifiez un file-based `FileSearchIndexCache`.

## Search ne trouve pas document content

1. Vérifiez `allowed_extensions`.
2. Vérifiez `max_file_size_kb`.
3. Vérifiez que PHP peut lire le fichier.
4. Vérifiez que le fichier est inside indexed docs root.
5. Rafraîchissez l'index après move ou rename.

## Folder apparaît dans search results

Un folder peut apparaître parce qu'un matched child document est dedans. Le
folder ne contient pas forcément la query; dDocs garde parent folders comme tree
context.

## Le document projet ne se sauvegarde pas

1. Vérifiez que la source est Project Documentation.
2. Vérifiez writable safe root.
3. Vérifiez filesystem permissions.
