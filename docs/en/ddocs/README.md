# dDocs

dDocs is a file-first documentation browser for Evolution CMS manager. It
discovers Markdown documentation in installed Evolution packages, shows package
roots in a left tree, renders the selected document in the right panel, and lets
the project keep its own local Markdown knowledge base.

The source of truth is the filesystem. dDocs does not need database tables for
package documentation.

## Capabilities

- Discover documentation from installed Evolution packages.
- Show a package/module tree with folders and Markdown documents.
- Respect the current manager language with fallback to English or neutral docs.
- Search by title, path, package name, and Markdown content.
- Render GitHub-flavored Markdown safely inside the manager.
- Resolve relative links between indexed documents.
- Render local images only from safe docs roots.
- Keep project-owned documentation in `ProjectDocs/`.
- Cache the generated file index for faster manager navigation.

## Guides

- [User Guide](user-guide.md)
- [Developer Guide](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Configuration](configuration.md)
- [Reference](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Documentation Standards](documentation-standards.md)
- [Markdown example](markdown-example.md)

## Markdown Rendering

dDocs sends raw Markdown to the manager page and renders it in the browser with
local dTui/TOAST UI assets. Code highlighting uses local Prism assets, including
the Evolution Blade grammar.

dDocs still owns the safety layer around the viewer:

- script-like HTML blocks are stripped before the Markdown is sent to the viewer;
- relative documentation links are mapped to indexed dDocs document ids;
- local images are converted only when they pass safe docs root checks;
- missing relative docs links are kept inert instead of navigating the manager iframe.

## Runtime Model

```text
Composer packages / local Evolution packages
        |
        v
DocsSourceRegistry
        |
        v
DocsIndexer
        |
        v
FileIndexCache
        |
        v
Livewire ModulePanel -> raw Markdown payload -> dTui/TOAST UI Viewer
                                           -> link/image post-processing
```

## Project Documentation

Docs created from the dDocs UI are stored in `ProjectDocs/` inside the dDocs
package. Project docs are writable, while vendor package docs stay read-only.

Use project docs for local knowledge that belongs to the current project:

- architecture notes;
- environment notes;
- deployment notes;
- project-specific decisions;
- AI/Codex working context.
