# Events Reference

[Back](parser-tags.md) / [Up](../README.md) / [Next](models.md)

Evolution CMS plugins listen to named events. Current code invokes events from
the core runtime, manager controllers/views/processors, file browser, cache
layer, document/user services, and compatibility surfaces. Fresh installations
seed the default event names into the `system_eventnames` table when it is
empty.

## Event Services

| Service ID | Area |
| ---: | --- |
| `1` | Parser, documents, elements, settings, file browser, and general system events. |
| `2` | Manager shell and manager authentication events. |
| `3` | Web user authentication and web user lifecycle events. |
| `4` | Cache and page-cache events. |
| `5` | Web runtime, page rendering, URLs, parser properties, and output events. |

## Runtime And Parser Events

| Event | Typical Area |
| --- | --- |
| `OnWebPageInit` | Web request initialization. |
| `OnBeforeLoadDocumentObject` | Before loading the document object. |
| `OnLoadDocumentObject` | Document object load. |
| `OnAfterLoadDocumentObject` | After loading the document object. |
| `OnLoadWebDocument` | Document load flow. |
| `OnWebPagePrerender` | Before web page output render. |
| `OnLoadWebPageCache` | Page cache load. |
| `OnBeforeSaveWebPageCache` | Before saving page cache. |
| `OnWebPageComplete` | End of web page processing. |
| `OnParseDocument` | Document parsing hook. |
| `OnBeforeParseParams` | Before parameter parsing. |
| `OnParseProperties` | Property parsing. |
| `OnMakeDocUrl` | URL generation. |
| `OnStripAlias` | Alias normalization. |
| `OnPageNotFound` | Not-found handling. |
| `OnPageUnauthorized` | Unauthorized page handling. |
| `OnLogPageHit` | Page-hit logging. |
| `OnLogEvent` | Event log writing. |
| `OnLoadSettings` | Runtime settings load. |
| `OnBeforeLoadExtension` | Extension loading. |
| `OnMakePageCacheKey` | Page cache key generation. |

## Cache And Site Events

| Event | Typical Area |
| --- | --- |
| `OnBeforeCacheUpdate` | Before cache rebuild. |
| `OnCacheUpdate` | After cache rebuild. |
| `OnSiteRefresh` | Manager site refresh action. |

## Manager Shell Events

| Event | Typical Area |
| --- | --- |
| `OnBeforeManagerPageInit` | Before manager page initialization. |
| `OnManagerPageInit` | Manager page initialization. |
| `OnManagerLoginFormPrerender` | Before manager login form render. |
| `OnManagerLoginFormRender` | Manager login form render. |
| `OnManagerMenuPrerender` | Manager menu generation. |
| `OnManagerMainFrameHeaderHTMLBlock` | Manager main frame header injection. |
| `OnManagerTopPrerender` | Top frame render. |
| `OnManagerFrameLoader` | Manager frame loader. |
| `OnManagerWelcomePrerender` | Welcome page prerender. |
| `OnManagerWelcomeHome` | Welcome page widgets/content. |
| `OnManagerWelcomeRender` | Welcome page render. |
| `OnManagerPreFrameLoader` | Before manager frame loader output. |
| `OnBeforeMinifyCss` | Manager CSS minification. |

## Tree And Resource Events

| Event | Typical Area |
| --- | --- |
| `OnManagerTreeInit` | Manager tree initialization. |
| `OnManagerTreePrerender` | Tree prerender. |
| `OnManagerTreeRender` | Tree render. |
| `OnManagerNodePrerender` | Individual node prerender. |
| `OnManagerNodeRender` | Individual node render. |
| `OnDocFormPrerender` | Resource form prerender. |
| `OnDocFormRender` | Resource form render. |
| `OnDocFormTemplateRender` | Resource form template render. |
| `OnBeforeDocFormSave` | Before resource save. |
| `OnDocFormSave` | After resource save. |
| `OnBeforeDocFormDelete` | Before resource delete. |
| `OnDocFormDelete` | After resource delete. |
| `OnDocFormUnDelete` | Resource undelete. |
| `OnDocPublished` | Resource published. |
| `OnDocUnPublished` | Resource unpublished. |
| `OnBeforeDocDuplicate` | Before resource duplicate. |
| `OnDocDuplicate` | After resource duplicate. |
| `onBeforeMoveDocument` | Before resource move. |
| `onAfterMoveDocument` | After resource move. |
| `OnBeforeEmptyTrash` | Before empty trash. |
| `OnEmptyTrash` | After empty trash. |

## Element Events

| Event Group | Events |
| --- | --- |
| Templates | `OnTempFormPrerender`, `OnTempFormRender`, `OnBeforeTempFormSave`, `OnTempFormSave`, `OnBeforeTempFormDelete`, `OnTempFormDelete` |
| Template Variables | `OnTVFormPrerender`, `OnTVFormRender`, `OnBeforeTVFormSave`, `OnTVFormSave`, `OnBeforeTVFormDelete`, `OnTVFormDelete` |
| Chunks | `OnChunkFormPrerender`, `OnChunkFormRender`, `OnBeforeChunkFormSave`, `OnChunkFormSave`, `OnBeforeChunkFormDelete`, `OnChunkFormDelete` |
| Snippets | `OnSnipFormPrerender`, `OnSnipFormRender`, `OnBeforeSnipFormSave`, `OnSnipFormSave`, `OnBeforeSnipFormDelete`, `OnSnipFormDelete` |
| Plugins | `OnPluginFormPrerender`, `OnPluginFormRender`, `OnBeforePluginFormSave`, `OnPluginFormSave`, `OnBeforePluginFormDelete`, `OnPluginFormDelete` |
| Modules | `OnBeforeModFormSave`, `OnModFormSave`, `OnModFormPrerender`, `OnModFormRender`, `OnBeforeModFormDelete`, `OnModFormDelete` |
| Rich Text Editor | `OnRichTextEditorRegister`, `OnRichTextEditorInit` |

## User And Permission Events

| Event | Typical Area |
| --- | --- |
| `OnBeforeManagerLogin` | Before manager login. |
| `OnManagerAuthentication` | Manager authentication. |
| `OnManagerLogin` | Manager login completed. |
| `OnBeforeManagerLogout` | Before manager logout. |
| `OnManagerLogout` | Manager logout completed. |
| `OnManagerSaveUser` | Manager user saved. |
| `OnManagerDeleteUser` | Manager user deleted. |
| `OnManagerChangePassword` | Manager password change. |
| `OnManagerCreateGroup` | Manager group created. |
| `OnBeforeWebLogin` | Before web user login. |
| `OnWebAuthentication` | Web user authentication. |
| `OnWebLogin` | Web user login completed. |
| `OnBeforeWebLogout` | Before web user logout. |
| `OnWebLogout` | Web user logout completed. |
| `OnWebSaveUser` | Web user saved. |
| `OnWebChangePassword` | Web user password change. |
| `OnUserFormPrerender` | User form prerender. |
| `OnUserFormRender` | User form render. |
| `OnBeforeUserSave` | Before user save. |
| `OnUserSave` | After user save. |
| `OnUserChangePassword` | User password change. |
| `OnBeforeUserDelete` | Before user delete. |
| `OnUserDelete` | After user delete. |
| `OnBeforeWUsrFormDelete` | Before web user delete. |
| `OnWUsrFormDelete` | After web user delete. |
| `OnWebDeleteUser` | Web user deleted. |
| `OnWebCreateGroup` | Web group created. |
| `OnCreateDocGroup` | Document group created. |

## System Settings Events

| Event | Settings Area |
| --- | --- |
| `OnSiteSettingsRender` | General settings tab. |
| `OnFriendlyURLSettingsRender` | Friendly URLs tab. |
| `OnUserSettingsRender` | Mail/user template settings tab. |
| `OnInterfaceSettingsRender` | Interface settings tab. |
| `OnSecuritySettingsRender` | Security settings tab. |
| `OnFileManagerSettingsRender` | File Manager settings tab. |
| `OnMiscSettingsRender` | File Browser/misc settings tab. |

## File Browser Events

| Event Group | Events |
| --- | --- |
| File browser init | `OnFileBrowserInit` |
| Upload | `OnBeforeFileBrowserUpload`, `OnFileBrowserUpload`, `OnFileManagerUpload` |
| Rename | `OnBeforeFileBrowserRename`, `OnFileBrowserRename` |
| Delete | `OnBeforeFileBrowserDelete`, `OnFileBrowserDelete` |
| Copy | `OnBeforeFileBrowserCopy`, `OnFileBrowserCopy` |
| Move | `OnBeforeFileBrowserMove`, `OnFileBrowserMove` |

## Documentation Rule

Event docs should include the invoking source and payload only after checking
the current call site. This page names the event surface; detailed payload
contracts belong in follow-up reference pages.
