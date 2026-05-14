# Exigences

[Retour](README.md) / [Haut](README.md) / [Suivant](installation.md)

La documentation actuelle de Evolution CMS doit décrire le runtime qui existe actuellement,
pas les anciennes hypothèses d'Evo 1.x des anciennes archives de documents.

## Exécution de base

| Exigence | Référence actuelle |
| --- | --- |
| PHP | `^8.3` |
| Composer | Composer 2.x pour l'installation de projets et de packages. |
| Accès à la base de données | PDO est requis. MySQL, PostgreSQL, SQLite et SQL Server sont pris en charge par les options d'installation actuelles lorsque le pilote PHP correspondant est disponible. |
| PHP extensions | Core nécessite JSON, PDO, ZIP, mbstring, extensions liées à XML, session, tokenizer, OpenSSL, ctype, fileinfo, filter, hash, iconv et PCRE. |
| Prise en charge des images en option | GD ou Imagick sont recommandés pour la gestion des images. |

Le projet racine `composer.json` est minimal, tandis que `core/composer.json` possède le
ensemble de dépendances d'exécution plus large : composants Illuminate 12, Flysystem, PHPMailer,
Tracy, Symfony Process, intégration Composer et packages de prise en charge.

## Durée d'exécution du programme d'installation

Le programme d'installation autonome nécessite :

| Exigence | Remarques |
| --- | --- |
| PHP | `^8.3` |
| Composer | Nécessaire pour l’installation globale du programme d’installation et la configuration du projet. |
| JSON, PDO, MySQLi, ZIP | Requis par le package d’installation. |
| GitHub accès | Nécessaire lorsque le programme d'amorçage télécharge ou met à jour le binaire du programme d'installation Go à partir des versions GitHub. |
| Répertoire bin du programme d'installation inscriptible | Nécessaire pour `evo self-install` et l'installation binaire de première exécution. |

La commande du programme d'installation `system-status` vérifie le système d'exploitation, la version PHP,
Pilotes Composer, PDO, JSON, MySQLi, mbstring, cURL, prise en charge des images, espace disque,
et limite de mémoire.

## Règle de documentation

Si une exigence est copiée à partir d'une ancienne documentation, vérifiez-la par rapport à la version actuelle.
Fichiers Composer, code d'installation et vérifications d'installation avant de le publier ici.
