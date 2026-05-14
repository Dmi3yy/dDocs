# Odniesienie do tagów analizatora składni

[Wstecz](blade-and-template-rendering.md) / [W górę](../README.md) / [Dalej](models.md)

Klasyczne szablony Evolution CMS używają znaczników parsera dla zasobów, ustawień,
fragmenty, fragmenty, elementy zastępcze, adresy URL i treść warunkowa. Ta strona nagrywa
bieżącą podstawową powierzchnię znacznika, aby przykłady pozostały spójne.

## Standardowe tagi

| Oznacz | Znaczenie | Przykład |
| --- | --- | --- |
| `[*field*]` | Bieżące pole zasobu lub Template Variable. | `[*pagetitle*]` |
| `[(setting)]` | Ustawienie systemowe lub wartość konfiguracji środowiska wykonawczego. | `[(site_name)]` |
| `{{chunk}}` | Zawartość Chunk. | `{{site_header}}` |
| `{{chunk?&name=`wartość`}}` | Chunk z parametrami lokalnymi. | `{{card?&title=`Witajcie`}}` |
| `[[snippet]]` | Wywołanie fragmentu z pamięci podręcznej. | `[[DocLister]]` |
| `[!snippet!]` | Niebuforowane wywołanie fragmentu. | `[!contactForm!]` |
| `[+placeholder+]` | Wartość zastępcza z zakresu analizatora. | `[+title+]` |
| `[~id~]` | Adres URL Resource. | `[~1~]` |
| `[^key^]` | Styl środowiska wykonawczego/meta symboli zastępczych używany do czyszczenia i ścieżek ucieczki. | `[^q^]` |

Podczas dokumentowania używaj chronionych przykładów z etykietami językowymi `html` lub `blade`
kod szablonu w Markdown.

## Pola Resource i TVs

Tagi Resource najpierw odczytują bieżący obiekt dokumentu. Potrafią też czytać
Template Variables, gdy dla zasobu ładowane są wartości TV.```html
<h1>[*pagetitle*]</h1>
<p>[*introtext*]</p>
<img src="[*hero_image*]" alt="">
```Parser obsługuje także wyszukiwanie kontekstu za pomocą `@` w znacznikach zasobów. Aktualny
obsługa kontekstu obejmuje element nadrzędny, ostateczny element nadrzędny, wyszukiwanie aliasów, poprzedni/następny
wyszukiwanie rodzeństwa i bezpośrednie wyszukiwanie identyfikatora zasobu.```html
[*pagetitle@parent*]
[*pagetitle@uparent(0)*]
[*pagetitle@alias(home)*]
```

## Ustawienia systemowe

Tagi ustawień odczytują konfigurację środowiska wykonawczego i znane wartości ścieżki/adresu URL.```html
<title>[(site_name)]</title>
<base href="[(site_url)]">
```Często generowane wartości obejmują `base_url`, `base_path`, `site_url`,
`valid_hostnames`, `site_manager_url` i `site_manager_path`.

##Chunks

Chunks to szablony wielokrotnego użytku. Parametry przekazywane do fragmentu są dostępne jako
lokalne symbole zastępcze podczas analizowania fragmentów.```html
{{button?&label=`Read more`&url=`[~12~]`}}
```Dane wyjściowe Chunk mogą zawierać elementy zastępcze, znaczniki zasobów, ustawienia, inne fragmenty,
i tagi warunkowe. Parser rekurencyjnie rozwiązuje zagnieżdżoną treść, aż do momentu
osiągnięto skonfigurowane limity przepustowości analizatora składni.

##Snippets

Fragmenty kodu w pamięci podręcznej korzystają z `[[...]]`. Fragmenty kodu niezapisane w pamięci podręcznej korzystają z `[!...!]` i są konwertowane
do znaczników fragmentów podczas przetwarzania danych wyjściowych po analizie.```html
[[menuBuilder?&startId=`0`]]
[!contactForm?&redirectTo=`15`!]
```Parametry Snippet są analizowane przed wykonaniem. Zachowaj jawne wartości parametrów
i unikaj polegania na nieudokumentowanym stanie globalnym.

## Elementy zastępcze

Symbole zastępcze są rozpoznawane na podstawie bieżącego zakresu symboli zastępczych analizatora lub lokalnego
dane przekazywane do wywołania fragmentu/parsera.```html
<article>
  <h2>[+title+]</h2>
  <p>[+summary+]</p>
</article>
```Symbole zastępcze mogą używać modyfikatorów. Modyfikatory są częścią klasycznego parsera
powierzchni i powinny być udokumentowane cechą od nich zależną.

## Tagi URL

Tagi URL są przepisywane podczas przetwarzania danych wyjściowych.```html
<a href="[~1~]">Home</a>
```Wyjście adresu URL zależy od stanu publikacji zasobu, ustawień przyjaznego adresu URL,
aliasy, sufiksy, podstawowy adres URL i procesor adresu URL.

## Tagi warunkowe

Tagi warunkowe są włączane poprzez ustawienie `enable_at_syntax`. Aktualny
podstawowa składnia wykorzystuje wielkie litery:

```html
<@IF:[*published*]>
  Published
<@ELSE>
  Draft
<@ENDIF>
```Parser normalizuje również stare formularze komentarzy HTML, takie jak `<!--@IF ...-->`,
`<!--@ELSE-->` i `<!--@ENDIF-->`.

## Powiązania i tryby szablonów wbudowanych

Pomocnicy szablonów analizatora rozpoznają tryby specjalne:

| Tryb | Znaczenie |
| --- | --- |
| `@CODE` / `@INLINE` / `@TPL` | Użyj wbudowanego kodu szablonu. |
| `@FILE` | Załaduj kod szablonu z pliku pod skonfigurowaną ścieżką szablonu. |
| `@DOCUMENT` / `@DOC` | Załaduj zawartość z bieżącego lub wybranego zasobu. |
| `@B_FILE` | Renderuj plik Blade. |
| `@B_CODE` | Renderuj wbudowany kod Blade poprzez wygenerowaną pamięć podręczną. |
| `@T_CODE` / `@T_FILE` | Zarezerwowane tryby szablonów w obsłudze parsera. |

Zobacz [Blade i odniesienie do renderowania szablonów](blade-and-template-rendering.md)
dla zachowania specyficznego dla Blade.

## Sprzątanie i ucieczka

Przepływ wyjściowy może:

- uruchamiaj fragmenty niezapisane w pamięci podręcznej podczas analizy końcowej;
- wstrzyknąć zarejestrowane skrypty startowe przed `</head>`;
- wstrzyknąć zarejestrowane skrypty przed `</body>`;
- wyczyść nieużywane znaczniki Evolution;
- przepisz tagi URL na końcowe adresy URL.

`getTagsForEscape()` zawiera standardowe pary znaczników, takie jak `{{ }}`, `[[ ]]`,
`[! !]`, `[* *]`, `[( )]`, `[+ +]`, `[~ ~]` i `[^ ^]`.

## Zasada dokumentacji

Pisząc przykłady, używaj najmniejszej powierzchni znacznika, która wyjaśnia zadanie. Dla
nowe projekty korzystające z szablonów Blade, preferuj przykłady Blade i linkuj tylko tutaj
gdy wymagane są klasyczne tagi parsera.
