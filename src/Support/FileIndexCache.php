<?php namespace Dmi3yy\dDocs\Support;

/**
 * Cache documentation nodes without making generated cache corruption fatal.
 *
 * Published cache files are replaced atomically so concurrent manager requests
 * never include a partially written PHP payload.
 */
final class FileIndexCache
{
    protected const SCHEMA_VERSION = 2;

    /** @var array<string, list<array<string, mixed>>> */
    protected array $memo = [];

    protected DocsIndexer $indexer;
    protected DocumentPath $paths;
    protected LanguageResolver $languages;

    public function __construct(?DocsIndexer $indexer = null, ?DocumentPath $paths = null, ?LanguageResolver $languages = null)
    {
        $this->paths = $paths ?? new DocumentPath();
        $this->languages = $languages ?? new LanguageResolver();
        $this->indexer = $indexer ?? new DocsIndexer(paths: $this->paths);
    }

    /**
     * Return cached nodes or rebuild an invalid, truncated, or outdated index.
     *
     * A parse error in the generated cache is treated as a cache miss. Fresh
     * nodes remain available even when publishing the cache cannot complete.
     *
     * @param string|null $language Requested documentation locale.
     * @param bool $refresh Bypass both the request memo and persisted cache.
     * @return list<array<string, mixed>>
     */
    public function index(?string $language = null, bool $refresh = false): array
    {
        $languageKey = $this->languageKey($language);

        if (!$refresh && isset($this->memo[$languageKey])) {
            return $this->memo[$languageKey];
        }

        if (!$this->enabled()) {
            return $this->memo[$languageKey] = $this->indexer->index($language);
        }

        $path = $this->cachePath();
        if ($path === null) {
            return $this->memo[$languageKey] = $this->indexer->index($language);
        }

        if (!$refresh && is_file($path)) {
            try {
                $payload = include $path;
            } catch (\ParseError) {
                // A truncated generated cache must not prevent rebuilding the index.
                $payload = null;
            }
            if (
                is_array($payload)
                && (int) ($payload['schema'] ?? 1) === self::SCHEMA_VERSION
                && ($payload['language'] ?? null) === $languageKey
                && is_array($payload['nodes'] ?? null)
            ) {
                $nodes = array_values(array_filter($payload['nodes'], 'is_array'));

                return $this->memo[$languageKey] = $nodes;
            }
        }

        $nodes = $this->indexer->index($language);
        $this->write($path, $nodes, $languageKey);

        return $this->memo[$languageKey] = $nodes;
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function refresh(?string $language = null): array
    {
        return $this->index($language, true);
    }

    public function enabled(): bool
    {
        return (bool) config('dmi3yy.settings.dDocs.cache_index', false);
    }

    public function cachePath(): ?string
    {
        $configured = trim((string) config('dmi3yy.settings.dDocs.index_cache_path', ''));
        $path = $configured !== '' ? $configured : $this->defaultCachePath();

        if ($path === null) {
            return null;
        }

        $directory = dirname($path);
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            return null;
        }

        return $this->isAllowedCachePath($path) ? $path : null;
    }

    /**
     * Publish a complete PHP payload through a temporary file in the same directory.
     *
     * Preserve existing permissions, clean up failed writes, and invalidate
     * OPcache after replacement so readers receive the newly generated index.
     *
     * @param string $path Validated cache destination.
     * @param list<array<string, mixed>> $nodes
     * @param string $language Normalized cache locale.
     * @return void
     */
    protected function write(string $path, array $nodes, string $language): void
    {
        $payload = [
            'schema' => self::SCHEMA_VERSION,
            'generated_at' => date('c'),
            'language' => $language,
            'nodes' => $nodes,
        ];

        $contents = "<?php\n\nreturn " . var_export($payload, true) . ";\n";
        $temporary = tempnam(dirname($path), '.ddocs-index-');
        if ($temporary === false) {
            return;
        }

        try {
            if (file_put_contents($temporary, $contents, LOCK_EX) !== strlen($contents)) {
                return;
            }
            $permissions = is_file($path) ? fileperms($path) : false;
            chmod($temporary, $permissions !== false ? ($permissions & 0777) : (0664 & ~umask()));
            // Readers see either the complete old file or the complete new file.
            if (rename($temporary, $path) && function_exists('opcache_invalidate')) {
                opcache_invalidate($path, true);
            }
        } finally {
            if (is_file($temporary)) {
                unlink($temporary);
            }
        }
    }

    protected function defaultCachePath(): ?string
    {
        foreach ($this->rawCacheRoots() as $root) {
            return rtrim($root, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'ddocs-index.php';
        }

        return null;
    }

    protected function isAllowedCachePath(string $path): bool
    {
        $directory = dirname($path);
        foreach ($this->cacheRoots() as $root) {
            if ($this->paths->isInside($directory, $root)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<string>
     */
    protected function cacheRoots(): array
    {
        return array_values(array_filter(array_map(fn (string $root): ?string => $this->paths->normalize($root), $this->rawCacheRoots())));
    }

    /**
     * @return list<string>
     */
    protected function rawCacheRoots(): array
    {
        $roots = [];

        if (function_exists('storage_path')) {
            $roots[] = storage_path('framework/cache');
        }

        if (function_exists('base_path')) {
            $roots[] = base_path('bootstrap/cache');
        }

        $roots = array_merge($roots, Settings::list('safe_roots'));

        return array_values(array_filter($roots));
    }

    protected function languageKey(?string $language): string
    {
        return $this->languages->normalize($language ?: $this->languages->managerLanguage());
    }
}
