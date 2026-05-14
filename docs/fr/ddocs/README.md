# dDocs

dDocs est un navigateur de documentation file-first pour le manager Evolution
CMS. Il découvre la documentation Markdown dans les paquets Evolution installés,
affiche les racines de paquets dans l'arbre de gauche, rend le document sélectionné
dans le panneau de droite et permet au projet de garder sa propre base de
connaissances Markdown locale.

La source de vérité est le système de fichiers. dDocs n'a pas besoin de tables de
base de données pour la documentation des paquets.

## Capacités

- Découvrir la documentation des paquets Evolution installés.
- Afficher un arbre paquet/module avec dossiers et documents Markdown.
- Respecter la langue actuelle du manager avec fallback vers l'anglais ou des docs neutres.
- Rechercher par titre, chemin, nom de paquet et contenu Markdown.
- Rendre GitHub-flavored Markdown en sécurité dans le manager.
- Résoudre les liens relatifs entre documents indexés.
- Rendre les images locales uniquement depuis des docs roots sûres.
- Garder la documentation du projet dans `ProjectDocs/`.
- Mettre en cache l'index de fichiers généré pour accélérer la navigation manager.

## Guides

- [Guide utilisateur](user-guide.md)
- [Guide développeur](developer-guide.md)
- [Frontend guide](frontend-guide.md)
- [Configuration](configuration.md)
- [Référence](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Standards de documentation](documentation-standards.md)

## Rendu Markdown

dDocs envoie le Markdown brut à la page manager et le rend dans le navigateur
avec les assets locaux dTui/TOAST UI. La coloration du code utilise les assets
locaux Prism, y compris la grammaire Evolution Blade.

dDocs possède toujours la couche de sécurité autour du viewer:

- les blocs HTML de type script sont supprimés avant l'envoi du Markdown au viewer;
- les liens relatifs de documentation sont mappés vers les ids des documents dDocs indexés;
- les images locales sont converties seulement si elles passent les contrôles de safe docs root;
- les liens relatifs manquants restent inertes au lieu de naviguer l'iframe manager.

## Modèle runtime

```text
Paquets Composer / paquets Evolution locaux
        |
        v
DocsSourceRegistry
        |
        v
DocsIndexer
        |
        v
FileIndexCache
        |
        v
Livewire ModulePanel -> raw Markdown payload -> dTui/TOAST UI Viewer
                                           -> link/image post-processing
```

## Documentation projet

Les documents créés depuis l'UI dDocs sont stockés dans `ProjectDocs/` à
l'intérieur du paquet dDocs. La documentation projet est modifiable, tandis que
la documentation des paquets vendor reste en lecture seule.

Utilisez la documentation projet pour les connaissances locales du projet courant:

- notes d'architecture;
- notes d'environnement;
- notes de déploiement;
- décisions spécifiques au projet;
- contexte de travail AI/Codex.
