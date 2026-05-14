# Guide utilisateur

Ce guide montre aux utilisateurs du manager comment lire et maintenir la
documentation dans dDocs. Il se concentre sur les tâches dans le manager
Evolution CMS.

## Ouvrir le module Documentation

1. Connectez-vous au manager Evolution CMS.
2. Ouvrez le module Documentation depuis le menu du manager.
3. Attendez que l'arbre de documentation à gauche et le panneau viewer à droite soient chargés.

La vue d'accueil liste les sources de documentation disponibles. Une source peut
être un paquet, le paquet dDocs lui-même ou Project Documentation.

## Parcourir les docs d'un paquet

1. Sélectionnez une source depuis la vue d'accueil ou l'arbre de gauche.
2. Dépliez les dossiers avec le chevron.
3. Sélectionnez un document.
4. Lisez le Markdown rendu dans le panneau de droite.

Les docs des paquets vendor sont en lecture seule. Pour les modifier, éditez les
fichiers dans le dépôt du paquet.

## Rechercher dans la documentation

1. Cliquez dans le champ de recherche de la sidebar.
2. Tapez un mot du titre, du chemin, du nom de paquet ou du contenu.
3. Ouvrez un résultat depuis l'arbre filtré.
4. Effacez le champ de recherche pour revenir à l'arbre complet.

dDocs ignore les fichiers plus grands que `max_file_size_kb` pour garder la
navigation manager réactive.

## Comprendre le fallback de langue

dDocs commence par la langue actuelle du manager. Si cette locale manque, il
revient à l'anglais puis aux docs neutres.

La documentation ukrainienne utilise `uk`. Si un ancien manager rapporte encore
la valeur legacy `ua`, dDocs ouvre automatiquement les docs `uk`.

## Changer la langue de documentation

dDocs suit actuellement la langue du manager ou la valeur configurée
`default_language`. Changez la langue du manager ou définissez `default_language`
quand un projet a besoin d'une langue de documentation fixe.

## Créer un document projet

1. Cliquez sur le bouton de création de document dans la toolbar de la sidebar.
2. Entrez le nom du document.
3. Confirmez le dialogue.
4. dDocs crée un fichier Markdown dans `ProjectDocs/` et l'ouvre.

Project Documentation est l'espace modifiable pour les connaissances locales du
projet.

## Créer un dossier projet

1. Cliquez sur le bouton de création de dossier dans la toolbar de la sidebar.
2. Entrez le nom du dossier.
3. Confirmez le dialogue.
4. Ouvrez le nouveau dossier depuis l'arbre.

Les noms de dossiers et documents sont convertis en noms de fichiers sûrs avant
l'écriture sur disque.

## Modifier un document projet

1. Ouvrez un document depuis Project Documentation.
2. Cliquez l'action edit dans l'en-tête du document.
3. Mettez à jour le Markdown dans l'éditeur.
4. Cliquez save.

dDocs rafraîchit l'index de fichiers après la sauvegarde.

## Supprimer un élément projet

1. Ouvrez le menu contextuel d'un élément modifiable de Project Documentation.
2. Choisissez delete.
3. Confirmez le dialogue.

La suppression n'est pas disponible pour les docs de paquets vendor ni pour les
racines de sources.

## Copier Markdown ou code

Utilisez l'action copy dans l'en-tête du document pour copier toute la source
Markdown. Utilisez l'action copy sur un bloc de code pour copier uniquement ce
snippet.

## Rafraîchir l'index

1. Ouvrez le panneau settings.
2. Cliquez refresh index.
3. Attendez le compteur de documents rafraîchi.

Rafraîchissez l'index après des changements manuels dans les docs de paquets ou
après modification des roots de documentation configurés.

## Télécharger la documentation en Markdown

1. Ouvrez le panneau settings.
2. Cliquez Download Markdown.
3. Enregistrez le fichier `.md` généré.

L'export contient les nœuds de documents lisibles depuis l'index dDocs courant.
Les liens relatifs locaux et les images gardent leurs chemins source originaux.

## Diagnostiquer un document manquant

Si un document manque:

1. Rafraîchissez l'index.
2. Vérifiez que l'extension du fichier est autorisée.
3. Vérifiez que le fichier est sous `max_file_size_kb`.
4. Vérifiez que le paquet a une structure `docs/` supportée.
5. Demandez à un développeur de vérifier les safe roots si la source est spécifique au projet.
