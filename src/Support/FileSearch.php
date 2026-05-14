<?php namespace Dmi3yy\dDocs\Support;

final class FileSearch
{
    public function __construct(
        protected ?FileDocumentRepository $documents = null,
    ) {
        $this->documents ??= new FileDocumentRepository();
    }

    public function filter(array $nodes, string $query): array
    {
        $query = trim(mb_strtolower($query));
        if ($query === '') {
            return $nodes;
        }

        $matches = [];
        $byId = [];

        foreach ($nodes as $node) {
            $byId[(string) $node['id']] = $node;

            if ($this->matchesNode($node, $query)) {
                $matches[(string) $node['id']] = true;
                $parent = $node['parent_id'] ?? null;
                while ($parent !== null && isset($byId[$parent])) {
                    $matches[$parent] = true;
                    $parent = $byId[$parent]['parent_id'] ?? null;
                }
            }
        }

        return array_values(array_filter($nodes, fn (array $node): bool => isset($matches[(string) $node['id']])));
    }

    protected function matchesNode(array $node, string $query): bool
    {
        $haystack = mb_strtolower(implode(' ', [
            (string) ($node['title'] ?? ''),
            (string) ($node['relative_path'] ?? ''),
            (string) ($node['source_name'] ?? ''),
            (string) ($node['package_name'] ?? ''),
        ]));

        if (str_contains($haystack, $query)) {
            return true;
        }

        if (($node['type'] ?? '') !== 'document') {
            return false;
        }

        $content = $this->documents->read($node);
        if ($content === null) {
            return false;
        }

        return str_contains(mb_strtolower($content), $query);
    }
}
