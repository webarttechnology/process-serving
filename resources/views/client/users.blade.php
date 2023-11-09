@extends('commons.header')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class=" cncl_tleb">
                            <a href="#!" data-toggle="modal" data-target="#invite-modal"
                                class="float-right btn btn-secondary text-white mb-3 ml-3">Invite
                                User</a>
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
                                                    {{-- <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ship to: activate to sort column ascending">Bar#</th> --}}
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
                                                    <td>{{$admin->id}}</td>
                                                    <td>{{$admin->name}}</td>
                                                    <td>{{$admin->email}}</td>
                                                    <td>{{$admin->phone}}</td>
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
                                                    <td>{{$admin->attorney ? 'Yes' : 'No'}}</td>
                                                    <td style="color:#008000">Active</td>
                                                    <td>
                                                        <a href="" class="btn btn-primary text-white my-1 mx-1"
                                                            data-toggle="modal" data-target="#exampleModal">
                                                            {{-- <i class="fa fa-eye" aria-hidden="true"></i> --}}
                                                            View
                                                        </a>
                                                        <a style="color:#fff" href="{{url('edit-user/'.$admin->id)}}" class="btn btn-success my-1 mx-1">
                                                            <!--<i class="fa fa-pencil" aria-hidden="true"></i>-->
                                                            Edit
                                                        </a>
                                                        <a style="color:#fff" href="#!" class="btn btn-danger my-1 mx-1">
                                                            <!--<i class="fa fa-times ml-2 text-danger" aria-hidden="true"></i>-->
                                                            delete
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
                                                    <div class="modal-body">
                                                        <div clss="row">
                                                            <div class="form-group">
                                                                <label for="">Email Id</label>
                                                                <input type="email" class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Role</label>
                                                                <Select class="form-control">
                                                                    <option value="admin">Admin</option>
                                                                    <option value="staff">Staff</option>
                                                                </Select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary"
                                                            data-dismiss="modal">Invite</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
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
                                                            <div class="col-md-12 mb-3"><strong>Organization Name:</strong>
                                                                Dennis P. Block</div>
                                                            <div class="col-md-12 mb-3"><strong>Address 1:*</strong> 455 N.
                                                                Moss St.</div>
                                                            <div class="col-md-12 mb-3"><strong>Address 2:</strong></div>
                                                            <div class="col-md-12 mb-3"><strong>City:*</strong> Burbank
                                                            </div>
                                                            <div class="col-md-12 mb-3"><strong>State:*</strong> California
                                                            </div>
                                                            <div class="col-md-12 mb-3"><strong>Zip Code:*</strong> 91502
                                                            </div>
                                                            <div class="col-md-12 mb-3"><strong>Primary Billing
                                                                    Contact:*</strong> Galina, Dennis@evict123.com, 323
                                                                938-2868</div>
                                                            <div class="col-md-12 mb-3"><strong>Secondary Billing
                                                                    Contact:</strong> </div>
                                                            <div class="col-md-12"><strong>Billing Code Required?</strong>
                                                                Yes</div>
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
