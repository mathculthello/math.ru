{include file="header.tpl"}
{include file=message.tpl}
<form name=problem method=post action="/admin/problem.php">
<table width=100%>
<tr class=tblheader1><td>{if $id}<input type=submit name=remove value="удалить">{/if}</td><td align=right><input type=submit name=save value="сохранить">{if $id} <input type=submit name=tex2mathml value="TeX->MathML"> <input type=submit name=tex2png value="TeX->png">{/if}</td></tr>
<tr><td class=tblheader1 valign=top>Автор(ы)</td><td><input type=text size=80 name=author value="{$author}"></td></tr>
<tr><td colspan=2 class=tblheader1>TeX</td></tr>
<tr><td class=tblheader1 valign=top>Условие</td><td><textarea cols=80 rows=10 name="tex_problem">{$tex_problem}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Ответ</td><td><textarea cols=80 rows=3 name="tex_answer">{$tex_answer}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Решение</td><td><textarea cols=80 rows=10 name="tex_solution">{$tex_solution}</textarea></td></tr>
<tr><td colspan=2 class=tblheader1>MathML</td></tr>
<tr><td class=tblheader1 valign=top>Условие</td><td><textarea cols=80 rows=10 name="mathml_problem">{$mathml_problem}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Ответ</td><td><textarea cols=80 rows=3 name="mathml_answer">{$mathml_answer}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Решение</td><td><textarea cols=80 rows=10 name="mathml_solution">{$mathml_solution}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Раздел</td>
<td><select name="sid[]" multiple>{foreach from=$section item=s key=i}
<option value="{$i}"{if $s.checked} selected{/if}>{""|indent:$s.level:"&nbsp;&nbsp;&nbsp;&nbsp;"}{$s.name}</option>
{/foreach}</select></td></tr>
<tr><td class=tblheader1 valign=top>ТК</td>
<td><select name="subjid[]" multiple>{foreach from=$subject item=s key=i}
<option value="{$i}"{if $s.checked} selected{/if}>{""|indent:$s.level:"&nbsp;&nbsp;&nbsp;&nbsp;"}{$s.name}</option>
{/foreach}</select></td></tr>
<tr class=tblheader1><td>{if $id}<input type=submit name=remove value="удалить">{/if}</td><td align=right><input type=submit name=save value="сохранить">{if $id} <input type=submit name=tex2mathml value="TeX->MathML"> <input type=submit name=tex2png value="TeX->png">{/if}</td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=pr value=1>
</form>
{if $tex2png}
<SCRIPT language=javascript>
    var title = 'tex2png output';
    _tex2png = window.open("",title.value,"width=680,height=600,resizable,scrollbars=yes");
    _tex2png.document.write("<HTML><TITLE>"+title+"</TITLE><BODY bgcolor=#ffffff>");
{foreach from=$tex2png_output item=str}
    _tex2png.document.write("{$str|strip}<br>");
{/foreach}
    _tex2png.document.write("</BODY></HTML>");
    _tex2png.document.close();
</SCRIPT>
{/if}