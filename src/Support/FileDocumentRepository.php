<?php namespace Dmi3yy\dDocs\Support;

final class FileDocumentRepository
{
    public function __construct(
        protected ?DocumentPath $paths = null,
    ) {
        $this->paths ??= new DocumentPath();
    }

    public function find(array $nodes, string $id): ?array
    {
        foreach ($nodes as $node) {
            if (($node['id'] ?? '') === $id && ($node['type'] ?? '') === 'document') {
                return $node;
            }
        }

        return null;
    }

    public function read(array $node): ?string
    {
        $path = (string) ($node['absolute_path'] ?? '');
        $docsPath = (string) ($node['docs_path'] ?? '');

        if (!$this->isReadableDocument($path, $docsPath)) {
            return null;
        }

        $content = file_get_contents($path);

        return $content === false ? null : $content;
    }

    public function isReadableDocument(string $path, string $docsPath): bool
    {
        if (!is_file($path) || !$this->paths->isInside($path, $docsPath)) {
            return false;
        }

        $allowed = array_map('strtolower', Settings::list('allowed_extensions', ['md', 'mdx']));
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowed, true)) {
            return false;
        }

        $maxKb = max(1, (int) config('dmi3yy.settings.dDocs.max_file_size_kb', 512));
        $size = filesize($path);

        return $size !== false && $size <= ($maxKb * 1024);
    }
}
