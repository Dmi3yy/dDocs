# Resources i drzewo dokumentów

[Wstecz](README.md) / [W górę](README.md) / [Dalej](elements.md)

Resources to węzły treści pokazane w drzewie dokumentów menedżera. Są
przechowywane przez model `SiteContent` i mogą reprezentować strony, foldery, łącza lub
inne typy treści w zależności od ich pól.

## Utwórz Resource

1. Otwórz drzewo dokumentów menedżera.
2. Wybierz lokalizację nadrzędną.
3. Utwórz nowy zasób lub łącze z poziomu drzewa lub elementów sterujących działaniami menedżera.
4. Wprowadź tytuł strony, alias, szablon, treść, ustawienia menu i opublikuj
   stan.
5. Zapisz zasób.
6. Odśwież pamięć podręczną witryny, jeśli zmiana nie jest widoczna od razu.

## Edytuj treść

Otwórz zasób z drzewa i zaktualizuj pola treści. Formularz zasobu
może zawierać pola Template Variable, jeśli wybrany szablon ma przypisany TVs.

Ważne pola zasobów obejmują:

| Powierzchnia pola | Dlaczego to ma znaczenie |
| --- | --- |
| Tytuł i tytuł menu | Używane w drzewie menedżerów, menu i pomocnikach wyjściowych. |
| Alias ​​| Używane przez przyjazne adresy URL, jeśli są włączone. |
| Indeks nadrzędny i menu | Kontroluj pozycję drzewa i kolejność menu. |
| Szablon | Kontroluje dostępny układ i Template Variables. |
| Stan opublikowany/usunięty | Kontroluje, czy zasób jest widoczny dla osób odwiedzających witrynę. |
| Flagi z możliwością wyszukiwania/buforowania | Wpływ na zachowanie wyszukiwania i pamięci podręcznej. |
| Prywatne flagi internetowe/menedżera | Wpływ na reguły dostępu. |

## Zorganizuj drzewo

Użyj akcji drzewa, aby przenosić, duplikować, usuwać, przywracać, publikować i cofać publikację
zasoby. Operacje przenoszenia wywołują przepływ przenoszenia bieżącego menedżera i wyzwalają przenoszenie
wydarzenia. Usuń zwykle oznacza zasób jako usunięty; pusty kosz usuwa usunięte
zasoby.

Jeśli zmiany w drzewie nie są widoczne, odśwież drzewo i wyczyść pamięć podręczną.

## Wyszukaj Resources

Powierzchnia wyszukiwania menedżera może przeszukiwać pola zasobów, dokładne identyfikatory, dokładne adresy URL,
filtry szablonów i wartości Template Variable. Dokładne wyszukiwanie adresu URL wykorzystuje prąd
przyjazne ustawienia adresów URL i rozpoznawanie aliasów.

Użyj wyszukiwania, gdy:

- zasób jest ukryty głęboko w drzewie;
- alias lub adres URL są znane, ale identyfikator zasobu nie;
- należy znaleźć wartość Template Variable;
- należy sprawdzić stan usunięty/nieopublikowany.

## Przyjazne adresy URL Uwagi

Przyjazne adresy URL zależą zarówno od ustawień Evolution CMS, jak i od przepisania serwera WWW
zasady. Jeśli zapisany alias nie działa:

1. Sprawdź ustawienie `friendly_urls`.
2. Sprawdź ustawienia sufiksu, prefiksu, folderu i dokładnego adresu URL.
3. Sprawdź reguły przepisywania na serwerze WWW.
4. Odśwież pamięć podręczną witryny.
5. Upewnij się, że zasób docelowy został opublikowany i nie został usunięty.

Aby zapoznać się z głębszymi kontrolami operacyjnymi, zobacz
[Rozwiązywanie problemów] (../07-security-updates-operations/troubleshooting.md).
