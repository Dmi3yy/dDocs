<?php namespace Dmi3yy\dDocs\Support;

final class LanguageResolver
{
    public function managerLanguage(): string
    {
        $configured = trim((string) config('dmi3yy.settings.dDocs.default_language', ''));
        if ($configured !== '') {
            return $this->normalize($configured);
        }

        if (isset($_SESSION['mgrUsrConfigSet']['manager_language'])) {
            return $this->normalize((string) $_SESSION['mgrUsrConfigSet']['manager_language']);
        }

        if (function_exists('evo')) {
            try {
                $language = evo()->getConfig('manager_language');
                if (is_string($language) && trim($language) !== '') {
                    return $this->normalize($language);
                }
            } catch (\Throwable) {
                // Continue through the fallback chain; manager boot order can vary.
            }
        }

        if (function_exists('evo') && is_file(evo()->getSiteCacheFilePath())) {
            $siteCache = (string) file_get_contents(evo()->getSiteCacheFilePath());
            preg_match('@\$c\[\'manager_language\'\]="\w+@i', $siteCache, $matches);

            if (count($matches)) {
                return $this->normalize(str_replace('$c[\'manager_language\']="', '', $matches[0]));
            }
        }

        if (function_exists('app')) {
            try {
                $language = app('db')->table('system_settings')
                    ->where('setting_name', 'manager_language')
                    ->value('setting_value');

                if (is_string($language) && trim($language) !== '') {
                    return $this->normalize($language);
                }
            } catch (\Throwable) {
                // Database access is a last-resort manager-language fallback only.
            }
        }

        if (function_exists('app')) {
            $locale = app()->getLocale();
            if (is_string($locale) && $locale !== '') {
                return $this->normalize($locale);
            }
        }

        return $this->normalize((string) config('dmi3yy.settings.dDocs.language_fallback', 'en'));
    }

    /**
     * Build the documentation locale chain for a manager language.
     *
     * Russian requests prefer Ukrainian documentation when a package does not
     * provide its own Russian locale, then continue to the configured fallback.
     *
     * @return list<string>
     */
    public function candidates(?string $language = null): array
    {
        $language = $this->normalize($language ?: $this->managerLanguage());
        $fallback = $this->normalize((string) config('dmi3yy.settings.dDocs.language_fallback', 'en'));

        $candidates = [$language];

        if ($language === 'ru') {
            $candidates[] = 'uk';
        }

        $candidates[] = $fallback;

        $candidates[] = 'neutral';

        return array_values(array_unique(array_filter($candidates)));
    }

    /**
     * @return array{path: string, language: string, fallback_language: string|null, available_languages: list<string>}
     */
    public function resolveDocsPath(string $docsPath, ?string $language = null): array
    {
        return $this->resolveDocsPaths($docsPath, $language)[0] ?? [
            'path' => $docsPath,
            'language' => 'neutral',
            'fallback_language' => null,
            'available_languages' => [],
        ];
    }

    /**
     * @return list<array{path: string, language: string, fallback_language: string|null, available_languages: list<string>}>
     */
    public function resolveDocsPaths(string $docsPath, ?string $language = null): array
    {
        $available = $this->availableLanguages($docsPath);
        $requested = $this->normalize($language ?: $this->managerLanguage());
        $resolved = [];

        foreach ($this->candidates($language) as $candidate) {
            if ($candidate === 'neutral' && $resolved === [] && $available['neutral'] !== null) {
                $resolved[] = [
                    'path' => $available['neutral'],
                    'language' => 'neutral',
                    'fallback_language' => $requested,
                    'available_languages' => array_keys($available['localized']),
                ];

                continue;
            }

            if (isset($available['localized'][$candidate])) {
                $resolved[] = [
                    'path' => $available['localized'][$candidate],
                    'language' => $candidate,
                    'fallback_language' => $candidate === $requested ? null : $candidate,
                    'available_languages' => array_keys($available['localized']),
                ];
            }
        }

        if ($resolved !== []) {
            return $resolved;
        }

        return [[
            'path' => $docsPath,
            'language' => 'neutral',
            'fallback_language' => null,
            'available_languages' => array_keys($available['localized']),
        ]];
    }

    /**
     * @return array{localized: array<string, string>, neutral: string|null}
     */
    public function availableLanguages(string $docsPath): array
    {
        $localized = [];
        foreach (['en', 'uk', 'ru', 'pl', 'de', 'fr'] as $language) {
            $candidate = $docsPath . DIRECTORY_SEPARATOR . $language;
            if (is_dir($candidate)) {
                $localized[$language] = $candidate;
            }
        }

        $legacyUkrainian = $docsPath . DIRECTORY_SEPARATOR . 'ua';
        if (!isset($localized['uk']) && is_dir($legacyUkrainian)) {
            $localized['uk'] = $legacyUkrainian;
        }

        $neutral = null;
        foreach (['pages', '.'] as $folder) {
            $candidate = $folder === '.' ? $docsPath : $docsPath . DIRECTORY_SEPARATOR . $folder;
            if ($this->hasMarkdownFiles($candidate)) {
                $neutral = $candidate;
                break;
            }
        }

        return [
            'localized' => $localized,
            'neutral' => $neutral,
        ];
    }

    public function normalize(string $language): string
    {
        $language = strtolower(trim(str_replace('_', '-', $language)));
        $language = explode('-', $language)[0] ?? 'en';

        if ($language === 'ua') {
            return 'uk';
        }

        return $language !== '' ? $language : 'en';
    }

    protected function hasMarkdownFiles(string $path): bool
    {
        if (!is_dir($path)) {
            return false;
        }

        foreach (['*.md', '*.mdx'] as $pattern) {
            if ((glob($path . DIRECTORY_SEPARATOR . $pattern) ?: []) !== []) {
                return true;
            }
        }

        return false;
    }
}
