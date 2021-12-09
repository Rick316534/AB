<?php

// 執行並列印結果 
print main(); 


// main
function main() 
{
    $sessionPath = "/var/www/html/session" ; // 設定存取位置
    $sessionId = "AB";                       // 設定sessionID
    $input = file_get_contents('php://input');  // 接值
    
    try {
        // 判斷接值是否成功
        if ($input != null) {
            $reply = json_decode($input) -> {'reply'}; // 取得猜數
            $topicReset = json_decode($input) -> {'topicReset'}; // 題目是否重置
        } else {
            throw new Exception("傳值失敗");
        }
        // 判斷猜數是否合法,如果通過將拆解後的輸入丟出，供遊戲判斷使用
        $replyNum = replyJudge($reply); //猜數拆解後的容器
         // 建立Session
         sessionSet($sessionPath, $sessionId);
         // 判斷session建立
         if (!Session_Id()) {
             throw new Exception("Session設定失敗");
         } 
        // 題目重新設定並清空歷史
        if ($topicReset) {
            session_unset();
            $topic = topic();
        } else {
            $topic = $_SESSION["topic"];
        }
        // 判斷_A_B,並給出結果
        $result = gameResult($replyNum, $topic);
        print_r(json_encode (array('history' => $_SESSION["history"] , 'result' => $result["answerA"] . "A" . $result["answerB"] . "B" )));
        // 判斷是否4A
        history($topic,$reply,$result);
        
        
        

    } catch (Exception $e) {
        return  $e->getMessage();
    }

}

// 判斷猜數是否合法
function replyJudge($reply) 
{
    $replyLength = strlen($reply); // 取的猜數字串長度
    $regularExpression = array('0','1','2','3','4','5','6','7','8','9'); // 允許的猜數輸入值
    $replyNum = preg_split('//', $reply, -1,PREG_SPLIT_NO_EMPTY); // 猜數拆解
    try {
        // (1)判斷猜數長度
        if ( $replyLength != 4) {
            throw new Exception("請輸入四個數字");
        }
        // (2)將猜數的字串拆解做正規判斷
        foreach ($replyNum as $value) {
            if (! in_array($value,$regularExpression)) {
                throw new Exception("僅能輸入數字");
            }
        }
        // (3)判斷猜數開頭不能為零
        if ($replyNum["0"] == "0") {
            throw new Exception("開頭不能為零");
        }
        // (4)判斷猜數內有無重複數字
        if ($replyLength != count(array_unique($replyNum))) {
            throw new Exception("不能重複數字");
        } 
        // 判斷成功
        return $replyNum ;

    } catch (Exception $e) {
        throw new Exception($e->getMessage());

    }
     
}

// 設定題目
function topic()
{   
    $topic = array();
    $count = 3;
    for($i = 0 ; $i <= $count ; $i++){
        $number = rand(0,9);
        if ($topic[0] == "" && $number == 0){
            $i--;
        } elseif (in_array($number,$topic)){   
            $i--;
        } else {
            $topic[$i]=$number;
        }
    }
    return $topic;
} 

// 判斷遊戲結果
function gameResult($replyNum, $topic) 
{
    $answerA = 0;
    $answerB = 0;
    for ($i = 0 ; $i < 4 ; $i++) {
        if ($replyNum[$i] == $topic[$i]) {
            $answerA += 1;
        } elseif (in_array($replyNum[$i] , $topic)) {
            $answerB += 1;
        }
    }
    return array("answerA" => $answerA , "answerB" => $answerB);
}

// 啟動Session
function sessionSet($path, $id) 
{
    Session_Save_Path($path);  // 設定存取位置
    Session_Id($id); // 設定sessionID
    Session_Start(); 
};


// 紀錄
function history($topic,$reply,$result) 
{
    if (!$_SESSION["topic"]) {
        $_SESSION["history"] =  "輸入" . $reply . "結果是" . $result["answerA"] . "A" . $result["answerB"] . "B" . "\n";
        $_SESSION["topic"] = $topic;
        
    } else {
        $_SESSION["history"] .= "輸入" . $reply . "結果是" . $result["answerA"] . "A" . $result["answerB"] . "B" . "\n"; 
    }
    
}

