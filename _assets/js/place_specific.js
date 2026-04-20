function renderLinks(){
	// let items = JSON.parse(links);
	let items = links;

	linksholder.innerHTML = "";
	
	items.forEach((el,id) => {
		let li = document.createElement('li');
		let a = document.createElement('a');
		let caption = el.includes('://') ? el.split("://")[1].split("/")[0] : el;

		caption = caption.length > 12 ? caption.slice(0,12).padEnd(15,'.') : caption;
		a.href = el;
		a.textContent = `${caption}`;

		li.appendChild(a);
		linksholder.appendChild(a);
	});

	document.querySelector('.cap').innerHTML = `<span>showing <b>${items.length}</b> links</span>`
}