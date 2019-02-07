{foreach from=$rubr_list item=s key=i}
{""|indent:$s.level-1:"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"}{if $s.level == 1}<h1>{elseif $s.level == 2}<b>{/if}<a href="/dic/rubr/{$i}">{$s.name}</a>{if $s.level == 1}</h1>{elseif $s.level == 2}</b><br/>{else}<br/>{/if}
{/foreach}