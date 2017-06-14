<?php
    include_once "../../include/header.php";
    include_once "../../db/connect.php";

    $resumeNo = $_GET["resumeNo"];
    $wdate = date("Y-m-d H:i:s");

    $sql = "SELECT COUNT(*) FROM work_item WHERE uid = '$uid' AND item_kind IN('resumeWeek', 'resumeMonth') AND end_date > NOW()";
    $result = mysql_query($sql);
    $arr = mysql_fetch_array($result);

    if($arr[0] == 0) {
        $sql = "SELECT COUNT(*) AS cnt, id, item_id FROM item_data
                     WHERE id =
                     (SELECT item_id FROM work_item WHERE uid = '$uid' AND item_kind = 'resume' AND count > 0 ORDER BY count)";
        $result = mysql_query($sql);
        $arr = mysql_fetch_array($result);

        $itemNo = $arr["id"];
        $itemID = $arr["item_id"];

        if($arr["cnt"] == 0) {
            echo '<script>alert("이력서를 열람하기 위해서는 아이템이 필요합니다.");</script>';
            echo "<script>history.back();</script>";
        } else {
            $sql = "INSERT INTO item_use_log(user_id, item_name, use_date) VALUES ('$uid', '$itemID', '$wdate')";
            $result = mysql_query($sql);

            if($result) {
                mysql_query("UPDATE work_item SET count = count - 1 WHERE uid = '$uid' AND item_id = '$itemNo'");

                $sql = "SELECT COUNT(*) FROM recent_resume WHERE uid = '$uid' AND resume_no = $resumeNo";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                if($arr[0] == 0) {
                    $sql = "SELECT title, keyword FROM work_resume_data WHERE no = $resumeNo";
                    $result = mysql_query($sql);
                    $arr = mysql_fetch_array($result);

                    $title = $arr["title"];
                    $keyword = explode(",", $arr["keyword"]);
                    $work2 = $keyword[4];

                    $sql = "INSERT INTO recent_resume(resume_no, wdate, work_2nd, title, uid) VALUES ($resumeNo, '$wdate', '$work2', '$title', '$uid')";
                    $result = mysql_query($sql);
                } else {
                    mysql_query("UPDATE recent_resume SET wdate = '$wdate' WHERE uid = '$uid' AND resume_no = $resumeNo");
                }

                $sql = "SELECT COUNT(*), no FROM recent_resume WHERE uid = '$uid' ORDER BY wdate";
                $result = mysql_query($sql);
                $arr = mysql_fetch_array($result);

                $resumeCnt = $arr[0];
                $delResumeNo = $arr[1];

                if($resumeCnt > 10) {
                    mysql_query("DELETE FROM recent_resume WHERE no = $delResumeNo");
                }
            }
        }
    }
?>
<script>
    $( document ).ready(function() {
        getNotice();
        guinCheck(0);

        var onePage               = '<?php echo $_GET["HguinOnePage"];?>';
        var guinArea1st           = '<?php echo $_GET["HguinArea1st"];?>';
        var guinArea2nd           = '<?php echo $_GET["HguinArea2nd"];?>';
        var guinArea3rd           = '<?php echo $_GET["HguinArea3rd"];?>';
        var guinWork1st           = '<?php echo $_GET["HguinWork1st"];?>';
        var guinWork2nd           = '<?php echo $_GET["HguinWork2nd"];?>';
        var guinAge               = '<?php echo $_GET["HguinAge"];?>';
        var guinPay               = '<?php echo $_GET["HguinPay"];?>';
        var guinTime              = '<?php echo $_GET["HguinTime"];?>';
        var guinGender            = '<?php echo $_GET["HguinGender"];?>';
        var guinCareer            = '<?php echo $_GET["HguinCareer"];?>';

        $("#HguinArea1st"           ).val(guinArea1st);
        $("#HguinArea2nd"           ).val(guinArea2nd);     
        $("#HguinArea3rd"           ).val(guinArea3rd);        
        $("#HguinWork1st"           ).val(guinWork1st);        
        $("#HguinWork2nd"           ).val(guinWork2nd);   
        $("#HguinAge"               ).val(guinAge);       
        $("#HguinPay"               ).val(guinPay);            
        $("#HguinTime"              ).val(guinTime);  
        $("#HguinGender"            ).val(guinGender);
        $("#HguinCareer"            ).val(guinCareer); 

        getGuinCounter();
        getViewGuinTab4Data();
    });

    function getNotice() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../../ajax/notice/getNoticeList.php',
            success: function(data) {
                for(var i=0; i<1; i++) {
                    document.getElementById("adNotice").innerHTML
                    = '<a href="../../notice/view.php?no=' + data.noticeList[i].no + '" class="c999">' + data.noticeList[i].title + '</a>';
                }
            }
        });
    }

    function guinCheck(val) {
        var id = "<?php echo $uid; ?>";

        if(id == "") {
            if(val == 1) {
                alert("로그인 후 이용해주세요.");
            }
        } else {
            if(val == 0) {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '../../ajax/guin/guinCheck.php',
                    success: function(data) {
                        if(data == 0) {
                            document.getElementById("guinCheck1").innerHTML
                            = '<a href="#" class="gujikCount count5 fl tc f14" style="background-color: black; color: #fff;" data-toggle="modal" data-target="#guinTabModal">'
                            + '<span class="glyphicon glyphicon-plus f22"></span>'
                            + '<p class="margin-vertical">채용 공고 작성</p>'
                            + '</a>';
                        }
                    }
                });
            } else {
                document.location.href = "../form/form.php";
            }
        }
    }

    function getViewGuinTab4Data() {
        var resumeNo    = '<?php echo $resumeNo ?>';
        var uid         = '<?php echo $uid ?>';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../../ajax/guin/getViewGuinTab1Data.php',
            data: {resumeNo:resumeNo, uid:uid},
            success: function (data) {
                for(var i=0; i<data.resumeData.length; i++) {
                    if(data.resumeData[i].img_url == null || data.resumeData[i].img_url == ''){
                        $("#imgUrl" ).attr("src", "../../images/profile.png" );
                    } else {
                        $("#imgUrl" ).attr("src", "../../gujikImage/" + data.resumeData[i].img_url );
                    }

                    $("#title"      ).text(data.resumeData[i].title);
                    $("#name"       ).text(data.resumeData[i].name);
                    $("#address"    ).text(data.resumeData[i].area_1st_nm + ' ' + data.resumeData[i].area_2nd_nm + ' ' + data.resumeData[i].area_3rd_nm);
                    $("#hopeAddress").text(data.resumeData[i].area_1st_nm + ' ' + data.resumeData[i].area_2nd_nm + ' ' + data.resumeData[i].area_3rd_nm);
                    $("#work_2nd_nm").text(data.resumeData[i].work_2nd_nm );
                    $("#sex"        ).text(data.resumeData[i].sex );
                    $("#age"        ).text(data.resumeData[i].age );
                    $("#career"     ).text(data.resumeData[i].career );
                    $("#obstacle"   ).text(data.resumeData[i].obstacle );
                    $("#email"      ).text(data.resumeData[i].email );
                    $("#phone"      ).text( '구인 신청 후 매칭 리스트에서 확인하실 수 있습니다.' ); //data.resumeData[i].phone
                    $("#time"       ).text(data.resumeData[i].time );
                    $("#pay"        ).text(data.resumeData[i].pay );
                    document.getElementById("contents").innerHTML = data.resumeData[i].content;
                    $("#birthday"   ).text('구인 신청 후 매칭 리스트에서 확인하실 수 있습니다.' ); // data.resumeData[i].birthday
                    $("#Hruid"      ).val(data.resumeData[i].ruid );
                    $("#reviewLink").attr("href","../resumeReview.php?resumeNo="+resumeNo+"");

                    if((data.resumeData[i].email).indexOf("undefined") == 0) {
                        $("#email").text("구직자가 이메일 주소를 입력하지 않았습니다.");
                    }
                }

                var cell = document.getElementById("workDate");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for(var i=0; i<data.workDateList.length; i++){
                    var checkedStr ="";

                    if(data.workDateList[i].myWorkDateYn == '지원한날짜임') checkedStr = 'checked';
                    document.getElementById("workDate").innerHTML
                    += '<input name="workDate" class="vm mr5 ml10" type="checkbox" '+checkedStr+' value="'+data.workDateList[i].resumeWorkDate+'"/>'+data.workDateList[i].resumeWorkDate;
                }
            }
        });
    }

    function getGuinCounter(){
        $.ajax({
             type: 'post',
             dataType: 'json',
             url: '../../ajax/gujik/getGujikCounter.php',
             success: function (data) {
               new numberCounter("newEmploy"    , data.listData[0].newEmploy);
               new numberCounter("allEmploy"    , data.listData[0].allEmploy);
               new numberCounter("newMatching"  , data.listData[0].newMatching);
               new numberCounter("allMatching"  , data.listData[0].allMatching);
            }
        });
    }

    function numberCounter(target_frame, target_number) {
        this.count = 0; this.diff = 0;
        this.target_count = parseInt(target_number);
        this.target_frame = document.getElementById(target_frame);
        this.timer = null;
        this.counter();
    };
  
    numberCounter.prototype.counter = function() {
        var self = this;
        this.diff = this.target_count - this.count;
  
        if(this.diff > 0) {
            self.count += Math.ceil(this.diff / 5);
        }
  
        this.target_frame.innerHTML = this.count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  
        if(this.count < this.target_count) {
            this.timer = setTimeout(function() { self.counter(); }, 20);
        } else {
            clearTimeout(this.timer);
        }
    };

    function goPage(addr,tab){
        $("#tab").val(tab);
        $("#viewForm").attr("action", addr);

        document.getElementById("viewForm").submit();
    }
/*
    function cancelApproval(){
        var work_join_list_no_arr = [];         
        $("input[name=workDate]:checked").each(function() {
            work_join_list_no_arr.push($(this).val());
        });

        if (work_join_list_no_arr.length == 0){
            alert("승인 취소할 근무일자를 선택해주세요.");
            return ;
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../../ajax/guin/cancelApproval.php',
            data: {work_join_list_no_arr:work_join_list_no_arr},
            success: function (data) {
            
                if(data.result == "1")
                {
                    alert(data.msg);
                    getViewGuinTab4Data();
                }
            }
            
        })

    }
*/
/*
   $euid                   = $_POST['euid'];
    $ruid                   = $_POST['ruid'];
    $work_date              = $_POST['work_date']; 
    $today                  = date("Y-m-d H:i:s");
    $work_resume_data_no    = $_POST['work_resume_data_no'];
*/
    function doGuin(){
        work_date = [];

        $("input[name=workDate]:checked").each(function() {
            work_date.push($(this).val());
        });     

        var work_resume_data_no = '<?php echo $resumeNo ?>';
        var euid                = '<?php echo $uid ?>';
        var ruid                = $("#Hruid").val();

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../../ajax/guin/doGuin.php',
            data: {work_resume_data_no:work_resume_data_no, euid:euid, work_date:work_date, ruid:ruid },
            success: function (data) {
                if(data.result=="0"){
                    alert(data.msg);

                } else if (data.result=="1"){
                    alert(data.msg);
                }
                
                getViewGuinTab4Data();
            }
        });
    }
</script>
<input type="hidden" id="Hruid" name="Hruid" />
<form method="get" id="viewForm">
    <input type="hidden" name="tab"                 id="tab"              value="">
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
</form>
<div class="wdfull">
    <div class="container center wdfull bb mb15">
        <div class="pg_rp"> 
            <div class="c999 fl subTitle">
                <a href="index.php" class="c999">HOME</a>
                <span class="plr5">&gt;</span>
                <a href="gujik.php" class="bold">구인자</a>
            </div>
            <div class="c999 fr padding-vertical">
                <span class="mr5 br15 subNotice">공지</span>
                <span id="adNotice"></span>
            </div>
        </div>
    </div>
</div>
<div class="container pl30">        
    <!-- 상단 카운트 영역 -->
    <div class="guingujikTabWrap fl pr">
       <div class="quick pa" style="left: -145px;">  
            <p class="di">
                <!-- 내 정보 -->
                <?php if($uid == "") { ?>
                <a href="javascript:alert('로그인 후 이용해주세요.')">
                    <img src="http://il-bang.com/pc_renewal/images/ggQuick1.png" alt="" class="db"> 
                </a>
                <a href="javascript:alert('로그인 후 이용해주세요.')">
                    <img src="http://il-bang.com/pc_renewal/images/ggQuick2.png" alt="" class="db">
                </a>
                <?php } else if($kind == "general") { ?>
                <a href="../../my-page/myInfo-general.php">
                    <img src="http://il-bang.com/pc_renewal/images/ggQuick1.png" alt="" class="db"> 
                </a>
                <a href="../../gujik.php?tab=2"">
                    <img src="http://il-bang.com/pc_renewal/images/ggQuick2.png" alt="" class="db">
                </a>
                <?php } else { ?>
                <a href="../../my-page/myInfo-comp.php">
                    <img src="http://il-bang.com/pc_renewal/images/ggQuick1.png" alt="" class="db"> 
                </a>
                <a href="../../guin.php?tab=2"">
                    <img src="http://il-bang.com/pc_renewal/images/ggQuick2.png" alt="" class="db">
                </a>
                <?php } ?>
                <a href="itemShop/itemshop.php">
                    <img src="http://il-bang.com/pc_renewal/images/ggQuick3.png" alt="" class="db"> 
                </a>
            </p>   
        </div>   
    </div>
    <script>
        /* quick menu */
        $(".quick").animate( { "top": $(document).scrollTop() + 0 +"px" }, 500 ); // 빼도 된다.
     
        $(window).scroll(function(){
            $(".quick").stop();
            
            if($(document).scrollTop()==0) {
                $(".quick").animate( { "top": $(document).scrollTop() + 0  + "px" }, 500 );
            } else {
                $(".quick").animate( { "top": $(document).scrollTop() + -50 + "px" }, 500 );
            }
        });                                    
    </script>               
    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 oh">
        <a href="../../ad/adMoney.php" class="linkImg di w100" style="height: 105px;"></a>
    </div>
    <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 border-grey border-box gujikTopBox oh">
        <div class="gujikCount padding-vertical count1 fl tc padding-vertical; margin-vertical">
            <h4 class="margin-vertical"><span id="newEmploy"></span>건</h4>
            <p class="margin-vertical">신규 이력서</p>
        </div>
        <div class="gujikCount padding-vertical count2 fl tc padding-vertical; margin-vertical">
            <h4 class="margin-vertical"><span id="allEmploy"></span>건</h4>
            <p class="margin-vertical">전체 이력서</p>   
        </div>
        <div class="gujikCount padding-vertical count3 fl tc padding-vertical; margin-vertical">
            <h4 class="margin-vertical"><span id="newMatching"></span>건</h4>
            <p class="margin-vertical">신규 매칭</p> 
        </div>
        <div class="gujikCount padding-vertical count4 fl tc padding-vertical; margin-vertical">
            <h4 class="margin-vertical"><span id="allMatching"></span>건</h4>
            <p class="margin-vertical">전체 매칭</p> 
        </div>
        <div id="guinCheck1">
            <a href="#" class="gujikCount count5 fl tc f14 f_white" style="background-color: black" onclick="guinCheck(1); return false;">
                <span class="glyphicon glyphicon-plus f22"></span>
                <p class="margin-vertical">채용 공고 작성</p>
            </a>
        </div>
    </div>
</div>
<div class="wdfull">    
    <div class="guingujikTabWrap">
        <ul class="nav nav-tabs mt10" role="tablist" id="myTab">
            <li role="presentation" class="noPadding guingujikTabLi text-center active"><a href="#gujikTab1" aria-controls="gujikTab1" role="tab" data-toggle="tab">전체</a></li>
            <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="javascript:goPage('../../guin.php',2)" >나의 채용 공고</a></li>
            <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="javascript:goPage('../../guin.php',3)" >매칭 리스트</a></li>
            <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="javascript:goPage('../../guin.php',4)">매칭 완료</a></li>
        </ul>
        <div class="tab-content container pl30">
            <!-- 첫번째 탭 내용 -->
            <div role="tabpanel" class="tab-pane active mt10" id="gujikTab1">
                <div class="gujikDetSect1 mt50">
                    <div class="border-navy">
                        <h4 class="bg_navy f_white padding-vertical tc noMargin" id="title"></h4>
                        <ul class="detailInfoUl_gujik pr">
                            <li class="bb padding">
                                <span class="di w10 bold">이름</span>
                                <span id="name"></span>
                            </li>
                            <li class="bb padding">
                                <span class="di w10 bold">생년월일</span>
                                <span id="birthday"></span> <!-- id="address" -->
                            </li>
                            <li class="padding">
                                <span class="di w10 bold">희망 근무지</span>
                                <span id="hopeAddress"></span>
                            </li>
                            <li class="pa tc" style="left: 0; top: 0; width: 18%">
                                <img src="" id="imgUrl" alt="" width="50%" style="margin-top: 8%">
                            </li>
                        </ul>
                    </div>
                </div>
                <h4 class="mt30 f16 mb10">희망 조건 및 구직자 정보</h4>
                <div class="gujikDetSect2 oh mt10">
                    <div class="oh bold bb">
                        <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">희망 직종</p>
                        <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">성별</p>
                        <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">나이</p>
                        <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">경력</p>
                        <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">장애 여부</p>
                    </div>
                    <div class="oh">
                        <p class="w20 fl sect2Table di lh70 f14 tc" id="work_2nd_nm"></p>
                        <p class="w20 fl sect2Table di lh70 f14 tc" id="sex"></p>
                        <p class="w20 fl sect2Table di lh70 f14 tc" id="age"></p>
                        <p class="w20 fl sect2Table di lh70 f14 tc" id="career"></p>
                        <p class="w20 fl sect2Table di lh70 f14 tc" id="obstacle"></p>
                    </div>
                </div>
                <h4 class="mt30 f16 mb10">구직자 정보</h4>
                <div class="gujikDetSect3 oh mb30">
                    <div class="oh">
                        <div class="oh cont">
                            <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl bold">메일 주소</p>
                            <p class="fl sect2Table di lh40 f12 tc noMargin pdl20" id="email"></p>
                        </div>
                        <div class="oh cont">
                            <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl bold">연락처</p>
                            <p class="fl sect2Table di lh40 f12 tc noMargin pdl20" id="phone"></p>
                        </div>
                        <div class="oh cont bg_grey">
                            <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl bold">희망 근무 일자</p>
                            <p class="fl sect2Table di lh40 f12 tc noMargin pl10 bg_white workDate" id="workDate"></p>
                        </div>
                        <div class="oh cont">
                            <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl bold">희망 근무 시간</p>
                            <p class="fl sect2Table di lh40 f12 tc noMargin pdl20" id="time"></p>
                        </div>
                        <div class="oh cont">
                            <p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl bold">희망 금액 (일당)</p>
                            <p class="fl sect2Table di lh40 f12 tc noMargin pdl20" ><b class="fc" id="pay"></b>원</p>
                        </div>
                        <div class="oh bb">
                            <p class="fl w100 noMargin sect2head di bg_grey lh40 f14 pl15 tl bold">자기소개</p>
                        </div>
                        <div class="padding sect3Inner tl">
                            <div class="di" id="contents" style="line-height: 20px;"></div>
                        </div>
                    </div>
                </div>
                <div class="tc">
                    <a href="#" id="reviewLink" class="info-review-btn">평가보기</a>
                    <a href="javascript:doGuin()" class="info-guin-btn">채용하기</a>
                </div>
                <div class="botWarn mt30 mb60">
                    <div class="botWarnImg fl"><img src="http://il-bang.com/pc_renewal/images/top_left_logo.png" alt="로고" class="wh95"></div>
                    <div class="botWarnTxt ml25">
                        본 구인정보는 게시자가 제공한 자료이며, (주)엠엠씨피플 일방은 기재된 내용에 대한 오류와 지연에 사용자가 이를 신뢰하여 취한 조치에 대해<br>
                        책임을 지지 않습니다. 본 정보의 저작권은 (주)엠엠씨피플 일방에 있으며, 동의없이 무단개제 및 재배포 할 수 없습니다. 
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            <!-- 두번째 탭 내용 -->
            <div role="tabpanel" class="tab-pane mt10" id="gujikTab2"></div>
            <div role="tabpanel" class="tab-pane mt10" id="gujikTab3"></div>
            <div role="tabpanel" class="tab-pane mt10 container pl20" id="gujikTab4"></div>
        </div>
    </div>
</div>
<script>
    // 파라미터 가져오는 펑션 - 정재            --> 에러나서 주석 처리함
    function getQuerystring(paramName) {
        var _tempUrl = window.location.search.substring(1); //url에서 처음부터 '?'까지 삭제
        var _tempArray = _tempUrl.split('&'); // '&'을 기준으로 분리하기                
          
        if(_tempArray != null && _tempArray != "") {
            for(var i = 0; _tempArray.length; i++) {
                var _keyValuePair = _tempArray[i].split('='); // '=' 을 기준으로 분리하기
              
                if(_keyValuePair[0] == paramName){ // _keyValuePair[0] : 파라미터 명
                    // _keyValuePair[1] : 파라미터 값
                    return _keyValuePair[1];
                }
            }
        }
    }    

    // param 변수에 파라미터값을 저장합니다.
    var param=getQuerystring('tab');
    
    if(param=='1'){
        $(".guingujikTabLi,.tab-pane").removeClass('active')
        $(".guingujikTabLi").eq(0).addClass('active')
        $("#gujikTab1").addClass('active')
    } else if(param=='2'){
        $(".guingujikTabLi,.tab-pane").removeClass('active')
        $(".guingujikTabLi").eq(1).addClass('active')
        $("#gujikTab2").addClass('active')
    } else if(param=='3'){
        $(".guingujikTabLi,.tab-pane").removeClass('active')
        $(".guingujikTabLi").eq(2).addClass('active')
        $("#gujikTab3").addClass('active')
    } else if(param=='4'){
        $(".guingujikTabLi,.tab-pane").removeClass('active')
        $(".guingujikTabLi").eq(3).addClass('active')
        $("#gujikTab4").addClass('active')
    }
</script>
<?php include_once "../../include/footer.php"; ?>