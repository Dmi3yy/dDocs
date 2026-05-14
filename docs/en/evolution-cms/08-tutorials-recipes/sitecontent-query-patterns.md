# SiteContent Query Patterns

[Back](forms-with-custom-routes.md) / [Up](README.md) / [Next](../10-reference/models.md)

`SiteContent` is the current model for resources in the document tree. It can be
used with Eloquent query scopes for published resources, Template Variables,
tree data, tags, and date ordering.

## Query Active Resources

```php
use EvolutionCMS\Models\SiteContent;

$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->orderBy('menuindex')
    ->get();
```

`active()` filters to published and not-deleted resources.

## Select Template Variable Values

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->where('parent', 0)
    ->orderBy('pagetitle')
    ->get();
```

`withTVs()` joins TV values by TV name and selects them into the result. Use this
for small and medium result sets where the joined fields are useful directly in
the query.

## Filter And Sort By TVs

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->tvFilter('tv:price:>:150:UNSIGNED;tv:brand:!null;')
    ->tvOrderBy('price asc UNSIGNED, brand asc')
    ->get();
```

TV filters support operators such as equality, comparison, `in`, `not_in`,
`like`, `like-r`, `like-l`, `null`, and `!null`. Numeric casts can be used for
numeric comparisons. SQLite numeric casts are normalized to `INTEGER`.

## Include TV Defaults

Use the `:d` marker when a query should fall back to the TV `default_text` value.

```php
$resources = SiteContent::query()
    ->withTVs(['price:d', 'brand'])
    ->active()
    ->tvFilter('tvd:price:>:150:UNSIGNED;')
    ->tvOrderBy('price:d asc UNSIGNED')
    ->get();
```

## Load TV Lists After A Query

For larger result sets, query resources first and then attach selected TV values:

```php
$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->get();

$rows = SiteContent::tvList($resources, ['price', 'brand']);
```

`tvList()` returns array rows with a `tvs` entry. Missing values are filled from
TV defaults when available.

## Query Tree Data

```php
$tree = SiteContent::query()
    ->GetRootTree(2)
    ->withTVs(['subtitle'], ':', true)
    ->get()
    ->toTree()
    ->toArray();
```

For a specific branch:

```php
$branch = SiteContent::descendantsOf(2)
    ->withTVs(['subtitle'])
    ->get()
    ->toTree()
    ->toArray();
```

Use tree queries when the hierarchy matters. Use flat queries when you only need
filtered rows.

## Tags And Date Ordering

```php
$resources = SiteContent::query()
    ->where('parent', 1)
    ->active()
    ->tagsData('17:5,7,8')
    ->orderByDate()
    ->get();
```

`orderByDate()` sorts by publish date when available and falls back to creation
date. `tagsData()` joins tag data for a selected TV/tag set.

## Validation Checklist

- Use `active()` when unpublished/deleted resources should not appear.
- Use `withoutProtected()` when access rules matter.
- Use `withTVs()` before `tvFilter()` or `tvOrderBy()` for those TV names.
- Use TV defaults deliberately with `:d` and `tvd`.
- Test SQLite and MySQL behavior when using numeric casts.
- Prefer package docs for package-specific query helpers.
