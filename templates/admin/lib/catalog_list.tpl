{include file="header.tpl"}
<table cellpadding=3>
<tr class=tblheader><td colspan="9">Тематический каталог</td></tr>
<tr class=tblheader1 valign="top"><td width="300" rowspan="2">Название раздела</td><td rowspan="2">Путь</td><td colspan="2" align="center">Число книг</td><td rowspan="2" colspan="5">Действия</td></tr>
<tr class=tblheader1><td>в разделе</td><td>в ветке</td></tr>
{foreach from=$catalog item=s name="cat"}
<tr class="{cycle values="tbldata1,tbldata2"}">
<td>{""|indent:$s.level-1:"&nbsp;&nbsp;&nbsp;&nbsp;"}<a href="/admin/lib/catalog.php?id={$s.id}">{$s.name}</a></td>
<td><a href="/admin/lib/catalog.php?id={$s.id}">{$s.path}</a></td>
<td>{$s.books}</td>
<td>{$s.books_all}</td>
<td>{if !$smarty.foreach.cat.first}<a href="/admin/lib/catalog_list.php?moveup={$s.id}">{/if}<img border="0" src="/img/moveup.gif"/>{if !$smarty.foreach.cat.first}</a>{/if}</td>
<td>{if !$smarty.foreach.cat.last}<a href="/admin/lib/catalog_list.php?movedown={$s.id}">{/if}<img border="0" src="/img/movedown.gif"/>{if !$smarty.foreach.cat.last}</a>{/if}</td>
<td>{if $s.books}<a href="/admin/lib/catalog_list.php?clear={$s.id}" title="Удалить книги из раздела">{/if}C{if !$s.books}</a>{/if}</td>
<td><a href="/admin/lib/catalog.php?pid={$s.id}" title="Добавить подраздел">+</a></td>
<td>{if !$s.books}<a href="/admin/lib/catalog_list.php?delit={$s.id}" title="Удалить раздел">{/if}-{if !$s.books}</a>{/if}</td>
</tr>
{/foreach}
<tr class=tblheader><td colspan="9" align="right"><input type="button" onclick="window.location='/admin/lib/catalog.php';" name="add" value="Добавить раздел"/></td></tr>
</table>