<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
<xsl:template match="Header"> 
<div class="page-wrapper">
    <div class="page-content">
		<div class="box">
            <h3 style="color:#085394;font-weight:600;margin:30px 0 0 30px;">Recent Orders</h3>
			<div class="center">
					
				<div id="demo" class="box jplist" style="margin: 20px 0 50px 0">
				
					<!-- ios button: show/hide panel -->
					<div class="jplist-ios-button">
						<i class="fa fa-sort"></i>
						jPList Actions
					</div>
					
					<!-- panel -->
					<div class="jplist-panel box panel-top">						
								
						<!-- reset button -->
                        <button 
                            type="button" 
                            class="jplist-reset-btn"
                            data-control-type="reset" 
                            data-control-name="reset" 
                            data-control-action="reset">
                            Reset <i class="fa fa-share"></i>
                        </button>

                        <!-- items per page dropdown -->
                        <div 
                            class="jplist-drop-down" 
                            data-control-type="items-per-page-drop-down" 
                            data-control-name="paging" 
                            data-control-action="paging">

                            <ul>
                                <li><span data-number="3"> 3 per page </span></li>
                                <li><span data-number="5"> 5 per page </span></li>
                                <li><span data-number="10" data-default="true"> 10 per page </span></li>
                                <li><span data-number="all"> View All </span></li>
                            </ul>
                        </div>

                        <!-- filter by jobno -->
                        <div class="text-filter-box">

                            <i class="fa fa-search  jplist-icon"></i>

                            <!--[if lt IE 10]>
                            <div class="jplist-label">Filter by Title:</div>
                            <![endif]-->

                            <input 
                                data-path=".like"
                                type="text" 
                                value="" 
                                placeholder="Filter by Job num" 
                                data-control-type="textbox" 
                                data-control-name="like-filter" 
                                data-control-action="filter"
                            />
                        </div>

                        <!-- filter by title -->
                        <div class="text-filter-box">

                            <i class="fa fa-search  jplist-icon"></i>

                            <!--[if lt IE 10]>
                            <div class="jplist-label">Filter by Title:</div>
                            <![endif]-->

                            <input 
                                data-path=".title" 
                                id="srchcase"
                                type="text" 
                                value="" 
                                placeholder="Filter by Order" 
                                data-control-type="textbox" 
                                data-control-name="title-filter" 
                                data-control-action="filter"
                            />
                        </div>

                        <!-- filter by description -->
                        <div class="text-filter-box">

                            <i class="fa fa-search  jplist-icon"></i>

                            <!--[if lt IE 10]>
                            <div class="jplist-label">Filter by Description:</div>
                            <![endif]-->

                            <input 
                                data-path=".desc" 
                                id="srchplnf"
                                type="text" 
                                value="" 
                                placeholder="Filter by Details" 
                                data-control-type="textbox" 
                                data-control-name="desc-filter" 
                                data-control-action="filter"
                            />	
                        </div>	

                        <!-- pagination results -->
                        <!-- <div 
                            class="jplist-label" 
                            data-type="Page {current} of {pages}" 
                            data-control-type="pagination-info" 
                            data-control-name="paging" 
                            data-control-action="paging">
                        </div> -->

                        <!-- pagination -->
                        <div 
                            class="jplist-pagination" 
                            data-control-type="pagination" 
                            data-control-name="paging" 
                            data-control-action="paging">
                        </div>						
						
					</div>				 
					
					 <!-- data -->
                    <div class="box text-shadow">
                        <table class="demo-tbl">

                            <!-- one more panel section -->
                            <thead class="jplist-panel">

                                <tr data-control-type="sort-buttons-group"
                                    data-control-name="header-sort-buttons"
                                    data-control-action="sort"
                                    data-mode="single"
                                    data-datetime-format="{month}/{day}/{year}">

                                    <th width="13%">
                                        <span class="header">JobNum</span>
                                        <span class="sort-btns">
                                            <i class="fa fa-caret-up" data-path=".like" data-type="number" data-order="asc" title="Sort by Likes Asc"></i>
                                            <i class="fa fa-caret-down" data-path=".like" data-type="number" data-order="desc" title="Sort by Likes Desc"></i>
                                        </span>
                                    </th>

                                    <th width="13%">
                                        <span class="header">Order</span>
                                        <span class="sort-btns">
                                            <i class="fa fa-caret-up" data-path=".title" data-type="number" data-order="asc" title="Sort by Title Asc"></i>
                                            <i class="fa fa-caret-down" data-path=".title" data-type="number" data-order="desc" title="Sort by Title Desc"></i>
                                        </span>
                                    </th>

                                    <th width="63%">
                                        <span class="header">Details</span>
                                        <span class="sort-btns">
                                            <i class="fa fa-caret-up" data-path=".desc" data-type="text" data-order="asc" title="Sort by Description Asc"></i>
                                            <i class="fa fa-caret-down" data-path=".desc" data-type="text" data-order="desc" title="Sort by Description Desc"></i>
                                        </span>
                                    </th>

                                    <th>
                                        <span class="header">Status</span>
                                        <span class="sort-btns">
                                            <i class="fa fa-caret-up" data-path=".cortno" data-type="text" data-order="asc" title="Sort by CourtCaseNo Asc"></i>
                                            <i class="fa fa-caret-down" data-path=".cortno" data-type="text" data-order="desc" title="Sort by CourtCaseNo Desc"></i>
                                        </span>
                                    </th>

                                    <!-- <th>
                                        <span class="header">Plaintiff</span>
                                        <span class="sort-btns">
                                            <i class="fa fa-caret-up" data-path=".desc" data-type="text" data-order="asc" title="Sort by Description Asc"></i>
                                            <i class="fa fa-caret-down" data-path=".desc" data-type="text" data-order="desc" title="Sort by Description Desc"></i>
                                        </span>
                                    </th> -->

                                    <!-- <th width="10%">
                                        <span class="header">Date</span>
                                        <span class="sort-btns">
                                            <i class="fa fa-caret-up" data-path=".tbl-date" data-type="datetime" data-order="asc" title="Sort by Date Asc"></i>
                                            <i class="fa fa-caret-down" data-path=".tbl-date" data-type="datetime" data-order="desc" title="Sort by Date Desc"></i>
                                        </span>
                                    </th> -->
                                </tr>
                            </thead>

                            <!-- data container -->
                            <tbody>
                                <!-- item 1 -->
                                <xsl:for-each select="Info/RecentJobs">
                                <tr class="tbl-item">

                                    <!-- like -->
                                    <td class="like" style="font-size:14px;padding:10px;"><xsl:value-of select="JobNum"/></td>

                                    <!-- title -->
                                    <td class="title" style="font-size:14px;padding:10px;"><xsl:value-of select="LawFirmJobRef"/></td>

                                    <!-- date -->
                                    <td class="desc" style="color:black;font-size:14px;padding:10px;"><xsl:value-of select="Servee"/></td>

                                    <!-- date -->
                                    <!-- <td class="def" style="color:black;font-size:14px;padding:10px;"><xsl:value-of select="Defendant"/></td> -->

                                    <!-- desc -->
                                    <!-- <td class="desc" style="color:black;font-size:14px;padding:10px;"><xsl:value-of select="Plaintiff"/></td> -->
                                    <xsl:choose>
                                        <xsl:when test="Status='PENDING'">
										    <td class="cortno" style="color:red;font-size:14px;padding:10px;"><xsl:value-of select="Status"/></td>
										</xsl:when>
                                        <xsl:otherwise>
									        <td class="cortno" style="color:blue;font-size:14px;padding:10px;"><xsl:value-of select="Status"/></td>
										</xsl:otherwise>
                                    </xsl:choose>
                                </tr>
                                </xsl:for-each>
                            </tbody>
                        </table>
                    </div>
                    <!-- end of data -->

                    <div class="box jplist-no-results text-shadow align-center">
                        <p>No results found</p>
                    </div>
                    
                    <!-- ios button: show/hide panel -->
                    <div class="jplist-ios-button">
                        <i class="fa fa-sort"></i>
                        jPList Actions
                    </div>
					
                    <!-- panel -->
                    <div class="jplist-panel box panel-bottom">						

                        <!-- items per page dropdown -->
                        <div 
                            class="jplist-drop-down" 
                            data-control-type="items-per-page-drop-down" 
                            data-control-name="paging" 
                            data-control-action="paging"
                            data-control-animate-to-top="true">

                            <ul>
                                <li><span data-number="3"> 3 per page </span></li>
                                <li><span data-number="5"> 5 per page </span></li>
                                <li><span data-number="10" data-default="true"> 10 per page </span></li>
                                <li><span data-number="all"> View All </span></li>
                            </ul>
                        </div>

                        <!-- pagination results -->
                        <!-- <div 
                            class="jplist-label" 
                            data-type="{start} - {end} of {all}"
                            data-control-type="pagination-info" 
                            data-control-name="paging" 
                            data-control-action="paging">
                        </div> -->

                        <!-- pagination -->
                        <div 
                            class="jplist-pagination" 
                            data-control-type="pagination" 
                            data-control-name="paging" 
                            data-control-action="paging"
                            data-control-animate-to-top="true">
                        </div>

                    </div>
						
                    
				</div>
				
				<!--<><><><><><><><><><><><><><><><><><><><><><><><><><> DEMO END <><><><><><><><><><><><><><><><><><><><><><><><><><>-->				
			</div>		
		</div>
    </div>
</div>
</xsl:template>
</xsl:stylesheet>