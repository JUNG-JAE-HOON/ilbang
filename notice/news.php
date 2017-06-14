<?php include_once "../include/header.php"; ?>
<script>
    $(document).ready(function () {
        getNewsList(1);
    });

    //공지사항 리스트
    function getNewsList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/notice/getNewsList.php',
            data: { page: page },
            success: function(data) {
                var cell = document.getElementById("newsList");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                for(var i=0; i<data.length; i++) {
                    if(data.newsList[i].newsNo != "") {
                        document.getElementById("newsList").innerHTML
                        += '<div class="oa bb adFormTitle tc">'
                        + '<div class="w10 fl">' + data.newsList[i].no + '</div>'
                        + '<a href="view.php?no=' + data.newsList[i].newsNo + '"><div class="w55 fl tl mw90 textCut">' + data.newsList[i].title + '</div></a>'
                        + '<div class="w10 fl">관리자</div>'
                        + '<div class="w15 fl">' + data.newsList[i].date + '</div>'
                        + '<div class="w10 fl">' + data.newsList[i].hit + '</div>'
                        + '</div>';
                    }
                }

                var cell  = document.getElementById("newsPage");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.paging.currentSection != 1) {
                    document.getElementById("newsPage").innerHTML += '<li><a href="javascript:getNewsList(' + data.paging.prevPage + ')">이전</a></li>';
                }

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("newsPage").innerHTML += '<li class="active"><a href="javascript:getNewsList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("newsPage").innerHTML += '<li><a href="javascript:getNewsList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("newsPage").innerHTML += '<li><a href="javascript:getNewsList(' + data.paging.nextPage + ')">다음</a></li>';
                }
            }
        });
    }
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > <b class="c555">공지사항</b></div>
    </div>
</div>
<div class="bannerArea">
    <img src="../images/news-banner.png" width="100%" />
</div>
<div class="pdtb30 oa margin-auto wdfull">
    <div class="margin-auto container pl25">
        <div class="mb5">
            <span class="f16 bold mr5 c666">공지사항</span>
            <span class="c888">일방 서비스의 새로운 소식을 확인하세요.</span>
        </div>
        <div class="oa mt10 f14 tc adListBorder bg_eee tc bold">
            <div class="fl padding-vertical w10">번호</div>
            <div class="fl padding-vertical w55">제목</div>
            <div class="fl padding-vertical w10">글쓴이</div>
            <div class="fl padding-vertical w15">작성 날짜</div>
            <div class="fl padding-vertical w10">조회수</div>
        </div>
        <div id="newsList"></div>
    </div>    
    <div class="container center tc pb5">
        <ul class="pagination" id="newsPage"></ul>
    </div>    
</div>
<?php include_once "../include/footer.php"; ?>   