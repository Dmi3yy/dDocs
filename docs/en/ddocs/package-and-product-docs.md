# Package And Product Documentation

dDocs is the canonical viewer and standard surface for package-level
documentation. Evolution CMS product documentation should stay separate because
it answers broader product questions.

## Package Documentation

Package docs explain one package or module.

Typical package pages:

- `README.md`
- `user-guide.md`
- `developer-guide.md`
- `configuration.md`
- `reference.md`
- `troubleshooting.md`

Package docs should answer:

- What does this package do?
- Who should use it?
- How does a manager user complete the visible workflows?
- How does a developer configure, extend, test, or debug it?
- Which routes, services, config keys, commands, or events are stable lookup
  surfaces?

## Product Documentation

Product docs explain Evolution CMS as a whole.

Typical product sections:

- Getting started.
- Using Evolution CMS.
- Site building.
- Development.
- Extras and packages.
- API and integrations.
- Security and operations.
- Tutorials and recipes.
- Reference.

Product docs should answer:

- How do I learn Evolution CMS from zero?
- How do I build and operate a site?
- Which concepts apply across many packages?
- Which current docs replace legacy EvoDOC pages?

## Boundary Rule

Do not force product navigation into every package. Link to product docs when the
reader needs global Evolution CMS context, then return to the package task or
reference.

## Cross-Link Examples

Allowed package-to-product links:

- link to a global Evolution CMS concept instead of re-explaining it;
- link to current product installation docs before package-specific setup;
- link to product security guidance before package operations notes;
- link to product API reference when the package only uses that API.

Avoid copying full product tutorials into package docs. Package docs should add
only the package-specific steps, settings, and troubleshooting.
