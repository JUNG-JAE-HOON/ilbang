<?php include_once "../include/header.php"; ?>
<script>
    $(document).ready(function() {
        var type = "<?php echo $kind; ?>";

        if(type == "general") {
            alert("기업 회원만 이용할 수 있습니다.");
            history.back();
        } else {
            getNotice();
            getMyInfo();
            getCompanyImage();
            getEmployList(1);
            getItemList(1);
            getItemPurchaseList(1);
            getItemUseList(1);
            getReserveList(1);
            getUseList(1);
        }
    });

    function getNotice() {
      //공지사항 리스트
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/notice/getNoticeList.php',
            success: function(data) {
                for(var i=0; i<1; i++) {
                    document.getElementById("adNotice").innerHTML
                    = '<a href="../notice/view.php?no=' + data.noticeList[i].no + '" class="c999">' + data.noticeList[i].title + '</a>';
                }
            }
        });
    }

    function getMyInfo() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/member/getMyInfo.php',
            success: function(data) {
                if(data.message != null) {
                    alert(data.message);
                    history.back();
                } else {
                    document.getElementById("myEmploy").innerHTML = data.memberInfo.employ;
                    document.getElementById("myMatching").innerHTML = data.memberInfo.matching;
                    document.getElementById("myADMoney").innerHTML = data.memberInfo.point;
                    document.getElementById("myNumber").innerHTML = data.memberInfo.number;
                    document.getElementById("myCompany").innerHTML = data.memberInfo.company;
                    document.getElementById("myFlotation").innerHTML = data.memberInfo.flotation + '년';
                    document.getElementById("phone1").value = data.memberInfo.phone1;
                    document.getElementById("phone2").value = data.memberInfo.phone2;
                    document.getElementById("phone3").value = data.memberInfo.phone3;
                    document.getElementById("birth_sex").innerHTML = data.memberInfo.birth + ' / ' + data.memberInfo.sex;
                    document.getElementById("email1").value = data.memberInfo.email1;
                    document.getElementById("email2").value = data.memberInfo.email2;

                    var types = document.getElementById("types");
                    var status = document.getElementById("status");

                    for(var i=0; i<types.length; i++) {
                        if(types[i].value == data.memberInfo.types) {
                            types[i].selected = true;
                        }
                    }

                    for(var i=0; i<status.length; i++) {
                        if(status[i].value == data.memberInfo.status) {
                            status[i].selected = true;
                        }
                    }

                    if(data.memberInfo.valid == "yes") {
                        document.getElementById("phone1").readOnly = true;
                        document.getElementById("phone2").readOnly = true;
                        document.getElementById("phone3").readOnly = true;
                        document.getElementById("valid").innerHTML = '* 본인 인증 완료';
                        document.getElementById("validBtn").style.display = 'none';
                    } else {
                        document.getElementById("valid").innerHTML = '* 본인 인증 필요';
                        document.getElementById("valid").style.color = '#eb5f43';
                    }

                    if(data.memberInfo.email1 == "undefined" || data.memberInfo.email2 == "undefined") {
                        document.getElementById("emailCheck").innerHTML = '* 메일 주소를 수정해주세요.';
                    } else {
                        document.getElementById("emailCheck").innerHTML = '';
                    }
                }
            }
        });
    }

    function getCompanyImage() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/guin/getLogoImage.php',
            success: function(data) {
                var img_url = data.logoData.img_url;
                var companyLogo = document.getElementById("company_logo");

                if(img_url != null) {
                    companyLogo.src = "../guinImage/" + img_url;
                } else {
                    companyLogo.src = "../images/144x38.png";
                }
            }
        });
    }

    function imageUpLoad() {
        var formData = new FormData();

         if($('#ex_file')[0].files.length != 0) {
            for(var i=0; i<$('#ex_file')[0].files.length; i++) {
                formData.append('upload', $('#ex_file')[0].files[i]);
            }

            $.ajax({
                url: '../ajax/guin/uploadGuinImage.php',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    if(data.logoData.image != null) {
                        var companyLogo = document.getElementById("company_logo");

                        companyLogo.src = "../guinImage/" + data.logoData.image;
                    }

                    alert(data.logoData.message);
                }
            });
        } else {
            alert("선택된 파일이 없습니다.");
        }
    }

    function imageDelete() {
        var companyLogo = document.getElementById("company_logo");

        if(confirm("정말 삭제하시겠습니까?")) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/guin/deleteGuinImage.php',
                success: function(data) {
                    companyLogo.src = "../images/144x38.png";

                    alert(data);
                }
            });
        }
    }

    function valid_btn() {
        var winHeight = document.body.clientHeight;
        var winWidth = document.body.clientWidth;
        var winX = window.screenLeft;
        var winY = window.scrrenTop;
        var popX = winX + (winWidth - 408)/2;
        var popY = winY + (winHeight - 650)/2;

        window.open("../in/in.php?id=<?php echo $uid; ?>", "valid", "width=408, height=650, top=" + popY + ", left=" + popX);
    }

    function getEmployList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/member/getEmployList.php',
            data: { page: page },
            success: function(data) {
                var cell = document.getElementById("employList");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.employList == null) {
                    document.getElementById("noEmploy").innerHTML = '<div class="bb" style="padding: 30px 0;">채용 공고가 없습니다.</div>';
                } else {
                    for(var i=0; i<data.employList.length; i++) {
                        document.getElementById("employList").innerHTML
                        += '<tr class="bb tc">'
                        + '<td class="vm">'
                        + '<div class="f16 bold mb5">' + data.employList[i].delegate + '</div>'
                        + '<span>' + data.employList[i].wdate + '</span>'
                        + '</td>'
                        + '<td class="vm tl" style="padding: 20px 0;">'
                        + '<span class="bold">[' + data.employList[i].company + '] </span>'
                        + '<span>' + data.employList[i].title + '</span>'
                        + '<span class="db margin-vertical textCut" style="max-width: 95%; padding-top: 2px;">'
                        + '<span class="mr5 fc f10 ilbangBadge">' + data.employList[i].work2 + '</span>' + data.employList[i].content
                        + '</span>'
                        + '<span class="mr10">경력 : ' + data.employList[i].career + '</span>'
                        + '<span class="f10 ildangBage">일당</span>'
                        + '<span>' + data.employList[i].pay + '원</span>'
                        + '</td>'
                        + '<td class="tc vm">'
                        + '<a href="javascript:delegate(' + data.employList[i].no + ', ' + page + ')">'
                        + '<div class="bg-525a71 fff mb10 margin-auto lh1" style="width: 126px; padding: 5px; border-radius: 2px;">대표 채용 공고로 설정</div>'
                        + '</a>'
                        + '<a href="../guin/form/modify.php?no=' + data.employList[i].no + '">'
                        + '<div class="di active-btn margin-auto lh1 mr10" style="width: 58px; padding: 5px; border-radius: 2px;">수정</div>'
                        + '</a>'
                        + '<a href="javascript: employDelete(' + data.employList[i].no + ', ' + page + ')">'
                        + '<div class="di active-btn margin-auto lh1" style="width: 58px; padding: 5px; border-radius: 2px;">삭제</div>'
                        + '</a>'
                        + '</td>'
                        + '<td class="tc vm">'
                        + '<span class="fc underline bold mr5">' + data.employList[i].matching + '</span>건'
                        + '</td>'
                        + '</tr>';
                    }
                }

                var cell  = document.getElementById("employPage");                

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.paging.currentSection != 1) {
                    document.getElementById("employPage").innerHTML += '<li><a href="javascript:getEmployList(' + data.paging.prevPage + ')">이전</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("employPage").innerHTML += '<li class="active"><a href="javascript:getEmployList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("employPage").innerHTML += '<li><a href="javascript:getEmployList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("employPage").innerHTML += '<li><a href="javascript:getEmployList(' + data.paging.nextPage + ')">다음</a></li>';
                }
            }
        });
    }

    function delegate(no, page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/member/delegate.php',
            data: { no: no },
            success: function(data) {
                alert(data);
                getEmployList(page);
            }
        });
    }

    function employDelete(no, page) {
        if(confirm("정말 삭제하시겠습니까?")) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/member/delete.php',
                data: { no: no },
                success: function(data) {
                    alert(data);
                    getEmployList(page);
                }
            });
        }
    }

    function getItemList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/item/getItemList.php',
            data: { page: page },
            success: function(data) {
                document.getElementById("itemList").innerHTML = '';

                for(var i=0; i<data.itemList.length; i++) {
                    document.getElementById("itemList").innerHTML
                    += '<tr class="bb">'
                    + '<td class="padding-vertical f14 w20">' + data.itemList[i].kind + '</td>'
                    + '<td class="padding-vertical f14 w30">' + data.itemList[i].name + '</td>'
                    + '<td class="padding-vertical f14 w30">' + data.itemList[i].remain + '</td>'
                    + '<td class="padding-vertical w20">'
                    + '<a href="../itemShop/itemshop.php" class="active-btn br2 p2">즉시 구매</a>'
                    + '</td>'
                    + '</tr>';
                }

                document.getElementById("itemPage").innerHTML = '';

                if(data.paging.currentSection != 1) {
                    document.getElementById("itemPage").innerHTML += '<li><a href="javascript:getItemList(' + data.paging.prevPage + ')">이전</a></li>';
                }

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("itemPage").innerHTML += '<li class="active"><a href="javascript:getItemList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("itemPage").innerHTML += '<li><a href="javascript:getItemList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("itemPage").innerHTML += '<li><a href="javascript:getItemList(' + data.paging.nextPage + ')">다음</a></li>';
                }
            }
        });
    }

    function getItemPurchaseList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/item/getItemPurchaseList.php',
            data: { page: page },
            success: function(data) {
                document.getElementById("itemPurchaseList").innerHTML = '';

                if(data.itemPurchaseList == null) {
                    document.getElementById("itemPurchaseList").innerHTML = '<div class="bb tc f14" style="padding: 30px 0;">아이템 구매 내역이 없습니다.</div>';
                } else {
                    for(var i=0; i<data.itemPurchaseList.length; i++) {
                        document.getElementById("itemPurchaseList").innerHTML
                        += '<div class="oa f14 tc bb">'
                        + '<div class="fl padding-vertical w20">' + data.itemPurchaseList[i].date + '</div>'
                        + '<div class="fl padding-vertical w20">' + data.itemPurchaseList[i].name + '</div>'
                        + '<div class="fl padding-vertical w20">' + data.itemPurchaseList[i].amount + '회</div>'
                        + '<div class="fl padding-vertical w20">' + data.itemPurchaseList[i].price + '원</div>'
                        + '<div class="fl padding-vertical w20">' + data.itemPurchaseList[i].method + '</div>'
                        + '</div>';
                    }
                }

                document.getElementById("itemPurchasePage").innerHTML = '';

                if(data.paging.currentSection != 1) {
                    document.getElementById("itemPurchasePage").innerHTML += '<li><a href="javascript:getItemPurchaseList(' + data.paging.prevPage + ')">이전</a></li>';
                }

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("itemPurchasePage").innerHTML += '<li class="active"><a href="javascript:getItemPurchaseList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("itemPurchasePage").innerHTML += '<li><a href="javascript:getItemPurchaseList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("itemPurchasePage").innerHTML += '<li><a href="javascript:getItemPurchaseList(' + data.paging.nextPage + ')">다음</a></li>';
                }
            }
        });
    }

    function getItemUseList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/item/getItemUseList.php',
            data: { page: page },
            success: function(data) {
                document.getElementById("itemUseList").innerHTML = '';

                if(data.itemUseList == null) {
                    document.getElementById("itemUseList").innerHTML = '<div class="bb tc f14" style="padding: 30px 0;">아이템 사용 내역이 없습니다.</div>';
                } else {
                    for(var i=0; i<data.itemUseList.length; i++) {
                        document.getElementById("itemUseList").innerHTML
                        += '<div class="oa f14 tc padding-vertical bb">'
                        + '<div class="w20 fl">' + data.itemUseList[i].date + '</div>'
                        + '<div class="w20 fl">' + data.itemUseList[i].name + '</div>'
                        + '<div class="w40 fl">' + data.itemUseList[i].content + '</div>'
                        + '<div class="w20 fl fc">' + data.itemUseList[i].amount + '</div>'
                        + '</div>';
                    }
                }

                document.getElementById("itemUsePage").innerHTML = '';

                if(data.paging.currentSection != 1) {
                    document.getElementById("itemUsePage").innerHTML += '<li><a href="javascript:getItemUseList(' + data.paging.prevPage + ')">이전</a></li>';
                }

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("itemUsePage").innerHTML += '<li class="active"><a href="javascript:getItemUseList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("itemUsePage").innerHTML += '<li><a href="javascript:getItemUseList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("itemUsePage").innerHTML += '<li><a href="javascript:getItemUseList(' + data.paging.nextPage + ')">다음</a></li>';
                }
            }
        });
    }

    function getReserveList(page) {
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

                if(data.length < 1) {
                    document.getElementById("adReserveList").innerHTML = '<div class="bb tc f14" style="padding: 30px 0;">내역이 없습니다.</div>';
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
                    document.getElementById("adReservePage").innerHTML += '<li><a href="javascript:getReserveList(' + data.paging.prevPage + ')">이전</a></li>';
                }

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("adReservePage").innerHTML += '<li class="active"><a href="javascript:getReserveList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("adReservePage").innerHTML += '<li><a href="javascript:getReserveList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("adReservePage").innerHTML += '<li><a href="javascript:getReserveList(' + data.paging.nextPage + ')">이전</a></li>';
                }
            }
        });
    }

    //ad머니 사용 내역
    function getUseList(page) {
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

                if(data.length < 1) {
                    document.getElementById("adUseList").innerHTML = '<div class="bb tc f14" style="padding: 30px 0;">내역이 없습니다.</div>';
                } else {
                    for(var i=0; i<data.length; i++) {
                        if(data.adUseList[i].day != "") {
                            document.getElementById("adUseList").innerHTML
                            += '<div class="oa f14 tc padding-vertical bb">'
                            + '<div class="w20 fl">' + data.adUseList[i].day + '&nbsp;&nbsp;<span style="color: #bbb;">' + data.adUseList[i].time + '</span></div>'
                            + '<div class="w15 fl">적립</div>'
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
                    document.getElementById("adUsePage").innerHTML += '<li><a href="javascript:getUseList(' + data.paging.prevPage + ')">이전</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("adUsePage").innerHTML += '<li class="active"><a href="javascript:getUseList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("adUsePage").innerHTML += '<li><a href="javascript:getUseList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("adUsePage").innerHTML += '<li><a href="javascript:getUseList(' + data.paging.nextPage + ')">다음</a></li>';
                }
            }
        });     
    }
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">
            <a href="../index.php" class="c999">HOME</a> > 
            <span class="c555 bold">마이 페이지</span>
        </div>
        <div class="c999 fr padding-vertical">
            <span class="mr5 br15 subNotice">공지</span>
            <a href="#" class="c999"><span id="adNotice"></span></a>
        </div>
    </div>
</div>
<!-- 섹션1 -->
<div class="container center pl30 mt15">
    <h3 class="di f20 mr10 mt10">마이 페이지</h3>
    <h4 class="di f12 c999">나의 정보를 볼 수 있는 마이 페이지입니다.</h4>
    <div class="row bd7">
        <div class="col-sm-6 border-right tc bg_grey p25 w44p" style="padding-top: 34px;">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 tc">
                <img src="" alt="" id="company_logo" name="company_logo" class="w144 mt20" />
            </div>
            <div class="di tl ml30">
                <div class="f14"><span class="bold"><?php echo $name; ?></span>님 환영합니다.</div>
                <?php if($kind == "company") { ?>
                <div>(기업 회원)</div>
                <?php } else if($kind == "jijeom") { ?>
                <div>(지점)</div>
                <?php } ?>
                <div class="mt25">
                    <span class="filebox">
                        <label for="ex_file" class="mb0 b525a71 br2 bg-525a71 cp fff f11" style="padding: 2px 4px;">파일 선택</label> 
                        <input type="file" id="ex_file" style="display: none;" onchange="imageUpLoad()" />
                    </span>
                    <!-- <div class="di b525a71 br2 bg-525a71 ptb1 plr4">
                        <a href="javascript:imageUpLoad()" class="cp fff f11">사진 변경</a>
                    </div> -->
                    <div class="di b525a71 br2 ptb1 plr4">
                        <a href="javascript:imageDelete()" class="cp f11">사진 삭제</a>
                    </div>
                    <p class="f12 imgUploadTxt mt10" style="color: #999;">※ 144x38 png 파일만 업로드 가능합니다.</p>
                </div>
            </div>
        </div><!-- 프로필 부분 end -->
        <div class="col-sm-2 border-right tc p25" style="padding: 43px 25px;"> 
            <div class="f14 bold">채용 공고 등록 수</div>
            <div><a href="../guin.php?tab=2"><span class="f25 fc underline bold" id="myEmploy"></span></a>개</div>
            <div class="di mt8 br5 border-grey vm" style="padding: 2px 8px;">
                <a href="javascript:applicationCheck(1)" class="cp">새 채용 공고 작성</a>
            </div>
        </div><!-- 신청서 등록수 end -->
        <div class="col-sm-2 border-right tc p25" style="padding: 43px 25px;"> 
            <div class="f14 bold">매칭된 리스트 보기</div>
            <div><a href="../guin.php?tab=3"><span class="f25 fc underline bold" id="myMatching"></span></a>개</div>
            <div class="di mt8 br5 border-grey vm" style="padding: 2px 8px;">
                <a href="../guin.php?tab=3" class="cp">매칭 리스트 보기</a>
            </div>
        </div><!-- 매칭된 리스트 end -->
        <div class="col-sm-2 tc p25 w22p" style="padding: 43px 25px;"> 
            <div class="f14 bold">나의 AD머니</div>
            <div class="f25 fc"><a href="../ad/adMoney.php"><span class="underline bold fc" id="myADMoney"></span></a> P</div>
            <div style="margin-top: 14px;">
                <span class="vm br5 border-grey mr5" style="padding: 3px 8px;"><a href="../ad/adReserve.php" class="cp">적립하기</a></span>
                <span class="vm br5 border-grey" style="padding: 3px 8px;"><a href="../pointmall/pointmall.php" class="cp">포인트몰 가기</a></span>
            </div>
        </div><!-- 나의 AD머니 -->
    </div>
</div>                          
<!-- 마이페이지 tab -->
<div class="container center pl30 mb40">
    <div class="mt15"> 
        <ul class="nav nav-pills nav-justified">
            <li class="active changeCt cmypageTabLi"><a data-toggle="tab" href="#menu1" class="bg-6d7382 fff">개인 정보 관리 / 비밀번호 변경</a></li>
            <li class="cmypageTabLi"><a data-toggle="tab" href="#menu2" class="bg-6d7382 fff">채용 공고 관리</a></li>
            <li class="cmypageTabLi"><a data-toggle="tab" href="#menu3" class="bg-6d7382 fff">아이템 사용 내역</a></li>
            <li class="cmypageTabLi"><a data-toggle="tab" href="#menu4" class="bg-6d7382 fff">AD머니 사용 / 적립 내역</a></li>
        </ul>
        <div class="tab-content">
            <div id="menu1" class="tab-pane in active ml15 mr15">
              <div class="mt5">
                <h3 class="di f16 bold">개인 정보 관리 / 비밀번호 변경</h3>
                <h4 class="di f12 fr mt25">각 항목은 구인/구직시 사용되오니 정보를 정확히 입력해주세요.</h4>
                <!-- 개인 정보 관리 / 비밀번호 변경-->
                <div class="bt3 lh20 f14">
                    <form action="modify.php" method="post" class="form-horizontal" onsubmit="return formCheck()">
                        <div class="bd-left2 border-right border-bottom">
                            <div class="form-group mglr0 ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl" for="id">아이디</label>
                                <span class="col-sm-10 pl15 mt8 lh30"><?php echo $uid; ?></span>
                            </div>
                            <div class="form-group mglr0 ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl" for="pwd">비밀번호</label>
                                <div class="col-sm-10 pl15 mt8">
                                    <input type="password" class="form-control w30 di" id="pwd" name="pwd" placeholder="비밀번호를 입력해주세요." />
                                </div>
                            </div>
                            <div class="form-group mglr0 ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl" for="pwd2">비밀번호 확인</label>
                                <div class="col-sm-10 pl15 mt8">
                                    <input type="password" class="form-control w30" id="pwd2" placeholder="비밀번호를 재입력해주세요." />
                                </div>
                            </div>
                            <div class="form-group ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl">사업자 등록 번호</label>
                                <div class="form-group mglr0 ml0 mb0 lh30">
                                    <span class="col-sm-10 pl15 mt8 lh30" id="myNumber"></span>
                                </div>
                            </div>
                            <div class="form-group mglr0 ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl">기업명</label>
                                <div class="form-group mglr0 ml0 mb0 lh30">
                                    <span class="col-sm-10 pl15 mt8 lh30" id="myCompany"></span>
                                </div>
                            </div>
                            <div class="form-group mglr0 ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl">이름</label>
                                <div class="col-sm-10 pl15 mt8"><?php echo $name; ?></div>
                            </div>
                            <div class="form-group mglr0 ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl">업종 <span class="fc">*</span></label>
                                <div class="col-sm-10 pl15 mt8">
                                    <select id="types" name="types" class="di h30p mr1p" style="width: 120px;">
                                        <option value="서비스업">서비스업</option>
                                        <option value="제조/화학">제조/화학</option>
                                        <option value="의료/제약/복지">의료/제약/복지</option>
                                        <option value="판매/유통">판매/유통</option>
                                        <option value="교육업">교육업</option>
                                        <option value="건설업">건설업</option>
                                        <option value="IT/통신">IT/통신</option>
                                        <option value="미디어/디자인">미디어/디자인</option>
                                        <option value="은행/금융업">은행/금융업</option>
                                        <option value="기관/협회">기관/협회</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mglr0 ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl" for="comp_type">기업 형태 <span class="fc">*</span></label>
                                <div class="col-sm-10 pl15 mt8">
                                    <select id="status" name="status" class="di h30p" style="width: 120px;">
                                        <option value="소기업">소기업</option>
                                        <option value="중기업">중기업</option>
                                        <option value="대기업">대기업</option>
                                        <option value="벤쳐기업">벤쳐기업</option>
                                        <option value="외국계기업">외국계기업</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl">설립연도</label>
                                <div class="form-group mglr0 ml0 mb0 lh30">
                                    <span class="col-sm-10 pl15 mt8 lh30" id="myFlotation"></span>
                                </div>
                            </div>
                            <div class="form-group ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl">휴대폰 번호 <span class="fc">*</span></label>
                                <div class="col-sm-10 pl15 mt8">
                                    <input type="text" class="form-control di w10" id="phone1" name="phone1" />
                                    <span class="mt10" style="margin: 0 5px;">-</span>
                                    <input type="text" class="form-control di w10" id="phone2" name="phone2" />
                                    <span class="mt10" style="margin: 0 5px;">-</span>
                                    <input type="text" class="form-control di w10 mr10" id="phone3" name="phone3" />
                                    <span class="c-green" id="valid"></span>
                                </div>
                            </div>
                            <div class="form-group ml0 mb0 border-bottom lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl" for="birth">생년월일 / 성별</label>
                                <div class="col-sm-10 pl15 mt8">
                                    <span id="birth_sex"></span>
                                </div>
                            </div>
                            <div class="form-group ml0 mb0 lh30">
                                <label class="control-label col-sm-2 bg_grey myInfo-label-pd tl">메일 주소 <span class="fc">*</span></label>
                                <div class="col-sm-10 pl15 mt8">
                                    <input type="text" class="form-control di w15" id="email1" name="email1" style="height: 32px;" />
                                    <span class="mt10" style="margin: 0 5px;">@</span>
                                    <input type="text" class="form-control info-email di mr10" id="email2" name="email2" style="height: 32px;" />
                                    <select class="info-email di" style="height: 32px;" onchange="emailChange(this.value)">
                                        <option value="" selected>직접 입력</option>
                                        <option value="naver.com">naver.com</option>
                                        <option value="gmail.com">gmail.com</option>
                                        <option value="hanmail.net">hanmail.net</option>
                                        <option value="nate.com">nate.com</option>
                                    </select>
                                    <span class="fc ml15" id="emailCheck"></span>
                                </div>
                            </div>
                            <script>
                                function emailChange(val) {
                                    if(val == "") {
                                        document.getElementById("email2").readOnly = false;
                                        document.getElementById("email2").value = "";
                                        document.getElementById("email2").focus();
                                    } else {
                                        document.getElementById("email2").value = val;
                                        document.getElementById("email2").readOnly = true;
                                    }
                                }
                            </script>
                        </div>
                        <div class="form-group mt50">
                            <div class="tc">
                                <a href="#" data-toggle="modal" data-target="#withdrawalModal"><div class="di info-outbtn bold">탈퇴하기</div></a>
                                <input type="submit" class="di info-modibtn" value="수정하기" />
                                <a href="javascript:valid_btn()" id="validBtn"><div class="di info-certibtn">본인 인증</div></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal c666" id="withdrawalModal">
                    <div class="modal-dialog" style="width: 300px; margin-top: 20%;">
                        <div class="modal-content" style="border: 5px solid #eb5f43;">
                            <div class="modal-body f14 tc" style="padding: 30px 10%;">
                                <div class="bold f15">정말 <span class="fc">탈퇴</span>하시겠습니까?</div>
                                <select class="w100 mb5 mt15" id="withdrawal_sel">
                                    <option value="" selected>탈퇴 이유 선택</option>
                                    <option value="사용 방법이 어렵고 복잡합니다.">사용 방법이 어렵고 복잡합니다.</option>
                                    <option value="다른 종류의 어플을 사용합니다.">다른 종류의 어플을 사용합니다.</option>
                                    <option value="사용할 일이 없어서">사용할 일이 없어서</option>
                                    <option value="개인 정보 도용">개인 정보 도용</option>
                                </select>
                                <div class="mb5">
                                    <input type="text" class="form-control" id="withdrawal_id" placeholder="아이디 입력" />
                                </div>
                                <div class="mb10">
                                    <input type="password" class="form-control" id="withdrawal_pwd" placeholder="비밀번호 입력" />
                                </div>
                                <a href="javascript:withdrawal()" class="f16">
                                    <div class="margin-auto active-btn padding-vertical">탈퇴하기</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function formCheck() {
                        var pwd = document.getElementById("pwd").value;
                        var pwd2 = document.getElementById("pwd2").value;
                        var phone1 = document.getElementById("phone1").value;
                        var phone2 = document.getElementById("phone2").value;
                        var phone3 = document.getElementById("phone3").value;
                        var email1 = document.getElementById("email1").value;
                        var email2 = document.getElementById("email2").value;

                        if(pwd != "" && pwd.length < 6) {
                            alert("비밀번호가 너무 짧습니다. (6자 이상)");
                            document.getElementById("pwd").focus();
                            return false;
                        } else if(pwd != pwd2) {
                            alert("비밀번호가 맞지 않습니다.");
                            return false;
                        } else if(phone1 == "") {
                            alert("휴대폰 번호를 입력해주세요.");
                            document.getElementById("phone1").focus();
                            return false;
                        } else if(phone2 == "") {
                            alert("휴대폰 번호를 입력해주세요.");
                            document.getElementById("phone2").focus();
                            return false;
                        } else if(phone3 == "") {
                            alert("휴대폰 번호를 입력해주세요.");
                            document.getElementById("phone3").focus();
                            return false;
                        } else if(phone1.length < 3) {
                            alert("휴대폰 번호를 똑바로 입력해주세요.");
                            document.getElementById("phone1").focus();
                            return false;
                        } else if(phone2.length < 3) {      //3자리인 사람도 있음
                            alert("휴대폰 번호를 똑바로 입력해주세요.");
                            document.getElementById("phone2").focus();
                            return false;
                        } else if(phone3.length < 4) {
                            alert("휴대폰 번호를 똑바로 입력해주세요.");
                            document.getElementById("phone3").focus();
                            return false;
                        } else if(email1 == "") {
                            alert("메일 주소를 입력해주세요.");
                            document.getElementById("email1").focus();
                            return false;
                        } else if(email2 == "") {
                            alert("메일 주소를 입력해주세요.");
                            document.getElementById("email2").focus();
                            return false;
                        } else if(email1 == "undefined" || email2 == "undefined") {
                            alert("메일 주소를 수정해주세요.");
                            return false;
                        }

                        return true;
                    }

                    function withdrawal() {
                        var withdrawalSel = $("#withdrawal_sel option:selected").val();
                        var withdrawalId = document.getElementById("withdrawal_id").value;
                        var withdrawalPwd = document.getElementById("withdrawal_pwd").value;

                        if(confirm("정말 탈퇴하시겠습니까?")) {
                            if(withdrawalSel == "") {
                                alert("탈퇴 이유를 선택해주세요.");
                                document.getElementById("withdrawal_sel").focus();
                            } else if(withdrawalId == "") {
                                alert("아이디를 입력해주세요.");
                                document.getElementById("withdrawal_id").focus();
                            } else if(withdrawalPwd == "") {
                                alert("비밀번호를 입력해주세요.");
                                document.getElementById("withdrawal_pwd").focus();
                            } else {
                                $.ajax({
                                    type: 'post',
                                    dataType: 'json',
                                    url: '../ajax/member/withdrawal.php',
                                    data: { withSel: withdrawalSel, withId: withdrawalId, withPwd: withdrawalPwd },
                                    success: function(data) {
                                        alert(data.message);

                                        if(data.check == 1) {
                                            document.location.href = "../index.php";
                                        }
                                    }
                                });
                            }
                        }
                    }
                </script>
               </div>
            </div><!-- 1번째 tab end -->    
            <div id="menu2" class="tab-pane ml15 mr15">
                <div class="center mt5">
                    <h3 class="di f16 bold">채용 공고 관리</h3>
                    <a href="javascript:applicationCheck(1)" class="fff">
                        <div class="di fr lh1 mt15" style="background-color: #5172b8; padding: 5px;">채용 공고 작성</div>
                    </a>
                </div>
                <table class="table table-condensed mb10">
                    <thead class="bg_grey bt2_999">
                        <tr class="bb">
                            <th class="tc bbn lh30 f14 bb fwN">등록일 / 공개 여부</th>
                            <th class="tc bbn lh30 f14 bb fwN">채용 공고 제목</th>
                            <th class="tc bbn lh30 f14 bb fwN">채용 공고 관리</th>
                            <th class="tc bbn lh30 f14 bb fwN">매칭 건수</th>
                        </tr>
                    </thead>
                    <tbody id="employList"></tbody>
                </table>
                <div class="tc f14" id="noEmploy"></div>
                <div class="center tc pb5 mt20">
                    <ul class="pagination" id="employPage"></ul>
                </div>
            </div><!-- 2번째 tab end -->
            <div id="menu3" class="tab-pane ml15 mr15 mt5">
                <div class="center">
                    <div class="oa">
                        <h3 class="f16 fl bold">아이템 보유 내역</h3>
                        <a href="../itemShop/itemshop.php">
                            <span class="c888 fr lh1 mt15" style="border: 1px solid #bbb; padding: 5px;">아이템샵</span>
                        </a>
                        <table class="table mb0">
                            <thead>
                                <tr class="bt2_999 bg_grey">
                                    <th class="tc f14 bb fwN padding-vertical w20">구분</th>
                                    <th class="tc f14 bb fwN padding-vertical w30">상품명</th>
                                    <th class="tc f14 bb fwN padding-vertical w30">기간 / 남은 횟수</th>
                                    <th class="tc f14 bb fwN padding-vertical w20">상품 구매</th>
                                </tr>
                            </thead>
                            <tbody class="tc" id="itemList"></tbody>
                        </table>
                        <div class="tc" id="noItem"></div>
                        <div class="center tc pb5">
                            <ul class="pagination" id="itemPage"></ul>
                        </div>
                    </div>
                    <div class="oa">
                        <h3 class="f16 bold">아이템 구매 내역</h3>
                        <div class="oa f14 tc adListBorder">
                            <div class="fl padding-vertical bg_grey w20">결제 날짜</div>
                            <div class="fl padding-vertical bg_grey w20">상품명</div>
                            <div class="fl padding-vertical bg_grey w20">수량</div>
                            <div class="fl padding-vertical bg_grey w20">결제 금액</div>
                            <div class="fl padding-vertical bg_grey w20">결제 방식</div>
                        </div>
                        <div id="itemPurchaseList"></div>
                        <div class="center tc pb5 mt20">
                            <ul class="pagination" id="itemPurchasePage"></ul>
                        </div>
                    </div>
                    <div class="oa">
                        <h3 class="f16 bold">아이템 사용 내역</h3>
                        <div class="oa f14 tc adListBorder bg_grey padding-vertical">
                            <div class="w20 fl">사용 날짜</div>
                            <div class="w20 fl">상품명</div>
                            <div class="w40 fl">사용 내용</div>
                            <div class="w20 fl">차감 수량</div>
                        </div>
                        <div id="itemUseList"></div>
                        <div class="center tc pb5 mt20">
                            <ul class="pagination" id="itemUsePage"></ul>
                        </div>
                    </div>
                </div><!-- 아이템사용내역 end -->
            </div><!-- 3번째 tab end -->
          <div id="menu4" class="tab-pane ml15 mr15">
            <div class="center mt5">
                    <div class="oa">
                        <h3 class="f16 fl bold">나의 AD머니</h3>
                        <a href="../ad/adReserve.php">
                            <span class="c니888 fr lh1 mt15" style="border: 1px solid #bbb; padding: 5px;">AD머니 적립</span>
                        </a>
                        <div class="clear"></div>
                        <div class="oa f14 tc adListBorder">
                            <div class="fl padding-vertical bg_grey w20">현재 나의 AD머니</div>
                            <div class="fl bold padding-vertical c888 w30"><span id="myPoint" class="fc"></span> P</div>
                            <div class="fl padding-vertical bg_grey w20">적립된 AD머니</div>
                            <div class="fl bold padding-vertical c888 w30" id="reservedPoint"></div>
                        </div>
                        <div class="oa f14 tc mb30" style="border-bottom: 1px solid #ddd;">
                          <div class="fl padding-vertical bg_grey w20">사용한 AD머니</div>
                          <div class="fl bold padding-vertical c888 w30" id="usedPoint"></div>
                        </div>
                    </div>
                    <h3 class="f16 bold">AD머니 적립 내역</h3>
                    <div class="oa f14 tc adListBorder bg_grey padding-vertical">
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
                    <h3 class="f16 bold">AD머니 사용 내역</h3>
                    <div class="oa f14 tc adListBorder bg_grey padding-vertical">
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
          </div><!-- 4번째 tab end -->
      </div>
    </div>
  </div>
  <script type="text/javascript">
    // 파라미터 가져오는 펑션 - 재훈씨
        function getQuerystring(paramName){

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
      // $(".guingujikTabLi").removeClass("active");
      // $(".guingujikTabLi").removeClass("db");
      if(param=='1'){
        $(".cmypageTabLi,.tab-pane").removeClass('active')
        $(".cmypageTabLi").eq(0).addClass('active')
        $("#menu1").addClass('active')
      } else if(param=='2'){
          $(".cmypageTabLi,.tab-pane").removeClass('active')
          $(".cmypageTabLi").eq(1).addClass('active')
          $("#menu2").addClass('active')

        // alert();
      } else if(param=='3'){
          $(".cmypageTabLi,.tab-pane").removeClass('active')
          $(".cmypageTabLi").eq(2).addClass('active')
          $("#menu3").addClass('active')
      } else if(param=='4'){
          $(".cmypageTabLi,.tab-pane").removeClass('active')
          $(".cmypageTabLi").eq(3).addClass('active')
          $("#menu4").addClass('active')
      }

</script>  
<?php include_once "../include/footer.php"; ?>