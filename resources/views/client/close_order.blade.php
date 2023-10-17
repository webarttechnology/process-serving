@extends('commons.header')
@section('content')

<div class="content-wrapper">
    <div class="card">
       <div class="card-body">
          <div class="row">
             <div class="col-12">
                <div class="form_sec mb-4">
                   <form action="">
                      <div class="flexy">
                         <div class="mx-2">
                           <input type="date" class="form-control" placeholder="Date">
                         </div>
                         <div class="mx-2">
                           <input type="text" class="form-control" placeholder="Order #">
                         </div>
                         <div class="mx-2">
                           <input type="text" class="form-control" placeholder="Order Type">
                         </div>
                         <div class="mx-2">
                           <input type="text" class="form-control" placeholder="Filter By Case Name or Case Number">
                         </div>
                         <div class="mx-2">
                           <input type="text" class="form-control" placeholder="Filter by Jurisdiction Or Serve Entity & Address">
                         </div>
                      </div>
                   </form>
                </div>
                <div class="table-responsive cncl_tleb">
                   <div id="order-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                      <div class="row">
                         <div class="col-sm-12">
                            <table id="" class="table dataTable no-footer" role="grid" aria-describedby="order-listing_info">
                               <thead>
                                  <tr role="row">
                                     <th class="sorting_desc" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" aria-label="Order #: activate to sort column ascending" aria-sort="descending" style="width: 51.7969px;">Closed Date</th>
                                     <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" aria-label="Purchased On: activate to sort column ascending" style="width: 97.7969px;">Order #</th>
                                     <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" aria-label="Customer: activate to sort column ascending" style="width: 67.6562px;">Order Type</th>
                                     <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" aria-label="Ship to: activate to sort column ascending" style="width: 54.1875px;">Case</th>
                                     <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" aria-label="Base Price: activate to sort column ascending" style="width: 74.0312px;">Name & Location</th>
                                     <th class="sorting" tabindex="0" aria-controls="order-listing" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 63.0469px;">Status</th>
                                  </tr>
                               </thead>
                               <tbody>
                                     <tr class="odd">
                                     <td><a href="inner-page.html">05/30/2023</a></td>
                                     <td><a href="inner-page.html">7647457</a></td>
                                     <td>
                                        <a href="inner-page.html"><div style="font-weight:bold;padding-bottom:6px;">URGENT</div>
                                        <div>Service of Process</div></a>
                                     </td>
                                     <td>
                                        <a href="inner-page.html">
                                           <div style="padding-bottom:6px;">DEELS PROPERTIES MV LLC, A CA <br> LTD. LIAB. CO. vs JOSSUE ABAD, et al.</div>
                                           <div style="font-weight:bold">23CHUD00582</div>
                                        </a>
                                     </td>
                                     <td>
                                        <a href="inner-page.html">
                                           <div style="padding-bottom:6px;">BEN GHARAGOZLI</div>
                                           <div>200 S Barrington Ave#491488 <br> Los Angeles CA 90049</div>
                                        </a>
                                     </td>
                                     <td>
                                       <a href="inner-page.html"> <label class="badge badge-success">Closed</label></a>
                                     </td>
                                  </tr>
                                  <tr class="even">
                                     <td>05/30/2023</td>
                                     <td>7647457</td>
                                     <td>
                                        <div style="font-weight:bold;padding-bottom:6px;">URGENT</div>
                                        <div>Service of Process</div>
                                     </td>
                                     <td>
                                        <div style="padding-bottom:6px;">DEELS PROPERTIES MV LLC, A CA <br> LTD. LIAB. CO. vs JOSSUE ABAD, et al.</div>
                                        <div style="font-weight:bold">23CHUD00582</div>
                                     </td>
                                     <td>
                                        <div style="padding-bottom:6px;">BEN GHARAGOZLI</div>
                                        <div>200 S Barrington Ave#491488 <br> Los Angeles CA 90049</div>
                                     </td>
                                     <td>
                                        <label class="badge badge-success">Closed</label>
                                     </td>
                                  </tr>
                                  <tr class="odd">
                                     <td>05/30/2023</td>
                                     <td>7647457</td>
                                     <td>
                                        <div style="font-weight:bold;padding-bottom:6px;">URGENT</div>
                                        <div>Service of Process</div>
                                     </td>
                                     <td>
                                        <div style="padding-bottom:6px;">DEELS PROPERTIES MV LLC, A CA <br> LTD. LIAB. CO. vs JOSSUE ABAD, et al.</div>
                                        <div style="font-weight:bold">23CHUD00582</div>
                                     </td>
                                     <td>
                                        <div style="padding-bottom:6px;">BEN GHARAGOZLI</div>
                                        <div>200 S Barrington Ave#491488 <br> Los Angeles CA 90049</div>
                                     </td>
                                     <td>
                                        <label class="badge badge-success">Closed</label>
                                     </td>
                                  </tr>
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