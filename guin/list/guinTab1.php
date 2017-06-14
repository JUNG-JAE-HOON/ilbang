<?php   
    if(isset($_GET['HgujikPage'])) {
        $page = $_GET['HgujikPage'];
    } else {
        $page = 1;
    }
  
    $gujikArea1st            = $_GET['HgujikArea1st'];
    $gujikArea2nd            = $_GET['HgujikArea2nd'];
    $gujikArea3rd            = $_GET['HgujikArea3rd']; 
    $gujikWork1st            = $_GET['HgujikWork1st']; 
    $gujikWork2nd            = $_GET['HgujikWork2nd']; 
    $gujikAge                = $_GET['HgujikAge']; 
    $gujikPay                = $_GET['HgujikPay']; 
    //$guinPayIsUnrelated     = $_GET['HguinPayIsUnrelated']; 
    $gujikTime               = $_GET['HgujikTime']; 
    $gujikGender             = $_GET['HgujikGender']; 
    $gujikCareer             = $_GET['HgujikCareer']; 
    //$guinCareerIsUnrelated  = $_GET['HguinCareerIsUnrelated']; 

    if(isset($_GET['HgujikOnePage'])) {
        $onePage = $_GET['HgujikOnePage']; // 한 페이지에 보여줄 게시글의 수.
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

    $sql  = "     SELECT  count(*) cnt          "; 
    $sql .= "     FROM work_resume_data A       ";
    $sql .= "         ,member B                 ";
    $sql .= "         ,member_extend C          ";
    $sql .= "     WHERE 1=1                     ";
    $sql .= "     AND A.member_no = B.no        ";
    $sql .= "     AND A.member_no = C.member_no ";
    $sql .= "     AND A.view = 'yes'            ";


         if ($gujikArea1st!='' && $gujikArea2nd=='' && $gujikArea3rd=='')   $sql .= " AND A.area_1st = '$gujikArea1st' ";
    else if ($gujikArea1st!='' && $gujikArea2nd!='' && $gujikArea3rd=='')   $sql .= " AND A.area_1st = '$gujikArea1st' AND A.area_2nd = '$gujikArea2nd' ";
    else if ($gujikArea1st!='' && $gujikArea2nd!='' && $gujikArea3rd!='')   $sql .= " AND A.area_1st = '$gujikArea1st' AND A.area_2nd = '$gujikArea2nd' AND A.area_3rd = '$gujikArea3rd' ";
     
         if ($gujikWork1st != '' && $gujikWork2nd == '')                   $sql .= " AND A.work_1st = '$gujikWork1st' ";
    else if ($gujikWork1st != '' && $gujikWork2nd != '')                   $sql .= " AND A.work_2nd = '$gujikWork2nd' ";

    if ($gujikAge               != ''           )                      $sql .= " AND A.age BETWEEN '$gujikAge' AND '$gujikAge' + 9";
    if ($gujikPay               != ''           )                      $sql .= " AND A.pay = '$gujikPay' ";
    if ($gujikTime              != ''           )                      $sql .= " AND A.time = '$gujikTime' ";
    if ($gujikGender            != ''           )                      $sql .= " AND C.sex = '$gujikGender' ";
    if ($gujikCareer            != ''           )                      $sql .= " AND A.career = '$gujikCareer' ";

    $result = mysql_query($sql, $ilbang_con);
        
    while($row = @mysql_fetch_array($result)){
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

    $sql  = "    SELECT  A.no      ";
    $sql  .= "   , B.name           ";
    $sql  .= "   , C.sex            ";
    $sql  .= "   , C.age            ";
    $sql  .= "   , A.title          ";
    $sql  .= "   , A.keyword        ";
    $sql  .= "   , A.content        ";
    $sql  .= "   , A.career         ";
    $sql  .= "   , A.pay            ";
    $sql  .= "   , A.time           ";
    $sql  .= "  , A.wdate           ";
    $sql  .= " FROM work_resume_data A  ";
    $sql  .= "   ,member B              ";
    $sql  .= "   ,member_extend C       ";
    $sql  .= " WHERE 1=1                ";
    $sql  .= " AND A.member_no = B.no   ";
    $sql  .= " AND A.member_no = C.member_no ";
    $sql  .= " AND A.view = 'yes' ";

         if ($gujikArea1st!='' && $gujikArea2nd=='' && $gujikArea3rd=='')   $sql .= " AND A.area_1st = '$gujikArea1st' ";
    else if ($gujikArea1st!='' && $gujikArea2nd!='' && $gujikArea3rd=='')   $sql .= " AND A.area_1st = '$gujikArea1st' AND A.area_2nd = '$gujikArea2nd' ";
    else if ($gujikArea1st!='' && $gujikArea2nd!='' && $gujikArea3rd!='')   $sql .= " AND A.area_1st = '$gujikArea1st' AND A.area_2nd = '$gujikArea2nd' AND A.area_3rd = '$gujikArea3rd' ";
     
         if ($gujikWork1st != '' && $gujikWork2nd == '')                   $sql .= " AND A.work_1st = '$gujikWork1st' ";
    else if ($gujikWork1st != '' && $gujikWork2nd != '')                   $sql .= " AND A.work_2nd = '$gujikWork2nd' ";

         if ($gujikAge               != ''           )                      $sql .= " AND A.age BETWEEN '$gujikAge' AND '$gujikAge' + 9";
         if ($gujikPay               != ''           )                      $sql .= " AND A.pay = '$gujikPay' ";
         if ($gujikTime              != ''           )                      $sql .= " AND A.time = '$gujikTime' ";
         if ($gujikGender            != ''           )                      $sql .= " AND C.sex = '$gujikGender' ";
         if ($gujikCareer            != ''           )                      $sql .= " AND A.career = '$gujikCareer' ";

    $sql .= " ORDER BY A.wdate desc $sqlLimit";
    $result = mysql_query($sql, $ilbang_con);
?>
<script>
    $(document).ready(function() {
        getNewGujikList();
        getTab1NewGujikList();

        $("#gujikArea2ndListArea").hide();
        $("#gujikArea3rdListArea").hide();

        loadSearchFormData();
    });

    function loadSearchFormData() {
        var onePage               = '<?php echo $_GET["HgujikOnePage"];?>';
        var gujikArea1st           = '<?php echo $_GET["HgujikArea1st"];?>';
        var gujikArea2nd           = '<?php echo $_GET["HgujikArea2nd"];?>';
        var gujikArea3rd           = '<?php echo $_GET["HgujikArea3rd"];?>';
        var gujikWork1st           = '<?php echo $_GET["HgujikWork1st"];?>';
        var gujikWork2nd           = '<?php echo $_GET["HgujikWork2nd"];?>';
        var gujikAge               = '<?php echo $_GET["HgujikAge"];?>';
        var gujikPay               = '<?php echo $_GET["HgujikPay"];?>';
        var gujikTime              = '<?php echo $_GET["HgujikTime"];?>';
        var gujikGender            = '<?php echo $_GET["HgujikGender"];?>';
        var gujikCareer            = '<?php echo $_GET["HgujikCareer"];?>';
   
        $("#HgujikArea1st"           ).val(gujikArea1st);
        $("#HgujikArea2nd"           ).val(gujikArea2nd);     
        $("#HgujikArea3rd"           ).val(gujikArea3rd);        
        $("#HgujikWork1st"           ).val(gujikWork1st);        
        $("#HgujikWork2nd"           ).val(gujikWork2nd);   
        $("#HgujikAge"               ).val(gujikAge);       
        $("#HgujikPay"               ).val(gujikPay);            
        //$("#HguinPayIsUnrelated"    ).val(guinPayIsUnrelated); 
        $("#HgujikTime"              ).val(gujikTime);  
        $("#HgujikGender"            ).val(gujikGender);
        $("#HgujikCareer"            ).val(gujikCareer);
        //$("#HguinCareerIsUnrelated" ).val(guinCareerIsUnrelated);
        //$("#guinArea1st").val(guinArea1st);
        //$("#guinArea2nd").val(guinArea2nd);
        //$("#guinArea3rd").val(guinArea3rd);

        if(onePage=='') {
            $("#onePage").val("10");
        } else {
            $("#onePage").val(onePage);
        }

        if(gujikArea1st != '')      loadGujikArea2ndList(gujikArea1st);
        if(gujikArea2nd != '')      loadGujikArea3rdList(gujikArea2nd);
        
        $("#si"+gujikArea1st).addClass("active-btn");

        if(gujikArea1st != '') {
            $("#gujikArea2ndListArea").show();
        }

        if(gujikArea2nd != '') {
            $("#gujikArea3rdListArea").show();
        }
      
        // 업직종
        loadGujikWork1stList();

        // 연령대
        if(gujikAge != ''){
            $('input:radio[name=gujikAge]').filter('[value='+gujikAge+']').prop('checked', true);
        }

        // 급여조건
        $("#gujikPay").val('<?php echo $_GET["HgujikPay"];?>');

        // 근무시간
        if(gujikTime != '' ){
            $('input:radio[name=gujikTime]').filter('[value='+gujikTime+']').prop('checked', true);
        }

        // 성별
        if(gujikGender != '' ){
            $('input:radio[name=gujikGender]').filter('[value='+gujikGender+']').prop('checked', true);
        }

        // 경력
        $("#gujikCareer").val('<?php echo $_GET["HgujikCareer"];?>');
    }

    // =================================================================================================================================================================
    //  ▽ ... LOAD DATA ... ▽
    // =================================================================================================================================================================
    function loadGujikArea2ndList(area_1st) {
        $.ajax({
             type: 'post',
             dataType: 'json',
             url: 'ajax/getArea2ndList.php',
             data: {area_1st:area_1st},
             success: function (data) {
                var cell = document.getElementById("gujikArea2ndListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikArea2ndListArea").innerHTML
                      += '<a href="javascript:setGujikArea2nd('+data.listData[i].area_2nd+')" id="gu'+data.listData[i].area_2nd+'" class="local1Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_2nd_nm+'</a>';
                }

                $("#gu"+'<?php echo $_GET["HgujikArea2nd"];?>').addClass("active-btn2");
            }
        });
    }

    function loadGujikArea3rdList(area_2nd) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea3rdList.php',
            data: {area_2nd:area_2nd},
            success: function (data) {
                  var cell = document.getElementById("gujikArea3rdListArea");

                  while (cell.hasChildNodes()){
                      cell.removeChild(cell.firstChild);
                  }

                  for (var i=0; i<data.listData.length; i++ ){
                      document.getElementById("gujikArea3rdListArea").innerHTML
                        += '<a href="javascript:setGujikArea3rd('+data.listData[i].area_3rd+')" id="dong'+data.listData[i].area_3rd+'" class="local2Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_3rd_nm+'</a>';
                  }

                  $("#dong"+'<?php echo $_GET["HgujikArea3rd"];?>').addClass("active-btn2");
              }
        });
    }

    function loadGujikWork1stList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork1stList.php',
            success: function (data) {
                var cell = document.getElementById("gujikWork1st");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("gujikWork1st").innerHTML = '<option value="">1차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikWork1st").innerHTML += '<option value="' + data.listData[i].work_1st + '">' + data.listData[i].work_1st_nm + '</option>';
                }

                $("#gujikWork1st").val('<?php echo $_GET["HgujikWork1st"];?>');

                loadGujikWork2ndList();
            }
        });
    }

    function loadGujikWork2ndList() {
        var work_1st = $("#gujikWork1st option:selected").val();

        if (work_1st == '') return;

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork2ndList.php',
            data: {work_1st:work_1st},
            success: function (data) {
                var cell = document.getElementById("gujikWork2nd");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("gujikWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikWork2nd").innerHTML += '<option value="' + data.listData[i].work_2nd + '">' + data.listData[i].work_2nd_nm + '</option>';
                }

                $("#gujikWork2nd").val('<?php echo $_GET["HgujikWork2nd"];?>');
            }
        });
    }
    // =================================================================================================================================================================
    //  △ ... LOAD DATA ... △
    // =================================================================================================================================================================

    function setGujikArea1st(area_1st) {
        $("input#HgujikArea1st").val(area_1st);
        $("input#HgujikArea2nd").val("");
        $("input#HgujikArea3rd").val("");
        $("#guingujikTab1 > ul > li > a"  ).removeClass("active-btn"); 
        $("#si"+area_1st).addClass("active-btn");
        $("#gujikArea2ndListArea").show();
    
        getGujikArea2ndList(area_1st);

        var cell = document.getElementById("gujikArea3rdListArea");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        $("#gujikArea3rdListArea").hide();
    }

    function getTab1NewGujikList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: './ajax/guin/getNewGujikList.php',
            success: function (data) {
                var cell = document.getElementById("Tab1newGujikListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ) {
                    if(data.listData[i].img_url == null) {
                        if(data.listData[i].sex == "male") {
                            //남자일때 이미지
                            data.listData[i].img_url = "./images/71x71-m.png";
                        } else if(data.listData[i].sex == "female") {
                            //여자일때 이미지
                            data.listData[i].img_url = "./images/71x71-f.png";
                        } else {
                            //성별 미입력시 이미지 (성별이 없을 때)
                            data.listData[i].img_url = "./images/71x71_original.png";
                        }
                    } else {
                        data.listData[i].img_url = './gujikImage/' + data.listData[i].img_url;
                    }
              
                    document.getElementById("Tab1newGujikListArea").innerHTML
                    += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 border-grey h125p">'
                    // +    '<a class="di pa plusIcon-grey plusIconPadding f23 bold f_grey" href="./guin/view/guinTab1.php?resumeNo='+data.listData[i].no+'" align="center" onfocus=this.blur();></a>'
                    +    '<a class="di pa plusIcon-grey plusIconPadding f23 bold f_grey" href="javascript:itemCheck(' + data.listData[i].no + ')" align="center" onfocus=this.blur();></a>'
                    +    '<div class="oh" style="padding:15px 24px 0 10px">'
                    +    '<img class="profileImg fl wh71 mr15" src=' + data.listData[i].img_url + ' alt="">'
                    +    '<div class="fl">'
                    +    '<h5 class="f_grey f13 gujikText-overflow cp" onclick="itemCheck(' + data.listData[i].no + ')">' + data.listData[i].title + '</h5>'
                    +    '<p class="f12">' + data.listData[i].work_1st_nm + '<span> > </span>' + data.listData[i].work_2nd_nm + '</p>'
                    +    '<p class="f12"><b>지역</b> : ' + data.listData[i].area_1st_nm + '<span> > </span>' + data.listData[i].area_2nd_nm + ' ' + data.listData[i].area_3rd_nm + '</p>'
                    +    '</div>'
                    +    '</div>'
                    +    '<div class="clear pt10 pl10 pr24">'
                    +    '<span class="ilbangBadge mr10">' + data.listData[i].work_2nd_nm + '</span>'
                    +    '<span class="pr10 border-right">' + data.listData[i].career + '</span>'
                    +    '<span class="ml10">' + data.listData[i].time + ' 근무 희망</span>'
                    +    '<span class="fr"><b class="fc">**,***</b>원</span>'
                    +    '</div>'
                    +    '</div>';
                }
            }
        });
    }

    function getGujikArea2ndList(area_1st) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea2ndList.php',
            data: {area_1st:area_1st},
            success: function (data) {
                var cell = document.getElementById("gujikArea2ndListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikArea2ndListArea").innerHTML
                    += '<a href="javascript:setGujikArea2nd('+data.listData[i].area_2nd+')" id="gu'+data.listData[i].area_2nd+'" class="local1Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_2nd_nm+'</a>';
                }
            }
        });
    }

    function setGujikArea2nd(area_2nd) {
        $("input#HgujikArea2nd"  ).val(area_2nd);     
        $("input#HgujikArea3rd"  ).val("");
        $("#gujikArea2ndListArea > a").removeClass("active-btn2")   ;
        $("#gu"+area_2nd).addClass("active-btn2");   
        
        getGujikArea3rdList(area_2nd);

        $("#gujikArea3rdListArea").show();
    }

    function getGujikArea3rdList(area_2nd) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea3rdList.php',
            data: {area_2nd:area_2nd},
            success: function (data) {
                var cell = document.getElementById("gujikArea3rdListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikArea3rdListArea").innerHTML
                    += '<a href="javascript:setGujikArea3rd('+data.listData[i].area_3rd+')" id="dong'+data.listData[i].area_3rd+'" class="local2Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_3rd_nm+'</a>';
                }
            }
        });
    }

    function setGujikArea3rd (area_3rd) {
        $("#HgujikArea3rd"  ).val(area_3rd);
        $("#gujikArea3rdListArea > a").removeClass("active-btn2");
        $("#dong"+area_3rd).addClass("active-btn2");
    }

    function getGujikWork1stList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork1stList.php',
            success: function (data) {
                var cell = document.getElementById("gujikWork1st");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("gujikWork1st").innerHTML = '<option value="">1차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikWork1st").innerHTML
                    += '<option value="' + data.listData[i].work_1st + '">' + data.listData[i].work_1st_nm + '</option>';
                }
            }
        });
    }

    function getGujikWork2ndList() {
        var work_1st = $("#gujikWork1st option:selected").val();
        
        $("#HgujikWork1st" ).val(work_1st);

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork2ndList.php',
            data: {work_1st:work_1st},
            success: function (data) {
                var cell = document.getElementById("gujikWork2nd");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("gujikWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikWork2nd").innerHTML
                    += '<option value="' + data.listData[i].work_2nd + '">' + data.listData[i].work_2nd_nm + '</option>';
                }
            }
        });
    }

    function setGujikWork2nd() {
        var work_2nd = $("#gujikWork2nd option:selected").val();
        
        $("#HgujikWork2nd").val(work_2nd);
    }

    function setGujikAge(age) {
        $("#HgujikAge").val(age);
    }

    function setGujikPay() {
        var gujikPay = $("#gujikPay option:selected").val();
        
        $("#HgujikPay").val(gujikPay);
    }

    function setGujikTime(time) {
        $("#HgujikTime").val(time);
    }

    function setGujikGender(sex) {
        $("#HgujikGender").val(sex);
    }

    function setGujikCareer() {
        var gujikCareer = $("#gujikCareer option:selected").val();
        
        $("#HgujikCareer").val(gujikCareer);
    }

    function setOnePage() {
        $("#HgujikPage").val(1);
        $("#HgujikOnePage").val($("#onePage option:selected").val());
        
        document.getElementById("gujikSearchForm").submit();
    }

    function gujikClear() {
        $("#HgujikPage").val(1);
        $("#HgujikOnePage").val(10);
        $("#HgujikArea1st").val("");
        $("#HgujikArea2nd").val("");     
        $("#HgujikArea3rd").val("");        
        $("#HgujikWork1st").val("");        
        $("#HgujikWork2nd").val("");        
        $("#HgujikPay").val("");            
        // $("#HgujikPayIsUnrelated"    ).val(""); 
        $("#HgujikTime").val("");  
        $("#HgujikGender").val("");
        $("#HgujikCareer").val("");
        // $("#HguinCareerIsUnrelated" ).val("");
        $("#HgujikAge").val("");  
        $("#guingujikTab1 > ul > li > a").removeClass("active-btn");
        $("#gujikArea2ndListArea > a").removeClass("active-btn2");
        $("#gujikArea3rdListArea > a").removeClass("active-btn2");
        $("#gujikArea1st").val("");
        $("#gujikArea2nd").val("");
        $("#gujikArea3rd").val("");
        $("#gujikWork1st").val("");
        //$("#guinWork2nd").val("");

        var cell = document.getElementById("gujikWork2nd");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        document.getElementById("gujikWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

        //$('input:radio[name=guinAge]').filter('[value=unrelated]').prop('checked', true);
        $('input:radio[name=gujikAge]').prop('checked', false);
        $("#gujikPay").val("");
        //$("#guinPayIsUnrelated").();
        // $("#gujikPayIsUnrelated").attr('checked', false);
        //$('input:radio[name=guinTime]').filter('[value=unrelated]').prop('checked', true);
        //$('input:radio[name=guinGender]').filter('[value=nothing]').prop('checked', true);
        $('input:radio[name=gujikTime]').prop('checked', false);
        $('input:radio[name=gujikGender]').prop('checked', false);
        $("#gujikCareer").val("");
        // $("#guinCareerIsUnrelated").attr('checked', false);

        var cell = document.getElementById("gujikArea2ndListArea");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        var cell = document.getElementById("gujikArea3rdListArea");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        $("#gujikArea2ndListArea").hide();
        $("#gujikArea3rdListArea").hide();
    }

    function gujikSearch(page) {
        $("#HgujikPage").val(page);

        document.getElementById("gujikSearchForm").submit();
    }

    function itemCheck(no) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/item/itemCheck.php',
            data: { no: no },
            success: function(data) {
                if(data.url == "") {
                    alert(data.message);
                    // if(confirm(data.message)) {
                    //     document.location.href = "itemShop/itemshop.php";
                    // }
                } else {
                    if(data.message == "") {
                        document.location.href = data.url;
                    } else {
                        if(confirm(data.message)) {
                            document.location.href = data.url;
                        }
                    }
                }
            }
        });
    }
</script>
<h3 class="f16 mb10">검색으로 찾기</h3>
<ul class="noPadding w100">
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si10000" href="javascript:setGujikArea1st('10000')">전국</a> <!-- javascript:setGuinArea1st('10000')-->
    </li>                  
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si1" href="javascript:setGujikArea1st('1')">서울</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si907" href="javascript:setGujikArea1st('907')">인천</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si1164" href="javascript:setGujikArea1st('1164')">광주</a>
    </li>
    <li class="border local guin_local fl text-center" >
        <a class="di w100 padding-vertical" id="si1420" href="javascript:setGujikArea1st('1420')">대전</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si1631" href="javascript:setGujikArea1st('1631')">대구</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si1923" href="javascript:setGujikArea1st('1923')">부산</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si2314" href="javascript:setGujikArea1st('2314')">울산</a>
    </li>
    <li class="border local guin_local fl text-center"> 
        <a class="di w100 padding-vertical" id="si2422" href="javascript:setGujikArea1st('2422')">경기</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si3312" href="javascript:setGujikArea1st('3312')">강원</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si3641" href="javascript:setGujikArea1st('3641')">충남</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si3950" href="javascript:setGujikArea1st('3950')">충북</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si4219" href="javascript:setGujikArea1st('4219')">전남</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si4687" href="javascript:setGujikArea1st('4687')">전북</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si5128" href="javascript:setGujikArea1st('5128')">경남</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si5709" href="javascript:setGujikArea1st('5709')">경북</a>
    </li>
    <li class="border local guin_local fl text-center">
        <a class="di w100 padding-vertical" id="si7700" href="javascript:setGujikArea1st('7700')">세종</a>
    </li>
    <li class="border local guin_local fl text-center border-right-ilbang">
        <a class="di w100 padding-vertical" id="si6296" href="javascript:setGujikArea1st('6296')">제주</a>
    </li>
</ul>
<div class="clear"></div>
<ul class="local1 padding oh border-grey noMargin" id="gujikArea2ndListArea"></ul>
<ul class="local2 padding oh border-grey" id="gujikArea3rdListArea"></ul>
<div class="clear"></div>
<!-- 폼 영역 -->        
<form class="form-horizontal bg_grey f_grey padding oh border-grey" id="gujikSearchForm" name="gujikSearchForm" method="get" action="./guin.php">
    <input type="hidden" name="HgujikPage"             id="HgujikPage"              value="<?php echo $page?>">
    <input type="hidden" name="HgujikOnePage"          id="HgujikOnePage"           value="<?php echo $onePage?>">
    <input type="hidden" name="HgujikArea1st"          id="HgujikArea1st"           value="">
    <input type="hidden" name="HgujikArea2nd"          id="HgujikArea2nd"           value="">
    <input type="hidden" name="HgujikArea3rd"          id="HgujikArea3rd"           value="">
    <input type="hidden" name="HgujikWork1st"          id="HgujikWork1st"           value="">
    <input type="hidden" name="HgujikWork2nd"           id="HgujikWork2nd"           value="">
    <input type="hidden" name="HgujikAge"               id="HgujikAge"               value="">          
    <input type="hidden" name="HgujikPay"               id="HgujikPay"               value="">
    <!--<input type="hidden" name="HguinPayIsUnrelated"    id="HguinPayIsUnrelated"    value="">-->
    <input type="hidden" name="HgujikTime"              id="HgujikTime"              value="">
    <input type="hidden" name="HgujikGender"            id="HgujikGender"            value="">
    <input type="hidden" name="HgujikCareer"            id="HgujikCareer"            value="">
    <!-- 1 -->
    <div class="form-group guin-form padding mt30">
        <label for="inputEmail3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">업직종</label>
        <div class="col-sm-10">
            <select name="gujikWork1st" onchange="getGujikWork2ndList()" id="gujikWork1st" class="form-control fl" style="width:20%">
                <option value="">1차 분류 선택</option>
            </select>
            <span class="fl vm di f16 arrow-right margin-horizontal mt4"><b>></b></span>
            <select name="gujikWork2nd" id="gujikWork2nd" onchange="setGujikWork2nd()" class="form-control fl" style="width:20%">
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
                    <input type="radio" name="gujikAge" value="10" onclick="setGujikAge('10')"><span class="ml5">10대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="gujikAge" value="20" onclick="setGujikAge('20')"><span class="ml5">20대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="gujikAge" value="30" onclick="setGujikAge('30')"><span class="ml5">30대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="gujikAge" value="40" onclick="setGujikAge('40')"><span class="ml5">40대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="gujikAge" value="50" onclick="setGujikAge('50')"><span class="ml5">50대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="gujikAge" value="60" onclick="setGujikAge('60')"><span class="ml5">60대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="gujikAge" value="70" onclick="setGujikAge('70')"><span class="ml5">70대</span>
                </label>
            </div>
            <div class="radio fl">
                <label class="ml15">
                    <input type="radio" name="gujikAge" value="80" onclick="setGujikAge('80')"><span class="ml5">80대</span>
                </label>
            </div>
        </div>
    </div>        
    <div class="form-group guin-form padding">
        <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">급여 조건</label>
        <div class="col-sm-10">
            <select name="gujikPay" id="gujikPay" onchange="setGujikPay()"  class="form-control fl" style="width:20%">
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
                     <input type="radio" name="gujikTime" value="1" onclick="setGujikTime('1')"><span class="ml5">오전</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="2" onclick="setGujikTime('2')"><span class="ml5">오후</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="3" onclick="setGujikTime('3')"><span class="ml5">저녁</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="4" onclick="setGujikTime('4')"><span class="ml5">새벽</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="5" onclick="setGujikTime('5')"><span class="ml5">오전 ~ 오후</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="6" onclick="setGujikTime('6')"><span class="ml5">오후 ~ 저녁</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="7" onclick="setGujikTime('7')"><span class="ml5">저녁 ~ 새벽</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="8" onclick="setGujikTime('8')"><span class="ml5">새벽 ~ 오전</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="9" onclick="setGujikTime('9')"><span class="ml5">종일</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikTime" value="10" onclick="setGujikTime('10')"><span class="ml5">무관/협의</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group guin-form padding">
        <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">성별</label>
        <div class="col-sm-10 lh12">
             <div class="radio">
                <label>
                    <input type="radio" name="gujikGender" value="male" onclick="setGujikGender('male')" ><span class="ml5">남자</span>
                </label>
                <label class="ml15">
                    <input type="radio" name="gujikGender" value="female" onclick="setGujikGender('female')" ><span class="ml5">여자</span>
                </label>
            </div>
        </div>
    </div>
    <div class="form-group guin-form padding">
        <label for="inputEmail3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">경력</label>
        <div class="col-sm-10">
            <select name="gujikCareer" id="gujikCareer" onchange="setGujikCareer()" class="form-control fl" style="width:20%">
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
            <li><a class="f14 bg_navy border-navy fff" href="javascript:gujikSearch(1)">검색</a></li>
            <li><a class="white-btn f14 border-navy" style="color: #545975;" href="javascript:gujikClear()">초기화</a></li>
        </ul>       
    </div>  
</form>
<!-- 섹션2 -->
<div class="container mt30 pr30">
    <h4 class="fl f16 mb10">최신 이력서 정보</h4>
    <p class="fr f12 mt10">* 신청시 바로 매칭 서비스를 받으실 수 있습니다.
        <a href="itemShop/itemshop.php" class="sm-btn sm-btn2 f12 ml10">상품 구매</a>
    </p>
    <div class="normalWrap oh w100" id="Tab1newGujikListArea"></div>
</div>
<div class="container mt30 pr30">
    <div class="oh">
        <h4 class="fl f16 mb10">이력서 정보</h4>         
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
        <ul class="bg_darkgrey guinInfoTlt oh noPadding">
            <li class="guinInfoLi1 tc fl">이름</li>
            <li class="guinInfoLi2 tc fl">이력서 정보</li>
            <li class="guinInfoLi3 fl tc">경력 / 희망 근무 시간</li>
            <li class="guinInfoLi4 fl">
                <p class="tc">등록일</p>
            </li>
        </ul>
        <?php
            while($row = @mysql_fetch_array($result)) {
                $keyword  = explode(",", $row["keyword"]);

                $oneData["area_1st_nm"] = $keyword[0];
                $oneData["area_2nd_nm"] = $keyword[1];
                $oneData["area_3rd_nm"] = $keyword[2];
                $oneData["work_1st_nm"] = $keyword[3];
                $oneData["work_2nd_nm"] = $keyword[4];
                $oneData["no"]        = $row["no"];
                $oneData["name"]      = $row["name"];
                $oneData["sex"]       = $row["sex"];
                $oneData["age"]       = $row["age"];
                $oneData["title"]     = $row["title"];
                $oneData["keyword"]   = $row["keyword"];
                $oneData["content"]   = $row["content"];
                $oneData["career"]    = $row["career"];
                $oneData["pay"]       = number_format($row["pay"]);
                $oneData["time"]      = $row["time"];
                $oneData["wdate"]     = $row["wdate"];
                $oneData["name"] = mb_substr($oneData["name"], 0, 1, 'utf-8') . "OO"; 
                $oneData["age"] = substr($oneData["age"], 0, 1) . "0";     

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

                if($oneData["sex"] == "male")     $oneData["sex"] = "남자";
                else if($oneData["sex"] == "female")   $oneData["sex"] = "여자";
                else if($oneData["sex"] == "nothing") $oneData["sex"] = "무관";  

                if($oneData["career"] == "-1")  $oneData["career"] = "무관";
                else if($oneData["career"] == "0")   $oneData["career"] = "신입";
                else if($oneData["career"] == "1")   $oneData["career"] = "1년 미만";  
                else if($oneData["career"] == "3")   $oneData["career"] = "3년 미만";  
                else if($oneData["career"] == "5")   $oneData["career"] = "5년 미만";  
                else if($oneData["career"] == "6")   $oneData["career"] = "5년 이상";  

                if(empty($oneData["area_1st_nm"])) $oneData["area_1st_nm"] = "";
                if(empty($oneData["area_2nd_nm"])) $oneData["area_2nd_nm"] = "";
                if(empty($oneData["area_3rd_nm"])) $oneData["area_3rd_nm"] = "";
                if(empty($oneData["work_1st_nm"])) $oneData["work_1st_nm"] = "";
                if(empty($oneData["work_2nd_nm"])) $oneData["work_2nd_nm"] = "일방";
                if(empty($oneData["company"]))     $oneData["company"]     = "";
                if(empty($oneData["title"]))       $oneData["title"]       = "타이들";
                if(empty($oneData["sex"]))         $oneData["sex"]         = "";
                if(empty($oneData["time"]))        $oneData["time"]        = "";
                if(empty($oneData["wdate"]))       $oneData["wdate"]       = "";
            ?>
        <ul class="oh noPadding guinInfoList bb pdt6">
            <li class="guinInfoLi1 fl tc" style="padding-top: 30px;">
                <div class="bold">
                    <?php echo $oneData["name"] ?> (<?php echo $oneData["sex"] ?>,<?php echo $oneData["age"] ?>대)<br />
                    <?php echo $oneData["area_1st_nm"] ?> > <?php echo $oneData["area_2nd_nm"] ?>
                </div>
            </li>
            <li class="guinInfoLi2 fl">
                <!-- <h5 class="cp" onclick=location.href="./guin/view/guinTab1.php?tab=1&resumeNo=<?php echo $oneData['no']?>"><?php echo $oneData["title"] ?></h5> -->
                <h5 class="cp" onclick="itemCheck(<?php echo $oneData['no']?>)"><?php echo $oneData["title"] ?></h5>
                <div class="margin-vertical info2Cont">
                    <span class="ilbangBadge"><b><?php echo $oneData["work_2nd_nm"] ?></b></span>
                    <span class="di text-cut guinDesc margin-verti ml5"><?php echo $oneData["content"] ?></span>
                </div>
                <div>
                    <span><?php echo $oneData["career"] ?></span> 
                    <span class="margin-horizontal"></span> 
                    <span class="border-grey payBedge mr5 f_navy bold">일당</span>  
                    <span class="bold f_navy"><?php echo $oneData["pay"] ?>원</span> 
                </div>
            </li>
            <li class="guinInfoLi3 lh25 fl tc">
                <p><?php echo $oneData["career"] ?></p>
                <p><?php echo $oneData["time"] ?></p>
            </li>
            <li class="guinInfoLi4 fl tc">
                <p class="lh25 mb10"><?php echo $oneData["wdate"] ?></p>  
                <p class="mb10">
                    <!-- <a href="./guin/view/guinTab1.php?tab=1&resumeNo=<?php echo $oneData['no']?>" class="direct sm-btn sm-btn3 f12">열람하기</a> -->
                    <a href="javascript:itemCheck(<?php echo $oneData['no']; ?>);" class="direct sm-btn sm-btn3 f12">열람하기</a>
                </p>
                <p>
                    <a href="./guin/resumeReview.php?resumeNo=<?php echo $oneData['no']?>" class="viewEsti sm-btn sm-btn2 f12">평가보기</a>
                </p>
            </li>
        </ul>
        <?php } ?>
    </div>
    <?php
        $paging .=  '<ul class="pagination">';
        
        //첫 페이지가 아니라면 처음 버튼을 생성
        if($page != 1) {
            $paging .= '<li><a href="javascript:gujikSearch(1)"> << 첫페이지 </a></li>';
        }
    
        //첫 섹션이 아니라면 이전 버튼을 생성
        if($currentSection != 1) {
            $paging .= '<li><a href="javascript:gujikSearch('.$prevPage.')">이전</a></li>';
        }

        for($i = $firstPage; $i <= $lastPage; $i++) {
            if($i == $page) {
                $paging .= '<li class="bg-light-gray"><a href="javascript:gujikSearch('. $i .')" class="bg-light-gray">'.$i.'</a></li>'; 
            } else {
                $paging .= '<li><a href="javascript:gujikSearch('. $i .')">'.$i.'</a></li>'; 
            }
        }

        //마지막 섹션이 아니라면 다음 버튼을 생성
        if($currentSection != $allSection) {
            $paging .= '<li><a href="javascript:gujikSearch('.$nextPage.')">다음</a></li>';
        }

        //마지막 페이지가 아니라면 끝 버튼을 생성
        if($page != $allPage && $allPage != 0) {
            $paging .= '<li><a href="javascript:gujikSearch('.$allPage.')">끝페이지 >> </a></li>';
        }
        
        $paging .=  '</ul>';
    ?>
    <div class="container center tc pb5">
        <?php echo $paging ?>
    </div>
</div>