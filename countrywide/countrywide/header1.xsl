<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" encoding="iso-8859-1" indent="no"/>
<xsl:template match="Header"> 
<html lang="en">

<head>
	<xsl:comment>Required meta tags</xsl:comment>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<xsl:comment>favicon</xsl:comment>
	<xsl:comment><link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" /></xsl:comment>
	<xsl:comment>plugins</xsl:comment>
	<link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" /> -->
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
	<link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
	<xsl:comment>loader</xsl:comment>
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<xsl:comment>Bootstrap CSS </xsl:comment>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
	<link href="assets/css/app.css" rel="stylesheet"/>
	<link href="assets/css/icons.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
	<xsl:comment>Theme Style CSS </xsl:comment>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"/>
    <script src="assets/js/jquery.min.js"></script>

    <!-- ===============DATA TABLE===================== -->
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css" />
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />

    <!-- demo page styles -->
	<link href="assets/jplist/css/jplist.demo-pages.min.css" rel="stylesheet" type="text/css" />

    <!-- jQuery lib -->		
    <!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script> -->

    <!-- jPList core js and css  -->
    <link href="assets/jplist/css/jplist.core.min.css" rel="stylesheet" type="text/css" />		
    <script src="assets/jplist/js/jplist.core.min.js"></script>
    
    <!-- jPList textbox filter control -->
    <script src="assets/jplist/js/jplist.textbox-filter.min.js"></script>
    <link href="assets/jplist/css/jplist.textbox-filter.min.css" rel="stylesheet" type="text/css" />
    
    <!-- jPList pagination bundle -->
    <script src="assets/jplist/js/jplist.pagination-bundle.min.js"></script>
    <link href="assets/jplist/css/jplist.pagination-bundle.min.css" rel="stylesheet" type="text/css" />		
    
    <!-- jPList history bundle -->
    <script src="assets/jplist/js/jplist.history-bundle.min.js"></script>
    <link href="assets/jplist/css/jplist.history-bundle.min.css" rel="stylesheet" type="text/css" />
    
    <!-- sort button control -->
    <script src="assets/jplist/js/jplist.sort-buttons.min.js"></script>

    <link href="assets/jplist/css/custom.css" rel="stylesheet" type="text/css" />
    
    <!-- ===============DATA TABLE===================== -->
    


	<title>Countrywide Process</title>
</head>

<body class="bg-theme bg-theme2">
	<xsl:comment>wrapper</xsl:comment>
	<div class="wrapper">
		<xsl:comment>sidebar wrapper </xsl:comment>
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<!-- <img src="https://legalconnect.s3.amazonaws.com/tenantlogos/countrywideprocess/countrywideprocess_logo.png" class="logo-icon" alt="logo icon"/> -->
					<img src="assets/images/countrywide_logonew.svg" class="logo-icon" alt="logo icon"/>
				</div>
				<xsl:comment><div>
					<h4 class="logo-text">Countrywide Process</h4>
				</div> </xsl:comment>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<xsl:comment>navigation</xsl:comment>
			<xsl:comment>  </xsl:comment>
			<ul class="metismenu" id="menu">
				<li class="d-none">
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class='bx bxs-home'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
					<ul>
						<li> <a href="index.html"><i class="bx bx-right-arrow-alt"></i>eCommerce</a>
						</li>
						<li> <a href="index2.html"><i class="bx bx-right-arrow-alt"></i>Analytics</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="dashboard.php">
						<div class="parent-icon"><i class='bx bxs-home'></i>
						</div>
						<div class="menu-title">Dashboard</div>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="parent-icon"><i class='bx bxs-user'></i>
						</div>
						<div class="menu-title">Place Order </div>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="parent-icon"><i class="fa-solid fa-users"></i>
						</div>
						<div class="menu-title">Manage Cases</div>
					</a>
				</li>
				<li>
					<a href="pending.php">
						<div class="parent-icon"><i class="fa-solid fa-map-location-dot"></i>
						</div>
						<div class="menu-title">Pending Orders</div>
					</a>
				</li>
				<li>
					<a href="#">
						<div class="parent-icon"><i class="fa-solid fa-map-location-dot"></i>
						</div>
						<div class="menu-title">Closed Orders</div>
					</a>
				</li>
				<xsl:comment><li>
					<a href="reports.php">
						<div class="parent-icon"><i class='bx bx-edit'></i>
						</div>
						<div class="menu-title">Reports</div>
					</a>
				</li>
				<li>
					<a href="payroll.php">
						<div class="parent-icon"><i class="fa-solid fa-money-bill"></i>
						</div>
						<div class="menu-title">Payroll</div>
					</a>
				</li>
				<li>
					<a href="javascript:;">
						<div class="parent-icon"><i class='bx bxs-cog' ></i>
						</div>
						<div class="menu-title">Setting</div>
					</a>
				</li> </xsl:comment>
			</ul>
			<xsl:comment>end navigation</xsl:comment>
		</div>
		<xsl:comment>end sidebar wrapper </xsl:comment>
		<xsl:comment>start header </xsl:comment>
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="search-bar flex-grow-1">
						
						<div class="position-relative search-bar-box">
							<xsl:comment><div class="input-group">
						  	
						  	<input type="text" aria-label="First name" class="form-control"/>
						  	<input type="text" aria-label="Last name" class="form-control"/>
						</div> </xsl:comment>
						<!-- <select class="form-select d-inline-block" style="width: 150px;position: relative;top: -2px;margin-right: -3px;height: 39px;">
									<option>Select</option>
									<option>1</option>
									<option>1</option>
								</select> -->
							<input type="text" class="form-control search-control" placeholder="Type to search..." style=" width: calc(100% - 154px); display: inline-block;color:rgb(80,80,80);"/> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
							<span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
						</div>
					</div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#">	<i class='bx bx-search'></i>
								</a>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">	<i class='bx bx-category'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<div class="row row-cols-3 g-3 p-3">
										<div class="col text-center">
											<div class="app-box mx-auto"><i class='bx bx-group'></i>
											</div>
											<div class="app-title">Teams</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto"><i class='bx bx-atom'></i>
											</div>
											<div class="app-title">Projects</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto"><i class='bx bx-shield'></i>
											</div>
											<div class="app-title">Tasks</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto"><i class='bx bx-notification'></i>
											</div>
											<div class="app-title">Feeds</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto"><i class='bx bx-file'></i>
											</div>
											<div class="app-title">Files</div>
										</div>
										<div class="col text-center">
											<div class="app-box mx-auto"><i class='bx bx-filter-alt'></i>
											</div>
											<div class="app-title">Alerts</div>
										</div>
									</div>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">7</span>
									<i class='bx bx-bell'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Notifications</p>
											<p class="msg-header-clear ms-auto">Marks all as read</p>
										</div>
									</a>
									<div class="header-notifications-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-group"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
												ago</span></h6>
													<p class="msg-info">5 new user registered</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-cart-alt"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Orders <span class="msg-time float-end">2 min
												ago</span></h6>
													<p class="msg-info">You have recived new orders</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-file"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">24 PDF File<span class="msg-time float-end">19 min
												ago</span></h6>
													<p class="msg-info">The pdf files generated</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-send"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Time Response <span class="msg-time float-end">28 min
												ago</span></h6>
													<p class="msg-info">5.1 min avarage time response</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-home-circle"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Product Approved <span
												class="msg-time float-end">2 hrs ago</span></h6>
													<p class="msg-info">Your new product has approved</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class="bx bx-message-detail"></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New Comments <span class="msg-time float-end">4 hrs
												ago</span></h6>
													<p class="msg-info">New customer comments recived</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class='bx bx-check-square'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Your item is shipped <span class="msg-time float-end">5 hrs
												ago</span></h6>
													<p class="msg-info">Successfully shipped your item</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class='bx bx-user-pin'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">New 24 authors<span class="msg-time float-end">1 day
												ago</span></h6>
													<p class="msg-info">24 new authors joined last week</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="notify"><i class='bx bx-door-open'></i>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Defense Alerts <span class="msg-time float-end">2 weeks
												ago</span></h6>
													<p class="msg-info">45% less alerts last 4 weeks</p>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Notifications</div>
									</a>
								</div>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>
									<i class='bx bx-comment'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Messages</p>
											<p class="msg-header-clear ms-auto">Marks all as read</p>
										</div>
									</a>
									<div class="header-message-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Daisy Anderson <span class="msg-time float-end">5 sec
												ago</span></h6>
													<p class="msg-info">The standard chunk of lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Althea Cabardo <span class="msg-time float-end">14
												sec ago</span></h6>
													<p class="msg-info">Many desktop publishing packages</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Oscar Garner <span class="msg-time float-end">8 min
												ago</span></h6>
													<p class="msg-info">Various versions have evolved over</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Katherine Pechon <span class="msg-time float-end">15
												min ago</span></h6>
													<p class="msg-info">Making this the first true generator</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Amelia Doe <span class="msg-time float-end">22 min
												ago</span></h6>
													<p class="msg-info">Duis aute irure dolor in reprehenderit</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Cristina Jhons <span class="msg-time float-end">2 hrs
												ago</span></h6>
													<p class="msg-info">The passage is attributed to an unknown</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">James Caviness <span class="msg-time float-end">4 hrs
												ago</span></h6>
													<p class="msg-info">The point of using Lorem</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Peter Costanzo <span class="msg-time float-end">6 hrs
												ago</span></h6>
													<p class="msg-info">It was popularised in the 1960s</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">David Buckley <span class="msg-time float-end">2 hrs
												ago</span></h6>
													<p class="msg-info">Various versions have evolved over</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Thomas Wheeler <span class="msg-time float-end">2 days
												ago</span></h6>
													<p class="msg-info">If you are going to use a passage</p>
												</div>
											</div>
										</a>
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
												<div class="user-online">
													<img src="https://via.placeholder.com/110x110" class="msg-avatar" alt="user avatar"/>
												</div>
												<div class="flex-grow-1">
													<h6 class="msg-name">Johnny Seitz <span class="msg-time float-end">5 days
												ago</span></h6>
													<p class="msg-info">All the Lorem Ipsum generators</p>
												</div>
											</div>
										</a>
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Messages</div>
									</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="https://via.placeholder.com/110x110" class="user-img" alt="user avatar"/>
							<div class="user-info ps-3">
								<p class="user-name mb-0"><xsl:value-of select="Info/ClientName"/></p>
								<p class="designattion mb-0"><xsl:value-of select="Info/ClientType"/></p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i class="bx bx-cog"></i><span>Settings</span></a>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i class='bx bx-home-circle'></i><span>Dashboard</span></a>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i class='bx bx-dollar-circle'></i><span>Earnings</span></a>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i class='bx bx-download'></i><span>Downloads</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="logout.php"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<xsl:comment>end header </xsl:comment>
		<xsl:comment>start page wrapper </xsl:comment>
	</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>