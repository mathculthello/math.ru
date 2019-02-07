{include file="header.tpl"}
{include file="generic_list.tpl" _show_pager="0" _form_name="ad_list" _show_insert="1" _header="Ссылки" _rows=$ad_list _href="/admin/lib/ad_list.php?" _item_href="/admin/lib/ad.php?"}
{include file="footer.tpl"}

{*
<input type=button onclick="document.location='/admin/h_person.php?mode={$mode}&page={$_p->page}&o_by={$_p->orderBy}&o={$_p->order}&n={$_p->itemsPerPage}'" value="Добавить">
*}