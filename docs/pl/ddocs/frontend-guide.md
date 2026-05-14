# Frontend guide

dDocs używa evo-ui dla powłoki managera oraz dTui/TOAST UI do renderowania
Markdown. To wewnętrzny frontend runtime, a nie publiczne frontend API dla
pakietów konsumenckich.

## Granica runtime

- `views/docs/shell.blade.php` odpowiada za dokument iframe managera, lokalne
  assety dTui, assety Prism i kod startowy viewer.
- `views/livewire/module-panel.blade.php` odpowiada za workspace dDocs, drzewo,
  listing folderów, nagłówek dokumentu i JSON payload dla viewer.
- `views/partials/tree-node.blade.php` odpowiada za rekurencyjne wiersze drzewa.
- dDocs renderuje Markdown w przeglądarce z JSON payload zamiast renderować HTML
  po stronie serwera.

## Granica evo-ui

dDocs powinien trzymać się konwencji wizualnych evo-ui dla ikon, kompaktowych
kontrolek managera, tokenów motywu, modali i formularzy ustawień. Workspace
drzewa/viewer jest obecnie lokalny dla dDocs, bo jest to specyficzny model
interakcji dokumentacji. Jeśli stanie się wielokrotnego użytku, należy wypromować
go przez zadanie evo-ui zamiast kopiować implementację do innego pakietu.

## UX bez górnych tabów

dDocs celowo nie używa standardowego górnego paska tabów modułu dla workspace
dokumentacji. Główna nawigacja to lewy panel źródeł/drzewa i prawy viewer
dokumentu. Przyszła standaryzacja WebUI tabów nie powinna wymuszać górnych tabów
w dDocs, chyba że moduł zyska kilka równorzędnych workspace wymagających
nawigacji tabami.

Ustawienia nadal są dostępne, ale są traktowane jako kompaktowa akcja workspace
dokumentu, a nie jako top-level tab modułu.

## Lokalny wyjątek stylowania evo-ui

dDocs może stosować scoped styles do wewnętrznych elementów formularzy evo-ui
tylko wewnątrz `.ddocs-settings`, gdy formularz ustawień jest osadzony w
workspace dokumentu. Wyjątek istnieje dlatego, że dDocs ukrywa zagnieżdżony
nagłówek/tabs formularza i układa sekcje jako część powierzchni czytnika.

Dozwolone lokalne wyjątki:

- `.ddocs-settings .evo-ui-form-*` tylko dla layoutu osadzonych ustawień;
- `.ddocs-search .evo-ui-input` tylko dla rozmiaru pola wyszukiwania w sidebar;
- `.ddocs-modal .evo-ui-btn--danger` tylko dla akcji potwierdzenia usunięcia;
- chrome edytora dTui/TOAST UI wewnątrz `.ddocs-editor`.

Nie styluj globalnych prymitywów evo-ui poza zakresem `.ddocs-*`. Jeśli inny
pakiet potrzebuje tego samego wzorca, utwórz zadanie evo-ui dla wspólnego
prymitywu albo wariantu zamiast kopiować CSS dDocs.

## Payload viewer

Viewer dokumentu otrzymuje:

```json
{
  "id": "document-node-id",
  "markdown": "# Document",
  "links": [],
  "images": [],
  "uml": []
}
```

Livewire odpowiada za wybór dokumentu i bezpieczne odczyty plików. Kod
przeglądarki odpowiada za renderowanie TOAST UI, chrome kopiowania kodu,
przechwytywanie linków wewnętrznych, bezpieczną zamianę lokalnych obrazów i
odzyskiwanie UML.

## Zmiany łamiące viewer

Traktuj te zmiany jako breaking changes dla viewer dDocs:

- kształt payload viewer;
- nazwy metod wyboru dokumentu Livewire;
- identyfikatory węzłów dokumentów;
- struktura map linków, obrazów i UML;
- zachowanie przycisku kopiowania kodu;
- przechwytywanie wewnętrznych linków Markdown;
- zachowanie bezpieczeństwa lokalnych obrazów.

## Reguły rozszerzania

- Trzymaj dokumentację pakietów jako pliki Markdown; nie dodawaj generowanej nawigacji HTML.
- Trzymaj linki względne wewnątrz drzewa docs pakietu.
- Trzymaj niestandardowe zachowanie viewer w dDocs, dopóki co najmniej dwa pakiety go nie potrzebują.
- Używaj tokenów evo-ui i istniejących komponentów ikon przed dodaniem lokalnego CSS.
- Dodawaj browser smoke checks przy zmianach boot viewer, kluczy Livewire albo dTui post-processing.
