@extends('commons.header')
@section('content')
    

<div class="main-panel dashboard_page">
         <!---------Main Panel----------->
            <div class="content-wrapper">
               <div class="row">
                  <div class="col-md-12 grid-margin">
                     <div class="row">
                        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                           <h3 class="font-weight-bold">Welcome Aamir</h3>
                           <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span class="text-primary">3 unread alerts!</span></h6>
                        </div>
                        <!-- <div class="col-12 col-xl-4">
                           <div class="justify-content-end d-flex">
                              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                 <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                 <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                 </button>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                 </div>
                              </div>
                           </div>
                        </div> -->
                     </div>
                  </div>
               </div>
               <div class="row">
                  <!-- <div class="col-md-12 grid-margin stretch-card">
                     <div class="card tale-bg">
                       <div class="card-people mt-auto">
                         <img src="images/dashboard/people.svg" alt="people">
                       </div>
                     </div>
                     </div> -->
                  <div class="col-md-6 mb-4 stretch-card transparent">
                     <div class="card card-green">
                        <div class="card-body cardmxy">
                           <div class="leftprt">
                              <h3 class="mb-2">Place an Order</h3>
                              <p>Place an electronic or physical order.</p>
                              <h2>05</h2>
                           </div>
                           <div class="rightprt">
                              <h2 class="mb-3"><i class="bi bi-arrow-right"></i></h2>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 mb-4 stretch-card transparent">
                     <div class="card card-light-blue">
                        <div class="card-body cardmxy">
                           <div class="leftprt">
                              <h3 class="mb-2">Manage Cases</h3>
                              <p>View, print and download case details, <br> associated orders and documents.</p>
                              <h2>11</h2>
                           </div>
                           <div class="rightprt">
                              <h2 class="mb-3"><i class="bi bi-file-earmark"></i></h2>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 stretch-card transparent">
                     <div class="card card-ble">
                        <div class="card-body cardmxy">
                           <div class="leftprt">
                              <h3 class="mb-2">Closed Orders</h3>
                              <p>View completed orders and associated documents <br> such as Conformed Copies and Proofs of Service.</p>
                              <h2>13</h2>
                           </div>
                           <div class="rightprt">
                              <h2><i class="bi bi-card-list"></i></h2>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                     <div class="card card-light-danger">
                        <div class="card-body cardmxy">
                           <div class="leftprt">
                              <h3 class="mb-2">Pending Orders</h3>
                              <p>View status updates on your pending orders.</p>
                              <h2>09</h2>
                           </div>
                           <div class="rightprt">
                              <h2><i class="bi bi-list-ul"></i></h2>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12 grid-margin stretch-card">
                     <div class="card cardxyt mt-5">
                        <div class="card-body">
                           <div class="d-flex card_head justify-content-between">
                              <p class="card-title mb-0">Recent Orders</p>
                              <p class="card-title mb-0"><a href="#">View Pending Orders</a></p>
                           </div>
                           <div class="table-responsive shadow-main">
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Order</th>
                                       <th>Details</th>
                                       <th>Status</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>6/02:#7673323-05 Process Serving</td>
                                       <td class="font-weight-bold">Plaintiff, Main v. MAIN DEFENDANT SOME BUSINESS</td>
                                       <td>Dispatched</td>
                                    </tr>
                                    <tr>
                                       <td>6/02:#7673323-04 Process Serving</td>
                                       <td class="font-weight-bold">Plaintiff, Main v. MAIN DEFENDANT XYC LLC</td>
                                       <td>Dispatched</td>
                                    </tr>
                                    <tr>
                                       <td>6/02:#7673323-03 Process Serving</td>
                                       <td class="font-weight-bold">Plaintiff, Main v. MAIN DEFENDANT ABC CORP</td>
                                       <td>Dispatched</td>
                                    </tr>
                                    <tr>
                                       <td>6/02:#7673323-02 Process Serving</td>
                                       <td class="font-weight-bold">Plaintiff, Main v. MAIN DEFENDANT Jane Doe 1</td>
                                       <td>Dispatched</td>
                                    </tr>
                                    <tr>
                                       <td>6/02:#7673323-01 Process Serving</td>
                                       <td class="font-weight-bold">Plaintiff, Main v. MAIN DEFENDANT John Doe 1</td>
                                       <td>Dispatched</td>
                                    </tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 grid-margin stretch-card">
                     <div class="card cardxyt">
                        <div class="card-body">
                           <div class="d-flex card_head justify-content-between">
                              <p class="card-title mb-0">Recent Cases</p>
                              <p class="card-title mb-0"><a href="#">Manage Cases</a></p>
                           </div>
                           <div class="table-responsive shadow-main">
                              <table class="table table-bordered">
                                 <thead>
                                    <tr>
                                       <th>Case</th>
                                       <th>Jurisdiction</th>
                                       <th>Action</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                       <td>0001234 Plaintiff, Main v. MAIN DEFENDANT</td>
                                       <td class="font-weight-bold">Los Angeles Stanley Mosk Central Courthouse</td>
                                       <td><a href="#">Place Order</a></td>
                                    </tr>
                                    <tr>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            

            <footer class="footer">
               <div class="d-sm-flex justify-content-center justify-content-sm-between">
                  <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023. <a href="#" target="_blank">Designed By Webart Technology</span>
                  <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Lorem Ipsum Dolor <i class="ti-heart text-danger ml-1"></i></span>
               </div>
            </footer>
            <!-- partial -->
         </div>
@endsection