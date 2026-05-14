# Wymagania

[Wstecz](README.md) / [W górę](README.md) / [Dalej](installation.md)

Aktualna dokumentacja Evolution CMS musi opisywać istniejące środowisko wykonawcze,
nie starsze założenia Evo 1.x z archiwum starszych dokumentów.

## Rdzeń wykonawczy

| Wymóg | Obecny poziom bazowy |
| --- | --- |
| PHP | `^8.3` |
| Composer | Composer 2.x do instalacji projektu i pakietu. |
| Dostęp do bazy danych | Wymagany jest PDO. MySQL, PostgreSQL, SQLite i SQL Server są obsługiwane przez bieżące opcje instalatora, jeśli dostępny jest pasujący sterownik PHP. |
| Rozszerzenia PHP | Rdzeń wymaga JSON, PDO, ZIP, mbstring, rozszerzeń związanych z XML, sesji, tokenizera, OpenSSL, ctype, informacji o pliku, filtra, skrótu, iconv i PCRE. |
| Opcjonalna obsługa obrazów | Do obsługi obrazów zalecany jest GD lub Imagick. |

Projekt główny `composer.json` jest minimalny, natomiast `core/composer.json` jest właścicielem
większy zestaw zależności wykonawczych: Illuminate 12 komponentów, Flysystem, PHPMailer,
Tracy, proces Symfony, integracja Composer i pakiety pomocnicze.

## Środowisko wykonawcze instalatora

Samodzielny instalator wymaga:

| Wymóg | Notatki |
| --- | --- |
| PHP | `^8.3` |
| Composer | Potrzebne do globalnej instalacji instalatora i konfiguracji projektu. |
| JSON, PDO, MySQLi, ZIP | Wymagane przez pakiet instalacyjny. |
| Dostęp GitHub | Potrzebne, gdy program inicjujący pobiera lub aktualizuje plik binarny instalatora Go z wersji GitHub. |
| Zapisywalny katalog bin instalatora | Potrzebne do `evo self-install` i pierwszej instalacji binarnej. |

Komenda instalacyjna `system-status` sprawdza wersję systemu operacyjnego PHP,
Composer, sterowniki PDO, JSON, MySQLi, mbstring, cURL, obsługa obrazów, miejsce na dysku,
i limit pamięci.

## Zasada dokumentacji

Jeśli wymaganie zostało skopiowane ze starej dokumentacji, sprawdź je w porównaniu z obecną
Pliki Composer, kod instalatora i instalacja są sprawdzane przed opublikowaniem ich tutaj.
