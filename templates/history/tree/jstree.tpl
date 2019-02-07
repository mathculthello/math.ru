{*
$_tree_name
$_tree
$_url
$_frame
*}
<table width=100%><tr><td align="right" class="small"><a href="javascript:void(tree.expandAll(),tree.draw())">Развернуть</a>&nbsp;|&nbsp;<a href="javascript:void(tree.collapseAll(),tree.draw())">Свернуть</a></td></tr></table>
<script type="text/javascript" src="/jstree/cooltreepro.js"></script>
<script type="text/javascript" src="/history/tree/tree_format.js"></script>
<script type="text/javascript">
var TREE_NODES = [

{section name=tree loop=$_tree}
{""|indent:$_tree[tree].level:"\t"}[ {literal}{{/literal}id:{$_tree[tree].id}{literal}}{/literal}, "{$_tree[tree].name}", "{$_url}{$_tree[tree].path}", "{$_frame}"
{if $smarty.section.tree.last || $_tree[tree.index_next].level < $_tree[tree.index].level}
{""|indent:$_tree[tree.index].level-$_tree[tree.index_next].level+1:"]\n"},
{elseif $_tree[tree.index_next].level > $_tree[tree.index].level}
,
{else}
],
{/if}
{/section}
];
var tree = new COOLjsTreePRO("tree", TREE_NODES, TREE_FORMAT);
tree.init();
{foreach from=$tree_path item=_node}
tree.expandNode(tree.nodeByID({$_node.id}).index, 1, 1);
{/foreach}
</script>
{*
<hr size="1" noshade="1" />
<div class="small" align="left"><a href="javascript:void(tree.expandAll(),tree.draw())">Развернуть</a>, <a href="javascript:void(tree.collapseAll(),tree.draw())">Свернуть</a></div>
*}