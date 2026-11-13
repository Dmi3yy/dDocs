# Приклад Markdown

Цей файл є smoke-документом для dDocs viewer і dTui Editor. Він спеціально
містить майже всі формати, які ми хочемо підтримувати у документації Evolution
пакетів: базовий Markdown, GitHub-style таблиці, code fences, Prism languages,
relative links, external smoke images, raw HTML safety examples і PlantUML
blocks.

## Короткий список перевірок

- Відкрий цей документ у dDocs viewer.
- Перевір, що заголовки, списки, таблиці, quote blocks і посилання виглядають
  як нормальна GitHub-like документація.
- Перевір, що code blocks мають компактну copy-кнопку і коректну підсвітку.
- Перевір, що `$$uml` блоки рендеряться як діаграми, а не як plain text.
- Відкрий цей файл у редакторі та перевір Markdown, Split і WYSIWYG modes.

---

## Заголовок рівня H1 8-)

## Заголовок рівня H2

### Заголовок рівня H3

#### Заголовок рівня H4

##### Заголовок рівня H5

###### Заголовок рівня H6

## Горизонтальні роздільники

___

---

***

## Типографічні заміни

Enable typographer option to see result.

(c) (C) (r) (R) (tm) (TM) (p) (P) +-

test.. test... test..... test?..... test!....

!!!!!! ???? ,,  -- ---

"Smartypants, double quotes" and 'single quotes'

## Абзаци

Documentation paragraphs should be short enough to scan. dDocs is used by
humans and by AI agents, so the best paragraphs explain one workflow, one
contract, or one decision at a time.

Line breaks inside the same paragraph should stay readable, while blank lines
create a new paragraph.

## Виділення тексту

**This is bold text**

__This is bold text__

*This is italic text*

_This is italic text_

~~Strikethrough~~

Use `inline code` for paths, config keys, commands, class names, and ids.

Keyboard example with safe inline HTML: <kbd>Cmd</kbd> + <kbd>K</kbd>.

## Цитати

> Blockquotes can also be nested...
>> ...by using additional greater-than signs right next to each other...
> > > ...or with spaces between arrows.

> Use blockquotes for warnings, quoted decisions, and notes copied from an
> external source.

## Списки

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

## Код

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

### Мови, які підтримує Prism

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
  "language": "uk",
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

#### Резервне відображення diff

```diff
- Server-side Markdown HTML rendering
+ Client-side Markdown rendering with dTui viewer
```

## Таблиці

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

## Посилання

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

## Зображення

Ці external images є спеціальними remote-image smoke examples. Звичайна package
documentation має використовувати images з `docs/assets/`.

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

## Безпека вставок HTML

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

## Синтаксис розширень markdown-it

Ці приклади перевіряють markdown-it style синтаксис, який dDocs нормалізує
перед рендером у manager: emoji aliases, sub/sup, inserted/marked text,
footnotes, definition lists, abbreviations і warning containers. Якщо новий
плагін-синтаксис ще не підтримується, він має лишатися читабельним текстом і не
ламати сторінку.

### Емодзі

Classic markup: :wink: :cry: :laughing: :yum:

Shortcuts: :-) :-( 8-) ;)

### Нижній і верхній індекси

- 19^th^
- H~2~O

### Вставлений і позначений текст

++Inserted text++

==Marked text==

### Виноски

Footnote 1 link[^first].

Footnote 2 link[^second].

Inline footnote^[Text of inline footnote] definition.

Duplicated footnote reference[^second].

[^first]: Footnote **can have markup**

    and multiple paragraphs.

[^second]: Footnote text.

### Списки визначень

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

### Скорочення

This is HTML abbreviation example.

It converts "HTML", but keeps partial entries like "xxxHTMLyyy" intact.

*[HTML]: Hyper Text Markup Language

### Користувацькі контейнери

::: warning
*here be dragons*
:::

## Блоки PlantUML

dDocs keeps `$$uml` blocks as Markdown custom blocks for dTui/TOAST UI. Viewer
має рендерити підтримані PlantUML типи як діаграми і зберігати читабельний
контраст у dark theme.

### Діаграма послідовності

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

### Діаграма варіантів використання

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

### Діаграма класів

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

### Діаграма об’єктів

$$uml
@startuml
object source {
  key = ddocs
  type = package
}
object document {
  title = Markdown example
  language = uk
}
source --> document
@enduml
$$

### Діаграма діяльності

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

### Діаграма компонентів

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

### Діаграма розгортання

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

### Діаграма станів

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

### Часова діаграма

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

### Карта думок

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

### Ієрархічна структура робіт

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

### Діаграма Ганта

$$uml
@startgantt
[Discovery] lasts 2 days
[Viewer] lasts 3 days
[Project docs] starts at [Viewer]'s end and lasts 2 days
@endgantt
$$

### Діаграма JSON

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

### Діаграма YAML

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

## Приклади екранування

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

## Очікуваний результат

This page is valid when:

1. Markdown renders without breaking the manager iframe.
2. Internal links stay inside dDocs.
3. External links open outside the manager surface.
4. Code blocks are highlighted and individually copyable.
5. UML blocks render or fail gracefully without hiding the rest of the page.
