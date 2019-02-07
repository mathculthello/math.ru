{include file="header.tpl"}
{if $edit == 1}
{include file="generic_list.tpl" _href="/admin/history/tree_edit.php?" _item_href="/admin/history/tree_person.php?" _header="Предложенные изменения" _columns=$_columns _rows=$person_list _form_name="h_person_list" _show_checkboxes="1" _checkboxes_name="selected" _checkboxes_key="id" _show_delete="1" _show_pager="1"}
{else}
{include file="generic_list.tpl" _href="/admin/history/tree_new.php?" _item_href="/admin/history/tree_person.php?" _header="Предложенные добавления" _columns=$_columns _rows=$person_list _form_name="h_person_list" _show_checkboxes="1" _checkboxes_name="selected" _checkboxes_key="id" _show_delete="1" _show_pager="1"}
{/if}
{include file="footer.tpl"}

{*
<form action="/admin/history/tree_new.php" method="POST" name="h_person_list">
<table border=0 cellspacing=3 cellpadding=2 width=100%>
<tr class=tblheader1><td width=20>&nbsp;</td><td>Ф.И.О.</td><td>Учитель</td></tr>
{section loop=$person_list name=i}
<tr class="{cycle values="tbldata1,tbldata2"}">
<td width=20><input type=checkbox name="selected[]" value="{$person_list[i].id}"></td>
<td><a href="/admin/h_tree_person.php?id={$person_list[i].id}">{$person_list[i].lname}&nbsp;{$person_list[i].fname|initials:1}{$person_list[i].sname|initials:1}</a></td>
<td><a href="/admin/h_tree_person.php?id={$person_list[i].pid}">{$person_list[i].plname}&nbsp;{$person_list[i].pfname|initials:1}{$person_list[i].psname|initials:1}</a></td>
</tr>
{/section}
</table>
*}
