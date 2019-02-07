{include file="history/header.tpl"}
<tr>
<td id=menucol valign=top>
{include file="menu.tpl" _path="/history/tree/"}
<img src="/i/p.gif" width=1 height=10><br/>
{include file="lib/alpha.tpl" _href="/history/tree/"} 
<img src="/i/p.gif" width=1 height=10><br/>
{include file="history/tree/search.tpl" _href="/history/tree/"} 
</td>
<td id=content valign=top align=center><div>

<h1>
Просим Вас с пониманием отнестись к тому, что информация попадет на сайт после просмотра членом редколлегии сайта.
</h1>
{include file="admin/message.tpl"}


<form name="person" method="post" enctype="multipart/form-data" action="">
<table width=100%>
<tr><td colspan="4" class="tblheader">{if $id}Изменить информацию{else}Добавить последователя{/if}</td></tr>
<tr><td class=tblheader1>Учитель</td><td colspan="3">{include file="history/tree/path.tpl"}</td></tr>
<tr><td class=tblheader1>Фамилия&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td colspan="3"> <input type=text size=25 name="lname" value="{$lname}"></td></tr>
<tr><td class=tblheader1>Имя&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td colspan="3"> <input type=text size=25 name="fname" value="{$fname}"></td></tr>
<tr><td class=tblheader1>Отчество</td><td colspan="3"> <input type=text size=25 name="sname" value="{$sname}"></td></tr>
<tr><td class=tblheader1>Портрет</td><td colspan="3">{if $portrait}<img src="/history/people/portrait/{$id}.{$portrait}" width="{$portrait_width}" height="{$portrait_height}"><br><br>{/if}загрузить: <input type="file" name="portrait_file"></td></tr>
<tr><td class=tblheader1>Даты рождения/смерти (в формате гггг-мм-дд)</td><td colspan="3"><input type=text size=12 name="birth_date" value="{$birth_date}"/> - <input type=text size=12 name="death_date" value="{$death_date}"/></td></tr>
<tr><td class=tblheader1 valign=top>Биографическая справка</td><td colspan="3"><textarea cols=60 rows=10 name=shortbio width="100%">{$shortbio}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Источник информации</td><td colspan="3"><input type=text size=80 name=source value="{$source}"></td></tr>
<tr><td class=tblheader1 valign=top>Область научных интересов</td><td colspan="3"><textarea cols=60 rows=10 name=area width="100%">{$area}</textarea></td></tr>
<tr><td colspan=4 class=tblheader>Информация о Вас</td></tr>
<tr>
<td class=tblheader1>ФИО&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td><input type=text name=name value="{$name}"></td>
<td class=tblheader1>Контакты&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td><input type=text name=contacts value="{$contacts}"></td>
</tr>
<tr>
<td class=tblheader1>Место работы</td><td><input type=text name=job value="{$job}"></td>
<td class=tblheader1>Профессия</td><td><input type=text name=occupation value="{$occupation}"></td>
</tr>
<tr class=tblheader><td align=right colspan="4"><input type=submit name=save value="Отправить"></td></tr>
<input type=hidden name=mode value="{$mode}">
<input type=hidden name=pid value="{$pid}">
<input type=hidden name=id value="{$id}">
<input type=hidden name=person value=1>
</table>
</form>
<br/>

</div></td>
<td id=right valign=top><img src="/i/p.gif" width=1 height=7><br>
{include file="right.tpl"}
</td>
</tr>
{include file="footer.tpl"}
