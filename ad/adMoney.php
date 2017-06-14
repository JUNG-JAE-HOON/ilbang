<?php include_once "../include/header.php"; ?>
<script>
    //공지사항 리스트
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: '../ajax/notice/getNoticeList.php',
        success: function(data) {
            for(var i=0; i<5; i++) {
                document.getElementById("noticeList").innerHTML
                += '<div class="oa clear adNoticeList">'
                + '<a href="../notice/view.php?no=' + data.noticeList[i].no + '">'
                + '<span class="c666">' + data.noticeList[i].title + '</span>'
                + '</a>'
                + '<span class="c888 fr">' + data.noticeList[i].date + '</span>'
                + '</div>';
            }
        }
    });
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > <b class="c555">AD머니</b></div>
        <div class="c999 fr padding-vertical">
            <span class="mr5 br15 subNotice">공지</span>
            <a href="#" class="c999"><span id="adNotice"></span></a>
        </div>
    </div>
</div>
<?php include_once "adHeader.php"; ?>
<div class="pdtb30 oa margin-auto container pl25"> 
    <div class="mb5">
        <span class="f16 bold mr5 c666">AD머니</span>
        <span class="c888">회원들이 광고를 끝까지 보고 퀴즈를 풀면 포인트가 적립됩니다.</span>
    </div>
    <div class="mt15">    
        <a class="di fl adBox1 mr5" href="adReserve.php">
            <div class="tc c666 fl adBigbox">
                <img src="http://il-bang.com/pc_renewal/images/admoneyBox01.png" alt="AD머니적립" class="mt50">
                <hr class="csHr mb25">
                <div class="f14 bold mb5">AD머니 적립</div>
                <div class="lh14 c888 mt15">광고를 보고 AD머니 포인트를<br />적립하실 수 있습니다.</div>
            </div>
        </a>
        <div class="tc c666 fl f14 mb60 adBigbox2">
            <a class="di fl" href="adUseList.php">
                <div class="adSmallbox mr5">
                    <img src="http://il-bang.com/pc_renewal/images/admoneyBox02.png" alt="AD머니 사용내역" class="mt30" />
                    <span class="db mt20 bold">AD머니 사용 내역</span>
                </div>
            </a>
            <a class="di fl" href="../pointmall/pointmall.php">
                <div class="adSmallbox mr5">
                    <img src="http://il-bang.com/pc_renewal/images/admoneyBox03.png" alt="포인트몰" class="mt30" />
                    <span class="db mt15 bold">포인트몰</span>
                </div>
            </a>
            <a class="di fl" href="adProposal.php">
                <div class="adSmallbox mr5">
                    <img src="http://il-bang.com/pc_renewal/images/admoneyBox04.png" alt="광고신청" class="mt30" />
                    <span class="db mt20 bold">광고 신청</span>
                </div>
            </a>
            <a class="di fl" href="adRegulations.php">
                <div class="adSmallbox">
                    <img src="http://il-bang.com/pc_renewal/images/admoneyBox05.png" alt="AD머니 광고규정" class="mt30" />
                    <span class="db mt25 bold">AD머니 광고 규정</span>
                </div>
            </a><br />
            <a class="di fl w100" href="hanaMembers.php">            
                <div class="fl mt5 adMediumbox tl">                
                    <div class="mb10 f16 bold" style="color: #28a2a4;">하나 멤버십 카드</div>
                    <div class="c888">하나머니 적립, 충전, 사용 서비스 및 각종<br />고객 우대 프로그램을 제공하고 있습니다.</div>                
                </div>
            </a>
            <!-- <a class="di fl w100 longBan_mobile" href="hanaMembers.php">            
                <div class="fl mt5 adMediumbox tl">                
                    <div class="mb10 f16 bold" style="color: #28a2a4;">하나 멤버십 카드</div>
                    <div class="c888">하나머니 적립, 충전, 사용 서비스 및 각종<br />고객 우대 프로그램을 제공하고 있습니다.</div>                
                </div>
            </a> -->
        </div>
    </div>
    <div class="clear"></div>
    <div class="clear pb10" style="border-bottom: 1px solid #555;">
        <span class="f16 bold mr5 c666">공지사항</span>
        <span class="c888">일방의 다양한 소식을 전해 드립니다.</span>
        <a href="../notice/news.php"><span class="fr adMore">더보기 +</span></a>
    </div>
    <div id="noticeList"></div>
    <div class="pb10 mt60">
        <div class="border-bottom bc_darkgrey pb10">
            <span class="f16 bold mr5 c666">업무 제휴</span>
            <span class="c888">업무 제휴 신청을 하시면 일방의 제휴 업체가 되실 수 있습니다.</span>
            <a href="cooperation.php"><span class="fr adMore">더보기 +</span></a>
        </div>
        <div class="adPartnerWrap row mt15">
            <div class="col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                <a href="http://www.goodtv.co.kr"><span class="db tr p5">바로가기 +</span></a>
                <div class="mt20 mb20">
                    <img src="http://il-bang.com/pc_renewal/images/adPartner01.png">
                    <p class="mt40">굿티비</p>
                </div>  
            </div>
            <div class="col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                <a href="http://tshome.co.kr/"><span class="db tr p5">바로가기 +</span></a>
                <div class="mt20 mb20">
                    <img src="http://il-bang.com/pc_renewal/images/adPartner02.png">
                    <p class="mt40">TS 솔루션</p>
                </div>  
            </div>
            <div class="col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                <!-- <a href="javascript:void(0);"><span class="db tr p5">바로가기 +</span></a> -->
                <div class="mt47 mb20">
                    <img src="http://il-bang.com/pc_renewal/images/adPartner03.png">
                    <p class="mt40">텐플러스</p>
                </div>  
            </div>
            <div class="col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                <a href="http://www.caa.or.kr/"><span class="db tr p5">바로가기 +</span></a>
                <div class="mt20 mb20">
                    <img src="http://il-bang.com/pc_renewal/images/adPartner04.png">
                    <p class="mt40">대한 팔씨름협회</p>
                </div>  
            </div>
            <div class="col-sm-4 w19_2 border-grey bg_f8 tc">
                <a href="http://maj.fgtv.com/"><span class="db tr p5">바로가기 +</span></a>
                <div class="mt20 mb20">
                    <img src="http://il-bang.com/pc_renewal/images/adPartner05.png">
                    <p class="mt40">순복음취업박람회</p>
                </div>  
            </div>
        </div>
    </div>
    <?php include_once "adFooter.php"; ?>
</div>
<?php include_once "../include/footer.php"; ?>