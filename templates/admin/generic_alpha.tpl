{*
_href ? &
*}

<div id=abc>
<a href="{$_href}192"{if $_l == 192} class=select{/if}>А</a>
<a href="{$_href}193"{if $_l == 193} class=select{/if}>Б</a>
<a href="{$_href}194"{if $_l == 194} class=select{/if}>В</a>
<a href="{$_href}195"{if $_l == 195} class=select{/if}>Г</a>
<a href="{$_href}196"{if $_l == 196} class=select{/if}>Д</a>
<a href="{$_href}197"{if $_l == 197} class=select{/if}>Е</a>
<a href="{$_href}198"{if $_l == 198} class=select{/if}>Ж</a>
<a href="{$_href}199"{if $_l == 199} class=select{/if}>З</a>
<a href="{$_href}200"{if $_l == 200} class=select{/if}>И</a>
<a href="{$_href}202"{if $_l == 202} class=select{/if}>К</a>
<a href="{$_href}203"{if $_l == 203} class=select{/if}>Л</a>
<a href="{$_href}204"{if $_l == 204} class=select{/if}>М</a>
<a href="{$_href}205"{if $_l == 205} class=select{/if}>Н</a>
<a href="{$_href}206"{if $_l == 206} class=select{/if}>О</a>
<a href="{$_href}207"{if $_l == 207} class=select{/if}>П</a>
<a href="{$_href}208"{if $_l == 208} class=select{/if}>Р</a>
<a href="{$_href}209"{if $_l == 209} class=select{/if}>С</a>
<a href="{$_href}210"{if $_l == 210} class=select{/if}>Т</a>
<a href="{$_href}211"{if $_l == 211} class=select{/if}>У</a>
<a href="{$_href}212"{if $_l == 212} class=select{/if}>Ф</a>
<a href="{$_href}213"{if $_l == 213} class=select{/if}>Х</a>
<a href="{$_href}214"{if $_l == 214} class=select{/if}>Ц</a>
<a href="{$_href}215"{if $_l == 215} class=select{/if}>Ч</a>
<a href="{$_href}216"{if $_l == 216} class=select{/if}>Ш</a>
<a href="{$_href}217"{if $_l == 217} class=select{/if}>Щ</a>
<a href="{$_href}221"{if $_l == 221} class=select{/if}>Э</a>
<a href="{$_href}222"{if $_l == 222} class=select{/if}>Ю</a>
<a href="{$_href}223"{if $_l == 223} class=select{/if}>Я</a>
<br>
<a href="{$_href}A"{if $_l == 1065} class=select{/if}>A</a>
<a href="{$_href}B"{if $_l == 1066} class=select{/if}>B</a>
<a href="{$_href}C"{if $_l == 1067} class=select{/if}>C</a>
<a href="{$_href}D"{if $_l == 1068} class=select{/if}>D</a>
<a href="{$_href}E"{if $_l == 1069} class=select{/if}>E</a>
<a href="{$_href}F"{if $_l == 1070} class=select{/if}>F</a>
<a href="{$_href}G"{if $_l == 1071} class=select{/if}>G</a>
<a href="{$_href}H"{if $_l == 1072} class=select{/if}>H</a>
<a href="{$_href}I"{if $_l == 1073} class=select{/if}>I</a>
<a href="{$_href}J"{if $_l == 1074} class=select{/if}>J</a>
<a href="{$_href}K"{if $_l == 1075} class=select{/if}>K</a>
<a href="{$_href}L"{if $_l == 1076} class=select{/if}>L</a>
<a href="{$_href}M"{if $_l == 1077} class=select{/if}>M</a>
<a href="{$_href}N"{if $_l == 1078} class=select{/if}>N</a>
<a href="{$_href}O"{if $_l == 1079} class=select{/if}>O</a>
<a href="{$_href}P"{if $_l == 1080} class=select{/if}>P</a>
<a href="{$_href}Q"{if $_l == 1081} class=select{/if}>Q</a>
<a href="{$_href}R"{if $_l == 1082} class=select{/if}>R</a>
<a href="{$_href}S"{if $_l == 1083} class=select{/if}>S</a>
<a href="{$_href}T"{if $_l == 1084} class=select{/if}>T</a>
<a href="{$_href}U"{if $_l == 1085} class=select{/if}>U</a>
<a href="{$_href}V"{if $_l == 1086} class=select{/if}>V</a>
<a href="{$_href}W"{if $_l == 1087} class=select{/if}>W</a>
<a href="{$_href}X"{if $_l == 1088} class=select{/if}>X</a>
<a href="{$_href}Y"{if $_l == 1089} class=select{/if}>Y</a>
<a href="{$_href}Z"{if $_l == 1090} class=select{/if}>Z</a>

</div>

{*
{foreach from=$rus_letters item=l key=ord}
<a href="{$_href}{$ord}"{if $ord==$letter} class="select"{/if}>{$l}</a> 
{/foreach}<br/><br/>
{foreach from=$lat_letters item=l key=ord}
{if $ord==$letter}<b>{$l}</b> {else}<a href="{$_href}{$l}">{$l}</a> {/if}
{/foreach}
*}