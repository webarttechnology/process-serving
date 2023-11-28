<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
<xsl:template match="Header"> 
	<div class="page-wrapper">
			<div class="page-content">
				<!-- <div class="row row-cols-1 row-cols-lg-4 row-cols-xl-4 dashboard">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body blck">
								<div class="d-flex align-items-center">
									<div class="widgets-icons"><i class="bi bi-arrow-right-circle-fill"></i>
									</div>
									<div class=" ms-auto">
										<h4 class="my-1">Place an Order</h4>
										<div class="dropdown">
											<button class="dropbtn">Choose here  <i class="bi bi-caret-down"></i></button>
											<div class="dropdown-content">
												<a href="courtfiling.php">Court Filing</a>
												<a href="#">Skip Tracing</a>
												<a href="#">Process Serving</a>
												<a href="#">eRecording Service</a>
												<a href="#">Courtesy Copy</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body blck">
								<div class="d-flex align-items-center">
									<div class="widgets-icons"><i class="bi bi-file-earmark"></i>
									</div>
									<div class=" ms-auto">
										<xsl:comment> <p class="mb-0">459</p> </xsl:comment>
										<h4 class="my-1">Manage Cases (2823)</h4>
										<div class="dropdown">
											<button class="dropbtn">Choose here  <i class="bi bi-caret-down"></i></button>
											<div class="dropdown-content">
												<a href="#">Court Filing</a>
												<a href="#">Skip Tracing</a>
												<a href="#">Process Serving</a>
												<a href="#">eRecording Service</a>
												<a href="#">Courtesy Copy</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
							<div class="card radius-10">
								<div class="card-body blck">
									<div class="d-flex align-items-center">
										<div class="widgets-icons"><i class="bi bi-list-ul"></i>
										</div>
										<div class="ms-auto">
											<xsl:comment> <p class="mb-0">500</p> </xsl:comment>
											<h4 class="my-1">Pending Orders (<xsl:value-of select="Info/PendingJobs"/>)</h4>
											<div class="dropdown">
												<button class="dropbtn">Choose here  <i class="bi bi-caret-down"></i></button>
												<div class="dropdown-content">
													<a href="#">Court Filing</a>
													<a href="#">Skip Tracing</a>
													<a href="#">Process Serving</a>
													<a href="#">eRecording Service</a>
													<a href="#">Courtesy Copy</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
					<div class="col-lg-12">
						<div class="card radius-10">
							<div class="card-body blck">
								<div class="d-flex align-items-center">
									<div class="widgets-icons"><i class="bi bi-list-stars"></i>
									</div>
									<div class="ms-auto">
										<xsl:comment> <p class="mb-0">500</p> </xsl:comment>
										<h4 class="my-1">Closed Orders</h4>
										<div class="dropdown">
											<button class="dropbtn">Choose here  <i class="bi bi-caret-down"></i></button>
											<div class="dropdown-content">
												<a href="#">Court Filing</a>
												<a href="#">Skip Tracing</a>
												<a href="#">Process Serving</a>
												<a href="#">eRecording Service</a>
												<a href="#">Courtesy Copy</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> -->
                <!-- ================================================================================================== -->
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                        <div class="col mb-4" style="width:260px;">
                            <div class="card" style="height:500px;background-color:white;border-radius:20px;">
                                <div class="card-body">
                                    <h5 class="card-title" style="background-color:#0dcaf0;padding:5px"><i class="bi bi-arrow-right-circle-fill"></i>   Place an Order</h5>
                                    <div class="card-text" style="color:black;">
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Court Filing</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Skip Tracing</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Process Serving</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">eRecording Service</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Courtesy Copy</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Courtesy Copy</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Courtesy Copy</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Courtesy Copy</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" style="width:260px;">
                            <div class="card" style="height:500px;background-color:white;border-radius:20px;">
                                <div class="card-body">
                                    <h5 class="card-title" style="background-color:#0dcaf0;padding:5px"><i class="bi bi-file-earmark"></i>RecentOrders(28)</h5>
                                    <div class="card-text" style="color:black;">
                                        <span style="font-size:12px;margin-top:10px;">Find an order</span>
                                        <div style="margin-bottom:10px;">
                                            <input type="text" placeholder="Name, number, client billing code,.."/>
                                            <i class="bi bi-search" style="background-color:#0dcaf0;color:white;padding:6px 10px 6px 10px;"></i>
                                        </div>
                                        <span style="font-size:15px;margin:5px 0 5px 0;">Recent orders</span><br/>
                                        <span style="font-size:10px;margin:5px 0 5px 0;">No orders placed in last 90 days.</span><br/><br/><br/><br/><br/>
                                        <hr/>
                                        <br/><br/>
                                        <span style="font-size:10px;margin:5px 0 5px 0;color:#0dcaf0;margin-left:55px;">View all orders >></span>
                                        <br/><br/><br/><br/><br/><br/><br/>
                                        <span style="font-size:20px;margin:5px 0 5px 0;color:#0dcaf0;margin-left:25px;">Expand view >>></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" style="width:260px;">
                            <div class="card" style="height:500px;background-color:white;border-radius:20px;">
                                <div class="card-body">
                                    <h5 class="card-title" style="background-color:#0dcaf0;padding:5px"><i class="bi bi-list-ul"></i>   Order Status</h5>
                                    <div class="card-text" style="color:black;">
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Court Filing</h6>
                                        <div class="container">
                                            <div class="row">
                                                <div class="col" style="border:1px solid #0dcaf0;background-color:#0dcaf0;">
                                                10 d
                                                </div>
                                                <div class="col" style="border:1px solid #0dcaf0;">
                                                60 d
                                                </div>
                                                <div class="col" style="border:1px solid #0dcaf0;">
                                                90 d
                                                </div>
                                            </div>
                                        </div>
                                        <br/><br/><br/><br/>
                                        Choose order:<br/>
                                        <select name="" id="">
                                            <option value="">select</option>
                                            <option value="">Court Filing</option>
                                            <option value="">Process Serving</option>
                                            <option value="">Skip Tracing</option>
                                            <option value="">eRecording Service</option>
                                        </select>
                                        <br/><br/><br/>
                                        Choose stage:<br/>
                                        <select name="" id="">
                                            <option value="">select</option>
                                            <option value="">Pending orders</option>
                                            <option value="">Draft orders</option>
                                            <option value="">Executed orders</option>
                                        </select>
                                        <br/><br/><br/><br/><br/><br/><br/>
                                        <span style="font-size:20px;margin:5px 0 5px 0;color:#0dcaf0;margin-left:25px;">Expand view >>></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col mb-4" style="width:260px;">
                            <div class="card" style="height:500px;background-color:white;border-radius:20px;">
                                <div class="card-body">
                                    <h5 class="card-title" style="background-color:#0dcaf0;padding:5px"><i class="bi bi-list-stars"></i>   Closed orders</h5>
                                    <div class="card-text" style="color:black;">
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Court Filing</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Skip Tracing</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Process Serving</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">eRecording Service</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Courtesy Copy</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Courtesy Copy</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Courtesy Copy</h6>
                                        <h6 class="card-title" style="border:1px solid #0dcaf0;color:#0dcaf0;padding:5px;text-align:center;">Courtesy Copy</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ================================================================================================== -->
				<xsl:comment>end row</xsl:comment>
                <xsl:comment>sohom's part</xsl:comment>
                <div class="row dashTable">
                	<div class="col-md-12">
                		<h4 class="d-inline-block">Recent Orders (<xsl:value-of select="Info/RecentJobs"/>)</h4> <a href="pending.php" class="d-inline-block">View Pending Orders</a>
                		<div class="card radius-10">
							<div class="card-body">
								<div class="table-responsive">
									<div class="tablescroll">
										<div class="dropdown" style="margin-bottom:10px;">
											<button class="dropbtn" style="border:1px solid black;">Choose here  <i class="bi bi-caret-down"></i></button>
											<div class="dropdown-content">
												<a href="#">Court Filing</a>
												<a href="#">Skip Tracing</a>
												<a href="#">Process Serving</a>
												<a href="#">eRecording Service</a>
												<a href="#">Courtesy Copy</a>
											</div>
										</div>
										<table class="table align-middle mb-0"> <xsl:comment> id="example" </xsl:comment>
											<thead class="table-dark">
												<tr>
													<th>Order</th>
													<th>Details</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												<xsl:for-each select="Info/RecentJobs">
												<tr>
													<td><xsl:value-of select="LawFirmJobRef"/></td>
													<td><xsl:value-of select="Servee"/></td>
													<td>
														<xsl:choose><xsl:when test="Status='PENDING'">
															<font color="red"><xsl:value-of select="Status"/></font>
													</xsl:when><xsl:otherwise>
															<font color="blue"><xsl:value-of select="Status"/></font>
													</xsl:otherwise></xsl:choose></td>
												</tr>
												</xsl:for-each>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
                	</div>
                	<!-- <div class="col-md-6">
                		<h4 class="d-inline-block">Recent Cases (2823)</h4> <a href="#" class="d-inline-block">Manage Cases</a>
                		<div class="card radius-10">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table align-middle mb-0"> <xsl:comment> id="example" </xsl:comment>
										<thead class="table-dark">
											<tr>
												<th>Order</th>
												<th>Details</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<xsl:for-each select="Case/Defendants/Defendant">
											<tr>
												<td><xsl:value-of select="DefendantID"/></td>
												<td>Alex Lima</td>
												<td>Active</td>
											</tr>
											</xsl:for-each>
										</tbody>
									</table>
								</div>
							</div>
						</div>
                	</div> -->
                </div>
            </div>
        </div>
</xsl:template>
</xsl:stylesheet>