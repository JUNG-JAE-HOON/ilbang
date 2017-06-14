<?php include_once "../../include/header.php"; ?>
<script type="text/javascript" src="../../js/jquery-ui-1.11.1.js"></script>
<script>
    $(document).ready(function() {
        var type = "<?php echo $kind; ?>";
        var emailCheck = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

        if(type == "general") {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../../ajax/gujik/getMemberInfo.php',
                success: function(data) {
                    if(data.message != null) {
                        alert(data.message);
                        history.back();
                    } else {
                        document.getElementById("memberName").innerHTML = data.memberInfo.name;
                        document.getElementById("memberBirth").innerHTML = data.memberInfo.birth + " / " + data.memberInfo.sex;
                        document.getElementById("memberPhone").innerHTML = data.memberInfo.phone;
                        document.getElementById("memberEmail").innerHTML = data.memberInfo.email;
                        document.getElementById("memberObstacle").innerHTML = data.memberInfo.obstacle;

                        if(data.memberInfo.birth == null || data.memberInfo.sex == null || data.memberInfo.birth == "" || data.memberInfo.sex == "") {
                            document.getElementById("memberBirth").innerHTML += '<span class="fc ml20">* 회원 정보 수정 요망</span>';
                        }

                        if(data.memberInfo.phone == null || data.memberInfo.phone == "" || (data.memberInfo.phone).length < 12 || (data.memberInfo.phone).length > 13) {
                            document.getElementById("memberPhone").innerHTML += '<span class="fc ml20">* 회원 정보 수정 요망</span>';
                        }

                        if(data.memberInfo.email == null || data.memberInfo.email == "" || !emailCheck.test(data.memberInfo.email) || (data.memberInfo.email).indexOf("undefined") == 0) {
                            document.getElementById("memberEmail").innerHTML += '<span class="fc ml20">* 회원 정보 수정 요망</span>';
                        }

                        if(data.memberInfo.obstacle == null || data.memberInfo.obstacle == "") {
                            document.getElementById("memberObstacle").innerHTML += '<span class="fc ml20">* 회원 정보 수정 요망</span>';
                        }

                        if(data.memberInfo.age < 20) {
                            document.getElementById("ageLimit").innerHTML = '* 19세 이하는 봉사 일방에만 신청할 수 있습니다. *';
                        }

                        pay();
                    }
                }
            });

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../../ajax/gujik/getCategoryList.php',
                success: function(data) {
                    document.getElementById("area_1st").innerHTML = '<option value="" selected>희망 지역(1차)</option>';
                    document.getElementById("area_2nd").innerHTML = '<option value="" selected>희망 지역(2차)</option>';

                    for(var i=0; i<data.areaList.length; i++) {
                        document.getElementById("area_1st").innerHTML += '<option value="' + data.areaList[i].no + '">' + data.areaList[i].name + '</option>';
                    }
                }
            });

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../../ajax/gujik/getProfileImage.php',
                success: function(data) {
                    var img_url = data.logoData.img_url;

                    if(img_url != null) {
                        var profile_img= document.getElementById("profile_img");

                        profile_img.src="../../gujikImage/" + img_url;
                    }
                }
            });
        } else {
            alert("개인 회원만 이용할 수 있습니다.");
            history.back();
        }
    });

    function pay() {
        document.getElementById("pay").innerHTML
        = '<option value="0" selected>0원</option>'
        + '<option value="50000">50,000원</option>'
        + '<option value="55000">55,000원</option>'
        + '<option value="60000">60,000원</option>'
        + '<option value="65000">65,000원</option>'
        + '<option value="70000">70,000원</option>'
        + '<option value="75000">75,000원</option>'
        + '<option value="80000">80,000원</option>'
        + '<option value="85000">85,000원</option>'
        + '<option value="90000">90,000원</option>'
        + '<option value="100000">100,000원</option>'
        + '<option value="110000">110,000원</option>'
        + '<option value="120000">120,000원</option>'
        + '<option value="130000">130,000원</option>'
        + '<option value="140000">140,000원</option>'
        + '<option value="150000">150,000원</option>'
        + '<option value="160000">160,000원</option>'
        + '<option value="170000">170,000원</option>'
        + '<option value="180000">180,000원</option>'
        + '<option value="190000">190,000원</option>'
        + '<option value="200000">200,000원</option>'
        + '<option value="220000">220,000원</option>'
        + '<option value="230000">230,000원</option>'
        + '<option value="250000">250,000원</option>'
        + '<option value="280000">280,000원</option>'
        + '<option value="300000">300,000원</option>'
        + '<option value="350000">350,000원</option>'
        + '<option value="400000">400,000원</option>'
        + '<option value="450000">450,000원</option>'
        + '<option value="500000">500,000원</option>';
    }
</script>
<div class="container pl30">
    <form action="gujikRegistration.php" method="post" class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 w100 noMargin" onsubmit="return formCheck()">
        <h4 class="mt40 di f16">기본 회원 정보</h4>
        <h5 class="di fr mt40 f12">여러 개의 이력서를 작성하고 싶을 때! <span class="prdBuyBtn"><a href="../../itemShop/itemshop.php" class="fff" style="padding: 2px 3px;">상품 구매</a></span></h5>
        <div class="formWrite oh mt5 mb50 pr">
            <div class="photo pa border-grey oh bg_grey w20 tc pt45" style="height:192px">
                <div>
                    <img src="../../images/profile.png" alt="" class="" id="profile_img" style="width: 86px; height: 86px;">
                </div>
            </div>
            <div class="oh">
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">이름 <span class="fc">*</span></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="memberName"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">생년월일 / 성별 <span class="fc">*</span></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="memberBirth"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">연락처 <span class="fc">*</span></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="memberPhone"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">이메일 <font class="fc">*</font></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="memberEmail"></div>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pdl20">장애 여부 <font class="fc">*</font></p>
                    <div class="form-inline lh45">
                        <div class="form-group ml10 w50" id="memberObstacle"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tc mb20 f14 fc bold" id="ageLimit"></div>
        <!-- <div class="w100 oh mb20">
            <h4 class="f16">이력서 제목</h4>
            <select id="title" name="title" class="di col-sm-4 mt7 applyTitle inputIcon f14" style="height: 50px;">
                <option value="" selected>내 이력서를 돋보이게 하는 제목을 선택하세요.</option>
                <option value="취업대란! 오히려 제게는 기회입니다.">취업대란! 오히려 제게는 기회입니다.</option>
                <option value="새싹을 틔울 수 있는 씨앗이 되겠습니다.">새싹을 틔울 수 있는 씨앗이 되겠습니다.</option>
                <option value="백만 불짜리 열정으로 능력을 보여드리겠습니다.">백만 불짜리 열정으로 능력을 보여드리겠습니다.</option>
                <option value="내일을 향한 작은 준비들">내일을 향한 작은 준비들</option>
            </select>
        </div> -->
        <div class="w100p oh">
            <h4 class="f16 mb10">이력서 작성</h4>
        </div>  
        <div class="formWrite oh mb30">
            <div class="oh">
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">이력서 제목 <span class="fc">*</span></p>
                    <input type="text" name="title" id="title" class="form-control margin di" placeholder="이력서 제목을 입력해주세요." style="width: 77%; margin-bottom: 0 !important;" />
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">희망 근무 지역 <span class="fc">*</span></p>
                    <select id="area_1st" name="area_1st" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon" onchange="area1Change(this.value)"></select>
                    <select id="area_2nd" name="area_2nd" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon"></select>
                </div>
                <script>
                    function area1Change(val) {
                        if(val == "") {
                            document.getElementById("area_2nd").innerHTML = '<option value="" selected>희망 지역(2차)</option>';
                        } else if(val == 10000) {
                            document.getElementById("area_2nd").innerHTML = '<option value="" selected>전국</option>';
                        } else if(val == 10001) {
                            document.getElementById("area_2nd").innerHTML = '<option value="" selected>전체</option>';
                        } else {
                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                url: '../../ajax/gujik/getCategoryList.php',
                                data: { area1: val },
                                success: function(data) {
                                    document.getElementById("area_2nd").innerHTML = '<option value="" selected>희망 지역(2차)</option>';

                                    for(var i=0; i<data.areaList2.length; i++) {
                                        document.getElementById("area_2nd").innerHTML += '<option value="' + data.areaList2[i].no + '">' + data.areaList2[i].name + '</option>';
                                    }
                                }
                            });
                        }
                    }
                </script>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">희망 직종 <span class="fc">*</span></p>
                    <select id="work_1st" name="work_1st" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon">
                        <option value="8000" selected>특성별</option>
                    </select>
                    <select id="work_2nd" name="work_2nd" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon" onchange="work2Change(this.value)"></select>
                </div>
                <script>
                    var work1 = document.getElementById("work_1st");
                    var work1Val = work1.options[work1.selectedIndex].value;

                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: '../../ajax/gujik/getCategoryList.php',
                        data: { work1: work1Val },
                        success: function(data) {
                            document.getElementById("work_2nd").innerHTML = '<option value="" selected>희망 직종(2차)</option>';

                            for(var i=0; i<data.workList.length; i++) {
                                document.getElementById("work_2nd").innerHTML += '<option value="' + data.workList[i].no + '">' + data.workList[i].name + '</option>';
                            }
                        }
                    });
                </script>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">희망 일급 <span class="fc">*</span></p>                  
                    <select id="pay" name="pay" class="di col-sm-4 mt7 ml10 changeInput w180 inputIcon mr10"></select>
                    <div id="bongsa" class="fc fl" style="padding-top: 14px;"></div>
                </div>
                <script>
                    function work2Change(val) {
                        if(val == 8017) {
                            document.getElementById("pay").innerHTML = '<option value="0" selected>0원</option>';
                            document.getElementById("bongsa").innerHTML = '* 봉사 일방은 일급 0원만 선택할 수 있습니다.';
                        } else {
                            pay();
                            document.getElementById("bongsa").innerHTML = '';
                        }
                    }
                </script>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20 cldArea">희망 근무일 <span class="fc">*</span></p>
                    <div class="col-sm-4 mt8 ml10 w78p">
                        <script type="text/javascript" src="../../js/jquery-ui.multidatespicker.js"></script> 
                        <input type="hidden" data-role="date" id="workDate" name="workDate" value="" />
                        <div style="margin-top:0.5em;" id="dateForm"></div>
                        <script type="text/javascript">
                            $(function() {
                                var today = new Date();

                                $('#dateForm').multiDatesPicker({
                                    minDate: 0,
                                    maxDate: 60,
                                    altField: '#workDate'
                                });
                            });
                        </script>
                    </div>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">희망 근무 시간 <span class="fc">*</span></p>
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
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">경력 사항 <span class="fc">*</span></p>
                    <select name="career" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon">
                        <option value="0" selected>신입</option>
                        <option value="1">1년 미만</option>
                        <option value="3">3년 미만</option>
                        <option value="5">5년 미만</option>
                        <option value="6">5년 이상</option>
                    </select>
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20" style="height: 100px;">자기 소개 <span class="fc">*</span></p>
                    <textarea class="form-control margin di" id="contents" name="contents" style="width:77%;" rows="3" placeholder="간단한 소개를 입력해주세요."></textarea>      
                </div>
                <div class="oh cont">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 pl20">이력서 공개 여부 <span class="fc">*</span></p>
                    <select id="open" name="open" class="di col-sm-4 mt7 ml10 changeInput w145 inputIcon mr10" onchange="openChange(this.value)">
                        <option value="yes" selected>공개</option>
                        <option value="no">비공개</option>
                    </select>
                    <div id="openMent" class="fc fl" style="padding-top: 14px;"></div>
                </div>
                <script>
                    function openChange(val) {
                        if(val == "no") {
                            document.getElementById("openMent").innerHTML = '* 비공개로 설정하시면 이력서가 구인자에게 노출되지 않습니다.';
                        } else {
                            document.getElementById("openMent").innerHTML = '';
                        }
                    }
                </script>        
            </div>
        </div>
        <div class="tc mb40">
            <input type="submit" class="cp gujikWrtBtn lh1 f14" value="이력서 작성 완료" style="padding: 12px 25px;" />
        </div>
    </form>
</div>
<script>
    function formCheck() {
        var title = document.getElementById("title").value;
        var area1 = $("#area_1st option:selected").val();
        var area2 = $("#area_2nd option:selected").val();
        var work2 = $("#work_2nd option:selected").val();
        var workDate = document.getElementById("workDate").value;
        var open = $("#open option:selected").val();
        var contents = document.getElementById("contents").value;

        if(title == "") {
            alert("이력서 제목을 입력해주세요.");
            document.getElementById("title").focus();
            return false;
        } else if(area1 == "") {
            alert("희망 지역을 선택해주세요.");
            document.getElementById("area_1st").focus();
            return false;
        } else if(area1 != 10000 && area1 != 10001 && area2 == "") {
            alert("희망 지역을 선택해주세요.");
            document.getElementById("area_2nd").focus();
            return false;
        } else if(work2 == "") {
            alert("희망 직종을 선택해주세요.");
            document.getElementById("work_2nd").focus();
            return false;
        } else if(workDate == "") {
            alert("희망 근무일을 선택해주세요.");
            return false;
        } else if(contents == "") {
            alert("자기 소개를 입력해주세요.");
            document.getElementById("content").focus();
            return false;
        }

        return true;
    }
</script>
<?php include_once "../../include/footer.php" ?>