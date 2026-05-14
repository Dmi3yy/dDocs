# Odniesienie CLI

[Wstecz](../07-security-updates-operations/troubleshooting.md) / [W górę](../README.md) / [Dalej](source-inventory.md)

Ta strona stanowi zwięzłe odwołanie do bieżącego wiersza poleceń Evolution CMS
powierzchnie instalacyjne. Użyj [Instalacja](../01-getting-started/installation.md)
dla procesu instalacji z przewodnikiem.

## Polecenia instalatora

| Polecenie | Cel |
| --- | --- |
| `evo install [dir] [flags]` | Zainstaluj projekt. Pomiń `dir` w trybie TUI, aby wybrać go interaktywnie. |
| `evo self-install` | Pobierz i zainstaluj plik binarny instalatora obok programu ładującego PHP. |
| `evo self-update` | Zaktualizuj plik binarny instalatora z najnowszej dostępnej wersji. |
| `evo system-status` | Wydrukuj status systemu JSON w celu przeprowadzenia diagnostyki instalatora. |
| `evo version` | Wydrukuj wersję instalacyjną. |

## Zainstaluj flagi

| Flaga | Znaczenie |
| --- | --- |
| `-f`, `--force` | Zainstaluj nawet wtedy, gdy katalog docelowy już istnieje lub wygląda jak istniejący projekt. |
| `--branch=<name>` | Zainstaluj Evolution CMS z określonej gałęzi Git zamiast najnowszej kompatybilnej wersji. |
| `--preset=<spec>` | Zastosuj ustawienie wstępne warstwy projektu po instalacji rdzenia. |
| `--db-type=<driver>` | Sterownik bazy danych: `mysql`, `pgsql`, `sqlite` lub `sqlsrv`. |
| `--db-host=<host>` | Host bazy danych dla instalacji innych niż SQLite. |
| `--db-port=<port>` | Port bazy danych. Jeśli zostanie pominięty, instalator, jeśli to możliwe, użyje domyślnego sterownika. |
| `--db-name=<name>` | Nazwa bazy danych lub nazwa pliku bazy danych SQLite. |
| `--db-user=<user>` | Nazwa użytkownika bazy danych dla instalacji innych niż SQLite. |
| `--db-password=<password>` | Hasło bazy danych dla instalacji innych niż SQLite. |
| `--admin-username=<name>` | Początkowa nazwa użytkownika administratora menedżera. |
| `--admin-email=<email>` | Początkowy adres e-mail administratora menedżera. |
| `--admin-password=<password>` | Początkowe hasło administratora menedżera. W trybie CLI musi mieć co najmniej 6 znaków. |
| `--admin-directory=<dir>` | Nazwa katalogu Manager. Domyślnie `manager` w trybie CLI. |
| `--language=<locale>` | Język instalacji, na przykład `en` lub `uk`. |
| `--github-pat=<token>` | Token GitHub dla żądań API i unikania limitów szybkości. |
| `--github_pat=<token>` | Alternatywna pisownia opcji tokena GitHub. |
| `--extras=<list>` | Extras oddzielony przecinkami do zainstalowania po konfiguracji. |
| `--log` | Zapisz dane wyjściowe dziennika instalatora do `log.md`. |
| `--cli` | Uruchom w nieinteraktywnym trybie CLI. |
| `--quiet` | Zredukuj dane wyjściowe CLI do ostrzeżeń i błędów. |
| `--composer-clear-cache` | Wyczyść pamięć podręczną Composer przed instalacją zależności. |
| `--composer-update` | Podczas konfiguracji użyj `composer update` zamiast `composer install`. |

## Wymagane wartości trybu CLI

Tryb CLI nie zadaje pytań. Podaj co najmniej:

```bash
evo install demo \
  --cli \
  --db-type=sqlite \
  --db-name=database.sqlite \
  --admin-email=admin@example.com \
  --admin-password=change-me
```

W przypadku pominięcia w trybie CLI instalator domyślnie przyjmuje:

| Wartość | Domyślne |
| --- | --- |
| Nazwa użytkownika administratora | `admin` |
| Katalog Manager | `manager` |
| Język | `en` |
| Ustawienie wstępne | `evolution` |
| Host inny niż SQLite | `localhost` |
| Użytkownik inny niż SQLite | `root` |

## Wstępnie ustawione specyfikacje

| Spec | Rozdzielczość |
| --- | --- |
| `evolution` | Instalacja tylko na rdzeniu; brak ustawień wstępnych warstwy projektu. |
| `default` | Domyślne publiczne repozytorium gotowych ustawień. |
| `evolution-cms-presets/default` | Repozytorium GitHub w ramach publicznej organizacji presetów. |
| `owner/repository` | Repozytorium GitHub. |
| Adres URL Git | Użyj bezpośrednio podanego adresu URL repozytorium. |
| Ścieżka lokalna | Użyj lokalnego zestawu gotowych ustawień i zachowaj go jako źródło. |
| `spec@ref` lub `spec#ref` | Użyj określonej gałęzi, tagu lub ref. |

## Składnia Extras

| Składnia | Znaczenie |
| --- | --- |
| `--extras=sTask,sSeo` | Zainstaluj zarządzaną Extras według nazwy pakietu. |
| `--extras=sTask@dev-main` | Zainstaluj zarządzaną Extra z jawnym ograniczeniem wersji lub gałęzi. |
| `--extras=legacy-store:84@1.12.2` | Zainstaluj pakiet Legacy Store według identyfikatora katalogu i wersji. |

Dokumentacja Extras jest własnością pakietu. Po instalacji dDocs powinien wykryć
dokumentację systemu plików każdego pakietu i pokaż ją w drzewie dokumentacji.

## Pola stanu systemu

`evo system-status` zwraca JSON z ogólnym statusem i indywidualnymi sprawdzeniami.
Aktualne kontrole obejmują:

- system operacyjny;
- wersja PHP;
- Dostępność Composer;
- sterowniki PDO i bazy danych;
- JSON, MySQLi, mbstring, cURL;
- Obsługa obrazów GD lub Imagick;
- miejsce na dysku;
- limit pamięci.

Ostrzeżenia oznaczają, że instalacja może nadal przebiegać w zależności od wybranej bazy danych
lub cecha. Błędy oznaczają, że w środowisku brakuje wymaganej linii bazowej.
