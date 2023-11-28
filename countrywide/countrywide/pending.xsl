<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
<xsl:template match="Header"> 
	<div class="page-wrapper">
			<div class="page-content">
				<xsl:comment>end row</xsl:comment>
                <xsl:comment>sohom's part</xsl:comment>
                <div class="row dashTable">
                	<div class="col-md-12">
                		<h4 class="d-inline-block">Pending Orders (<xsl:value-of select="Info/PendingJobs"/>)</h4>
                		<div class="card radius-10">
							<div class="card-body">
								<div class="table-responsive">
									<table class="table align-middle mb-0" id="pendingTable"> <xsl:comment> id="example" </xsl:comment>
										<thead class="table-dark">
											<tr>
												<th>Order</th>
												<th>Details</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
                                            <tr>
												<th><input type="text" id="order" placeholder="Order no." /></th>
												<th><input type="text" id="det" placeholder="Details.." /></th>
											</tr>
										    <xsl:for-each select="Info/PendingJobs">
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
            </div>
        </div>
        <script src="assets/js/filter.js"></script>
</xsl:template>
</xsl:stylesheet>