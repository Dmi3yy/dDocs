# Informacje o środowisku wykonawczym konfiguracji

[Wstecz](source-inventory.md) / [W górę](../README.md) / [Dalej](core-composer.md)

Evolution CMS ma dwie warstwy konfiguracyjne: pliki projektu/środowiska wykonawczego i bazę danych
ustawienia systemowe. Najpierw uruchamiana jest konfiguracja środowiska wykonawczego, a następnie ustawienia systemowe
ładowane przez przepływy podstawowe i menedżerskie.

## Przepływ ładowania początkowego

| Krok | Zachowanie w czasie wykonywania |
| --- | --- |
| Automatyczne ładowanie Composer | `core/bootstrap.php` ładuje `core/vendor/autoload.php`. |
| Zainstaluj znacznik czasu | `EVO_INSTALL_TIME` jest odczytywany z `core.install`, jeśli jest obecny. |
| Moduł ładujący środowisko | Program ładujący pamięć podręczną środowiska próbuje załadować wartości `.env` z wygenerowaną pamięcią podręczną PHP. |
| Definicje niestandardowe | `core/custom/define.php` jest ładowany, jeśli jest obecny. |
| Podstawowe definicje | `core/includes/define.inc.php` definiuje podstawowe ścieżki i stałe. |
| Flaga sesji | `EVO_SESSION` jest odczytywany z env i domyślnie włączony. |
| Serwer proxy sesji | `core/functions/session_proxy.php` łączy zgodność sesji. |
| Dziedzictwo obejmuje | `core/includes/legacy.inc.php` ładuje zachowanie zgodności. |
| Ochrona | `core/includes/protect.inc.php` wzmacnia bezpośredni dostęp. |
| Początek sesji | Manager/żądania parsera rozpoczynają sesję CMS, chyba że kontekst je wyłączy. |

Bootstrap musi pozostać tolerancyjny. Jeśli ładowanie pamięci podręcznej środowiska nie powiedzie się, plik
środowisko wykonawcze wraca do bezpośredniego ładowania Dotenv.

## Pliki środowiska

Kolejność wyszukiwania środowiska:

1. `core/custom/.env`
2. `.env` w katalogu głównym projektu

Plik pamięci podręcznej środowiska to:

```text
core/storage/cache/env.php
```

Pamięć podręczna jest ważna, gdy czas jej modyfikacji jest nowszy lub równy
wybrany plik `.env`. Jeśli jest nieaktualny, moduł ładujący analizuje `.env`, stosuje wartości,
i zapisuje atomowo nową pamięć podręczną tablicy PHP.

## Reguły pamięci podręcznej środowiska

| Zasada | Zachowanie |
| --- | --- |
| Niezmienne obciążenie | Istniejące wartości w `$_ENV` lub `$_SERVER` nie są nadpisywane. |
| Obsługa starszej wersji `getenv()` | `putenv()` jest wywoływany tylko w przypadku braku wartości OS/env. |
| Wartości null | Usunięto z wygenerowanej pamięci podręcznej. |
| Puste ciągi | Zachowane jako wartości rzeczywiste. |
| Zapis w pamięci podręcznej | Zapisuje do pliku tymczasowego z blokadą, a następnie zmienia nazwę na miejsce. |
| Zachowanie w przypadku niepowodzenia | Awarie są pochłaniane i tam, gdzie to możliwe, stosuje się bezpośrednie ładowanie Dotenv. |

Wyczyść pamięć podręczną po zmianie buforowanych wartości `.env` lub konfiguracji środowiska wykonawczego
przez projekt.

## Podstawowe pliki konfiguracyjne

| Plik | Odpowiedzialność |
| --- | --- |
| `core/config/app.php` | Dostawcy, aliasy, grupy oprogramowania pośredniczącego, ustawienia regionalne aplikacji, rezerwowe ustawienia regionalne. |
| `core/config/cache.php` | Magazyny pamięci podręcznej i zachowanie pamięci podręcznej. |
| `core/config/database.php` | Menedżer bazy danych i linia bazowa Redis. |
| `core/config/database/default.php` | Domyślna konfiguracja połączenia z bazą danych. |
| `core/config/database/migrations.php` | Konfiguracja repozytorium migracji. |
| `core/config/filesystems.php` | Dyski systemu plików i katalogi główne pamięci. |
| `core/config/logging.php` | Kanały rejestrowania i zachowanie dziennika. |
| `core/config/session.php` | Sterownik sesji i opcje sesji. |
| `core/config/tracy.php` | Integracja Tracy/debugowania. |
| `core/config/view.php` | Wyświetl ścieżki, skompilowaną ścieżkę Blade i starszą konfigurację wywołania zwrotnego dyrektyw. |
| `core/config/blade-icons.php` | Blade Konfiguracja ikon. |
| `core/config/cms/observers.php` | Modelowanie okablowania obserwatora. |

## Niestandardowa warstwa projektu

Projekt zastępuje na żywo pod `core/custom/`. Aktualne przykłady obejmują:

| Plik | Cel |
| --- | --- |
| `.env.example` | Szablon środowiska projektu. |
| `.env.docker.example` | Szablon środowiska zorientowanego na Docker. |
| `define.php.example` | Niestandardowe definicje stałych ładowane przed definicjami rdzenia. |
| `composer.json.example` | Punkt rozszerzenia projektu Composer połączony przez podstawową konfigurację Composer. |
| `config/cms/settings.php.example` | Przykład zastąpienia ustawień projektu CMS. |
| `config/middleware.php.sample` | Przykład niestandardowych aliasów/grup oprogramowania pośredniego. |
| `routes.php.example` | Przykład rejestracji trasy projektu. |

Nie edytuj podstawowych plików konfiguracyjnych w celu zachowania wyłącznie projektu, gdy plik `core/custom`
istnieje nadpisanie.

## Dostawcy i aliasy

Lista dostawców aplikacji obejmuje usługi Illuminate, usługi Evolution,
starsi dostawcy kompatybilności, dostawcy menedżerów/motywów, routing/sesja/system
dostawcy zadań, dostawcy Blade i dostawcy usług zarządzania dokumentami/użytkownikami.

Podstawowe aliasy ujawniają popularne fasady Illuminate, takie jak `Artisan`, `Cache`, `DB`,
`Event`, `File`, `Log`, `Route`, `Session`, `Storage`, `View` i ewolucja
fasady takie jak `ManagerTheme`, `UrlProcessor`, `TemplateProcessor`,
`DocumentManager`, `UserManager` i `Tailwind`.

## Grupy oprogramowania pośredniego

| Grupa | Zachowanie |
| --- | --- |
| `mgr` | Sesja, proxy sesji, CSRF, autoryzacja menedżera, powiązania tras, błędy widoku udostępnionego. |
| `global` | Sesja, serwer proxy sesji, powiązania tras, błędy widoku udostępnionego. |
| `aliases` | `csrf`, `authtoken`, `managerauth` i `bindings`. |

Zamiast tego dodaj niestandardowe oprogramowanie pośrednie za pośrednictwem niestandardowej konfiguracji oprogramowania pośredniego projektu
zmiana podstawowej listy oprogramowania pośredniego.

## Granica ustawień systemowych

Pliki konfiguracyjne środowiska wykonawczego definiują strukturę i zachowanie ładowania początkowego. System CMS-owy
ustawienia definiują zachowanie witryny przechowywane w bazie danych, np. przyjazne adresy URL,
szablony, ścieżki menedżera plików, domyślne ustawienia pamięci podręcznej i preferencje interfejsu menedżera.

Użyj [Odniesienia do ustawień systemowych](system-settings.md) w przypadku CMS-a opartego na bazie danych
ustawienia i ta strona zawierająca pliki konfiguracyjne środowiska wykonawczego, środowiska, dostawców, aliasy,
i oprogramowanie pośrednie.
