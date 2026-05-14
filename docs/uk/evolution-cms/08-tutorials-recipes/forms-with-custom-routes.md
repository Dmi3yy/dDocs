# Форми з індивідуальними маршрутами

[Назад](README.md) / [Вгору](README.md) / [Далі](sitecontent-query-patterns.md)

Використовуйте спеціальні маршрути, коли проект потребує чистої кінцевої точки зовнішнього інтерфейсу для форми
подання, відповіді JSON або сторінки проекту. Поточний Evolution CMS
завантажує читабельні маршрути проекту з `core/custom/routes.php`, а потім повертається назад
до аналізатора.

## Додайте маршрут

Створіть або оновіть `core/custom/routes.php`:

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

Route::post('/contact', static function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => ['required', 'min:2'],
        'email' => ['required', 'email'],
        'message' => ['required', 'min:10'],
    ]);

    if ($validator->fails()) {
        return Response::json([
            'ok' => false,
            'html' => View::make('partials.contact-form', [
                'old' => $request->all(),
            ])->withErrors($validator)->render(),
            'errors' => $validator->errors(),
        ], 422);
    }

    return Response::json([
        'ok' => true,
        'html' => View::make('partials.contact-thanks', [
            'name' => $request->input('name'),
        ])->render(),
    ]);
});
```

## Надіслати з інтерфейсу

```html
<form id="contact-form" method="post" action="/contact">
    <input name="name" type="text">
    <input name="email" type="email">
    <textarea name="message"></textarea>
    <button type="submit">Send</button>
</form>

<script>
document.getElementById('contact-form').addEventListener('submit', async (event) => {
    event.preventDefault();

    const form = event.currentTarget;
    const response = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            Accept: 'application/json',
        },
    });

    const payload = await response.json();

    if (payload.html) {
        form.outerHTML = payload.html;
    }
});
</script>
```

## Зберігати запасний аналізатор

Постачальник маршрутизації завантажує маршрути проекту, а потім викликає резервний аналізатор. що
означає, що звичайні ресурси Evolution CMS все ще працюють, якщо не збігається користувацький маршрут.

Якщо групі маршрутів потрібно обернути аналізатор проміжним програмним забезпеченням, використовуйте маршрут проекту
файл і перевірте, чи звичайні URL-адреси ресурсів все ще вирішуються.

## Межа пакета

Для багаторазових функціональних можливостей віддайте перевагу пакету з власним контролером, представленнями,
маршрути, тести та документація пакета dDocs. Використовуйте маршрути проекту для
специфічна для проекту поведінка.

## Контрольний список перевірки

- Маршрут знаходиться у файлі маршруту проекту.
- Маршрут використовує поточні помічники запиту/відповіді/перегляду Illuminate.
- Перевірка повертає чітку форму помилки JSON.
- Звичайні URL-адреси ресурсів все ще повертаються до аналізатора.
- Форма не залежить від старого компонента або прихованого ресурсу.
