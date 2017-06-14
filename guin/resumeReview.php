<?php include_once "../include/header.php"; ?>
<script>
    $(document).ready(function() {
       getResumeReviewInfo();
    });

    function getResumeReviewInfo() {
        var resumeNo = '<?php echo $_GET["resumeNo"]; ?>';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/getResumeReviewData.php',
            data: { resumeNo: resumeNo },
            success: function(data) {
                if(data.img_url == null || data.img_url == '') {
                    data.img_url = "../images/profile.png";
                } else {
                    data.img_url = "../gujikImage/" + data.img_url ;
                }
                    
                $("#name").text(data.name);
                $("#sexNage").text(data.sex + ", " + data.age + "세");
                $("#totalScore").text(data.totalScore + "점");
                $("#Heuid").val(data.euid);
                $("#Hruid").val(data.ruid);               
                $("#profileImg").attr('src', data.img_url);

                $(".rateAvg").rateYo({
                    onChange: function (rating, rateYoInstance) {
                        $(".rating b").text(rating);
                    },
                    rating:data.totalScore,
                    halfStar: true,
                    starWidth:'15px',
                    readOnly:true
                });

                document.getElementById("workDate").innerHTML = '<option value="" selected>근무 일자</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("workDate").innerHTML += '<option value="' + data.listData[i].work_join_list_no + '">' + data.listData[i].work_date + '</option>';
                }

                var cell = document.getElementById("reviewListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("reviewListArea").innerHTML
                += '<h4 class="di mt30 f16 mb10 mr10">평가보기</h4>'
                + '<h5 class="di c999 f12">총 <strong class="fc">' + data.reviewList.length + '</strong>개의 평가가 있습니다.</h5>';

                for (var i=0; i<data.reviewList.length; i++) {
                    var starCnt = Number(data.reviewList[i].score);
                  
                    document.getElementById("reviewListArea").innerHTML
                    += '<div class="reviewContentWrap border-top">'
                    +       '<div class="reviewLine border-bottom p25">'
                    +           '<div class="di w10">'
                    +               '<img src="http://il-bang.com/pc_renewal/images/review01.png" alt="리뷰"/>'
                    +           '</div>'
                    +           '<div class="di" style="width: 76%;">'
                    +               '<p class="bold fl">익명</p>'
                    +               '<div id="rateYo' + i + '" class="fl"></div>'   
                    +               data.reviewList[i].script
                    +               '<div class="clear"></div>'
                    +               '<p>'+data.reviewList[i].content+'</p>'
                    +           '</div>'
                    +           '<div class="c999 di" style="width: 12%;">' + data.reviewList[i].wdate + '</div>'
                    +       '</div>'
                    +       '<div class="clear"></div>'
                    +   '</div>';
                           
                    $("#rateYo"+i).rateYo({                           
                        starWidth:"15px",
                        rating:starCnt,
                        readOnly: true
                    });
                }
            }
        });
    }

    function reviewDelete(no) {
        if(confirm("정말 삭제하시겠습니까?\n(삭제된 데이터는 복구할 수 없습니다.)")) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/item/resumeReviewDelete.php',
                data: { no: no },
                success: function(data) {
                    alert(data);
                    getResumeReviewInfo();
                }
            });
        }
    }
                                                                                                                                                                                                               
    function insertReview() {
        var work_join_list_no   = $("#workDate option:selected").val(); 
        var reviewContent       = $("#reviewContent").val();
        var euid                = $("#Heuid").val();
        var ruid                = $("#Hruid").val();
        var score               = $("#Hscore").val();

        if (work_join_list_no == '') {
            alert('리뷰를 작성할 근무 일자를 선택해주세요.');
            return ;
        }

        if (reviewContent == ''){
            alert('리뷰를 작성하세요.');
            $("#reviewContent").focus();
            return ;
        }

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/insertResumeReview.php',
            data: {work_join_list_no:work_join_list_no,reviewContent:reviewContent,euid:euid,ruid:ruid,score:score},
            success: function (data) {
                if(data.result == 1){
                    alert("리뷰가 등록되었습니다.");
                    getResumeReviewInfo();
                    $("#reviewContent").val("");
                } else {
                    alert("리뷰 등록 실패하였습니다.")
                }
            }
        });
    }

    function setScore(score) {
        $("#Hscore").val(score);
    }

    function getReviewContent() {
        var work_join_list_no   = $("#workDate option:selected").val();

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/getResumeReviewContent.php',
            data: {work_join_list_no:work_join_list_no},
            success: function (data) {
                if(data.content != '' && data.content != null){
                    $("#reviewContent").val(data.content);
                    $("#reviewContent").select();
                } 
            }
        });
    }
</script>
<input type="hidden" id="Hscore">
<input type="hidden" id="Heuid">
<input type="hidden" id="Hruid">
<div class="container pl30">    
    <div class="guinjikTabWrap">
        <div class="tab-content">
            <!-- 첫번째 탭 내용 -->
            <div role="tabpanel" class="tab-pane active mt10" id="gujikTab1">
                <div class="gujikDetSect1 mt50">
                    <div class="border-navy">
                        <h4 class="bg_navy f_white padding-vertical tc noMargin f16">평가보기</h4>
                        <ul class="detailInfoUl_gujik pr">
                            <li class="bb padding">
                                <span class="di w10">구직자</span>
                                <span id="name"></span>
                            </li>
                            <li class="bb padding">
                                <span class="di w10">성별 / 나이</span>
                                <span id="sexNage"></span>
                            </li>
                            <li class="padding" style="margin-bottom: 15px;">
                                <span class="di w10 fl">평점</span>
                                <div class="rateAvg fl noPadding mr5"></div>
                                <span class="fc fl" id="totalScore"></span>
                            </li>
                            <li class="pa tc" style="left:0; top:0; width:18%">
                                <img id="profileImg"  alt="" width="50%" style="margin-top:8%">
                            </li>
                        </ul>
                    </div>
                </div> 
                <div class="reviewWrap mb35" id="reviewListArea"></div>
            </div>
            <select id="workDate" class="mr15 smallSelect" onchange="getReviewContent()"></select>
            <span>근무 일자를 선택하여 리뷰를 남겨주세요.</span>
            <div class="reviewWrtWrap mt10 mb50">
                <div class="starWrap fl" style="padding-left: 23px;">
                    <div id="rateYoD" class="fl noPadding"></div>
                    <div class="rating noPadding fr" style="width:70px; text-align: right; font-size: 15px;"><b>0</b> / 5.0</div>
                    <script>
                        $(function () {
                            $("#rateYoD").rateYo({
                                onChange: function (rating, rateYoInstance) {
                                    $(".rating b").text(rating);
                                },
                                halfStar: true,
                                starWidth:'20px'
                            });
                            
                            var userRating = $("#rateYoD").rateYo();
                                                    
                            $("#rateYoD").click(function () {
                                var rating = userRating.rateYo("rating");
                                
                                $("#Hscore").val(rating);
                            });
                        });
                    </script>
                </div>
                <input type="text" class="form-control fl" id="reviewContent" style="width: 71.3% !important; height: 70px !important; border-radius: 0 !important; border-top: 0 !important; border-bottom: 0 !important; border-color: #ddd !important;" placeholder="솔직한 후기를 남겨주세요. (매칭 완료자만 리뷰를 작성할 수 있습니다.)" />
                <!-- <input type="text" class="form-control fl reviewTextarea" id="reviewContent" rows="3" style="border-radius: 0; border: 0 !important;" placeholder="솔직한 후기를 남겨주세요. (매칭 완료자만 리뷰를 작성하실 수 있습니다.) " /> -->
                <button onclick="javascript:insertReview()" class="btn btn-primary reviewWrtBtn fl" style="border-radius: 0;">리뷰 등록</button>
                <div class="clear"></div>
            </div>
        </div>
        <!-- 두번째 탭 내용 -->
        <div role="tabpanel" class="tab-pane mt10" id="gujikTab2"></div>
        <div role="tabpanel" class="tab-pane mt10" id="gujikTab3"></div>
        <div role="tabpanel" class="tab-pane mt10" id="gujikTab4"></div>
    </div>
</div>
<?php include_once "../include/footer.php"; ?>