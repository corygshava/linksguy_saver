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

		body{
			/* font-family: 'inter_24pt','tw cen mt',calibri; */
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
			overflow: hidden;
			border: 1px solid transparent;
			border: 1px solid rgba(80, 80, 80, 0.30);
		}
		[data-subrole="link"] * {
			color: var(--clr-text);
		}
		[data-subrole="link"] .actions{
			translate: 70px 0;
			opacity: 0;
			pointer-events: none;
		}
		[data-subrole="link"]:hover{
			border: 1px solid var(--themecolor);
			/* box-shadow: 0 0 12px rgba(120,120,120,0.3); */
			/* box-shadow: 0 0 12px var(--themecolor); */
		}
		[data-subrole="link"]:hover .cap{
			color: var(--themecolor);
		}
		[data-subrole="link"]:hover .actions{
			translate: 0 0;
			opacity: 1;
			pointer-events: all;
		}

		#categoriesholder>div{
			display: flex;
			/* flex-direction: row; */
			gap: 8px;
		}
		#categoriesholder .category {
			/* display: inline-flex; */
			padding: 3px 8px;
			border: 1px solid var(--themecolor);
			border-radius: var(--roundness);
			background: transparent;
			color: var(--themecolor);
			transition: 0.3s;
			font-size: 0.7rem;
			font-weight: 700;
		}
		#categoriesholder .category i{
			translate: 0 20%;
		}
		#categoriesholder .category:hover{
			scale: 1.1;
		}
		#categoriesholder .category:hover,#categoriesholder .category.active{
			/*display: inline-flex;*/
			background: var(--themecolor);
			color: #fff;
			border: 1px solid var(--themecolor);
		}
		#categoriesholder .category>*{
			translate: 0 -2px;
		}

		.thelinks{
			width: 100%;
		}

		.opbtn{
			background: transparent;
			border: 1px solid transparent;
			padding: 4px 8px;
			font-size: 0.8rem;
		}
	</style>
</head>
<body>
	<div class="flowline gap-sm spacy-tn" style="position: fixed;top: 0;left: 0;z-index: 3;">
		<button class="btn circle_btn altmodetxt bg-dark" data-myclass="btn circle_btn" data-runme="toggle_ui_mode" id="mode_indicator"><i class="fa fa-moon"></i></button>
	</div>
	<div class="container-fluid flow centroid">
		<div class="content">
			<div class="headguy _panelbg _shadow-sm spacy-sm distance-md themeround">
				<span class="h3"><b class="themetxt logotxt">_H</b> linksguy</span>
			</div>

			<div class="topnav flowline spread overflow">
				<div>
				</div>
				<div>
					<button class="mybtn trans" data-runme="refresh"><i class="fas fa-sync-alt"></i></button>
					<button class="mybtn primary sm" data-runme="add_link"><i class="fas fa-plus"></i> add link</button>
				</div>
			</div>

			<!--
			<div class="input_area distance-sm themeround collapser panelbg">
				<a class="text-decoration-none spacy-sm flowline spread centerline" href="#addArea" data-toggle="collapse" data-target="#addArea">
					<span class="text-uppercase font-weight-bold">Add link</span>
					<i class="fa fa-chevron-down myicon"></i>
				</a>
				<form class="collapse panelbg themeround" id="addArea" data-preventDefault="yes">
					<div class="spacy-sm">
						<div class="row">
							<div class="form-group col-md-6">
								<label class="form-label" for="thecap">caption</label>
								<input type="text" class="form-control-custom" id="thecap" name="thecap" placeholder="what is this link for?">
							</div>
							<div class="form-group col-md-6">
								<label class="form-label" for="thelink">category</label>
								<select type="url" class="form-control-custom" id="thelink" name="thelink" placeholder="your link" required>
									<option>new</option>
									<option>misc</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="form-label" for="thelink">url</label>
							<input type="url" class="form-control-custom" id="thelink" name="thelink" placeholder="your link" required>
						</div>

						<div class="flowline right">
							<button class="mybtn secondary" data-toggle="collapse" data-target="#addArea">
								cancel
							</button>
							<button class="mybtn primary">
								<i class="fas fa-plus"></i> <t>add link</t>
							</button>
						</div>
					</div>
				</form>
			</div>
			-->

			<div class="links_area distance-sm themeround collapser panelbg_ collapser w3-display-container">
				<div class="spacy-sm">
					<span class="h4">Your links</span>
				</div>
				<div class="spacy-sm flowline spread centerline overflow">
					<div>
						<b>Filters</b>
					</div>
					<div class="flowline gap-sm">
						<div class="search-box">
							<input type="text" placeholder="Quick search..." id="quickSearch">
							<button><i class="fas fa-search"></i></button>
						</div>
						<div class="flow centroid">
							<a class="" data-toggle="collapse" data-target="#categoriesholder" href="#categoriesholder">
								<i class="fa fa-chevron-down myicon"></i>
								<!-- categories -->
							</a>
						</div>
					</div>
				</div>
				<div id="categoriesholder" class="collapse">
					<div class="pl-3 flowline gap-tn">
						<button class="btn flowline centerline category 0 active"><b>all</b></button>
						<button class="btn flowline centerline category 0"><b>new</b></button>
						<button class="btn flowline centerline category 1"><b>misc</b></button>
						<button class="btn flowline centerline category 2"><b>ccc</b></button>
					</div>
				</div>
			</div>

			<div class="thelinks">
				<div id="linksholder" class="spacy-sm_ pb-4" data-role="linksguy">
				</div>
			</div>

			<div class="like_box spacy-sm w3-hide" data-role="like_box">
				<div class="inner spacy-sm slide-l">
					<div class="w3-display-topright spacy-sm_">
						<button class="mybtn trans" data-runme="fbk_hide_likebox"><i class="fas fa-times"></i></button>
					</div>
					<div class="border-bottom pb-3">
						<span class="h4">Like this project</span>
						<span>
							did this project <b>help you</b>, <b>impress you</b> or annoy you or fill you with hope for the future, if it did let me know, I love hearing from my fans and haters alike.
						</span>
					</div>
					<div class="flowline overflow gap-tn left pt-3">
						<button class="mybtn2 tn secondary w3-hide_ liker" data-runme="fbk_like_project" data-mything="like"><i class="fas fa-thumbs-up"></i> like project</button>
						<button class="mybtn2 tn secondary w3-hide_ liker" data-runme="fbk_like_project" data-mything="dislike"><i class="fas fa-thumbs-down"></i> dislike project</button>
						<span class="text-muted liketxt" data-role="verdict"><b>you liked this, try again tomorrow</b></span>
						<button class="mybtn2 tn primary themegrad" data-runme="fbk_leave_comment"><i class="fas fa-comment"></i> comment</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		fbk_app_alias = "linksaver_guy";

		let ui_cats = undefined;
		let ui_links = undefined;
		let ui_search_npt = undefined;

		let last_links = [];
		let last_cats = [];
		let cats_parsed = [];

		// runtime data
			let debounce = 1000;
			let debounce_inter = undefined;
			let cur_filters = {};
			let cur_cat = 0;

		linkAtlas = {
			'get_categories' : './op/get_categories',
			'add_category' : './op/add_category',
			'edit_category' : './op/edit_category',
			'delete_category' : './op/delete_category',
			'get_links' : './op/get_links',
			'add_link' : './op/add_link',
			'edit_link' : './op/edit_link',
			'delete_link' : './op/delete_link',
		};

		links = [];

		window['getlinks'] = (e) => {
			let s = quickSearch.value;
			let payld = {limit: 20, search: s,...cur_filters};

			ui_links.innerHTML = mekLoader();

			const get_links = () => {
				getcategories();
				/*
				if(!(Object.keys(cur_filters).length > 0)){
					getcategories();
				} else {
					rendercats();
				}
				// */

				window[fetch_bypass](`${linkAtlas['get_links']}`,payld,'GET').then(d => {
					responseHandler(d,runafter,d);
				})
				.catch(err => {
					console.error(err);
					alert_danger(err.message);
				});
			}

			const runafter = (d) => {
				// alert_dark('rendering links');

				// let links = d.sendme.data || d.sendme;
				let links = d.sendme.data;
				console.log('returned data',d);
				last_links = links;
				renderlinks(links);
			}

			get_links();
		}

		window['getcategories'] = (e) => {
			let s = quickSearch.value;
			let payld = {limit: 20, search: s};

			// ui_links.innerHTML = mekLoader();

			const get_links = () => {
				window[fetch_bypass](linkAtlas['get_categories'],payld,'GET').then(d => {
					responseHandler(d,runafter,d);
				})
				.catch(err => {
					console.error(err);
					alert_danger(err.message);
				});
			}

			const runafter = (d) => {
				// alert_dark('gotten categories');
				let cats = d.sendme;
				console.log('returned data',d);
				last_cats = cats;

				cats_parsed = [];
				cats_parsed.push({value: 0,caption: "no category"});
				let arr = [...cats].map(c => {return {value: c.id, caption: c.category_name}});
				cats_parsed = [...cats_parsed, ...arr];
				rendercats(cats);
			}

			get_links();
		}

		window['renderlinks'] = (links = null) => {
			if(links == null){
				link = last_links;
			}

			let outht = ``;

			if(links.length == 0){
				outht = mekStandin('No links saved yet');
			}

			links.forEach((l,n) => {
				let len = 32;
				let catname = l.my_category == undefined ? 'no_tag' : l.my_category.category_name;
				let link_preview = l.link.length > len ? l.link.slice(0,len - 1) + '...' : l.link;
				outht += `
					<div class="themeround flowline spread centerline mb-2 slide-up panelbg" data-subrole="link" data-myid="${l.id}" style="${mekstagger(100,n+1)}" data-link="${l.link}">
						<div class="flow" style="gap:2px">
							<b class="cap">${l.caption}</b>
							<div>
								<b class="mybadge">${catname}</b>
								<small class="text-muted">${link_preview}</small>
							</div>
						</div>
						<div class="actions w3-hide_">
							<button class="opbtn themeround w3-hover-blue w3-hide" data-myid="${l.id}" data-runme="open_link"><i class="fa fa-external-link-alt"></i></button>
							<button class="opbtn themeround w3-hover-blue" data-myid="${l.id}" data-runme="edit_link"><i class="fa fa-pencil-alt"></i></button>
							<button class="opbtn themeround w3-hover-red" data-myid="${l.id}" data-runme="delete_link"><i class="fa fa-trash"></i></button>
						</div>
					</div>
				`;
			})

			ui_links.innerHTML = outht;

			setTimeout(() => {
				let btns = document.querySelectorAll(`[data-subrole="link"]`);

				btns.forEach(b => {
					b.addEventListener('click',(e) => {
						console.log(e);

						if(e.target.closest('.actions') != null){
							// alert_info('clicked actions');
							return;
						}

						let url = b.dataset.link;
						openinnewtab(url);
					})
				})
			},200);
			refreshUI(200);
		}

		window['rendercats'] = (links = null) => {
			let items = cats_parsed;
			let outht = `<div class="pl-3 flowline gap-tn left border-bottom_ spacy-tn overflow">`;

			if(items.length == 0){
				outht = mekStandin('No links saved yet');
			}

			items.forEach((l,n) => {
				let xcl = l.value == cur_cat ? 'active' : '';
				let fun = l.value != 0 ? 'filter' : 'clear_filters';
				outht += `
					<button class="btn flowline centerline category left slide-down ${xcl}" data-runme="${fun}" data-filter="category_id" data-value="${l.value}" style="${mekstagger(100,n)}">${l.caption}</button>
				`;
			})

			outht += `
					<button class="btn flowline centerline category left w3-orange borderless" data-runme="add_category"><b><i class="fas fa-plus"></i></b></button>
					<button class="btn flowline centerline category left w3-orange borderless" data-runme="manage_categories"><b><i class="fas fa-cog"></i></b></button>
				</div>`;

			ui_cats.innerHTML = outht;
			refreshUI(200);
		}

		function init() {
			ui_links = document.querySelector('#linksholder');
			ui_cats = document.querySelector('#categoriesholder');

			ui_search_npt = document.querySelector('#quickSearch');

			ui_search_npt.addEventListener('input',(e) => {
				search_handler();
			})
		}

		function start() {
			alert_dark('initialising');
			init();
			getlinks();
		}

		// links mgt ops
			window['add_link'] = (el) => {
				alert_info('adding a link');

				let inputs = [
					{
						typ: 'text',
						field: 'caption',
						label: 'caption',
						required: true,
					},
					{
						typ: 'url',
						field: 'link',
						label: 'link',
						required: true,
					},
					{
						typ: 'select',
						field: 'category_id',
						label: 'category',
						required: true,
						options: cats_parsed,
					}
				];

				const provide_input = () => {
					setTimeout(() => {
						get_input('Add new link',inputs,handleinput);
					},300);
				}

				const handleinput = (data) => {
					window[fetch_bypass](linkAtlas['add_link'],data,'POST').then(d => {
						responseHandler(d,runafter,d);

						if(!d.result){
							provide_input();
						}
					})
					.catch(err => {
						console.error(err);
						alert_warning('adding failed, try again');
						provide_input();
					});
				}

				const runafter = () => {
					getlinks();
				}

				provide_input();
			}
			window['edit_link'] = (el) => {
				alert_info('editing link');
				let l_id = el.dataset.myid;
				let link = last_links.filter(l => {return l.id == l_id})[0];

				if(link == undefined){
					alert_danger('invalid link id');
					return;
				}

				let inputs = [
					{
						typ: 'hidden',
						field: 'id',
						value: l_id,
					},
					{
						typ: 'text',
						field: 'caption',
						label: 'caption',
						value: link.caption,
						required: true,
					},
					{
						typ: 'url',
						field: 'link',
						label: 'link',
						value: link.link,
						required: true,
					},
					{
						typ: 'select',
						field: 'category_id',
						label: 'category',
						value: link.category,
						required: true,
						options: cats_parsed,
					}
				];

				const provide_input = () => {
					setTimeout(() => {
						get_input('Edit link',inputs,handleinput);
					},300);
				}

				const handleinput = (data) => {
					window[fetch_bypass](linkAtlas['edit_link'],data,'POST').then(d => {
						responseHandler(d,runafter,d);

						if(!d.result){
							provide_input();
						}
					})
					.catch(err => {
						console.error(err);
						alert_warning('editing failed, try again');
						provide_input();
					});
				}

				const runafter = () => {
					getlinks();
				}

				provide_input();
			}
			window['delete_link'] = (el) => {
				// alert_dark('deleting link');
				let l_id = el.dataset.myid;
				let link = last_links.filter(l => {return l.id == l_id})[0];

				if(link == undefined){
					alert_danger('invalid link id');
					return;
				}

				let inputs = [
					{
						typ: 'hidden',
						field: 'id',
						value: l_id,
					},
					{
						typ: 'text',
						field: 'caption',
						label: 'caption',
						value: link.caption,
						required: true,
					},
					{
						typ: 'url',
						field: 'link',
						label: 'link',
						value: link.link,
						required: true,
					},
					{
						typ: 'select',
						field: 'category_id',
						label: 'category',
						value: link.category,
						required: true,
						options: cats_parsed,
					}
				];

				const confirm_delete = () => {
					confirmAction('Delete link',`delete the link for ${mekBold(link.caption,'themetxt')}`,() => {do_delete({id: l_id})});
				}

				const do_delete = (data) => {
					window[fetch_bypass](linkAtlas['delete_link'],data,'POST').then(d => {
						responseHandler(d,runafter,d);

						if(!d.result){
							provide_input();
						}
					})
					.catch(err => {
						console.error(err);
						alert_warning('deleting failed, try again');
						// provide_input();
					});
				}

				const runafter = () => {
					getlinks();
				}

				confirm_delete();
			}
			window['refresh'] = () => {
				alert_dark('refreshing');
				getlinks();
			}
			window['search_handler'] = () => {
				if(debounce_inter !== undefined){
					clearTimeout(debounce_inter);
				}

				debounce_inter = setTimeout(() => {
					alert_info('searching...');
					getlinks();
				}, debounce);
			}
			window['filter'] = (el) => {
				cur_filters[el.dataset.filter] = el.dataset.value;
				getlinks();

				cur_cat = el.dataset.value;
			}
			window['clear_filters'] = (el) => {
				cur_filters = {};
				cur_cat = 0;
				getlinks();
			}

			window['add_category'] = (el) => {
				alert_dark('adding a category');

				let inputs = [
					{
						typ: 'text',
						field: 'category_name',
						label: 'category name',
						required: true,
					}
				];

				const provide_input = () => {
					setTimeout(() => {
						get_input('Add new Category',inputs,handleinput);
					},300);
				}

				const handleinput = (data) => {
					window[fetch_bypass](linkAtlas['add_category'],data,'POST').then(d => {
						responseHandler(d,runafter,d);

						if(!d.result){
							provide_input();
						}
					})
					.catch(err => {
						console.error(err);
						alert_warning('adding failed, try again');
						provide_input();
					});
				}

				const runafter = () => {
					getcategories();
				}

				provide_input();
			}
			window['edit_category'] = (el) => {
				let c_id = el.dataset.myid;
				let cat = cats_parsed.filter(c => {return c.value == c_id})[0];

				if(cat == undefined){
					alert_danger('invalid category');
					return;
				}
				alert_dark('adding a category');

				let inputs = [
					{
						typ: 'hidden',
						value: c_id,
						field: 'id'
					},
					{
						typ: 'text',
						field: 'category_name',
						label: 'category name',
						required: true,
						value: cat.caption
					}
				];

				const provide_input = () => {
					setTimeout(() => {
						get_input(`Edit Category: ${mekBold(cat.caption,'themetxt')}`,inputs,handleinput);
					},300);
				}

				const handleinput = (data) => {
					window[fetch_bypass](linkAtlas['edit_category'],data,'POST').then(d => {
						responseHandler(d,runafter,d);

						if(!d.result){
							provide_input();
						}
					})
					.catch(err => {
						console.error(err);
						alert_warning('Editing failed, try again');
						provide_input();
					});
				}

				const runafter = () => {
					getcategories();
				}

				provide_input();
			}
			window['delete_category'] = (el) => {
				// alert_dark('deleting link');
				let c_id = el.dataset.myid;
				let cat = cats_parsed.filter(c => {return c.value == c_id})[0];

				if(cat == undefined){
					alert_danger('invalid category id');
					return;
				}

				const confirm_delete = () => {
					confirmAction('Delete category',`delete the category ${mekBold(cat.caption,'themetxt')}`,() => {do_delete({id: c_id})});
				}

				const do_delete = (data) => {
					window[fetch_bypass](linkAtlas['delete_category'],data,'POST').then(d => {
						responseHandler(d,runafter,d);

						if(!d.result){
							provide_input();
						}
					})
					.catch(err => {
						console.error(err);
						alert_warning('deleting failed, try again');
						// provide_input();
					});
				}

				const runafter = () => {
					getlinks();
				}

				confirm_delete();
			}
			window['manage_categories'] = (el) => {
				alert_info('managing categories');

				let outht = mekStandin('no idea what UI yet');

				outht = ``;

				cats_parsed.forEach((c) => {
					outht += `
						<div class="flowline spread in_fullwidth themehover border mb-3 spacy-tn themeround halfpick" data-myid="${c.value}">
							<div>${mekBold(c.caption)}</div>
							<div>
								${mekIcon('fas fa-edit','mr-3 w3-hover-text-blue',`data-runme="edit_category" data-myid="${c.value}" data-dismiss="modal"`)}
								${mekIcon('fas fa-trash','mr-3 w3-hover-text-red',`data-runme="delete_category" data-myid="${c.value}" data-dismiss="modal"`)}
							</div>
						</div>
					`;
				})

				mekModal({
					title: 'Manage categories',
					sub: 'here you can manage the categories available',
					has_continue: false,
					content: outht
				});

				refreshUI(200);
			}

		callOnLoad.push({act: start});
		callOnLoad.push({act: setup_uimode});
		callOnLoad.push({act: fbk_handle_reactpanel});
	</script>
</body>
</html>
