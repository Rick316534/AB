let btn = document.getElementById("btn");
let reply = document.getElementById("reply");
let answer=document.getElementById("answer");
let reset = document.getElementById("reset");
let historicalRecord=document.getElementById("history");
let jsn; //
let phpArray; //
let topicReset = true;
reset.addEventListener("click",function(){
    topicReset = true;
    answer.innerText = "";
    historicalRecord.innerText = "";
    reply.value = "";
})
btn.addEventListener("click", function(){
    jsn = JSON.stringify({"reply":reply.value,"topicReset":topicReset});
    let xhr = new XMLHttpRequest();
    try {
        xhr.open('post','AB.php');
        xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        xhr.send(jsn);
        xhr.onload = function() 
        {
            try {
                phpArray = JSON.parse(this.responseText);
                historicalRecord.innerText = phpArray['history'];
                answer.innerText = phpArray['result'];
                topicReset = false;
            } catch(e) { 
                answer.innerText = this.responseText;
            }
            
        }

    } catch (e) {

    }
})

