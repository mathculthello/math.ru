{if $error_message}

<table width="100%" cellpadding=1 cellspacing=0 border=0><tr><td bgcolor="#CC0000" width="100%">
<table width="100%" cellpadding=0 cellspacing=0 border=0>
<tr><td class=tit_error height=18><img src="/i/s_error.png" width=16 height=16 hspace=0 vspace=0 border=0> Ошибка</td></tr>
<tr><td class=tbldata1 valign=top>
<ul>
{section name=i loop=$error_message}<li>{$error_message[i]}{/section}
</ul>
</td></tr></table>
</td></tr></table>

{elseif $message}
<table width="100%" cellpadding=1 cellspacing=0 border=0><tr><td bgcolor="#339900" width="100%">
<table width="100%" cellpadding=0 cellspacing=0 border=0>
<tr><td class=tit_okay height=18><img src="/i/s_okay.png" width=16 height=16 hspace=0 vspace=0 border=0></td></tr>
<tr><td class=tbldata1 valign=top>
<ul>
<li>{$message}
</ul>
</td></tr></table>
</td></tr></table>
{/if}
