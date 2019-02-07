{include file="header.tpl"}
{include file="auth/user_search.tpl"}
<hr size=1 noshade=1 />
{include file="generic_list.tpl" _show_pager="1" _form_name="user_list" _show_insert="1" _header="Пользователи" _rows=$user _href="/admin/auth/user_list.php?" _item_href="/admin/auth/user.php?"}
{include file="footer.tpl"}
