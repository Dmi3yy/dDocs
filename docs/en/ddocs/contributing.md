# Contributing To Documentation

This guide explains how to add or update package documentation that dDocs can
index reliably.

## Choose The Page Type

Pick one primary type before writing.

| Need | Use |
| --- | --- |
| Teach a complete path | Tutorial |
| Help someone complete a task | How-to guide |
| Provide exact lookup data | Reference |
| Explain concepts or boundaries | Explanation |

## Write A User Task

1. Start with the user's goal.
2. Use numbered steps.
3. Put one action in each step.
4. Keep architecture details out of the page.
5. Link to troubleshooting when the task can fail.

## Write Developer Documentation

Include the runtime boundary, routes, config keys, services, extension points,
testing commands, and safety notes. Prefer tables for reference data.

## Add A Locale

1. Create `docs/<locale>/README.md`.
2. Add required pages for the package surface.
3. Mark translation status honestly in `docs/README.md`.
4. Use `uk` for Ukrainian docs.
5. Do not create `docs/ua`; runtime compatibility is handled by dDocs
   normalization.

## Run Checks

Required local checks:

```bash
php docs/checks/docs-check.php
```

Recommended external checks:

```bash
npx markdownlint-cli2 "docs/**/*.md"
vale docs
lychee docs
```

## Review Checklist

- The page has one H1.
- Heading levels do not skip.
- Internal links are relative and resolve.
- Code fences have languages.
- No local absolute filesystem paths are present.
- No generated static-site files are under `docs/`.
- No `docs/ua` folder exists.
- User guides are task-based.
- Developer guides include boundaries and verification commands.
