@extends('commons.header')
@section('content')
    <!-- -->
    <input type="hidden" id="session-data" value="{{ session('step3') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="content-wrapper place_order">
        <div class="row">
            <div class="col-md-2 px-0">
                <!-- Tabs nav -->
                <div class="nav flex-column nav-pills nav-pills-custom p-2" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    <a class="nav-link {{ $step == 1 ? 'active' : '' }}" id="step1s" href="#step1" 
                        role="tab" aria-controls="v-pills-profile" aria-selected="false">
                        <span class="font-weight-bold small text-uppercase">CASE INFO</span>
                    </a>
                    <a class="nav-link {{ $step == 2 ? 'active' : '' }}" id="step2s" href="#step2" 
                        role="tab" aria-controls="v-pills-messages" aria-selected="false">
                        <span class="font-weight-bold small text-uppercase">CASE PARTICIPANTS</span>
                    </a>
                    <a class="nav-link {{ $step == 3 ? 'active' : '' }}" id="step3s" href="#step3" 
                        role="tab" aria-controls="v-pills-settings" aria-selected="false">
                        <span class="font-weight-bold small text-uppercase">DOCUMENTS</span>
                    </a>
                    <a class="nav-link {{ $step == 4 ? 'active' : '' }}" id="step4s" href="#step4" 
                        role="tab" aria-controls="v-serve-settings" aria-selected="false">
                        <span class="font-weight-bold small text-uppercase">SERVE INFO</span>
                    </a>
                    <a class="nav-link {{ $step == 5 ? 'active' : '' }}" id="step5s" href="#step5" 
                        role="tab" aria-controls="v-details-settings" aria-selected="false">
                        <span class="font-weight-bold small text-uppercase">ORDER DETAILS</span>
                    </a>
                </div>
            </div>
            <div class="col-md-10 p-2">
                <!-- Tabs content -->
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade bg-white bg-sdw py-2 {{ $step == 1 ? 'active show' : '' }}" id="step1"
                        role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <form method="POST" id="case_form">
                            <div class="bxptyrtmain">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hdnngprt text-center">
                                            <h3>Case Info</h3>
                                            <a href="{{ route('reset_order') }}">Reset Order</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="case-number">Case Number :</label>
                                            <input type="text" class="form-control" id="c_num" name="c_num"
                                                placeholder="Case Number" value="<?php echo isset($ca) ? $ca->case_no : ''; ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label for="case-number">Case Title :</label>
                                                    <input type="text" class="form-control" name="c_ti" id="c_ti"
                                                        placeholder="Case Title" <?php echo isset($ca) ? 'disabled' : ''; ?>
                                                        value="<?php echo isset($ca) ? $ca->case_title : ''; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="case-number">Jurisdiction :</label>
                                                    <div id="c_ju">
                                                        <select required class=" form-control jur_select"
                                                            <?php echo null !== session('case_id') ? 'disabled' : ''; ?> name="c_ju">
                                                            <option value="default">Select...</option>
                                                            @foreach ($jur as $item)
                                                                @if (isset($ca))
                                                                    @if ($ca->jurisdiction == $item->court_name)
                                                                        <option selected value="{{ $item->court_name }}">
                                                                            {{ $item->court_name }}
                                                                        </option>
                                                                    @else
                                                                        <option value="{{ $item->court_name }}">
                                                                            {{ $item->court_name }}
                                                                        </option>
                                                                    @endif
                                                                @else
                                                                    <option value="{{ $item->court_name }}">
                                                                        {{ $item->court_name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div id="c_juii" style="display: none">
                                                        <input type="text" class="form-control" id="c_jui"
                                                            placeholder="Jurisdicton" readonly>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class=" table-responsive">
                                <table class="table">
                                    <thead class="txtryt text-capitalize">
                                        <tr>
                                            <th>
                                                <h4>Proof of Service Information</h4>
                                            </th>
                                            <th width="5%">
                                                <div class="btnsct">
                                                    <a href="javascript:void(0)" class="pencl" onclick="attorney()"><i
                                                            class="fa fa-plus m-0" aria-hidden="true"></i></a>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            <div class="bxptyrtmain">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mt-2 mb-4">
                                            <select required class="form-control" name="c_at" id="att_select">
                                                <option value="">Select...</option>
                                                @foreach ($att as $item)
                                                    @if (isset($ca))
                                                        @if ($ca->attorney == $item->name)
                                                            <option selected value="{{ $item->name }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @else
                                                            <option value="{{ $item->name }}">
                                                                {{ $item->name }}
                                                            </option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $item->name }}">
                                                            {{ $item->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="cntnsecty">
                                            <input type="hidden" id="selected-attorney"
                                                value="{{ isset($ca_at) ? $ca_at->id : '' }}">
                                            <ul id="attorney-info-list">
                                                <li class="listhdng">Attorney Name & Bar ID:</li>
                                                @if (isset($ca_at->b_id))
                                                    <li id="s_bid">{{ $ca_at->name }}&nbsp;{{ $ca_at->b_id }}</li>
                                                @else
                                                    <li id="s_bid">-</li>
                                                @endif
                                                <li class="listhdng">Firm Name:</li>
                                                @if (isset($ca_at->firm_name))
                                                    <li id="s_afm">{{ $ca_at->firm_name }}</li>
                                                @else
                                                    {{-- Law Office of Joseph Trenk --}}
                                                    <li id="s_afm">-</li>
                                                @endif
                                                <li class="listhdng">Firm Address:</li>
                                                @if (isset($ca_at->street_address))
                                                    <li id="s_fa">{{ $ca_at->street_address }}</li>
                                                @else
                                                    {{-- Street Address1 --}}
                                                    <li id="s_fa">-</li>
                                                @endif
                                                <li class="listhdng">City, State, Zip Code:</li>
                                                @if (isset($ca_at->city_state_zip))
                                                    <li id="s_csz"> {{ $ca_at->city_state_zip }}</li>
                                                @else
                                                    {{-- City, State, Zip --}}
                                                    <li id="s_csz">-</li>
                                                @endif
                                                <li class="listhdng">Email :</li>
                                                @if (isset($ca_at->email))
                                                    <li id="s_em">{{ $ca_at->email }}</li>
                                                @else
                                                    <li id="s_em">-</li>
                                                @endif
                                                <li class="listhdng">Phone :</li>
                                                @if (isset($ca_at->phone))
                                                    <li id="s_ph">{{ $ca_at->phone }}</li>
                                                @else
                                                    <li id="s_ph">-</li>
                                                @endif
                                            </ul>

                                            <div
                                                class="form-group modify-attorney-wrapper mt-3 justify-content-between {{ empty($ca_at) ? 'd-none' : 'd-flex' }}">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input ml-0"
                                                        id="modify-attorney">
                                                    <label class="form-check-label ml-4 mb-0" for="modify-attorney">Click
                                                        here to override Proof of Service Information</label>
                                                </div>
                                                <button type="button" class="btn btn-primary ml-2 d-none"
                                                    id="update-attorney">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bxptyrtmain">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="formprt p-0 mb-3">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <button type="submit" class="ptrbtn" id="step-1-save-btn">Save &
                                                        Next</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade bg-white py-2 {{ $step == 2 ? 'active show' : '' }}" id="step2"
                        role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        <div class="bxptyrtmain">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hdnngprt text-center">
                                        <h3>Case Participants</h3>
                                        <a href="{{ route('reset_order') }}">Reset Order</a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="m-0 py-3">Click here to add Case Participants if not already listed below:</h5>
                                <div class="btnprt">
                                    <button type="button" class="ptrbtn" data-toggle="modal" data-target="#addparty">
                                        Add Party(s)
                                    </button>
                                    <!-- add party modal -->
                                    <div class="modal modalprtcstm fade" id="addparty" data-bs-keyboard="false"
                                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <form id="add_party_form" method="post">
                                            @csrf

                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-center" id="exampleModalLabel">Add
                                                            Party</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="formprt brdrrbtm text-center mb-3">

                                                                    <label class="radio-inline mr-3">
                                                                        <input type="radio" class="mr-1"
                                                                            name="p_type"
                                                                            onclick="addPartyModalChange('org')"
                                                                            value="organization"
                                                                            id="p_type">Organization
                                                                    </label>
                                                                    <label class="radio-inline mr-3">
                                                                        <input type="radio" class="mr-1"
                                                                            name="p_type"
                                                                            onclick="addPartyModalChange('person')"
                                                                            value="person" checked id="p_type_p">Person
                                                                    </label>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="formprt mb-3">
                                                                    <label for="timezone">Role :</label>
                                                                    <select class="form-control" name="p_role"
                                                                        id="p_role">
                                                                        <option value="">Select...</option>
                                                                        <option value="Appellant">Appellant</option>
                                                                        <option value="Claimant">Claimant</option>
                                                                        <option value="Cross-Complainant">Cross-Complainant
                                                                        </option>
                                                                        <option value="Cross-Defendant">Cross-Defendant
                                                                        </option>
                                                                        <option value="Defendant">Defendant</option>
                                                                        <option value="Guardian Ad Litem">Guardian Ad Litem
                                                                        </option>
                                                                        <option value="Intervenor">Intervenor</option>
                                                                        <option value="Judgment Creditor">Judgment Creditor
                                                                        </option>
                                                                        <option value="Judgment Debtor">Judgment Debtor
                                                                        </option>
                                                                        <option value="Non-Party">Non-Party</option>
                                                                        <option value="Petitioner">Petitioner</option>
                                                                        <option value="Plaintiff">Plaintiff</option>
                                                                        <option value="Real Parties in Interest">Real
                                                                            Parties in Interest</option>
                                                                        <option value="Requester">Requester</option>
                                                                        <option value="Respondent">Respondent</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" id="party_modal_org_fname"
                                                                style="display: block;">
                                                                <div class="formprt mb-3">
                                                                    <label for="fmname">First Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="p_fname" name="p_fname"
                                                                        placeholder="First Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" id="party_modal_org_mid_name"
                                                                style="display: block;">
                                                                <div class="formprt mb-3">
                                                                    <label for="midname">Middle Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="p_mname" name="p_mname"
                                                                        placeholder="Middle Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6" id="party_modal_org_last_name"
                                                                style="display: block;">
                                                                <div class="formprt mb-3">
                                                                    <label for="lastname">Last Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="p_lname" name="p_lname"
                                                                        placeholder="Last Name">
                                                                </div>
                                                            </div>

                                                            <!-- name for org -->
                                                            <div class="col-md-12" id="party_modal_org_name"
                                                                style="display: none;">
                                                                <div class="formprt mb-3">
                                                                    <label for="org_name">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="org_name" name="org_name"
                                                                        placeholder="Name">
                                                                </div>
                                                            </div>


                                                            <div class="col-md-6" id="party_modal_org_suffix"
                                                                style="display: block;">
                                                                <div class="formprt mb-3">
                                                                    <label for="Suffix">Suffix</label>
                                                                    <select class="form-control" name="p_sfx"
                                                                        id="p_sfx">
                                                                        <option value="default">Default</option>
                                                                        <option value="Jr.">Jr.</option>
                                                                        <option value="Sr.">Sr.</option>
                                                                        <option value="II">II</option>
                                                                        <option value="III">III</option>
                                                                        <option value="IV">IV</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="formprt">
                                                                    <div class="d-inline-block mr-1">
                                                                        <p>
                                                                            Is this your Lead Client ?
                                                                        </p>
                                                                    </div>
                                                                    <div class="d-inline-block">

                                                                        <label class="radio-inline mr-3">
                                                                            <input type="radio" class="mr-1"
                                                                                name="p_lclient" id="p_lclient"
                                                                                value="yes"
                                                                                onclick="addPartyLeadClient('yes')">Yes
                                                                        </label>
                                                                        <label class="radio-inline mr-3">
                                                                            <input type="radio" class="mr-1"
                                                                                value="no" name="p_lclient"
                                                                                id="p_lclient_no"
                                                                                onclick="addPartyLeadClient('no')"
                                                                                checked>No
                                                                        </label>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12" id="party_modal_billing_code"
                                                                style="display: none;">
                                                                <div class="formprt mb-3">
                                                                    <label for="billing_code">Billing Code</label>
                                                                    <input type="text" class="form-control"
                                                                        id="p_bcode" name="p_bcode"
                                                                        placeholder="Billing Code">
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" value="Save" class="ptrbtn mr-3">
                                                        <button type="button" class="ptrbtn"
                                                            onclick="resetModalFields();">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end modal -->
                                    <!-- edit Person party modal -->
                                    <div class="modal modalprtcstm fade" id="editpartyp" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <form id="edit_party_formp" method="post">
                                            @csrf
                                            <input type="hidden" id="pe_id" name="pe_id" value="">
                                            <input type="hidden" name="pe_type" value="person">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-center" id="exampleModalLabel">Edit
                                                            Party</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="formprt mb-3">
                                                                    <label for="timezone">Role :</label>
                                                                    <select class="form-control" name="pe_role"
                                                                        id="pe_role">
                                                                        <option value="default">Select...</option>
                                                                        <option value="Appellant">Appellant</option>
                                                                        <option value="Claimant">Claimant</option>
                                                                        <option value="Cross-Complainant">Cross-Complainant
                                                                        </option>
                                                                        <option value="Cross-Defendant">Cross-Defendant
                                                                        </option>
                                                                        <option value="Defendant">Defendant</option>
                                                                        <option value="Guardian Ad Litem">Guardian Ad Litem
                                                                        </option>
                                                                        <option value="Intervenor">Intervenor</option>
                                                                        <option value="Judgment Creditor">Judgment Creditor
                                                                        </option>
                                                                        <option value="Judgment Debtor">Judgment Debtor
                                                                        </option>
                                                                        <option value="Non-Party">Non-Party</option>
                                                                        <option value="Petitioner">Petitioner</option>
                                                                        <option value="Plaintiff">Plaintiff</option>
                                                                        <option value="Real Parties in Interest">Real
                                                                            Parties in Interest</option>
                                                                        <option value="Requester">Requester</option>
                                                                        <option value="Respondent">Respondent</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" id="pparty_modal_name"
                                                                style="display: block;">
                                                                <div class="formprt mb-3">
                                                                    <label for="fmname">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="pe_name" name="pe_name" placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12" id="pparty_modal_org_suffix"
                                                                style="display: block;">
                                                                <div class="formprt mb-3">
                                                                    <label for="Suffix">Suffix</label>
                                                                    <select class="form-control" name="pe_sfx"
                                                                        id="pe_sfx">
                                                                        <option value="default">Default</option>
                                                                        <option value="Jr.">Jr.</option>
                                                                        <option value="Sr.">Sr.</option>
                                                                        <option value="II">II</option>
                                                                        <option value="III">III</option>
                                                                        <option value="IV">IV</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="formprt">
                                                                    <div class="d-inline-block mr-1">
                                                                        <p>
                                                                            Is this your Lead Client ?
                                                                        </p>
                                                                    </div>
                                                                    <div class="d-inline-block">

                                                                        <label class="radio-inline mr-3">
                                                                            <input type="radio" class="mr-1"
                                                                                name="pe_lclient" id="pe_lclient"
                                                                                value="yes"
                                                                                onclick="editPartyLeadClient('yes')">Yes
                                                                        </label>
                                                                        <label class="radio-inline mr-3">
                                                                            <input type="radio" class="mr-1"
                                                                                value="no" name="pe_lclient"
                                                                                id="pe_lclient"
                                                                                onclick="editPartyLeadClient('no')"
                                                                                checked>No
                                                                        </label>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12" id="pparty_modal_billing_code"
                                                                style="display: none;">
                                                                <div class="formprt mb-3">
                                                                    <label for="billing_code">Billing Code</label>
                                                                    <input type="text" class="form-control"
                                                                        id="pep_bcode" name="pe_bcode"
                                                                        placeholder="Billing Code">
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" value="Save" class="ptrbtn mr-3">
                                                        <button type="button" class="ptrbtn"
                                                            data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end modal -->
                                    <!-- edit Person party modal -->
                                    <div class="modal modalprtcstm fade" id="editpartyo" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <form id="edit_party_formo" method="post">
                                            @csrf
                                            <input type="hidden" id="po_id" name="pe_id" value="">
                                            <input type="hidden" name="pe_type" value="organization">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-center" id="exampleModalLabel">Edit
                                                            Party</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="formprt mb-3">
                                                                    <label for="timezone">Role :</label>
                                                                    <select class="form-control" name="pe_role"
                                                                        id="pe_role">
                                                                        <option value="default">Select...</option>
                                                                        <option value="Appellant">Appellant</option>
                                                                        <option value="Claimant">Claimant</option>
                                                                        <option value="Cross-Complainant">Cross-Complainant
                                                                        </option>
                                                                        <option value="Cross-Defendant">Cross-Defendant
                                                                        </option>
                                                                        <option value="Defendant">Defendant</option>
                                                                        <option value="Guardian Ad Litem">Guardian Ad Litem
                                                                        </option>
                                                                        <option value="Intervenor">Intervenor</option>
                                                                        <option value="Judgment Creditor">Judgment Creditor
                                                                        </option>
                                                                        <option value="Judgment Debtor">Judgment Debtor
                                                                        </option>
                                                                        <option value="Non-Party">Non-Party</option>
                                                                        <option value="Petitioner">Petitioner</option>
                                                                        <option value="Plaintiff">Plaintiff</option>
                                                                        <option value="Real Parties in Interest">Real
                                                                            Parties in Interest</option>
                                                                        <option value="Requester">Requester</option>
                                                                        <option value="Respondent">Respondent</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- name for org -->
                                                            <div class="col-md-12" id="party_modal_org_name">
                                                                <div class="formprt mb-3">
                                                                    <label for="org_name">Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="pe_nam" name="pe_name" placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="formprt">
                                                                    <div class="d-inline-block mr-1">
                                                                        <p>
                                                                            Is this your Lead Client ?
                                                                        </p>
                                                                    </div>
                                                                    <div class="d-inline-block">

                                                                        <label class="radio-inline mr-3">
                                                                            <input type="radio" class="mr-1"
                                                                                name="pe_lclient" id="pe_lclient"
                                                                                value="yes"
                                                                                onclick="editPartyLeadCliento('yes')">Yes
                                                                        </label>
                                                                        <label class="radio-inline mr-3">
                                                                            <input type="radio" class="mr-1"
                                                                                value="no" name="pe_lclient"
                                                                                id="pe_lclient"
                                                                                onclick="editPartyLeadCliento('no')"
                                                                                checked>No
                                                                        </label>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12" id="ppparty_modal_billing_code"
                                                                style="display: none;">
                                                                <div class="formprt mb-3">
                                                                    <label for="billing_code">Billing Code</label>
                                                                    <input type="text" class="form-control"
                                                                        id="pe_bcode" name="pe_bcode"
                                                                        placeholder="Billing Code">
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="submit" value="Save" class="ptrbtn mr-3">
                                                        <button type="button" class="ptrbtn"
                                                            data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end modal -->
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="txtryt">
                                    <tr class="text-center">
                                        <th class="col-1">Lead Client</th>
                                        <th class="col-5">Name</th>
                                        <th class="col-4">Role</th>
                                        <th class="col-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="party_tbody">
                                    @if (count($parties) > 0)
                                        @foreach ($parties as $item)
                                            <tr class="brdrrbtm text-center" id="pa_{{ $item->id }}">
                                                <td>
                                                    @if (isset($orderInfo) && $orderInfo->l_client == $item->id)
                                                        <input type="checkbox"
                                                            onclick="leadClientChange(this, event, {{ $item->id }})"
                                                            disabled checked>
                                                    @else
                                                        <input type="checkbox"
                                                            onclick="leadClientChange(this, event, {{ $item->id }})">
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $item->name }}
                                                </td>
                                                <td>
                                                    {{ $item->role }}
                                                </td>
                                                <td>
                                                    @if ($item->order_id == session('order_id'))
                                                        <div class="btnsct">
                                                            <a href="javascript:void(0)"
                                                                onclick="edit_party({{ $item->id }})"
                                                                class="pencl"><i class="fa fa-pencil"
                                                                    aria-hidden="true"></i></a>
                                                            <a href="javascript:void(0)" class="crss"
                                                                onclick="del_party({{ $item->id }})"><i
                                                                    class="fa fa-times" aria-hidden="true"></i></a>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr id="no_pa">
                                            <td colspan="4" class="text-center">
                                                There are no Case Participants entered
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="bxptyrt ">
                            <div class="d-inline-block mr-2">
                                <h6>Select number of Party(s) to Serve:</h6>
                            </div>
                            <div class="d-inline-block mr-2">
                                <select class="form-control" id="no_of_party">
                                    <option value="-" selected>Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
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
                            <div class="d-inline-block">
                                <p> (for more than 15 Party(s), please place multiple orders)</p>
                            </div>
                        </div>
                        <!-- edit Person party modal -->
                        <div class="modal modalprtcstm fade" id="add_free_serve" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <form id="add_free_serve_form" method="post">
                                @csrf
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">Add Free Serve</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="formprt mb-3">
                                                        <label>Party to Serve</label>
                                                        <input type="text" id="add-free-serve-form-input"
                                                            name="party" required placeholder="Enter Serve Name"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="submit" value="Save" id="save_free" class="ptrbtn mr-3">
                                            <button type="button" class="ptrbtn" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- end modal -->
                        <form id="serve_form" method="post">
                            @csrf
                            <div class="d-flex">
                                <div class="table-responsive ">
                                    <table class="table">
                                        <thead class="txtryt text-capitalize">
                                            <tr>
                                                <th class="col-5">Party(s) To Serve*</th>
                                                <th class="col-3">Role</th>
                                                <th class="col-3">Registered Agent</th>
                                                <th class="col-1" width="5%">
                                                    {{-- <div class="btnsct">
                                                        <a href="javascript:void(0)" class="pencl"
                                                            onclick="add_free_serve()"><i class="fa fa-plus m-0"
                                                                aria-hidden="true"></i></a>
                                                    </div> --}}
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody id="serve_table">
                                            @if (isset($serve[0]))
                                                @foreach ($serve as $key => $item)
                                                    @php
                                                        $str = 'Registered Agent';

                                                        switch ($item->role) {
                                                            case 'Authorized Person':
                                                            case 'Individual':
                                                                $str = 'Not Mandatory';
                                                                break;
                                                            case 'Association or Partnership':
                                                            case 'Joint Stock Company/Association':
                                                            case 'Corporation':
                                                                $str = 'Registered Agent';
                                                                break;
                                                            case 'Public Entity':
                                                            case 'Business Organization, Form Unknown':
                                                            case 'Fictitious':
                                                            case 'Sole Proprietorship':
                                                                $str = 'Person Autorized';
                                                                break;
                                                            case 'Estate':
                                                                $str = 'The executor or administrator of the Estate.';
                                                                break;
                                                            case 'Trust':
                                                                $str = 'Name of trustee.';
                                                                break;
                                                            case 'Defunct Corporation':
                                                                $str = 'State Official/Person Authorized';
                                                                break;
                                                            case 'Minor':
                                                                $str = 'Parent of legal guardian.';
                                                                break;
                                                            default:
                                                                break;
                                                        }

                                                    @endphp
                                                    <tr id="serve_row_{{ $key }}">
                                                        <input type="hidden" name="order_id"
                                                            value="{{ session('order_id') }}">
                                                        <td class='col-5'>
                                                            <select
                                                                onChange='addNewPartyToServe(this ,{{ $key }})'
                                                                class="form-control serve-party-name" name="party[]">
                                                                <option value="-">Select...</option>
                                                                {{-- <option value="new">New</option> --}}
                                                                @foreach ($par as $pars)
                                                                    {{-- @php var_dump($item->p_t_serve, session('order_id'));exit; @endphp --}}
                                                                    <option
                                                                        {{ $pars->name == $item->p_t_serve ? 'selected' : '' }}
                                                                        value="{{ $pars->name }}">
                                                                        {{ $pars->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class='col-3'>
                                                            <select class="form-control role-select"
                                                                onchange="roleChangeUpdate(this)" name="role[]">
                                                                <option value="-">Select...</option>
                                                                <option <?php if ($item->role == 'Association or Partnership') {
                                                                    echo 'selected';
                                                                } ?>
                                                                    value="Association or Partnership">
                                                                    Association or
                                                                    Partnership
                                                                </option>
                                                                <option <?php if ($item->role == 'Authorized Person') {
                                                                    echo 'selected';
                                                                } ?> value="Authorized Person">
                                                                    Authorized
                                                                    Person</option>
                                                                <option <?php if ($item->role == 'Business Organization, Form Unknown') {
                                                                    echo 'selected';
                                                                } ?>
                                                                    value="Business Organization, Form Unknown">
                                                                    Business
                                                                    Organization, Form Unknown</option>
                                                                <option <?php if ($item->role == 'Corporation') {
                                                                    echo 'selected';
                                                                } ?> value="Corporation">
                                                                    Corporation
                                                                </option>
                                                                <option <?php if ($item->role == 'Defunct Corporation') {
                                                                    echo 'selected';
                                                                } ?> value="Defunct Corporation">
                                                                    Defunct
                                                                    Corporation </option>
                                                                <option <?php if ($item->role == 'Estate') {
                                                                    echo 'selected';
                                                                } ?> value="Estate">Estate
                                                                </option>
                                                                <option <?php if ($item->role == 'Fictitious') {
                                                                    echo 'selected';
                                                                } ?> value="Fictitious">
                                                                    Fictitious
                                                                </option>
                                                                <option <?php if ($item->role == 'Individual') {
                                                                    echo 'selected';
                                                                } ?> value="Individual">
                                                                    Individual
                                                                </option>
                                                                <option <?php if ($item->role == 'Joint Stock Company/Association') {
                                                                    echo 'selected';
                                                                } ?>
                                                                    value="Joint Stock Company/Association">Joint Stock
                                                                    Company/Association</option>
                                                                <option <?php if ($item->role == 'Minor') {
                                                                    echo 'selected';
                                                                } ?> value="Minor">Minor
                                                                </option>
                                                                <option <?php if ($item->role == 'Occupant Prejudgment Claim') {
                                                                    echo 'selected';
                                                                } ?>
                                                                    value="Occupant Prejudgment Claim">Occupant
                                                                    Prejudgment
                                                                    Claim
                                                                </option>
                                                                <option <?php if ($item->role == 'Public Entity') {
                                                                    echo 'selected';
                                                                } ?> value="Public Entity">
                                                                    Public
                                                                    Entity</option>
                                                                <option <?php if ($item->role == 'Sole Proprietorship') {
                                                                    echo 'selected';
                                                                } ?> value="Sole Proprietorship">
                                                                    Sole
                                                                    Proprietorship
                                                                </option>
                                                                <option <?php if ($item->role == 'Trust') {
                                                                    echo 'selected';
                                                                } ?> value="Trust">Trust
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td class='col-3'>
                                                            <input type="text" class="form-control" name="agent[]"
                                                                placeholder="{{ $str }}"
                                                                value="{{ $item->agent }}">
                                                        </td>
                                                        <td class='col-6'>
                                                            <div class='btnsct'><a href='javascript:void(0)'
                                                                    class='pencl'
                                                                    style='background-color: red; color:white;'
                                                                    onclick='remove_more({{ $key }}, {{ $item->id }})'><i
                                                                        class='fa fa-times' aria-hidden='true'></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr id="no_ser">
                                                    <td colspan="5" class="text-center">
                                                        There are no Case Serve entered
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-md-12 ml-5 mb-2">
                                    @if (session('service_check'))
                                        <input class="form-check-input" type="checkbox" name="service_check" value="yes"
                                            checked>
                                    @else
                                        <input class="form-check-input" type="checkbox" name="service_check" value="yes">
                                    @endif
                                    <label class="form-check-label" for="inlineCheckbox3">Click here to serve all parties with the "Same Service Level" (Examples: Routine, Priority, Urgent or On-Demand)</label>
                                </div>

                                <div class="col-md-12 ml-5 mb-2">
                                    @if (session('doc_check'))
                                        <input class="form-check-input" type="checkbox" name="doc_check" value="yes"
                                            checked>
                                    @else
                                        <input class="form-check-input" type="checkbox" name="doc_check" value="yes">
                                    @endif
                                    <label class="form-check-label" for="inlineCheckbox3">Check to serve all parties with
                                        the
                                        same documents.</label>
                                </div>

                                <div class="col-md-12 ml-5 mb-2">
                                    @if (session('add_check'))
                                        <input class="form-check-input" type="checkbox" name="add_check" value="yes"
                                            checked>
                                    @else
                                        <input class="form-check-input" type="checkbox" name="add_check" value="yes">
                                    @endif

                                    <label class="form-check-label" for="inlineCheckbox3">Check to serve all parties at
                                        the
                                        same address.</label>
                                </div>
                                <div class="col-md-12 ml-5 mb-2">
                                    <input class="form-check-input" type="checkbox" id="servInfoCheck3" name="check_3"
                                        onclick="displayServiceInfo()">
                                    <label class="form-check-label" for="inlineCheckbox3">Check to advance witness fees to
                                        all
                                        parties.</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="formprt mb-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <button type="submit" id="serve" class="ptrbtn">
                                                    Save & Next
                                                </button>
                                                <button type="button" class="ptrbtn prev-btn">
                                                    < Back </button>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0)" onclick="draft()"
                                                    class="ptrbtn save-as-draft">Save as Draft</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Trigger button to open the modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Select Court Defined Documents Title
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="selectform">
                                        <select id="firstSelect" class="form-control">
                                            <option value="-">Select</option>
                                            <option value="civil">Civil</option>
                                            <option value="family-law">Family Law</option>
                                            <option value="eviction">Eviction</option>
                                            <option value="small-claims">Small Claims</option>
                                        </select>
                                        <br>
                                        <!-- Second select field with dependent options -->
                                        <select id="secondSelect" class="form-control" style="display: none;">
                                            <option value="-">Select</option>
                                            <option value="suboption1" data-parent="option1">Suboption 1 (Option 1)
                                            </option>
                                            <option value="suboption2" data-parent="option1">Suboption 2 (Option 1)
                                            </option>
                                            <option value="suboption3" data-parent="option2">Suboption 3 (Option 2)
                                            </option>
                                            <option value="suboption4" data-parent="option3">Suboption 4 (Option 3)
                                            </option>
                                            <option value="suboption5" data-parent="option3">Suboption 5 (Option 3)
                                            </option>
                                            <option value="suboption6" data-parent="option4">Suboption 6 (Option 4)
                                            </option>
                                            <option value="suboption7" data-parent="option5">Suboption 7 (Option 5)
                                            </option>
                                        </select>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="selectButton">Select</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane document-tab fade bg-white px-3 py-2 {{ $step == 3 ? 'active show' : '' }}"
                        id="step3" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                        {{-- <form method="POST" id="doc_form" enctype="multipart/form-data">
                            @csrf --}}
                        <div class="documentsbdy">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="hdnngprt text-center">
                                        <h3>Documents Upload</h3>
                                        <a href="{{ route('reset_order') }}">Reset Order</a>
                                    </div>

                                    @if (isset($s_d[0]))
                                        @if (session('doc_check'))
                                            <div class="col-md-12">
                                                <div id="accordion2" class=" acrdnsect">
                                                    <div class="card">
                                                        <div class="card-header" id="headingFour">
                                                            <h4 class=" p-2 pt-3" style="color: white">
                                                                Document For: All Serve
                                                            </h4>
                                                        </div>
                                                        <div class="card-body p-3">
                                                            @php
                                                                $d_s = DB::table('documents')
                                                                    ->where(['order_id' => session('order_id')])
                                                                    ->where(['case_no' => session('case_id')])
                                                                    ->first();
                                                            @endphp
                                                            <input type="hidden" id="s_id_{{ $item->id }}"
                                                                value="{{ $item->id }}">
                                                            <div class="row align-items-center justify-content-center">
                                                                {{-- <div class="col-md-4">
                                                                    <div class="my-1">
                                                                        <label for="case-number">The Document
                                                                            Title:</label>
                                                                        <select class=" form-control" name="u_title"
                                                                            id="sd_u_title_{{ $item->id }}">
                                                                            <option value="Starts With">Starts
                                                                                With
                                                                            </option>
                                                                            <option value="Contain">
                                                                                Contain
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div> --}}
                                                                {{-- <div class="col-md-3 text-right">
                                                                        <div>
                                                                            <div class="btnprt">
                                                                                <button class="ptrbtn w-100"
                                                                                    onclick="cdd({{ $item->id }})">
                                                                                    Court
                                                                                    Defined
                                                                                    Document Titles
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div> --}}
                                                                {{-- <input type="hidden" value="{{ $item->id }}"
                                                                        name="sid" id="sid_{{ $item->id }}"> --}}
                                                                @php
                                                                    $d_dd = DB::table('documents')
                                                                        ->where(['order_id' => session('order_id')])
                                                                        ->where(['case_no' => session('case_id')])
                                                                        ->where(['s_d' => 'yes'])
                                                                        ->get();
                                                                @endphp

                                                                <div class="{{ count($d_dd) > 0 ? 'col-md-4' : 'col-md-12' }}"
                                                                    id="cdfs{{ $item->id }}">
                                                                    <label>Court Defined Documents</label>
                                                                    <select {{ count($d_dd) > 0 ? 'disabled' : '' }}
                                                                        id="first{{ $item->id }}"
                                                                        class="form-control dynamic_sd">
                                                                        <option value="-">Select</option>
                                                                        <option
                                                                            {{ count($d_dd) > 0 && $d_dd[0]->type == 'eviction' ? 'selected' : '' }}
                                                                            value="eviction">Eviction</option>
                                                                        <option
                                                                            {{ count($d_dd) > 0 && $d_dd[0]->type == 'civil' ? 'selected' : '' }}
                                                                            value="civil">Civil</option>
                                                                        <option
                                                                            {{ count($d_dd) > 0 && $d_dd[0]->type == 'family_law' ? 'selected' : '' }}
                                                                            value="family_law">Family Law</option>
                                                                        <option
                                                                            {{ count($d_dd) > 0 && $d_dd[0]->type == 'small_claims' ? 'selected' : '' }}
                                                                            value="small_claims">Small Claims
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-8" id="cdss{{ $item->id }}"
                                                                    style="{{ count($d_dd) == 0 ? 'display:none' : '' }}">
                                                                    <label>Document Name</label>
                                                                    <select id="second{{ $item->id }}"
                                                                        class="form-control dynamic_se"
                                                                        style="display: none;">
                                                                        <option value="-">Select Document</option>

                                                                        @if (count($d_dd) > 0)
                                                                            @php
                                                                                $options = DB::table('court_defined_documents')
                                                                                    ->where('category', $d_dd[0]->type)
                                                                                    ->get();
                                                                            @endphp

                                                                            @foreach ($options as $option)
                                                                                <option value="{{ $option->document }}">
                                                                                    {{ $option->document }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </div>

                                                                {{-- <div class="col-md-6">
                                                                    <div class="my-1">
                                                                        <label for="case-number">Document Title
                                                                            :</label>
                                                                        <input type="text" class="form-control"
                                                                            id="sd_d_title_{{ $item->id }}"
                                                                            placeholder="Enter free-form title or choose from the list below">
                                                                    </div>
                                                                </div> --}}
                                                                <div class="col-md-11">
                                                                    <div class="my-1">
                                                                        <label>Chose Document</label>
                                                                        <input type="file" class="form-control"
                                                                            id="sd_d_file_{{ $item->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1 text-center">
                                                                    <a href="javascript:void(0)"
                                                                        class="ptrbtn w-100 mt-4 p-0"
                                                                        id="sd_d_upload_{{ $item->id }}"
                                                                        onclick="sd_d_upload({{ $item->id }})">
                                                                        <i class="fa fa-cloud-upload"
                                                                            aria-hidden="true"></i>
                                                                    </a>
                                                                </div>
                                                                {{-- @if (isset($d_d->document))
                                                                    <div class="d_fn col-md-12" id="d_fn"
                                                                        style="color: red;">
                                                                        {{ $d_d->document }}
                                                                    </div>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mb-3">
                                                <table class="table">
                                                    <tbody id="sd_s_d_table_{{ $item->id }}">

                                                        @foreach ($d_dd as $itemd)
                                                            <tr id="ss_d_r_{{ $itemd->id }}">
                                                                <td>
                                                                    <a style="color: red; text-decoration:none;"
                                                                        href="uploads/{{ $itemd->document }}"
                                                                        target="_blank">{{ $itemd->document }}</a>
                                                                </td>
                                                                <td width='5%'>
                                                                    <div class='btnsct'>
                                                                        <a href='javascript:void(0)' class='pencl'
                                                                            style='background-color: red; color:white;'
                                                                            onclick='del_document({{ $itemd->id }})'><i
                                                                                class='fa fa-times'
                                                                                aria-hidden='true'></i></a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                        @php 
                                            $documentExists = false;
                                            $documentType = '';

                                            foreach( $s_d as $check )
                                            {
                                                $d_d = DB::table('documents')
                                                        ->where(['order_id' => session('order_id')])
                                                        ->where(['case_no' => session('case_id')])
                                                        ->where(['s_no' => $check->id])
                                                        ->get();
                                                
                                                if( count($d_d) > 0  )
                                                {
                                                    $documentExists = true;
                                                    $documentType = $d_d[0]->type;
                                                }
                                            }
                                        @endphp
                                            @foreach ($s_d as $item)
                                                @php
                                                    $d_d = DB::table('documents')
                                                        ->where(['order_id' => session('order_id')])
                                                        ->where(['case_no' => session('case_id')])
                                                        ->where(['s_no' => $item->id])
                                                        ->get();
                                                @endphp
                                                <input type="hidden" id="s_id_{{ $item->id }}"
                                                    value="{{ $item->id }}">
                                                <div class="col-md-12">
                                                    <div id="accordion2" class=" acrdnsect">
                                                        <div class="card">
                                                            <div class="card-header" id="headingFour">
                                                                <h4 class=" p-2 pt-3" style="color: white">
                                                                    <span style="font-size: 16px;">Document For:&nbsp;
                                                                    </span><b>{{ $item->p_t_serve }}</b> &nbsp;
                                                                    <span
                                                                        style="font-size: 14px;">(<i>{{ $item->role }}</i>)
                                                                    </span>
                                                                </h4>
                                                            </div>
                                                            <div class="card-body p-3">
                                                                <div class="row align-items-center justify-content-center">
                                                                    {{-- <div class="col-md-4">
                                                                        <div class="my-1">
                                                                            <label for="case-number">The Document
                                                                                Title:</label>
                                                                            <select class=" form-control" name="u_title"
                                                                                id="u_title_{{ $item->id }}">
                                                                                <option value="Starts With">Starts
                                                                                    With
                                                                                </option>
                                                                                <option value="Contain">
                                                                                    Contain
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div> --}}
                                                                    {{-- <div class="col-md-3 text-right">
                                                                        <div>
                                                                            <div class="btnprt">
                                                                                <button class="ptrbtn w-100"
                                                                                    onclick="cdd({{ $item->id }})">
                                                                                    Court
                                                                                    Defined
                                                                                    Document Titles
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div> --}}
                                                                    {{-- <input type="hidden" value="{{ $item->id }}"
                                                                        name="sid" id="sid_{{ $item->id }}"> --}}

                                                                    <div class="court-defined-document {{ $documentExists ? 'col-md-4' : 'col-md-12' }}"
                                                                        id="cddfs{{ $item->id }}">
                                                                        <label>Court Defined Documents</label>
                                                                        {{-- @php var_dump($d_d[0]);exit; @endphp --}}
                                                                        <select {{ $documentExists ? 'disabled' : '' }}
                                                                            id="firstSelec{{ $item->id }}"
                                                                            class="form-control dynamic document-type-select">
                                                                            <option value="-">Select</option>
                                                                            <option
                                                                                {{ $documentType == 'eviction' ? 'selected' : '' }}
                                                                                value="eviction">Eviction</option>
                                                                            <option
                                                                                {{ $documentType == 'civil' ? 'selected' : '' }}
                                                                                value="civil">Civil</option>
                                                                            <option
                                                                                {{ $documentType == 'family_law' ? 'selected' : '' }}
                                                                                value="family_law">Family Law</option>
                                                                            <option
                                                                                {{ $documentType == 'small_claims' ? 'selected' : '' }}
                                                                                value="small_claims">Small Claims
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-8 document-name-wrapper" id="cddss{{ $item->id }}"
                                                                        style="{{ !$documentExists ? 'display:none' : '' }}">
                                                                        <label>Document Name</label>
                                                                        <select id="secondSelec{{ $item->id }}"
                                                                            class="form-control dynamic_se"
                                                                            style="display: none;">
                                                                            <option value="-">Select Document</option>
                                                                            @if ($documentExists)
                                                                                @php
                                                                                    $options = DB::table('court_defined_documents')
                                                                                        ->where('category', $documentType)
                                                                                        ->get();
                                                                                @endphp

                                                                                @foreach ($options as $option)
                                                                                    <option
                                                                                        value="{{ $option->document }}">
                                                                                        {{ $option->document }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>

                                                                    {{-- <div class="col-md-6">
                                                                        <div class="my-1">
                                                                            <label for="case-number">Document Title
                                                                                :</label>
                                                                            <input type="text" class="form-control"
                                                                                id="d_title_{{ $item->id }}"
                                                                                placeholder="Enter free-form title or choose from the list below">
                                                                        </div>
                                                                    </div> --}}
                                                                    <div class="col-md-11">
                                                                        <div class="my-1">
                                                                            <label>Chose Document</label>
                                                                            <input type="file" class="form-control"
                                                                                id="d_file_{{ $item->id }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1 text-center">
                                                                        <a href="javascript:void(0)"
                                                                            class="ptrbtn w-100 mt-4 p-0"
                                                                            id="d_upload_{{ $item->id }}"
                                                                            onclick="d_upload({{ $item->id }})"><i
                                                                                class="fa fa-cloud-upload"
                                                                                aria-hidden="true"></i>
                                                                        </a>
                                                                    </div>
                                                                    @if (isset($d_d->document))
                                                                        <div class="d_fn col-md-12" id="d_fn"
                                                                            style="color: red;">
                                                                            {{ $d_d->document }}
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="table-responsive mb-3">
                                                    <table class="table">
                                                        <tbody id="s_d_table_{{ $item->id }}">
                                                            @foreach ($d_d as $itemd)
                                                                <tr id="s_d_r_{{ $itemd->id }}">
                                                                    <td>
                                                                        <a style="color: red; text-decoration:none;"
                                                                            href="uploads/{{ $itemd->document }}"
                                                                            target="_blank">{{ $itemd->document }}</a>
                                                                    </td>
                                                                    <td width='5%'>
                                                                        <div class='btnsct'>
                                                                            <a href='javascript:void(0)' class='pencl'
                                                                                style='background-color: red; color:white;'
                                                                                onclick='del_document({{ $itemd->id }})'><i
                                                                                    class='fa fa-times'
                                                                                    aria-hidden='true'></i></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="table-responsive mb-2">
                                            <table class="table">
                                                <thead class="txtryt">
                                                    <tr class="text-center">
                                                        <th>Serve</th>
                                                        <th>Capacity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($s_d as $item)
                                                        <tr class="text-center">
                                                            <td>
                                                                {{ $item->p_t_serve }}
                                                            </td>
                                                            <td>
                                                                {{ $item->role }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="table-responsive mb-2" style="height:0;">
                                            <table class="table">
                                                <thead class="txtryt">
                                                    <tr class="text-center">
                                                        <th width="25%">Serve</th>
                                                        <th>Document</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="" id="dd">
                                                    @php
                                                        $d_d_d = DB::table('documents')
                                                            ->where('order_id', session('order_id'))
                                                            ->where('case_no', session('case_id'))
                                                            ->when(
                                                                session('doc_check'),
                                                                function ($query) {
                                                                    return $query->where('s_d', 'yes')->orderBy('id');
                                                                },
                                                                function ($query) {
                                                                    return $query->where('s_d', null)->orderBy('s_no');
                                                                },
                                                            )
                                                            ->get();
                                                    @endphp
                                                    @foreach ($d_d_d as $item)
                                                        @php
                                                            $s_d = DB::table('serves')
                                                                ->where(['order_id' => session('order_id'), 'id' => $item->s_no])
                                                                ->first();
                                                        @endphp
                                                        <tr id="ddd{{ $item->id }}">
                                                            @if (isset($s_d->p_t_serve))
                                                                <td>{{ $s_d->p_t_serve }}</td>
                                                            @else
                                                                <td>-</td>
                                                            @endif
                                                            <td>
                                                                <a style="color: red; text-decoration:none;"
                                                                    href="uploads/{{ $item->document }}"
                                                                    target="_blank">{{ $item->document }}</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <h5>There are no <b>Serve</b> entered</h5>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="bxptyrtmain border-top pt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="formprt p-0 mb-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <a id="step-3-save-btn" href="javascript:void(0)" id=""
                                                    onclick="stepaddress()" class="ptrbtn mr-3">Save & Next</a>
                                                <button type="button" class="ptrbtn prev-btn">
                                                    < Back </button>
                                            </div>
                                            <div>
                                                <a href="javascript:void(0)" onclick="draft()"
                                                    class="ptrbtn save-as-draft">Save as Draft</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- </form> --}}
                    </div>
                    <div class="tab-pane fade sinfoprt bg-white odrfoo py-2 {{ $step == 4 ? 'active show' : '' }}"
                        id="step4" role="tabpanel" aria-labelledby="v-serve-settings-tab">
                        <div class="bxptyrtmain">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hdnngprt text-center">
                                        <h3>Serve Info</h3>
                                        <a href="{{ route('reset_order') }}">Reset Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bxptyrtmain">
                            <div class="mainbdy servsect">
                                @php
                                    $s_d = DB::table('serves')
                                        ->where(['order_id' => session('order_id')])
                                        ->get();
                                    $c_d = DB::table('serve_address')
                                        ->where(['order_id' => session('order_id')])
                                        ->first();
                                @endphp

                                @if (isset($s_d[0]))
                                    <form method="POST" id="add_address" class="add_address">
                                        @csrf
                                        @if (session('add_check'))
                                            <div class="row">
                                                {{-- <input type="hidden" name="s_id_s[]" value="{{ $item->id }}"> --}}
                                                <div class="col-md-12">
                                                    <div class=" acrdnsect">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <div class="pl-4 pr-4">
                                                                    <h4 class=" p-2 pt-3" style="color: white">
                                                                        <span style="font-size: 16px;">Same Address
                                                                            For:&nbsp;
                                                                        </span><b>All Servees</b> &nbsp;
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                            <div class="card-body p-3">
                                                                <div class="row w-100  align-items-center">
                                                                    <div class="col-md-12">
                                                                        <div class="formprt "
                                                                            id="address_wrapper_{{ session('order_id') }}">
                                                                            <label class="w-100">Address:
                                                                                <a data-id="{{ session('order_id') }}"
                                                                                    href="#!"
                                                                                    class="float-right add-more-address"
                                                                                    style="color: black">
                                                                                    <i class="fa fa-plus"
                                                                                        aria-hidden="true"></i>
                                                                                </a>
                                                                            </label>
                                                                            @if (!empty($c_d->address))
                                                                                @foreach (json_decode($c_d->address) as $index => $address)
                                                                                    <div
                                                                                        class="d-flex align-items-center justify-content-start">

                                                                                        <select
                                                                                            onchange="addressTypeUpdate(this)"
                                                                                            class="form-control col-sm-2 "
                                                                                            name="business_type[{{ session('order_id') }}][]"
                                                                                            id="business_type_{{ session('order_id') }}__{{ $index }}">
                                                                                            <option
                                                                                                {{ json_decode($c_d->type)[$index] == 'Residence' ? 'selected' : '' }}
                                                                                                value="Residence">Residence
                                                                                            </option>
                                                                                            <option
                                                                                                {{ json_decode($c_d->type)[$index] == 'Business' ? 'selected' : '' }}
                                                                                                value="Business">Business
                                                                                            </option>
                                                                                        </select>

                                                                                        <input type="text"
                                                                                            name="s_add_business_name[{{ session('order_id') }}][]"
                                                                                            class="form-control ml-2 my-2 col-sm-4 {{ json_decode($c_d->type)[$index] != 'Business' ? 'd-none' : '' }}"
                                                                                            id="address_business_name_{{ session('order_id') }}_{{ $index }}"
                                                                                            value="{{ json_decode($c_d->business_name)[$index] }}"
                                                                                            placeholder="Business Name">

                                                                                        <input type="text"
                                                                                            name="s_add[{{ session('order_id') }}][]"
                                                                                            class="form-control my-2 ml-2 col-sm-5"
                                                                                            id="address_{{ session('order_id') }}_{{ $index }}"
                                                                                            value="{{ $address }}"
                                                                                            oninput="addressVal('#address_{{ session('order_id') }}')"
                                                                                            placeholder="Address">

                                                                                        @if ($index > 0)
                                                                                            <a href="#!"
                                                                                                class="col-sm-1 text-right ml-auto"
                                                                                                onclick="removeAddress(this, event)"
                                                                                                style="color: #000"><i
                                                                                                    class="fa fa-times"
                                                                                                    aria-hidden="true"></i></a>
                                                                                        @endif
                                                                                    </div>
                                                                                @endforeach
                                                                            @else
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-start">

                                                                                    <select
                                                                                        class="form-control col-sm-2 " onchange="addressTypeUpdate(this)"
                                                                                        name="business_type[{{ session('order_id') }}][]"
                                                                                        id="business_type_{{ session('order_id') }}">
                                                                                        <option value="Residence">
                                                                                            Residence</option>
                                                                                        <option value="Business">Business
                                                                                        </option>
                                                                                    </select>

                                                                                    <input type="text"
                                                                                        name="s_add_business_name[{{ session('order_id') }}][]"
                                                                                        class="form-control ml-2 my-2 col-sm-4 d-none"
                                                                                        id="address_business_name_{{ session('order_id') }}"
                                                                                        placeholder="Business Name">

                                                                                    <input type="text"
                                                                                        name="s_add[{{ session('order_id') }}][]"
                                                                                        oninput="addressVal('#address_{{ session('order_id') }}')"
                                                                                        class="form-control my-2 ml-2 col-sm-5"
                                                                                        id="address_{{ session('order_id') }}"
                                                                                        placeholder="Address">
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-5">
                                                                        <div class="formprt mb-3">
                                                                            <label for="timezone">Time Zone :</label>
                                                                            <select class="form-control" required
                                                                                name="s_t_z">
                                                                                <option
                                                                                    <?php if (isset($c_d->timezone) == 'Eastern Standard Time') {
                                                                                        echo 'selected';
                                                                                    } ?>value="Eastern Standard Time">
                                                                                    Eastern
                                                                                    Standard Time</option>
                                                                                <option <?php if (isset($c_d->timezone) == 'Central Standard Time') {
                                                                                    echo 'selected';
                                                                                } ?>
                                                                                    value="Central Standard Time">
                                                                                    Central
                                                                                    Standard Time</option>
                                                                                <option <?php if (isset($c_d->timezone) == 'Mountain Standard Time') {
                                                                                    echo 'selected';
                                                                                } ?>
                                                                                    value="Mountain Standard Time">
                                                                                    Mountain
                                                                                    Standard Time</option>
                                                                                <option
                                                                                    {{ (isset($c_d->timezone) && $c_d->timezone == 'Pacific Standard Time') || !isset($c_d->timezone) ? 'selected' : '' }}
                                                                                    value="Pacific Standard Time">
                                                                                    Pacific
                                                                                    Standard Time</option>
                                                                                <option <?php if (isset($c_d->timezone) == 'Alaskan Standard Time') {
                                                                                    echo 'selected';
                                                                                } ?>
                                                                                    value="Alaskan Standard Time">
                                                                                    Alaskan
                                                                                    Standard Time</option>
                                                                                <option <?php if (isset($c_d->timezone) == 'Hawaiian Standard Time') {
                                                                                    echo 'selected';
                                                                                } ?>
                                                                                    value="Hawaiian Standard Time">
                                                                                    Hawaiian
                                                                                    Standard Time</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="formprt mb-3">
                                                                            <label for="datetime">Hearing Date/Time
                                                                                :</label>
                                                                            <input type="datetime-local" name="h_time"
                                                                                value=" <?php if (isset($c_d->h_date)) {
                                                                                    echo $c_d->h_date;
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>"
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <div class="formprt mb-3">
                                                                            <label for="dept">Dept/Div :</label>
                                                                            <input  type="text"
                                                                                class="form-control" name="dpt"
                                                                                value=" <?php if (isset($c_d->dept)) {
                                                                                    echo $c_d->dept;
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>"
                                                                                placeholder="Dept/Div">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="formprt mb-3">
                                                                            <label class="form-label">Advance Witness
                                                                                Fees:</label>
                                                                            <div class="d-flex px-4 flex-column">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio" name="w_fee"
                                                                                        value="Yes"
                                                                                        <?php if (isset($c_d->w_fee) && $c_d->w_fee == 'Yes') {
                                                                                            echo 'checked';
                                                                                        } ?>>
                                                                                    <label class="form-check-label">
                                                                                        Yes
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="radio" name="w_fee"
                                                                                        value="No"
                                                                                        <?php if ((isset($c_d->w_fee) && $c_d->w_fee != 'Yes') || !isset($c_d->w_fee)) {
                                                                                            echo 'checked';
                                                                                        } ?>>
                                                                                    <label class="form-check-label"
                                                                                        for="w_fee_no">
                                                                                        No
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="formprt mb-3">
                                                                            <label class="form-label">Proof:</label>
                                                                            <div class="d-flex flex-column ">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" name="proof"
                                                                                        style="margin-left: 0;"
                                                                                        value="File (Additional fee will apply)"
                                                                                        <?php if (isset($c_d->proof) && $c_d->proof == 'File (Additional fee will apply)') {
                                                                                            echo 'checked';
                                                                                        } ?>>
                                                                                    <label class="form-check-label">
                                                                                        File (Additional fee will apply)
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" name="proof"
                                                                                        style="margin-left: 0;"
                                                                                        value="Notarize"
                                                                                        <?php if (isset($c_d->proof) && $c_d->proof == 'Notarize') {
                                                                                            echo 'checked';
                                                                                        } ?>>
                                                                                    <label class="form-check-label">
                                                                                        Notarize
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="formprt mb-3">
                                                                            <label>Special
                                                                                Instructions:</label>
                                                                            <textarea cols="30" rows="7" name="s_instruction" class="form-control"
                                                                                placeholder="Special Instructions"><?php if (isset($c_d->s_inst)) {
                                                                                    echo $c_d->s_inst;
                                                                                } else {
                                                                                    echo '';
                                                                                } ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                @foreach ($s_d as $item)
                                                    <input type="hidden" name="s_id_s[]"
                                                        value="{{ $item->id }}">
                                                    <div class="col-md-12">
                                                        <div class=" acrdnsect">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div class="pl-4 pr-4">
                                                                        <h4 class=" p-2 pt-3" style="color: white">
                                                                            <span style="font-size: 16px;">Address
                                                                                For:&nbsp;
                                                                            </span><b>{{ $item->p_t_serve }}</b> &nbsp;
                                                                            <span
                                                                                style="font-size: 14px;">(<i>{{ $item->role }}</i>)
                                                                            </span>
                                                                        </h4>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body p-3">
                                                                    <div class="row w-100  align-items-center">
                                                                        <div class="col-md-12">
                                                                            <div class="formprt "
                                                                                id="address_wrapper_{{ $item->id }}">
                                                                                <label class="w-100">Address:
                                                                                    <a data-id="{{ $item->id }}"
                                                                                        href="#!"
                                                                                        class="float-right add-more-address"
                                                                                        style="color: black">
                                                                                        <i class="fa fa-plus"
                                                                                            aria-hidden="true"></i>
                                                                                    </a>
                                                                                </label>
                                                                                @if (!empty($item->address) && is_array(json_decode($item->address)))
                                                                                    @foreach (json_decode($item->address) as $index => $address)
                                                                                        <div
                                                                                            class="d-flex align-items-center justify-content-start">
                                                                                            <select
                                                                                                onchange="addressTypeUpdate(this)"
                                                                                                class="form-control col-sm-2 "
                                                                                                name="business_type[{{ $item->id }}][]"
                                                                                                id="business_type_{{ session('order_id') }}_{{ $index }}">
                                                                                                <option
                                                                                                    {{ json_decode($item->type)[$index] == 'Residence' ? 'selected' : '' }}
                                                                                                    value="Residence">
                                                                                                    Residence</option>
                                                                                                <option
                                                                                                    {{ json_decode($item->type)[$index] == 'Business' ? 'selected' : '' }}
                                                                                                    value="Business">
                                                                                                    Business</option>
                                                                                            </select>

                                                                                            <input type="text"
                                                                                                name="s_add_business_name[{{ $item->id }}][]"
                                                                                                class="form-control my-2 ml-2 col-sm-4 {{ json_decode($item->type)[$index] != 'Business' ? 'd-none' : '' }}"
                                                                                                id="address_business_name_{{ $item->id }}_{{ $index }}"
                                                                                                value="{{ json_decode($item->business_name)[$index] }}"
                                                                                                placeholder="Business Name">

                                                                                            <input type="text"
                                                                                                name="s_add[{{ $item->id }}][]"
                                                                                                oninput="addressVal('#address_{{ $item->id }}_{{ $index }}')"
                                                                                                class="form-control my-2 ml-2 col-sm-5 "
                                                                                                id="address_{{ $item->id }}_{{ $index }}"
                                                                                                value="{{ $address }}"
                                                                                                placeholder="Address">


                                                                                            @if ($index > 0)
                                                                                                <a href="#!"
                                                                                                    class="col-sm-1 text-right ml-auto"
                                                                                                    onclick="removeAddress(this, event)"
                                                                                                    style="color: #000"><i
                                                                                                        class="fa fa-times"
                                                                                                        aria-hidden="true"></i></a>
                                                                                            @endif
                                                                                        </div>
                                                                                    @endforeach
                                                                                @else
                                                                                    <div
                                                                                        class="d-flex align-items-center justify-content-start">
                                                                                        <select
                                                                                            onchange="addressTypeUpdate(this)"
                                                                                            class="form-control col-sm-2 "
                                                                                            name="business_type[{{ $item->id }}][]"
                                                                                            id="business_type_{{ session('order_id') }}">
                                                                                            <option value="Residence">
                                                                                                Residence</option>
                                                                                            <option value="Business">
                                                                                                Business</option>
                                                                                        </select>

                                                                                        <input type="text"
                                                                                            name="s_add_business_name[{{ $item->id }}][]"
                                                                                            class="form-control my-2 ml-2 col-sm-4 d-none"
                                                                                            id="address_business_name_{{ $item->id }}"
                                                                                            placeholder="Business Name">

                                                                                        <input type="text"
                                                                                            name="s_add[{{ $item->id }}][]"
                                                                                            oninput="addressVal('#address_{{ $item->id }}')"
                                                                                            class="form-control my-2 ml-2 col-sm-5"
                                                                                            id="address_{{ $item->id }}"
                                                                                            placeholder="Address">

                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="formprt mb-3">
                                                                                <label for="timezone">Time Zone :</label>
                                                                                <select required class="form-control"
                                                                                    name="s_t_z[]">
                                                                                    <option
                                                                                        <?php if ($item->timezone == 'Eastern Standard Time') {
                                                                                            echo 'selected';
                                                                                        } ?>value="Eastern Standard Time">
                                                                                        Eastern
                                                                                        Standard Time</option>
                                                                                    <option <?php if ($item->timezone == 'Central Standard Time') {
                                                                                        echo 'selected';
                                                                                    } ?>
                                                                                        value="Central Standard Time">
                                                                                        Central
                                                                                        Standard Time</option>
                                                                                    <option <?php if ($item->timezone == 'Mountain Standard Time') {
                                                                                        echo 'selected';
                                                                                    } ?>
                                                                                        value="Mountain Standard Time">
                                                                                        Mountain
                                                                                        Standard Time</option>
                                                                                    <option
                                                                                        {{ (isset($item->timezone) && $item->timezone == 'Pacific Standard Time') || !isset($item->timezone) ? 'selected' : '' }}
                                                                                        value="Pacific Standard Time">
                                                                                        Pacific
                                                                                        Standard Time</option>
                                                                                    <option <?php if ($item->timezone == 'Alaskan Standard Time') {
                                                                                        echo 'selected';
                                                                                    } ?>
                                                                                        value="Alaskan Standard Time">
                                                                                        Alaskan
                                                                                        Standard Time</option>
                                                                                    <option <?php if ($item->timezone == 'Hawaiian Standard Time') {
                                                                                        echo 'selected';
                                                                                    } ?>
                                                                                        value="Hawaiian Standard Time">
                                                                                        Hawaiian
                                                                                        Standard Time</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-5">
                                                                            <div class="formprt mb-3">
                                                                                <label for="datetime">Hearing Date/Time
                                                                                    :</label>
                                                                                <input type="datetime-local"
                                                                                    name="h_time[]"
                                                                                    value="{{ $item->h_date }}"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <div class="formprt mb-3">
                                                                                <label for="dept">Dept/Div :</label>
                                                                                <input  type="text"
                                                                                    class="form-control" name="dpt[]"
                                                                                    value="{{ $item->dept }}"
                                                                                    placeholder="Dept/Div">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="formprt mb-3">
                                                                                <label class="form-label">Advance Witness
                                                                                    Fees:</label>
                                                                                <div class="d-flex px-4 flex-column">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="w_fee_<?php echo $loop->iteration; ?>"
                                                                                            id="w_fee_yes_<?php echo $loop->iteration; ?>"
                                                                                            value="Yes"
                                                                                            <?php if ($item->w_fee == 'Yes') {
                                                                                                echo 'checked';
                                                                                            } ?>>
                                                                                        <label class="form-check-label">
                                                                                            Yes
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                            type="radio"
                                                                                            name="w_fee_<?php echo $loop->iteration; ?>"
                                                                                            id="w_fee_no_<?php echo $loop->iteration; ?>"
                                                                                            value="No"
                                                                                            <?php if ($item->w_fee != 'Yes') {
                                                                                                echo 'checked';
                                                                                            } ?>>
                                                                                        <label class="form-check-label">
                                                                                            No
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                            <div class="formprt mb-3">
                                                                                <label class="form-label">Proof:</label>
                                                                                <div class="d-flex px-4 flex-column">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            name="proof[]"
                                                                                            style="margin-left: 0;"
                                                                                            value="File (Additional fee will apply)"
                                                                                            <?php if ($item->proof == 'File (Additional fee will apply)') {
                                                                                                echo 'checked';
                                                                                            } ?>>
                                                                                        <label class="form-check-label">
                                                                                            File (Additional fee will apply)
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                            type="checkbox"
                                                                                            name="proof[]"
                                                                                            style="margin-left: 0;"
                                                                                            value="Notarize"
                                                                                            <?php if ($item->proof == 'Notarize') {
                                                                                                echo 'checked';
                                                                                            } ?>>
                                                                                        <label class="form-check-label">
                                                                                            Notarize
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="formprt mb-3">
                                                                                <label>Special
                                                                                    Instructions:</label>
                                                                                <textarea cols="30" rows="7" name="s_instruction[]" class="form-control"
                                                                                    placeholder="Special Instructions">{{ $item->s_inst }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="table-responsive mb-2">
                                            <table class="table">
                                                <thead class="txtryt">
                                                    <tr class="text-center">
                                                        <th>Serve</th>
                                                        <th>Capacity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($s_d as $item)
                                                        <tr class="text-center">
                                                            <td>
                                                                {{ $item->p_t_serve }}
                                                            </td>
                                                            <td>
                                                                {{ $item->role }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">
                                                            <h5>There are no <b>Serve</b> entered</h5>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                @endif
                            </div>
                            <div class="formprt mb-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="submit" id="address-save-btn" class="ptrbtn mr-3">
                                            Save & Next
                                        </button>
                                        <button type="button" class="ptrbtn prev-btn">
                                            < Back </button>
                                    </div>
                                    <div>
                                        <a href="javascript:void(0)" onclick="draft()"
                                            class="ptrbtn save-as-draft">Save as Draft</a>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane servsect fade bg-white px-3 py-4 {{ $step == 5 ? 'active show' : '' }}"
                        id="step5" role="tabpanel" aria-labelledby="v-details-settings-tab">
                        <div class="bxptyrtmain">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="hdnngprt text-center">
                                        <h3>Order Details</h3>
                                        <a href="{{ route('reset_order') }}">Reset Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $o_d = DB::table('order_details')
                                ->where(['order_id' => session('order_id')])
                                ->first();
                        @endphp
                        <form method="POST" id="order_details">
                            @csrf
                            <div class="bxptyrtmain">
                                <div class="mainbdy servbdy">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if (session('service_check'))
                                                @php
                                                    $index = 1;
                                                @endphp
                                                <h4 class="d-block pb-3">When would you like this attempted for all Servee?</h4>
                                                <ul class="rediolist">
                                                    <input type="hidden" name="attempt_type[]" id="attempt_type_{{$index}}">
                                                    <li>
                                                        <label class="radio">
                                                            <input required data-type="routine" data-index="{{$index}}" type="radio"
                                                                class="mr-1 optradio" name="optradio[]"
                                                                value="{{ date('d-m-Y g:i a', strtotime('+ 72 hours')) }}">
                                                            <strong>Routine Service</strong> Attempt by
                                                            <strong>{{ date('l g:i a', strtotime('+ 72 hours')) }}</strong>
                                                            for $75
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="radio">
                                                            <input required data-type="priority" data-index="{{$index}}" type="radio"
                                                                class="mr-1 optradio" name="optradio[]"
                                                                value="{{ date('d-m-Y g:i a', strtotime('+ 48 hours')) }}">
                                                            <strong>Priority Service</strong> Attempt by
                                                            <strong>{{ date('l g:i a', strtotime('+ 48 hours')) }}</strong>
                                                            for $100
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="radio">
                                                            <input required data-type="urgent" data-index="{{$index}}" type="radio"
                                                                class="mr-1 optradio" name="optradio[]"
                                                                value="{{ date('d-m-Y g:i a', strtotime('+ 24 hours')) }}">
                                                            <strong>Urgent Service</strong> Attempt by
                                                            <strong>{{ date('l g:i a', strtotime('+ 24 hours')) }}</strong>
                                                            for $125
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="radio">
                                                            <input required data-type="on demand" data-index="{{$index}}" type="radio"
                                                                class="mr-1 optradio" name="optradio[]"
                                                                value="{{ date('d-m-Y g:i a', strtotime('+ 4 hours')) }}">
                                                            <strong>On Demand Service</strong> Attempt by
                                                            <strong>{{ date('l g:i a', strtotime('+ 4 hours')) }}</strong> for
                                                            $175
                                                        </label>
                                                    </li>
                                                </ul>
                                            @else
                                                @foreach ( $s_d as $index => $servee )
                                                    <h4 class="d-block pb-3">When would you like this attempted for <strong>{{ $servee->p_t_serve }}</strong>?</h4>
                                                    <ul class="rediolist">
                                                        <input type="hidden" name="attempt_type[]" id="attempt_type_{{$index}}">
                                                        <li>
                                                            <label class="radio">
                                                                <input required data-type="routine" data-index="{{$index}}" type="radio"
                                                                    class="mr-1 optradio" name="optradio[{{$index}}]"
                                                                    value="{{ date('d-m-Y g:i a', strtotime('+ 72 hours')) }}">
                                                                <strong>Routine Service</strong> Attempt by
                                                                <strong>{{ date('l g:i a', strtotime('+ 72 hours')) }}</strong>
                                                                for $75
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="radio">
                                                                <input required data-type="priority" data-index="{{$index}}" type="radio"
                                                                    class="mr-1 optradio" name="optradio[{{$index}}]"
                                                                    value="{{ date('d-m-Y g:i a', strtotime('+ 48 hours')) }}">
                                                                <strong>Priority Service</strong> Attempt by
                                                                <strong>{{ date('l g:i a', strtotime('+ 48 hours')) }}</strong>
                                                                for $100
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="radio">
                                                                <input required data-type="urgent" data-index="{{$index}}" type="radio"
                                                                    class="mr-1 optradio" name="optradio[{{$index}}]"
                                                                    value="{{ date('d-m-Y g:i a', strtotime('+ 24 hours')) }}">
                                                                <strong>Urgent Service</strong> Attempt by
                                                                <strong>{{ date('l g:i a', strtotime('+ 24 hours')) }}</strong>
                                                                for $125
                                                            </label>
                                                        </li>
                                                        <li>
                                                            <label class="radio">
                                                                <input required data-type="on demand" data-index="{{$index}}" type="radio"
                                                                    class="mr-1 optradio" name="optradio[{{$index}}]"
                                                                    value="{{ date('d-m-Y g:i a', strtotime('+ 4 hours')) }}">
                                                                <strong>On Demand Service</strong> Attempt by
                                                                <strong>{{ date('l g:i a', strtotime('+ 4 hours')) }}</strong> for
                                                                $175
                                                            </label>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            @endif
                                            <p class="nots">
                                                * Prices listed and service times displayed are per address attempted and
                                                only
                                                an estimate based on the information provided. If you need your order
                                                processed
                                                sooner than the times listed above, please call us at (888) 962-9696.
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formprt mb-3">
                                                <label for="bssnm">Internal Reference/Matter Number (Optional) :</label>
                                                <input type="text" class="form-control" name="irn"
                                                    value=" <?php if (isset($o_d->irn)) {
                                                        echo $o_d->irn;
                                                    } else {
                                                        echo '';
                                                    } ?>"
                                                    placeholder="Internal Reference/Matter Number (Optional)">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="formprt mb-3">
                                                <label for="bssnm"> Notifications: :</label>
                                                <br>
                                                <input class="mr-1" name="notification" value="Dennis Block"
                                                    <?php echo isset($o_d->notification) === 'Dennis Block' ? 'checked' : ''; ?> type="checkbox">Dennis Block
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <input class="mr-1" name="notification" value="Test"
                                                    <?php echo isset($o_d->notification) === 'Test' ? 'checked' : ''; ?> type="checkbox">Test

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="formprt mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <input type="submit" value="Submit" class="ptrbtn mr-3">
                                                        <button type="button" class="ptrbtn prev-btn">
                                                            < Back </button>
                                                    </div>
                                                    <div>
                                                        <a href="javascript:void(0)" onclick="draft()"
                                                            class="ptrbtn save-as-draft">Save as Draft</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    </div>

    <!-- new server info modal -->
    <div class="modal modalprtcstm fade" id="attorney_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="add_attorney" method="post">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Add Attorney</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="formprt mb-3">
                                    <label for="fmname">First Name *</label>
                                    <input type="text" class="form-control" name="fname"
                                        placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formprt mb-3">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" class="form-control" name="lname"
                                        placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formprt mb-3">
                                    <label for="bar_id">Bar Id</label>
                                    <input type="text" class="form-control" name="b_id" placeholder="Bar Id">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formprt mb-3">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formprt mb-3">
                                    <label for="phone">Phone *</label>
                                    <input type="number" class="form-control" name="phone" placeholder="phone"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formprt mb-3">
                                    <label for="password">Password *</label>
                                    <input type="password" class="form-control" name="pass"
                                        placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="formprt mb-3">
                                    <label for="conf_password">Confirm Password *</label>
                                    <input type="password" class="form-control" name="cpass"
                                        placeholder="Confirm Password" required>
                                </div>
                            </div>


                            <!-- new addition -->
                            <div class="col-md-12">
                                <div class="formprt mb-3">
                                    <label for="phone">Firm Name *</label>
                                    <input type="text" class="form-control" name="firm_name"
                                        placeholder="Firm Name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formprt mb-3">
                                    <label for="phone">Street Address *</label>
                                    <input type="text" class="form-control" name="street_address"
                                        placeholder="Street Address" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="formprt mb-3">
                                            <label for="phone">City *</label>
                                            <input type="text" class="form-control" name="city"
                                                placeholder="City" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formprt mb-3">
                                            <label for="phone">State *</label>
                                            <input type="text" class="form-control" name="state"
                                                placeholder="State" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="formprt mb-3">
                                            <label for="phone">Zip *</label>
                                            <input type="text" class="form-control" name="zip"
                                                placeholder="Zip" required>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="ptrbtn mr-3">Save</button>
                        <button type="button" class="ptrbtn" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal modalprtcstm fade" id="edit_address_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="edit_address_form" method="post">
            @csrf
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Edit Address</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="formprt mb-1">
                            <label for="addressType">Address Type:</label>
                            <select class="form-control" id="addressType">
                                <option value="Business">Business</option>
                                <option value="Residence">Residence</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <!-- Business Name (Text Field) -->
                        <div class="formprt mb-1 " id="business-name-wrapper">
                            <label for="businessName">Business Name:</label>
                            <input type="text" class="form-control" id="businessName">
                        </div>

                        <!-- Address (Auto-filled) -->
                        <div class="formprt mb-1">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" required id="addressFull">
                        </div>

                        <!-- Unit or Suite (Text Field) -->
                        <div class="formprt mb-1">
                            <label for="unitSuite">Unit or Suite:</label>
                            <input type="text" class="form-control" id="unitSuite">
                        </div>

                        <!-- City (Text Field) -->
                        <div class="formprt mb-1">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" required id="cityAddress">
                        </div>

                        <!-- State (Select Box with US States) -->
                        <div class="formprt mb-1">
                            <label for="state">State:</label>
                            <select class="form-control" id="stateAddress">
                                <option value="Alabama">Alabama</option>
                                <option value="Alaska">Alaska</option>
                                <option value="Arizona">Arizona</option>
                                <option value="Arkansas">Arkansas</option>
                                <option value="California">California</option>
                                <option value="Colorado">Colorado</option>
                                <option value="Connecticut">Connecticut</option>
                                <option value="Delaware">Delaware</option>
                                <option value="Florida">Florida</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Hawaii">Hawaii</option>
                                <option value="Idaho">Idaho</option>
                                <option value="Illinois">Illinois</option>
                                <option value="Indiana">Indiana</option>
                                <option value="Iowa">Iowa</option>
                                <option value="Kansas">Kansas</option>
                                <option value="Kentucky">Kentucky</option>
                                <option value="Louisiana">Louisiana</option>
                                <option value="Maine">Maine</option>
                                <option value="Maryland">Maryland</option>
                                <option value="Massachusetts">Massachusetts</option>
                                <option value="Michigan">Michigan</option>
                                <option value="Minnesota">Minnesota</option>
                                <option value="Mississippi">Mississippi</option>
                                <option value="Missouri">Missouri</option>
                                <option value="Montana">Montana</option>
                                <option value="Nebraska">Nebraska</option>
                                <option value="Nevada">Nevada</option>
                                <option value="New Hampshire">New Hampshire</option>
                                <option value="New Jersey">New Jersey</option>
                                <option value="New Mexico">New Mexico</option>
                                <option value="New York">New York</option>
                                <option value="North Carolina">North Carolina</option>
                                <option value="North Dakota">North Dakota</option>
                                <option value="Ohio">Ohio</option>
                                <option value="Oklahoma">Oklahoma</option>
                                <option value="Oregon">Oregon</option>
                                <option value="Pennsylvania">Pennsylvania</option>
                                <option value="Rhode Island">Rhode Island</option>
                                <option value="South Carolina">South Carolina</option>
                                <option value="South Dakota">South Dakota</option>
                                <option value="Tennessee">Tennessee</option>
                                <option value="Texas">Texas</option>
                                <option value="Utah">Utah</option>
                                <option value="Vermont">Vermont</option>
                                <option value="Virginia">Virginia</option>
                                <option value="Washington">Washington</option>
                                <option value="West Virginia">West Virginia</option>
                                <option value="Wisconsin">Wisconsin</option>
                                <option value="Wyoming">Wyoming</option>
                            </select>
                        </div>

                        <!-- Zip (Text Field) -->
                        <div class="formprt mb-1">
                            <label for="zip">Zip:</label>
                            <input type="text" class="form-control" required id="zipAddress">
                        </div>


                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- add party modal -->
    <div class="modal modalprtcstm fade" id="change_party" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form id="change_party_form" method="post">
            @csrf
            <input type="hidden" name="party_form_id" id="party_form_id">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Add
                            Party</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="formprt">
                                    <div class="d-inline-block mr-1">
                                        <p>
                                            Change Lead Client ?
                                        </p>
                                    </div>
                                    <div class="d-inline-block">

                                        <label class="radio-inline mr-3">
                                            <input checked type="radio" class="mr-1" name="change_lead"
                                                id="p_lclient_change_no" value="no">For this order only
                                        </label>
                                        <label class="radio-inline mr-3">
                                            <input type="radio" class="mr-1" value="yes" name="change_lead"
                                                id="p_lclient_change">For this and All Orders Following
                                        </label>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formprt">
                                    <div class="d-inline-block mr-1">
                                        <p>
                                            Change the Billing Code ?
                                        </p>
                                    </div>
                                    <div class="d-inline-block">

                                        <label class="radio-inline mr-3">
                                            <input checked type="radio" class="mr-1" name="change_billing"
                                                id="p_lclient_no_change" value="no"> For this order only
                                        </label>
                                        <label class="radio-inline mr-3">
                                            <input type="radio" class="mr-1" value="yes"
                                                name="change_billing" id="p_lclient_change">For this and All Orders
                                            Following
                                        </label>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" id="party_modal_billing_code_change" style="display: none;">
                                <div class="formprt mb-3">
                                    <label for="billing_code">Billing Code</label>
                                    <input type="text" class="form-control" id="p_bcode_change" name="p_bcode"
                                        placeholder="Billing Code">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Save" class="ptrbtn mr-3">
                        <button type="button" class="ptrbtn" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script 
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2h5V1Jl9owOguijhl9Fy21uuAjlkKjpY&libraries=places">
    </script>

    <script>
        var currentElm = '';
        var zip = "";

        function addressVal(elm) {
            currentElm = elm;
            let autocomplete;
            // var address = document.getElementById('address').value;
            address1Field = document.querySelector(elm);

            console.log(address1Field);

            autocomplete = new google.maps.places.Autocomplete(address1Field, {
                componentRestrictions: {
                    country: ["us"]
                },
                fields: ["address_components", "geometry", "formatted_address"],
                types: ["address"],
            });

            autocomplete.addListener("place_changed", function() {
                var place = autocomplete.getPlace();

                for (var i = 0; i < place.address_components.length; i++) {
                    var component = place.address_components[i];
                    if (component.types.includes('postal_code')) {
                        zip = component.long_name;
                        break;
                    }
                }

                // address1Field.value = address1Field.value + ', ' + zip;

                openModalWithPlaceDetails(address1Field);
            });

            address1Field.focus();
        }

        function openModalWithPlaceDetails(address1Field) {

            $("#addressFull").val($(address1Field).val());
            $("#zipAddress").val(zip);

            if($(address1Field).prev().prev().val() == 'Residence') {
                $("#addressType").val('Residence');
                $("#business-name-wrapper").hide();
            } else {
                $("#addressType").val('Business');
                $("#business-name-wrapper").show();
            }
            $("#edit_address_modal").modal('show');

        }
    </script>
@endsection
