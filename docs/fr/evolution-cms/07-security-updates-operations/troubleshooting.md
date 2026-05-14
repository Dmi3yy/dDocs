# Dépannage

[Retour](../01-getting-started/core-concepts.md) / [Haut](README.md) / [Suivant](../10-reference/source-inventory.md)

Utilisez cette page pour les vérifications de première ligne avant d'ouvrir un code plus approfondi ou un hébergement
diagnostic. Il se concentre sur le Evolution CMS actuel et le comportement de l'installateur.

## Vérifications rapides

| Symptôme | Vérifiez d'abord |
| --- | --- |
| Le programme d'installation ne démarre pas | Confirmez PHP 8.3 ou version ultérieure, la disponibilité de Composer et un répertoire binaire d'installation inscriptible. Exécutez `evo system-status` lorsqu’il est disponible. |
| Le programme d'installation ne peut pas télécharger ou mettre à jour le fichier binaire | Vérifiez l'accès réseau aux versions GitHub. En cas de débit limité, définissez `GITHUB_TOKEN` ou transmettez l'option de jeton d'installation GitHub. |
| Composer est introuvable | Assurez-vous que Composer est un exécutable sur `PATH`, et pas seulement un alias de shell. Définissez `EVO_COMPOSER_BIN` lorsque l'hôte a besoin d'un chemin Composer explicite. |
| La configuration de la base de données échoue | Vérifiez que le pilote de base de données sélectionné est installé pour PHP, que les paramètres hôte/port/nom/utilisateur/mot de passe sont corrects et que les noms SQLite sont valides pour le répertoire de base de données du projet. |
| L'installation est terminée mais la connexion du gestionnaire échoue | Vérifiez le répertoire du gestionnaire choisi lors de l'installation, le comportement de la session/du cookie, les enregistrements des utilisateurs de la base de données et si la commande d'installation a signalé des avertissements de repli de l'utilisateur administrateur. |
| Une page est vierge ou renvoie une erreur de serveur | Vérifiez les journaux d'erreurs PHP, les journaux d'application, les dépendances Composer manquantes et si les caches générés nécessitent une actualisation complète. |
| Les modifications ne sont pas visibles sur le site | Videz le cache complet ou exécutez l'action d'actualisation du site. La mise en cache Resource, le cache d'affichage, le cache d'environnement et le cache du navigateur peuvent tous masquer les modifications récentes. |
| Les URL conviviales ne fonctionnent pas | Vérifiez que `friendly_urls` est activé, que les règles de réécriture sont configurées sur le serveur Web, que les alias sont valides et que le cache a été actualisé. |
| Le navigateur de fichiers ou les téléchargements échouent | Vérifiez `filemanager_path`, `rb_base_dir`, les paramètres d'extension de téléchargement, la taille de téléchargement maximale et les autorisations du système de fichiers pour les répertoires cibles. |
| Un utilisateur gestionnaire ne peut pas voir un document | Vérifiez les autorisations du gestionnaire, les groupes de documents, les groupes d'utilisateurs, les indicateurs de confidentialité des ressources et si l'utilisateur a accès à l'action du gestionnaire. |
| La documentation du package est manquante dans dDocs | Confirmez que le package possède un dossier de système de fichiers `docs/`, que le package est installé dans le projet, que dDocs a été actualisé et que la langue actuelle du gestionnaire correspond à un paramètre régional de documentation disponible. |
| Une fonctionnalité spécifique à Extra n'est pas documentée ici | Ouvrez ce Extra dans dDocs. La documentation du produit décrit le comportement partagé du Evolution CMS ; Les Extras installés possèdent leurs manuels de fonctionnalités. |

## Cache et actualisation

Le chemin d’actualisation complet commun appelle `evo()->clearCache('full')`. Le site du gestionnaire
L'actualisation publie et dépublie également les ressources planifiées, efface le cache complet,
supprime le cache d'environnement généré lorsqu'il est présent et appelle l'événement d'actualisation du site.

Utilisez une actualisation du cache après avoir modifié :

- modèles, morceaux, extraits de code, plugins, modules ou Template Variables ;
- les paramètres système qui affectent le routage, les chemins, les téléchargements, le cache ou la sortie du gestionnaire ;
- les fournisseurs de services de package, les actifs, les vues ou la configuration générée ;
- Alias ​​de ressources, état de publication, autorisations ou paramètres d'URL conviviaux.

## Liste de contrôle des URL conviviales

Les problèmes d'URL conviviales impliquent généralement à la fois les paramètres Evolution CMS et le serveur Web.
configuration.

| Zone | Que vérifier |
| --- | --- |
| Paramètres Manager | `friendly_urls`, paramètres de suffixe/préfixe, comportement du dossier, paramètres d'URL stricts et alias. |
| Serveur Web | Les règles de réécriture Apache ou le routage Nginx équivalent sont actifs pour le projet. |
| Resources | Les alias sont uniques là où ils sont nécessaires et les ressources sont publiées, visibles et non supprimées. |
| Cache | Actualisez le site après avoir modifié les alias, les paramètres d'URL ou le comportement de réécriture. |

## Liste de contrôle des fichiers et des téléchargements

Les problèmes de gestionnaire de fichiers et de téléchargement proviennent généralement de chemins, de listes autorisées d'extensions ou
autorisations.| Zone de réglage | Que vérifier |
| --- | --- |
| Chemin du gestionnaire de fichiers | Le chemin configuré pointe à l'intérieur du projet et est lisible par PHP. |
| Resource répertoire de base du navigateur | Le répertoire de base du navigateur pointe vers l’emplacement prévu des ressources. |
| Télécharger des extensions | Les listes de fichiers, d'images et d'extensions multimédias autorisent le type de fichier attendu. |
| Taille du téléchargement | Les limites de téléchargement Evolution CMS et PHP/serveur Web sont suffisamment élevées. |
| Autorisations | PHP peut créer, écrire, renommer et supprimer des fichiers dans le répertoire cible. |

## Limite de la documentation du package

dDocs est la surface de documentation du package pour Extras installé. Si un colis
apparaît dans l'arborescence dDocs avec uniquement un nom de package ou sans pages localisées,
corrigez la source de la documentation du paquet plutôt que de copier son manuel dans
Documentation du produit Evolution CMS.

Pour les problèmes de documentation du package, vérifiez :

- le package contient `docs/en/README.md` ou une autre entrée de paramètres régionaux prise en charge ;
- Les documents du package ukrainien utilisent le dossier de paramètres régionaux `uk` ; héritage local ukrainien
  les dossiers doivent être migrés avant la publication ;
- les documents du package ont des titres stables et un H1 par page ;
- les liens relatifs sont résolus à l'intérieur de la racine de la documentation du package ;
- L'index/le cache dDocs a été actualisé après les modifications de fichiers.

## Données de support à collecter

Lorsqu'un problème nécessite un examen plus approfondi, collectez :

- Version PHP et pilotes de base de données activés ;
- version ou branche Evolution CMS ;
- version du programme d'installation et commande utilisée ;
- le type de base de données et si le problème se produit avant ou après les migrations ;
- langage du gestionnaire ;
- modification des paramètres système liés au cache, aux URL, aux chemins, aux téléchargements ou aux autorisations ;
- l'action exacte du gestionnaire ou l'URL qui échoue ;
- installations ou mises à jour récentes du package.
