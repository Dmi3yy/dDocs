# Elementy

[Wstecz](resources-and-document-tree.md) / [W górę](README.md) / [Dalej](settings-permissions-and-files.md)

Zarządzanie elementami to obszar menedżera szablonów, Template Variables,
fragmenty, fragmenty, wtyczki i moduły. Obecny kod menedżera organizuje je jako
zakładkach w kontrolerze Resources.

## Typy elementów

| Element | Użyj go do |
| --- | --- |
| Szablon | Układ strony i struktura wyników zasobów. |
| Template Variable | Niestandardowe pola dołączone do szablonów i zapisane dla każdego zasobu. |
| Chunk | Znaczniki lub fragmenty tekstu wielokrotnego użytku. |
| Snippet | Logika oparta na PHP, która zwraca dane wyjściowe. |
| Plugin | Kod rozszerzenia sterowany zdarzeniami. |
| Module | Ekran narzędzia lub aplikacji po stronie Manager. |

## Pracuj z szablonami

Twórz lub edytuj szablony, gdy zasób wymaga układu lub innego zestawu
Template Variables. Szablon można wybierać, blokować, kategoryzować i łączyć
do TVs.

Podczas zmiany szablonu:

1. Zapisz szablon.
2. Przejrzyj przypisane Template Variables.
3. Odśwież pamięć podręczną, gdy dane wyjściowe się nie zmieniają.
4. Przetestuj zasoby korzystające z szablonu.

## Pracuj z Template Variables

Template Variables definiuje pola strukturalne, które pojawiają się na zasobach za pomocą
przypisane szablony. TVs ma typ, podpis, kategorię, elementy/opcje,
tryb wyświetlania, domyślny tekst i reguły dostępu do roli/szablonu.

Użyj TVs do danych treści, którymi redaktorzy powinni zarządzać oddzielnie od głównych
pole zawartości zasobu.

## Pracuj z Chunks i Snippets

Chunks to bloki tekstu lub znaczników wielokrotnego użytku. Snippets to bloki logiczne oparte na PHP.
Obydwa można włączać, wyłączać, duplikować, usuwać, blokować i kategoryzować
menadżer.

Używaj fragmentów do powtarzania znaczników. Użyj fragmentów, gdy dane wyjściowe wymagają logiki środowiska wykonawczego.

## Pracuj z Plugins i zdarzeniami

Plugins są połączone z nazwanymi zdarzeniami i uruchamiane, gdy środowisko wykonawcze je wywoła
wydarzenia. Kolejność Plugin jest kontrolowana przez priorytet zdarzenia. Używaj wtyczek na potrzeby cyklu życia
haki, takie jak zapisywanie dokumentów, parser, menedżer, pamięć podręczna, przeglądarka plików i użytkownik
wydarzenia.

Przed dodaniem lub zmianą a. zobacz [Odniesienie do zdarzeń](../10-reference/events.md).
połączenie zdarzenia wtyczki.

## Pracuj z Modules

Modules to narzędzia po stronie menedżera. Mogą zawierać kod modułu, pliki zasobów,
współdzielone parametry, zależności i akcje uruchamiania/edytowania. Zainstalowane moduły pakietu mogą
posiada również dokumentację należącą do pakietu w dDocs.

Nie kopiuj instrukcji modułu pakietu do tego drzewa dokumentacji produktu. Otwórz
źródło pakietu w dDocs, jeśli opcja należy do zainstalowanego Extra.
