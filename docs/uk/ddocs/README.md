# dDocs

dDocs - файловий браузер документації для менеджера Evolution CMS. Модуль
знаходить Markdown-документацію у встановлених пакетах, показує її деревом,
рендерить вибраний документ у правій панелі та дозволяє вести локальні нотатки
проєкту як звичайні файли.

Джерело правди - файлова система. Для документації пакетів dDocs не потребує
таблиць у базі даних.

## Можливості

- Знаходить документацію встановлених Evolution-пакетів.
- Показує дерево пакетів, папок і Markdown-документів.
- Враховує мову менеджера з fallback до English або нейтральних документів.
- Шукає за назвою, шляхом, назвою пакета і Markdown-вмістом.
- Безпечно рендерить GitHub-flavored Markdown у менеджері.
- Перехоплює відносні посилання між проіндексованими документами.
- Показує локальні зображення тільки з безпечних коренів документації.
- Зберігає проєктну документацію у `ProjectDocs/`.
- Кешує файловий індекс для швидшої навігації.

## Що читати першим

- [Гайд користувача](user-guide.md)
- [Гайд розробника](developer-guide.md)
- [Frontend Guide](frontend-guide.md)
- [Конфігурація](configuration.md)
- [Reference](reference.md)
- [Troubleshooting](troubleshooting.md)
- [Стандарти документації](documentation-standards.md)
- [Markdown example](markdown-example.md)

## Рендеринг Markdown

dDocs передає сирий Markdown у сторінку менеджера і рендерить його в браузері
через локальні assets dTui/TOAST UI. Підсвітка коду працює через локальний
Prism, включно з граматикою Evolution Blade.

dDocs також відповідає за безпеку viewer:

- HTML-блоки, схожі на scripts, прибираються перед передачею у viewer;
- відносні посилання документації мапляться на ідентифікатори документів dDocs;
- локальні зображення конвертуються тільки після перевірки safe roots;
- відсутні відносні посилання лишаються неактивними і не навігують iframe.

## Runtime Model

```text
Composer packages / local Evolution packages
        |
        v
DocsSourceRegistry
        |
        v
DocsIndexer
        |
        v
FileIndexCache
        |
        v
Livewire ModulePanel -> raw Markdown payload -> dTui/TOAST UI Viewer
                                           -> link/image post-processing
```

## Документація проєкту

Документи, створені з UI dDocs, зберігаються у `ProjectDocs/` всередині пакета
dDocs. Project docs доступні для запису, а vendor docs залишаються read-only.

Використовуйте project docs для:

- архітектурних нотаток;
- опису локального середовища;
- нотаток про deployment;
- рішень конкретного проєкту;
- робочого контексту AI/Codex.
