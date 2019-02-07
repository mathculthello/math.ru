{*
$_tree_name
$_tree
$_url
$_frame
*}
<div class="small" align="left"><a href="javascript:void(tree.expandAll(),tree.draw())">Развернуть</a>, <a href="javascript:void(tree.collapseAll(),tree.draw())">Свернуть</a></div>
<hr size="1" noshade="1" />
<script type="text/javascript" src="/jstree/cooltreepro.js"></script>
<script type="text/javascript" src="/jstree/tree_format.js"></script>
<script type="text/javascript">
var TREE_NODES = [

{section name=tree loop=$_tree}
{""|indent:$_tree[tree].level:"\t"}[ '{$_tree[tree].name}', '{$_url}?id={$_tree[tree].id}', '{$_frame}'
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
</script>