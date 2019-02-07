{foreach from=$rubr_path item=r name="rpath"}
{if !$smarty.foreach.rpath.last}<a href="/dic/rubr/{$r.id}">{$r.name}</a> :: {else} {$r.name} {/if}
{/foreach}
