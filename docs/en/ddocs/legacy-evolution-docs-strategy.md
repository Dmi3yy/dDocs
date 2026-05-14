# Legacy Evolution Docs Strategy

Older Evolution documentation sources are valuable, but they should not be the
canonical structure for new package docs.

## Recommended Roles

| Surface | Role |
| --- | --- |
| `docs.evo.im` | Legacy archive for older Evolution documentation. |
| `github.com/evolution-cms/docs` | Legacy source repository unless it is rebuilt around the new product docs structure. |
| `evo.im/docs` | Canonical product documentation direction. |
| dDocs package docs | Canonical package-level documentation inside installed package repositories. |

## Migration Strategy

1. Freeze legacy docs as historical material.
2. Add a clear legacy banner when the surface supports it.
3. Move current product content toward `evo.im/docs`.
4. Move package-specific content into each package `docs/` tree.
5. Migrate by value, not by volume.
6. Preserve redirects or alias maps for old public URLs.
7. Map old `ua` public URLs or folders to `uk`; do not create new `ua` docs
   pages.

## Package Content Labels

Use these statuses while migrating package pages from old docs:

- `current`
- `legacy`
- `deprecated`
- `migration-needed`
- `needs-review`

## Redirect Policy

When old public URLs are replaced, keep a map from the old URL to the new product
or package page. Broken public docs links should be treated as release risks.

Use this redirect map shape:

| Field | Meaning |
| --- | --- |
| `old_url` | Legacy public URL or package docs path. |
| `new_target` | Current product or package docs target. |
| `status` | `redirect`, `archive`, `drop`, or `needs-review`. |
| `notes` | Migration reason or reviewer note. |
