
<!-- 구매 현황 관리 -->
<script>

  $(document).ready(function() {
    getPurchaseMngList(1);
  });

  function getPurchaseMngList(page) {
      //console.log('getPurchaseMngList');
      var uid = '<?php echo $uid?>';
      //uid = 'GIGA'; // 테스트 나중에 지워야함.
      if (uid=='') {
        console.log("로그인을 하지 않앗습니다. 조회된 데이터가 없습니다.");
        return;
      }

      var yyyymm = $("#yyyymm option:selected").val();
      
      $.ajax({
          type: 'post',
          dataType: 'json',
          url: '../ajax/admin/getPurchaseMngList.php',
          data: {page:page,yyyymm:yyyymm},
          success: function (data) {
                var cell = document.getElementById("purchaseMngListArea");
                //console.log("리턴");
                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ) {
                    
                    document.getElementById("purchaseMngListArea").innerHTML
                      += '<div class="bb f12 oh userList" style="padding: 10px;">'
                      +    '<span class="di tc fl">' +data.listData[i].rowNum + '</span>'
                      +    '<span class="di tc fl">' +data.listData[i].kind + '</span>'
                      +    '<span class="di tc fl">' +data.listData[i].uid + '</span>'
                      +    '<span class="di tc fl">' +data.listData[i].itemPurchaseAmt  + '원 (결제 10%제외)</span>'
                      +    '<span class="di tc fl tab2"">' +data.listData[i].marketPurchaseAmt  + '(30% 구글 수수료)</span>'
                      +    '<span class="di tc fl tab2""><a href="">' +data.listData[i].matchingAmt  + '원</a></span>'
                      +    '<span class="di tc fl tab2""><a href="">' +data.listData[i].mathicngCommission  + '원</a></span>'
                      +    '<span class="di tc fl tab2"">' +data.listData[i].payAmtA  + '+' +data.listData[i].payAmtB  + '=' +data.listData[i].totalAmt  + '원</span>'
                      +  '</div>';

                }
                document.getElementById("totalSumAmt").innerHTML =  data.totalSumAmt;
                document.getElementById("purchaseMngListPagingArea").innerHTML = data.paging;


          }
      });
  }
  
/*
  $(document).ready(function() {
    
    var date  = new Date(); 
    var year  = date.getFullYear(); 
    var month = new String(date.getMonth()+1);
    var day   = new String(date.getDate()); 

    if(month.length == 1){ 
      month = "0" + month; 
    }

    if(day.length == 1){ 
      day = "0" + day; 
    } 
    //alert(year+month+day)
    //fn_calcDayMonthCount('20161101','20170101','M');
    //alert(fn_calcDayMonthCount('20161231','20171232','M'));


    //2016-12
  });

  
  // param : pStartDate - 시작일
  // param : pEndDate  - 마지막일
  // param : pType       - 'D':일수, 'M':개월수
  // Update. 2014.11.07. 변수명 변경 : strGapDT->strTermCnt
  // Update. 2014.11.07. 개월수 계산 시 년도가 다른 경우 부정확성 보완 : floor->r
  function fn_calcDayMonthCount(pStartDate, pEndDate, pType) {
    var strSDT = new Date(pStartDate.substring(0,4),pStartDate.substring(4,6)-1,pStartDate.substring(6,8));
    var strEDT = new Date(pEndDate.substring(0,4),pEndDate.substring(4,6)-1,pEndDate.substring(6,8));
    var strTermCnt = 0;
     
    if(pType == 'D') {  //일수 차이
        strTermCnt = (strEDT.getTime()-strSDT.getTime())/(1000*60*60*24);
    } else {            //개월수 차이
        //년도가 같으면 단순히 월을 마이너스 한다.
        // => 20090301-20090201 의 경우(윤달이 있는 경우) 아래 else의 로직으로는 정상적인 1이 리턴되지 않는다.
        if(pEndDate.substring(0,4) == pStartDate.substring(0,4)) {
            strTermCnt = pEndDate.substring(4,6) * 1 - pStartDate.substring(4,6) * 1;
        } else {
            //strTermCnt = Math.floor((strEDT.getTime()-strSDT.getTime())/(1000*60*60*24*365.25/12));
            //strTermCnt = Math.ceil((strEDT.getTime()-strSDT.getTime())/(1000*60*60*24*365/12));

            strTermCnt = Math.floor((strEDT.getTime()-strSDT.getTime())/(1000*60*60*24*365/12));
        }
    }
    
    return strTermCnt;
}
*/
</script>
<div class="row">
  <style>
    .userList span.tab2:nth-child(5){width:18% !important}
    .userList span.tab2:nth-child(6){width:15% !important}
    .userList span.tab2:nth-child(7){width:10%}
    .userList span.tab2:nth-child(8){width:10%}
  </style>
  <div class="adminCont lh40 mt50 bg_white oh loadArea">
  <div class="color4 f16 pb20">
    <span>구매현황관리</span>
    <div class="datePick di fr">
<?php

    $sql  = " SELECT DATE_FORMAT(B.wdate, '%Y-%m') as yyyymm   ";
    $sql .= " FROM  member A                                   ";
    $sql .= "     , work_item B                                ";
    $sql .= " WHERE 1=1                                        ";
    $sql .= " AND A.reuid = '$uid'                             ";
    $sql .= " AND A.no = B.member_no                           ";
    $sql .= " GROUP BY DATE_FORMAT(B.wdate, '%Y-%m')           ";
    $sql .= " ORDER BY yyyymm desc                             ";

    $result = mysql_query($sql, $ilbang_con);

    $yyyymm = "";
    $i      = 0 ;
    while($row = mysql_fetch_array($result)){

      if($i==0) $yyyymm .= '<option selected value="'.$row["yyyymm"].'">'.$row["yyyymm"].'</option>';
      else      $yyyymm .= '<option value="'.$row["yyyymm"].'">'.$row["yyyymm"].'</option>';

      $i++;
    }
    //$uid = 'GIGA'; // test
    if($uid=="" || $yyyymm == "" ){
      $today = date("Y-m");
      $yyyymm = '<option selected value="'.$today.'">'.$today.'</option>';
    }



?>
       <select onchange="getPurchaseMngList()" id="yyyymm" class="lh40 br5 fr" name="" id="" style="width:100px; height: 40px; border-radius:5px">
          <?php echo $yyyymm ?>
       </select>
    </div>
  </div>
  
  <div class="tabContPd">
    <div class="f12 oh w100 userList c999" style="padding: 10px; border-bottom: 2px solid #ddd;">
        <span class="tc di fl font_grey">NO</span>
        <span class="tc di fl font_grey">유형</span>                                                        
        <span class="tc di fl font_grey">아이디</span>
        <span class="tc di fl font_grey">아이템 구매 금액</span>
        <span class="tc di fl font_grey tab2">마켓 구매 금액</span>
        <span class="tc di fl font_grey tab2">매칭수수료 현황</span>
        <span class="tc di fl font_grey tab2">매칭료</span>
        <span class="tc di fl font_grey tab2">지급 금액</span>
    </div>
    <div id="purchaseMngListArea">
    <!--
      <div class="bb f12 oh userList" style="padding: 10px;">'
        <span class="di tc fl">01</span>
        <span class="di tc fl">기업</span>
        <span class="di tc fl">ilbang9192</span>
        <span class="di tc fl">15,000원(결제 10%제외)</span>
        <span class="di tc fl tab2"">10,000(30% 구글 수수료)</span>
        <span class="di tc fl tab2""><a href="">2,000원</a></span>
        <span class="di tc fl tab2""><a href="">10,000원</a></span>
        <span class="di tc fl tab2"">1500+2000=3500원</span>
      </div>
    -->  
    </div>
  </div>

  <div class="clear text-center mt20">
    <ul id="purchaseMngListPagingArea" class="pagination"></ul>
  </div>

  </div>
</div>
<div class="totalSumArea w100">
  <div class="container">
    
    <div id="totalSumAmt" class="fr"></div>
    <p class="fr">합계금액 : </p>
  </div>
</div>