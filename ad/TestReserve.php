<?php
    include_once "../include/header.php";

    if(isset($_GET["tab"])) {
        $tab = $_GET["tab"];
    } else {
        $tab = 1;
    }
?>
<style>
    .imgHover:hover {
        border: 3px solid #eb5f43;
    }
</style>
<script>
    $(document).ready(function () {
        getADVideoList(1);
        getADBannerList(1);
    });

    function getADVideoList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getADList.php',
            data: { page: page, type: 0 },
            success: function(data) {                
                var cell = document.getElementById("adVideoList");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.adList == null) {
                    document.getElementById("adVideoList").innerHTML = '<div class="f16 tc" style="padding: 40px 0;">동영상이 없습니다.</div>';
                } else {
                    for(var i=0; i<data.adList.length; i++) {
                        document.getElementById("adVideoList").innerHTML
                        += '<div class="fl imgHover mr10 mb10" style="width: 251px; height: 185px;">'
                        + '<div class="fl" style="width: 245px; height: 140px;">'
                        + '<a href="#" onclick="javascript:getModalData(' + page + ', ' + data.adList[i].no +', 0)" data-toggle="modal" data-target="#adVideoModal">'
                        + '<img class="wdfull border-grey" src="' + data.adList[i].thum +'" /></a>'
                        + '<div class="wdfull p5">'
                        + '<div class="textCut mw70 fl">' + data.adList[i].title + '</div>'
                        + '<div class="w30 tr fr mt8"><img src="../images/point.png" class="adPoint" /><span class="fc bold">' + data.adList[i].point +'</span></div><br />'
                        + '<div class="textCut mw70 fl f10 c999">' + data.adList[i].content + '</div>'
                        + '</div>'
                        + '</div>';
                    }
                }

                var cell  = document.getElementById("adVideoPage");                

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.paging.currentSection != 1) {
                    document.getElementById("adVideoPage").innerHTML
                    += '<li><a href="javascript:getADVideoList(' + data.paging.prevPage + ')" aria-label="Previous">'
                    + '<span aria-hidden="true">이전</span>'
                    + '</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("adVideoPage").innerHTML += '<li class="active"><a href="javascript:getADVideoList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("adVideoPage").innerHTML += '<li><a href="javascript:getADVideoList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("adVideoPage").innerHTML
                    += '<li><a href="javascript:getADVideoList(' + data.paging.nextPage + ')" aria-label="Next">'
                    + '<span aria-hidden="true">다음</span>'
                    + '</a></li>';
                }
            }
        });
    }

    function getADBannerList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getADList.php',
            data: { page: page, type: 1 },
            success: function(data) {
                var cell = document.getElementById("adBannerList");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.adList == null) {
                    document.getElementById("adBannerList").innerHTML = '<div class="f16 tc" style="padding: 40px 0;">배너가 없습니다.</div>';
                } else {
                    for(var i=0; i<data.adList.length; i++) {
                        document.getElementById("adBannerList").innerHTML
                        += '<div class="fl oa imgHover mr10 mb5" style="width: 340px; height: 155px;">'
                        + '<div class="fl" style="width: 334px; height: 94px;">'
                        + '<a href="#" onclick="javascript:getModalData(' + page + ', ' + data.adList[i].no +', 1)" data-toggle="modal" data-target="#adBannerModal">'
                        + '<img class="wdfull border-grey" src="' + data.adList[i].thum +'" style="width: 334px; height: 94px;" /></a>'
                        + '<div class="wdfull p5">'
                        + '<div class="textCut mw70 fl">' + data.adList[i].title + '</div>'
                        + '<div class="tr fr mt8"><img src="../images/point.png" class="adPoint" /><span class="fc bold">' + data.adList[i].point +'</span></div>'
                        + '<div class="fl f10 c999" style="width: 285px;">' + data.adList[i].content + '</div>'
                        + '</div>';
                    }
                }

                var cell  = document.getElementById("adBannerPage");                

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.paging.currentSection != 1) {
                    document.getElementById("adBannerPage").innerHTML
                    += '<li><a href="javascript:getADBannerList(' + data.paging.prevPage + ')" aria-label="Previous">'
                    + '<span aria-hidden="true">이전</span>'
                    + '</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("adBannerPage").innerHTML += '<li class="active"><a href="javascript:getADBannerList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("adBannerPage").innerHTML += '<li><a href="javascript:getADBannerList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("adBannerPage").innerHTML
                    += '<li><a href="javascript:getADBannerList(' + data.paging.nextPage + ')" aria-label="Next">'
                    + '<span aria-hidden="true">다음</span>'
                    + '</a></li>';
                }                
            }
        });
    }
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > AD머니 > <b class="c555">AD머니 적립</b></div>
        <div class="c999 fr padding-vertical">
            <span class="mr5 br15 subNotice">공지</span>
            <a href="#" class="c999"><span id="adNotice"></span></a>
        </div>
    </div>
</div>
<?php include_once "adHeader.php"; ?>
<div class="pdtb30 oa margin-auto wdfull">
    <div class="mb20 container pl25">
        <div class="mb5">
            <span class="f16 bold mr5 c666">AD머니 적립</span>
            <span class="c888">회원들이 광고를 끝까지 보고 퀴즈를 풀면 포인트가 적립됩니다.</span>
        </div>
    </div>
    <div class="oa wdfull">
        <div class="adTabWrap">
            <ul class="nav nav-tabs margin-auto tc f16" role="tablist" id="adTab">
                <?php if($tab == 1) { ?>
                <li class="w50 noPadding active" role="presentation"><a href="#adTab1" aria-controls="adTab1" role="tab" data-toggle="tab">AD 동영상</a></li>
                <li class="w50 noPadding" role="presentation"><a href="#adTab2" aria-controls="adTab2" role="tab" data-toggle="tab">AD 배너</a></li>
                <?php } else { ?>
                <li class="w50 noPadding" role="presentation"><a href="#adTab1" aria-controls="adTab1" role="tab" data-toggle="tab">AD 동영상</a></li>
                <li class="w50 noPadding active" role="presentation"><a href="#adTab2" aria-controls="adTab2" role="tab" data-toggle="tab">AD 배너</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="tab-content container pl25 mt50 c666">
        <?php if($tab == 1) { ?>
        <div class="tab-pane active" id="adTab1" role="tabpanel">
            <div id="adVideoList" class="margin-auto oh mb10"></div>
            <div class="clear text-center">
                <ul id="adVideoPage" class="pagination"></ul>
            </div>
        </div>        
        <div class="tab-pane" id="adTab2" role="tabpanel">
            <div id="adBannerList" class="margin-auto oh mb10"></div>
            <div class="clear text-center">
                <ul id="adBannerPage" class="pagination"></ul>
            </div>
        </div>
        <?php } else if($tab == 2) { ?>
        <div class="tab-pane" id="adTab1" role="tabpanel">
            <div id="adVideoList" class="margin-auto oh mb10"></div>
            <div class="clear text-center">
                <ul id="adVideoPage" class="pagination"></ul>
            </div>
        </div>        
        <div class="tab-pane active" id="adTab2" role="tabpanel">
            <div id="adBannerList" class="margin-auto oh mb10"></div>
            <div class="clear text-center">
                <ul id="adBannerPage" class="pagination"></ul>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="pdtb30 oa margin-auto container pl25">
        <?php include_once "adFooter.php"; ?>
    </div>
</div>
<div class="modal fade c666" id="adVideoModal">
    <div class="modal-dialog mt50" style="width: 650px;">
        <div class="modal-content noBorder" style="background-color: transparent;">
            <div class="modal-header noBorder oh">
                <a href="#" class="fr" data-dismiss="modal"><img src="../images/exit.png" /></a>                
            </div>
            <div class="modal-body f14 tc bg_white" style="padding: 0; padding-bottom: 10px;">
                <div class="wdfull bold pd15">동영상을 보신 후 퀴즈를 풀어 <span class="fc">포인트를 적립</span>하세요!</div>
                <iframe id="video" width="100%" height="350px" allowfullscreen="true" src="" frameborder="0" allowscriptaccess="always"></iframe>
                <div class="wdfull padding-vertical"><span class="fc bold">Q </span><span id="quiz"></span></div>
                <div class="oh f12 margin-auto tc mb20" style="width: 600px; padding: 20px 0;">
                    <div class="fl w24">
                        <input type="radio" id="correct1" name="correct" style="margin: 0 0.5ex;" />
                        <label for="correct1" id="videoCorrect1">보기1</label>
                    </div>
                    <div class="fl f10 adQuizBar">|</div>
                    <div class="fl w24">
                        <input type="radio" id="correct2" name="correct" style="margin: 0 0.5ex;" />
                        <label for="correct2" id="videoCorrect2">보기2</label>
                    </div>
                    <div class="fl f10 adQuizBar">|</div>
                    <div class="fl w24">
                        <input type="radio" id="correct3" name="correct" style="margin: 0 0.5ex;" />
                        <label for="correct3" id="videoCorrect3">보기3</label>
                    </div>
                    <div class="fl f10 adQuizBar">|</div>
                    <div class="fl w24">
                        <input type="radio" id="correct4" name="correct" style="margin: 0 0.5ex;" />
                        <label for="correct4" id="videoCorrect4">보기4</label>
                    </div>
                </div>
                <a id="reserveBtn">
                    <div class="adQuizBtn">적립하기</div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade c666" id="adBannerModal">
    <div class="modal-dialog mt50" style="width: 700px;">
        <div class="modal-content noBorder" style="background-color: transparent;">
            <div class="modal-header noBorder oh">
                <a href="#" class="fr" data-dismiss="modal"><img src="../images/exit.png" /></a>                
            </div>
            <div class="modal-body f14 tc bg_white" style="padding: 0; padding-bottom: 10px;">
                <div class="wdfull bold pd15">배너를 보신 후 퀴즈를 풀어 <span class="fc">포인트를 적립</span>하세요!</div>
                <img src="" id="bannerImg" width="100%" />                
                <div class="wdfull padding-vertical mt30"><span class="fc bold">Q </span><span id="bannerQuiz"></span></div>
                <div class="oh f12 margin-auto tc mb20" style="width: 650px; padding: 20px 0;">
                    <div class="fl w24 textCut" style="max-width: 24%;">
                        <input type="radio" id="banCorrect1" name="correct" style="margin: 0 0.5ex;" />
                        <label for="banCorrect1" id="bannerCorrect1">보기1</label>
                    </div>
                    <div class="fl f10 adQuizBar">|</div>
                    <div class="fl w24">
                        <input type="radio" id="banCorrect2" name="correct" style="margin: 0 0.5ex;" />
                        <label for="banCorrect2" id="bannerCorrect2">보기2</label>
                    </div>
                    <div class="fl f10 adQuizBar">|</div>
                    <div class="fl w24">
                        <input type="radio" id="banCorrect3" name="correct" style="margin: 0 0.5ex;" />
                        <label for="banCorrect3" id="bannerCorrect3">보기3</label>
                    </div>
                    <div class="fl f10 adQuizBar">|</div>
                    <div class="fl w24">
                        <input type="radio" id="banCorrect4" name="correct" style="margin: 0 0.5ex;" />
                        <label for="banCorrect4" id="bannerCorrect4">보기4</label>
                    </div>
                </div>
                <a id="reserveBtn2">
                    <div class="adQuizBtn">적립하기</div>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function getModalData(page, val, type) {
        var correct = document.getElementsByName("correct");

        for(var i=0; i<correct.length; i++) {
            correct[i].checked = false;
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getADData.php',
            data: { val: val },
            success: function(data) {
                var link = "javascript:pointReserve(" + page + ", " + data.adDataList.no + ", " + type + ")";

                if(type == 0) {
                    $("#video").attr('src', data.adDataList.link);
                    $("#quiz").text(data.adDataList.quiz);
                    $("#videoCorrect1").text(data.adDataList.exam1);
                    $("#videoCorrect2").text(data.adDataList.exam2);
                    $("#videoCorrect3").text(data.adDataList.exam3);
                    $("#videoCorrect4").text(data.adDataList.exam4);
                    $("#reserveBtn").attr('href', link);
                } else if(type == 1) {
                    $("#bannerImg").attr('src', data.adDataList.link);
                    $("#bannerQuiz").text(data.adDataList.quiz);
                    $("#bannerCorrect1").text(data.adDataList.exam1);
                    $("#bannerCorrect2").text(data.adDataList.exam2);
                    $("#bannerCorrect3").text(data.adDataList.exam3);
                    $("#bannerCorrect4").text(data.adDataList.exam4);
                    $("#reserveBtn2").attr('href', link);
                }
            }
        });
    }

    function pointReserve(page, val, type) {
        var correct = 0;

        if(type == 0) {
            if($("#correct1").is(":checked")) {
                correct = 1;
            } else if($("#correct2").is(":checked")) {
                correct = 2;
            } else if($("#correct3").is(":checked")) {
                correct = 3;
            } else if($("#correct4").is(":checked")) {
                correct = 4;
            }
        } else if(type == 1){
            if($("#banCorrect1").is(":checked")) {
                correct = 1;
            } else if($("#banCorrect2").is(":checked")) {
                correct = 2;
            } else if($("#banCorrect3").is(":checked")) {
                correct = 3;
            } else if($("#banCorrect4").is(":checked")) {
                correct = 4;
            }
        }

        if(correct == 0) {
            alert("정답을 선택해주세요.");
        } else {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/ad/adPointReserve.php',
                data: { val: val, correct: correct },
                success: function(data) {
                    alert(data);

                    if(type == 0) {
                        $("#adVideoModal").modal("hide");
                    } else if(type == 1) {
                        $("#adBannerModal").modal("hide");
                    }

                    getADMoney();
                    getADBannerList(page);
                }
            });
        }
    }
</script>
<?php include_once "../include/footer.php"; ?>