# Wzorce zapytań o treść witryny

[Wstecz](forms-with-custom-routes.md) / [W górę](README.md) / [Dalej](../10-reference/models.md)

`SiteContent` to bieżący model zasobów w drzewie dokumentów. To może być
używany z zakresami zapytań Eloquent dla opublikowanych zasobów, Template Variables,
dane drzewa, znaczniki i kolejność dat.

## Zapytanie o aktywne Resources

```php
use EvolutionCMS\Models\SiteContent;

$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->orderBy('menuindex')
    ->get();
```

Filtry `active()` do opublikowanych i nieusuniętych zasobów.

## Wybierz wartości Template Variable

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->where('parent', 0)
    ->orderBy('pagetitle')
    ->get();
`

```

withTVs()` łączy wartości TV według nazwy TV i wybiera je do wyniku. Użyj tego
dla małych i średnich zestawów wyników, w których połączone pola są bezpośrednio przydatne
zapytanie.

## Filtruj i sortuj według TVs

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->tvFilter('tv:price:>:150:UNSIGNED;tv:brand:!null;')
    ->tvOrderBy('price asc UNSIGNED, brand asc')
    ->get();
```

Filtry TV obsługują operatory takie jak równość, porównanie, `in`, `not_in`,
`like`, `like-r`, `like-l`, `null` i `!null`. Można stosować rzutowania numeryczne
porównania numeryczne. Rzuty numeryczne SQLite są znormalizowane do `INTEGER`.

## Dołącz wartości domyślne TV

Użyj znacznika `:d`, gdy zapytanie powinno wracać do wartości TV `default_text`.

```php
$resources = SiteContent::query()
    ->withTVs(['price:d', 'brand'])
    ->active()
    ->tvFilter('tvd:price:>:150:UNSIGNED;')
    ->tvOrderBy('price:d asc UNSIGNED')
    ->get();
```

## Załaduj listy TV po zapytaniu

W przypadku większych zestawów wyników najpierw wykonaj zapytanie o zasoby, a następnie dołącz wybrane wartości TV:

```php
$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->get();

$rows = SiteContent::tvList($resources, ['price', 'brand']);
`

```

tvList()` zwraca wiersze tablicy z wpisem `tvs`. Brakujące wartości są uzupełniane z
TV jest domyślny, jeśli jest dostępny.

## Zapytanie o dane drzewa

```php
$tree = SiteContent::query()
    ->GetRootTree(2)
    ->withTVs(['subtitle'], ':', true)
    ->get()
    ->toTree()
    ->toArray();
```

Dla konkretnego oddziału:

```php
$branch = SiteContent::descendantsOf(2)
    ->withTVs(['subtitle'])
    ->get()
    ->toTree()
    ->toArray();
```

Używaj zapytań do drzewa, gdy hierarchia ma znaczenie. Używaj zapytań płaskich tylko wtedy, gdy potrzebujesz
filtrowane wiersze.

## Zamawianie tagów i daty

```php
$resources = SiteContent::query()
    ->where('parent', 1)
    ->active()
    ->tagsData('17:5,7,8')
    ->orderByDate()
    ->get();
`

```

orderByDate()` sortuje według daty publikacji, jeśli jest dostępna, i wraca do tworzenia
data. `tagsData()` łączy dane znacznika dla wybranego TV/zestawu znaczników.

## Lista kontrolna walidacji

- Użyj `active()`, gdy niepublikowane/usunięte zasoby nie powinny się pojawiać.
- Użyj `withoutProtected()`, gdy zasady dostępu mają znaczenie.
- Użyj `withTVs()` przed `tvFilter()` lub `tvOrderBy()` dla tych nazw TV.
- Celowo używaj ustawień domyślnych TV z `:d` i `tvd`.
- Przetestuj zachowanie SQLite i MySQL podczas korzystania z rzutowania numerycznego.
- Preferuj dokumenty pakietu dla pomocników zapytań specyficznych dla pakietu.
