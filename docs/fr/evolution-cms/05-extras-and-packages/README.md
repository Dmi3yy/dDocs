# Extras Et Packages

[Evolution CMS](../README.md) / Extras Et Packages

Les Extras etendent Evolution CMS avec des manager modules, frontend
integrations, commands, migrations, parser elements, services ou de la
documentation. Les Extras installes exposent leur propre documentation dans
dDocs; la documentation produit decrit donc ici seulement les conventions
communes de package et d'integration.

## Pages

| Page | Objectif |
| --- | --- |
| [Creer un package](create-package.md) | Creer un package Evolution CMS moderne avec service provider, manager module, EvoUI/Livewire, config, localisation, docs et release checks. |
| [Creer un preset](create-preset.md) | Creer un ready-site scaffold pour installer avec views, themes, custom project code, config, required Extras et validation checks. |

## Limite De Documentation Des Packages

La documentation produit Evolution CMS ne duplique pas chaque Extra installe.
Chaque package doit fournir son propre arbre `docs/<locale>/`, et dDocs indexe
ces fichiers depuis le filesystem.

Cette section sert aux standards communs:

- package layout;
- preset layout;
- Composer et service provider contracts;
- manager module wiring;
- EvoUI et Livewire conventions;
- config et settings conventions;
- package documentation requirements;
- release checklist.

Les workflows, API methods, field lists, screenshots, troubleshooting et
migration notes propres a un package doivent rester dans la documentation de ce
package.
