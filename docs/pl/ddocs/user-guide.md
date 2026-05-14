# Przewodnik użytkownika

Ten przewodnik pokazuje, jak czytać i utrzymywać dokumentację w dDocs z poziomu
menedżera Evolution CMS.

## Otworzyć moduł dokumentacji

1. Zaloguj się do menedżera Evolution CMS.
2. Otwórz moduł Dokumentacja.
3. Poczekaj, aż załadują się drzewo po lewej i panel podglądu po prawej.

## Przeglądać dokumentację pakietów

1. Wybierz źródło na stronie startowej albo w drzewie.
2. Rozwiń foldery.
3. Wybierz dokument.
4. Czytaj wyrenderowany Markdown w prawym panelu.

Vendor docs są tylko do odczytu. Zmieniaj je w repozytorium pakietu.

## Szukać dokumentacji

1. Kliknij pole wyszukiwania w sidebar.
2. Wpisz fragment tytułu, ścieżki, nazwy pakietu albo treści.
3. Otwórz wynik z przefiltrowanego drzewa.
4. Wyczyść pole, aby wrócić do pełnego drzewa.

## Zrozumieć fallback języka

dDocs zaczyna od języka menedżera. Jeśli brakuje dokumentacji dla tej lokalizacji,
przechodzi do English, a potem do neutral docs.

Ukraińska dokumentacja używa tylko `uk`. Legacy manager input `ua` jest
normalizowany do `uk`.

## Utworzyć dokument projektu

1. Kliknij create document w toolbar sidebar.
2. Wpisz nazwę dokumentu.
3. Potwierdź dialog.
4. dDocs utworzy Markdown file w `ProjectDocs/`.

## Edytować dokument projektu

1. Otwórz dokument z Project Documentation.
2. Kliknij edit w header dokumentu.
3. Zmień Markdown w editor.
4. Kliknij save.

## Odświeżyć indeks

1. Otwórz settings panel.
2. Kliknij refresh index.
3. Poczekaj na aktualną liczbę dokumentów.
