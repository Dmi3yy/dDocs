# CLI Reference

[Back](../07-security-updates-operations/troubleshooting.md) / [Up](../README.md) / [Next](source-inventory.md)

This page is a compact reference for current Evolution CMS command-line
installation surfaces. Use [Installation](../01-getting-started/installation.md)
for the guided install flow.

## Installer Commands

| Command | Purpose |
| --- | --- |
| `evo install [dir] [flags]` | Install a project. Omit `dir` in TUI mode to choose it interactively. |
| `evo self-install` | Download and install the installer binary beside the PHP bootstrapper. |
| `evo self-update` | Update the installer binary from the latest available release. |
| `evo system-status` | Print system status JSON for installer diagnostics. |
| `evo version` | Print the installer version. |

## Install Flags

| Flag | Meaning |
| --- | --- |
| `-f`, `--force` | Install even when the target directory already exists or looks like an existing project. |
| `--branch=<name>` | Install Evolution CMS from a specific Git branch instead of the latest compatible release. |
| `--preset=<spec>` | Apply a project-layer preset after core install. |
| `--db-type=<driver>` | Database driver: `mysql`, `pgsql`, `sqlite`, or `sqlsrv`. |
| `--db-host=<host>` | Database host for non-SQLite installs. |
| `--db-port=<port>` | Database port. If omitted, the installer uses the driver default when possible. |
| `--db-name=<name>` | Database name, or SQLite database file name. |
| `--db-user=<user>` | Database username for non-SQLite installs. |
| `--db-password=<password>` | Database password for non-SQLite installs. |
| `--admin-username=<name>` | Initial manager administrator username. |
| `--admin-email=<email>` | Initial manager administrator email. |
| `--admin-password=<password>` | Initial manager administrator password. In CLI mode it must be at least 6 characters. |
| `--admin-directory=<dir>` | Manager directory name. Defaults to `manager` in CLI mode. |
| `--language=<locale>` | Installation language, for example `en` or `uk`. |
| `--github-pat=<token>` | GitHub token for API requests and rate-limit avoidance. |
| `--github_pat=<token>` | Alternative spelling for the GitHub token option. |
| `--extras=<list>` | Comma-separated Extras to install after setup. |
| `--log` | Write installer log output to `log.md`. |
| `--cli` | Run in non-interactive CLI mode. |
| `--quiet` | Reduce CLI output to warnings and errors. |
| `--composer-clear-cache` | Clear Composer cache before dependency installation. |
| `--composer-update` | Use `composer update` instead of `composer install` during setup. |

## CLI Mode Required Values

CLI mode does not ask questions. Provide at least:

```bash
evo install demo \
  --cli \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-email=admin@example.com \
  --admin-password=change-me
```

When omitted in CLI mode, the installer defaults:

| Value | Default |
| --- | --- |
| Admin username | `admin` |
| Manager directory | `manager` |
| Language | `en` |
| Preset | `evolution` |
| Non-SQLite host | `localhost` |
| Non-SQLite user | `root` |

## Preset Specs

| Spec | Resolution |
| --- | --- |
| `evolution` | Core-only install; no project-layer preset. |
| `default` | Default public preset repository. |
| `evolution-cms-presets/default` | GitHub repository under the public presets organization. |
| `owner/repository` | GitHub repository. |
| Git URL | Use the provided repository URL directly. |
| Local path | Use the local preset checkout and keep it as the source. |
| `spec@ref` or `spec#ref` | Use a specific branch, tag, or ref. |

## Extras Syntax

| Syntax | Meaning |
| --- | --- |
| `--extras=sTask,sSeo` | Install managed Extras by package name. |
| `--extras=sTask@dev-main` | Install a managed Extra with an explicit version or branch constraint. |
| `--extras=legacy-store:84@1.12.2` | Install a Legacy Store package by catalog ID and version. |

Extras documentation is package-owned. After install, dDocs should discover
each package's filesystem documentation and show it in the documentation tree.

## System Status Fields

`evo system-status` returns JSON with an overall status and individual checks.
Current checks include:

- operating system;
- PHP version;
- Composer availability;
- PDO and database drivers;
- JSON, MySQLi, mbstring, cURL;
- GD or Imagick image support;
- disk space;
- memory limit.

Warnings mean the install may still proceed depending on the selected database
or feature. Errors mean the environment is missing a required baseline.
