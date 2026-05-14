# Core Concepts

[Back](installation.md) / [Up](README.md) / [Next](../07-security-updates-operations/troubleshooting.md)

This page defines the vocabulary used by current Evolution CMS product
documentation. It is a short concept map, not an API reference.

## Main Terms

| Term | Meaning | Current code surface |
| --- | --- | --- |
| Manager | The authenticated administration interface used to edit content, elements, settings, users, packages, and manager modules. | Manager controllers and views under the manager runtime. |
| Resource | A content item stored in the site tree. A resource can represent a page, folder-like node, link, or another content type depending on its fields. | `EvolutionCMS\Models\SiteContent` and the `site_content` table. |
| Document Tree | The hierarchical view of resources. Parent, child, order, published, deleted, and visibility state all affect how a resource appears. | `SiteContent` parent/child relations and the closure table. |
| Template | A layout/content structure assigned to resources. Templates can be connected to Template Variables. | `EvolutionCMS\Models\SiteTemplate`. |
| Template Variable | A custom field definition that can be attached to templates and saved per resource. | `SiteTmplvar`, `SiteTmplvarTemplate`, and `SiteTmplvarContentvalue`. |
| Chunk | A reusable text or markup element. Chunks are usually used for repeated layout fragments or small reusable output blocks. | `EvolutionCMS\Models\SiteHtmlsnippet`. |
| Snippet | A PHP-backed element that can run logic and return output from templates, chunks, or resource content. | `EvolutionCMS\Models\SiteSnippet`. |
| Plugin | Event-driven PHP code connected to one or more system events. Plugins react to manager, parser, cache, document, and extension lifecycle events. | `EvolutionCMS\Models\SitePlugin` and `SitePluginEvent`. |
| Event | A named hook invoked by the runtime. Events are stored as names and connected to plugins with priority. | `EvolutionCMS\Models\SystemEventname` and `evo()->invokeEvent(...)`. |
| Module | A manager-side tool or application surface. Modules can be run from the manager and can belong to packages. | `EvolutionCMS\Models\SiteModule`. |
| Package | A Composer-distributed code package that can provide services, views, routes, config, assets, modules, and documentation. | Composer packages plus Evolution package commands/services. |
| Extra | An optional package or extension installed into a project. Extras own their own package documentation in dDocs. | Installed package sources indexed by dDocs. |
| Cache | Generated runtime data used by the parser, manager, views, package metadata, and settings. Cache can be cleared from the manager or console. | `evo()->clearCache('full')`, `cache:clear-full`, and site refresh. |

## How They Fit Together

A typical page starts as a resource in the Document Tree. The resource chooses a
Template. The Template can expose Template Variables for structured fields.
Templates, Chunks, and Snippets can compose output. Plugins listen to Events to
extend runtime behavior. Modules provide manager-side tools for larger workflows.

```text
Resource -> Template -> TV values
         -> Chunks and Snippets
         -> Plugins through Events
         -> Cache and rendered output
```

## Product Docs And Package Docs

Evolution CMS product documentation explains core product concepts, manager
behavior, runtime architecture, APIs, operations, and upgrade boundaries.

Installed Extras are documented by their own packages. dDocs reads those package
docs from the filesystem and shows them next to the product documentation. Do
not copy full Extra manuals into this product tree unless the page is explaining
a core integration contract shared by all packages.

## Legacy Boundaries

Evolution CMS still contains compatibility surfaces for older code and old
installation flows. Current documentation should name those surfaces only when a
reader needs to understand compatibility or migration behavior. New tutorials
and how-to guides should start from current installer, package, manager, and
Composer-based workflows.
