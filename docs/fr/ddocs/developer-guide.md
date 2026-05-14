# Guide développeur

Ce guide explique comment dDocs est câblé, comment il découvre la documentation
et comment les développeurs doivent l'étendre en sécurité.

## Modèle runtime

```text
DocsSourceRegistry -> DocsIndexer -> FileIndexCache
                                  -> FileDocumentRepository
ModulePanel        -> raw Markdown payload
Browser viewer     -> dTui/TOAST UI + Prism
LinkResolver       -> link, image, and UML maps
DocumentPath       -> path safety checks
FileSearch         -> title, path, source, and content search
```

Le système de fichiers est la source de vérité. dDocs n'utilise pas de tables de
base de données pour la documentation des paquets.

## Services

| Service | Responsabilité |
| --- | --- |
| `DocsSourceRegistry` | Trouve les docs de paquets, docs projet, roots configurées et métadonnées de source. |
| `DocsIndexer` | Construit les nœuds dossiers et documents avec ids stables, métadonnées de langue, fusion des branches fallback, timestamps et checksums. |
| `FileIndexCache` | Stocke et rafraîchit le cache de métadonnées PHP généré. |
| `FileDocumentRepository` | Lit les fichiers Markdown sélectionnés après contrôles de sécurité. |
| `LanguageResolver` | Résout la langue manager, normalise l'entrée legacy `ua` vers `uk`, retourne les locale roots ordonnées et trouve les docs neutres. |
| `ManagerText` | Charge les labels UI manager depuis `lang/<locale>/global.php` avec fallback vers les labels anglais. |
| `LinkResolver` | Résout les liens internes, images locales, HTML sûr, langues de code et URL d'images UML. |
| `FileSearch` | Filtre les nœuds par titre, chemin, nom de paquet et contenu Markdown. |
| `MarkdownExport` | Construit un fichier Markdown téléchargeable à partir des documents lisibles de l'index courant. |
| `Diagnostics` | Rapporte l'état des sources read-only, cache, langue et path-safety pour manager/debug. |

## Lookup runtime

Gardez les données lookup exactes hors de ce guide afin que la documentation
reste maintenable.

- Les routes, fonctionnalités Markdown supportées, comportement UML et métadonnées
  des nœuds documents vivent dans la [Référence](reference.md).
- Les clés de configuration, defaults, types de valeurs et notes de sécurité
  vivent dans la [Configuration](configuration.md).
- Le frontend payload et les changements cassants du viewer vivent dans le
  [Frontend guide](frontend-guide.md).

Diagnostics inclut des métadonnées du système de fichiers, donc les routes
diagnostiques doivent rester derrière le guard manager/debug décrit dans la
[Référence](reference.md).

## Modèle runtime de recherche

dDocs utilise actuellement filesystem live search: un filtre live au-dessus de
l'index de fichiers, pas un moteur de recherche dédié, un index full-text ou un
service de recherche indexé.

`DocsIndexer` construit des nœuds de métadonnées de navigation. `FileIndexCache`
stocke ces nœuds comme métadonnées PHP générées pour que l'arbre s'ouvre vite.
Ce cache stocke les titres, chemins, métadonnées de source, métadonnées de
langue, timestamps et checksums; il ne stocke pas le texte normalisé des
documents, tokens, headings, snippets ou posting list de recherche.

`ModulePanel` charge tous les nœuds depuis `FileIndexCache` et les passe à
`FileSearch`. `FileSearch` matche d'abord les champs de métadonnées comme le
titre, le chemin relatif, le nom de source et le nom de paquet. Quand le nœud est
un document et que les métadonnées ne matchent pas, il lit le fichier Markdown
via `FileDocumentRepository` et vérifie le contenu brut.

La recherche dans le contenu respecte toujours le modèle de sécurité filesystem.
Elle lit uniquement les nœuds documents indexés, extensions autorisées, safe docs
roots et fichiers sous `max_file_size_kb`.

Quand un document matche, `FileSearch` retourne aussi ses dossiers parents. Ces
dossiers sont du contexte UI, pas des matches de recherche. Cela garde l'arbre
lisible pendant qu'une recherche est active.

Les checksums appartiennent actuellement aux métadonnées et à l'invalidation du
cache. Ils ne sont pas encore utilisés pour l'invalidation d'un index search car
aucun index search séparé n'existe.

## Roadmap de recherche

La recherche doit rester filesystem-first. La prochaine étape devrait être un
`FileSearchIndexCache` généré et file-based, pas une table de base de données ni
un service de recherche externe.

Roadmap recommandée:

1. Ajouter `FileSearchIndexCache` comme cache PHP ou JSON généré pour le texte recherchable.
2. Garder l'index de navigation et l'index search comme responsabilités séparées.
3. Rebuild incrémental par checksum et mtime pour éviter de relire les documents inchangés.
4. Stocker texte recherchable normalisé, headings, tokens et source de snippet.
5. Ajouter un scoring simple: titre au-dessus de heading, heading au-dessus de chemin, chemin au-dessus de source/package, source/package au-dessus du body content.
6. Classer exact phrase au-dessus de token match, et token match au-dessus de prefix match.
7. Ajouter des snippets pour que les titres génériques montrent un contexte utile.
8. Highlight les matches côté client après rendu, sans modifier la source Markdown.
9. Ajouter de petits filtres query comme `source:ddocs`, `path:configuration`, `type:reference` et `lang:uk`.
10. Ajouter des search modes: quick metadata search, full-text search et current source search.

Évitez Elasticsearch, Meilisearch, Typesense, SQLite FTS, le contenu search
stocké en base et vector search pour le premier release. Ils ajoutent une
infrastructure qui ne correspond pas au modèle actuel file-as-source-of-truth.

## Contrat de découverte des sources

dDocs découvre la documentation depuis:

- le paquet dDocs lui-même;
- les paquets Composer installés qui ressemblent à des paquets Evolution;
- les racines de paquets avec `docs/`, legacy `Docs/`, `README.md` ou `index.md`;
- Project Documentation dans `ProjectDocs/`;
- les safe roots et extra docs roots configurés.

Les nouveaux paquets doivent exposer `docs/` en lowercase. Legacy `Docs/` est
accepté uniquement pour compatibilité.

## Contrat de langue

dDocs résout les roots de documentation dans l'ordre de priorité pour
l'utilisateur manager:

1. `default_language`, quand configuré.
2. Langue du manager Evolution.
3. Valeur legacy manager `ua` normalisée vers la locale de documentation `uk`.
4. `language_fallback`, généralement `en`.
5. Docs neutres comme `docs/pages`, `docs/README.md` ou `index.md`.

L'arbre est une vue logique fusionnée, pas une liste brute de dossiers locale.
Les fichiers localisés gagnent pour le même chemin relatif, et les branches
localisées manquantes sont remplies depuis la locale fallback. Par exemple, si
`docs/uk/ddocs` existe mais `docs/uk/evolution-cms` n'existe pas, dDocs garde la
branche ukrainienne `ddocs` et remplit `evolution-cms` depuis
`docs/en/evolution-cms`.

L'arbre ne doit pas afficher toutes les locales à la fois ni exposer les branches
fallback comme une racine de langue séparée.

Les dossiers de locale de documentation doivent utiliser `uk` pour le contenu
ukrainien. Un dossier legacy `docs/ua` peut être lu uniquement comme alias de
migration et est exposé comme `uk` dans l'index.

## Points d'extension

| Surface | Statut | Règle |
| --- | --- | --- |
| Découverte de sources | Service interne | Ajouter les roots de paquets via `DocsSourceRegistry`, pas en contournant les safe roots. |
| Renderer post-processing | Runtime frontend interne | Préserver la forme du viewer payload, les maps de liens, images, UML et le comportement code-copy. |
| Safe roots | Configuration projet | Ajouter les roots de confiance via settings, pas via defaults du paquet. |
| Labels manager | Internal helper | Utiliser `ManagerText` pour les labels de module et settings. |
| Diagnostics | Route manager/debug gardée | Garder les métadonnées filesystem derrière le diagnostics guard. |
| Indexation search | Service interne | Garder les limites de taille de fichier et les lectures sûres intactes. |

## Sécurité des chemins

Toutes les lectures et écritures de fichiers doivent utiliser des chemins
normalisés et des contrôles safe-root. Un chemin brut venant d'une requête ne doit
jamais être fiable.

Les actions modifiables sont limitées à Project Documentation. Les docs de
paquets vendor sont indexées et rendues, mais pas écrites par l'UI manager.

## Comportement du cache

Quand `cache_index` est activé, dDocs écrit un fichier PHP généré qui contient
uniquement des métadonnées. Il stocke les nœuds sources, nœuds dossiers, chemins
de documents, métadonnées de langue, timestamps et checksums. Il ne stocke pas le
Markdown canonique en base.

Rafraîchissez l'index après des changements manuels de package docs, changements
de configuration de roots ou changements de structure de langue.

## Limite frontend

dDocs a une vraie surface frontend: Blade shell, Livewire DOM, viewer dTui/TOAST
UI, Prism et browser post-processing. Gardez le comportement tree/viewer propre à
la documentation local à dDocs jusqu'à ce qu'un autre paquet ait besoin de la
même primitive. Promouvez les primitives partagées via evo-ui au lieu de les
copier.

## Commandes de vérification

Exécutez ces contrôles avant release:

```bash
find . -path './vendor' -prune -o -name '*.php' -print0 | xargs -0 -n1 php -l
composer validate --no-check-publish
```

Exécutez les contrôles de documentation dDocs:

```bash
php docs/checks/docs-check.php
```

Exécutez le smoke demo runtime depuis le manager demo installé lorsque disponible.
