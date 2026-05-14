# Installation

[Retour](requirements.md) / [Haut](README.md) / [Suivant](core-concepts.md)

Le chemin d'installation actuellement recommandé est le Evolution CMS autonome.
Package d’installation. L'ancien programme d'installation Web existe toujours dans la caisse principale,
mais la documentation moderne devrait d'abord enseigner le flux de travail autonome `evo`.

## Installer le programme d'installation

Installez le programme d'installation globalement avec Composer :

```bash
composer global require evolution-cms/installer
```

Assurez-vous que le répertoire bin global Composer est disponible dans `PATH`, puis vérifiez :

```bash
evo version
```

Lors de la première exécution, le programme d'amorçage PHP installe le binaire Go correspondant à partir de GitHub.
Libère, vérifie les sommes de contrôle, stocke le binaire à côté du programme d'amorçage et
lui délègue le commandement.

Vous pouvez préinstaller le binaire explicitement :

```bash
evo self-install
```

Mettez à jour le binaire du programme d'installation avec :

```bash
evo self-update
```

Pour inspecter l'environnement local avant une installation, exécutez :

```bash
evo system-status
```

La commande status renvoie JSON pour l'adaptateur du programme d'installation. Il vérifie le
système d'exploitation, version PHP, Composer, PDO et pilotes de base de données, JSON, MySQLi,
mbstring, cURL, prise en charge des images, espace disque et limite de mémoire.

## Créer un projet

Exécutez le programme d'installation interactif :

```bash
evo install
```

Le programme d'installation guide l'utilisateur à travers :

- répertoire cible ;
- connexion à la base de données ;
- compte administrateur ;
- répertoire des gestionnaires ;
- langue d'installation ;
- préréglage du projet ;
- sélection Extras en option.

Utilisez le mode interactif lorsqu'un humain choisit le chemin du projet, le préréglage,
base de données, langue et Extras en option. Utilisez le mode CLI lorsque ces réponses sont
connu à l'avance et l'installation doit s'exécuter sans invite TUI.

Pour une installation par script :

```bash
evo install demo \
  --cli \
  --branch=3.5.x \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-username=admin \
  --admin-email=admin@example.com \
  --admin-password=change-me \
  --admin-directory=manager \
  --language=uk \
  --preset=evolution-cms-presets/default
```

Le mode CLI nécessite un type de base de données, un nom de base de données, une adresse e-mail d'administrateur et un nom d'administrateur.
mot de passe. Par défaut, le nom d'utilisateur administrateur est `admin`, le répertoire du gestionnaire est
`manager`, la langue sur `en` et le préréglage sur `evolution` lorsque ces valeurs
ne sont pas fournis.

Pour la liste complète des options, voir [Référence CLI](../10-reference/cli-reference.md).

## Options de base de données

Le programme d'installation prend en charge ces pilotes de base de données lorsque l'extension PHP correspondante
est disponible :

| Chauffeur | Remarques |
| --- | --- |
| `sqlite` | Nécessite un nom de fichier de base de données. Le programme d'installation stocke les noms SQLite normalisés dans le répertoire de la base de données du projet. |
| `mysql` | Nécessite un hôte, un nom de base de données, un utilisateur et un mot de passe en mode CLI, sauf si les valeurs par défaut sont acceptables. |
| `pgsql` | Nécessite le pilote PostgreSQL PDO et les informations d'identification de connexion. |
| `sqlsrv` | Nécessite le pilote SQL Server PDO et les informations d'identification de connexion. |

Le programme d'installation teste la connexion à la base de données avant de continuer. En interactif
mode, une connexion échouée peut être réessayée. En mode CLI, un échec de connexion s'arrête
l'installation.

## Préréglages

Le programme d'installation sépare le noyau Evolution CMS de la couche projet.

| Entrée prédéfinie | Signification |
| --- | --- |
| Omis en mode TUI | Afficher les choix de préréglages du catalogue de préréglages publics. |
| `evolution` | Installez uniquement le noyau Evolution. |
| `default` | Résolvez le problème dans le référentiel public prédéfini par défaut. |
| `evolution-cms-presets/default` | Copiez la couche de projet par défaut après l'installation principale. |
| `owner/repository` | Résolvez en un référentiel GitHub. |
| Git URL ou chemin local | Utilisez une source prédéfinie personnalisée. |

Le préréglage ne définit pas la future identité Git du site créé. Le
le répertoire cible peut devenir son propre référentiel de projet.

Un préréglage peut inclure un suffixe ref lorsqu'une branche ou une balise autre que celle par défaut est nécessaire :

```bash
evo install demo --preset=evolution-cms-presets/default@dev
```

Les préréglages sont appliqués via le fichier « core/artisan » du projet installé.
preset:commande install` une fois le noyau Evolution CMS prêt, puis préréglé
les migrations s'exécutent.

## Extras pendant l'installation

Le programme d'installation peut installer Extras une fois le projet principal prêt :

```bash
evo install demo --extras=sTask,sSeo
```

Les packages Legacy Store peuvent être sélectionnés par ID si nécessaire :

```bash
evo install demo --extras=legacy-store:84@1.12.2
```

Ne documentez pas l'ancienne installation des composants comme chemin par défaut pour l'installation actuelle.
projets. Conservez les informations sur les composants hérités dans l'archive héritée, sauf si un
Le package actuel le remplace explicitement.

Extras installé doit fournir sa propre documentation de package. dDocs découvre
ces documents à partir des sources du package installé et les affiche à côté du produit
documentation.

## Dépannage

| Problème | Vérifier |
| --- | --- |
| GitHub API limite de débit | Définissez `GITHUB_TOKEN` ou transmettez `--github-pat`. |
| Composer est un alias de shell | Définissez `EVO_COMPOSER_BIN` sur le véritable exécutable Composer. |
| Le binaire ne peut pas être installé | Vérifiez les autorisations d'écriture pour le répertoire `bin` du package d'installation. |
| L'option de base de données échoue | Exécutez `evo system-status` et vérifiez le pilote PDO correspondant. |
| Le mode CLI se ferme avant l'installation | Fournissez `--db-type`, `--db-name`, `--admin-email` et `--admin-password`. |
| Un projet existant est détecté | Utilisez `--force` uniquement lorsque vous souhaitez intentionnellement effectuer l'installation dans un répertoire existant. |

## Limite de l'ancien programme d'installation Web

La caisse principale contient toujours un programme d'installation Web et un script d'installation CLI. Garder
ces documents pour la maintenance, la compatibilité et le débogage de l'installation. Nouvel utilisateur
la documentation doit commencer par le programme d'installation autonome, sauf si une tâche est
spécifiquement sur le comportement de l'installation Web héritée.
