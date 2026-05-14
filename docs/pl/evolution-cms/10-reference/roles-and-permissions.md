# Odniesienie do ról i uprawnień

[Wstecz](system-settings.md) / [W górę](../README.md) / [Dalej](blade-and-template-rendering.md)

Evolution CMS oddziela uprawnienia menedżera, dostęp do grupy dokumentów i użytkownika internetowego
dostęp, blokady elementów i uprawnienia do plików. Ta strona dokumentuje bieżący stan
podstawowe powierzchnie uprawnień do dokumentacji produktu. Zezwolenie specyficzne dla pakietu
ekrany należą do własnego źródła dDocs każdego pakietu.

## Model do naśladowania Manager

Role Manager są reprezentowane przez model `UserRole`. Użytkownicy Manager otrzymują
rolę poprzez atrybuty użytkownika i kontrole uprawnień odczytują aktywną sesję
tablica uprawnień dla bieżącego kontekstu.

| Powierzchnia | Cel |
| --- | --- |
| `UserRole` | Nazwa roli, opis i flagi uprawnień menedżera. |
| `UserAttribute.role` | Rola przypisana do konta menedżera lub użytkownika sieci. |
| `RolePermissions` | Dodatkowe rekordy uprawnień połączone według roli. |
| `Permissions` i `PermissionsGroups` | Definicje i grupowanie uprawnień. |
| `UserRoleVar` | Template Variable dostęp/ranking według roli. |
| `ActiveUserLock` | Zablokuj stan aktualnie edytowanych elementów i zasobów. |

Podstawowym pomocnikiem uprawnień jest `hasPermission($permission, $context = '')`.
`hasAnyPermissions([...], $context = '')` zwraca wartość true, jeśli którakolwiek z nich znajduje się na liście
pozwolenie jest dostępne.

## Flagi uprawnień ról

| Powierzchnia | Flagi uprawnień |
| --- | --- |
| Powłoka Manager | `frames`, `home`, `logout`, `help`, `messages`, `about`, `credits`, `action_ok`, `error_dialog` |
| Resources | `view_document`, `new_document`, `edit_document`, `save_document`, `publish_document`, `delete_document`, `empty_trash`, `view_unpublished`, `change_resourcetype` |
| Szablony | `new_template`, `edit_template`, `save_template`, `delete_template` |
| Template Variables | Dostęp TV jest obsługiwany poprzez relacje rola-TV i uprawnienia, takie jak `manage_tv_permissions`, jeśli są obecne. |
| Chunks | `new_chunk`, `edit_chunk`, `save_chunk`, `delete_chunk` |
| Snippets | `new_snippet`, `edit_snippet`, `save_snippet`, `delete_snippet` |
| Plugins | `new_plugin`, `edit_plugin`, `save_plugin`, `delete_plugin` |
| Modules | `new_module`, `edit_module`, `save_module`, `delete_module`, `exec_module` |
| Użytkownicy | `new_user`, `edit_user`, `save_user`, `delete_user`, `change_password`, `save_password` |
| Role | `new_role`, `edit_role`, `save_role`, `delete_role` |
| Uprawnienia | `access_permissions`, `web_access_permissions` |
| Pliki | `file_manager`, `assets_files`, `assets_images`, `bk_manager` |
| Logi i zamki | `logs`, `view_eventlog`, `delete_eventlog`, `remove_locks`, `display_locks` |
| Statyczny import/eksport | `import_static`, `export_static` |
| Użytkownicy sieci | `new_web_user`, `edit_web_user`, `save_web_user`, `delete_web_user` |

Niektóre bieżące ścieżki kodu sprawdzają również nowsze nazwane uprawnienia, takie jak
`manage_groups`, `manage_document_permissions`, `manage_tv_permissions`,
`manage_metatags`, `system_tasks.view`, `system_tasks.site_update` i
`system_tasks.manage_packages`. Udokumentuj te uprawnienia za pomocą funkcji that
używa ich, ponieważ są to nazwy możliwości, a nie podstawowe kolumny ról.

## Uprawnienia dostępu do dokumentów

Uprawnienia dostępu do dokumentów wykorzystują grupy dokumentów i grupy członków.

| Model/Powierzchnia stołu | Cel |
| --- | --- |
| `DocumentgroupName` | Nazwane grupy dokumentów. |
| `DocumentGroup` | Łączy zasoby z grupami dokumentów. |
| `MemberGroup` | Łączy użytkowników z grupami członkowskimi. |
| `membergroup_access` | Łączy grupy członków z grupami dokumentów. |
| `use_udperms` | Włącza sprawdzanie uprawnień użytkownika/dokumentu. |
| `udperms_allowroot` | Kontroluje zachowanie roota w zakresie uprawnień do dokumentów. |

Gdy włączona jest funkcja `use_udperms`, użytkownicy niebędący administratorami są sprawdzani pod kątem
grupy, do których mają dostęp. Resource zapisywanie i przepływy drzewa/zapytań muszą je zachować
sprawdza nienaruszone.

## Uprawnienia dostępu do sieci

Uprawnienia dostępu do sieci chronią zasoby frontonu dla uwierzytelnionych użytkowników sieci.
Są one niezależne od uprawnień roli menedżera.| Powierzchnia | Cel |
| --- | --- |
| Użytkownicy sieci | Użytkownicy, którzy uwierzytelniają się w interfejsie witryny. |
| Role użytkowników sieci | Opcjonalne przypisanie roli do atrybutów użytkownika. |
| Grupy użytkowników sieci | Grupy używane do podejmowania decyzji dotyczących dostępu do frontonu. |
| Grupy dokumentów | Grupy Resource, które można połączyć z grupami członkowskimi. |
| `web_access_permissions` | Uprawnienie Manager do zarządzania dostępem do sieci. |

Użyj tej warstwy, jeśli odwiedzający witrynę powinni zobaczyć tylko wybrane chronione zasoby.
Nie używaj ról menedżera jako modelu autoryzacji frontendu.

## Zamki

Evolution CMS śledzi zablokowane elementy, aby zapobiec niebezpiecznej jednoczesnej edycji.
Zamykane typy obejmują:

| Wpisz identyfikator | Element |
| ---: | --- |
| `1` | Szablon |
| `2` | Template Variable |
| `3` | Chunk |
| `4` | Snippet |
| `5` | Plugin |
| `6` | Module |
| `7` | Resource |
| `8` | Rola |

Kontrolery i modele ujawniają stan blokady za pomocą metod takich jak
`getLockedElements()`, `isAlreadyEdit` i `alreadyEditInfo`.

## Uprawnienia do plików

Zachowanie podczas tworzenia pliku jest kontrolowane przez ustawienia systemowe:

| Ustawienie | Domyślne | Znaczenie |
| --- | --- | --- |
| `new_file_permissions` | `0644` | Uprawnienia stosowane do nowych plików, gdy ustawia je menedżer plików. |
| `new_folder_permissions` | `0755` | Uprawnienia stosowane do nowych folderów, gdy ustawia je menedżer plików. |
| `filemanager_path` | `[(base_path)]` | Korzeń dla operacji menedżera plików. |
| `rb_base_dir` | `[(base_path)]assets/` | Katalog podstawowy przeglądarki Resource. |

Uprawnienia do plików nie zastępują uprawnień menedżera. Potrzeba użytkownika
zarówno możliwości menedżera, jak i dostęp do systemu plików, aby zapis się powiódł.

## Zasada dokumentacji

Dokumentując pozwolenie, podaj dokładny klucz uprawnień i menedżera
powierzchnia, która to sprawdza. Jeśli funkcja należy do zainstalowanego pakietu, zachowaj plik
dokumentacja uprawnień w dokumentacji tego pakietu i łącze do tej strony tylko dla
podstawowy model uprawnień.
