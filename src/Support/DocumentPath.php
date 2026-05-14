<?php namespace Dmi3yy\dDocs\Support;

final class DocumentPath
{
    public function normalize(string $path): ?string
    {
        $path = trim($path);
        if ($path === '') {
            return null;
        }

        $real = realpath($path);

        return $real !== false ? $real : null;
    }

    public function isInside(string $path, string $root): bool
    {
        $path = $this->normalize($path);
        $root = $this->normalize($root);

        if ($path === null || $root === null) {
            return false;
        }

        return $path === $root || str_starts_with($path, $root . DIRECTORY_SEPARATOR);
    }

    /**
     * @param list<string> $roots
     */
    public function isInsideAny(string $path, array $roots): bool
    {
        foreach ($roots as $root) {
            if (is_string($root) && $this->isInside($path, $root)) {
                return true;
            }
        }

        return false;
    }

    public function relativeTo(string $path, string $root): ?string
    {
        $path = $this->normalize($path);
        $root = $this->normalize($root);

        if ($path === null || $root === null || !$this->isInside($path, $root)) {
            return null;
        }

        return ltrim(str_replace('\\', '/', substr($path, strlen($root))), '/');
    }
}
