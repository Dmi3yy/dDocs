# Dokumentacja Evolution CMS

[Centrum dokumentacji](../README.md) / Evolution CMS

To jest kanoniczna polska dokumentacja produktu Evolution CMS w dDocs.
Najpierw opisuje bieżącą bazę kodu, a starszych materiałów używa tylko po
sprawdzeniu ich względem aktualnego kodu.

## Zacznij tutaj

| Potrzebuję | Otwórz |
| --- | --- |
| Zainstaluj nowy projekt | [Instalacja](01-getting-started/installation.md) |
| Sprawdź wymagania dotyczące środowiska wykonawczego | [Wymagania](01-getting-started/requirements.md) |
| Naucz się podstawowego słownictwa | [Podstawowe koncepcje](01-getting-started/core-concepts.md) |
| Użyj podstawowych przepływów pracy menedżera | [Przy użyciu Evolution CMS](02-using-evolution-cms/README.md) |
| Zrozumienie układu środowiska wykonawczego | [Struktura projektu](04-development/project-structure.md) |
| Utwórz nowoczesny pakiet | [Utwórz pakiet](05-extras-and-packages/create-package.md) |
| Utwórz site preset | [Utwórz preset](05-extras-and-packages/create-preset.md) |
| Znajdź mapy referencyjne dla programistów | [API i integracje](06-api-and-integrations/README.md) |
| Diagnozuj typowe problemy w projekcie | [Rozwiązywanie problemów](07-security-updates-operations/troubleshooting.md) |
| Przejrzyj podstawowe ustawienia domyślne i ustawienia | [Odniesienia do ustawień systemowych](10-reference/system-settings.md) |
| Przejrzyj role i uprawnienia | [Odniesienie do ról i uprawnień](10-reference/roles-and-permissions.md) |
| Zrozumienie konfiguracji i ładowania `.env` | [Odniesienia do środowiska wykonawczego konfiguracji](10-reference/configuration-runtime.md) |
| Zrozumienie okablowania rdzenia Composer | [Odniesienie do rdzenia Composer](10-reference/core-composer.md) |
| Zrozumienie starszej zgodności | [Starsze informacje dotyczące zgodności](10-reference/legacy-compatibility.md) |
| Użyj szablonów i dyrektyw Blade | [Blade i odniesienie do renderowania szablonów](10-reference/blade-and-template-rendering.md) |
| Wyszukaj klasyczne tagi parsera | [Odniesienie do znaczników parsera](10-reference/parser-tags.md) |
| Wyszukaj polecenia Artisan dla zainstalowanego projektu | [Omówienie poleceń Artisan](10-reference/artisan-commands.md) |
| Wyszukaj polecenia instalatora | [Odniesienie CLI](10-reference/cli-reference.md) |
| Postępuj zgodnie ze sprawdzonymi przepisami | [Poradniki i przepisy](08-tutorials-recipes/README.md) |
| Sprawdź konwencje pakietów | [Extras i pakiety](05-extras-and-packages/README.md) |
| Przeglądaj wszystkie strony referencyjne | [Odniesienie](10-reference/README.md) |
| Zrozumienie mapy źródłowej | [Zapasy źródłowe](10-reference/source-inventory.md) |
| Postępuj zgodnie z zasadami łączenia stron | [Nawigacja w dokumentacji](10-reference/documentation-navigation.md) |
| Zobacz dozwolone źródła treści | [Zasady dotyczące źródeł dokumentacji](10-reference/documentation-source-policy.md) |

## Kształt dokumentacji

Dokumentacja produktu Evolution CMS jest uporządkowana według zadań czytelnika, a nie według starego repozytorium
foldery.

```text
evolution-cms/
  01-getting-started/
  02-using-evolution-cms/
  03-site-building/
  04-development/
  05-extras-and-packages/
  06-api-and-integrations/
  07-security-updates-operations/
  08-tutorials-recipes/
  09-community-support/
  10-reference/
```

Ten baseline zawiera pierwsze strony dokumentacji produktu gotowe do review
przed wydaniem. Głębokie reference na poziomie metod, route payloads i
field-level help dla Managera są śledzone jako osobne zadania i powinny być
dodawane dopiero po walidacji aktualnego kodu.

## Polityka źródłowa

- Bieżący kod Evolution CMS jest źródłem prawdy o zachowaniu środowiska wykonawczego.
- Samodzielny pakiet `evolution-cms/installer` jest źródłem prawdy
  bieżący przebieg instalacji.
- Stare archiwum dokumentacji pozostaje archiwum starszej wersji.
- Stare podręczniki komponentów nie są migrowane do tego drzewa dokumentacji produktów, ponieważ
  zainstalowany Extras udostępnia własną dokumentację pakietu w dDocs.
- Notatki dotyczące najlepszych praktyk mogą stać się stronami publicznymi dopiero po sprawdzeniu bieżącego kodu.

## Reguła nawigacji

Strony powinny używać stabilnych linków względnych. Kiedy sekcja rośnie, dodaj małą
linię nawigacyjną z łączami `Back`, `Up` i `Next`, dzięki czemu czytelnicy mogą przeglądać
docs bez polegania wyłącznie na drzewie.
