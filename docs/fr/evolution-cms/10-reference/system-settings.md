# Référence des paramètres système

[Retour](artisan-and-manager-actions.md) / [Haut](../README.md) / [Suivant](roles-and-permissions.md)

Evolution CMS stocke les paramètres d'exécution et de gestionnaire dans la couche des paramètres système.
Les valeurs par défaut pour une nouvelle installation sont définies par l'usine de paramètres de base
et peut être modifié via l'écran Paramètres système du gestionnaire lorsque le
L'utilisateur gestionnaire est autorisé à modifier les paramètres.

## Manager Onglets

| Onglet | Zone de paramètres |
| --- | --- |
| Général | Paramètres par défaut du site, publication, valeurs par défaut du cache, comportement de l'arborescence, modèles, journalisation, dates et suivi des visiteurs. |
| URL conviviales | Mode URL convivial, suffixes, alias, comportement d'URL strict et comportement d'URL de dossier. |
| Interfaces | Manager langue, thème, disposition des menus, dimensionnement de l'arborescence, éditeurs, apparence de connexion et boutons de l'interface utilisateur. |
| Sécurité | Tentatives de connexion, durée de vie de la session, captcha, validation du référent, hachage du mot de passe, politique d'évaluation et disponibilité du site. |
| Dossier Manager | Racine du gestionnaire de fichiers, listes d'autorisation d'extension de téléchargement, taille de téléchargement, autorisations de fichier et autorisations de dossier. |
| Navigateur de fichiers | Racine du navigateur Resource, paramètres de redimensionnement des images, fichiers cachés, vignettes, nettoyage des noms de fichiers et mode navigateur. |
| Modèles de courrier | Expéditeur, transport du courrier, paramètres SMTP, modèles d'inscription et de rappel de mot de passe. |

Plugins peut ajouter HTML aux onglets de paramètres via le rendu des paramètres système
événements répertoriés dans [Référence des événements] (events.md).

## Valeurs par défaut critiques

| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `site_name` | `My Evolution CMS Site` | Nom du site public utilisé par les modèles par défaut et les étiquettes du gestionnaire. |
| `site_start` | `1` | Resource utilisé comme page de démarrage du site. |
| `error_page` | `1` | Resource utilisé pour les erreurs non trouvées, sauf substitution. |
| `unauthorized_page` | `1` | Resource utilisé lorsqu'un visiteur ne peut pas accéder à une page protégée. |
| `site_unavailable_page` | vide | Ressource facultative pour la maintenance/état indisponible. |
| `base_url` | `/` | URL de base utilisée par la génération d'URL d'exécution. |
| `valid_hostnames` | vide | Liste verte des hôtes. Vide signifie aucune liste de noms d'hôtes explicite. |
| `server_protocol` | `http` | Protocole par défaut utilisé dans les URL générées. |
| `server_offset_time` | `0` | Décalage horaire du serveur en secondes. |
| `datetime_format` | `dd-mm-YYYY` | Manager format d'affichage de la date/heure. |

## Resource Paramètres par défaut

| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `default_template` | `0` | Modèle par défaut pour les nouvelles ressources. |
| `publish_default` | `0` | Si les nouvelles ressources sont publiées par défaut. |
| `cache_default` | `1` | Si les nouvelles ressources peuvent être mises en cache par défaut. |
| `search_default` | `1` | Si les nouvelles ressources sont consultables par défaut. |
| `auto_menuindex` | `1` | Attribuez automatiquement des valeurs d’index de menu. |
| `resource_tree_node_name` | `pagetitle` | Champ Resource utilisé comme étiquette du nœud d'arborescence. |
| `tree_page_click` | `27` | Action Manager ouverte en cliquant sur un nœud d'arborescence de ressources. |
| `tree_show_protected` | `0` | Si les ressources protégées sont visibles dans l'arborescence. |
| `show_meta` | `0` | Indique si les champs de métadonnées sont affichés par défaut. |
| `show_newresource_btn` | `1` | Si le nouveau bouton de ressource est affiché. |

## Paramètres d'URL conviviaux par défaut

| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `friendly_urls` | `0` | Les URL conviviales sont désactivées par défaut. |
| `friendly_url_prefix` | vide | Préfixe ajouté aux URL conviviales. |
| `friendly_url_suffix` | `/` | Suffixe ajouté aux URL conviviales. |
| `friendly_alias_urls` | `1` | Les URL basées sur des alias sont activées. |
| `use_alias_path` | `1` | Les alias parents sont inclus dans les chemins générés. |
| `make_folders` | `0` | Le comportement d'URL de type dossier est désactivé par défaut. |
| `seostrict` | `0` | La gestion stricte des URL SEO est désactivée par défaut. |
| `aliaslistingfolder` | `0` | Le comportement du dossier de liste d’alias est désactivé par défaut. |
| `allow_duplicate_alias` | `0` | Les alias en double sont bloqués par défaut. |
| `automatic_alias` | `1` | La génération automatique d'alias est activée. |
| `xhtml_urls` | `1` | Les URL avec échappement de style XHTML sont activées. |

## Paramètres par défaut de l'analyseur et du cache| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `enable_cache` | `1` | Le cache d'exécution est activé par défaut. |
| `cache_type` | `1` | Mode backend du cache par défaut. |
| `chunk_processor` | `DLTemplate` | Processeur Chunk utilisé par défaut. |
| `enable_bindings` | `1` | La syntaxe de liaison est activée. |
| `enable_at_syntax` | `0` | La syntaxe conditionnelle `@` est désactivée par défaut. |
| `allow_eval` | `with_scan` | Le comportement d'évaluation est autorisé avec l'analyse. |
| `safe_functions_at_eval` | `time,date,strtotime,strftime` | Fonctions sécurisées pour l’analyse liée à l’évaluation. |
| `minifyphp_incache` | `0` | La minification PHP dans le cache est désactivée. |
| `html_comment` | vide | Commentaires de débogage facultatifs de l’analyseur. |

Voir [Référence des balises Parser](parser-tags.md) avant de documenter la syntaxe du modèle
ou le comportement de l'analyseur.

## Manager Paramètres par défaut de l'interface

| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `use_editor` | `1` | L'édition de texte enrichi est activée. |
| `which_editor` | `TinyMCE4` | Clé de l'éditeur de texte enrichi par défaut. |
| `tinymce4_theme` | `custom` | Paramètre de thème TinyMCE par défaut. |
| `tinymce4_skin` | `lightgray` | Peau TinyMCE par défaut. |
| `manager_theme_mode` | `3` | Mode thème du gestionnaire par défaut. |
| `manager_menu_position` | `top` | Position du menu Manager. |
| `manager_menu_height` | `2.2` | Hauteur du menu Manager dans `rem`. |
| `manager_tree_width` | `20` | Largeur de l'arborescence Manager dans `rem`. |
| `login_form_position` | `left` | Position de mise en page du formulaire de connexion. |
| `login_form_style` | `dark` | Style de formulaire de connexion. |
| `manager_login_startup` | `0` | Comportement de démarrage du gestionnaire par défaut après la connexion. |
| `use_breadcrumbs` | `0` | Fil d'Ariane désactivé par défaut. |
| `remember_last_tab` | `0` | Manager ne mémorise pas le dernier onglet par défaut. |
| `global_tabs` | `1` | Onglets globaux activés. |
| `group_tvs` | `0` | Les Template Variables ne sont pas regroupés par défaut. |
| `show_picker` | `0` | Interface utilisateur du sélecteur désactivée par défaut. |
| `show_fullscreen_btn` | `0` | Bouton plein écran masqué par défaut. |

## Paramètres par défaut des fichiers et des téléchargements

| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `filemanager_path` | `[(base_path)]` | Chemin de base du gestionnaire de fichiers. |
| `rb_base_dir` | `[(base_path)]assets/` | Répertoire de base du navigateur Resource. |
| `rb_base_url` | `assets/` | URL de base du navigateur Resource. |
| `use_browser` | `1` | Navigateur Resource activé. |
| `which_browser` | `mcpuk` | Implémentation du navigateur de ressources par défaut. |
| `rb_webuser` | `0` | Mode navigateur utilisateur Web désactivé. |
| `upload_maxsize` | `5000000` | Limite de taille de téléchargement en octets. |
| `new_file_permissions` | `0644` | Autorisations pour les fichiers nouvellement créés. |
| `new_folder_permissions` | `0755` | Autorisations pour les dossiers nouvellement créés. |
| `clean_uploaded_filename` | `1` | Les noms de fichiers téléchargés sont nettoyés. |
| `strip_image_paths` | `1` | Les chemins d’image sont supprimés dans les sorties sélectionnées. |
| `denyZipDownload` | `0` | Le téléchargement ZIP est autorisé par défaut. |
| `denyExtensionRename` | `0` | Le blocage du changement de nom d’extension est désactivé par défaut. |
| `showHiddenFiles` | `0` | Les fichiers cachés ne sont pas affichés par défaut. |
| `snapshot_path` | `[(base_path)]assets/backup/` | Chemin d'instantané/sauvegarde par défaut. |

Les listes d'autorisation de téléchargement par défaut sont intentionnellement larges pour des raisons de compatibilité avec les versions antérieures.
Les projets devraient les renforcer pour la politique de production.

## Paramètres de sécurité et d'accès par défaut

| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `use_udperms` | `1` | Les autorisations utilisateur/document sont activées. |
| `udperms_allowroot` | `0` | L'accès root via les autorisations de document est désactivé. |
| `failed_login_attempts` | `3` | Échec des tentatives de connexion avant que le comportement de blocage ne s'applique. |
| `blocked_minutes` | `10` | Durée du blocage de connexion en minutes. |
| `session_timeout` | `15` | QQFR0117Délai d'expiration de la session QQ en minutes. |
| `validate_referer` | `1` | Validation du référent activée. |
| `use_captcha` | `0` | Captcha désactivé par défaut. |
| `pwd_hash_algo` | `0` | Paramètre d'algorithme de hachage de mot de passe par défaut. |
| `check_files_onlogin` | liste des fichiers principaux | Fichiers vérifiés lors de la connexion du gestionnaire. |
| `warning_visibility` | `1` | Avertissements Manager visibles. |
| `send_errormail` | `0` | Erreur d'envoi d'e-mail désactivé. |
| `error_reporting` | `1` | Paramètre de rapport d'erreurs par défaut. |

## Paramètres de messagerie par défaut| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `emailsender` | `you@example.com` | Adresse de l'expéditeur par défaut. |
| `email_sender_method` | `1` | Paramètre de la méthode de l'expéditeur. |
| `email_method` | `mail` | Transport de courrier par défaut. |
| `smtp_host` | `smtp.example.com` | Espace réservé de l’hôte SMTP par défaut. |
| `smtp_port` | `25` | Port SMTP par défaut. |
| `smtp_auth` | `0` | Authentification SMTP désactivée. |
| `smtp_username` | `emailsender` | Espace réservé pour le nom d'utilisateur SMTP par défaut. |
| `smtp_secure` | vide | Pas de mode de cryptage SMTP par défaut. |

## Règle de documentation

Lorsque vous documentez un paramètre, incluez la valeur par défaut actuelle uniquement après avoir vérifié les
paramètres d'usine ou installer le chemin de départ. Si un projet remplace un paramètre via
la base de données ou l'environnement, documentez le remplacement dans la documentation du projet, et non
dans cette référence produit.
