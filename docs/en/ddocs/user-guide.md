# User Guide

This guide shows manager users how to read and maintain documentation in dDocs.
It focuses on tasks inside the Evolution CMS manager.

## Open The Documentation Module

1. Sign in to the Evolution CMS manager.
2. Open the Documentation module from the manager menu.
3. Wait for the left documentation tree and right viewer panel to load.

The home view lists available documentation sources. A source can be a package,
the dDocs package itself, or Project Documentation.

## Browse Package Docs

1. Select a source from the home view or the left tree.
2. Expand folders with the chevron.
3. Select a document.
4. Read the rendered Markdown in the right panel.

Vendor package docs are read-only. To change vendor docs, edit the files in the
package repository.

## Search Documentation

1. Click the search field in the sidebar.
2. Type a word from the document title, path, package name, or content.
3. Open a result from the filtered tree.
4. Clear the search field to return to the full tree.

dDocs skips files larger than `max_file_size_kb` so manager navigation stays
responsive.

## Understand Language Fallback

dDocs starts with the current manager language. If that locale is missing, it
falls back to English and then to neutral docs.

Ukrainian documentation uses `uk`. If an older manager still reports the legacy
`ua` language value, dDocs opens `uk` docs automatically.

## Switch Documentation Language

dDocs currently follows the manager language or the configured
`default_language`. Change the manager language or set `default_language` when a
project needs a fixed documentation language.

## Create A Project Document

1. Click the create document button in the sidebar toolbar.
2. Enter the document name.
3. Confirm the dialog.
4. dDocs creates a Markdown file in `ProjectDocs/` and opens it.

Project Documentation is the writable area for local project knowledge.

## Create A Project Folder

1. Click the create folder button in the sidebar toolbar.
2. Enter the folder name.
3. Confirm the dialog.
4. Open the new folder from the tree.

Folder and document names are converted to safe filenames before they are written
to disk.

## Edit A Project Document

1. Open a document from Project Documentation.
2. Click the edit action in the document header.
3. Update the Markdown in the editor.
4. Click save.

dDocs refreshes the file index after saving.

## Delete A Project Item

1. Open the context menu for a writable Project Documentation item.
2. Choose delete.
3. Confirm the dialog.

Deleting is not available for vendor package docs or root source folders.

## Copy Markdown Or Code

Use the copy action in the document header to copy the full Markdown source.
Use the copy action on a code block to copy only that snippet.

## Refresh The Index

1. Open the settings panel.
2. Click refresh index.
3. Wait for the refreshed document count.

Refresh the index after changing package docs manually or changing configured
documentation roots.

## Download Documentation As Markdown

1. Open the settings panel.
2. Click Download Markdown.
3. Save the generated `.md` file.

The export includes readable document nodes from the current dDocs index. Local
relative links and images keep their original source paths.

## Troubleshoot A Missing Document

If a document is missing:

1. Refresh the index.
2. Check that the file extension is allowed.
3. Check that the file is below `max_file_size_kb`.
4. Check that the package has a supported `docs/` structure.
5. Ask a developer to review the safe roots if the source is project-specific.
