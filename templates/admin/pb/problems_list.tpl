{include file="header.tpl"}
{include file="pb/problems_search.tpl"}
<hr size=1 noshade=1 />
{include file="generic_list.tpl" _show_pager="1" _header="Задачи problems.ru" _rows=$problems _href="/admin/pb/problems_list.php?" _item_href="http://problems.ru/view_problem_details_new.php?" _target="_new"}
{include file="footer.tpl"}
