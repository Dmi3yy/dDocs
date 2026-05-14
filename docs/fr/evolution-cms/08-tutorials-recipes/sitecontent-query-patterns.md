# Modèles de requête SiteContent

[Retour](forms-with-custom-routes.md) / [Haut](README.md) / [Suivant](../10-reference/models.md)

`SiteContent` est le modèle actuel pour les ressources dans l'arborescence des documents. Cela peut être
utilisé avec les étendues de requête Eloquent pour les ressources publiées, Template Variables,
données d'arborescence, balises et ordre des dates.

## Requête active Resources

```php
use EvolutionCMS\Models\SiteContent;

$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->orderBy('menuindex')
    ->get();
````active()` filtre les ressources publiées et non supprimées.

## Sélectionnez les valeurs Template Variable

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->where('parent', 0)
    ->orderBy('pagetitle')
    ->get();
````withTVs()` rejoint les valeurs TV par le nom TV et les sélectionne dans le résultat. Utilisez ceci
pour les ensembles de résultats petits et moyens où les champs joints sont utiles directement dans
la requête.

## Filtrer et trier par TVs

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->tvFilter('tv:price:>:150:UNSIGNED;tv:brand:!null;')
    ->tvOrderBy('price asc UNSIGNED, brand asc')
    ->get();
```Les filtres TV prennent en charge les opérateurs tels que l'égalité, la comparaison, `in`, `not_in`,
`like`, `like-r`, `like-l`, `null` et `!null`. Les conversions numériques peuvent être utilisées pour
comparaisons numériques. Les conversions numériques SQLite sont normalisées en `INTEGER`.

## Inclure les valeurs par défaut de TV

Utilisez le marqueur `:d` lorsqu'une requête doit revenir à la valeur TV `default_text`.```php
$resources = SiteContent::query()
    ->withTVs(['price:d', 'brand'])
    ->active()
    ->tvFilter('tvd:price:>:150:UNSIGNED;')
    ->tvOrderBy('price:d asc UNSIGNED')
    ->get();
```

## Charger les listes TV après une requête

Pour des ensembles de résultats plus volumineux, interrogez d'abord les ressources, puis attachez les valeurs TV sélectionnées :

```php
$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->get();

$rows = SiteContent::tvList($resources, ['price', 'brand']);
````tvList()` renvoie les lignes du tableau avec une entrée `tvs`. Les valeurs manquantes sont remplies à partir de
TV est la valeur par défaut lorsqu'elle est disponible.

## Données de l'arbre de requête

```php
$tree = SiteContent::query()
    ->GetRootTree(2)
    ->withTVs(['subtitle'], ':', true)
    ->get()
    ->toTree()
    ->toArray();
```Pour une branche spécifique :

```php
$branch = SiteContent::descendantsOf(2)
    ->withTVs(['subtitle'])
    ->get()
    ->toTree()
    ->toArray();
```Utilisez des requêtes arborescentes lorsque la hiérarchie est importante. Utilisez des requêtes plates lorsque vous en avez seulement besoin
lignes filtrées.

## Tags et commande par date

```php
$resources = SiteContent::query()
    ->where('parent', 1)
    ->active()
    ->tagsData('17:5,7,8')
    ->orderByDate()
    ->get();
````orderByDate()` trie par date de publication lorsqu'il est disponible et revient à la création
date. `tagsData()` joint les données de balise pour un ensemble TV/tag sélectionné.

## Liste de contrôle de validation

- Utilisez `active()` lorsque les ressources non publiées/supprimées ne doivent pas apparaître.
- Utilisez `withoutProtected()` lorsque les règles d'accès sont importantes.
- Utilisez `withTVs()` avant `tvFilter()` ou `tvOrderBy()` pour ces noms TV.
- Utilisez délibérément les valeurs par défaut de TV avec `:d` et `tvd`.
- Testez le comportement de SQLite et MySQL lors de l'utilisation de conversions numériques.
- Préférez les documents du package pour les assistants de requête spécifiques au package.
