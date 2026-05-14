# Перелік джерел

[Назад](../01-getting-started/installation.md) / [Вгору](../README.md) / [Далі](documentation-navigation.md)

Ця сторінка фіксує поточні source surfaces, з яких має будуватися
документація продукту Evolution CMS.

## Поточні джерела коду

| Поверхня | Використання в документації |
| --- | --- |
| Evolution root | Файли входу проекту, кореневі метадані Composer, публічний `index.php`, sample config і project-level README. |
| `core/` | Завантажувальна програма, середовище виконання Composer, конфігурація, кеш середовища, міграції бази даних, засівки, тести, сховище та точка входу Artisan. |
| `core/src/` | Основні служби, парсер, постачальники, моделі, контролери, проміжне програмне забезпечення, фасади, застарілі адаптери, класи підтримки та команди консолі. |
| `manager/` | Manager точка входу, маршрутизація дій, перегляди, процесори, включення, медіа та поведінка інтерфейсу користувача менеджера. |
| `install/` | Застарілий веб-інсталятор, сценарій встановлення CLI, ресурси встановлення, функції налаштування та заглушки встановлення. |
| `assets/` | Збірні модулі, плагіни, фрагменти, ресурси менеджера та ресурси під час встановлення. |
| `views/` | Заповнювачі рівня публічного перегляду проекту. |
| Пакет автономного інсталятора | Поточний рекомендований порядок встановлення та поведінка команд `evo`. |
| Installed Extras | Package-level docs виявляються окремо через dDocs і не мають дублюватися тут. |
| Old docs archive | Тільки legacy reference material після перевірки за поточним кодом. |
| Перевірені рекомендації | Майбутні рецепти лише після перевірки поточного коду. |

## Поточні сигнали часу виконання

| Сигнал | Примітки |
| --- | --- |
| PHP baseline | Поточне ядро ​​та інсталятор потребують PHP `^8.3`. |
| Framework layer | Core використовує компоненти Illuminate 12 і поверхні Symfony Console/Process. |
| Manager routing | Manager запитує маршрут через один обробник дій та ідентифікатори дій. |
| Console layer | Core надає Artisan commands для cache, views, packages, presets, routes, scheduling, site updates, translations, tree updates, migrations, seeders, Tailwind і system tasks. |
| Data layer | Core має Eloquent models для resources, elements, users, permissions, settings, event logs, scheduler/worker state і closure-table tree data. |
| Tests | Поточне ядро ​​має тести Pest для встановлення, керування, оновлення, системних завдань, утиліт підтримки та поведінки сумісності. |

## Backlog покриття документації

Поточний baseline охоплює вимоги, installer-first встановлення, довідник
installer CLI, основні поняття, базові робочі процеси Manager, структуру
проекту, карти reference для розробників, configuration/runtime bootstrap,
Core Composer, legacy compatibility, Artisan-команди встановленого проекту,
system settings/defaults, roles and permissions, Blade/template rendering,
classic parser tags, два перевірені рецепти, source policy, navigation rules і
first-line troubleshooting.

| Gap | Запланована public page |
| --- | --- |
| Повна класика API і DB API | `06-api-and-integrations/` і `10-reference/` після перевірки на рівні методу |
| Довідка щодо налаштувань інтерфейсу користувача по полях | Розширте [Довідник із параметрів системи](system-settings.md) після перевірки кожної мітки вкладки менеджера та збережіть процесор |
| Контракти корисного навантаження подій | Розширення [Посилання на події](events.md) після перевірки кожного сайту виклику `invokeEvent` |
| Навігація по документації | [Навігація документацією](documentation-navigation.md) |
| Більше найкращих рецептів | `08-tutorials-recipes/` після перевірки поточного коду |
| Локалізації | Тримати локалізовані копії синхронізованими з перевіреним EN baseline |
