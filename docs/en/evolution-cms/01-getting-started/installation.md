# Installation

[Back](requirements.md) / [Up](README.md) / [Next](core-concepts.md)

The current recommended installation path is the standalone Evolution CMS
Installer package. The legacy web installer still exists in the core checkout,
but the modern documentation should teach the standalone `evo` workflow first.

## Install The Installer

Install the installer globally with Composer:

```bash
composer global require evolution-cms/installer
```

Make sure the Composer global bin directory is available in `PATH`, then verify:

```bash
evo version
```

On first run, the PHP bootstrapper installs the matching Go binary from GitHub
Releases, verifies checksums, stores the binary next to the bootstrapper, and
delegates the command to it.

You can pre-install the binary explicitly:

```bash
evo self-install
```

Update the installer binary with:

```bash
evo self-update
```

To inspect the local environment before an install, run:

```bash
evo system-status
```

The status command returns JSON for the installer adapter. It checks the
operating system, PHP version, Composer, PDO and database drivers, JSON, MySQLi,
mbstring, cURL, image support, disk space, and memory limit.

## Create A Project

Run the interactive installer:

```bash
evo install
```

The installer guides the user through:

- target directory;
- database connection;
- administrator account;
- manager directory;
- installation language;
- project preset;
- optional Extras selection.

Use interactive mode when a human is choosing the project path, preset,
database, language, and optional Extras. Use CLI mode when those answers are
known up front and the install should run without TUI prompts.

For a scripted install:

```bash
evo install demo \
  --cli \
  --branch=3.5.x \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-username=admin \
  --admin-email=admin@example.com \
  --admin-password=change-me \
  --admin-directory=manager \
  --language=uk \
  --preset=evolution-cms-presets/default
```

CLI mode requires a database type, database name, admin email, and admin
password. It defaults the admin username to `admin`, the manager directory to
`manager`, the language to `en`, and the preset to `evolution` when those values
are not provided.

For the complete option list, see [CLI Reference](../10-reference/cli-reference.md).

## Database Options

The installer supports these database drivers when the matching PHP extension
is available:

| Driver | Notes |
| --- | --- |
| `sqlite` | Requires a database file name. The installer stores normalized SQLite names under the project database directory. |
| `mysql` | Requires host, database name, user, and password in CLI mode unless defaults are acceptable. |
| `pgsql` | Requires the PostgreSQL PDO driver and connection credentials. |
| `sqlsrv` | Requires the SQL Server PDO driver and connection credentials. |

The installer tests the database connection before continuing. In interactive
mode, a failed connection can be retried. In CLI mode, a failed connection stops
the install.

## Presets

The installer separates Evolution CMS core from the project layer.

| Preset input | Meaning |
| --- | --- |
| Omitted in TUI mode | Show preset choices from the public presets catalog. |
| `evolution` | Install Evolution core only. |
| `default` | Resolve to the default public preset repository. |
| `evolution-cms-presets/default` | Copy the default project layer after core install. |
| `owner/repository` | Resolve to a GitHub repository. |
| Git URL or local path | Use a custom preset source. |

The preset does not define the future Git identity of the created site. The
target directory can become its own project repository.

A preset can include a ref suffix when a non-default branch or tag is needed:

```bash
evo install demo --preset=evolution-cms-presets/default@dev
```

Presets are applied through the installed project's `core/artisan
preset:install` command after Evolution CMS core is ready, then preset
migrations run.

## Extras During Install

The installer can install Extras after the core project is ready:

```bash
evo install demo --extras=sTask,sSeo
```

Legacy Store packages can be selected by ID when needed:

```bash
evo install demo --extras=legacy-store:84@1.12.2
```

Do not document old component installation as the default path for current
projects. Keep legacy component information in the legacy archive unless a
current package explicitly replaces it.

Installed Extras should provide their own package documentation. dDocs discovers
those docs from the installed package sources and shows them beside the product
documentation.

## Troubleshooting

| Problem | Check |
| --- | --- |
| GitHub API rate limit | Set `GITHUB_TOKEN` or pass `--github-pat`. |
| Composer is a shell alias | Set `EVO_COMPOSER_BIN` to the real Composer executable. |
| Binary cannot be installed | Check write permissions for the installer package `bin` directory. |
| Database option fails | Run `evo system-status` and verify the matching PDO driver. |
| CLI mode exits before install | Provide `--db-type`, `--db-name`, `--admin-email`, and `--admin-password`. |
| Existing project is detected | Use `--force` only when you intentionally want to install into an existing directory. |

## Legacy Web Installer Boundary

The core checkout still contains a web installer and CLI install script. Keep
those docs for maintenance, compatibility, and install debugging. New user
documentation should start with the standalone installer unless a task is
specifically about legacy web install behavior.
