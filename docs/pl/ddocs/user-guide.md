# Gaid użytkownika

Ten przewodnik pokazuje użytkownikom managera, jak czytać i utrzymywać
dokumentację w dDocs. Skupia się na zadaniach wykonywanych wewnątrz managera
Evolution CMS.

## Otwórz moduł dokumentacji

1. Zaloguj się do managera Evolution CMS.
2. Otwórz moduł Documentation z menu managera.
3. Poczekaj, aż załaduje się lewe drzewo dokumentacji i prawy panel viewer.

Widok startowy pokazuje dostępne źródła dokumentacji. Źródłem może być pakiet,
sam pakiet dDocs albo Project Documentation.

## Przeglądaj dokumentację pakietu

1. Wybierz źródło z widoku startowego albo z lewego drzewa.
2. Rozwiń foldery za pomocą chevron.
3. Wybierz dokument.
4. Czytaj wyrenderowany Markdown w prawym panelu.

Dokumentacja pakietów vendor jest tylko do odczytu. Aby ją zmienić, edytuj pliki
w repozytorium pakietu.

## Szukaj w dokumentacji

1. Kliknij pole wyszukiwania w sidebar.
2. Wpisz słowo z tytułu dokumentu, ścieżki, nazwy pakietu albo treści.
3. Otwórz wynik z przefiltrowanego drzewa.
4. Wyczyść pole wyszukiwania, aby wrócić do pełnego drzewa.

dDocs pomija pliki większe niż `max_file_size_kb`, aby nawigacja w managerze
pozostawała responsywna.

## Zrozum fallback języka

dDocs zaczyna od bieżącego języka managera. Jeśli ta lokalizacja nie istnieje,
wraca do angielskiego, a potem do dokumentów neutralnych.

Dokumentacja ukraińska używa `uk`. Jeśli starszy manager nadal zwraca legacy
wartość `ua`, dDocs automatycznie otwiera dokumentację `uk`.

## Zmień język dokumentacji

dDocs obecnie podąża za językiem managera albo skonfigurowanym
`default_language`. Zmień język managera albo ustaw `default_language`, gdy
projekt potrzebuje stałego języka dokumentacji.

## Utwórz dokument projektu

1. Kliknij przycisk tworzenia dokumentu w toolbar sidebar.
2. Wpisz nazwę dokumentu.
3. Potwierdź dialog.
4. dDocs utworzy plik Markdown w `ProjectDocs/` i go otworzy.

Project Documentation to zapisywalny obszar dla lokalnej wiedzy projektowej.

## Utwórz folder projektu

1. Kliknij przycisk tworzenia folderu w toolbar sidebar.
2. Wpisz nazwę folderu.
3. Potwierdź dialog.
4. Otwórz nowy folder z drzewa.

Nazwy folderów i dokumentów są konwertowane na bezpieczne nazwy plików przed
zapisem na dysk.

## Edytuj dokument projektu

1. Otwórz dokument z Project Documentation.
2. Kliknij akcję edycji w nagłówku dokumentu.
3. Zaktualizuj Markdown w edytorze.
4. Kliknij save.

dDocs odświeża indeks plików po zapisaniu.

## Usuń element projektu

1. Otwórz menu kontekstowe dla zapisywalnego elementu Project Documentation.
2. Wybierz delete.
3. Potwierdź dialog.

Usuwanie nie jest dostępne dla dokumentacji pakietów vendor ani dla korzeni
źródeł.

## Kopiuj Markdown albo kod

Użyj akcji copy w nagłówku dokumentu, aby skopiować pełne źródło Markdown.
Użyj akcji copy przy code block, aby skopiować tylko ten fragment.

## Odśwież indeks

1. Otwórz panel ustawień.
2. Kliknij refresh index.
3. Poczekaj na odświeżoną liczbę dokumentów.

Odśwież indeks po ręcznej zmianie dokumentacji pakietów albo po zmianie
skonfigurowanych korzeni dokumentacji.

## Pobierz dokumentację jako Markdown

1. Otwórz panel ustawień.
2. Kliknij Download Markdown.
3. Zapisz wygenerowany plik `.md`.

Eksport zawiera czytelne węzły dokumentów z bieżącego indeksu dDocs. Lokalne
linki względne i obrazy zachowują swoje oryginalne ścieżki źródłowe.

## Rozwiąż problem brakującego dokumentu

Jeśli dokumentu brakuje:

1. Odśwież indeks.
2. Sprawdź, czy rozszerzenie pliku jest dozwolone.
3. Sprawdź, czy plik mieści się w limicie `max_file_size_kb`.
4. Sprawdź, czy pakiet ma wspieraną strukturę `docs/`.
5. Poproś dewelopera o sprawdzenie safe roots, jeśli źródło jest specyficzne dla projektu.
