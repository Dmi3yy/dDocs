# Standards de documentation

Chaque page a un primary documentation type: Tutorial, How-to guide, Reference
ou Explanation.

## Required And Conditional Files

| File | Rule |
| --- | --- |
| `docs/README.md` | Required. |
| `docs/<locale>/README.md` | Required for supported locales. |
| `docs/<locale>/user-guide.md` | Required for user-facing packages. |
| `docs/<locale>/developer-guide.md` | Required for runtime/integration packages. |
| `docs/<locale>/configuration.md` | Required when package has settings. |
| `docs/<locale>/reference.md` | Required when routes, APIs, services, or formats need lookup. |
| `docs/<locale>/frontend-guide.md` | Conditional, only when package has frontend surface. |

## Locale Policy

La locale ukrainienne de documentation est uniquement `uk`. Legacy `ua` est un
runtime alias et ne doit pas apparaître comme docs folder, manifest locale,
language index entry ou release target.

## Quality Gates

- One H1 per page.
- No skipped heading levels.
- Code fences have language names.
- Internal links are relative and valid.
- No `docs/ua`.
- No local absolute filesystem paths.
