# Inventaire source

[Retour](../01-getting-started/installation.md) / [Haut](../README.md) / [Suivant](documentation-navigation.md)

Cette référence enregistre les surfaces sources actuelles qui devraient alimenter Evolution
Documentation du produit CMS.

## Sources de code actuelles

| Surfaces | Utilisation de la documentation |
| --- | --- |
| Racine d'évolution | Fichiers d'entrée de projet, métadonnées racine Composer, `index.php` public, exemple de configuration et README au niveau du projet. |
| `core/` | Amorçage du runtime, runtime Composer, configuration, cache d'environnement, migrations de bases de données, seeders, tests, stockage et point d'entrée Artisan. |
| `core/src/` | Services de base, analyseur, fournisseurs, modèles, contrôleurs, middleware, façades, adaptateurs hérités, classes de support et commandes de console. |
| `manager/` | Manager point d'entrée, routage des actions, vues, processeurs, inclusions, médias et comportement de l'interface utilisateur du gestionnaire. |
| `install/` | Programme d'installation Web hérité, script d'installation CLI, ressources d'installation, fonctions de configuration et stubs d'installation. |
| `assets/` | Modules groupés, plugins, extraits de code, ressources de gestion et ressources au moment de l'installation. |
| `views/` | Espaces réservés pour les couches de vue de projet publique. |
| Package d'installation autonome | Flux d’installation actuellement recommandé et comportement de la commande `evo`. |
| Extras installé | Les documents au niveau du package sont découverts séparément par dDocs et ne doivent pas être dupliqués ici. |
| Archives de documents anciens | Matériel de référence existant uniquement, après validation par rapport au code actuel. |
| Notes de bonnes pratiques validées | Recettes futures uniquement après révision du code actuel. |

## Signaux d'exécution actuels

| Signalisation | Remarques |
| --- | --- |
| PHP référence | Le noyau et le programme d'installation actuels nécessitent PHP `^8.3`. |
| Couche de cadre | Core utilise les composants Illuminate 12 et les surfaces Symfony Console/Process. |
| Manager routage | Les requêtes Manager sont acheminées via un seul gestionnaire d'action et des ID d'action. |
| Couche console | Core expose les commandes Artisan pour le cache, les vues, les packages, les préréglages, les itinéraires, la planification, les mises à jour de site, les traductions, les mises à jour d'arborescence, les migrations, les semoirs, Tailwind et les tâches système. |
| Couche de données | Core dispose de modèles Eloquent pour les ressources, les éléments, les utilisateurs, les autorisations, les paramètres, les journaux d'événements, l'état du planificateur/travailleur et les données de l'arborescence des tables de fermeture. |
| Essais | Le noyau actuel comporte des tests Pest pour l'installation, le gestionnaire, le programme de mise à jour, les tâches système, les utilitaires de support et le comportement de compatibilité. |

## Carnet de couverture de la documentation

La ligne de base en anglais couvre les exigences, l'installation par l'installateur en premier,
référence du programme d'installation CLI, concepts de base, flux de travail du gestionnaire principal, projet
structure, cartes de référence des développeurs, démarrage de la configuration/de l'exécution, noyau
Composer, compatibilité héritée, commandes Artisan du projet installé, système
paramètres/valeurs par défaut, rôles et autorisations, Blade/rendu de modèle, classique
balises d'analyseur, deux recettes validées, politique source, règles de navigation et
dépannage de première ligne.

| Écart | Page publique prévue |
| --- | --- |
| API et DB API classiques complets | `06-api-and-integrations/` et `10-reference/` après validation au niveau de la méthode |
| Aide de l'interface utilisateur des paramètres champ par champ | Étendez la [Référence des paramètres système] (system-settings.md) après avoir vérifié chaque étiquette d'onglet du gestionnaire et enregistré le processeur |
| Contrats de charge utile d'événement | Étendre la [Référence des événements](events.md) après avoir validé chaque site d'appel `invokeEvent` |
| Navigation dans la documentation | [Navigation dans la documentation](documentation-navigation.md) |
| Plus de recettes de bonnes pratiques | `08-tutorials-recipes/` après validation du code actuel |
| Traductions locales | Gardez les miroirs localisés synchronisés avec la ligne de base anglaise révisée |
