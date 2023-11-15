@extends('commons.header')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class=" cncl_tleb">
                            <a href="#!" data-toggle="modal" data-target="#invite-modal"
                                class="float-right btn btn-secondary text-white mb-3 ml-3">Invite User</a>
                            <a href="{{ url('add-user') }}" class="float-right btn btn-primary text-white mb-3">Add User</a>
                            <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row">
                                    <div class="col-sm-12 table-responsive">
                                        <table id="draft-order-table" class="table dataTable no-footer" role="grid"
                                            aria-describedby="order-listing_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Purchased On: activate to sort column ascending">User
                                                        id</th>
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Purchased On: activate to sort column ascending">User
                                                        Name</th>
                                                    <th class="sorting_desc" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Order #: activate to sort column ascending"
                                                        aria-sort="descending">Email
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Customer: activate to sort column ascending">Phone</th>
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ship to: activate to sort column ascending">Role</th>
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ship to: activate to sort column ascending">Attorney
                                                    </th>

                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ship to: activate to sort column ascending">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ship to: activate to sort column ascending">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($adminData as $admin)
                                                    <tr class="odd">
                                                        <td>{{ $admin->id }}</td>
                                                        <td>{{ $admin->name }}</td>
                                                        <td>{{ $admin->email }}</td>
                                                        <td>{{ $admin->phone }}</td>
                                                        <td>
                                                            @php
                                                                switch ($admin->role) {
                                                                    case 'staff':
                                                                        echo 'Staff';
                                                                        break;
                                                                    case 'owner_admin':
                                                                        echo 'Owner Admin';
                                                                        break;
                                                                    case 'admin':
                                                                        echo 'Admin';
                                                                        break;

                                                                    default:
                                                                        # code...
                                                                        break;
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td>{{ $admin->attorney ? 'Yes' : 'No' }}</td>
                                                        <td style="color:#008000">Active</td>
                                                        <td>
                                                            <a href=""
                                                                class="btn btn-primary text-white my-1 mx-1 details-view"
                                                                data-id="{{ $admin->id }}" data-toggle="modal"
                                                                data-target="#exampleModal">View
                                                            </a>
                                                            <a style="color:#fff"
                                                                href="{{ url('edit-user/' . $admin->id) }}"
                                                                class="btn btn-success my-1 mx-1">
                                                                Edit
                                                            </a>
                                                            <a style="color:#fff"
                                                                href="{{ url('delete-user/' . $admin->id) }}"
                                                                class="btn btn-danger my-1 mx-1"
                                                                onclick="return confirm('Are you sure you want to delete this record?')">
                                                                Delete
                                                            </a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="modal fade" id="invite-modal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Invite a user
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('inviteUser') }}" method="post"
                                                        id="invite-user">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div clss="row">
                                                                <div class="form-group">
                                                                    <label for="">Email Id</label>
                                                                    <input type="email" class="form-control"
                                                                        name="email">

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="">Role</label>
                                                                    <Select class="form-control" name="role">
                                                                        <option value="admin">Admin</option>
                                                                        <option value="staff">Staff</option>
                                                                    </Select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Invite</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Acount Information
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div clss="row">
                                                            <div class="col-md-12 mb-3">
                                                                <strong> Name:</strong>
                                                                <span id="name"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>Email:</strong>
                                                                <span id="email"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>Phone Number:</strong>
                                                                <span id="phone"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>Address :</strong>
                                                                <span id="address"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>City:</strong>
                                                                <span id="city"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>State:</strong>
                                                                <span id="state"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>Zip Code:</strong>
                                                                <span id="zip"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>Billing Email:</strong>
                                                                <span id="billing_email"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>Billing Contact:</strong>
                                                                <span id="billing_contact"></span>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <strong>Type Of Account:</strong>
                                                                <span id="type_of_account"></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
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
    </div>
@endsection



<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


<script>
    $(document).ready(function() {
        $('.details-view').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '{{ url('account-details') }}' + "/" + id,
                type: 'GET',
                dataType: 'json',
                success: function(details) {
                    console.log(details);
                    $('#name').text(details.name);
                    $('#email').text(details.email);
                    $('#phone').text(details.phone);
                    $('#address').text(details.admin_info_single.address);
                    $('#city').text(details.admin_info_single.billing_city);
                    $('#state').text(details.admin_info_single.billing_state);
                    $('#zip').text(details.admin_info_single.zip);
                    $('#billing_email').text(details.admin_info_single.billing_email);
                    $('#billing_contact').text(details.admin_info_single.billing_phone);
                    $('#type_of_account').text(details.admin_info_single.type_of_account);
                },
                error: function(error) {
                    console.error('Ajax request failed: ', error);
                }
            });
        });

    });
</script>
