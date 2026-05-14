# Markdown example

This file is a smoke document for the dDocs viewer and dTui Editor. It
intentionally includes the formats we want Evolution package documentation to
support: core Markdown, GitHub-style tables, code fences, Prism languages,
relative links, external smoke images, raw HTML safety examples, and PlantUML
blocks.

## Quick checklist

- Open this document in the dDocs viewer.
- Check that headings, lists, tables, quote blocks, and links look like readable
  GitHub-like documentation.
- Check that code blocks have a compact copy button and correct highlighting.
- Check that `$$uml` blocks render as diagrams, not plain text.
- Open this file in the editor and check Markdown, Split, and WYSIWYG modes.

---

## h1-style Heading 8-)

## h2 Heading

### h3 Heading

#### h4 Heading

##### h5 Heading

###### h6 Heading

## Horizontal Rules

___

---

***

## Typographic replacements

Enable typographer option to see result.

(c) (C) (r) (R) (tm) (TM) (p) (P) +-

test.. test... test..... test?..... test!....

!!!!!! ???? ,,  -- ---

"Smartypants, double quotes" and 'single quotes'

## Paragraphs

Documentation paragraphs should be short enough to scan. dDocs is used by
humans and by AI agents, so the best paragraphs explain one workflow, one
contract, or one decision at a time.

Line breaks inside the same paragraph should stay readable, while blank lines
create a new paragraph.

## Emphasis

**This is bold text**

__This is bold text__

*This is italic text*

_This is italic text_

~~Strikethrough~~

Use `inline code` for paths, config keys, commands, class names, and ids.

Keyboard example with safe inline HTML: <kbd>Cmd</kbd> + <kbd>K</kbd>.

## Blockquotes

> Blockquotes can also be nested...
>> ...by using additional greater-than signs right next to each other...
> > > ...or with spaces between arrows.

> Use blockquotes for warnings, quoted decisions, and notes copied from an
> external source.

## Lists

Unordered:

+ Create a list by starting a line with `+`, `-`, or `*`.
+ Sub-lists are made by indenting 2 spaces:
  - Marker character change forces new list start:
    * Ac tristique libero volutpat at
    + Facilisis in pretium nisl aliquet
    - Nulla volutpat aliquam velit
+ Very easy!

Ordered:

1. Lorem ipsum dolor sit amet
2. Consectetur adipiscing elit
3. Integer molestie lorem at massa

Numbering can stay stable during editing:

1. You can use sequential numbers...
1. ...or keep all the numbers as `1.`

Start numbering with offset:

57. foo
1. bar

Task list:

- [x] Add Markdown viewer.
- [x] Add client-side rendering.
- [ ] Verify all docs in dDocs.

## Code

Inline `code`.

Indented code:

    // Some comments
    line 1 of code
    line 2 of code
    line 3 of code

Plain fenced code:

```text
Sample text here...
```

### Supported Prism languages

Use a language name after the opening fence. dTui currently highlights these
languages and aliases.

#### Bash

```bash
php artisan package:installrequire dmi3yy/ddocs "*"
php artisan vendor:publish --provider="Dmi3yy\\dDocs\\dDocsServiceProvider" --tag=ddocs-config
php artisan view:clear
```

```sh
cd core
php artisan cache:clear-full
```

```shell
rg "Docs" vendor composer.json
```

#### PHP

```php
<?php

return [
    'enabled' => true,
    'language_fallback' => 'en',
    'allowed_extensions' => ['md', 'mdx'],
    'max_file_size_kb' => 512,
];
```

#### Blade

```blade
<x-evo::layout :title="$pageTitle">
    <livewire:ddocs.module-panel />

    @if ($document)
        <x-evo::button icon="copy" wire:click="copyDocument" />
    @endif
</x-evo::layout>
```

```laravel-blade
{{-- Alias example --}}
@foreach ($documents as $document)
    <x-evo::badge>{{ $document['title'] }}</x-evo::badge>
@endforeach
```

```bladephp
{!! $safeHtml !!}
```

#### JavaScript

```javascript
const payload = JSON.parse(document.querySelector('[data-ddocs-viewer]').textContent);

document.addEventListener('click', (event) => {
  const link = event.target.closest('a[data-ddocs-target]');
  if (!link) return;

  event.preventDefault();
  Livewire.dispatch('ddocs-open-document', { id: link.dataset.ddocsTarget });
});
```

#### TypeScript

```typescript
type DocsNode = {
  id: string;
  title: string;
  type: 'folder' | 'document';
  children?: DocsNode[];
};

const isDocument = (node: DocsNode): boolean => node.type === 'document';
```

#### HTML

```html
<article class="markdown-body">
  <h1>Documentation</h1>
  <p>Rendered in the Evolution manager.</p>
</article>
```

#### XML

```xml
<module name="dDocs">
  <icon>book-open</icon>
  <title>Documentation</title>
</module>
```

#### CSS

```css
.ddocs-viewer {
  min-height: 0;
  overflow: auto;
  color: var(--evo-text);
}
```

#### SCSS

```scss
.ddocs-card {
  border: 1px solid var(--evo-border);

  &:hover {
    border-color: var(--evo-accent);
  }
}
```

#### JSON

```json
{
  "source_key": "ddocs",
  "title": "Documentation",
  "language": "en",
  "documents": 12
}
```

#### YAML

```yaml
title: Developer Guide
sidebar_label: Developer
sidebar_position: 20
tags:
  - docs
  - evolution
```

```yml
cache_index: true
index_cache_path: core/cache/ddocs-index.php
```

#### SQL

```sql
select id, title, status
from tasks
where project_key = 'ddocs'
order by position asc;
```

#### Markdown

```markdown
# Package Name Documentation

Short explanation of what the package does.

## Guides

- [User Guide](user-guide.md)
- [Developer Guide](developer-guide.md)
```

#### Diff fallback

```diff
- Server-side Markdown HTML rendering
+ Client-side Markdown rendering with dTui viewer
```

## Tables

| Option | Description |
| ------ | ----------- |
| data   | path to data files to supply the data that will be passed into templates. |
| engine | engine to be used for processing templates. Handlebars is the default. |
| ext    | extension to be used for dest files. |

Right aligned columns:

| Option | Description |
| ------:| -----------:|
| data   | path to data files to supply the data that will be passed into templates. |
| engine | engine to be used for processing templates. Handlebars is the default. |
| ext    | extension to be used for dest files. |

Merged cells from the TOAST UI table-merged-cell plugin:

| @cols=2:merged |
| --- | --- |
| table | table2 |

Evolution package metadata:

| Field | Required | Example |
| --- | ---: | --- |
| `name` | yes | `dmi3yy/ddocs` |
| `title` | yes | `Documentation` |
| `icon` | yes | `book-open` |
| `description` | recommended | File-first docs browser. |

## Links

[Configuration](configuration.md)

[Developer Guide](developer-guide.md)

[Documentation Standards](documentation-standards.md)

Missing local link example:

```markdown
[Missing local link](missing-document.md)
```

[External link](https://github.com/evolution-cms/evolution)

[External link with title](https://github.com/evolution-cms/evolution "title text!")

Autoconverted link: https://github.com/evolution-cms/evolution

Reference link to [configuration][config].

[config]: configuration.md

## Images

These external images are deliberate remote-image smoke examples. Normal package
documentation should prefer images stored under `docs/assets/`.

External PNG smoke example:

![External PNG smoke example](https://octodex.github.com/images/minion.png)

External JPG smoke example with title:

![External JPG smoke example](https://octodex.github.com/images/stormtroopocat.jpg "External JPG smoke example")

Reference-style external image:

![Reference-style external smoke example][octocat]

[octocat]: https://octodex.github.com/images/dojocat.jpg "Reference-style external smoke example"

Blocked local image example. Keep unsafe paths as code so editor preview does not show a broken image:

```markdown
![Blocked path traversal](../../../../etc/passwd)
```

## Raw HTML safety

Safe inline HTML can be useful:

<details open>
<summary>Open details</summary>
<div class="ddocs-details-body">
<p>This content should stay readable in the viewer.</p>
<p><mark>Marked by raw HTML</mark></p>
</div>
</details>

Unsafe HTML must never execute. Keep examples inside code fences:

```html
<script>alert('blocked')</script>
<iframe src="https://example.com"></iframe>
```

## Markdown-it style plugin syntax

These examples verify the markdown-it style syntax that dDocs normalizes before
rendering in the manager: emoji aliases, sub/sup, inserted/marked text,
footnotes, definition lists, abbreviations, and warning containers. If a new
plugin syntax is not supported yet, it must remain readable as text and must not
break the page.

### Emojis

Classic markup: :wink: :cry: :laughing: :yum:

Shortcuts: :-) :-( 8-) ;)

### Subscript and Superscript

- 19^th^
- H~2~O

### Inserted and Marked Text

++Inserted text++

==Marked text==

### Footnotes

Footnote 1 link[^first].

Footnote 2 link[^second].

Inline footnote^[Text of inline footnote] definition.

Duplicated footnote reference[^second].

[^first]: Footnote **can have markup**

    and multiple paragraphs.

[^second]: Footnote text.

### Definition Lists

Term 1

:   Definition 1
with lazy continuation.

Term 2 with *inline markup*

:   Definition 2

        { some code, part of Definition 2 }

    Third paragraph of definition 2.

_Compact style:_

Term 1
  ~ Definition 1

Term 2
  ~ Definition 2a
  ~ Definition 2b

### Abbreviations

This is HTML abbreviation example.

It converts "HTML", but keeps partial entries like "xxxHTMLyyy" intact.

*[HTML]: Hyper Text Markup Language

### Custom Containers

::: warning
*here be dragons*
:::

## PlantUML blocks

dDocs keeps `$$uml` blocks as Markdown custom blocks for dTui/TOAST UI. The
viewer should render supported PlantUML types as diagrams and keep readable
contrast in the dark theme.

### Sequence diagram

$$uml
@startuml
actor User
participant "dDocs Manager" as Manager
participant "DocsIndexer" as Indexer
User -> Manager: Open module
Manager -> Indexer: Build file index
Indexer --> Manager: Tree nodes
User -> Manager: Select document
Manager --> User: Render Markdown
@enduml
$$

### Use case diagram

$$uml
@startuml
left to right direction
actor "Manager user" as User
rectangle dDocs {
  User -- (Browse package docs)
  User -- (Search Markdown)
  User -- (Open project docs)
}
@enduml
$$

### Class diagram

$$uml
@startuml
class DocsSourceRegistry {
  +sources(): array
}
class DocsIndexer {
  +index(): array
}
class FileDocumentRepository {
  +read(node): string
}
DocsSourceRegistry --> DocsIndexer
DocsIndexer --> FileDocumentRepository
@enduml
$$

### Object diagram

$$uml
@startuml
object source {
  key = ddocs
  type = package
}
object document {
  title = Markdown example
  language = en
}
source --> document
@enduml
$$

### Activity diagram

$$uml
@startuml
start
:Scan safe roots;
if (Cache enabled?) then (yes)
  :Load generated index;
else (no)
  :Build runtime index;
endif
:Render tree;
stop
@enduml
$$

### Component diagram

$$uml
@startuml
package "dDocs" {
  [Livewire ModulePanel]
  [DocsIndexer]
  [LinkResolver]
  [FileIndexCache]
}
[Livewire ModulePanel] --> [DocsIndexer]
[Livewire ModulePanel] --> [LinkResolver]
[DocsIndexer] --> [FileIndexCache]
@enduml
$$

### Deployment diagram

$$uml
@startuml
node "Evolution manager" {
  artifact "dDocs module"
}
node "Filesystem" {
  folder "vendor package docs"
  folder "ProjectDocs"
}
"dDocs module" --> "vendor package docs"
"dDocs module" --> "ProjectDocs"
@enduml
$$

### State diagram

$$uml
@startuml
[*] --> Backlog
Backlog --> Decomposition
Decomposition --> InProgress
InProgress --> ReadyToTest
ReadyToTest --> Closed
ReadyToTest --> InProgress : feedback
@enduml
$$

### Timing diagram

$$uml
@startuml
robust "Index cache" as Cache
robust "Viewer" as Viewer
@0
Cache is Empty
Viewer is Idle
@5
Cache is Warm
Viewer is Rendering
@10
Viewer is Ready
@enduml
$$

### Mindmap

$$uml
@startmindmap
* dDocs
** Sources
*** Packages
*** ProjectDocs
** Viewer
*** Markdown
*** Links
*** Images
** Editor
*** dTui
*** Save file
@endmindmap
$$

### WBS

$$uml
@startwbs
* dDocs MVP
** Discovery
*** Safe roots
*** Language fallback
** Viewer
*** Markdown
*** Code copy
*** UML
** Project docs
*** Create folder
*** Create document
@endwbs
$$

### Gantt

$$uml
@startgantt
[Discovery] lasts 2 days
[Viewer] lasts 3 days
[Project docs] starts at [Viewer]'s end and lasts 2 days
@endgantt
$$

### JSON diagram

$$uml
@startjson
{
  "module": "dDocs",
  "source": "filesystem",
  "db": false,
  "languages": ["uk", "en", "pl", "de", "fr"]
}
@endjson
$$

### YAML diagram

$$uml
@startyaml
module: dDocs
source: filesystem
db: false
languages:
  - uk
  - en
  - pl
  - de
  - fr
@endyaml
$$

## Escaping examples

Literal Blade syntax in documentation:

```blade
{{ $title }}
{!! $safeHtml !!}
```

Literal Markdown fence in documentation:

````markdown
```php
echo "Nested fence example";
```
````

## Expected result

This page is valid when:

1. Markdown renders without breaking the manager iframe.
2. Internal links stay inside dDocs.
3. External links open outside the manager surface.
4. Code blocks are highlighted and individually copyable.
5. UML blocks render or fail gracefully without hiding the rest of the page.
