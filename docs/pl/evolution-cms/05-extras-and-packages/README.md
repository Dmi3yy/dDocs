# Extras I Pakiety

[Evolution CMS](../README.md) / Extras I Pakiety

Extras rozszerzają Evolution CMS przez manager modules, frontend integrations,
commands, migrations, parser elements, services albo dokumentację. Zainstalowane
Extras mają własną dokumentację w dDocs, dlatego dokumentacja produktu opisuje
tutaj tylko wspólne zasady budowania pakietów i integracji.

## Strony

| Strona | Cel |
| --- | --- |
| [Utwórz pakiet](create-package.md) | Zbuduj nowoczesny Evolution CMS package z service provider, manager module, EvoUI/Livewire, config, lokalizacją, docs i release checks. |
| [Utwórz preset](create-preset.md) | Zbuduj ready-site scaffold dla installer z views, themes, custom project code, config, required Extras i validation checks. |

## Granica Dokumentacji Pakietów

Dokumentacja produktu Evolution CMS nie powiela dokumentacji każdego Extra.
Każdy package powinien dostarczać własne drzewo `docs/<locale>/`, a dDocs
indeksuje te pliki bezpośrednio z filesystem.

Ten rozdział opisuje wspólne standardy:

- package layout;
- preset layout;
- Composer i service provider contracts;
- manager module wiring;
- EvoUI i Livewire conventions;
- config i settings conventions;
- package documentation requirements;
- release checklist.

Workflows, API methods, field lists, screenshots, troubleshooting i migration
notes specyficzne dla pakietu powinny być w dokumentacji tego pakietu.
