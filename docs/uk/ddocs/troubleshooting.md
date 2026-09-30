# Troubleshooting

Цей гайд допомагає, коли dDocs не показує очікувану документацію.

## Документ не з'являється

1. Оновіть індекс у settings panel.
2. Перевірте, що package має `docs/`, legacy `Docs/`, `README.md` або
   `index.md`.
3. Перевірте, що extension є у `allowed_extensions`.
4. Перевірте, що file size нижчий за `max_file_size_kb`.
5. Перевірте manager language і fallback.

## Український документ не відкривається

1. Перевірте, що українські docs лежать у `docs/uk`.
2. Перемістіть legacy `docs/ua` content у `docs/uk`.
3. Оновіть індекс.
4. Перевірте, що `default_language` не форсить недоступну locale.

dDocs нормалізує legacy manager input `ua` до `uk`; `ua` не є public
documentation locale.

## Документ відкривається порожнім

1. Зробіть hard reload вкладки менеджера.
2. Перевірте browser console на помилки Livewire або dTui.
3. Оновіть індекс.
4. Перевірте, що файл читається і лежить всередині docs root.

## Локальне зображення заблоковане

1. Перемістіть image всередину package docs root.
2. Використовуйте relative Markdown image path.
3. Перевірте allowed extension.
4. Перевірте image size проти `max_file_size_kb`.

## UML не рендериться

1. Перевірте, що block використовує формат `$$uml`.
2. Перевірте, що configured renderer URL доступний.
3. Перевірте, що source не містить unsupported remote theme directives.

## Пошук працює повільно

Поточний search - filesystem live search. Metadata matches швидкі, але content
matches можуть читати Markdown files із диска.

1. Увімкніть `cache_index`.
2. Зменшіть oversized Markdown files.
3. Тримайте generated static-site output поза `docs/`.
4. Використовуйте `docs_old/` для legacy generated docs.
5. Для великих docs sets плануйте file-based `FileSearchIndexCache`.

## Пошук не знаходить content документа

1. Перевірте, що extension є в `allowed_extensions`.
2. Перевірте, що file size нижчий за `max_file_size_kb`.
3. Перевірте, що PHP може прочитати файл.
4. Перевірте, що файл лежить всередині indexed docs root.
5. Оновіть індекс після move або rename.

## Пошук знаходить старий content

1. Оновіть індекс.
2. За можливості зберігайте project documents через dDocs UI.
3. Перевірте, що результат не прийшов з іншого indexed package або locale.
4. Очистіть generated index cache, якщо filesystem metadata stale.

## Folder з'являється в search results

Folders повертаються, коли matched child document лежить всередині них. Сам
folder може не містити query. dDocs лишає parent folders видимими, щоб filtered
tree мав context.

## Large Markdown file не шукається

Files вище `max_file_size_kb` пропускаються safe reads. Розбийте файл або
підніміть project setting тільки для trusted documentation roots.

## Search повертає забагато результатів

Поточний search ще не має scoring, snippets або query syntax. Звужуйте query
через title/path terms. Filters `source:`, `path:`, `type:` і `lang:` належать
до search-index roadmap.

## Diagnostics недоступні

Diagnostics навмисно захищені. Потрібен manager account із settings permission
або debug mode у local environment.

## Документ проєкту не зберігається

1. Перевірте, що вибране джерело - Project Documentation.
2. Перевірте, що target path лежить у writable safe root.
3. Перевірте filesystem permissions.
4. Перейменуйте файл або папку, якщо filename normalization прибрала unsafe
   characters.

## Пошкоджений кеш індексу

Обірваний `ddocs-index.php` може містити незавершений PHP-вираз. dDocs
автоматично пропускає такий кеш і відновлює індекс із файлів документації.
Новий індекс записується через тимчасовий файл у тому самому каталозі та
замінює попередній лише після повного запису. Документи не змінюються.

Якщо проблема повторюється, перевірте вільне місце, права запису в каталог
кешу та повноту передавання файлів під час розгортання. Кеш індексу можна
перебудувати через «Оновити індекс» у налаштуваннях dDocs.
