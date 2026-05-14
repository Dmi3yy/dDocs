# Evolution CMS Dokumentation

[Dokumentations-Hub](../README.md) / Evolution CMS

Dies ist die kanonische deutsche Produktdokumentation für Evolution CMS in
dDocs. Sie dokumentiert zuerst die aktuelle Codebasis und verwendet älteres
Material nur nach Validierung gegen den aktuellen Code.

## Hier beginnen

| Brauchen | Öffnen |
| --- | --- |
| Installieren Sie ein neues Projekt | [Installation](01-getting-started/installation.md) |
| Laufzeitanforderungen prüfen | [Anforderungen](01-getting-started/requirements.md) |
| Grundwortschatz lernen | [Kernkonzepte](01-getting-started/core-concepts.md) |
| Kernmanager-Workflows verwenden | [Verwendung von Evolution CMS](02-using-evolution-cms/README.md) |
| Verstehen Sie das Laufzeitlayout | [Projektstruktur](04-development/project-structure.md) |
| Ein modernes Paket erstellen | [Paket erstellen](05-extras-and-packages/create-package.md) |
| Ein site preset erstellen | [Preset erstellen](05-extras-and-packages/create-preset.md) |
| Finden Sie Entwickler-Referenzkarten | [API und Integrationen](06-api-and-integrations/README.md) |
| Diagnostizieren Sie häufig auftretende Projektprobleme | [Fehlerbehebung](07-security-updates-operations/troubleshooting.md) |
| Überprüfen Sie die Kernstandards und -einstellungen | [Referenz zu Systemeinstellungen](10-reference/system-settings.md) |
| Überprüfen Sie Rollen und Berechtigungen | [Referenz zu Rollen und Berechtigungen](10-reference/roles-and-permissions.md) |
| Konfiguration und Laden von `.env` verstehen | [Konfigurationslaufzeitreferenz](10-reference/configuration-runtime.md) |
| Verstehen Sie die Kernverkabelung Composer | [Kern-Composer-Referenz](10-reference/core-composer.md) |
| Legacy-Kompatibilität verstehen | [Legacy-Kompatibilitätsreferenz](10-reference/legacy-compatibility.md) |
| Verwenden Sie Blade-Vorlagen und -Anweisungen | [Blade und Referenz zum Rendern von Vorlagen](10-reference/blade-and-template-rendering.md) |
| Suchen Sie nach klassischen Parser-Tags | [Parser-Tags-Referenz](10-reference/parser-tags.md) |
| Suchen Sie nach Artisan-Befehlen für das installierte Projekt | [Artisan Befehlsreferenz](10-reference/artisan-commands.md) |
| Suchen Sie nach Installationsbefehlen | [CLI Referenz](10-reference/cli-reference.md) |
| Befolgen Sie validierte Rezepte | [Tutorials und Rezepte](08-tutorials-recipes/README.md) |
| Paketkonventionen pruefen | [Extras und Pakete](05-extras-and-packages/README.md) |
| Durchsuchen Sie alle Referenzseiten | [Referenz](10-reference/README.md) |
| Verstehen Sie die Quellkarte | [Quellinventar](10-reference/source-inventory.md) |
| Befolgen Sie die Regeln für die Seitenverlinkung | [Dokumentationsnavigation](10-reference/documentation-navigation.md) |
| Siehe zulässige Inhaltsquellen | [Dokumentationsquellenrichtlinie](10-reference/documentation-source-policy.md) |

## Dokumentationsform

Evolution CMS-Produktdokumente sind nach Leseraufgabe organisiert, nicht nach altem Repository
Ordner.

```text
evolution-cms/
  01-getting-started/
  02-using-evolution-cms/
  03-site-building/
  04-development/
  05-extras-and-packages/
  06-api-and-integrations/
  07-security-updates-operations/
  08-tutorials-recipes/
  09-community-support/
  10-reference/
```

Diese Baseline enthaelt die ersten releasefaehigen Produktdokumentationsseiten.
Tiefe method-level references, route payloads und field-level help für den
Manager werden als separate Aufgaben verfolgt und erst nach Validierung des
aktuellen Codes ergänzt.

## Quellrichtlinie

– Der aktuelle Evolution CMS-Code ist die Quelle der Wahrheit für das Laufzeitverhalten.
– Das eigenständige `evolution-cms/installer`-Paket ist die Quelle der Wahrheit für
  der aktuelle Installationsablauf.
- Das alte Dokumentationsarchiv bleibt ein Legacy-Archiv.
- Alte Komponentenhandbücher werden nicht in diesen Produktdokumentbaum migriert, weil
  Installierte Extras stellen ihre eigene Paketdokumentation in dDocs bereit.
- Best-Practice-Notizen können erst nach Überprüfung des aktuellen Codes zu öffentlichen Seiten werden.

## Navigationsregel

Seiten sollten stabile relative Links verwenden. Wenn ein Abschnitt wächst, fügen Sie einen kleinen hinzu
Navigationszeile mit `Back`-, `Up`- und `Next`-Links, damit Leser die Navigation durchqueren können
Dokumente, ohne sich nur auf den Baum zu verlassen.
