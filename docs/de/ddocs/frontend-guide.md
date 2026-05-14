# Frontend Guide

dDocs nutzt evo-ui für den manager shell und dTui/TOAST UI für Markdown
rendering. Das ist ein internal frontend runtime, keine öffentliche frontend API.

## Boundary

- `views/docs/shell.blade.php` lädt dTui, Prism und viewer boot code.
- `views/livewire/module-panel.blade.php` rendert workspace, tree, folder
  listing und JSON payload.
- `views/partials/tree-node.blade.php` rendert recursive tree rows.

Das tree/viewer primitive bleibt lokal in dDocs. Wenn es reusable wird, soll es
über eine eigene evo-ui Aufgabe verschoben werden.

## No-Top-Tabs UX

dDocs verwendet absichtlich keinen oberen module tab strip für den documentation
workspace. Die Hauptnavigation ist der left source/tree panel und der right
document viewer. Future WebUI tab standardization darf top tabs nicht in dDocs
erzwingen.

## Local evo-ui Styling Exception

dDocs darf scoped styles für evo-ui form internals nur innerhalb von
`.ddocs-settings` verwenden, wenn die settings form in den document workspace
eingebettet ist. Erlaubte Ausnahmen: `.ddocs-settings .evo-ui-form-*`,
`.ddocs-search .evo-ui-input`, `.ddocs-modal .evo-ui-btn--danger` und
dTui/TOAST UI editor chrome in `.ddocs-editor`.

Globale evo-ui primitives dürfen nicht außerhalb eines `.ddocs-*` scope gestylt
werden. Wenn ein anderes package dasselbe pattern braucht, erstelle eine evo-ui
Aufgabe für ein shared primitive.

## Breaking Viewer Changes

Breaking changes:

- viewer payload shape;
- Livewire document selection method names;
- document node ids;
- link, image und UML map structure;
- code-copy behavior;
- internal Markdown link interception.
