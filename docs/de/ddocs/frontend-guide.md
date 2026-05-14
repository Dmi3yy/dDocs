# Frontend guide

dDocs nutzt evo-ui für die Manager-Shell und dTui/TOAST UI für Markdown-Rendering.
Das ist ein interner Frontend-Runtime, keine öffentliche Frontend-API für
Consumer-Pakete.

## Runtime-Grenze

- `views/docs/shell.blade.php` besitzt das Manager-iframe-Dokument, lokale dTui
  Assets, Prism Assets und den Viewer-Bootcode.
- `views/livewire/module-panel.blade.php` besitzt den dDocs Workspace, Baum,
  Folder Listing, Dokumentkopf und JSON Payload für den Viewer.
- `views/partials/tree-node.blade.php` besitzt rekursive Baumzeilen.
- dDocs rendert Markdown im Browser aus einem JSON Payload, statt HTML auf dem
  Server zu rendern.

## evo-ui Grenze

dDocs soll den visuellen evo-ui Konventionen für Icons, kompakte
Manager-Kontrollen, Theme Tokens, Modals und Settings-Forms folgen. Der
Tree/Viewer Workspace ist aktuell lokal in dDocs, weil er ein
dokumentationsspezifisches Interaktionsmodell ist. Wenn er wiederverwendbar wird,
soll er über eine evo-ui Aufgabe promoted werden, statt die Implementierung in
ein anderes Paket zu kopieren.

## UX ohne obere Tabs

dDocs verwendet absichtlich nicht den normalen oberen Modul-Tabstrip für den
Dokumentationsworkspace. Die primäre Navigation ist das linke Source/Tree-Panel
und der rechte Dokument-Viewer. Zukünftige WebUI-Tab-Standardisierung darf keine
Top-Tabs in dDocs erzwingen, außer das Modul bekommt mehrere gleichrangige
Workspaces, die Tab-Navigation brauchen.

Settings bleiben verfügbar, werden aber als kompakte Aktion des Dokumenten-
Workspaces behandelt, nicht als top-level Modul-Tab.

## Lokale evo-ui Styling-Ausnahme

dDocs darf scoped styles für interne evo-ui Formularelemente nur innerhalb von
`.ddocs-settings` anwenden, wenn das Settings-Formular in den Dokumentenworkspace
eingebettet wird. Diese Ausnahme existiert, weil dDocs den verschachtelten
Formular-Heading/Tabs versteckt und Sektionen als Teil der Reader-Oberfläche
anordnet.

Erlaubte lokale Ausnahmen:

- `.ddocs-settings .evo-ui-form-*` nur für eingebettetes Settings-Layout;
- `.ddocs-search .evo-ui-input` nur für die Größe des Sidebar-Suchfelds;
- `.ddocs-modal .evo-ui-btn--danger` nur für die Delete-Bestätigung;
- dTui/TOAST UI Editor-Chrome innerhalb von `.ddocs-editor`.

Style keine globalen evo-ui Primitives außerhalb eines `.ddocs-*` Scopes. Wenn
ein anderes Paket dasselbe Pattern braucht, erstelle eine evo-ui Aufgabe für ein
gemeinsames Primitive oder eine Variante, statt dDocs CSS zu kopieren.

## Viewer Payload

Der Dokument-Viewer erhält:

```json
{
  "id": "document-node-id",
  "markdown": "# Document",
  "links": [],
  "images": [],
  "uml": []
}
```

Livewire besitzt Dokumentauswahl und sichere Dateilesevorgänge. Browser-Code
besitzt TOAST UI Rendering, Code-Copy Chrome, Abfangen interner Links, sichere
Ersetzung lokaler Bilder und UML Recovery.

## Breaking Viewer Changes

Behandle diese Änderungen als breaking changes für den dDocs Viewer:

- Form des Viewer Payload;
- Namen der Livewire-Methoden für Dokumentauswahl;
- Dokumentknoten-IDs;
- Struktur von Link-, Image- und UML-Maps;
- Verhalten des Code-Copy Buttons;
- Abfangen interner Markdown-Links;
- Sicherheitsverhalten lokaler Bilder.

## Erweiterungsregeln

- Halte Paketdokumentation als Markdown-Dateien; füge keine generierte HTML-Navigation hinzu.
- Halte relative Links innerhalb des Paket-Docs-Baums.
- Halte eigenes Viewer-Verhalten in dDocs, bis mindestens zwei Pakete es brauchen.
- Nutze evo-ui Tokens und vorhandene Icon-Komponenten, bevor du lokales CSS ergänzt.
- Ergänze Browser smoke checks, wenn Viewer-Boot, Livewire Keys oder dTui Post-Processing geändert werden.
