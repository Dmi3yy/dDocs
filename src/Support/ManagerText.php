<?php namespace Dmi3yy\dDocs\Support;

final class ManagerText
{
    /**
     * @return array<string, mixed>
     */
    public static function all(): array
    {
        return self::labels(self::language());
    }

    /**
     * @param array<string, scalar> $replace
     */
    public static function get(string $key, array $replace = []): string
    {
        $value = self::all()[$key] ?? self::labels('en')[$key] ?? $key;

        foreach ($replace as $name => $replacement) {
            $value = str_replace(':' . $name, (string) $replacement, $value);
        }

        return $value;
    }

    public static function choice(string $key, int $count): string
    {
        $value = self::get($key, ['count' => $count]);
        $parts = explode('|', $value);

        if ($count === 0 && isset($parts[0])) {
            return self::cleanChoice($parts[0], $count);
        }

        if ($count === 1 && isset($parts[1])) {
            return self::cleanChoice($parts[1], $count);
        }

        return self::cleanChoice(end($parts) ?: $value, $count);
    }

    /**
     * @return array<string, mixed>
     */
    protected static function labels(string $language): array
    {
        $path = dirname(__DIR__, 2) . '/lang/' . $language . '/global.php';

        if (!is_file($path)) {
            $path = dirname(__DIR__, 2) . '/lang/en/global.php';
        }

        $labels = include $path;

        return is_array($labels) ? $labels : [];
    }

    public static function language(): string
    {
        if (isset($_SESSION['mgrUsrConfigSet']['manager_language'])) {
            return (string) $_SESSION['mgrUsrConfigSet']['manager_language'];
        }

        if (function_exists('evo')) {
            try {
                $language = evo()->getConfig('manager_language');
                if (is_string($language) && trim($language) !== '') {
                    return $language;
                }
            } catch (\Throwable) {
                // Continue through fallbacks; manager boot order can differ per entrypoint.
            }
        }

        if (function_exists('evo') && is_file(evo()->getSiteCacheFilePath())) {
            $siteCache = (string) file_get_contents(evo()->getSiteCacheFilePath());
            preg_match('@\$c\[\'manager_language\'\]="\w+@i', $siteCache, $matches);

            if (count($matches) > 0) {
                return str_replace('$c[\'manager_language\']="', '', $matches[0]);
            }
        }

        if (function_exists('app')) {
            try {
                $language = app('db')->table('system_settings')
                    ->where('setting_name', 'manager_language')
                    ->value('setting_value');

                if (is_string($language) && trim($language) !== '') {
                    return $language;
                }
            } catch (\Throwable) {
                // Keep label lookup file-only unless the manager database is already available.
            }
        }

        return 'en';
    }

    /**
     * @return list<string>
     */
    public static function languageCandidates(): array
    {
        $language = self::language();
        $candidates = match ($language) {
            'uk' => ['uk', 'ua', 'en'],
            'ua' => ['ua', 'uk', 'en'],
            default => [$language, 'en'],
        };

        return array_values(array_unique(array_filter($candidates)));
    }

    protected static function cleanChoice(string $value, int $count): string
    {
        $value = preg_replace('/^\\{\\d+\\}\\s*/', '', $value) ?? $value;
        $value = preg_replace('/^\\[.*?\\]\\s*/', '', $value) ?? $value;

        return str_replace(':count', (string) $count, $value);
    }
}
