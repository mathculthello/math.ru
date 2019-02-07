{include file="header.tpl"}
{include file="message.tpl"}
<form name=section method=post action="/admin/subject.php">
<table width=100%>
<tr><td class=tblheader1>Название</td><td><input type=text size=60 name="name" value="{$name}"></td></tr>
<tr><td class=tblheader1>Путь</td><td><input type=text size=30 name="path" value="{$path}"></td></tr>
<tr valign=top><td class=tblheader1>Родительский раздел</td>
<td><select name=pid size=10>{foreach from=$section item=s key=i}
{if !($id == $s.pid || $lft == $s.lft || ($s.lft >= $lft && $s.lft <= $rgt))}
<option value="{$i}"{if $i == $pid} selected{/if}>{""|indent:$s.level:"&nbsp;&nbsp;&nbsp;&nbsp;"}{$s.name}</option>
{/if}{/foreach}</select></td></tr>
{if $items_num}
<tr valign=top><td class=tblheader1>Задачи ({$items_num})</td>
<td><input type=checkbox name="moveitems"> переместить в раздел<br> 
<select name="moveto" size=10>{foreach from=$section item=s key=i}
<option value="{$i}"{if $i == $id} selected{/if}>{""|indent:$s.level:"&nbsp;&nbsp;&nbsp;&nbsp;"}{$s.name}</option>
{/foreach}</select></td></tr>
{/if}
<tr class=tblheader1><td></td><td align=right><input type=submit name=save value="сохранить">{if $id} <input type=submit name=remove value="удалить">{/if}</td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=section value=1>
</form>