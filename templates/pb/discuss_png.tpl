{include file="pb/header.tpl"}
<tr>
    <td id=menu valign=top>
{include file="pb/section.tpl"}
<img src="/i/p.gif" width=1 height=10>
{include file="pb/subj.tpl"}
<img src="/i/p.gif" width=1 height=10>
{include file="pb/format.tpl"}

</td>
    <td id=content valign=top align=center><div>
<h4>Задача #{$problem.id}</h4>
<img src=/pb/img/{$problem.id}_p.png><br/>
<h4>Решение</h4>
<img src=/pb/img/{$problem.id}_s.png>
<br/><br/>
<hr/>
<br/>
{include file="pb/message.tpl"}
<br/>
    </div></td>
    <td id=right valign=top>
    {include file="pb/display_format.tpl"}
    {include file="news.tpl"}
    </td>
</tr>
{include file="footer.tpl"}