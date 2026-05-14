# Référence de compatibilité héritée

[Retour](core-composer.md) / [Haut](../README.md) / [Suivant](artisan-commands.md)

Evolution CMS conserve une couche de compatibilité héritée afin que le code actuel puisse prendre en charge
API Evolution classiques, comportement de l'analyseur, actions du gestionnaire et extension plus ancienne
modèles tandis que le runtime utilise des composants modernes PHP et Illuminate.

## Couche source héritée

| Fichier ou classe | Responsabilité |
| --- | --- |
| `core/includes/legacy.inc.php` | Bootstrap est inclus pour la compatibilité héritée. |
| `Legacy/DeprecatedCore.php` | Comportement de compatibilité de base obsolète. |
| `Legacy/ManagerApi.php` | Action Manager/surface de compatibilité API. |
| `Legacy/TemplateParser.php` | Compatibilité de l'analyseur de modèles. |
| `Legacy/Modifiers.php` | Prise en charge du modificateur d’analyseur et du modificateur conditionnel. |
| `Legacy/Phx.php` | Compatibilité espace réservé/modificateur de style PHx. |
| `Legacy/Cache.php` | Comportement de reconstruction/mise à jour du cache hérité. |
| `Legacy/Permissions.php` | Comportement de compatibilité des autorisations utilisateur/document. |
| `Legacy/ErrorHandler.php` | Gestion des erreurs héritées. |
| `Legacy/LogHandler.php` | Comportement de journalisation hérité. |
| `Legacy/PasswordHash.php` | Compatibilité de hachage de mot de passe hérité. |
| `Legacy/PhpCompat.php` | Aides à la compatibilité PHP. |
| `Legacy/Categories.php` | Comportement de compatibilité des catégories. |
| `Legacy/ModuleCategoriesManager.php` | Comportement de compatibilité de catégorie Module. |
| `Legacy/mgrResources.php` | Compatibilité Manager ressource/élément d'assistance. |

## Fournisseurs hérités

La liste des fournisseurs d'applications enregistre les fournisseurs de compatibilité pour les applications obsolètes.
comportement de base, DB API, gestionnaire API, modificateurs, hachage de mot de passe, PHx,
DLTemplate, ModResource, ModUsers, assistants de système de fichiers et support associé.

Ces fournisseurs maintiennent les API classiques disponibles tandis que le code plus récent utilise les API actuelles.
services, modèles, contrôleurs et façades.

## Legacy inclut et aide

Core Composer charge automatiquement les fichiers d'aide/d'action qui préservent les anciennes fonctions basées sur
superficies :

| Zone | Fichiers chargés automatiquement |
| --- | --- |
| Manager aides à l'action | `functions/actions/*.php` pour le gestionnaire de fichiers, les paramètres, la mutation de contenu, les plugins, la journalisation, l'aide et le comportement du gestionnaire de sauvegarde. |
| Aides à l'exécution | `functions/helper.php`, `functions/laravel.php`, `functions/utils.php` |
| Arbre et nœuds | `functions/nodes.php` |
| Préchargement et processeurs | `functions/preload.php`, `functions/processors.php` |

Le nouveau code devrait préférer les services et modèles actuels, mais la documentation doit
reconnaître que ces surfaces fonctionnelles existent toujours.

## Actions Manager héritées

Le gestionnaire contient toujours des gestionnaires d'actions et des processeurs :

| Surfaces | Objectif |
| --- | --- |
| `core/factory/actionlist.php` | Carte d’ID d’action héritée. |
| `manager/actions/` | Gestionnaires de pages/actions hérités et dynamiques. |
| `manager/processors/` | Processeurs mutants pour la sauvegarde, la suppression, la publication, le cache, les paramètres, les rôles, les modules, les utilisateurs et les éléments. |
| `ManagerTheme` | Résout le comportement actif du thème de l’action/du contrôleur et du gestionnaire. |
| Modèles de cartes d'action | Fournissez des ID d’action de modification/nouveau/enregistrement/suppression/exécution pour les écrans basés sur un modèle. |

Lors de la documentation d'une fonctionnalité de gestionnaire, validez l'ID d'action, le contrôleur/l'action
fichier, processeur et vue Blade ensemble.

## Compatibilité de l'analyseur

Les fonctionnalités de l'analyseur classique font toujours partie du runtime actuel :

| Fonctionnalité | Remarques |
| --- | --- |
| Resource balises | Syntaxe des champs `[*field*]` et TV. |
| Balises de paramètres | `[(setting)]`. |
| Chunks et extraits | `{{chunk}}`, `[[snippet]]` et `[!snippet!]`. |
| Espaces réservés | `[+placeholder+]` avec comportement PHx/modificateur. |
| Balises URL | `[~id~]`. |
| Balises conditionnelles | `<@IF:...>`, `<@ELSEIF:...>`, `<@ELSE>`, `<@ENDIF>`. |
| Modes de modèle | `@CODE`, `@FILE`, `@DOCUMENT`, `@B_FILE` et `@B_CODE`. |

Utilisez [Référence des balises Parser] (parser-tags.md) pour les détails de la syntaxe.

## Ce qu'il ne faut pas migrer aveuglément

Ne copiez pas les anciens manuels de composants dans la documentation du produit simplement parce que le
la couche héritée existe toujours. Anciens composants, anciens extraits et anciennes constructions de sites
les modèles doivent rester dans l'archive héritée à moins qu'ils ne soient validés par rapport au
code actuel et représentent toujours l’utilisation recommandée.

Les Extras installés exposent leurs propres documents en tant que sources dDocs distinctes.

## Règle de documentationLorsque vous documentez un comportement hérité, étiquetez-le comme étant compatible, sauf s'il s'agit du comportement existant.
chemin actuel recommandé. Associez les revendications héritées aux références de code actuelles et
évitez de transformer d’anciennes API en nouveaux exemples de bonnes pratiques.
