<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
<xsl:template match="Cases"> 
	<div class="page-wrapper">
		<div class="page-content">
			<xsl:comment>end row</xsl:comment>
			<xsl:comment>sohom's part</xsl:comment>
			<div class="row dashTable">
				<div class="col-md-12" style="margin-bottom:50px;">
					<h4 class="d-inline-block" style="color:#085394">Recent Cases</h4> <a href="#" class="d-inline-block">Manage Cases</a>
					<div class="card radius-10">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table align-middle mb-0"> <xsl:comment> id="example" </xsl:comment>
									<thead class="table-dark">
										<tr>
											<th>Case</th>
											<th>Details</th>
											<th>Jurisdiction</th>
										</tr>
									</thead>
									<tbody>
										<xsl:for-each select="Case">
										<tr>
											<td><xsl:value-of select="CaseID"/></td>
											<td><xsl:value-of select="Plaintiff"/></td>
											<td><xsl:value-of select="Court"/></td>
										</tr>
										</xsl:for-each>
										<tr><td colspan="3" style="text-align:center;"><a href="recentcases.php" style="color:#085394">Show more >></a></td></tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</xsl:template>
</xsl:stylesheet>