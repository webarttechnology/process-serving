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
                                                    aria-label="Purchased On: activate to sort column ascending"
                                                    >Order #</th>
                                                    <th class="sorting_desc" tabindex="0"
                                                            aria-controls="order-listing" rowspan="1" colspan="1"
                                                            aria-label="Order #: activate to sort column ascending"
                                                            aria-sort="descending" >Date
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Customer: activate to sort column ascending"
                                                        >Case No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ship to: activate to sort column ascending"
                                                        >Jurisdiction</th>
                                                    <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Ship to: activate to sort column ascending"
                                                        >Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($orders as $order)
                                                    @php if( empty($order->case) ) continue; @endphp
                                                    <tr class="odd">
                                                        <td>{{ $order->order_id }}</td>
                                                        <td>{{ date('m-d-Y',strtotime( $order->updated_at)) }}</td>
                                                        <td>
                                                            <div><strong>{{ isset($order->case->case_title) ? $order->case->case_title : '' }}</strong></div>
                                                            <div>{{ isset($order->case->case_no) ? $order->case->case_no : '' }}</div>
                                                        </td>
                                                        <td>{!! $order->case->jurisdiction !!}</td>
                                                        <td>
                                                            <a  href="{{ route('edit_draft_order', ['id' => $order->id]) }}">
                                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                            </a>
                                                            <a href="#!" onclick="deleteOrder(this, {{ $order->id }})">
                                                                <i class="fa fa-times ml-2 text-danger" aria-hidden="true"></i>
                                                            </a>
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
