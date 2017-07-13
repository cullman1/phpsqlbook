function createElement(id, response) 
{
    whereheader = document.getElementById("whereheader");
    whereheader.innerHTML = "INTO:";
    var response1 = unescape(response);
    splitter = response1.split(",");
    root = document.createElement("div");

    for(i=1;i<=splitter.length-2;i++)
    {
        divname = "divup" + i;
        var second = document.getElementById(divname);
        var name1 = "textbox" + i;
        var third = document.getElementById(name1);
        var name2 = "button" +i ;
        var fourth = document.getElementById(name2);
        if (second!=null)
        {
            second.removeChild(third);
            second.removeChild(fourth);
        }
    }

    for(i=1;i<=splitter.length-2;i++)
    {
        elem = document.createElement("div");
        elem.id = "div" + i;
        elem1 = document.createElement("label"); 
        elem1.textContent  = splitter[i];
        elem1.id = "label" + i;
        elem2 = document.createElement("input");
        elem2.id = "checkbox" + i;
        elem2.name = "checkbox" + i;
        elem2.type = "checkbox";
        
        elem.appendChild(elem1);
        elem.appendChild(elem2);
      
        root.appendChild(elem);
    }
    var listener = document.getElementById("placeholderwhere").addEventListener("click", function(e) {

        if(e.target && e.target.nodeName == "INPUT") 
        {
            if (e.target.checked)
            {
                elem3 = document.createElement("input");
                elem3.id = "textbox" + e.target.id.replace("checkbox","");
                elem3.type = "text";
                elem3.name = "textbox" + e.target.id.replace("checkbox","");
            
                elem4 = document.createElement("input");
                elem4.id = "button" + e.target.id.replace("checkbox","");
                elem4.type = "button";
                elem4.style.marginLeft = "10px";
                elem4.name = "button" + e.target.id.replace("checkbox","");
                elem4.value = "Add Value";
                elem4.onclick = function (e) {  
                    var number = e.target.id.replace("button","");
                    var colnames = "";
                    var contents = "";
                    for(j=1;j<i;j++)
                    {
                        var colname = "label" + j;
                        var textcontent = "textbox" + j;
                        var doc1 = document.getElementById(colname);
                        var doc2 = document.getElementById(textcontent);
                        if (doc2 != null)
                        {
                            colnames = colnames + doc1.textContent + ",";
                            if (isNaN(doc2.value))
                            {
                                contents = contents + "'" + doc2.value + "',";
                            }
                            else
                            {
                                contents = contents + "" + doc2.value + ",";
                            }
                        }
                    }
                    $('#sqlquery').val("INSERT INTO " + $('#table').val() + " (" + colnames.substring(0,colnames.length-1) + ") VALUES (" +  contents.substring(0,contents.length-1) + ")");};
                divname = "div" + e.target.id.replace("checkbox","");
                var second = document.getElementById(divname);
                second.appendChild(elem3);
                second.appendChild(elem4);
            }
            else
            {
                if (e.target.id.indexOf("textbox")==-1 && e.target.id.indexOf("button")==-1 )
                {   
                    divname = "div" + e.target.id.replace("checkbox","");
                    var second = document.getElementById(divname);
                    var name1 = "textbox" + e.target.id.replace("checkbox","");
                    var third = document.getElementById(name1);
                    var name2 = "button" + e.target.id.replace("checkbox","");
                    var fourth = document.getElementById(name2);
                    second.removeChild(third);
                    second.removeChild(fourth);
                }
            }
        }
    });
    $('#'+id).html(root);
}

function createUpdate(id, response) 
{
    whereheader = document.getElementById("whereheader");
    whereheader.innerHTML = "SET:";
    var response1 = unescape(response);
    splitter = response1.split(",");
    root = document.createElement("div");
    
    //Remove previous textboxes
    for(i=1;i<=splitter.length-2;i++)
    {
        divname = "div" + i;
        var second = document.getElementById(divname);
        var name1 = "textbox" + i;
        var third = document.getElementById(name1);
        var name2 = "button" +i ;
        var fourth = document.getElementById(name2);
        if (second!=null)
        {
            second.removeChild(third);
            second.removeChild(fourth);
        }
    }

    //Add label and checkbox
    for(i=1;i<=splitter.length-2;i++)
    {
        elem = document.createElement("div");
        elem.id = "divup" + i;
        elem1 = document.createElement("label"); 
        elem1.textContent  = splitter[i];
        elem1.id = "label" + i;
        elem2 = document.createElement("input");
        elem2.id = "checkbox" + i;
        elem2.name = "checkbox" + i;
        elem2.type = "checkbox";
        
        elem.appendChild(elem1);
        elem.appendChild(elem2);
      
        root.appendChild(elem);
    }
    
    //Add event to checkbox
    var listener = document.getElementById("placeholderwhere").addEventListener("click", function(e) {
        if(e.target && e.target.nodeName == "INPUT") 
        {
            if (e.target.checked)
            {  
                labelname  = "label" + e.target.id.replace("checkbox","");
                label1 = document.getElementById(labelname);

                if(label1.textContent.indexOf('=')===-1)
                {
                    label1.textContent = label1.textContent + " = ";
                }
                elem3 = document.createElement("input");
                elem3.id = "textbox" + e.target.id.replace("checkbox","");
                elem3.type = "text";
                elem3.name = "textbox" + e.target.id.replace("checkbox","");
                elem3.style.width = "150px";            

                elem4 = document.createElement("input");
                elem4.id = "button" + e.target.id.replace("checkbox","");
                elem4.type = "button";
                elem4.style.marginLeft = "10px";
                elem4.name = "button" + e.target.id.replace("checkbox","");
                elem4.value = "Add Value";
                elem4.onclick = function (e) {  
                    var number = e.target.id.replace("button","");
                    $('.hideupdatewhere').css("display", "block");
                    var doc2 = document.getElementById(elem3.id);
                    if (isNaN(doc2.Value))
                    {
                        $('#sqlquery').val("UPDATE " + $('#table').val() + " SET " + label1.textContent+ " '" + doc2.value +"'");
                    }
                    else
                    {
                        $('#sqlquery').val("UPDATE " + $('#table').val() + " SET " + label1.textContent+ " " + doc2.value);
                    }
                    $.get("func4.php", {
                        func: "show_column",
                        drop_var: $('#table').val()
                    },  function(response){
                        setTimeout("finishAjax('placeholderupdatewhere', '" + escape(response) + "')", 400); });
                };
                divname = "divup" + e.target.id.replace("checkbox","");
                var second = document.getElementById(divname);
                second.appendChild(elem3);
                second.appendChild(elem4);
            }
            else
            {
                if (e.target.id.indexOf("textbox")==-1 && e.target.id.indexOf("button")==-1 )
                {   
                    divname = "divup" + e.target.id.replace("checkbox","");
                    var second = document.getElementById(divname);
                    var name1 = "textbox" + e.target.id.replace("checkbox","");
                    var third = document.getElementById(name1);
                    var name2 = "button" + e.target.id.replace("checkbox","");
                    var fourth = document.getElementById(name2);
                    second.removeChild(third);
                    second.removeChild(fourth);
                }
            }
        }
    });
    $('#'+id).html(root);
}

function showTable()
{
    $('.hidetable').css("display", "block");
    $('#sqlquery').val($('#command').val());
}

function showcolumn()
{
    colval = $('#column').val();

    if (colval == "NONE" || typeof colval == undefined) {
        colval = "*";
    }
    $('#sqlquery').val($('#command').val() + " " + colval + " FROM " + $('#table').val());
    $('.hidewhere').css("display", "block");
}

function showupdate()
{
    whereheader = document.getElementById("whereheader");
    whereheader.innerHTML = "SET:";
    labelname  = "label" + i;
    textboxname = "textbox" + i;
    elem1 = document.getElementById(labelname);
    doc2 = document.getElementById(textboxname);
    $('.hideoperator').css("display", "block");
    if (isNaN(doc2.Value))
    {
        $('#sqlquery').val("UPDATE " + $('#table').val() + " SET " + elem1.textContent+ " = '" + doc2.value +"' WHERE " + $('#update').val() );
    }
    else
    {
        $('#sqlquery').val("UPDATE " + $('#table').val() + " SET " + elem1.textContent+ " = " + doc2.value +  " WHERE " +  $('#update').val());
    }
}

function showwhere()
{
    colval = $('#column').val();

    if (colval == "NONE" || typeof colval == undefined) {
        colval = "*";
    }
    $('#sqlquery').val($('#command').val() + " " + colval + " FROM " + $('#table').val() + " WHERE ");
    $('.hideoperator').css("display", "block");
}
function showOperator()
{
    $('#sqlquery').val($('#command').val() + " " + $('#column').val() + " FROM " + $('#table').val() + " WHERE " + $('#where').val());
    $('.hideoperator').css("display", "block");
}
function showValue()
{
    if($('#command').val()!="UPDATE")
    {
        $('#sqlquery').val($('#command').val() + " " + $('#column').val() + " FROM " + $('#table').val() + " WHERE " + $('#where').val() + " " + $('#operator').val());
    }
    $('.wherevalue').css("display", "block");
    $('.wherevalue').focus();
}

function completeValue()
{
    if($('#command').val()!="UPDATE")
    {
        finalval = "";
        if (isNaN($('#wherevalue').val()))
        {
            finalval = "'" + $('#wherevalue').val() + "'";
        }
        else
        {
            finalval = +$('#wherevalue').val();
        }
        $('#sqlquery').val($('#command').val() + " " + $('#column').val() + " FROM " + $('#table').val() + " WHERE " + $('#where').val() + " " + $('#operator').val() + " " + finalval);
        $('.wherevalue').css("display", "block");
    }
    else
    {
        var sofar = $('#sqlquery').val();
        $('#sqlquery').val(sofar + " WHERE " + $('#update').val() + " " + $('#operator').val() + " " +  $('#wherevalue').val());
    }
}

function showRest()
{
    colval = $('#column').val();
    if (colval == "NONE" ||  colval == undefined) {
        colval = "*";
    }
 
    switch($('#command').val())
    {
        case "SELECT":
            $('#sqlquery').val($('#command').val() + " " + colval + " FROM " + $('#table').val());
            $('.hidecolumn').css("display", "none");
            $('.hidewhere').css("display", "block");
            $('.hideoperator').css("display", "none");
            $.get("func2.php", {
                func: "show_column",
                drop_var: $('#table').val()
            }, function (response) {
                setTimeout("finishAjax('placeholdercolumn', '" + escape(response) + "')", 400);
                setTimeout("finishAjax('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);
            });
            break;
        case "INSERT":
            $('#sqlquery').val($('#command').val() + " INTO " + $('#table').val() + " () VALUES ");
            $('.hidecolumn').css("display", "none");
            $('#whereheader').val("COLUMN:");
            $('.hidewhere').css("display", "block");
            $('.hideoperator').css("display", "none");
            $.get("func3.php", {
                func: "show_combo",
                drop_var: $('#table').val()
            }, function (response) {
                setTimeout("createElement('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);
            });
            break;
        case "UPDATE":
            $('#sqlquery').val($('#command').val() + " " + $('#table').val() + " SET ");
            $('.hidecolumn').css("display", "none");
            $('#whereheader').val("COLUMN:");
            $('.hidewhere').css("display", "block");
            $('.hideoperator').css("display", "none");
            $.get("func3.php", {
                func: "show_combo",
                drop_var: $('#table').val()
            }, function (response) {
                setTimeout("createUpdate('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);
            });
            break;
            break;
        case "DELETE":
            $('#sqlquery').val($('#command').val() + " " + colval + " FROM " + $('#table').val());
            $('.hidecolumn').css("display", "none");
            $('.hidewhere').css("display", "block");
            $('.hideoperator').css("display", "none");
            $.get("func2.php", {
                func: "show_column",
                drop_var: $('#table').val()
            }, function (response) {
                setTimeout("finishAjax('placeholdercolumn', '" + escape(response) + "')", 400);
                setTimeout("finishAjax('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);
            });
            break;
    }
    return false;
}

function showFrom()
{
    $('#sqlquery').val("SELECT * FROM " + $('#table').val());
    $('.hidetable').css("display", "block");
    if ($('#sqlresult').html().trim()=="" || $('#command').css('display','block'))
    {
        $('#command').css('display','none');
        $('#hiddenpass').val($('#table').val());
        document.tableform.submit();
    }
    $.get("func2.php", {
        func: "show_column",
        drop_var: $('#table').val()
    },  function(response){
        setTimeout("finishAjax('placeholdercolumn', '" + escape(response) + "')", 400);
        setTimeout("finishAjax('placeholderwhere', '" + response.replace(/column/g, 'where') + "')", 400);
       
    });
    return false;
}

function finishAjax(id, response) {
    whereheader = document.getElementById("whereheader");
    whereheader.innerHTML = "WHERE:";
    $('#'+id).html(unescape(response));
    $('#'+id).fadeIn();
}

