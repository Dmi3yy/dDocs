# Assets Policy

This page defines how screenshots, images, and diagrams should be stored for
dDocs package documentation.

## Folder Layout

```text
docs/assets/
  images/
    en/
    uk/
  diagrams/
```

Use locale folders for screenshots that contain translated UI text. Use
`docs/assets/diagrams/` for PlantUML sources, exported diagrams, and architecture
images that are shared across locales.

## Screenshot Rules

- Capture the current Evolution manager UI only.
- Remove personal data, customer names, tokens, private URLs, and local paths.
- Add useful alt text whenever the screenshot is embedded.
- Update screenshots when the visible workflow changes.
- Prefer focused screenshots over full-screen captures when the surrounding UI
  does not add meaning.

## Diagram Rules

- Keep editable source files when possible, such as `.puml`.
- Name diagrams by the concept they explain.
- Keep diagrams close to the docs page that uses them through relative links.
- Do not use diagrams as a replacement for reference tables.

## File Names

Use lowercase names with hyphens.

```text
docs/assets/images/en/settings-screen.png
docs/assets/diagrams/source-registry-flow.puml
```
