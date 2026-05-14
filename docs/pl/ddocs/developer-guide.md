# Gaid dewelopera

Ten przewodnik wyjaśnia, jak dDocs jest połączony, jak wykrywa dokumentację i
jak deweloperzy powinni bezpiecznie go rozszerzać.

## Model runtime

```text
DocsSourceRegistry -> DocsIndexer -> FileIndexCache
                                  -> FileDocumentRepository
ModulePanel        -> raw Markdown payload
Browser viewer     -> dTui/TOAST UI + Prism
LinkResolver       -> link, image, and UML maps
DocumentPath       -> path safety checks
FileSearch         -> title, path, source, and content search
```

System plików jest źródłem prawdy. dDocs nie używa tabel bazy danych dla
dokumentacji pakietów.

## Serwisy

| Serwis | Odpowiedzialność |
| --- | --- |
| `DocsSourceRegistry` | Wyszukuje dokumentację pakietów, dokumentację projektu, skonfigurowane roots i metadane źródeł. |
| `DocsIndexer` | Buduje węzły folderów i dokumentów ze stabilnymi id, metadanymi języka, scalaniem gałęzi fallback, timestampami i checksumami. |
| `FileIndexCache` | Przechowuje i odświeża wygenerowany cache metadanych PHP. |
| `FileDocumentRepository` | Czyta wybrane pliki Markdown po kontrolach bezpieczeństwa. |
| `LanguageResolver` | Rozwiązuje język managera, normalizuje legacy `ua` do `uk`, zwraca uporządkowane locale roots i znajduje dokumenty neutralne. |
| `ManagerText` | Ładuje etykiety UI managera z `lang/<locale>/global.php` z fallbackiem do etykiet angielskich. |
| `LinkResolver` | Rozwiązuje linki wewnętrzne, lokalne obrazy, bezpieczny HTML, języki kodu i URL-e obrazów UML. |
| `FileSearch` | Filtruje węzły po tytule, ścieżce, nazwie pakietu i treści Markdown. |
| `MarkdownExport` | Buduje jeden pobieralny plik Markdown z czytelnych dokumentów bieżącego indeksu plików. |
| `Diagnostics` | Raportuje stan źródeł read-only, cache, języka i path safety dla manager/debug. |

## Dane lookup runtime

Nie trzymaj dokładnych danych lookup w tym przewodniku, aby dokumentacja była
łatwa do utrzymania.

- Trasy, wspierane funkcje Markdown, zachowanie UML i metadane węzłów dokumentów
  są w [Referencji](reference.md).
- Klucze konfiguracji, wartości domyślne, typy i notatki bezpieczeństwa są w
  [Konfiguracji](configuration.md).
- Frontend payload i zmiany łamiące viewer są w [Frontend guide](frontend-guide.md).

Diagnostyka zawiera metadane systemu plików, dlatego trasy diagnostyczne muszą
pozostać za guardem manager/debug opisanym w [Referencji](reference.md).

## Model runtime wyszukiwania

dDocs obecnie używa filesystem live search: live filter nad indeksem plików, a
nie dedykowanego search engine, full-text index ani indeksowanej usługi search.

`DocsIndexer` buduje węzły metadanych nawigacji. `FileIndexCache` przechowuje te
węzły jako wygenerowane metadane PHP, aby drzewo otwierało się szybko. Cache
przechowuje tytuły, ścieżki, metadane źródeł, metadane języka, timestampy i
checksumy; nie przechowuje znormalizowanego tekstu dokumentów, tokenów,
nagłówków, snippets ani posting list dla wyszukiwania.

`ModulePanel` ładuje wszystkie węzły z `FileIndexCache` i przekazuje je do
`FileSearch`. `FileSearch` najpierw dopasowuje pola metadanych, takie jak tytuł,
ścieżka względna, nazwa źródła i nazwa pakietu. Gdy węzeł jest dokumentem, a
metadane nie pasują, odczytuje plik Markdown przez `FileDocumentRepository` i
sprawdza surową treść.

Wyszukiwanie po treści nadal respektuje model bezpieczeństwa systemu plików.
Czyta tylko zaindeksowane węzły dokumentów, dozwolone rozszerzenia, bezpieczne
docs roots i pliki poniżej `max_file_size_kb`.

Gdy dokument pasuje, `FileSearch` zwraca także jego foldery nadrzędne. Te
foldery są kontekstem UI, a nie dopasowaniami search. Dzięki temu drzewo
pozostaje czytelne podczas aktywnego wyszukiwania.

Checksumy obecnie należą do metadanych i invalidacji cache. Nie są jeszcze używane
do invalidacji indeksu search, bo oddzielny indeks search jeszcze nie istnieje.

## Roadmap wyszukiwania

Wyszukiwanie powinno pozostać filesystem-first. Następnym krokiem powinien być
wygenerowany file-based `FileSearchIndexCache`, a nie tabela w bazie danych ani
zewnętrzna usługa search.

Rekomendowany roadmap:

1. Dodać `FileSearchIndexCache` jako wygenerowany cache PHP albo JSON dla tekstu wyszukiwalnego.
2. Utrzymać indeks nawigacji i indeks search jako oddzielne odpowiedzialności.
3. Przebudowywać inkrementalnie po checksum i mtime, aby nie czytać ponownie niezmienionych dokumentów.
4. Przechowywać znormalizowany tekst wyszukiwalny, nagłówki, tokeny i źródło snippet.
5. Dodać proste scoring: tytuł ponad heading, heading ponad ścieżką, ścieżka ponad source/package, source/package ponad treścią.
6. Ranking exact phrase ponad token match, a token match ponad prefix match.
7. Dodać snippets, aby ogólne tytuły nadal pokazywały użyteczny kontekst wyniku.
8. Podświetlać dopasowania po stronie klienta po renderze, bez zmiany źródła Markdown.
9. Dodać małe filtry query, takie jak `source:ddocs`, `path:configuration`, `type:reference` i `lang:uk`.
10. Dodać tryby search: szybkie wyszukiwanie metadanych, full-text search i current source search.

Unikaj Elasticsearch, Meilisearch, Typesense, SQLite FTS, database-backed search
content i vector search w pierwszym release. Dodają infrastrukturę, która nie
pasuje do obecnego modelu file-as-source-of-truth.

## Kontrakt wykrywania źródeł

dDocs wykrywa dokumentację z:

- samego pakietu dDocs;
- zainstalowanych pakietów Composer wyglądających jak pakiety Evolution;
- korzeni pakietów z `docs/`, legacy `Docs/`, `README.md` albo `index.md`;
- Project Documentation w `ProjectDocs/`;
- skonfigurowanych safe roots i extra docs roots.

Nowe pakiety powinny wystawiać lowercase `docs/`. Legacy `Docs/` jest akceptowane
wyłącznie dla kompatybilności.

## Kontrakt językowy

dDocs rozwiązuje korzenie dokumentacji w kolejności priorytetów dla użytkownika
managera:

1. `default_language`, gdy jest skonfigurowany.
2. Język managera Evolution.
3. Legacy wartość managera `ua` normalizowana do locale dokumentacji `uk`.
4. `language_fallback`, zwykle `en`.
5. Dokumenty neutralne, takie jak `docs/pages`, `docs/README.md` albo `index.md`.

Drzewo jest scalonym widokiem logicznym, a nie surową listą folderów locale.
Zlokalizowane pliki wygrywają dla tej samej ścieżki względnej, a brakujące
zlokalizowane gałęzie są uzupełniane z locale fallback. Na przykład jeśli
`docs/uk/ddocs` istnieje, ale `docs/uk/evolution-cms` nie istnieje, dDocs zachowa
ukraińską gałąź `ddocs` i uzupełni `evolution-cms` z `docs/en/evolution-cms`.

Drzewo nie powinno pokazywać wszystkich locale naraz ani eksponować gałęzi
fallback jako osobnego korzenia języka.

Foldery locale dokumentacji muszą używać `uk` dla treści ukraińskiej. Legacy
folder `docs/ua` może być czytany wyłącznie jako alias migracyjny i jest
eksponowany w indeksie jako `uk`.

## Punkty rozszerzania

| Powierzchnia | Status | Reguła |
| --- | --- | --- |
| Wykrywanie źródeł | Serwis internal | Dodawaj korzenie pakietów przez `DocsSourceRegistry`, nie omijając safe roots. |
| Renderer post-processing | Wewnętrzny frontend runtime | Zachowaj kształt viewer payload, mapy linków, mapy obrazów, mapy UML i zachowanie code-copy. |
| Safe roots | Konfiguracja projektu | Dodawaj zaufane roots przez ustawienia, nie przez domyślne wartości pakietu. |
| Etykiety managera | Internal helper | Używaj `ManagerText` dla etykiet modułu i ustawień. |
| Diagnostyka | Guarded manager/debug route | Trzymaj metadane systemu plików za diagnostics guard. |
| Indeksowanie search | Serwis internal | Zachowaj limity rozmiaru plików i bezpieczne odczyty. |

## Bezpieczeństwo ścieżek

Wszystkie odczyty i zapisy plików muszą używać znormalizowanych ścieżek i kontroli
safe-root. Surowa ścieżka z requestu nigdy nie może być zaufana.

Akcje zapisywalne są ograniczone do Project Documentation. Dokumentacja pakietów
vendor jest indeksowana i renderowana, ale nie jest zapisywana przez UI managera.

## Zachowanie cache

Gdy `cache_index` jest włączony, dDocs zapisuje wygenerowany plik PHP zawierający
tylko metadane. Przechowuje węzły źródeł, folderów, ścieżki dokumentów, metadane
języka, timestampy i checksumy. Nie przechowuje kanonicznego Markdown w bazie danych.

Odśwież indeks po ręcznych zmianach package docs, zmianach konfiguracji roots albo
zmianach struktury językowej.

## Granica frontend

dDocs ma prawdziwą powierzchnię frontend: Blade shell, Livewire DOM, dTui/TOAST UI
viewer, Prism i browser post-processing. Zachowanie drzewa/viewer specyficzne dla
dokumentacji trzymaj lokalnie w dDocs, dopóki inny pakiet nie potrzebuje tego
samego prymitywu. Wspólne prymitywy promuj przez evo-ui zamiast je kopiować.

## Komendy weryfikacji

Uruchom te kontrole przed release:

```bash
find . -path './vendor' -prune -o -name '*.php' -print0 | xargs -0 -n1 php -l
composer validate --no-check-publish
```

Uruchom kontrole dokumentacji dDocs:

```bash
php docs/checks/docs-check.php
```

Uruchom demo runtime smoke z zainstalowanego manager demo, gdy jest dostępny.
