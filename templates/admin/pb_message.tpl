{include file="header.tpl"}
<form name=message method=post action="/admin/pb_message.php">
<table width=100%>
<tr><td class=tblheader1>Время</td><td>{$time}</td></tr>
<tr><td class=tblheader1>Имя</td><td>{$name}</td></tr>
<tr><td class=tblheader1>email</td><td>{$email}</td></tr>
<tr><td class=tblheader1>Состояние</td><td><select name="state"><option value="hide"{if $state=='hide'} selected{/if}>скрыть</option><option value="display"{if $state=='display'} selected{/if}>показывать</option></select></td></tr>
<tr><td class=tblheader1>Задача</td><td><a href="/admin/problem.php?id={$problem_id}">Задача #{$problem_id}</a></td></tr>
<tr><td class=tblheader1>Текст</td><td><textarea cols=50 rows=10 name="text">{$text}</textarea></td></tr>
<tr class=tblheader1><td>{if $id} <input type=submit name=remove value="удалить">{/if}</td><td><input type=submit name=save value="сохранить"></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=message value=1>
</form>