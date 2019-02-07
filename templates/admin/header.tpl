<HTML>
<HEAD>
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
<LINK rel=stylesheet type=text/css href="/admin/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{$_title|default:"Math.ru Admin"}</title>
<script src="/admin/functions.js" type="text/javascript" language="javascript"></script>
</HEAD>
<body style="margin: 0 0;">
{literal}
<script language='javascript'>
				function showTabPage(tab_indx, tab_num)
				{
				
					var oElement = null;

					for (var i = 0; i < tab_num; i++)
					{
						oElement = document.getElementById('tab' + i);
						oElement.className = 'tabOff';
						oElement = document.getElementById('page' + i);
						oElement.style.display = 'none';
					}

					oElement = document.getElementById('tab' + tab_indx);
					oElement.className = 'tabOn';
					oElement = document.getElementById('page' + tab_indx);
					oElement.style.display = 'block';

					document.body.focus();
				}
</script>
{/literal}
