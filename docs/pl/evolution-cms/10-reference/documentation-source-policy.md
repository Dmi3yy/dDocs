# Polityka źródła dokumentacji

[Wstecz](documentation-navigation.md) / [W górę](../README.md)

Dokumentacja Evolution CMS musi opisywać bieżące zachowanie produktu. Historyczny
Materiał może pomóc, ale nie jest kanoniczny, dopóki nie zostanie sprawdzony pod kątem prądu
kod.

## Dozwolone źródła

| Źródło | Użyj |
| --- | --- |
| Aktualny kod Evolution CMS | Środowisko wykonawcze, menedżer, API, modele, konfiguracja, zdarzenia, CLI, zgodność instalatora i starsze ograniczenia. |
| Samodzielny kod instalatora i README | Bieżący przebieg konfiguracji pierwszego instalatora i zachowanie komendy `evo`. |
| Stare archiwum dokumentacji Evolution CMS | Klasyczne API, DB API, terminologia i zachowanie historyczne po walidacji. |
| Zatwierdzone notatki dotyczące najlepszych praktyk | Przyszłe receptury po sprawdzeniu bieżących interfejsów API routingu, modelu i menedżera. |
| Dokumentacja pakietu | Połączone, gdy utrzymywany Extra jest właścicielem szczegółów specyficznych dla pakietu. |

## Materiał nie został przeniesiony

Stare podręczniki komponentów nie są kopiowane do tego drzewa dokumentacji produktów. Zostają w środku
archiwum dziedzictwa. Aktualnie zainstalowane Extras pojawiają się w dDocs poprzez własne
dokumentacja na poziomie pakietu.

## Przejrzyj zasadę

W przypadku wykorzystania materiałów historycznych lub najlepszych praktyk:

1. Sprawdź aktualną ścieżkę kodu.
2. Sprawdź, czy dana funkcja jest aktualna, starsza lub przestarzała.
3. Przepisz stronę dla bieżącego zadania czytelnika.
4. Linkuj do dokumentacji pakietu zamiast kopiować instrukcje pakietu.
5. Zachowaj stare strony komponentów jako materiał archiwalny.

## Przyszłe tematy dotyczące najlepszych praktyk

Pierwsi kandydaci to:

- trasy, żądania Ajax, sprawdzanie poprawności żądań, odpowiedzi JSON i częściowe Blade
  renderowanie;
- Wykorzystanie modelu `SiteContent`, wykonywanie zapytań TV, przechodzenie przez drzewo zamknięcia i zasoby
  wzorce selekcji.

Należą do nich, gdy podstawowa dokumentacja jest wystarczająco dokładna, aby je wspierać i
po zweryfikowaniu przykładów z bieżącym kodem.
