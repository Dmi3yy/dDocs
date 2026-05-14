# Довідка про події

[Назад](parser-tags.md) / [Вгору](../README.md) / [Далі](models.md)

Плагіни Evolution CMS прослуховують іменовані події. Поточний код викликає події з
ядро виконання, диспетчерські контролери/представлення/процесори, файловий браузер, кеш
шар, служби документів/користувачів і поверхні сумісності. Свіжі установки
ввести назви подій за замовчуванням у таблицю `system_eventnames`, якщо вони є
порожній.

## Обслуговування заходів

| ID послуги | Площа |
| ---: | --- |
| `1` | Синтаксичний аналізатор, документи, елементи, налаштування, перегляд файлів і загальні системні події. |
| `2` | Manager події автентифікації оболонки та менеджера. |
| `3` | Автентифікація веб-користувача та події життєвого циклу веб-користувача. |
| `4` | Події кешу та кешу сторінки. |
| `5` | Середовище веб-виконання, відтворення сторінок, URL-адреси, властивості синтаксичного аналізатора та вихідні події. |

## Події часу виконання та аналізатора

| Подія | Типовий район |
| --- | --- |
| `OnWebPageInit` | Ініціалізація веб-запиту. |
| `OnBeforeLoadDocumentObject` | Перед завантаженням об'єкта документа. |
| `OnLoadDocumentObject` | Завантаження об’єкта документа. |
| `OnAfterLoadDocumentObject` | Після завантаження об'єкта документа. |
| `OnLoadWebDocument` | Потік завантаження документів. |
| `OnWebPagePrerender` | Перед рендерингом виведення веб-сторінки. |
| `OnLoadWebPageCache` | Завантаження кешу сторінки. |
| `OnBeforeSaveWebPageCache` | Перед збереженням кешу сторінки. |
| `OnWebPageComplete` | Кінець обробки веб-сторінки. |
| `OnParseDocument` | Хук аналізу документа. |
| `OnBeforeParseParams` | Перед розбором параметрів. |
| `OnParseProperties` | Розбір властивостей. |
| `OnMakeDocUrl` | Генерація URL. |
| `OnStripAlias` | Нормалізація псевдонімів. |
| `OnPageNotFound` | Обробка не знайдено. |
| `OnPageUnauthorized` | Несанкціонована обробка сторінки. |
| `OnLogPageHit` | Реєстрація відвідувань сторінки. |
| `OnLogEvent` | Написання журналу подій. |
| `OnLoadSettings` | Завантаження налаштувань виконання. |
| `OnBeforeLoadExtension` | Завантаження розширення. |
| `OnMakePageCacheKey` | Генерація ключа кешу сторінки. |

## Кеш і події сайту

| Подія | Типовий район |
| --- | --- |
| `OnBeforeCacheUpdate` | Перед відновленням кешу. |
| `OnCacheUpdate` | Після відновлення кешу. |
| `OnSiteRefresh` | Manager дія оновлення сайту. |

## Manager Події Shell

| Подія | Типовий район |
| --- | --- |
| `OnBeforeManagerPageInit` | Перед ініціалізацією сторінки менеджера. |
| `OnManagerPageInit` | Manager ініціалізація сторінки. |
| `OnManagerLoginFormPrerender` | Відтворення форми перед входом менеджера. |
| `OnManagerLoginFormRender` | Manager візуалізація форми входу. |
| `OnManagerMenuPrerender` | Формування меню Manager. |
| `OnManagerMainFrameHeaderHTMLBlock` | Manager впорскування жатки головної рами. |
| `OnManagerTopPrerender` | Візуалізація верхнього кадру. |
| `OnManagerFrameLoader` | Manager рамний завантажувач. |
| `OnManagerWelcomePrerender` | Попередня візуалізація сторінки привітання. |
| `OnManagerWelcomeHome` | Віджети/вміст сторінки привітання. |
| `OnManagerWelcomeRender` | Візуалізація сторінки привітання. |
| `OnManagerPreFrameLoader` | Перед виведенням завантажувача кадрів менеджера. |
| `OnBeforeMinifyCss` | Manager CSS мініфікація. |

## Дерево та події Resource

| Подія | Типовий район |
| --- | --- |
| `OnManagerTreeInit` | Ініціалізація дерева Manager. |
| `OnManagerTreePrerender` | Попередня візуалізація дерева. |
| `OnManagerTreeRender` | Візуалізація дерева. |
| `OnManagerNodePrerender` | Попереднє рендеринг окремого вузла. |
| `OnManagerNodeRender` | Індивідуальний рендер вузла. |
| `OnDocFormPrerender` | Resource попередня візуалізація форми. |
| `OnDocFormRender` | Візуалізація форми Resource. |
| `OnDocFormTemplateRender` | Візуалізація шаблону форми Resource. |
| `OnBeforeDocFormSave` | Перед збереженням ресурсу. |
| `OnDocFormSave` | Після збереження ресурсу. |
| `OnBeforeDocFormDelete` | Перед видаленням ресурсу. |
| `OnDocFormDelete` | Після видалення ресурсу. |
| `OnDocFormUnDelete` | Resource відновити. |
| `OnDocPublished` | Resource опубліковано. |
| `OnDocUnPublished` | Resource не опубліковано. |
| `OnBeforeDocDuplicate` | Перед дублюванням ресурсу. |
| `OnDocDuplicate` | Після дублікату ресурсу. |
| `onBeforeMoveDocument` | Перед переміщенням ресурсу. |
| `onAfterMoveDocument` | Після переміщення ресурсу. |
| `OnBeforeEmptyTrash` | Перед порожнім сміттям. |
| `OnEmptyTrash` | Після порожнього сміття. |

## Події елемента| Група подій | Події |
| --- | --- |
| Шаблони | `OnTempFormPrerender`, `OnTempFormRender`, `OnBeforeTempFormSave`, `OnTempFormSave`, `OnBeforeTempFormDelete`, `OnTempFormDelete` |
| Template Variables | `OnTVFormPrerender`, `OnTVFormRender`, `OnBeforeTVFormSave`, `OnTVFormSave`, `OnBeforeTVFormDelete`, `OnTVFormDelete` |
| Chunks | `OnChunkFormPrerender`, `OnChunkFormRender`, `OnBeforeChunkFormSave`, `OnChunkFormSave`, `OnBeforeChunkFormDelete`, `OnChunkFormDelete` |
| Snippets | `OnSnipFormPrerender`, `OnSnipFormRender`, `OnBeforeSnipFormSave`, `OnSnipFormSave`, `OnBeforeSnipFormDelete`, `OnSnipFormDelete` |
| Plugins | `OnPluginFormPrerender`, `OnPluginFormRender`, `OnBeforePluginFormSave`, `OnPluginFormSave`, `OnBeforePluginFormDelete`, `OnPluginFormDelete` |
| Modules | `OnBeforeModFormSave`, `OnModFormSave`, `OnModFormPrerender`, `OnModFormRender`, `OnBeforeModFormDelete`, `OnModFormDelete` |
| Текстовий редактор | `OnRichTextEditorRegister`, `OnRichTextEditorInit` |

## Події користувачів і дозволів

| Подія | Типовий район |
| --- | --- |
| `OnBeforeManagerLogin` | Перед входом менеджера. |
| `OnManagerAuthentication` | Аутентифікація Manager. |
| `OnManagerLogin` | Manager вхід завершено. |
| `OnBeforeManagerLogout` | Перед виходом менеджера. |
| `OnManagerLogout` | Manager вихід із системи завершено. |
| `OnManagerSaveUser` | Manager користувача збережено. |
| `OnManagerDeleteUser` | Manager користувача видалено. |
| `OnManagerChangePassword` | Manager зміна пароля. |
| `OnManagerCreateGroup` | Група Manager створена. |
| `OnBeforeWebLogin` | Перед входом користувача в Інтернет. |
| `OnWebAuthentication` | Веб-автентифікація користувача. |
| `OnWebLogin` | Вхід веб-користувача завершено. |
| `OnBeforeWebLogout` | Перед виходом веб-користувача. |
| `OnWebLogout` | Вихід веб-користувача завершено. |
| `OnWebSaveUser` | Веб-користувача збережено. |
| `OnWebChangePassword` | Зміна пароля веб-користувача. |
| `OnUserFormPrerender` | Попередня візуалізація форми користувача. |
| `OnUserFormRender` | Візуалізація форми користувача. |
| `OnBeforeUserSave` | Перед збереженням користувача. |
| `OnUserSave` | Після збереження користувача. |
| `OnUserChangePassword` | Зміна пароля користувача. |
| `OnBeforeUserDelete` | Перед видаленням користувача. |
| `OnUserDelete` | Після видалення користувача. |
| `OnBeforeWUsrFormDelete` | Перед видаленням веб-користувача. |
| `OnWUsrFormDelete` | Після видалення веб-користувача. |
| `OnWebDeleteUser` | Веб-користувача видалено. |
| `OnWebCreateGroup` | Створено веб-групу. |
| `OnCreateDocGroup` | Групу документів створено. |

## Події параметрів системи

| Подія | Область налаштувань |
| --- | --- |
| `OnSiteSettingsRender` | Вкладка Загальні налаштування. |
| `OnFriendlyURLSettingsRender` | Вкладка Дружні URL-адреси. |
| `OnUserSettingsRender` | Вкладка налаштувань шаблону пошти/користувача. |
| `OnInterfaceSettingsRender` | Вкладка налаштувань інтерфейсу. |
| `OnSecuritySettingsRender` | Вкладка параметрів безпеки. |
| `OnFileManagerSettingsRender` | Вкладка налаштувань файлу Manager. |
| `OnMiscSettingsRender` | Браузер файлів/вкладка «Інші налаштування». |

## Події браузера файлів

| Група подій | Події |
| --- | --- |
| Ініціалізація файлового браузера | `OnFileBrowserInit` |
| Завантажити | `OnBeforeFileBrowserUpload`, `OnFileBrowserUpload`, `OnFileManagerUpload` |
| Перейменувати | `OnBeforeFileBrowserRename`, `OnFileBrowserRename` |
| Видалити | `OnBeforeFileBrowserDelete`, `OnFileBrowserDelete` |
| Копіювати | `OnBeforeFileBrowserCopy`, `OnFileBrowserCopy` |
| Перемістити | `OnBeforeFileBrowserMove`, `OnFileBrowserMove` |

## Правило документації

Документи подій мають містити джерело виклику та корисне навантаження лише після перевірки
поточний сайт виклику. Ця сторінка називає поверхню події; детальне корисне навантаження
контракти належать до наступних довідкових сторінок.
