# Référence sur les rôles et les autorisations

[Retour](system-settings.md) / [Haut](../README.md) / [Suivant](blade-and-template-rendering.md)

Evolution CMS sépare les autorisations du gestionnaire, l'accès au groupe de documents et l'utilisateur Web
accès, verrouillages d'éléments et autorisations de fichiers. Cette page documente l'actualité
Surfaces d'autorisation principales pour la documentation produit. Autorisation spécifique au package
les écrans appartiennent à la source dDocs de chaque package.

## Manager Modèle de rôle

Les rôles Manager sont représentés par le modèle `UserRole`. Les utilisateurs du Manager reçoivent un
rôle via les attributs utilisateur et les contrôles d'autorisation lisent la session active
tableau d’autorisations pour le contexte actuel.

| Surfaces | Objectif |
| --- | --- |
| `UserRole` | Nom du rôle, description et indicateurs d'autorisation du gestionnaire. |
| `UserAttribute.role` | Rôle attribué à un compte gestionnaire ou utilisateur web. |
| `RolePermissions` | Enregistrements d'autorisations supplémentaires liés par rôle. |
| `Permissions` et `PermissionsGroups` | Définitions et regroupements d’autorisations. |
| `UserRoleVar` | Template Variable accès/classement par rôle. |
| `ActiveUserLock` | État de verrouillage pour les éléments et les ressources en cours de modification. |

L'assistant d'autorisation principal est `hasPermission($permission, $context = '')`.
`hasAnyPermissions([...], $context = '')` renvoie vrai lorsqu'un élément est répertorié
l'autorisation est disponible.

## Indicateurs d'autorisation de rôle

| Zone | Indicateurs d'autorisation |
| --- | --- |
| Coque Manager | `frames`, `home`, `logout`, `help`, `messages`, `about`, `credits`, `action_ok`, `error_dialog` |
| Resources | `view_document`, `new_document`, `edit_document`, `save_document`, `publish_document`, `delete_document`, `empty_trash`, `view_unpublished`, `change_resourcetype` |
| Modèles | `new_template`, `edit_template`, `save_template`, `delete_template` |
| Template Variables | L'accès à TV est géré via des relations de rôle TV et des autorisations telles que `manage_tv_permissions` lorsqu'elles sont présentes. |
| Chunks | `new_chunk`, `edit_chunk`, `save_chunk`, `delete_chunk` |
| Snippets | `new_snippet`, `edit_snippet`, `save_snippet`, `delete_snippet` |
| Plugins | `new_plugin`, `edit_plugin`, `save_plugin`, `delete_plugin` |
| Modules | `new_module`, `edit_module`, `save_module`, `delete_module`, `exec_module` |
| Utilisateurs | `new_user`, `edit_user`, `save_user`, `delete_user`, `change_password`, `save_password` |
| Rôles | `new_role`, `edit_role`, `save_role`, `delete_role` |
| Autorisations | `access_permissions`, `web_access_permissions` |
| Fichiers | `file_manager`, `assets_files`, `assets_images`, `bk_manager` |
| Bûches et serrures | `logs`, `view_eventlog`, `delete_eventlog`, `remove_locks`, `display_locks` |
| Import/export statique | `import_static`, `export_static` |
| Internautes | `new_web_user`, `edit_web_user`, `save_web_user`, `delete_web_user` |

Certains chemins de code actuels vérifient également les autorisations nommées les plus récentes, telles que
`manage_groups`, `manage_document_permissions`, `manage_tv_permissions`,
`manage_metatags`, `system_tasks.view`, `system_tasks.site_update` et
`system_tasks.manage_packages`. Documentez ces autorisations avec la fonctionnalité qui
les utilise, car ce sont des noms de capacités plutôt que des colonnes de rôles principaux.

## Autorisations d'accès aux documents

Les autorisations d'accès aux documents utilisent des groupes de documents et des groupes de membres.

| Modèle/Surface de table | Objectif |
| --- | --- |
| `DocumentgroupName` | Groupes de documents nommés. |
| `DocumentGroup` | Lie les ressources aux groupes de documents. |
| `MemberGroup` | Relie les utilisateurs aux groupes membres. |
| `membergroup_access` | Relie les groupes membres aux groupes de documents. |
| `use_udperms` | Permet les vérifications des autorisations des utilisateurs/documents. |
| `udperms_allowroot` | Contrôle le comportement de root pour les autorisations de document. |

Lorsque `use_udperms` est activé, les utilisateurs non-administrateurs sont vérifiés par rapport au
groupes auxquels ils peuvent accéder. Resource Les flux de sauvegarde et d'arborescence/requête doivent conserver ceux-ci.
chèques intacts.

## Autorisations d'accès au Web

Les autorisations d'accès au Web protègent les ressources frontales pour les utilisateurs Web authentifiés.
Elles sont distinctes des autorisations du rôle de gestionnaire.| Surfaces | Objectif |
| --- | --- |
| Internautes | Utilisateurs qui s'authentifient sur l'interface du site. |
| Rôles des utilisateurs Web | Attribution de rôle facultative sur les attributs utilisateur. |
| Groupes d'utilisateurs Web | Groupes utilisés pour les décisions d’accès au frontend. |
| Groupes de documents | Groupes Resource pouvant être connectés aux groupes membres. |
| `web_access_permissions` | Autorisation Manager pour la gestion des accès Web. |

Utilisez cette couche lorsque les visiteurs du site doivent voir uniquement les ressources protégées sélectionnées.
N'utilisez pas les rôles de gestionnaire comme modèle d'autorisation front-end.

## Serrures

Evolution CMS suit les éléments verrouillés pour empêcher toute modification simultanée dangereuse.
Les types verrouillables incluent :

| Identifiant du type | Élément |
| --- : | --- |
| `1` | Modèle |
| `2` | Template Variable |
| `3` | Chunk |
| `4` | Snippet |
| `5` | Plugin |
| `6` | Module |
| `7` | Resource |
| `8` | Rôle |

Les contrôleurs et les modèles exposent l'état du verrouillage via des méthodes telles que
`getLockedElements()`, `isAlreadyEdit` et `alreadyEditInfo`.

## Autorisations de fichiers

Le comportement de création de fichiers est contrôlé par les paramètres système :

| Paramètre | Par défaut | Signification |
| --- | --- | --- |
| `new_file_permissions` | `0644` | Autorisations appliquées aux nouveaux fichiers là où le gestionnaire de fichiers les définit. |
| `new_folder_permissions` | `0755` | Autorisations appliquées aux nouveaux dossiers là où le gestionnaire de fichiers les définit. |
| `filemanager_path` | `[(base_path)]` | Racine pour les opérations du gestionnaire de fichiers. |
| `rb_base_dir` | `[(base_path)]assets/` | Répertoire de base du navigateur Resource. |

Les autorisations de fichiers ne remplacent pas les autorisations du gestionnaire. Un utilisateur a besoin
à la fois la capacité du gestionnaire et l'accès au système de fichiers pour qu'une écriture réussisse.

## Règle de documentation

Lors de la documentation d'une autorisation, nommez la clé d'autorisation exacte et le responsable
surface qui le vérifie. Si la fonctionnalité appartient à un package installé, conservez le
documentation sur les autorisations dans la documentation de ce package et lien vers cette page uniquement pour
le modèle d’autorisation de base.
