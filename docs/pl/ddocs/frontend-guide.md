# Frontend Guide

dDocs używa evo-ui dla manager shell oraz dTui/TOAST UI do renderowania
Markdown. To internal frontend runtime, a nie publiczne frontend API.

## Boundary

- `views/docs/shell.blade.php` ładuje dTui, Prism i viewer boot code.
- `views/livewire/module-panel.blade.php` renderuje workspace, tree, folder
  listing i JSON payload.
- `views/partials/tree-node.blade.php` odpowiada za recursive tree rows.

Tree/viewer primitive pozostaje lokalny w dDocs. Jeśli stanie się reusable,
należy przenieść go do evo-ui przez osobne zadanie.

## No-Top-Tabs UX

dDocs celowo nie używa górnego module tab strip dla documentation workspace.
Główna nawigacja to left source/tree panel i right document viewer. Future WebUI
tab standardization nie powinna wymuszać top tabs w dDocs.

## Local evo-ui Styling Exception

dDocs może stosować scoped styles dla evo-ui form internals tylko wewnątrz
`.ddocs-settings`, gdy settings form jest osadzony w document workspace.
Dozwolone wyjątki: `.ddocs-settings .evo-ui-form-*`,
`.ddocs-search .evo-ui-input`, `.ddocs-modal .evo-ui-btn--danger` oraz
dTui/TOAST UI editor chrome w `.ddocs-editor`.

Nie stylizuj global evo-ui primitives poza `.ddocs-*` scope. Jeśli inny package
potrzebuje tego samego pattern, utwórz evo-ui task dla shared primitive.

## Breaking Viewer Changes

Breaking changes:

- viewer payload shape;
- Livewire document selection method names;
- document node ids;
- link, image i UML map structure;
- code-copy behavior;
- internal Markdown link interception.
