{*
$_tree
$_url
$_frame
$_tree_path
*}

<script type="text/javascript" src="/jstree/cooltreepro.js"></script>
<script type="text/javascript" src="/history/tree/tree_format.js"></script>
<script type="text/javascript">
var TREE_NODES = [

{section name=tree loop=$_tree}

{""|indent:$_tree[tree].level:"\t"}[ {literal}{{/literal}id:{$_tree[tree].id}{literal}}{/literal}, "{$_tree[tree].name}", "{$_url}?id={$_tree[tree].id}", "{$_frame}"
{if $smarty.section.tree.last || $_tree[tree.index_next].level < $_tree[tree.index].level}
{""|indent:$_tree[tree.index].level-$_tree[tree.index_next].level+1:"]\n"},
{elseif $_tree[tree.index_next].level > $_tree[tree.index].level}
,
{else}
],
{/if}
{/section}
];

var tree = new COOLjsTreePRO("{$_tree_name}", TREE_NODES, TREE_FORMAT);
tree.init();
{foreach from=$_tree_path item=_node}
tree.expandNode(tree.nodeByID({$_node.id}).index, 1, 1);
{/foreach}
</script>



{*
{""|indent:$_tree[tree].level:"\t"}[ '{$_tree[tree].name}', '{$_url}?id={$_tree[tree].id}', '{$_frame}'
{if $smarty.section.tree.last || $_tree[tree.index_next].level < $_tree[tree.index].level}
{""|indent:$_tree[tree.index].level-$_tree[tree.index_next].level+1:"]\n"},
{elseif $_tree[tree.index_next].level > $_tree[tree.index].level}
,
{else}
],
{/if}
*}