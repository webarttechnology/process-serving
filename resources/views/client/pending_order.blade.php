@extends('commons.header')
@section('content')
    <div class="main-panel cancel_order">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="cncl_tleb">
                                <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <div class="row">
                                        <div class="col-sm-12 table-responsive">
                                            <table id="pending-order-table" class="table dataTable no-footer" role="grid"
                                                aria-describedby="order-listing_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting_desc" tabindex="0"
                                                            aria-controls="order-listing" rowspan="1" colspan="1"
                                                            aria-label="Order #: activate to sort column ascending"
                                                            aria-sort="descending">Date
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Purchased On: activate to sort column ascending">
                                                            Order #</th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Customer: activate to sort column ascending">Order
                                                            Type</th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Ship to: activate to sort column ascending">Case
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Base Price: activate to sort column ascending">Name
                                                            & Location</th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Status: activate to sort column ascending">Status
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        <tr class="odd">
                                                            <td><a
                                                                    href="pending-inrpg.html">{{ date('m-d-y', strtotime($order->updated_at)) }}</a>
                                                            </td>
                                                            <td><a href="pending-inrpg.html">{{ $order->order_id }}</a></td>
                                                            <td>
                                                                <div class="mb-1">
                                                                    @if (is_array(json_decode($order->attempt_type, true)))
                                                                        @foreach (json_decode($order->attempt_type, true) as $index => $type)
                                                                        @php
                                                                            $time = json_decode($order->attempt_time, true);
                                                                        @endphp
                                                                            <strong style="text-transform: capitalize">
                                                                                {{ $type }} Service
                                                                            </strong>
                                                                            <div>{{ $time[$index] }}</div>
                                                                            <br>
                                                                        @endforeach
                                                                    @else
                                                                        <strong style="text-transform: capitalize">
                                                                            {{ $order->attempt_type }}
                                                                        </strong>
                                                                        <div>{{ $order->attempt_time }}</div>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>
                                                                    <strong>{{ isset($order->case->case_title) ? $order->case->case_title : '' }}</strong>
                                                                </div>
                                                                <div>
                                                                    {{ isset($order->case->case_no) ? $order->case->case_no : '' }}
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div>{{ $order->case->jurisdiction }}</div>
                                                            </td>
                                                            <td>
                                                                <a href="pending-inrpg.html"> <label
                                                                        class="badge badge-danger">Pending</label></a>
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
    </div>
@endsection
