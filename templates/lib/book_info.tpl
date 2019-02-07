<h1 class="book_title">{$book.title}</h1>
{if $book.subtitle}<h1 style="font-size:14px;">{$book.subtitle}</h1>{/if}
<span class="book_author">
{foreach from=$book.authors item=a name=authors}
<a href="{if $a.show_in_history}/history/people/{else}/lib/author/{/if}{$a.path}" title="{if $a.show_in_history}Страница автора{else}Все книги автора{/if}">{$a.fname|initials:1}{$a.sname|initials:1}{$a.lname}</a>{if !$smarty.foreach.authors.last}, {/if}
{/foreach}
</span><br/><br/>
{$book.publ}{if $book.year && $book.publ}, {/if}{$book.year}. {if $book.pages}{$book.pages} с.{/if}<br/>
{if $book.ISBN}ISBN {$book.ISBN}{/if}{if $book.ISBN && $book.copies}; {/if}{if $book.copies}Тираж {$book.copies} экз.{/if}<br/>
{if $book.series}Серия <a href="/lib/ser/{$book.spath}">{$book.sname}</a>{if $book.num}, выпуск {$book.num}{/if}{/if}
<table width=100% border=0 cellspacing=0 cellpadding=0><tr>
<td valign=top class=small>
<!--
{section name=i loop=$path}
/<a href="/lib/catalog.php?subj={$path[i].id}">{$path[i].name}</a>{if $path[i].num ne $path[i.index_next].num}<br/>{/if}
{/section}
-->
</td><td align=right>
<table class="book_download">
<tr><td colspan=5>Загрузить (Mb)</td></tr>
<tr>
<td>{if $book.djvu}<a href="/lib/files/{$book.djvu_file}">djvu ({$book.djvu})</a>{else}djvu (-){/if}</td>
<td>{if $book.pdf}<a href="/lib/files/{$book.pdf_file}">pdf ({$book.pdf})</a>{else}pdf (-){/if}</td>
<td>{if $book.ps}<a href="/lib/files/{$book.ps_file}">ps ({$book.ps})</a>{else}ps (-){/if}</td>
<td>{if $book.html}<a href="/lib/files/{$book.html_file}">html ({$book.html})</a>{else}html (-){/if}</td>
<td>{if $book.tex}<a href="/lib/files/{$book.tex_file}">tex ({$book.tex})</a>{else}tex (-){/if}</td>
</tr>
</table>
</td></tr></table>
<br/>
{if $book.anno}{$book.anno|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"}<hr size=1 noshade>{/if}
{if $book.contents}<h3>Содержание</h3>{$book.contents|replace:"@@href@@":"/lib/files/$djvu_file?djvuopts&page="}<hr size=1 noshade>{/if}
{if $book.biblio}<h3>Список литературы</h3>{$book.biblio}<br>{/if}
<table width=100% border=0 cellspacing=0 cellpadding=0 valign=bottom><tr><td valign=top class=small>
<!--
{section name=i loop=$path}
/<a href="/lib/catalog.php?subj={$path[i].id}">{$path[i].name}</a>{if $path[i].num ne $path[i.index_next].num}<br/>{/if}
{/section}
-->
</td><td align=right>
{if $book.anno || $book.contents || $book.biblio}
<table class="book_download">
<tr><td colspan=5>Загрузить (Mb)</td></tr>
<tr>
<td>{if $book.djvu}<a href="/lib/files/{$book.djvu_file}">djvu ({$book.djvu})</a>{else}djvu (-){/if}</td>
<td>{if $book.pdf}<a href="/lib/files/{$book.pdf_file}">pdf ({$book.pdf})</a>{else}pdf (-){/if}</td>
<td>{if $book.ps}<a href="/lib/files/{$book.ps_file}">ps ({$book.ps})</a>{else}ps (-){/if}</td>
<td>{if $book.html}<a href="/lib/files/{$book.html_file}">html ({$book.html})</a>{else}html (-){/if}</td>
<td>{if $book.tex}<a href="/lib/files/{$book.tex_file}">tex ({$book.tex})</a>{else}tex (-){/if}</td>
</tr>
</table>
{/if}

</td></tr></table>
<br>
<div class="small" align="right">Постоянный адрес этой страницы: 
{if $book.spath && $book.num}
<a href="http://math.ru/lib/{$book.spath}/{$book.num}">http://math.ru/lib/{$book.spath}/{$book.num}</a></div>
{else}
<a href="http://math.ru/lib/{$book.id}">http://math.ru/lib/{$book.id}</a></div>
{/if}
<br>