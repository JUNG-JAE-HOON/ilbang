<?php
    include_once "../include/header.php";

    if(isset($_GET["tab"])) {
        $tab = $_GET["tab"];
    } else {
        $tab = 1;
    }
?>
<script>
    $(document).ready(function() {
        getNotice();

        $('.collapse.in').prev('.csAcco-heading').addClass('active');
        $('#accordion, #bs-collapse').on('show.bs.collapse', function(a) {
            $(a.target).prev('.csAcco-heading').addClass('active');
        }).on('hide.bs.collapse', function(a) {
            $(a.target).prev('.csAcco-heading').removeClass('active');
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

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/getFAQList.php',
            success: function(data) {
                for(var i=1; i<=data.faqList.length; i++) {
                    document.getElementById("faqList").innerHTML
                    += '<div class="bb">'
                    + '<div class="panel-heading csAcco-heading csQnaPanel" role="tab">'
                    + '<div class="csAcco-title">'
                    + '<a role="button" class="noPadding" data-toggle="collapse" data-parent="#accordion" href="#faqCollapse' + i + '" aria-expanded="true">'
                    + '<div class="lh1 oh" style="padding: 10px 15px;">'
                    + '<div class="fl tc csQ">Q</div>'
                    + '<div class="bold" style="padding-top: 5px;">' + data.faqList[i-1].question + '</div>'
                    + '</div>'
                    + '</a>'
                    + '</div>'
                    + '</div>'
                    + '<div id="faqCollapse' + i + '" class="panel-collapse collapse" role="tabpanel">'
                    + '<div class="panel-body bg-fafafa oh" style="padding: 10px 15px;">'
                    + '<div class="csA fl tc">A</div>'
                    + '<div class="fl" style="padding-top: 3px; line-height: 20px;">' + data.faqList[i-1].answer + '</div>'
                    + '</div>'
                    + '</div>'
                    + '</div>';
                }
            }
        });

        getQNAList(1);
    });

    function getQNAList(page) {
        var id = "<?php echo $uid; ?>";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/qna/getQNAList.php',
            data: { page: page },
            success: function(data) {
                var cell = document.getElementById("qnaList");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.qnaList.length == 0) {
                    if(id == "") {
                        document.getElementById("qnaList").innerHTML = '<div class="tc f16 bb" style="padding: 50px 0;">로그인 후 이용해주세요.</div>';
                    } else {
                        if(id == data.admin) {
                            document.getElementById("qnaList").innerHTML = '<div class="tc f16 bb" style="padding: 50px 0;">올라온 질문이 없습니다.</div>';
                        } else {
                            document.getElementById("qnaList").innerHTML = '<div class="tc f16 bb" style="padding: 50px 0;">등록한 질문이 없습니다.</div>';
                        }
                    }
                }

                for(var i=0; i<data.qnaList.length; i++) {
                    document.getElementById("qnaList").innerHTML
                    += '<div class="bb">'
                    +       '<div class="panel-heading csQnaPanel bg_white">'
                    +           '<div class="panel-title">'
                    +               '<div class="mb10">'
                    +                   '<span class="csQbadge" style="margin-right: 10px;">질문</span>'
                    +                   '<span class="csQid">' + data.qnaList[i].id + '</span>'
                    +                   '<span class="csQdate mr5">' + data.qnaList[i].Qdate + '</span>'
                    +                   '<span id="userBtn' + data.qnaList[i].no + '"></span>'
                    +               '</div>'
                    +               '<div>'
                    +                   '<div class="csQtxt di" style="padding: 0 47px; width:90%;">' + data.qnaList[i].question + '</div>'
                    +                   '<a data-toggle="collapse" data-parent="#accordion" href="#question' + data.qnaList[i].no + '">'
                    +                       '<span id="Qwating' + data.qnaList[i].no + '" class="underline di f13 bold tr"></span>'
                    +                   '</a>'
                    +               '</div>'
                    +           '</div>'
                    +           '<div id="QShow' + data.qnaList[i].no + '" style="display:none;">'
                    +               '<div class="ml45 mt10">'
                    +                   '<textarea class="form-control fl w85 mr1p" id="qContent' + data.qnaList[i].no + '" name="qContent" rows="3" placeholder="내용을 입력하세요." style="height: 74px;">'
                    +                       (data.qnaList[i].question).replace(/<br[^>]*>/gi, '')
                    +                   '</textarea>'
                    +                   '<a href="javascript:QWrite(1, ' + data.qnaList[i].no + ', ' + page + ')">'
                    +                       '<div class="btn btn-primary csQnaWrtBtn noPadding" style="width: 14%; height: 74px; line-height: 74px;">수정하기</div>'
                    +                   '</a>'
                    +               '</div>'
                    +           '</div>'
                    +       '</div>'
                    +       '<div id="question' + data.qnaList[i].no + '" class="panel-collapse collapse"></div>'
                    + '</div>';

                    var btnNo = "userBtn" + data.qnaList[i].no;
                    var watingNo = "Qwating" + data.qnaList[i].no;
                    var questionNo = "question" + data.qnaList[i].no;

                    if(id != data.admin) {
                        document.getElementById(btnNo).innerHTML
                        = '<a href="javascript:qnaIdCheck(' + data.qnaList[i].no + ', ' + page + ', 0)" class="csModifyBtn mr5">수정</a>'
                        + '<a href="javascript:qnaIdCheck(' + data.qnaList[i].no + ', ' + page + ', 1);" class="csDeleteBtn">삭제</a>';
                    }

                    if(data.qnaList[i].Aview == 0) {
                        document.getElementById(watingNo).classList.add("csAwaiting");
                        document.getElementById(watingNo).innerHTML = '답변 대기중';

                        if(id == data.admin) {
                            document.getElementById(questionNo).innerHTML
                            = '<div class="panel-body p20" style="border-top: 1px solid #ddd;">'
                            +   '<div class="ml45 f16">답변 하기</div>'
                            +   '<div class="ml45 mt10">'
                            +       '<textarea class="form-control fl w85 mr1p" id="aContent' + data.qnaList[i].no + '" rows="3" placeholder="내용을 입력하세요." style="height: 74px;"></textarea>'
                            +       '<a href="javascript:AWrite(0, ' + data.qnaList[i].no + ', ' + page + ')">'
                            +           '<div class="btn btn-primary csQnaWrtBtn noPadding" style="width: 14%; height: 74px; line-height: 74px;">답변 달기</div>'
                            +       '</a>'
                            +   '</div>'
                            + '</div>';
                        }
                    } else {
                        document.getElementById(watingNo).classList.add("csAresult");
                        document.getElementById(watingNo).innerHTML = '답변 완료';
                        document.getElementById(questionNo).innerHTML
                        = '<div class="panel-body p20" style="border-top: 1px solid #ddd;">'
                        + '<div class="fl oh">'
                        + '<div class="fl mr5"><img src="./../images/arrow.png" alt="arrow"></div>'
                        + '<div class="csABadge fl lh1" style="padding: 4px 8px; margin: 2px 10px 0 0;">답변</div>'
                        + '<div class="oh mb5" style="margin-top: 3px;">'
                        + '<div class="fl mr10 bold csQid">관리자</div>'
                        + '<div class="fl mr10">' + data.qnaList[i].Adate + '</div>'
                        + '<div id="adminBtn' + data.qnaList[i].no + '" class="fl"></div>'
                        + '</div>'
                        + '</div>'
                        + '<div class="clear"></div>'
                        + '<div class="csAtxt" style="padding-top: 6px;" style="line-height: 18px;">' + data.qnaList[i].answer + '</div>'
                        + '<div id="adminInput' + data.qnaList[i].no + '" style="display: none;"></div>'
                        + '</div>';

                        var adminBtnNo = "adminBtn" + data.qnaList[i].no;
                        var adminInput = "adminInput" + data.qnaList[i].no;

                        if(id == data.admin) {
                            document.getElementById(adminBtnNo).innerHTML
                            = '<a href="javascript:showModify(' + data.qnaList[i].no + ')"><div class="fl mr5 border-grey csManagerBtn">수정</div></a>'
                            + '<a href="javascript:AWrite(2, ' + data.qnaList[i].no + ', ' + page + ')"><div class="fl mr10 border-grey csManagerBtn">삭제</div></a>'

                            document.getElementById(adminInput).innerHTML
                            = '<div class="mt10" style="margin-left: 20px;">'
                            + '<textarea class="form-control fl w85 mr1p" id="aContent' + data.qnaList[i].no + '" rows="3" placeholder="내용을 입력하세요." style="height: 74px;">'
                            + (data.qnaList[i].answer).replace(/<br[^>]*>/gi, '')
                            + '</textarea>'
                            + '<a href="javascript:AWrite(1, ' + data.qnaList[i].no + ', ' + page + ')">'
                            + '<div class="btn btn-primary csQnaWrtBtn noPadding" style="width: 14%; height: 74px; line-height: 74px;">답변 수정</div>'
                            + '</a>'
                            + '</div>';
                        }
                    }
                }

                var cell = document.getElementById("qnaPage");

                while (cell.hasChildNodes()) {
                    cell.removeChild(cell.firstChild);
                }

                if(data.paging.currentSection != 1) {
                    document.getElementById("qnaPage").innerHTML += '<li><a href="javascript:getQNAList(' + data.paging.prevPage + ')">이전</a></li>';
                }                            

                for (var i=data.paging.firstPage; i<=data.paging.lastPage; i++) {
                    if(i == data.paging.page) {                        
                        document.getElementById("qnaPage").innerHTML += '<li class="active"><a href="javascript:getQNAList(' + i + ')">' + i + '</a></li>';
                    } else {
                        document.getElementById("qnaPage").innerHTML += '<li><a href="javascript:getQNAList(' + i + ')">' + i + '</a></li>';
                    }
                }

                if (data.paging.currentSection != data.paging.allSection) {
                    document.getElementById("qnaPage").innerHTML += '<li><a href="javascript:getQNAList(' + data.paging.nextPage + ')">다음</a></li>';
                }
            }
        });
    }

    function QWrite(val, no, page) {
        if(no == null) {
            no = "";
        }

        var conNo = "qContent" + no;
        var qContent = document.getElementById(conNo).value;

        if(qContent == "") {
            alert("질문을 입력해주세요.");
            document.getElementById(conNo).focus();
        } else {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/qna/qnaWrite.php',
                data: { val: val, no: no, qContent: qContent },
                success: function(data) {
                    alert(data.message);

                    if(data.check == 1) {
                        if(val == 0) {
                            document.getElementById("csWriteForm").style.display = "none";
                        }

                        getQNAList(page);
                    }
                }
            });
        }
    }

    function qnaIdCheck(no, page, val) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/qna/qnaIdCheck.php',
            data: { no: no, val: val },
            success: function(data) {
                if(data != null) {
                    alert(data);
                } else {
                    if(val == 0) {
                        QShow(no);
                    } else {
                        QDelete(no, page);
                    }
                }
            }
        });
    }

    function QShow(no) {
        var showNo = "QShow" + no;

        document.getElementById(showNo).style.display = "block";
    }

    function QDelete(no, page) {
        if(confirm("정말 삭제하시겠습니까?")) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/qna/qnaDelete.php',
                data: { no: no },
                success: function(data) {
                    alert(data.message);

                    if(data.check == 1) {
                        getQNAList(page);
                    }
                }
            });
        }
    }

    function AWrite(val, no, page) {
        var conNo = "aContent" + no;
        var aContent = document.getElementById(conNo).value;

        if(val != 2 && aContent == "") {
            alert("내용을 입력해주세요.");
            document.getElementById(conNo).focus();
        } else if(val == 2) {
            if(confirm("정말 삭제하시겠습니까?")) {
                var check = 1;
            } else {
                var check = 0;
            }
        } else {
            var check = 1;
        }

        if(check == 1) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/qna/adminWrite.php',
                data: { val: val, no: no, aContent: aContent },
                success: function(data) {
                    alert(data);
                    getQNAList(page);
                }
            });
        }
    }

    function showModify(no) {
        var adminInput = "adminInput" + no;

        document.getElementById(adminInput).style.display = "block";
    }
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > <b class="c555">고객센터</b></div>
        <div class="c999 fr padding-vertical">
            <span class="mr5 br15 subNotice">공지</span>
            <a href="#" class="c999"><span id="adNotice"></span></a>
        </div>
    </div>
</div>
<div class="container wdfull">
    <img src="./../images/csBanner2.png" alt="고객센터" class="img-responsive" />
</div>
<div class="pdtb30 oa margin-auto wdfull">
    <div class="container pl20 mb20">
        <span class="f16 bold mr5 c666">고객센터</span>
        <span class="c888">일방 서비스의 궁금한 점을 물어보세요.</span>
    </div>
    <div class="oa wdfull">
        <div class="csTabWrap">
            <ul class="nav nav-tabs f14 tc" role="tablist" id="myTab">
                <?php if($tab == 1) { ?>
                <li role="presentation" class="noPadding w50 active"><a href="#faqTab" aria-controls="faqTab" role="tab" data-toggle="tab">FAQ 자주 묻는 질문</a></li>
                <li class="noPadding w50" role="presentation"><a href="#qnaTab" aria-controls="qnaTab" role="tab" data-toggle="tab">Q&A 묻고 답하기</a></li>
                <?php } else { ?>
                <li role="presentation" class="noPadding w50"><a href="#faqTab" aria-controls="faqTab" role="tab" data-toggle="tab">FAQ 자주 묻는 질문</a></li>
                <li class="noPadding w50 active" role="presentation"><a href="#qnaTab" aria-controls="qnaTab" role="tab" data-toggle="tab">Q&A 묻고 답하기</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="tab-content container pl20 c666 mt50">
        <?php if($tab == 1) { ?>
        <div role="tabpanel" class="tab-pane active mt10" id="faqTab">
        <?php } else { ?>
        <div role="tabpanel" class="tab-pane mt10" id="faqTab">
        <?php } ?>
            <h3 class="f16 c555">FAQ 자주묻는 질문</h3>
            <div class="panel-group wrap csPaneltBt" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="bb">
                    <div class="lh1" style="padding: 12px 15px;">
                        <div class="panel-title f13 oh">
                            <div class="fl csInfoBadge" style="padding: 5px;">안내</div>
                            <div class="fl c555" style="padding-top: 5px;">고객분들이 일방 서비스를 이용하면서 자주 묻는 질문을 모아 답변했습니다.</div>
                        </div>
                    </div>
                </div>
                <div id="faqList"></div>
            </div>
        </div>
        <?php if($tab == 1) { ?>
        <div role="tabpanel" class="tab-pane mt10" id="qnaTab">
        <?php } else { ?>
        <div role="tabpanel" class="tab-pane mt10 active" id="qnaTab">
        <?php } ?>
            <div class="oh">
                <h3 class="f16 c555 fl">Q&A 묻고 답하기</h3>
                <?php if($uid != "" && $uid != $admin) { ?>
                <a href="javascript:csQ();"><div class="fff fr mt15 csWrBtn">글쓰기</div></a>
                <?php } ?>
            </div>
            <div class="csPaneltBt" id="accordion">
                <div class="bb">
                    <div class="lh1" style="padding: 12px 15px;">
                        <div class="panel-title f13 oh">
                            <div class="fl csInfoBadge" style="padding: 5px;">안내</div>
                            <div class="fl c555" style="padding-top: 5px;">일방 서비스 이용에 궁금한 점을 문의해주시면 친절히 답변해드리겠습니다.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-default noBorder-top noBorder-right noBorder-left csWriteForm" id="csWriteForm">
                <div class="panel-heading bg_white">
                    <div class="panel-title mb5">
                        <div class="oh mt5 f14">
                            <div class="fl mr5 bold" style="padding-top: 2px;"><?php echo $name; ?>님</div>
                            <!-- <div class="fl"><input type="password" id="qPasswd" name="qPasswd" placeholder="비밀번호 입력" style="padding-left: 5px;" /></div> -->
                        </div>
                        <div class="oh mt5">
                            <textarea class="form-control fl w85 mr1p" id="qContent" name="qContent" rows="3" placeholder="질문을 입력하세요." style="height: 74px;"></textarea>
                            <a href="javascript:QWrite(0, '', 1)">
                                <div class="btn btn-primary csQnaWrtBtn noPadding" style="width: 14%; height: 74px; line-height: 74px;">질문하기</div>
                            </a>
                        </div>                                                                                                                                 
                    </div>  
                </div>
            </div>
            <div id="qnaList"></div>
            <div class="tc mt15">
                <ul id="qnaPage" class="pagination"></ul>
            </div>
        </div>
    </div>
</div>
<script>
    function csA() {
        $('.csForm').show();
    }

    function csQ() {
        $('.csWriteForm').show();

        document.getElementById('qContent').value = '';
    }
</script>
<?php include_once "../include/footer.php"; ?>