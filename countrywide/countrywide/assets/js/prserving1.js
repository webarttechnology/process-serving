$(document).ready(function(){//enable or disable inpfields in case info

    var usrname=$(".clname").val();
    var usradr=$(".claddress").val();
    var usrcitystzip=$(".clzip").val();
    var usrphone=$(".clphone").val();
    //  ordrinfo====
    var prtyids=[];
    //  ordrinfo====
    // prty =====
    var ledclntflag=0;
    var leadclientcodeid=0;
    var oldcodeid=0;
    var prtyno=0;
    var editprtyrowid="";
    // prty =====
    // doc ======
    var docid=0;
    // doc ======
    var atmdata=[];

    var userid=$("#userid").val();// get/load saved draft if present
    $.ajax({
        dataType:"json",
        type	:"POST",
        url		:'https://countrywideprocess.com/webservice/getcasedraft.php',
        data	:{userid:userid,sectn:"ci"},
        success:function(data)
        {
            // console.log(data);
            if(data!=0)
            {
                swal({
                    text: "Do you want to resume where you left off?",
                    buttons: true,
                    // dangerMode: true,
                })
                .then((getdraft) => {
                    if (getdraft)
                    {
                        // =====caseinfo start========
                        if(data.caseno==0)// if new case/ not applicable
                        {
                            $(".caseno").val("Not Applicable");
                            $('.newcasechkbx').prop('checked', true);
                            $('.newcasechkbx').trigger('change');
                            $('#srchcourt').val(data.court);
                            $('#srchcourt').attr('data-courtid',data.court_id);
                            $('#slctattrny option:contains("'+data.reqatrname+'")').prop('selected', true);
                            $('#slctattrny').trigger('change');
                        }
                        //  ======caseinfo end=======
                        //  ======orderinfo start=======
                        if(data.srvnum!=0)
                        {
                            // console.log(data.srvnum);
                            $('.parties option[value="'+data.srvnum+'"]').prop('selected', true);
                            $('.parties').trigger('change');
                            if(data.srvnum==1)// only one serve
                            {
                                $('#ordprtyname0').val(data.srvname);
                                $('#ordprtycap0 option:contains("'+data.srvcap+'")').prop('selected', true);
                                $('#ordregagntname0').val(data.srvregagent);
                                $('#srchaddr').val(data.address);
                                $('#srchaddr').attr("data-adrid",data.addr_id);
                                $('#srvbusname').val(data.busname);
                                $('#srvtzone option:contains("'+data.timezone+'")').prop('selected', true);
                                $('#srvdate').val(data.heardate);
                                $("#witnsfee"+data.witnsfee).prop("checked", true);
                                if(data.proof!=null)
                                {
                                    $("#prf"+data.proof).prop("checked", true);
                                }
                                $('#spinstr').val(data.spinstrctn);
                            }
                            else{// multiple serve
                                $.ajax({
                                    dataType:"json",
                                    type	:"POST",
                                    url		:'https://countrywideprocess.com/webservice/getcasedraft.php',
                                    data	:{userid:userid,sectn:"oi"},
                                    success:function(dataoi)
                                    {
                                        // console.log(dataoi);
                                        prtyids=[];
                                        for(var i=0;i<dataoi[0].srvnum;i++)
                                        {
                                            prtyids[i]=dataoi.srvid;
                                            // console.log(dataoi[i].srvname);
                                            $('#ordprtyname'+(i+1)).val(dataoi[i].srvname);
                                            $('#ordprtycap'+(i+1)+' option:contains("'+dataoi[i].srvcap+'")').prop('selected', true);
                                            $('#ordregagntname'+(i+1)).val(dataoi[i].srvregagent);
                                        }
                                        if(dataoi[0].samedocs==1)
                                        {
                                            $('#samedocchk').prop('checked', true);
                                        }
                                        if(dataoi[0].sameaddr==1)
                                        {
                                            $('#sameaddrchk').prop('checked', true);
                                        }
                                        if(dataoi[0].allwtnsfee==1)
                                        {
                                            $('#allwitnsfeechk').prop('checked', true);
                                        }
                                    }
                                });
                            }
                            $(".steps li").eq($("#caseinfonext").parents(".form-container").index() + 1).addClass("active");
                            $("#caseinfonext").parents(".form-container").removeClass("active").next().addClass("active flipInX");
                        }
                        //  ======orderinfo end=======
                        //  ======casepart start=======
                        $.ajax({
                            dataType:"json",
                            type	:"POST",
                            url		:'https://countrywideprocess.com/webservice/getcasedraft.php',
                            data	:{userid:userid,sectn:"cp"},
                            success:function(datacp)
                            {
                                // console.log(datacp);
                                if(datacp!=null)
                                {
                                    var prtynum=datacp.length;
                                    var putlead="";
                                    var putbillcode="";
                                    prtyno=prtynum;

                                    for(var i=0;i<prtynum;i++)
                                    {
                                        if(datacp[i].prtywho=="per")
                                        {
                                            if(datacp[i].leadclient==1)
                                            {
                                                putlead='checked="checked"';
                                                putbillcode='<input type="text" class="prtycodtxt" id="prtycolcode'+(i+1)+'" value="'+datacp[i].billcode+'"/>';
                                                leadclientcodeid="prtycolcode"+(i+1);
                                            }
                                            else{
                                                putlead="";
                                                putbillcode="";
                                            }
                                            $('#prtytbl').append('<tr id="'+(i+1)+'" ><td class="text-center"><input class="form-check-input rdo'+(i+1)+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+(i+1)+'" class="text-center">'+datacp[i].prtysfx+' '+datacp[i].prtyfname+' '+datacp[i].prtymname+' '+datacp[i].prtylname+'</td><td id="prtyroletd'+(i+1)+'" class="text-center">'+datacp[i].prtyrole+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td></tr>');
                                            $('#prtyinfodiv').append('<div class="prtyrowdiv" id="prtyrowdiv'+(i+1)+'" style="display:none;"><input type="text" id="prtycolwho'+(i+1)+'" value="per"/><input type="text" id="prtycolrole'+(i+1)+'" value="'+datacp[i].prtyrole+'"/><input type="text" id="prtycolsfx'+(i+1)+'" value="'+datacp[i].prtysfx+'"/><input type="text" id="prtycolfname'+(i+1)+'" value="'+datacp[i].prtyfname+'"/><input type="text" id="prtycolmname'+(i+1)+'" value="'+datacp[i].prtymname+'"/><input type="text" id="prtycollname'+(i+1)+'" value="'+datacp[i].prtylname+'"/>'+putbillcode+'</div>');
                                        }
                                        else if(datacp[i].prtywho=="org")
                                        {
                                            if(datacp[i].leadclient==1)
                                            {
                                                putlead='checked="checked"';
                                                putbillcode='<input type="text" class="prtycodtxt" id="prtycolcode'+(i+1)+'" value="'+datacp[i].billcode+'"/>';
                                                leadclientcodeid="prtycolcode"+(i+1);
                                            }
                                            else{
                                                putlead="";
                                                putbillcode="";
                                            }
                                            $('#prtytbl').append('<tr id="'+(i+1)+'"><td class="text-center"><input class="form-check-input rdo'+(i+1)+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+(i+1)+'" class="text-center">'+datacp[i].prtysfx+' '+datacp[i].prtyfname+' '+datacp[i].prtymname+' '+datacp[i].prtylname+'</td><td id="prtyroletd'+(i+1)+'" class="text-center">'+datacp[i].prtyrole+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td></tr>');
                                            $('#prtyinfodiv').append('<div class="prtyrowdiv" id="prtyrowdiv'+(i+1)+'" style="display:none;"><input type="text" id="prtycolwho'+(i+1)+'" value="org"/><input type="text" id="prtycolrole'+(i+1)+'" value="'+datacp[i].prtyrole+'"/><input type="text" id="prtycolfname'+(i+1)+'" value="'+datacp[i].prtyfname+'"/>'+putbillcode+'</div>');
                                        }
                                        else if(datacp[i].prtywho=="serv")
                                        {
                                            if(datacp[i].leadclient==1)
                                            {
                                                putlead='checked="checked"';
                                                putbillcode='<input type="text" class="prtycodtxt" id="prtycolcode'+(i+1)+'" value="'+datacp[i].billcode+'"/>';
                                                leadclientcodeid="prtycolcode"+(i+1);
                                            }
                                            else{
                                                putlead="";
                                                putbillcode="";
                                            }
                                            $('#prtytbl').append('<tr id="'+(i+1)+'"><td class="text-center"><input class="form-check-input rdo'+(i+1)+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+(i+1)+'" class="text-center">'+datacp[i].prtysfx+' '+datacp[i].prtyfname+' '+datacp[i].prtymname+' '+datacp[i].prtylname+'</td><td id="prtyroletd'+(i+1)+'" class="text-center">'+datacp[i].prtyrole+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td></tr>');
                                            $('#prtyinfodiv').append('<div class="prtyrowdiv" id="prtyrowdiv'+(i+1)+'" style="display:none;"><input type="text" id="prtycolwho'+(i+1)+'" value="serv"/><input type="text" id="prtycolrole'+(i+1)+'" value="'+datacp[i].prtyrole+'"/><input type="text" id="prtycolfname'+(i+1)+'" value="'+datacp[i].prtyfname+'"/>'+putbillcode+'</div>');
                                        }
                                        orderinfochanges();
                                    }
                                    $(".steps li").eq($("#odrinfonext").parents(".form-container").index() + 1).addClass("active");
                                    $("#odrinfonext").parents(".form-container").removeClass("active").next().addClass("active flipInX");
                                }
                            }
                        });
                        //  ======casepart end=======
                    }
                    // else {
                    //   swal("Your imaginary file is safe!");
                    // }
                });
            }
        }
    });

    // ====================================================case info start========================================================

    $("#atrreqnametbl").hide();
    $("#editprtybtn").hide();// hide edit party btn

    $('.caseno').keyup(function(e){// search for a case by caseno

        var caseno=$(this).val();
        if(caseno.length>3)
        {
            $('#caseresult').show();

            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'searchcase.php',
                data	:{caseno:caseno},		
                success:function(data)
                {
                    $("#caserestbody").empty();

                    parser = new DOMParser();
                    xmlDoc = parser.parseFromString(data,"text/xml");
                    var totlcases=xmlDoc.getElementsByTagName("Case").length;
                    for(var i=0;i<totlcases;i++)
                    {
                        if(xmlDoc.getElementsByTagName("CourtCaseNo")[i].childNodes[0])
                        var CourtCaseNo=xmlDoc.getElementsByTagName("CourtCaseNo")[i].childNodes[0].nodeValue;
                        else
                        var CourtCaseNo="";
                        if(xmlDoc.getElementsByTagName("Defendant")[i].childNodes[0])
                        var Defendant=xmlDoc.getElementsByTagName("Defendant")[i].childNodes[0].nodeValue;
                        else
                        var Defendant="";
                        if(xmlDoc.getElementsByTagName("DefendantRole")[i].childNodes[0])
                        var DefendantRole=xmlDoc.getElementsByTagName("DefendantRole")[i].childNodes[0].nodeValue;
                        else
                        var Defendant="";
                        if(xmlDoc.getElementsByTagName("Plaintiff")[i].childNodes[0])
                        var Plaintiff=xmlDoc.getElementsByTagName("Plaintiff")[i].childNodes[0].nodeValue;
                        else
                        var Plaintiff="";
                        if(xmlDoc.getElementsByTagName("Court")[i].childNodes[0])
                        var Court=xmlDoc.getElementsByTagName("Court")[i].childNodes[0].nodeValue;
                        else
                        var Court="";
                        $('#caserestbody').append('<tr><th class="getcase" id="case'+i+'" scope="row">'+CourtCaseNo+'</th><td id="def'+i+'" style="color:black;">'+Defendant+'<input type="text" id="defrol'+i+'" value="'+DefendantRole+'" hidden /></td><td id="plain'+i+'" style="color:black;">'+Plaintiff+'</td><td id="court'+i+'" style="color:black;">'+Court+'</td></tr>');
                    }

                }
            });
        }
        else{
            $('#caseresult').hide();
        }
    });

    $('.editdet').on('change', function(e){// edit or disable attorney details fields
        if(e.target.checked){
            $('.clfrmname').prop('disabled', false);
            $('.clfrmname').css('border', '1px solid black');
            $('.clname').prop('disabled', false);
            $('.clname').css('border', '1px solid black');
            $('.claddress').prop('disabled', false);
            $('.claddress').css('border', '1px solid black');
            $('.clzip').prop('disabled', false);
            $('.clzip').css('border', '1px solid black');
            $('.clphone').prop('disabled', false);
            $('.clphone').css('border', '1px solid black');
        }
        else{
            $('.clfrmname').prop('disabled', true);
            $('.clfrmname').css('border', 'none');
            $('.clname').prop('disabled', true);
            $('.clname').css('border', 'none');
            $('.claddress').prop('disabled', true);
            $('.claddress').css('border', 'none');
            $('.clzip').prop('disabled', true);
            $('.clzip').css('border', 'none');
            $('.clphone').prop('disabled', true);
            $('.clphone').css('border', 'none');
        }
    });

     $('.newcasechkbx').on('change', function(e){//to add new case
        if(e.target.checked){
            $('.newcasediv').show();// shows the div to add new case
            $('#definpdiv').hide();
            $('#defrolinpdiv').hide();
            $('#plaininpdiv').hide();
            $('#srchcourt').val("");// clear values of existing case fields after hiding
            $('#definp').val("");
            $('#defrolinp').val("");
            $('#plaininp').val("");
            $('.caseno').val("Not Applicable");
            $("#caseresult").hide();
        }
        else{
            $('.caseno').val("");
            $('.newcasediv').hide();
        }
     });

    $(document).on('click', '.getcase', function(){// get values from selected courtcaseno row and insert in fields

        // e.preventDefault();
        var elementid = $(this).attr('id');
        var index=elementid.split("e");
        var caseno= $(this).text();
        var def=$('#def'+index[1]).text();
        var defrol=$('#defrol'+index[1]).val();
        var plain=$('#plain'+index[1]).text();
        var court=$('#court'+index[1]).text();

        $('.newcasediv').show();
        $('#definpdiv').show();
        $('#defrolinpdiv').show();
        $('#plaininpdiv').show();
        $('.caseno').val(caseno);
        $('#srchcourt').val(court);
        $('#definp').val(def);
        $('#defrolinp').val(defrol);
        $('#plaininp').val(plain);
        $('.newcasechkbx').prop('checked', false);
        // $(".newcasechkbx").trigger("change");
    });

    $('#srchcourt').keyup(function(e){// search for courts

        var court=$(this).val();
        // console.log(court);
        if(court!="")
        {
            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'searchcourt.php',
                data	:{court:court},		
                success:function(data)
                {
                    // console.log(data);
                    $("#myUL").show();
                    $("#myUL").html(data);
                }
            });
        }
        else{
            $("#myUL").empty();
            $("#myUL").hide();
        }
    });

    $(document).on('click', '.courtlst', function(e){// get values from court search res
        e.preventDefault();
        var court=$(this).text();
        var cid=$(this).attr("data-courtid");

        $("#srchcourt").val(court);
        $("#srchcourt").attr("data-courtid",cid);
        $("#myUL").hide();
        $("#myUL").empty();
    });

    $('#slctattrny').on('change', function(e){//select(tag) attorney dropdown

        var slctattrny=$(this).val();
        var memb=slctattrny.split("/");

        if(slctattrny=="new")
        {
            $('#addattrny').modal('show'); // open add new attrny modal
        }
        else if(memb[1]=="at")// get address of selected attorney/requestor and insert it in the editable field
        {
            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'getreqatrmemb.php',
                data	:{memb:memb[1],id:memb[0]},		
                success:function(data)
                {
                    // console.log(data);
                    parser = new DOMParser();
                    xmlDoc = parser.parseFromString(data,"text/xml");
                    var id=xmlDoc.getElementsByTagName("AttorneyID")[0].childNodes[0].nodeValue;
                    var name=xmlDoc.getElementsByTagName("Attorney")[1].childNodes[0].nodeValue;
                    $("#atrreqnametbl").show();//show hidden table row clnt name if not the same logined user
                    $('.clname').val(name);
                    if(xmlDoc.getElementsByTagName("address")[0].childNodes[0])
                    {
                        var address=xmlDoc.getElementsByTagName("address")[0].childNodes[0].nodeValue;
                        $('.claddress').val(address);
                    }
                    else{
                        $('.claddress').val("not available");
                    }
                    if(xmlDoc.getElementsByTagName("city")[0].childNodes[0])
                        var city=xmlDoc.getElementsByTagName("city")[0].childNodes[0].nodeValue;
                    if(xmlDoc.getElementsByTagName("state")[0].childNodes[0])
                        var state=xmlDoc.getElementsByTagName("state")[0].childNodes[0].nodeValue;
                    if(xmlDoc.getElementsByTagName("zip")[0].childNodes[0])
                    {
                        var zip=xmlDoc.getElementsByTagName("zip")[0].childNodes[0].nodeValue;
                        $('.clzip').val(city+", "+state+", "+zip);
                    }
                    else{
                        $('.clzip').val("not available");
                    }
                    if(xmlDoc.getElementsByTagName("phone")[0].childNodes[0])
                    {
                        var phone=xmlDoc.getElementsByTagName("phone")[0].childNodes[0].nodeValue;
                        $('.clphone').val(phone);
                    }
                    else{
                        $('.clphone').val("not available");
                    }
                }
            });
        }
        else if(memb[1]=="same")
        {
            $("#atrreqnametbl").hide();//hide table row clnt name if the same logined user
            $(".clname").val(usrname);
            $(".claddress").val(usradr);
            $(".clzip").val(usrcitystzip);
            $(".clphone").val(usrphone);
        }
        else if(memb[1]=="req")
        {
            // ====================================================================================
            $("#atrreqnametbl").show();//show hidden table row clnt name if not the same logined user
            var membname=$("#slctattrny option:selected").text();
            $(".clname").val(membname);
            $(".claddress").val(usradr);
            $(".clzip").val(usrcitystzip);
            $(".clphone").val(usrphone);
        }
    });

    //hide attorney and requestor input fields on page load. only view on checkbox val change.
    $('#addmembbtn').hide();
    $('#attorneydiv').hide();
    $('#requestordiv').hide();

    $('#slctreqatr').on('change', function(e){//select(tag) view add new attr or req fields

        var select=$(this).val();

        if(select=="atr")
        {
            $('#addmembbtn').show();
            $('#attorneydiv').show();
            $('#requestordiv').hide();
        }
        else if(select=="req")
        {
            $('#addmembbtn').show();
            $('#attorneydiv').hide();
            $('#requestordiv').show();
        }
        else{
            $('#addmembbtn').hide();
            $('#attorneydiv').hide();
            $('#requestordiv').hide();
        }
    });

    $('#addmembbtn').on('click', function(e){//to add new attorney

        var newmemb=$("#slctreqatr").val();// to identify adding attorney or requestor on php file.
        var atrname=$("#attrnyname").val();
        var atrbarid=$("#attrnybarid").val();
        var atremail=$("#attrnyemail").val();
        var atraddress=$("#attrnyaddress").val();
        var atrcity=$("#attrnycity").val();
        var atrstate=$("#attrnystate").val();
        var atrzip=$("#attrnyzip").val();
        var atrphone=$("#attrnyphone").val();
        var reqname=$("#reqname").val();
        var reqemail=$("#reqemail").val();
        // var baridtype=/^\d+$/.test(atrbarid)// uncomment if attorney barid should be only numeric/digits
        if((newmemb=="atr" && atrname!="" && atrbarid!="") || (newmemb=="req" && reqname!="" && reqemail!=""))
        {
            // if(baridtype=="true")// uncomment if attorney barid should be only numeric/digits
            // {
                $("#addatrnyerr").html("");
                $.ajax({
                    dataType:"json",
                    type	:"POST",
                    url		:'addreqatrmemb.php',
                    data	:{atrname:atrname,atrbarid:atrbarid,atremail:atremail,atraddress:atraddress,atrcity:atrcity,atrstate:atrstate,atrzip:atrzip,atrphone:atrphone,
                            reqname:reqname,reqemail:reqemail,
                            newmemb:newmemb},		
                    success:function(data)
                    {
                        $('#addattrny').modal('toggle');
                        listallreqatr();
                    }
                });
            // }
            // else{
            //     $("#addatrnyerr").html("Attorney barid should be numeric*");
            // }
        }
        else{
            $("#addatrnyerr").html("All fields are mandatory*");
        }
    });

    function listallreqatr()
    {
        $.ajax({
            dataType:"json",
            type	:"POST",
            url		:'getreqatrmemb.php',
            data	:{getall:"all",id:"",memb:""},		
            success:function(data)
            {
                $("#slctattrny").html(data);
            }
        });
    }

    $('#caseinfonext').on('click', function(e){// on case info next btn
        // alert("ok");
        // var sectn="caseinfo";
        var caseerr=0;
        var caseno=$(".caseno").val();
        var courtid=$("#srchcourt").attr("data-courtid");
        var court=$("#srchcourt").val();
        var atrid=$("#slctattrny").val();
        var firmname=$(".clfrmname").val();
        var clname=$(".clname").val();
        var claddress=$(".claddress").val();
        var clzip=$(".clzip").val();
        var clphone=$(".clphone").val();
        // console.log(caseno);
        // console.log(courtid);
        // console.log(court);
        // console.log(atrid);
        if($(".newcasechkbx").prop('checked') == false){
            if(caseno=="")
            {
                swal("Please enter a Case number.");
                caseerr=1;
                return false;
            }
        }
        else{
            if(courtid=="" || court=="")
            {
                swal("Please select a court.");
                caseerr=1;
                return false;
            }
            if(atrid=="")
            {
                swal("Please select an attorney.");
                caseerr=1;
                return false;
            }
            if(firmname=="")
            {
                swal("Please enter Firm Name.");
                caseerr=1;
                return false;
            }
            if(clname=="")
            {
                swal("Please enter Name.");
                caseerr=1;
                return false;
            }
            if(claddress=="")
            {
                swal("Please enter Address.");
                caseerr=1;
                return false;
            }
            if(clzip=="")
            {
                swal("Please enter State,city,zip.");
                caseerr=1;
                return false;
            }
            if(clphone=="")
            {
                swal("Please enter Phone.");
                caseerr=1;
                return false;
            }
        }
        if(caseerr==0)// case info save as draft===========
        {
            var sectn="caseinfo";
            // var userid=$("#userid").val();
            var caseno=$(".caseno").val();
            var court=$("#srchcourt").val();
            var courtid=$("#srchcourt").attr("data-courtid");
            var atrnyid=$("#slctattrny").val();
            var atrny=$("#slctattrny option:selected").text();
            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'https://countrywideprocess.com/webservice/savecasedraft.php',
                data	:{sectn:sectn,userid:userid,caseno:caseno,courtid:courtid,court:court,atrnyid:atrnyid,atrny:atrny},
                success:function(data)
                {
                    // $("#slctattrny").html(data);
                    // console.log(data);
                }
            });
        }
    });
    // ====================================================case info end========================================================
    // ====================================================order info start========================================================

    $('.parties').on('change', function(e)// add rows for parties
    {
        var parties=$(this).val();
        if(parties==0)
        {
            $("#partybody").empty();
            $("#orderdetdiv").hide();
            $("#forallpartiesdiv").hide();
        }
        else if(parties==1)
        {
            $("#partybody").empty();
            $('#tblparties').append('<tr><td><input type="text" id="ordprtyname0" class="form-control" style="width:100%"/></td><td><select id="ordprtycap0" class="form-select ordprtycap"><option value="">Select...</option> <option value="Association or Partnership">Association or Partnership</option><option value="Authorized Person">Authorized Person</option><option value="Business Organization, Form Unknown">Business Organization, Form Unknown</option><option value="Corporation">Corporation</option><option value="Defunct Corporation">Defunct Corporation</option><option value="Estate">Estate</option><option value="Fictitious">Fictitious</option><option value="Individual">Individual</option><option value="Joint Stock Company/Association">Joint Stock Company/Association</option><option value="Field">Field</option><option value="Minor">Minor</option><option value="Occupant Prejudgment Claim">Occupant Prejudgment Claim</option><option value="Public Entity">Public Entity</option><option value="Sole Proprietorship">Sole Proprietorship</option><option value="Trust">Trust</option></select></td><td><input type="text" id="ordregagntname0" class="form-control" placeholder=""/></td></tr>');
            $("#orderdetdiv").show();
            $("#forallpartiesdiv").hide();
        }
        else{
            $("#partybody").empty();
            for(var i=0;i<parties;i++)
            {
                $('#tblparties').append('<tr><td><input type="text" id="ordprtyname'+(i+1)+'" class="form-control" style="width:100%"/></td><td><select id="ordprtycap'+(i+1)+'" class="form-select ordprtycap"><option value="">Select...</option> <option value="Association or Partnership">Association or Partnership</option><option value="Authorized Person">Authorized Person</option><option value="Business Organization, Form Unknown">Business Organization, Form Unknown</option><option value="Corporation">Corporation</option><option value="Defunct Corporation">Defunct Corporation</option><option value="Estate">Estate</option><option value="Fictitious">Fictitious</option><option value="Individual">Individual</option><option value="Joint Stock Company/Association">Joint Stock Company/Association</option><option value="Field">Field</option><option value="Minor">Minor</option><option value="Occupant Prejudgment Claim">Occupant Prejudgment Claim</option><option value="Public Entity">Public Entity</option><option value="Sole Proprietorship">Sole Proprietorship</option><option value="Trust">Trust</option></select></td><td><input type="text" id="ordregagntname'+(i+1)+'" class="form-control" placeholder=""/></td></tr>');
            }
            $("#orderdetdiv").hide();
            $("#forallpartiesdiv").show();
        }
    });

    $(document).on('change', '.ordprtycap', function(e)// capacity change event on registered agent
    {
        // alert("ko");
        var thisval=$(this).val();
        var thisid=$(this).attr("id");
        thisid=thisid.split("p");
        var doc_id=thisid[2];
        if(thisval=="Association or Partnership")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","Mandatory**");
            $("#ordregagntname"+doc_id).val("");
        }
        else if(thisval=="Corporation")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","Mandatory**");
            $("#ordregagntname"+doc_id).val("");
        }
        else if(thisval=="Defunct Corporation")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","Mandatory**");
            $("#ordregagntname"+doc_id).val("");
        }
        else if(thisval=="Estate")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","Mandatory**");
            $("#ordregagntname"+doc_id).val("");
        }
        else if(thisval=="Joint Stock Company/Association")// ~~
        {
            $("#ordregagntname"+doc_id).attr("placeholder","Mandatory**");
            $("#ordregagntname"+doc_id).val("Trustee of the corporation and of its stockholders");
        }
        else if(thisval=="Minor")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","Mandatory**");
            $("#ordregagntname"+doc_id).val("");
        }
        else if(thisval=="Occupant Prejudgment Claim")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","");
            $("#ordregagntname"+doc_id).val(" On behalf of: ALL OTHER UNNAMED OCCUPANTS");
        }
        else if(thisval=="Public Entity")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","");
            $("#ordregagntname"+doc_id).val("Person Authorized to Accept Service of Process");
        }
        else if(thisval=="Sole Proprietorship")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","");
            $("#ordregagntname"+doc_id).val("Person Authorized to Accept Service of Process");
        }
        else if(thisval=="Trust")
        {
            $("#ordregagntname"+doc_id).attr("placeholder","");
            $("#ordregagntname"+doc_id).val("Person Authorized to Accept Service of Process");
        }
        else{
            $("#ordregagntname"+doc_id).attr("placeholder","");
            $("#ordregagntname"+doc_id).val("");
        }
    });

    $('#srchaddr').keyup(function(e){// search for address - single

        var adr=$(this).val();
        // console.log(adr);
        if(adr!="")
        {
            var type="single";
            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'searchaddress.php',
                data	:{adr:adr,type:type},		
                success:function(data)
                {
                    // console.log(data);
                    if(data!="")
                    {
                        $("#srchadrli").show();
                        $("#srchadrli").html(data);
                    }
                }
            });
        }
        else{
            $("#srchadrli").empty();
            $("#srchadrli").hide();
        }
    });

    $(document).on('click', '.adrlst', function(e){// get values from address search res
        e.preventDefault();
        var address=$(this).text();
        var adrid=$(this).attr("data-adrid");

        $("#srchaddr").val(address);
        $("#srchaddr").attr("data-adrid",adrid);
        $(".srchadrli").hide();
        $(".srchadrli").empty();
    });

    $('#adadrbtn').on('click', function(e){//to add new address
        // console.log("ok");
        var newadr=$("#newadr").val();// to identify adding bussiness or residence address.
        var newadrunit=$("#newadrunit").val();
        var newcity=$("#newcity").val();
        var newstate=$("#newstate").val();
        var newzip=$("#newzip").val();
        // console.log(newadr);
        // console.log(newadrunit);
        // console.log(newcity);
        // console.log(newstate);
        // console.log(newzip);
        if(newadr!="" && newcity!="" && newstate!="" && newzip!="")
        {
            $("#addadrerr").html("");
            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'addnewaddress.php',
                data	:{newadr:newadr,newadrunit:newadrunit,newcity:newcity,newstate:newstate,newzip:newzip},		
                success:function(data)
                {
                    // console.log(data);
                    $('#addadrmodal').modal('toggle');
                    // listallreqatr();
                }
            });
        }
        else{
            $("#addadrerr").html("All fields are mandatory*");
        }
    });

    $('#odrinfonext').on('click', function(e){// check if for-all-parties check boxes are checked - next btn click
        // alert("ok");
        var parties=$(".parties").val();
        var srvname="";
        var srvcap="";
        var srvagnt="";
        var caseerr=0;

        // ===validation==start
        if(parties==0)
        {
            swal("Please select number of Parties to serve.");
            caseerr=1;
            return false;
        }
        else if(parties==1)
        {
            srvname=$("#ordprtyname0").val();
            srvcap=$("#ordprtycap0").val();
            srvagnt=$("#ordregagntname0").val();
            var srvaddr=$("#srchaddr").val();
            var srvbusname=$("#srvbusname").val();
            var srvtzone=$("#srvtzone").val();
            var srvdate=$("#srvdate").val();
            var srvtzone=$("#srvtzone").val();
            if(srvname=="" || srvcap=="" || srvagnt=="" || srvaddr=="" || srvbusname=="" || srvtzone==0 || srvdate=="")
            {
                swal("Fields cannot be empty");
                caseerr=1;
                return false;
            }
        }
        else if(parties>1)
        {
            for(var i=0;i<parties;i++)
            {
                srvname=$("#ordprtyname"+(i+1)).val();
                srvcap=$("#ordprtycap"+(i+1)).val();
                srvagnt=$("#ordregagntname"+(i+1)).val();
                if(srvname=="" || srvcap=="" || srvagnt=="")
                {
                    swal("Fields cannot be empty");
                    caseerr=1;
                    return false;
                }
            }
        }
        // ====validation==end

        orderinfochanges();// changes happen on order info next btn click for docs and adr sections

        if(caseerr==0)// order info save as draft=======
        {
            var sectn="orderinfo";
            // var temp="";
            if(parties>1)
            {
                var srv=[];
                var cap=[];
                var regagent=[];
                for(var i=0;i<parties;i++)
                {
                    srv[i]=$("#ordprtyname"+(i+1)).val();
                    cap[i]=$("#ordprtycap"+(i+1)).val();
                    regagent[i]=$("#ordregagntname"+(i+1)).val();
                }
            }
            else{
                var srv=$("#ordprtyname0").val();
                var cap=$("#ordprtycap0").val();
                var regagent=$("#ordregagntname0").val();
            }
            var userid=$("#userid").val();
            var address=$("#srchaddr").val();
            // console.log(address);
            var adrid=$("#srchaddr").attr("data-adrid");
            // console.log(adrid);
            var busname=$("#srvbusname").val();
            var tzone=$("#srvtzone option:selected").text();
            var hdate=$("#srvdate").val();
            var witnsfee=$('input[name="witnsfee"]:checked').val();
            var proof=$('input[name="Proof"]:checked').val();
            var spinstr=$("#spinstr").val();

            var cmnsrvchk=[];
            for(var i=0;i<3;i++)
            {
                if($(".cmnsrvchk"+i).prop('checked') == true){
                    cmnsrvchk[i]=1;
                    // console.log("1");
                }
                else{
                    cmnsrvchk[i]=0;
                    // console.log("0");
                }
            }

            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'https://countrywideprocess.com/webservice/savecasedraft.php',
                data	:{sectn:sectn,userid:userid,parties:parties,address:address,adrid:adrid,srv:srv,cap:cap,regagent:regagent,busname:busname,tzone:tzone,hdate:hdate,witnsfee:witnsfee,proof:proof,spinstr:spinstr,cmnsrvchk:cmnsrvchk},
                success:function(data)
                {
                    // $("#slctattrny").html(data);
                    // console.log(data);
                    for(var i=0;i<data.length;i++)
                    {
                        prtyids[i]=data[i];
                    }
                    // console.log(prtyids);
                }
            });
        }
    });

    function orderinfochanges()
    {
        var parties=$(".parties").val();

        // ====changes for documents - same doc chkbox====
        if(parties<=1 || (parties>1 && $("#samedocchk").prop('checked') == true))// single/no party/mult party without same docs
        {
            // alert("konakona");
            $("#1prtydocdiv").show();
            $("#multprtydocdiv").hide();
        }
        else if(parties>1 && $("#samedocchk").prop('checked') == false)// mult party with same docs
        {
            $("#multprtydocdiv").empty();
            for(i=0;i<parties;i++)
            {
                var prty=$("#ordprtyname"+(i+1)).val();
                var prtycap=$("#ordprtycap"+(i+1)+" :selected").text();
                $("#multprtydocdiv").append('<div id="docdiv_'+(i+1)+'">'+
                                                '<button class="collapsible" type="button" style="margin-bottom:10px;">Documents for '+prty+' - '+prtycap+
                                                    '<span class="docalert" id="docalert_'+(i+1)+'" style="color:orange;float:right;">(Documents required)</span>'+
                                                '</button>'+
                                                '<div class="content" style="margin-bottom:10px;">'+
                                                    '<div class="row">'+
                                                        '<div class="col-md-12 mb-3">'+
                                                            '<div class="docu-line"></div>'+
                                                        '</div>'+
                                                        '<div class="col-md-4 text-end">'+
                                                            '<label>Type the Document Title using:</label>'+
                                                        '</div>'+
                                                        '<div class="col-md-4 text-start">'+
                                                            '<div class="form-check form-check-inline">'+
                                                                '<input class="form-check-input" type="radio" name="fltrdoctype_'+(i+1)+'" id="rdbtnstarts_'+(i+1)+'" value="start" style="appearance: auto;"/>'+
                                                                '<label class="form-check-label" for="rdbtnstarts_'+(i+1)+'">Starts with</label>'+
                                                            '</div>'+
                                                            '<div class="form-check form-check-inline">'+
                                                                '<input class="form-check-input" type="radio" name="fltrdoctype_'+(i+1)+'" id="rdbtncontains_'+(i+1)+'" value="contain" checked="checked" style="appearance: auto;"/>'+
                                                                '<label class="form-check-label" for="rdbtncontains_'+(i+1)+'">Contains </label>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="col-md-4 text-center">'+
                                                            '<a href="#" class="crtdefttl" id="crtdefttl_'+(i+1)+'" data-bs-toggle="modal" data-bs-target="#documentsmodal" data-bs-whatever="@fat">Court defined Document Titles</a>'+
                                                        '</div>'+
                                                        '<div class="col-md-3 text-end pt-2">'+
                                                            '<label for="formFile" class="form-label">Document Title:</label>'+
                                                        '</div>'+
                                                        '<div class="col-md-6">'+
                                                            '<input type="text" class="form-control srchdocttl" id="srchdocttl_'+(i+1)+'" value="" data-ttlid="" style="width:-webkit-fill-available;"/>'+
                                                        '</div>'+
                                                        '<div class="col-md-3">'+
                                                            '<div class="attach file btn btn-lg btn-primary" id="attach_'+(i+1)+'">'+
                                                                'Attach file'+
                                                                '<input type="file" class="attach-fld docupbtn" name="docupbtn_'+(i+1)+'" id="docupbtn_'+(i+1)+'" data-fileid=""/>'+
                                                            '</div>'+
                                                            '<div class="btn btn-lg btn-primary faxacptbtn" id="faxacptbtn_'+(i+1)+'" style="display:none;">'+
                                                                'Accept'+
                                                                '<input type="button" class="attach-fld" name="" id="faxaccbtn_'+(i+1)+'"/>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<ul id="docUL_'+(i+1)+'" class="srchresUL" style="height:271px;overflow:auto;display:none;">'+
                                                        '</ul>'+
                                                        '<table class="table table-borderless primary-blue tbldoctitle" id="tbldoctitle_'+(i+1)+'" style="display:none;">'+
                                                            '<tr>'+
                                                                '<th width="90%" class="">Title</th><th></th>'+
                                                            '</tr>'+
                                                            '<!-- <tr>'+
                                                                '<td class="">docname here</td><td class=""><i id="" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td>'+
                                                            '</tr> -->'+
                                                        '</table>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>');
            }
            $("#1prtydocdiv").hide();
            $("#multprtydocdiv").show();
        }

        // ====changes for serve info - same address chkbox====
        if(parties<=1 || (parties>1 && $("#sameaddrchk").prop('checked') == true))// single/no party/mult party without same address
        {
            // alert("konakona");
            $("#1srvadrdiv").show();
            $("#multsrvadrdiv").hide();

            $("#srchaddr_0").val($("#srchaddr").val());
            $("#busname_0").val($("#srvbusname").val());
            var zonetxt=$("#srvtzone option:selected").text();
            $('#srvtimezn_0 option:contains("'+zonetxt+'")').prop('selected', true);
            $("#hrdate_0").val($("#srvdate").val());
            $("#spcinstr_0").val($("#spinstr").val());
        }
        else if(parties>1 && $("#sameaddrchk").prop('checked') == false)// mult party with same address
        {
            $("#multsrvadrdiv").empty();
            $("#multsrvadrdiv").append("<span id=''>Click on Party Name below to add Serve Info if required</span>");
            for(i=0;i<parties;i++)
            {
                var prty=$("#ordprtyname"+(i+1)).val();
                var prtycap=$("#ordprtycap"+(i+1)+" :selected").text();
                $("#multsrvadrdiv").append('<div id="adrdiv_'+(i+1)+'">'+
                                                '<button class="collapsible" type="button" style="margin-bottom:10px;">'+prty+' - '+prtycap+
                                                    '<span class="adralert" id="adralert_'+(i+1)+'" style="color:orange;float:right;">(Address required)</span>'+
                                                '</button>'+
                                                '<div class="content" style="margin-bottom:10px;">'+
                                                    '<div class="row mb-3">'+
                                                        '<div class="col-md-6 mt-3 position-relative">'+
                                                            '<a href="#" class="vrfy-cd" data-bs-toggle="modal" data-bs-target="#addadrmodal" data-bs-whatever="@mdo" style="padding:3px;color:green;"><i class="fa fa-plus" aria-hidden="true"></i></a>'+
                                                            '<input type="text" class="form-control srchaddr" id="srchaddr_'+(i+1)+'" data-adrid="" placeholder="Address*" style="width:153%;"/>'+
                                                        '</div>'+
                                                        '<ul class="srchadrli multadrsrchli" id="srchadrli_'+(i+1)+'" style="height:271px;overflow:auto;display:none;">'+
                                                        '</ul>'+
                                                    '</div>'+
                                                    '<div class="col-md-6">'+
                                                        '<input type="text" class="form-control" id="busname_'+(i+1)+'" placeholder="Business Name"/>'+
                                                    '</div>'+
                                                    '<div class="row mb-3 mt-4">'+
                                                        '<div class="col-md-6">'+
                                                            '<label>Time Zone</label>'+
                                                            '<select  class="form-select" id="srvtimezn_'+(i+1)+'">'+
                                                                '<option value="0"> Select Time Zone </option>'+
                                                                '<option value="22">Eastern Standard Time</option>'+
                                                                '<option value="16">Central Standard Time</option>'+
                                                                '<option value="13">Mountain Standard Time</option>'+
                                                                '<option value="10">Pacific Standard Time</option>'+
                                                                '<option value="6">Alaskan Standard Time</option>'+
                                                                '<option value="4">Hawaiian Standard Time</option>'+
                                                            '</select>'+
                                                        '</div>'+
                                                        '<div class="col-md-6 mb-3">'+
                                                            '<label>Hearing Date Time</label>'+
                                                            '<input type="date" class="form-control" id="hrdate_'+(i+1)+'" placeholder="Hearing Date"/>'+
                                                        '</div>'+
                                                        '<div class="col-md-6 mb-3">'+
                                                            '<label>Advance Witness Fees :</label>'+
                                                            '<div class="form-check form-check-inline">'+
                                                                '<input class="form-check-input" type="radio" name="witnsfee_'+(i+1)+'" id="yeswitnsfee_'+(i+1)+'" value="yes" style="appearance: auto;"/>'+
                                                                '<label class="form-check-label" for="yeswitnsfee_'+(i+1)+'">Yes</label>'+
                                                            '</div>'+
                                                            '<div class="form-check form-check-inline">'+
                                                                '<input class="form-check-input" type="radio" name="witnsfee_'+(i+1)+'" id="nowitnsfee_'+(i+1)+'" value="no" style="appearance: auto;" checked="checked"/>'+
                                                                '<label class="form-check-label" for="nowitnsfee_'+(i+1)+'">No</label>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="col-md-6 mb-3">'+
                                                            '<label>Proof : </label>'+
                                                            '<div class="form-check form-check-inline">'+
                                                                '<input class="form-check-input" type="radio" name="proofrdo_'+(i+1)+'" id="prffile_'+(i+1)+'" value="file" style="appearance: auto;"/>'+
                                                                '<label class="form-check-label" for="prffile_'+(i+1)+'">File <span style="font-size: 11px; color: #000;">(Additional fee will apply)</span></label>'+
                                                            '</div>'+
                                                            '<div class="form-check form-check-inline">'+
                                                                '<input class="form-check-input" type="radio" name="proofrdo_'+(i+1)+'" id="prfnotrz_'+(i+1)+'" value="notrz" style="appearance: auto;"/>'+
                                                                '<label class="form-check-label" for="prfnotrz_'+(i+1)+'">Notarize <span style="font-size: 11px; color: #000;">(Additional fee will apply)</span></label>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="col-md-12">'+
                                                            '<label class="form-label">Special Instructions</label>'+
                                                            '<textarea class="form-control" id="spcinstr_'+(i+1)+'" rows="3" style="width:83%;color:black;"></textarea>'+
                                                        '</div>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>');
            }
            $("#1srvadrdiv").hide();
            $("#multsrvadrdiv").show();
        }
    }
    // ====================================================order info end========================================================
    // ====================================================case participants start========================================================

    $('input[type=radio][name=whoradio]').change(function() {// select between organization and person in add parties.
        if (this.value == 'per') {
            $('#srvprtydiv').hide();
            $('#prtyfname').show();
            $('#prtymname').show();
            $('#prtylname').show();
            $('#prtysfx').show();
        }
        else if (this.value == 'org') {
            $('#srvprtydiv').hide();
            $('#prtyfname').show();
            $('#prtymname').hide();
            $('#prtylname').hide();
            $('#prtysfx').hide();
        }
        else if(this.value=='serv')
        {
            $('#srvprtydiv').show();
            $('#srvprtyslct').empty();
            $('#prtyfname').hide();
            $('#prtymname').hide();
            $('#prtylname').hide();
            $('#prtysfx').hide();

            var rowCount = $('#tblparties tr').length;
            // console.log(rowCount);
            $('#srvprtyslct').append('<option value="">--select--</option>');
            for(i=1;i<rowCount;i++)
            {
                var serv=$('#ordprtyname'+i).val();
                $('#srvprtyslct').append('<option value="'+i+'">'+serv+'</option>');
            }
        }
        $('#prtyrole').val("");
        $('#prtyfname').val("");
        $('#prtymname').val("");
        $('#prtylname').val("");
        $('#prtysuffx').val("");
    });

    $('input[type=radio][name=prtyledcln]').change(function() {// select between leadclient yes/no in add parties.
        if (this.value == 1) {
            // console.log("1");
            $('#prtybill').show();
        }
        else if (this.value == 0) {
            // console.log("0");
            $('#prtybill').hide();
        }
    });

    $('.add-party').on('click', function(e){// changes happen while opening add party modal =====================

        $("#editprtybtn").hide();// hide edit party btn
        $("#addprty").show();

        $("#prtypers").prop("checked", true);
        $('#srvprtydiv').hide();
        $('#prtyfname').show();
        $('#prtymname').show();
        $('#prtylname').show();
        $('#prtysfx').show();


        if(!$("input[name='leadradio']:checked").val())
        {
            // console.log("no checked");
            $(".leadclntdiv").show();
            $('#leadno').prop('checked', true);
            $('#prtybill').hide();
            ledclntflag=0;
            leadclientcodeid=0;
        }
        else{
            // console.log("checked");
            $(".leadclntdiv").hide();
            $('#prtybill').hide();
            ledclntflag=1;
        }
    });

    $('input[type=radio][name=prtyledcln]').change(function() {//
        if (this.value == 1) {
            // console.log("1");
            $('#prtybill').show();
        }
        else if (this.value == 0) {
            // console.log("0");
            $('#prtybill').hide();
        }
    });

    $('#addprty').on('click', function(e){//==== to add new party
        // console.log("ok");
        var putlead="";// for lead client
        var putbillcode="";// for lead client
        var who=$("input[name='whoradio']:checked").val()
        var prtyrole=$("#prtyrole").val();
        var prtyroletxt=$("#prtyrole :selected").text();
        var prtyfname=$("#prtyfname").val();
        var prtymname=$("#prtymname").val();
        var prtylname=$("#prtylname").val();
        var prtysuffx=$("#prtysuffx :selected").text();
        var leadcntradio=$('input[name="prtyledcln"]:checked').val();
        var prtybillcode=$("#prtybillcode").val();

        if(who=="per")
        {
            if(prtyrole!="" && prtyfname!="" && prtylname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                prtyno=prtyno+1;
                if(leadcntradio==1)
                {
                    ledclntflag=1;
                    putlead='checked="checked"';
                    putbillcode='<input type="text" class="prtycodtxt" id="prtycolcode'+prtyno+'" value="'+prtybillcode+'"/>';
                    leadclientcodeid="prtycolcode"+prtyno;
                }
                else{
                    ledclntflag=0;
                    putlead="";
                    putbillcode="";
                    
                }
                $("#addprtyerr").html("");
                $('#prtytbl').append('<tr id="'+prtyno+'" ><td class="text-center"><input class="form-check-input rdo'+prtyno+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+prtyno+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+prtyno+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td></tr>');
                $('#prtyinfodiv').append('<div class="prtyrowdiv" id="prtyrowdiv'+prtyno+'" style="display:none;"><input type="text" id="prtycolwho'+prtyno+'" value="per"/><input type="text" id="prtycolrole'+prtyno+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolsfx'+prtyno+'" value="'+prtysuffx+'"/><input type="text" id="prtycolfname'+prtyno+'" value="'+prtyfname+'"/><input type="text" id="prtycolmname'+prtyno+'" value="'+prtymname+'"/><input type="text" id="prtycollname'+prtyno+'" value="'+prtylname+'"/>'+putbillcode+'</div>');
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }
        else if(who=="org")
        {
            if(prtyrole!="" && prtyfname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                prtyno=prtyno+1;
                if(leadcntradio==1)
                {
                    ledclntflag=1;
                    putlead='checked="checked"';
                    putbillcode='<input type="text" class="prtycodtxt" id="prtycolcode'+prtyno+'" value="'+prtybillcode+'"/>';
                    leadclientcodeid="prtycolcode"+prtyno;
                }
                else{
                    ledclntflag=0;
                    putlead="";
                    putbillcode="";
                    
                }
                $("#addprtyerr").html("");
                $('#prtytbl').append('<tr id="'+prtyno+'"><td class="text-center"><input class="form-check-input rdo'+prtyno+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+prtyno+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+prtyno+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td></tr>');
                $('#prtyinfodiv').append('<div class="prtyrowdiv" id="prtyrowdiv'+prtyno+'" style="display:none;"><input type="text" id="prtycolwho'+prtyno+'" value="org"/><input type="text" id="prtycolrole'+prtyno+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolfname'+prtyno+'" value="'+prtyfname+'"/>'+putbillcode+'</div>');
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }
        else if(who=="serv")
        {
            prtyfname=$("#srvprtyslct option:selected").text();
            if(prtyrole!="" && prtyfname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                prtyno=prtyno+1;
                if(leadcntradio==1)
                {
                    ledclntflag=1;
                    putlead='checked="checked"';
                    putbillcode='<input type="text" class="prtycodtxt" id="prtycolcode'+prtyno+'" value="'+prtybillcode+'"/>';
                    leadclientcodeid="prtycolcode"+prtyno;
                }
                else{
                    ledclntflag=0;
                    putlead="";
                    putbillcode="";
                    
                }
                $("#addprtyerr").html("");
                $('#prtytbl').append('<tr id="'+prtyno+'"><td class="text-center"><input class="form-check-input rdo'+prtyno+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+prtyno+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+prtyno+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td></tr>');
                $('#prtyinfodiv').append('<div class="prtyrowdiv" id="prtyrowdiv'+prtyno+'" style="display:none;"><input type="text" id="prtycolwho'+prtyno+'" value="serv"/><input type="text" id="prtycolrole'+prtyno+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolfname'+prtyno+'" value="'+prtyfname+'"/>'+putbillcode+'</div>');
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }
    });

    $(document).on('click', '#delprty', function(e){// remove an added party - row deletion
        // console.log("whhaaaat!!!");
        var id=$(this).closest('tr').attr('id');
        // console.log(id);
        if ($(".rdo"+id).prop("checked")) {
            // console.log("checked");
            $(".leadclntdiv").show();
            leadclientcodeid=0;
        }
        $(this).closest('tr').remove();
        $("#prtyrowdiv"+id).remove();
    });

    $(document).on('click', '#editprty', function(e){// edit an added party - show in edit fields
        // console.log("whhaaaat!!!");
        $("#editprtybtn").show();// show edit party btn
        $("#addprty").hide();// hide add party btn

        var getprtywho="";
        var getprtyrole="";
        var getprtysfx="";
        var getprtyfname="";
        var getprtymname="";
        var getprtylname="";
        var getprtycode="";
        var id=$(this).closest('tr').attr('id');
        editprtyrowid=id;
        // console.log(id);
        // if ($(".rdo"+id).prop("checked")) {
        //     // console.log("checked");
        //     // $(".leadclntdiv").show();
        // }
        getprtywho=$("#prtycolwho"+id).val();
        getprtyrole=$("#prtycolrole"+id).val();
        getprtysfx=$("#prtycolsfx"+id).val();
        getprtyfname=$("#prtycolfname"+id).val();
        // console.log(getprtysfx);

        if(!$("input[name='leadradio']:checked").val())
        {
            // console.log("no checked");
            // $(".leadclntdiv").show();
            // $('#leadno').prop('checked', true);
            // $('#prtybill').hide();
            ledclntflag=0;
        }
        else{
            // console.log("checked");
            // $(".leadclntdiv").hide();
            // $('#prtybill').hide();
            ledclntflag=1;
        }

        if(getprtywho=="per")
        {
            getprtymname=$("#prtycolmname"+id).val();
            getprtylname=$("#prtycollname"+id).val();
            $("#prtypers").prop("checked", true);
            $('#prtyfname').show();
            $('#prtymname').show();
            $('#prtylname').show();
            $('#prtysfx').show();
            $('#srvprtydiv').hide();
        }
        else if(getprtywho=="org")
        {
            $("#prtyorg").prop("checked", true);
            $('#prtyfname').show();
            $('#prtymname').hide();
            $('#prtylname').hide();
            $('#prtysfx').hide();
            $('#srvprtydiv').hide();
        }
        else if(getprtywho=="serv")
        {
            $('#srvprtydiv').show();
            $('#prtyfname').hide();
            $("#prtyserv").prop("checked", true);
            $('#prtymname').hide();
            $('#prtylname').hide();
            $('#prtysfx').hide();
            $('#srvprtyslct option:contains("'+getprtyfname+'")')
        }
        // console.log(getprtywho);
        $('#prtyfname').val(getprtyfname);
        $('#prtymname').val(getprtymname);
        $('#prtylname').val(getprtylname);
        $('#prtyrole option:contains('+getprtyrole+')').prop('selected', true);
        $('#prtysuffx option:contains('+getprtysfx+')').prop('selected', true);

        if($(".rdo"+id).prop("checked")) {
            // console.log("checked");
            $(".leadclntdiv").show();
            $('#leadyes').prop('checked', true);
            getprtycode=$("#prtycolcode"+id).val();
            // console.log(getprtycode);
            $("#prtybillcode").val(getprtycode);
        }
        else{
            if(!$("input[name='leadradio']:checked").val())
            {
                // console.log("no checked");
                $(".leadclntdiv").show();
                $('#leadno').prop('checked', true);
                $('#prtybill').hide();
                ledclntflag=0;
            }
            else{
                // console.log("checked");
                $(".leadclntdiv").hide();
                $('#prtybill').hide();
                ledclntflag=1;
            }
                // console.log(ledclntflag);
                // $(".leadclntdiv").hide();
                // $('#leadno').prop('checked', true);
        }

        $('#addprtymodal').modal('toggle');
    });

    $('#editprtybtn').on('click', function(e){// ===== save edited party data ================

        var who=$("input[name='whoradio']:checked").val()
        var prtyrole=$("#prtyrole").val();
        var prtyroletxt=$("#prtyrole :selected").text();
        var prtyfname=$("#prtyfname").val();
        var prtymname=$("#prtymname").val();
        var prtylname=$("#prtylname").val();
        var prtysuffx=$("#prtysuffx :selected").text();
        var leadcntradio=$('input[name="prtyledcln"]:checked').val();
        var prtybillcode=$("#prtybillcode").val();
        
        if(leadcntradio==1)
        {
            putlead='checked="checked"';
            putbillcode='<input type="text" class="prtycodtxt" id="prtycolcode'+editprtyrowid+'" value="'+prtybillcode+'"/>';
            leadclientcodeid="prtycolcode"+editprtyrowid;
        }
        else{
            putlead="";
            putbillcode="";
            oldcodeid=0;
        }
        if(who=="per")
        {
            if(prtyrole!="" && prtyfname!="" && prtylname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                $("#addprtyerr").html("");
                $("#"+editprtyrowid).empty();
                $('#prtyrowdiv'+editprtyrowid).empty();
                $("#"+editprtyrowid).append('<td class="text-center"><input class="form-check-input rdo'+editprtyrowid+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+editprtyrowid+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+editprtyrowid+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td>');
                $('#prtyrowdiv'+editprtyrowid).append('<input type="text" id="prtycolwho'+editprtyrowid+'" value="per"/><input type="text" id="prtycolrole'+editprtyrowid+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolsfx'+editprtyrowid+'" value="'+prtysuffx+'"/><input type="text" id="prtycolfname'+editprtyrowid+'" value="'+prtyfname+'"/><input type="text" id="prtycolmname'+editprtyrowid+'" value="'+prtymname+'"/><input type="text" id="prtycollname'+editprtyrowid+'" value="'+prtylname+'"/>'+putbillcode);
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
                leadclientcodeid=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }
        else if(who=="org")
        {
            if(prtyrole!="" && prtyfname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                $("#addprtyerr").html("");
                $("#"+editprtyrowid).empty();
                $('#prtyrowdiv'+editprtyrowid).empty();
                $("#"+editprtyrowid).append('<td class="text-center"><input class="form-check-input rdo'+editprtyrowid+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+editprtyrowid+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+editprtyrowid+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td>');
                $('#prtyrowdiv'+editprtyrowid).append('<input type="text" id="prtycolwho'+editprtyrowid+'" value="org"/><input type="text" id="prtycolrole'+editprtyrowid+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolfname'+editprtyrowid+'" value="'+prtyfname+'"/>'+putbillcode);
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
                leadclientcodeid=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }
        else if(who=="serv")
        {
            prtyfname=$("#srvprtyslct option:selected").text();
            if(prtyrole!="" && prtyfname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                $("#addprtyerr").html("");
                $("#"+editprtyrowid).empty();
                $('#prtyrowdiv'+editprtyrowid).empty();
                $("#"+editprtyrowid).append('<td class="text-center"><input class="form-check-input rdo'+editprtyrowid+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+editprtyrowid+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+editprtyrowid+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td>');
                $('#prtyrowdiv'+editprtyrowid).append('<input type="text" id="prtycolwho'+editprtyrowid+'" value="serv"/><input type="text" id="prtycolrole'+editprtyrowid+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolfname'+editprtyrowid+'" value="'+prtyfname+'"/>'+putbillcode);
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
                leadclientcodeid=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }

        // $("#editprtybtn").hide();// hide edit party btn
        // $("#addprty").show();// show add party btn
    });

    $(document).on("change", "input[name='leadradio']", function () {// on direct lead client edit - show
        // alert("aaa");
        $("#editprtybtn").hide();// hide edit party btn
        $("#addprty").hide();// hide add party btn
        $("#ldprtyprtybtn").show();// show edit lead party btn
        $("#prtycancel").hide();// hide prty cancel btn
        $("#ldprtycancel").show();// show lead prty cancel btn

        var oldercodeid=leadclientcodeid;// id of billcode textfield
        if(oldercodeid!=0)
        {
            oldcodeid=leadclientcodeid;
            var oldercode=$("#"+leadclientcodeid).val();// bill code
            // console.log(oldercodeid);
            // console.log(oldercode);
        }

        var getprtywho="";
        var getprtyrole="";
        var getprtysfx="";
        var getprtyfname="";
        var getprtymname="";
        var getprtylname="";
        var getprtycode="";
        var id=$(this).closest('tr').attr('id');
        editprtyrowid=id;
        // console.log(id);

        getprtywho=$("#prtycolwho"+id).val();// getting value frm hidden field
        getprtyrole=$("#prtycolrole"+id).val();
        getprtysfx=$("#prtycolsfx"+id).val();
        getprtyfname=$("#prtycolfname"+id).val();
        // console.log(getprtysfx);

        if(getprtywho=="per")
        {
            getprtymname=$("#prtycolmname"+id).val();
            getprtylname=$("#prtycollname"+id).val();
            $("#prtypers").prop("checked", true);
            $('#srvprtydiv').hide();
            $('#prtyfname').show();
            $('#prtymname').show();
            $('#prtylname').show();
            $('#prtysfx').show();
        }
        else if(getprtywho=="org")
        {
            $('#srvprtydiv').hide();
            $('#prtyfname').show();
            $("#prtyorg").prop("checked", true);
            $('#prtymname').hide();
            $('#prtylname').hide();
            $('#prtysfx').hide();
        }
        else if(getprtywho=="serv")
        {
            $('#srvprtydiv').show();
            $('#prtyfname').hide();
            $("#prtyserv").prop("checked", true);
            $('#prtymname').hide();
            $('#prtylname').hide();
            $('#prtysfx').hide();
            $('#srvprtyslct option:contains("'+getprtyfname+'")')
        }

        $('#prtyfname').val(getprtyfname);// view values in textfields
        $('#prtymname').val(getprtymname);
        $('#prtylname').val(getprtylname);
        $('#prtybillcode').val("");
        $('#prtyrole option:contains('+getprtyrole+')').prop('selected', true);
        $('#prtysuffx option:contains('+getprtysfx+')').prop('selected', true);

        $(".leadclntdiv").show();
        $('#leadyes').prop('checked', true);
        $('#prtybill').show();

        // $("#"+leadclientcodeid).remove();
        $('#addprtymodal').modal('toggle');
    });

    $('#ldprtycancel').on('click', function(e){// direct lead prty edit cancel btn

        // $("#editprtybtn").hide();// hide edit party btn
        // $("#addprty").hide();// hide add party btn
        $("#ldprtyprtybtn").hide();// hide save editted lead party btn
        $("#prtycancel").show();// hide prty cancel btn
        $("#ldprtycancel").hide();// hide lead prty cancel btn

        var oldercodeid=leadclientcodeid;// id of billcode textfield
        if(oldercodeid!=0)
        {
            var oldercode=$("#"+leadclientcodeid).val();// bill code
            // console.log(oldercodeid);
            // console.log(oldercode);
            var id=oldercodeid.split("prtycolcode");
            // console.log(id[1]);
            $(".rdo"+id[1]).prop("checked", true);// check older lead client radio
        }
        if($('.prtycodtxt').length==0)
        {
            var checked=$('input[name="leadradio"]:checked').attr("class");
            checked=checked.split(" ");
            // console.log(checked);
            $('.'+checked[1]).prop('checked', false);
        }
    });

    $('#ldprtyprtybtn').on('click', function(e){// save direct lead prty
        $('#addprtymodal').modal('toggle');

        var who=$("input[name='whoradio']:checked").val()
        var prtyrole=$("#prtyrole").val();
        var prtyroletxt=$("#prtyrole :selected").text();
        var prtyfname=$("#prtyfname").val();
        var prtymname=$("#prtymname").val();
        var prtylname=$("#prtylname").val();
        var prtysuffx=$("#prtysuffx :selected").text();
        var leadcntradio=$('input[name="prtyledcln"]:checked').val();
        var prtybillcode=$("#prtybillcode").val();

        if(leadcntradio==1)
        {
            putlead='checked="checked"';
            putbillcode='<input type="text" class="prtycodtxt" id="prtycolcode'+editprtyrowid+'" value="'+prtybillcode+'"/>';
            leadclientcodeid="prtycolcode"+editprtyrowid;
            $("#"+oldcodeid).remove();
            oldcodeid=0;
        }
        else{
            putlead="";
            putbillcode="";
        }
        // console.log(oldcodeid);

        if(who=="per")
        {
            if(prtyrole!="" && prtyfname!="" && prtylname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                $("#addprtyerr").html("");
                $("#"+editprtyrowid).empty();
                $('#prtyrowdiv'+editprtyrowid).empty();
                $("#"+editprtyrowid).append('<td class="text-center"><input class="form-check-input rdo'+editprtyrowid+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+editprtyrowid+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+editprtyrowid+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td>');
                $('#prtyrowdiv'+editprtyrowid).append('<input type="text" id="prtycolwho'+editprtyrowid+'" value="per"/><input type="text" id="prtycolrole'+editprtyrowid+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolsfx'+editprtyrowid+'" value="'+prtysuffx+'"/><input type="text" id="prtycolfname'+editprtyrowid+'" value="'+prtyfname+'"/><input type="text" id="prtycolmname'+editprtyrowid+'" value="'+prtymname+'"/><input type="text" id="prtycollname'+editprtyrowid+'" value="'+prtylname+'"/>'+putbillcode);
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
                leadclientcodeid=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }
        else if(who=="org")
        {
            if(prtyrole!="" && prtyfname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                $("#addprtyerr").html("");
                $("#"+editprtyrowid).empty();
                $('#prtyrowdiv'+editprtyrowid).empty();
                $("#"+editprtyrowid).append('<td class="text-center"><input class="form-check-input rdo'+editprtyrowid+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+editprtyrowid+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+editprtyrowid+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td>');
                $('#prtyrowdiv'+editprtyrowid).append('<input type="text" id="prtycolwho'+editprtyrowid+'" value="org"/><input type="text" id="prtycolrole'+editprtyrowid+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolfname'+editprtyrowid+'" value="'+prtyfname+'"/>'+putbillcode);
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
                leadclientcodeid=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }
        else if(who=="serv")
        {
            prtyfname=$("#srvprtyslct option:selected").text();
            if(prtyrole!="" && prtyfname!="" && ((leadcntradio==1 && prtybillcode!="") || leadcntradio==0))
            {
                $("#addprtyerr").html("");
                $("#"+editprtyrowid).empty();
                $('#prtyrowdiv'+editprtyrowid).empty();
                $("#"+editprtyrowid).append('<td class="text-center"><input class="form-check-input rdo'+editprtyrowid+'" type="radio" name="leadradio" '+putlead+' value="1"/></td><td id="prtyname'+editprtyrowid+'" class="text-center">'+prtysuffx+' '+prtyfname+' '+prtymname+' '+prtylname+'</td><td id="prtyroletd'+editprtyrowid+'" class="text-center">'+prtyroletxt+'</td><td class="text-center"><i id="editprty" class="fa fa-pencil-square" aria-hidden="true" style="cursor:pointer;"></i><i id="delprty" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td>');
                $('#prtyrowdiv'+editprtyrowid).append('<input type="text" id="prtycolwho'+editprtyrowid+'" value="serv"/><input type="text" id="prtycolrole'+editprtyrowid+'" value="'+prtyroletxt+'"/><input type="text" id="prtycolfname'+editprtyrowid+'" value="'+prtyfname+'"/>'+putbillcode);
                $('#addprtymodal').modal('toggle');
                $("#prtyrole").val("");
                $("#prtyfname").val("");
                $("#prtymname").val("");
                $("#prtylname").val("");
                $("#prtysuffx").val("");
                $("#prtybillcode").val("");
                if(leadcntradio==1)
                {
                    $(".leadclntdiv").hide();
                    $('#leadyes').prop('checked', false);
                    $('#leadno').prop('checked', true);
                    $('#prtybill').hide();
                }
            }
            else{
                $("#addprtyerr").html("all fields are mandatory*");
            }
            if(!$("input[name='leadradio']:checked").val())// check for lead client radio checked
            {
                // console.log("no checked");
                ledclntflag=0;
                leadclientcodeid=0;
            }
            else{
                // console.log("checked");
                ledclntflag=1;
            }
        }

        $("#ldprtyprtybtn").hide();// hide save editted lead party btn
        $("#prtycancel").show();// hide prty cancel btn
        $("#ldprtycancel").hide();// hide lead prty cancel btn
    });

    $('#csepartnext').on('click', function(e){
        var prtynum = $('input:radio[name=leadradio]').length;
        // console.log(prtynum);

        if(prtynum>1)
        {
            if(!$("input[name='leadradio']:checked").val())
            {
                swal("Add Lead Party to continue.");
                return false;
            }
            else{
                var sectn="";
                var prtywho="";
                var prtyrole="";
                var prtycode="";
                var id="";

                $.ajax({// delete old case part draft
                    dataType:"json",
                    type	:"POST",
                    url		:'https://countrywideprocess.com/webservice/savecasedraft.php',
                    data	:{userid:userid,sectn:"delcasepart"},
                    success:function(data)
                    {
                        // $("#slctattrny").html(data);
                        // console.log(data);
                    }
                });

                const myTimeout = setTimeout(savecasepart, 5000);
                function savecasepart()
                {
                    $(".prtyrowdiv").each(function()
                    {
                        id=$(this).attr("id");
                        id=id.split("v");
                        var doc_id=id[1];
                        prtywho=$("#prtycolwho"+doc_id).val();
                        prtyrole=$("#prtycolrole"+doc_id).val();
                        if($("#prtycolcode"+doc_id).length==1)
                        {
                            prtycode=$("#prtycolcode"+doc_id).val();
                        }
                        else{
                            prtycode=0;
                        }
                        if(prtywho=="per")
                        {
                            var prtyname=[$("#prtycolsfx"+doc_id).val(),$("#prtycolfname"+doc_id).val(),$("#prtycolmname"+doc_id).val(),$("#prtycollname"+doc_id).val()];
                        }
                        else{
                            var prtyname=$("#prtycolfname"+doc_id).val();
                        }

                        $.ajax({
                            dataType:"json",
                            type	:"POST",
                            url		:'https://countrywideprocess.com/webservice/savecasedraft.php',
                            data	:{sectn:"casepart",userid:userid,prtywho:prtywho,prtyrole:prtyrole,prtycode:prtycode,prtyname:prtyname},
                            success:function(data)
                            {
                                // $("#slctattrny").html(data);
                                // console.log(data);
                            }
                        });
                    });
                }
            }
        }
        else{
            swal("Add Party to continue.");
            return false;
        }
        
    });
    // ================================================case participants end===================================================
    // ===================================================documents start====================================================
    $('#faxpagediv').hide();// hide fax page on load
    
    $('input[type=radio][name=fileup]').change(function() {// select between fax or upload docs
        if (this.value == 1) {
            // console.log("1");
            $('#faxpagediv').hide();
            $('.attach').show();
            $('.faxacptbtn').hide();
            $(".tbldoctitle").find("tr:gt(0)").remove();
            $(".docalert").css("color","orange");
            $(".docalert").text("(Documents required)");
        }
        else if (this.value == 2) {
            // console.log("2");
            $('#faxpagediv').show();
            $('.attach').hide();
            $('.faxacptbtn').show();
            $('.docupbtn').val("");
            $(".tbldoctitle").find("tr:gt(0)").remove();
            $(".docalert").css("color","orange");
            $(".docalert").text("(Documents required)");
        }
    });

    $(document).on('click', '.collapsible', function(e){// collapse doc div
        // console.log("whhaaaat!!!");
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight){
        content.style.maxHeight = null;
        } else {
        content.style.maxHeight = "592px";
        } 
    });
    // ======for collapsible div====

    function getdoctype()
    {
        var type="getalldoc";
        $.ajax({// get all doc types view in select - modal
            dataType:"json",
            type	:"POST",
            url		:'getdocuments.php',
            data	:{type:type},		
            success:function(data)
            {
                // console.log(data);
                $('#doctpslct').html(data);
            }
        });
    }
    getdoctype();

    // $('#doctpslct').on('change', function(e)// get doc titles on doc type change
    // {
    //     var type="dynamic";
    //     var doc_id=$('#doctpslct').val();
    //     if(doc_id!="")
    //     {
    //         $.ajax({
    //             dataType:"json",
    //             type	:"POST",
    //             url		:'getdocuments.php',
    //             data	:{doc_id:doc_id,type:type},		
    //             success:function(data)
    //             {
    //                 console.log(data);
    //                 // $('#addadrmodal').modal('toggle');
    //                 // listallreqatr();
    //             }
    //         });
    //     }
    // });

    $(document).on('click', '.crtdefttl', function(e){// court defined document title text link for modal
        // alert("ppppp");
        var elementid=$(this).attr("id");
        elementid=elementid.split("_");
        // alert(elementid[1]);
        docid=elementid[1];
    });

    $('#doctypebtn').on('click', function(e)// get doc titles on doc type save btn
    {
        var ttlid=$('#doctpslct').val();
        var doctitle=$("#doctpslct option:selected").text();
        // console.log(ttlid);
        if(ttlid!="")
        {
            $('#srchdocttl_'+docid).val(doctitle);
            $('#srchdocttl_'+docid).attr("data-ttlid",ttlid);
            $('#documentsmodal').modal('toggle');
        }
    });

    $(document).on('keyup', '.srchdocttl', function(e){// search for doc type/title
        // var id=$(this).closest('tr').attr('id');
        var docsrchtagid=$(this).attr('id');
        docsrchtagid=docsrchtagid.split("_");
        var doc_id=docsrchtagid[1];

        var fltrtype=$('input[name="fltrdoctype_'+doc_id+'"]:checked').val();
        // console.log(fltrtype);
        var type="filter";
        var dockey=$(this).val();
        // console.log(dockey);
        if(dockey!="")
        {
            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'getdocuments.php',
                data	:{dockey:dockey,type:type,fltrtype:fltrtype},
                success:function(data)
                {
                    // console.log(data);
                    $("#docUL_"+doc_id).show();
                    $("#docUL_"+doc_id).html(data);
                    // $('#addadrmodal').modal('toggle');
                    // listallreqatr();
                }
            });
        }
        else{
            $("#docUL_"+doc_id).hide();
        }
    });

    $(document).on('click', '.doclst', function(e){// get doc type from search result on click
        e.preventDefault();
        var liid=$(this).parent().parent().attr("id");
        liid=liid.split("_");
        var doc_id=liid[1];
        var docttl=$(this).text();
        var ttlid=$(this).attr("data-docid");// id of clicked doc title search result listed
        $("#srchdocttl_"+doc_id).attr("data-ttlid",ttlid);
        // console.log("title id = "+ttlid);
        // console.log("div id = "+doc_id);
        $("#srchdocttl_"+doc_id).val(docttl);
        $("#docUL_"+doc_id).hide();
        $("#docUL_"+doc_id).html("");
    });

    $(document).on('click', '.faxacptbtn', function(e)// accept fax doc type and view in table
    {
        var divid=$(this).attr("id");
        divid=divid.split("_");
        var doc_id=divid[1];
        var doctxt=$("#srchdocttl_"+doc_id).val();
        var ttlid=$("#srchdocttl_"+doc_id).attr("data-ttlid");
        if(doctxt!="")
        {
            $("#tbldoctitle_"+doc_id).show();
            $("#tbldoctitle_"+doc_id).append('<tr id="docrow_'+doc_id+'">'+
                                                '<td class="doctxt_'+doc_id+'" data-ttlid="'+ttlid+'" data-method="fax">'+doctxt+'</td><td class=""><i id="docdel_'+doc_id+'" class="fa fa-close red d-inline-block ms-2 deldoc" style="cursor:pointer;"></i></td>'+
                                            '</tr>');
            $("#srchdocttl_"+doc_id).val("");
            $("#srchdocttl_"+doc_id).attr("data-ttlid","");
            $("#docalert_"+doc_id).text("(Documents submitted)");
            $("#docalert_"+doc_id).css("color","#afffaf");
            $("#docUL_"+doc_id).hide();
            $("#docUL_"+doc_id).html("");
        }
        else{
            swal("Please add document title");
        }
    });

    $(document).on('click', '.docupbtn', function(e)// on upload btn click
    {
        var divid=$(this).attr("id");
        divid=divid.split("_");
        var doc_id=divid[1];
        var doctxt=$("#srchdocttl_"+doc_id).val();
        // console.log(doctxt);
        if(doctxt=="")
        {
            e.preventDefault();
            swal("Please add document title");
        }
    });

    $(document).on('change', '.docupbtn', function(e){// view the selected doc title in table only if doctitle and file selected
        // alert($(this).val());

        var divid=$(this).attr("id");
        divid=divid.split("_");
        var doc_id=divid[1];
        var doctxt=$("#srchdocttl_"+doc_id).val();
        var ttlid=$("#srchdocttl_"+doc_id).attr("data-ttlid");
        // console.log(doctxt);
        if(doctxt!="")
        {
            let rand = (Math.random() + 1).toString(36).substring(7);
            // console.log("random", r);

            $("#tbldoctitle_"+doc_id).show();
            $("#tbldoctitle_"+doc_id).append('<tr id="docrow_'+doc_id+'">'+
                                                '<td class="doctxt_'+doc_id+'" data-ttlid="'+ttlid+'" data-fileid="'+rand+'" data-method="upload">'+doctxt+'</td><td class=""><i id="docdel_'+doc_id+'" class="fa fa-close red d-inline-block ms-2 deldoc" style="cursor:pointer;"></i></td>'+
                                            '</tr>');
            $("#attach_"+doc_id).append('<input type="file" class="attach-fld docupbtn" name="docupbtn_'+doc_id+'" id="docupbtn_'+doc_id+'" data-fileid=""/>');
            $(this).hide();
            $(this).attr("data-fileid",rand);
            $(this).attr("name","file_"+rand);
            $(this).attr("id","file_"+rand);
            $(this).removeClass("docupbtn");
            $(this).addClass("docbtn_"+doc_id);

            $("#srchdocttl_"+doc_id).val("");
            $("#srchdocttl_"+doc_id).attr("data-ttlid","");
            $("#docalert_"+doc_id).text("(Documents submitted)");
            $("#docalert_"+doc_id).css("color","#afffaf");
        }
        else{
            e.preventDefault();
        }
    });

    $(document).on('click', '.deldoc', function(e)// remove an added doc row
    {
        var thisid=$(this).attr("id");
        thisid=thisid.split("_");
        var doc_id=thisid[1];
        $("#docrow_"+doc_id).remove();
        var numItems = $('#docdel_'+doc_id).length;
        if(numItems==0)
        {
            $("#tbldoctitle_"+doc_id).hide();
            $("#docalert_"+doc_id).text("(Documents required)");
            $("#docalert_"+doc_id).css("color","orange");
        }
    });

    // $("form#data").submit(function(e) {
    $('#docnxtbtn').on('click', function(e){

        e.preventDefault();   
        var caseerr=0;
        var docttle="";
        var rowCount="";
        var parties=$(".parties").val();
        if(parties<=1 || (parties>1 && $("#samedocchk").prop('checked') == true))// single/no party/mult party without same docs
        {
            // alert("konakona");
            rowCount = $('#tbldoctitle_0 tr').length;
            // console.log(rowCount);
            if($('#rdbtnup').is(':checked'))
            {
                if(rowCount<2)
                {
                    swal("Please add document title and upload file.");
                    caseerr==1;
                    // console.log(rowCount);
                    return false;
                }
            }
            else{
                if(rowCount<2)
                {
                    swal("Please add document title.");
                    caseerr==1;
                    // console.log(rowCount);
                    return false;
                }
            }
        }
        else if(parties>1 && $("#samedocchk").prop('checked') == false)// mult party with same docs
        {
            // console.log(rowCount);
            for(var i=0;i<parties;i++)
            {
                rowCount = $('#tbldoctitle_'+(i+1)+' tr').length;
                if($('#rdbtnup').is(':checked'))
                {
                    if(rowCount<2)
                    {
                        swal("Please add document title and upload file.");
                        caseerr==1;
                        // console.log(rowCount);
                        return false;
                    }
                }
                else{
                    if(rowCount<2)
                    {
                        swal("Please add document title.");
                        caseerr==1;
                        // console.log(rowCount);
                        return false;
                    }
                }
            }
        }

        if(caseerr==0)
        {
            var form_data = new FormData();
            form_data.append("userid", userid);// append user id
            var method=$("input[name='fileup']:checked").val();

            if($("#samedocchk").prop('checked')==true)
            {
                var samedoc=1;
            }
            else{
                var samedoc=0;
            }
            form_data.append("samedoc", samedoc);// append whether is same doc checked
            form_data.append("sectn", "casedocs");// append section
            form_data.append("method", method);// append method
            form_data.append("partynum", parties);// append num of parties/serve

            if(parties==1 || (parties>1 && $("#samedocchk").prop('checked')==true))
            {
                var i=0;
                var idarr=[];// store file ids
                $(".doctxt_0").each(function()
                {
                    var docttle=$(this).text();
                    // console.log(docttle);
                    form_data.append("docttle_0_"+i, docttle);// append doc title
                    var ttlid=$(this).attr("data-ttlid");
                    form_data.append("ttlid0_"+i, ttlid);// append doc title id
                    if(method==1)
                    {
                        var fileid=$(this).attr("data-fileid");
                        console.log(fileid);
                        idarr[i]=fileid;
                        form_data.append("file_"+fileid, document.getElementById('file_'+fileid).files[0]);// append file name
                    }
                    i++;
                });
                form_data.append("fileid", idarr);// append file ids
                form_data.append("numdocs", i);// append number of docs
            }
            else if(parties>1 && $("#samedocchk").prop('checked')==false)
            {
                var docttle="";
                var ttlid="";
                // var arr=[[],[]];
                var k=[];
                for(var i=0;i<parties;i++)
                {
                    var j=0;
                    $(".doctxt_"+(i+1)).each(function(){
                        // console.log("hehe");
                        docttle=$(this).text();
                        form_data.append("docttle_"+(i+1)+"_"+(j+1), docttle);// append doc title
                        ttlid=$(this).attr("data-ttlid");
                        form_data.append("ttlid"+(i+1)+"_"+(j+1), ttlid);// append doc title id
                        if(method==1)
                        {
                            var fileid=$(this).attr("data-fileid");
                            form_data.append("fileid"+(i+1)+"_"+(j+1), fileid);// append file id s
                            form_data.append("file_"+fileid, document.getElementById('file_'+fileid).files[0]);// append doc files
                        }
                        j++;
                    });
                    k[i]=j;
                    form_data.append("fileid", idarr);// append file ids
                    form_data.append("numdocs", k);// append number of docs
                }
            }

            $.ajax({
                dataType: "json",
                type:"POST",
                url:"https://countrywideprocess.com/webservice/savecasedraft.php",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success:function(data)
                {
                    console.log(data);
                }
            });

            // $.ajax({
            //     dataType:"json",
            //     type	:"POST",
            //     url		:'https://countrywideprocess.com/webservice/savecasedraft.php',
            //     // data	:{sectn:"casedocs",partynum:parties,method:method,prtyrole:prtyrole,prtycode:prtycode,prtyname:prtyname},
            //     data	:form_data,
            //     success:function(data)
            //     {
            //         // $("#slctattrny").html(data);
            //         console.log(data);
            //     }
            // });
            // var form_data = new FormData();
            // form_data.append("method", "aaa");
            // alert(bannerupload);
        }
    });
    // ===================================================documents end====================================================

    // ===================================================serve info start====================================================
    $(document).on('keyup', '.srchaddr', function(e){// search for address - multi
        // console.log("ssss");
        var adr=$(this).val();
        var thisid=$(this).attr("id");
        thisid=thisid.split("_");
        var doc_id=thisid[1];
        // console.log(adr);
        if(adr!="")
        {
            var type="multi";
            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'searchaddress.php',
                data	:{adr:adr,type:type},		
                success:function(data)
                {
                    // console.log(data);
                    if(data!="")
                    {
                        $("#srchadrli_"+doc_id).html(data);
                        $("#srchadrli_"+doc_id).show();
                    }
                }
            });
        }
        else{
            $("#srchadrli_"+doc_id).empty();
            $("#srchadrli_"+doc_id).hide();
        }
    });

    $(document).on('click', '.multadrsrchli', function(e){// get values from address search res - multi
        e.preventDefault();
        // console.log("multi");
        var thisid=$(this).parent().parent().attr("id");
        console.log(thisid);
        thisid=thisid.split("_");
        var doc_id=thisid[1];
        var address=$(this).text();
        var adrid=$(this).attr("data-adrid");

        $("#srchaddr_"+doc_id).val(address);
        $("#srchaddr_"+doc_id).attr("data-adrid",adrid);
        $(".srchadrli").hide();
        $(".srchadrli").empty();
    });

    $('#srvinfonxtbtn').on('click', function(e){// serve info next click changes for order details attempt time
        // alert("ok sir");
        var parties=$(".parties").val();
        // ====changes for order info - multi parties====
        if(parties<=1)// single/no party
        {
            // alert("konakona");
            $("#1ordrdetdiv").show();
            $("#multordrdetdiv").hide();
        }
        else// mult parties
        {
            var servadr="";
            $("#multordrdetdiv").empty();
            $("#multordrdetdiv").append("<span id=''>Click on Party Name below to add Serve Info if required</span>");

            var pcity=[];
            var temp="";
            for(i=0;i<parties;i++)
            {
                temp=$("#srchaddr_"+(i+1)).val();
                temp=temp.split(",");
                pcity[i]=temp[1];
            }

            $.ajax({
                dataType:"json",
                type	:"POST",
                url		:'https://countrywideprocess.com/webservice/getattemptprice.php',
                data	:{parties:parties,pcity:pcity},		
                success:function(data)
                {
                    // atmdata=data;
                    // console.log(data);
                    // // console.log(atmdata);
                    // console.log(data[1][0][0]['levels']);
            //     }
            // });
            
            for(i=0;i<parties;i++)
            {
                var servadr="";
                if($("#sameaddrchk").prop('checked') == true)
                {
                    servadr=$("#srchaddr_0").val();
                }
                else{
                    servadr=$("#srchaddr_"+(i+1)).val();
                }

                console.log(servadr);
                // calc date
                const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
                var date1 = new Date();
                var date2 = new Date();
                var a=date1.setDate(date1.getDate() + 2);// add 1 day
                var day1=weekday[new Date(a).getDay()];
                var b=date2.setDate(date2.getDate() + 3);// add 2 day
                var day2=weekday[new Date(b).getDay()];

                var prty=$("#ordprtyname"+(i+1)).val();
                var prtycap=$("#ordprtycap"+(i+1)+" :selected").text();
                $("#multordrdetdiv").append('<div id="ordrdetdiv_'+(i+1)+'">'+
                                                '<button class="collapsible" type="button">When would you like this attempted?('+prty+' - '+servadr+')</button>'+
                                                '<div class="content" style="margin-bottom:10px;">'+
                                                    '<div class="col-lg-12 mb-3">'+
                                                        '<div class="form-check form-check-inline">'+
                                                            '<input class="form-check-input" type="radio" name="inlineRadioProof" id="prffile" value="option1" style="appearance: auto;"/>'+
                                                            '<label class="form-check-label" for="prffile">Attempt by Tomorrow 3:00 PM for '+data[i][0][3]['prices']+'$ (On Demand) *</label>'+
                                                        '</div>'+
                                                        '<div class="form-check form-check-inline">'+
                                                            '<input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>'+
                                                            '<label class="form-check-label" for="prfnotrz">Attempt by Tomorrow 5:00 PM for '+data[i][0][2]['prices']+'$ (Urgent) *</label>'+
                                                        '</div>'+
                                                        '<div class="form-check form-check-inline">'+
                                                            '<input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>'+
                                                            '<label class="form-check-label" for="prfnotrz">Attempt by '+day1+' 5:00 PM for '+data[i][0][1]['prices']+'$ (Priority) *</label>'+
                                                        '</div>'+
                                                        '<div class="form-check form-check-inline mb-4">'+
                                                            '<input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>'+
                                                            '<label class="form-check-label" for="prfnotrz">Attempt by '+day2+' 5:00 PM for '+data[i][0][0]['prices']+'$ (Routine) *</label>'+
                                                        '</div>'+
                                                        '<br/>'+
                                                        '<span class="" style="font-size: 11px; color: #000;">'+
                                                            '* Prices listed and service times displayed are per address attempted and only an estimate based on the information provided. If you need your order processed sooner than the times listed above, please call us at (888) 962-9696.'+
                                                        '</span>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>');
            }
        }
    });
            $("#1ordrdetdiv").hide();
            $("#multordrdetdiv").show();
        }
    });
    // ===================================================serve info end====================================================
    // ===================================================case submit start====================================================
    $('#casesubmitbtn').on('click', function(e){

        var memid=$("#slctattrny").val();// atr/req/same id
        if(memid!="same")
        {
            memid=memid.split("/");
            if(memid[1]=="at")
            {
                var atrid=memid[0];
                var reqid=0;
            }
            else if(memid[1]=="req")
            {
                var atrid=0;
                var reqid=memid[0];
            }
            console.log(memid[0]);
        }
        else{
            var atrid=userid;
            var reqid=0;
        }
        var courtid=$("#srchcourt").attr("data-courtid");
        var caseno=$(".caseno").val();
        var billcode=$(".prtycodtxt").val();

        var id="";
        var prtywho=[];
        var prtyrole=[];
        var prtyname=[];
        var prtycode=[];
        var i=0;
        var plainindex
        var diffindex
        $(".prtyrowdiv").each(function()
        {
            id=$(this).attr("id");
            id=id.split("v");
            var doc_id=id[1];
            prtywho[i]=$("#prtycolwho"+doc_id).val();
            prtyrole[i]=$("#prtycolrole"+doc_id).val();
            if($("#prtycolcode"+doc_id).length==1)
            {
                prtycode[i]=$("#prtycolcode"+doc_id).val();
                plainindex=i;
            }
            else{
                prtycode[i]=0;
                diffindex=i;
            }
            if(prtywho[i]=="per")
            {
                prtyname[i]=[$("#prtycolsfx"+doc_id).val(),$("#prtycolfname"+doc_id).val(),$("#prtycolmname"+doc_id).val(),$("#prtycollname"+doc_id).val()];
            }
            else{
                prtyname[i]=$("#prtycolfname"+doc_id).val();
            }
            i++;
        });

        var prtynum=$(".parties").val();

        if(prtynum>1 && $("#samedocchk").prop('checked')==true)// if multiple servee added check if servees are served with same docs
        {
            var samedocs=1;
        }
        else{
            var samedocs=0;
        }

        if(prtynum>1)
        {
            var srvname=[];
            var srvcap=[];
            var srvregagent=[];
            var srvaddr=[];
            var srvadrid=[];
            var srvbusname=[];
            var tzone=[];
            var hdate=[];
            var witnsfee=[];
            var proof=[];
            var splinstr=[];
            for(i=0;i<prtynum;i++)
            {
                srvname[i]=$("#ordprtyname"+(i+1)).val();
                srvcap[i]=$("#ordprtycap"+(i+1)).val();
                srvregagent[i]=$("#ordregagntname"+(i+1)).val();
                srvaddr[i]=$("#srchaddr_"+(i+1)).val();
                srvadrid[i]=$("#srchaddr_"+(i+1)).attr("data-adrid");
                srvbusname[i]=$("#busname_"+(i+1)).val();
                tzone[i]=$("#srvtimezn_"+(i+1)).val();
                hdate[i]=$("#hrdate_"+(i+1)).val();
                if($("#yeswitnsfee_"+(i+1)).prop("checked"))
                {
                    witnsfee[i]=1;
                }
                else{
                    witnsfee[i]=0;
                }
                if($("#prffile_"+(i+1)).prop("checked"))
                {
                    proof[i]="file";
                }
                else if($("#prfnotrz_"+(i+1)).prop("checked"))
                {
                    proof[i]="notarize";
                }
                splinstr[i]=$("#spcinstr_"+(i+1)).val();
            }
        }
        else{
            var srvname=$("#ordprtyname0").val();
            var srvcap=$("#ordprtycap0").val();
            var srvregagent=$("#ordregagntname0").val();
            var srvaddr=$("#srchaddr").val();
            var srvadrid=$("#srchaddr").attr("data-adrid");
            var srvbusname=$("#srvbusname").val();
            var tzone=$("#srvtzone").val();
            var hdate=$("#srvdate").val();
            if($("#witnsfeeyes").prop("checked"))
            {
                var witnsfee=1;
            }
            else{
                var witnsfee=0;
            }
            var proof="";
            if($("#prffile").prop("checked"))
            {
                proof="file";
            }
            else if($("#prfnotarize").prop("checked"))
            {
                proof="notarize";
            }
            var splinstr=$("#spinstr").val();
        }

        if(prtynum==1 || (prtynum>1 && $("#samedocchk").prop('checked') == true))// single/no party/mult party with same docs
        {
            var i=0;
            var docttle="";
            var ttlid="";
            $(".doctxt_0").each(function()
            {
                docttle=$(this).text();
                // console.log(docttle);
                // form_data.append("docttle_0_"+i, docttle);// append doc title
                ttlid=$(this).attr("data-ttlid");
                // form_data.append("ttlid0_"+i, ttlid);// append doc title id
                // if(method==1)
                // {
                //     var fileid=$(this).attr("data-fileid");
                //     console.log(fileid);
                //     idarr[i]=fileid;
                //     form_data.append("file_"+fileid, document.getElementById('file_'+fileid).files[0]);// append file name
                // }
                i++;
            });
            var numdocs=i;
            // form_data.append("numdocs", i);// append number of docs
        }
        else if(prtynum>1 && $("#samedocchk").prop('checked') == false)// mult party without same docs
        {
            docttle=0;
            ttlid=0;
        }

        console.log(docttle);
        console.log(ttlid);

        $.ajax({
            dataType:"json",
            type	:"POST",
            url		:'addcase.php',
            data	:{atrid:atrid,reqid:reqid,courtid:courtid,caseno:caseno,billcode:billcode,plntf:prtyname[plainindex],
                diff:prtyname[diffindex],plntfrole:prtyrole[plainindex],diffrole:prtyrole[diffindex],prtynum:prtynum,srvname:srvname,
                srvcap:srvcap,srvregagent:srvregagent,srvaddr:srvaddr,srvadrid:srvadrid,srvbusname:srvbusname,tzone:tzone,hdate:hdate,witnsfee:witnsfee,
                proof:proof,splinstr:splinstr,samedocs:samedocs,docttle:docttle,ttlid:ttlid},
            success:function(data)
            {
                console.log(data);
            }
        });
    });
    // ===================================================case submit end====================================================

    // $.ajax({
    //     dataType:"json",
    //     type	:"POST",
    //     url		:'https://countrywideprocess.com/webservice/test.php',
    //     data	:{},		
    //     success:function(data)
    //     {
    //         console.log(data);
    //     }
    // });
});