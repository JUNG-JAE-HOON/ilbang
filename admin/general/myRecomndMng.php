<?php include_once "../include/session.php"; ?>
<link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/jquery.rateyo.min.css"> 
<script type="text/javascript" src="http://il-bang.com/pc_renewal/js/jquery.rateyo.min.js"></script>
<script>
    $(document).ready(function() {
        getRecomndList(1);
    });

    function getRecomndList(page) {
        var id = "<?php echo $uid; ?>";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/admin/getRecomndList.php',
            data: { page: page },
            success: function(data) {
                document.getElementById("recomndList").innerHTML = '';

                if(id == "") {
                    document.getElementById("recomndList").innerHTML = '<div class="f16 tc c666" style="padding-top: 80px;">로그인 해주시기 바랍니다.</div>';
                } else if(data.recomndList == null) {
                    document.getElementById("recomndList").innerHTML = '<div class="f16 tc c666" style="padding-top: 80px;">나를 추천인으로 등록한 사람이 없습니다.</div>';
                } else {
                    for(var i=0; i<data.recomndList.length; i++) {
                        document.getElementById("recomndList").innerHTML
                        += '<div class="bb f12 oh userList" style="padding: 10px;">'
                        + '<span class="di tc fl">' + data.recomndList[i].no + '</span>'
                        + '<span class="di tc fl">' + data.recomndList[i].uid + '</span>'
                        + '<span class="di tc fl">' + data.recomndList[i].name + '</span>'
                        + '<span class="di tc fl">' + data.recomndList[i].phone + '</span>'
                        + '<span class="di tc fl">' + data.recomndList[i].visit + '회</span>'
                        + '<span class="di tc fl"><a href="" id="resume' + data.recomndList[i].no + '">' + data.recomndList[i].resumeCnt + '건</a></span>'
                        + '<span class="di tc fl"><a href="" id="matchingFinish' + data.recomndList[i].no + '">' + data.recomndList[i].matchingFinishCnt + '건</a></span>'
                        + '<span class="di tc fl">' + data.recomndList[i].date + '</span>'
                        + '</div>';

                        var resumeNo = "resume" + data.recomndList[i].no;
                        var matchingFinishNo = "matchingFinish" + data.recomndList[i].no;

                        if(data.recomndList[i].resumeCnt != 0) {
                            document.getElementById(resumeNo).classList.add('underline');
                            document.getElementById(resumeNo).href = "javascript:getResumeList(1, '" + data.recomndList[i].uid + "')";
                        } else {
                            document.getElementById(resumeNo).href = "javascript:void(0)";
                        }

                        if(data.recomndList[i].matchingFinishCnt != 0) {
                            document.getElementById(matchingFinishNo).classList.add('underline');
                            document.getElementById(matchingFinishNo).href = "javascript:getMatchingList(1, '" + data.recomndList[i].uid + "', 'general')";
                        } else {
                            document.getElementById(matchingFinishNo).href = "javascript:void(0)";
                        }
                    }

                    document.getElementById("recomndGeneralPage").innerHTML = '';

                    if(data.paging.currentSection != 1) {
                        document.getElementById("recomndGeneralPage").innerHTML = '<li><a href="javascript:getRecomndList(' + data.paging.prevPage + ')">이전</a></li>';
                    }                            

                    for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                        if(i == data.paging.page) {                        
                            document.getElementById("recomndGeneralPage").innerHTML += '<li class="active"><a href="javascript:getRecomndList(' + i + ')">' + i + '</a></li>';
                        } else {
                            document.getElementById("recomndGeneralPage").innerHTML += '<li><a href="javascript:getRecomndList(' + i + ')">' + i + '</a></li>';
                        }
                    }

                    if (data.paging.currentSection != data.paging.allSection) {
                        document.getElementById("recomndGeneralPage").innerHTML += '<li><a href="javascript:getRecomndList(' + data.paging.nextPage + ')">다음</a></li>';
                    }
                }
            }
        });
    }

    function getResumeList(page, id) {
        document.getElementById("modalTitle").innerHTML = id + '님의 이력서';
        document.getElementById("li1").innerHTML = '등록일 / 공개 여부';
        document.getElementById("li2").innerHTML = '이력서 제목';
        document.getElementById("li3").innerHTML = '열람';
        document.getElementById("li4").innerHTML = '매칭 건수';
        document.getElementById("backImg").href = "javascript:getResumeList(" + page + ", '" + id + "')";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/member/getResumeList.php',
            data: { page: page, uid: id },
            success: function(data) {
                document.getElementById("contentSubList").style.display = 'none';
                document.getElementById("backImg").style.display = 'none';
                document.getElementById("contentList").style.display = 'block';
                document.getElementById("parentContent").style.display = 'block';
                document.getElementById("paging").style.display = 'block';
                document.getElementById("contentList").innerHTML = '';

                for(var i=0; i<data.resumeList.length; i++) {
                    document.getElementById("contentList").innerHTML
                    += '<div class="bb oh" style="padding: 15px 0;">'
                    +       '<div class="fl" style="width: 170px;">'
                    +           '<div class="f16 bold mb5">' + data.resumeList[i].delegate + '</div>'
                    +           '<span class="f14">' + data.resumeList[i].wdate + '</span>'
                    +           '<span class="fc underline ml5" id="open' + data.resumeList[i].no + '">' + data.resumeList[i].open + '</span>'
                    +       '</div>'
                    +       '<div class="fl tl oh" style="width: 540px; line-height: 1;">'
                    +           '<div class="f16 bold" style="margin-bottom: 12px;">' + data.resumeList[i].title + '</div>'
                    +           '<div class="mr5 fc f12 ilbangBadge fl mb10">' + data.resumeList[i].work2 + '</div>'
                    +           '<div class="f12 c777 fl mb10" style="margin-top: 1px;">희망 지역 : ' + data.resumeList[i].area1 + ' > ' + data.resumeList[i].area2 + '</div>'
                    +           '<div class="clear c999 f12 mr10 fl" style="margin-top: 2px;">경력 : ' + data.resumeList[i].career + '</div>'
                    +           '<div class="hopeIldangBadge fl f12 lh1">일당</div>'
                    +           '<div class="f12 fl" style="margin-top: 2px;">' + data.resumeList[i].pay + '원</div>'
                    +       '</div>'
                    +       '<div class="fl oh" style="width: 120px;">'
                    +           '<a href="javascript:getResumeData(' + data.resumeList[i].no + ')">'
                    +               '<div class="di direct sm-btn3 f12" style="line-height: 1; margin-top: 23px; padding: 3px 6px;">열람하기</div>'
                    +           '</a>'
                    +       '</div>'
                    +       '<div class="fl" style="width: 120px;">'
                    +           '<div class="mt25" style="line-height: 1;"><span class="fc underline">' + data.resumeList[i].matching + '</span>건</div>'
                    +       '</div>'
                    +    '</div>';

                    if(data.resumeList[i].open == "비공개") {
                        var open = "open" + data.resumeList[i].no;
                        
                        document.getElementById(open).style.color = "#666";
                    }
                }

                document.getElementById("contentPage").innerHTML = '';

                if(data.paging.currentSection != 1) {
                    document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getResumeList(' + data.paging.prevPage + ', ' + '\'' + id + '\'' + ')">이전</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("contentPage").innerHTML += '<li class="active"><a href="javascript:getResumeList(' + i + ', ' + '\'' + id + '\'' + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getResumeList(' + i + ', ' + '\'' + id + '\'' + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getResumeList(' + data.paging.nextPage + ', ' + '\'' + id + '\'' + ')">다음</a></li>';
                }
            }
        });

        $("#recomndModal").modal('show');
    }

    function getResumeData(no) {
        document.getElementById("backImg").style.display = 'block';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/admin/getResumeData.php',
            data: { no: no },
            success: function(data) {
                getGeneralCSS();

                document.getElementById("modalTitle").innerHTML += ' 보기';
                document.getElementById("parentContent").style.display = 'none';
                document.getElementById("paging").style.display = 'none';
                document.getElementById("contentList").style.display = 'none';

                document.getElementById("title").innerHTML = data.resumeList.title;
                document.getElementById("logoImg").src = data.resumeList.imgUrl;
                document.getElementById("subBlock1").innerHTML
                = '<div class="fl bold tl bb" style="width: 100px; padding: 10px 0;">이름</div>'
                + '<div class="fl bb tl" style="width: 696px; padding: 10px 0;">' + data.resumeList.name + '</div>'
                + '<div class="clear fl bold tl bb" style="width: 100px; padding: 10px 0;">생년월일</div>'
                + '<div class="fl tl bb" style="width: 696px; padding: 10px 0;">' + data.resumeList.birth + '</div>'
                + '<div class="clear fl bold tl" style="width: 100px; padding: 10px 0;">희망 근무지</div>'
                + '<div class="fl tl" style="width: 696px; padding: 10px 0;">' + data.resumeList.addr + '</div>';

                document.getElementById("subBlock2").innerHTML
                = '<div class="f16 tl bold mb5">희망 조건 및 구직자 정보</div>'
                + '<div class="bd-left2 oh" style="border-top: 3px solid #2a3243;">'
                + '<div class="bg_eee fl" style="width: 189px; border-right: 1px solid #ddd; padding: 10px 0;">희망 직종</div>'
                + '<div class="bg_eee fl" style="width: 190px; border-right: 1px solid #ddd; padding: 10px 0;">성별</div>'
                + '<div class="bg_eee fl" style="width: 190px; border-right: 1px solid #ddd; padding: 10px 0;">나이</div>'
                + '<div class="bg_eee fl" style="width: 190px; border-right: 1px solid #ddd; padding: 10px 0;">경력</div>'
                + '<div class="bg_eee fl" style="width: 189px; padding: 10px 0;">장애 여부</div>'
                + '<div class="fl" style="width: 189px; border-right: 1px solid #ddd; padding: 30px 0;">' + data.resumeList.work + '</div>'
                + '<div class="fl" style="width: 190px; border-right: 1px solid #ddd; padding: 30px 0;">' + data.resumeList.sex + '</div>'
                + '<div class="fl" style="width: 190px; border-right: 1px solid #ddd; padding: 30px 0;">' + data.resumeList.age + '</div>'
                + '<div class="fl" style="width: 190px; border-right: 1px solid #ddd; padding: 30px 0;">' + data.resumeList.career + '</div>'
                + '<div class="fl" style="width: 189px; padding: 30px 0;">' + data.resumeList.obstacle + '</div>'
                + '</div>';

                document.getElementById("subBlock3").innerHTML
                = '<div class="f16 tl bold mb5">구직자 정보</div>'
                + '<div class="gujikDetSect3 oh">'
                + '<div class="oh cont">'
                + '<div class="di w20 noMargin sect2head bg_grey lh40 f14 pl15 tl bold">메일 주소</div>'
                + '<div class="sect2Table di lh40 f12 tc noMargin pdl20">' + data.resumeList.email + '</div>'
                + '</div>'
                + '<div class="oh cont">'
                + '<div class="di w20 noMargin sect2head bg_grey lh40 f14 pl15 tl bold">연락처</div>'
                + '<div class="sect2Table di lh40 f12 tc noMargin pdl20">' + data.resumeList.phone + '</div>'
                + '</div>'
                + '<div class="oh cont bg_grey">'
                + '<div class="di w20 noMargin sect2head bg_grey lh40 f14 pl15 tl bold" style="width: 150px;">희망 근무 일자</div>'
                + '<div class="di sect2Table lh40 f12 tc noMargin pl15 bg_white workDate">' + data.resumeList.date + '</div>'
                + '</div>'
                + '<div class="oh cont">'
                + '<div class="di w20 noMargin sect2head bg_grey lh40 f14 pl15 tl bold">희망 근무 시간</div>'
                + '<div class="sect2Table di lh40 f12 tc noMargin pdl20">' + data.resumeList.time + '</div>'
                + '</div>'
                + '<div class="oh cont">'
                + '<div class="di w20 noMargin sect2head bg_grey lh40 f14 pl15 tl bold">희망 금액 (일당)</div>'
                + '<div class="sect2Table di lh40 f12 tc noMargin pdl20">&#8361; <span class="fc">' + data.resumeList.pay + '</span></div>'
                + '</div>'
                + '<div class="oh">'
                + '<div class="di w20 noMargin sect2head bg_grey lh40 f14 pl15 tl bold">자기 소개</div>'
                + '<div class="sect2Table di lh40 f12 tc noMargin pdl20">' + data.resumeList.content + '</div>'
                + '</div">'
                + '</div>';

                document.getElementById("contentSubList").style.display = 'block';
            }
        });
    }

    function getMatchingList(page, id, type) {
        document.getElementById("modalTitle").innerHTML = id + '님의 매칭 완료 목록';
        document.getElementById("li1").innerHTML = '회사 위치';
        document.getElementById("li2").innerHTML = '채용 내용';
        document.getElementById("li3").innerHTML = '근무 조건';
        document.getElementById("li4").innerHTML = '열람 및 평가';
        document.getElementById("backImg").href = "javascript:getMatchingList(" + page + ", '" + id + "', '" + type + "')";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/admin/getMatchingList.php',
            data: { page: page, id: id, type: type },
            success: function(data) {
                document.getElementById("backImg").style.display = 'none';
                document.getElementById("parentContent").style.display = 'block';
                document.getElementById("paging").style.display = 'block';
                document.getElementById("contentList").style.display = 'block';
                document.getElementById("contentList").innerHTML = '';
                document.getElementById("contentSubList").style.display = 'none';

                for(var i=0; i<data.matchingList.length; i++) {
                    document.getElementById("contentList").innerHTML
                    += '<div class="bb oh" style="padding: 15px 0;">'
                    +       '<div class="fl" style="width: 170px; line-height: 73px;">'
                    +           '<div class="f16 bold mb5">' + data.matchingList[i].area + '</div>'
                    +       '</div>'
                    +       '<div class="fl tl oh" style="width: 540px;">'
                    +           '<div class="f16 bold mb10">' + data.matchingList[i].title + '</div>'
                    +           '<div class="mr5 fc f12 ilbangBadge fl mb10">' + data.matchingList[i].work + '</div>'
                    +           '<div class="f12 c777 fl">' + data.matchingList[i].business + '</div>'
                    +           '<div class="clear f12 c777 fl mr5">' + data.matchingList[i].career + '</div>'
                    +           '<div class="fl payBedge f_navy border-grey bold mr5">일당</div>'
                    +           '<div class="fl f_navy bold f12">' + data.matchingList[i].pay + '원</div>'
                    +       '</div>'
                    +       '<div class="fl oh tc" style="width: 120px;">'
                    +           '<div class="mt10">' + data.matchingList[i].sex + '</div>'
                    +           '<div>' + data.matchingList[i].career + '</div>'
                    +           '<div>' + data.matchingList[i].time + '</div>'
                    +       '</div>'
                    +       '<div class="fl oh" style="width: 120px;">'
                    +           '<a href="javascript:getEmployData(' + data.matchingList[i].employNo + ')">'
                    +               '<div class="di direct sm-btn sm-btn3 f12 mt10">열람하기</div>'
                    +           '</a><br />'
                    +           '<a href="" id="review' + data.matchingList[i].no + '">'
                    +               '<div class="di direct sm-btn sm-btn3 f12 mt10" style="background-color: #8c8c8c; border-color: #8c8c8c;">리뷰보기</div>'
                    +           '</a>'
                    +       '</div>'
                    +    '</div>';

                    var review = "review" + data.matchingList[i].no;

                    if(data.matchingList[i].review == "yes") {
                        document.getElementById(review).href = "javascript:getReview(1, " + data.matchingList[i].no + ", '" + id + "')";
                    } else {
                        document.getElementById(review).href = "javascript:alert('리뷰가 없습니다.')";
                    }
                }

                document.getElementById("contentPage").innerHTML = '';

                if(data.paging.currentSection != 1) {
                    document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getMatchingList(' + data.paging.prevPage + ', ' + '\'' + id + '\'' + ', ' + '\'' + type +  '\'' + ')">이전</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("contentPage").innerHTML += '<li class="active"><a href="javascript:getMatchingList(' + i + ', ' + '\'' + id + '\'' + ', ' + '\'' + type +  '\'' + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getMatchingList(' + i + ', ' + '\'' + id + '\'' + ', ' + '\'' + type +  '\'' + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getMatchingList(' + data.paging.nextPage + ', ' + '\'' + id + '\'' + ', ' + '\'' + type +  '\'' + ')">다음</a></li>';
                }
            }
        });

        $("#recomndModal").modal('show');
    }

    function getEmployData(no) {
        document.getElementById("backImg").style.display = 'block';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/admin/getEmployData.php',
            data: { no: no },
            success: function(data) {
                getCompanyCSS();

                document.getElementById("modalTitle").innerHTML += ' 보기';
                document.getElementById("parentContent").style.display = 'none';
                document.getElementById("paging").style.display = 'none';
                document.getElementById("contentList").style.display = 'none';

                document.getElementById("title").innerHTML = data.employList.title;
                document.getElementById("logoImg").src = data.employList.imgUrl;
                document.getElementById("subBlock1").innerHTML
                = '<div class="fl bold tl bb" style="width: 100px; padding: 10px 0;">간단 소개</div>'
                + '<div class="fl bb tl" style="width: 702px; padding: 10px 0;">' + data.employList.business + '</div>'
                + '<div class="clear fl bold tl bb" style="width: 100px; padding: 10px 0;">담당자</div>'
                + '<div class="fl tl bb" style="width: 702px; padding: 10px 0;">' + data.employList.manager + '</div>'
                + '<div class="clear fl bold tl" style="width: 100px; padding: 10px 0;">회사 위치</div>'
                + '<div class="fl tl" style="width: 702px; padding: 10px 0;">' + data.employList.addr + '</div>';

                document.getElementById("subBlock2").innerHTML
                = '<div class="f16 tl bold mb5">근무 조건 및 모집 정보</div>'
                + '<div class="bd-left2 oh" style="border-top: 3px solid #2a3243;">'
                + '<div class="bg_eee fl" style="width: 189px; border-right: 1px solid #ddd; padding: 10px 0;">모집 부문</div>'
                + '<div class="bg_eee fl" style="width: 190px; border-right: 1px solid #ddd; padding: 10px 0;">성별</div>'
                + '<div class="bg_eee fl" style="width: 190px; border-right: 1px solid #ddd; padding: 10px 0;">나이</div>'
                + '<div class="bg_eee fl" style="width: 190px; border-right: 1px solid #ddd; padding: 10px 0;">경력</div>'
                + '<div class="bg_eee fl" style="width: 189px; padding: 10px 0;">외국인 고용 특례</div>'
                + '<div class="fl" style="width: 189px; border-right: 1px solid #ddd; padding: 30px 0;">' + data.employList.work + '</div>'
                + '<div class="fl" style="width: 190px; border-right: 1px solid #ddd; padding: 30px 0;">' + data.employList.sex + '</div>'
                + '<div class="fl" style="width: 190px; border-right: 1px solid #ddd; padding: 30px 0;">' + data.employList.age + '</div>'
                + '<div class="fl" style="width: 190px; border-right: 1px solid #ddd; padding: 30px 0;">' + data.employList.career + '</div>'
                + '<div class="fl" style="width: 189px; padding: 30px 0;">' + data.employList.fn + '</div>'
                + '</div>'
                + '<div class="clear"></div>';

                document.getElementById("subBlock3").innerHTML
                = '<div class="f16 tl bold mb5">모집 내용</div>'
                + '<div class="wdfull oh">'
                + '<div class="gujikDetSect3">'
                + '<div class="oh cont">'
                + '<div class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">담당 업무</div>'
                + '<div class="fl sect2Table di lh40 f12 tc noMargin pdl20">' + data.employList.business + '</div>'
                + '</div>'
                + '<div class="oh cont">'
                + '<div class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">연락처</div>'
                + '<div class="fl sect2Table di lh40 f12 tc noMargin pdl20">' + data.employList.phone + '</div>'
                + '</div>'
                + '<div class="oh cont bg_grey">'
                + '<div class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">근무 일자</div>'
                + '<div class="fl sect2Table di lh40 f12 tc noMargin pl20 pr20 bg_white workDate">' + data.employList.date + '</div>'
                + '</div>'
                + '<div class="oh cont">'
                + '<div class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">근무 시간</div>'
                + '<div class="fl sect2Table di lh40 f12 tc noMargin pdl20">' + data.employList.time + '</div>'
                + '</div>'
                + '<div class="oh cont">'
                + '<div class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">금액 (일당)</div>'
                + '<div class="fl sect2Table di lh40 f12 tc noMargin pdl20">&#8361; <span class="fc">' + data.employList.pay + '</span></div>'
                + '</div>'
                + '<div class="oh cont">'
                + '<div class="fl w100 noMargin sect2head di bg_grey lh40 f14 pl15 tl">상세 모집 내용</div>'
                + '</div>'
                + '<div class="sect3Inner">'
                + '<div class="tl p15">' + data.employList.content + '</div>'
                + '</div>'
                + '</div>'                
                + '<span class="mt25 mb5 f16 tl bold db">위치정보</span>'
                + '<div class="gujikDetSect4">'
                + '<div class="oh cont bb">'
                + '<div class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">위치 정보</div>'
                + '<div class="fl sect2Table di lh40 f12 tc noMargin pdl20">' + data.employList.addr + '</div>'
                + '</div>'
                + '<div class="oh cont">'
                + '<div class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc mapSecTlt" >지도 보기</div>'
                + '<div id="map" style="width:756px;height:495px;"></div>'
                + '</div>'
                + '</div>'
                + '</div>';

                if(data.employList.lat != "" && data.employList.lng != "") {
                    setTimeout("getMap(" + data.employList.lat + ", " + data.employList.lng + ")", 1000 * 2);
                } else {
                    document.getElementById("map").innerHTML = '위치 정보가 없습니다.';
                }

                document.getElementById("contentSubList").style.display = 'block';
            }
        });
    }

    function getMap(lat, lng) {
        var lat = lat;
        var lng = lng;

        if (lat == '' || lng == '' ){
            lat = "37.566264";
            lng = "126.977888";
        }

        var mapContainer = document.getElementById('map'), // 지도를 표시할 div 

        mapOption = { 
            center: new daum.maps.LatLng(lat, lng), // 지도의 중심좌표
            level: 3 // 지도의 확대 레벨
        };

        var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

        // 마커가 표시될 위치입니다 
        var markerPosition  = new daum.maps.LatLng(lat, lng); 

        // 마커를 생성합니다
        var marker = new daum.maps.Marker({
            position: markerPosition
        });

        // 마커가 지도 위에 표시되도록 설정합니다
        marker.setMap(map);
    }

    function getReview(page, no, id) {
        document.getElementById("backImg").style.display = 'block';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/admin/getReview.php',
            data: { page: page, no: no },
            success: function(data) {
                getCompanyCSS();

                document.getElementById("modalTitle").innerHTML =  id + '님의 평가보기';
                document.getElementById("parentContent").style.display = 'none';
                document.getElementById("contentList").style.display = 'none';
                document.getElementById("paging").style.display = 'block';
                document.getElementById("contentSubList").style.display = 'block';
                document.getElementById("subBlock3").innerHTML = '';

                document.getElementById("title").innerHTML = "평가보기";
                document.getElementById("subBlock2").innerHTML = '<div class="f16 tl bold mb5" style="border-bottom: 2px solid #ddd;">평가보기</div>';

                for(var i=0; i<data.reviewList.length; i++) {
                    document.getElementById("logoImg").src = data.reviewList[i].imgUrl;
                    document.getElementById("subBlock1").innerHTML
                    = '<div class="fl bold tl bb" style="width: 100px; padding: 10px 0;">구인자</div>'
                    + '<div class="fl bb tl" style="width: 702px; padding: 10px 0;">' + data.reviewList[i].name + '</div>'
                    + '<div class="clear fl bold tl bb" style="width: 100px; padding: 10px 0;">성별 / 나이</div>'
                    + '<div class="fl tl bb" style="width: 702px; padding: 10px 0;">' + data.reviewList[i].sex + ' / ' + data.reviewList[i].age + '</div>'
                    + '<div class="clear fl bold tl" style="width: 100px; padding: 10px 0;">평점</div>'
                    + '<div class="rateYoAvg mr5 fl mt3" style="margin-top:12px"></div><div class="fl tl" style="padding: 10px 0;">' + data.reviewList[i].avg + '점</div>';

                    document.getElementById("subBlock2").innerHTML
                    += '<div class="oh" style="border-bottom: 2px solid #ddd; padding: 15px;">'
                    + '<div class="fl mr10"><img src="' + data.reviewList[i].reviewImg + '" /></div>'
                    + '<div class="fl"><span class="bold mr5 fl">' + data.reviewList[i].ruid + '</span><span class="rateYo'+i+' ml5 mr5 fl mt3"></span><span class="fl">' + data.reviewList[i].score + '점</span></div>'
                    + '<div class="fr c999">' + data.reviewList[i].date + '</div><br /><br />'
                    + '<div class="fl">' + data.reviewList[i].content + '</div>'
                    + '</div>';

                    $(".rateYo"+i).rateYo({
                        readOnly: true,
                        rating: data.reviewList[i].score,
                        starWidth: '14px'
                    });

                    $(".rateYoAvg").rateYo({
                        rating: data.reviewList[i].avg,
                        readOnly: true,
                        starWidth: '16px',
                        halfStar: false
                    });
                }

                document.getElementById("contentPage").innerHTML = '';

                if(data.paging.currentSection != 1) {
                    document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getReview(' + data.paging.prevPage + ', ' + no + ', ' + '\'' + id + '\'' + ')">이전</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("contentPage").innerHTML += '<li class="active"><a href="javascript:getReview(' + i + ', ' + no + ', ' + '\'' + id + '\'' + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getReview(' + i + ', ' + no + ', ' + '\'' + id + '\'' + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getReview(' + data.paging.nextPage + ', ' + no + ', ' + '\'' + id + '\'' + ')">다음</a></li>';
                }
            }
        });
    }
</script>
<div class="f12 oh w100 userList c999" style="padding: 10px; border-bottom: 2px solid #ddd;">
    <span class="tc di fl font_grey">NO</span>
    <span class="tc di fl font_grey">아이디</span>                                                        
    <span class="tc di fl font_grey">이름</span>
    <span class="tc di fl font_grey">연락처</span>
    <span class="tc di fl font_grey">로그인 횟수</span>
    <span class="tc di fl font_grey">이력서 갯수</span>
    <span class="tc di fl font_grey">매칭 완료 현황</span>
    <span class="tc di fl font_grey">가입일</span>
</div>
<div id="recomndList"></div>
<div class="clear text-center mt20">
    <ul id="recomndGeneralPage" class="pagination"></ul>
</div>