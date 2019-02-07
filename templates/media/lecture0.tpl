{include file="media/header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file="menu.tpl"}
    <center >
    <img src="/i/ma_line.gif" width="160" height="1" vspace=4><br>
    Для просмотра файлов<br>необходим <b>RealPlayer</b><br>версии 9 или выше.<br>
    <a href="http://www.real.com" target="_blank"><img src="/i/ma_real_logo.gif" width="81" height="33" border="0" alt="Установить RealPlayer" vspace=4></a><br>
    <img src=/i/ma_line.gif" width="160" height="1"></center>
</td>
<td id=content valign=top align=center><div>
<img src="/i/p.gif" width="1" height="10"/>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" id=bl2>
    <tr><td id=razd><img src="/i/p.gif" width="1" height="1"></td></tr>

    <tr>
        <td id=cnt>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td id=realfoto rowspan=2 width=176 valign=top>
                <img src="/i/p.gif" width="1" height="11"><br>
{foreach from=$screen item=s}
                <img src="/media/img/{$id}_image{$s.id}.{$s.ext}" width="170" height="115" border="0">
{/foreach}
                <br>
                <img src="/i/p.gif" width="1" height="20"></td>
                <td rowspan=2 width=10><img src="/i/p.gif" width="10" height="1"></td>
                <td valign=top><h1>{$title}</h1>
                <p>{$lect}<br>
                <img src="/i/p.gif" width="1" height="6"><br>
                <b>{$date|date_format:"%d.%m.%Y"}</b></p>
                </td>
            </tr>
            <tr>
                <td valign=bottom align=right id=ma_bm>
{if $path}                
                [ <img src="/i/ma_real_ico.gif" width="17" height="16" border="0" alt="Запись в формате {$l.codec}" align=absmiddle> <u>{$codec}</u>, {$size} Mb. ]&nbsp;&nbsp;&nbsp;<a href="/media/files/{$path}"><img src="/i/ma_load.gif" width="135" height="17" border="0" alt="Скачать запись" align=absmiddle></a>
{/if}               
                </td>
            </tr>
        </table>
    </tr>
    <tr><td id=razd><img src="/i/p.gif" width="1" height="1"></td></tr>
    <tr><td><img src="/i/p.gif" width="1" height="5"></td></tr>

</table>
</div></td>
<td id=right valign=top width=150>
{include file="right.tpl"}
</td>
</tr>
{include file="footer.tpl"}
