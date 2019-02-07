{include file="header.tpl"}
<input type=button onclick="document.location='/admin/problem.php'" value="Добавить задачу">
<hr size=1 noshade>
<br><br>
{include file="pages.tpl"}<br>
{section loop=$problem name=i}
<b>Задача #{$problem[i].id}</b><br>
{$problem[i].tex_problem}<br>
<div align=right><a href="/admin/problem.php?id={$problem[i].id}">Редактировать</a></div>
<hr size=1 noshade>
{/section}
<br>{include file="pages.tpl"}
