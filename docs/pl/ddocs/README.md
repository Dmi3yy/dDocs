# dDocs

dDocs to dokumentacyjna przeglądarka file-first dla managera Evolution CMS. Wykrywa
dokumentację Markdown w zainstalowanych pakietach Evolution, pokazuje źródła
pakietów w lewym drzewie, renderuje wybrany dokument w prawym panelu i pozwala
projektowi utrzymywać własną lokalną bazę wiedzy Markdown.

Źródłem prawdy jest system plików. dDocs nie potrzebuje tabel w bazie danych dla
dokumentacji pakietów.

## Możliwości

- Wykrywanie dokumentacji z zainstalowanych pakietów Evolution.
- Pokazywanie drzewa pakietów/modułów z folderami i dokumentami Markdown.
- Uwzględnianie języka managera z fallbackiem do angielskiego lub dokumentów neutralnych.
- Wyszukiwanie po tytule, ścieżce, nazwie pakietu i treści Markdown.
- Bezpieczne renderowanie GitHub-flavored Markdown wewnątrz managera.
- Rozwiązywanie linków względnych między zaindeksowanymi dokumentami.
- Renderowanie lokalnych obrazów tylko z bezpiecznych katalogów dokumentacji.
- Przechowywanie dokumentacji projektu w `ProjectDocs/`.
- Cache generowanego indeksu plików dla szybszej nawigacji w managerze.

## Przewodniki

- [Gaid użytkownika](user-guide.md)
- [Gaid dewelopera](developer-guide.md)
- [Frontend guide](frontend-guide.md)
- [Konfiguracja](configuration.md)
- [Referencja](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Standardy dokumentacji](documentation-standards.md)

## Renderowanie Markdown

dDocs wysyła surowy Markdown do strony managera i renderuje go w przeglądarce
lokalnymi assetami dTui/TOAST UI. Podświetlanie kodu używa lokalnych assetów
Prism, w tym gramatyki Evolution Blade.

dDocs nadal odpowiada za warstwę bezpieczeństwa wokół viewer:

- bloki HTML podobne do skryptów są usuwane przed wysłaniem Markdown do viewer;
- względne linki dokumentacji są mapowane na zaindeksowane identyfikatory dokumentów dDocs;
- lokalne obrazy są konwertowane tylko po przejściu kontroli bezpiecznych katalogów docs;
- brakujące względne linki dokumentacji pozostają nieaktywne zamiast nawigować iframe managera.

## Model runtime

```text
Pakiety Composer / lokalne pakiety Evolution
        |
        v
DocsSourceRegistry
        |
        v
DocsIndexer
        |
        v
FileIndexCache
        |
        v
Livewire ModulePanel -> raw Markdown payload -> dTui/TOAST UI Viewer
                                           -> link/image post-processing
```

## Dokumentacja projektu

Dokumenty tworzone z UI dDocs są zapisywane w `ProjectDocs/` wewnątrz pakietu
dDocs. Dokumentacja projektu jest zapisywalna, a dokumentacja pakietów vendor
pozostaje tylko do odczytu.

Używaj dokumentacji projektu dla lokalnej wiedzy należącej do bieżącego projektu:

- notatki architektoniczne;
- notatki środowiskowe;
- notatki wdrożeniowe;
- decyzje specyficzne dla projektu;
- kontekst pracy AI/Codex.
