<?php
    include_once "../../include/session.php";
    include_once "../../db/connect.php";

    $sql = " SELECT id
        ,  item_id
        ,  item_name
        ,  item_price
        ,  item_amount
        ,  content
        ,  item_term
        ,  item_type
        ,  kind
        ,  discount_rate
        ,  item_kind    
    FROM item_data
    WHERE 1=1
    AND charge_type='P' ";

    if ($kind!="") {
        if($kind == "general") {
            $sql .= " AND (kind = '$kind' OR kind = 'common')";
        } else {
            $sql .= " AND (kind = 'company' OR kind = 'common')";
        }
    }

    $sql .= " ORDER BY id asc ";

    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $itemData["id"] = $arr["id"];
        $itemData["item_id"] = $arr["item_id"];
        $itemData["item_name"] = $arr["item_name"];
        $itemData["item_price"] = number_format($arr["item_price"]);
        $itemData["item_amount"] =  $arr["item_amount"];
        $itemData["content"] = $arr["content"];
        $itemData["item_kind"] = $arr["item_kind"];
        $itemData["item_term"] = $arr["item_term"];
        $itemData["item_type"] = $arr["item_type"];
        $itemData["kind"] = $arr["kind"];
        $itemData["discount_rate"] = $arr["discount_rate"];

        $itemData["discount_amt"] = number_format(floor($arr["item_price"] - ($arr["item_price"] * $arr["discount_rate"])));

        $itemList[] = $itemData;
    }


    $sql = "SELECT no as employ_no
                ,  title
            FROM work_employ_data
            WHERE 1=1
            AND view = 'yes'
            AND uid = '$uid' ";

    $result = mysql_query($sql);

    $employList = array();
    while($row = mysql_fetch_array($result)) {
        $itemData["employ_no"]  = $row["employ_no"];
        $itemData["title"]      = $row["title"];

        $employList[] = $itemData;
    }



    echo json_encode(array('itemList' => $itemList, 'employList' => $employList));
?>