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
                                                            aria-label="Job ID" aria-sort="descending">Job Id
                                                        </th>
                                                        <th class="sorting_desc" tabindex="0"
                                                            aria-controls="order-listing" rowspan="1" colspan="1"
                                                            aria-label="Servee Name" aria-sort="descending">Name
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1" aria-label="Job Type">Job Type
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1"
                                                            aria-label="Hearing Date/Hearing Time<">Hearing Date/Hearing
                                                            Time</th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1" aria-label="Charges">Charges
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="order-listing"
                                                            rowspan="1" colspan="1" aria-label="Action">Action
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order['Defendants']['Defendant'] as $orderInfo)
                                                        @php
                                                            if ($orderInfo['Jobs']['Job']['JobNum'] == '4157463') {
                                                                // dd($orderInfo);
                                                            }
                                                        @endphp
                                                        <tr class="odd">
                                                            <td>#{{ $orderInfo['Jobs']['Job']['JobNum'] }}</td>
                                                            <td>{{ $orderInfo['Name'] }}</td>
                                                            <td>{{ $orderInfo['Jobs']['Job']['JobType'] }}</td>
                                                            <td>{{ $orderInfo['Jobs']['Job']['HearingDate'] . ' / ' . $orderInfo['Jobs']['Job']['HearingTime'] }}
                                                            </td>
                                                            <td>${{ $orderInfo['Jobs']['Job']['Charges']['Charge']['Amount'] }}
                                                            </td>
                                                            <td>
                                                                <a class="btn btn-primary text-white" href="{{ route('chargeJob', ['id' => $id, 'amount' => $orderInfo['Jobs']['Job']['Charges']['Charge']['Amount']]) }}">Charge</a>

                                                                @if (isset($orderInfo['Jobs']['Job']['Attachments']['Attachment']['doctype']))
                                                                    @if (Str::endsWith($orderInfo['Jobs']['Job']['Attachments']['Attachment']['doctype'], '_Proof'))
                                                                        <a target="_blank" class="btn btn-primary" href="{{ route('downloadLdmaxAttatchments3', ['id' => $orderInfo['Jobs']['Job']['Attachments']['Attachment']['AttachmentID']]) }}">Download POF</a>
                                                                    @endif
                                                                @else
                                                                    @foreach ($orderInfo['Jobs']['Job']['Attachments']['Attachment'] as $key3 => $value3)
                                                                        @if (Str::endsWith($value3['doctype'], '_Proof'))
                                                                            <a target="_blank" class="btn btn-primary text-white" href="{{ route('downloadLdmaxAttatchments3', ['id' =>$value3['AttachmentID']]) }}">Download POF</a>
                                                                        @endif
                                                                    @endforeach
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
    </div>
@endsection
