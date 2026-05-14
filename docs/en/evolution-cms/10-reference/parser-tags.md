# Parser Tags Reference

[Back](blade-and-template-rendering.md) / [Up](../README.md) / [Next](models.md)

Evolution CMS classic templates use parser tags for resources, settings,
chunks, snippets, placeholders, URLs, and conditional content. This page records
the current core tag surface so examples can stay consistent.

## Standard Tags

| Tag | Meaning | Example |
| --- | --- | --- |
| `[*field*]` | Current resource field or Template Variable. | `[*pagetitle*]` |
| `[(setting)]` | System setting or runtime config value. | `[(site_name)]` |
| `{{chunk}}` | Chunk content. | `{{site_header}}` |
| `{{chunk?&name=`value`}}` | Chunk with local parameters. | `{{card?&title=`Hello`}}` |
| `[[snippet]]` | Cached snippet call. | `[[DocLister]]` |
| `[!snippet!]` | Uncached snippet call. | `[!contactForm!]` |
| `[+placeholder+]` | Placeholder value from parser scope. | `[+title+]` |
| `[~id~]` | Resource URL. | `[~1~]` |
| `[^key^]` | Runtime/meta placeholder style used by cleanup and escaping paths. | `[^q^]` |

Use fenced examples with `html` or `blade` language labels when documenting
template code in Markdown.

## Resource Fields And TVs

Resource tags read the current document object first. They can also read
Template Variables when TV values are loaded for the resource.

```html
<h1>[*pagetitle*]</h1>
<p>[*introtext*]</p>
<img src="[*hero_image*]" alt="">
```

The parser also supports context lookup with `@` in resource tags. Current
context handling includes parent, ultimate parent, alias lookup, previous/next
sibling lookup, and direct resource id lookup.

```html
[*pagetitle@parent*]
[*pagetitle@uparent(0)*]
[*pagetitle@alias(home)*]
```

## System Settings

Settings tags read runtime configuration and known path/url values.

```html
<title>[(site_name)]</title>
<base href="[(site_url)]">
```

Common generated values include `base_url`, `base_path`, `site_url`,
`valid_hostnames`, `site_manager_url`, and `site_manager_path`.

## Chunks

Chunks are reusable templates. Parameters passed to a chunk are available as
local placeholders during chunk parsing.

```html
{{button?&label=`Read more`&url=`[~12~]`}}
```

Chunk output can contain placeholders, resource tags, settings, other chunks,
and conditional tags. The parser recursively resolves nested content until the
configured parser pass limits are reached.

## Snippets

Cached snippets use `[[...]]`. Uncached snippets use `[!...!]` and are converted
to snippet tags during post-parse output.

```html
[[menuBuilder?&startId=`0`]]
[!contactForm?&redirectTo=`15`!]
```

Snippet parameters are parsed before execution. Keep parameter values explicit
and avoid relying on undocumented global state.

## Placeholders

Placeholders are resolved from the current parser placeholder scope or local
data passed into a chunk/parser call.

```html
<article>
  <h2>[+title+]</h2>
  <p>[+summary+]</p>
</article>
```

Placeholders can use modifiers. Modifiers are part of the classic parser
surface and should be documented with the feature that depends on them.

## URL Tags

URL tags are rewritten during output processing.

```html
<a href="[~1~]">Home</a>
```

URL output depends on resource publication state, friendly URL settings,
aliases, suffixes, base URL, and the URL processor.

## Conditional Tags

Conditional tags are enabled through the `enable_at_syntax` setting. Current
core syntax uses uppercase tags:

```html
<@IF:[*published*]>
  Published
<@ELSE>
  Draft
<@ENDIF>
```

The parser also normalizes old HTML-comment forms such as `<!--@IF ...-->`,
`<!--@ELSE-->`, and `<!--@ENDIF-->`.

## Bindings And Inline Template Modes

Parser template helpers recognize special modes:

| Mode | Meaning |
| --- | --- |
| `@CODE` / `@INLINE` / `@TPL` | Use inline template code. |
| `@FILE` | Load template code from a file under the configured template path. |
| `@DOCUMENT` / `@DOC` | Load content from the current or selected resource. |
| `@B_FILE` | Render a Blade file. |
| `@B_CODE` | Render inline Blade code through generated cache. |
| `@T_CODE` / `@T_FILE` | Reserved template modes in parser handling. |

See [Blade And Template Rendering Reference](blade-and-template-rendering.md)
for Blade-specific behavior.

## Cleanup And Escaping

The output flow can:

- run uncached snippets during post-parse;
- inject registered startup scripts before `</head>`;
- inject registered scripts before `</body>`;
- clean unused Evolution tags;
- rewrite URL tags into final URLs.

`getTagsForEscape()` includes standard tag pairs such as `{{ }}`, `[[ ]]`,
`[! !]`, `[* *]`, `[( )]`, `[+ +]`, `[~ ~]`, and `[^ ^]`.

## Documentation Rule

When writing examples, use the smallest tag surface that explains the task. For
new projects that use Blade templates, prefer Blade examples and link here only
when classic parser tags are required.
