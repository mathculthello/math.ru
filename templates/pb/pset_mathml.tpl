{include file="header.tpl"}
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
                
function getinfoU(ie,nn,button)
{
buttonname = "solutionbutton" + button
if (ie4)
        {
        if (document.all.item(ie).style.display == '') 
          {
          document.all.item(ie).style.display = 'none'
          document.all.item(buttonname).value = 'РџРѕРєР°Р·Р°С‚СЊ СЂРµС€РµРЅРёРµ'
          document.all.item(buttonname).title = 'РџРѕРєР°Р·Р°С‚СЊ СЂРµС€РµРЅРёРµ'

          }
          else
          {
          document.all.item(ie).style.display = ''
          document.all.item(buttonname).value = 'РЎРєСЂС‹С‚СЊ СЂРµС€РµРЅРёРµ'
          document.all.item(buttonname).title = 'РЎРєСЂС‹С‚СЊ СЂРµС€РµРЅРёРµ'
          }
        }
if (nn6)
        {
        if (document.getElementById(ie).style.display == '') 
          {
          document.getElementById(ie).style.display = 'none'
          document.getElementById(buttonname).value = 'РџРѕРєР°Р·Р°С‚СЊ СЂРµС€РµРЅРёРµ'
          document.getElementById(buttonname).title = 'РџРѕРєР°Р·Р°С‚СЊ СЂРµС€РµРЅРёРµ'
          }
          else
          {
        document.getElementById(ie).style.display = ''
          document.getElementById(buttonname).value = 'РЎРєСЂС‹С‚СЊ СЂРµС€РµРЅРёРµ'
          document.getElementById(buttonname).title = 'РЎРєСЂС‹С‚СЊ СЂРµС€РµРЅРёРµ'
          }
        }       

}
</script>
{/literal}

<table border="0" cellpadding="10" cellspacing="5" width="100%" valign="top">
{foreach from=$problems item=p}
<tr><td>
<b>Р—Р°РґР°С‡Р° {$p.num}</b><div align="right"><a href="/olympiads/mmo/texproblem.php?id={$p.id}">РЎРєР°С‡Р°С‚СЊ TРµX-РІР°СЂРёР°РЅС‚</a></div><br/>
{$p.mathml_problem}
<br/>
{foreach from=$p.ppic item=pic}
{$pic.num}
<img src="/olympiads/pic/{$p.id}p_{$pic.num}.{$pic.type}"/><br/>
{/foreach}
<br/>
<input id="solutionbutton{$p.id}" type="button" class="solutionbutton" value="РџРѕРєР°Р·Р°С‚СЊ СЂРµС€РµРЅРёРµ" onclick="getinfoU('solution{$p.id}', 'document.solution{$p.id}', {$p.id})" title="РџРѕРєР°Р·Р°С‚СЊ СЂРµС€РµРЅРёРµ" />
<div id="solution{$p.id}" style="display:none;">
<b>Р РµС€РµРЅРёРµ</b><br/>
{$p.mathml_solution}
</div>
</td></tr>
{/foreach}
</table>
{include file="footer.xtpl"}