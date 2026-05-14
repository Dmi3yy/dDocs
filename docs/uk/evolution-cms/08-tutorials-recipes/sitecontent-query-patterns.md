# Шаблони запитів вмісту сайту

[Назад](forms-with-custom-routes.md) / [Вгору](README.md) / [Далі](../10-reference/models.md)

`SiteContent` — поточна модель ресурсів у дереві документів. Це може бути
використовується з областями запитів Eloquent для опублікованих ресурсів, Template Variables,
дані дерева, теги та впорядкування дат.

## Запит активний Resources

```php
use EvolutionCMS\Models\SiteContent;

$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->orderBy('menuindex')
    ->get();
````active()` фільтрує опубліковані та невидалені ресурси.

## Виберіть значення Template Variable

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->where('parent', 0)
    ->orderBy('pagetitle')
    ->get();
````withTVs()` об’єднує значення TV за назвою TV і вибирає їх у результат. Використовуйте це
для малих і середніх наборів результатів, де об’єднані поля корисні безпосередньо
запит.

## Фільтрувати та сортувати за TVs

```php
$resources = SiteContent::query()
    ->withTVs(['price', 'brand'])
    ->active()
    ->tvFilter('tv:price:>:150:UNSIGNED;tv:brand:!null;')
    ->tvOrderBy('price asc UNSIGNED, brand asc')
    ->get();
```Фільтри TV підтримують такі оператори, як рівність, порівняння, `in`, `not_in`,
`like`, `like-r`, `like-l`, `null` і `!null`. Числові приведення можна використовувати для
числові порівняння. Числові приведення SQLite нормалізовано до `INTEGER`.

## Включити TV за замовчуванням

Використовуйте маркер `:d`, коли запит має повернутися до значення TV `default_text`.```php
$resources = SiteContent::query()
    ->withTVs(['price:d', 'brand'])
    ->active()
    ->tvFilter('tvd:price:>:150:UNSIGNED;')
    ->tvOrderBy('price:d asc UNSIGNED')
    ->get();
```

## Завантажувати списки TV після запиту

Для більших наборів результатів спочатку надішліть запит до ресурсів, а потім додайте вибрані значення TV:

```php
$resources = SiteContent::query()
    ->active()
    ->where('parent', 0)
    ->get();

$rows = SiteContent::tvList($resources, ['price', 'brand']);
````tvList()` повертає рядки масиву з записом `tvs`. Пропущені значення заповнюються з
TV за замовчуванням, якщо доступно.

## Дані дерева запитів

```php
$tree = SiteContent::query()
    ->GetRootTree(2)
    ->withTVs(['subtitle'], ':', true)
    ->get()
    ->toTree()
    ->toArray();
```Для конкретної гілки:

```php
$branch = SiteContent::descendantsOf(2)
    ->withTVs(['subtitle'])
    ->get()
    ->toTree()
    ->toArray();
```Використовуйте запити дерева, коли ієрархія має значення. Використовуйте плоскі запити лише тоді, коли вам це потрібно
відфільтрованих рядків.

## Теги та порядок дат

```php
$resources = SiteContent::query()
    ->where('parent', 1)
    ->active()
    ->tagsData('17:5,7,8')
    ->orderByDate()
    ->get();
````orderByDate()` сортує за датою публікації, якщо вона доступна, і повертається до створення
дата. `tagsData()` об’єднує дані тегів для вибраного набору TV/тегів.

## Контрольний список перевірки

- Використовуйте `active()`, коли неопубліковані/видалені ресурси не повинні з'являтися.
- Використовуйте `withoutProtected()`, коли правила доступу важливі.
- Використовуйте `withTVs()` перед `tvFilter()` або `tvOrderBy()` для цих імен TV.
- Навмисне використання стандартних значень TV з `:d` і `tvd`.
— Перевірте поведінку SQLite і MySQL під час використання числових приведення.
- Надавайте перевагу документам пакетів для помічників запитів щодо пакетів.
