# Ustawienia, uprawnienia i pliki

[Wstecz](elements.md) / [W górę](README.md) / [Dalej](../04-development/project-structure.md)

Ten przewodnik omawia podstawowe obszary konfiguracji menedżera: ustawienia systemowe, przyjazne
Adresy URL, dostęp do plików, przesyłanie, wyszukiwanie, role, uprawnienia i grupy dostępu do sieci.

## Ustawienia systemowe

Strona menedżera Ustawień systemowych jest chroniona uprawnieniami i można ją zablokować
inny użytkownik-menedżer go edytuje. Aktualne karty ustawień obejmują:

| Zakładka | Powszechne zastosowanie |
| --- | --- |
| Ogólne | Domyślne ustawienia witryny, domyślne ustawienia publikowania, domyślne ustawienia pamięci podręcznej, domyślne ustawienia wyszukiwania, zachowanie indeksu menu, szablony i ustawienia czasu. |
| Przyjazne adresy URL | Tryb adresu URL, przyrostek/prefiks, zachowanie folderów, ścisłe adresy URL i zachowanie aliasów. |
| Interfejs | Manager język, motyw, opcje edytora i opcje interfejsu. |
| Bezpieczeństwo | Ustawienia zabezpieczeń hasła i menedżera. |
| Przeglądarka plików | Resource Podstawowa ścieżka przeglądarki i czyszczenie przesłanych nazw plików. |
| Plik Manager | Ścieżka menedżera plików, listy dozwolonych przesyłania, listy dozwolonych obrazów/multimediów i rozmiar przesyłanych plików. |
| Szablony poczty | Ustawienia szablonu poczty Manager. |

Po zmianie ustawień wpływających na dane wyjściowe, ścieżki, adresy URL, przesyłanie, pamięć podręczną lub
zachowanie menedżera, odśwież pamięć podręczną i przetestuj przepływ pracy, którego to dotyczy.

## Przyjazne adresy URL

Przyjazne adresy URL wymagają:

1. Włączono ustawienia przyjaznego adresu URL Evolution CMS.
2. Prawidłowe aliasy zasobów.
3. Zasady przepisywania serwera WWW dla projektu.
4. Odśwież pamięć podręczną po zmianach.

Jeśli dokładne adresy URL nie zostaną znalezione, użyj wyszukiwania menedżera według adresu URL i zweryfikuj zasób
są publikowane, nie usuwane i nie blokowane przez reguły dostępu.

## Pliki i przesłane pliki

Przeglądarka plików i zachowanie podczas przesyłania zależą zarówno od ustawień Evolution CMS, jak i od
uprawnienia do systemu plików.

Sprawdź:

- ścieżka menedżera plików;
- katalog bazowy przeglądarki zasobów;
- dozwolone rozszerzenia plików/obrazów/multimediów;
- ustawienie rozmiaru przesyłanego pliku;
- Limity przesyłania PHP i serwera WWW;
- uprawnienia do odczytu/zapisu katalogów.

## Role i uprawnienia Manager

Role i uprawnienia Manager kontrolują dostęp użytkowników menedżerów. Kiedy użytkownik
nie można otworzyć ekranu, sprawdź:

1. Rola użytkownika.
2. Zezwolenie wymagane przez stronę menedżera.
3. Czy zasób lub element jest zablokowany.
4. Czy akcja jest ukryta przez reguły dostępu menedżera.

## Uprawnienia dostępu do sieci

Uprawnienia dostępu do sieci korzystają z grup użytkowników i grup dokumentów. Strona menedżera może
utwórz, zmień nazwę, usuń i połącz te grupy.

Użyj uprawnień dostępu do sieci, gdy odwiedzający witrynę powinni zobaczyć tylko określone chronione
zasoby. Jeśli funkcja jest wyłączona, na stronie menedżera pojawi się wcześniej ostrzeżenie
zarządzanie grupą.

## Szukaj

Wyszukiwanie Manager pozwala znaleźć zasoby według identyfikatora, pól tekstowych, dokładnego adresu URL, szablonu i
Wartości Template Variable. Użyj go w przypadkach pomocy technicznej, w których znajduje się lokalizacja drzewa
nieznany lub zasób jest ukryty, usunięty, niepublikowany lub chroniony.

## Granica dokumentacji pakietu

Dokumentacja głównego menedżera opisuje wbudowane zachowanie Evolution CMS. Zainstalowano Extras
pojawiają się jako oddzielne źródła dokumentacji w dDocs. Jeśli ekran menedżera należy
do pakietu, otwórz dokumentację tego pakietu, zamiast oczekiwać, że zrobi to dokumentacja produktu
powielić jego instrukcję.
