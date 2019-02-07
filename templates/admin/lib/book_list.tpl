{include file="header.tpl"}
{include file="lib/book_search.tpl"}
<hr/>
<input type=button onclick="document.location='/admin/lib/book.php'" value="Добавить книгу"><br/>
{include file="generic_list.tpl" _show_pager="1" _form_name="book_list" _show_insert="1" _header="Книги" _rows=$books _href="/admin/lib/book_list.php?" _item_href="/admin/lib/book.php?"}


{*

{include file="pages_info.tpl"}
{include file="pages.tpl"}
{include file="lib/book_list_.tpl"}

<table border=0 cellspacing=3 cellpadding=2 width=100%>
<tr class=tblheader1>
<td rowspan=2 width=150 valign=top>{if $_p->orderBy == 'author'}<img src="/img/sort{$a_o}.gif" width=16 height=16 /> {/if}<a href="/admin/lib/book_list.php?n={$_p->itemsPerPage}&page={$_p->page}&o_by=author&o={$a_o}">Автор(ы)</a></td>
<td rowspan=2 width=500 valign=top>{if $_p->orderBy == 'title'}<img src="/img/sort{$t_o}.gif" width=16 height=16 /> {/if}<a href="/admin/lib/book_list.php?n={$_p->itemsPerPage}&page={$_p->page}&o_by=title&o={$t_o}">Название</a></td>
<td rowspan=2 width=20 valign=top>Год</td>
<td rowspan=2 width=20 valign=top>Стр.</td>
<td colspan=5 align=center>Скачать архив, Mb</td>
</tr>
<tr class=tblheader1><td>djvu</td><td>pdf</td><td>ps</td><td>html</td><td>TeX</td></tr>
{foreach from=$books item=b}
{strip}
<tr class="{cycle values="tbldata1,tbldata2"}"><td>
{foreach from=$b.authors item=a name=authors}
<nobr><a href="/admin/lib/book_list.php?author={$a.id}" title="Все книги автора">{$a.fname} {$a.sname} {$a.lname}</a></nobr><br/>
{/foreach}
</td>
<td><a href="/admin/lib/book.php?id={$b.id}" title="Описание книги">{$b.title}</a></td>
<td class=small>{$b.year|default:'-'}</td>
<td class=small>{$b.pages|default:'-'}</td>
<td class=small>{if $b.djvu}<a href="/lib/files/{$b.djvu_file}">{$b.djvu}</a>{else}-{/if}</td>
<td class=small>{if $b.pdf}<a href="/lib/files/{$b.pdf_file}">{$b.pdf}</a>{else}-{/if}</td>
<td class=small>{if $b.ps}<a href="/lib/files/{$b.ps_file}">{$b.ps}</a>{else}-{/if}</td>
<td class=small>{if $b.html}<a href="/lib/files/{$b.html_file}">{$b.html}</a>{else}-{/if}</td>
<td class=small>{if $b.tex}<a href="/lib/files/{$b.tex_file}">{$b.tex}</a>{else}-{/if}</td>
</tr>
{/strip}
{/foreach}
</table>
{include file="pages.tpl"}
*}

{include file="footer.tpl"}
