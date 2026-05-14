# Resources And Document Tree

[Back](README.md) / [Up](README.md) / [Next](elements.md)

Resources are the content nodes shown in the manager document tree. They are
stored by the `SiteContent` model and can represent pages, folders, links, or
other content types depending on their fields.

## Create A Resource

1. Open the manager document tree.
2. Choose the parent location.
3. Create a new resource or link from the tree or manager action controls.
4. Enter the page title, alias, template, content, menu settings, and publish
   state.
5. Save the resource.
6. Refresh the site cache if the change is not visible immediately.

## Edit Content

Open the resource from the tree and update the content fields. The resource form
can include Template Variable fields when the selected template has TVs assigned.

Important resource fields include:

| Field Area | Why It Matters |
| --- | --- |
| Title and menu title | Used in manager tree, menus, and output helpers. |
| Alias | Used by friendly URLs when enabled. |
| Parent and menu index | Control tree position and menu order. |
| Template | Controls available layout and Template Variables. |
| Published/deleted state | Controls whether the resource is visible to site visitors. |
| Searchable/cacheable flags | Affect search and cache behavior. |
| Private web/manager flags | Affect access rules. |

## Organize The Tree

Use tree actions to move, duplicate, delete, undelete, publish, and unpublish
resources. Move operations call the current manager move flow and trigger move
events. Delete usually marks a resource as deleted; empty trash removes deleted
resources.

If tree changes are not visible, refresh the tree and clear cache.

## Search Resources

The manager search surface can search resource fields, exact IDs, exact URLs,
template filters, and Template Variable values. Exact URL search uses current
friendly URL settings and alias resolution.

Use search when:

- a resource is hidden deep in the tree;
- the alias or URL is known but the resource ID is not;
- a Template Variable value needs to be found;
- deleted/unpublished state needs to be checked.

## Friendly URL Notes

Friendly URLs depend on both Evolution CMS settings and web-server rewrite
rules. If a saved alias does not work:

1. Check the `friendly_urls` setting.
2. Check suffix, prefix, folder, and strict URL settings.
3. Verify rewrite rules in the web server.
4. Refresh site cache.
5. Confirm the target resource is published and not deleted.

For deeper operations checks, see
[Troubleshooting](../07-security-updates-operations/troubleshooting.md).
