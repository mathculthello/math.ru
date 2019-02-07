{include file="header.tpl"}
{include file="generic_list.tpl" _show_delete="1" _show_checkboxes="1" _checkboxes_name="selected" _checkboxes_key="id" _form_name="news_list" _show_insert="1" _header="Новости" _rows=$news _href="/admin/news/index.php?" _item_href="/admin/news/news.php?" _show_pager="1" _order_column="ord"}
{include file="footer.tpl"}