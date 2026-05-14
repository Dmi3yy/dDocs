# Nawigacja w dokumentacji

[Wstecz](source-inventory.md) / [W górę](../README.md) / [Dalej](documentation-source-policy.md)

Dokumentacja Evolution CMS wykorzystuje małą gramatykę nawigacyjną, dzięki czemu czytelnicy mogą się poruszać
przez sekcję, nie polegając wyłącznie na lewym drzewie.

## Typy nawigacji

| Typ łącza | Cel | Przykład |
| --- | --- |
| Strukturalne | Przejdź przez drzewo dokumentacji. | `Back`, `Up`, `Next` |
| Sekcja dzieci | Pokaż strony należące do sekcji. | Tabela w `README.md` |
| Semantyczny | Połącz powiązane koncepcje lub obszary źródłowe. | `Related`, `See Also` |

## Połączenia strukturalne

Użyj tego kształtu na górze sekcji wielostronicowych:

```text
# Page Title

[Back](previous.md) / [Up](README.md) / [Next](next.md)

Short reader-focused opening paragraph.

## Task Or Reference Section

...

## Related

- [Relevant page](other-page.md)
```

Jeśli sąsiad strukturalny nie istnieje, pomiń to połączenie zamiast wymyślać sąsiada
cel.

## Strony docelowe sekcji

Sekcja Strony `README.md` powinny być małymi portalami. Powinny one obejmować:

- jeden krótki akapit dotyczący sekcji;
- tabela stron podrzędnych;
- aktualny zakres sekcji;
- linki do powiązanych sekcji tylko wtedy, gdy są potrzebne.

## Strony referencyjne źródeł

Strony referencyjne źródeł mogą zawierać tabele źródłowe, listy poleceń, listy modeli,
tabele konfiguracyjne i status walidacji. Nie mogą zawierać prywatnych
ścieżki systemu plików, warunki planowania wewnętrznego lub wygenerowane metadane analityczne.

## Łącza Extras

Nie duplikuj zainstalowanej dokumentacji Extras w produkcie Evolution CMS
dokumenty. Link do dokumentów na poziomie pakietu, jeśli obsługiwany pakiet jest właścicielem szczegółów.
