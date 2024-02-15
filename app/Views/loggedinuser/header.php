<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<link href="<?php echo base_url('images/logo.png') ?>" width="160" rel="icon">
	<link href="<?php echo base_url('images/logo.png') ?>" width="32" rel="logo">

	<link rel="stylesheet" href="<?php echo base_url('css/font-awesome.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/dataTables.bootstrap.min.css') ?>">
	    <link rel="stylesheet" href="https://maidendropgroup.com/public/css/polist-styles.css" media="print">
	<link rel="stylesheet" href="<?php echo base_url('css/bootstrap-social.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/bootstrap-select.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/fileinput.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/awesome-bootstrap-checkbox.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/style.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/jquery-ui.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('css/select2.min.css') ?>" />

	<script src="<?php echo base_url('js/jquery.min.js') ?>"></script>
	<script src="<?php echo base_url('js/bootstrap-select.min.js') ?>"></script>
	<script src="<?php echo base_url('js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('js/jquery.dataTables.min.js') ?>"></script>
	<script src="<?php echo base_url('js/dataTables.bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('js/Chart.min.js') ?>"></script>
	<script src="<?php echo base_url('js/fileinput.js') ?>"></script>
	<script src="<?php echo base_url('js/chartData.js') ?>"></script>
	<script src="<?php echo base_url('js/main.js') ?>"></script>
	<script src="<?php echo base_url('js/jquery-ui.js') ?>"></script>
	<script src="<?php echo base_url('js/select2.min.js') ?>"></script>
	<script src="<?php echo base_url('js/sweetalert.min.js') ?>"></script>
	<script src='<?php echo base_url('js/jquery.validate.min.js') ?>'></script>

	<script>
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
	</script>
</head>
<div class="brand clearfix">
	<h4 class="pull-left text-white text-uppercase" style="margin:5px 0px 0px 20px"><img src="<?php echo base_url('images/logo.png') ?>" height="50px"></img>
		&nbsp;&nbsp;&nbsp; <?php echo isset($_SESSION['userdetails']) ? $_SESSION['userdetails']->rolename . " Panel" : "";

				// 			if (isset($_SESSION['userdetails'])) {
				// 			    if ($_SESSION['userdetails']->roleid != 1) {
				// 			        foreach ($lookups['branchlookup'] as $branch) {
				// 			            if ($branch->branchid == $_SESSION['userdetails']->branchid) {
				// 			                echo " - {$branch->branchname}";
				// 			            }
				// 			        }
				// 			    }
				// 			}
							?>
	</h4>

	<?php if (count($_SESSION) > 0 && $_SESSION['userdetails'] != null) : ?>
		<div class="mob_res" style="margin:20px 20px 20px 20px;float:right">
			<b style="color: white;">Search</b>
			<input type="text" id="tags" style="width: 25vw;" />
		</div>
		<div class="mob_res" style="margin:20px 20px 20px 20px;float:right">
			<?php
			$db = db_connect();
			$query = $db->query("SELECT * FROM batchlookup");
			$results = $query->getResult();
			$bg = $results;
			$db->close();
			?>
			<b style="color: white;">Academic Year</b>
			<select onchange="window.location.href = '<?php echo base_url('home/set_academic_year') ?>' + '/' + this.value">
				<option value="">Select</option>
				<?php
				foreach ($results as $result) :
				?>
					<option value="<?php echo $result->batchid ?>" <?php echo $_SESSION['activebatch'] == $result->batchid ? "selected" : "" ?>><?php echo $result->batchname ?></option>
				<?php
				endforeach;
				?>
			</select>
		</div> 
	<?php endif; ?>
	
		<?php if (count($_SESSION) > 0 && $_SESSION['agentdetails'] != null) : ?>
		<div class="mob_res" style="margin:20px 20px 20px 20px;float:right">
			<b style="color: white;">Search</b>
			<input type="text" id="tags" style="width: 25vw;" />
		</div>
		<div class="mob_res" style="margin:20px 20px 20px 20px;float:right">
			<?php
			$db = db_connect();
			$query = $db->query("SELECT * FROM batchlookup");
			$results = $query->getResult();
			$bg = $results;
			$db->close();
			?>
			<b style="color: white;">Academic Year</b>
			<select onchange="window.location.href = '<?php echo base_url('home/set_academic_year') ?>' + '/' + this.value">
				<option value="">Select</option>
				<?php
				foreach ($results as $result) :
				?>
					<option value="<?php echo $result->batchid ?>" <?php echo $_SESSION['activebatch'] == $result->batchid ? "selected" : "" ?>><?php echo $result->batchname ?></option>
				<?php
				endforeach;
				?>
			</select>
		</div>
	<?php endif; ?>

	<span class="menu-btn"><i class="fa fa-bars"></i></span>

	<ul class="ts-profile-nav">
		<li class="ts-profile-nav">
			<a href="">&nbsp;</a>
		</li>
	</ul>

	<div class="loading" style="display: none;">
		<div class='uil-ring-css' style='transform:scale(0.79);'>
			<div></div>
		</div>
	</div>
</div>
<style>
	div.loading {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
	}

	@-webkit-keyframes uil-ring-anim {
		0% {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}

		100% {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@-webkit-keyframes uil-ring-anim {
		0% {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}

		100% {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@-moz-keyframes uil-ring-anim {
		0% {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}

		100% {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@-ms-keyframes uil-ring-anim {
		0% {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}

		100% {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@-moz-keyframes uil-ring-anim {
		0% {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}

		100% {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@-webkit-keyframes uil-ring-anim {
		0% {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}

		100% {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@-o-keyframes uil-ring-anim {
		0% {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}

		100% {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@keyframes uil-ring-anim {
		0% {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}

		100% {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	.uil-ring-css {
		margin: auto;
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		width: 200px;
		height: 200px;
	}

	.uil-ring-css>div {
		position: absolute;
		display: block;
		width: 160px;
		height: 160px;
		top: 20px;
		left: 20px;
		border-radius: 80px;
		box-shadow: 0 6px 0 0 #99cc33;
		-ms-animation: uil-ring-anim 1s linear infinite;
		-moz-animation: uil-ring-anim 1s linear infinite;
		-webkit-animation: uil-ring-anim 1s linear infinite;
		-o-animation: uil-ring-anim 1s linear infinite;
		animation: uil-ring-anim 1s linear infinite;
	}
</style>
<style>
	.ui-menu .ui-menu-item {
		background-color: #F7F4F4;
		margin: 3px;
	}

	.ui-autocomplete-row a {
		display: inline-block;
		text-decoration: none;
		width: 93%;
	}

	.ui-autocomplete-row a span {
		padding: 10px;
		font-size: 15px;
		text-align: center;
	}

	.ui-autocomplete-row a img {
		vertical-align: middle;
	}

	.ui-state-active,
	.ui-widget-content .ui-state-active {
		border: none;
		background: #EFEFEF;
		color: inherit;
	}

	.ui-menu .ui-state-focus,
	.ui-menu .ui-state-active {
		margin: 0;
	}
</style>
<script>
	$(document).ready(function() {
		var dt;
		$('.select2').select2();

		$('.datepicker').datepicker({
			dateFormat: "dd/mm/yy",
			changeMonth: true,
        	changeYear: true,
			maxDate: 0
		});

		$('.paymentdate').datepicker({
			dateFormat: "dd/mm/yy",
			minDate: 0,
			maxDate: 0
		}).keydown(false);
		
		dt = $('.DataTable').DataTable();
	});

	$("#tags").autocomplete({
		source: "<?php echo base_url('users/autocomplete_users') ?>",
		minLength: 0,
		position: {
			my: "right top",
			at: "right bottom"
		}
		// ,
		// select: function(event, ui) {
		// 	window.location.href = "<?php echo base_url('users/studentdetails') ?>?id=" + ui.item.id;
		// }
	}).data("ui-autocomplete")._renderItem = function(ul, item) {
		return $("<li class='ui-autocomplete-row'></li>")
			.data("item.autocomplete", item)
			.append(item.label)
			.appendTo(ul);
	};
</script>
<script>

</script>