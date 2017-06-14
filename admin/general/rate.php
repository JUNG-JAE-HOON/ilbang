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
            <div class="reviewWrtWrap mt30 mb50">
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