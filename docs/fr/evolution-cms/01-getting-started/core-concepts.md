# Concepts de base

[Retour](installation.md) / [Haut](README.md) / [Suivant](../07-security-updates-operations/troubleshooting.md)

Cette page définit le vocabulaire utilisé par le produit Evolution CMS actuel
documentation. Il s'agit d'une courte carte conceptuelle et non d'une référence API.

## Termes principaux

| Terme | Signification | Surface du code actuel |
| --- | --- | --- |
| Manager | L'interface d'administration authentifiée utilisée pour modifier le contenu, les éléments, les paramètres, les utilisateurs, les packages et les modules de gestion. | Contrôleurs et vues Manager sous le runtime du gestionnaire. |
| Resource | Un élément de contenu stocké dans l'arborescence du site. Une ressource peut représenter une page, un nœud de type dossier, un lien ou un autre type de contenu en fonction de ses champs. | `EvolutionCMS\Models\SiteContent` et la table `site_content`. |
| Arborescence des documents | La vue hiérarchique des ressources. L'état parent, enfant, ordre, publication, suppression et visibilité affectent tous l'apparence d'une ressource. | `SiteContent` relations parent/enfant et table de clôture. |
| Modèle | Une structure de mise en page/contenu attribuée aux ressources. Les modèles peuvent être connectés au Template Variables. | `EvolutionCMS\Models\SiteTemplate`. |
| Template Variable | Une définition de champ personnalisé qui peut être attachée aux modèles et enregistrée par ressource. | `SiteTmplvar`, `SiteTmplvarTemplate` et `SiteTmplvarContentvalue`. |
| Chunk | Un élément de texte ou de balisage réutilisable. Les Chunks sont généralement utilisés pour des fragments de mise en page répétés ou de petits blocs de sortie réutilisables. | `EvolutionCMS\Models\SiteHtmlsnippet`. |
| Snippet | Un élément basé sur PHP qui peut exécuter une logique et renvoyer une sortie à partir de modèles, de morceaux ou de contenu de ressource. | `EvolutionCMS\Models\SiteSnippet`. |
| Plugin | Code PHP piloté par les événements connecté à un ou plusieurs événements système. Plugins réagit aux événements du cycle de vie du gestionnaire, de l'analyseur, du cache, du document et de l'extension. | `EvolutionCMS\Models\SitePlugin` et `SitePluginEvent`. |
| Événement | Un hook nommé invoqué par le runtime. Les événements sont stockés sous forme de noms et connectés aux plugins en priorité. | `EvolutionCMS\Models\SystemEventname` et `evo()->invokeEvent(...)`. |
| Module | Un outil ou une surface d’application côté gestionnaire. Modules peut être exécuté depuis le gestionnaire et peut appartenir à des packages. | `EvolutionCMS\Models\SiteModule`. |
| Forfait | Un package de code distribué Composer qui peut fournir des services, des vues, des itinéraires, une configuration, des actifs, des modules et de la documentation. | Packages Composer plus commandes/services du package Evolution. |
| Extra | Un package ou une extension facultatif installé dans un projet. Extras possède sa propre documentation de package dans dDocs. | Sources des packages installés indexés par dDocs. |
| Cache | Données d'exécution générées utilisées par l'analyseur, le gestionnaire, les vues, les métadonnées du package et les paramètres. Le cache peut être vidé depuis le gestionnaire ou la console. | `evo()->clearCache('full')`, `cache:clear-full` et actualisation du site. |

## Comment ils s'emboîtent

Une page typique démarre en tant que ressource dans l'arborescence du document. La ressource choisit un
Modèle. Le modèle peut exposer Template Variables pour les champs structurés.
Les modèles Chunks et Snippets peuvent composer la sortie. Plugins écouter les événements pour
étendre le comportement d'exécution. Modules fournit des outils côté gestionnaire pour des flux de travail plus importants.

```text
Resource -> Template -> TV values
         -> Chunks and Snippets
         -> Plugins through Events
         -> Cache and rendered output
```

## Documents sur les produits et documents sur les packages

La documentation du produit Evolution CMS explique les concepts de base du produit, le gestionnaire
comportement, architecture d'exécution, API, opérations et limites de mise à niveau.

Les Extras installés sont documentés par leurs propres packages. dDocs lit ces packages
documents du système de fichiers et les affiche à côté de la documentation du produit. Faire
ne copiez pas les manuels complets du Extra dans cette arborescence de produits à moins que la page n'explique
un contrat d’intégration de base partagé par tous les packages.

## Limites héritées

Evolution CMS contient toujours des surfaces de compatibilité pour le code plus ancien et les anciens
flux d’installation. La documentation actuelle ne devrait nommer ces surfaces que lorsqu'un
le lecteur doit comprendre le comportement de compatibilité ou de migration. Nouveaux tutoriels
et les guides pratiques doivent commencer à partir du programme d'installation, du package, du gestionnaire et
Flux de travail basés sur Composer.
