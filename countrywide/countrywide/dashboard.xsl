<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
<xsl:template match="Header"> 
	<div class="page-wrapper">
		<div class="dash__header">
			<h1>Dashboard</h1>
			<div class="row gy-4">
				<div class="col-md-6 col-xl-3">
					<div class="top_card">
						<div class="topcard_heding">
							<h5>Place an Order</h5>
							<span class="card-icon"><i class="bi bi-arrow-right-circle-fill"></i></span>
						</div>
						<select class="cp-select" name="" id="placeorder">
							<option value="" style="line-height: 2.5;">Choose here</option>
							<option value="">Efiling</option>
							<option value="">EService</option>
							<option value="courtfiling.php">courtfiling</option>
							<option value="prserving.php">Process Serving</option>
							<option value="prservingnew.php">Process Serving New</option>
							<option value="">eRecording</option>
							<option value="">Skip Tracing</option>
							<option value="">Courtesy Copy</option>
							<option value="">Research and Retrieval</option>
							<option value="">Secretary of State Filing</option>
						</select>
					</div>
				</div>
				<div class="col-md-6 col-xl-3">
					<div class="top_card">
						<div class="topcard_heding">
                            <h5>Manage Cases<span class="count_label">(228)</span></h5>
                            <span class="card-icon"><i class="bi bi-file-earmark"></i></span>
                        </div>
						<div class="dropdown">
							<button class="dropbtn">Choose here<i class="fa-solid fa-chevron-down"></i></button>
							<div class="dropdown-content">
								<a href="#">Efiling</a>
								<a href="#">EService</a>
								<a href="#">Court Filing</a>
								<a href="#">Process Serving</a>
								<a href="#">eRecording Service</a>
								<a href="#">Skip Tracing</a>
								<a href="#">Courtesy Copy</a>
								<a href="#">Research and Retrieval</a>
								<a href="#">Secretary of State Filing</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xl-3">
					<div class="top_card">
                        <div class="topcard_heding">
                            <h5>Order Status</h5>
                            <span class="card-icon"><i class="bi bi-list-ul"></i></span>
                        </div>
						<div class="dropdown">
							<button class="dropbtn">Choose here<i class="fa-solid fa-chevron-down"></i></button>
							<div class="dropdown-content">
								<a href="#">Efiling</a>
								<a href="#">EService</a>
								<a href="#">Court Filing</a>
								<a href="#">Process Serving</a>
								<a href="#">eRecording Service</a>
								<a href="#">Skip Tracing</a>
								<a href="#">Courtesy Copy</a>
								<a href="#">Research and Retrieval</a>
								<a href="#">Secretary of State Filing</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-xl-3">
					<div class="top_card">
                        <div class="topcard_heding">
                            <h5>Closed orders</h5>
                            <span class="card-icon"><i class="bi bi-list-stars"></i></span>
                        </div>
						<div class="dropdown">
							<button class="dropbtn">Choose here<i class="fa-solid fa-chevron-down"></i></button>
							<div class="dropdown-content">
								<a href="#">Efiling</a>
								<a href="#">EService</a>
								<a href="#">Court Filing</a>
								<a href="#">Process Serving</a>
								<a href="#">eRecording Service</a>
								<a href="#">Skip Tracing</a>
								<a href="#">Courtesy Copy</a>
								<a href="#">Research and Retrieval</a>
								<a href="#">Secretary of State Filing</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="page-content">
			<xsl:comment>end row</xsl:comment>
			<xsl:comment>sohom's part</xsl:comment>
			<div class="row">
				<div class="col-md-12">
					<div class="section-heading">
						<h4>Recent Orders (<xsl:value-of select="Info/RecentJobs"/>)</h4>
						<a href="pending.php">View Pending Orders</a>
					</div>
					<div class="table-responsive split-table mb-5">
						<div class="tablescroll">
							<div class="dropdown w-small">
								<select class="cp-select">
									<option>Select</option>
									<option>Court Filing</option>
									<option>Skip Tracing</option>
									<option>Process Serving</option>
									<option>eRecording Service</option>
									<option>Courtesy Copy</option>
								</select>
							</div>
							<table class="table">
								<xsl:comment> id="example" </xsl:comment>
								<thead class="table-dark">
									<tr>
										<th width="20%">Order</th>
										<th width="60%">Details</th>
										<th width="20%">Status</th>
									</tr>
								</thead>
								<tbody>
									<xsl:for-each select="Info/RecentJobs[20 >= position()]">
									<tr>
										<td><xsl:value-of select="LawFirmJobRef"/></td>
										<td><xsl:value-of select="Servee"/></td>
										<td>
											<xsl:choose><xsl:when test="Status='PENDING'">
												<span class="task-status red"><xsl:value-of select="Status"/></span>
										</xsl:when><xsl:otherwise>
												<span class="task-status blue"><xsl:value-of select="Status"/></span>
										</xsl:otherwise></xsl:choose></td>
									</tr>
									</xsl:for-each>
									<tr><td colspan="5" class="showmore-btn"><a href="recentorders.php">Show more</a></td></tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="section-heading">
						<h4>Recent Cases</h4>
						<a href="#">Manage Cases</a>
					</div>
					<div class="table-responsive split-table mb-5">
						<table class="table">
							<xsl:comment> id="example" </xsl:comment>
							<thead class="table-dark">
								<tr>
									<th>Case</th>
									<th>CourtCaseNo</th>
									<th>Defendant</th>
									<th>Plaintiff</th>
									<th>Jurisdiction</th>
								</tr>
							</thead>
							<tbody>
								<xsl:for-each select="Case[20 >= position()]">
								<tr>
									<td><xsl:value-of select="CaseID"/></td>
									<td><xsl:value-of select="CourtCaseNo"/></td>
									<td><xsl:value-of select="Defendant"/></td>
									<td><xsl:value-of select="Plaintiff"/></td>
									<td><xsl:value-of select="Court"/></td>
								</tr>
								</xsl:for-each>
								<tr><td colspan="5" class="showmore-btn"><a href="recentcases.php">Show more</a></td></tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
    </div>
</xsl:template>
</xsl:stylesheet>