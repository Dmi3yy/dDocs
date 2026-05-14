# Instalacja

[Wstecz](requirements.md) / [W górę](README.md) / [Dalej](core-concepts.md)

Aktualnie zalecana ścieżka instalacji to samodzielna ścieżka Evolution CMS
Pakiet instalatora. Starszy instalator sieciowy nadal istnieje w głównym koszyku,
ale współczesna dokumentacja powinna najpierw uczyć samodzielnego przepływu pracy `evo`.

## Zainstaluj instalator

Zainstaluj instalator globalnie za pomocą Composer:

```bash
composer global require evolution-cms/installer
```Upewnij się, że globalny katalog bin Composer jest dostępny w `PATH`, a następnie sprawdź:

```bash
evo version
```Przy pierwszym uruchomieniu program inicjujący PHP instaluje pasujący plik binarny Go z GitHub
Zwalnia, weryfikuje sumy kontrolne, przechowuje plik binarny obok programu ładującego i
przekazuje mu polecenie.

Możesz wstępnie zainstalować plik binarny jawnie:

```bash
evo self-install
```Zaktualizuj plik binarny instalatora za pomocą:

```bash
evo self-update
```Aby sprawdzić środowisko lokalne przed instalacją, uruchom:

```bash
evo system-status
```Komenda status zwraca JSON dla adaptera instalatora. Sprawdza
system operacyjny, wersja PHP, Composer, PDO i sterowniki baz danych, JSON, MySQLi,
mbstring, cURL, obsługa obrazów, miejsce na dysku i limit pamięci.

## Utwórz projekt

Uruchom interaktywny instalator:

```bash
evo install
```

Instalator prowadzi użytkownika przez:

- katalog docelowy;
- połączenie z bazą danych;
- konto administratora;
- katalog menedżerów;
- język instalacji;
- gotowe projekty;
- opcjonalny wybór Extras.

Użyj trybu interaktywnego, gdy człowiek wybiera ścieżkę projektu, predefiniowaną,
baza danych, język i opcjonalny Extras. Użyj trybu CLI, jeśli te odpowiedzi są
znane z góry i instalacja powinna przebiegać bez monitów TUI.

W przypadku instalacji skryptowej:

```bash
evo install demo \
  --cli \
  --branch=3.5.x \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-username=admin \
  --admin-email=admin@example.com \
  --admin-password=change-me \
  --admin-directory=manager \
  --language=uk \
  --preset=evolution-cms-presets/default
```Tryb CLI wymaga podania typu bazy danych, nazwy bazy danych, adresu e-mail administratora i admina
hasło. Domyślna nazwa użytkownika administratora to `admin`, a katalog menedżera to
`manager`, język do `en` i ustawienie wstępne do `evolution`, gdy te wartości
nie są zapewnione.

Pełną listę opcji można znaleźć w [Odniesienie do CLI](../10-reference/cli-reference.md).

## Opcje bazy danych

Instalator obsługuje te sterowniki baz danych, jeśli ma odpowiednie rozszerzenie PHP
jest dostępny:

| Kierowca | Notatki |
| --- | --- |
| `sqlite` | Wymaga nazwy pliku bazy danych. Instalator przechowuje znormalizowane nazwy SQLite w katalogu bazy danych projektu. |
| `mysql` | Wymaga hosta, nazwy bazy danych, użytkownika i hasła w trybie CLI, chyba że akceptowane są wartości domyślne. |
| `pgsql` | Wymaga sterownika PostgreSQL PDO i poświadczeń połączenia. |
| `sqlsrv` | Wymaga sterownika SQL Server PDO i poświadczeń połączenia. |

Przed kontynuowaniem instalator testuje połączenie z bazą danych. W interaktywnym
trybie, można ponowić nieudane połączenie. W trybie CLI nieudane połączenie zostaje zatrzymane
instalacja.

## Ustawienia wstępne

Instalator oddziela rdzeń Evolution CMS od warstwy projektu.

| Wstępnie ustawione wejście | Znaczenie |
| --- | --- |
| Pominięte w trybie TUI | Pokaż gotowe ustawienia z publicznego katalogu ustawień wstępnych. |
| `evolution` | Zainstaluj tylko rdzeń Evolution. |
| `default` | Przejdź do domyślnego publicznego repozytorium ustawień wstępnych. |
| `evolution-cms-presets/default` | Skopiuj domyślną warstwę projektu po instalacji rdzenia. |
| `owner/repository` | Przejdź do repozytorium GitHub. |
| Git Adres URL lub ścieżka lokalna | Użyj niestandardowego, wstępnie ustawionego źródła. |

Ustawienie wstępne nie definiuje przyszłej tożsamości Git utworzonej witryny. The
katalog docelowy może stać się własnym repozytorium projektu.

Ustawienie wstępne może zawierać sufiks ref, gdy potrzebna jest gałąź lub znacznik inny niż domyślny:

```bash
evo install demo --preset=evolution-cms-presets/default@dev
```Presety są stosowane poprzez zainstalowany plik `core/Artist
polecenie preset:install` po przygotowaniu rdzenia Evolution CMS, a następnie ustawienie wstępne
trwają migracje.

## Extras Podczas instalacji

Instalator może zainstalować Extras, gdy projekt podstawowy będzie gotowy:

```bash
evo install demo --extras=sTask,sSeo
```W razie potrzeby pakiety Legacy Store można wybierać według identyfikatora:

```bash
evo install demo --extras=legacy-store:84@1.12.2
```Nie dokumentuj instalacji starego komponentu jako domyślnej ścieżki dla bieżącej
projekty. Zachowaj informacje o starszych komponentach w starszym archiwum, chyba że: a
bieżący pakiet wyraźnie go zastępuje.

Zainstalowany Extras powinien zapewniać własną dokumentację pakietu. dDocs odkrywa
te dokumenty z zainstalowanych źródeł pakietów i pokazuje je obok produktu
dokumentacja.

## Rozwiązywanie problemów

| Problem | Sprawdź |
| --- | --- |
| GitHub API limit szybkości | Ustaw `GITHUB_TOKEN` lub przekaż `--github-pat`. |
| Composer to alias powłoki | Ustaw `EVO_COMPOSER_BIN` na prawdziwy plik wykonywalny Composer. |
| Nie można zainstalować pliku binarnego | Sprawdź uprawnienia do zapisu dla katalogu pakietu instalacyjnego `bin`. |
| Opcja bazy danych nie działa | Uruchom `evo system-status` i sprawdź pasujący sterownik PDO. |
| Tryb CLI kończy się przed instalacją | Podaj `--db-type`, `--db-name`, `--admin-email` i `--admin-password`. |
| Wykryto istniejący projekt | Użyj `--force` tylko wtedy, gdy celowo chcesz zainstalować w istniejącym katalogu. |

## Granica starszego instalatora internetowego

Podstawowa wersja pakietu nadal zawiera instalator sieciowy i skrypt instalacyjny CLI. Zachowaj
te dokumenty dotyczące konserwacji, zgodności i debugowania instalacji. Nowy użytkownik
dokumentację należy rozpocząć od samodzielnego instalatora, chyba że jest to zadanie
szczególnie na temat starszego zachowania związanego z instalacją internetową.
