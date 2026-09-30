# Troubleshooting

Use this guide when dDocs does not show the expected documentation.

## Document Does Not Appear

1. Refresh the index from the settings panel.
2. Check that the package has `docs/`, legacy `Docs/`, `README.md`, or
   `index.md`.
3. Check that the file extension is listed in `allowed_extensions`.
4. Check that the file size is below `max_file_size_kb`.
5. Check the current manager language and fallback.
6. If the current locale tree is partial, check that `language_fallback` points
   to a locale that contains the missing branch.

## Ukrainian Document Is Missing

1. Check that Ukrainian docs live under `docs/uk`.
2. Move legacy `docs/ua` content to `docs/uk`.
3. Refresh the index.
4. Check that `default_language` does not force an unavailable locale.

dDocs normalizes legacy manager `ua` input to `uk`; it does not treat `ua` as a
public documentation locale.

## Fallback Branch Does Not Appear

1. Check that `language_fallback` is configured, usually as `en`.
2. Check that the missing branch exists under the fallback locale, such as
   `docs/en/evolution-cms`.
3. Refresh the index from the settings panel.
4. Check that the fallback files use allowed Markdown extensions and are under
   the package docs root.

Localized files win over fallback files with the same relative path. Fallback
only fills missing branches or documents.

## Document Opens But Content Is Empty

1. Hard reload the manager tab.
2. Check the browser console for Livewire or dTui errors.
3. Refresh the index.
4. Check that the document is readable and inside its docs root.

## Local Image Is Blocked

1. Move the image under the package docs root.
2. Use a relative Markdown image path.
3. Check that the extension is allowed.
4. Check that the image is below `max_file_size_kb`.

## UML Does Not Render

1. Check that the block uses the `$$uml` format.
2. Check that the configured renderer URL is reachable.
3. Check that the source does not include unsupported remote theme directives.

## Search Feels Slow

Current search is filesystem live search. Metadata matches are fast, but content
matches may read Markdown files from disk.

1. Enable `cache_index` so navigation metadata is cached.
2. Reduce oversized Markdown files.
3. Keep generated static-site output outside `docs/`.
4. Use `docs_old/` for legacy generated docs.
5. For large documentation sets, plan a file-based `FileSearchIndexCache`.

## Search Does Not Find Document Content

1. Check that the file extension is listed in `allowed_extensions`.
2. Check that the file is below `max_file_size_kb`.
3. Check that the file is readable by PHP.
4. Check that the file is inside an indexed docs root.
5. Refresh the index after moving or renaming docs.

## Search Finds Old Content

1. Refresh the index.
2. Save project documents through the dDocs UI when possible.
3. Check that the result does not come from another indexed package or locale.
4. Clear the generated index cache when filesystem metadata is stale.

## Folder Appears In Search Results

Folders are returned when a child document matches. The folder itself may not
contain the query. dDocs keeps parent folders visible so the filtered tree still
has context.

## Large Markdown File Is Not Searched

Files above `max_file_size_kb` are skipped by safe reads. Split the file or raise
the project setting only for trusted documentation roots.

## Search Returns Too Many Results

The current search has no scoring, snippets, or query syntax. Narrow the query
with title/path terms for now. Advanced filters such as `source:`, `path:`,
`type:`, and `lang:` belong to the search-index roadmap.

## Diagnostics Are Missing

Diagnostics are intentionally gated. Use a manager account with settings
permission or enable debug mode in a local environment.

## Project Document Cannot Be Saved

1. Confirm that the selected source is Project Documentation.
2. Check that the target path is inside a writable safe root.
3. Check filesystem permissions.
4. Rename the file or folder if filename normalization removed unsafe
   characters.

## Damaged Index Cache

A truncated `ddocs-index.php` can contain an incomplete PHP expression. dDocs
treats that cache as a miss and rebuilds the index from documentation files.
New indexes are written to a temporary file in the same directory and replace
the previous cache only after the full payload has been written. Source
documents are unchanged.

If corruption recurs, check free disk space, cache directory write permissions,
and whether deployment transfers complete files. Use Refresh index in the
dDocs settings panel to rebuild the cache manually.
