<ul>
{foreach from=$words item=w name=term}
<li>{if $w.id == $term}{$w.title}{else}<a href="/dic/{$w.id}">{$w.title}</a>{/if}</li>
{/foreach}
</ul>
{*{if $w.type == 'term'}[!]{elseif $w.type == 'fact'}[?]{elseif $w.type == 'formula'}[*]{/if}*}