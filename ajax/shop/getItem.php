<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $id= $_POST["item_id"];



    $sql = "SELECT id, item_id, item_name, item_price, item_amount, content,item_term,item_type,kind,image FROM item_data WHERE id='$id'";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        
        $itemData["id"] = $arr["id"];
        $itemData["item_id"] = $arr["item_id"];
        $itemData["item_name"] = $arr["item_name"];
        $itemData["item_price"] = $arr["item_price"];
        $itemData["item_amount"] =  $arr["item_amount"];
        $itemData["content"] = $arr["content"];
        $itemData["item_term"] = $arr["item_term"];
        $itemData["item_type"] = $arr["item_type"];
        $itemData["kind"] = $arr["kind"];
        $itemData["image"] = $arr["image"]; 
        $itemData["order_code"] = date("YmdHis",time()).$memberNo;
        $itemList[] = $itemData;
    }



    echo json_encode(array('itemList' => $itemList));
?>