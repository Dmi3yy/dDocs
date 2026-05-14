<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Dmi3yy\dDocs\Support\Diagnostics;
use Dmi3yy\dDocs\Support\MarkdownExport;

$managerDiagnosticsAllowed = static function (): bool {
    if ((bool) config('app.debug', false)) {
        return true;
    }

    if (!defined('IN_MANAGER_MODE') || !IN_MANAGER_MODE || !function_exists('evo')) {
        return false;
    }

    try {
        return (bool) evo()->hasPermission('settings');
    } catch (\Throwable) {
        return false;
    }
};

$plantUmlRoute = static function () {
    $rendererUrl = rtrim((string) config(
        'cms.settings.dTuiEditor.plugins.uml.options.rendererURL',
        'https://www.plantuml.com/plantuml/png/'
    ), '/') . '/';

    $requestedUml = request('uml', '');
    $encoded = is_scalar($requestedUml) ? (string) $requestedUml : '';
    if ($encoded === '' || strlen($encoded) > 10000 || !preg_match('/^[A-Za-z0-9_-]+$/', $encoded)) {
        return response('', 404);
    }

    $requestedFormat = request('format', '');
    $format = strtolower(is_scalar($requestedFormat) ? (string) $requestedFormat : '');
    if (in_array($format, ['svg', 'png'], true)) {
        $rendererUrl = preg_replace('~/plantuml/(?:png|svg)/$~', '/plantuml/' . $format . '/', $rendererUrl) ?: $rendererUrl;
    }

    return Redirect::away($rendererUrl . $encoded);
};

Route::get('dtui-plantuml', $plantUmlRoute)->name('dDocs.plantuml.compat');

Route::prefix('ddocs')->name('dDocs.')->group(function () use ($plantUmlRoute, $managerDiagnosticsAllowed) {
    Route::get('health', fn () => Response::json(['ok' => true, 'mode' => 'file-only']))->name('health');
    Route::get('diagnostics', function (Diagnostics $diagnostics) use ($managerDiagnosticsAllowed) {
        if (!$managerDiagnosticsAllowed()) {
            return Response::make('', 404);
        }

        return Response::json($diagnostics->report());
    })->name('diagnostics');
    Route::get('export-markdown', function (MarkdownExport $export) use ($managerDiagnosticsAllowed) {
        if (!$managerDiagnosticsAllowed()) {
            return Response::make('', 404);
        }

        $payload = $export->build();

        return Response::make($payload['content'], 200, [
            'Content-Type' => 'text/markdown; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $payload['filename'] . '"',
            'X-dDocs-Document-Count' => (string) $payload['document_count'],
        ]);
    })->name('exportMarkdown');
    Route::get('plantuml', $plantUmlRoute)->name('plantuml');
});
