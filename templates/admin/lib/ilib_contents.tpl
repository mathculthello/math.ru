{include file="header.tpl"}
<form name="ilib_contents" method="post" action="/admin/lib/ilib_contents.php">
<table border=0 cellspacing=3 cellpadding=2 width=100%>
{$books_num}
<br>
С отмеченными: <input type="submit" name="update_mathru" value="Обновить содержания math.ru"> <input type="submit" name="update_ilib" value="Обновить содержания ilib">
<br>
{foreach from=$books item=b}
<tr class="{cycle values="tbldata1,tbldata2"}">
<td><input type="checkbox" name="checked[]" value="{$b.id}"></td>
<td>{$b.id}</td>
<td>{$b.title}</td>
<td><a href="http://math.ru/lib/{$b.id}" target="_blank">{if $b.contents}math.ru{else}[...]{/if}</a></td>
<td>{if $b.ilib_path}<a href="http://ilib.mirror0.mccme.ru/{$b.ilib_path}" target="_blank">{if $b.ilib_contents}ilib{else}[...]{/if}{/if}</a></td>
</tr>
{/foreach}
</table>
</form>