# Działania Artisan i Manager

[Wstecz](events.md) / [W górę](../README.md) / [Dalej](source-inventory.md)

Ta strona mapuje bieżące powierzchnie poleceń i działań menedżera. To jest początek
punkt dla głębszego odniesienia do poleceń i dokumentacji przepływu pracy menedżera.

## Polecenia Artisan

| Powierzchnia | Polecenia |
| --- | --- |
| Pamięć podręczna i widoki | `cache:clear-full`, wyczyść skompilowaną pamięć podręczną, przejrzyste widoki. |
| Pakiety | `package:discover`, `package:create`, `package:installrequire`, `package:removerequire`, `package:installautoload`, `package:runconsoles`, `extras`. |
| Ustawienia wstępne | `preset:apply`, `preset:install`. |
| Listy i diagnostyka | `doc:list`, `template:list`, `tv:list`, `deprecated:list`, lista tras. |
| Harmonogram | lista harmonogramów i polecenia uruchamiania harmonogramu. |
| Zadania systemowe | puls harmonogramu i polecenia pracownika zadaniowego. |
| Strona/środowisko wykonawcze | aktualizacja witryny, aktualizacja drzewa, synchronizacja tłumaczeń, publikacja dostawcy, kompilacja Tailwind. |

Użyj [CLI Reference](cli-reference.md) dla autonomicznej komendy instalatora `evo`
powierzchni i [Omówienie poleceń Artisan](artisan-commands.md) dla pełnego
Powierzchnia poleceń zainstalowanego projektu. Ta strona to kompaktowa mapa, która łączy
polecenia z powierzchniami akcji menedżera.

## Źródła akcji Manager

Akcje Manager nie są pojedynczym nowoczesnym plikiem trasy. Obecne zachowanie menedżera jest
rozwiązany z kilku powierzchni:

| Powierzchnia | Odpowiedzialność |
| --- | --- |
| `ManagerTheme` | Rozwiązuje akcję aktywnego menedżera i kontroler. |
| `core/factory/actionlist.php` | Starsza mapa identyfikatorów akcji i metadane akcji. |
| `core/src/Controllers/` | Aktualne kontrolery strony menedżera. |
| `manager/actions/` | Starsze i dynamiczne procedury obsługi akcji. |
| `manager/processors/` | Mutowanie procesorów zapisu/usuwania/publikowania/ustawień/pamięci podręcznej. |
| `manager/views/` | Blade widoki i przyciski akcji. |
| Model `managerActionsMap` tablice | Wspólne identyfikatory akcji do edycji, zapisywania, usuwania, duplikowania, włączania, wyłączania, sortowania, uruchamiania i powiązanych akcji modelu. |

## Wspólne akcje modelu

| Obszar modelu | Wspólne działania |
| --- | --- |
| Szablony | nowy, edytuj, zapisz, usuń, duplikuj. |
| Template Variables | nowy, edytuj, zapisz, usuń, duplikuj, sortuj. |
| Chunks | nowy, edytuj, zapisz, włącz, wyłącz, usuń, zduplikuj. |
| Snippets | nowy, edytuj, zapisz, włącz, wyłącz, usuń, zduplikuj. |
| Plugins | nowy, edytuj, zapisz, włącz, wyłącz, usuń, duplikuj, sortuj, czyść. |
| Modules | nowy, edytuj, zapisz, włącz, wyłącz, usuń, zduplikuj, uruchom, zależność. |
| Resources | twórz, edytuj, zapisuj, przenoś, duplikuj, publikuj, cofaj publikację, usuwaj, przywracaj, opróżniaj kosz. |

## Zasada dokumentacji

Dokumentując działanie menedżera, zweryfikuj wszystkie trzy warstwy:

- identyfikator akcji lub modelowa mapa akcji;
- administrator/akcja/procesor obsługujący żądanie;
- widok menedżera, który udostępnia użytkownikowi akcję.

Nie traktuj starych nazw akcji jako bieżącego zachowania, chyba że nadal są one rozwiązywane
bieżące środowisko wykonawcze menedżera.
