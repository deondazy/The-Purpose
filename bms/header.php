<?php require __DIR__ . '/includes/bms-user.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr" class="layout-static">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?= $page ?> ‹ The Purpose Center — BMS</title><!-- TODO: Change Hardcoded Site Name -->

	<!-- Global stylesheets -->
	<link href="<?= $config->site->url; ?>/bms/assets/fonts/inter/inter.css" rel="stylesheet" type="text/css">
	<link href="<?= $config->site->url; ?>/bms/assets/icons/phosphor/styles.min.css" rel="stylesheet" type="text/css">
	<link href="<?= $config->site->url; ?>/bms/assets/css/all.min.css" id="stylesheet" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="<?= $config->site->url; ?>/bms/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
    <script src="<?= $config->site->url; ?>/bms/assets/js/jquery.min.js"></script>
	<script src="<?= $config->site->url; ?>/bms/assets/js/app.js"></script>
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
								<?= $page ?>
							</h4>
						</div>
					</div>
				</div>
				<!-- /page header -->