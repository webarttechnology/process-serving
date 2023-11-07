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
                    <a class="nav-link active" id="accountTab" data-toggle="tab" href="#account" role="tab"
                        aria-controls="v-pills-profile" aria-selected="false">
                        <span class="font-weight-bold small text-uppercase">Account Information</span>
                    </a>
                    <a class="nav-link " id="paymentTab" data-toggle="tab" href="#payment" role="tab"
                        aria-controls="v-pills-messages" aria-selected="false">
                        <span class="font-weight-bold small text-uppercase">Payment Information</span>
                    </a>
                </div>
            </div>
            <div class="col-md-10 p-2">
                <!-- Tabs content -->
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade bg-white bg-sdw py-2 active show" id="account"
                        role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <form method="POST"  action="{{ url('update_account_info') }}">
                            @csrf
                            <div class="bxptyrtmain">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hdnngprt text-center">
                                            <h3>Account Information</h3>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="case-number">Name :</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Name"
                                                value="{{ isset($userInfo) ? $userInfo->name : ''; }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="case-number">Email :</label>
                                            
                                            <input type="text" class="form-control" name="email" id="email" disabled
                                                placeholder="Email" 
                                                value="{{ isset($userInfo) ? $userInfo->email : ''; }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="case-number">Phone :</label>
                                            <input type="text" class="form-control" name="phone" id="phone"
                                                placeholder="Phone"
                                                value="{{ isset($userInfo) ? $userInfo->phone : ''; }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="case-number">Address :</label>
                                            
                                            <input type="text" class="form-control" name="address" id="address"
                                                placeholder="Address" 
                                                value="{{ isset($extraInfo) ? $extraInfo->address : ''; }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="case-number">State :</label>
                                            <input type="text" class="form-control" name="state" id="state"
                                                placeholder="State"
                                                value="{{ isset($extraInfo) ? $extraInfo->billing_state : ''; }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="case-number">City :</label>
                                            
                                            <input type="text" class="form-control" name="city" id="city"
                                                placeholder="City" 
                                                value="{{ isset($extraInfo) ? $extraInfo->billing_city : ''; }}" required>
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
                                                    <button type="submit" class="ptrbtn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form method="POST"  action="{{ url('update_password_info') }}">
                            @csrf
                            <div class="bxptyrtmain">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="hdnngprt text-center">
                                            <h3>Change Password</h3>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="case-number">Password :</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password"
                                                 required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="case-number">Email :</label>
                                            
                                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" 
                                                placeholder="Confirm Password" 
                                                 required>
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
                                                    <button type="submit" class="ptrbtn">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade bg-white bg-sdw py-2 " id="payment"
                        role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <div class="bxptyrtmain">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection