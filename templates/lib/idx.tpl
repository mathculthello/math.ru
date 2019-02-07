var books = new Array();
{foreach from=$books item=b}
{strip}
books[{$b.id}] = {literal}{{/literal}id:{$b.id}, title: '{$b.title|escape}', path: '{$b.path|escape}', author: new Array(
{foreach from=$b.author item=a name=au}{literal}{{/literal}id:{$a.id}, path:'{$a.path|escape}', name:'{$a.fname|escape|initials}{$a.sname|escape|initials}{$a.lname|escape}'{literal}}{/literal}{if !$smarty.foreach.au.last},{/if}{/foreach}) {literal}}{/literal};
{/strip}
{/foreach}

var key_index = new Array();
{foreach from=$key_index item=k key=i}
key_index[{$i}] = new Array({foreach from=$k item=b name=bi}{$b}{if !$smarty.foreach.bi.last},{/if}{/foreach});
{/foreach}

var year_index = new Array();
{foreach from=$year_index item=k key=i}
year_index[{$i}] = new Array({foreach from=$k item=b name=bi}{$b}{if !$smarty.foreach.bi.last},{/if}{/foreach});
{/foreach}

var author_index = new Array();
{foreach from=$author_index item=k key=i}
author_index[{$i}] = new Array({foreach from=$k item=b name=bi}{$b}{if !$smarty.foreach.bi.last},{/if}{/foreach});
{/foreach}
