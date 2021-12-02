let btn = document.getElementById("btn");
let xhr = new XMLHttpRequest();
btn.addEventListener("click", function({
	xhr.open('get','work.php');
	xhr.send(null);
	xhr.onload = function() {
    		let _data = xhr.responseText;
    		console.log(_data);
}
});
