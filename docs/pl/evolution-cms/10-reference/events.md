# Odniesienie do wydarzeń

[Wstecz](parser-tags.md) / [W górę](../README.md) / [Dalej](models.md)

Wtyczki Evolution CMS nasłuchują nazwanych zdarzeń. Bieżący kod wywołuje zdarzenia z
podstawowe środowisko wykonawcze, kontrolery/widoki/procesory menedżera, przeglądarka plików, pamięć podręczna
warstwy, usługi dokumentów/użytkowników i powierzchnie zgodności. Świeże instalacje
wstaw domyślne nazwy zdarzeń do tabeli `system_eventnames`, jeśli taka istnieje
pusty.

## Usługi związane z wydarzeniami

| Identyfikator usługi | Powierzchnia |
| ---: | --- |
| `1` | Parser, dokumenty, elementy, ustawienia, przeglądarka plików i ogólne zdarzenia systemowe. |
| `2` | Manager zdarzenia uwierzytelniania powłoki i menedżera. |
| `3` | Uwierzytelnianie użytkowników sieci i zdarzenia cyklu życia użytkownika sieci. |
| `4` | Zdarzenia pamięci podręcznej i pamięci podręcznej strony. |
| `5` | Środowisko wykonawcze sieci Web, renderowanie stron, adresy URL, właściwości analizatora składni i zdarzenia wyjściowe. |

## Zdarzenia środowiska wykonawczego i analizatora składni

| Wydarzenie | Typowy obszar |
| --- | --- |
| `OnWebPageInit` | Inicjalizacja żądania internetowego. |
| `OnBeforeLoadDocumentObject` | Przed załadowaniem obiektu dokumentu. |
| `OnLoadDocumentObject` | Ładowanie obiektu dokumentu. |
| `OnAfterLoadDocumentObject` | Po załadowaniu obiektu dokumentu. |
| `OnLoadWebDocument` | Przepływ ładowania dokumentów. |
| `OnWebPagePrerender` | Przed renderowaniem wyniku strony internetowej. |
| `OnLoadWebPageCache` | Ładowanie pamięci podręcznej strony. |
| `OnBeforeSaveWebPageCache` | Przed zapisaniem pamięci podręcznej strony. |
| `OnWebPageComplete` | Koniec przetwarzania strony internetowej. |
| `OnParseDocument` | Hak do analizowania dokumentów. |
| `OnBeforeParseParams` | Przed analizą parametrów. |
| `OnParseProperties` | Analiza właściwości. |
| `OnMakeDocUrl` | Generowanie adresu URL. |
| `OnStripAlias` | Normalizacja aliasów. |
| `OnPageNotFound` | Nie znaleziono obsługi. |
| `OnPageUnauthorized` | Nieautoryzowana obsługa strony. |
| `OnLogPageHit` | Rejestrowanie trafień na stronę. |
| `OnLogEvent` | Zapisywanie dziennika zdarzeń. |
| `OnLoadSettings` | Ładowanie ustawień środowiska wykonawczego. |
| `OnBeforeLoadExtension` | Ładowanie rozszerzenia. |
| `OnMakePageCacheKey` | Generowanie klucza pamięci podręcznej strony. |

## Zdarzenia w pamięci podręcznej i witrynie

| Wydarzenie | Typowy obszar |
| --- | --- |
| `OnBeforeCacheUpdate` | Przed odbudowaniem pamięci podręcznej. |
| `OnCacheUpdate` | Po odbudowaniu pamięci podręcznej. |
| `OnSiteRefresh` | Akcja odświeżania witryny Manager. |

## Zdarzenia powłoki Manager

| Wydarzenie | Typowy obszar |
| --- | --- |
| `OnBeforeManagerPageInit` | Przed inicjalizacją strony menedżera. |
| `OnManagerPageInit` | Inicjalizacja strony Manager. |
| `OnManagerLoginFormPrerender` | Przed renderowaniem formularza logowania menedżera. |
| `OnManagerLoginFormRender` | Renderowanie formularza logowania Manager. |
| `OnManagerMenuPrerender` | Generowanie menu Manager. |
| `OnManagerMainFrameHeaderHTMLBlock` | Manager wtrysk nagłówka ramki głównej. |
| `OnManagerTopPrerender` | Renderowanie górnej ramki. |
| `OnManagerFrameLoader` | Ładowarka ramek Manager. |
| `OnManagerWelcomePrerender` | Wstępne renderowanie strony powitalnej. |
| `OnManagerWelcomeHome` | Widżety/treść strony powitalnej. |
| `OnManagerWelcomeRender` | Renderowanie strony powitalnej. |
| `OnManagerPreFrameLoader` | Przed wyjściem modułu ładującego ramki menedżera. |
| `OnBeforeMinifyCss` | Minifikacja Manager CSS. |

## Drzewo i zdarzenia Resource

| Wydarzenie | Typowy obszar |
| --- | --- |
| `OnManagerTreeInit` | Inicjalizacja drzewa Manager. |
| `OnManagerTreePrerender` | Wstępne renderowanie drzewa. |
| `OnManagerTreeRender` | Renderowanie drzewa. |
| `OnManagerNodePrerender` | Wstępne renderowanie pojedynczego węzła. |
| `OnManagerNodeRender` | Renderowanie poszczególnych węzłów. |
| `OnDocFormPrerender` | Wstępne renderowanie formularza Resource. |
| `OnDocFormRender` | Renderowanie formularza Resource. |
| `OnDocFormTemplateRender` | Renderowanie szablonu formularza Resource. |
| `OnBeforeDocFormSave` | Przed zapisaniem zasobów. |
| `OnDocFormSave` | Po zapisaniu zasobów. |
| `OnBeforeDocFormDelete` | Przed usunięciem zasobu. |
| `OnDocFormDelete` | Po usunięciu zasobu. |
| `OnDocFormUnDelete` | Resource cofnij usunięcie. |
| `OnDocPublished` | Opublikowano Resource. |
| `OnDocUnPublished` | Resource niepublikowane. |
| `OnBeforeDocDuplicate` | Przed duplikatem zasobu. |
| `OnDocDuplicate` | Po zduplikowaniu zasobu. |
| `onBeforeMoveDocument` | Przed przeniesieniem zasobów. |
| `onAfterMoveDocument` | Po przeniesieniu zasobów. |
| `OnBeforeEmptyTrash` | Przed pustymi śmieciami. |
| `OnEmptyTrash` | Po pustych śmieciach. |

## Wydarzenia elementowe| Grupa Wydarzeń | Wydarzenia |
| --- | --- |
| Szablony | `OnTempFormPrerender`, `OnTempFormRender`, `OnBeforeTempFormSave`, `OnTempFormSave`, `OnBeforeTempFormDelete`, `OnTempFormDelete` |
| Template Variables | `OnTVFormPrerender`, `OnTVFormRender`, `OnBeforeTVFormSave`, `OnTVFormSave`, `OnBeforeTVFormDelete`, `OnTVFormDelete` |
| Chunks | `OnChunkFormPrerender`, `OnChunkFormRender`, `OnBeforeChunkFormSave`, `OnChunkFormSave`, `OnBeforeChunkFormDelete`, `OnChunkFormDelete` |
| Snippets | `OnSnipFormPrerender`, `OnSnipFormRender`, `OnBeforeSnipFormSave`, `OnSnipFormSave`, `OnBeforeSnipFormDelete`, `OnSnipFormDelete` |
| Plugins | `OnPluginFormPrerender`, `OnPluginFormRender`, `OnBeforePluginFormSave`, `OnPluginFormSave`, `OnBeforePluginFormDelete`, `OnPluginFormDelete` |
| Modules | `OnBeforeModFormSave`, `OnModFormSave`, `OnModFormPrerender`, `OnModFormRender`, `OnBeforeModFormDelete`, `OnModFormDelete` |
| Edytor tekstu sformatowanego | `OnRichTextEditorRegister`, `OnRichTextEditorInit` |

## Zdarzenia użytkowników i uprawnień

| Wydarzenie | Typowy obszar |
| --- | --- |
| `OnBeforeManagerLogin` | Przed zalogowaniem menedżera. |
| `OnManagerAuthentication` | Uwierzytelnianie Manager. |
| `OnManagerLogin` | Logowanie Manager zakończone. |
| `OnBeforeManagerLogout` | Przed wylogowaniem menedżera. |
| `OnManagerLogout` | Wylogowanie Manager zakończone. |
| `OnManagerSaveUser` | Użytkownik Manager został zapisany. |
| `OnManagerDeleteUser` | Użytkownik Manager został usunięty. |
| `OnManagerChangePassword` | Zmiana hasła Manager. |
| `OnManagerCreateGroup` | Grupa Manager została utworzona. |
| `OnBeforeWebLogin` | Przed zalogowaniem użytkownika internetowego. |
| `OnWebAuthentication` | Uwierzytelnianie użytkownika sieci. |
| `OnWebLogin` | Logowanie użytkownika internetowego zakończone. |
| `OnBeforeWebLogout` | Przed wylogowaniem użytkownika sieciowego. |
| `OnWebLogout` | Wylogowanie użytkownika internetowego zostało zakończone. |
| `OnWebSaveUser` | Użytkownik sieci został zapisany. |
| `OnWebChangePassword` | Zmiana hasła użytkownika internetowego. |
| `OnUserFormPrerender` | Wstępne renderowanie formularza użytkownika. |
| `OnUserFormRender` | Renderowanie formularza użytkownika. |
| `OnBeforeUserSave` | Przed zapisaniem przez użytkownika. |
| `OnUserSave` | Po zapisaniu przez użytkownika. |
| `OnUserChangePassword` | Zmiana hasła użytkownika. |
| `OnBeforeUserDelete` | Przed usunięciem użytkownika. |
| `OnUserDelete` | Po usunięciu użytkownika. |
| `OnBeforeWUsrFormDelete` | Przed usunięciem użytkownika internetowego. |
| `OnWUsrFormDelete` | Po usunięciu użytkownika internetowego. |
| `OnWebDeleteUser` | Użytkownik sieci został usunięty. |
| `OnWebCreateGroup` | Utworzono grupę internetową. |
| `OnCreateDocGroup` | Utworzono grupę dokumentów. |

## Ustawienia systemu Zdarzenia

| Wydarzenie | Obszar ustawień |
| --- | --- |
| `OnSiteSettingsRender` | Zakładka Ustawienia ogólne. |
| `OnFriendlyURLSettingsRender` | Zakładka Przyjazne adresy URL. |
| `OnUserSettingsRender` | Zakładka ustawień szablonu poczty/użytkownika. |
| `OnInterfaceSettingsRender` | Zakładka Ustawienia interfejsu. |
| `OnSecuritySettingsRender` | Zakładka Ustawienia zabezpieczeń. |
| `OnFileManagerSettingsRender` | Plik Karta ustawień Manager. |
| `OnMiscSettingsRender` | Karta przeglądarki plików/różnych ustawień. |

## Zdarzenia przeglądarki plików

| Grupa Wydarzeń | Wydarzenia |
| --- | --- |
| Inicjacja przeglądarki plików | `OnFileBrowserInit` |
| Prześlij | `OnBeforeFileBrowserUpload`, `OnFileBrowserUpload`, `OnFileManagerUpload` |
| Zmień nazwę | `OnBeforeFileBrowserRename`, `OnFileBrowserRename` |
| Usuń | `OnBeforeFileBrowserDelete`, `OnFileBrowserDelete` |
| Kopiuj | `OnBeforeFileBrowserCopy`, `OnFileBrowserCopy` |
| Przesuń | `OnBeforeFileBrowserMove`, `OnFileBrowserMove` |

## Zasada dokumentacji

Dokumenty zdarzeń powinny zawierać źródło wywołania i ładunek dopiero po sprawdzeniu
bieżącą witrynę połączeń. Ta strona zawiera nazwę powierzchni zdarzenia; szczegółowy ładunek
umowy znajdują się na kolejnych stronach referencyjnych.
