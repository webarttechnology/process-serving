<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
<xsl:template match="Header"> 
	<div class="page-wrapper">
			<div class="page-content">
				<xsl:comment>end row</xsl:comment>
                <xsl:comment>sohom's part</xsl:comment>
                <div class="row dashTable">
                	<div class="col-md-12">
                		<h4 class="d-inline-block">Order Info </h4>
                		<div class="card radius-10">
							<div class="card-body">
								<div class="table-responsive">
									<div class="">
										<!-- =================================== -->
                                        <div class="cotainer" style="color:black;">
                                            
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Order Info</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Case Info</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Case Participants</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Documents</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Case Participants</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Order Details</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                                    <form name="my-form" style="color:black;">
                                                        <div class="form-group row">
                                                            <label for="full_name" class="col-form-label">Select County</label>
                                                            <div class="col-md-6">
                                                                <select class="drpdwn1" name="" id="">
                                                                    <option value="">Select</option>
                                                                    <option value="">Alameda</option>
                                                                    <option value="">Buttle</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="" class="col-form-label">Select Filing Type:</label>
                                                            <div class="col-md-6">
                                                                <input type="radio" name="a" style="bakcground-color:white"/>Subsequent Filing
                                                                <input type="radio" name="a" style="bakcground-color:white"/>Case Initiation
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="" class="col-form-label">Serve after filing:</label>
                                                            <div class="col-md-6">
                                                                <input type="radio" name="a" style="bakcground-color:white"/>Yes
                                                                <input type="radio" name="a" style="bakcground-color:white"/>No
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="phone_number" class="col-form-label">Select number of :</label>
                                                            <div class="col-md-6">
                                                                <select class="drpdwn1" name="" id="">
                                                                    <option value="">Select</option>
                                                                    <option value="">1</option>
                                                                    <option value="">2</option>
                                                                    <option value="">3</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="present_address" class="col-form-label">Present Address</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="present_address" class="form-control"/>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="permanent_address" class="col-form-label">Permanent Address</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="permanent_address" class="form-control" name="permanent-address"/>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label for="nid_number" class="col-form-label"><abbr
                                                                        title="National Id Card">NID</abbr> Number</label>
                                                            <div class="col-md-6">
                                                                <input type="text" id="nid_number" class="form-control" name="nid-number"/>
                                                            </div>
                                                        </div>
                                                        <br/><br/>
                                                        <div class="col-md-6 offset-md-4">
                                                            <button type="submit" class="btn btn-primary">Next</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
                                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                                            </div>

                                            
                                        </div>
                                        <!-- =================================== -->
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