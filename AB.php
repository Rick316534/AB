<?php
//-------------------------------- if you want change user , open this
include_once("config.php");
mysqli_query($link, 'SET NAMES utf8');
//-------------------------------------------- get value..
$input=file_get_contents('php://input');                                                   
$A_num=0;$B_num=0;
$Reply = json_decode($input) -> {'reply'} ;
$num = json_decode($input) -> {'num'} ;
$rangestr =json_decode($input) -> {'rangestr'};
//--------sql
$sql_delete = "delete from `history`";
$sql_select="select * from `history`";

//--------------------------------------------------- set a topic 
if($rangestr==1){
    $rangestr = 0;
    mysqli_query($link,$sql_delete);
    $Range=array();
    $count=3;
    for($i=0;$i<=$count;$i++){
        $number=rand(0,9);
        if($Range[0]=="" && $number==0)
                $i--;
        elseif(in_array($number,$Range))
                $i--;
        else
            $Range[$i]=$number;
    }
    $num = 1;
    $sql ="insert into `history`(topic,rangestr) values(\"".$Range[0].$Range[1].$Range[2].$Range[3]."\",\"".$rangestr."\")";
    $result = mysqli_query($link,$sql);
}
//-------------------------------------------------- check a reply is ok
$result = mysqli_query($link,$sql_select);
$row=mysqli_fetch_assoc($result);
$length = strlen($Reply);
if($length==0)
    echo "未填入數字!";
elseif($length<4)
    echo "不能少於四個數";
elseif($length>4)
    echo "不能多於四個數";
else{
    for($i=-4;$i<0;$i++){
        $topic_num[$i]=substr($row["topic"],$i,1);
        $Reply_num[$i]=substr($Reply,$i,1);
    }
    if($length!=count(array_unique($Reply_num)))
        echo "數字重複";
    elseif($Reply_num[0]=="0")
        echo "開頭不能為0";
    else{
        //--------------------------------------------------- answer
        for($i=-4;$i<0;$i++){
            if($Reply_num[$i]==$topic_num[$i])
                $A_num+=1;
            elseif(in_array($Reply_num[$i],$topic_num))
                $B_num+=1;
        }
        if($A_num==4)
            $rangestr=1;
        $sql_insert ="insert into `history`(num,replied,result,topic,rangestr) values(\"".$num."\",\"".$Reply."\",\"". $A_num."A".$B_num."B"."\",\"".$row["topic"]."\",\"".$rangestr."\")";
        mysqli_query($link,$sql_insert);
        $result = mysqli_query($link,$sql_select);
        if($result){
            while($row = mysqli_fetch_assoc($result)){
                $datas[]=$row;
            }
        }   
        $jsn = $datas;
        echo json_encode($jsn);
        
    }
}
mysqli_close($link);




       


















