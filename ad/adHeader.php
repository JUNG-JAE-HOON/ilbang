<script>
    $(document).ready(function() {
        getNotice();
        getADMoney();
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

    function getADMoney() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getMyADMoney.php',
            success: function(data) {
                document.getElementById("MyAD").innerHTML = data.myAD.point;
            }
        });
    }
 </script> 
<div class="adbg mt15 wdfull pdtb20">
    <div class="oa margin-auto" style="width: 900px;">
        <div class="fl" style="width: 310px; height: 100px;">
            <div class="f14 mb20 c666 lh26">
                일방 회원들이 <span class="fc">광고를 시청하면 AD머니 포인트를</span><br />
                <span class="fc">적립받으며</span>, 적립 받은 포인트를 E-머니로 전환하여<br />
                <span class="fc">포인트몰에서 사용</span>이 가능합니다.<br />            
            </div>
            <a href="adRegulations.php"><span class="bg_white br15 f13 pdtb5lr10">AD머니 광고 규정 보기 ></span></a>
        </div>
        <div class="fr pdt10" style="width: 340px; height: 135px;">
            <div class="tc fl mb20 mr20" style="width: 180px;">
                <div class="fc mb15">나의 AD머니</div>
                <div class="bg br30 f22 fff underline lh50" id="MyAD"></div>                    
            </div> 
            <a href="adUseList.php">
                <div class="di fl tc pt10 f10 fc br50p adBlackCircle">
                    <img src="http://il-bang.com/pc_renewal/images/adTopIcon.png" alt="사용내역" class="w15p ha">
                    <span class="db mt3">사용 내역</span>
                </div>
            </a>
            <div class="c666 f13 clear"><span class="bold">포인트몰에서 AD머니</span>로 다양한 상품을 구매하실 수 있습니다.</div>
        </div>
    </div>
</div>