<?php include_once "include/header.php"; ?>
<script>
    $(document).ready(function() {
        var name = "QR" + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(name);
        var val = '';

        if(start != -1) {
            start += name.length;

            var end = cookieData.indexOf(';', start);

            if(end == -1) {
                end  = cookieData.length;
                val = cookieData.substring(start, end);
            }
        }

        if(!val) {
            $("#myQRmodal").modal('show');
        }

        getNotice();
        getEmergencyGuinList(); 
        getRankGuinList();
        randomGuinList();
        getRecentList(1);
        indexGuinCheck2(0);
    });

    function closePopupNotToday(name, val, day) {
        var expire = new Date();

        expire.setDate(expire.getDate() + day);
        cookies = name + '=' + escape(val) + '; path=/ ';

        if(typeof day != "undefined") {
            cookies += '; expires=' + expire.toGMTString() + ';';
        }

        document.cookie = cookies;
        $("#myQRmodal").modal('hide');
    }

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

    function indexGuinCheck2(val) {
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
                            document.getElementById("index_guinCheck2").innerHTML
                            = '<a class="mainLogout bold" href="#" data-toggle="modal" data-target="#guinTabModal">긴급 구인</a>';

                            document.getElementById("index_guinCheck3").innerHTML
                            = '<a href="#" class="border-grey bg_white p5 f11 ml5 br2" data-toggle="modal" data-target="#guinTabModal">긴급 구인 신청하기</a>';

                            document.getElementById("index_guinCheck4").innerHTML
                            = '<a href="#" data-toggle="modal" data-target="#guinTabModal">'
                            + '<span class="f14">긴급 구인</span>'
                            + '</a>';
                        }
                    }
                });
            } else {
                applicationCheck(1);
            }
        }
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

                for(var i=0; i<4; i++) {
                    if(data.listData.length <= i ) continue;

                    if(data.listData[i].img_url == null || data.listData[i].img_url == '' ) {
                        data.listData[i].img_url = 'images/C144x38.png';
                    } else {
                        data.listData[i].img_url = 'guinImage/'+data.listData[i].img_url;
                    }
                    
                    document.getElementById("emergencyGuinListArea1").innerHTML
                    += '<div class="di urgentList pr cp" align="center" onclick=location.href="./guin/view/tab1.php?employNo='+data.listData[i].no+'">' 
                    +  '<a class="di pa plusIcon glyphicon glyphicon-plus f25 bold fc" href="./guin/view/tab1.php?employNo='+data.listData[i].no+'" align="center"></a>'
                    +  '<p class="mt30"><img src="'+data.listData[i].img_url+'" alt="" class="wh144"></p>'
                    +  '<div align="left" class="col-md-offset-1 col-lg-offset-1 mt30">'
                    +  '<h4 class="f_grey bold">'+data.listData[i].company+'</h4>'
                    +  '<p>' + data.listData[i].work_1st_nm + ' > ' + data.listData[i].work_2nd_nm + '</p>'
                    +  '<p><b>지역</b> : ' + data.listData[i].area_1st_nm + '<span> > </span>' + data.listData[i].area_2nd_nm + ' ' + data.listData[i].area_3rd_nm + '</p>'
                    +  '<p><b><span class="fc f16">'+data.listData[i].pay+'</span>원</b>' // 1.32km
                    // +  '<p class="oh mr30 pa rmk-dist"><span class="">1.23</span>km</p>' 
                    +  '</div>' 
                    +  '</div>';
                }
            }
        });
    }
    
    function getRankGuinList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/guin/getRankGuinList.php',
            success: function(data) {
                document.getElementById("vipList").innerHTML = '';
                document.getElementById("platinumList").innerHTML = '';
                document.getElementById("grandList").innerHTML = '';
                document.getElementById("specialList").innerHTML = '';

                //VIP LIST
                if(data.vipList == null) {
                    document.getElementById("vipList").innerHTML = '<div class="bb f16" style="padding: 20px; color: #aaa;">현재 VIP 리스트가 없습니다.</div>';
                } else {
                    for(var i=0; i<data.vipList.length; i++) {
                        document.getElementById("vipList").innerHTML
                        += '<div class="di rmk-vip-list pr cp" align="center">'
                        + '<a class="di pa plusIcon glyphicon glyphicon-plus f25 bold fc" href="./guin/view/tab1.php?employNo=' + data.vipList[i].no + '" align="center"></a>'
                        + '<p class="mt30"><img src="' + data.vipList[i].logo + '" alt="" class="wh144"></p>'
                        + '<div align="left" class="col-md-offset-1 col-lg-offset-1 mt30">'
                        + '<h4 class="f_grey bold" style="margin-bottom: 8px;">' + data.vipList[i].company + '</h4>'
                        + '<p>' + data.vipList[i].work + '</p>'
                        + '<p><span class="bold">지역</span> : ' + data.vipList[i].area + '</p>'
                        + '<p class="f16"><span class="bold fc">' + data.vipList[i].pay + '</span>원</p>'
                        // +  '<p class="oh mr30 pa rmk-dist"><span class="">1.23</span>km</p>' 
                        + '</div>'
                        + '</div>';
                    }
                }

                //PLATINUM LIST
                if(data.platinumList == null) {
                    document.getElementById("platinumList").innerHTML = '<div class="bb f16" style="padding: 20px; color: #aaa;">현재 플래티넘 리스트가 없습니다.</div>';
                } else {
                    for(var i=0; i<data.platinumList.length; i++) {
                        document.getElementById("platinumList").innerHTML
                        += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 border cp rmk-plat-wrap" onclick=location.href="./guin/view/tab1.php?employNo=' + data.platinumList[i].no + '">'
                        // + '<a class="di pa plusIcon-grey2 plusIconPadding bold f_grey" onfocus="this.blur();" href="./guin/view/tab1.php?employNo=' + data.platinumList[i].no + '"></a>'
                        + '<div class="vm mormalLogo fl f16 tc" style="width: 144px; margin-top: 43px;">' + data.platinumList[i].company + '</div>'
                        + '<div class="fl pl30 rmk-plat-info1">'
                        + '<h4 class="f_grey bold">' + data.platinumList[i].title + '</h4>'
                        + '<p class="pt5"><b>담당 업무</b> : '+ data.platinumList[i].business + '</p>'
                        + '<p><span class="ilbangBadge mr5"><b>' + data.platinumList[i].work1 + '</b></span>'
                        + '<span class="mr20">' + data.platinumList[i].work2 + '</span> ' + data.platinumList[i].area + '</p>'
                        + '</div>'
                        + '<div class="rmk-plat-info2 oh tc">'
                        + '<p>' + data.platinumList[i].sex + '<p>'
                        + '<p>' + data.platinumList[i].age + '<p>'
                        + '<p>' + data.platinumList[i].time + '<p>'
                        + '</div>'
                        + '<p class="f16 pa rmk-plat-info3"><span class="bold fc">' + data.platinumList[i].pay + '</span>원</p>'
                        + '</div>';
                    }
                }

                //GRAND LIST
                if(data.grandList == null) {
                    document.getElementById("grandList").innerHTML = '<div class="bb f16" style="padding: 20px; color: #aaa;">현재 그랜드 리스트가 없습니다.</div>';
                } else {
                    for(var i=0; i<data.grandList.length; i++) {
                        document.getElementById("grandList").innerHTML
                        += '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 border cp rmk-plat-wrap" onclick=location.href="./guin/view/tab1.php?employNo=' + data.grandList[i].no + '">'
                        // + '<a class="di pa plusIcon-grey2 plusIconPadding bold f_grey" onfocus="this.blur();" href="./guin/view/tab1.php?employNo=' + data.grandList[i].no + '"></a>'
                        + '<div class="vm mormalLogo fl f16 tc" style="width: 144px; margin-top: 43px;">' + data.grandList[i].company + '</div>'
                        + '<div class="fl pl30 rmk-plat-info1">'
                        + '<h4 class="f_grey bold">' + data.grandList[i].title + '</h4>'
                        + '<p class="pt5"><b>담당 업무</b> : '+ data.grandList[i].business + '</p>'
                        + '<p><span class="ilbangBadge mr5"><b>' + data.grandList[i].work1 + '</b></span>'
                        + '<span class="mr20">' + data.grandList[i].work2 + '</span> ' + data.grandList[i].area + '</p>'
                        + '</div>'
                        + '<div class="rmk-plat-info2 oh tc">'
                        + '<p>' + data.grandList[i].sex + '<p>'
                        + '<p>' + data.grandList[i].age + '<p>'
                        + '<p>' + data.grandList[i].time + '<p>'
                        + '</div>'
                        + '<p class="f16 pa rmk-plat-info3"><span class="bold fc">' + data.grandList[i].pay + '</span>원</p>'
                        + '</div>';
                    }
                }

                //SPECIAL LIST
                if(data.specialList == null) {
                    document.getElementById("specialList").innerHTML = '<div class="bb f16" style="padding: 20px; color: #aaa;">현재 스페셜 리스트가 없습니다.</div>';
                } else {
                    for(var i=0; i<data.specialList.length; i++) {
                        document.getElementById("specialList").innerHTML
                        += '<a href="guin/view/tab1.php?employNo=' + data.specialList[i].no + '">'
                        + '<ul class="oh noPadding bb pdt6">'
                        + '<li class="rmk-special-li1 fl tc oh">'
                        + '<div class="bold mt15 mb20">' + data.specialList[i].area + '</div>'
                        + '</li>'
                        + '<li class="rmk-special-li2 fl" style="line-height: 1;">'
                        + '<div class="mt15 mb20" style="padding-top: 1px;">'
                        + '<span class="ilbangBadge" style="line-height: 15px;"><b>' + data.specialList[i].work + '</b></span>'
                        + '<span class="di text-cut guinDesc margin-verti ml5" style="padding-top: 1px">' + data.specialList[i].business + '</span>'
                        + '</div>'
                        + '</li>'
                        + '<li class="rmk-special-li3 fl tc">'
                        + '<p class="mt15 mb20">' + data.specialList[i].company + '</p>'
                        + '</li>'
                        + '<li class="rmk-special-li4 fl tc">'
                        + '<div class="rmk-pay mt15 mb20">'
                        + '<span class="border-grey payBedge mr5">일당</span>'
                        + '<span>' + data.specialList[i].pay + '원</span>'
                        + '</div>'
                        + '</li>'
                        + '</ul>'
                        + '</a>';
                    }
                }
            }
        });
    }

    function randomGuinList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/guin/randomGuinList.php',
            success: function (data) {
                document.getElementById("randomSpecial").innerHTML
                = '<a class="di oh" href="guin/view/tab1.php?employNo=' + data.specialGuin.no + '" style="width:60%;">'
                + '<span class="ilbangBadge noMargin">스페셜</span>'
                + '<p class="st2-bottom-text fl ml10 text-cut" style="padding-top: 1px;">' + data.specialGuin.title + '</p>'
                + '</a>'
                + '<ul class="di noPadding fr mr20" style="padding-top: 1px !important;">'
                + '<li class="fl f_grey">'
                + '<a href="http://il-bang.com/pc_renewal/guin/view/tab1.php?employNo=' + data.specialGuin.no + '">정보 보기 </a>'
                + '</li>'
                + '<li class="fl f_grey" style="margin:0 5px"> | </li>'
                + '<li class="fl f_grey">'
                + '<a href="' + data.specialGuin.different + '">다른 정보 보기</a>'
                + '</li>'
                + '</ul>';

                document.getElementById("randomGuin").innerHTML
                = '<a href="guin/view/tab1.php?employNo=' + data.randomGuin.no + '">'
                + '<span class="rmk-badge di bold" style="line-height: 1; padding: 3px 8px; margin-right: 7px;">' + data.randomGuin.work + '</span>'
                + '<span class="text-cut di vm" style="padding-bottom: 2px; max-width: 65%;">' + data.randomGuin.title + '</span>'
                + '</a>';
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

    function getRecentList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getRecentList.php',
            data: { page: page },
            success: function(data) {
                document.getElementById("recentList").innerHTML = '<li class="rmk-quick-li tc f14" style="width: 160px; padding: 5px 0;">' + data.title + '</li>';

                if(data.recentList == null) {
                } else {
                    for(var i=0; i<data.recentList.length; i++) {
                        document.getElementById("recentList").innerHTML
                        += '<li class="rmk-quick-li text-cut f12" style="width: 130px;">'
                        + '<a href="' + data.recentList[i].url + '">' + data.recentList[i].title + '</a>'
                        + '</li>';
                    }
                }

                if(data.paging.firstPage == data.paging.page) {
                    document.getElementById("recentPage").innerHTML
                    = '<span class="rmk-left">'
                    + '<img src="images/rmk-pg-left.png" />'
                    + '</span>';
                } else {
                    document.getElementById("recentPage").innerHTML
                    = '<span class="rmk-left" onclick="javascript:getRecentList(' + (page - 1) + ')">'
                    + '<img src="images/rmk-pg-left.png" />'
                    + '</span>';
                }

                document.getElementById("recentPage").innerHTML
                += '<span class="oh" style="margin: 0 8px 0 6px;">'
                + '<span class="rmk-crt bold">' + data.paging.page + '</span>'
                + '<span> / </span>'
                + '<span class="rmk-ttl">' + data.paging.lastPage + '</span>'
                + '</span>';

                if(data.paging.lastPage == data.paging.page) {
                    document.getElementById("recentPage").innerHTML
                    += '<span class="rmk-right">'
                    + '<img src="images/rmk-pg-right.png" />'
                    + '</span>';
                } else {
                    document.getElementById("recentPage").innerHTML
                    += '<span class="rmk-right" onclick="javascript:getRecentList(' + (page + 1) + ')">'
                    + '<img src="images/rmk-pg-right.png" />'
                    + '</span>';
                }
            }
        });
    }
</script>
<!-- Modal -->
<div id="myQRmodal" class="modal fade">
    <div class="modal-dialog" style="width: 670px; margin: 90px auto;">
        <a href="javascript:closeMainPopup();" class="fr mb10" data-dismiss="modal" aria-hidden="true">
            <img src="http://il-bang.com/pc_renewal/images/qrCodeX.png" alt="닫힘" />
        </a>
        <div class="qrModalWrap clear">
            <a href="https://play.google.com/store/apps/details?id=net.saltfactory.il_bang" class="bg_darkdarkgrey fff f12 fr qrModal">구글 스토어 웹으로 확인하기</a>
            <!-- <a href="https://itunes.apple.com/kr/app/ilbang/id1136479101?mt=8" class="bg_darkdarkgrey fff f12 fr qrModal">앱스토어웹으로 확인하기</a> -->
        </div>
        <a href="javascript:closePopupNotToday('QR', 'QR', 1)" style="font-size: 14px;">
            <div class="tr" style="width: 100%; background-color: #fff; padding: 15px;">오늘 하루 그만보기</div>
        </a>
    </div>
</div>
<!-- Modal END! -->
<div class="clear"></div>
<div class="container center wdfull bb pt5 pb5">
    <div class="pg_rp"> 
        <div class="c999 fl pl35">
            <span class="mr5 br15 subNotice">공지</span>
            <span id="adNotice"></span>
        </div>
    </div>
</div>
<div class="clear"></div>    
</div>
<!-- 섹션1 -->
<!-- col-md-10 col-lg-10 -->
<div class="container center pr">
<!-- 퀵배너 -->
    <div class="quick di pa rmk-quick-area">
        <a href="ad/adMoney.php">
            <img src="images/quick.png" alt="" width="100%" class="hidden-xs hidden-md">
        </a>
        <div class="border-grey rmk-quick noPadding mt20 text-center">
            <ul class=" f10 noPadding" id="recentList"></ul>
            <div class="rmk-paging di" id="recentPage"></div>
        </div>
    </div> 
    <div class="sctInner1 oh mt20 mb35">
        <!-- 탭 -->
        <div class="count fl oh top-section1">
            <div class="top-sec-ban1 fl" style="width:55%; margin-right: 1%;">
                <img src="images/remake/top-ban1.png" alt="" width="100%" height="115px"> 
            </div>
            <div class="top-sec-ban2 fl" style="width:44%">
                <img src="images/remake/top-ban2.png" alt="" width="100%" onclick="location.href='https://play.google.com/store/apps/details?id=net.saltfactory.il_bang'">
            </div>
            <div class="top-section1-inner fl w100 mt10 border-top-ilbang oh">
                <div class="sec1-local fl">
                    <div class="sec1-title">
                        <img src="images/remake/sec1-tlt1.png" alt="">
                        <a class='f_grey fr f14 mr15' href="search/guingujik-info-search.php?searchKeyword=전체">전체 보기 ></a>
                    </div>
                    <div class="sec1-cont oh">
                        <ul class="local-detail noPadding oh lh35">
                            <li><a href="search/guingujik-info-search.php?searchKeyword=서울">서울</a></li>
                            <span class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=경기">경기</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=인천">인천</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=강원">강원</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=대전">대전</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=세종">세종</a></li>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=충남">충남</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=충북">충북</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=부산">부산</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=울산">울산</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=경남">경남</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=경북">경북</a></li>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=대구">대구</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=광주">광주</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=전남">전남</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=전북">전북</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=제주">제주</a></li>
                            <span  class="fl rmk-dot">・</span>
                            <li><a href="search/guingujik-info-search.php?searchKeyword=전체">전체</a></li>
                        </ul>
                    </div>
                    <div>
                        <ul class="sec1-cont-btn lh30 noPadding oh noMargin">
                            <li class="sec1-btn col-md-4 col-lg-4 tc vm cp">
                                <img src="images/remake/sec1-btn1.png" alt="" class="di">
                                <a href="ad/cost-info.php">
                                    <span class="f14">서비스 안내</span>
                                </a>
                            </li>
                            <li class="sec1-btn col-md-4 col-lg-4 tc vm cp">
                                <img src="images/remake/sec1-btn2.png" alt="" class="di">
                                <span id="index_guinCheck4">
                                    <a href="javascript:indexGuinCheck2(1)">
                                        <span class="f14">긴급 구인</span>
                                    </a>
                                </span>
                            </li>
                            <li class="sec1-btn col-md-4 col-lg-4 tc vm cp">
                                <img src="images/remake/sec1-btn3.png" alt="" class="di">
                                <a href="ad/cooperation.php">
                                    <span class="f14">업무 제휴</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="sec1-reccomend fl h100">
                    <div class="sec2-title">
                        <img src="images/remake/sec1-tlt2.png" alt="">
                        <a class='f_grey fr f14 mr15' href="search/guingujik-info-search.php?searchKeyword=일방">전체 보기 ></a>
                    </div>
                    <div class="sec2-cont">
                        <div class="cate-detail item">
                            <!-- 캐러셀 -->
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item active">
                                    <div class="rmk-category noPadding">
                                        <ul class="oh noPadding">
                                            <li class="fl">
                                                <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=물류" class="">
                                                    <img src="images/remake/sec2-icon1.png" alt="...">
                                                    <span>물류 일방</span>
                                                </a>
                                            </li>
                                            <li class="fl">
                                                <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=유통" class="">
                                                    <img src="images/remake/sec2-icon1_1.png" alt="...">
                                                    <span>유통 일방</span>
                                                </a>
                                            </li>
                                            <li class="fl">
                                                <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=건설" class="">
                                                    <img src="images/remake/sec2-icon2.png" alt="...">
                                                    <span>건설 일방</span>
                                                </a>
                                            </li>
                                            <li class="fl">
                                                <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=생산" class="">
                                                    <img src="images/remake/sec2-icon5.png" alt="...">
                                                    <span>생산 일방</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="" style="width:80%; margin:25px auto 0">
                                        <ul class="noPadding oh">
                                            <li class="fl">
                                                <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=서비스" class="">
                                                    <img src="images/remake/sec2-icon4.png" alt="...">
                                                    <span>서비스 일방</span>
                                                </a>
                                            </li>
                                            <li  class="fl"></li>
                                            <li  class="fl"></li>
                                            <li  class="fl"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                <span class="rmk-carousel-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                <span class="rmk-carousel-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!-- 캐러셀 -->
                        <script>
                            $('.carousel').carousel({
                                wrap : boolean
                            })
                        </script>
                    </div>
                    <div class="sect2-bottom" style="border-top: 1px solid #ddd; padding: 9px 0 0 12px;" id="randomSpecial"></div> 
                </div>
            </div>
        </div>
    </div>
    <div class="tabWrap tabWrap1 fl rmk-loginTab oh">
        <div class="login-main">
            <?php if($uid == "") { ?>
                <ul class="nav nav-tabs nav-tabs-remake" role="tablist" id="myTab">
                    <li role="presentation" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 noPadding text-center active">
                        <a href="#topTab1" aria-controls="topTab1" role="tab" data-toggle="tab" class="no-border-left">기업 회원</a>
                    </li>
                    <li class="col-xs-4 col-sm-4 col-md-4 col-lg-4 noPadding text-center" role="presentation">
                        <a href="#topTab2" aria-controls="topTab2" role="tab" data-toggle="tab">일반 회원</a>
                    </li>
                    <li class="col-xs-4 col-sm-4 col-md-4 col-lg-4 noPadding text-center" role="presentation">
                        <a href="#topTab3" aria-controls="topTab3" role="tab" data-toggle="tab" class="no-border-right">지점</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- 첫번째 탭 내용 -->
                    <!-- 로그인시 -->
                    <div role="tabpanel" class="tab-pane active mt20 p10 mloginTab" id="topTab1">
                        <form class="oh" action="log/memberCheck.php" method="post" onsubmit="return loginCheck(0)">
                            <input type="hidden" name="loginType" value="company" />
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 rmk-login-area">
                                <input type="hidden" name="url" value="<?php echo $url; ?>" />
                                <input type="text" class="loginInput mb2 pl5" id="company_id" name="user_id" />
                                <input type="password" class="loginInput pl5" id="company_passwd" name="user_passwd" />
                            </div>                
                            <input type="submit" class="btn btn-danger col-xs-3 col-sm-3 col-md-3 col-lg-3" style="height: 60px" value="로그인" />
                        </form>
                        <ul class="oh w100 f11 rmk-find">
                            <li class="fl">
                                <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=1">아이디 찾기</a>
                                <span class="margin-horizontal">|</span>
                            </li>
                            <li class="fl">
                                <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=2">비밀번호 찾기</a>
                                <span class="margin-horizontal">|</span>
                            </li>
                            <li class="fl">
                                <a href="signup/step1.php">회원가입</a>
                            </li>
                        </ul>
                    </div>
                    <div class="clear"></div>          
                    <!-- 두번째 탭 내용 -->
                    <div role="tabpanel" class="tab-pane mt20 p10 mloginTab" id="topTab2">
                        <form action="log/memberCheck.php" method="post" onsubmit="return loginCheck(1)">
                            <input type="hidden" name="loginType" value="general" />
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 rmk-login-area">
                                <input type="hidden" name="url" value="<?php echo $url; ?>" />
                                <input type="text" class="loginInput mb2 pl5" id="general_id" name="user_id" />
                                <input type="password" class="loginInput pl5" id="general_passwd" name="user_passwd" />
                            </div>              
                            <input type="submit" class="btn btn-danger col-xs-3 col-sm-3 col-md-3 col-lg-3" style="height: 60px" value="로그인" />
                        </form>
                        <ul class="oh w100 f11 rmk-find">
                            <li class="fl">
                                <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=1">아이디 찾기</a>
                                <span class="margin-horizontal">|</span>
                            </li>
                            <li class="fl">
                                <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=2">비밀번호 찾기</a>
                                <span class="margin-horizontal">|</span>
                            </li>
                            <li class="fl">
                                <a href="signup/step1.php">회원가입</a>
                            </li>
                        </ul>
                    </div>
                    <div role="tabpanel" class="tab-pane mt20 p10 mloginTab" id="topTab3">
                        <form action="log/memberCheck.php" method="post" onsubmit="return loginCheck(2)">
                            <input type="hidden" name="loginType" value="jijeom" />
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 rmk-login-area">
                                <input type="hidden" name="url" value="<?php echo $url; ?>" />
                                <input type="text" class="loginInput mb2 pl5" id="jijeom_id" name="user_id" />
                                <input type="password" class="loginInput pl5" id="jijeom_passwd" name="user_passwd" />
                            </div>              
                            <input type="submit" class="btn btn-danger col-xs-3 col-sm-3 col-md-3 col-lg-3" style="height: 60px" value="로그인" />
                        </form>
                        <ul class="oh w100 f11 rmk-find">
                            <li class="fl">
                                <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=1">아이디 찾기</a>
                                <span class="margin-horizontal">|</span>
                            </li>
                            <li class="fl">
                                <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=2">비밀번호 찾기</a>
                                <span class="margin-horizontal">|</span>
                            </li>
                            <li class="fl">
                                <a href="signup/step1.php">회원가입</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <?php } else { ?>
                <div class="logoutWrap" id="logoutWrap">
                    <div class="tc">
                        <div class="di mr20 tc di">
                            <strong><?php echo $uid; ?>님</strong>
                        </div>                
                        <a href="log/logout.php" class="logoutBtn tc border-grey di" style="height: 30px; margin-top: 16px">로그아웃</a>
                    </div> 
                    <hr style="margin:20px 0 0">  
                    <div class="w100 oh tc mt5 padding-vertical">
                        <a class="mainLogout bold" href="ad/adProposal.php">광고 신청</a>
                        <span class="margin-horizontal">|</span>
                        <span id="index_guinCheck2">
                            <a class="mainLogout bold" href="javascript:indexGuinCheck2(1);">긴급 구인</a>
                        </span>
                        <span class="margin-horizontal">|</span>
                        <?php if($kind == "general") { ?>
                        <a class="mainLogout bold" href="my-page/myInfo-general.php">마이 페이지</a>
                        <?php } else { ?>
                        <a class="mainLogout bold" href="my-page/myInfo-comp.php">마이 페이지</a>
                        <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="rmk_notice padding-horizontal" id="randomGuin"></div>
            </div>
            <div>
              <a href="http://tshome.co.kr/" class="oh">
                  <img src="images/remake/ts-main-ban.png" alt="" width="25%" height="108.2px" class="mt5">
              </a>
            </div>
        </div>
        <script>
            function loginCheck(val) {
                if(val == 0) {
                    var id = document.getElementById("company_id").value;
                    var pwd = document.getElementById("company_passwd").value;
                } else if(val == 1) {
                    var id = document.getElementById("general_id").value;
                    var pwd = document.getElementById("general_passwd").value;
                } else if(val == 2) {
                    var id = document.getElementById("jijeom_id").value;
                    var pwd = document.getElementById("jijeom_passwd").value;
                }

                if(id == "") {
                    alert("아이디를 입력해주세요.");
                    return false;
                } else if(pwd == "") {
                    alert("비밀번호를 입력해주세요.");
                    return false;
                }

                return true;
            }
        </script>
        <!-- 배너 스와이퍼 -->
        <div class="container-fluid bg_darkgrey mt50 vm mb35" style="height: 70px; border:2px solid #efefef">
            <div class="midBanner center mt20"> 
                <div class="tc">
                    <img class="di center" src="images/mainLogo1.png" alt="">
                </div>
                <div class="tc">
                    <img class="di center" src="images/mainLogo2.png" alt="">  
                </div>
                <div class="tc">
                    <img class="di center" src="images/mainLogo3.png" alt="">  
                </div>
                <div class="tc">
                    <img class="di center" src="images/mainLogo4.png" alt="">  
                </div>
                <div class="tc">
                    <img class="di center" src="images/mainLogo5.png" alt="">  
                </div>
                <div class="tc">
                    <img class="di center" src="images/mainLogo6.png" alt="">  
                </div>
                <div class="tc">
                    <img class="di center" src="images/mainLogo7.png" alt="">  
                </div>
                <div class="tc">
                    <img class="di center" src="images/mainLogo8.png" alt="">  
                </div>
            </div>
        </div>    
        <script>
            $(document).ready(function(){
                $('.midBanner').slick({
                    slidesToShow: 5,
                    slidesToScroll: 2,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    centerMode:true,
                });
            });
        </script>
        <!-- 긴급구인 -->
        <div class="container center">    
            <h5 class="fl bold mb10 mt10">
                <img src="images/search-icon.png" alt="">긴급 구인
            </h5>
            <p class="fr f12">* 신청시 바로 매칭 서비스를 받으실 수 있습니다.
                <span id="index_guinCheck3">                    
                    <a href="javascript:indexGuinCheck2(1)" class="bg_white p5 f11 ml5 br2">
                        <img src="images/remake/rmk-emergency.png" alt=""> 
                    </a>
                </span>
            </p>
            <div class="clear"></div>
            <div class="urgentWrap mb10" id="emergencyGuinListArea1"></div>
            <div class="guinWrap">
                <a href="itemShop/itemshop.php" class="di urgentListIndex pr" align="center">
                    <img src="images/emergencyBanner01.png" style="height: 200px;" />
                </a>
                <a href="ad/adMoney.php" class="di urgentListIndex pr" align="center">
                    <img src="images/emergencyBanner02.png" style="height: 200px;" />
                </a>
            </div>
        </div>
        <div class="container center mt20">    
            <h5 class="mb10 mt10 di">
                <img src="images/search-icon.png" alt="">
                <span class="bold">VIP 채용 정보</span>
            </h5>
            <p class="fr f12">* 다양한 상품을 사용해 보세요.
                <a href="itemShop/itemshop.php" class="bg_white p5 f11 ml5 br2 di">
                    <img class="vm" src="images/remake/rmk-itemshop.png" alt=""> 
                </a>
            </p>
            <div class="clear" style="overflow: hidden;"></div>
            <div class="vipWrap mb10" id="vipList"></div>
        </div>
    </div>
</div>
<!-- 플래티넘 -->
<div class="container center mt30 mb35">      
    <h5 class="fl bold mb10 mt15">
        <img src="images/search-icon.png" alt="">플래티넘 채용 정보
    </h5>
    <p class="fr f12">* 다양한 상품을 사용해 보세요.
        <a href="itemShop/itemshop.php" class="bg_white p5 f11 ml5 br2 di">
            <img class="vm" src="images/remake/rmk-itemshop.png" alt=""> 
        </a>
    </p>
    <div class="clear"></div>
    <div class="platinumWrap oh pr" id="platinumList"></div>
</div>
<!-- 그랜드 -->
<div class="container center mt30 mb35">      
    <h5 class="fl bold mb10 mt15">
        <img src="images/search-icon.png" alt="">그랜드 채용 정보
    </h5>
    <p class="fr f12">* 다양한 상품을 사용해 보세요.
        <a href="itemShop/itemshop.php" class="bg_white p5 f11 ml5 br2 di">
            <img class="vm" src="images/remake/rmk-itemshop.png" alt=""> 
        </a>
    </p>
    <div class="clear"></div>
    <div class="grandWrap" id="grandList"></div>
</div>  
<!-- 스페셜구인 -->
<div class="container center mt30 mb35 special">      
    <h5 class="fl bold mb10 mt15">
        <img src="images/search-icon.png" alt="">스페셜 채용 정보
    </h5>
    <p class="fr f12">* 다양한 상품을 사용해 보세요.
        <a href="itemShop/itemshop.php" class="bg_white p5 f11 ml5 br2 di">
            <img class="vm" src="images/remake/rmk-itemshop.png" alt=""> 
        </a>
    </p>
    <div class="clear"></div>
    <!-- 스페셜 채용정보 내용 -->
    <div class="bt2 oh w100 guinInfo">
        <div id="specialList"></div>
    </div>
</div>  
<script>
    $(document).ready(function() {
        /* quick menu */
        $(".quick").animate( { "top": $(document).scrollTop() + 20 +"px" }, 500 ); // 빼도 된다.
        
        $(window).scroll(function() {
            $(".quick").stop();
            $(".quick").animate( { "top": $(document).scrollTop() + 20 + "px" }, 500 );
        });
    });

    function specialMove() {
        var offset = $("#specialList").offset();

        $('html, body').animate({scrollTop : offset.top}, 400);
    }
</script>
<?php include_once "include/footer.php"; ?>