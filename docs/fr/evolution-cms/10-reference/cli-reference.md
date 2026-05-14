# CLI Référence

[Retour](../07-security-updates-operations/troubleshooting.md) / [Haut](../README.md) / [Suivant](source-inventory.md)

Cette page est une référence compacte pour la ligne de commande Evolution CMS actuelle.
surfaces de pose. Utiliser [Installation](../01-getting-started/installation.md)
pour le flux d’installation guidée.

## Commandes du programme d'installation

| Commande | Objectif |
| --- | --- |
| `evo install [dir] [flags]` | Installer un projet. Omettez `dir` en mode TUI pour le choisir de manière interactive. |
| `evo self-install` | Téléchargez et installez le binaire du programme d'installation à côté du programme d'amorçage PHP. |
| `evo self-update` | Mettez à jour le binaire du programme d'installation à partir de la dernière version disponible. |
| `evo system-status` | Imprimer l'état du système JSON pour les diagnostics de l'installateur. |
| `evo version` | Imprimez la version du programme d'installation. |

## Installer les drapeaux

| Drapeau | Signification |
| --- | --- |
| `-f`, `--force` | Installez même lorsque le répertoire cible existe déjà ou ressemble à un projet existant. |
| `--branch=<name>` | Installez Evolution CMS à partir d'une branche Git spécifique au lieu de la dernière version compatible. |
| `--preset=<spec>` | Appliquez un préréglage de couche de projet après l'installation principale. |
| `--db-type=<driver>` | Pilote de base de données : `mysql`, `pgsql`, `sqlite` ou `sqlsrv`. |
| `--db-host=<host>` | Hôte de base de données pour les installations non SQLite. |
| `--db-port=<port>` | Port de base de données. En cas d'omission, le programme d'installation utilise la valeur par défaut du pilote lorsque cela est possible. |
| `--db-name=<name>` | Nom de la base de données ou nom du fichier de base de données SQLite. |
| `--db-user=<user>` | Nom d'utilisateur de base de données pour les installations non SQLite. |
| `--db-password=<password>` | Mot de passe de base de données pour les installations non-SQLite. |
| `--admin-username=<name>` | Nom d’utilisateur initial de l’administrateur du gestionnaire. |
| `--admin-email=<email>` | E-mail initial de l'administrateur du gestionnaire. |
| `--admin-password=<password>` | Mot de passe administrateur du gestionnaire initial. En mode CLI, il doit comporter au moins 6 caractères. |
| `--admin-directory=<dir>` | Nom du répertoire Manager. La valeur par défaut est `manager` en mode CLI. |
| `--language=<locale>` | Langue d'installation, par exemple `en` ou `uk`. |
| `--github-pat=<token>` | Jeton GitHub pour les requêtes API et le contournement des limites de débit. |
| `--github_pat=<token>` | Orthographe alternative pour l’option de jeton GitHub. |
| `--extras=<list>` | Extras séparé par des virgules à installer après l'installation. |
| `--log` | Écrivez la sortie du journal du programme d’installation dans `log.md`. |
| `--cli` | Exécuté en mode CLI non interactif. |
| `--quiet` | Réduisez la sortie CLI aux avertissements et aux erreurs. |
| `--composer-clear-cache` | Effacez le cache Composer avant l’installation des dépendances. |
| `--composer-update` | Utilisez `composer update` au lieu de `composer install` lors de la configuration. |

## CLI Mode Valeurs requises

Le mode CLI ne pose pas de questions. Prévoir au minimum :

```bash
evo install demo \
  --cli \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-email=admin@example.com \
  --admin-password=change-me
```En cas d'omission en mode CLI, le programme d'installation par défaut :

| Valeur | Par défaut |
| --- | --- |
| Nom d'utilisateur administrateur | `admin` |
| Manager Annuaire | `manager` |
| Langue | `en` |
| Préréglage | `evolution` |
| Hôte non-SQLite | `localhost` |
| Utilisateur non-SQLite | `root` |

## Spécifications prédéfinies

| Spécification | Résolution |
| --- | --- |
| `evolution` | Installation de base uniquement ; pas de préréglage de couche de projet. |
| `default` | Dépôt de préréglages public par défaut. |
| `evolution-cms-presets/default` | Dépôt GitHub sous l'organisation publique des préréglages. |
| `owner/repository` | Dépôt GitHub. |
| Git URL | Utilisez directement l'URL du référentiel fourni. |
| Chemin local | Utilisez la récupération des préréglages locaux et conservez-la comme source. |
| `spec@ref` ou `spec#ref` | Utilisez une branche, une balise ou une référence spécifique. |

## Extras Syntaxe

| Syntaxe | Signification |
| --- | --- |
| `--extras=sTask,sSeo` | Installez Extras géré par nom de package. |
| `--extras=sTask@dev-main` | Installez un Extra géré avec une contrainte de version ou de branche explicite. |
| `--extras=legacy-store:84@1.12.2` | Installez un package Legacy Store par ID de catalogue et version. |

La documentation Extras appartient au package. Après l'installation, dDocs devrait découvrir
la documentation du système de fichiers de chaque package et affichez-la dans l'arborescence de la documentation.

## Champs d'état du système

`evo system-status` renvoie JSON avec un statut global et des contrôles individuels.
Les contrôles actuels comprennent :

- le système d'exploitation ;
-Version PHP ;
- Disponibilité Composer ;
- PDO et pilotes de base de données ;
- JSON, MySQLi, mbstring, cURL ;
- Prise en charge des images GD ou Imagick ;
- l'espace disque ;
- limite de mémoire.

Les avertissements signifient que l'installation peut toujours se poursuivre en fonction de la base de données sélectionnée
ou une fonctionnalité. Les erreurs signifient qu’il manque à l’environnement une référence requise.
