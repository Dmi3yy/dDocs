<?php namespace Dmi3yy\dDocs\Support;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class DocsIndexer
{
    protected DocsSourceRegistry $sources;
    protected LanguageResolver $languages;
    protected DocumentPath $paths;

    public function __construct(?DocsSourceRegistry $sources = null, ?LanguageResolver $languages = null, ?DocumentPath $paths = null)
    {
        $this->paths = $paths ?? new DocumentPath();
        $this->languages = $languages ?? new LanguageResolver();
        $this->sources = $sources ?? new DocsSourceRegistry($this->paths);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function index(?string $language = null): array
    {
        $nodes = [];

        foreach ($this->sources->sources() as $source) {
            $resolvedRoots = $this->languages->resolveDocsPaths((string) $source['docs_path'], $language);
            $primary = $resolvedRoots[0] ?? null;
            if ($primary === null) {
                continue;
            }

            $docsPath = $this->paths->normalize((string) $primary['path']);
            if ($docsPath === null || !is_dir($docsPath)) {
                continue;
            }

            $sourceNode = $this->sourceNode($source, $primary, $docsPath);
            $nodes[$sourceNode['id']] = $sourceNode;
            $folderIds = ['' => $sourceNode['id']];
            $indexedDocuments = [];

            foreach ($this->resolvedRootContexts($source, $resolvedRoots) as $context) {
                $contextPath = (string) $context['path'];
                $contextResolved = $context['resolved'];

                if (!(bool) ($source['readonly'] ?? $source['is_vendor'] ?? true)) {
                    foreach ($this->writableDirectories($contextPath, $context) as $relativeDirectory) {
                        $this->ensureFolderNodes($nodes, $folderIds, $source, $contextResolved, $contextPath, $relativeDirectory);
                    }
                }

                foreach ($this->markdownFiles($contextPath, $context) as $file) {
                    $relative = $this->paths->relativeTo($file->getPathname(), $contextPath);
                    if ($relative === null) {
                        continue;
                    }

                    $relativeKey = strtolower(trim(str_replace('\\', '/', $relative), '/'));
                    if (isset($indexedDocuments[$relativeKey])) {
                        continue;
                    }

                    $parentId = $this->ensureFolderNodes($nodes, $folderIds, $source, $contextResolved, $contextPath, dirname($relative));
                    $node = $this->documentNode($source, $contextResolved, $contextPath, $file, $relative, $parentId);
                    $nodes[$node['id']] = $node;
                    $indexedDocuments[$relativeKey] = true;
                }
            }
        }

        $nodes = $this->organizeDocumentationSources(array_values($nodes));
        usort($nodes, fn (array $left, array $right): int => $this->compareNodes($left, $right));

        return $nodes;
    }

    /**
     * @param array<string, mixed> $source
     * @param list<array<string, mixed>> $resolvedRoots
     * @return list<array<string, mixed>>
     */
    protected function resolvedRootContexts(array $source, array $resolvedRoots): array
    {
        $contexts = [];
        $includeNeutralRoot = true;

        foreach ($resolvedRoots as $resolved) {
            $docsPath = $this->paths->normalize((string) ($resolved['path'] ?? ''));
            if ($docsPath === null || !is_dir($docsPath)) {
                continue;
            }

            foreach ($this->docsRootContexts($source, $resolved, $docsPath, $includeNeutralRoot) as $context) {
                $contexts[] = $context;
            }

            $includeNeutralRoot = false;
        }

        return $contexts;
    }

    /**
     * @param array<string, mixed> $source
     * @param array<string, mixed> $resolved
     * @return list<array<string, mixed>>
     */
    protected function docsRootContexts(array $source, array $resolved, string $docsPath, bool $includeNeutralRoot = true): array
    {
        $contexts = [[
            'path' => $docsPath,
            'resolved' => $resolved,
            'skip_language_dirs' => false,
            'skip_root_index' => false,
            'skip_internal_tasks' => !(bool) config('dmi3yy.settings.dDocs.show_internal_task_docs', false),
            'root_readme_only' => (bool) ($source['root_readme_only'] ?? false),
        ]];

        $sourceDocsPath = $this->paths->normalize((string) ($source['docs_path'] ?? ''));
        if (
            $includeNeutralRoot
            && (string) ($resolved['language'] ?? '') !== 'neutral'
            && $sourceDocsPath !== null
            && $sourceDocsPath !== $docsPath
            && is_dir($sourceDocsPath)
            && !(bool) ($source['root_readme_only'] ?? false)
            && $this->hasMarkdownFiles($sourceDocsPath, true)
        ) {
            $neutral = $resolved;
            $neutral['language'] = 'neutral';
            $neutral['fallback_language'] = (string) ($resolved['language'] ?? 'neutral');

            $contexts[] = [
                'path' => $sourceDocsPath,
                'resolved' => $neutral,
                'skip_language_dirs' => true,
                'skip_root_index' => true,
                'skip_internal_tasks' => !(bool) config('dmi3yy.settings.dDocs.show_internal_task_docs', false),
                'root_readme_only' => false,
            ];
        }

        return $contexts;
    }

    /**
     * @param array<string, mixed> $source
     * @param array<string, mixed> $resolved
     * @return array<string, mixed>
     */
    protected function sourceNode(array $source, array $resolved, string $docsPath): array
    {
        $id = $this->nodeId((string) $source['key'], '', (string) $resolved['language'], 'folder');

        return [
            'id' => $id,
            'source_key' => (string) $source['key'],
            'source_name' => (string) $source['name'],
            'source_icon' => (string) ($source['icon'] ?? 'tabler-package'),
            'source_description' => (string) ($source['description'] ?? ''),
            'description' => (string) ($source['description'] ?? ''),
            'icon' => (string) ($source['icon'] ?? 'tabler-package'),
            'source_type' => (string) $source['source_type'],
            'package_name' => (string) $source['package_name'],
            'title' => (string) $source['name'],
            'language' => (string) $resolved['language'],
            'fallback_language' => $resolved['fallback_language'],
            'logical_path' => '',
            'relative_path' => '',
            'absolute_path' => $docsPath,
            'docs_path' => $docsPath,
            'root_path' => (string) ($source['root_path'] ?? ''),
            'parent_id' => null,
            'type' => 'folder',
            'mtime' => filemtime($docsPath) ?: 0,
            'checksum' => null,
            'available_languages' => $resolved['available_languages'] ?? [],
            'is_vendor' => (bool) $source['is_vendor'],
            'readonly' => (bool) ($source['readonly'] ?? $source['is_vendor'] ?? true),
            'sort_order' => $this->sortOrder(''),
        ];
    }

    /**
     * @param array<string, array<string, mixed>> $nodes
     * @param array<string, string> $folderIds
     * @param array<string, mixed> $source
     * @param array<string, mixed> $resolved
     */
    protected function ensureFolderNodes(array &$nodes, array &$folderIds, array $source, array $resolved, string $docsPath, string $folder): string
    {
        $folder = trim(str_replace('\\', '/', $folder), '/.');
        if ($folder === '') {
            return $folderIds[''];
        }

        $parent = '';
        foreach (explode('/', $folder) as $part) {
            $path = trim($parent . '/' . $part, '/');
            if (!isset($folderIds[$path])) {
                $absolute = $docsPath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
                $parentId = $folderIds[$parent] ?? $folderIds[''];
                $id = $this->nodeId((string) $source['key'], $path, (string) $resolved['language'], 'folder');

                $nodes[$id] = [
                    'id' => $id,
                    'source_key' => (string) $source['key'],
                    'source_name' => (string) $source['name'],
                    'source_icon' => (string) ($source['icon'] ?? 'tabler-package'),
                    'source_description' => (string) ($source['description'] ?? ''),
                    'source_type' => (string) $source['source_type'],
                    'package_name' => (string) $source['package_name'],
                    'title' => $this->label($part),
                    'language' => (string) $resolved['language'],
                    'fallback_language' => $resolved['fallback_language'],
                    'logical_path' => $path,
                    'relative_path' => $path,
                    'absolute_path' => $absolute,
                    'docs_path' => $docsPath,
                    'root_path' => (string) ($source['root_path'] ?? ''),
                    'parent_id' => $parentId,
                    'type' => 'folder',
                    'mtime' => is_dir($absolute) ? (filemtime($absolute) ?: 0) : 0,
                    'checksum' => null,
                    'available_languages' => $resolved['available_languages'] ?? [],
                    'is_vendor' => (bool) $source['is_vendor'],
                    'readonly' => (bool) ($source['readonly'] ?? $source['is_vendor'] ?? true),
                    'sort_order' => $this->sortOrder($path),
                ];

                $folderIds[$path] = $id;
            }

            $parent = $path;
        }

        return $folderIds[$folder];
    }

    /**
     * @param array<string, mixed> $source
     * @param array<string, mixed> $resolved
     * @return array<string, mixed>
     */
    protected function documentNode(array $source, array $resolved, string $docsPath, SplFileInfo $file, string $relative, string $parentId): array
    {
        $path = $file->getPathname();

        return [
            'id' => $this->nodeId((string) $source['key'], $relative, (string) $resolved['language'], 'document'),
            'source_key' => (string) $source['key'],
            'source_name' => (string) $source['name'],
            'source_icon' => (string) ($source['icon'] ?? 'tabler-package'),
            'source_description' => (string) ($source['description'] ?? ''),
            'source_type' => (string) $source['source_type'],
            'package_name' => (string) $source['package_name'],
            'title' => $this->documentTitle($path, $relative),
            'language' => (string) $resolved['language'],
            'fallback_language' => $resolved['fallback_language'],
            'logical_path' => $relative,
            'relative_path' => $relative,
            'absolute_path' => $path,
            'docs_path' => $docsPath,
            'root_path' => (string) ($source['root_path'] ?? ''),
            'parent_id' => $parentId,
            'type' => 'document',
            'mtime' => $file->getMTime(),
            'checksum' => $this->checksum($file),
            'available_languages' => $resolved['available_languages'] ?? [],
            'is_vendor' => (bool) $source['is_vendor'],
            'readonly' => (bool) ($source['readonly'] ?? $source['is_vendor'] ?? true),
            'sort_order' => $this->sortOrder($relative),
        ];
    }

    /**
     * @param array<string, mixed> $options
     * @return list<SplFileInfo>
     */
    protected function markdownFiles(string $docsPath, array $options = []): array
    {
        $allowed = array_map('strtolower', Settings::list('allowed_extensions', ['md', 'mdx']));
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($docsPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
        );

        $files = [];
        foreach ($iterator as $file) {
            if (!$file instanceof SplFileInfo || !$file->isFile()) {
                continue;
            }

            if (!in_array(strtolower($file->getExtension()), $allowed, true)) {
                continue;
            }

            $relative = $this->paths->relativeTo($file->getPathname(), $docsPath);
            if ($relative === null || $this->shouldSkipRelativePath($relative, $options)) {
                continue;
            }

            $files[] = $file;
        }

        usort($files, fn (SplFileInfo $left, SplFileInfo $right): int => $this->comparePath($left->getPathname(), $right->getPathname()));

        return $files;
    }

    /**
     * @param array<string, mixed> $options
     * @return list<string>
     */
    protected function writableDirectories(string $docsPath, array $options = []): array
    {
        if (($options['root_readme_only'] ?? false) || !is_dir($docsPath)) {
            return [];
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($docsPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST,
        );

        $directories = [];
        foreach ($iterator as $item) {
            if (!$item instanceof SplFileInfo || !$item->isDir()) {
                continue;
            }

            $relative = $this->paths->relativeTo($item->getPathname(), $docsPath);
            if ($relative === null || $this->shouldSkipRelativePath($relative, $options)) {
                continue;
            }

            $directories[] = trim(str_replace('\\', '/', $relative), '/');
        }

        usort($directories, fn (string $left, string $right): int => $this->comparePath($left, $right));

        return $directories;
    }

    /**
     * @param array<string, mixed> $options
     */
    protected function shouldSkipRelativePath(string $relative, array $options): bool
    {
        $relative = trim(str_replace('\\', '/', $relative), '/');
        $segments = explode('/', $relative);
        $first = strtolower($segments[0] ?? '');

        if (($options['skip_language_dirs'] ?? false) && in_array($first, ['en', 'ua', 'uk', 'ru', 'pl', 'de', 'fr'], true)) {
            return true;
        }

        if (($options['skip_internal_tasks'] ?? false) && $first === 'tasks') {
            return true;
        }

        if (($options['skip_root_index'] ?? false) && count($segments) === 1 && in_array(strtolower($relative), ['readme.md', 'readme.mdx', 'index.md', 'index.mdx'], true)) {
            return true;
        }

        if (($options['root_readme_only'] ?? false) && (count($segments) !== 1 || !in_array(strtolower($relative), ['readme.md', 'readme.mdx', 'index.md', 'index.mdx'], true))) {
            return true;
        }

        return false;
    }

    protected function hasMarkdownFiles(string $path, bool $neutralOnly = false): bool
    {
        foreach ($this->markdownFiles($path, [
            'skip_language_dirs' => $neutralOnly,
            'skip_root_index' => false,
            'skip_internal_tasks' => true,
        ]) as $_file) {
            return true;
        }

        return false;
    }

    protected function documentTitle(string $path, string $relative): string
    {
        if ($this->isWithinMaxSize($path)) {
            $handle = fopen($path, 'rb');
            if (is_resource($handle)) {
                try {
                    while (($line = fgets($handle)) !== false) {
                        if (preg_match('/^#\s+(.+)$/', trim($line), $matches)) {
                            return trim($matches[1]);
                        }
                    }
                } finally {
                    fclose($handle);
                }
            }
        }

        return $this->label(pathinfo($relative, PATHINFO_FILENAME));
    }

    protected function label(string $value): string
    {
        $value = preg_replace('/^\d+[_\-\s]+/', '', $value) ?? $value;
        $value = str_replace(['_', '-'], ' ', $value);
        $value = trim(preg_replace('/\s+/', ' ', $value) ?? $value);

        return $value !== '' ? $value : 'Untitled';
    }

    protected function checksum(SplFileInfo $file): ?string
    {
        if (!$this->isWithinMaxSize($file->getPathname())) {
            return null;
        }

        return sha1_file($file->getPathname()) ?: null;
    }

    protected function isWithinMaxSize(string $path): bool
    {
        $maxKb = max(1, (int) config('dmi3yy.settings.dDocs.max_file_size_kb', 512));
        $size = filesize($path);

        return $size !== false && $size <= ($maxKb * 1024);
    }

    protected function nodeId(string $sourceKey, string $relative, string $language, string $type): string
    {
        return substr(sha1($sourceKey . '|' . $language . '|' . $type . '|' . $relative), 0, 20);
    }

    /**
     * Place selected package documentation inside the main dDocs source.
     *
     * The source keeps its own package metadata and descendants; only its
     * navigation parent changes, so documents are not copied or duplicated.
     *
     * @param list<array<string, mixed>> $nodes
     * @return list<array<string, mixed>>
     * @since 1.1.0
     */
    protected function organizeDocumentationSources(array $nodes): array
    {
        $documentationRootId = null;
        foreach ($nodes as $node) {
            if (
                ($node['parent_id'] ?? null) === null
                && strtolower((string) ($node['package_name'] ?? '')) === 'dmi3yy/ddocs'
            ) {
                $documentationRootId = (string) ($node['id'] ?? '');
                break;
            }
        }

        if ($documentationRootId === '') {
            return $nodes;
        }

        foreach ($nodes as &$node) {
            if (
                ($node['parent_id'] ?? null) === null
                && strtolower((string) ($node['package_name'] ?? '')) === 'evolution-cms/evo-ui'
            ) {
                $node['parent_id'] = $documentationRootId;
            }
        }
        unset($node);

        return $nodes;
    }

    /**
     * Compare indexed nodes for stable source and navigation ordering.
     *
     * @param array<string, mixed> $left
     * @param array<string, mixed> $right
     */
    protected function compareNodes(array $left, array $right): int
    {
        $sameParent = ($left['parent_id'] ?? null) !== null
            && ($left['parent_id'] ?? null) === ($right['parent_id'] ?? null);
        if ($sameParent && ($left['type'] ?? '') === 'folder' && ($right['type'] ?? '') === 'folder') {
            $navigation = $this->documentationFolderPriority($left) <=> $this->documentationFolderPriority($right);
            if ($navigation !== 0) {
                return $navigation;
            }
        }

        $source = $this->sourcePriority($left) <=> $this->sourcePriority($right);
        if ($source !== 0) {
            return $source;
        }

        $source = strnatcasecmp((string) $left['source_name'], (string) $right['source_name']);
        if ($source !== 0) {
            return $source;
        }

        $source = strnatcasecmp((string) $left['package_name'], (string) $right['package_name']);
        if ($source !== 0) {
            return $source;
        }

        return $this->comparePath((string) $left['relative_path'], (string) $right['relative_path'], (string) $left['type'], (string) $right['type']);
    }

    /**
     * Return the product documentation folder position in the dDocs source.
     *
     * @param array<string, mixed> $node
     * @since 1.1.0
     */
    protected function documentationFolderPriority(array $node): int
    {
        $package = strtolower((string) ($node['package_name'] ?? ''));
        $path = strtolower(trim((string) ($node['relative_path'] ?? ''), '/'));

        return match (true) {
            $package === 'dmi3yy/ddocs' && $path === 'evolution-cms' => 10,
            $package === 'evolution-cms/evo-ui' && $path === '' => 20,
            $package === 'dmi3yy/ddocs' && $path === 'ddocs' => 30,
            default => 100,
        };
    }

    /**
     * @param array<string, mixed> $node
     */
    protected function sourcePriority(array $node): int
    {
        if (($node['source_key'] ?? '') === 'ddocs-projectdocs') {
            return 1;
        }

        return strtolower((string) ($node['package_name'] ?? '')) === 'dmi3yy/ddocs' ? 2 : 10;
    }

    /**
     * Compare indexed paths for stable navigation order.
     *
     * Items are grouped by depth, then documents are placed before sibling
     * folders, with natural path ordering retained inside each type.
     */
    protected function comparePath(string $left, string $right, string $leftType = 'document', string $rightType = 'document'): int
    {
        $leftDepth = substr_count(trim($left, '/'), '/');
        $rightDepth = substr_count(trim($right, '/'), '/');
        if ($leftDepth !== $rightDepth) {
            return $leftDepth <=> $rightDepth;
        }

        if ($leftType !== $rightType) {
            return $leftType === 'document' ? -1 : 1;
        }

        return strnatcasecmp($this->sortOrder($left), $this->sortOrder($right));
    }

    protected function sortOrder(string $path): string
    {
        $basename = strtolower(pathinfo($path, PATHINFO_FILENAME));
        if (in_array($basename, ['readme', 'index'], true)) {
            return '0000-' . $basename;
        }

        return strtolower($path);
    }
}
