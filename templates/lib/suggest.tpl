{include file="lib/header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file="lib/left.tpl" _path="/lib/suggest"}
</td>
<td id=content valign=top align=center><div>

{if isset($message)}<hr><b>{$message}</b><hr>{/if}
<br/>
Если вы считаете, что какая-то интересная книга не вошла в библиотеку - напишите нам
и мы постараемся ее включить.<br/>
(естественно, если это возможно по соображениям авторского права.)
<br/><br/>
<form name=suggest method=post action="/lib/suggest.php">
<table width=100%>
<tr><td colspan="4" class="tblheader">Добавить книгу</td></tr>
<tr><td class=tblheader1 width=150>Автор(ы)&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td colspan=3><input type=text name=sauthor style="width:100%" value="{if isset($sauthor)}{$sauthor}{/if}"></td><td></td></tr>
<tr><td class=tblheader1>Название&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td colspan=3><input type=text name=stitle style="width:100%" value="{if isset($stitle)}{$stitle}{/if}"></td><td></td></tr>
<tr><td class=tblheader1>Издание, год</td><td colspan=3><input type=text name=publ style="width:100%" value="{if isset($publ)}{$publ}{/if}"></td><td></td></tr>
<tr><td class=tblheader1 valign=top>Дополнительная информация</td><td colspan=3><textarea rows=3 name=info style="width:100%">{if isset($info)}{$info}{/if}</textarea></td><td></td></tr>
<tr><td colspan=4 class=tblheader>Информация о вас</td></tr>
<tr>
<td class=tblheader1>ФИО&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td><input type=text name=name value="{if isset($name)}{$name}{/if}"></td>
<td class=tblheader1>Контакты&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td><input type=text name=contacts value="{if isset($contacts)}{$contacts}{/if}"></td>
</tr>
<tr>
<td class=tblheader1>Место работы</td><td><input type=text name=job value="{if isset($job)}{$job}{/if}"></td>
<td class=tblheader1>Профессия</td><td><input type=text name=occupation value="{if isset($occupation)}{$occupation}{/if}"></td>
</tr>
<tr><td colspan=4 align=right class=tblheader1><input type=submit value="Отправить"></td></tr>
</table><input type=hidden name=suggest value=1></form>

</div></td>
<td id=right valign=top width=150>
{include file="lib/right.tpl"}
</td>
</tr>
{include file="footer.tpl"}
