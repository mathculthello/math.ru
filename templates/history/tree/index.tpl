{include file="history/header.tpl"}
<tr>
<td id=menucol valign=top>
{include file="menu.tpl" _path="/history/tree/"}
<img src="/i/p.gif" width=1 height=10><br/>
{include file="lib/alpha.tpl" _href="/history/tree/"} 
<img src="/i/p.gif" width=1 height=10><br/>
{include file="history/tree/search.tpl" _href="/history/tree/"} 
</td>
<td id=content valign=top align=center><div>

<br/>
{include file="history/tree/jstree.tpl" _tree=$tree _url="/history/tree/"}
<br/>
<hr size="1" noshade="1"/>
{include file="history/tree/path.tpl"}
<br/>
{include file="history/tree/person_info.tpl"}
<br/>
<table width="100%"><tr><td align="right"><input type="button" onclick="window.location='/history/tree/new/{$path}'" value="Добавить последователя" /> <input type="button" onclick="window.location='/history/tree/new.php?id={$id}'" value="Дополнить информацию" /></td></tr></table>
<br/>

</div></td>
<td id=right valign=top><img src="/i/p.gif" width=1 height=7><br>
{include file="right.tpl"}
</td>
</tr>
{include file="history/tree/footer.tpl"}
