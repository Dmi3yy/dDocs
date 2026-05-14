# SiteContent-Abfragemuster

[Zurück](forms-with-custom-routes.md) / [Nach oben](README.md) / [Weiter](../10-reference/models.md)

`SiteContent` ist das aktuelle Modell für Ressourcen im Dokumentenbaum. Es kann sein
Wird mit Eloquent-Abfragebereichen für veröffentlichte Ressourcen verwendet, Template Variables,
Baumdaten, Tags und Datumsreihenfolge.

## Abfrage aktiv Resources

```php
use EvolutionCMS\Models\SiteContent;

$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->orderBy('menuindex')
    ->get();
`

```

active()` filtert nach veröffentlichten und nicht gelöschten Ressourcen.

## Wählen Sie Template Variable-Werte aus

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->where('parent', 0)
    ->orderBy('pagetitle')
    ->get();
`

```

withTVs()` verknüpft TV-Werte nach TV-Namen und wählt sie im Ergebnis aus. Benutzen Sie dies
für kleine und mittlere Ergebnismengen, bei denen die verbundenen Felder direkt nützlich sind
die Abfrage.

## Filtern und sortieren nach TVs

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->tvFilter('tv:price:>:150:UNSIGNED;tv:brand:!null;')
    ->tvOrderBy('price asc UNSIGNED, brand asc')
    ->get();
```

TV-Filter unterstützen Operatoren wie Gleichheit, Vergleich, `in`, `not_in`,
`like`, `like-r`, `like-l`, `null` und `!null`. Numerische Umwandlungen können für verwendet werden
numerische Vergleiche. SQLite numerische Umwandlungen werden auf `INTEGER` normalisiert.

## TV-Standardwerte einschließen

Verwenden Sie die Markierung `:d`, wenn eine Abfrage auf den Wert TV `default_text` zurückgreifen soll.

```php
$resources = SiteContent::query()
    ->withTVs(['price:d', 'brand'])
    ->active()
    ->tvFilter('tvd:price:>:150:UNSIGNED;')
    ->tvOrderBy('price:d asc UNSIGNED')
    ->get();
```

## TV-Listen nach einer Abfrage laden

Für größere Ergebnismengen fragen Sie zuerst Ressourcen ab und hängen Sie dann ausgewählte TV-Werte an:

```php
$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->get();

$rows = SiteContent::tvList($resources, ['price', 'brand']);
`

```

tvList()` gibt Arrayzeilen mit einem `tvs`-Eintrag zurück. Fehlende Werte werden ausgefüllt
TV wird standardmäßig verwendet, sofern verfügbar.

## Baumdaten abfragen

```php
$tree = SiteContent::query()
    ->GetRootTree(2)
    ->withTVs(['subtitle'], ':', true)
    ->get()
    ->toTree()
    ->toArray();
```

Für eine bestimmte Branche:

```php
$branch = SiteContent::descendantsOf(2)
    ->withTVs(['subtitle'])
    ->get()
    ->toTree()
    ->toArray();
```

Verwenden Sie Baumabfragen, wenn die Hierarchie wichtig ist. Verwenden Sie flache Abfragen, wenn Sie sie nur benötigen
gefilterte Zeilen.

## Tags und Datumsbestellung

```php
$resources = SiteContent::query()
    ->where('parent', 1)
    ->active()
    ->tagsData('17:5,7,8')
    ->orderByDate()
    ->get();
`

```

orderByDate()` sortiert nach Veröffentlichungsdatum, sofern verfügbar, und greift auf die Erstellung zurück
Datum. `tagsData()` verbindet Tag-Daten für einen ausgewählten TV/Tag-Satz.

## Validierungscheckliste

– Verwenden Sie `active()`, wenn unveröffentlichte/gelöschte Ressourcen nicht angezeigt werden sollen.
- Verwenden Sie `withoutProtected()`, wenn Zugriffsregeln wichtig sind.
- Verwenden Sie `withTVs()` vor `tvFilter()` oder `tvOrderBy()` für diese TV-Namen.
- Verwenden Sie die Standardeinstellungen TV bewusst mit `:d` und `tvd`.
– Testen Sie das Verhalten von SQLite und MySQL bei der Verwendung numerischer Umwandlungen.
- Bevorzugen Sie Paketdokumente für paketspezifische Abfragehilfen.
