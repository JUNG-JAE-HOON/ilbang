<?php include_once "../../include/header.php"; ?>
<script type="text/javascript" src="../../js/jquery-ui-1.11.1.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../../ajax/guin/getMemberInfo.php',
            success: function(data) {
                if(data.message != null) {
                    alert(data.message);
                    history.back();
                } else {
                    document.getElementById("comNumber").innerHTML = data.memberInfo.number;
                    document.getElementById("comCompany").innerHTML = data.memberInfo.company;
                    document.getElementById("comCeo").innerHTML = data.memberInfo.ceo;
                    document.getElementById("comTypes").innerHTML = data.memberInfo.types;
                    document.getElementById("comStatus").innerHTML = data.memberInfo.status;
                    document.getElementById("comFlotation").innerHTML = data.memberInfo.flotation + "년";

                    $("#emergency").change(function() {
                        if($("#emergency").is(":checked")) {
                            if(data.itemEmergency.totalCnt == 'not') {
                                alert('사용할 수 있는 아이템이 없습니다.\n구매 후 이용바랍니다.');
                                document.getElementById("emergency").checked = false;
                            } else {
                                document.getElementById("itemComment").innerHTML = '(현재 남은 수량 : ' + data.itemEmergency.cnt + '회)';
                            }
                        } else {
                            document.getElementById("itemComment").innerHTML = '';
                        }
                    });
                }
            }
        });

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../../ajax/guin/getGuinInfoList.php',
            success: function(data) {
                document.getElementById("area_1st").innerHTML = '<option value="" selected>모집 지역(1차)</option>';
                document.getElementById("area_2nd").innerHTML = '<option value="" selected>모집 지역(2차)</option>';

                for(var i=0; i<data.areaList.length; i++) {
                    document.getElementById("area_1st").innerHTML += '<option value="' + data.areaList[i].no + '">' + data.areaList[i].name + '</option>';
                }
            }
        });

        getLogoImage();
    });

    function getLogoImage() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../../ajax/guin/getLogoImage.php',
            success: function(data) {
                console.log(data.logoData);
                console.log(data.logoData.img_url);
                var img_url=data.logoData.img_url;

                if(img_url != null){
                    console.log("이미지 있을경우");
                    var company_logo= document.getElementById("company_logo");
                    company_logo.src="http://il-bang.com/pc_renewal/guinImage/"+img_url;
                }
            }
        });
    }

    function open_popup_BGNXP2I5vR() {
        var dname = document.domain;

        window.open("http://www.newroad.co.kr/find/roadname/BGNXP2I5vR.do?domain="+dname,"popup","width=511,height=675,scrollbars=0");
    }
</script>
<div class="container c666 pl30">
    <form action="guinRegistration.php" method="post" class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 w100 noMargin" onsubmit="return formCheck()">
        <h4 class="fl mt35 f16">기본 회원 정보</h4>
        <h5 class="fr mt40 f12">여러 개의 이력서를 작성하고 싶을 때!
            <span class="prdBuyBtn" style="padding: 2px 4px;"><a href="../../itemShop/itemshop.php" class="fff">상품 구매</a></span>
        </h5>
        <div class="clear"></div>
        <div class="formWrite oh mt5 mb50 pr">
            <div class="photo pa border-grey oh bg_grey w20 tc" style="height:192px; padding-top:70px;">
                <img src="../../images/144x38.png" alt="" id="company_logo" class="border-grey wh144"/><br />
            </div>
            <div class="oh">
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">사업자 등록 번호</p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="comNumber"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">기업명</p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="comCompany"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">대표자</p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="comCeo"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">업종</p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="comTypes"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">기업 형태</p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="comStatus"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">설립 연도</p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="comFlotation"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w100p">
            <h4 class="f16">채용 공고 작성</h4>
        </div>
        <div class="formWrite oh mt10 mb30">
            <div class="oh">
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">아이템</p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w78p f14">
                            <input type="checkbox" id="emergency" name="emergency" value="1" />
                            <label for="emergency" class="ml5" style="margin-bottom: 0;">긴급 구인 1회</label>
                            <span id="itemComment" class="f12 fc ml5"></span>
                        </div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">모집 제목 <font class="fc">*</font></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w78p">
                          <input type="text" class="form-control w76p" id="title" name="title" placeholder="모집 제목을 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">모집 지역 <span class="fc">*</span></p>
                    <select id="area_1st" name="area_1st" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon" onchange="area1Change(this.value)"></select>
                    <select id="area_2nd" name="area_2nd" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon"></select>
                </div>
                <script>
                    function area1Change(val) {
                        if(val == "") {
                            document.getElementById("area_2nd").innerHTML = '<option value="" selected>모집 지역(2차)</option>';
                        } else if(val == 10000) {
                            document.getElementById("area_2nd").innerHTML = '<option value="" selected>전국</option>';
                        } else if(val == 10001) {
                            document.getElementById("area_2nd").innerHTML = '<option value="" selected>전체</option>';
                        } else {
                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                url: '../../ajax/guin/getGuinInfoList.php',
                                data: { area1: val },
                                success: function(data) {
                                    document.getElementById("area_2nd").innerHTML = '<option value="" selected>모집 지역(2차)</option>';

                                    for(var i=0; i<data.areaList2.length; i++) {
                                        document.getElementById("area_2nd").innerHTML += '<option value="' + data.areaList2[i].no + '">' + data.areaList2[i].name + '</option>';
                                    }
                                }
                            });
                        }
                    }
                </script>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">모집 직종 <span class="fc">*</span></p>
                    <select id="work_1st" name="work_1st" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon">
                        <option value="8000" selected>특성별</option>
                    </select>
                    <select id="work_2nd" name="work_2nd" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon" onchange="work2Change(this.value)"></select>
                </div>
                <script>
                    var work1Val = document.getElementById("work_1st");
                    var work1 = work1Val.options[work1Val.selectedIndex].value;

                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: '../../ajax/guin/getGuinInfoList.php',
                        data: { work1: work1 },
                        success: function(data) {
                            document.getElementById("work_2nd").innerHTML = '<option value="" selected>모집 직종(2차)</option>';

                            for(var i=0; i<data.workList.length; i++) {
                                document.getElementById("work_2nd").innerHTML += '<option value="' + data.workList[i].no + '">' + data.workList[i].name + '</option>';
                            }
                        }
                    });
                </script>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">일급 <span class="fc">*</span></p>
                    <div class="form-inline lh45 fl">
                        <div class="form-group ml10">
                          <input type="text" class="form-control" id="pay" name="pay" placeholder="금액 입력 (숫자만)" style="width: 140px;" />
                          <span class="ml5 mr15">원</span>
                        </div>
                    </div>
                    <div id="bongsa" class="fc fl" style="padding-top: 15px;"></div>
                </div>
                <script>
                    function work2Change(val) {
                        if(val == 8017) {
                            document.getElementById("pay").value = 0;
                            document.getElementById("pay").readOnly = true;
                            document.getElementById("bongsa").innerHTML = '* 봉사 일방은 일급 0원만 입력할 수 있습니다.';
                        } else {
                            // pay();
                            document.getElementById("pay").value = '';
                            document.getElementById("pay").readOnly = false;
                            document.getElementById("bongsa").innerHTML = '';
                        }
                    }
                </script>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20 cldArea">모집 근무일 <span class="fc">*</span></p>
                    <div class="col-sm-4 mt8 ml10 w78p">
                        <script type="text/javascript" src="../../js/jquery-ui.multidatespicker.js"></script> 
                        <input type="hidden" data-role="date" id="workDate" name="workDate" value="" />
                        <div style="margin-top:0.5em;" id="dateForm"></div>
                        <script>
                            var today = new Date();

                            $('#dateForm').multiDatesPicker({
                                minDate: 0,
                                maxDate: 60,
                                altField: '#workDate'
                            });
                        </script>
                        <style>
                            .ui-corner-all{border-radius:0;}
                        </style>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">모집 근무 시간 <span class="fc">*</span></p>
                    <select name="time" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon">
                        <option value="1" selected>오전</option>
                        <option value="2">오후</option>
                        <option value="3">저녁</option>
                        <option value="4">새벽</option>
                        <option value="5">오전 ~ 오후</option>
                        <option value="6">오후 ~ 저녁</option>
                        <option value="7">저녁 ~ 새벽</option>
                        <option value="8">새벽 ~ 오전</option>
                        <option value="9">풀타임</option>
                        <option value="10">협의</option>
                    </select>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">모집 연령대 <span class="fc">*</span></p>
                    <select id="minAge" name="minAge" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon" onchange="ageChange(this.value)">
                        <option value="" selected>최소 연령 선택</option>
                        <option value="20">20세</option>
                        <option value="30">30세</option>
                        <option value="40">40세</option>
                        <option value="50">50세</option>
                        <option value="60">60세</option>
                        <option value="70">70세</option>
                        <option value="0">무관</option>
                    </select>
                    <sapn class="di col-sm-2 w30p tc mt15">~</sapn>
                    <select id="maxAge" name="maxAge" class="di col-sm-4 mt7 changeInput w145 inputIcon">
                        <option value="" selected>최대 연령 선택</option>
                        <option value="20">20세</option>
                        <option value="30">30세</option>
                        <option value="40">40세</option>
                        <option value="50">50세</option>
                        <option value="60">60세</option>
                        <option value="70">70세</option>
                        <option value="80">80세</option>
                    </select>
                </div>
                <script>                    
                    function ageChange(val) {
                        document.getElementById("maxAge").innerHTML = '<option value="" selected>최대 연령 선택</option>';

                        if(val == 0) {
                            var age = 2;
                        } else {
                            var age = parseInt(val.substr(0, 1)) + 1;
                        }

                        for(var i=age; i<=8; i++) {
                            document.getElementById("maxAge").innerHTML += '<option value="' + i + '0">' + i + '0세</option>';
                        }

                        document.getElementById("maxAge").innerHTML += '<option value="0">무관</option>';
                    }
                </script>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">필요 경력 <span class="fc">*</span></p>
                    <select name="career" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon">
                        <option value="-1" selected>무관</option>
                        <option value="0">신입</option>
                        <option value="1">1년 미만</option>
                        <option value="3">3년 미만</option>
                        <option value="5">5년 미만</option>
                        <option value="6">5년 이상</option>
                    </select>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">모집 성별 <span class="fc">*</span></p>
                    <select name="sex" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon">
                        <option value="nothing" selected>무관</option>
                        <option value="man">남자</option>
                        <option value="woman">여자</option>
                    </select>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">모집 인원 <span class="fc">*</span></p>
                    <select name="people" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon">
                        <option value="1" selected>1명</option>
                        <option value="2">2명</option>
                        <option value="3">3명</option>
                        <option value="4">4명</option>
                        <option value="5">5명</option>
                        <option value="6">6명</option>
                        <option value="7">7명</option>
                        <option value="8">8명</option>
                        <option value="9">9명</option>
                        <option value="10">10명</option>
                    </select>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20" style="height: 90px;">근무지 주소 <span class="fc">*</span></p>
                    <div class="form-inline mt10 mb10">
                        <div class="form-group lh35 ml10 w78p">
                            <input type="text" class="form-control di w76p" id="address1" name="address1" placeholder="주소 검색 버튼을 눌러주세요." />
                            <a href="javascript:open_popup_BGNXP2I5vR()" class="di ml5 b999 bg-555 br2 fff f12 lh20" style="padding: 4px 10px;">주소 검색</a>
                            <input type="text" class="form-control w76p" id="address2" name="address2" placeholder="주소 검색 버튼을 눌러주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">담당자 이름 <span class="fc">*</span></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w78p">
                          <input type="text" class="form-control w76p" id="manager" name="manager" placeholder="담당자 이름을 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">담당자 연락처 <span class="fc">*</span></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w78p">
                          <input type="text" class="form-control w10" id="phone1" name="phone1"  />
                          <span>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                          <input type="text" class="form-control w10" id="phone2" name="phone2" />
                          <span>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                          <input type="text" class="form-control w10" id="phone3" name="phone3" />
                        </div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">담당 업무 내용 <span class="fc">*</span></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w78p">
                          <input type="text" class="form-control w76p" id="business" name="business" placeholder="담당 업무 내용을 간략하게 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20" style="height: 100px;">상세 모집 내용 <span class="fc">*</span></p>
                    <textarea class="form-control margin di" id="contents" name="contents" style="width:77%;" rows="3" placeholder="상세 모집 내용을 입력해주세요."></textarea>      
                </div>        
            </div>          
        </div>
        <div class="tc mb40">
            <input type="submit" class="cp gujikWrtBtn lh1 f14" value="채용공고 작성 완료" style="padding: 12px 25px;" />
        </div>
    </form>
</div>
<script>
    $("#phone1").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#phone2").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#phone3").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#pay").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    function formCheck() {
        var title = document.getElementById("title").value;
        var area1 = $("#area_1st option:selected").val();
        var area2 = $("#area_2nd option:selected").val();
        var work2 = $("#work_2nd option:selected").val();
        var pady = document.getElementById("pay").value;
        var workDate = document.getElementById("workDate").value;
        var minAge = $("#minAge option:selected").val();
        var maxAge = $("#maxAge option:selected").val();
        var jusoCheck = document.getElementById("address1").readOnly;
        var address1 = document.getElementById("address1").value;
        var address2 = document.getElementById("address2").value;
        var manager = document.getElementById("manager").value;
        var phone1 = document.getElementById("phone1").value;
        var phone2 = document.getElementById("phone2").value;
        var phone3 = document.getElementById("phone3").value;
        var business = document.getElementById("business").value;
        var contents = document.getElementById("contents").value;

        if(title == "") {
            alert("모집 제목을 입력해주세요.");
            document.getElementById("title").focus();
            return false;
        } else if(area1 == "") {
            alert("모집 지역을 선택해주세요.");
            document.getElementById("area_1st").focus();
            return false;
        } else if(area1 != 10000 && area1 != 10001 && area2 == "") {
            alert("모집 지역을 선택해주세요.");
            document.getElementById("area_2nd").focus();
            return false;
        } else if(work2 == "") {
            alert("모집 직종을 선택해주세요.");
            document.getElementById("work_2nd").focus();
            return false;
        } else if(pay == "") {
            alert("일급을 입력해주세요.");
            document.getElementById("pay").focus();
            return false;
        } else if(pay < 0) {
            alert("일급을 똑바로 입력해주세요.");
            document.getElementById("pay").focus();
            return false;
        } else if(workDate == "") {
            alert("모집 근무일을 선택해주세요.");
            return false;
        } else if(minAge == "") {
            alert("최소 연령을 선택해주세요.");
            document.getElementById("minAge").focus();
            return false;
        } else if(maxAge == "") {
            alert("최대 연령을 선택해주세요.");
            document.getElementById("maxAge").focus();
            return false;
        } else if(address1 == "" || address2 == "") {
            alert("근무지 주소를 입력해주세요.");
            document.getElementById("address2").focus();
            return false;
        } else if(!jusoCheck) {
            alert("주소 검색을 통해 주소를 입력해주세요.");
            document.getElementById("address2").focus();
            return false;
        } else if(manager == "") {
            alert("담당자 이름을 입력해주세요.");
            document.getElementById("manager").focus();
            return false;
        } else if(phone1 == "" || phone2 == "" || phone3 == "") {
            alert("담당자 연락처를 입력해주세요.");
            document.getElementById("phone3").focus();
            return false;
        } else if(phone1.length != 3) {
            alert("휴대폰 번호를 똑바로 입력해주세요.");
            document.getElementById("phone1").focus();
            return false;
        } else if(phone2.length != 4) {
            alert("휴대폰 번호를 똑바로 입력해주세요.");
            document.getElementById("phone2").focus();
            return false;
        } else if(phone3.length != 4) {
            alert("휴대폰 번호를 똑바로 입력해주세요.");
            document.getElementById("phone3").focus();
            return false;
        } else if(business == "") {
            alert("담당 업무 내용을 입력해주세요.");
            document.getElementById("business").focus();
            return false;
        } else if(contents == "") {
            alert("상세 모집 내용을 입력해주세요.");
            document.getElementById("contents").focus();
            return false;
        }

        return true;
    }
</script>
<?php include_once "../../include/footer.php" ?>