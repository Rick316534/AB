let btn = document.getElementById("btn");
let Reply = document.getElementById("Reply");
let answer=document.getElementById("answer");
let history=document.getElementById("history");
let xhr = new XMLHttpRequest();
let num = 0;
let jsn,obj,rangestr=1;
btn.addEventListener("click", function(){
    
    num += 1;
    jsn=JSON.stringify({"num": num.toString() ,"reply":Reply.value,"rangestr":rangestr});
    let xhr = new XMLHttpRequest();
    xhr.open('post','AB.php');
    xhr.setRequestHeader('Content-type','application/x-www-form-urlencoded');
    xhr.send(jsn);
    xhr.onload = function() {
        console.log(rangestr);
        console.log(this.responseText);
        obj=JSON.parse(this.responseText);
        let objlength = obj.length-1;
        answer.innerText = obj[objlength].result;
        obj.forEach(element => {
            if(element.rangestr=="1")
                rangestr=1;
            else
                rangestr=0;
            answer.innerText=element.result;
            if(element.num ==1)
                history.innerText = "輸入： " + element.replied + " 結果： " +element.result +"\n";
            else
                history.innerText += "輸入： " + element.replied + " 結果： " +element.result +"\n";
            
        });
    }
    
    
})
