# Odniesienia do modeli

[Wstecz](parser-tags.md) / [W górę](../README.md) / [Dalej](events.md)

To odniesienie odwzorowuje bieżącą powierzchnię modelu Eloquent. Jest to strona wyszukiwania
autorzy dokumentacji i programiści; nie jest to pełne odniesienie do schematu.

## Modele treści i drzew

| Modelka | Odpowiedzialność |
| --- | --- |
| `SiteContent` | Resource/węzły drzewa dokumentów, pola treści, flagi publikowania/usuwania/pamięci podręcznej/wyszukiwania, relacje nadrzędny/podrzędny, grupy dokumentów, wartości szablonów i zachowanie drzewa tabeli zamknięcia. |
| `ClosureTable` | Pamięć przodków/potomków/głębokości drzewa dla operacji hierarchii zasobów. |
| `DocumentGroup` | QQPL0049Wiersze relacji QQ do grupy dokumentów. |
| `DocumentgroupName` | Nazwane grupy dokumentów używane przez reguły dostępu do sieci i menedżerów. |
| `FileGroup` | Wiersze grup dostępu do plików połączone z grupami dokumentów. |

## Modele elementów

| Modelka | Odpowiedzialność |
| --- | --- |
| `SiteTemplate` | Szablony przypisane do zasobów i połączone z Template Variables. |
| `SiteTmplvar` | Definicje Template Variable: typ, nazwa, podpis, kategoria, elementy, wyświetlanie, wartości domyślne i właściwości. |
| `SiteTmplvarTemplate` | Relacja i ranga szablonu do TV. |
| `SiteTmplvarContentvalue` | Wartości TV zapisane dla poszczególnych zasobów. |
| `SiteTmplvarAccess` | Reguły dostępu TV. |
| `SiteHtmlsnippet` | Chunks. Historyczna nazwa modelu pozostaje `SiteHtmlsnippet`. |
| `SiteSnippet` | Snippets i metadane fragmentu powiązanego z modułem. |
| `SitePlugin` | Plugins, kod wtyczki, właściwości, powiązanie modułów, stan włączenia/wyłączenia i alternatywne wyszukiwania wtyczek. |
| `SitePluginEvent` | QQPL0057Relacja i priorytet QQ-do zdarzenia. |
| `SiteModule` | Moduły Manager, kod modułu/pliki zasobów, współdzielone parametry i akcje uruchamiania/edycji/zależności. |
| `SiteModuleAccess` | Reguły dostępu Module. |
| `SiteModuleDepobj` | Module wiersze obiektu zależności. |
| `Category` | Grupowanie kategorii dla elementów i organizacji menedżerskiej. |

## Ustawienia, zdarzenia i dzienniki

| Modelka | Odpowiedzialność |
| --- | --- |
| `SystemSetting` | Ustawienia systemowe ładowane przez środowisko wykonawcze i menedżera. |
| `SystemEventname` | Nazwany rejestr zdarzeń podłączony do wtyczek. |
| `EventLog` | Zapisy dziennika zdarzeń. |
| `ManagerLog` | Rekordy dziennika aktywności Manager. |

## Użytkownicy i uprawnienia

| Modelka | Odpowiedzialność |
| --- | --- |
| `User` | Model konta użytkownika Manager/web. |
| `UserAttribute` | Dane profilu użytkownika i atrybutów. |
| `UserSetting` | Ustawienia poszczególnych użytkowników. |
| `UserValue` | Przechowywanie wartości użytkownika. |
| `UserRole` | Wzór do naśladowania Manager. |
| `UserRoleVar` | Relacja dostępu rola-TV. |
| `Permissions` | Rekordy uprawnień Manager. |
| `PermissionsGroups` | Rekordy grupy uprawnień. |
| `RolePermissions` | Wiersze relacji uprawnień roli. |
| `MemberGroup` | Wiersze relacji grupy użytkowników sieci Web. |
| `MembergroupAccess` | Wiersze relacji dostępu do grupy członkowskiej. |
| `MembergroupName` | Nazwane grupy użytkowników sieci. |

## Modele stanu środowiska wykonawczego

| Modelka | Odpowiedzialność |
| --- | --- |
| `ActiveUser` | Śledzenie aktywnych użytkowników menedżera. |
| `ActiveUserLock` | Aktywne blokady edycji. |
| `ActiveUserSession` | Aktywne zapisy sesji menedżera. |
| `SystemCliTask` | Przechowywane wiersze zadań systemowych dla przepływów CLI/worker. |
| `SystemCliTaskLog` | Wiersze dziennika zadań. |
| `SystemSchedulerHealth` | Harmonogram dokumentacji zdrowotnej. |
| `SystemWorkerHealth` | Dokumentacja zdrowia pracownika. |

## Zasada dokumentacji

Pisząc szczegółową dokumentację modelu, sprawdź poprawność pliku modelu, relacji,
migracje i wspólne testy. Nie wnioskuj o polach tylko ze starej dokumentacji
lub z etykiet interfejsu użytkownika.
