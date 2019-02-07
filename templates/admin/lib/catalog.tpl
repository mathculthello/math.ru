{include file="header.tpl"}
{include file=message.tpl}
<form name=subj method=post action="/admin/lib/catalog.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">Редактирование раздела</td></tr>
<tr><td class=tblheader1>Название</td><td><input type=text size=60 name="name" value="{$name}"></td></tr>
<tr><td class=tblheader1>Путь</td><td><input type=text size=60 name="path" value="{$path}"></td></tr>
<tr><td class=tblheader1>Родительский раздел</td>
<td><select name=pid>{foreach from=$catalog item=s key=i}
{if !($id == $s.pid || $lft == $s.lft || ($s.lft >= $lft && $s.lft <= $rgt))}
<option value="{$i}"{if $i == $pid} selected{/if}>{""|indent:$s.level:"&nbsp;&nbsp;&nbsp;&nbsp;"}{$s.name}</option>
{/if}{/foreach}</select></td></tr>
{if $books_num}
<tr><td class=tblheader1>Книги ({$books_num})</td>
<td><input type=checkbox name="movebooks"> переместить в раздел 
<select name="moveto">{foreach from=$catalog item=s key=i}{if $i != $id}
<option value="{$i}"{if $i == $pid} selected{/if}>{""|indent:$s.level:"&nbsp;&nbsp;&nbsp;&nbsp;"}{$s.name}</option>
{/if}{/foreach}</select></td></tr>
{/if}
<tr class="tblheader"><td></td><td align=right><input type=submit name=save value="сохранить">{if $id} <input type=submit name=remove value="удалить">{/if}</td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=subj value=1>
</form>

{if $books}
<hr/>
{include file="lib/book_list_.tpl" _href="/admin/lib/catalog.php"}
{/if}