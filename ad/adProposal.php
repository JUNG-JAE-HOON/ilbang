<?php
    include_once "../include/header.php";

    $tab = $_GET["tab"];
?>
<script>
    $(document).ready(function () {
        getProposalList(1);
    });

    function getProposalList(page) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getADProposalList.php',
            data: { page: page },
            success: function(data) {
                var id = "<?php echo $uid; ?>";

                if(id == "") {
                    document.getElementById("adProposalList").innerHTML = '<div class="f14 tc bb" style="padding: 5% 0;">로그인 해주시기 바랍니다.</div>';
                } else {
                    var cell = document.getElementById("adProposalList");

                    while (cell.hasChildNodes()) {
                        cell.removeChild(cell.firstChild);
                    }

                    if(data.adProposalList == null) {
                        document.getElementById("adProposalList").innerHTML = '<div class="bb f14" style="padding: 5% 0;">신청 내역이 없습니다.</div>';
                    } else {
                        for(var i=0; i<data.adProposalList.length; i++) {
                            document.getElementById("adProposalList").innerHTML
                            += '<div class="oa bb adFormTitle">'
                            + '<div class="w20 fl">' + data.adProposalList[i].day + '&nbsp;&nbsp;<span style="color: #bbb;">' + data.adProposalList[i].time + '</span></div>'
                            + '<div class="w15 fl">' +data.adProposalList[i].typeTitle + '</div>'
                            + '<div class="w30 fl bold">' + data.adProposalList[i].title + '</div>'
                            + '<div class="w15 fl">' + data.adProposalList[i].expose + '회</div>'
                            + '<div class="w15 fl">'
                            + '<a href="#" onclick="javascript:getProposalModal(' + data.adProposalList[i].no + ', ' + data. adProposalList[i].type + ')" data-toggle="modal" data-target="#adProposalModal" class="underline">수정</a> / '
                            + '<a href="javascript:proposalDelete(' + data.adProposalList[i].no + ')" class="underline">삭제</a>'
                            + '</div>'
                            + '</div>';
                        }

                        if(data.adProposalList.length == 0) {
                            document.getElementById("adProposalList").innerHTML = '<div class="bb f20" style="padding: 20% 0;">신청 내역이 없습니다.</div>';
                        }
                    }
                }

                var cell  = document.getElementById("adProposalPage");                

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.paging.currentSection != 1) {
                    document.getElementById("adProposalPage").innerHTML += '<li><a href="javascript:getProposalList(' + data.paging.prevPage + ')">이전</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("adProposalPage").innerHTML += '<li class="active"><a href="javascript:getProposalList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("adProposalPage").innerHTML += '<li><a href="javascript:getProposalList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("adProposalPage").innerHTML += '<li><a href="javascript:getProposalList(' + data.paging.nextPage + ')">다음</a></li>';
                }
            }
        });
    }
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > AD머니 > <b class="c555">광고 신청</b></div>
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
            <span class="f16 bold mr5 c666">광고 신청</span>
            <span class="c888">효과적인 광고 운영 방법, 일방과 함께하세요.</span>
        </div>
    </div>
    <div class="oa wdfull">
        <div class="adTabWrap">            
            <ul class="nav nav-tabs margin-auto tc f16" role="tablist" id="adTab">
                <?php if($tab == 3) { ?>
                <li class="w33 noPadding" role="presentation"><a href="#adTab1" aria-controls="adTab1" role="tab" data-toggle="tab">AD 동영상</a></li>
                <li class="w33 noPadding" role="presentation"><a href="#adTab2" aria-controls="adTab2" role="tab" data-toggle="tab">AD 배너</a></li>
                <li class="w33 noPadding active" role="presentation"><a href="#adTab3" aria-controls="adTab3" role="tab" data-toggle="tab">신청 내역</a></li>
                <?php } else { ?>
                <li class="w33 noPadding active" role="presentation"><a href="#adTab1" aria-controls="adTab1" role="tab" data-toggle="tab">AD 동영상</a></li>
                <li class="w33 noPadding" role="presentation"><a href="#adTab2" aria-controls="adTab2" role="tab" data-toggle="tab">AD 배너</a></li>
                <li class="w33 noPadding" role="presentation"><a href="#adTab3" aria-controls="adTab3" role="tab" data-toggle="tab">신청 내역</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <!-- 탭1 (ad동영상) -->
    <div class="tab-content c666 mt50 container pl25">
        <?php if($tab == 3) { ?>
        <div class="tab-pane" id="adTab1" role="tabpanel">
        <?php } else { ?>
        <div class="tab-pane active" id="adTab1" role="tabpanel">
        <?php } ?>
            <div class="f16 bold pdl10 mb5">신청 정보</div>
            <form class="adForm tc" action="adProposalProcess.php" method="post" onsubmit="return form_check(0);">
                <input type="hidden" name="type" value="0" />
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">제목 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" name="adTitle" placeholder="제목을 입력하세요." /></div>
                    <div class="adFormTitle bg_eee w15 fl">링크 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" name="adLink" placeholder="링크 주소를 입력하세요." /></div>
                </div>
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">내용 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" name="adContent" placeholder="내용을 입력하세요." /></div>
                    <div class="adFormTitle bg_eee w15 fl">영상 시간 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="adTime" name="adTime" placeholder="시간을 입력하세요. (초)" /></div>
                </div>
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">문제 <span class="fc">*</span></div>
                    <div class="w85 pdtb1p fl"><input type="text" class="adForminput" name="adQuiz" placeholder="문제 입력하세요." /></div>                    
                </div>
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">보기 <span class="fc">*</span></div>
                    <div class="w85 pdtb1p fl">
                        <input type="text" class="adForminput w24 mr1p fl" name="adExample1" placeholder="보기1" />
                        <input type="text" class="adForminput w24 mr1p fl" name="adExample2" placeholder="보기2" />
                        <input type="text" class="adForminput w24 mr1p fl" name="adExample3" placeholder="보기3" />
                        <input type="text" class="adForminput w25 fl" name="adExample4" placeholder="보기4" />
                    </div>
                </div>
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">정답 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="adCorrect" name="adCorrect" placeholder="답을 입력하세요. (숫자만 입력)" /></div>
                    <div class="adFormTitle bg_eee w15 fl">노출수 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="adExpose" name="adExpose" onkeyup="calculation()" placeholder="노출수를 입력하세요. (숫자만 입력)" /></div>
                </div>                
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">적립금 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl">
                        <input type="text" class="adForminput" id="adPrice" name="adPrice" onkeyup="calculation()" placeholder="적립 금액을 입력하세요. (숫자만 입력)" />
                    </div>
                    <div class="adFormTitle w50 fl pdr30">총 금액 : <span class="fr"><span class="fc mr5" id="totalPrice">0</span>원</span></div>
                </div>
                <div class="oa margin-auto mt50" style="width: 310px;">
                    <input type="reset" class="adBtn fl mr10 bg_white" style="color: #43495c;" value="초기화" />
                    <input type="submit" class="adBtn fl fff" style="background-color: #43495c;" value="신청하기" />
                </div>
            </form>
        </div>
        <!-- 탭2 (ad배너) -->
        <div class="tab-pane" id="adTab2" role="tabpanel">
            <div class="f16 bold pdl10 mb5">신청 정보</div>
            <form class="adForm tc" action="adProposalProcess.php" method="post" onsubmit="return form_check(1);">
                <input type="hidden" name="type" value="1" />
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">제목 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" name="adTitle" placeholder="제목을 입력하세요." /></div>
                    <div class="adFormTitle bg_eee w15 fl">링크 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" name="adLink" placeholder="링크 주소를 입력하세요." /></div>
                </div>
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">내용 <span class="fc">*</span></div>
                    <div class="w85 pdtb1p fl"><input type="text" class="adForminput" name="adContent" placeholder="내용을 입력하세요." /></div>                    
                </div>
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">문제 <span class="fc">*</span></div>
                    <div class="w85 pdtb1p fl"><input type="text" class="adForminput" name="adQuiz" placeholder="문제 입력하세요." /></div>
                </div>
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">보기 <span class="fc">*</span></div>
                    <div class="w85 pdtb1p fl">
                        <input type="text" class="adForminput w24 mr1p fl" name="adExample1" placeholder="보기1" />
                        <input type="text" class="adForminput w24 mr1p fl" name="adExample2" placeholder="보기2" />
                        <input type="text" class="adForminput w24 mr1p fl" name="adExample3" placeholder="보기3" />
                        <input type="text" class="adForminput w25 fl" name="adExample4" placeholder="보기4" />
                    </div>
                </div>
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">정답 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="adCorrect2" name="adCorrect" placeholder="답을 입력하세요. (숫자만 입력)" /></div>
                    <div class="adFormTitle bg_eee w15 fl">노출수 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="adExpose2" name="adExpose" onkeyup="calculation2()" placeholder="노출수를 입력하세요. (숫자만 입력)" /></div>
                </div>                
                <div class="oa bb">
                    <div class="adFormTitle bg_eee w15 fl">적립금 <span class="fc">*</span></div>
                    <div class="w35 pdtb1p fl">
                        <input type="text" class="adForminput" id="adPrice2" name="adPrice" onkeyup="calculation2()" placeholder="적립 금액을 입력하세요. (숫자만 입력)" />
                    </div>
                    <div class="adFormTitle w50 fl pdr30">총 금액 : <span class="fr"><span class="fc mr5" id="totalPrice2">0</span>원</span></div>
                </div>
                <div class="oa margin-auto mt50" style="width: 310px;">
                    <input type="reset" class="adBtn fl mr10 bg_white" style="color: #43495c;" value="초기화" />
                    <input type="submit" class="adBtn fl fff" style="background-color: #43495c;" value="신청하기" />
                </div>
            </form>
        </div>
        <!-- 탭3 (신청 내역) -->
        <?php if($tab == 3) { ?>
        <div class="tab-pane active" id="adTab3" role="tabpanel">
        <?php } else { ?>
        <div class="tab-pane" id="adTab3" role="tabpanel">
        <?php } ?>
            <div class="f16 bold pdl10 mb5">신청 내역</div>
            <div class="adForm tc">
                <div class="oa bb bg_eee adFormTitle">
                    <div class="w20 fl">날짜 / 시간</div>
                    <div class="w15 fl">구분</div>
                    <div class="w30 fl">신청 제목</div>
                    <div class="w15 fl">노출 횟수</div>
                    <div class="w15 fl">수정 / 삭제</div>
                </div>
                <div id="adProposalList"></div>
                <div class="text-center mb40">
                    <ul id="adProposalPage" class="pagination"></ul>
                </div>
            </div>
        </div>
        <div class="pb10 pdl10" style="border-bottom: 1px solid #555; margin-top: 15%;">
            <span class="f16 bold mr5 c666">광고가 시작되면 이렇게 적용됩니다!</span>
        </div>
        <div class="oh" style="padding: 30px 10%;">
            <div class="fl">
                <img src="../images/admobile1.png" />
                <div class="pd15">신청하신 광고 상품(AD 동영상, AD 배너)가<br />노출됩니다.</div>
            </div>
            <div class="fr">
                <img src="../images/admobile2.png" />
                <div class="pd15">회원들이 광고를 끝까지 보고 퀴즈를 풀면<br />포인트가 적립됩니다.</div>
            </div>
            <div class="clear" style="padding-top: 50px;">
                <div class="f16 bold mr5 c666">광고를 해지하고 싶다면?</div>
                <div class="mt10">기타 문의 사항이 있으시면 고객센터(02-2138-7365)로 전화주시거나 문의에 글을 남겨주시면 바로 해지를 도와드립니다.</div>
            </div>
        </div>
    </div>
    <div class="pdtb30 oa margin-auto" style="width: 900px;" >
        <?php include_once "adFooter.php"; ?>
    </div>
</div>
<div class="modal fade c666" id="adProposalModal">
    <div class="modal-dialog mt50">
        <div class="modal-content noBorder" style="background-color: transparent;">
            <div class="modal-header noBorder oh">
                <a href="#" class="fr" data-dismiss="modal"><img src="../images/exit.png" /></a>                
            </div>
            <div class="modal-body f14 tc bg_white noPadding oh" style="padding-bottom: 10px;">
                <div class="wdfull bold pd15 f20">광고 수정</div>
                <form class="adForm tc" action="adProposalProcess.php" method="post" onsubmit="return form_check(2);" style="padding: 20px 25px;">
                    <input type="hidden" id="adNo" name="adNo" value="" />
                    <input type="hidden" name="type" value="2" />
                    <div class="oa bb" style="border-top: 1px solid #ddd;">
                        <div class="adFormTitle bg_eee w15 fl">제목 <span class="fc">*</span></div>
                        <div class="w35 pdtb1p fl"><input type="text" class="adForminput" name="adTitle" /></div>
                        <div class="adFormTitle bg_eee w15 fl">링크 <span class="fc">*</span></div>
                        <div class="w35 pdtb1p fl"><input type="text" class="adForminput" name="adLink" /></div>
                    </div>
                    <div class="oa bb">
                        <div class="adFormTitle bg_eee w15 fl">내용 <span class="fc">*</span></div>
                        <div class="w35 pdtb1p fl" id="modalADContent"><input type="text" class="adForminput" name="adContent" /></div>                        
                        <div class="adFormTitle bg_eee w15 fl" id="modalADTime">영상 시간 <span class="fc">*</span></div>
                        <div class="w35 pdtb1p fl" id="modalADTime2"><input type="text" class="adForminput" id="adTime2" name="adTime" /></div>                        
                    </div>
                    <div class="oa bb">
                        <div class="adFormTitle bg_eee w15 fl">문제 <span class="fc">*</span></div>
                        <div class="w85 pdtb1p fl"><input type="text" class="adForminput" name="adQuiz" /></div>
                    </div>
                    <div class="oa bb">
                        <div class="adFormTitle bg_eee w15 fl">보기 <span class="fc">*</span></div>
                        <div class="w85 pdtb1p fl">
                            <input type="text" class="adForminput w24 mr1p fl" name="adExample1" />
                            <input type="text" class="adForminput w24 mr1p fl" name="adExample2" />
                            <input type="text" class="adForminput w24 mr1p fl" name="adExample3" />
                            <input type="text" class="adForminput w25 fl" name="adExample4" />
                        </div>
                    </div>
                    <div class="oa bb">
                        <div class="adFormTitle bg_eee w15 fl">정답 <span class="fc">*</span></div>
                        <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="adCorrect3" name="adCorrect" /></div>
                        <div class="adFormTitle bg_eee w15 fl">노출수 <span class="fc">*</span></div>
                        <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="adExpose3" name="adExpose" onkeyup="calculation3()" /></div>
                    </div>                
                    <div class="oa bb">
                        <div class="adFormTitle bg_eee w15 fl">적립금 <span class="fc">*</span></div>
                        <div class="w35 pdtb1p fl">
                            <input type="text" class="adForminput" id="adPrice3" name="adPrice" onkeyup="calculation3()" />
                        </div>
                        <div class="adFormTitle w50 fl pdr30">총 금액 : <span class="fr"><span class="fc mr5" id="totalPrice3">0</span>원</span></div>
                    </div>
                    <div class="oa margin-auto mt50" style="width: 310px;">
                        <input type="submit" class="adBtn fl mr10 fff" style="background-color: #43495c;" value="수정하기" />
                        <a href="javascript:form_reset(2)" class="adBtn fl bg_white" style="color: #43495c;">초기화</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script> 
    $(document).ready(function() {
        $("#adTime").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adCorrect").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adExpose").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adPrice").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adCorrect2").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adExpose2").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adPrice2").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adTime2").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adCorrect3").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adExpose3").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#adPrice3").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });
    });

    var title;
    var link;
    var content;
    var quiz;
    var exam1;
    var exam2;
    var exam3;
    var exam4;
    var correct;
    var expose;
    var price;

    function video() {
        title = document.getElementsByName("adTitle")[0];
        link = document.getElementsByName("adLink")[0];
        content = document.getElementsByName("adContent")[0];
        time = document.getElementsByName("adTime")[0];
        quiz = document.getElementsByName("adQuiz")[0];
        exam1 = document.getElementsByName("adExample1")[0];
        exam2 = document.getElementsByName("adExample2")[0];
        exam3 = document.getElementsByName("adExample3")[0];
        exam4 = document.getElementsByName("adExample4")[0];
        correct = document.getElementsByName("adCorrect")[0];
        expose = document.getElementsByName("adExpose")[0];
        price = document.getElementsByName("adPrice")[0];
    }

    function banner() {
        title = document.getElementsByName("adTitle")[1];
        link = document.getElementsByName("adLink")[1];
        content = document.getElementsByName("adContent")[1];            
        quiz = document.getElementsByName("adQuiz")[1];
        exam1 = document.getElementsByName("adExample1")[1];
        exam2 = document.getElementsByName("adExample2")[1];
        exam3 = document.getElementsByName("adExample3")[1];
        exam4 = document.getElementsByName("adExample4")[1];
        correct = document.getElementsByName("adCorrect")[1];
        expose = document.getElementsByName("adExpose")[1];
        price = document.getElementsByName("adPrice")[1];
    }

    function modalData() {
        title = document.getElementsByName("adTitle")[2];
        link = document.getElementsByName("adLink")[2];
        content = document.getElementsByName("adContent")[2];
        time = document.getElementsByName("adTime")[1];
        quiz = document.getElementsByName("adQuiz")[2];
        exam1 = document.getElementsByName("adExample1")[2];
        exam2 = document.getElementsByName("adExample2")[2];
        exam3 = document.getElementsByName("adExample3")[2];
        exam4 = document.getElementsByName("adExample4")[2];
        correct = document.getElementsByName("adCorrect")[2];
        expose = document.getElementsByName("adExpose")[2];
        price = document.getElementsByName("adPrice")[2];
    }

    function calculation() {
        video();

        var total = parseInt(expose.value) * parseInt(price.value);
        total = total.toLocaleString('en');
            
        if(expose.value == "" || price.value == "") {
            document.getElementById("totalPrice").innerHTML = 0;    
        } else {
            document.getElementById("totalPrice").innerHTML = total;
        }
    }

    function calculation2() {
        banner();

        var total = parseInt(expose.value) * parseInt(price.value);
        total = total.toLocaleString('en');
            
        if(expose.value == "" || price.value == "") {
            document.getElementById("totalPrice2").innerHTML = 0;    
        } else {
            document.getElementById("totalPrice2").innerHTML = total;
        }
    }

    function calculation3() {
        modalData();

        var total = parseInt(expose.value) * parseInt(price.value);
        total = total.toLocaleString('en');
            
        if(expose.value == "" || price.value == "") {
            document.getElementById("totalPrice3").innerHTML = 0;    
        } else {
            document.getElementById("totalPrice3").innerHTML = total;
        }
    }

    function form_check(val) {
        var id = "<?php echo $uid; ?>";

        if(val == 0) {
            video();
        } else if(val == 1) {
            banner();
        } else if(val == 2) {
            modalData();
        }
        
        if(id == "") {
            alert("로그인 후 이용해주세요.");
            return false;
        } else if(title.value == "") {
            alert("제목을 입력해주세요.");
            title.focus();
            return false;
        } else if(link.value == "") {
            alert("링크를 입력해주세요.");
            link.focus();
            return false;
        } else if(content.value == "") {
            alert("내용을 입력해주세요.");
            content.focus();
            return false;
        } else if(time.value == "" && val != 1) {
            alert("영상 시간을 입력해주세요.");
            time.focus();
            return false;
        } else if(quiz.value == "") {
            alert("문제를 입력해주세요.");
            quiz.focus();
            return false;
        } else if(exam1 == "" || exam2 == "" || exam3 == "" || exam4 == "") {
            alert("보기를 입력해주세요.");
            exam1.focus();
            return false;
        } else if(correct.value == "") {
            alert("정답을 입력해주세요.");
            correct.focus();
            return false;
        } else if(expose.value == "") {
            alert("노출수를 입력해주세요.");
            expose.focus();
            return false;
        } else if(price.value == "") {
            alert("적립 금액을 입력해주세요.");
            price.focus();
            return false;
        } else if(correct.value > 4) {
            alert("정답을 똑바로 입력해주세요.");
            correct.focus();
            return false;
        }       

        return true;
    }

    function getProposalModal(val, type) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/ad/getProposalData.php',
            data: { val: val },
            success: function(data) {
                var src = "javascript:adAdjustment(" + data.proposalData.no + ",1)";

                modalData();

                title.value = data.proposalData.title;
                link.value = data.proposalData.link;
                content.value = data.proposalData.content;
                quiz.value = data.proposalData.quiz;
                exam1.value = data.proposalData.exam1;
                exam2.value = data.proposalData.exam2;
                exam3.value = data.proposalData.exam3;
                exam4.value = data.proposalData.exam4;
                correct.value = data.proposalData.correct;
                expose.value = data.proposalData.expose;
                price.value = data.proposalData.price;
                document.getElementById("totalPrice3").innerHTML = data.proposalData.totalPrice;
                document.getElementById("adNo").value = data.proposalData.no;

                if(type == 0) {
                    time.value = data.proposalData.time;

                    document.getElementById("modalADTime").style.display = "block";
                    document.getElementById("modalADTime2").style.display = "block";
                    document.getElementById("modalADContent").style.cssText = "width: 35% !important";
                } else if(type == 1) {                    
                    document.getElementById("modalADTime").style.display = "none";
                    document.getElementById("modalADTime2").style.display = "none";
                    document.getElementById("modalADContent").style.cssText = "width: 85% !important";
                }
            }
        });
    }

    function proposalDelete(no) {
        if(confirm("정말 삭제 하시겠습니까?")) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/ad/adProposalDelete.php',
                data: { no: no },
                success: function(data) {
                    alert(data);
                    document.location.href = 'adProposal.php?tab=3';
                }
            });
        }
    }
</script>
<?php include_once "../include/footer.php"; ?>