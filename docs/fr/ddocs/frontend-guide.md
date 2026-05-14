# Frontend guide

dDocs utilise evo-ui pour le shell manager et dTui/TOAST UI pour le rendu
Markdown. C'est un runtime frontend interne, pas une API frontend publique pour
les paquets consommateurs.

## Limite runtime

- `views/docs/shell.blade.php` possède le document iframe du manager, les assets
  locaux dTui, les assets Prism et le code de boot du viewer.
- `views/livewire/module-panel.blade.php` possède le workspace dDocs, l'arbre,
  le listing de dossiers, l'en-tête du document et le JSON payload du viewer.
- `views/partials/tree-node.blade.php` possède les lignes récursives de l'arbre.
- dDocs rend Markdown dans le navigateur depuis un JSON payload au lieu de rendre
  HTML côté serveur.

## Limite evo-ui

dDocs doit suivre les conventions visuelles evo-ui pour les icônes, contrôles
manager compacts, tokens de thème, modals et formulaires settings. Le workspace
tree/viewer est actuellement local à dDocs parce que c'est un modèle
d'interaction propre à la documentation. S'il devient réutilisable, il faut le
promouvoir via une tâche evo-ui au lieu de copier l'implémentation dans un autre
paquet.

## UX sans tabs supérieurs

dDocs n'utilise volontairement pas le tab strip supérieur standard du module
pour le workspace documentation. La navigation primaire est le panneau source/tree
à gauche et le document viewer à droite. Une future standardisation des tabs WebUI
ne doit pas forcer des top tabs dans dDocs sauf si le module obtient plusieurs
workspaces pairs qui nécessitent une navigation par tabs.

Les settings restent disponibles, mais ils sont traités comme une action compacte
du workspace document plutôt que comme un top-level module tab.

## Exception locale de style evo-ui

dDocs peut appliquer des styles scoped aux internes de formulaires evo-ui
uniquement dans `.ddocs-settings` lorsque le formulaire settings est intégré au
workspace document. Cette exception existe parce que dDocs masque le heading/tabs
imbriqué du formulaire et dispose les sections comme partie de la surface reader.

Exceptions locales autorisées:

- `.ddocs-settings .evo-ui-form-*` seulement pour le layout settings intégré;
- `.ddocs-search .evo-ui-input` seulement pour la taille du champ search de sidebar;
- `.ddocs-modal .evo-ui-btn--danger` seulement pour l'action de confirmation delete;
- le chrome de l'éditeur dTui/TOAST UI dans `.ddocs-editor`.

Ne stylez pas les primitives globales evo-ui hors d'un scope `.ddocs-*`. Si un
autre paquet a besoin du même pattern, créez une tâche evo-ui pour une primitive
ou variante partagée au lieu de copier le CSS dDocs.

## Payload du viewer

Le viewer de document reçoit:

```json
{
  "id": "document-node-id",
  "markdown": "# Document",
  "links": [],
  "images": [],
  "uml": []
}
```

Livewire possède la sélection du document et les lectures de fichiers sûres. Le
code navigateur possède le rendu TOAST UI, le chrome code-copy, l'interception
des liens internes, le remplacement sécurisé des images locales et la récupération
UML.

## Changements cassants du viewer

Traitez ces changements comme breaking changes pour le viewer dDocs:

- forme du viewer payload;
- noms des méthodes Livewire de sélection de document;
- ids des nœuds de documents;
- structure des maps link, image et UML;
- comportement du bouton code-copy;
- interception des liens Markdown internes;
- comportement de sécurité des images locales.

## Règles d'extension

- Garder les docs de paquets comme fichiers Markdown; ne pas ajouter de navigation HTML générée.
- Garder les liens relatifs dans l'arbre docs du paquet.
- Garder le comportement viewer personnalisé dans dDocs jusqu'à ce qu'au moins deux paquets en aient besoin.
- Utiliser les tokens evo-ui et les composants d'icônes existants avant d'ajouter du CSS local.
- Ajouter des browser smoke checks lors de changements du boot viewer, des clés Livewire ou du post-processing dTui.
