{include file="pb/header.tpl"}
<tr>
    <td id=menu valign=top>
{include file="pb/section.tpl"}
<img src="/i/p.gif" width=1 height=10><br>
{include file="pb/subj.tpl"}<br>
    </td>
    <td id=content valign=top align=center><div>
{include file="generic/pages_info.tpl"}<br>
{include file="generic/pages.tpl"}<br>
{section loop=$problem name=i}
<b>Задача #{$problem[i].id}</b><br>
{$problem[i].tex_problem}<br>
<hr>
{/section}
{include file="generic/pages.tpl"}
    </div></td>
    <td id=right valign=top><img src="/i/p.gif" width=1 height=7><br>
    {include file="news.tpl"}
    </td>
</tr>
{include file="footer.tpl"}