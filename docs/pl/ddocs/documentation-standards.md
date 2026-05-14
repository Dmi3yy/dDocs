# Standardy dokumentacji

Każda strona ma jeden primary documentation type: Tutorial, How-to guide,
Reference albo Explanation.

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

Ukrainian documentation locale is only `uk`. Legacy `ua` is a runtime alias and
must not appear as docs folder, manifest locale, language index entry, or release
target.

## Quality Gates

- One H1 per page.
- No skipped heading levels.
- Code fences have language names.
- Internal links are relative and valid.
- No `docs/ua`.
- No local absolute filesystem paths.
