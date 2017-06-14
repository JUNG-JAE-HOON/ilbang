<?php include_once "../include/header.php"; ?>
<div id="map"></div>
<script>
    $(document).ready(function() {
        getArea1();
    });

    function getCoordinates(addr) {
        var geocoder = new daum.maps.services.Geocoder();

        geocoder.addr2coord(addr, function(status, result) {
            if (status === daum.maps.services.Status.OK) {
                var coords = new daum.maps.LatLng(result.addr[0].lat, result.addr[0].lng);

                document.getElementById("lat").value = result.addr[0].lat;
                document.getElementById("lng").value = result.addr[0].lng;
            }
        });   
    }

    function open_popup_BGNXP2I5vR() {
        var dname = document.domain;

        window.open("http://www.newroad.co.kr/find/roadname/BGNXP2I5vR.do?domain="+dname,"popup","width=511,height=675,scrollbars=0");
    }

    function fileInfo(file) {
        var file = file.split("\\");

        document.getElementById("fileName").innerHTML = file[file.length-1];
    }

    function getArea1() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/gujik/getCategoryList.php',
            success: function(data) {
                document.getElementById("area_1st").innerHTML = '<option value="" selected>희망 지역(1차)</option>';
                document.getElementById("area_2nd").innerHTML = '<option value="" selected>희망 지역(2차)</option>';

                for(var i=0; i<data.areaList.length; i++) {
                    document.getElementById("area_1st").innerHTML += '<option value="' + data.areaList[i].no + '">' + data.areaList[i].name + '</option>';
                }
            }
        });
    }

    function adminCodeCheck() {
        var code = document.getElementById("adminCode").value;

        if(code == "") {
            alert("관리자 코드를 똑바로 입력해주세요.");
        } else {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/gameng/findAdminCode.php',
                data: { code: code },
                success: function(data) {
                    if(data == 0) {
                        alert("사용 가능한 관리자 코드입니다.");
                    } else {
                        alert("이미 사용중인 관리자 코드입니다.");
                    }

                    document.getElementById("adminChk").value = data;
                }
            });
        }
    }

    function checkBizID(bizID)  {
        // bizID는 숫자만 10자리로 해서 문자열로 넘긴다.
        var checkID = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5, 1);
        var tmpBizID, i, chkSum = 0, c2, remander;

        bizID = bizID.replace(/-/gi,'');

        for (i=0; i<=7; i++) {
            chkSum += checkID[i] * bizID.charAt(i);
        }

        c2 = "0" + (checkID[8] * bizID.charAt(8));
        c2 = c2.substring(c2.length - 2, c2.length);
        chkSum += Math.floor(c2.charAt(0)) + Math.floor(c2.charAt(1));
        remander = (10 - (chkSum % 10)) % 10 ;

        if (Math.floor(bizID.charAt(9)) == remander) {
            return true ; // OK!
        }

        return false;
    }

    function numberCheck() {
        var number1 = document.getElementById("gameng_number1").value;
        var number2 = document.getElementById("gameng_number2").value;
        var number3 = document.getElementById("gameng_number3").value;
        var number = number1 + "-" + number2 + "-" + number3;
        var chkNumber = number1 + number2 + number3;
        var numberCheck = checkBizID(chkNumber);

        if(!numberCheck || number1 == "" || number2 == "" || number3 == "") {
            alert("잘못된 사업자 번호입니다.");
        } else {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/jijeom/numberCheck.php',
                data: { number: number },
                success: function(data) {
                    document.getElementById("numberCheck2").value = data;

                    if(data == 1) {
                        alert("이미 등록된 사업자 번호입니다.");
                    } else {
                        alert("사용 가능한 사업자 번호입니다.");
                    }
                }
            });
        }
    }
</script>
<div class="branchApply branchpWrap">
    <div class="center"><h3 class="branchTitle">가맹점 신청</h3></div>
        <h4 class="f16">가맹점 정보</h4>
        <div class="branchInfo oh mt10">
            <input type="hidden" id="adminChk" />
            <form action="gamengResistration.php" method="post" class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 w100 noMargin" enctype="multipart/form-data" onsubmit="return formCheck()">
                <input type="hidden" id="lat" name="lat" />
                <input type="hidden" id="lng" name="lng" />
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">카테고리</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p lh35">
                            <select id="gameng_category" name="category" class="di h40p w100">
                                <option value="" selected>카테고리 선택</option>
                                <option value="음식">음식</option>
                                <option value="카페/디저트">카페/디저트</option>
                                <option value="패션">패션</option>
                                <option value="헬스/레저">헬스/레저</option>
                                <option value="교육">교육</option>
                                <option value="주유/차량">주유/차량</option>
                                <option value="뷰티/마사지">뷰티/마사지</option>
                                <option value="마트/생활">마트/생활</option>
                                <option value="숙박">숙박</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">가맹점 이름</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p">
                            <input type="text" class="form-control w100 singupInputs" id="gameng_name" name="name" placeholder="가맹점 이름을 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">대표자 이름</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p">
                            <input type="text" class="form-control w100 singupInputs" id="gameng_ceo" name="ceo" placeholder="대표자 이름을 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont bb bg_grey">
                    <p class="fl w20 noMargin sect2head di lh40 f14 tc">사업자 번호</p>
                    <div class="fl form-inline sect2Table di lh40 f12 tc noMargin pl40 pr40 pt5 bg_white workDate">
                        <div class="form-group mb10">
                            <input class="form-control singupInputs col-sm-2 w25" id="gameng_number1" name="number1" type="text" onkeyup="if(this.value > 999) { this.value = (this.value).substring(0, 3); }" />
                            <div class="col-sm-1 f14 tc di w5p">-</div>
                            <input class="form-control singupInputs col-sm-2 w25" id="gameng_number2" name="number2" type="text" onkeyup="if(this.value > 99) { this.value = (this.value).substring(0, 2); }" />
                            <div class="col-sm-1 f14 tc di w5p">-</div>
                            <input class="form-control singupInputs col-sm-2 w25" id="gameng_number3" name="number3" type="text" onkeyup="if(this.value > 99999) { this.value = (this.value).substring(0, 5); }" />
                            <input type="button" class="col-sm-2 ml10 w10 lh33 bg_eee border-grey bold br2" value="확인" onclick="numberCheck()" />
                            <input type="hidden" id="numberCheck2" value="" />
                        </div>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14" style="height: 140px;">가맹점 주소</p>
                    <div class="form-inline mt5">
                        <div class="form-group lh35 pl40 pr40 w78p mb5">
                            <select id="area_1st" name="area_1st" class="di col-sm-4 singupInputs w145 inputIcon mr5" onchange="area1Change(this.value)"></select>
                            <select id="area_2nd" name="area_2nd" class="di col-sm-4 singupInputs w145 inputIcon"></select>
                            <input type="text" class="form-control di w83 singupInputs" id="address1" name="address1" readonly placeholder="주소 검색 버튼을 눌러주세요." />
                            <a href="javascript:open_popup_BGNXP2I5vR()" class="di ml5 bg_eee border-grey bold br2 f12 lh30 mt5" style="padding: 4px 6px;">주소 검색</a>
                            <input type="text" class="form-control w100 singupInputs mt5" id="address2" name="address2" />
                        </div>
                    </div>
                </div>
                <script>
                    function area1Change(val) {
                        if(val == "") {
                            document.getElementById("area_2nd").innerHTML = '<option value="" selected>희망 지역(2차)</option>';
                        } else if(val == 10000) {
                            document.getElementById("area_2nd").innerHTML = '<option value="10000" selected>전국</option>';
                        } else if(val == 10001) {
                            document.getElementById("area_2nd").innerHTML = '<option value="10001" selected>전체</option>';
                        } else {
                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                url: '../ajax/gujik/getCategoryList.php',
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
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">업종 / 기업 형태</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p lh35">
                            <select id="gameng_types" name="types" class="di h40p mr1p" style="width: 49.2%;">
                                <option value="" selected>업종 선택</option>
                                <option value="서비스업">서비스업</option>
                                <option value="제조/화학">제조/화학</option>
                                <option value="의료/제약/복지">의료/제약/복지</option>
                                <option value="판매/유통">판매/유통</option>
                                <option value="교육업">교육업</option>
                                <option value="건설업">건설업</option>
                                <option value="IT/통신">IT/통신</option>
                                <option value="미디어/디자인">미디어/디자인</option>
                                <option value="은행/금융업">은행/금융업</option>
                                <option value="기관/협회">기관/협회</option>
                            </select>
                            <select id="gameng_status" name="status" class="di h40p" style="width: 49.2%;">
                                <option value="" selected>기업 형태 선택</option>
                                <option value="소기업">소기업</option>
                                <option value="중기업">중기업</option>
                                <option value="대기업">대기업</option>
                                <option value="벤쳐기업">벤쳐기업</option>
                                <option value="외국계기업">외국계기업</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">설립연도</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p lh35">
                            <select id="gameng_flotation" name="flotation" class="di h40p w100"></select>
                        </div>
                    </div>
                </div>
                <script>
                    var date = new Date();
                    var year = date.getFullYear();
                    
                    document.getElementById("gameng_flotation").innerHTML = '<option value="" selected>설립연도 선택</option>';

                    for(var i=year; i>=1900; i--) {
                        document.getElementById("gameng_flotation").innerHTML += '<option value="' + i + '">' + i + '년</option>';
                    }
                </script>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">주요 사업 내용</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p lh35">
                            <input class="form-control singupInputs w100" id="gameng_content" name="content" type="text" placeholder="주요 사업 내용을 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">할인율</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p">
                            <input type="text" class="form-control singupInputs w100" id="discountRate" name="discountRate" placeholder="할인율을 입력해주세요. (%)" />
                        </div>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">관리자 코드</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p">
                            <input type="text" class="form-control singupInputs w83 di" id="adminCode" name="adminCode" placeholder="관리자 코드를 입력해주세요." />
                            <a href="javascript:adminCodeCheck()" class="di ml5 bg_eee border-grey w10 tc bold br2 f12 lh30 mt5" style="padding: 4px 6px;">확인</a>
                        </div>
                    </div>
                </div>
             	  <div class="oh cont bb">
             	      <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">전화번호</p>
             	      <div class="form-inline lh45">
             	          <div class="form-group pl40 pr40 w78p">
             	              <input type="text" class="form-control singupInputs w25" id="gameng_phone1" name="phone1" onkeyup="if(this.value > 999) { this.value = (this.value).substring(0, 3); }" />
             	              <span>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
             	              <input type="text" class="form-control singupInputs w25" id="gameng_phone2" name="phone2" onkeyup="if(this.value > 9999) { this.value = (this.value).substring(0, 4); }" />
             	              <span>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
             	              <input type="text" class="form-control singupInputs w25" id="gameng_phone3" name="phone3" onkeyup="if(this.value > 999) { this.value = (this.value).substring(0, 4); }" />
             	          </div>
             	      </div>
             	  </div>
             	  <div class="oh cont bb">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 tc">가맹점 로고 이미지</p>
                    <div class="form-inline w80 fl lh45">
                        <span class="fl pl40 textCut" id="fileName" style="width: 380px;">선택한 파일이 없습니다. (크기 : 58x58 픽셀, png파일만 가능)</span>
                        <div class="filebox fr pr50">
                            <label for="ex_file" class="mb0">파일 선택</label> 
                            <input type="file" id="ex_file" name="file" accept="image/png" onchange="fileInfo(this.value)" />
                        </div>
                    </div>
                </div>
                <div class="center tc mb100 pt70">
                    <a class="c-red beforeBtn btn mr45" href="javascript:history.back();">취소하기</a>
                    <input type="submit" class="fff nextBtn btn" value="신청하기" />
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $("#gameng_ceo").keyup(function() {
        $(this).val($(this).val().replace(/[ 0-9 | \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi, ''));
    });

    $("#discountRate").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#gameng_number1").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#gameng_number2").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#gameng_number3").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#gameng_phone1").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#gameng_phone2").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#gameng_phone3").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    function formCheck() {
        var id = "<?php echo $uid; ?>";
        var name = document.getElementById("gameng_name").value;
        var ceo = document.getElementById("gameng_ceo").value;
        var number1 = document.getElementById("gameng_number1").value;
        var number2 = document.getElementById("gameng_number2").value;
        var number3 = document.getElementById("gameng_number3").value;
        var number = number1 + number2 + number3;
        var numberCheck = checkBizID(number);
        var numberCheck2 = document.getElementById("numberCheck2").value;
        var area1 = $("#area_1st option:selected").val();
        var area2 = $("#area_2nd option:selected").val();
        var address1 = document.getElementById("address1").value;
        var address2 = document.getElementById("address2").value;
        var discountRate = document.getElementById("discountRate").value;
        var code = document.getElementById("adminCode").value;
        var codeChk = document.getElementById("codeChk").value;
        var status = $("#gameng_status option:selected").val();
        var types = $("#gameng_types option:selected").val();
        var flotation = $("#gameng_flotation option:selected").val();
        var content = document.getElementById("gameng_content").value;
        var phone1 = document.getElementById("gameng_phone1").value;
        var phone2 = document.getElementById("gameng_phone2").value;
        var phone3 = document.getElementById("gameng_phone3").value;
        var file = document.getElementById("ex_file").value;

        if(id == "") {
            alert("로그인 후 이용해주세요.");
            return false;
        } else if(name == "") {
            alert("가맹점 이름을 입력해주세요.");
            return false;
        } else if(ceo == "") {
            alert("대표자 이름을 입력해주세요.");
            return false;
        } else if(number1 == "" || number2 == "" || number3 == "") {
            alert("사업자 번호를 입력해주세요.");
            return false;
        } else if(!numberCheck) {
            alert("사업자 등록 번호를 똑바로 입력해주세요.");
            return false;
        } else if(numberCheck2 == 1) {
            alert("이미 등록된 사업자 번호입니다.");
            return false;
        } else if(area1 == "" || area2 == "") {
            alert("지역을 선택해주세요.");
            return false;
        } else if(address1 == "" || address2 == "") {
            alert("주소를 입력해주세요.");
            return false;
        } else if(discountRate == "") {
            alert("할인율을 입력해주세요.");
            return false;
        } else if(code == "" || codeChk != 0) {
            alert("관리자 코드를 똑바로 입력해주세요.");
            return false;
        } else if(status == "") {
            alert("기업 형태를 선택해주세요.");
            return false;
        } else if(types == "") {
            alert("업종을 선택해주세요.");
            return false;
        } else if(flotation == "") {
            alert("설립연도를 선택해주세요.");
            return false;
        } else if(content == "") {
            alert("주요 사업 내용을 입력해주세요.");
            return false;
        } else if(phone1 == "" || phone2 == "" || phone3 == "") {
            alert("전화번호를 입력해주세요.");
            return false;
        } else if(file == "") {
            alert("이미지 파일을 선택해주세요.");
            return false;
        }

        return true;
    }
</script>
<?php include_once "../include/footer.php"; ?>