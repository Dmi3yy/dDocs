# API та інтеграції

[Evolution CMS](../README.md) / API та інтеграції

У цьому розділі зібрано поточні інтеграційні поверхні для розробників
Evolution CMS: основні API середовища виконання, моделі, події, дії менеджера, Artisan
команди, межі пакетів і рівні сумісності.

## Сторінок

| Сторінка | Призначення |
| --- | --- |
| [Посилання на моделі](../10-reference/models.md) | Поточна карта моделі Eloquent і групи відповідальності. |
| [Посилання на події](../10-reference/events.md) | Поточні поверхні подій/плагінів, згруповані за областю виконання. |
| [Довідка про параметри системи](../10-reference/system-settings.md) | Поточні заводські налаштування та вкладки налаштувань менеджера. |
| [Довідка про ролі та дозволи](../10-reference/roles-and-permissions.md) | Manager ролі, ключі дозволів, групи документів, веб-доступ, блокування та дозволи на файли. |
| [Довідка про виконання конфігурації](../10-reference/configuration-runtime.md) | Bootstrap, кеш середовища, конфігураційні файли, користувацькі заміни, постачальники, псевдоніми та проміжне програмне забезпечення. |
| [Довідка про ядро ​​Composer](../10-reference/core-composer.md) | Composer межі залежностей і автозавантаження. |
| [Довідка про сумісність із застарілими версіями](../10-reference/legacy-compatibility.md) | Застарілі служби, помічники, сумісність парсерів і сумісність дій менеджера. |
| [Довідник команд Artisan](../10-reference/artisan-commands.md) | Повна поверхня команд встановленого проекту, зареєстрована основним середовищем виконання. |
| [Blade і довідка про візуалізацію шаблонів](../10-reference/blade-and-template-rendering.md) | Візуалізація Blade, перегляди менеджера, директиви та директиви піктограм. |
| [Довідка про теги аналізатора](../10-reference/parser-tags.md) | Класичні теги аналізатора Evolution і порядок аналізатора. |
| [Дії Artisan і Manager](../10-reference/artisan-and-manager-actions.md) | Поточна панель пошуку команд і дій менеджера. |
| [Створити пакет](../05-extras-and-packages/create-package.md) | Сучасна package structure, service provider wiring, manager module pattern, EvoUI/Livewire surfaces, docs і release checks. |
| [Створити preset](../05-extras-and-packages/create-preset.md) | Ready-site scaffold structure для installer presets, required Extras, theme assets, custom project code і validation checks. |
| [Структура проекту](../04-development/project-structure.md) | Макет джерела за довідковими сторінками. |

## Сфера дії

Цей розділ є підтвердженою картою поточних поверхонь інтеграції. Рівень методу
класичні Core API, DB API, маршрутизація та посилання на бази даних по полях повинні
додавати як окремі довідкові сторінки лише після перевірки кожної заяви
поточний код.
