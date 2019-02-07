{include file="header.tpl"}
<table><tr><td valign="top">
<form method=post action=/admin/history/tree.php name=h_person_search>
<table cellpadding=2>
<tr class=tblheader><td>Поиск</td></tr>
<tr>
<td class="tblheader1" align=right>Фамилия:&nbsp;<input type=text name=search_string value="{$search_string}"/>
&nbsp;<input type=submit value="Найти"/></td></tr>
</table>
<input type=hidden name=search value=1>
</form>
</td><td>
<table cellpadding=2>
<tr class=tblheader><td>Алфавитный каталог</td></tr>
<tr class="tblheader1"><td>
{include file="generic_alpha.tpl" _href="/admin/history/tree.php?letter="}
</td></tr></table>
</td></tr></table>
<hr size=1 noshade=1 />
{if $search}
<h2>Результаты поиска</h2>
{section name=i loop=$search_results}
<a href="/admin/history/tree.php?id={$search_results[i].id}">{$search_results[i].lname}&nbsp;{$search_results[i].fname|initials:1}{$search_results[i].sname|initials:1}&nbsp;{life_date_format birth=$search_results[i].birth_date death=$search_results[i].death_date brackets="p"}</a><br/>
{sectionelse}
{/section}

{else}
<table width=100%><tr><td align="right" class="small"><a href="javascript:void(tree.expandAll(),tree.draw())">Развернуть</a>&nbsp;|&nbsp;<a href="javascript:void(tree.collapseAll(),tree.draw())">Свернуть</a></td></tr></table>

{include file="generic_jstree.tpl" _tree=$tree _tree_path=$tree_path _url="/admin/history/tree.php" _frame="main"}

<br>
<hr size=1 noshade=1 />
<form name="tree" method="post" action="/admin/history/tree.php">
<input type="hidden" name="id" value="{$id}"/>
<input type="hidden" name="person_to_insert" value=""/>
<input type="button" value="Добавить последователя" onclick="popup=window.open('/admin/history/person_picker.php?form_name=tree&element_name=person_to_insert&reload=1&ismultiple=1','person_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
&nbsp;&nbsp;&nbsp;
<input type=button onclick="document.location='/admin/history/person.php?id={$id}'" value="Редактировать">
&nbsp;&nbsp;&nbsp;
<input type=button onclick="confirmGo('Удалить из дерева?', '/admin/history/tree.php?person_to_delete={$id}')" value="Удалить из дерева">
</form>
{include file="history/person_info.tpl"}
<script type="text/javascript">RedrawAllTrees()</script>
{/if}