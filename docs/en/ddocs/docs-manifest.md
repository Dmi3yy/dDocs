# Docs Manifest

A docs manifest is an optional inventory file that lets packages describe their
documentation without making dDocs guess every intent from the filesystem.

## Proposed File

Use `docs/docs.json` when a package needs explicit metadata.

```json
{
  "schemaVersion": 1,
  "package": "dmi3yy/ddocs",
  "title": "dDocs",
  "canonicalLocale": "en",
  "visibility": "public",
  "generated": false,
  "legacy": false,
  "owners": ["dDocs maintainers"],
  "audience": ["manager-users", "developers", "agents"],
  "status": "complete",
  "locales": {
    "en": "complete",
    "uk": "complete",
    "pl": "partial",
    "de": "partial",
    "fr": "partial"
  },
  "legacyAliases": {
    "ua": "uk"
  },
  "entrypoints": {
    "overview": {
      "type": "explanation",
      "path": "en/README.md",
      "status": "complete"
    },
    "user": {
      "type": "how-to",
      "path": "en/user-guide.md",
      "status": "complete"
    },
    "developer": {
      "type": "explanation",
      "path": "en/developer-guide.md",
      "status": "complete"
    },
    "reference": {
      "type": "reference",
      "path": "en/reference.md",
      "status": "complete"
    }
  }
}
```

## Fields

| Field | Rule |
| --- | --- |
| `schemaVersion` | Integer manifest schema version. |
| `package` | Composer package name. |
| `title` | Human-readable package or module name. |
| `canonicalLocale` | Source locale for canonical content. Use `en` unless the package deliberately chooses another source. |
| `visibility` | `public`, `internal`, or `legacy`. |
| `generated` | `true` only for generated docs inventory, never for hand-written package docs. |
| `legacy` | Marks migrated or archived docs. |
| `owners` | People or teams responsible for docs review. |
| `audience` | Stable audience labels used by docs navigation and agents. |
| `status` | Overall docs status: `complete`, `partial`, `stub`, `machine-draft`, or `needs-review`. |
| `locales` | Locale status map. Do not list `ua`; Ukrainian docs use `uk`. |
| `legacyAliases` | Optional input aliases, such as legacy manager `ua` mapped to docs locale `uk`. Aliases are not locales. |
| `entrypoints` | Important pages by reader need, type, path, and page status. |

## Current Status

The manifest is a proposal, not a required dDocs runtime contract. Packages can
adopt it before dDocs starts reading it.
