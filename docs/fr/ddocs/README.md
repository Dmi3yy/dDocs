# dDocs

dDocs est un navigateur de documentation basé sur les fichiers pour le manager
Evolution CMS. Le module trouve la documentation Markdown dans les paquets
installés, l'affiche sous forme d'arbre, rend le document choisi et garde les
notes du projet comme fichiers.

La source de vérité est le filesystem. dDocs n'a pas besoin de tables de base de
données pour la documentation des paquets.

## Guides

- [Guide utilisateur](user-guide.md)
- [Guide développeur](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Configuration](configuration.md)
- [Reference](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Standards de documentation](documentation-standards.md)

## Règles

- La documentation des paquets vit dans `docs/`.
- La locale ukrainienne de documentation est uniquement `uk`.
- Les vendor docs sont read-only.
- Project Documentation est stockée dans `ProjectDocs/`.
- Les liens internes doivent être relatifs.
- Les code fences doivent indiquer un language identifier.
