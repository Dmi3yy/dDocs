# Extras Und Pakete

[Evolution CMS](../README.md) / Extras Und Pakete

Extras erweitern Evolution CMS mit manager modules, frontend integrations,
commands, migrations, parser elements, services oder Dokumentation.
Installierte Extras haben eigene Dokumentation in dDocs, deshalb beschreibt die
Produktdokumentation hier nur gemeinsame Paket- und Integrationsregeln.

## Seiten

| Seite | Zweck |
| --- | --- |
| [Paket erstellen](create-package.md) | Ein modernes Evolution CMS package mit service provider, manager module, EvoUI/Livewire, config, Lokalisierung, docs und release checks erstellen. |
| [Preset erstellen](create-preset.md) | Ein ready-site scaffold fuer installer mit views, themes, custom project code, config, required Extras und validation checks erstellen. |

## Grenze Der Paketdokumentation

Die Evolution CMS Produktdokumentation dupliziert nicht jedes installierte Extra.
Jedes package sollte ein eigenes `docs/<locale>/` tree liefern, und dDocs
indiziert diese Dateien aus dem filesystem.

Dieser Abschnitt ist fuer gemeinsame Standards:

- package layout;
- preset layout;
- Composer und service provider contracts;
- manager module wiring;
- EvoUI und Livewire conventions;
- config und settings conventions;
- package documentation requirements;
- release checklist.

Package-spezifische workflows, API methods, field lists, screenshots,
troubleshooting und migration notes gehoeren in die Dokumentation des Pakets.
