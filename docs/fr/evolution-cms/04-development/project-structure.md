# Structure du projet

[Retour](README.md) / [Haut](README.md) / [Suivant](../10-reference/cli-reference.md)

Cette page mappe le référentiel Evolution CMS actuel dans la documentation
limites. Il explique où chercher avant d'écrire un gestionnaire plus profond, API, modèle,
ou les pages d'opérations.

## Disposition de niveau supérieur

| Chemin | Responsabilité |
| --- | --- |
| `composer.json` | Métadonnées Composer au niveau du projet et exigences de base PHP. |
| `index.php` | Point d'entrée public pour les requêtes Web. |
| `core/` | Runtime principal, intégration du framework, configuration, base de données, console, tests, stockage et code source. |
| `manager/` | Manager point d'entrée, actions, processeurs, vues, inclusions et médias de gestion. |
| `assets/` | Actifs publics, fichiers téléchargés, extraits de code/plugins/modules/modèles/espaces réservés TV regroupés, emplacements de cache, de sauvegarde, d'importation et d'exportation. |
| `views/` | Espaces réservés pour les calques de la vue du projet. |
| `install/` | Surface du programme d'installation Web/CLI héritée conservée pour des raisons de compatibilité et de débogage. Les nouveaux documents doivent d'abord enseigner le programme d'installation autonome. |

## Exécution de base

`core/` est la principale limite d'exécution.

| Chemin | Responsabilité |
| --- | --- |
| `core/composer.json` | Ensemble principal de dépendances d'exécution, comprenant les composants Illuminate, la base de données, le routage, la vue, le cache, la file d'attente, la messagerie, le système de fichiers, Tracy, l'intégration Composer et le comportement de fusion de packages. |
| `core/bootstrap.php` | Amorçage d'exécution : chargement automatique Composer, chargement du cache `.env`, définitions personnalisées, définitions principales, sessions, inclusions héritées et inclusions de protection. |
| `core/config/` | Configuration d'exécution pour l'application, le cache, la base de données, les systèmes de fichiers, la journalisation, la session, Tracy, les vues, les icônes, les migrations et le câblage de l'observateur. |
| `core/custom/` | Couche de remplacement du projet pour les exemples d'environnement, les exigences Composer personnalisées, les middlewares, les définitions et les itinéraires. |
| `core/database/` | Migrations, seeders et artefacts de base de données. |
| `core/factory/` | Listes d'exécution au niveau de l'usine telles que les paramètres et les actions du gestionnaire. |
| `core/functions/` | Assistants de fonctions partagées. |
| `core/includes/` | La compatibilité inclut et les fichiers d'inclusion d'exécution. |
| `core/lang/` | Fichiers de langue de base. |
| `core/modifiers/` | Prise en charge de l'analyseur/modificateur. |
| `core/storage/` | Stockage et cache d'exécution générés. |
| `core/tests/` | Couverture actuelle des tests Pest/PHPUnit pour l'installation, le gestionnaire, le noyau, les utilitaires de support, le package/l'exécution et le comportement de compatibilité. |

## Couches sources

`core/src/` est la couche source actuelle PHP.

| Couche | Responsabilité |
| --- | --- |
| `Core.php` | Objet d'exécution central pour la configuration, l'exécution de l'analyseur, le cache, les événements, le chargement de documents et les API de compatibilité. |
| `Parser.php` | Rendu de documents et flux de compatibilité orientés analyseur. |
| `UrlProcessor.php` | Génération d'URL et résolution d'URL conviviale. |
| `Bootstrap/` | Aides à l’environnement et au bootstrap. |
| `Console/` | Commandes Artisan pour le cache, les vues, les packages, les préréglages, les itinéraires, la planification, les mises à jour de site, les traductions, les mises à jour d'arborescence et les tâches système. |
| `Controllers/` | Contrôleurs de pages Manager et écrans de ressources/utilisateurs/système. |
| `Events/` | Cours de support événementiel. |
| `Exceptions/` | Classes d’exceptions d’exécution. |
| `Extensions/` | Cours de prise en charge des extensions. |
| `Facades/` | Accesseurs de style Laravel pour les services partagés. |
| `Interfaces/` | Contrats pour le thème du gestionnaire et les abstractions d'exécution. |
| `Legacy/` | Couche de compatibilité pour les anciennes API et le comportement de l'analyseur. |
| `Middleware/` | Middleware HTTP et gestionnaire. |
| `Models/` | Modèles éloquents pour les ressources, les éléments, les utilisateurs, les autorisations, les paramètres, les événements, l'état du planificateur/travailleur et les données d'arborescence. |
| `Observers/` | Câblage de l'observateur du modèle. |
| `Providers/` | Fournisseurs de services pour l'authentification, Blade, Composer, la configuration, la base de données, les événements, le système de fichiers, le thème du gestionnaire, les packages, le routage, les sessions, les tâches, Tracy, la gestion des URL, etc. |
| `Services/` | Flux de services de niveau supérieur, y compris les services de stockage/package et de tâches système. |
| `Support/` | Classes utilitaires et aides de support. |
| `Tracy/` | Intégration du panneau de débogage. |
| `Traits/` | Caractéristiques partagées pour les modèles et le comportement d'exécution. |

## Manager Exécution

`manager/` est l'interface utilisateur du gestionnaire et la surface d'action.| Chemin | Responsabilité |
| --- | --- |
| `manager/actions/` | Gestionnaires d’actions de gestionnaire hérités et dynamiques. |
| `manager/processors/` | Enregistrer/supprimer/publier/cache/paramètres les processeurs qui modifient les données du gestionnaire. |
| `manager/views/` | Vues Blade pour les pages du gestionnaire, les partiels, les écrans de paramètres, les ressources, les modules, les utilisateurs et les cadres. |
| `manager/includes/` | Contrôle d'accès Manager, vérifications de configuration, inclusions d'analyseur, en-têtes, aides au débogage et limites d'inclusion héritées. |
| `manager/media/` | Manager CSS, JS, images, ressources de navigateur et médias thématiques. |

Lorsque vous documentez le comportement du gestionnaire, validez à la fois la classe contrôleur/source et
la vue gestionnaire ou le processeur qui exécute réellement l'action.

## Modèles et éléments

Le contenu de base et les concepts d'éléments correspondent aux modèles Eloquent :

| Concepts | Modèle |
| --- | --- |
| Resource / nœud d'arborescence de documents | `SiteContent` |
| Modèle | `SiteTemplate` |
| Template Variable | `SiteTmplvar` |
| Relation TV-modèle | `SiteTmplvarTemplate` |
| TV valeur sur une ressource | `SiteTmplvarContentvalue` |
| Chunk | `SiteHtmlsnippet` |
| Snippet | `SiteSnippet` |
| Plugin | `SitePlugin` |
| Relation Plugin-événement | `SitePluginEvent` |
| Nom de l'événement | `SystemEventname` |
| Module | `SiteModule` |
| Paramètres | `SystemSetting` |
| Manager utilisateur | `User` et `UserAttribute` |
| Autorisations et groupes | `Permissions`, `UserRole`, `DocumentGroup`, `DocumentgroupName` et modèles de groupes associés |

La documentation détaillée du modèle champ par champ appartient aux pages API/référence, et non
dans cet aperçu de la structure.

## Package et limites Extra

La documentation du produit Evolution CMS décrit les contrats d'exécution et d'extension partagés.
Les Extras installés possèdent leurs manuels de fonctionnalités. Dans dDocs, la documentation du package est
lu à partir de la racine de la documentation du système de fichiers de chaque package installé et affiché à côté de ceci
arbre de produits.

Documentez un Extra dans cette arborescence de produits uniquement lorsque la page explique un partage
Contrat de package Evolution CMS, comportement de l'installateur ou règle d'intégration du gestionnaire.

## Limite de l'installateur

Le programme d’installation autonome constitue le principal flux d’installation actuel. Il possède `evo
install`, `evo auto-installation`, `evo auto-mise à jour`, and `evo état du système`.

Le dossier `install/` du référentiel reste important pour la compatibilité,
maintenance, stubs d'installation et débogage, mais de nouveaux documents d'installation destinés aux utilisateurs
devrait commencer par le programme d’installation autonome.

## Tester les surfaces

Les tests actuels sont sous `core/tests/` et couvrent :

- comportement d'installation et de migration ;
- Contrats d'interface utilisateur du gestionnaire et comportement d'accès ;
- commandes de mise à jour du cache et du site ;
- supporte les utilitaires et la normalisation des chemins ;
- comportement de compatibilité pour les API existantes ;
- flux de tâches package/magasin/système.

Lorsqu'une page de documentation décrit le comportement d'exécution, préférez un code actuel
chemin plus un test existant comme validation. Si aucun test n’existe, documentez la réclamation
de manière conservatrice et marquer une validation plus approfondie comme travail de suivi.
