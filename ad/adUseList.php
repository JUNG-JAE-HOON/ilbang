<?php include_once "../include/header.php"; ?>
<script>
    $(document).ready(function () {
        getNotice();
        getReserveList(1);
        getUseList(1);
    });

    //공지사항 불러오기
    function getNotice() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getNoticeList.php',
            success: function(data) {
                for(var i=0; i<1; i++) {
                    document.getElementById("adNotice").innerHTML = data.noticeList[i].title;                
                }
            }
        });
    }

    //ad머니 적립 내역
    function getReserveList(page) {
        var id = "<?php echo $uid; ?>";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getADReserveList.php',
            data: { page: page },
            success: function(data) {
                document.getElementById("myPoint").innerHTML = data.myPoint;

                if(data.reservedPoint == 0) {
                    document.getElementById("reservedPoint").innerHTML = data.reservedPoint + " P";
                } else {
                    document.getElementById("reservedPoint").innerHTML = "+ " + data.reservedPoint + " P";
                }

                var cell = document.getElementById("adReserveList");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(id == "") {
                    document.getElementById("adReserveList").innerHTML = '<div class="f14 tc bb" style="padding: 5% 0;">로그인 해주시기 바랍니다.</div>';
                } else if(data.length == 0) {
                    document.getElementById("adReserveList").innerHTML = '<div class="f14 tc bb" style="padding: 5% 0;">적립 내역이 없습니다.</div>';
                } else {
                    for(var i=0; i<data.length; i++) {
                        if(data.adReserveList[i].day != "") {
                            document.getElementById("adReserveList").innerHTML
                            += '<div class="oa f14 tc padding-vertical bb">'
                            + '<div class="w20 fl">' + data.adReserveList[i].day + '&nbsp;&nbsp;<span style="color: #bbb;">' + data.adReserveList[i].time + '</span></div>'
                            + '<div class="w15 fl">적립</div>'
                            + '<div class="w30 fl tl">' + data.adReserveList[i].content + '</div>'
                            + '<div class="w17_5 fl">+ ' + data.adReserveList[i].point + ' P</div>'
                            + '<div class="w17_5 fl fc bold">' + data.adReserveList[i].total + ' P</div>'
                            + '</div>';
                        }
                    }
                }

                var cell  = document.getElementById("adReservePage");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.paging.currentSection != 1) {
                    document.getElementById("adReservePage").innerHTML
                    += '<li><a href="javascript:getReserveList(' + data.paging.prevPage + ')" aria-label="Previous">'
                    + '<span aria-hidden="true">이전</span>'
                    + '</a></li>';
                }

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("adReservePage").innerHTML += '<li class="active"><a href="javascript:getReserveList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("adReservePage").innerHTML += '<li><a href="javascript:getReserveList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("adReservePage").innerHTML
                    += '<li><a href="javascript:getReserveList(' + data.paging.nextPage + ')" aria-label="Next">'
                    + '<span aria-hidden="true">다음</span>'
                    + '</a></li>';
                }
            }
        });
    }

    //ad머니 사용 내역
    function getUseList(page) {
        var id = "<?php echo $uid; ?>";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getADUseList.php',
            data: { page: page },
            success: function(data) {
                if(data.usedPoint == 0) {
                    document.getElementById("usedPoint").innerHTML = data.usedPoint + " P";
                } else {
                    document.getElementById("usedPoint").innerHTML = "- " + data.usedPoint + " P";
                }

                var cell = document.getElementById("adUseList");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(id == "") {
                    document.getElementById("adUseList").innerHTML = '<div class="f14 tc bb" style="padding: 5% 0;">로그인 해주시기 바랍니다.</div>';
                } else if(data.length == 0) {
                    document.getElementById("adUseList").innerHTML = '<div class="f14 tc bb" style="padding: 5% 0;">사용 내역이 없습니다.</div>';
                } else {
                    for(var i=0; i<data.length; i++) {
                        if(data.adUseList[i].day != "") {
                            document.getElementById("adUseList").innerHTML
                            += '<div class="oa f14 tc padding-vertical bb">'
                            + '<div class="w20 fl">' + data.adUseList[i].day + '&nbsp;&nbsp;<span style="color: #bbb;">' + data.adUseList[i].time + '</span></div>'
                            + '<div class="w15 fl">사용</div>'
                            + '<div class="w30 fl tl">' + data.adUseList[i].content + '</div>'
                            + '<div class="w17_5 fl">- ' + data.adUseList[i].point + ' P</div>'
                            + '<div class="w17_5 fl fc bold">' + data.adUseList[i].total + ' P</div>'
                            + '</div>';
                        }
                    }
                }

                var cell  = document.getElementById("adUsePage");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.paging.currentSection != 1) {
                    document.getElementById("adUsePage").innerHTML
                    += '<li><a href="javascript:getUseList(' + data.paging.prevPage + ')" aria-label="Previous">'
                    + '<span aria-hidden="true">이전</span>'
                    + '</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("adUsePage").innerHTML += '<li class="active"><a href="javascript:getUseList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("adUsePage").innerHTML += '<li><a href="javascript:getUseList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("adUsePage").innerHTML
                    += '<li><a href="javascript:getUseList(' + data.paging.nextPage + ')" aria-label="Next">'
                    + '<span aria-hidden="true">다음</span>'
                    + '</a></li>';
                }
            }
        });     
    }
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > AD머니 > <b class="c666">AD머니 사용 내역</b></div>
        <div class="c999 fr padding-vertical">
            <span class="mr5 br15 subNotice">공지</span>
            <a href="#" class="c999"><span id="adNotice"></span></a>
        </div>
    </div>
</div>
<?php include_once "adHeader.php"; ?>
<div class="pdtb30 oa margin-auto wdfull">
    <div class="margin-auto container pl25">
        <div class="mb5">
            <span class="f16 bold mr5 c666">AD머니 사용 내역</span>
            <span class="c888">회원들의 적립 내용과 사용 내역을 조회해 보실 수 있습니다.</span>
        </div>
    </div>
    <hr style="border-color: #ddd; margin: 0;" />
    <div class="margin-auto mt40 c666 container pl25">
        <div class="oa">
            <span class="f16 bold">나의 AD머니</span>
            <a href="adReserve.php"><span class="c888 fr" style="border: 1px solid #bbb; padding: 5px 5px 2px;">AD머니 적립</span></a>
            <div class="oa mt10 f14 tc adListBorder">
                <div class="fl padding-vertical bg_eee w20">현재 나의 AD머니</div>
                <div class="fl bold padding-vertical c888 w30"><span id="myPoint" class="fc"></span> P</div>
                <div class="fl padding-vertical bg_eee w20">적립된 AD머니</div>
                <div class="fl bold padding-vertical c888 w30" id="reservedPoint"></div>
            </div>
            <div class="oa f14 tc mb40" style="border-bottom: 1px solid #ddd;">
                <div class="fl padding-vertical bg_eee w20">사용한 AD머니</div>
                <div class="fl bold padding-vertical c888 w30" id="usedPoint"></div>
            </div>
            <span class="f16 bold">AD머니 적립 내역</span>
            <div class="oa mt10 f14 tc adListBorder bg_eee padding-vertical">
                <div class="w20 fl">날짜 / 시간</div>
                <div class="w15 fl">구분</div>
                <div class="w30 fl">적립 내용</div>
                <div class="w17_5 fl">AD머니 변동</div>
                <div class="w17_5 fl">AD머니 잔액</div>
            </div>
            <div id="adReserveList"></div>
            <div class="text-center mb10">
                <ul id="adReservePage" class="pagination"></ul>
            </div>
            <span class="f16 bold">AD머니 사용 내역</span>
            <div class="oa mt10 f14 tc adListBorder bg_eee padding-vertical">
                <div class="w20 fl">날짜 / 시간</div>
                <div class="w15 fl">구분</div>
                <div class="w30 fl">적립 내용</div>
                <div class="w17_5 fl">AD머니 변동</div>
                <div class="w17_5 fl">AD머니 잔액</div>
            </div>
            <div id="adUseList"></div>
            <div class="text-center mb40">
                <ul id="adUsePage" class="pagination"></ul>
            </div>
        </div>
        <?php include_once "adFooter.php"; ?>
    </div>
</div>
<?php include_once "../include/footer.php"; ?>