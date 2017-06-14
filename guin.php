<?php
    include_once "include/header.php";
    include_once "db/connect.php";
?>
<script>
    $(document).ready(function() {
        getNotice();
        getGujikCounter();
        guinCheck(0);
    });

    function getNotice() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/notice/getNoticeList.php',
            success: function(data) {
                for(var i=0; i<1; i++) {
                    document.getElementById("adNotice").innerHTML
                    = '<a href="notice/view.php?no=' + data.noticeList[i].no + '" class="c999">' + data.noticeList[i].title + '</a>';
                }
            }
        });
    }
    
    function getGujikCounter() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/gujik/getGujikCounter.php',
            success: function (data) {
                new numberCounter("newEmploy", data.listData[0].newEmploy);
                new numberCounter("allEmploy", data.listData[0].allEmploy);
                new numberCounter("newMatching", data.listData[0].newMatching);
                new numberCounter("allMatching", data.listData[0].allMatching);
            }
        });
    }

    function numberCounter(target_frame, target_number) {
        this.count = 0;
        this.diff = 0;
        this.target_count = parseInt(target_number);
        this.target_frame = document.getElementById(target_frame);
        this.timer = null;
        
        this.counter();
    }
  
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
                    url: 'ajax/guin/guinCheck.php',
                    success: function(data) {
                        if(data == 0) {
                            document.getElementById("guinCheck1").innerHTML
                            = '<a href="#" class="gujikCount count5 fl tc f14 f_white" style="background-color: black" data-toggle="modal" data-target="#guinTabModal">'
                            + '<span class="glyphicon glyphicon-plus f22"></span>'
                            + '<p class="margin-vertical">채용 공고 작성</p>'
                            + '</a>';

                            document.getElementById("guinCheck2").innerHTML
                            = '<a href="#" class="f12 underline" data-toggle="modal" data-target="#guinTabModal">채용 공고 등록</a>'
                            + '<span class="margin-horizontal">|</span>'
                            + '<a href="#" data-toggle="modal" data-target="#guinTabModal" class="f12 underline">긴급 구인 등록</a>'
                            + '</a>';

                            document.getElementById("guinCheck3").innerHTML = '<a href="#" class="formWriteBtn f12 f_white" data-toggle="modal" data-target="#guinTabModal">채용 공고 작성</a>';
                        }
                    }
                });
            } else {
                applicationCheck(1);
            }
        }
    }
</script>
<div class="wdfull">
    <div class="container center wdfull bb mb15">
        <div class="pg_rp"> 
            <div class="c999 fl subTitle">
                <a href="index.php" class="c999">HOME</a>
                <span class="plr5">></span>
                <a href="guin.php" class="bold">구인자</a>
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
                    <img src="images/ggQuick1.png" alt="" class="db"> 
                </a>
                <a href="javascript:alert('로그인 후 이용해주세요.')">
                    <img src="images/ggQuick2.png" alt="" class="db"> 
                </a>
                <?php } else if($kind == "general") { ?>
                <a href="my-page/myInfo-general.php">
                    <img src="images/ggQuick1.png" alt="" class="db">
                </a>
                <a href="gujik.php?tab=2">
                    <img src="images/ggQuick2.png" alt="" class="db">
                </a>
                <?php } else { ?>
                <a href="my-page/myInfo-comp.php">
                    <img src="images/ggQuick1.png" alt="" class="db">
                </a>
                <a href="guin.php?tab=2">
                    <img src="images/ggQuick2.png" alt="" class="db">
                </a>
                <?php } ?>
                <a href="itemShop/itemshop.php">
                    <img src="images/ggQuick3.png" alt="" class="db"> 
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
        <a href="ad/adMoney.php" class="linkImg di w100" style="height: 105px;"></a>
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
        <span id="guinCheck1">
            <a href="#" class="gujikCount count5 fl tc f14 f_white" style="background-color: black" onclick="guinCheck(1); return false;">
            <span class="glyphicon glyphicon-plus f22"></span>
                <p class="margin-vertical">채용 공고 작성</p>
            </a>
        </span>
    </div>    
</div>
<div class="wdfull">
    <div class="guingujikTabWrap fl">
        <ul class="nav nav-tabs mt10" role="tablist" id="myTab">
            <li role="presentation" class="noPadding guingujikTabLi text-center active"><a href="#guingujikTab1" aria-controls="guingujikTab1" role="tab" data-toggle="tab">전체</a></li>
            <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="#guingujikTab2" aria-controls="guingujikTab2" role="tab" data-toggle="tab">나의 채용 공고</a></li>
            <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="#guingujikTab3" aria-controls="guingujikTab3" role="tab" data-toggle="tab">매칭 리스트</a></li>
            <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="#guingujikTab4" aria-controls="guingujikTab4" role="tab" data-toggle="tab">매칭 완료</a></li>
        </ul>
        <div class="tab-content container">
            <!-- 첫번째 탭 내용 -->
            <div role="tabpanel" class="tab-pane active mt10 container pl30" id="guingujikTab1">
                <?php include_once "guin/list/guinTab1.php" ?>
            </div>
            <!-- 두번째 탭 내용 -->
            <div role="tabpanel" class="tab-pane mt10 container pl30" id="guingujikTab2">
                <?php include_once "guin/list/guinTab2.php" ?>
            </div>
            <div role="tabpanel" class="tab-pane mt10 container pl30" id="guingujikTab3">
                <?php include_once "guin/list/guinTab3.php" ?>
            </div>
            <div role="tabpanel" class="tab-pane mt10 container pl30" id="guingujikTab4">
                <?php include_once "guin/list/guinTab4.php" ?>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<script>
    // 구인
    $(".guin_local a").each(function(i) {
        $(this).click(function() {
            $("#botTab1 > ul > li > a"  ).removeClass("active-btn")    ;
            $(".guinLocal2").hide()
            $(".guin_local a").removeClass("active-btn");
            $(this).addClass("active-btn");
            $(".guinLocal1").show();
        });
    });

    $(".guinLocal1").each(function() {
        $(".guinLocal1").click(function() {
            $(".guinLocal2").css('display','block');
        });
    });

    $(".guinLocal2").each(function(i) {
        $(this).click(function() {
        });
    });
        
    $(document).on('click','.guinLocal1 a',function() {
        $(".guinLocal1 a").removeClass("active-btn2");
        $(this).addClass("active-btn2");
    });

    $(document).on('click','.guinLocal2 a',function(){
        $(".guinLocal2 a").removeClass("active-btn2");
        $(this).addClass("active-btn2");
    });

    // 구직
    $(".gujik_local a").each(function(i) {
        $(this).click(function() {
            $(".gujikLocal2").hide()
            $(".gujik_local a").removeClass("active-btn");
            $(this).addClass("active-btn");
            $(".gujikLocal1").show();
        });
    });

    $(".gujikLocal1").each(function() {
        $(".gujikLocal1").click(function() {
            $(".gujikLocal2").css('display','block');
        });
    });

    $(".gujikLocal2").each(function(i) {
        $(this).click(function() {
        });
    });
      
    $(document).on('click','.gujikLocal1 a',function() {
        $(".gujikLocal1 a").removeClass("active-btn2");
        $(this).addClass("active-btn2");
    });

    $(document).on('click','.gujikLocal2 a',function() {
        $(".gujikLocal2 a").removeClass("active-btn2");
        $(this).addClass("active-btn2");
    });

    // 파라미터 가져오는 펑션 - 정재
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

    if(param=='1') {
        $(".guingujikTabLi,.tab-pane").removeClass('active');
        $(".guingujikTabLi").eq(0).addClass('active');
        $("#guingujikTab1").addClass('active');
    } else if(param=='2') {
        $(".guingujikTabLi,.tab-pane").removeClass('active');
        $(".guingujikTabLi").eq(1).addClass('active');
        $("#guingujikTab2").addClass('active');
    } else if(param=='3') {
        $(".guingujikTabLi,.tab-pane").removeClass('active');
        $(".guingujikTabLi").eq(2).addClass('active');
        $("#guingujikTab3").addClass('active');
    } else if(param=='4'){
        $(".guingujikTabLi,.tab-pane").removeClass('active');
        $(".guingujikTabLi").eq(3).addClass('active');
        $("#guingujikTab4").addClass('active');
    }
</script>
<?php include_once "include/footer.php"; ?>