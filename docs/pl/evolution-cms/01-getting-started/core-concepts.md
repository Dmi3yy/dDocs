# Podstawowe koncepcje

[Wstecz](installation.md) / [W górę](README.md) / [Dalej](../07-security-updates-operations/troubleshooting.md)

Ta strona definiuje słownictwo używane w bieżącym produkcie Evolution CMS
dokumentacja. Jest to krótka mapa koncepcyjna, a nie odniesienie do API.

## Główne warunki

| Termin | Znaczenie | Bieżąca powierzchnia kodu |
| --- | --- | --- |
| Manager | Uwierzytelniony interfejs administracyjny używany do edycji treści, elementów, ustawień, użytkowników, pakietów i modułów menedżera. | Kontrolery i widoki Manager w środowisku wykonawczym menedżera. |
| Resource | Element treści przechowywany w drzewie serwisu. Zasób może reprezentować stronę, węzeł podobny do folderu, łącze lub inny typ zawartości, w zależności od jego pól. | `EvolutionCMS\Models\SiteContent` i tabela `site_content`. |
| Drzewo dokumentów | Hierarchiczne spojrzenie na zasoby. Stan nadrzędny, podrzędny, zamówienie, opublikowany, usunięty i widoczność wpływają na wygląd zasobu. | `SiteContent` Relacje rodzic/dziecko i tabela zamknięcia. |
| Szablon | Układ/struktura treści przypisana do zasobów. Szablony można podłączyć do Template Variables. | `EvolutionCMS\Models\SiteTemplate`. |
| Template Variable | Niestandardowa definicja pola, którą można dołączyć do szablonów i zapisać dla każdego zasobu. | `SiteTmplvar`, `SiteTmplvarTemplate` i `SiteTmplvarContentvalue`. |
| Chunk | Tekst lub element znacznika wielokrotnego użytku. Chunks są zwykle używane w przypadku powtarzających się fragmentów układu lub małych bloków wyjściowych wielokrotnego użytku. | `EvolutionCMS\Models\SiteHtmlsnippet`. |
| Snippet | Element oparty na PHP, który może uruchamiać logikę i zwracać dane wyjściowe z szablonów, porcji lub zawartości zasobów. | `EvolutionCMS\Models\SiteSnippet`. |
| Plugin | Sterowany zdarzeniami kod PHP połączony z jednym lub większą liczbą zdarzeń systemowych. Plugins reaguje na zdarzenia związane z cyklem życia menedżera, parsera, pamięci podręcznej, dokumentu i rozszerzenia. | `EvolutionCMS\Models\SitePlugin` i `SitePluginEvent`. |
| Wydarzenie | Nazwany hak wywoływany przez środowisko wykonawcze. Zdarzenia zapisywane są pod nazwami i łączone z wtyczkami z priorytetem. | `EvolutionCMS\Models\SystemEventname` i `evo()->invokeEvent(...)`. |
| Module | Narzędzie lub powierzchnia aplikacji po stronie menedżera. Modules można uruchomić z menedżera i może należeć do pakietów. | `EvolutionCMS\Models\SiteModule`. |
| Pakiet | Pakiet kodu rozpowszechniany za pomocą Composer, który może udostępniać usługi, widoki, trasy, konfigurację, zasoby, moduły i dokumentację. | Pakiety Composer plus polecenia/usługi pakietu Evolution. |
| Extra | Opcjonalny pakiet lub rozszerzenie instalowane w projekcie. Extras posiada własną dokumentację pakietu w dDocs. | Zainstalowane źródła pakietów indeksowane przez dDocs. |
| Pamięć podręczna | Wygenerowane dane środowiska wykonawczego używane przez parser, menedżer, widoki, metadane pakietu i ustawienia. Pamięć podręczną można wyczyścić w menedżerze lub konsoli. | `evo()->clearCache('full')`, `cache:clear-full` i odświeżenie witryny. |

## Jak one do siebie pasują

Typowa strona zaczyna się jako zasób w drzewie dokumentów. Zasób wybiera a
Szablon. Szablon może udostępnić Template Variables dla pól strukturalnych.
Szablony, Chunks i Snippets mogą tworzyć dane wyjściowe. Plugins słuchaj zdarzeń
wydłużyć zachowanie w czasie wykonywania. Modules zapewnia narzędzia po stronie menedżera dla większych przepływów pracy.

```text
Resource -> Template -> TV values
         -> Chunks and Snippets
         -> Plugins through Events
         -> Cache and rendered output
```

## Dokumentacja produktu i dokumentacja pakietu

Dokumentacja produktu Evolution CMS wyjaśnia podstawowe koncepcje produktu, menedżerze
zachowanie, architektura środowiska wykonawczego, interfejsy API, operacje i granice aktualizacji.

Zainstalowane Extras są udokumentowane w osobnych pakietach. dDocs odczytuje te pakiety
docs z systemu plików i wyświetla je obok dokumentacji produktu. Zrób
nie kopiuj pełnych podręczników Extra do tego drzewa produktów, chyba że strona wyjaśnia
podstawowa umowa integracyjna wspólna dla wszystkich pakietów.

## Starsze granice

Evolution CMS nadal zawiera powierzchnie kompatybilności dla starszego kodu i starego
przepływy instalacji. Aktualna dokumentacja powinna nazywać te powierzchnie tylko wtedy, gdy a
czytelnik musi zrozumieć zachowanie zgodności lub migracji. Nowe tutoriale
a przewodniki instruktażowe powinny zaczynać się od bieżącego instalatora, pakietu, menedżera i
Przepływy pracy oparte na Composer.
