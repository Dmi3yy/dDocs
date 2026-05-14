# Référence des balises de l'analyseur

[Retour](blade-and-template-rendering.md) / [Haut](../README.md) / [Suivant](models.md)

Les modèles classiques Evolution CMS utilisent des balises d'analyseur pour les ressources, les paramètres,
morceaux, extraits de code, espaces réservés, URL et contenu conditionnel. Cette page enregistre
la surface actuelle de la balise principale afin que les exemples puissent rester cohérents.

## Balises standards

| Étiquette | Signification | Exemple |
| --- | --- | --- |
| `[*field*]` | Champ de ressource actuelle ou Template Variable. | `[*pagetitle*]` |
| `[(setting)]` | Paramètre système ou valeur de configuration d’exécution. | `[(site_name)]` |
| `{{chunk}}` | Contenu Chunk. | `{{site_header}}` |
| `{{chunk?&name=`valeur`}}` | Chunk avec paramètres locaux. | `{{card?&title=`Bonjour`}}` |
| `[[snippet]]` | Appel d’extrait de code mis en cache. | `[[DocLister]]` |
| `[!snippet!]` | Appel d’extrait non mis en cache. | `[!contactForm!]` |
| `[+placeholder+]` | Valeur d’espace réservé de la portée de l’analyseur. | `[+title+]` |
| `[~id~]` | URL Resource. | `[~1~]` |
| `[^key^]` | Style d'espace réservé d'exécution/méta utilisé par les chemins de nettoyage et d'échappement. | `[^q^]` |

Utilisez des exemples isolés avec les étiquettes de langue `html` ou `blade` lors de la documentation
code de modèle dans Markdown.

## Resource Champs et TVs

Les balises Resource lisent d'abord l'objet du document actuel. Ils peuvent aussi lire
Template Variables lorsque les valeurs TV sont chargées pour la ressource.

```html
<h1>[*pagetitle*]</h1>
<p>[*introtext*]</p>
<img src="[*hero_image*]" alt="">
```

L'analyseur prend également en charge la recherche contextuelle avec `@` dans les balises de ressources. Actuel
la gestion du contexte inclut le parent, le parent ultime, la recherche d'alias, le précédent/le suivant
recherche de frères et sœurs et recherche directe d'identifiant de ressource.

```html
[*pagetitle@parent*]
[*pagetitle@uparent(0)*]
[*pagetitle@alias(home)*]
```

## Paramètres système

Les balises de paramètres lisent la configuration d’exécution et les valeurs de chemin/URL connues.

```html
<title>[(site_name)]</title>
<base href="[(site_url)]">
```

Les valeurs générées courantes incluent `base_url`, `base_path`, `site_url`,
`valid_hostnames`, `site_manager_url` et `site_manager_path`.

## Chunks

Les Chunks sont des modèles réutilisables. Les paramètres transmis à un morceau sont disponibles sous forme
espaces réservés locaux pendant l’analyse des morceaux.

```html
{{button?&label=`Read more`&url=`[~12~]`}}
```

La sortie Chunk peut contenir des espaces réservés, des balises de ressources, des paramètres, d'autres morceaux,
et les balises conditionnelles. L'analyseur résout de manière récursive le contenu imbriqué jusqu'à ce que le
les limites de réussite de l'analyseur configurées sont atteintes.

## Snippets

Les extraits de code mis en cache utilisent `[[...]]`. Les extraits non mis en cache utilisent `[!...!]` et sont convertis
pour extraire des balises lors de la sortie post-analyse.

```html
[[menuBuilder?&startId=`0`]]
[!contactForm?&redirectTo=`15`!]
```

Les paramètres Snippet sont analysés avant l'exécution. Gardez les valeurs des paramètres explicites
et évitez de vous fier à un état mondial non documenté.

## Espaces réservés

Les espaces réservés sont résolus à partir de la portée actuelle de l'espace réservé de l'analyseur ou de la zone locale.
données transmises dans un appel chunk/analyseur.

```html
<article>
  <h2>[+title+]</h2>
  <p>[+summary+]</p>
</article>
```

Les espaces réservés peuvent utiliser des modificateurs. Les modificateurs font partie de l'analyseur classique
surface et doivent être documentés avec la fonctionnalité qui en dépend.

## balises d'URL

Les balises URL sont réécrites lors du traitement de sortie.

```html
<a href="[~1~]">Home</a>
```

La sortie de l'URL dépend de l'état de publication de la ressource, des paramètres d'URL conviviaux,
alias, suffixes, URL de base et processeur d'URL.

## Balises conditionnelles

Les balises conditionnelles sont activées via le paramètre `enable_at_syntax`. Actuel
la syntaxe de base utilise des balises majuscules :

```html
<@IF:[*published*]>
  Published
<@ELSE>
  Draft
<@ENDIF>
```

L'analyseur normalise également les anciens formulaires de commentaires HTML tels que `<!--@IF ...-->`,
`<!--@ELSE-->` et `<!--@ENDIF-->`.

## Liaisons et modes de modèles en ligne

Les assistants de modèles d'analyseur reconnaissent les modes spéciaux :

| Mode | Signification |
| --- | --- |
| `@CODE` / `@INLINE` / `@TPL` | Utilisez le code du modèle en ligne. |
| `@FILE` | Chargez le code du modèle à partir d'un fichier sous le chemin du modèle configuré. |
| `@DOCUMENT` / `@DOC` | Charger le contenu de la ressource actuelle ou sélectionnée. |
| `@B_FILE` | Rendu un fichier Blade. |
| `@B_CODE` | Rendre le code Blade en ligne via le cache généré. |
| `@T_CODE` / `@T_FILE` | Modes de modèles réservés dans la gestion de l'analyseur. |

Voir [Blade et référence de rendu de modèle](blade-and-template-rendering.md)
pour le comportement spécifique à Blade.

## Nettoyage et évasion

Le flux de sortie peut :

- exécuter des extraits non mis en cache pendant la post-analyse ;
- injecter des scripts de démarrage enregistrés avant `</head>` ;
- injecter des scripts enregistrés avant `</body>` ;
- nettoyer les balises Evolution inutilisées ;
- réécrire les balises URL dans les URL finales.

`getTagsForEscape()` inclut des paires de balises standard telles que `{{ }}`, `[[ ]]`,
`[! !]`, `[* *]`, `[( )]`, `[+ +]`, `[~ ~]` et `[^ ^]`.

## Règle de documentation

Lorsque vous écrivez des exemples, utilisez la plus petite surface de balise qui explique la tâche. Pour
les nouveaux projets qui utilisent les modèles Blade, préfèrent les exemples Blade et lien ici uniquement
lorsque des balises d'analyseur classiques sont requises.
