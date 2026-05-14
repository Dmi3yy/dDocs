# Resources et arborescence des documents

[Retour](README.md) / [Haut](README.md) / [Suivant](elements.md)

Resources sont les nœuds de contenu affichés dans l'arborescence des documents du gestionnaire. Ils sont
stocké par le modèle `SiteContent` et peut représenter des pages, des dossiers, des liens ou
d'autres types de contenu en fonction de leurs domaines.

## Créer un Resource

1. Ouvrez l'arborescence des documents du gestionnaire.
2. Choisissez l'emplacement parent.
3. Créez une nouvelle ressource ou un nouveau lien à partir de l'arborescence ou des contrôles d'action du gestionnaire.
4. Entrez le titre de la page, l'alias, le modèle, le contenu, les paramètres du menu et publiez
   état.
5. Enregistrez la ressource.
6. Actualisez le cache du site si la modification n'est pas visible immédiatement.

## Modifier le contenu

Ouvrez la ressource depuis l'arborescence et mettez à jour les champs de contenu. Le formulaire ressource
peut inclure des champs Template Variable lorsque le modèle sélectionné est affecté à TVs.

Les champs de ressources importants incluent :

| Zone de terrain | Pourquoi c'est important |
| --- | --- |
| Titre et titre du menu | Utilisé dans l'arborescence du gestionnaire, les menus et les assistants de sortie. |
| Alias ​​| Utilisé par les URL conviviales lorsqu'il est activé. |
| Index des parents et des menus | Contrôlez la position de l’arborescence et l’ordre des menus. |
| Modèle | Disposition des contrôles disponibles et Template Variables. |
| État publié/supprimé | Contrôle si la ressource est visible pour les visiteurs du site. |
| Indicateurs consultables/mises en cache | Affecte le comportement de recherche et de cache. |
| Drapeaux Web/gestionnaire privés | Affecte les règles d’accès. |

## Organiser l'arbre

Utilisez les actions de l'arborescence pour déplacer, dupliquer, supprimer, restaurer, publier et annuler la publication.
ressources. Les opérations de déplacement appellent le flux de déplacement du gestionnaire actuel et déclenchent le déplacement
événements. Supprimer marque généralement une ressource comme supprimée ; vider la corbeille supprime supprimé
ressources.

Si les modifications de l'arborescence ne sont pas visibles, actualisez l'arborescence et videz le cache.

## Recherche Resources

La surface de recherche du gestionnaire peut rechercher des champs de ressources, des identifiants exacts, des URL exactes,
filtres de modèles et valeurs Template Variable. La recherche d'URL exacte utilise le courant
paramètres d'URL conviviaux et résolution d'alias.

Utilisez la recherche lorsque :

- une ressource est cachée au plus profond de l'arbre ;
- l'alias ou l'URL est connu mais l'ID de ressource ne l'est pas ;
- il faut trouver une valeur Template Variable ;
- l'état supprimé/non publié doit être vérifié.

## Remarques sur les URL conviviales

Les URL conviviales dépendent à la fois des paramètres Evolution CMS et de la réécriture du serveur Web.
règles. Si un alias enregistré ne fonctionne pas :

1. Vérifiez le paramètre `friendly_urls`.
2. Vérifiez les paramètres de suffixe, de préfixe, de dossier et d'URL stricte.
3. Vérifiez les règles de réécriture sur le serveur Web.
4. Actualisez le cache du site.
5. Confirmez que la ressource cible est publiée et non supprimée.

Pour des contrôles opérationnels plus approfondis, voir
[Dépannage](../07-security-updates-operations/troubleshooting.md).
