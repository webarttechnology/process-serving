@extends('commons.header')
@section('content')
    <div class="model-wrapper">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Acount Information</h5>
        </div>
        <div class="modal-body">
            <form class="row" action="{{ route ('update_users' , ['id' => $adminData->id])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="col-md-6 mb-4">
                    <label for="exampleInputName" class="form-label">Organization Name:</label>
                    <input type="text" class="form-control" value="Organizer Name" name="organizer_name" readonly>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="exampleInputName" class="form-label">Role:</label>
                    <select class="form-select form-select-sm form-control" aria-label=".form-select-sm example" name="role">
                        <option selected>Open this select menu</option>
                        <option value="admin" {{ $adminData->role == "admin" ? 'selected' : '' }}>Admin</option>
                        <option value="staff" {{ $adminData->role == "staff" ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>
                <div class="col-md-6 mb-4">
                    <label for="exampleInputName" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{$adminData->name}}">
                </div>
                
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="Last Name" class="sect">Attorney<span style="color: red">*</span> 
                        <input type="checkbox" {{$adminData->attorney ? 'checked' : ""}} id="attorney" name="attorney"></label>
                        <input type="text" class="form-control" id="bar_id" name="bar_id" value="{{isset($adminData->attorney_info) ? $adminData->attorney_info->b_id : ''}}" {{$adminData->attorney ? '' : "readonly"}} >
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="exampleInputContact" class="form-label">Email:*</label>
                            <div class="cont_wrapper">
                                <input type="text" class="form-control mb-2 mr-1 ml-1" id="exampleInputContact" aria-describedby="contact" name="email"
                                value="{{$adminData->email}}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="exampleInputContact" class="form-label">Phone:*</label>
                            <div class="cont_wrapper">
                                <input type="number" class="form-control mb-2 mr-1 ml-1" id="exampleInputContact" aria-describedby="contact" name="phone"
                                value="{{$adminData->phone}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="exampleInputAddress" class="form-label">Address 1:*</label>
                    <input type="text" class="form-control" id="exampleInputAddress" aria-describedby="address" name="address1" value="{{isset($adminData->admin_info_single) ? $adminData->admin_info_single->address : ''}}">
                </div>
               
                <div class="col-md-6 mb-4">
                    <label for="exampleInputCity" class="form-label">City:*</label>
                    <input type="text" class="form-control" id="exampleInputCity" aria-describedby="city" name="city" value="{{isset($adminData->admin_info_single) ?$adminData->admin_info_single->billing_city : ''}}">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="exampleInputAddress" class="form-label">State:*</label>
                    <select class="form-select form-select-sm form-control" aria-label=".form-select-sm example" name="state">
                        <option selected>Open this select menu</option>
                        <option value="AL">ALABAMA</option>
                        <option value="AK">ALASKA</option>
                        <option value="AS">AMERICAN SAMOA</option>
                        <option value="AZ">ARIZONA</option>
                        <option value="AR">ARKANSAS</option>
                        <option value="CA">CALIFORNIA</option>
                        <option value="CO">COLORADO</option>
                        <option value="CT">CONNECTICUT</option>
                        <option value="DE">DELAWARE</option>
                        <option value="DC">DISTRICT OF COLUMBIA</option>
                        <option value="FM">FEDERATED STATES OF MICRONESIA</option>
                        <option value="FL">FLORIDA</option>
                        <option value="GA">GEORGIA</option>
                        <option value="GU">GUAM GU</option>
                        <option value="HI">HAWAII</option>
                        <option value="ID">IDAHO</option>
                        <option value="IL">ILLINOIS</option>
                        <option value="IN">INDIANA</option>
                        <option value="IA">IOWA</option>
                        <option value="KS">KANSAS</option>
                        <option value="KY">KENTUCKY</option>
                        <option value="LA">LOUISIANA</option>
                        <option value="ME">MAINE</option>
                        <option value="MH">MARSHALL ISLANDS</option>
                        <option value="MD">MARYLAND</option>
                        <option value="MA">MASSACHUSETTS</option>
                        <option value="MI">MICHIGAN</option>
                        <option value="MN">MINNESOTA</option>
                        <option value="MS">MISSISSIPPI</option>
                        <option value="MO">MISSOURI</option>
                        <option value="MT">MONTANA</option>
                        <option value="NE">NEBRASKA</option>
                        <option value="NV">NEVADA</option>
                        <option value="NH">NEW HAMPSHIRE</option>
                        <option value="NJ">NEW JERSEY</option>
                        <option value="NM">NEW MEXICO</option>
                        <option value="NY">NEW YORK</option>
                        <option value="NC">NORTH CAROLINA</option>
                        <option value="ND">NORTH DAKOTA</option>
                        <option value="MP">NORTHERN MARIANA ISLANDS</option>
                        <option value="OH">OHIO</option>
                        <option value="OK">OKLAHOMA</option>
                        <option value="OR">OREGON</option>
                        <option value="PW">PALAU</option>
                        <option value="PA">PENNSYLVANIA</option>
                        <option value="PR">PUERTO RICO</option>
                        <option value="RI">RHODE ISLAND</option>
                        <option value="SC">SOUTH CAROLINA</option>
                        <option value="SD">SOUTH DAKOTA</option>
                        <option value="TN">TENNESSEE</option>
                        <option value="TX">TEXAS</option>
                        <option value="UT">UTAH</option>
                        <option value="VT">VERMONT</option>
                        <option value="VI">VIRGIN ISLANDS</option>
                        <option value="VA">VIRGINIA</option>
                        <option value="WA">WASHINGTON</option>
                        <option value="WV">WEST VIRGINIA</option>
                        <option value="WI">WISCONSIN</option>
                        <option value="WY">WYOMING</option>
                        <option value="AP">ARMED FORCES PACIFIC</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="exampleInputCode" class="form-label">Zip Code:*</label>
                    <input type="text" class="form-control" id="exampleInputCode" aria-describedby="code" name="zip" value="{{isset($adminData->admin_info_single) ?$adminData->admin_info_single->zip: ''}}">
                </div>
             
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="exampleInputContact" class="form-label">Billing Email:*</label>
                            <div class="cont_wrapper">
                                <input type="text" class="form-control mb-2 mr-1 ml-1" id="exampleInputContact" name="billing_email" value="{{isset($adminData->admin_info_single) ?$adminData->admin_info_single->billing_email : ''}}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="exampleInputContact" class="form-label">Billing Phone:*</label>
                            <div class="cont_wrapper">
                                <input type="text" class="form-control mb-2 mr-1 ml-1" id="exampleInputContact" name="billing_phone" value="{{isset($adminData->admin_info_single) ?$adminData->admin_info_single->billing_phone : ''}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 language-select">
                    <div class="mb-3">
                        <label for="Type of Account" class="sect">Type of Account<span style="color: red"> * </span></label>
                        <select class="valid form-control" aria-invalid="false" title="How Did You Hear of Us?" id="department" name="deperment" required="">
                            <option value="" selected="">Choose Type of Account </option>
                            <option value="Law Firm/Legal Department" {{ $adminData->admin_info_single->type_of_account == "Law Firm/Legal Department" ? 'selected' : '' }}>Law Firm/Legal Department </option>
                            <option value="Party Without Attorney" {{ $adminData->admin_info_single->type_of_account == "Party Without Attorney" ? 'selected' : '' }}>Party Without Attorney </option>
                            <option value="Insurance Company" {{ $adminData->admin_info_single->type_of_account == "Insurance Company" ? 'selected' : '' }}>Insurance Company </option>
                            <option value="Government Agency" {{ $adminData->admin_info_single->type_of_account == "Government Agency" ? 'selected' : '' }}>Government Agency </option>
                            <option value="eFiling Fee Waiver (Pro Per)" {{ $adminData->admin_info_single->type_of_account == "eFiling Fee Waiver (Pro Per)" ? 'selected' : '' }}>eFiling Fee Waiver (Pro Per) </option>
                            <option value="Affiliate Partner" {{ $adminData->admin_info_single->type_of_account == "Affiliate Partner" ? 'selected' : '' }}>Affiliate Partner </option>
                            <option value="Paralegal" {{ $adminData->admin_info_single->type_of_account == "Paralegal" ? 'selected' : '' }}>Paralegal</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <label for="exampleInputContact" class="form-label">Billing Code Required?</label>
                    <div class="form-check mb-4">
                        <input class="form-check-input" name="billing_code" type="radio" value="Yes" 
                        {{ old('billing_code') === 'Yes'  ? 'checked' : '' }} id="flexCheckDefault" style="margin-left:0;">
                        <label class="form-check-label" for="flexCheckDefault">  Yes </label>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" checked name="billing_code" type="radio" value="No" id="flexCheckChecked2" style="margin-left:0;">
                        <label class="form-check-label" for="flexCheckChecked2">  No </label>
                    </div>
                    <label for="exampleInputContact" class="form-label">This is your internal billing reference, file or client matter number.</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script>
        $("#attorney").on('click', function(e) {
            if ($(this).prop('checked')) {
                $("#bar_id").prop('readonly', false);
                $("#bar_id").prop('required', true);
            } else {
                $("#bar_id").val('');
                $("#bar_id").prop('readonly', true);
                $("#bar_id").prop('required', false);
            }
        })
    </script>
@endsection
