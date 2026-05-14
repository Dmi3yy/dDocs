# Frontend Guide

dDocs utilise evo-ui pour le manager shell et dTui/TOAST UI pour le rendu
Markdown. C'est un internal frontend runtime, pas une frontend API publique.

## Boundary

- `views/docs/shell.blade.php` charge dTui, Prism et viewer boot code.
- `views/livewire/module-panel.blade.php` rend workspace, tree, folder listing
  et JSON payload.
- `views/partials/tree-node.blade.php` rend les recursive tree rows.

Le tree/viewer primitive reste local dans dDocs. S'il devient reusable, il doit
être déplacé vers evo-ui via une tâche dédiée.

## No-Top-Tabs UX

dDocs n'utilise volontairement pas le module tab strip supérieur pour le
documentation workspace. La navigation principale est le left source/tree panel
et le right document viewer. Future WebUI tab standardization ne doit pas forcer
top tabs dans dDocs.

## Local evo-ui Styling Exception

dDocs peut appliquer des scoped styles aux evo-ui form internals uniquement dans
`.ddocs-settings`, quand la settings form est intégrée au document workspace.
Exceptions autorisées: `.ddocs-settings .evo-ui-form-*`,
`.ddocs-search .evo-ui-input`, `.ddocs-modal .evo-ui-btn--danger` et le chrome
dTui/TOAST UI editor dans `.ddocs-editor`.

Ne stylez pas global evo-ui primitives hors d'un scope `.ddocs-*`. Si un autre
package a besoin du même pattern, créez une tâche evo-ui pour un shared
primitive.

## Breaking Viewer Changes

Breaking changes:

- viewer payload shape;
- Livewire document selection method names;
- document node ids;
- link, image et UML map structure;
- code-copy behavior;
- internal Markdown link interception.
