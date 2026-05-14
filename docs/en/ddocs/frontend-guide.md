# Frontend Guide

dDocs uses evo-ui for the manager shell and dTui/TOAST UI for Markdown rendering.
This is an internal frontend runtime, not a public frontend API for consumer
packages.

## Runtime Boundary

- `views/docs/shell.blade.php` owns the manager iframe document, local dTui
  assets, Prism assets, and viewer boot code.
- `views/livewire/module-panel.blade.php` owns the dDocs workspace, tree, folder
  listing, document header, and JSON payload for the viewer.
- `views/partials/tree-node.blade.php` owns recursive tree rows.
- dDocs renders Markdown in the browser from a JSON payload instead of rendering
  HTML on the server.

## evo-ui Boundary

dDocs should follow evo-ui visual conventions for icons, compact manager
controls, theme tokens, modals, and settings forms. The tree/viewer workspace is
currently local to dDocs because it is a documentation-specific interaction
model. If it becomes reusable, promote it through an evo-ui task instead of
copying the implementation into another package.

## No-Top-Tabs UX

dDocs intentionally does not use the standard upper module tab strip for the
documentation workspace. The primary navigation is the left source/tree panel
and the right document viewer. Future WebUI tab standardization must not force
top tabs into dDocs unless the module gains multiple peer workspaces that need
tab navigation.

Settings are still available, but they are treated as a compact document
workspace action rather than a top-level module tab.

## Local evo-ui Styling Exception

dDocs may apply scoped styles to evo-ui form internals only inside
`.ddocs-settings` while embedding the settings form into the document workspace.
This exception exists because dDocs hides the nested form heading/tabs and lays
sections out as part of the reader surface.

Allowed local exceptions:

- `.ddocs-settings .evo-ui-form-*` for embedded settings layout only;
- `.ddocs-search .evo-ui-input` for the sidebar search field sizing only;
- `.ddocs-modal .evo-ui-btn--danger` for the delete confirmation action only;
- dTui/TOAST UI editor chrome inside `.ddocs-editor`.

Do not style global evo-ui primitives outside a `.ddocs-*` scope. If another
package needs the same pattern, create an evo-ui task for a shared primitive or
variant instead of copying dDocs CSS.

## Viewer Payload

The document viewer receives:

```json
{
  "id": "document-node-id",
  "markdown": "# Document",
  "links": [],
  "images": [],
  "uml": []
}
```

Livewire owns document selection and safe file reads. Browser code owns TOAST UI
rendering, code-copy chrome, internal link interception, safe local image
replacement, and UML recovery.

## Breaking Viewer Changes

Treat these as breaking changes for the dDocs viewer:

- viewer payload shape;
- Livewire document selection method names;
- document node ids;
- link, image, and UML map structure;
- code-copy button behavior;
- internal Markdown link interception;
- local image safety behavior.

## Extension Rules

- Keep package docs as Markdown files; do not add generated HTML navigation.
- Keep relative links inside the package docs tree.
- Keep custom viewer behavior in dDocs until at least two packages need it.
- Use evo-ui tokens and existing icon components before adding local CSS.
- Add browser smoke checks when changing viewer boot, Livewire keys, or dTui
  post-processing.
