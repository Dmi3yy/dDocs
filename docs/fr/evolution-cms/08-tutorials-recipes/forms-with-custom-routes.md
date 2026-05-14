# Formulaires avec des itinéraires personnalisés

[Retour](README.md) / [Haut](README.md) / [Suivant](sitecontent-query-patterns.md)

Utilisez des itinéraires personnalisés lorsqu'un projet a besoin d'un point de terminaison frontal propre pour le formulaire
soumission, réponses JSON ou pages spécifiques au projet. Evolution CMS actuel
charge les itinéraires de projet lisibles à partir de `core/custom/routes.php`, puis revient
à l'analyseur.

## Ajouter un itinéraire

Créez ou mettez à jour `core/custom/routes.php` :

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

## Soumettre depuis le frontend

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

## Conserver la solution de secours de l'analyseur

Le fournisseur de routage charge les routes du projet, puis appelle l'analyseur de secours. Cela
signifie que les ressources Evolution CMS normales fonctionnent toujours lorsqu'aucun itinéraire personnalisé ne correspond.

Si un groupe de routage doit envelopper l'analyseur avec un middleware, utilisez la route du projet
et testez que les URL de ressources normales sont toujours résolues.

## Limite du paquet

Pour des fonctionnalités réutilisables, préférez un package avec son propre contrôleur, ses propres vues,
les itinéraires, les tests et la documentation du package dDocs. Utiliser les itinéraires du projet pour
comportement spécifique au projet.

## Liste de contrôle de validation

- L'itinéraire est dans le fichier d'itinéraire du projet.
- L'itinéraire utilise les assistants de requête/réponse/affichage Illuminate actuels.
- La validation renvoie une forme d'erreur JSON claire.
- Les URL de ressources normales reviennent toujours à l'analyseur.
- Le formulaire ne dépend pas d'un ancien composant ou d'une ressource cachée.
