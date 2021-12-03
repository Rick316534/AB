let btn = document.getElementById("btn");
let Reply = document.getElementById("Reply");
let answer=document.getElementById("answer");
let xhr = new XMLHttpRequest();
btn.addEventListener("click", function(){
    console.log(Reply.value);
    let xhr = new XMLHttpRequest();
    xhr.open('post','AB.php');
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.send(Reply.value);
    xhr.onload = function() {
        console.log(this.responseText);
    }
})
