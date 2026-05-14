# Navigation documentaire

[Retour](source-inventory.md) / [Haut](../README.md) / [Suivant](documentation-source-policy.md)

La documentation Evolution CMS utilise une petite grammaire de navigation pour que les lecteurs puissent se déplacer
à travers une section sans s'appuyer uniquement sur l'arborescence de gauche.

## Types de navigation

| Type de lien | Objectif | Exemple |
| --- | --- |
| Structurel | Parcourez l’arborescence de la documentation. | `Back`, `Up`, `Next` |
| Section enfants | Afficher les pages appartenant à une section. | Un tableau dans `README.md` |
| Sémantique | Connectez les concepts ou les zones sources associés. | `Related`, `See Also` |

## Liens structurels

Utilisez cette forme en haut des sections de plusieurs pages :

```text
# Page Title

[Back](previous.md) / [Up](README.md) / [Next](next.md)

Short reader-focused opening paragraph.

## Task Or Reference Section

...

## Related

- [Relevant page](other-page.md)
```

Si un voisin structurel n’existe pas, omettez ce lien au lieu d’inventer un
cible.

## Pages de destination des sections

Les pages de la section `README.md` doivent être de petits portails. Ils devraient inclure :

- un court paragraphe sur la section ;
- un tableau des pages enfants ;
- la portée actuelle de la section ;
- des liens vers des sections connexes uniquement en cas de besoin.

## Pages de référence source

Les pages de référence source peuvent inclure des tables sources, des listes de commandes, des listes de modèles,
tables de configuration et état de validation. Ils ne doivent pas inclure des
chemins du système de fichiers, termes de planification interne ou métadonnées d’analyse générées.

## Extras Liens

Ne dupliquez pas la documentation Extras installée dans le produit Evolution CMS.
documents. Lien vers la documentation au niveau du package lorsqu'un package maintenu possède les détails.
