# Référence des événements

[Retour](parser-tags.md) / [Haut](../README.md) / [Suivant](models.md)

Les plugins Evolution CMS écoutent les événements nommés. Le code actuel appelle des événements de
le moteur d'exécution principal, les contrôleurs/vues/processeurs du gestionnaire, le navigateur de fichiers, le cache
couche, services de document/utilisateur et surfaces de compatibilité. Nouvelles installations
insérer les noms d'événements par défaut dans la table `system_eventnames` lorsqu'il est
vide.

## Services événementiels

| Numéro de service | Zone |
| --- : | --- |
| `1` | Analyseur, documents, éléments, paramètres, navigateur de fichiers et événements généraux du système. |
| `2` | Manager événements d'authentification du shell et du gestionnaire. |
| `3` | Authentification des utilisateurs Web et événements du cycle de vie des utilisateurs Web. |
| `4` | Événements de cache et de cache de pages. |
| `5` | Runtime Web, rendu des pages, URL, propriétés de l'analyseur et événements de sortie. |

## Événements d'exécution et d'analyseur

| Événement | Zone typique |
| --- | --- |
| `OnWebPageInit` | Initialisation de la requête Web. |
| `OnBeforeLoadDocumentObject` | Avant de charger l'objet document. |
| `OnLoadDocumentObject` | Chargement de l'objet du document. |
| `OnAfterLoadDocumentObject` | Après avoir chargé l'objet document. |
| `OnLoadWebDocument` | Flux de chargement des documents. |
| `OnWebPagePrerender` | Avant le rendu de la sortie de la page Web. |
| `OnLoadWebPageCache` | Chargement du cache de pages. |
| `OnBeforeSaveWebPageCache` | Avant de sauvegarder le cache des pages. |
| `OnWebPageComplete` | Fin du traitement de la page Web. |
| `OnParseDocument` | Crochet d’analyse de documents. |
| `OnBeforeParseParams` | Avant l'analyse des paramètres. |
| `OnParseProperties` | Analyse de propriété. |
| `OnMakeDocUrl` | Génération d'URL. |
| `OnStripAlias` | Normalisation des alias. |
| `OnPageNotFound` | Manipulation introuvable. |
| `OnPageUnauthorized` | Gestion de pages non autorisées. |
| `OnLogPageHit` | Journalisation des pages consultées. |
| `OnLogEvent` | Rédaction du journal des événements. |
| `OnLoadSettings` | Chargement des paramètres d’exécution. |
| `OnBeforeLoadExtension` | Chargement des extensions. |
| `OnMakePageCacheKey` | Génération de clé de cache de page. |

## Événements de cache et de site

| Événement | Zone typique |
| --- | --- |
| `OnBeforeCacheUpdate` | Avant la reconstruction du cache. |
| `OnCacheUpdate` | Après reconstruction du cache. |
| `OnSiteRefresh` | Manager action d'actualisation du site. |

## Manager Événements Shell

| Événement | Zone typique |
| --- | --- |
| `OnBeforeManagerPageInit` | Avant l'initialisation de la page du gestionnaire. |
| `OnManagerPageInit` | Manager initialisation des pages. |
| `OnManagerLoginFormPrerender` | Avant le rendu du formulaire de connexion du gestionnaire. |
| `OnManagerLoginFormRender` | Rendu du formulaire de connexion Manager. |
| `OnManagerMenuPrerender` | Manager génération de menus. |
| `OnManagerMainFrameHeaderHTMLBlock` | Injection d'en-tête de cadre principal Manager. |
| `OnManagerTopPrerender` | Rendu du cadre supérieur. |
| `OnManagerFrameLoader` | Chargeur de châssis Manager. |
| `OnManagerWelcomePrerender` | Pré-rendu de la page d'accueil. |
| `OnManagerWelcomeHome` | Widgets/contenu de la page d'accueil. |
| `OnManagerWelcomeRender` | Rendu de la page de bienvenue. |
| `OnManagerPreFrameLoader` | Avant la sortie du chargeur de trame du gestionnaire. |
| `OnBeforeMinifyCss` | Manager CSS minification. |

## Arbre et événements Resource

| Événement | Zone typique |
| --- | --- |
| `OnManagerTreeInit` | Manager initialisation de l'arborescence. |
| `OnManagerTreePrerender` | Pré-rendu d'arbre. |
| `OnManagerTreeRender` | Rendu d'arbre. |
| `OnManagerNodePrerender` | Pré-rendu de nœud individuel. |
| `OnManagerNodeRender` | Rendu de nœud individuel. |
| `OnDocFormPrerender` | Pré-rendu de formulaire Resource. |
| `OnDocFormRender` | Rendu de formulaire Resource. |
| `OnDocFormTemplateRender` | Rendu du modèle de formulaire Resource. |
| `OnBeforeDocFormSave` | Avant la sauvegarde des ressources. |
| `OnDocFormSave` | Après sauvegarde des ressources. |
| `OnBeforeDocFormDelete` | Avant la suppression de la ressource. |
| `OnDocFormDelete` | Après la suppression de la ressource. |
| `OnDocFormUnDelete` | Resource annuler la suppression. |
| `OnDocPublished` | Resource publié. |
| `OnDocUnPublished` | Resource inédit. |
| `OnBeforeDocDuplicate` | Avant la duplication des ressources. |
| `OnDocDuplicate` | Après la duplication des ressources. |
| `onBeforeMoveDocument` | Avant le déplacement des ressources. |
| `onAfterMoveDocument` | Après le déplacement des ressources. |
| `OnBeforeEmptyTrash` | Avant de vider la poubelle. |
| `OnEmptyTrash` | Après la poubelle vide. |

## Événements d'élément| Groupe d'événements | Événements |
| --- | --- |
| Modèles | `OnTempFormPrerender`, `OnTempFormRender`, `OnBeforeTempFormSave`, `OnTempFormSave`, `OnBeforeTempFormDelete`, `OnTempFormDelete` |
| Template Variables | `OnTVFormPrerender`, `OnTVFormRender`, `OnBeforeTVFormSave`, `OnTVFormSave`, `OnBeforeTVFormDelete`, `OnTVFormDelete` |
| Chunks | `OnChunkFormPrerender`, `OnChunkFormRender`, `OnBeforeChunkFormSave`, `OnChunkFormSave`, `OnBeforeChunkFormDelete`, `OnChunkFormDelete` |
| Snippets | `OnSnipFormPrerender`, `OnSnipFormRender`, `OnBeforeSnipFormSave`, `OnSnipFormSave`, `OnBeforeSnipFormDelete`, `OnSnipFormDelete` |
| Plugins | `OnPluginFormPrerender`, `OnPluginFormRender`, `OnBeforePluginFormSave`, `OnPluginFormSave`, `OnBeforePluginFormDelete`, `OnPluginFormDelete` |
| Modules | `OnBeforeModFormSave`, `OnModFormSave`, `OnModFormPrerender`, `OnModFormRender`, `OnBeforeModFormDelete`, `OnModFormDelete` |
| Éditeur de texte enrichi | `OnRichTextEditorRegister`, `OnRichTextEditorInit` |

## Événements d'utilisateur et d'autorisation

| Événement | Zone typique |
| --- | --- |
| `OnBeforeManagerLogin` | Avant la connexion du gestionnaire. |
| `OnManagerAuthentication` | Authentification Manager. |
| `OnManagerLogin` | Manager connexion terminée. |
| `OnBeforeManagerLogout` | Avant la déconnexion du gestionnaire. |
| `OnManagerLogout` | QQFR0091Déconnexion QQ terminée. |
| `OnManagerSaveUser` | Manager utilisateur enregistré. |
| `OnManagerDeleteUser` | Utilisateur Manager supprimé. |
| `OnManagerChangePassword` | Changement de mot de passe Manager. |
| `OnManagerCreateGroup` | Groupe Manager créé. |
| `OnBeforeWebLogin` | Avant la connexion de l'utilisateur Web. |
| `OnWebAuthentication` | Authentification des utilisateurs Web. |
| `OnWebLogin` | Connexion de l'utilisateur Web terminée. |
| `OnBeforeWebLogout` | Avant la déconnexion de l’utilisateur Web. |
| `OnWebLogout` | Déconnexion de l'utilisateur Web terminée. |
| `OnWebSaveUser` | Utilisateur Web enregistré. |
| `OnWebChangePassword` | Changement de mot de passe utilisateur Web. |
| `OnUserFormPrerender` | Pré-rendu du formulaire utilisateur. |
| `OnUserFormRender` | Rendu du formulaire utilisateur. |
| `OnBeforeUserSave` | Avant la sauvegarde de l'utilisateur. |
| `OnUserSave` | Après la sauvegarde de l'utilisateur. |
| `OnUserChangePassword` | Changement de mot de passe utilisateur. |
| `OnBeforeUserDelete` | Avant la suppression par l'utilisateur. |
| `OnUserDelete` | Après la suppression de l'utilisateur. |
| `OnBeforeWUsrFormDelete` | Avant la suppression par l'utilisateur Web. |
| `OnWUsrFormDelete` | Après la suppression de l'utilisateur Web. |
| `OnWebDeleteUser` | Utilisateur Web supprimé. |
| `OnWebCreateGroup` | Groupe Web créé. |
| `OnCreateDocGroup` | Groupe de documents créé. |

## Événements de paramètres système

| Événement | Zone de paramètres |
| --- | --- |
| `OnSiteSettingsRender` | Onglet Paramètres généraux. |
| `OnFriendlyURLSettingsRender` | Onglet URL conviviales. |
| `OnUserSettingsRender` | Onglet Paramètres du modèle de messagerie/utilisateur. |
| `OnInterfaceSettingsRender` | Onglet Paramètres de l'interface. |
| `OnSecuritySettingsRender` | Onglet Paramètres de sécurité. |
| `OnFileManagerSettingsRender` | Onglet Paramètres du fichier Manager. |
| `OnMiscSettingsRender` | Onglet Navigateur de fichiers/Paramètres divers. |

## Événements du navigateur de fichiers

| Groupe d'événements | Événements |
| --- | --- |
| Initialisation du navigateur de fichiers | `OnFileBrowserInit` |
| Télécharger | `OnBeforeFileBrowserUpload`, `OnFileBrowserUpload`, `OnFileManagerUpload` |
| Renommer | `OnBeforeFileBrowserRename`, `OnFileBrowserRename` |
| Supprimer | `OnBeforeFileBrowserDelete`, `OnFileBrowserDelete` |
| Copier | `OnBeforeFileBrowserCopy`, `OnFileBrowserCopy` |
| Déplacer | `OnBeforeFileBrowserMove`, `OnFileBrowserMove` |

## Règle de documentation

Les documents d'événement doivent inclure la source d'appel et la charge utile uniquement après vérification
le site d'appel actuel. Cette page nomme la surface d'événement ; charge utile détaillée
les contrats appartiennent aux pages de référence de suivi.
