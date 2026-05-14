# Blade et référence de rendu de modèle

[Retour](roles-and-permissions.md) / [Haut](../README.md) / [Suivant](parser-tags.md)

Evolution CMS prend en charge à la fois les modèles d'analyseurs Evolution classiques et les modèles soutenus par Blade.
modèles. Le runtime actuel choisit le chemin de rendu à partir de la ressource
modèle et le mappage de vue Blade disponible.

## Flux de rendu

| Étape | Comportement d'exécution |
| --- | --- |
| Charger la ressource | Core charge l'objet ressource, valide l'état supprimé/publié/référence et prépare les données du document. |
| Résoudre le modèle | Le runtime demande au processeur de modèles une vue de document Blade. Si aucun n'est disponible, il charge le code du modèle à partir de la base de données. |
| Partager des données | Les modèles Blade reçoivent `modx`, `documentObject` et affichent les données du runtime. |
| Rendu Blade | Si une vue Blade existe, elle est restituée par la fabrique de vues et la ressource est traitée comme non mise en cache pour cette passe. |
| Analyser le modèle classique | Si aucune vue Blade n'existe, le code du modèle classique est analysé par l'analyseur Evolution. |
| Invoquer des événements | `OnLoadWebDocument` s'exécute une fois le contenu du document préparé. Les événements de sortie et le comportement post-analyse s’exécutent plus tard dans le flux de réponse. |

Si une ressource n'a pas de modèle attribué, le runtime utilise `[*content*]` comme modèle.
modèle classique vierge.

## Sources de modèles

| Source | Syntaxe ou surface | Remarques |
| --- | --- | --- |
| Modèle de base de données | Manager Élément de modèle | Modèle d'analyseur Evolution classique. |
| Blade affichage du document | Vue résolue du processeur de modèle | Chemin d’accès Blade actuel pour les modèles de ressources. |
| Fichier modèle créé lors de l'enregistrement | Option de modèle Manager | L'enregistrement du modèle peut créer un fichier `.blade.php` correspondant. |
| `@FILE` mode bloc/modèle | `@FILE:path` | Lit un fichier modèle sous le chemin et l'extension du modèle configurés. |
| `@CODE` / `@INLINE` / `@TPL` | Chaîne de code en ligne | Utilisé par les assistants de fragments/modèles d'analyseur. |
| `@DOCUMENT` / `@DOC` | Contenu du document par identifiant ou document actuel | Extrait le contenu du document dans des modèles d'analyseur. |
| `@B_FILE` | Blade mode fichier | Restitue un fichier Blade via la fabrique de vues clonées. |
| `@B_CODE` | Mode code Blade | Écrit un fichier de cache Blade généré et le restitue via un espace de noms `cache::`. |

## Blade Données

Les modèles de document Blade reçoivent l'objet d'exécution actuel et les données du document.

| Variables | Signification |
| --- | --- |
| `$modx` | Objet de base/d'exécution Evolution CMS actuel. |
| `$documentObject` | Données actuelles de l'objet ressource. |
| Afficher les données | Données d'exécution supplémentaires préparées par `getDataForView()`. |

Lorsque le processeur de blocs `DLTemplate` est actif, les mêmes données partagées sont également
transmis dans son intégration Blade.

## Manager Blade Vues

L'interface utilisateur du gestionnaire utilise les vues Blade sous l'espace de noms de la vue du gestionnaire.

| Voir le modèle | Objectif |
| --- | --- |
| `manager::template.page` | Shell de page de gestionnaire standard. |
| `manager::template.blank` | Shell de page de gestionnaire minimal. |
| `manager::partials.header` | Actifs d’en-tête Manager et pile de scripts supérieurs. |
| `manager::partials.footer` | Manager pile de scripts de bas de page et de bas de page. |
| `manager::partials.actionButtons` | Boutons d'action standard de la page du gestionnaire. |
| `manager::form.*` | Gestionnaire partagé de lignes, d'entrées, de commandes radio, de sélections et de zones de texte. |
| `manager::page.*` | Écrans de page Manager et partiels de page imbriqués. |

Les piles Blade courantes utilisées par les vues de gestionnaire incluent `scripts.top` et
`scripts.bot`.

## Directives de base Blade

| Directive | Sortie |
| --- | --- |
| `@evoConfig($key)` | Valeur échappée de `evo()->getConfig($key)`. |
| `@makeUrl($value)` | URL d'échappement générée par le processeur d'URL. |
| `@evoParser($value)` | Analyse du contenu Evolution via `evo_parser()`. |
| `@evoRole($role)` | Ouvre un bloc conditionnel lorsque `evo_role($role)` est vrai. |
| `@evoElseRole($role)` | Ajoute une branche `elseif` pour une autre vérification de rôle. |
| `@evoEndRole` | Ferme le bloc conditionnel du rôle. |
| `@auth` | Vrai lorsque `evo()->getLoginUserID()` n'est pas faux. |
| `@guest` | Vrai lorsqu'aucun utilisateur frontal n'est connecté. |
| `@svg($name, ...)` | Rend un SVG d'icônes Blade via l'adaptateur Evolution. |Les directives personnalisées héritées peuvent toujours être enregistrées à partir de `view.directive`, mais
ce chemin est obsolète et ne doit pas être utilisé pour la documentation des nouveaux produits.

## Aides aux directives de support

La classe d'assistance de support définit également les rappels de directives hérités utilisés par les anciens
Enregistrement de directive piloté par la configuration :

| Aide | Signification |
| --- | --- |
| `csrf()` | Génère un champ CSRF. Obsolète. |
| `evoLang($key)` | Lit une valeur du lexique du gestionnaire. |
| `evoStyle($key)` | Lit une valeur de style gestionnaire. |
| `evoAdminLang()` | Lit le nom de langue du gestionnaire actif. |
| `evoCharset()` | Lit le jeu de caractères du gestionnaire. |
| `evoAdminThemeUrl()` | Lit l'URL du thème du gestionnaire. |
| `evoAdminThemeName()` | Lit le nom du thème du gestionnaire. |

Les nouvelles pages de gestionnaire devraient plutôt préférer les assistants de gestionnaire actuels et les vues partagées.
d'ajouter de nouvelles directives basées sur la configuration.

## Blade Icônes

Evolution CMS est livré avec un adaptateur pour les icônes Blade. L'adaptateur :

- fusionne la configuration principale de `blade-icons` ;
- enregistre la fabrique d'icônes et le manifeste ;
- enregistre la directive `@svg` ;
- enregistre les composants d'icône lorsque le manifeste d'icône existe ;
- publie la configuration `blade-icons.php` en mode console.

Utilisez les icônes via les jeux d'icônes configurés et maintenez les noms des icônes de l'interface utilisateur du gestionnaire stables.
lorsque les documents du package ou les captures d'écran y font référence.

## Règle de documentation

Lors de la documentation du comportement d'un modèle, indiquez si l'exemple est un analyseur classique
syntaxe ou syntaxe Blade. Ne mélangez pas les balises d'analyseur et les directives Blade dans le même
exemple, sauf si la page explique explicitement comment les deux chemins de rendu interagissent.
