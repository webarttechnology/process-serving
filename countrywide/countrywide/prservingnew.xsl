<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
<xsl:template match="Clients">
<div class="page-wrapper">
<div class="page-content">
<input type="text" name="userid" id="userid" value="{Client/ClientID}" style="display:none;"/>
<div class="load" style="display:none;"></div>
<section class="minbody" style="color:black !important;">
    <div class="pricingpg progresspg">
        <div class="pgmincontent pt-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="contentbox pb-5 px-3 wow bounceInDown" data-wow-delay=".6s"> 
                            <div class="row calculetorbox">
                                <div class="col-md-12">
                                    <div class="row">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-wizard">
                                        <div class="steps">
                                            <ul>
                                                <li>Case Info</li>
                                                <li>Order Info</li>
                                                <!-- <li>Case Participants</li> -->
                                                <!-- <li>Order Documents</li> -->
                                                <!-- <li>Serve Info</li> -->
                                                <li>Order Details</li>
                                            </ul>
                                        </div>
                                        <div class="myContainer">
                                            <div class="form-container animated border shadow p-4">
                                                <form>
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <label class="form-label">Case Number:</label>
                                                            <input type="text" class="form-control caseno" id="exampleInputEmail1" data-caseid="" placeholder="Enter your Case Number for Serve"/>
                                                            <div class="form-check">
                                                                <input class="form-check-input newcasechkbx" type="checkbox" value="" id="flexCheckDefault" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="flexCheckDefault">
                                                                    Check here if you do not have a Case Number.
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="newcasediv" style="display:none">
                                                            <div style="display:flex;">
                                                                <div class="mb-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" name="" id="evict" value="yes" style="appearance: auto;"/>
                                                                        <label class="form-check-label" for="evict">Check if this is an Eviction Case</label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="checkbox" name="" id="initial" value="no" style="appearance: auto;"/>
                                                                        <label class="form-check-label" for="initial">Check if this is the Initial Service Example - Summons and Complaint</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label">Court county:</label>
                                                                <input type="text" class="form-control" id="srchcourt" data-courtid="" placeholder="Court" style="width:45%;"/>
                                                                <div >
                                                                    <ul id="myUL" style="height:271px;overflow:auto;display:none;">

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" id="plaininpdiv">
                                                                <label class="form-label">Plaintiff</label>
                                                                <input type="text" class="form-control" id="plaininp" placeholder="Plaintiff" style="width:45%;" readonly="readonly"/>
                                                            </div>
                                                            <div class="col-md-12" id="definpdiv">
                                                                <label class="form-label">Defendant</label>
                                                                <input type="text" class="form-control" id="definp" placeholder="Defendant" style="width:45%;" readonly="readonly"/>
                                                            </div>
                                                            <!-- <div class="col-md-12" id="defrolinpdiv">
                                                                <label class="form-label">Defendant role</label>
                                                                <input type="text" class="form-control" id="defrolinp" placeholder="role" style="width:45%;"/>
                                                            </div> -->
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <h3 style="font-size:14px;">Proof of Service Information</h3>
                                                                    <div class="col-md-6">
                                                                        <select class="form-select selectpicker" id="slctattrny">
                                                                            <option selected="" value="">Attorney of Record:</option>
                                                                            <option value="new">New</option>
                                                                            <option value="{Client/ClientID}/same"><xsl:value-of select="Client/Client"/></option>
                                                                            <xsl:for-each select="Client/Attorneys/Attorney">
                                                                                <xsl:choose><xsl:when test="Attorney!='NONE'">
                                                                                    <option value="{AttorneyID}/at"><xsl:value-of select="Attorney"/></option>
                                                                                </xsl:when></xsl:choose>
                                                                            </xsl:for-each>
                                                                            <xsl:for-each select="Client/Secretaries/Secretary">
                                                                                <xsl:choose><xsl:when test="Secretary!='NONE'">
                                                                                    <option value="{SecretaryID}/req"><xsl:value-of select="Secretary"/></option>
                                                                                </xsl:when></xsl:choose>
                                                                            </xsl:for-each>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <table class="table table-borderless" style="color:black">
                                                                            <tr>
                                                                                <th width="40%">Firm Name:</th>
                                                                                <th width="60%"><input class="clfrmname" type="text" value="{Client/Client}" name="" id="" style="height:30px;width:100%;border:none;" disabled="disabled"/></th>
                                                                            </tr>
                                                                            <tr id="atrreqnametbl">
                                                                                <td width="40%">Name:</td>
                                                                                <td width="60%"><input class="clname" type="text" value="{Client/Client}" name="" id="" style="height:30px;width:100%;border:none;" disabled="disabled"/></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Address:</td>
                                                                                <td><input class="claddress" type="text" value="{Client/Address}" name="" id="" style="height:30px;width:100%;border:none;" disabled="disabled"/></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>City/State/Zip:</td>
                                                                                <td><input class="clzip" type="text" value="{Client/City}, {Client/State}, {Client/Zip}" name="" id="" style="height:30px;width:100%;border:none;" disabled="disabled"/></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Phone:</td>
                                                                                <td><input class="clphone" type="text" value="{Client/Phone}" name="" id="" style="height:30px;width:100%;border:none;" disabled="disabled"/></td>
                                                                            </tr>
                                                                            <tr><td colspan="2"><input type="checkbox" class="editdet" name="" id=""/>  Check here to override name on Proof of Service</td></tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr/>
                                                    <!-- case part -->
                                                    <div class="row mb-3">
                                                        <h5>Add Case Participants</h5>
                                                        <div class="col-md-7 text-right mb-3" style="width:100%;">
                                                            <label>Click to add Party(s) if not listed below:</label><br/>
                                                        </div><br/>

                                                        <!-- <button type="button" id="addprty" class="btn" style="background-color:#0d6efd;width:300px;color:white;margin-bottom:10px"><i class="fa fa-plus"></i> Add a New Party to the Case</button>
                                                        <button type="button" id="editprtybtn" class="btn" style="background-color:#0d6efd;width:300px;color:white;margin-bottom:10px;display:none;"><i class="fa fa-plus"></i> Save changes</button>
                                                        <button type="button" id="ldprtyprtybtn" class="btn" style="background-color:#0d6efd;width:300px;color:white;margin-bottom:10px;display:none;"><i class="fa fa-plus"></i> Save changes</button>
                                                        <button type="button" id="prtycancel" class="btn" style="background-color:#7d8897;width:100px;color:white;margin-bottom:10px;display:none;">Cancel</button>
                                                        <button type="button" id="ldprtycancel" class="btn" style="background-color:#7d8897;width:100px;color:white;margin-bottom:10px;display:none;">Cancel</button> -->
                                                        <div class="mb-3">
                                                            <div class="" style="display:flex;flex-direction:row;justify-content: center;width: 100%;">
                                                                <div class="" style="margin:0 5% 0 5%;">
                                                                    <input type="radio" id="prtyserv" name="whoradio" value="serv" style="color:black !important;"/>
                                                                    <label class="form-check-label" for="prtyserv" style="color:black !important;">choose from servee</label>
                                                                </div>
                                                                <div class="" style="margin:0 5% 0 5%;">
                                                                    <input type="radio" id="prtyorg" name="whoradio" value="org" style="color:black !important;"/>
                                                                    <label class="form-check-label" for="prtyorg" style="color:black !important;">Organisation</label>
                                                                </div>
                                                                <div class="" style="margin:0 5% 0 5%;">
                                                                    <input type="radio" id="prtypers" name="whoradio" value="per" checked="checked" style="color:black !important;"/>
                                                                    <label class="form-check-label" for="prtypers" style="color:black !important;">Person</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span id="addprtyerr" style="color:red;font-size:14px;"></span>
                                                        <!-- <table class="table" id="">
                                                            <tbody id="">
                                                                <tr>
                                                                    <td width="30%">
                                                                        <select id="prtyrole" class="form-select">
                                                                            <option value="">Select...</option>
                                                                            <option value="APP">Appellant</option>
                                                                            <option value="CLT">Claimant</option>
                                                                            <option value="CCT">Cross-Complainant</option>
                                                                            <option value="CDT">Cross-Defendant</option>
                                                                            <option value="DFN">Defendant</option>
                                                                            <option value="GALM">Guardian Ad Litem</option>
                                                                            <option value="INV">Intervenor</option>
                                                                            <option value="JCR">Judgment Creditor</option>
                                                                            <option value="JDR">Judgment Debtor</option>
                                                                            <option value="NPR">Non-Party</option>
                                                                            <option value="PET">Petitioner</option>
                                                                            <option value="PLN">Plaintiff</option>
                                                                            <option value="RPI">Real Parties in Interest</option>
                                                                            <option value="RER">Requester</option>
                                                                            <option value="RSP">Respondent</option>
                                                                        </select>
                                                                    </td>
                                                                    <td width="30%">
                                                                        <input type="text" id="prtyname" class="form-control" style="width:100%" placeholder="Party name"/>
                                                                        <select class="form-select sfl-fld" id="srvprtyslct" style="color:black !important;display:none;">
                                                                            
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-check form-check-inline leadclntdiv">
                                                                            <input class="form-check-input" type="checkbox" name="leadclient" id="prtyledcln" value="1" style="appearance: auto;"/>
                                                                            <label class="form-check-label" for="prtyledcln">Check if this is your Lead Client</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="leadclntdiv" id="prtybill" style="display:none;">
                                                            <div class="col-md-10 mb-3 px-1">
                                                                <input type="text" class="form-control" id="prtybillcode" placeholder="Billing Code" style="float:right;"/>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-md-10 mb-3">
                                                            <div class="row">
                                                                <div class="col-md-3 px-1">
                                                                    <select id="prtyrole" class="form-select">
                                                                        <option value="">Select...</option>
                                                                        <option value="APP">Appellant</option>
                                                                        <option value="CLT">Claimant</option>
                                                                        <option value="CCT">Cross-Complainant</option>
                                                                        <option value="CDT">Cross-Defendant</option>
                                                                        <option value="DFN">Defendant</option>
                                                                        <option value="GALM">Guardian Ad Litem</option>
                                                                        <option value="INV">Intervenor</option>
                                                                        <option value="JCR">Judgment Creditor</option>
                                                                        <option value="JDR">Judgment Debtor</option>
                                                                        <option value="NPR">Non-Party</option>
                                                                        <option value="PET">Petitioner</option>
                                                                        <option value="PLN">Plaintiff</option>
                                                                        <option value="RPI">Real Parties in Interest</option>
                                                                        <option value="RER">Requester</option>
                                                                        <option value="RSP">Respondent</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-5 px-1" id="srvprtydiv" style="display:none;">
                                                                    <!-- <label class="sfl" style="color:black !important;">Name:*</label> -->
                                                                    <select class="form-select sfl-fld" id="srvprtyslct" style="color:black !important;">
                                                                        <!-- <option value="">select</option> -->
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-2 px-1">
                                                                    <input type="text" class="form-control" id="prtyfname" placeholder="First Name" style="color:black !important;"/>
                                                                </div>
                                                                <div class="col-sm-2 px-1">
                                                                    <input type="text" class="form-control" id="prtymname" placeholder="Middle Name" style="color:black !important;"/>
                                                                </div>
                                                                <div class="col-sm-2 px-1">
                                                                    <input type="text" class="form-control" id="prtylname" placeholder="Last Name" style="color:black !important;"/>
                                                                </div>
                                                                <div class="col-sm-2 px-1" id="prtysfx">
                                                                    <select class="form-select sfl-fld" id="prtysuffx" style="color:black !important;">
                                                                        <option value="0">--Suffix--</option>
                                                                        <option value="1">Jr.</option>
                                                                        <option value="2">Sr.</option>
                                                                        <option value="3">II</option>
                                                                        <option value="4">III</option>
                                                                        <option value="5">IV</option>
                                                                    </select>
                                                                </div><br/>
                                                                <!-- <div class="col"> -->
                                                                    <button type="button" id="addprty" class="btn" style="background-color:#0d6efd;width:250px;color:white;margin-bottom:10px;position:absolute;right:5%;"><i class="fa fa-plus"></i> Add This Party</button>
                                                                    <button type="button" id="editprtybtn" class="btn" style="background-color:#0d6efd;width:200px;color:white;margin-bottom:10px;display:none;position:absolute;right:11%;"><i class="fa fa-plus"></i> Save changes</button>
                                                                    <button type="button" id="ldprtyprtybtn" class="btn" style="background-color:#0d6efd;width:200px;color:white;margin-bottom:10px;display:none;position:absolute;right:11%;"><i class="fa fa-plus"></i> Save changes</button>
                                                                    <button type="button" id="prtycancel" class="btn" style="background-color:#7d8897;width:100px;color:white;margin-bottom:10px;display:none;position:absolute;right:1.8%;">Cancel</button>
                                                                    <button type="button" id="ldprtycancel" class="btn" style="background-color:#7d8897;width:100px;color:white;margin-bottom:10px;display:none;position:absolute;right:1.8%;">Cancel</button>
                                                                <!-- </div> -->
                                                                <div class="leadclntdiv">
                                                                    <input class="form-check-input" type="checkbox" name="leadclient" id="prtyledcln" value="1" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="prtyledcln">Check if this is your Lead Client</label>
                                                                </div>
                                                                <div class="leadclntdiv" id="prtybill" style="display:none;">
                                                                    <div class="">
                                                                        <input type="text" class="form-control" id="prtybillcode" placeholder="Billing Code" style=""/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <table class="table table-borderless primary-blue" id="prtytbl">
                                                            <tr>
                                                                <th width="30%" class="">Party Role*</th>
                                                                <th class="">Add Party Name(s):*</th>
                                                                <!-- <th width="15%" class="text-center"></th> -->
                                                            </tr>
                                                            <!-- <tr>
                                                                <td class="text-center">
                                                                        <input class="form-check-input" type="checkbox" value="" checked="checked"/>
                                                                </td>
                                                                <td class="text-center">Raju Chakraborty Sr.</td>
                                                                <td class="text-center">Claimant</td>   
                                                                <td class="text-center">
                                                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                                                        <i class="fa fa-close red d-inline-block ms-2"></i>
                                                                </td>
                                                            </tr> -->
                                                        </table>
                                                        <div id="prtyinfodiv" style="display:none"></div>
                                                    </div>
                                                    <!-- case part -->
                                                    <div class="form-group text-center mar-b-0">
                                                        <!-- <input type="button" value="BACK" class="btn btn-dark back" style="background-color:#212529"/> -->
                                                        <input type="button" value="NEXT" id="caseinfonext" class="btn btn-primary next text-white" style="background-color:#0d6efd"/>
                                                    </div>
                                                </form>
                                                <table class="table table-striped" id="caseresult" style="display:none;">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">CourtCaseNo</th>
                                                            <th scope="col">Plaintiff</th>
                                                            <th scope="col">Defendant</th>
                                                            <th scope="col">Court county</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="caserestbody">
                                                        <!-- <tr>
                                                            <th scope="row" style="color:black;">1</th>
                                                            <td style="color:black;">Mark</td>
                                                            <td style="color:black;"><button style="background-color:#0d6efd;color:white;height:30px;border:1px solid #64a3ff">Place order</button></td>
                                                        </tr> -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <!-- <div class="form-container animated border shadow p-4">
                                                case participants
                                            </div> -->
                                            <!-- <div class="form-container animated border shadow p-4">
                                                
                                            </div> -->
                                        
                                            <!-- <div class="form-container animated border shadow p-4"> -->
                                                <!-- ========================================================== -->
                                                <!-- servee address -->
                                                <!-- ============================================================== -->
                                                <!-- <div class="form-group text-center mar-b-0">
                                                    <input type="button" value="BACK" class="btn btn-dark back" style="background-color:#212529"/>
                                                    <input type="button" value="NEXT" id="srvinfonxtbtn" class="btn btn-primary next" style="background-color:#0d6efd"/>
                                                </div>
                                            </div> -->
                                            <div class="form-container animated border shadow p-4">
                                                <form action="#" method="post" id="hockey">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <h5>Add Servee Info</h5>
                                                            <div class="autocomplete-container" id="autocomplete-container"></div>
                                                            <label class="d-inline-block">Select number of Party(s) to Serve:</label>
                                                            <div class="dropdown-form d-inline-block">
                                                                <select name="hockeyList" class="parties">
                                                                    <option value="0">Select</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="6">7</option>
                                                                    <option value="8">8</option>
                                                                    <option value="9">9</option>
                                                                    <option value="10">10</option>
                                                                    <option value="11">11</option>
                                                                    <option value="12">12</option>
                                                                    <option value="13">13</option>
                                                                    <option value="14">14</option>
                                                                    <option value="15">15</option>
                                                                </select>
                                                            </div>
                                                            <label class="d-inline-block"> (for more than 15 Party(s), please place multiple orders)</label>
                                                        </div>
                                                        <table class="table table-striped" id="tblparties">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Party(s) To Serve*</th>
                                                                    <th scope="col">Capacity*</th>
                                                                    <th scope="col">Registered Agent</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="partybody">
                                                                <!-- <tr>
                                                                    <td><input type="text" class="form-control" id="" placeholder="Party(s) To Serve*" style="width:100%;"/></td>
                                                                    <td>
                                                                        <select class="form-select">
                                                                            <option value="">Select...</option> 
                                                                            <option value="Association or Partnership">Association or Partnership</option>
                                                                            <option value="Authorized Person">Authorized Person</option>
                                                                            <option value="Business Organization, Form Unknown">Business Organization, Form Unknown</option>
                                                                            <option value="Corporation">Corporation</option>
                                                                            <option value="Defunct Corporation">Defunct Corporation</option>
                                                                            <option value="Estate">Estate</option>
                                                                            <option value="Fictitious">Fictitious</option>
                                                                            <option value="Individual">Individual</option>
                                                                            <option value="Joint Stock Company/Association">Joint Stock Company/Association</option>
                                                                            <option value="Minor">Minor</option>
                                                                            <option value="Occupant Prejudgment Claim">Occupant Prejudgment Claim</option>
                                                                            <option value="Public Entity">Public Entity</option>
                                                                            <option value="Sole Proprietorship">Sole Proprietorship</option>
                                                                            <option value="Trust">Trust</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" class="form-control" id="" placeholder="Registered Agent"/></td>
                                                                </tr> -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div id="orderdetdiv" style="display:none;">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 position-relative">
                                                                <a href="#" class="vrfy-cd" data-bs-toggle="modal" data-bs-target="#addadrmodal" data-bs-whatever="@mdo" style="padding:3px;color:green;"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                <input type="text" class="form-control" id="srchaddr" data-adrid="" placeholder="Address*" style="width:153%;"/>
                                                            </div>
                                                            <!-- ======================================================================= -->
                                                            <ul class="srchadrli" id="srchadrli" style="height:271px;overflow:auto;display:none;">
                                                                <!-- <li><a href="#" class='adrlst'>AAAAAA</a></li> -->
                                                            </ul>
                                                            <!-- ======================================================================= -->
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" id="srvbusname" placeholder="Business Name"/>
                                                        </div>
                                                        <div class="row mb-3 mt-4">
                                                            <div class="col-md-6">
                                                                <label>Time Zone</label>
                                                                <select id="srvtzone" class="form-select">
                                                                    <option value="0"> Select Time Zone </option>
                                                                    <option value="22">Eastern Standard Time</option>
                                                                    <option value="16">Central Standard Time</option>
                                                                    <option value="13">Mountain Standard Time</option>
                                                                    <option value="10">Pacific Standard Time</option>
                                                                    <option value="6">Alaskan Standard Time</option>
                                                                    <option value="4">Hawaiian Standard Time</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Hearing Date Time</label>
                                                                <input type="date" class="form-control" id="srvdate" placeholder="Hearing Date"/>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Advance Witness Fees :</label>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="witnsfee" id="witnsfeeyes" value="yes" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="witnsfeeyes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="witnsfee" id="witnsfeeno" value="no" style="appearance: auto;" checked="checked"/>
                                                                    <label class="form-check-label" for="witnsfeeno">No</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Proof : </label>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="Proof" id="prffile" value="file" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="prffile">File <span style="font-size: 11px; color: #000;">(Additional fee will apply)</span></label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="Proof" id="prfnotarize" value="notarize" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="prfnotarize">Notarize <span style="font-size: 11px; color: #000;">(Additional fee will apply)</span></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label">Special Instructions</label>
                                                                <textarea class="form-control" id="spinstr" rows="3" style="width:83%;color:black;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3" id="forallpartiesdiv" style="display:none;">
                                                        <div class="col-md-6 position-relative">
                                                            <div class="form-check">
                                                                <input class="form-check-input cmnsrvchk0" type="checkbox" name="cmnsrvchk[]" value="1" id="samedocchk" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="samedocchk">
                                                                    Check to serve all parties with the same documents.
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input cmnsrvchk1" type="checkbox" name="cmnsrvchk[]" value="1" id="sameaddrchk" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="sameaddrchk">
                                                                    Check to serve all parties at the same address.
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input cmnsrvchk2" type="checkbox" name="cmnsrvchk[]" value="1" id="allwitnsfeechk" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="allwitnsfeechk">
                                                                    Check to advance witness fees to all parties.
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr/>
                                                    <!-- <div class="container">
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                Serve at the following
                                                            </div>
                                                            <div class="col-sm">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="adrtype" id="adrres" value="res" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="adrres">Residential Address</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="adrtype" id="adrbus" value="bus" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="adrbus">Business Address</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><br/> -->
                                                    <div id="1srvadrdiv">
                                                        <div class="row">
                                                            <div class="col-sm">
                                                                Serve at the following
                                                            </div>
                                                            <div class="col-sm">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input adrtype" type="radio" name="adrtype_0" id="adrres_0" value="res" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="adrres_0">Residential Address</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input adrtype" type="radio" name="adrtype_0" id="adrbus_0" value="bus" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="adrbus_0">Business Address</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6 position-relative">
                                                                <a href="#" class="vrfy-cd addadricon" data-bs-toggle="modal" data-bs-target="#addadrmodal" data-bs-whatever="@mdo" style="padding:3px;color:green;"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                <input type="text" class="form-control srchaddr" id="srchaddr_0" data-adrid="" placeholder="Address*" style="width:153%;"/>
                                                            </div>
                                                            <!-- ======================================================================= -->
                                                            <ul class="srchadrli" id="srchadrli_0" style="height:271px;overflow:auto;display:none;">
                                                                <!-- <li><a href="#" class='adrlst'>AAAAAA</a></li> -->
                                                            </ul>
                                                            <!-- ======================================================================= -->
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control busname" id="busname_0" placeholder="Business Name"/>
                                                        </div>
                                                        <div class="row mb-3 mt-4">
                                                            <div class="col-md-6">
                                                                <label>Time Zone</label>
                                                                <select  class="form-select" id="srvtimezn_0">
                                                                    <option value="0"> Select Time Zone </option>
                                                                    <option value="22">Eastern Standard Time</option>
                                                                    <option value="16">Central Standard Time</option>
                                                                    <option value="13">Mountain Standard Time</option>
                                                                    <option value="10">Pacific Standard Time</option>
                                                                    <option value="6">Alaskan Standard Time</option>
                                                                    <option value="4">Hawaiian Standard Time</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3 hrdate">
                                                                <label>Hearing Date Time</label>
                                                                <input type="date" class="form-control" id="hrdate_0" placeholder="Hearing Date"/>
                                                            </div>
                                                            <div class="col-md-6 mb-3" style="padding-top:40px;">
                                                                <label>Advance Witness Fees :</label>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="witnsfee_0" id="yeswitnsfee_0" value="yes" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="yeswitnsfee_0">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio" name="witnsfee_0" id="nowitnsfee_0" value="no" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="nowitnsfee_0">No</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label>Proof : </label>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="prffile_0" id="prffile_0" value="file" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="prffile_0">File <span style="font-size: 11px; color: #000;">(Additional fee will apply)</span></label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" name="prfnotrz_0" id="prfnotrz_0" value="notrz" style="appearance: auto;"/>
                                                                    <label class="form-check-label" for="prfnotrz_0">Notarize</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <label class="form-label">Special Instructions</label>
                                                                <textarea class="form-control" id="spcinstr_0" rows="3" style="width:83%;color:black;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="multsrvadrdiv">
                                                        <!-- <div id="adrdiv_1">
                                                            <button class="collapsible" type="button">Documents for - defendant<span style="color:orange;float:right;">(Address required)</span></button>
                                                            <div class="content" style="margin-bottom:10px;">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6 mt-3 position-relative">
                                                                        <a href="#" class="vrfy-cd" data-bs-toggle="modal" data-bs-target="#addadrmodal" data-bs-whatever="@mdo" style="padding:3px;color:green;"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                        <input type="text" class="form-control" id="" placeholder="Address*" style="width:153%;"/>
                                                                    </div>
                                                                    <ul class="" style="height:271px;overflow:auto;display:none;">
                                                                        
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Business Name"/>
                                                                </div>
                                                                <div class="row mb-3 mt-4">
                                                                    <div class="col-md-6">
                                                                        <label>Time Zone</label>
                                                                        <select  class="form-select">
                                                                            <option value="0"> Select Time Zone </option>
                                                                            <option value="22">Eastern Standard Time</option>
                                                                            <option value="16">Central Standard Time</option>
                                                                            <option value="13">Mountain Standard Time</option>
                                                                            <option value="10">Pacific Standard Time</option>
                                                                            <option value="6">Alaskan Standard Time</option>
                                                                            <option value="4">Hawaiian Standard Time</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Hearing Date Time</label>
                                                                        <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Hearing Date"/>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Advance Witness Fees :</label>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" style="appearance: auto;"/>
                                                                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" style="appearance: auto;"/>
                                                                            <label class="form-check-label" for="inlineRadio2">No</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Proof : </label>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="inlineRadioProof" id="prffile" value="option1" style="appearance: auto;"/>
                                                                            <label class="form-check-label" for="prffile">File <span style="font-size: 11px; color: #000;">(Additional fee will apply)</span></label>
                                                                        </div>
                                                                        <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>
                                                                            <label class="form-check-label" for="prfnotrz">Notarize</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label">Special Instructions</label>
                                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" style="width:83%;color:black;"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <!-- <div class="form-group text-center mar-b-0">
                                                        <input type="button" value="BACK" class="btn btn-dark back text-white" style="background-color:#212529"/>
                                                        <input type="button" id="odrinfonext" value="NEXT" class="btn btn-primary next text-white" style="background-color:#0d6efd"/>
                                                    </div> -->
                                                </form>
                                                <hr/>
                                                <h5>Add Documents</h5>
                                                <form name="frmdocs" id="frmdocs" method="post" enctype="multipart/form-data">
                                                    <div class="col-md-12 text-center mb-3">
                                                        <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="fileup" id="rdbtnup" value="1" checked="checked" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="rdbtnup">Upload </label>
                                                        </div>
                                                        <!-- <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="fileup" id="rdbtnfax" value="2" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="rdbtnfax">Fax</label>
                                                        </div> -->
                                                        <!-- <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="fileup" id="rdbtnex" value="option2" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="rdbtnex">Existing Documents</label>
                                                        </div> -->
                                                    </div>
                                                    <div class="row" id="1prtydocdiv">
                                                        <div id="docdiv_0">
                                                            <div class="col-md-12 mb-3">
                                                                <div class="docu-line"></div>
                                                            </div>
                                                            <div class="col-md-4 text-end">
                                                                <label>Type the Document Title using:</label>
                                                            </div>
                                                            <div class="col-md-4 text-start">
                                                                <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="fltrdoctype_0" id="rdbtnstarts_0" value="start" style="appearance: auto;"/>
                                                                        <label class="form-check-label" for="rdbtnstarts_0">Starts with</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="fltrdoctype_0" id="rdbtncontains_0" value="contain" checked="checked" style="appearance: auto;"/>
                                                                        <label class="form-check-label" for="rdbtncontains_0">Contains </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 text-center"><a href="#" class="crtdefttl" id="crtdefttl_0" data-bs-toggle="modal" data-bs-target="#documentsmodal" data-bs-whatever="@fat">Court defined Document Titles</a></div>
                                                            <div class="col-md-3 text-end pt-2">
                                                                <label for="formFile" class="form-label">Document Title:</label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" class="form-control srchdocttl" id="srchdocttl_0" value="" data-ttlid="" style="width:-webkit-fill-available;"/>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="attach file btn btn-lg btn-primary" id="attach_0">
                                                                        Attach file
                                                                    <input type="file" class="attach-fld docupbtn" name="docupbtn_0" id="docupbtn_0" data-fileid=""/>
                                                                </div>
                                                                <div class="btn btn-lg btn-primary faxacptbtn" id="faxacptbtn_0" style="display:none;">
                                                                        Accept
                                                                    <input type="button" class="attach-fld" name="" id="faxaccbtn_0"/>
                                                                </div>
                                                            </div>
                                                            <ul id="docUL_0" class="srchresUL" style="height:271px;overflow:auto;display:none;">
                                                                <!-- search result doc li here -->
                                                            </ul>
                                                            <br/>
                                                            <table class="table table-borderless primary-blue tbldoctitle" id="tbldoctitle_0">
                                                                <tr>
                                                                    <th width="90%" class="">Title</th><th></th>
                                                                </tr>
                                                                <!-- <tr>
                                                                    <td class="">docname here</td><td class=""><i id="" class="fa fa-close red d-inline-block ms-2" style="cursor:pointer;"></i></td>
                                                                </tr> -->
                                                            </table>
                                                            <div id="filedata_0"></div>
                                                        </div>
                                                    </div>
                                                    <!-- ===========================collapsible div=============================== -->
                                                    <div id="multprtydocdiv">
                                                        <!-- <button class="collapsible" type="button">Documents for - defendant<span style="color:orange;float:right;">(Documents required)</span></button>
                                                        <div class="content">
                                                            <div class="row">
                                                                <div class="col-md-12 mb-3">
                                                                    <div class="docu-line"></div>
                                                                </div>
                                                                <div class="col-md-4 text-end">
                                                                    <label>Type the Document Title using:</label>
                                                                </div>
                                                                <div class="col-md-4 text-start">
                                                                    <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="doctypestart" id="rdbtnstarts" value="option2" style="appearance: auto;"/>
                                                                            <label class="form-check-label" for="rdbtnstarts">Starts with</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                            <input class="form-check-input" type="radio" name="doctypestart" id="rdbtncontains" value="option2" checked="checked" style="appearance: auto;"/>
                                                                            <label class="form-check-label" for="rdbtncontains">Contains </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 text-center"><a href="#" data-bs-toggle="modal" data-bs-target="#documentsmodal" data-bs-whatever="@fat">Court defined Document Titles</a></div>
                                                                <div class="col-md-3 text-end pt-2">
                                                                    <label for="formFile" class="form-label">Document Title:</label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" class="form-control" id="exampleInputEmail1"/>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="attach file btn btn-lg btn-primary">
                                                                            Attach file
                                                                        <input type="file" class="attach-fld" name="file"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <!-- ============================collapsible div============================== -->
                                                    <div class="mb-3" id="faxpagediv">
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label" for="rdbtnex">Total Pages of All Documents*:</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="fax1" name="faxnumrdo" value="option1" checked="checked" style="appearance:auto;"/>
                                                            <label class="form-check-label" for="fax1">1-15 </label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="fax2" name="faxnumrdo" value="option2" style="appearance: auto;"/>
                                                            <label class="form-check-label" for="fax2">16-50</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="fax3" name="faxnumrdo" value="option2" style="appearance: auto;"/>
                                                            <label class="form-check-label" for="fax3">Over 50</label>
                                                        </div>
                                                        <div style="display:flex;flex-direction:row;">
                                                            <input type="text" class="form-control" id="" name="faxnumtxt" style="width:80px;height:40px;"/>
                                                            <label class="form-check-label" style="font-size:14px;">*Estimate. Actual pages counted when faxed.</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group text-center mar-b-0 mt-3">
                                                        <input type="button" value="BACK" class="btn btn-dark back" style="background-color:#212529"/>
                                                        <input type="submit" value="NEXT" id="docnxtbtn" class="btn btn-primary next" style="background-color:#0d6efd"/>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="form-container animated border shadow p-4">
                                                <div class="container">
                                                    <div id="1ordrdetdiv" style="display:none;">
                                                        <!-- <h6 class="mb-4">When would you like this attempted?</h6>
                                                        <div class="col-lg-12 mb-3">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="inlineRadioProof" id="prffile" value="option1" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="prffile">Attempt by Tomorrow 3:00 PM for $175.00(On Demand) *</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="prfnotrz">Attempt by Tomorrow 3:00 PM for $175.00(On Demand) *</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="prfnotrz">Attempt by Tomorrow 3:00 PM for $175.00(On Demand) *</label>
                                                            </div>
                                                            <div class="form-check form-check-inline mb-4">
                                                                <input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>
                                                                <label class="form-check-label" for="prfnotrz">Attempt by Tomorrow 3:00 PM for $175.00(On Demand) *</label>
                                                            </div>
                                                            <br/>
                                                            <span class="" style="font-size: 11px; color: #000;">
                                                                * Prices listed and service times displayed are per address attempted and only an estimate based on the information provided. If you need your order processed sooner than the times listed above, please call us at (888) 962-9696.
                                                            </span>
                                                        </div> -->
                                                    </div>
                                                    <div id="multordrdetdiv" style="display:none;">
                                                        <!-- <div id="ordrdetdiv_1">
                                                            <button class="collapsible" type="button">When would you like this attempted?(name - address)</button>
                                                            <div class="content" style="margin-bottom:10px;">
                                                                <div class="col-lg-12 mb-3">
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="inlineRadioProof" id="prffile" value="option1" style="appearance: auto;"/>
                                                                        <label class="form-check-label" for="prffile">Attempt by Tomorrow 3:00 PM for $175.00(On Demand) *</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>
                                                                        <label class="form-check-label" for="prfnotrz">Attempt by Tomorrow 3:00 PM for $175.00(On Demand) *</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>
                                                                        <label class="form-check-label" for="prfnotrz">Attempt by Tomorrow 3:00 PM for $175.00(On Demand) *</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline mb-4">
                                                                        <input class="form-check-input" type="radio" name="inlineRadioProof" id="prfnotrz" value="option2" style="appearance: auto;"/>
                                                                        <label class="form-check-label" for="prfnotrz">Attempt by Tomorrow 3:00 PM for $175.00(On Demand) *</label>
                                                                    </div>
                                                                    <br/>
                                                                    <span class="" style="font-size: 11px; color: #000;">
                                                                        * Prices listed and service times displayed are per address attempted and only an estimate based on the information provided. If you need your order processed sooner than the times listed above, please call us at (888) 962-9696.
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div id="ordrdetdatadiv" style="display:none;">
                                                        <!-- data of all attempt datas displayed accordingly -->
                                                    </div>
                                                    <span style=""><strong>Notifications:</strong>Check box of person(s) you would like to notify of status updates.</span>
                                                    <div class="mb-3" style="width:100%;border:1px solid black;height:20%;overflow:auto;">
                                                        <div style="display: flex;flex-wrap:wrap;">
                                                            <xsl:for-each select="Client/Attorneys/Attorney">
                                                                <xsl:choose><xsl:when test="Attorney!='NONE'">
                                                                    <div style="padding:5px;width:200px;height:33px;margin:0;">
                                                                        <input type="checkbox" name="reqatrchk" id="{AttorneyID}/at" value="{AttorneyID}/at" data-email="{collectoremail}"/><label for="{AttorneyID}/at"><xsl:value-of select="Attorney"/></label>
                                                                    </div>
                                                                </xsl:when></xsl:choose>
                                                            </xsl:for-each>
                                                            <xsl:for-each select="Client/Secretaries/Secretary">
                                                                <xsl:choose><xsl:when test="Secretary!='NONE'">
                                                                    <div style="padding:5px;width:200px;height:33px;margin:0;">
                                                                        <input type="checkbox" name="reqatrchk" id="{SecretaryID}/req" value="{SecretaryID}/req" data-email="{Email}"/><label for="{SecretaryID}/req"><xsl:value-of select="Secretary"/></label>
                                                                    </div>
                                                                </xsl:when></xsl:choose>
                                                            </xsl:for-each>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label><strong>Internal Reference Number</strong> (Optional)</label>
                                                        <input type="text" class="form-control" id="intrefno" style="width:100%;"/>
                                                    </div>
                                                    <span class="" style="font-size: 11px; color: #000;">
                                                        By submitting this order it is understood and agreed that you are authorizing Countrywide Process, LLC to ACH debit the bank account or charge the credit card on file for the total amount of fees charged by Countrywide Process (including any statutory court or witness fees).
                                                    </span>
                                                </div>
                                                <div class="form-group text-center mar-b-0">
                                                    <input type="button" value="BACK" class="btn btn-dark back" style="background-color:#212529"/>
                                                    <input type="submit" id="casesubmitbtn" value="SUBMIT" class="btn btn-primary submit" style="background-color:#0d6efd"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- add atorney/requestor Modal -->
<div class="modal fade" id="addattrny" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:white !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black !important;">Add Attorney/Requestor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="addatrnyerr" style="color:red;"></p>
                <form>
                    <div class="mb-3">
                        <select id="slctreqatr" class="form-select" style="color:black !important;">
                            <option selected="" value="" style="color:black !important;"> ..Select.. </option>
                            <option value="atr" style="color:black !important;">Attorney</option>      
                            <option value="req" style="color:black !important;">Requestor</option>
                        </select>
                    </div>
                    <div id="attorneydiv">
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="attrnyname" placeholder="Name"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="attrnybarid" placeholder="Bar ID"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="attrnyemail" placeholder="Email"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="attrnyaddress" placeholder="Address"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="attrnycity" placeholder="City"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="attrnystate" placeholder="State"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="attrnyzip" placeholder="Zip"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="attrnyphone" placeholder="Phone"/>
                        </div>
                    </div>

                    <div id="requestordiv">
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="reqname" placeholder="Name"/>
                        </div>
                        <div class="mb-3">
                            <input type="text" style="color:black !important;" class="form-control" id="reqemail" placeholder="Email"/>
                        </div>
                    </div>

                    <div class="mb-3">
                        <input type="button" style="background-color:#0d6efd;color:white !important;" class="form-control" id="addmembbtn" placeholder="Bar ID" value="Add"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- add address Modal -->
<div class="modal fade" id="addadrmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color:white !important;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black !important;">Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <p style="color:black !important;">The address you entered cannot be validated. Please re-enter below</p> -->
                <p id="addadrerr" style="color:red;"></p>
                <form>
                    <!-- <div class="mb-3">
                        <select  class="form-select" name="newadrtype" style="color:black !important;">
                            <option selected="" value="" style="color:black !important;"> Address Type </option>
                            <option value="buss" style="color:black !important;">Business</option>      
                            <option value="resi" style="color:black !important;">Residence</option>
                        </select>
                    </div> -->
                    <div class="mb-3">
                        <input type="text" name="newadr" class="form-control" id="newadr" placeholder="Address"/>
                    </div>
                    <div class="mb-3">
                            <input type="text" name="newadrunit" class="form-control" id="newadrunit" placeholder="Unit or Suite (Optional)"/>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="newcity" class="form-control" id="newcity" placeholder="City"/>
                    </div>
                    <div class="mb-3">
                            <select  class="form-select" name="newstate" id="newstate" style="color:black !important;">
                            <option value=""> State </option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District Of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option>  <option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>
                        </select>
                    </div>
                    <div class="mb-3">
                            <input type="text" name="newzip" class="form-control" id="newzip" placeholder="ZipCode"/>
                    </div>
                    <!-- <div class="mb-3">
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Business Name"/>
                    </div> -->
                    <div class="text-center">
                            <input type="button" id="adadrbtn" value="Add" class="btn btn-primary Ok text-white vrfyBtn"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- add party Modal -->
<!-- <div class="modal fade lg" id="addprtymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color:white !important;width:100%;">
            <div class="modal-header">
                <h5 class="modal-title w-100 d-block text-center" style="font-size:16px;color:black;">Add Party</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="mb-3">
                <div class="" style="display:flex;flex-direction:row;justify-content: center;width: 100%;">
                    <div class="" style="margin:0 5% 0 5%;">
                        <input type="radio" id="prtyserv" name="whoradio" value="serv" style="color:black !important;"/>
                        <label class="form-check-label" for="prtyserv" style="color:black !important;">choose from servee</label>
                    </div>
                    <div class="" style="margin:0 5% 0 5%;">
                        <input type="radio" id="prtyorg" name="whoradio" value="org" style="color:black !important;"/>
                        <label class="form-check-label" for="prtyorg" style="color:black !important;">Organisation</label>
                    </div>
                    <div class="" style="margin:0 5% 0 5%;">
                        <input type="radio" id="prtypers" name="whoradio" value="per" checked="checked" style="color:black !important;"/>
                        <label class="form-check-label" for="prtypers" style="color:black !important;">Person</label>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row mb-3" style="margin-left:30px;">
                    <span id="addprtyerr" style="color:red;font-size:14px;"></span>
                    <div class="col-md-2 mb-3 px-1">
                        <label class="d-inline-block" style="color:black !important;">Role:*</label>
                    </div>
                    <div class="col-md-10 mb-3 px-1">
                        <select class="form-select d-inline-block" id="prtyrole" style="color:black !important;">
                            <option value="">Select...</option>
                            <option value="APP">Appellant</option>
                            <option value="CLT">Claimant</option>
                            <option value="CCT">Cross-Complainant</option>
                            <option value="CDT">Cross-Defendant</option>
                            <option value="DFN">Defendant</option>
                            <option value="GALM">Guardian Ad Litem</option>
                            <option value="INV">Intervenor</option>
                            <option value="JCR">Judgment Creditor</option>
                            <option value="JDR">Judgment Debtor</option>
                            <option value="NPR">Non-Party</option>
                            <option value="PET">Petitioner</option>
                            <option value="PLN">Plaintiff</option>
                            <option value="RPI">Real Parties in Interest</option>
                            <option value="RER">Requester</option>
                            <option value="RSP">Respondent</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="d-inline-block" style="color:black !important;">Name:*</label>
                    </div>
                    <div class="col-md-10 mb-3">
                        <div class="row">
                            <div class="col-md-3 px-1" id="srvprtydiv" style="display:none;">
                                <select class="form-select sfl-fld" id="srvprtyslct" style="color:black !important;">
                                </select>
                            </div>
                            <div class="col-md-3 px-1">
                                <input type="text" class="form-control" id="prtyfname" placeholder="First Name" style="color:black !important;"/>
                            </div>
                            <div class="col-md-3 px-1">
                                <input type="text" class="form-control" id="prtymname" placeholder="Middle Name" style="color:black !important;"/>
                            </div>
                            <div class="col-md-3 px-1">
                                <input type="text" class="form-control" id="prtylname" placeholder="Last Name" style="color:black !important;"/>
                            </div>
                            <div class="col-md-3 px-1" id="prtysfx">
                                <label class="sfl" style="color:black !important;">Suffix:</label>
                                <select class="form-select sfl-fld" id="prtysuffx" style="color:black !important;">
                                    <option value="0">Select</option>
                                    <option value="1">Jr.</option>
                                    <option value="2">Sr.</option>
                                    <option value="3">II</option>
                                    <option value="4">III</option>
                                    <option value="5">IV</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3 leadclntdiv">
                        <label style="color:black !important;">Is this your Lead Client ?</label>
                    </div>
                    <div class="col-md-10 mb-3 leadclntdiv">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="prtyledcln" id="leadyes" value="1"/>
                            <label class="form-check-label" for="leadyes" style="color:black !important;">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="prtyledcln" id="leadno" value="0" checked="checked"/>
                            <label class="form-check-label" for="leadno" style="color:black !important;">No</label>
                        </div>
                    </div>
                    <div class="leadclntdiv" id="prtybill" style="display:none;">
                        <div class="col-md-2 mb-3 px-1">
                            <label style="color:black !important;">Billing Code:</label>
                        </div>
                        <div class="col-md-10 mb-3 px-1">
                            <input type="text" class="form-control" id="prtybillcode"/>
                        </div>
                    </div>
                    <div class="form-group text-center mar-b-0">
                        <input type="button" id="editprtybtn" value="SAVE" class="btn btn-dark back text-white"/>
                        <input type="button" id="ldprtyprtybtn" value="SAVE" class="btn btn-dark back text-white" style="display:none;"/>
                        <input type="button" id="prtycancel" value="CANCEL" data-bs-dismiss="modal" class="btn btn-primary next text-white"/>
                        <input type="button" id="ldprtycancel" value="CANCEL" data-bs-dismiss="modal" class="btn btn-primary next text-white" style="display:none;"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<!-- == court docs type modal== -->
<div class="modal fade" id="documentsmodal" tabindex="-1" aria-labelledby="documentsmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-100 d-block text-center" id="documentsmodalLabel" style="font-size:15px;">Pre-defined Court Documents</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-3 mb-3">Title:</div>
                        <div class="col-md-9 mb-3">
                            <select class="form-select" id="doctpslct">
                                <!-- <option value="">...Select...</option>
                                <option value="Affidavits/Proofs of Service">Affidavits/Proofs of Service</option>
                                <option value="Alternative Dispute Resolution (ADR)">Alternative Dispute Resolution (ADR)</option>
                                <option value="Case Initiation">Case Initiation</option>
                                <option value="Case Management">Case Management</option>
                                <option value="Complaints / Petitions">Complaints / Petitions</option>
                                <option value="Cover Sheets">Cover Sheets</option>
                                <option value="Declarations/Affidavits/Statements">Declarations/Affidavits/Statements</option>
                                <option value="Declarations/Notices">Declarations/Notices</option>
                                <option value="Enforcement Of Judgment">Enforcement Of Judgment</option>
                                <option value="Exhibits, Briefs, Receipts">Exhibits, Briefs, Receipts</option>
                                <option value="Family Law Documents">Family Law Documents</option>
                                <option value="Landlord / Tenant">Landlord / Tenant</option>
                                <option value="Misc.">Misc.</option>
                                <option value="Motions">Motions</option>
                                <option value="Notices">Notices</option>
                                <option value="Oppositions/Reply's/Objections">Oppositions/Reply's/Objections</option>
                                <option value="Orders">Orders</option>
                                <option value="Post Judgment">Post Judgment</option>
                                <option value="Probate">Probate</option><option value="Requests">Requests</option>
                                <option value="Small Claims">Small Claims</option>
                                <option value="Subpoena">Subpoena</option>
                                <option value="Subpoena's">Subpoena's</option>
                                <option value="Summons">Summons</option>
                                <option value="User Defined Title">User Defined Title</option>
                                <option value="Workers' Compensation">Workers' Compensation</option> -->
                            </select>
                        </div>
                        <!-- <div class="col-md-3 mb-3">Titles:</div>
                        <div class="col-md-9 mb-3">
                            <select class="form-select" id="">
                                <option value="Select...">Select...</option>
                            </select>
                        </div> -->
                        <div class="text-center">
                            <div class="form-group text-center mar-b-0">
                                <input type="button" id="doctypebtn" value="SAVE" class="btn btn-dark back text-white"/>
                                <input type="button" value="CANCEL" data-bs-dismiss="modal" class="btn btn-primary next text-white"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
</xsl:template>
</xsl:stylesheet>