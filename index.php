<?php
	// 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Link logger rework</title>

	<meta name="csrf-token" content="tUB1qja4zG1qTdeYxibSJfCmdxYR1nnDcKjrKL0t">

	<link rel="stylesheet" href="_assets/_vendor/BS4/css/bootstrap.min.css">
	<link rel="stylesheet" href="_assets/css/fa-all.css">
	<link rel="stylesheet" href="_assets/css/w3.css">
	<link rel="stylesheet" href="_assets/css/coryG_UIOps.css">
	<link rel="stylesheet" href="_assets/css/coryG_base.css">
	<link rel="stylesheet" href="_assets/css/fonts.css">
	<link rel="stylesheet" href="_assets/css/animate.css">
	<link rel="stylesheet" href="_assets/css/mediaoptima.css">

	<link rel="stylesheet" type="text/css" href="_assets/css/inter_slop.css">

	<script src="_assets/js/jquery-3.6.0.min.js"></script>
	<script src="_assets/js/popper.min.js"></script>
	<script src="_assets/_vendor/BS4/js/bootstrap.bundle.min.js"></script>
	<script src="_assets/_vendor/misc/html2canvas.min.js"></script>
	<script src="_assets/_vendor/misc/jspdf.umd.min.js"></script>
	<script src="_assets/_vendor/misc/qrcode.min.js"></script>
	<script src="_assets/js/chart.js"></script>
	<script src="_assets/js/SuperScript.js"></script>
	<script src="_assets/js/toappend.js"></script>

	<script src="_assets/js/anims.js"></script>
	<script src="_assets/js/coryG_UIOps.js"></script>
	<script src="_assets/js/customalerter.js"></script>
	<script src="_assets/js/super_encryptor.js"></script>
	<script src="_assets/js/app.js"></script>

	<style>
		:root{
			--maxw: 600px;
		}
		.content{
			max-width: var(--maxw);
			width: 100%;
		}
		.content>div{
			width: 100%;
		}

		.headguy{
			text-align: center;
		}

		[data-subrole="link"]{
			cursor: pointer;
			padding: 8px 16px;
		}
		[data-subrole="link"]:hover{
			border: 1px solid transparent;
			box-shadow: 0 0 12px rgba(120,120,120,0.3);
		}

		.opbtn{
			border: 1px solid transparent;
			padding: 8px 12px;
		}
	</style>
</head>
<body>
	<div class="flowline gap-sm spacy-tn" style="position: fixed;top: 0;left: 0;">
		<button class="btn btn-dark" data-runme="toggle_ui_mode" id="mode_indicator"><i class="fa fa-moon"></i></button>
	</div>
	<div class="container-fluid flow centroid">
		<div class="content">
			<div class="headguy panelbg shadow-sm spacy-md distance-md themeround">
				<span class="h3">Link logger</span>
			</div>

			<div class="input_area distance-sm themeround collapser panelbg">
				<a class="text-decoration-none spacy-sm flowline spread centerline" href="#addArea" data-toggle="collapse" data-target="#addArea">
					<span class="text-uppercase text-muted font-weight-bold">Add link</span>
					<i class="fa fa-chevron-down myicon"></i>
				</a>
				<form class="collapse panelbg spacy-sm themeround" id="addArea">
					<div class="form-group">
						<label class="form-label" for="thecap">caption</label>
						<input type="text" class="form-control-custom" id="thecap" name="thecap" placeholder="what is this link for?">
					</div>
					<div class="form-group">
						<label class="form-label" for="thelink">url</label>
						<input type="url" class="form-control-custom" id="thelink" name="thelink" placeholder="your link" required>
					</div>
					<div class="flowline right">
						<button class="mybtn secondary" onclick="viewClient_samples(${sample.owner.id})" data-openthis="addArea">
							<i class="fas fa-plus"></i> add link
						</button>
					</div>
				</form>
			</div>

			<div class="links_area distance-sm themeround collapser panelbg">
				<div class="spacy-sm flowline spread">
					<div>
						<span class="h4">saved links</span>
					</div>
					<div>
						<div class="search-box">
							<input type="text" placeholder="Quick search..." id="quickSearch">
							<button><i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
				<div id="linksholder" class="spacy-sm" data-role="linksguy">
					<div class="border themeround flowline spread centerline mb-2" data-subrole="link" data-myid="0">
						<div>
							<b>New link</b>
						</div>
						<div class="actions">
							<button class="opbtn themeround w3-hover-red"><i class="fa fa-trash"></i></button>
							<button class="opbtn themeround w3-hover-blue"><i class="fa fa-external-link-alt"></i></button>
						</div>
					</div>
					<div class="border themeround flowline spread centerline mb-2" data-subrole="link" data-myid="0">
						<div>
							<b>New link</b>
						</div>
						<div class="actions">
							<button class="opbtn themeround w3-hover-red"><i class="fa fa-trash"></i></button>
							<button class="opbtn themeround w3-hover-blue"><i class="fa fa-external-link-alt"></i></button>
						</div>
					</div>
					<div class="border themeround flowline spread centerline mb-2" data-subrole="link" data-myid="0">
						<div>
							<b>New link</b>
						</div>
						<div class="actions">
							<button class="opbtn themeround w3-hover-red"><i class="fa fa-trash"></i></button>
							<button class="opbtn themeround w3-hover-blue"><i class="fa fa-external-link-alt"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		links = [];

		window['getlinks'] = (e) => {
			let s = quickSearch.value;
			let payld = {limit: 20, search: s};

			window[fetch_bypass]('./op/get_links',payld,'GET').then(d => {
				responseHandler(d,runafter,d);
			});

			const runafter = (d) => {
				alert_dark('rendering links');
			}
		}

		function start() {
			alert_dark('initialising');
			getlinks();
		}

		// dark / light mode switch setup
			let cur_ui_mode = "dark";
			let mode_timeout = undefined;

			window['setup_uimode'] = () => {
				let now = new Date();
				let hr = now.getHours();
				let mode = hr >= 19 ? "dark" : "light";

				if(cur_ui_mode.toLowerCase() != mode){
					alert_info(`changing to ${mode} mode`);
				}

				cur_ui_mode = mode;
				set_ui_mode();

				if(mode_timeout !== undefined){
					clearTimeout(mode_timeout);
				}
				mode_timeout = setTimeout(() => {
					setup_uimode();
				},20000);
			}
			window['toggle_ui_mode'] = () => {
				if(mode_timeout !== undefined){
					clearTimeout(mode_timeout);
				}

				let curmode = cur_ui_mode;
				let newmode = curmode == "dark" ? "light" : "dark";
				cur_ui_mode = newmode;
				set_ui_mode();
			}
			window['set_ui_mode'] = () => {
				let cls = cur_ui_mode == 'dark' ? 'fa fa-sun' : 'fa fa-moon';
				let cls2 = cur_ui_mode == 'dark' ? 'light' : 'dark';
				mode_indicator.innerHTML = `<i class="${cls}"></i>`;
				mode_indicator.className = `btn btn-${cls2.toLowerCase()} themeround`;
				document.body.dataset.mode = cur_ui_mode;
			}

		callOnLoad.push({act: start});
		callOnLoad.push({act: setup_uimode});
	</script>
</body>
</html>
