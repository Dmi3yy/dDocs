<?php namespace Dmi3yy\dDocs\Support;

/**
 * Discover documentation roots and resolve package metadata for manager navigation.
 * Package branding is optional; existing localized names and Tabler icons remain fallbacks.
 */

final class DocsSourceRegistry
{
    protected DocumentPath $paths;

    public function __construct(?DocumentPath $paths = null)
    {
        $this->paths = $paths ?? new DocumentPath();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function sources(): array
    {
        $sources = [];

        foreach ($this->candidatePackageRoots() as $root) {
            foreach ($this->docsPathsForRoot($root) as $docsPath) {
                $source = $this->sourceFromPath($root, $docsPath, 'package', true);
                $sources[$source['key']] = $source;
            }
        }

        foreach ($this->userDocsSources() as $source) {
            $sources[$source['key']] = $source;
        }

        foreach ($this->configuredRoots() as $root) {
            foreach ($this->docsPathsForRoot($root) as $docsPath) {
                $source = $this->sourceFromPath($root, $docsPath, 'project', false);
                $sources[$source['key']] = $source;
            }
        }

        return array_values($sources);
    }

    /**
     * @return list<string>
     */
    protected function candidatePackageRoots(): array
    {
        $roots = [$this->packageRoot()];

        if ((bool) config('dmi3yy.settings.dDocs.scan_vendor_packages', true)) {
            $roots = array_merge($roots, $this->composerInstalledRoots(), $this->vendorPackageRoots());
        }

        return $this->uniqueExistingDirectories($roots);
    }

    public function userDocsPath(): string
    {
        return $this->packageRoot() . DIRECTORY_SEPARATOR . 'ProjectDocs';
    }

    /**
     * @return list<array<string, mixed>>
     */
    protected function userDocsSources(): array
    {
        $path = $this->paths->normalize($this->userDocsPath());
        if ($path === null || !is_dir($path)) {
            return [];
        }

        return [[
            'key' => 'ddocs-projectdocs',
            'name' => ManagerText::get('project_docs') ?: 'Project Docs',
            'description' => ManagerText::get('project_docs_description') ?: '',
            'icon' => 'tabler-folder',
            'type' => 'project',
            'source_type' => 'project',
            'package_name' => 'project/docs',
            'root_path' => $path,
            'docs_path' => $path,
            'root_readme_only' => false,
            'is_vendor' => false,
            'readonly' => false,
            'enabled' => true,
        ]];
    }

    /**
     * @return list<string>
     */
    protected function configuredRoots(): array
    {
        if (!(bool) config('dmi3yy.settings.dDocs.scan_project_docs', true)) {
            return [];
        }

        $roots = array_merge(
            Settings::list('safe_roots'),
            Settings::list('extra_docs_roots'),
        );

        return $this->uniqueExistingDirectories($roots);
    }

    /**
     * @return list<string>
     */
    protected function composerInstalledRoots(): array
    {
        $vendorRoot = $this->vendorRoot();
        if ($vendorRoot === null) {
            return [];
        }

        $installedJson = $vendorRoot . '/composer/installed.json';
        if (!is_file($installedJson)) {
            return [];
        }

        $payload = json_decode((string) file_get_contents($installedJson), true);
        if (!is_array($payload)) {
            return [];
        }

        $packages = $payload['packages'] ?? $payload;
        if (!is_array($packages)) {
            return [];
        }

        $roots = [];
        foreach ($packages as $package) {
            if (!is_array($package)) {
                continue;
            }

            $installPath = (string) ($package['install-path'] ?? '');
            if ($installPath === '') {
                continue;
            }

            $root = $this->resolveRelative($vendorRoot . '/composer', $installPath);
            if ($this->isDiscoverablePackage($package, $root)) {
                $roots[] = $root;
            }
        }

        return $roots;
    }

    /**
     * @return list<string>
     */
    protected function vendorPackageRoots(): array
    {
        $vendorRoot = $this->vendorRoot();
        if ($vendorRoot === null || !is_dir($vendorRoot)) {
            return [];
        }

        $roots = [];
        foreach (glob($vendorRoot . '/*/*', GLOB_ONLYDIR) ?: [] as $candidate) {
            $metadata = $this->composerMetadata($candidate);
            if ($metadata !== [] && $this->isDiscoverablePackage($metadata, $candidate)) {
                $roots[] = $candidate;
            }
        }

        return $roots;
    }

    /**
     * @return list<string>
     */
    protected function docsPathsForRoot(string $root): array
    {
        $paths = [];

        foreach (['Docs', 'docs'] as $folder) {
            $candidate = $root . DIRECTORY_SEPARATOR . $folder;
            if (is_dir($candidate)) {
                $paths[] = $candidate;
            }
        }

        if ($paths !== []) {
            return $this->uniqueExistingDirectories($paths);
        }

        foreach (['README.md', 'README.mdx', 'index.md', 'index.mdx'] as $file) {
            $candidate = $root . DIRECTORY_SEPARATOR . $file;
            if (is_file($candidate)) {
                $paths[] = $root;
                break;
            }
        }

        return $this->uniqueExistingDirectories($paths);
    }

    /**
     * @return array<string, mixed>
     */
    protected function sourceFromPath(string $root, string $docsPath, string $type, bool $vendor): array
    {
        $composer = $this->composerMetadata($root);
        $package = (string) ($composer['name'] ?? basename($root));
        $name = $this->displayName($package, $root, $composer);
        $key = $this->sourceKey($package, $docsPath);
        $isVendor = $vendor;

        return [
            'key' => $key,
            'name' => $name,
            'description' => $this->displayDescription($package, $root, $composer),
            'icon' => $this->displayIcon($package, $root, $composer),
            'type' => $type,
            'source_type' => $type,
            'package_name' => $package,
            'root_path' => $this->paths->normalize($root),
            'docs_path' => $this->paths->normalize($docsPath),
            'root_readme_only' => $this->isRootReadmeOnly($root, $docsPath),
            'is_vendor' => $isVendor,
            'readonly' => $isVendor,
            'enabled' => true,
        ];
    }

    protected function isRootReadmeOnly(string $root, string $docsPath): bool
    {
        $root = $this->paths->normalize($root);
        $docsPath = $this->paths->normalize($docsPath);

        return $root !== null && $docsPath !== null && $root === $docsPath;
    }

    protected function isUnderVendor(string $path): bool
    {
        $parts = explode(DIRECTORY_SEPARATOR, trim($path, DIRECTORY_SEPARATOR));

        return in_array('vendor', $parts, true);
    }

    /**
     * @return array<string, mixed>
     */
    protected function composerMetadata(string $root): array
    {
        $path = $root . '/composer.json';
        if (!is_file($path)) {
            return [];
        }

        $payload = json_decode((string) file_get_contents($path), true);

        return is_array($payload) ? $payload : [];
    }

    /**
     * @param array<string, mixed> $package
     */
    protected function isDiscoverablePackage(array $package, string $root): bool
    {
        $name = strtolower((string) ($package['name'] ?? ''));
        foreach (['dmi3yy/', 'seiger/', 'evolution-cms/', 'evolutioncms-services/'] as $prefix) {
            if (str_starts_with($name, $prefix)) {
                return true;
            }
        }

        $type = strtolower((string) ($package['type'] ?? ''));
        if (str_contains($type, 'evolution') || str_contains($type, 'evo')) {
            return true;
        }

        $providers = $package['extra']['laravel']['providers'] ?? [];
        if (is_array($providers)) {
            foreach ($providers as $provider) {
                $provider = (string) $provider;
                if (
                    str_starts_with($provider, 'Dmi3yy\\')
                    || str_starts_with($provider, 'Seiger\\')
                    || str_starts_with($provider, 'EvoUI\\')
                    || str_starts_with($provider, 'EvolutionCMS\\')
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Resolve the catalog label without altering the Composer package identifier.
     *
     * Explicit Composer branding is language-independent; packages without it keep
     * their localized metadata, aliases, and generated-name fallbacks.
     *
     * @param array<string, mixed> $composer Package composer.json metadata.
     * @return string Display label shared by source cards and navigation nodes.
     */
    protected function displayName(string $package, string $root, array $composer): string
    {
        // An explicit package brand is locale-independent and must retain its spelling.
        $name = $composer['extra']['ddocs']['name'] ?? null;
        if (is_string($name) && trim($name) !== '') {
            return trim($name);
        }

        $translated = $this->translatedPackageName($package, $root);
        if ($translated !== null) {
            return $translated;
        }

        $aliases = $composer['extra']['laravel']['aliases'] ?? [];
        if (is_array($aliases) && $aliases !== []) {
            $alias = (string) array_key_first($aliases);
            if ($alias !== '') {
                return $alias;
            }
        }

        $canonical = [
            'dmi3yy/ddocs' => 'dDocs',
            'dmi3yy/dissues' => 'dIssues',
            'dmi3yy/dtui-editor' => 'dTui Editor',
            'evolution-cms/etinymce' => 'eTinyMCE',
            'evolution-cms/evo-ui' => 'evo-ui',
            'seiger/sarticles' => 'sArticles',
            'seiger/slang' => 'sLang',
            'seiger/sseo' => 'sSeo',
        ];

        if (isset($canonical[strtolower($package)])) {
            return $canonical[strtolower($package)];
        }

        $name = str_contains($package, '/') ? substr($package, strrpos($package, '/') + 1) : $package;
        $name = str_replace(['-', '_'], ' ', $name);
        $name = preg_replace('/\s+/', ' ', $name) ?: $name;

        return $name !== '' ? ucwords($name) : basename($root);
    }

    protected function translatedPackageName(string $package, string $root): ?string
    {
        $keys = $this->metadataKeys($package, 'title');

        if ($keys === []) {
            return null;
        }

        foreach (ManagerText::languageCandidates() as $language) {
            $path = $root . '/lang/' . $language . '/global.php';
            if (!is_file($path)) {
                continue;
            }

            $labels = include $path;
            if (!is_array($labels)) {
                continue;
            }

            foreach ($keys as $key) {
                $value = trim((string) ($labels[$key] ?? ''));
                if ($value !== '') {
                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * Resolve an opt-in package image or the existing Tabler icon for cards and tree nodes.
     * Invalid custom metadata falls back without changing other packages or exposing files.
     *
     * @param array<string, mixed> $composer Installed package metadata.
     * @return string Tabler identifier or a package-local SVG encoded as an image data URI.
     */
    protected function displayIcon(string $package, string $root, array $composer): string
    {
        $custom = $this->packageIconSvg($root, $composer['extra']['ddocs']['icon_svg'] ?? null);
        if ($custom !== null) {
            return $custom;
        }

        // Packages may declare a Tabler name, never raw SVG or a filesystem path.
        $icon = $composer['extra']['ddocs']['icon'] ?? null;
        if (is_string($icon) && preg_match('/\Atabler-[a-z0-9]+(?:-[a-z0-9]+)*\z/', trim($icon))) {
            return trim($icon);
        }

        $translated = $this->translatedMetadata($package, $root, 'icon');
        if ($translated !== null) {
            return $translated;
        }

        return [
            'dmi3yy/ddocs' => 'tabler-book-2',
            'dmi3yy/dissues' => 'tabler-circle-dot',
            'dmi3yy/dtui-editor' => 'tabler-pencil',
            'evolution-cms/etinymce' => 'tabler-writing',
            'evolution-cms/evo-ui' => 'tabler-brush',
            'seiger/sarticles' => 'tabler-rss',
            'seiger/slang' => 'tabler-language',
            'seiger/sseo' => 'tabler-chart-line',
        ][strtolower($package)] ?? 'tabler-package';
    }

    /**
     * @param array<string, mixed> $composer
     */
    protected function displayDescription(string $package, string $root, array $composer): string
    {
        $translated = $this->translatedMetadata($package, $root, 'description');
        if ($translated !== null) {
            return $this->cleanDescription($translated);
        }

        $description = trim((string) ($composer['description'] ?? ''));
        if ($description !== '') {
            return $this->cleanDescription($description);
        }

        return $this->cleanDescription([
            'dmi3yy/ddocs' => 'File-first documentation browser for Evolution CMS manager.',
            'dmi3yy/dissues' => 'Task board and issue workflow for Evolution manager.',
            'dmi3yy/dtui-editor' => 'Toast UI based Markdown and rich text editor for Evolution manager.',
            'evolution-cms/etinymce' => 'TinyMCE integration for Evolution CMS manager.',
            'evolution-cms/evo-ui' => 'Shared Evolution manager UI components and styling primitives.',
            'seiger/sarticles' => 'Publication and article management module for Evolution CMS.',
            'seiger/slang' => 'Multilingual content and language tools for Evolution CMS.',
            'seiger/sseo' => 'SEO tools and metadata management for Evolution CMS.',
        ][strtolower($package)] ?? '');
    }

    /**
     * Read an explicitly declared SVG inside its package, or keep the Tabler fallback.
     *
     * Return an image data URI, not inline markup: SVG scripts cannot execute in
     * the manager document. Resolve symlinks before checking the package boundary.
     *
     * @param string $root Installed package directory.
     * @param mixed $relative Optional package-relative extra.ddocs.icon_svg value.
     * @return string|null SVG image data URI, or null for an invalid/unreadable asset.
     * @since 1.2.0
     */
    protected function packageIconSvg(string $root, mixed $relative): ?string
    {
        if (!is_string($relative) || !preg_match('/\A[a-zA-Z0-9_-][a-zA-Z0-9_\/.\-]*\.svg\z/i', $relative)) {
            return null;
        }
        $base = realpath($root);
        $path = $base === false ? false : realpath($base . '/' . $relative);
        if ($path === false || !str_starts_with($path, $base . DIRECTORY_SEPARATOR)
            || !is_file($path) || !is_readable($path)) {
            return null;
        }
        $svg = file_get_contents($path, false, null, 0, 65537);
        if ($svg === false || trim($svg) === '' || strlen($svg) > 65536 || stripos($svg, '<!DOCTYPE') !== false) {
            return null;
        }
        $previous = libxml_use_internal_errors(true);
        try {
            $document = new \DOMDocument();
            if (!$document->loadXML($svg, LIBXML_NONET) || $document->documentElement?->localName !== 'svg'
                || $document->documentElement?->namespaceURI !== 'http://www.w3.org/2000/svg') {
                return null;
            }
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    protected function cleanDescription(string $description): string
    {
        $description = html_entity_decode(strip_tags($description), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $description = trim(preg_replace('/\s+/', ' ', $description) ?? $description);

        return mb_strlen($description) > 140 ? mb_substr($description, 0, 137) . '...' : $description;
    }

    protected function translatedMetadata(string $package, string $root, string $kind): ?string
    {
        $keys = $this->metadataKeys($package, $kind);
        if ($keys === []) {
            return null;
        }

        foreach (ManagerText::languageCandidates() as $language) {
            $path = $root . '/lang/' . $language . '/global.php';
            if (!is_file($path)) {
                continue;
            }

            $labels = include $path;
            if (!is_array($labels)) {
                continue;
            }

            foreach ($keys as $key) {
                $value = trim((string) ($labels[$key] ?? ''));
                if ($value !== '') {
                    return $value;
                }
            }
        }

        return null;
    }

    /**
     * @return list<string>
     */
    protected function metadataKeys(string $package, string $kind): array
    {
        $genericKeys = [
            'title' => ['module_title'],
            'icon' => ['module_icon'],
            'description' => ['module_description'],
        ];

        $titleKeys = [
            'dmi3yy/ddocs' => ['module_title', 'docs', 'documentation'],
            'dmi3yy/dissues' => ['module_title', 'issues'],
            'evolution-cms/evo-ui' => ['module_title'],
            'seiger/sarticles' => ['module_title', 'articles'],
            'seiger/slang' => ['module_title', 'slang'],
            'seiger/sseo' => ['module_title', 'title'],
        ];

        $iconKeys = [
            'dmi3yy/ddocs' => ['module_icon', 'docs_icon'],
            'dmi3yy/dissues' => ['module_icon', 'issues_icon'],
            'evolution-cms/evo-ui' => ['module_icon'],
            'seiger/sarticles' => ['module_icon', 'articles_icon'],
            'seiger/slang' => ['module_icon', 'slang_icon'],
            'seiger/sseo' => ['module_icon', 'icon'],
        ];

        $descriptionKeys = [
            'dmi3yy/ddocs' => ['module_description', 'file_only_subtitle', 'description'],
            'dmi3yy/dissues' => ['module_description', 'description'],
            'dmi3yy/dtui-editor' => ['module_description', 'description'],
            'evolution-cms/evo-ui' => ['module_description', 'description'],
            'seiger/sarticles' => ['module_description', 'description'],
            'seiger/slang' => ['module_description', 'description'],
            'seiger/sseo' => ['module_description', 'description'],
        ];

        $packageKeys = match ($kind) {
            'icon' => $iconKeys[strtolower($package)] ?? [],
            'description' => $descriptionKeys[strtolower($package)] ?? [],
            default => $titleKeys[strtolower($package)] ?? [],
        };

        return array_values(array_unique(array_merge(
            $genericKeys[$kind] ?? $genericKeys['title'],
            $packageKeys
        )));
    }

    protected function sourceKey(string $package, string $docsPath): string
    {
        $base = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $package) ?: basename($docsPath));
        $hash = substr(sha1((string) $this->paths->normalize($docsPath)), 0, 10);

        return trim($base, '-') . '-' . $hash;
    }

    protected function packageRoot(): string
    {
        return dirname(__DIR__, 2);
    }

    protected function vendorRoot(): ?string
    {
        if (function_exists('base_path')) {
            $path = base_path('vendor');
            if (is_dir($path)) {
                return $path;
            }
        }

        $current = $this->packageRoot();
        while ($current !== dirname($current)) {
            $candidate = $current . '/vendor';
            if (is_dir($candidate)) {
                return $candidate;
            }

            $current = dirname($current);
        }

        return null;
    }

    protected function resolveRelative(string $base, string $path): string
    {
        if (str_starts_with($path, DIRECTORY_SEPARATOR)) {
            return $path;
        }

        return $base . DIRECTORY_SEPARATOR . $path;
    }

    /**
     * @param list<mixed> $paths
     * @return list<string>
     */
    protected function uniqueExistingDirectories(array $paths): array
    {
        $result = [];
        foreach ($paths as $path) {
            if (!is_string($path)) {
                continue;
            }

            $real = $this->paths->normalize($path);
            if ($real !== null && is_dir($real)) {
                $result[strtolower($real)] = $real;
            }
        }

        return array_values($result);
    }
}
