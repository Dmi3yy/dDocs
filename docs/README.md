# dDocs Documentation

dDocs is the file-first documentation browser and documentation standard surface
for Evolution CMS manager packages. It discovers package Markdown, builds a safe
tree, renders documents in the manager, and keeps project-owned notes as files.

## Languages

- [English](en/README.md)
- [Українська](uk/README.md)
- [Deutsch](de/README.md)
- [Francais](fr/README.md)
- [Polski](pl/README.md)

Each supported dDocs language folder contains:

- `README.md` - localized overview and navigation.
- `user-guide.md` - manager user workflows and visible behavior.
- `developer-guide.md` - architecture, package integration, routes, and checks.

Additional files are conditional. dDocs includes `configuration.md`,
`reference.md`, `troubleshooting.md`, and `frontend-guide.md` because it has
settings, routes, a file index, and a browser viewer runtime.

## Locale Status

| Locale | Status | Notes |
| --- | --- | --- |
| `en` | `complete` | Canonical source for package docs. |
| `uk` | `complete` | Canonical Ukrainian locale. |
| `pl` | `complete` | Localized release pages exist, terminology still follows shared technical names. |
| `de` | `complete` | Localized release pages exist, terminology still follows shared technical names. |
| `fr` | `complete` | Localized release pages exist, terminology still follows shared technical names. |

## Read This First

| Reader | Start here |
| --- | --- |
| Manager user | [User Guide](en/ddocs/user-guide.md) |
| Package developer | [Developer Guide](en/ddocs/developer-guide.md) |
| Documentation contributor | [Contributing To Documentation](en/ddocs/contributing.md) |
| AI agent | [AI And Agent Readiness](en/ddocs/ai-agent-readiness.md) |

## Language Policy

Ukrainian documentation uses `uk` only. Legacy Evolution manager values such as
`ua` are normalized internally to `uk`; do not create `docs/ua`, list `ua` as a
documentation locale, or add `ua` to docs manifests.

## Canonical Guides

- [Documentation Standards](en/ddocs/documentation-standards.md)
- [Ukrainian Documentation Standards](uk/ddocs/documentation-standards.md)
- [Configuration](en/ddocs/configuration.md)
- [Reference](en/ddocs/reference.md)
- [Troubleshooting](en/ddocs/troubleshooting.md)
- [Contributing To Documentation](en/ddocs/contributing.md)
- [Glossary And Word List](en/ddocs/glossary.md)
- [Assets Policy](en/ddocs/assets-policy.md)
- [Package And Product Documentation](en/ddocs/package-and-product-docs.md)
- [Docs Manifest](en/ddocs/docs-manifest.md)
- [AI And Agent Readiness](en/ddocs/ai-agent-readiness.md)
- [Migration Guide](en/ddocs/migration-guide.md)
- [Legacy Evolution Docs Strategy](en/ddocs/legacy-evolution-docs-strategy.md)
- [Markdown Example](en/ddocs/markdown-example.md)

## Package Documentation Contract

New Evolution packages should use a lowercase `docs/` root:

```text
docs/
  README.md
  assets/
    images/
    diagrams/
  en/
    README.md
    user-guide.md
    developer-guide.md
  uk/
    README.md
    user-guide.md
    developer-guide.md
```

The minimum user-facing locale set is English, Ukrainian (`uk`), Polish, German,
and French. Packages may keep Russian as a legacy extra when they already ship
it.

## dDocs Navigation Contract

- All package entrypoints must stay inside this `docs/` tree.
- Localized READMEs are navigation and onboarding pages, not generated task logs.
- Internal links must be relative and must resolve inside the package source.
- Code fences must include language identifiers so dTui and Prism can highlight
  and copy them consistently.
- Images must live under `docs/assets/images/` or another path inside the docs
  root. dDocs blocks paths that escape safe roots.
- Old generated documentation sites should move to `docs_old/` so dDocs does
  not index Docusaurus, Jekyll, build config, or generated static files.
