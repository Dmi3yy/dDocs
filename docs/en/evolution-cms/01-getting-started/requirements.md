# Requirements

[Back](README.md) / [Up](README.md) / [Next](installation.md)

Current Evolution CMS documentation must describe the runtime that exists now,
not the older Evo 1.x assumptions from the legacy docs archive.

## Core Runtime

| Requirement | Current baseline |
| --- | --- |
| PHP | `^8.3` |
| Composer | Composer 2.x for project and package installation. |
| Database access | PDO is required. MySQL, PostgreSQL, SQLite, and SQL Server are supported by the current installer options when the matching PHP driver is available. |
| PHP extensions | Core requires JSON, PDO, ZIP, mbstring, XML-related extensions, session, tokenizer, OpenSSL, ctype, fileinfo, filter, hash, iconv, and PCRE. |
| Optional image support | GD or Imagick is recommended for image handling. |

The root project `composer.json` is minimal, while `core/composer.json` owns the
larger runtime dependency set: Illuminate 12 components, Flysystem, PHPMailer,
Tracy, Symfony Process, Composer integration, and supporting packages.

## Installer Runtime

The standalone installer requires:

| Requirement | Notes |
| --- | --- |
| PHP | `^8.3` |
| Composer | Needed for global installer installation and project setup. |
| JSON, PDO, MySQLi, ZIP | Required by the installer package. |
| GitHub access | Needed when the bootstrapper downloads or updates the Go installer binary from GitHub Releases. |
| Writable installer bin directory | Needed for `evo self-install` and first-run binary installation. |

The installer `system-status` command checks operating system, PHP version,
Composer, PDO drivers, JSON, MySQLi, mbstring, cURL, image support, disk space,
and memory limit.

## Documentation Rule

If a requirement is copied from old documentation, verify it against current
Composer files, installer code, and install checks before publishing it here.

