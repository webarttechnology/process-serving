@extends('commons.header')
@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class=" cncl_tleb">
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
                                                        aria-label="Status">Status</th>

                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ship to: activate to sort column ascending">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>#{{ $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>
                                                            @switch($user->open_credit_verify)
                                                                @case(0)
                                                                    <p class="text-warning">Pending</p>
                                                                    @break
                                                                @case(1)
                                                                    <p class="text-success">Approved</p>
                                                                    @break
                                                                @default
                                                                    <p class="text-danger">Rejected</p>
                                                            @endswitch
                                                        </td>
                                                        <td>
                                                            @if ($user->open_credit_verify == 0)
                                                                <a style="color:#fff"
                                                                    href="{{ url('approve-user-credit/' . $user->id) }}"
                                                                    class="btn btn-success my-1 mx-1"
                                                                    onclick="return confirm('Are you sure you want to approve?')">
                                                                    Approve
                                                                </a>
                                                                <a style="color:#fff"
                                                                    href="{{ url('reject-user-credit/' . $user->id) }}"
                                                                    class="btn btn-danger my-1 mx-1"
                                                                    onclick="return confirm('Are you sure you want to reject?')">
                                                                    Reject
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
