# Formularze z niestandardowymi trasami

[Wstecz](README.md) / [W górę](README.md) / [Dalej](sitecontent-query-patterns.md)

Użyj niestandardowych tras, gdy projekt wymaga czystego punktu końcowego frontonu dla formularza
zgłoszenia, odpowiedzi JSON lub strony dotyczące konkretnego projektu. Aktualny Evolution CMS
ładuje czytelne trasy projektu z `core/custom/routes.php`, a następnie wraca
do parsera.

## Dodaj trasę

Utwórz lub zaktualizuj `core/custom/routes.php`:

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

## Prześlij z frontonu

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

## Zachowaj rezerwę parsera

Dostawca routingu ładuje trasy projektu, a następnie wywołuje rezerwę analizatora składni. To
oznacza, że normalne zasoby Evolution CMS nadal działają, gdy żadna trasa niestandardowa nie pasuje.

Jeśli grupa tras musi owinąć parser oprogramowaniem pośredniczącym, użyj trasy projektu
plik i sprawdź, czy normalne adresy URL zasobów nadal są rozpoznawane.

## Granica pakietu

Aby uzyskać funkcjonalność wielokrotnego użytku, preferuj pakiet z własnym kontrolerem, widokami,
trasy, testy i dokumentacja pakietu dDocs. Użyj tras projektu dla
zachowanie specyficzne dla projektu.

## Lista kontrolna walidacji

- Trasa znajduje się w pliku trasy projektu.
- Trasa korzysta z aktualnych pomocników żądania/odpowiedzi/wyświetlenia Illuminate.
- Walidacja zwraca wyraźny kształt błędu JSON.
- Normalne adresy URL zasobów nadal wracają do analizatora składni.
- Formularz nie zależy od starego komponentu ani ukrytego zasobu.
