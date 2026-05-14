<?php namespace Dmi3yy\dDocs\Support;

final class Diagnostics
{
    protected DocsSourceRegistry $sources;
    protected DocsIndexer $indexer;
    protected FileIndexCache $cache;
    protected DocumentPath $paths;

    public function __construct(?DocsSourceRegistry $sources = null, ?DocsIndexer $indexer = null, ?FileIndexCache $cache = null, ?DocumentPath $paths = null)
    {
        $this->paths = $paths ?? new DocumentPath();
        $this->sources = $sources ?? new DocsSourceRegistry($this->paths);
        $this->indexer = $indexer ?? new DocsIndexer(paths: $this->paths);
        $this->cache = $cache ?? new FileIndexCache(paths: $this->paths);
    }

    /**
     * @return array<string, mixed>
     */
    public function report(): array
    {
        $sources = $this->sources->sources();
        $nodes = $this->indexer->index();
        $documents = array_values(array_filter($nodes, fn (array $node): bool => ($node['type'] ?? '') === 'document'));

        return [
            'mode' => 'file-only',
            'cache_index' => $this->cache->enabled(),
            'cache_path' => $this->cache->enabled() ? $this->cache->cachePath() : null,
            'sources_count' => count($sources),
            'documents_count' => count($documents),
            'languages' => $this->languages($documents),
            'sources' => array_map(fn (array $source): array => [
                'key' => $source['key'],
                'name' => $source['name'],
                'type' => $source['source_type'],
                'package_name' => $source['package_name'],
                'docs_path' => $source['docs_path'],
                'is_vendor' => $source['is_vendor'],
            ], $sources),
            'path_safety' => $this->pathSafety($documents[0] ?? null),
        ];
    }

    /**
     * @param list<array<string, mixed>> $documents
     * @return array<string, int>
     */
    protected function languages(array $documents): array
    {
        $languages = [];
        foreach ($documents as $document) {
            $language = (string) ($document['language'] ?? 'neutral');
            $languages[$language] = ($languages[$language] ?? 0) + 1;
        }

        ksort($languages);

        return $languages;
    }

    /**
     * @param array<string, mixed>|null $document
     * @return array<string, bool>
     */
    protected function pathSafety(?array $document): array
    {
        if ($document === null) {
            return [
                'has_document' => false,
                'escape_blocked' => true,
            ];
        }

        $escape = dirname((string) $document['docs_path']) . DIRECTORY_SEPARATOR . basename((string) $document['absolute_path']);

        return [
            'has_document' => true,
            'safe_document_inside_root' => $this->paths->isInside((string) $document['absolute_path'], (string) $document['docs_path']),
            'escape_blocked' => !$this->paths->isInside($escape, (string) $document['docs_path']),
        ];
    }
}
