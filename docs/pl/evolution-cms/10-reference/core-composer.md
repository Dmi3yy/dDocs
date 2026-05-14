# Odniesienie do rdzenia Composer

[Wstecz](configuration-runtime.md) / [W górę](../README.md) / [Dalej](legacy-compatibility.md)

Evolution CMS używa pliku Composer na poziomie projektu i podstawowego pliku Composer. The
core Composer to główna granica zależności środowiska wykonawczego dla zainstalowanego
Projekt Evolution CMS.

## Pliki Composer

| Plik | Odpowiedzialność |
| --- | --- |
| `composer.json` | Metadane pakietu projektu/głównego, linia bazowa PHP, minimalne rozszerzenia platformy i skrypt analizy projektu. |
| `core/composer.json` | Główne zależności środowiska wykonawczego, reguły automatycznego ładowania, konfiguracja wtyczki Composer, skrypty wykrywania pakietów i narzędzia testowe. |
| `core/custom/composer.json` | Punkt rozszerzenia specyficzny dla projektu scalony przez podstawową wtyczkę łączącą Composer, jeśli jest obecna. |

Główny plik Composer opisuje pakiet projektu. Zależność środowiska wykonawczego
wykres działa pod `core/composer.json`.

## Metadane pakietu wykonawczego

| Pole | Aktualna wartość |
| --- | --- |
| Pakiet | `evolution-cms/evolution` |
| Wpisz | `project` |
| Wersja | `3.5.7` |
| Licencja | `GPL-3.0-or-later` |
| Wartość bazowa PHP | `^8.3` |
| Katalog dostawców | `vendor` wewnątrz `core/` |
| Minimalna stabilność | `dev` |
| Wolę stabilne | `true` |

## Grupy zależności środowiska wykonawczego

| Grupa | Pakiety |
| --- | --- |
| Composer/czas wykonywania | `composer/composer`, `wikimedia/composer-merge-plugin` |
| Elementy szkieletu | Oświetl pamięć podręczną, konfigurację, konsolę, kontener, bazę danych, zdarzenia, system plików, HTTP, dziennik, paginacja, kolejka, Redis, routing, wsparcie, tłumaczenie, sprawdzanie poprawności, widok |
| Baza danych i migracje | Rozszerzenia `doctrine/dbal`, PDO |
| HTTP i integracja | `guzzlehttp/guzzle`, `symfony/process` |
| Środowisko i konfiguracja | `vlucas/phpdotenv`, `phpoption/phpoption` |
| Poczta | `phpmailer/phpmailer` |
| Sesje i Redis | `predis/predis`, `dmitry-suffi/redis-session-handler` |
| Media i kanały | `james-heinrich/phpthumb`, `rosell-dk/webp-convert`, `simplepie/simplepie` |
| System plików | `league/flysystem` |
| Debugowanie | `tracy/tracy` |
| Harmonogram | `dragonmantank/cron-expression` |
| Ikony | `secondnetwork/blade-tabler-icons` |
| Usługi ewolucyjne | `evolutioncms-services/document-manager`, `evolutioncms-services/user-manager` |

Wymagania dotyczące rozszerzeń platformy obejmują popularne rozszerzenia PHP, takie jak `ctype`,
`dom`, `fileinfo`, `filter`, `hash`, `iconv`, `json`, `libxml`, `mbstring`,
`openssl`, `pcre`, `pdo`, `session`, `simplexml`, `tokenizer`, `xml`,
`xmlreader` i `zip`.

## Composer Scal Plugin

Podstawowa konfiguracja Composer wykorzystuje `wikimedia/composer-merge-plugin`, aby uwzględnić:

```text
custom/composer.json
```Zachowanie scalania:

| Opcja | Wartość |
| --- | --- |
| `recurse` | `true` |
| `replace` | `true` |
| `merge-dev` | `false` |
| `merge-extra` | `true` |
| `merge-scripts` | `false` |

Zamiast edytować, użyj `core/custom/composer.json` w przypadku pakietów na poziomie projektu
bezpośrednio do głównego pliku wykonawczego Composer.

## Reguły automatycznego ładowania

| Typ automatycznego ładowania | Wpisy |
| --- | --- |
| PSR-4 | `EvolutionCMS\\` do `src/`, `Database\\Seeders\\` do `database/seeders/` |
| Mapa klas | `database/migrations/` |
| Pliki | Pomocnicy akcji podstawowych, funkcje pomocnicze, funkcje mostu Laravel, pomocnicy węzłów, pomocnicy wstępnego ładowania, pomocnicy procesora i narzędzia. |
| Dev PSR-4 | `Tests\\` do `tests/` |

Lista automatycznego ładowania plików zapewnia dostęp do starszych funkcji pomocniczych/akcji w pliku
nowoczesne środowisko wykonawcze.

## Skrypty Composer

| Skrypt | Cel |
| --- | --- |
| `sync-replace` | Uruchamia pomocnika synchronizacji zastępowania wersji. |
| `test` | Przeprowadza testy szkodników. |
| `optimize` | Instaluje zależności produkcyjne i zrzuca zoptymalizowane autorytatywne automatyczne ładowanie. |
| `optimize-dev` | Instaluje zależności deweloperskie i zrzuca zoptymalizowane autorytatywne automatyczne ładowanie. |
| `upd` | Synchronizuje wersje zamienne i aktualizuje plik blokady. |
| `pre-install-cmd` | Uruchamia synchronizację zastępczą przed instalacją. |
| `pre-update-cmd` | Uruchamia synchronizację zastępczą przed aktualizacją. |
| `post-autoload-dump` | Uruchamia `php artisan package:discover`. |

Wykrywanie pakietów jest częścią generowania automatycznego ładowania. Jeśli usługodawcy lub
metadane pakietu nie są odświeżane, uruchom zrzut automatycznego ładowania Composer i sprawdź pakiet
wynik odkrycia.

## Narzędzia deweloperskie

Podstawowe zależności deweloperskie obejmują:

| Pakiet | Cel |
| --- | --- |
| `pestphp/pest` | Biegacz testowy. |
| `mockery/mockery` | Testuj podwójnie. |
| `roave/security-advisories` | Blokuje znane wersje zależności podatne na ataki. |

Plik projektu głównego Composer udostępnia także skrypt analityczny PHPStan dla pliku
warstwa projektu.

## Zasada dokumentacji

Podczas dokumentowania instalacji pakietu, wymagań Composer lub usługi
odkrycie dostawcy, określ, która granica Composer jest używana: projekt główny,
rdzeń wykonawczy lub `core/custom/composer.json`.
