# dDocs

dDocs to plikowa przeglądarka dokumentacji dla menedżera Evolution CMS. Moduł
odnajduje dokumentację Markdown w zainstalowanych pakietach, pokazuje ją jako
drzewo, renderuje wybrany dokument i pozwala utrzymywać notatki projektu jako
zwykłe pliki.

Źródłem prawdy jest filesystem. dDocs nie potrzebuje tabel w bazie danych dla
dokumentacji pakietów.

## Przewodniki

- [Przewodnik użytkownika](user-guide.md)
- [Przewodnik dewelopera](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Konfiguracja](configuration.md)
- [Reference](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Standardy dokumentacji](documentation-standards.md)

## Zasady

- Dokumentacja pakietów żyje w `docs/`.
- Ukraińska lokalizacja dokumentacji to tylko `uk`.
- Vendor docs są read-only.
- Project Documentation jest zapisywana w `ProjectDocs/`.
- Linki wewnętrzne muszą być względne.
- Code fences muszą mieć language identifier.
