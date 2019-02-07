{include file="teacher/header.tpl"}
<tr>
	<td id=menucol valign=top>
{include file="menu.tpl" _path="/teacher/"}
<br/>
{include file="teacher/courses_menu.tpl" _path="/teacher/"}
<br/>
{if !$_user_loggedin}
{include file="login.tpl"}
{/if}
	</td>
	<td id=content valign=top align=center><div>
<h1 align="center">Элективные курсы</h1>

<h2 align="center">Старшая школа (10&#8211;11 классы)</h2>
<p>
<ol>
	<li><a href="mnogogr.doc">Многогранники</a>.
	<li><a href="difur.doc">Дифференциальные уравнения и их приложения</a>.
	<li><a href="image10.doc">Изображение пространственных фигур</a>.
</ol>
</p>
<h2 align="center">Основная школа (7&#8211;9 классы)</h2>
<p>
<ol>
	<li><a href="line.doc">Кривые</a>.
	<li><a href="mnogogr7.doc">Многогранники</a>.
</ol>
</p>

	</div></td>
	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>
</tr>
{include file="footer.tpl"}