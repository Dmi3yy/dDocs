# Blade i odniesienie do renderowania szablonów

[Wstecz](roles-and-permissions.md) / [W górę](../README.md) / [Dalej](parser-tags.md)

Evolution CMS obsługuje zarówno klasyczne szablony parsera Evolution, jak i oparte na Blade
szablony. Bieżące środowisko wykonawcze wybiera ścieżkę renderowania z zasobu
szablon i dostępne mapowanie widoków Blade.

## Przepływ renderowania

| Krok | Zachowanie w czasie wykonywania |
| --- | --- |
| Załaduj zasób | Core ładuje obiekt zasobu, sprawdza stan usunięty/opublikowany/odniesienia i przygotowuje dane dokumentu. |
| Rozwiąż szablon | Środowisko wykonawcze pyta procesor szablonów o widok dokumentu Blade. Jeśli żaden nie jest dostępny, ładuje kod szablonu z bazy danych. |
| Udostępnij dane | Szablony Blade odbierają `modx`, `documentObject` i przeglądają dane ze środowiska wykonawczego. |
| Renderuj Blade | Jeśli istnieje widok Blade, jest on renderowany przez fabrykę widoków, a zasób jest traktowany w przypadku tego przebiegu jako niemożliwy do buforowania. |
| Przeanalizuj klasyczny szablon | Jeśli nie istnieje widok Blade, klasyczny kod szablonu jest analizowany przez parser Evolution. |
| Wywołaj zdarzenia | `OnLoadWebDocument` jest uruchamiany po przygotowaniu treści dokumentu. Zdarzenia wyjściowe i zachowanie po analizie są uruchamiane w dalszej części przepływu odpowiedzi. |

Jeśli do zasobu nie ma przypisanego szablonu, środowisko wykonawcze używa `[*content*]` jako pliku
pusty klasyczny szablon.

## Źródła szablonów

| Źródło | Składnia lub powierzchnia | Notatki |
| --- | --- | --- |
| Szablon bazy danych | Manager Element szablonu | Klasyczny szablon parsera Evolution. |
| Widok dokumentu Blade | Widok rozwiązany procesora szablonów | Bieżąca ścieżka Blade dla szablonów zasobów. |
| Plik szablonu utworzony podczas zapisywania | Opcja szablonu Manager | Zapisanie szablonu umożliwia utworzenie odpowiedniego pliku `.blade.php`. |
| `@FILE` tryb fragmentu/szablonu | `@FILE:path` | Odczytuje plik szablonu ze skonfigurowanej ścieżki i rozszerzenia szablonu. |
| `@CODE` / `@INLINE` / `@TPL` | Ciąg kodu wbudowanego | Używane przez pomocników fragmentów/szablonów parsera. |
| `@DOCUMENT` / `@DOC` | Treść dokumentu według identyfikatora lub bieżącego dokumentu | Pobiera treść dokumentu do szablonów analizatora składni. |
| `@B_FILE` | Tryb pliku Blade | Renderuje plik Blade za pomocą fabryki sklonowanych widoków. |
| `@B_CODE` | Tryb kodu Blade | Zapisuje wygenerowany plik pamięci podręcznej Blade i renderuje go za pomocą przestrzeni nazw `cache::`. |

## Dane Blade

Szablony dokumentów Blade otrzymują bieżący obiekt wykonawczy i dane dokumentu.

| Zmienna | Znaczenie |
| --- | --- |
| `$modx` | Bieżący obiekt rdzenia/środowiska wykonawczego Evolution CMS. |
| `$documentObject` | Aktualne dane obiektu zasobu. |
| Zobacz dane | Dodatkowe dane wykonawcze przygotowane przez `getDataForView()`. |

Gdy procesor porcji `DLTemplate` jest aktywny, te same współużytkowane dane są również aktywne
przeszedł do integracji Blade.

## Manager Blade Widoki

Interfejs menedżera używa widoków Blade w przestrzeni nazw widoku menedżera.

| Zobacz wzór | Cel |
| --- | --- |
| `manager::template.page` | Standardowa powłoka strony menedżera. |
| `manager::template.blank` | Minimalna powłoka strony menedżera. |
| `manager::partials.header` | Zasoby nagłówka Manager i stos najlepszych skryptów. |
| `manager::partials.footer` | Manager stopka i dolny stos skryptów. |
| `manager::partials.actionButtons` | Standardowe przyciski akcji na stronie menedżera. |
| `manager::form.*` | Wspólny menedżer formularzy wierszy, danych wejściowych, elementów sterujących radiem, zaznaczeń i obszarów tekstowych. |
| `manager::page.*` | Ekrany stron Manager i części stron zagnieżdżonych. |

Typowe stosy Blade używane przez widoki menedżera obejmują `scripts.top` i
`scripts.bot`.

## Podstawowe dyrektywy Blade

| Dyrektywa | Wyjście |
| --- | --- |
| `@evoConfig($key)` | Wartość ucieczki z `evo()->getConfig($key)`. |
| `@makeUrl($value)` | Uciekający adres URL wygenerowany przez procesor adresu URL. |
| `@evoParser($value)` | Przeanalizowano zawartość Evolution za pomocą `evo_parser()`. |
| `@evoRole($role)` | Otwiera blok warunkowy, gdy `evo_role($role)` ma wartość true. |
| `@evoElseRole($role)` | Dodaje gałąź `elseif` dla kolejnej kontroli roli. |
| `@evoEndRole` | Zamyka blok warunkowy roli. |
| `@auth` | Prawda, jeśli `evo()->getLoginUserID()` nie jest fałszem. |
| `@guest` | Prawda, gdy nie jest zalogowany żaden użytkownik frontonu. |
| `@svg($name, ...)` | Renderuje plik SVG ikon Blade za pośrednictwem adaptera Evolution. |Starsze dyrektywy niestandardowe można nadal rejestrować w `view.directive`, ale
ta ścieżka jest przestarzała i nie należy jej używać w dokumentacji nowego produktu.

## Pomocnicy dyrektywy wsparcia

Klasa pomocnicza obsługi definiuje również starsze wywołania zwrotne dyrektyw używane przez starsze
rejestracja dyrektyw oparta na konfiguracji:

| Pomocnik | Znaczenie |
| --- | --- |
| `csrf()` | Wysyła pole CSRF. Przestarzałe. |
| `evoLang($key)` | Odczytuje wartość leksykonu menedżera. |
| `evoStyle($key)` | Odczytuje wartość stylu menedżera. |
| `evoAdminLang()` | Odczytuje nazwę języka aktywnego menedżera. |
| `evoCharset()` | Odczytuje zestaw znaków menedżera. |
| `evoAdminThemeUrl()` | Odczytuje adres URL motywu menedżera. |
| `evoAdminThemeName()` | Odczytuje nazwę motywu menedżera. |

Zamiast tego nowe strony menedżerów powinny preferować obecnych pomocników menedżerów i wspólne widoki
dodania nowych dyrektyw opartych na konfiguracji.

## Ikony Blade

Evolution CMS dostarcza adapter do ikon Blade. Adapter:

- łączy podstawową konfigurację `blade-icons`;
- rejestruje fabrykę ikon i manifest;
- rejestruje dyrektywę `@svg`;
- rejestruje komponenty ikony, gdy istnieje manifest ikony;
- publikuje konfigurację `blade-icons.php` w trybie konsoli.

Używaj ikon poprzez skonfigurowane zestawy ikon i utrzymuj stabilne nazwy ikon interfejsu menedżera
gdy dokumentacja pakietu lub zrzuty ekranu odnoszą się do nich.

## Zasada dokumentacji

Dokumentując zachowanie szablonu, określ, czy przykład jest klasycznym analizatorem składni
składnia lub składnia Blade. Nie mieszaj w tym samym znaczników parsera i dyrektyw Blade
przykład, chyba że strona wyraźnie wyjaśnia, w jaki sposób współdziałają dwie ścieżki renderowania.
