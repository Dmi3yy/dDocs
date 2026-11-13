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
```Pamięć podręczna jest ważna, gdy czas jej modyfikacji jest nowszy lub równy
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

## Konfiguracja projektu

Sześć poniższych przykładów znajdziesz w kodzie źródłowym Evolution CMS w gałęzi `3.6.x`. Pakiet instalacyjny ich nie zawiera. Otwórz potrzebny przykład, skopiuj jego zawartość do wskazanego pliku, licząc ścieżkę od katalogu głównego projektu, i zastąp przykładowe wartości. Jeśli plik już istnieje, dodaj tylko potrzebne ustawienia lub kod i zachowaj dotychczasową konfigurację.

| Przykład w gałęzi `3.6.x` | Plik w projekcie | Co zmienić |
| --- | --- | --- |
| [`.env.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.example) | `core/custom/.env` | Ustaw parametry połączenia z bazą danych. W razie potrzeby dodaj ustawienia domeny lub panelu administracyjnego. Jeśli projekt korzysta już z pliku `.env` w katalogu głównym, dodaj ustawienia właśnie tam. |
| [`.env.docker.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.docker.example) | Na przykład `core/custom/.env.docker` | Zastąp przykładowe wartości `DB_USERNAME`, `DB_PASSWORD` i `DB_DATABASE`. W Docker Compose wskaż ten plik w `env_file` usługi CMS. Jeśli baza danych działa w osobnej usłudze, ustaw jej nazwę jako `DB_HOST`. CMS nie ładuje automatycznie pliku `.env.docker`. |
| [`define.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/define.php.example) | `core/custom/define.php` | Komentarz w przykładzie wymienia dostępne stałe. Użyj `define()` dla stałych, które chcesz nadpisać, na przykład `define('EVO_SITE_HOSTNAMES', 'example.com,www.example.com');`, i podaj domeny swojej witryny. |
| [`routes.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/routes.php.example) | `core/custom/routes.php` | Zastąp przykładową trasę `/helloworld` własną ścieżką i funkcją obsługującą żądanie. Poradnik pokazuje, jak dodać trasę dla formularza. [Formularze z własnymi trasami](../08-tutorials-recipes/forms-with-custom-routes.md) |
| [`ControllerNamespace.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings/ControllerNamespace.php.example) | `core/custom/config/cms/settings/ControllerNamespace.php` | Zwróć przestrzeń nazw swoich kontrolerów jako ciąg znaków zakończony ukośnikiem odwrotnym. Wskaż przestrzeń nazw, w której automatycznie ładowana jest klasa `BaseController`. |
| [`settings.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings.php.example) | `core/custom/config/cms/settings.php` | Zwróć tablicę zawierającą wyłącznie ustawienia, które chcesz nadpisać. Na przykład przypisz nazwę swojej witryny do `site_name`. |

Przechowuj rzeczywiste hasła w lokalnych plikach środowiskowych lub przekazuj je przez środowisko uruchomieniowe. Nie dodawaj ich do Gita.

W `core/custom/` znajdziesz też `composer.json.example` dla zależności projektu i `config/middleware.php.sample` dla własnych aliasów i grup middleware.

### Tworzenie plików w konsoli

Uruchom ten blok w Bashu z katalogu głównego projektu. Na końcu zostaw tylko polecenia dla potrzebnych przykładów. Każde polecenie pomija istniejący plik docelowy. Następnie zmień przykładowe wartości zgodnie z tabelą.

```bash
copy_evo_file() (
    source_path=$1
    target=$2
    [ ! -e "$target" ] && [ ! -L "$target" ] || exit 0
    mkdir -p "$(dirname "$target")" || exit 1
    sample=$(mktemp) || exit 1
    trap 'rm -f "$sample"' EXIT
    curl -fsSL "https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/$source_path" -o "$sample" || exit 1
    set -o noclobber
    cat "$sample" > "$target"
)

install_example() {
    copy_evo_file "core/custom/$1.example" "core/custom/$1"
}

install_example .env
install_example .env.docker
install_example define.php
install_example routes.php
install_example config/cms/settings/ControllerNamespace.php
install_example config/cms/settings.php
```

Do pracy z agentem możesz też pobrać plik `AGENTS.md` do katalogu głównego i dopisać w nim reguły swojego projektu. Modele PHP rdzenia są już w pakiecie instalacyjnym w `core/src/Models/`. [Dokumentacja modeli](models.md) · [Kod źródłowy modeli](https://github.com/evolution-cms/evolution/tree/3.6.x/core/src/Models)

```bash
copy_evo_file AGENTS.md AGENTS.md
```

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
