# Extras Та Пакети

[Evolution CMS](../README.md) / Extras Та Пакети

Extras розширюють Evolution CMS manager modules, frontend integrations,
commands, migrations, parser elements, services або документацією. Встановлені
Extras мають власну документацію в dDocs, тому product docs описують тільки
спільні правила створення пакетів та інтеграції.

## Сторінки

| Сторінка | Призначення |
| --- | --- |
| [Створити пакет](create-package.md) | Створити сучасний Evolution CMS package із service provider, manager module, EvoUI/Livewire, config, локалізацією, docs і release checks. |
| [Створити preset](create-preset.md) | Створити ready-site scaffold для installer з views, themes, custom project code, config, required Extras і validation checks. |

## Межа Документації Пакетів

Evolution CMS product documentation не дублює кожен встановлений Extra. Кожен
package має постачати власне дерево `docs/<locale>/`, а dDocs індексує ці
документи з filesystem.

Цей розділ використовується для спільних стандартів:

- package layout;
- preset layout;
- Composer і service provider contracts;
- manager module wiring;
- EvoUI і Livewire conventions;
- config і settings conventions;
- package documentation requirements;
- release checklist.

Специфічні workflows, API methods, field lists, screenshots, troubleshooting і
migration notes мають жити у документації конкретного package.
