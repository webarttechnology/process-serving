@extends('commons.header')
@section('content')
    <div class="model-wrapper">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Acount Information</h5>
        </div>
        <div class="modal-body">
            <form class="row">
                <div class="col-md-6 mb-4">
                    <label for="exampleInputName" class="form-label">Organization Name:</label>
                    <input type="text" class="form-control" id="exampleInputName" aria-describedby="name" value="Tester"
                        readonly>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="Last Name" class="sect">Attorney<span style="color: red">
                                *
                            </span> <input type="checkbox" id="attorney" name="attorney"></label>
                        <input placeholder="Enter Bar Id" type="text" class="form-control" id="bar_id" name="bar_id"
                            readonly="">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="exampleInputContact" class="form-label">Email:*</label>
                            <div class="cont_wrapper">
                                <input type="text" class="form-control mb-2 mr-1 ml-1" id="exampleInputContact"
                                    aria-describedby="contact">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="exampleInputContact" class="form-label">Phone:*</label>
                            <div class="cont_wrapper">
                                <input type="text" class="form-control mb-2 mr-1 ml-1" id="exampleInputContact"
                                    aria-describedby="contact">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="exampleInputAddress" class="form-label">Address 1:*</label>
                    <input type="text" class="form-control" id="exampleInputAddress" aria-describedby="address">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="exampleInputAddress" class="form-label">Address 2</label>
                    <input type="text" class="form-control" id="exampleInputAddress" aria-describedby="address">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="exampleInputCity" class="form-label">City:*</label>
                    <input type="text" class="form-control" id="exampleInputCity" aria-describedby="city">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="exampleInputAddress" class="form-label">State:*</label>
                    <select class="form-select form-select-sm form-control" aria-label=".form-select-sm example">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>

                <div class="col-md-6 mb-4">
                    <label for="exampleInputCode" class="form-label">Zip Code:*</label>
                    <input type="text" class="form-control" id="exampleInputCode" aria-describedby="code">
                </div>
                <div class="col-md-6 mb-4">
                    <label for="exampleInputAddress" class="form-label">Password:*</label>
                    <input type="password" class="form-control">
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="exampleInputContact" class="form-label">Billing Email:*</label>
                            <div class="cont_wrapper">
                                <input type="text" class="form-control mb-2 mr-1 ml-1" id="exampleInputContact"
                                    aria-describedby="contact">
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="exampleInputContact" class="form-label">Billing Phone:*</label>
                            <div class="cont_wrapper">
                                <input type="text" class="form-control mb-2 mr-1 ml-1" id="exampleInputContact"
                                    aria-describedby="contact">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 language-select">
                    <div class="mb-3">
                        <label for="Type of Account" class="sect">Type of
                            Account<span style="color: red"> * </span></label>
                        <select class="valid form-control" aria-invalid="false" title="How Did You Hear of Us?"
                            id="department" name="deperment" required="">
                            <option value="" selected="">Choose Type of Account
                            </option>
                            <option value="Law Firm/Legal Department">Law Firm/Legal
                                Department
                            </option>
                            <option value="Party Without Attorney">Party Without
                                Attorney
                            </option>
                            <option value="Insurance Company">Insurance Company
                            </option>
                            <option value="Government Agency">Government Agency
                            </option>
                            <option value="eFiling Fee Waiver (Pro Per)">eFiling Fee
                                Waiver (Pro Per)
                            </option>
                            <option value="Affiliate Partner">Affiliate Partner
                            </option>
                            <option value="Paralegal">Paralegal
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
                    <label for="exampleInputContact" class="form-label">Billing Code Required?</label>

                    <div class="form-check mb-4">
                        <input class="form-check-input" name="demo" type="radio" value=""
                            id="flexCheckDefault" style="margin-left:0;">
                        <label class="form-check-label" for="flexCheckDefault">
                            Yes
                        </label>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" name="demo" type="radio" value=""
                            id="flexCheckChecked2" style="margin-left:0;">
                        <label class="form-check-label" for="flexCheckChecked2">
                            No
                        </label>
                    </div>
                    <label for="exampleInputContact" class="form-label">This is your internal billing reference, file or
                        client matter number.</label>
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
