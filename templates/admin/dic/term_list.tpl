{include file="header.tpl"}
{if $type == "fact"}
{assign var=_header value="Факты"}
{assign var=_href value="/admin/dic/term_list.php?type=fact&"}
{assign var=_item_href value="/admin/dic/term.php?type=fact&"}
{elseif $type == "term"}
{assign var=_header value="Понятия"}
{assign var=_href value="/admin/dic/term_list.php?type=term&"}
{assign var=_item_href value="/admin/dic/term.php?type=term&"}
{elseif $type == "formula"}
{assign var=_header value="Формулы"}
{assign var=_href value="/admin/dic/term_list.php?type=formula&"}
{assign var=_item_href value="/admin/dic/term.php?type=formula&"}
{/if}
{include file="generic_list.tpl" _show_pager="1" _form_name="term_list" _show_insert="1" _rows=$term}
{include file="footer.tpl"}
