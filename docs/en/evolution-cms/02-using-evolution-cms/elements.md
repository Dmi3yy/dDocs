# Elements

[Back](resources-and-document-tree.md) / [Up](README.md) / [Next](settings-permissions-and-files.md)

Element Management is the manager area for templates, Template Variables,
chunks, snippets, plugins, and modules. Current manager code organizes these as
tabs in the Resources controller.

## Element Types

| Element | Use It For |
| --- | --- |
| Template | Page layout and resource output structure. |
| Template Variable | Custom fields attached to templates and saved per resource. |
| Chunk | Reusable markup or text fragments. |
| Snippet | PHP-backed logic that returns output. |
| Plugin | Event-driven extension code. |
| Module | Manager-side tool or application screen. |

## Work With Templates

Create or edit templates when a resource needs a layout or a different set of
Template Variables. A template can be selectable, locked, categorized, and linked
to TVs.

When changing a template:

1. Save the template.
2. Review assigned Template Variables.
3. Refresh cache when output does not change.
4. Test resources that use the template.

## Work With Template Variables

Template Variables define structured fields that appear on resources using the
assigned templates. TVs have a type, caption, category, elements/options,
display mode, default text, and role/template access rules.

Use TVs for content data that editors should manage separately from the main
resource content field.

## Work With Chunks And Snippets

Chunks are reusable text or markup blocks. Snippets are PHP-backed logic blocks.
Both can be enabled, disabled, duplicated, deleted, locked, and categorized from
the manager.

Use chunks for repeated markup. Use snippets when the output needs runtime logic.

## Work With Plugins And Events

Plugins are connected to named events and run when the runtime invokes those
events. Plugin order is controlled by event priority. Use plugins for lifecycle
hooks such as document save, parser, manager, cache, file browser, and user
events.

See [Events Reference](../10-reference/events.md) before adding or changing a
plugin event connection.

## Work With Modules

Modules are manager-side tools. They can have module code, resource files,
shared params, dependencies, and run/edit actions. Installed package modules may
also have package-owned documentation in dDocs.

Do not copy a package module manual into this product docs tree. Open the
package source in dDocs when the feature belongs to an installed Extra.
