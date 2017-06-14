<?php include_once "../include/header.php"; ?>
<script>
    function open_popup_BGNXP2I5vR() {
        var dname = document.domain;

        window.open("http://www.newroad.co.kr/find/roadname/BGNXP2I5vR.do?domain="+dname,"popup","width=511,height=675,scrollbars=0");
    }

    function fileInfo(file) {
        var file = file.split("\\");

        document.getElementById("fileName").innerHTML = file[file.length-1];
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
        var number1 = document.getElementById("jijeom_number1").value;
        var number2 = document.getElementById("jijeom_number2").value;
        var number3 = document.getElementById("jijeom_number3").value;
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
    <div class="center">
        <h3 class="branchTitle">지점 신청</h3>
        <img src="../images/branch01.png" alt="등록 신청 정보 입력" />
    </div>
    <div class="mt40 mb100 center branchContent">
        <div class="mt60 mb70">
            <h3 class="f14 bold">지점 신청 관련 <span class="fc">공지사항</span> 및 <span class="fc">유의 사항</span></h3>
            <div class="border-grey p20 lh22">
                1. 조건 불충분에 의해 <span class="fc">미승인</span>이 날수 있습니다.<br>
                2. 허위사실 기재시 부득이하게 <span class="fc">불이익</span>을 당하실 수 있습니다.<br>
                3. 지점신청 후 일방의 자체 검열 후 지정이 되실 수 있습니다.<br>
                4. 지점이 되시면 유로상품 저체를 <span class="fc">50% 할인 서비스</span>를 받으실 수 있습니다.<br>
                5. 추천인을 통해서 매출이 났을 경우 <span class="fc">매출의 30%의 이익</span>을 보실 수 있습니다.<br>
                6. 아웃소싱 및 직업소개소에 한해 지점신청이 가능합니다.
            </div>
        </div>
        <h4 class="f16">지점 정보</h4>
        <div class="branchInfo oh mt10">
            <form action="jijeomResistration.php" method="post" class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1 w100 noMargin" enctype="multipart/form-data" onsubmit="return formCheck()">
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">회사명</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p">
                            <input type="text" class="form-control w100 singupInputs" id="jijeom_company" name="company" placeholder="회사명을 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">대표자 이름</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p">
                            <input type="text" class="form-control singupInputs w100" id="jijeom_ceo" name="ceo" placeholder="대표자 이름을 입력해주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont bb bg_grey">
                    <p class="fl w20 noMargin sect2head di lh40 f14 tc">사업자 번호</p>
                    <div class="fl form-inline sect2Table di lh40 f12 tc noMargin pl40 pr40 pt5 bg_white workDate">
                        <div class="form-group mb10">
                            <input class="form-control singupInputs col-sm-2 w25" id="jijeom_number1" name="number1" type="text" onkeyup="if(this.value > 999) { this.value = (this.value).substring(0, 3); }" />
                            <div class="col-sm-1 f14 tc di w5p">-</div>
                            <input class="form-control singupInputs col-sm-2 w25" id="jijeom_number2" name="number2" type="text" onkeyup="if(this.value > 99) { this.value = (this.value).substring(0, 2); }" />
                            <div class="col-sm-1 f14 tc di w5p">-</div>
                            <input class="form-control singupInputs col-sm-2 w25" id="jijeom_number3" name="number3" type="text" onkeyup="if(this.value > 99999) { this.value = (this.value).substring(0, 5); }" />
                            <input type="button" class="col-sm-2 ml10 w10 lh33 bg_eee border-grey bold br2" value="확인" onclick="numberCheck()" />
                            <input type="hidden" id="numberCheck2" value="" />
                        </div>
                        <p class="fc lh22 mb20">
                            ※ 사업자등록번호 도용 방지를 위해 기업 인증을 시행하고 있습니다.<br />
                            ※ 지점・지사의 경우, 해당 지점・지사의 사업자 등록 번호를 입력해 주세요.<br />
                            ※ 인증이 되지 않을 경우 고객센터(Tel.02-2138-7365)로 문의해 주세요.
                        </p>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14" style="height: 100px;">주소</p>
                    <div class="form-inline mt5">
                        <div class="form-group lh35 pl40 pr40 w78p">
                            <input type="text" class="form-control di w83 singupInputs" id="address1" name="address1" readonly placeholder="주소 검색 버튼을 눌러주세요." />
                            <a href="javascript:open_popup_BGNXP2I5vR()" class="di ml5 bg_eee border-grey bold br2 f12 lh30" style="padding: 4px 6px;">주소 검색</a>
                            <input type="text" class="form-control w100 singupInputs mt5" id="address2" name="address2" placeholder="주소 검색 버튼을 눌러주세요." />
                        </div>
                    </div>
                </div>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">업종 / 기업 형태</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p lh35">
                            <select id="jijeom_types" name="types" class="di h40p mr1p" style="width: 49.1%;">
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
                            <select id="jijeom_status" name="status" class="di h40p" style="width: 49.1%;">
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
                            <select id="jijeom_flotation" name="flotation" class="di h40p w100"></select>
                        </div>
                    </div>
                </div>
                <script>
                    var date = new Date();
                    var year = date.getFullYear();
                    
                    document.getElementById("jijeom_flotation").innerHTML = '<option value="" selected>설립연도 선택</option>';

                    for(var i=year; i>=1900; i--) {
                        document.getElementById("jijeom_flotation").innerHTML += '<option value="' + i + '">' + i + '년</option>';
                    }
                </script>
                <div class="oh cont bb">
                    <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">주요 사업 내용</p>
                    <div class="form-inline lh45">
                        <div class="form-group pl40 pr40 w78p lh35">
                            <input class="form-control singupInputs w100" id="jijeom_content" name="content" type="text" placeholder="주요 사업 내용을 입력해주세요." />
                        </div>
                    </div>
                </div>
             	  <div class="oh cont bb">
             	      <p class="fl tc w20 noMargin sect2head di bg_grey lh45 f14">전화번호</p>
             	      <div class="form-inline lh45">
             	          <div class="form-group pl40 pr40 w78p">
             	              <input type="text" class="form-control singupInputs w25" id="phone1" name="phone1" onkeyup="if(this.value > 999) { this.value = (this.value).substring(0, 3); }" />
             	              <span>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
             	              <input type="text" class="form-control singupInputs w25" id="phone2" name="phone2" onkeyup="if(this.value > 9999) { this.value = (this.value).substring(0, 4); }" />
             	              <span>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
             	              <input type="text" class="form-control singupInputs w25" id="phone3" name="phone3" onkeyup="if(this.value > 999) { this.value = (this.value).substring(0, 4); }" />
             	          </div>
             	      </div>
             	  </div>
             	  <div class="oh cont bb">
                    <p class="fl w20 noMargin sect2head di bg_grey lh45 f14 tc">인증서</p>
                    <div class="form-inline w80 fl lh45">
                        <span class="fl pl40 textCut jijeomFileName" id="fileName">선택한 파일이 없습니다.</span>
                        <div class="filebox fr pr50">
                            <label for="ex_file" class="mb0">파일 선택</label> 
                            <input type="file" id="ex_file" name="file" accept="image/*" onchange="fileInfo(this.value)" />
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
    $("#jijeom_ceo").keyup(function() {
        $(this).val($(this).val().replace(/[ 0-9 | \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi, ''));
    });

    $("#jijeom_number1").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#jijeom_number2").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#jijeom_number3").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#jijeom_phone1").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#jijeom_phone2").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    $("#jijeom_phone3").keyup(function() {
        $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
    });

    function formCheck() {
        var id = "<?php echo $uid; ?>";
        var company = document.getElementById("jijeom_company").value;
        var number1 = document.getElementById("jijeom_number1").value;
        var number2 = document.getElementById("jijeom_number2").value;
        var number3 = document.getElementById("jijeom_number3").value;
        var number = number1 + number2 + number3;
        var numberCheck = checkBizID(number);
        var numberCheck2 = document.getElementById("numberCheck2").value;
        var address1 = document.getElementById("address1").value;
        var address2 = document.getElementById("address2").value;
        var ceo = document.getElementById("jijeom_ceo").value;
        var status = $("#jijeom_status option:selected").val();
        var types = $("#jijeom_types option:selected").val();
        var flotation = $("#jijeom_flotation option:selected").val();
        var content = document.getElementById("jijeom_content").value;
        var phone1 = document.getElementById("jijeom_phone1").value;
        var phone2 = document.getElementById("jijeom_phone2").value;
        var phone3 = document.getElementById("jijeom_phone3").value;
        var file = document.getElementById("ex_file").value;

        if(id == "") {
            alert("로그인 후 이용해주세요.");
            return false;
        } else if(company == "") {
            alert("회사명을 입력해주세요.");
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
        } else if(address1 == "" || address2 == "") {
            alert("주소를 입력해주세요.");
            return false;
        } else if(ceo == "") {
            alert("대표 이름을 입력해주세요.");
            return false;
        } else if(types == "") {
            alert("업종을 선택해주세요.");
            return false;
        } else if(status == "") {
            alert("기업 형태를 선택해주세요.");
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
            alert("인증서 파일을 선택해주세요.");
            return false;
        }

        return true;
    }
</script>
<?php include_once "../include/footer.php"; ?>