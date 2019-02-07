{include file="header.tpl"}
{include file="history/person_search.tpl"}
<hr size=1 noshade=1 />
{include file="generic_list.tpl" _show_pager="1" _form_name="person_list" _show_insert="1" _header="Персоны" _rows=$person _href="/admin/history/person_list.php?" _item_href="/admin/history/person.php?"}
{include file="footer.tpl"}

{*
<input type=button onclick="document.location='/admin/h_person.php?mode={$mode}&page={$_p->page}&o_by={$_p->orderBy}&o={$_p->order}&n={$_p->itemsPerPage}'" value="Добавить">
*}