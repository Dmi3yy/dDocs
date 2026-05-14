# AI And Agent Readiness

dDocs documentation should be easy for humans to scan and safe for AI agents to
use as context.

## Page Shape

- Start with a short purpose paragraph.
- Use stable headings that can be referenced directly.
- Keep one audience and one primary documentation type per page.
- Put reference facts in tables.
- Keep commands in language-tagged code fences.
- State boundaries explicitly, especially read-only and writable surfaces.

## Implementation Context

Developer-facing pages should include:

- runtime model;
- routes;
- config keys;
- services and responsibilities;
- source discovery contract;
- safe path rules;
- cache behavior;
- extension boundaries;
- verification commands.

## Safety Notes

- Do not include secrets, tokens, customer data, or private URLs.
- Do not include local absolute paths unless the page is explicitly documenting
  a local developer command and the path is inside a fenced example.
- Mark generated files and legacy docs clearly.
- Keep dIssues task artifacts out of public package docs.
- Never create `docs/ua`; migrate Ukrainian docs to `docs/uk` and leave legacy
  `ua` only in migration or runtime-normalization notes.
- Never create a placeholder `frontend-guide.md` for a package without a real
  frontend surface.

## Search Terminology

- Call the current implementation filesystem live search or a live filter over
  the file index.
- Do not call the current implementation a search engine, full-text index,
  indexed search, or search service.
- Keep `FileIndexCache` responsible for navigation metadata.
- Treat `FileSearchIndexCache` as a future generated file-based cache, not as
  existing runtime behavior.
- Do not propose database search, external search services, or vector search
  before deterministic file-based indexing, snippets, scoring, and filters.

## Agent Checklist

Before an agent changes package docs, it should check:

- Which package is in scope.
- Which docs type the page represents.
- Whether locale updates are required.
- Whether links, code fences, headings, and screenshots still pass quality
  gates.
- Whether the change accidentally promotes a legacy alias into a canonical docs
  locale.
