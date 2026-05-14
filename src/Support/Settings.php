<?php namespace Dmi3yy\dDocs\Support;

final class Settings
{
    /**
     * @param list<mixed> $default
     * @return list<string>
     */
    public static function list(string $key, array $default = []): array
    {
        $value = config('dmi3yy.settings.dDocs.' . $key, $default);

        if (is_array($value)) {
            return array_values(array_filter(array_map('trim', array_map('strval', $value))));
        }

        return array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', (string) $value) ?: [])));
    }
}
