# Struktura projektu

[Wstecz](README.md) / [W górę](README.md) / [Dalej](../10-reference/cli-reference.md)

Ta strona odwzorowuje bieżące repozytorium Evolution CMS w dokumentacji
granice. Wyjaśnia gdzie szukać przed napisaniem głębszego menadżera, API, model,
lub strony operacyjne.

## Układ najwyższego poziomu

| Ścieżka | Odpowiedzialność |
| --- | --- |
| `composer.json` | Metadane Composer na poziomie projektu i wymagania bazowe PHP. |
| `index.php` | Publiczny punkt wejścia dla żądań internetowych. |
| `core/` | Główne środowisko wykonawcze, integracja frameworka, konfiguracja, baza danych, konsola, testy, pamięć masowa i kod źródłowy. |
| `manager/` | Punkt wejścia Manager, akcje, procesory, widoki, elementy dołączane i media zarządzające. |
| `assets/` | Zasoby publiczne, przesłane pliki, dołączone fragmenty/wtyczki/moduły/szablony/elementy zastępcze TV, pamięć podręczna, lokalizacje kopii zapasowych, importu i eksportu. |
| `views/` | Elementy zastępcze warstwy widoku projektu. |
| `install/` | Zachowano starszą powierzchnię instalatora web/CLI w celu zapewnienia zgodności i debugowania. Nowe dokumenty powinny najpierw uczyć samodzielnego instalatora. |

## Rdzeń wykonawczy

`core/` to główna granica środowiska wykonawczego.

| Ścieżka | Odpowiedzialność |
| --- | --- |
| `core/composer.json` | Główny zestaw zależności środowiska wykonawczego, obejmujący komponenty Illuminate, bazę danych, routing, widok, pamięć podręczną, kolejkę, pocztę, system plików, Tracy, integrację Composer i zachowanie scalania pakietów. |
| `core/bootstrap.php` | Bootstrap w czasie wykonywania: automatyczne ładowanie Composer, ładowanie pamięci podręcznej `.env`, definicje niestandardowe, definicje rdzenia, sesje, starsze wersje i zabezpieczenia. |
| `core/config/` | Konfiguracja środowiska uruchomieniowego dla aplikacji, pamięci podręcznej, bazy danych, systemów plików, rejestrowania, sesji, Tracy, widoków, ikon, migracji i okablowania obserwatorów. |
| `core/custom/` | Warstwa zastępcza projektu dla przykładów środowisk, niestandardowych wymagań Composer, oprogramowania pośredniego, definicji i tras. |
| `core/database/` | Migracje, moduły początkowe i artefakty bazy danych. |
| `core/factory/` | Listy środowiska wykonawczego na poziomie fabrycznym, takie jak ustawienia i działania menedżera. |
| `core/functions/` | Pomocnicy funkcji współdzielonych. |
| `core/includes/` | Zgodność obejmuje pliki i środowisko wykonawcze. |
| `core/lang/` | Podstawowe pliki językowe. |
| `core/modifiers/` | Obsługa parsera/modyfikatora. |
| `core/storage/` | Wygenerowano pamięć podręczną i pamięć podręczną środowiska uruchomieniowego. |
| `core/tests/` | Aktualny zakres testów szkodników/PHPUnit w zakresie instalacji, menedżera, rdzenia, narzędzi wsparcia, pakietu/środowiska wykonawczego i zachowania zgodności. |

## Warstwy źródłowe

`core/src/` to bieżąca warstwa źródłowa PHP.

| Warstwa | Odpowiedzialność |
| --- | --- |
| `Core.php` | Centralny obiekt wykonawczy do konfiguracji, wykonywania parsera, pamięci podręcznej, zdarzeń, ładowania dokumentów i interfejsów API zgodności. |
| `Parser.php` | Renderowanie dokumentów zorientowane na parser i przepływ zgodności. |
| `UrlProcessor.php` | Generowanie adresów URL i przyjazne rozwiązywanie adresów URL. |
| `Bootstrap/` | Pomocnicy środowiska i ładowania początkowego. |
| `Console/` | Polecenia Artisan dotyczące pamięci podręcznej, widoków, pakietów, ustawień wstępnych, tras, planowania, aktualizacji witryn, tłumaczeń, aktualizacji drzewa i zadań systemowych. |
| `Controllers/` | Kontrolery stron Manager i ekrany zasobów/użytkowników/systemów. |
| `Events/` | Zajęcia z obsługi wydarzeń. |
| `Exceptions/` | Klasy wyjątków środowiska wykonawczego. |
| `Extensions/` | Zajęcia wspomagające rozszerzenie. |
| `Facades/` | Akcesory w stylu Laravel dla usług współdzielonych. |
| `Interfaces/` | Kontrakty na motywy menedżerskie i abstrakcje środowiska wykonawczego. |
| `Legacy/` | Warstwa zgodności dla starszych interfejsów API i zachowania analizatora składni. |
| `Middleware/` | Oprogramowanie pośredniczące protokołu HTTP i menedżera. |
| `Models/` | Wymowne modele zasobów, elementów, użytkowników, uprawnień, ustawień, zdarzeń, stanu harmonogramu/procesu roboczego i danych drzewa. |
| `Observers/` | Modelowanie okablowania obserwatora. |
| `Providers/` | Dostawcy usług w zakresie autoryzacji, Blade, Composer, konfiguracji, bazy danych, zdarzeń, systemu plików, motywu menedżera, pakietów, routingu, sesji, zadań, Tracy, obsługi adresów URL i innych. |
| `Services/` | Przepływy usług wyższego poziomu, w tym usługi sklepu/pakietu i zadań systemowych. |
| `Support/` | Zajęcia użytkowe i pomocnicy wspierający. |
| `Tracy/` | Integracja panelu debugowania. |
| `Traits/` | Wspólne cechy modeli i zachowania w czasie wykonywania. |

## Manager Środowisko wykonawcze

`manager/` to interfejs menedżera i powierzchnia akcji.| Ścieżka | Odpowiedzialność |
| --- | --- |
| `manager/actions/` | Starsze i dynamiczne procedury obsługi akcji menedżera. |
| `manager/processors/` | Zapisz/usuń/publikuj/buforuj/ustaw procesory, które mutują dane menedżera. |
| `manager/views/` | Widoki Blade dla stron menedżera, części, ekranów ustawień, zasobów, modułów, użytkowników i ramek. |
| `manager/includes/` | Manager kontrola dostępu, sprawdzanie konfiguracji, dołączanie analizatora składni, nagłówki, pomoce debugowania i starsze funkcje włączania granic. |
| `manager/media/` | Manager CSS, JS, obrazy, zasoby przeglądarki i multimedia tematyczne. |

Dokumentując zachowanie menedżera, sprawdź poprawność zarówno klasy kontrolera/źródła, jak i
widok menedżera lub procesor, który faktycznie wykonuje akcję.

## Modele i elementy

Podstawowe treści i koncepcje elementów są odwzorowywane na modele Eloquent:

| Koncepcja | Modelka |
| --- | --- |
| Resource / węzeł drzewa dokumentów | `SiteContent` |
| Szablon | `SiteTemplate` |
| Template Variable | `SiteTmplvar` |
| QQPL0047Relacja QQ-szablon | `SiteTmplvarTemplate` |
| Wartość TV w zasobie | `SiteTmplvarContentvalue` |
| Chunk | `SiteHtmlsnippet` |
| Snippet | `SiteSnippet` |
| Plugin | `SitePlugin` |
| Plugin-relacja zdarzenia | `SitePluginEvent` |
| Nazwa wydarzenia | `SystemEventname` |
| Module | `SiteModule` |
| Ustawienia | `SystemSetting` |
| Użytkownik Manager | `User` i `UserAttribute` |
| Uprawnienia i grupy | `Permissions`, `UserRole`, `DocumentGroup`, `DocumentgroupName` i powiązane modele grupowe |

Szczegółowa dokumentacja modelu pole po polu znajduje się na stronach API/referencje, a nie
w tym przeglądzie struktury.

## Pakiet i granice Extra

Dokumentacja produktu Evolution CMS opisuje wspólne umowy dotyczące środowiska wykonawczego i rozszerzeń.
Zainstalowane Extras posiadają własne podręczniki funkcji. W dDocs dokumentacja pakietu to
odczytany z katalogu głównego dokumentacji systemu plików każdego zainstalowanego pakietu i pokazany obok
drzewo produktów.

Udokumentuj Extra w tym drzewie produktów tylko wtedy, gdy strona wyjaśnia udostępnienie
Umowa pakietu Evolution CMS, zachowanie instalatora lub reguła integracji menedżera.

## Granica instalatora

Instalator autonomiczny to podstawowy bieżący proces instalacji. Jest właścicielem `evo
install`, `evo samodzielna instalacja`, `evo samoczynna aktualizacja`, and `evo status systemu`.

Folder `install/` repozytorium pozostaje ważny dla kompatybilności,
konserwację, fragmenty instalacji i debugowanie, ale nową dokumentację instalacyjną dostępną dla użytkownika
należy rozpocząć od samodzielnego instalatora.

## Powierzchnie testowe

Aktualne testy działają pod `core/tests/` i obejmują:

- zachowanie podczas instalacji i migracji;
- umowy interfejsu menedżera i zachowanie dostępu;
- polecenia aktualizacji pamięci podręcznej i witryny;
- wsparcie mediów i normalizacja ścieżek;
- zachowanie zgodności ze starszymi interfejsami API;
- przepływy zadań pakietu/sklepu/systemu.

Gdy strona dokumentacji opisuje zachowanie środowiska wykonawczego, preferuj bieżący kod
path plus istniejący test jako walidacja. Jeżeli nie ma żadnego testu, należy udokumentować roszczenie
zachowawczo i oznacz głębszą walidację jako pracę następczą.
