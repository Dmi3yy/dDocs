# Frontend Guide

dDocs використовує evo-ui для manager shell і dTui/TOAST UI для Markdown
rendering. Це internal frontend runtime, not a public frontend API.

## Runtime Boundary

- `views/docs/shell.blade.php` відповідає за manager iframe document, локальні
  dTui assets, Prism assets, manager viewport request і viewer boot code.
- `views/livewire/module-panel.blade.php` відповідає за workspace, tree, folder
  listing, document header і JSON payload для viewer.
- `views/partials/tree-node.blade.php` відповідає за recursive tree rows.
- dDocs рендерить Markdown у браузері з JSON payload, а не серверним HTML.

## evo-ui Boundary

dDocs має триматися evo-ui conventions для icons, compact manager controls,
theme tokens, modals і settings forms. Tree/viewer workspace поки локальний для
dDocs, бо це документаційна модель взаємодії. Якщо вона стане reusable, її
треба переносити в evo-ui через окрему задачу, а не копіювати в інші пакети.

## No-Top-Tabs UX

dDocs навмисно не використовує стандартний верхній module tab strip для
documentation workspace. Основна навігація - left source/tree panel і right
document viewer. Майбутня WebUI tab standardization не має примусово додавати
top tabs у dDocs, поки в модулі немає кількох рівноправних workspaces.

Settings доступні, але вони працюють як compact document workspace action, а не
як верхня module tab.

## Manager Viewport

dDocs займає повний manager workspace і просить manager приховати дерево
ресурсів через системний helper:

```html
<script>window.parent?.evo?.moduleViewport?.requestHiddenTree(window);</script>
```

Shell тільки повідомляє активний iframe intent. Відновлення дерева при переході
на інші вкладки або стандартні manager screens має виконувати `evo.moduleViewport`
у manager runtime.

## Local evo-ui Styling Exception

dDocs може мати scoped styles для evo-ui form internals тільки всередині
`.ddocs-settings`, коли settings form вбудована у document workspace. Виняток
потрібний, бо dDocs ховає nested form heading/tabs і розкладає sections як
частину reader surface.

Дозволені локальні винятки:

- `.ddocs-settings .evo-ui-form-*` тільки для embedded settings layout;
- `.ddocs-search .evo-ui-input` тільки для sizing sidebar search field;
- `.ddocs-modal .evo-ui-btn--danger` тільки для delete confirmation action;
- dTui/TOAST UI editor chrome всередині `.ddocs-editor`.

Не стилізуйте global evo-ui primitives поза `.ddocs-*` scope. Якщо інший пакет
потребує такого самого pattern, створіть evo-ui task для shared primitive або
variant, а не копіюйте CSS із dDocs.

## Viewer Payload

Document viewer отримує:

```json
{
  "id": "document-node-id",
  "markdown": "# Document",
  "links": [],
  "images": [],
  "uml": []
}
```

Livewire відповідає за document selection і safe file reads. Browser code
відповідає за TOAST UI rendering, code-copy chrome, internal link interception,
safe local image replacement і UML recovery.

## Breaking Viewer Changes

Treat these as breaking changes для dDocs viewer:

- viewer payload shape;
- Livewire document selection method names;
- document node ids;
- link, image, and UML map structure;
- code-copy button behavior;
- internal Markdown link interception;
- local image safety behavior.

## Extension Rules

- Package docs залишаються Markdown файлами; generated HTML navigation не
  додаємо.
- Relative links мають лишатися всередині package docs tree.
- Custom viewer behavior тримаємо в dDocs, поки мінімум два пакети не потребують
  такого самого primitive.
- Спершу використовуємо evo-ui tokens і icon components, а вже потім локальний
  CSS.
- Для змін viewer boot, Livewire keys або dTui post-processing потрібні browser
  smoke checks.
