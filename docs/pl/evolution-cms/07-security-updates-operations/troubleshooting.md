# Rozwiązywanie problemów

[Wstecz](../01-getting-started/core-concepts.md) / [W górę](README.md) / [Dalej](../10-reference/source-inventory.md)

Użyj tej strony do kontroli pierwszej linii przed otwarciem głębszego kodu lub hostingu
diagnostyka. Koncentruje się na bieżącym Evolution CMS i zachowaniu instalatora.

## Szybkie kontrole

| Objaw | Najpierw sprawdź |
| --- | --- |
| Instalator nie uruchamia się | Potwierdź PHP 8.3 lub nowszy, dostępność Composer i zapisywalny katalog binarny instalatora. Uruchom `evo system-status`, jeśli jest dostępny. |
| Instalator nie może pobrać ani zaktualizować pliku binarnego | Sprawdź dostęp sieciowy do wersji GitHub. Jeśli prędkość jest ograniczona, ustaw `GITHUB_TOKEN` lub podaj opcję tokenu instalatora GitHub. |
| Nie znaleziono Composer | Upewnij się, że Composer jest plikiem wykonywalnym na `PATH`, a nie tylko aliasem powłoki. Ustaw `EVO_COMPOSER_BIN`, gdy host potrzebuje jawnej ścieżki Composer. |
| Konfiguracja bazy danych nie powiodła się | Sprawdź, czy wybrany sterownik bazy danych jest zainstalowany dla PHP, host/port/nazwa/użytkownik/hasło są poprawne, a nazwy SQLite są prawidłowe dla katalogu bazy danych projektu. |
| Instalacja została zakończona, ale logowanie menedżera nie powiodło się | Sprawdź katalog menedżera wybrany podczas instalacji, zachowanie sesji/plików cookie, rekordy użytkowników bazy danych i czy polecenie install zgłosiło ostrzeżenia awaryjne dotyczące administratora i użytkownika. |
| Strona jest pusta lub zwraca błąd serwera | Sprawdź dzienniki błędów PHP, dzienniki aplikacji, brakujące zależności Composer i czy wygenerowane pamięci podręczne wymagają pełnego odświeżenia. |
| Zmiany nie są widoczne na stronie | Wyczyść całą pamięć podręczną lub uruchom akcję odświeżenia witryny. Buforowanie Resource, pamięć podręczna widoku, pamięć podręczna env i pamięć podręczna przeglądarki mogą ukryć ostatnie zmiany. |
| Przyjazne adresy URL nie działają | Upewnij się, że `friendly_urls` jest włączony, reguły przepisywania są skonfigurowane na serwerze WWW, aliasy są prawidłowe i pamięć podręczna została odświeżona. |
| Przeglądarka plików lub przesyłanie plików nie powiodło się | Sprawdź `filemanager_path`, `rb_base_dir`, ustawienia rozszerzenia przesyłania, maksymalny rozmiar wysyłania i uprawnienia systemu plików dla katalogów docelowych. |
| Użytkownik-menedżer nie może zobaczyć dokumentu | Sprawdź uprawnienia menedżera, grupy dokumentów, grupy użytkowników, flagi prywatności zasobów i czy użytkownik ma dostęp do akcji menedżera. |
| Brak dokumentacji pakietu w dDocs | Upewnij się, że pakiet zawiera folder systemu plików `docs/`, pakiet został zainstalowany w projekcie, dDocs został odświeżony, a bieżący język menedżera jest mapowany na dostępne ustawienia regionalne dokumentów. |
| Funkcja specyficzna dla Extra nie jest tutaj udokumentowana | Otwórz ten Extra w dDocs. Dokumentacja produktu opisuje wspólne zachowanie Evolution CMS; zainstalowany Extras posiada własne podręczniki funkcji. |

## Pamięć podręczna i odświeżanie

Typowa ścieżka pełnego odświeżania wywołuje `evo()->clearCache('full')`. Strona menedżera
odświeżanie powoduje również publikację i cofnięcie publikacji zaplanowanych zasobów, czyści pełną pamięć podręczną,
usuwa wygenerowaną pamięć podręczną env, jeśli jest obecna, i wywołuje zdarzenie odświeżania witryny.

Użyj odświeżenia pamięci podręcznej po zmianie:

- szablony, fragmenty, fragmenty, wtyczki, moduły lub Template Variables;
- ustawienia systemowe wpływające na routing, ścieżki, przesyłanie, pamięć podręczną lub dane wyjściowe menedżera;
- dostawcy usług pakietowych, zasoby, widoki lub wygenerowana konfiguracja;
- aliasy zasobów, stan publikacji, uprawnienia lub ustawienia przyjaznego adresu URL.

## Lista kontrolna przyjaznego adresu URL

Problemy z przyjaznym adresem URL zwykle dotyczą zarówno ustawień Evolution CMS, jak i serwera WWW
konfiguracja.

| Powierzchnia | Co zweryfikować |
| --- | --- |
| Ustawienia Manager | `friendly_urls`, ustawienia sufiksu/prefiksu, zachowanie folderu, ścisłe ustawienia adresu URL i aliasy. |
| Serwer WWW | Reguły przepisywania Apache lub równoważny routing Nginx są aktywne dla projektu. |
| Resources | Aliasy są unikalne tam, gdzie jest to potrzebne, a zasoby są publikowane, widoczne i nie są usuwane. |
| Pamięć podręczna | Odśwież witrynę po zmianie aliasów, ustawień adresu URL lub przepisania zachowania. |

## Lista kontrolna plików i przesyłania

Problemy z menedżerem plików i przesyłaniem zwykle wynikają ze ścieżek, list dozwolonych rozszerzeń lub
uprawnienia.| Obszar ustawień | Co zweryfikować |
| --- | --- |
| Ścieżka menedżera plików | Skonfigurowana ścieżka wskazuje wewnątrz projektu i jest czytelna dla PHP. |
| Katalog bazowy przeglądarki Resource | Katalog podstawowy przeglądarki wskazuje zamierzoną lokalizację zasobów. |
| Prześlij rozszerzenia | Listy rozszerzeń plików, obrazów i multimediów umożliwiają oczekiwany typ pliku. |
| Prześlij rozmiar | Limit przesyłania Evolution CMS i limit przesyłania PHP/serwera WWW są wystarczająco wysokie. |
| Uprawnienia | PHP może tworzyć, zapisywać, zmieniać nazwy i usuwać pliki w katalogu docelowym. |

## Granica dokumentacji pakietu

dDocs to powierzchnia dokumentacji pakietu dla zainstalowanego Extras. Jeśli pakiet
pojawia się w drzewie dDocs tylko z nazwą pakietu lub bez zlokalizowanych stron,
napraw źródło dokumentacji pakietu, zamiast kopiować do niego jego instrukcję
Dokumentacja produktu Evolution CMS.

W przypadku problemów z dokumentacją pakietu sprawdź:

- pakiet zawiera `docs/en/README.md` lub inny obsługiwany wpis locale;
- Ukraińska dokumentacja pakietów korzysta z folderu ustawień regionalnych `uk`; starsze ukraińskie ustawienia regionalne
  foldery należy przenieść przed wydaniem;
- dokumentacja pakietu ma stałe tytuły i jedno H1 na stronę;
- linki względne są rozwiązywane w katalogu głównym dokumentów pakietu;
- Indeks/pamięć podręczna dDocs została odświeżona po zmianach plików.

## Dane pomocnicze do zebrania

Kiedy problem wymaga głębszej analizy, zbierz:

- Wersja PHP i włączone sterowniki baz danych;
- Wersja lub gałąź Evolution CMS;
- wersja instalatora i użyte polecenie;
- typ bazy danych i to, czy problem występuje przed czy po migracji;
- język menedżerski;
- zmienione ustawienia systemowe dotyczące pamięci podręcznej, adresów URL, ścieżek, przesyłania lub uprawnień;
- dokładne działanie menedżera lub adres URL, który się nie powiódł;
- ostatnie instalacje lub aktualizacje pakietów.
