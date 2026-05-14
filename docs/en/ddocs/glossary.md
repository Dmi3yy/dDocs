# Glossary And Word List

This glossary keeps Evolution package documentation consistent across dDocs,
package READMEs, and agent context.

## Core Terms

| Term | Use this meaning |
| --- | --- |
| Evolution CMS | The product and manager runtime. Use `Evolution CMS` on first mention and `Evolution` later when the context is clear. |
| Manager | The authenticated Evolution CMS back office UI. Do not call it admin unless quoting legacy docs. |
| Resource | A managed site item in Evolution CMS. Do not replace it with page unless the UI label is literally page. |
| Document | A Markdown file shown by dDocs, or an Evolution content object when the product context says so. Clarify the context when both meanings appear. |
| Extra | A package or module installed into an Evolution project. |
| Package | A Composer-distributed codebase. Package docs live in `docs/`. |
| Module | A manager UI surface registered by a package. dDocs is a module. |
| Project docs | Writable documentation owned by the current project. |
| Vendor docs | Read-only documentation shipped by installed packages. |
| Safe root | A filesystem root that dDocs is allowed to index or render from. |
| Source | A documentation root discovered by dDocs, such as a package, project docs folder, or configured extra root. |
| Locale | A documentation language folder such as `en`, `uk`, `pl`, `de`, or `fr`. |
| Fallback | The language resolution behavior used when the requested locale is missing. |
| Reference | Exact lookup material such as routes, config keys, events, services, or formats. |
| How-to guide | Task-based instructions that help the reader complete one workflow. |
| Explanation | Conceptual material that explains architecture, boundaries, and tradeoffs. |

## Evolution Building Blocks

| Term | Use this meaning |
| --- | --- |
| Template Variable | A custom field attached to Evolution templates. Spell out on first mention, then use `TV`. |
| Chunk | A reusable content or markup fragment in Evolution CMS. |
| Snippet | PHP logic that can be executed from Evolution content or templates. |
| Plugin | Event-driven Evolution logic attached to manager or site events. |
| Template | The layout definition used to render resources. |
| Artisan command | A command exposed through the Evolution/Laravel console runtime. |
| Blade view | A server-rendered Laravel Blade template. |
| Livewire component | A reactive server-driven UI component. |

## Preferred Words

| Prefer | Avoid | Reason |
| --- | --- | --- |
| user guide | manual | Task-based docs should focus on workflows. |
| developer guide | backend docs | Developer docs may include backend, frontend, routes, config, and tests. |
| frontend guide | frontend docs for every package | Use only when a package has a real frontend surface. |
| package docs | module docs | Some packages do not expose a manager module. |
| legacy docs | old docs | `legacy` is clearer and less judgmental. |
| read-only | locked | Matches the dDocs source boundary. |
| configure | set up | Use configure for settings and set up for initial installation. |

## Locale Names

| Locale | Name |
| --- | --- |
| `en` | English |
| `uk` | Ukrainian, canonical ISO locale |
| `pl` | Polish |
| `de` | German |
| `fr` | French |
| `ru` | Russian legacy extra when already shipped |

## Legacy Aliases

| Alias | Rule |
| --- | --- |
| `ua` | Old Evolution manager language code. dDocs normalizes it to docs locale `uk`; do not create `docs/ua` or list `ua` as a documentation locale. |
