<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$GLOBALS['ddocs_test_root'] = $root;
$GLOBALS['ddocs_test_base_path'] = dirname($root);
$GLOBALS['ddocs_test_storage_path'] = sys_get_temp_dir() . '/ddocs-test-storage';
$GLOBALS['ddocs_test_cleanup'] = [];

/**
 * @return array<string, mixed>
 */
function ddocs_default_config(): array
{
    return [
        'dmi3yy' => [
            'settings' => [
                'dDocs' => [
                    'allowed_extensions' => ['md', 'mdx'],
                    'allowed_image_extensions' => ['png', 'jpg', 'jpeg', 'gif', 'webp'],
                    'cache_index' => false,
                    'default_language' => '',
                    'extra_docs_roots' => [],
                    'index_cache_path' => '',
                    'language_fallback' => 'en',
                    'max_file_size_kb' => 512,
                    'safe_roots' => [],
                    'scan_project_docs' => false,
                    'scan_vendor_packages' => false,
                    'show_internal_task_docs' => false,
                ],
            ],
        ],
    ];
}

function ddocs_config_reset(): void
{
    $GLOBALS['ddocs_test_config'] = ddocs_default_config();
    $_SESSION = [];
}

function ddocs_config_set(string $key, mixed $value): void
{
    $segments = explode('.', $key);
    $target = &$GLOBALS['ddocs_test_config'];

    foreach ($segments as $segment) {
        if (!isset($target[$segment]) || !is_array($target[$segment])) {
            $target[$segment] = [];
        }

        $target = &$target[$segment];
    }

    $target = $value;
}

if (!function_exists('config')) {
    function config(string $key, mixed $default = null): mixed
    {
        $value = $GLOBALS['ddocs_test_config'] ?? ddocs_default_config();

        foreach (explode('.', $key) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }
}

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return rtrim((string) $GLOBALS['ddocs_test_base_path'], DIRECTORY_SEPARATOR)
            . ($path !== '' ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $path = ''): string
    {
        return rtrim((string) $GLOBALS['ddocs_test_storage_path'], DIRECTORY_SEPARATOR)
            . ($path !== '' ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR) : '');
    }
}

foreach ([
    'Settings.php',
    'DocumentPath.php',
    'ManagerText.php',
    'LanguageResolver.php',
    'DocsSourceRegistry.php',
    'DocsIndexer.php',
    'FileDocumentRepository.php',
    'FileIndexCache.php',
    'FileSearch.php',
    'LinkResolver.php',
    'MarkdownExport.php',
    'Diagnostics.php',
] as $file) {
    require_once $root . '/src/Support/' . $file;
}

ddocs_config_reset();

$stats = [
    'tests' => 0,
    'assertions' => 0,
    'failures' => 0,
    'skips' => 0,
];

function test(string $name, callable $callback): void
{
    global $stats;

    $stats['tests']++;
    ddocs_config_reset();

    try {
        $callback();
        echo "\033[32mPASS\033[0m {$name}\n";
    } catch (Throwable $exception) {
        if (str_starts_with($exception->getMessage(), '__SKIP__: ')) {
            $stats['skips']++;
            echo "\033[33mSKIP\033[0m {$name}: " . substr($exception->getMessage(), 10) . "\n";
            return;
        }

        $stats['failures']++;
        echo "\033[31mFAIL\033[0m {$name}: {$exception->getMessage()}\n";
    }
}

function assert_true(mixed $condition, string $message = 'Expected condition to be true.'): void
{
    global $stats;
    $stats['assertions']++;

    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function assert_false(mixed $condition, string $message = 'Expected condition to be false.'): void
{
    assert_true(!$condition, $message);
}

function assert_same(mixed $expected, mixed $actual, string $message = 'Values are not the same.'): void
{
    global $stats;
    $stats['assertions']++;

    if ($expected !== $actual) {
        throw new RuntimeException($message . ' Expected ' . var_export($expected, true) . ', got ' . var_export($actual, true) . '.');
    }
}

function assert_contains(string $needle, string $haystack, string $message = 'Expected string was not found.'): void
{
    assert_true(str_contains($haystack, $needle), $message . ' Missing: ' . $needle);
}

function assert_not_contains(string $needle, string $haystack, string $message = 'Unexpected string was found.'): void
{
    assert_false(str_contains($haystack, $needle), $message . ' Found: ' . $needle);
}

function skip_test(string $message): void
{
    throw new RuntimeException('__SKIP__: ' . $message);
}

function temp_dir(string $prefix = 'ddocs-test'): string
{
    $dir = sys_get_temp_dir() . '/' . $prefix . '-' . bin2hex(random_bytes(6));
    if (!mkdir($dir, 0775, true) && !is_dir($dir)) {
        throw new RuntimeException('Unable to create temp directory: ' . $dir);
    }

    $GLOBALS['ddocs_test_cleanup'][] = $dir;

    return $dir;
}

function remove_tree(string $path): void
{
    if (!is_dir($path)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST,
    );

    foreach ($iterator as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }

    rmdir($path);
}

function write_file(string $path, string $content): void
{
    $dir = dirname($path);
    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        throw new RuntimeException('Unable to create directory: ' . $dir);
    }

    file_put_contents($path, $content);
}

/**
 * @return array<string, mixed>
 */
function require_file(string $path): array
{
    $payload = include $path;

    return is_array($payload) ? $payload : [];
}

register_shutdown_function(static function (): void {
    foreach (array_reverse($GLOBALS['ddocs_test_cleanup'] ?? []) as $path) {
        remove_tree($path);
    }
});

/**
 * @param array{failures?: int} $stats
 */
function test_exit_code(array $stats): int
{
    return ((int) ($stats['failures'] ?? 0)) > 0 ? 1 : 0;
}

test('composer metadata exposes dDocs as an Evolution module with a test script', function () use ($root): void {
    $composer = json_decode((string) file_get_contents($root . '/composer.json'), true, flags: JSON_THROW_ON_ERROR);

    assert_same('dmi3yy/ddocs', $composer['name'] ?? null);
    assert_same('evolutioncms-module', $composer['type'] ?? null);
    assert_same('Dmi3yy\\dDocs\\dDocsServiceProvider', $composer['extra']['laravel']['providers'][0] ?? null);
    assert_same('Dmi3yy\\dDocs\\Facades\\dDocs', $composer['extra']['laravel']['aliases']['dDocs'] ?? null);
    assert_same('php tests/run.php', $composer['scripts']['test'] ?? null);
});

test('manager provider moves the dDocs module item after Help in the utility menu', function () use ($root): void {
    $provider = (string) file_get_contents($root . '/src/dDocsServiceProvider.php');

    assert_contains("Event::listen('evolution.OnManagerTopPrerender'", $provider);
    assert_contains('document.getElementById({$encodedModuleItemId})', $provider);
    assert_contains("document.querySelector('#system > .dropdown-menu')", $provider);
    assert_contains("a[href=\"index.php?a=9\"]", $provider);
    assert_contains('helpItem.after(moduleItem)', $provider);
});

test('all manager language files keep the English key contract', function () use ($root): void {
    $english = require_file($root . '/lang/en/global.php');
    $englishKeys = array_keys($english);
    sort($englishKeys);

    foreach (['de', 'fr', 'pl', 'ru', 'ua', 'uk'] as $language) {
        $labels = require_file($root . '/lang/' . $language . '/global.php');
        $keys = array_keys($labels);
        sort($keys);

        assert_same($englishKeys, $keys, 'Language file key drift in ' . $language . '.');
    }
});

test('settings list parser accepts arrays, comma lists, and newline lists', function (): void {
    ddocs_config_set('dmi3yy.settings.dDocs.allowed_extensions', "md, mdx\nmarkdown");
    assert_same(['md', 'mdx', 'markdown'], Dmi3yy\dDocs\Support\Settings::list('allowed_extensions'));

    ddocs_config_set('dmi3yy.settings.dDocs.allowed_extensions', [' md ', '', 9]);
    assert_same(['md', '9'], Dmi3yy\dDocs\Support\Settings::list('allowed_extensions'));
});

test('manager text falls back to English and cleans plural choices', function (): void {
    $_SESSION['mgrUsrConfigSet']['manager_language'] = 'missing-locale';

    assert_same('Download Markdown', Dmi3yy\dDocs\Support\ManagerText::get('download_markdown'));
    assert_same('Index refreshed: 3 documents.', Dmi3yy\dDocs\Support\ManagerText::get('cache_refreshed', ['count' => 3]));
    assert_same('No documents', Dmi3yy\dDocs\Support\ManagerText::choice('search_results', 0));
    assert_same('1 document', Dmi3yy\dDocs\Support\ManagerText::choice('search_results', 1));
    assert_same('2 documents', Dmi3yy\dDocs\Support\ManagerText::choice('search_results', 2));
});

test('language resolver normalizes legacy ua input to canonical uk docs locale', function (): void {
    $resolver = new Dmi3yy\dDocs\Support\LanguageResolver();

    assert_same('uk', $resolver->normalize('ua'));
    assert_same('uk', $resolver->normalize('uk-UA'));
    assert_same('en', $resolver->normalize(''));

    $_SESSION['mgrUsrConfigSet']['manager_language'] = 'ua';
    assert_same('uk', $resolver->managerLanguage());

    ddocs_config_set('dmi3yy.settings.dDocs.default_language', 'pl-PL');
    assert_same('pl', $resolver->managerLanguage());
    assert_same(['uk', 'en', 'neutral'], $resolver->candidates('ua'));
});

test('language resolver exposes uk as the docs locale even for a legacy ua folder', function (): void {
    $docs = temp_dir();
    write_file($docs . '/ua/README.md', '# Ukrainian legacy source');
    write_file($docs . '/en/README.md', '# English source');

    $resolver = new Dmi3yy\dDocs\Support\LanguageResolver();
    $available = $resolver->availableLanguages($docs);

    assert_true(isset($available['localized']['uk']), 'Legacy ua folder must be surfaced as uk.');
    assert_false(isset($available['localized']['ua']), 'ua must not be exposed as a documentation locale.');
    assert_same($docs . '/ua', $available['localized']['uk']);
});

test('document path safety rejects escapes and computes safe relative paths', function (): void {
    $root = temp_dir();
    write_file($root . '/docs/page.md', '# Page');
    write_file($root . '/outside.md', '# Outside');

    $paths = new Dmi3yy\dDocs\Support\DocumentPath();

    assert_true($paths->isInside($root . '/docs/page.md', $root . '/docs'));
    assert_false($paths->isInside($root . '/outside.md', $root . '/docs'));
    assert_same('page.md', $paths->relativeTo($root . '/docs/page.md', $root . '/docs'));
    assert_same(null, $paths->relativeTo($root . '/outside.md', $root . '/docs'));
});

test('file document repository reads only allowed Markdown inside the docs root', function (): void {
    $root = temp_dir();
    write_file($root . '/docs/page.md', '# Page');
    write_file($root . '/docs/page.txt', 'Not docs');
    write_file($root . '/outside.md', '# Outside');
    write_file($root . '/docs/large.md', str_repeat('x', 2048));

    ddocs_config_set('dmi3yy.settings.dDocs.max_file_size_kb', 1);
    $repository = new Dmi3yy\dDocs\Support\FileDocumentRepository();

    assert_same("# Page", trim((string) $repository->read([
        'absolute_path' => $root . '/docs/page.md',
        'docs_path' => $root . '/docs',
    ])));
    assert_same(null, $repository->read([
        'absolute_path' => $root . '/docs/page.txt',
        'docs_path' => $root . '/docs',
    ]));
    assert_same(null, $repository->read([
        'absolute_path' => $root . '/outside.md',
        'docs_path' => $root . '/docs',
    ]));
    assert_same(null, $repository->read([
        'absolute_path' => $root . '/docs/large.md',
        'docs_path' => $root . '/docs',
    ]));
});

test('docs indexer fallback contexts include English-only structure for a uk request', function (): void {
    $docs = temp_dir();
    write_file($docs . '/uk/ddocs/README.md', '# dDocs');
    write_file($docs . '/en/evolution-cms/README.md', '# Evolution CMS');

    $languages = new Dmi3yy\dDocs\Support\LanguageResolver();
    $indexer = new Dmi3yy\dDocs\Support\DocsIndexer(languages: $languages);
    $resolved = $languages->resolveDocsPaths($docs, 'uk');

    $contextsMethod = new ReflectionMethod($indexer, 'resolvedRootContexts');
    $contextsMethod->setAccessible(true);
    $markdownMethod = new ReflectionMethod($indexer, 'markdownFiles');
    $markdownMethod->setAccessible(true);

    $source = [
        'key' => 'fixture',
        'name' => 'Fixture',
        'source_type' => 'package',
        'package_name' => 'fixture/package',
        'docs_path' => $docs,
        'root_path' => dirname($docs),
        'root_readme_only' => false,
        'is_vendor' => true,
        'readonly' => true,
    ];

    $paths = [];
    foreach ($contextsMethod->invoke($indexer, $source, $resolved) as $context) {
        foreach ($markdownMethod->invoke($indexer, (string) $context['path'], $context) as $file) {
            $paths[] = str_replace('\\', '/', substr($file->getPathname(), strlen((string) $context['path']) + 1));
        }
    }

    sort($paths);
    assert_same(['ddocs/README.md', 'evolution-cms/README.md'], $paths);
});

test('docs indexer builds current dDocs nodes without exposing ua as a node language', function (): void {
    $nodes = (new Dmi3yy\dDocs\Support\DocsIndexer())->index('uk');
    $documents = array_values(array_filter($nodes, static fn (array $node): bool => ($node['type'] ?? '') === 'document'));
    $languages = array_values(array_unique(array_map(static fn (array $node): string => (string) ($node['language'] ?? ''), $documents)));
    $paths = array_map(static fn (array $node): string => (string) ($node['relative_path'] ?? ''), $documents);

    assert_true(count($documents) > 0, 'dDocs should index at least one document.');
    assert_false(in_array('ua', $languages, true), 'Indexed docs must not expose ua as a documentation locale.');
    assert_true(in_array('evolution-cms/README.md', $paths, true), 'Evolution CMS docs must be visible in the current index.');
});

test('file search matches metadata, reads document content, and preserves parent folders', function (): void {
    $root = temp_dir();
    write_file($root . '/docs/guides/install.md', '# Install' . "\n\n" . 'The body contains a hidden needle.');

    $nodes = [
        ['id' => 'source', 'type' => 'folder', 'title' => 'Source', 'parent_id' => null, 'relative_path' => '', 'source_name' => 'Fixture', 'package_name' => 'fixture/package'],
        ['id' => 'folder', 'type' => 'folder', 'title' => 'Guides', 'parent_id' => 'source', 'relative_path' => 'guides', 'source_name' => 'Fixture', 'package_name' => 'fixture/package'],
        ['id' => 'doc', 'type' => 'document', 'title' => 'Install', 'parent_id' => 'folder', 'relative_path' => 'guides/install.md', 'source_name' => 'Fixture', 'package_name' => 'fixture/package', 'absolute_path' => $root . '/docs/guides/install.md', 'docs_path' => $root . '/docs'],
    ];

    $search = new Dmi3yy\dDocs\Support\FileSearch();
    $result = $search->filter($nodes, 'hidden needle');
    $ids = array_map(static fn (array $node): string => (string) $node['id'], $result);

    assert_same(['source', 'folder', 'doc'], $ids);
    assert_same([], $search->filter($nodes, 'nothing-here'));
});

test('link resolver rewrites internal links, blocks unsafe content, and resolves local images', function (): void {
    if (!class_exists(DOMDocument::class)) {
        skip_test('DOM extension is not available.');
    }

    $root = temp_dir();
    write_file($root . '/docs/guide/readme.md', '# Readme');
    write_file($root . '/docs/guide/next.md', '# Next');
    write_file($root . '/docs/guide/logo.png', 'png');

    $document = [
        'id' => 'doc-readme',
        'type' => 'document',
        'relative_path' => 'guide/readme.md',
        'absolute_path' => $root . '/docs/guide/readme.md',
        'docs_path' => $root . '/docs',
        'root_path' => $root,
        'source_key' => 'fixture',
    ];
    $nodes = [
        $document,
        ['id' => 'doc-next', 'type' => 'document', 'relative_path' => 'guide/next.md', 'source_key' => 'fixture'],
    ];

    $html = '<script>alert(1)</script>'
        . '<a href="next.md">Next</a>'
        . '<a href="missing.md">Missing</a>'
        . '<a href="https://example.com">External</a>'
        . '<img src="logo.png" alt="Logo">'
        . '<h2>Heading Here</h2>'
        . '<pre><code class="language-puml">@startuml' . "\n" . 'A -> B' . "\n" . '@enduml</code></pre>';

    $output = (new Dmi3yy\dDocs\Support\LinkResolver())->rewriteHtml($html, $document, $nodes);

    assert_contains('data-ddocs-document-id="doc-next"', $output, 'Internal Markdown links should be rewritten to dDocs document ids.');
    assert_contains('ddocs-link-missing', $output, 'Missing relative Markdown links should be marked.');
    assert_contains('rel="noopener noreferrer"', $output, 'External links should be opened safely.');
    assert_contains('data:image/png;base64,', $output, 'Local images inside docs roots should be embedded as safe data URIs.');
    assert_contains('id="heading-here"', $output, 'Headings should receive stable anchors.');
    assert_contains('class="ddocs-uml dtui-uml"', $output, 'PlantUML blocks should be rewritten to UML figures.');
    assert_not_contains('<script', $output, 'Unsafe script tags must be removed.');
});

test('file index cache writes and reuses a generated PHP cache inside safe roots', function (): void {
    $cacheRoot = temp_dir();
    $cachePath = $cacheRoot . '/cache/ddocs-index.php';

    ddocs_config_set('dmi3yy.settings.dDocs.cache_index', true);
    ddocs_config_set('dmi3yy.settings.dDocs.index_cache_path', $cachePath);
    ddocs_config_set('dmi3yy.settings.dDocs.safe_roots', [$cacheRoot]);

    $cache = new Dmi3yy\dDocs\Support\FileIndexCache();
    $fresh = $cache->refresh('en');

    assert_true(is_file($cachePath), 'Index cache file should be written.');

    $payload = require_file($cachePath);
    assert_same(2, (int) ($payload['schema'] ?? 0));
    assert_same('en', $payload['language'] ?? null);
    assert_true(count($payload['nodes'] ?? []) > 0, 'Cache payload should contain indexed nodes.');

    $cached = (new Dmi3yy\dDocs\Support\FileIndexCache())->index('en');
    assert_same(count($fresh), count($cached), 'Cached index should have the same node count as the refreshed index.');
});

test('markdown export builds one Markdown payload from readable indexed documents', function (): void {
    $export = (new Dmi3yy\dDocs\Support\MarkdownExport())->build('en');

    assert_true(($export['document_count'] ?? 0) > 0, 'Export should include indexed documents.');
    assert_contains('# Documentation export', (string) $export['content']);
    assert_contains('- Source: `dDocs`', (string) $export['content']);
    assert_contains('- Path: `', (string) $export['content']);
    assert_true(str_ends_with((string) $export['filename'], '.md'), 'Export filename should be Markdown.');
});

test('diagnostics reports file-only mode, documents, languages, and path safety', function (): void {
    $report = (new Dmi3yy\dDocs\Support\Diagnostics())->report();

    assert_same('file-only', $report['mode'] ?? null);
    assert_true(($report['sources_count'] ?? 0) > 0, 'Diagnostics should see at least one docs source.');
    assert_true(($report['documents_count'] ?? 0) > 0, 'Diagnostics should see at least one document.');
    assert_true(is_array($report['languages'] ?? null), 'Diagnostics should expose language counts.');
    assert_true(($report['path_safety']['escape_blocked'] ?? false) === true, 'Diagnostics should verify path escape blocking.');
});

test('public docs do not contain a docs/ua locale folder', function () use ($root): void {
    assert_false(is_dir($root . '/docs/ua'), 'dDocs public documentation must not expose docs/ua.');
});

echo "\n";
echo 'Tests: ' . $stats['tests'] . ', Assertions: ' . $stats['assertions'] . ', Skips: ' . $stats['skips'] . ', Failures: ' . $stats['failures'] . "\n";

exit(test_exit_code($stats));
