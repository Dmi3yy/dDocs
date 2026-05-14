# API et intégrations

[Evolution CMS](../README.md) / API et intégrations

Cette section rassemble les surfaces d'intégration destinées aux développeurs pour les
Evolution CMS : API d'exécution principales, modèles, événements, actions du gestionnaire, Artisan
commandes, limites des packages et couches de compatibilité.

## Pages

| Pages | Objectif |
| --- | --- |
| [Référence des modèles](../10-reference/models.md) | Carte modèle Eloquent actuelle et groupes de responsabilité. |
| [Référence des événements](../10-reference/events.md) | Surfaces d'événements/plug-ins actuelles regroupées par zone d'exécution. |
| [Référence des paramètres système](../10-reference/system-settings.md) | Paramètres d'usine actuels et onglets des paramètres du gestionnaire. |
| [Référence sur les rôles et les autorisations](../10-reference/roles-and-permissions.md) | Rôles Manager, clés d'autorisation, groupes de documents, accès Web, verrous et autorisations de fichiers. |
| [Référence d'exécution de configuration](../10-reference/configuration-runtime.md) | Bootstrap, cache d'environnement, fichiers de configuration, remplacements personnalisés, fournisseurs, alias et middleware. |
| [Référence de base Composer](../10-reference/core-composer.md) | Dépendance Composer et limites de chargement automatique. |
| [Référence de compatibilité héritée](../10-reference/legacy-compatibility.md) | Services hérités, aides, compatibilité des analyseurs et compatibilité des actions du gestionnaire. |
| [Référence des commandes Artisan](../10-reference/artisan-commands.md) | Surface de commande complète du projet installé enregistrée par le runtime principal. |
| [Blade et référence de rendu de modèle](../10-reference/blade-and-template-rendering.md) | Rendu Blade, vues du gestionnaire, directives et directives d'icône. |
| [Référence des balises de l'analyseur](../10-reference/parser-tags.md) | Balises de l'analyseur Classic Evolution et ordre de l'analyseur. |
| [Actions Artisan et Manager](../10-reference/artisan-and-manager-actions.md) | Surface de recherche actuelle des commandes et des actions du gestionnaire. |
| [Creer un package](../05-extras-and-packages/create-package.md) | Package structure moderne, service provider wiring, manager module pattern, EvoUI/Livewire surfaces, docs et release checks. |
| [Creer un preset](../05-extras-and-packages/create-preset.md) | Ready-site scaffold structure pour installer presets, required Extras, theme assets, custom project code et validation checks. |
| [Structure du projet](../04-development/project-structure.md) | Disposition source derrière les pages de référence. |

## Portée

Cette section est une carte validée des surfaces d'intégration actuelles. Au niveau de la méthode
Les références classiques aux bases de données Core API, DB API, de routage et champ par champ doivent
être ajouté en tant que pages de référence distinctes seulement après que chaque affirmation ait été vérifiée par rapport à
code actuel.
