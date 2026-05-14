# Migrate Legacy Docs To dDocs

Use this guide when moving older EvoDOC, Docusaurus, Jekyll, or package README
content into the dDocs package standard.

## Choose What To Migrate

1. Keep current, accurate package instructions.
2. Move obsolete generated sites to `docs_old/`.
3. Mark deprecated content as legacy before rewriting it.
4. Do not migrate pages only because they exist.

## Map Old Pages To New Types

| Old content | New destination |
| --- | --- |
| Installation and first use | `README.md` or `user-guide.md` |
| Manager workflow | `user-guide.md` |
| Architecture notes | `developer-guide.md` |
| Config tables | `configuration.md` |
| API, routes, events, commands | `reference.md` |
| Known errors | `troubleshooting.md` |
| Generated HTML site output | `docs_old/` |

## Rewrite Procedure

1. Create or update the package `docs/README.md`.
2. Split mixed pages by reader need.
3. Convert internal links to relative Markdown links.
4. Move images under `docs/assets/`.
5. Add fence languages to every code block.
6. Add locale status if translations are incomplete.
7. Run the documentation quality gates.

## Migrate Ukrainian Docs

1. Move legacy `docs/ua` content to `docs/uk`.
2. Update relative links that point to `ua/`.
3. Refresh the dDocs index.
4. Keep `ua` only as a runtime alias or redirect source.
5. Do not preserve `ua` as a documentation locale.

## Post-Migration Checks

After moving legacy docs, verify:

1. Root `docs/README.md` language index links to `uk`, not `ua`.
2. `docs/docs.json` does not list `ua` under `locales`.
3. `legacyAliases` maps old manager input `ua` to `uk`, if the package uses a
   manifest.
4. Relative links no longer point to `ua/`.
5. Redirect maps point old public `ua` URLs to current `uk` pages.
6. `php docs/checks/docs-check.php` passes.

## Do Not Migrate

Do not migrate content when it is:

- tied to outdated APIs with no current replacement;
- duplicated by a better current page;
- unverified or impossible to test;
- about deprecated components without a supported migration path;
- generated static-site output instead of source documentation.

## Legacy Labels

Use one of these labels in the page introduction when content is not fully
current:

- `legacy`
- `deprecated`
- `migration-needed`
- `needs-review`
