const appkey = "trybxp_companion_";
const pref_paths = appkey + 'savedlinks';

const fetch_bypass = "fetch_bypass_" + mekRandomString(5);
const fetch_ui = "fetch_bypass_" + mekRandomString(5);
const fetch_bypass_fyls = "fetch_bypass_fyls_" + mekRandomString(5);
const simple_fetch = "simple_fetch_bypass_" + mekRandomString(5);
// const session_CSRF_token = mekRandomString(12);
const session_CSRF_token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const fetch_identifier = "viaFetch";
const confirm_callback = "runtime_fun_" + mekRandomString(5);
const confirm_canceller = "runtime_fun_" + mekRandomString(5);

const mainhost = ".";
const imagepath = `${mainhost}/res/images/`;

const pref_auth = 'trybXP_comp_app_access_token';
var curfun = "";

var cache_lifetime_in_secs = 60 * 60 * 24;
let enableCache = true;
// var cache_lifetime_in_secs = 24;

// var confirm_modal = undefined;
// var confirm_toggler = undefined;
// var the_modal = undefined;
// var the_modal_toggler = undefined;

// UI elements
var dft_holder = undefined;

const pages = {
	'emulator' : './UX_dev/app.html',
	'home' : "index.html",
	'api tester' : "api_tester.html",
	'actions' : "actions.html",
}

curfun = fetch_bypass;
if(window[curfun] == undefined){
	window[curfun] = async (p,dta = {},mt = 'POST',skipappend = false,use_as_is=false) => {
		try{
			alert_silent({to: p,data: dta,method: mt});

			mt = mt.toUpperCase();

			if(!skipappend && !use_as_is){
				dta[fetch_identifier] = 'yes';
				dta['source'] = 'makwldnnalwkndajkdnajwdn_testenviron';
			}
			// alert_dark(JSON.stringify(dta));

			let headers = {
				'X-Requested-With' : 'XMLHttpRequest',
				'X-CSRF-TOKEN' : session_CSRF_token,
				'Accept' : 'application/json',
				'Content-Type' : 'application/json',
			};

			const prff = JSON.parse(localStorage.getItem(pref_auth));

			// alert(prff);

			if (prff !== null) {
				headers['Authorization'] = `Bearer ${prff.value}`
			}

			let body = mt == "GET" || mt == 'HEAD' ? null : (use_as_is ? dta : JSON.stringify(dta));

			// await alert_dark('sending info');

			// alert_info(JSON.stringify(headers));
			// console.log(`[${fetch_bypass}] passed_data: `,dta);
			// console.log(`[${fetch_bypass}] headers: `,headers);
			// console.log(`[${fetch_bypass}] request body: `,body);

			let s_data = {
				method: mt.toUpperCase(),
				headers: headers,
				// credentials: 'same-origin',
			};

			if(!(mt == "GET" || mt == 'HEAD')){
				s_data.body = body;
			}

			let req = await fetch(p,s_data);

			if(!req.ok){
				if(req.status == 422){
					throw new Error(`[${req.status}] -> some required fields are missing`);
				} else if(req.status == 419){
					throw new Error(`[${req.status}] -> Your session has expired, reload the page to continue`);
				}

				throw new Error(`[${req.status}] -> ${req.statusText}`);
			}

			return await req.json();
		} catch (error){
			alert_danger(error);
			throw new Error(error);
		}
	}
}

curfun = fetch_bypass_fyls;
if(window[curfun] == undefined){
	window[curfun] = async (p,dta = {},mt = 'POST',skipappend = false,use_as_is=false) => {
		try{
			alert_silent({to: p,data: dta,method: mt});

			if(!skipappend && !use_as_is){
				dta[fetch_identifier] = 'yes';
			}
			// alert_dark(JSON.stringify(dta));

			let headers = {
				'X-Requested-With' : 'XMLHttpRequest',
				'X-CSRF-TOKEN' : session_CSRF_token,
				'Accept' : 'application/json',
				// 'Content-Type' : 'multipart/form-data',
			};
			const prff = JSON.parse(localStorage.getItem(pref_auth));
			if (prff !== null) {
				headers['Authorization'] = `Bearer ${prff.value}`
			}

			let body = mt == "GET" || mt == 'HEAD' ? null : (use_as_is ? dta : JSON.stringify(dta));

			// alert_info(JSON.stringify(headers));
			// console.log(`${fetch_bypass}: `,dta);

			let req = await fetch(p,{
				method: mt.toUpperCase(),
				headers: headers,
				// credentials: 'same-origin',
				body: body,
			});

			if(!req.ok){
				if(req.status == 422){
					throw new Error(`[${req.status}] -> some required fields are missing`);
				} else if(req.status == 419){
					throw new Error(`[${req.status}] -> Your session has expired, reload the page to continue`);
				}

				throw new Error(`[${req.status}] -> ${req.statusText}`);
			}

			return await req.json();
		} catch (error){
			alert_danger(error);
			throw new Error(error);
		}
	}
}

curfun = simple_fetch;
if(window[curfun] == undefined){
	window[curfun] = async (p,dta = {},mt = 'POST') => {
		try{
			alert_silent({to: p,data: dta,method: mt});

			dta[fetch_identifier] = 'yes';
			// alert_dark(JSON.stringify(dta));

			mt = mt.toUpperCase();
			let body = mt == "GET" || mt == 'HEAD' ? null : JSON.stringify(dta);

			// alert_info(JSON.stringify(headers));
			// console.log(`${fetch_bypass}: `,dta);

			let req = await fetch(p,{
				method: mt,
				// credentials: 'same-origin',
				body: body,
			});

			if(!req.ok){
				throw new Error(`[${req.status}] -> ${req.statusText}`);
			}

			return await req.json();
		} catch (error){
			alert_danger(error);
			throw error;
		}
	}
}

curfun = "simple_fetcher";
if(window[curfun] == undefined){
	window[curfun] = async (p,dta = {},mt = 'POST') => {
		try{
			alert_silent({to: p,data: dta,method: mt});

			dta['viaFetch'] = 'yes';
			// alert_dark(JSON.stringify(dta));

			my_CSRF_token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

			let headers = {
				'X-Requested-With' : 'XMLHttpRequest',
				'X-CSRF-TOKEN' : my_CSRF_token,
				'Accept' : 'application/json',
				'Content-Type' : 'application/json',
			};

			mt = mt.toUpperCase();
			let body = mt == "GET" || mt == 'HEAD' ? null : JSON.stringify(dta);

			// alert_info(JSON.stringify(headers));
			// console.log(`${fetch_bypass}: `,dta);

			let req = await fetch(p,{
				method: mt,
				// credentials: 'same-origin',
				headers: headers,
				body: body,
			});

			if(!req.ok){
				throw new Error(`[${req.status}] -> ${req.statusText}`);
			}

			return await req.json();
		} catch (error){
			alert_danger(error);
			throw error;
		}
	}
}

curfun = fetch_ui;
if(window[curfun] == undefined){
	window[curfun] = async (p,dta = {},mt = 'POST',skipappend = false,use_as_is=false) => {
		try{
			let now = new Date();
			let mkey = `${pref_prefix}[${p}]`;
			let pkey = `${pref_prefix}mypermissions`;
			let local_cache_version = localStorage.getItem(mkey);
			let saved_perms = localStorage.getItem(pkey);

			let cache_saved = local_cache_version !== undefined && local_cache_version !== null;
			let perms_saved = saved_perms !== undefined && saved_perms !== null;

			if(cache_saved && perms_saved && enableCache){
				let local_cache = JSON.parse(local_cache_version);
				let myperms = getitempermissions(p);

				if(mypermissions.includes(myperms) || myperms == undefined){
					let cache_age = getDateDiff(now, local_cache.saved_at);
					let usecache = (cache_age <= cache_lifetime_in_secs);
					let isvalid = saved_perms.toLowerCase() == JSON.stringify(mypermissions).toLowerCase();

					if(usecache && isvalid){
						alert_dark('loading from cache');
						return local_cache.html;
					} else {
						if(!usecache){
							// alert_dark(`cache is old [${cache_age} / ${cache_lifetime_in_secs}s old], disposing`,12);
							localStorage.removeItem(mkey);
						} else {
							// alert_dark('cache is invalid');
						}
					}
				} else {
					// alert_dark('cache found but you dont have permissions');
					// alert_dark(`permissions required: ${myperms}`);
				}
			} else {
				// alert_dark('no cache found');
			}

			alert_silent({to: p,data: dta,method: mt});
			alert_info('loading from server, please wait');

			const prff = JSON.parse(localStorage.getItem(pref_auth));

			let headers = {
				'X-Requested-With' : 'XMLHttpRequest',
				'X-CSRF-TOKEN' : session_CSRF_token,
				'Accept' : 'application/json',
				'Content-Type' : 'application/json',
			};

			// alert(prff);

			if (prff !== null) {
				headers['Authorization'] = `Bearer ${prff.value}`
			}

			let s_data = {
				method: mt.toUpperCase(),
				headers: headers,
				// credentials: 'same-origin',
			};

			let req = await fetch(p,s_data);
			let final = await req.text();
			let cache = {
				saved_at: (new Date()).toLocaleString(),
				html: final
			};
			let cache_data = JSON.stringify(cache);

			// save cache for fast loading later
			localStorage.setItem(mkey,cache_data);
			localStorage.setItem(pkey,JSON.stringify(mypermissions));

			return final;
		} catch (error){
			alert_danger(error);
			throw new Error(error);
		}
	}
}

curfun = "loadUI";
if(window[curfun] == undefined){
	window[curfun] = async ({p='/',mt='get',holder=undefined,prerun = () => {alert_info('loading...')},postrun=() => {alert_info('loaded')}}) => {
		if(holder === undefined){
			holder = dft_holder;
		}

		if(typeof prerun == "function"){
			prerun();
		}

		showloader();

		window[fetch_ui](p,{},mt).then(d => {
			hideloader();
			holder.innerHTML = d;
			refreshUI(300)

			if(typeof postrun == "function"){
				postrun();
			}
		})
	}
}

curfun = "log_visit";
if(window[curfun] == undefined){
	window[curfun] = async (p,dta = {},mt = 'POST') => {
		let mypage = undefined;
		let base = document.querySelector('base');
		let c_page = cpg(window.location.href);

		if(base != undefined){
			// alert_info(base.href);
			c_page = window.location.href.replace(base.href,'');
		}

		// alert_info(c_page);
		window['simple_fetcher'](`${mainhost}/api/log_visit`,{where: c_page}).then(w => {
			if(w){
				alert_silent('wirked');
			} else {
				alert_silent('not wirked');
			}
		});
	}
}

curfun = "mekXtras";
if(window[curfun] == undefined){
	window[curfun] = (m) => {
				dft_holder = document.querySelector('#app_ui');

		// alert_info('making extras');
		alert_silent('making extras');

		// make the confirmer modal
		if(false && confirm_modal === undefined){
			let conid = "confirmerBox_" + mekRandomString(3);
			let desig = `#${conid}`;

			let b = document.createElement('div');

			b.className = "mymodal";
			b.style.display = "none";
			b.id = conid;
			b.dataset.shown = "0";
			b.innerHTML = `
				<div class="modal-content modal-sm w3-animate-opacity" role="document">
					<button type="button" class="close w3-right w3-btn" data-toggler="${desig}" aria-label="Close">
						<i class="fa fa-times"></i>
					</button>
					<div class="flow gap-sm">
						<div class="modal-header">
							<span class="modal-title h3">Confirm Action</span>
						</div>
						<div class="modal-body">
							do you want to delete this
						</div>
						<div class="modal-footer w3-left-align">
							<button type="button" class="btn outline except" data-toggler="${desig}" data-subrole="cancel">cancel</button>
							<button class="btn primary except" data-subrole="continue">continue &raquo;</button>
						</div>
					</div>
				</div>
			`;

			let btn = document.createElement('button');
			btn.classList.add('w3-hide');
			btn.dataset.toggler = desig;
			btn.dataset.onshow = "flex";

			document.body.appendChild(b);
			document.body.appendChild(btn);
			confirm_modal = b;
			confirm_toggler = btn;
		}

		// make the common modal
		conid = "modalBox_" + mekRandomString(3);
		desig = `#${conid}`;

		b = document.createElement('div');

		b.className = "mymodal fade";
		b.style.display = "none";
		b.id = conid;
		b.dataset.shown = "0";
		b.innerHTML = `
			<div class="modal-content modal-sm w3-animate-opacity" role="document" style="width: 90vw;max-width: 800px;">
				<button type="button" class="close w3-right w3-btn" data-toggler="${desig}" aria-label="Close">
					<i class="fa fa-times"></i>
				</button>
				<div class="flow gap-sm">
					<div class="modal-header">
						<span class="modal-title h3">nn</span>
						<p class="modal-subtitle">--</p>
					</div>
					<div class="modal-body">
						do you want to delete this
					</div>
					<div class="modal-footer w3-left-align w3-hide">
						<button type="button" class="btn outline except" data-toggler="${desig}" data-subrole="cancel">cancel</button>
						<button class="btn primary except" data-subrole="continue">continue &raquo;</button>
					</div>
				</div>
			</div>
		`;

		btn = document.createElement('button');
		btn.classList.add('w3-hide');
		btn.dataset.toggler = desig;
		btn.dataset.onshow = "flex";

		document.body.appendChild(b);
		document.body.appendChild(btn);

		// alert_info('med modal');
		alert_silent('med modal');
		the_modal = b;
		the_modal_toggler = btn;


		// refresh UI when everything is done
		refreshUI(100);
	}
}

function getFormdata(formElement) {
	if (!(formElement instanceof HTMLFormElement)) {
		throw new Error('Input must be a <form> element');
	}

	if (!formElement.reportValidity()) {
		return null; // Validation failed
	}

	return new FormData(formElement);
}

function responseHandler(w,callback,args = undefined,quiet = false,skip_prepro = false) {
	console.log('response_handler: ',w);

	const runcallback = () => {
		if(callback != undefined || typeof callback === 'function'){
			args = args ?? w;
			callback(args);
		}
	}

	if(skip_prepro){
		runcallback();
	}

	if(w.success){
		if(w.result){
			if(!quiet) {alert_success(w.message);}

			runcallback();
		} else {
			if(!quiet) alert_warning(w.message,7);
		}
	} else {
		alert_warning('sorry, you arent logged in. lets fix that',12);
		setTimeout(() => {
			// window.location.reload();
			// window.location.assign('./login');
		}, 3000);
	}
}

// [html generators]________________________________________________________________________________
function mekdisplay(what,startclasses = '',template='[val]') {
	let out = '';
	let trydate = new Date(what);

	if(what == null ) return 'null';
	if(what == undefined ) return 'undefined';
	if(trydate != 'Invalid Date' && (typeof what != 'object') && (("" + what).includes('-') || ("" + what).includes('/'))){
		return trydate.toLocaleDateString('en-US', {
					year: 'numeric',
					month: 'numeric',
					day: 'numeric',
					hour: 'numeric',
					minute: 'numeric'
				});
	}

	if(typeof what == 'object'){
		out += `<div class="${startclasses}">`;
		Object.keys(what).forEach(k => {
			val = `<b>${k}</b> : ${mekdisplay(what[k])}<br>`;
			out += template.replaceAll('[val]',val);
		})
		out += '</div>';
	} else if(typeof what == "array"){
		what.forEach(k => {
			out += `<div>${k}</div>`;
		})
	} else if(typeof what == 'string'){
		if(what.includes('http:') || what.includes('https:')){
			out += `<a href="${what}">${what.substr(0,50)}</a>`;
		} else {
			out += what;
		}
	} else {
		out += template.replaceAll('[val]',what);
	}

	return out;
}

function mekstagger(delay,count) {
	let del = count * delay;
	return `animation-delay: ${del}ms;animation-fill-mode: forwards;opacity: 0;`;
}

function mekError(hed= 'Error',demo='an error happened',serious = false){
	let sertxt = serious ? `<button class="mybtn primary sm" onclick="window.location.reload()">reload page</button>` : '';

	return `
		<div class="spacy-mg w3-center slide-up flow gap-sm">
			${mekHeading(hed,'h4')}
			<b><i class="w3-text-red">${demo}</i></b>
			<div>
				${sertxt}
			</div>
		</div>
	`;
}
function mekUiAlert(msg,typ='danger',icon='fa fa-info') {
	return `
		<article class="spacy-sm border-${typ} uialert alert-${typ} text-${typ} slide-up" style="border-left: 3px solid;">
			<i class="${icon} mr-2"></i><b>${msg}</b>
		</article>
	`;
}
function mekStandin(demo='an error happened',class_ovr = 'w3-text-black',cta_link = undefined,cta_text = undefined){
	let cta = '';

	cta = cta_link != undefined ?
		`<a href="${cta_link}" class="btn outline"><i class="fa fa-plus"></i> ${cta_text || 'go now'}</a>` :
		'';

	return `
		<div class="spacy-mg w3-center slide-up">
			<b><i class="${class_ovr}">${demo}</i></b>
			${cta}
		</div>
	`;
}

function mekSection(heading = "heading",demo='an error happened',class_ovr = 'w3-text-black',cta_link = undefined,cta_text = undefined){
	let cta = '';

	cta = cta_link != undefined ?
		`<a href="${cta_link}" class="btn outline"><i class="fa fa-plus"></i> ${cta_text || 'go now'}</a>` :
		'';

	return `
		<div class="spacy-mg w3-center slide-up">
			<span class="h3">${heading}</span>
			<p class="${class_ovr}">${demo}</p>
			${cta}
		</div>
	`;
}

function mekArticle(pr) {
	let dft = {heading: "Content",sub: "",content: "<i>no content defined</i>",_props: "",c_props: "",c_class: "formguy",_class: "spacy-md"};
	pr = {...dft,...pr};

	alert_silent('loading article');
	alert_silent(pr);
	console.log("mekArticle argument: ",pr);

	let heading = pr.heading || "";
	let sub = pr.sub || "testing article";
	let content = pr.content || "<hr>";
	let props = pr._props || "";
	let content_props = pr.c_props || "";
	let c_class = pr.c_class || "formguy";
	let className = pr._class || "spacy-md";

	return `
		<article class="slide-up ${className}" ${props}>
			<div>
				<span class="h2">${heading}</span>
				<span>${sub}</span>
			</div>
			<div class="${c_class}" ${content_props}>
				${content}
			</div>
		</article>
	`;
}

function mekCenteredDiv(m) {
	const dftm = {
		maxwidth: 400,
		props: '',
		content: '',
	}

	m = {...dftm,...m};

	let outht = `
		<div class="flow centroid" ${m.props}>
			<div class="in_fullwidth_" style="width:100%;max-width: ${m.maxwidth}px;">${m.content}</div>
		</div>
	`;

	return outht;
}

function mekButton(pr = {caption: "",type: "button",icon:"",_props: "",_class:"",btype: "primary",act: undefined}) {
	pr = {caption: "",type: "button",icon:"",_props: "",_class:"",btype: "x",act: undefined,...pr};

	let caption = pr.caption || "cap";
	let type = pr.type || "button";
	let icon = pr.icon || "";
	let _props = pr._props || "data-genui";
	let _class = pr._class || "xx";
	let mytype = pr.btype || "x";
	let act = pr.act || undefined;

	if(mytype != undefined){
		_class = `btn ${mytype}`;
	} else if(mytype == "x"){
		_class = _class == "xx" ? "btn primary" : _class;
	}

	let mfun_code = undefined;

	if(typeof act == "function"){
		// create a function stored in the window property so that it can be run later via clicking the button
		// potential memory leak though
		mfun_code = "runtime_act_" + mekRandomString(4);
		window[mfun_code] = () => {
			act();
		};

		_props += ` data-runme="${mfun_code}"`;

		setTimeout(() => {
			refreshUI();
		}, 200);
	}

	return `<button type="${type}" class="${_class}" ${_props}>${caption} <i class="fa ${icon}"></i></button>`
}

function mekInputholder(params) {
	const dftdata = {
		label: "input",
		field: "inp_name",
		typ:"text",
		placeholder: undefined,
		props: undefined,
		_inp_props: undefined,
		_inp_classes: undefined,
		required: false
	};

	params = {...dftdata,...params};

	let field = params.field || "input_field_"+mekRandomString(3);
	let label = params.label || field;
	let typ = params.typ || "text";
	let placeholder = params.placeholder || `enter ${label} here`;
	let props = params.props || 'data-noprops';
	let val = params.value || '';
	let _inp_props = params._inp_props || '';
	let _inp_req = params.required ? "required" : "";
	let _inp_classes = params._inp_classes || "no_additional_classes";

	let xtrs = props == undefined ? "" : props;

	placeholder = placeholder == undefined ? `enter ${label} here...` : placeholder;

	let inputht = `<input class="form-control-custom ${_inp_classes}" type="${typ}" name="${field}" id="${field}" placeholder="${placeholder}" ${_inp_props} ${_inp_req} value="${val}">`;

	if(typ == 'select'){
		let optht = ``;

		let opts = params.options ?? [];

		opts.forEach(o => {
			optht += `<option value="${o.value}">${o.caption ?? o.value}</option>`;
		})

		inputht = `
			<select class="form-control-custom ${_inp_classes}" name="${field}" id="${field}" ${_inp_props} ${_inp_req}>
				<option disabled>${placeholder}</option>
				${optht}
			</select>
		`;
	} else if(typ == "textarea"){
		inputht = `<textarea class="form-control-custom ${_inp_classes}" rows="3" name="${field}" id="${field}" placeholder="${placeholder}" ${_inp_props} ${_inp_req}>${val}</textarea>`
	}

	return `
		<div class="inputholder" ${props || "data-noprops"}>
			<label class="form-label" for="${field}">${label} ${params.required === true ? '*' : ''}</label>
			${inputht}
		</div>
	`;
}

function mekForm(m) {
	let dftdata = {
		inputs: [],
		action: "",
		method: "get",
		onsubmit: "",
		props: `data-mymessage="info submitted successfully"`,
		extrahtml_pre: '',
		extrahtml_post: '',
		blockDefault: false
	};

	let use = {...dftdata,...m};

	let _sub = use.onsubmit == "" ? undefined : use.onsubmit;
	let _submitter = _sub == undefined ? "" : `data-onsubmit="${_sub}"`;
	let _props = use.props;
	let _block = use.blockDefault ? "yes" : "no";

	let outht = `
		<form class="formguy" action="${use.action}" method="${use.method}" ${_props} ${_submitter} data-blockdefault="${_block}">
			${use.extrahtml_pre}
	`;

	use.inputs.forEach(i => {
		outht += mekInputholder(i);
	})

	outht += `
			${use.extrahtml_post}
			<div class="distance-sm">
				${mekButton({caption: "submit data",btype: "primary",type:"submit"})}
			</div>
		</form>
	`;

	return outht;
}

function mekLoader(t) {
	return `
		<div class="spacy-lg w3-center flow centroid gap-md slide-up">
			<div>${t || "loading..."}</div>
			<div class="loader"></div>
		</div>
	`;
}

function mekNavbar(links,cta = {}) {
	const linkHTML = links.map(l => {
		l.href = l.href ?? "#";
		const text = l.caption ?? l.href;
		const iconTag = l.icon ? `<i class="${l.icon}"></i>` : '';
		const props = l.props ?? '';
		return `<a href="${l.href}" ${props}>${iconTag}${text}</a>`;
	}).join('');

	let dft = {link: '#contact',icon:'fa-phone',label: "reach out"}

	cta = {...dft,...cta};

	return `
		<nav class="" data-scroller data-scrollend="80%" data-classdata="w3-animate-opacity,scrolled">
			<div class="navcon">
				<div class="logo">
					<a href="#" class="logo">Haosel</a>
				</div>

				<div class="navlinks" id="sitelinks" data-visibledata="0,0,1">
					${linkHTML}
				</div>

				<div>
					<a href="${cta.link}" class="btn cta-btn">
						<i class="fa ${cta.icon}"></i>
						${cta.label}
					</a>
				</div>

				<div class="hamburger smallmenu w3-hide-large btn" data-toggler="#mobilemenu" id="hamburger" data-onshow="flex">
					<a><i class="fa fa-bars"></i></a>
				</div>
			</div>
		</nav>`;
}

const mekCards = (actions) => {
	// actions: [{icon:'fa-user',label:'Profile',handler:()=>{}}, ...]
	const markup = `
		<div id="actionOverlay" class="mymodal w3-animate-opacity" style="display:none;" data-shown="0">
			<div class="modal-content" style="max-width:720px;padding:2rem">
				<button class="closebtn" data-toggler="#actionOverlay">
					<i class="fa fa-times"></i>
				</button>
				<div class="spacy-md flowline overflow center" style="margin-top:1rem">
					${actions.map((a,id)=>`
						<div class="thecard small slide-up" style="flex:0 0 180px;cursor:pointer;${mekstagger(400,id)}" data-toggler="#actionOverlay" data-runme="${a.handler}">
							<div class="card-content flow center">
								<i class="fa ${a.icon} themetxt"></i>
								<span class="modetxt">${a.label}</span>
							</div>
						</div>
					`).join('')}
				</div>
			</div>
		</div>
	`;
	return markup;
}

const mekModal = (d) => {
	const dft = {title: 'modal',sub: ' ',content: ' '};
	d = {...dft,...d};

	let mdl = the_modal;

	const title = mdl.querySelector('.modal-title');
	const subtitle = mdl.querySelector('.modal-subtitle');
	const con = mdl.querySelector('.modal-body');

	title.innerHTML = d.title;
	subtitle.innerHTML = d.sub;
	con.innerHTML = d.content;

	the_modal_toggler.click();
}

function mekHeading(content,type){
	return `<span class="${type || 'h2'}">${content || 'heading'}</span>`;
}
function mekSpan(w) {
	return `<span>${w}</span>`;
}
function mekStrong(w) {
	return `<strong>${w}</strong>`;
}
function mekBold(w) {
	return mekStrong(w);
}

// [end of generators]_____________________________________________________________

function confirmAction(title=undefined,msg=undefined,callback=() => {alert_warning('testing dialog confirmation')},keepopen = false,canceller=()=>{}) {
	if(typeof callback != 'function'){
		alert_danger('invalid callback');
		return;
	}

	title = title == undefined ? 'Confirm Action' : title;
	msg = msg == undefined ? 'Proceed with action' : msg;

	const cont_btn = confirm_modal.querySelector('[data-subrole="continue"]');
	const closebtn = confirm_modal.querySelector('[data-subrole="cancel"]');
	const txt = confirm_modal.querySelector('.modal-body');
	const hed = confirm_modal.querySelector('.modal-title');

	txt.innerHTML = msg;
	hed.innerHTML = title;

	window['confirm_callback_called'] = false;
	window['confirm_canceller_called'] = false;

	window[confirm_callback] = (n) => {
		if(window['confirm_callback_called']){
			alert_silent('double calling detected for `confirm_callback`')
			return;
		}
		window['confirm_callback_called'] = true;

		callback();

		if(!keepopen){
			confirm_toggler.click();
		}
	};
	window[confirm_canceller] = (n) => {
		if(window['confirm_canceller_called']){
			alert_silent('double calling detected for `confirm_canceller`')
			return;
		}
		window['confirm_canceller_called'] = true;

		canceller();
	};

	if(cont_btn.dataset.wasset == undefined){
		cont_btn.addEventListener('click',() => {
			window[confirm_callback]();
			cont_btn.dataset.wasset = "imset";
			// alert_success('confirmer');
		})
	}
	if(closebtn.dataset.wasset == undefined){
		closebtn.addEventListener('click',() => {
			window[confirm_canceller]()
			closebtn.dataset.wasset = "imset";
			confirm_toggler.click();
			// alert_danger('cancelling');
		});
	}

	confirm_toggler.click();
}

// utils (backups in case uiops or toappend isnt updating)
	if(window['objtoquery'] == undefined){
		window['objtoquery'] = (obj, prefix = '') => {
			// makes objects be sent via get if possible
			const pairs = [];

			for (const key in obj) {
				if (obj.hasOwnProperty(key)) {
					const fullKey = prefix ? `${prefix}[${key}]` : key;
					const value = obj[key];

					if (value !== null && typeof value === 'object' && !Array.isArray(value)) {
						pairs.push(objtoquery(value, fullKey));
					} else if (Array.isArray(value)) {
						value.forEach(item => {
							pairs.push(encodeURIComponent(fullKey + '[]') + '=' + encodeURIComponent(item));
						});
					} else {
						pairs.push(encodeURIComponent(fullKey) + '=' + encodeURIComponent(value));
					}
				}
			}

			return pairs.join('&');
		}
	}

	function clear_view_cache() {
		let tokill = [];

		for(let c = 0;c < localStorage.length;c++){
			let key = localStorage.key(c);
			if(key.includes(pref_prefix)){
				tokill.push(key);
			}
		}

		tokill.forEach(tk => {
			localStorage.removeItem(tk);
		})

		alert_dark('all view cache cleared');
	}

function formatDate0(date) {
	if(!date){return '--';}

	const d = new Date(date); // Ensures input is a Date object
	const day = String(d.getDate()).padStart(2, '0');
	const month = String(d.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
	const year = d.getFullYear();
	const hours = String(d.getHours()).padStart(2, '0');
	const minutes = String(d.getMinutes()).padStart(2, '0');
	const seconds = String(d.getSeconds()).padStart(2, '0');

	return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
}

function formatDate(date) {
	if(!date){return '--';}

	return date.toLocaleDateString('en-US', {
		month: 'short',
		day: 'numeric',
		year: 'numeric'
	});
}

function formatDateTime(date) {
	if(!date){return '--';}

	return date.toLocaleString('en-US', {
		year: 'numeric',
		month: '2-digit',
		day: '2-digit',
		hour: '2-digit',
		minute: '2-digit',
		second: '2-digit',
		hour12: false
	}).replace(/(\d+)\/(\d+)\/(\d+),/, '$3-$1-$2');
}

function formatNumber(n,dp = 0,locale = true) {
	if(Number(n) == NaN){
		alert_danger('invalid number passed for formatting');
		return 'NaN';
	} else {
		n = Number(n);
	}

	let parts = n.toString().split('.');
	let p1 = locale ? Number(parts[0]).toLocaleString() : Number(parts[0]);
	let p2 = parts[1] || '00';

	p2 = p2.slice(0,dp);
	res = dp == 0 || !(n.toString().includes('.')) ? p1 : `${p1}.${p2}`;

	return res;
}


// log visit
callOnLoad.push({act: window['log_visit']});
callOnLoad.push({act: window['mekXtras']});
