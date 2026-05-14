# Politique relative aux sources de documentation

[Retour](documentation-navigation.md) / [Haut](../README.md)

La documentation Evolution CMS doit décrire le comportement actuel du produit. Historique
le matériel peut aider, mais il n'est pas canonique tant qu'il n'est pas vérifié par rapport au courant
code.

## Sources autorisées

| Source | Utiliser |
| --- | --- |
| Code Evolution CMS actuel | Runtime, gestionnaire, API, modèles, configuration, événements, CLI, compatibilité du programme d'installation et limites héritées. |
| Code d'installation autonome et README | Flux de configuration actuel du programme d’installation en premier et comportement de la commande `evo`. |
| Anciennes archives de documents Evolution CMS | API classique, DB API, terminologie et comportement historique après validation. |
| Notes de bonnes pratiques validées | Les recettes futures après la vérification des API de routage, de modèle et de gestionnaire actuelles. |
| Documentation du package | Lié lorsqu’un Extra maintenu possède les détails spécifiques au package. |

## Matériel non migré

Les anciens manuels de composants ne sont pas copiés dans cette arborescence de documentation produit. Ils restent dans
les archives héritées. Les Extras actuellement installés apparaissent dans dDocs via leur propre
documentation au niveau du package.

## Règle de révision

Lorsque du matériel historique ou des meilleures pratiques est utilisé :

1. Vérifiez le chemin du code actuel.
2. Vérifiez si la fonctionnalité est actuelle, héritée ou obsolète.
3. Réécrivez la page pour la tâche de lecture en cours.
4. Créez un lien vers la documentation du package au lieu de copier les manuels du package.
5. Conservez les anciennes pages de composants comme documents d'archives.

## Futurs sujets de bonnes pratiques

Les premiers candidats sont :

- routes, requêtes Ajax, validation des requêtes, réponses JSON et partielles Blade
  rendu ;
- Utilisation du modèle `SiteContent`, requêtes TV, parcours de l'arbre de fermeture et ressources
  modèles de sélection.

Ceux-ci appartiennent une fois que la documentation de base est suffisamment précise pour les prendre en charge et
après que les exemples ont été vérifiés par rapport au code actuel.
