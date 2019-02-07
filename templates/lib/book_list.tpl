<table border=0 cellspacing=3 cellpadding=2 width=100% class="bookstable">
{if $ser_info}<colgroup width="20"/>{/if}<colgroup width="130" /><colgroup width="100%"/><colgroup width="30" /><colgroup width="30" /><colgroup width="30" /><colgroup width="20" /><colgroup width="20" /><colgroup width="20" /><colgroup width="20" />
<tr class=tblheader1>
{if $ser_info}
<td rowspan=2 valign=top width="20"><a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=num&o={$n_o}">#</a>{if $_p->orderBy == 'num'}<a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=num&o={$n_o}" border="0"><img src="/img/sort{$n_o}.gif" width=16 height=16 align=right border="0" valign="bottom"/></a>{/if}</td>
{/if}
<td rowspan=2 valign=top width="130"><a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=author&o={$a_o}">Автор(ы)</a>{if $_p->orderBy == 'author'}<a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=author&o={$a_o}" border="0"><img src="/img/sort{$a_o}.gif" width=16 height=16 align=right border="0" valign="bottom"/></a>{/if}</td>
<td rowspan=2 valign=top width="100%"><a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=title&o={$t_o}">Название</a>{if $_p->orderBy == 'title'}<a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=title&o={$t_o}" align=right><img src="/img/sort{$t_o}.gif" width=16 height=16 align=right border="0" valign="bottom"/></a>{/if}</td>
<td rowspan=2 valign=top width="30"><a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=year&o={$y_o}">Год</a>{if $_p->orderBy == 'year'}<a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=year&o={$y_o}" align=right valign="bottom"><img src="/img/sort{$y_o}.gif" width=16 height=16 align=right border="0" valign="bottom"/></a>{/if}</td>
<td rowspan=2 valign=top width="30"><a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=pages&o={$p_o}">Стр.</a>{if $_p->orderBy == 'pages'}<a href="{$_url}?n={$_p->itemsPerPage}&page={$_p->page}&o_by=pages&o={$p_o}" align=right valign="bottom"><img src="/img/sort{$p_o}.gif" width=16 height=16 align=right border="0" valign="bottom"/></a>{/if}</td>
<td colspan=5 align=center>Загрузить, Mb</td>
</tr>
<tr class=tblheader1><td width="30">djvu</td><td width="20">pdf</td><td width="20">ps</td><td width="20">html</td><td width="20">TeX</td></tr>
{foreach from=$books item=b}
<tr class="{cycle values="tbldata1,tbldata2"}" valign=top>
{if $ser_info}
<td><a href="/lib/book/{$b.path}">{$b.num}</a></td>
{/if}
<td>
{foreach from=$b.authors item=a name=authors}
<nobr><a href="{if $a.show_in_history}/history/people/{else}/lib/author/{/if}{$a.path}" title="{if $a.show_in_history}Страница автора{else}Все книги автора{/if}">{$a.fname|initials}{$a.sname|initials}{$a.lname}{if !$smarty.foreach.authors.last}, {/if}</a></nobr> 
{/foreach}
</td>
{if $b.anno}
<script language="JavaScript" type="text/javascript"><!--
var tooltip{$b.id} = "{$b.anno|truncate:400|regex_replace:"/[\"]/":"\\\'"|regex_replace:"/[\r\t\n]/":" "}";
--></script>
{/if}
<td><a href="/lib/book/{$b.path}"{if $b.anno} onmouseover="this.T_STATIC=true;this.T_DELAY = 1000;this.T_WIDTH=500;this.T_STICKY=true;return escape(tooltip{$b.id})"{else} onmouseover="this.T_DELAY=100000;return escape('')"{/if}{if $search_mode == "search"} target="_new"{/if}>{$b.title}</a>
{if $b.matched_pages}
<br/>
Страницы: {$b.matched_pages}
{/if}
</td>
<td>{$b.year|default:'-'}</td>
<td>{$b.pages|default:'-'}</td>
<td>{if $b.djvu}<a href="/lib/files/{$b.djvu_file}">{$b.djvu}</a>{else}-{/if}</td>
<td>{if $b.pdf}<a href="/lib/files/{$b.pdf_file}">{$b.pdf}</a>{else}-{/if}</td>
<td>{if $b.ps}<a href="/lib/files/{$b.ps_file}">{$b.ps}</a>{else}-{/if}</td>
<td>{if $b.html}<a href="/lib/files/{$b.html_file}">{$b.html}</a>{else}-{/if}</td>
<td>{if $b.tex}<a href="/lib/files/{$b.tex_file}">{$b.tex}</a>{else}-{/if}</td>
</tr>
{/foreach}
</table>
