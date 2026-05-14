# Formulare mit benutzerdefinierten Routen

[Zurück](README.md) / [Nach oben](README.md) / [Weiter](sitecontent-query-patterns.md)

Verwenden Sie benutzerdefinierte Routen, wenn ein Projekt einen sauberen Frontend-Endpunkt für das Formular benötigt
Einreichung, JSON-Antworten oder projektspezifische Seiten. Aktuelle Evolution CMS
lädt lesbare Projektrouten von `core/custom/routes.php` und greift dann zurück
zum Parser.

## Eine Route hinzufügen

Erstellen oder aktualisieren Sie `core/custom/routes.php`:

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

## Vom Frontend aus senden

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

## Parser-Fallback beibehalten

Der Routing-Anbieter lädt Projektrouten und ruft dann den Parser-Fallback auf. Das
bedeutet, dass normale Evolution CMS-Ressourcen weiterhin funktionieren, wenn keine benutzerdefinierte Route übereinstimmt.

Wenn eine Routengruppe den Parser mit Middleware umschließen muss, verwenden Sie die Projektroute
Datei und testen Sie, ob normale Ressourcen-URLs weiterhin aufgelöst werden.

## Paketgrenze

Für wiederverwendbare Funktionen bevorzugen Sie ein Paket mit eigenem Controller, eigenen Ansichten usw.
Routen, Tests und dDocs-Paketdokumentation. Projektrouten nutzen für
projektspezifisches Verhalten.

## Validierungscheckliste

- Die Route befindet sich in der Projektroutendatei.
– Die Route verwendet aktuelle Illuminate-Anfrage-/Antwort-/Ansichtshelfer.
– Die Validierung gibt eine eindeutige Fehlerform JSON zurück.
– Normale Ressourcen-URLs greifen weiterhin auf den Parser zurück.
- Das Formular ist nicht von einer alten Komponente oder versteckten Ressource abhängig.
