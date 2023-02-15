<?php require_once dirname(__DIR__) . '/bootstrap.php'; ?>

<!DOCTYPE html>
<html lang="en" dir="ltr" class="layout-static">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Blog Management System</title>

	<!-- Global stylesheets -->
	<link href="assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
	<link href="assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="assets/js/app.js"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include __DIR__ . '/includes/sidebar.php'; ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Main navbar -->
			<?php include __DIR__ . '/includes/topbar.php'; ?>
			<!-- /main navbar -->


			<!-- Inner content -->
			<div class="content-inner">

				<!-- Page header -->
				<div class="page-header">
					<div class="page-header-content d-lg-flex">
						<div class="d-flex">
							<h4 class="page-title mb-0">
								Dashboard
							</h4>
						</div>
					</div>
				</div>
				<!-- /page header -->