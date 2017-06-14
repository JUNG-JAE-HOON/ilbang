<?php include_once "../include/header.php"; ?>
<script>
    $(document).ready(function() {
        getNotice();
    });

    function getNotice() {
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
</script>
<div class="wdfull">
    <div class="container center wdfull bb mb15">
        <div class="pg_rp"> 
            <div class="c999 fl subTitle">
                <a href="index.php" class="c999">HOME</a>
                <span class="plr5">></span>
                <a href="guin.php" class="bold">하나 멤버스</a>
            </div>
            <div class="c999 fr padding-vertical">
                <span class="mr5 br15 subNotice">공지</span>
                <span id="adNotice"></span>
            </div>
        </div>
    </div>
</div>
<div class="hanaMembersWrap wdfull center">
    <div class="container mt50 mb60">
        <div class="tc mb35">
            <img src="http://il-bang.com/pc_renewal/images/hanaMembers01.png" alt="일방 하나멤버스 멤버십카드" class="tc" /></div>
        <div class="tc mb45">
            <img src="http://il-bang.com/pc_renewal/images/hanaMembers02.png" alt="하나금융그룹에서 제공하는 멤버십 서비스로서 하나머니 적립,충전,사용서비스 및 각종 고객 우대 프로그램을 제공합니다." class="tc" />
        </div>
        <div class="tc">
            <img src="http://il-bang.com/pc_renewal/images/hanaMembers03.png" alt="하나멤버스카드" class="tc" />
        </div>
    </div>
    <div class="hanaMemberBox">
        <div class="container">    
            <div class="hanaMemberSmallBox">
                <img src="http://il-bang.com/pc_renewal/images/hanaMembers04.png" alt="하나멤버스 1Q카드 Daily" />
                <div class="fr hanaSmallTxt">
                    <p class="f16 bold mb15">
                        <span class="c-3e9fa5">포인트를 현금처럼 쓰는</span>하나멤버스 신용카드
                    </p>
                    <p class="f14 border-bottom pb7 mb5">
                        <span class="bold">브랜드</span>
                        <img src="http://il-bang.com/pc_renewal/images/hanaMembers06.png" class="pl15">
                    </p>
                    <div class="f14 mb25">
                        <span class="bold fl">연회비</span>
                         <div class="di pl15"> 
                            <p>국내전용 8,000원</p>
                            <p>국내전용 10,000원</p>
                        </div><div class="clear"></div>
                    </div>
                    <a href=" http://www.hanacard.co.kr/hscroute.jsp?goURL=/PI42000000D.web?_frame=no&CD_PD_SEQ=5261&bansrc=ilbang&ban_nm=daily" class="hanaBtn">Daily 카드 발급하기</a>
                </div>
            </div>
            <div class="hanaMemberSmallBox2">
                <img src="http://il-bang.com/pc_renewal/images/hanaMembers05.png" alt="하나멤버스 Mega 체크카드" />
                <div class="fr hanaSmallTxt">
                    <p class="f16 bold mb15">
                        <span class="c-3e9fa5">포인트를 현금처럼 쓰는</span>하나멤버스 신용카드
                    </p>
                    <p class="f14 border-bottom pb7 mb5">
                        <span class="bold">브랜드</span>
                        <img src="http://il-bang.com/pc_renewal/images/hanaMembers06.png" class="pl15">
                    </p>
                    <div class="f14 mb25">
                        <span class="bold fl">연회비</span>
                         <div class="di pl15"> 
                            <p>국내전용 8,000원</p>
                            <p>국내전용 10,000원</p>
                        </div><div class="clear"></div>
                    </div>
                    <a href="http://www.hanacard.co.kr/hscroute.jsp?goURL=/PI42000000D.web?_frame=no&CD_PD_SEQ=5262&bansrc=ilbang&ban_nm=megacheck" class="hanaBtn2">체크카드 발급하기</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once "../include/footer.php" ?>