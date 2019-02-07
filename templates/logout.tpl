    <table width="165" cellpadding=1 cellspacing=0 border=0 align=center>

    <tr><td bgcolor="#6C6C6C">
    <table width="100%" cellpadding=3 cellspacing=0 border=0 align=center bgcolor="#f4f4f4"><form name=logout method=post>
    <tr><th class=tit1>Пользователь</th></tr>
    <tr><td align=left class=small>Имя: {$_user_login}</td></tr>
    <tr><td align=left class=small>Email: {$_user_email}</td></tr>
    <tr><td align=left class=small><a href="/auth/profile.php">Персональная информация</a></td></tr>
    <tr><td align=left class=small><a href="/auth/cd_key.php">Ключ для CD</a></td></tr>
<input type='hidden' name='logout' value=1>
    <tr><td  align=center><input type="button" onClick="document.logout.submit();" name="logout" value="Выход" onMouseOver="this.style.backgroundImage='url(i/bmfon2.gif)'" onMouseOut="this.style.backgroundImage='url(i/bmfon.gif)'" onMouseDown="this.style.backgroundImage='url(i/bmfon3.gif)'" class="button"/></td></tr>
    </form>
    </table>
    </td></tr>
    </table><br/>
