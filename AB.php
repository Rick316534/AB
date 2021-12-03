<?php

$Range=array();
$count=3;
for($i=0;$i<=$count;$i++){
        $number=rand(0,9);
        if($Range[0]==""&& $number==0){
                $i--;
        }
        elseif(in_array($number,$Range)){
                $i--;
        }else{
                $Range[$i]=$number;
        }
}

                                                             

$A_num=0;$B_num=0;
$Reply=file_get_contents('php://input');
   for($i=-4;$i<0;$i++){
        if($Reply!=""){
            $Reply_num=substr($Reply,$i,1);
            if($Reply_num==$Range[$i+4]){
                    $A_num+=1;
            }elseif(in_array($Reply_num,$Range)){
                    $B_num+=1;
            }
        }
        else{
            echo "notthing";
        }
    }
echo $Range[0],$Range[1],$Range[2],$Range[3],"</br>",$Reply;
echo $A_num."A".$B_num."B";
