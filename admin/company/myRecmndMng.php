<?php include_once "../include/session.php"; ?>
<script>
   $(document).ready(function() {
        getCmpMyRecmmndList();
    });

    function getCmpMyRecmmndList(page) {
        var id = "<?php echo $uid; ?>";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/admin/getCmpMyRecmmndList.php',
            data: { page: page },
            success: function (data) {
                var cell = document.getElementById("cmpRecmmndListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                if(id == "") {
                    document.getElementById("cmpRecmmndListArea").innerHTML = '<div class="f16 tc c666" style="padding-top: 80px;">로그인 해주시기 바랍니다.</div>';
                } else if(data.listData.length == 0) {
                    document.getElementById("cmpRecmmndListArea").innerHTML = '<div class="f16 tc c666" style="padding-top: 80px;">나를 추천인으로 등록한 사람이 없습니다.</div>';
                } else {
                    for (var i=0; i<data.listData.length; i++ ) {
                        document.getElementById("cmpRecmmndListArea").innerHTML
                        += '<div class="bb f12 oh userList" style="padding: 10px;">'
                        + '<span class="di tc fl">' +data.listData[i].rowNum + '</span>'
                        + '<span class="di tc fl">' +data.listData[i].uid + '</span>'
                        + '<span class="di tc fl text-cut">' +data.listData[i].name + '</span>'
                        + '<span class="di tc fl">' +data.listData[i].phone + '</span>'
                        + '<span class="di tc fl">' +data.listData[i].login_count + '회</span>'
                        + '<span class="di tc fl"><a href="" id="employ' + data.listData[i].rowNum + '">' +data.listData[i].employCnt + '건</a></span>'
                        + '<span class="di tc fl"><a href="" id="EmatchingComple' + data.listData[i].rowNum + '">' +data.listData[i].matchingCompleCnt + '건</a></span>'
                        + '<span class="di tc fl">' +data.listData[i].joinDate + '</span>'
                        + '</div>';

                        var employ = "employ" + data.listData[i].rowNum;
                        var EmatchingComple = "EmatchingComple" + data.listData[i].rowNum;

                        if(data.listData[i].employCnt != 0) {
                            document.getElementById(employ).classList.add('underline');
                            document.getElementById(employ).href = "javascript:getEmployList(1, '" + data.listData[i].uid + "')";       //javascript:getEmployList(페이지, 조회할 아이디);
                        } else {
                            document.getElementById(employ).href = "javascript:void(0)";
                        }

                        if(data.listData[i].matchingCompleCnt != 0) {
                            document.getElementById(EmatchingComple).classList.add('underline');
                            document.getElementById(EmatchingComple).href = "javascript:getMatchingList(1, '" + data.listData[i].uid + "', 'company')";       //javascript:getEMatchingCompleList(페이지, 조회할 아이디);
                        } else {
                            document.getElementById(EmatchingComple).href = "javascript:void(0)";
                        }
                    }

                    document.getElementById("cmpRecmmndListPagingArea").innerHTML = data.paging;
                }
            }
        });
    }

    function getEmployList(page, id) {
        document.getElementById("modalTitle").innerHTML = id + '님의 채용 공고';
        document.getElementById("li1").innerHTML = '등록일';
        document.getElementById("li2").innerHTML = '신청서 제목';
        document.getElementById("li3").innerHTML = '열람';
        document.getElementById("li4").innerHTML = '매칭 건수';
        document.getElementById("backImg").href = "javascript:getEmployList(" + page + ", '" + id + "')";       //뒤로 가기 버튼 눌렀을 때 실행되는 함수

        document.getElementById("contentSubList").style.display = 'none';
        document.getElementById("backImg").style.display = 'none';
        document.getElementById("contentList").style.display = 'block';
        document.getElementById("parentContent").style.display = 'block';
        document.getElementById("paging").style.display = 'block';
        document.getElementById("contentList").innerHTML = '';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/member/getEmployList.php',
            data: { uid: id },
            success: function(data) {
                for(var i=0; i<data.employList.length; i++) {
                    document.getElementById("contentList").innerHTML
                    += '<div class="bb oh" style="padding: 15px 0;">'
                    +       '<div class="fl mt20" style="width: 170px;">'
                    +           '<span class="f14">' + data.employList[i].wdate + '</span>'
                    +       '</div>'
                    +       '<div class="fl tl oh" style="width: 540px; line-height: 1;">'
                    +           '<div class="f14 bold" style="margin-bottom: 12px;">' + data.employList[i].title + '</div>'
                    +           '<div class="mr5 fc f12 ilbangBadge fl mb10">' + data.employList[i].work2 + '</div>'
                    +           '<div class="f12 c777 fl mb10" style="margin-top: 2px;">' + data.employList[i].business + '</div>'
                    +           '<div class="clear c999 f12 mr10 fl" style="margin-top: 2px;">경력 : ' + data.employList[i].career + '</div>'
                    +           '<div class="hopeIldangBadge fl f12 lh1">일당</div>'
                    +           '<div class="f12 fl" style="margin-top: 2px;">' + data.employList[i].pay + '원</div>'
                    +       '</div>'
                    +       '<div class="fl oh" style="width: 120px;">'
                    +           '<a href="javascript:getEmployData(' + data.employList[i].no + ')">'
                    +               '<div class="di direct sm-btn3 f12" style="line-height: 1; margin-top: 23px; padding: 3px 6px;">열람하기</div>'
                    +           '</a>'
                    +       '</div>'
                    +       '<div class="fl" style="width: 120px;">'
                    +           '<div class="mt25" style="line-height: 1;"><span class="fc underline">' + data.employList[i].matching + '</span>건</div>'
                    +       '</div>'
                    +    '</div>';
                }

                document.getElementById("contentPage").innerHTML = '';

                if(data.paging.currentSection != 1) {
                    document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getEmployList(' + data.paging.prevPage + ', ' + '\'' + id + '\'' + ')">이전</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("contentPage").innerHTML += '<li class="active"><a href="javascript:getEmployList(' + i + ', ' + '\'' + id + '\'' + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getEmployList(' + i + ', ' + '\'' + id + '\'' + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("contentPage").innerHTML += '<li><a href="javascript:getEmployList(' + data.paging.nextPage + ', ' + '\'' + id + '\'' + ')">다음</a></li>';
                }
            }
        });

        $("#recomndModal").modal('show');
    }
</script>
<div class="f12 oh w100 userList c999" style="padding: 10px; border-bottom: 2px solid #ddd;">
    <span class="tc di fl font_grey">NO</span>
    <span class="tc di fl font_grey">아이디</span>
    <span class="tc di fl font_grey">이름</span>
    <span class="tc di fl font_grey">연락처</span>
    <span class="tc di fl font_grey">로그인 횟수</span>
    <span class="tc di fl font_grey">채용 공고 갯수</span>
    <span class="tc di fl font_grey">매칭 완료 현황</span>
    <span class="tc di fl font_grey">가입일</span>
</div>
<div id="cmpRecmmndListArea"></div>
<div class="clear text-center mt20">
    <ul id="cmpRecmmndListPagingArea" class="pagination"></ul>
</div>
