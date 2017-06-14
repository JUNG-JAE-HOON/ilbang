<?php
    if($_GET['HguinPage']!='') {
        $page = $_GET['HguinPage'];
    } else {
        $page = 1;
    }
  
    $guinArea1st = $_GET['HguinArea1st'];
    $guinArea2nd = $_GET['HguinArea2nd'];
    $guinArea3rd = $_GET['HguinArea3rd']; 
    $guinWork1st = $_GET['HguinWork1st']; 
    $guinWork2nd = $_GET['HguinWork2nd']; 
    $guinAge = $_GET['HguinAge']; 
    $guinPay = $_GET['HguinPay']; 
    //$guinPayIsUnrelated     = $_GET['HguinPayIsUnrelated']; 
    $guinTime = $_GET['HguinTime']; 
    $guinGender = $_GET['HguinGender']; 
    $guinCareer = $_GET['HguinCareer']; 
    //$guinCareerIsUnrelated  = $_GET['HguinCareerIsUnrelated']; 

    if($_GET['HguinOnePage']!='') {
        $onePage = $_GET['HguinOnePage']; // 한 페이지에 보여줄 게시글의 수.
    } else {
        $onePage = 10;
    }

    /*
        $guinArea1st            = "1";
        $guinArea2nd            = "";
        $guinArea3rd            = ""; 
        $guinWork1st            = ""; 
        $guinWork2nd            = ""; 
        $guinAge                = "unrelated"; 
        $guinPay                = ""; 
        $guinPayIsUnrelated     = ""; 
        $guinTime               = "unrelated"; 
        $guinGender             = "nothing"; 
        $guinCareer             = ""; 
        $guinCareerIsUnrelated  = ""; 
    */

    //-- ,  ROUND(6371 * acos( cos( radians(35.5058023792) ) * cos( radians(lat) ) * cos( radians(lng) - radians(129.4417746378) ) + sin( radians(35.5058023792) ) * sin( radians(lat) ) ),2) as distance
    $sql  = " SELECT  count(*) cnt ";
    $sql .= " FROM work_employ_data A ";
    $sql .= " WHERE 1=1 ";
    $sql .= " AND A.view = 'yes' ";

    if ($guinArea1st!='' && $guinArea2nd=='' && $guinArea3rd=='')     $sql .= " AND A.area_1st = '$guinArea1st' ";
    else if ($guinArea1st!='' && $guinArea2nd!='' && $guinArea3rd=='')     $sql .= " AND A.area_1st = '$guinArea1st' AND A.area_2nd = '$guinArea2nd' ";
    else if ($guinArea1st!='' && $guinArea2nd!='' && $guinArea3rd!='')     $sql .= " AND A.area_1st = '$guinArea1st' AND A.area_2nd = '$guinArea2nd' AND A.area_3rd = '$guinArea3rd' ";
     
    if ($guinWork1st != '' && $guinWork2nd == '')                     $sql .= " AND A.work_1st = '$guinWork1st' ";
    else if ($guinWork1st != '' && $guinWork2nd != '')                     $sql .= " AND A.work_2nd = '$guinWork2nd' ";

    if ($guinAge               != ''           )                      $sql .= " AND '$guinAge' BETWEEN A.age_1st AND A.age_2nd";
    if ($guinPay               != ''           )                      $sql .= " AND A.pay = '$guinPay' ";
    if ($guinTime              != ''           )                      $sql .= " AND A.time = '$guinTime' ";
    if ($guinGender            != ''           )                      $sql .= " AND A.sex = '$guinGender' ";
    if ($guinCareer            != ''           )                      $sql .= " AND A.career = '$guinCareer' ";

    $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)) {
        $allPost = $row["cnt"];    // 전체 게시글 수
    }

    //$allPost = $row['cnt']; //전체 게시글의 수
    //$onePage = 5; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수
    $oneSection = 5; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
    $currentSection = ceil($page / $oneSection); //현재 섹션
    $allSection = ceil($allPage / $oneSection); //전체 섹션의 수
    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

    if ($allPost == 0){
        $lastPage = 1;
        $currentSection = 1;
        $allSection = 1;
    } else if($currentSection == $allSection) {
        $lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
    } else {
        $lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
    }

    $prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
    $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.
    $currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
    $sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage;
    
    $sql   = " SELECT  A.no       ";
    $sql  .= "      ,  A.company  ";
    $sql  .= "      ,  A.keyword  ";
    $sql  .= "      ,  A.title    ";
    $sql  .= "      ,  A.business ";
    $sql  .= "      ,   A.career  ";
    $sql  .= "      ,   A.pay     ";
    $sql  .= "      ,   A.sex     ";
    $sql  .= "      ,   A.age_1st ";
    $sql  .= "      ,   A.age_2nd ";
    $sql  .= "      ,   A.time    ";
    $sql  .= "      ,   A.wdate   ";
    $sql  .= " FROM work_employ_data A ";
    $sql  .= " WHERE 1=1 ";
    $sql  .= " AND A.view = 'yes' ";

    if ($guinArea1st!='' && $guinArea2nd=='' && $guinArea3rd=='')     $sql .= " AND A.area_1st = '$guinArea1st' ";
    else if ($guinArea1st!='' && $guinArea2nd!='' && $guinArea3rd=='')     $sql .= " AND A.area_1st = '$guinArea1st' AND A.area_2nd = '$guinArea2nd' ";
    else if ($guinArea1st!='' && $guinArea2nd!='' && $guinArea3rd!='')     $sql .= " AND A.area_1st = '$guinArea1st' AND A.area_2nd = '$guinArea2nd' AND A.area_3rd = '$guinArea3rd' ";
     
    if ($guinWork1st != '' && $guinWork2nd == '')                     $sql .= " AND A.work_1st = '$guinWork1st' ";
    else if ($guinWork1st != '' && $guinWork2nd != '')                     $sql .= " AND A.work_2nd = '$guinWork2nd' ";

    if ($guinAge               != ''           )                      $sql .= " AND '$guinAge' BETWEEN A.age_1st AND A.age_2nd";
    if ($guinPay               != ''           )                      $sql .= " AND A.pay = '$guinPay' ";
    if ($guinTime              != ''           )                      $sql .= " AND A.time = '$guinTime' ";
    if ($guinGender            != ''           )                      $sql .= " AND A.sex = '$guinGender' ";
    if ($guinCareer            != ''           )                      $sql .= " AND A.career = '$guinCareer' ";

    $sql .= " ORDER BY A.wdate desc $sqlLimit";
    $result = mysql_query($sql, $ilbang_con);
?>
<script>
    $(document).ready(function() {
        $("#guinArea2ndListArea").hide();
        $("#guinArea3rdListArea").hide();  

        loadSearchFormData();
        // getEmergencyGuinList();
    });

    function loadSearchFormData(){
        var onePage = '<?php echo $_GET["HguinOnePage"];?>';
        var guinArea1st = '<?php echo $_GET["HguinArea1st"];?>';
        var guinArea2nd = '<?php echo $_GET["HguinArea2nd"];?>';
        var guinArea3rd = '<?php echo $_GET["HguinArea3rd"];?>';
        var guinWork1st = '<?php echo $_GET["HguinWork1st"];?>';
        var guinWork2nd = '<?php echo $_GET["HguinWork2nd"];?>';
        var guinAge = '<?php echo $_GET["HguinAge"];?>';
        var guinPay = '<?php echo $_GET["HguinPay"];?>';
        var guinTime = '<?php echo $_GET["HguinTime"];?>';
        var guinGender = '<?php echo $_GET["HguinGender"];?>';
        var guinCareer = '<?php echo $_GET["HguinCareer"];?>';

        $("#HguinArea1st").val(guinArea1st);
        $("#HguinArea2nd").val(guinArea2nd);     
        $("#HguinArea3rd").val(guinArea3rd);        
        $("#HguinWork1st").val(guinWork1st);        
        $("#HguinWork2nd").val(guinWork2nd);   
        $("#HguinAge").val(guinAge);       
        $("#HguinPay").val(guinPay);            
        $("#HguinTime").val(guinTime);  
        $("#HguinGender").val(guinGender);
        $("#HguinCareer").val(guinCareer);

        if(onePage=='') {
            $("#onePage").val("10");
        } else {
            $("#onePage").val(onePage);
        }

        if(guinArea1st != '')      loadGuinArea2ndList(guinArea1st);
        if(guinArea2nd != '')      loadGuinArea3rdList(guinArea2nd);

        $("#si"+guinArea1st).addClass("active-btn");
      
        if(guinArea1st != ''){
            $("#guinArea2ndListArea").show();
        }

        if(guinArea2nd != ''){
            $("#guinArea3rdListArea").show();
        }
      
        // 업직종
        loadGuinWork1stList();

        // 연령대
        if(guinAge != ''){
            $('input:radio[name=guinAge]').filter('[value='+guinAge+']').prop('checked', true);
        }

        // 급여조건
        $("#guinPay").val('<?php echo $_GET["HguinPay"];?>');

        // 근무시간
        if(guinTime != '' ){
            $('input:radio[name=guinTime]').filter('[value='+guinTime+']').prop('checked', true);
        }
        
        // 성별
        if(guinGender != '' ){
            $('input:radio[name=guinGender]').filter('[value='+guinGender+']').prop('checked', true);
        }

        // 경력
        $("#guinCareer").val('<?php echo $_GET["HguinCareer"];?>');
    }

    // =================================================================================================================================================================
    //  ▽ ... LOAD DATA ... ▽
    // =================================================================================================================================================================
    function loadGuinArea2ndList(area_1st) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea2ndList.php',
            data: {area_1st:area_1st},
            success: function (data) {
                var cell = document.getElementById("guinArea2ndListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinArea2ndListArea").innerHTML
                    += '<a href="javascript:setGuinArea2nd('+data.listData[i].area_2nd+')" id="gu'+data.listData[i].area_2nd+'" class="local1Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_2nd_nm+'</a>';
                }

                $("#gu"+'<?php echo $_GET["HguinArea2nd"];?>').addClass("active-btn2");
            }
        });
    }

    function loadGuinArea3rdList(area_2nd) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea3rdList.php',
            data: {area_2nd:area_2nd},
            success: function (data) {
                var cell = document.getElementById("guinArea3rdListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinArea3rdListArea").innerHTML
                    += '<a href="javascript:setGuinArea3rd('+data.listData[i].area_3rd+')" id="dong'+data.listData[i].area_3rd+'" class="local2Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_3rd_nm+'</a>';
                }

                $("#dong"+'<?php echo $_GET["HguinArea3rd"];?>').addClass("active-btn2");
            }
        });
    }

    function loadGuinWork1stList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork1stList.php',
            success: function (data) {
                var cell = document.getElementById("guinWork1st");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("guinWork1st").innerHTML = '<option value="">1차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinWork1st").innerHTML += '<option value="' + data.listData[i].work_1st + '">' + data.listData[i].work_1st_nm + '</option>';
                }

                $("#guinWork1st").val('<?php echo $_GET["HguinWork1st"];?>');

                loadGuinWork2ndList();
            }
        });
    }

    function loadGuinWork2ndList() {
        var work_1st = $("#guinWork1st option:selected").val();

        if (work_1st == '') return;

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork2ndList.php',
            data: {work_1st:work_1st},
            success: function (data) {
                var cell = document.getElementById("guinWork2nd");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("guinWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinWork2nd").innerHTML += '<option value="' + data.listData[i].work_2nd + '">' + data.listData[i].work_2nd_nm + '</option>';
                }

                $("#guinWork2nd").val('<?php echo $_GET["HguinWork2nd"];?>');
            }
        });
    }
    // =================================================================================================================================================================
    //  △ ... LOAD DATA ... △
    // =================================================================================================================================================================  

    function setGuinArea1st(area_1st) {
        $("input#HguinArea1st").val(area_1st);
        $("input#HguinArea2nd").val("");
        $("input#HguinArea3rd").val("");
        $("#guingujikTab1 > ul > li > a"  ).removeClass("active-btn"); 
        $("#si"+area_1st).addClass("active-btn");
        $("#guinArea2ndListArea").show();
    
        getGuinArea2ndList(area_1st);

        var cell = document.getElementById("guinArea3rdListArea");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }    
        
        $("#guinArea3rdListArea").hide();
    }

    function getGuinArea2ndList(area_1st) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea2ndList.php',
            data: {area_1st:area_1st},
            success: function (data) {
                var cell = document.getElementById("guinArea2ndListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinArea2ndListArea").innerHTML
                    += '<a href="javascript:setGuinArea2nd('+data.listData[i].area_2nd+')" id="gu'+data.listData[i].area_2nd+'" class="local1Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_2nd_nm+'</a>';
                }
            }
        });
    }

    function setGuinArea2nd(area_2nd) {
        $("input#HguinArea2nd").val(area_2nd);
        $("input#HguinArea3rd").val("");
        $("#guinArea2ndListArea > a").removeClass("active-btn2")   ;
        $("#gu"+area_2nd).addClass("active-btn2");   

        getGuinArea3rdList(area_2nd);

        $("#guinArea3rdListArea").show();
    }

    function getGuinArea3rdList(area_2nd) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea3rdList.php',
            data: {area_2nd:area_2nd},
            success: function (data) {
                var cell = document.getElementById("guinArea3rdListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinArea3rdListArea").innerHTML
                    += '<a href="javascript:setGuinArea3rd('+data.listData[i].area_3rd+')" id="dong'+data.listData[i].area_3rd+'" class="local2Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_3rd_nm+'</a>';
                }
            }
        });
    }

    function setGuinArea3rd (area_3rd) {
        $("#HguinArea3rd"  ).val(area_3rd);   
        $("#guinArea3rdListArea > a").removeClass("active-btn2");
        $("#dong"+area_3rd).addClass("active-btn2");
    }

    function getGuinWork1stList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork1stList.php',
            success: function (data) {
                var cell = document.getElementById("guinWork1st");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("guinWork1st").innerHTML = '<option value="">1차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinWork1st").innerHTML += '<option value="' + data.listData[i].work_1st + '">' + data.listData[i].work_1st_nm + '</option>';
                }
            }
        });
    }

    function getGuinWork2ndList() {
        var work_1st = $("#guinWork1st option:selected").val();
        
        $("#HguinWork1st" ).val(work_1st);

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork2ndList.php',
            data: {work_1st:work_1st},
            success: function (data) {
                var cell = document.getElementById("guinWork2nd");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("guinWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinWork2nd").innerHTML += '<option value="' + data.listData[i].work_2nd + '">' + data.listData[i].work_2nd_nm + '</option>';
                }
            }
        });
    }

    function setGuinWork2nd() {
        var work_2nd = $("#guinWork2nd option:selected").val();
    
        $("#HguinWork2nd").val(work_2nd);
    }

    function setGuinAge(age) {
        $("#HguinAge").val(age);
    }

    function setGuinPay(){
        var guinPay = $("#guinPay option:selected").val();
        
        $("#HguinPay").val(guinPay);
    }

    function setGuinPayIsUnrelated() {
        if($("input:checkbox[id='guinPayIsUnrelated']").is(":checked")){
            $("#HguinPayIsUnrelated").val('Y');
        } else {
            $("#HguinPayIsUnrelated").val('N');
        }
    }

    function setGuinTime(time) {
        $("#HguinTime").val(time);
    }

    function setGuinGender(sex) {
        $("#HguinGender").val(sex);
    }

    function setGuinCareer() {
        var guinCareer = $("#guinCareer option:selected").val();
        
        $("#HguinCareer").val(guinCareer);
    }

    function guinSearch(page) {
        $("#HguinPage").val(page);
        $("#guinSearchForm").attr("action", "./gujik.php");
        
        document.getElementById("guinSearchForm").submit();
    }

    function setGuinCareerIsUnrelated(){
        if($("input:checkbox[id='guinCareerIsUnrelated']").is(":checked")) {
            $("#HguinCareerIsUnrelated").val('Y');
        } else {
            $("#HguinCareerIsUnrelated").val('N');
        }
    }

    function setOnePage() {
        $("#HguinPage").val(1);
        $("#HguinOnePage").val($("#onePage option:selected").val());
        $("#guinSearchForm").attr("action", "./guin.php");

        document.getElementById("guinSearchForm").submit();
    }

    function guinClear() {
        $("#HguinPage").val(1);
        $("#HguinOnePage").val(10);
        $("#HguinArea1st").val("");
        $("#HguinArea2nd").val("");     
        $("#HguinArea3rd").val("");        
        $("#HguinWork1st").val("");        
        $("#HguinWork2nd").val("");        
        $("#HguinPay").val("");            
        $("#HguinPayIsUnrelated").val(""); 
        $("#HguinTime").val("");  
        $("#HguinGender").val("");
        $("#HguinCareer").val("");
        $("#HguinCareerIsUnrelated").val("");
        $("#HguinAge").val("");  
        $("#guingujikTab1 > ul > li > a").removeClass("active-btn"); 
        $("#guinArea2ndListArea > a").removeClass("active-btn2");
        $("#guinArea3rdListArea > a").removeClass("active-btn2");
        $("#guinArea1st").val("");
        $("#guinArea2nd").val("");
        $("#guinArea3rd").val("");
        $("#guinWork1st").val("");
        //$("#guinWork2nd").val("");

        var cell = document.getElementById("guinWork2nd");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        document.getElementById("guinWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';
        
        $('input:radio[name=guinAge]').prop('checked', false);
        $("#guinPay").val("");
        $("#guinPayIsUnrelated").attr('checked', false);
        $('input:radio[name=guinTime]').prop('checked', false);
        $('input:radio[name=guinGender]').prop('checked', false);
        $("#guinCareer").val("");
        $("#guinCareerIsUnrelated").attr('checked', false);

        var cell = document.getElementById("guinArea2ndListArea");

        while (cell.hasChildNodes()) {
            cell.removeChild(cell.firstChild);
        }

        var cell = document.getElementById("guinArea3rdListArea");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        $("#guinArea2ndListArea").hide();
        $("#guinArea3rdListArea").hide();
    }

    function getEmergencyGuinList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getEmergencyGuinList.php',
            success: function (data) {
                var cell = document.getElementById("emergencyGuinListArea1");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<4; i++ ){
                    if(data.listData.length <= i ) continue;
                    
                    if(data.listData[i].img_url == null || data.listData[i].img_url == '' ) {
                        data.listData[i].img_url = './images/144x38.png';
                    } else {
                        data.listData[i].img_url = './guinImage/'+data.listData[i].img_url;
                    }
                    
                    document.getElementById("emergencyGuinListArea1").innerHTML
                    += '<div class="di urgentList pr" align="center">' 
                    +  '<a class="di pa plusIcon glyphicon glyphicon-plus f25 bold fc" href="./guin/view/tab1.php?employNo='+data.listData[i].no+'" align="center"></a>'
                    +  '<p class="mt30"><img src="'+data.listData[i].img_url+'" alt="" class="wh144"></p>'
                    +  '<div align="left" class="col-md-offset-1 col-lg-offset-1">'
                    +  '<h5 class="f_grey">'+data.listData[i].company+'</h5>'
                    +  '<p>' + data.listData[i].work_1st_nm + '<span> > </span>' + data.listData[i].work_2nd_nm + '</p>'
                    +  '<p><b>지역</b> : ' + data.listData[i].area_1st_nm + '<span> > </span>' + data.listData[i].area_2nd_nm + ' ' + data.listData[i].area_3rd_nm + '</p>'
                    +  '<p><b><span class="fc">' + data.listData[i].pay+'</span>원</b> <span class="fr dist"></span></p>' // 1.32km
                    +  '</div>' 
                    +  '</div>';
                }

                var cell = document.getElementById("emergencyGuinListArea2");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=4; i<8; i++ ){
                    if(data.listData.length <= i ) continue;

                    if(data.listData[i].img_url == null || data.listData[i].img_url == '' ) {
                        data.listData[i].img_url = './images/144x38.png';
                    } else {
                        data.listData[i].img_url = './guinImage/'+data.listData[i].img_url;
                    }
                            
                    document.getElementById("emergencyGuinListArea2").innerHTML
                    += '<div class="di urgentList pr" align="center">' 
                    +  '<a class="di pa plusIcon glyphicon glyphicon-plus f25 bold fc" href="./guin/view/tab1.php?employNo='+data.listData[i].no+'" align="center"></a>'
                    +  '<p class="mt30"><img src="'+data.listData[i].img_url+'" alt="" class="wh144"></p>'
                    +  '<div align="left" class="col-md-offset-1 col-lg-offset-1">'
                    +  '<h5 class="f_grey">'+data.listData[i].company+'</h5>'
                    +  '<p>' + data.listData[i].work_1st_nm + '<span> > </span>' + data.listData[i].work_2nd_nm + '</p>'
                    +  '<p><b>지역</b> : ' + data.listData[i].area_1st_nm + '<span> > </span>' + data.listData[i].area_2nd_nm + ' ' + data.listData[i].area_3rd_nm + '</p>'
                    +  '<p><b><span class="fc">' + data.listData[i].pay + '</span>원</b> <span class="fr dist"></span></p>'
                    +  '</div>'
                    +  '</div>';
                }
            }
        });
    }

    function viewEmploy(no) {
        $("#guinSearchForm").attr("action", "./gujik/view/tab1.php");
        $("#employNo" ).val(no);
        
        document.getElementById("guinSearchForm").submit();
    }
</script>
<h4 class="mt30 f16 mb10">검색으로 찾기</h4>
<ul class="noPadding w100 oh mt10 mb0 border-top-ilbang">
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si10000" href="javascript:setGuinArea1st('10000')">전국</a> <!-- javascript:setGuinArea1st('10000')-->
    </li>                  
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si1" href="javascript:setGuinArea1st('1')">서울</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si907" href="javascript:setGuinArea1st('907')">인천</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si1164" href="javascript:setGuinArea1st('1164')">광주</a>
    </li>
    <li class="border local guin_local fl text-center" >
        <a class="di w100 padding-vertical" id="si1420" href="javascript:setGuinArea1st('1420')">대전</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si1631" href="javascript:setGuinArea1st('1631')">대구</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si1923" href="javascript:setGuinArea1st('1923')">부산</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si2314" href="javascript:setGuinArea1st('2314')">울산</a>
    </li>
    <li class="border local guin_local fl text-center"> 
        <a class="di w100 padding-vertical" id="si2422" href="javascript:setGuinArea1st('2422')">경기</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si3312" href="javascript:setGuinArea1st('3312')">강원</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si3641" href="javascript:setGuinArea1st('3641')">충남</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si3950" href="javascript:setGuinArea1st('3950')">충북</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si4219" href="javascript:setGuinArea1st('4219')">전남</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si4687" href="javascript:setGuinArea1st('4687')">전북</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si5128" href="javascript:setGuinArea1st('5128')">경남</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si5709" href="javascript:setGuinArea1st('5709')">경북</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si7700" href="javascript:setGuinArea1st('7700')">세종</a>
    </li>
    <li class="border local guin_local fl text-center border-right-ilbang">
        <a class="di w100 padding-vertical" id="si6296" href="javascript:setGuinArea1st('6296')">제주</a>
    </li>
</ul>
<ul class="local1 padding oh border-grey noMargin" id="guinArea2ndListArea"></ul>
<ul class="local2 padding oh border-grey" id="guinArea3rdListArea"></ul>
<!-- 폼 영역 -->        
<form class="form-horizontal bg_grey f_grey padding oh border-grey" id="guinSearchForm" name="guinSearchForm" method="get">
    <input type="hidden" name="employNo"                 id="employNo"              value="">
    <input type="hidden" name="HguinPage"              id="HguinPage"              value="<?php echo $page?>">
    <input type="hidden" name="HguinOnePage"           id="HguinOnePage"           value="<?php echo $onePage?>">
    <input type="hidden" name="HguinArea1st"           id="HguinArea1st"           value="">
    <input type="hidden" name="HguinArea2nd"           id="HguinArea2nd"           value="">
    <input type="hidden" name="HguinArea3rd"           id="HguinArea3rd"           value="">
    <input type="hidden" name="HguinWork1st"           id="HguinWork1st"           value="">
    <input type="hidden" name="HguinWork2nd"           id="HguinWork2nd"           value="">
    <input type="hidden" name="HguinAge"               id="HguinAge"               value="">
    <input type="hidden" name="HguinPay"               id="HguinPay"               value="">
    <input type="hidden" name="HguinTime"              id="HguinTime"              value="">
    <input type="hidden" name="HguinGender"            id="HguinGender"            value="">
    <input type="hidden" name="HguinCareer"            id="HguinCareer"            value="">
    <!-- 1 -->
    <div class="form-group guin-form padding mt30">
        <label for="inputEmail3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">업직종</label>
        <div class="col-sm-10">
            <select name="guinWork1st" onchange="getGuinWork2ndList()" id="guinWork1st" class="form-control fl" style="width:20%">
                <option value="">1차 분류 선택</option>
            </select>
            <span class="fl vm di f16 arrow-right margin-horizontal mt4"><b>></b></span>
            <select name="guinWork2nd" id="guinWork2nd" onchange="setGuinWork2nd()" class="form-control fl" style="width:20%">
                <option value="">2차 분류 선택</option>
            </select>
        </div>
    </div>
    <!-- 2 -->
    <div class="form-group guin-form padding">
        <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">연령대</label>
        <div class="col-sm-10 lh12">
            <div class="radio fl">
                <label>
                    <input type="radio" name="guinAge" value="10" onclick="setGuinAge('10')"><span class="ml5">10대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="guinAge" value="20" onclick="setGuinAge('20')"><span class="ml5">20대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="guinAge" value="30" onclick="setGuinAge('30')"><span class="ml5">30대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="guinAge" value="40" onclick="setGuinAge('40')"><span class="ml5">40대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="guinAge" value="50" onclick="setGuinAge('50')"><span class="ml5">50대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="guinAge" value="60" onclick="setGuinAge('60')"><span class="ml5">60대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="guinAge" value="70" onclick="setGuinAge('70')"><span class="ml5">70대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="guinAge" value="80" onclick="setGuinAge('80')"><span class="ml5">80대</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group guin-form padding">
        <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">급여 조건</label>
        <div class="col-sm-10">
            <select name="guinPay" id="guinPay" onchange="setGuinPay()" class="form-control fl" style="width:20%">
                <option value="">일당</option>
                <option value="0">0</option>
                <option value="50000">50,000</option>
                <option value="100000">100,000</option>
                <option value="150000">150,000</option>
                <option value="200000">200,000</option>
                <option value="250000">250,000</option>
                <option value="300000">300,000</option>
                <option value="350000">350,000</option>
                <option value="350000">350,000</option>
                <option value="400000">400,000</option>
                <option value="450000">450,000</option>
                <option value="500000">500,000</option>
            </select>
        </div>
    </div>
    <div class="form-group guin-form padding">
        <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">근무 시간</label>
        <div class="col-sm-10 lh12">
            <div class="radio fl">
                <label>
                    <input type="radio" name="guinTime" value="1" onclick="setGuinTime('1')"><span class="ml5">오전</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="2" onclick="setGuinTime('2')"><span class="ml5">오후</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="3" onclick="setGuinTime('3')"><span class="ml5">저녁</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="4" onclick="setGuinTime('4')"><span class="ml5">새벽</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="5" onclick="setGuinTime('5')"><span class="ml5">오전 ~ 오후</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="6" onclick="setGuinTime('6')"><span class="ml5">오후 ~ 저녁</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="7" onclick="setGuinTime('7')"><span class="ml5">저녁 ~ 새벽</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="8" onclick="setGuinTime('8')"><span class="ml5">새벽 ~ 오전</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="9" onclick="setGuinTime('9')"><span class="ml5">종일</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinTime" value="10" onclick="setGuinTime('10')"><span class="ml5">무관/협의</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group guin-form padding">
        <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">성별</label>
        <div class="col-sm-10 lh12">
            <div class="radio">
                <label>
                    <input type="radio" name="guinGender" value="nothing" onclick="setGuinGender('nothing')" ><span class="ml5">무관</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinGender" value="man" onclick="setGuinGender('man')"><span class="ml5">남자</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="guinGender" value="woman" onclick="setGuinGender('woman')"><span class="ml5">여자</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group guin-form padding">
        <label for="inputEmail3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">경력</label>
        <div class="col-sm-10">
            <select name="guinCareer" id="guinCareer" onchange="setGuinCareer()" class="form-control fl" style="width:20%">
                <option value="">필요 경력</option>
                <option value="0">신입</option>
                <option value="1">1년 미만</option>
                <option value="3">3년 미만</option>
                <option value="5">5년 미만</option>
                <option value="6">5년 이상</option>
            </select>
        </div>
    </div>
    <div class="formBtnWrap">
        <ul class="pager">
            <li><a class="f14 bg_navy border-navy fff" href="javascript:guinSearch(1)">검색</a></li>
            <li><a class="white-btn f14 border-navy" style="color: #545975;" href="javascript:guinClear()">초기화</a></li>
        </ul>
    </div>  
</form>
<!-- 섹션2 -->
<!-- <div class="container mt30 pr30">
    <h4 class="fl f16 mb10">긴급 채용 정보</h4>
    <p class="fr f12 mt10">* 신청시 바로 매칭 서비스를 받으실 수 있습니다.
        <a href="javascript:alert('준비중 입니다.')" class="sm-btn sm-btn2 f12 ml10">상품 구매</a>
    </p>
    <div class="oh w100" id="emergencyGuinListArea1"></div>
    <div class="mt10" id="emergencyGuinListArea2"></div>
</div> -->
<div class="container mt30 pr30">
    <div>
        <h4 class="fl f16 mb10">채용 정보</h4>
        <div class="form-group oh noMargin">
        <div class="fr">
            <select name="onePage" id="onePage" onchange="setOnePage()" class="smallSelect">
                <option value="10">10개씩</option>
                <option value="20">20개씩</option>
                <option value="30">30개씩</option>
                <option value="40">40개씩</option>
                <option value="50">50개씩</option>
            </select>
        </div>
    </div>
</div>
<div class="bt2 oh w100 guinInfo">
    <ul class="bg_darkgrey guinInfoTlt oh noPadding bb">
        <li class="gujikInfoLi1 tc fl">회사 위치</li>
        <li class="gujikInfoLi2 tc fl">채용 내용</li>
        <li class="gujikInfoLi3 fl tc">근무 조건</li>
        <li class="gujikInfoLi4 fl tc">등록일</li>
    </ul>
    <div id="employListArea">
        <?php
            while($row = @mysql_fetch_array($result)) {
                $keyword  = explode(",", $row["keyword"]);

                $oneData["area_1st_nm"] = $keyword[0];
                $oneData["area_2nd_nm"] = $keyword[1];
                $oneData["area_3rd_nm"] = $keyword[2];
                $oneData["work_1st_nm"] = $keyword[3];
                $oneData["work_2nd_nm"] = $keyword[4];
                $oneData["no"]        = $row["no"];
                $oneData["company"]   = $row["company"];
                $oneData["title"]     = $row["title"];
                $oneData["business"]  = $row["business"];
                $oneData["career"]    = $row["career"];
                $oneData["sex"]       = $row["sex"];
                $oneData["age_1st"]   = $row["age_1st"];
                $oneData["age_2nd"]   = $row["age_2nd"];
                $oneData["pay"]       = number_format($row["pay"]);
                $oneData["time"]      = $row["time"];
                $oneData["wdate"]       = $row["wdate"];

                if($oneData["time"] == "1")  $oneData["time"] = "오전";
                else if($oneData["time"] == "2")  $oneData["time"] = "오후";
                else if($oneData["time"] == "3")  $oneData["time"] = "저녁";
                else if($oneData["time"] == "4")  $oneData["time"] = "새벽";
                else if($oneData["time"] == "5")  $oneData["time"] = "오전 ~ 오후";
                else if($oneData["time"] == "6")  $oneData["time"] = "오후 ~ 저녁";
                else if($oneData["time"] == "7")  $oneData["time"] = "저녁 ~ 새벽";
                else if($oneData["time"] == "8")  $oneData["time"] = "새벽 ~ 오전";
                else if($oneData["time"] == "9")  $oneData["time"] = "풀타임";
                else if($oneData["time"] == "10")  $oneData["time"] = "무관/협의";

                if($oneData["sex"] == "man")     $oneData["sex"] = "남자";
                else if($oneData["sex"] == "woman")   $oneData["sex"] = "여자";
                else if($oneData["sex"] == "nothing") $oneData["sex"] = "무관";  

                if($oneData["career"] == "-1")  $oneData["career"] = "무관";
                else if($oneData["career"] == "0")   $oneData["career"] = "신입";
                else if($oneData["career"] == "1")   $oneData["career"] = "1년 미만";  
                else if($oneData["career"] == "3")   $oneData["career"] = "3년 미만";  
                else if($oneData["career"] == "5")   $oneData["career"] = "5년 미만";  
                else if($oneData["career"] == "6")   $oneData["career"] = "5년 이상";  

                if(empty($oneData["area_1st_nm"])) $oneData["area_1st_nm"] = "회사 위치 정보가 없습니다.";
                if(empty($oneData["area_2nd_nm"])) $oneData["area_2nd_nm"] = "";
                if(empty($oneData["area_3rd_nm"])) $oneData["area_3rd_nm"] = "";
                if(empty($oneData["work_1st_nm"])) $oneData["work_1st_nm"] = "";
                if(empty($oneData["work_2nd_nm"])) $oneData["work_2nd_nm"] = "일방";
                if(empty($oneData["company"]))     $oneData["company"]     = "";
                if(empty($oneData["title"]))       $oneData["title"]       = "제목";
                if(empty($oneData["business"]))    $oneData["business"]    = "";
                if(empty($oneData["sex"]))         $oneData["sex"]         = "";
                if(empty($oneData["age_1st"]))     $oneData["age_1st"]     = "";
                if(empty($oneData["age_2nd"]))     $oneData["age_2nd"]     = "";
                if(empty($oneData["time"]))        $oneData["time"]        = "";
                if(empty($oneData["wdate"]))       $oneData["wdate"]       = "";
        ?>
        <ul class="oh noPadding gujikInfoList bb pdt6" >
            <li class="guinInfoLi1 lh87 fl tc">
                <div class="bold"><?php echo $oneData["area_1st_nm"] ?> <?php echo $oneData["area_2nd_nm"] ?> <?php echo $oneData["area_3rd_nm"] ?></div>
            </li>
            <li class="gujikInfoLi2 fl">
                <h5 class="cp" onclick=location.href="javascript:viewEmploy('<?php echo $oneData["no"] ?>')"><?php echo $oneData["title"] ?> <?php echo $oneData["company"] ?></h5>
                <div class="margin-vertical info2Cont">
                    <span class="ilbangBadge"><b><?php echo $oneData["work_2nd_nm"] ?></b></span>
                    <span class="di text-cut guinDesc margin-verti ml5"><?php echo $oneData["business"] ?></span>
                </div>
                <div>
                    <span class="mr5"><?php echo $oneData["career"] ?></span> 
                    <!-- <span class="margin-horizontal">12.6km</span>  -->
                    <span class="border-grey payBedge">일당</span>  
                    <span><?php echo $oneData["pay"] ?>원</span>  
                </div>
            </li>
            <li class="gujikInfoLi3 lh25 fl tc">
                <p><?php echo $oneData["sex"] ?></p>
                <p><?php echo $oneData["age_1st"] ?>대 ~ <?php echo $oneData["age_2nd"] ?>대</p>
                <p><?php echo $oneData["time"] ?></p>
            </li>
            <li class="gujikInfoLi4 fl tc">
                <p class="lh25 mb10"><?php echo $oneData["wdate"] ?></p> 
                <p class="mb10">
                    <a href="javascript:viewEmploy('<?php echo $oneData["no"] ?>')" class="direct sm-btn sm-btn1 f12" style="border: 1px solid #eb5f43;">열람하기</a>
                </p>
                <p>
                    <a href="./guin/review.php?employNo=<?php echo $oneData["no"] ?>" class="viewEsti sm-btn sm-btn2 f12">평가보기</a>
                </p>
            </li>
        </ul>
        <?php } ?>
    </div>
</div>
<?php
    $paging .=  '<ul class="pagination">';

    //첫 페이지가 아니라면 처음 버튼을 생성
    if($page != 1) {
        $paging .= '<li><a href="javascript:guinSearch(1)"> << 첫페이지 </a></li>';
    }

    //첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1) {
        $paging .= '<li><a href="javascript:guinSearch('.$prevPage.')">이전</a></li>';
    }

    for($i = $firstPage; $i <= $lastPage; $i++) {
        if($i == $page) {
            $paging .= '<li class="bg-light-gray"><a href="javascript:guinSearch('. $i .')" class="bg-light-gray">'.$i.'</a></li>'; 
        } else {
            $paging .= '<li><a href="javascript:guinSearch('. $i .')">'.$i.'</a></li>'; 
        }
    }

    //마지막 섹션이 아니라면 다음 버튼을 생성
    if($currentSection != $allSection) {
        $paging .= '<li><a href="javascript:guinSearch('.$nextPage.')">다음</a></li>';
    }

    //마지막 페이지가 아니라면 끝 버튼을 생성
    if($page != $allPage && $allPage != 0) {
        $paging .= '<li><a href="javascript:guinSearch('.$allPage.')">끝페이지 >> </a></li>';
    }

    $paging .=  '</ul>';
?>
<div class="container center tc pb5">
    <?php echo $paging ?>
</div>
</div>