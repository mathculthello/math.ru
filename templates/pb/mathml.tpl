{include file="pb/header.xtpl"}
<tr>
<td id="menu" valign="top">
{include file="pb/section.tpl"}
<img src="/i/p.gif" width="1" height="10"/>
{include file="pb/subj.tpl"}
<img src="/i/p.gif" width="1" height="10"/>
{include file="pb/format.tpl"}

</td>
    <td id="content" valign="top" align="center"><div>


{literal}
<script type="text/javascript" language="JavaScript">
var ie4, nn4, nn6
    ie4 = nn4 = nn6
if (document.all)
        {ie4 = 1}
if (document.layers)
        {nn4 = 1}
if (document.getElementById) {
        if(!ie4){nn6 = 1}
}
                
function getinfoU(ie,nn,button) {
    buttonname = "solutionbutton" + button
    if (ie4) {
        if (document.all.item(ie).style.display == '') {
            document.all.item(ie).style.display = 'none'
            document.all.item(buttonname).value = 'Показать решение'
            document.all.item(buttonname).title = 'Показать решение'
        } else {
            document.all.item(ie).style.display = ''
            document.all.item(buttonname).value = 'Скрыть решение'
            document.all.item(buttonname).title = 'Скрыть решение'
        }
    }
    if (nn6) {
        if (document.getElementById(ie).style.display == '') {
            document.getElementById(ie).style.display = 'none'
            document.getElementById(buttonname).value = 'Показать решение'
            document.getElementById(buttonname).title = 'Показать решение'
        } else {
            document.getElementById(ie).style.display = ''
            document.getElementById(buttonname).value = 'Скрыть решение'
            document.getElementById(buttonname).title = 'Скрыть решение'
        }
    }       
}
</script>
{/literal}

{include file="generic/pages.tpl" _info="1"}
<hr/>
{section loop=$problem name=i}

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td><h4>Задача #{$problem[i].id}</h4></td>
        <td align="right" style="font: 11px"><a href="/pb/texproblem.php?id={$problem[i].id}">Скачать в TеX</a> | <a href="/pb/discuss.php?id={$problem[i].id}">Обсудить на форуме</a></td>
    </tr>
</table><br/>
{$problem[i].mathml_problem}<br/>
<input id="solutionbutton{$problem[i].id}" type="button" class="solutionbutton" value="Показать решение" onclick="getinfoU('solution{$problem[i].id}', 'document.solution{$problem[i].id}', {$problem[i].id})" title="Показать решение"/>
<div id="solution{$problem[i].id}" style="display:none;">
<b>Решение</b><br/>
{$problem[i].mathml_solution}
</div>

<hr/>
{/section}

{include file="generic/pages.tpl" _info="1"}<br/>

    </div></td>
    <td id="right" valign="top">
    {include file="pb/display_format.tpl"}
    </td>
</tr>
{include file="footer.tpl"}