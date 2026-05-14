# Documentation Navigation

[Back](source-inventory.md) / [Up](../README.md) / [Next](documentation-source-policy.md)

Evolution CMS documentation uses a small navigation grammar so readers can move
through a section without relying only on the left tree.

## Navigation Types

| Link type | Purpose | Example |
| --- | --- |
| Structural | Traverse the documentation tree. | `Back`, `Up`, `Next` |
| Section children | Show pages that belong under a section. | A table in `README.md` |
| Semantic | Connect related concepts or source areas. | `Related`, `See Also` |

## Structural Links

Use this shape at the top of multi-page sections:

```text
# Page Title

[Back](previous.md) / [Up](README.md) / [Next](next.md)

Short reader-focused opening paragraph.

## Task Or Reference Section

...

## Related

- [Relevant page](other-page.md)
```

If a structural neighbor does not exist, omit that link instead of inventing a
target.

## Section Landing Pages

Section `README.md` pages should be small portals. They should include:

- one short paragraph about the section;
- a table of child pages;
- the current scope of the section;
- links to related sections only when needed.

## Source Reference Pages

Source reference pages may include source tables, command lists, model lists,
configuration tables, and validation status. They must not include private
filesystem paths, internal planning terms, or generated analysis metadata.

## Extras Links

Do not duplicate installed Extras documentation inside Evolution CMS product
docs. Link to package-level docs when a maintained package owns the details.
