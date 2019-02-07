function confirmLink(theLink, theMsg)
{
    // Confirmation is not required in the configuration file
    // or browser is Opera (crappy js implementation)
//    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
//        return true;
//    }

    var is_confirmed = confirm(theMsg);
    if (is_confirmed) {
        theLink.href += '&is_js_confirmed=1';
    }

    return is_confirmed;
} // end of the 'confirmLink()' function


function confirmGo(theMsg, theURL)
{

//    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
//        return true;
//    }

    var is_confirmed = confirm(theMsg);
    if (is_confirmed) {
//        theLink.href += '&is_js_confirmed=1';
		document.location = theURL;
    }
    return is_confirmed;
} // end of the 'confirmLink()' function

function binn_enlargeArea(btn, el_id)
{
    div_el = document.getElementById(el_id);
    if (div_el.style.position != 'absolute')
    {
        var main_tbl = document.forms[0].childNodes[0];
        var selEls = document.forms[0].elements; 
        main_tbl.style.visibility = 'hidden';
        for (i = 0; i < selEls.length; i++)
            selEls[i].style.visibility = 'hidden';
        div_el.style.position = 'absolute';
        var selEls = div_el.all; 
        for (i = 0; i < selEls.length; i++)
            selEls[i].style.visibility = 'visible';
        document.body.scroll = 'no';
        div_el.style.top = document.body.scrollTop+10;
        div_el.style.left = 10;
        binn_areaResize();
        btn.value = '-';
        btn.title = '????????';
        window.attachEvent('onresize', binn_areaResize);
        div_el.style.visibility = 'visible';
    }
    else
    {
        var main_tbl = document.forms[0].childNodes[0];
        var selEls = document.forms[0].elements; 
        div_el.style.position = '';
        div_el.style.top = '';
        div_el.style.left = '';
        div_el.style.width = '';
        var area = div_el.all.tags('TEXTAREA');
        area[0].style.width = '';
        area[0].style.height = '';
        document.body.scroll = 'yes';
        btn.value = '+';
        btn.title = '??????????';
        window.detachEvent('onresize', binn_areaResize);
        main_tbl.style.visibility = 'visible';
        for (i = 0; i < selEls.length; i++)
            selEls[i].style.visibility = 'visible';
    }
}
function binn_areaResize()
{
    div_el.style.width = document.body.clientWidth-20;
    var area = div_el.all.tags('TEXTAREA');
    area[0].style.width = document.body.clientWidth-20;
    area[0].style.height = document.body.clientHeight-60;
}

/**
 * Checks/unchecks all tables
 *
 * @param   string   the form name
 * @param   boolean  whether to check or to uncheck the element
 *
 * @return  boolean  always true
 */
function setCheckboxes(the_form, the_elements, do_check)
{
    var elts      = document.forms[the_form].elements[the_elements+'[]'];
    var elts_cnt  = elts.length;

    if (elts_cnt) {
        for (var i = 0; i < elts_cnt; i++) {
            elts[i].checked = do_check;
        } // end for
    } else {
        elts.checked        = do_check;
    } // end if... else

    return true;
} // end of the 'setCheckboxes()' function

function toggleBox(tab_indx, tab_num)
{

	var oElement = null;

	for (var i = 0; i < tab_num; i++)
	{
		oElement = document.getElementById('box' + i);
		if (i == tab_indx && oElement.style.display == 'none')
		{
			oElement.style.display = 'block';
		}
		else
		{
			oElement.style.display = 'none';
		}
	}

	document.body.focus();
}
