# Référence des modèles

[Retour](parser-tags.md) / [Haut](../README.md) / [Suivant](events.md)

Cette référence mappe la surface actuelle du modèle Eloquent. Il s'agit d'une page de recherche pour
auteurs et développeurs de documentation ; ce n'est pas une référence de schéma complète.

## Modèles de contenu et d'arborescence

| Modèle | Responsabilité |
| --- | --- |
| `SiteContent` | Resource/nœuds de l'arborescence du document, champs de contenu, indicateurs de publication/suppression/cache/recherche, relations parent/enfant, groupes de documents, valeurs de modèle et comportement de l'arborescence de la table de fermeture. |
| `ClosureTable` | Stockage d'arborescence ancêtre/descendant/profondeur pour les opérations de hiérarchie de ressources. |
| `DocumentGroup` | Resource-lignes de relation entre le groupe de documents. |
| `DocumentgroupName` | Groupes de documents nommés utilisés par les règles d'accès Web et gestionnaire. |
| `FileGroup` | Lignes du groupe d'accès aux fichiers connectées aux groupes de documents. |

## Modèles d'éléments

| Modèle | Responsabilité |
| --- | --- |
| `SiteTemplate` | Modèles affectés aux ressources et connectés à Template Variables. |
| `SiteTmplvar` | Définitions Template Variable : type, nom, légende, catégorie, éléments, affichage, valeurs par défaut et propriétés. |
| `SiteTmplvarTemplate` | Relation et classement entre le modèle et TV. |
| `SiteTmplvarContentvalue` | Valeurs TV enregistrées pour des ressources individuelles. |
| `SiteTmplvarAccess` | Règles d'accès TV. |
| `SiteHtmlsnippet` | Chunks. Le nom du modèle historique reste `SiteHtmlsnippet`. |
| `SiteSnippet` | Snippets et métadonnées d'extraits liés au module. |
| `SitePlugin` | Plugins, code du plugin, propriétés, liaison de module, état activé/désactivé et recherches alternatives de plugin. |
| `SitePluginEvent` | QQFR0057Relation QQ-événement et priorité. |
| `SiteModule` | Modules Manager, fichiers de code/ressources de module, paramètres partagés et actions d'exécution/modification/dépendance. |
| `SiteModuleAccess` | Règles d'accès Module. |
| `SiteModuleDepobj` | Lignes d'objet de dépendance Module. |
| `Category` | Regroupement de catégories pour les éléments et l'organisation du gestionnaire. |

## Paramètres, événements et journaux

| Modèle | Responsabilité |
| --- | --- |
| `SystemSetting` | Paramètres système chargés par le runtime et le gestionnaire. |
| `SystemEventname` | Registre d'événements nommés connecté aux plugins. |
| `EventLog` | Enregistrements du journal des événements. |
| `ManagerLog` | Enregistrements du journal d'activité Manager. |

## Utilisateurs et autorisations

| Modèle | Responsabilité |
| --- | --- |
| `User` | Modèle de compte utilisateur Manager/web. |
| `UserAttribute` | Profil utilisateur et données d’attribut. |
| `UserSetting` | Paramètres par utilisateur. |
| `UserValue` | Stockage de la valeur utilisateur. |
| `UserRole` | Modèle Manager. |
| `UserRoleVar` | Relation d'accès rôle-à-TV. |
| `Permissions` | Enregistrements d'autorisation Manager. |
| `PermissionsGroups` | Enregistrements de groupes d’autorisations. |
| `RolePermissions` | Lignes de relation d'autorisation de rôle. |
| `MemberGroup` | Lignes de relation de groupe d'utilisateurs Web. |
| `MembergroupAccess` | Lignes de relation d’accès au groupe de membres. |
| `MembergroupName` | Groupes d'utilisateurs Web nommés. |

## Modèles d'état d'exécution

| Modèle | Responsabilité |
| --- | --- |
| `ActiveUser` | Suivi des utilisateurs du gestionnaire actif. |
| `ActiveUserLock` | Verrous d'édition actifs. |
| `ActiveUserSession` | Enregistrements de session du gestionnaire actif. |
| `SystemCliTask` | Lignes de tâches système stockées pour les flux CLI/worker. |
| `SystemCliTaskLog` | Lignes du journal des tâches. |
| `SystemSchedulerHealth` | Dossiers de santé du planificateur. |
| `SystemWorkerHealth` | Dossiers de santé des travailleurs. |

## Règle de documentation

Lors de la rédaction de documents de modèle détaillés, validez le fichier modèle, les relations,
migrations et tests ensemble. Ne déduisez pas les champs uniquement de l'ancienne documentation
ou à partir des étiquettes de l'interface utilisateur.
