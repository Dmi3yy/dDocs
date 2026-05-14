# Informacje o komendach Artisan

[Wstecz](legacy-compatibility.md) / [W górę](../README.md) / [Dalej](models.md)

Ta strona dokumentuje powierzchnię poleceń Artisan zainstalowanego projektu zarejestrowaną przez
bieżący rdzeń Evolution CMS. Jest niezależny od instalatora autonomicznego
Polecenie `evo` udokumentowane w [CLI Reference](cli-reference.md).

## Środowisko wykonawcze konsoli

Evolution CMS korzysta z niestandardowej aplikacji konsolowej, która:

- używa danych wersji Evolution CMS jako nazwy aplikacji konsolowej;
- wyłącza automatyczne wyjście i przechwytywanie wyjątków;
- tworzy obiekt żądania ze skonfigurowanego adresu URL witryny dla kontekstu konsoli;
- wywołuje zdarzenie startowe Artisan;
- ładuje odroczonych dostawców i polecenia ładowania początkowego.

Uruchom te komendy z kontekstu wykonawczego `core/` zainstalowanego projektu, chyba że a
polecenie jawnie akceptuje ścieżkę docelową.

## Pamięć podręczna i widoki

| Polecenie | Cel |
| --- | --- |
| `cache:clear` | Wyczyść skonfigurowany magazyn pamięci podręcznej Illuminate. |
| `cache:forget` | Usuń jeden klucz ze skonfigurowanego magazynu pamięci podręcznej. |
| `cache:clear-full` | Wyczyść skompilowaną pamięć podręczną Blade/view oraz powierzchnie pamięci podręcznej Evolution. |
| `clear-compiled` | Usuń skompilowany plik klasy. |
| `view:clear` | Wyczyść skompilowane pliki widoku Blade. |

## Baza danych i nasiona

| Polecenie | Cel |
| --- | --- |
| `migrate` | Uruchom migrację baz danych. |
| `migrate:fresh` | Usuń wszystkie tabele i ponownie uruchom migrację. |
| `migrate:install` | Utwórz repozytorium migracji. |
| `migrate:refresh` | Zresetuj i uruchom ponownie migracje. |
| `migrate:reset` | Wycofaj wszystkie migracje. |
| `migrate:rollback` | Wycofaj ostatnią partię migracji. |
| `migrate:status` | Pokaż stan migracji. |
| `make:migration` | Utwórz plik migracji. Komenda rozwoju. |
| `db:seed` | Uruchom siewniki. |

Traktuj destrukcyjne polecenia migracji jako zadania operacyjne. Mogą zniszczyć dane
po uruchomieniu z niewłaściwą bazą danych.

## Listy i diagnostyka

| Polecenie | Cel |
| --- | --- |
| `doc:list` | Lista dokumentów/zasobów z `site_content`. |
| `tpl:list` | Szablony list z `site_templates`. |
| `tv:list` | Lista Template Variables. |
| `deprecated:list` | Wyświetl listę przestarzałych znaczników i opcjonalnych znaczników usunięcia/wersji. Komenda rozwoju. |
| `route:list` | Lista zarejestrowanych tras. |

Polecenia te są przydatne do sprawdzania poprawności dokumentacji, ponieważ ujawniają
bieżących obiektów wykonawczych bez polegania na starych podręcznikach.

## Pakiety i Extras

| Polecenie | Podpis | Cel |
| --- | --- | --- |
| `package:discover` | `package:discover` | Generuj dane dotyczące wykrywania dostawców usług dla pakietów niestandardowych. |
| `package:create` | `package:create {packagename?}` | Utwórz rusztowanie pakietu. |
| `package:runconsoles` | `package:runconsoles` | Uruchamiaj polecenia konsoli z niestandardowych pakietów. |
| `package:installrequire` | `package:installrequire {key} {value} {composer_run=1}` | Dodaj wymaganie Composer do wymagań pakietu niestandardowego. |
| `package:removerequire` | `package:removerequire {key} {composer_run=1}` | Usuń wymaganie Composer z wymagań pakietu niestandardowego. |
| `package:installautoload` | `package:installautoload {key} {value} {composer_run=1}` | Dodaj wpis automatycznego ładowania do wymagań pakietu niestandardowego. |
| `extras` | `extras {typePackage?} {packageName?} {versionPackage?} {namePackage?} {--list} {--json}` | Przeglądaj lub instaluj Extras/packages w zależności od argumentów. |

Zainstalowany Extras powinien dokumentować polecenia specyficzne dla pakietu w pliku
własna dokumentacja pakietu. Ta strona dokumentuje podstawową powierzchnię poleceń, która odkrywa
i zarządza pakietami.

## Ustawienia wstępne

| Polecenie | Cel |
| --- | --- |
| `preset:install` | Zainstaluj ustawienie wstępne z repozytorium Git lub ścieżki lokalnej. |
| `preset:apply` | Zastosuj wstępnie ustawioną warstwę projektu do instalacji Evolution CMS. |

`preset:apply` obsługuje opcje ścieżki docelowej, ścieżki źródłowej, źródła/ref Git,
zachowanie sklonowanych źródeł, nazwy presetu, usuwanie brakujących plików z presetu,
tryb pracy na sucho, siewniki wymuszone i pomijanie automatycznego ładowania zrzutu Composer.

## Planowanie i zadania systemowe| Polecenie | Cel |
| --- | --- |
| `schedule:list` | Lista zaplanowanych poleceń. |
| `schedule:run` | Uruchom odpowiednie zaplanowane polecenia. |
| `schedule:work` | Uruchom pętlę procesu roboczego programu planującego. |
| `schedule:finish` | Oznacz zaplanowane wydarzenie jako zakończone. |
| `schedule:clear-cache` | Wyczyść stan muteksu/pamięci podręcznej harmonogramu. |
| `schedule:test` | Przetestuj zaplanowane polecenie. |
| `system:scheduler-heartbeat` | Rejestruj stan pulsu harmonogramu. |
| `system:task-worker` | Rejestruj aktywność pracownika zadań systemowych i przygotuj wykonanie zadania w kolejce. |

Polecenia zadań systemowych są poleceniami operacyjnymi środowiska wykonawczego. Dokumenty produkcyjne powinny
uwzględnij zasady nadzoru procesów i rejestrowania przed zaleceniem „zawsze włączone”.
pracownicy.

## Konserwacja witryny i projektu

| Polecenie | Cel |
| --- | --- |
| `make:site` | Aktualizuj/buduj obiekty witryny ze skonfigurowanych źródeł. |
| `closuretable:rebuild` | Odbuduj tabelę zamknięcia drzewa zasobów. |
| `translations:sync` | Synchronizuj klucze tłumaczeń z domyślnym plikiem językowym. |
| `tailwind:build {package?} {--force}` | Skompiluj Tailwind CSS dla jednego pakietu, wszystkich pakietów lub wymuszonej przebudowy. |
| `vendor:publish` | Publikuj zasoby dostawcy, które można opublikować. Komenda rozwoju. |

`make:site` i `closuretable:rebuild` wpływają na stan środowiska wykonawczego. Użyj kopii zapasowych i a
znany przebieg wdrażania przed uruchomieniem ich w środowisku produkcyjnym.

## Polecenia programistyczne

Polecenia programistyczne obejmują `vendor:publish`, `deprecated:list` i
`make:migration`. Są zarejestrowane przez tego samego usługodawcę, ale powinny być
udokumentowane jako narzędzia programistyczne/konserwacyjne, a nie zwykłe przepływy pracy menedżera.

## Zasada dokumentacji

Dokumentując polecenie, należy uwzględnić:

- nazwa/podpis polecenia;
- kontekst wykonawczy;
- czy odczytuje czy mutuje stan projektu;
- czy jest bezpieczny do produkcji;
- powiązana konfiguracja lub granica Composer.

W tym opisie produktu nie dokumentuj zachowania poleceń specyficznych dla pakietu
chyba że polecenie jest zarejestrowane przez rdzeń Evolution CMS.
