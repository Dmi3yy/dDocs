# Odniesienie do zgodności ze starszymi wersjami

[Wstecz](core-composer.md) / [W górę](../README.md) / [Dalej](artisan-commands.md)

Evolution CMS utrzymuje starszą warstwę kompatybilności, dzięki czemu bieżący kod może obsługiwać
klasyczne interfejsy API Evolution, zachowanie parsera, działania menedżera i starsze rozszerzenia
wzory, podczas gdy środowisko wykonawcze wykorzystuje nowoczesne komponenty PHP i Illuminate.

## Starsza warstwa źródłowa

| Plik lub klasa | Odpowiedzialność |
| --- | --- |
| `core/includes/legacy.inc.php` | Bootstrap zawiera dla zgodności ze starszymi wersjami. |
| `Legacy/DeprecatedCore.php` | Przestarzałe zachowanie zgodności podstawowej. |
| `Legacy/ManagerApi.php` | Powierzchnia kompatybilności Manager/API. |
| `Legacy/TemplateParser.php` | Zgodność parsera szablonów. |
| `Legacy/Modifiers.php` | Obsługa modyfikatora parsera i modyfikatora warunkowego. |
| `Legacy/Phx.php` | Zgodność z symbolami zastępczymi/modyfikatorami w stylu PHx. |
| `Legacy/Cache.php` | Zachowanie w zakresie przebudowy/aktualizacji starszej pamięci podręcznej. |
| `Legacy/Permissions.php` | Zachowanie zgodności uprawnień użytkownika/dokumentu. |
| `Legacy/ErrorHandler.php` | Starsza obsługa błędów. |
| `Legacy/LogHandler.php` | Starsze zachowanie rejestrowania. |
| `Legacy/PasswordHash.php` | Zgodność mieszania haseł ze starszymi wersjami. |
| `Legacy/PhpCompat.php` | Pomocnicy kompatybilności PHP. |
| `Legacy/Categories.php` | Zachowanie zgodności kategorii. |
| `Legacy/ModuleCategoriesManager.php` | Zachowanie zgodności kategorii Module. |
| `Legacy/mgrResources.php` | Zgodność pomocnika zasobów/elementów Manager. |

## Starsi dostawcy

Lista dostawców aplikacji rejestruje dostawców zgodności jako przestarzałe
podstawowe zachowanie, DB API, menedżer API, modyfikatory, haszowanie haseł, PHx,
DLTemplate, ModResource, ModUsers, pomocnicy systemu plików i powiązane wsparcie.

Ci dostawcy udostępniają klasyczne interfejsy API, podczas gdy nowszy kod korzysta z bieżącego
usługi, modele, kontrolery i fasady.

## Starsze wersje obejmują i pomocników

Core Composer automatycznie ładuje pliki pomocy/akcji, które zachowują starsze funkcje
powierzchnie:

| Powierzchnia | Automatycznie ładowane pliki |
| --- | --- |
| Pomocnicy akcji Manager | `functions/actions/*.php` dla menedżera plików, ustawień, mutacji treści, wtyczek, rejestrowania, pomocy i zachowania menedżera kopii zapasowych. |
| Pomocnicy środowiska uruchomieniowego | `functions/helper.php`, `functions/laravel.php`, `functions/utils.php` |
| Drzewo i węzły | `functions/nodes.php` |
| Wstępne ładowanie i procesory | `functions/preload.php`, `functions/processors.php` |

Nowy kod powinien preferować obecne usługi i modele, ale dokumentacja musi
uznać, że te powierzchnie funkcyjne nadal istnieją.

## Starsze akcje Manager

Menedżer nadal zawiera procedury obsługi akcji i procesory:

| Powierzchnia | Cel |
| --- | --- |
| `core/factory/actionlist.php` | Starsza mapa identyfikatorów działań. |
| `manager/actions/` | Starsze i dynamiczne procedury obsługi stron/akcji. |
| `manager/processors/` | Mutowanie procesorów w celu zapisywania, usuwania, publikowania, buforowania, ustawień, ról, modułów, użytkowników i elementów. |
| `ManagerTheme` | Rozwiązuje problem aktywnego działania/kontrolera i zachowania motywu menedżera. |
| Modelowe mapy akcji | Podaj identyfikatory akcji edycji/nowego/zapisywania/usuwania/uruchamiania dla ekranów opartych na modelach. |

Dokumentując funkcję menedżera, sprawdź identyfikator akcji, kontroler/akcję
plik, procesor i widok Blade razem.

## Zgodność parsera

Klasyczne funkcje analizatora składni pozostają częścią bieżącego środowiska wykonawczego:

| Funkcja | Notatki |
| --- | --- |
| Tagi Resource | Składnia pola `[*field*]` i TV. |
| Ustawienia tagów | `[(setting)]`. |
| Chunks i fragmenty | `{{chunk}}`, `[[snippet]]` i `[!snippet!]`. |
| Elementy zastępcze | `[+placeholder+]` z zachowaniem PHx/modyfikatorem. |
| Tagi URL | `[~id~]`. |
| Tagi warunkowe | `<@IF:...>`, `<@ELSEIF:...>`, `<@ELSE>`, `<@ENDIF>`. |
| Tryby szablonów | `@CODE`, `@FILE`, `@DOCUMENT`, `@B_FILE` i `@B_CODE`. |

Aby uzyskać szczegółowe informacje na temat składni, użyj [Odniesienia do tagów parsera](parser-tags.md).

## Czego nie migrować na ślepo

Nie kopiuj starych instrukcji komponentów do dokumentacji produktu tylko dlatego, że
starsza warstwa nadal istnieje. Stare komponenty, stare fragmenty i starsze metody tworzenia witryn
wzorce powinny pozostać w dotychczasowym archiwum, chyba że zostaną sprawdzone względem
bieżący kod i nadal reprezentują zalecane użycie.

Zainstalowany Extras udostępnia własne dokumenty jako oddzielne źródła dDocs.

## Zasada dokumentacjiDokumentując starsze zachowanie, oznacz je jako zgodność, chyba że tak jest
zalecana ścieżka prądu. Połącz starsze roszczenia z bieżącymi odniesieniami do kodu i
unikaj przekształcania starych interfejsów API w nowe przykłady najlepszych praktyk.
