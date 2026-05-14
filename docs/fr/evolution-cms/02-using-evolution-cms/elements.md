# Éléments

[Retour](resources-and-document-tree.md) / [Haut](README.md) / [Suivant](settings-permissions-and-files.md)

Element Management est la zone de gestion des modèles, Template Variables,
morceaux, extraits, plugins et modules. Le code du manager actuel les organise comme
onglets du contrôleur Resources.

## Types d'éléments

| Élément | Utilisez-le pour |
| --- | --- |
| Modèle | Mise en page et structure de sortie des ressources. |
| Template Variable | Champs personnalisés attachés aux modèles et enregistrés par ressource. |
| Chunk | Balisage ou fragments de texte réutilisables. |
| Snippet | Logique basée sur PHP qui renvoie la sortie. |
| Plugin | Code d'extension piloté par les événements. |
| Module | Manager-côté outil ou écran d'application. |

## Travailler avec des modèles

Créez ou modifiez des modèles lorsqu'une ressource nécessite une mise en page ou un ensemble différent de
Template Variables. Un modèle peut être sélectionnable, verrouillé, catégorisé et lié
à TVs.

Lors d'un changement de modèle :

1. Enregistrez le modèle.
2. Examinez le Template Variables attribué.
3. Actualisez le cache lorsque la sortie ne change pas.
4. Testez les ressources qui utilisent le modèle.

## Travailler avec Template Variables

Template Variables définit les champs structurés qui apparaissent sur les ressources à l'aide du
modèles attribués. TVs ont un type, une légende, une catégorie, des éléments/options,
mode d'affichage, texte par défaut et règles d'accès aux rôles/modèles.

Utilisez TVs pour les données de contenu que les éditeurs doivent gérer séparément du fichier principal.
champ de contenu de la ressource.

## Travailler avec Chunks et Snippets

Les Chunks sont des blocs de texte ou de balisage réutilisables. Les Snippets sont des blocs logiques soutenus par PHP.
Les deux peuvent être activés, désactivés, dupliqués, supprimés, verrouillés et catégorisés à partir de
le gérant.

Utilisez des morceaux pour un balisage répété. Utilisez des extraits lorsque la sortie nécessite une logique d’exécution.

## Travailler avec Plugins et les événements

Plugins sont connectés à des événements nommés et s'exécutent lorsque le runtime les appelle
événements. L'ordre Plugin est contrôlé par la priorité de l'événement. Utiliser des plugins pour le cycle de vie
crochets tels que la sauvegarde de documents, l'analyseur, le gestionnaire, le cache, le navigateur de fichiers et l'utilisateur
événements.

Voir [Référence des événements](../10-reference/events.md) avant d'ajouter ou de modifier un
connexion à l'événement du plugin.

## Travailler avec Modules

Modules sont des outils côté gestionnaire. Ils peuvent avoir du code de module, des fichiers de ressources,
paramètres partagés, dépendances et actions d'exécution/modification. Les modules de package installés peuvent
disposent également d'une documentation appartenant au package dans dDocs.

Ne copiez pas le manuel d'un module de package dans cette arborescence de documentation du produit. Ouvrez le
source du package dans dDocs lorsque la fonctionnalité appartient à un Extra installé.
