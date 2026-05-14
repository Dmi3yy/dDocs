# Forms With Custom Routes

[Back](README.md) / [Up](README.md) / [Next](sitecontent-query-patterns.md)

Use custom routes when a project needs a clean frontend endpoint for form
submission, JSON responses, or project-specific pages. Current Evolution CMS
loads readable project routes from `core/custom/routes.php` and then falls back
to the parser.

## Add A Route

Create or update `core/custom/routes.php`:

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

## Submit From The Frontend

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

## Keep Parser Fallback

The routing provider loads project routes and then calls parser fallback. That
means normal Evolution CMS resources still work when no custom route matches.

If a route group needs to wrap the parser with middleware, use the project route
file and test that normal resource URLs still resolve.

## Package Boundary

For reusable functionality, prefer a package with its own controller, views,
routes, tests, and dDocs package documentation. Use project routes for
project-specific behavior.

## Validation Checklist

- The route is in the project route file.
- The route uses current Illuminate request/response/view helpers.
- Validation returns a clear JSON error shape.
- Normal resource URLs still fall back to the parser.
- The form does not depend on an old component or hidden resource.
