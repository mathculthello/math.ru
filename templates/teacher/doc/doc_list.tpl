{include file="teacher/header.tpl"}
<tr>
	<td id=menucol valign=top>
{include file="menu.tpl"}
<br>
{include file="menu.tpl" _path="/teacher/doc/" _menu=$_menu_doc _title="Документы"}
	</td>
	<td id=content valign=top align=center><div>
<h1>{$cat.title}</h1>
<br/>
<table border=0 cellspacing=3 cellpadding=2 width=100% class="bookstable">
<tr class="tblheader"><td>Название документа</td><td width="200">Скачать архив</td></tr>
{foreach from=$doc item=d}
<tr class="{cycle values="tbldata2,tbldata1"}"><td>
<a href="/teacher/doc/{$d.id}">{$d.title}</a><br/>
</td><td>
<a href="/teacher/doc/arch/{$d.path}">{$d.size/1024|string_format:"%.2f"} Кб</a>
</td></tr>
{/foreach}
</table>
	</div></td>
	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>
</tr>
{include file="footer.tpl"}
