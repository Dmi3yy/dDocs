# Documentation Source Policy

[Back](documentation-navigation.md) / [Up](../README.md)

Evolution CMS documentation must describe current product behavior. Historical
material can help, but it is not canonical until it is checked against current
code.

## Allowed Sources

| Source | Use |
| --- | --- |
| Current Evolution CMS code | Runtime, manager, API, models, config, events, CLI, installer compatibility, and legacy boundaries. |
| Standalone installer code and README | Current installer-first setup flow and `evo` command behavior. |
| Old Evolution CMS docs archive | Classic API, DB API, terminology, and historical behavior after validation. |
| Validated best-practice notes | Future recipes after current routing, model, and manager APIs are checked. |
| Package documentation | Linked when a maintained Extra owns the package-specific details. |

## Material Not Migrated

Old component manuals are not copied into this product-docs tree. They stay in
the legacy archive. Current installed Extras appear in dDocs through their own
package-level documentation.

## Review Rule

When historical or best-practice material is used:

1. Check the current code path.
2. Check whether the feature is current, legacy, or deprecated.
3. Rewrite the page for the current reader task.
4. Link to package docs instead of copying package manuals.
5. Keep old component pages as archive material.

## Future Best-Practice Topics

The first candidates are:

- routes, Ajax requests, request validation, JSON responses, and Blade partial
  rendering;
- `SiteContent` model usage, TV querying, closure tree traversal, and resource
  selection patterns.

These belong after the core documentation is accurate enough to support them and
after examples are verified against current code.
