<?php include_once "../include/header.php"; ?>
<script>
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
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > AD머니 > <b class="c555">AD머니 광고 규정</b></div>
        <div class="c999 fr padding-vertical">
            <span class="mr5 br15 subNotice">공지</span>
            <span id="adNotice"></span></a>
        </div>
    </div>
</div>
<div class="adbg mt15 wdfull oh" style="border-bottom: 1px solid #bbb;">
    <div class="margin-auto pdt40" style="width: 1005px;"> 
        <div class="mr200 fl" style="width: 375px;"><img src="../images/regulations1.png" /></div>
        <div class="fl" style="width: 430px;"><img src="../images/regulations2.png" /></div>
    </div>
</div>
<div class="wdfull c666 tc">
    <div class="margin-auto mt50" style="width: 120px;">
        <img src="../images/regulations3.png" />
    </div>
    <div class="f14 mt20">
        <div>일방에서는 좀더 효과적이고 효율적인 광고를 제공합니다.</div>
        <div class="mt5">모두 안심하고 이용하세요.</div>
    </div>
    <div class="margin-auto" style="width: 900px;">
        <div class="adRegulBox mt50 f14 oa">
            <div class="f16 fl adRegulBoxLeft adRegulBa">배너</div>
            <div class="fl bold adRegulBoxRight bb br">금액</div>
            <div class="fl bold adRegulBoxRight bb">규격</div>
            <div class="fl adRegulBoxRight bb2999 br">1,000,000</div>
            <div class="fl adRegulBoxRight bb2999">3컷</div>
            <div class="fl bold adRegulBoxRight bb br">1회차</div>
            <div class="fl bold adRegulBoxRight bb">2회차</div>
            <div class="fl adRegulBoxRight bb br">
                <div class="w33 fl">광고 포인트</div>
                <div class="w33 fl">지급 포인트(P)</div>
                <div class="w33 fl">참여 인원(명)</div>
            </div>
            <div class="fl adRegulBoxRight bb">
                <div class="w33 fl">광고 포인트</div>
                <div class="w33 fl">지급 포인트(P)</div>
                <div class="w33 fl">참여 인원(명)</div>
            </div>
            <div class="fl adRegulBoxRight br">
                <div class="w33 fl">500,000</div>
                <div class="w33 fl">50</div>
                <div class="w33 fl">10,000</div>
            </div>
            <div class="fl adRegulBoxRight">
                <div class="w33 fl">750,000</div>
                <div class="w33 fl">50</div>
                <div class="w33 fl">15,000</div>
            </div>
        </div>
        <div class="mt15 fc tl pl10">
            <span class="mr20">* 포인트 지급 광고주 선택</span>
            <span>* 타겟 광고 (지역, 성별, 연령대)</span>
        </div>
        <div class="adRegulBox mt80 f14 oa">
            <div class="f16 fl adRegulBoxLeft adRegulVi">동영상</div>
            <div class="fl bold adRegulBoxRight bb br">금액</div>
            <div class="fl bold adRegulBoxRight bb">규격</div>
            <div class="fl adRegulBoxRight br">2,000,000</div>
            <div class="fl adRegulBoxRight">30초</div>
            <div class="fl adRegulBoxRight br">3,000,000</div>
            <div class="fl adRegulBoxRight">40초</div>
            <div class="fl adRegulBoxRight bb2999 br">5,000,000</div>
            <div class="fl adRegulBoxRight bb2999">50초</div>
            <div class="fl bold adRegulBoxRight bb br">1회차</div>
            <div class="fl bold adRegulBoxRight bb">2회차</div>
            <div class="fl adRegulBoxRight bb br">
                <div class="w33 fl">광고 포인트</div>
                <div class="w33 fl">지급 포인트(P)</div>
                <div class="w33 fl">참여 인원(명)</div>
            </div>
            <div class="fl adRegulBoxRight bb">
                <div class="w33 fl">광고 포인트</div>
                <div class="w33 fl">지급 포인트(P)</div>
                <div class="w33 fl">참여 인원(명)</div>
            </div>
            <div class="fl adRegulBoxRight br">
                <div class="w33 fl">1,000,000</div>
                <div class="w33 fl">100</div>
                <div class="w33 fl">10,000</div>
            </div>
            <div class="fl adRegulBoxRight">
                <div class="w33 fl">1,500,000</div>
                <div class="w33 fl">100</div>
                <div class="w33 fl">15,000</div>
            </div>
            <div class="fl adRegulBoxRight br">
                <div class="w33 fl">1,500,000</div>
                <div class="w33 fl">50</div>
                <div class="w33 fl">15,000</div>
            </div>
            <div class="fl adRegulBoxRight">
                <div class="w33 fl">2,250,000</div>
                <div class="w33 fl">100</div>
                <div class="w33 fl">22,500</div>
            </div>
            <div class="fl adRegulBoxRight br">
                <div class="w33 fl">2,500,000</div>
                <div class="w33 fl">50</div>
                <div class="w33 fl">25,000</div>
            </div>
            <div class="fl adRegulBoxRight">
                <div class="w33 fl">3,750,000</div>
                <div class="w33 fl">100</div>
                <div class="w33 fl">37,500</div>
            </div>
        </div>
        <div class="mt15 fc tl pl10">
            <span class="mr20">* 포인트 지급 광고주 선택</span>
            <span>* 타겟 광고 (지역, 성별, 연령대)</span>
        </div>
        <div class="oa margin-auto mt80" style="width: 310px;">
            <a href="adProposal.php" class="adBtn fl mr10 fff" style="background-color: #43495c;">AD광고 신청</a>
            <a href="adProposal.php?tab=3" class="adBtn fl bg_white" style="color: #43495c;">신청 내역 보기</a>
        </div>
    </div>
</div>
<div class="pdtb30 oa margin-auto" style="width: 1100px;" >
    <?php include_once "adFooter.php"; ?>
</div>
<?php include_once "../include/footer.php"; ?>