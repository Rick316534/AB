<?php
$link=@mysqli_connect(
    'localhost',
    'test',
    '1234',
    'abbase'
);
if(!$link){
    die("error connecting");
}else{
    return $link;
}
mysqli_close($link);
?>