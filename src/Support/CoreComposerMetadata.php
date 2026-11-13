<?php

namespace Dmi3yy\dDocs\Support;

/**
 * Shows the installed core's Composer metadata in the bundled Composer reference.
 */
final class CoreComposerMetadata
{
    /**
     * Replace the documented field markers with values from the local core manifest.
     * The field names remain readable when the manifest or a value is unavailable.
     *
     * @param array<string, mixed> $document
     */
    public function render(string $markdown, array $document, string $corePath): string
    {
        if (($document['package_name'] ?? null) !== 'dmi3yy/ddocs'
            || ($document['relative_path'] ?? null) !== 'evolution-cms/10-reference/core-composer.md') {
            return $markdown;
        }

        $json = @file_get_contents(rtrim($corePath, '/\\') . '/composer.json', false, null, 0, 1048576);
        $manifest = $json === false ? null : json_decode($json, true);

        $fields = [
            'name' => $manifest['name'] ?? null,
            'type' => $manifest['type'] ?? null,
            'version' => $manifest['version'] ?? null,
            'license' => $manifest['license'] ?? null,
            'require.php' => $manifest['require']['php'] ?? null,
            'config.vendor-dir' => $manifest['config']['vendor-dir'] ?? (is_array($manifest) ? 'vendor' : null),
            'minimum-stability' => $manifest['minimum-stability'] ?? (is_array($manifest) ? 'stable' : null),
            'prefer-stable' => $manifest['prefer-stable'] ?? (is_array($manifest) ? false : null),
        ];

        $replacements = [];
        foreach ($fields as $field => $value) {
            if ($field === 'license' && is_array($value)) {
                $value = implode(', ', array_filter($value, 'is_string'));
            }
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            // Keep each value on one line and inside its Markdown table cell.
            $marker = '`' . $field . '`<!-- core-composer -->';
            $replacements[$marker] = '`' . $field . '`';
            if (is_string($value) && preg_match('~\A[\p{L}\p{N} ._+/@^<>=!\~*(),:|-]+\z~u', $value) === 1) {
                $replacements[$marker] = '`' . str_replace('|', '\\|', $value) . '`';
            }
        }

        return strtr($markdown, $replacements);
    }
}
