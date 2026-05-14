# Inwentarz źródłowy

[Wstecz](../01-getting-started/installation.md) / [W górę](../README.md) / [Dalej](documentation-navigation.md)

To odniesienie opisuje bieżące powierzchnie źródłowe, które powinny zasilać Ewolucję
Dokumentacja produktu CMS.

## Bieżące źródła kodu

| Powierzchnia | Wykorzystanie dokumentacji |
| --- | --- |
| Korzeń ewolucji | Pliki wpisów projektu, metadane root Composer, publiczne `index.php`, przykładowa konfiguracja i README na poziomie projektu. |
| `core/` | Bootstrap środowiska wykonawczego, środowisko wykonawcze Composer, konfiguracja, pamięć podręczna środowiska, migracje baz danych, moduły początkowe, testy, pamięć masowa i punkt wejścia Artisan. |
| `core/src/` | Usługi podstawowe, parser, dostawcy, modele, kontrolery, oprogramowanie pośrednie, fasady, starsze adaptery, klasy wsparcia i polecenia konsoli. |
| `manager/` | Punkt wejścia Manager, routing akcji, widoki, procesory, dołączenia, multimedia i zachowanie interfejsu użytkownika menedżera. |
| `install/` | Starszy instalator sieciowy, skrypt instalacyjny CLI, zasoby instalacyjne, funkcje konfiguracyjne i elementy instalacyjne. |
| `assets/` | Dołączone moduły, wtyczki, fragmenty, zasoby menedżera i zasoby instalacyjne. |
| `views/` | Elementy zastępcze warstwy widoku projektu publicznego. |
| Samodzielny pakiet instalacyjny | Aktualny zalecany przebieg instalacji i zachowanie komendy `evo`. |
| Zainstalowano Extras | Dokumenty na poziomie pakietu są odkrywane oddzielnie przez dDocs i nie powinny być tutaj powielane. |
| Archiwum starych dokumentów | Tylko starsze materiały referencyjne, po sprawdzeniu zgodności z bieżącym kodem. |
| Zatwierdzone notatki dotyczące najlepszych praktyk | Przyszłe przepisy dopiero po sprawdzeniu bieżącego kodu. |

## Bieżące sygnały czasu działania

| Sygnał | Notatki |
| --- | --- |
| Wartość bazowa PHP | Obecny rdzeń i instalator wymagają PHP `^8.3`. |
| Warstwa szkieletowa | Core wykorzystuje komponenty Illuminate 12 i powierzchnie Symfony Console/Process. |
| Routing Manager | Żądania Manager są kierowane przez pojedynczą procedurę obsługi akcji i identyfikatory akcji. |
| Warstwa konsoli | Core udostępnia polecenia Artisan dotyczące pamięci podręcznej, widoków, pakietów, ustawień wstępnych, tras, planowania, aktualizacji witryn, tłumaczeń, aktualizacji drzew, migracji, nasion, Tailwind i zadań systemowych. |
| Warstwa danych | Core zawiera wymowne modele zasobów, elementów, użytkowników, uprawnień, ustawień, dzienników zdarzeń, stanu harmonogramu/procesu roboczego i danych drzewa tabeli zamknięcia. |
| Testy | Obecny rdzeń zawiera testy szkodników dotyczące instalacji, menedżera, aktualizacji, zadań systemowych, narzędzi wsparcia i zachowania zgodności. |

## Zaległości dotyczące dokumentacji

Aktualny baseline obejmuje wymagania, instalację installer-first, reference
installer CLI, podstawowe pojęcia, główne przepływy pracy Managera, strukturę
projektu, mapy reference dla programistów, configuration/runtime bootstrap,
Core Composer, legacy compatibility, polecenia Artisan zainstalowanego
projektu, system settings/defaults, roles and permissions, Blade/template
rendering, classic parser tags, dwa zweryfikowane przepisy, source policy,
navigation rules i first-line troubleshooting.

| Luka | Planowana strona publiczna |
| --- | --- |
| Pełna klasyka API i DB API | `06-api-and-integrations/` i `10-reference/` po walidacji na poziomie metody |
| Pomoc w interfejsie użytkownika dotyczącym ustawień „pole po polu” | Rozszerz [Odniesienie do ustawień systemowych](system-settings.md) po sprawdzeniu etykiety każdej karty menedżera i zapisz procesor |
| Umowy dotyczące ładunku zdarzeń | Rozszerz [Odniesienie do zdarzeń](events.md) po sprawdzeniu poprawności każdej witryny wywołań `invokeEvent` |
| Nawigacja w dokumentacji | [Nawigacja w dokumentacji](documentation-navigation.md) |
| Więcej przepisów na najlepsze praktyki | `08-tutorials-recipes/` po sprawdzeniu poprawności bieżącego kodu |
| Tłumaczenia lokalne | Utrzymywać lokalne kopie zsynchronizowane ze sprawdzonym EN baseline |
