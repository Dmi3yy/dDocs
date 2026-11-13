# Довідка з конфігурації

[Назад](source-inventory.md) / [Вгору](../README.md) / [Далі](core-composer.md)

Evolution CMS має два рівні конфігурації: файли проекту/виконання та база даних
налаштування системи. Спочатку завантажується конфігурація середовища виконання, а потім системні налаштування
завантажується потоками ядра та менеджера.

## Послідовність завантаження

| Крок | Поведінка під час виконання |
| --- | --- |
| Composer автозавантаження | `core/bootstrap.php` завантажує `core/vendor/autoload.php`. |
| Інсталювати позначку часу | `EVO_INSTALL_TIME` зчитується з `core.install`, якщо він присутній. |
| Завантажувач середовища | Завантажувач кешу середовища намагається завантажити значення `.env` за допомогою згенерованого кешу PHP. |
| Спеціальні визначення | `core/custom/define.php` завантажується за наявності. |
| Основні визначення | `core/includes/define.inc.php` визначає основні шляхи та константи. |
| Прапор сеансу | `EVO_SESSION` зчитується з env і за умовчанням увімкнено. |
| Проксі сеансу | Сумісність сеансу проводів `core/functions/session_proxy.php`. |
| Спадщина включає | `core/includes/legacy.inc.php` завантажує поведінку сумісності. |
| Захист | `core/includes/protect.inc.php` посилює прямий доступ. |
| Початок сесії | Manager/запити аналізатора запускають сеанс CMS, якщо вони не вимкнені контекстом. |

Бутстрап повинен залишатися толерантним. Якщо не вдається завантажити кеш середовища,
час виконання повертається до прямого завантаження Dotenv.

## Файли середовища

Порядок пошуку середовища:

1. `core/custom/.env`
2. `.env` у корені проекту

Файл кешу середовища:

```text
core/storage/cache/env.php
```Кеш дійсний, якщо час його модифікації є новим або дорівнює
вибраний файл `.env`. Якщо він застарілий, завантажувач аналізує `.env`, застосовує значення,
і атомарно записує новий кеш масиву PHP.

## Правила кешу середовища

| Правило | Поведінка |
| --- | --- |
| Незмінне навантаження | Існуючі значення в `$_ENV` або `$_SERVER` не перезаписуються. |
| Застаріла підтримка `getenv()` | `putenv()` викликається лише тоді, коли значення OS/env відсутнє. |
| Нульові значення | Видалено зі згенерованого кешу. |
| Порожні рядки | Збереглися як справжні цінності. |
| Запис кешу | Записує у тимчасовий файл із блокуванням, а потім перейменовує на місце. |
| Поведінка при відмові | Помилки ковтаються, і за можливості використовується пряме завантаження Dotenv. |

Очистіть кеш після зміни `.env` або кешованих значень конфігурації середовища виконання
за проектом.

## Основні файли конфігурації

| Файл | Відповідальність |
| --- | --- |
| `core/config/app.php` | Постачальники, псевдоніми, групи проміжного програмного забезпечення, локаль програми, резервна локаль. |
| `core/config/cache.php` | Зберігання кешу та поведінка кешу. |
| `core/config/database.php` | Менеджер бази даних і базова лінія Redis. |
| `core/config/database/default.php` | Конфігурація підключення до бази даних за замовчуванням. |
| `core/config/database/migrations.php` | Конфігурація репозиторію міграції. |
| `core/config/filesystems.php` | Диски файлової системи та корені сховища. |
| `core/config/logging.php` | Канали реєстрації та поведінка журналу. |
| `core/config/session.php` | Драйвер сеансу та параметри сеансу. |
| `core/config/tracy.php` | Інтеграція Tracy/debug. |
| `core/config/view.php` | Переглянути шляхи, скомпільований шлях Blade і конфігурацію зворотного виклику застарілої директиви. |
| `core/config/blade-icons.php` | Blade Конфігурація значків. |
| `core/config/cms/observers.php` | Електропроводка моделі спостерігача. |

## Конфігурація проєкту

Шість зразків із таблиці доступні у вихідному коді гілки `3.6.x` Evolution CMS.
В інсталяційному пакеті їх немає. Відкрийте потрібний зразок, скопіюйте його вміст
у файл за вказаним шляхом від кореня проєкту й замініть демонстраційні значення.
Якщо файл уже існує, додайте до нього лише потрібні параметри або код, зберігши
поточні налаштування.

| Зразок у гілці `3.6.x` | Файл у проєкті | Що змінити |
| --- | --- | --- |
| [`.env.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.example) | `core/custom/.env` | Вкажіть параметри підключення до вашої бази даних. За потреби додайте налаштування домену або менеджера. Якщо проєкт уже використовує кореневий `.env`, додайте параметри до нього. |
| [`.env.docker.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/.env.docker.example) | Наприклад, `core/custom/.env.docker` | Замініть демонстраційні `DB_USERNAME`, `DB_PASSWORD` і `DB_DATABASE`. У Docker Compose підключіть файл через `env_file` до сервісу CMS. Якщо база даних працює в іншому сервісі, задайте його ім’я як `DB_HOST`. CMS автоматично не завантажує `.env.docker`. |
| [`define.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/define.php.example) | `core/custom/define.php` | Зразок перелічує доступні константи в коментарі. Додайте виклики `define()` для потрібних перевизначень, наприклад `define('EVO_SITE_HOSTNAMES', 'example.com,www.example.com');`, і підставте домени свого сайту. |
| [`routes.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/routes.php.example) | `core/custom/routes.php` | Замініть демонстраційний маршрут `/helloworld` своїм шляхом і обробником. Посібник показує, як додати маршрут для форми. [Форми з власними маршрутами](../08-tutorials-recipes/forms-with-custom-routes.md) |
| [`ControllerNamespace.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings/ControllerNamespace.php.example) | `core/custom/config/cms/settings/ControllerNamespace.php` | Файл має повертати рядок із простором імен ваших контролерів із кінцевою зворотною скісною рискою. Вкажіть простір імен, у якому автозавантажується ваш `BaseController`. |
| [`settings.php.example`](https://github.com/evolution-cms/evolution/blob/3.6.x/core/custom/config/cms/settings.php.example) | `core/custom/config/cms/settings.php` | Поверніть масив лише з потрібними перевизначеннями. Наприклад, замініть значення `site_name` на назву вашого сайту. |

Зберігайте справжні паролі в локальних файлах середовища або передавайте їх через
середовище виконання. Не додавайте їх до Git.

Інші приклади в `core/custom/`: `composer.json.example` для залежностей проєкту та
`config/middleware.php.sample` для власних псевдонімів і груп проміжного програмного забезпечення.

### Створення файлів через консоль

Запустіть потрібну команду в Bash із кореня проєкту. Кожен блок самостійний і пропускає наявний файл. Після завантаження змініть демонстраційні значення за таблицею. Якщо проєкт уже використовує кореневий `.env`, додайте потрібні змінні до нього.

`.env`

```bash
(
  target=core/custom/.env
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/.env.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`.env.docker`

```bash
(
  target=core/custom/.env.docker
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/.env.docker.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`define.php`

```bash
(
  target=core/custom/define.php
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/define.php.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`routes.php`

```bash
(
  target=core/custom/routes.php
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/routes.php.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`ControllerNamespace.php`

```bash
(
  target=core/custom/config/cms/settings/ControllerNamespace.php
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/config/cms/settings/ControllerNamespace.php.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

`settings.php`

```bash
(
  target=core/custom/config/cms/settings.php
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/core/custom/config/cms/settings.php.example' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

Для роботи з агентом можна окремо завантажити `AGENTS.md` у корінь проєкту. Додайте до нього правила вашого проєкту. PHP-моделі ядра вже входять до інсталяційного пакета в `core/src/Models/`. [Довідка з моделей](models.md) · [Вихідний код моделей](https://github.com/evolution-cms/evolution/tree/3.6.x/core/src/Models)

```bash
(
  target=AGENTS.md
  [[ -e "$target" || -L "$target" ]] && exit 0
  mkdir -p "$(dirname "$target")" || exit 1
  sample=$(mktemp) || exit 1
  trap 'rm -f "$sample"' EXIT
  curl -fsSL 'https://raw.githubusercontent.com/evolution-cms/evolution/3.6.x/AGENTS.md' -o "$sample" || exit 1
  set -o noclobber
  cat "$sample" > "$target"
)
```

## Постачальники та псевдоніми

Список постачальників програм включає служби Iluminate, служби Evolution,
старі постачальники сумісності, менеджер/теми, маршрутизація/сеанс/система
постачальників завдань, постачальників Blade та постачальників послуг керування документами/користувачами.

Основні псевдоніми розкривають загальні фасади Illuminate, такі як `Artisan`, `Cache`, `DB`,
`Event`, `File`, `Log`, `Route`, `Session`, `Storage`, `View` та Evolution
фасади, такі як `ManagerTheme`, `UrlProcessor`, `TemplateProcessor`,
`DocumentManager`, `UserManager` і `Tailwind`.

## Групи проміжного програмного забезпечення

| Група | Поведінка |
| --- | --- |
| `mgr` | Сеанс, проксі-сервер сеансу, CSRF, авторизація менеджера, прив’язки маршрутів, помилки спільного перегляду. |
| `global` | Сеанс, проксі-сервер сеансу, прив’язки маршрутів, помилки спільного перегляду. |
| `aliases` | `csrf`, `authtoken`, `managerauth` і `bindings`. |

Замість цього додайте спеціальне проміжне програмне забезпечення через конфігурацію спеціального проміжного програмного забезпечення проекту
зміна списку основного проміжного програмного забезпечення.

## Межа параметрів системи

Файли конфігурації середовища виконання визначають структуру та поведінку початкового завантаження. CMS система
налаштування визначають поведінку сайту, що зберігається в базі даних, наприклад дружні URL-адреси,
шаблони, шляхи до файлового менеджера, параметри кешу за замовчуванням і параметри інтерфейсу користувача менеджера.

Використовуйте [Довідник із параметрів системи] (system-settings.md) для CMS із підтримкою бази даних
налаштування та цю сторінку для файлів конфігурації середовища виконання, середовища, провайдерів, псевдонімів,
і проміжне програмне забезпечення.
