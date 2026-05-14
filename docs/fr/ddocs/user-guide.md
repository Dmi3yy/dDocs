# Guide utilisateur

Ce guide montre comment lire et maintenir la documentation dans dDocs depuis le
manager Evolution CMS.

## Ouvrir le module Documentation

1. Connectez-vous au manager Evolution CMS.
2. Ouvrez le module Documentation.
3. Attendez le chargement de l'arbre à gauche et du viewer à droite.

## Lire la documentation d'un paquet

1. Choisissez une source sur la page d'accueil ou dans l'arbre.
2. Ouvrez les dossiers nécessaires.
3. Sélectionnez un document.
4. Lisez le Markdown rendu dans le panneau droit.

Les vendor docs sont en lecture seule. Modifiez-les dans le repository du paquet.

## Rechercher

1. Cliquez le champ de recherche dans le sidebar.
2. Saisissez un mot du titre, du chemin, du nom du paquet ou du contenu.
3. Ouvrez un résultat dans l'arbre filtré.
4. Videz le champ pour revenir à l'arbre complet.

## Comprendre le fallback de langue

dDocs commence par la langue du manager. Si la documentation manque, il passe à
English puis aux neutral docs.

La documentation ukrainienne utilise uniquement `uk`. Le legacy manager input
`ua` est normalisé vers `uk`.

## Créer un document projet

1. Cliquez create document dans le toolbar sidebar.
2. Saisissez le nom du document.
3. Confirmez le dialog.
4. dDocs crée un Markdown file dans `ProjectDocs/`.

## Modifier un document projet

1. Ouvrez un document de Project Documentation.
2. Cliquez edit dans le document header.
3. Modifiez le Markdown dans l'editor.
4. Cliquez save.
