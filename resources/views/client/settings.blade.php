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
                    <div class="tab-pane fade bg-white bg-sdw py-2 active show" id="account" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab">
                        <form method="POST" action="{{ url('update_account_info') }}">
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
                                                placeholder="Name" value="{{ isset($userInfo) ? $userInfo->name : '' }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="case-number">Email :</label>

                                            <input type="text" class="form-control" name="email" id="email"
                                                disabled placeholder="Email"
                                                value="{{ isset($userInfo) ? $userInfo->email : '' }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="case-number">Phone :</label>
                                            <input type="text" class="form-control" name="phone" id="phone"
                                                placeholder="Phone" value="{{ isset($userInfo) ? $userInfo->phone : '' }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="case-number">Address :</label>

                                            <input type="text" class="form-control" name="address" id="address"
                                                placeholder="Address"
                                                value="{{ isset($userInfo) ? $userInfo->adminInfo->address : '' }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="case-number">State :</label>
                                            <input type="text" class="form-control" name="state" id="state"
                                                placeholder="State"
                                                value="{{ isset($userInfo) ? $userInfo->adminInfo->billing_state : '' }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="case-number">City :</label>

                                            <input type="text" class="form-control" name="city" id="city"
                                                placeholder="City"
                                                value="{{ isset($userInfo) ? $userInfo->adminInfo->billing_city : '' }}"
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
                        <form method="POST" action="{{ url('update_password_info') }}">
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
                                                placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="case-number">Email :</label>

                                            <input type="password" class="form-control" name="confirm_password"
                                                id="confirm_password" placeholder="Confirm Password" required>
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
                    <div class="tab-pane fade bg-white bg-sdw py-2 " id="payment" role="tabpanel"
                        aria-labelledby="v-pills-profile-tab">
                        <div class="bxptyrtmain">
                            <p>By choosing to pay by check as your payment method, it is understood and agreed that you are
                                applying for Open Credit. If credit is granted, payment is due 15 days from the date of
                                service. In addition, a credit card will be used as a guarantee of payment and will be
                                charged for invoices that are not paid within 30 days from the date of service. All
                                transactions must be in U.S. dollars.</p>
                            <div class="text-right">
                                <button type="button" data-toggle="modal" data-target="#paymentModal"
                                    class="btn btn-primary mb-2 ">Edit</button>
                            </div>
                            <p><strong>Name on Card: </strong> <span
                                    class="float-right">{{ isset($paymentInfo[0]['person_name']) ? $paymentInfo[0]['person_name'] : '' }}</span>
                            </p>
                            <p><strong>Card Details: </strong> <span
                                    class="float-right">{{ isset($paymentInfo[0]['nickname']) ? $paymentInfo[0]['nickname'] : '' }}</span>
                            </p>
                            <p><strong>Billing Address:* </strong> <span
                                    class="float-right">{{ isset($paymentInfo[0]['address_1']) ? $paymentInfo[0]['address_1'] : '' }}</span>
                            </p>
                            @if (isset($paymentInfo[0]['address_city']))
                                <p><strong>Billing City/State/Zip:*
                                    </strong>
                                    <span
                                        class="float-right">{{ implode(', ', [$paymentInfo[0]['address_city'], $paymentInfo[0]['address_state'], $paymentInfo[0]['address_zip']]) }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <form method="post" id="payment-type-form" action="{{ url('update_payment_method') }}">
                    <input type="hidden" name="payment_token" id="payment_token">
                    <input type="hidden" name="stax_customer_id" id="stax_customer_id">
                    <input type="hidden" name="owner_id" id="owner_id" {{ $ownerId }}>
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Edit Payment Information
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div clss="row">
                            <div class="mb-3">
                                <span>Payment Type :</span><span style="color: red"> * </span>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="payment_type" value="ACH" checked=""> ACH
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="payment_type" value="Credit Card">
                                        Credit
                                        Card
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>First Name:</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Last Name:</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name">
                                </div>
                            </div>
                            <div id="ach-type">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Account Type:</label>
                                        <select class="valid form-control" aria-invalid="false" name="checking"
                                            required="">
                                            <option value="" selected="">Choose Account Type
                                            </option>
                                            <option value="Business Checking">Business Checking
                                            </option>
                                            <option value="Personal Checking">Personal Checking
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Tax ID:</label>
                                        <input type="text" class="form-control" id="tax_id"
                                            placeholder="Enter Tax ID" name="tax_id" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Account Holder Name:</label>
                                        <input type="text" class="form-control" id="acc_holder_name"
                                            placeholder="Enter Account Holder Name" name="acc_holder_name"
                                            required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Bank Name:</label>
                                        <input type="text" class="form-control" id="bank_name"
                                            placeholder="Enter Bank Name" name="bank_name" required="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label>Bank Account Number:</label>
                                        <input type="text" class="form-control" id="bank_acc_number"
                                            placeholder="Enter Bank Account Number" name="bank_acc_number"
                                            required="">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label>Bank Routing Number:</label>
                                        <input type="text" class="form-control" id="bank_routing_number"
                                            placeholder="Enter Bank Routing Number" name="bank_routing_number"
                                            required="">
                                    </div>
                                </div>
                            </div>
                            <div id="card-type" style="display: none;">
                                <div class="row">
                                    <div id="card-number" style="height:45px;" class="col-md-6 mb-3"></div>
                                    <div id="card-cvv" style="height:45px;" class="col-md-6 mb-3"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">Expiry Month</label>
                                        <select class="valid form-control" aria-invalid="false" name="expiry_month"
                                            id="expiry_month" required="">
                                            <option selected="">Select Expiry Month</option>
                                            <option value="01">Jan</option>
                                            <option value="02">Feb</option>
                                            <option value="03">Mar</option>
                                            <option value="04">Apr</option>
                                            <option value="05">May</option>
                                            <option value="06">Jun</option>
                                            <option value="07">Jul</option>
                                            <option value="08">Aug</option>
                                            <option value="09">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Expiry Year</label>
                                        <select class="valid form-control" aria-invalid="false" name="expiry_year"
                                            id="expiry_year" required="">
                                            <option selected="">Select Expiry Year</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                            <option value="2031">2031</option>
                                            <option value="2032">2032</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Billing Address:</label>
                                    <input type="text" class="form-control" id="billing_address"
                                        placeholder="Enter Billing Address" name="billing_address" required="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Billing State:</label>
                                    <input type="text" class="form-control" id="billing_state"
                                        placeholder="Enter Billing State" name="billing_state" required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label>Billing City:</label>
                                    <input type="text" class="form-control" id="billing_city"
                                        placeholder="Enter Billing City" name="billing_city" required="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Billing Zip:</label>
                                    <input type="text" class="form-control" id="billing_zip"
                                        placeholder="Enter Billing Zip" name="billing_zip" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script src="https://staxjs.staxpayments.com/stax.js?nocache=2"></script>
    <script>
        $("input[name='payment_type']").on('change', function(e) {
            e.preventDefault();

            if ($(this).val() == 'ACH') {
                $("#ach-type").show();
                $("#card-type").hide();
            } else {
                $("#ach-type").hide();
                $("#card-type").show();
            }
        });

        var staxjs = new StaxJs("Sayandip-7e0bc1aa119c", {
            number: {
                id: 'card-number', // the html id of the div you want to contain the credit card number field
                placeholder: '0000 0000 0000 0000', // the placeholder the field should contain
                style: 'height: 30px;border: 1px solid #ced4da;font-size: 15 px;padding: 0.375rem 0.75rem;border-radius: 0.25rem;', // the style to apply to the field
                type: 'text', // the input type (optional)
                format: 'prettyFormat' // the formatting of the CC number (prettyFormat || plainFormat || maskedFormat)
            },
            cvv: {
                id: 'card-cvv', // the html id of the div you want to contain the cvv field
                placeholder: 'CVV', // the placeholder the field should contain
                style: 'height: 30px;border: 1px solid #ced4da;font-size: 15 px;padding: 0.375rem 0.75rem;border-radius: 0.25rem;', // the style to apply to the field
                type: 'text' // the input type (optional)
            }
        });

        // console.log(staxjs);

        staxjs.showCardForm().then(handler => {
                console.log(handler);
            })
            .catch((err) => {
                console.log("there was an error loading the form: ", err);
            });

        document.querySelector('#submitButton').onclick = (e) => {
            e.preventDefault();
            var errorStr = '';
            if ($("#billing_address").val() == '') {
                errorStr += 'Billing Address is empty';
            } else if ($("#billing_state").val() == '') {
                errorStr += 'Billing Address is empty';
            } else if ($("#billing_city").val() == '') {
                errorStr += 'Billing City is empty';
            } else if ($("#billing_zip").val() == '') {
                errorStr += 'Billing Zip is empty';
            }

            if (errorStr != '') {
                return toastr.error(errorStr);
            }

            var form = document.querySelector('#payment-type-form');
            if ($("input[name='payment_type']:checked").val() !== 'ACH') {
                var extraDetails = {
                    total: 1,
                    address_zip: $("#billing_zip").val(),
                    firstname: $("#first_name").val(),
                    lastname: $("#last_name").val(),
                    month: $('#expiry_month').val(),
                    year: $('#expiry_year').val(),
                    address_1: $("#billing_address").val(),
                    address_city: $("#billing_city").val(),
                    address_state: $("#billing_state").val(),
                    reference: "23452",
                    // url: "https://app.staxpayments.com/#/bill/",
                    method: 'card',
                    validate: false,
                    customer_id: '{{ $customerId }}'
                };

            } else {
                var extraDetails = {
                    firstname: $("#first_name").val(),
                    lastname: $("#last_name").val(),
                    person_name: $("#acc_holder_name").val(),
                    method: "bank",
                    address_zip: $("#billing_zip").val(),
                    bank_type: "savings",
                    bank_name: $('#bank_name').val(),
                    bank_account: $('#bank_acc_number').val(),
                    bank_routing: $('#bank_routing_number').val(),
                    bank_holder_type: "personal",
                    address_1: $("#billing_address").val(),
                    address_city: $("#billing_city").val(),
                    address_state: $("#billing_state").val(),
                    reference: "23452",
                    validate: false,
                    match_customer: false,
                    customer_id: '{{ $customerId }}'
                };

                // $("form").trigger('submit');
            }

            staxjs.tokenize(extraDetails).then((result) => {
                    if (result) {
                        $("#payment_token").val(result.id);
                        $("#stax_customer_id").val(result.customer_id);
                        console.log(result);
                        // form.submit();
                        window.location.reload();
                    }
                })
                .catch((err) => {
                    console.log(err);
                    if ($("input[name='payment_type']:checked").val() === 'ACH') {
                        if (err.errors) {
                            var errorString = err.errors.join('<br>');
                        } else {

                            var errorString = "";
                            for (var key in err) {
                                if (err.hasOwnProperty(key)) {
                                    var errors = err[key];
                                    errorString += errors.join('<br>') + '<br>';
                                }
                            }
                        }
                        toastr.error(errorString);
                    } else {
                        if ($("#card-cvv").val() == '') {
                            toastr.error("Card cvv is required");
                        } else {
                            if (err.address_state) {
                                toastr.error(err.address_state[0]);
                            } else {
                                toastr.error(err.message);
                            }
                        }
                    }
                });
        }
    </script>
@endsection
