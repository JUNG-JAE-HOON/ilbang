<?php include_once "../log/session.php"; ?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no” />
    <title>PC버전 리뉴얼</title>
    <link rel="stylesheet" href="./../css/bootstrap.css?ver=1.0.7">
    <link rel="stylesheet" href="./../css/default.css?ver=1.0.7">
    <link rel="stylesheet" href="./../css/hwajin.css">
    <link rel="stylesheet" href="./../css/yeojin.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>   
    <script>
        var id = "<?php echo $uid; ?>";

        if(id != "") {
            alert("로그아웃 후 이용해주세요.");
            document.location.href = '../index.php';
        }

        function enterKey(event, type) {
            if(event.keyCode == 13) {
                modalLogin();
            }
        }
    </script>
</head>
<body>
    <div class="container center wdfull singNavBb">
        <div class="pg_rp singNavPad mt15">
            <nav class="navbar-default">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <div class="mr10">
                                    <a href="../index.php"><img src="./../images/signUp/logo_03.png" alt="logo"/></a>
                                </div>
                            </li>
                            <li class="c-red pt40 pb10 f16">회원가입</li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="pt40 pb10"><a href="../index.php" class="signNav">Home</a></li>
                            <li class="pt40 pb10"><a href="#" class="signNav" data-toggle="modal" data-target="#loginModal">로그인</a></li>
                            <li class="pt40 pb10"><a href="../cs/cs.php?tab=2" class="signNav">고객센터</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
        </div>
    </div>
    <div class="modal fade c666" id="loginModal">
        <div class="modal-dialog" style="width: 300px; margin-top: 20%;">
            <div class="modal-content" style="border: 5px solid #eb5f43;">
                <div class="modal-body f14 tc" style="padding: 30px 10%;">
                    <div class="mb5"><input type="text" class="form-control" id="user_id" name="user_id" placeholder="아이디 입력" onkeypress="enterKey(event)" /></div>
                    <div class="mb10"><input type="password" class="form-control" id="user_pwd" name="user_pwd" placeholder="비밀번호 입력" onkeypress="enterKey(event)" /></div>
                    <a href="javascript:modalLogin()" class="f16">
                        <div class="margin-auto active-btn padding-vertical mb20">로그인</div>
                    </a>
                    <div class="f12">혹시
                        <a href="pwidFind.php?tab=1" class="underline"><span>아이디</span></a> 또는 
                        <a href="pwidFind.php?tab=2" class="underline"><span>비밀번호</span></a>를 잊으셨나요?
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function modalLogin() {
            var user_id = document.getElementById("user_id").value;
            var user_pwd = document.getElementById("user_pwd").value;

            if(user_id == "") {
                alert("아이디를 입력해주세요.");
                document.getElementById("user_id").focus();
            } else if(user_pwd == "") {
                alert("비밀번호를 입력해주세요.");
                document.getElementById("user_pwd").focus();
            } else {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '../log/modalLogin.php',
                    data: { user_id: user_id, user_pwd: user_pwd },
                    success: function(data) {
                        if(data.login.val) {
                            document.location.href = '../index.php';
                        } else {
                            alert(data.login.message);
                        }
                    }
                });
            }
        }
    </script>
    <!-- nav end! -->
    <div class="signupWrap center">
        <div>
            <div class="mt50 mb50 tc">
                <div class="tc di mr15">
                    <div class="signupC">
                        <p class="f14 mb0">step<strong class="f20">1</strong></p>
                        <p class="bold">회원 구분</p>
                    </div>
                </div>
                <div class="tc di mr15">
                    <img src="./../images/next.png" alt="next" class="pb20"/>
                </div>
                <div class="tc di mr15">
                    <div class="signupC">
                        <p class="f14 mb0">step<strong class="f20">2</strong></p>
                        <p class="bold">약관 동의</p>
                    </div>
                </div>
                <div class="tc di mr15">
                    <img src="./../images/next.png" alt="next" class="pb20"/>
                </div>
                <div class="tc di mr15">
                    <div class="signupSelectC">
                        <p class="f14 mb0">step<strong class="f20">3</strong></p>
                        <p class="bold">정보 입력</p>
                    </div>
                </div>
                <div class="tc di mr15">
                    <img src="./../images/next.png" alt="next" class="pb20"/>
                </div>
                <div class="tc di mr15">
                    <div class="signupC">
                        <p class="f14 mb0">step<strong class="f20">4</strong></p>
                        <p class="bold">가입 완료</p>
                    </div>
                </div>
            </div><div class="clear"></div>
            <input type="hidden" id="idCheck" value="" />
            <!-- step circle end! -->
            <div class="mt50 mb50 tc">
                <h3>정보 입력 (기업 회원)</h3>
                <h4 class="tc f12 c555 mt15 lh20">빠르고 정확한 구인/구직을 위해 회원님의 정확한 정보를 입력해주세요.<br />
                    <span class="c-red">*은 필수 입력 사항입니다.</span>
                </h4>
                <!-- form -->
                <div class="signupFormWrap" style="padding: 0 14%;">
                    <hr align="center" class="step3Hr2">
                    <form class="form-horizontal" action="memberJoin.php" method="post" onsubmit="return formCheck()">
                        <input type="hidden" name="kind" value="company" />
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="id">아이디 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10 mr1p" style="width: 68.33%;">
                                <input class="form-control singupInputs" id="id" name="id" type="text" placeholder="아이디를 입력해주세요." onkeyup="blankCheck('id', this.value)" />
                            </div>
                            <a href="javascript:idSearch()">
                                <div class="active-btn fl h40p" style="width: 12%; line-height: 40px; border-radius: 2px;">중복 확인</div>
                            </a>
                            <div id="idMent" class="fc tl bold clear" style="margin-left: 19%; padding-top: 5px;"></div>
                        </div><!-- 아이디 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="password">비밀번호 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs" id="pwd" name="pwd" type="password" placeholder="비밀번호를 입력해주세요." onkeyup="blankCheck('pwd', this.value)" />
                            </div>
                            <div id="pwdMent" class="fc tl bold clear" style="margin-left: 19%; padding-top: 5px;"></div>
                        </div><!-- 비밀번호입 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="password">비밀번호 확인 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs" id="pwd2" type="password" placeholder="비밀번호를 재입력해주세요." onkeyup="blankCheck('pwd2', this.value)" />
                            </div>
                            <div id="pwdMent2" class="fc tl bold clear" style="margin-left: 19%; padding-top: 5px;"></div>
                        </div><!-- 비밀번호 재입력 end! -->
                        <hr align="center" class="step3Hr2">
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="ceo">이름 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs" id="name" name="name" type="text" placeholder="이름을 입력해주세요." />
                            </div>
                        </div><!-- 대표자 이름 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="birth">생년월일 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <select id="year" name="year" class="di w32 h40p mr1p"></select>
                                <select id="month" name="month" class="di w32 h40p mr1p"></select>
                                <select id="day" name="day" class="di h40p" style="width: 32.6%;"></select>
                                <script>
                                    var date = new Date();
                                    var year = date.getFullYear() - 15;

                                    document.getElementById("year").innerHTML = '<option value="" selected>년도</option>';
                                    document.getElementById("month").innerHTML = '<option value="" selected>월</option>';
                                    document.getElementById("day").innerHTML = '<option value="" selected>일</option>';

                                    for(var i=year; i>=1900; i--) {
                                        document.getElementById("year").innerHTML += '<option value="' + i + '">' + i + '</option>';
                                    }

                                    for(var i=1; i<=12; i++) {
                                        document.getElementById("month").innerHTML += '<option value="' + i + '">' + i + '</option>';
                                    }

                                    for(var i=1; i<=31; i++) {
                                        document.getElementById("day").innerHTML += '<option value="' + i + '">' + i + '</option>';
                                    }
                                </script>
                            </div>
                        </div><!-- 생년월일 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" style="padding-top: 4px;">성별 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10 tl f14">
                                <label class="radio-inline mr15 lh12"><input type="radio" name="sex" value="male" checked />남자</label>
                                <label class="radio-inline lh12"><input type="radio" name="sex" value="female" />여자</label>
                            </div>
                        </div><!-- 성별 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="email">메일 주소 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs col-sm-4 w30" id="email1" name="email1" type="text" placeholder="메일 주소 입력" />
                                <span class="col-sm-4" style="width: 5%; margin-top: 12px;">@</span>
                                <input class="form-control singupInputs col-sm-4 w30 mr1p" id="email2" name="email2" type="text" />
                                <select class="info-email di col-sm-4 w33 h40p" onchange="emailChange(this.value)">
                                    <option value="" selected>직접 입력</option>
                                    <option value="naver.com">naver.com</option>
                                    <option value="gmail.com">gmail.com</option>
                                    <option value="hanmail.net">hanmail.net</option>
                                    <option value="nate.com">nate.com</option>
                                </select>
                            </div>
                        </div><!-- 이메일 end! -->
                        <script>
                            function emailChange(val) {
                                if(val == "") {
                                    document.getElementById("email2").readOnly = false;
                                    document.getElementById("email2").value = "";
                                    document.getElementById("email2").focus();
                                } else {
                                    document.getElementById("email2").value = val;
                                    document.getElementById("email2").readOnly = true;
                                }
                            }
                        </script>
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="phone">휴대폰 번호 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs di col-sm-4 w30" id="phone1" name="phone1" type="text" onkeyup="if(this.value > 999) { this.value = (this.value).substring(0, 3); }" />
                                <div class="fl f14 mt10 tc" style="width: 4.5%;">-</div>
                                <input class="form-control singupInputs di col-sm-4 w30" id="phone2" name="phone2" type="text" onkeyup="if(this.value > 9999) { this.value = (this.value).substring(0, 4); }" />
                                <div class="fl f14 mt10 tc" style="width: 4.5%;">-</div>
                                <input class="form-control singupInputs di col-sm-4 w30" id="phone3" name="phone3" type="text" onkeyup="if(this.value > 9999) { this.value = (this.value).substring(0, 4); }" />
                            </div>
                        </div><!-- 휴대폰번호 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" style="padding-top: 4px;">장애 여부 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10 tl f14">
                                <label class="radio-inline mr15 lh12"><input type="radio" name="obstacle" value="yes" />장애</label>
                                <label class="radio-inline lh12"><input type="radio" name="obstacle" value="no" checked />비장애</label>
                            </div>
                        </div><!-- 장애 여부 end! -->
                        <hr align="center" class="step3Hr2">
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="company">회사 / 점포명 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs" id="company" name="company" type="text" placeholder="회사 / 점포명을 입력해주세요." />
                            </div>
                        </div><!-- 회사/점포명 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="ceo">대표자 이름 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs" id="ceo" name="ceo" type="text" placeholder="대표자 이름을 입력해주세요." />
                            </div>
                        </div><!-- 대표자 이름 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10">사업자 등록 번호 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                            <input class="form-control singupInputs di col-sm-4 w30" id="number1" name="number1" type="text" />
                                <div class="fl f14 mt10 tc" style="width: 4.5%;">-</div>
                                <input class="form-control singupInputs di col-sm-4 w30" id="number2" name="number2" type="text" />
                                <div class="fl f14 mt10 tc" style="width: 4.5%;">-</div>
                                <input class="form-control singupInputs di col-sm-4 w31" id="number3" name="number3" type="text" />
                            </div>
                        </div><!-- 사업자등록번호 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10">업종 / 기업 형태 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <select id="types" name="types" class="di h40p mr1p" style="width: 49.2%;">
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
                                <select id="status" name="status" class="di h40p" style="width: 49.2%;">
                                    <option value="" selected>기업 형태 선택</option>
                                    <option value="소기업">소기업</option>
                                    <option value="중기업">중기업</option>
                                    <option value="대기업">대기업</option>
                                    <option value="벤쳐기업">벤쳐기업</option>
                                    <option value="외국계기업">외국계기업</option>
                                </select>
                            </div>
                        </div><!-- 업종 / 기업 형태 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="content">주요 사업 내용 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs" id="content" name="content" type="text" placeholder="주요 사업 내용을 입력해주세요." />
                            </div>
                        </div><!-- 주요사업내용 end! -->
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10">설립연도 <span class="c-red">*</span></label>
                            <div class="col-sm-10 signupCol10">
                                <select id="flotation" name="flotation" class="di h40p w100"></select>
                            </div>
                        </div><!-- 설립연도 end! -->
                        <script>
                            var date = new Date();
                            var year = date.getFullYear();
                            
                            document.getElementById("flotation").innerHTML = '<option value="" selected>설립연도 선택</option>';

                            for(var i=year; i>=1900; i--) {
                                document.getElementById("flotation").innerHTML += '<option value="' + i + '">' + i + '</option>';
                            }
                        </script>
                        <div class="form-group">
                            <label class="control-label col-sm-2 tl f14 mr10" for="reuid">추천인</label>
                            <div class="col-sm-10 signupCol10">
                                <input class="form-control singupInputs" id="reuid" name="reuid" type="text" placeholder="추천인을 입력해주세요." />
                            </div>
                        </div>
                        <hr align="center" class="step3Hr2">
                        <input type="submit" class="fff singupOkBtn noBorder" value="회원가입 완료" />
                    </form>
                </div><!-- form end -->
            </div>
        </div>
    </div>    
    <div class="clear"></div>
    <script>
        $("#id").keyup(function() {
            $(this).val($(this).val().replace(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣 | \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi, ''));
        });

        $("#name").keyup(function() {
            $(this).val($(this).val().replace(/[ 0-9 | \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi, ''));
        });

        $("#ceo").keyup(function() {
            $(this).val($(this).val().replace(/[ 0-9 | \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi, ''));
        });

        $("#email1").keyup(function() {
            $(this).val($(this).val().replace(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, ''));
        });

        $("#email2").keyup(function() {
            $(this).val($(this).val().replace(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, ''));
        });

        $("#number1").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#number2").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#number3").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#phone1").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#phone2").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        $("#phone3").keyup(function() {
            $(this).val($(this).val().replace(/[^0-9]*$/gi,''));
        });

        function idSearch() {
            var id = document.getElementById("id").value;

            if(id == "") {
                alert("아이디를 입력해주세요.");
                document.getElementById("id").focus();
            } else if(id.length < 4) {
                alert("아이디가 너무 짧습니다. (6자 이상)");
                document.getElementById("id").focus();
            } else {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '../ajax/idSearch.php',
                    data: { id: id },
                    success: function(data) {
                        alert(data.message);
                        document.getElementById("idCheck").value = data.check;

                        blankCheck('id', id);
                    }
                });
            }
        }

        function blankCheck(type, val) {
            var idCheck = document.getElementById("idCheck").value;
            var joinPwd = document.getElementById("pwd").value;
            var joinPwd2 = document.getElementById("pwd2").value;

            if(type == "id" && val == "") {
                document.getElementById("idMent").innerHTML = "* 아이디를 입력해주세요.";
            } else if(type == "id" && val.length < 6) {
                document.getElementById("idMent").innerHTML = "* 아이디가 너무 짦습니다.";
            } else if(type == "id" && idCheck == "" || type == "id" && idCheck == 1) {
                document.getElementById("idMent").innerHTML = "* 중복 확인 버튼을 눌러주세요.";
            } else {
                document.getElementById("idMent").innerHTML = "";
            }

            if(type == "pwd" && val == "") {
                document.getElementById("pwdMent").innerHTML = "* 비밀번호를 입력해주세요.";
            } else if(type == "pwd" && val.length < 6) {
                document.getElementById("pwdMent").innerHTML = "* 비밀번호가 너무 짧습니다.";
            } else if(type == "pwd" && val != joinPwd2) {
                document.getElementById("pwdMent").innerHTML = "* 비밀번호가 맞지 않습니다.";
            } else {
                document.getElementById("pwdMent").innerHTML = "";
            }

            if(type == "pwd2" && val == "") {
                document.getElementById("pwdMent2").innerHTML = "* 비밀번호 확인을 입력해주세요.";
            } else if(type == "pwd2" && joinPwd != val) {
                document.getElementById("pwdMent2").innerHTML = "* 비밀번호가 맞지 않습니다.";
            } else {
                document.getElementById("pwdMent2").innerHTML = "";
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

        function formCheck() {
            var id = document.getElementById("id").value;
            var idCheck = document.getElementById("idCheck").value;
            var pwd = document.getElementById("pwd").value;
            var pwd2 = document.getElementById("pwd2").value;
            var name = document.getElementById("name").value;
            var ceo = document.getElementById("ceo").value;
            var year = $("#year option:selected").val();
            var month = $("#month option:selected").val();
            var day = $("#day option:selected").val();
            var email1 = document.getElementById("email1").value;
            var email2 = document.getElementById("email2").value;
            var phone1 = document.getElementById("phone1").value;
            var phone2 = document.getElementById("phone2").value;
            var phone3 = document.getElementById("phone3").value;
            var company = document.getElementById("company").value;
            var number1 = document.getElementById("number1").value;
            var number2 = document.getElementById("number2").value;
            var number3 = document.getElementById("number3").value;
            var number = number1 + number2 + number3;
            var numberCheck = checkBizID(number);
            var types = $("#types option:selected").val();
            var status = $("#status option:selected").val();
            var content = document.getElementById("content").value;
            var flotation = $("#flotation option:selected").val();

            if(id == "") {
                alert("아이디를 입력해주세요.");
                document.getElementById("id").focus();
                return false;
            } else if(id.length < 6) {
                alert("아이디가 너무 짧습니다. (6자 이상)");
                document.getElementById("id").focus();
                return false;
            } else if(idCheck == "" || idCheck == 1) {
                alert("아이디 중복 확인을 눌러주세요.");
                return false;
            } else if(pwd == "") {
                alert("비밀번호를 입력해주세요.");
                document.getElementById("pwd").focus();
                return false;
            } else if(pwd2 == "") {
                alert("비밀번호를 재입력해주세요.");
                document.getElementById("pwd2").focus();
                return false;
            } else if(pwd.length < 6) {
                alert("비밀번호가 너무 짧습니다. (6자 이상)");
                document.getElementById("pwd").focus();
                return false;
            } else if(pwd != pwd2) {
                alert("비밀번호가 맞지 않습니다.");
                return false;
            } else if(name == "") {
                alert("이름을 입력해주세요.");
                document.getElementById("name").focus();
                return false;
            } else if(year == "" || month == "" || day == "") {
                alert("생년월일을 선택해주세요.");
                return false;
            } else if(email1 == "") {
                alert("메일 주소를 입력해주세요.");
                document.getElementById("email1").focus();
                return false;
            } else if(email2 == "") {
                alert("메일 주소를 입력해주세요.");
                document.getElementById("email2").focus();
                return false;
            } else if(phone1 == "") {
                alert("휴대폰 번호를 입력해주세요.");
                document.getElementById("phone1").focus();
                return false;
            } else if(phone2 == "") {
                alert("휴대폰 번호를 입력해주세요.");
                document.getElementById("phone2").focus();
                return false;
            } else if(phone3 == "") {
                alert("휴대폰 번호를 입력해주세요.");
                document.getElementById("phone3").focus();
                return false;
            } else if(phone1.length < 3) {
                alert("휴대폰 번호를 똑바로 입력해주세요.");
                document.getElementById("phone1").focus();
                return false;
            } else if(phone2.length < 3) {          //3자리 번호도 있음
                alert("휴대폰 번호를 똑바로 입력해주세요.");
                document.getElementById("phone2").focus();
                return false;
            } else if(phone3.length < 4) {
                alert("휴대폰 번호를 똑바로 입력해주세요.");
                document.getElementById("phone3").focus();
                return false;
            } else if(company == "") {
                alert("회사 / 점포명을 입력해주세요.");
                document.getElementById("company").focus();
                return false;
            } else if(ceo == "") {
                alert("대표자 이름을 입력해주세요.");
                document.getElementById("ceo").focus();
                return false;
            } else if(ceo.length < 2) {
                alert("대표자 이름을 똑바로 입력해주세요.");
                document.getElementById("ceo").focus();
                return false;
            } else if(!numberCheck) {
                alert("사업자 등록 번호를 똑바로 입력해주세요.");
                return false;
            } else if(number1 == "") {
                alert("사업자 등록 번호를 입력해주세요.");
                document.getElementById("number1").focus();
                return false;
            } else if(number2 == "") {
                alert("사업자 등록 번호를 입력해주세요.");
                document.getElementById("number2").focus();
                return false;
            } else if(number3 == "") {
                alert("사업자 등록 번호를 입력해주세요.");
                document.getElementById("number3").focus();
                return false;
            } else if(types == "") {
                alert("업종을 선택해주세요.");
                document.getElementById("types").focus();
                return false;
            } else if(status == "") {
                alert("기업 형태를 선택해주세요.");
                document.getElementById("status").focus();
                return false;
            } else if(content == "") {
                alert("주요 사업 내용을 입력해주세요.");
                document.getElementById("content").focus();
                return false;
            } else if(flotation == "") {
                alert("설립연도를 선택해주세요.");
                document.getElementById("flotation").focus();
                return false;
            }

            return true;
        }
    </script>
    <!-- footer -->
    <div class="footer">
        <div class="wdfull border-top pt5 mb25">
            <div class="signupWrap oh">
                 <div class="tc">  
                    <ul class="pl10 noMargin footerNav">
                        <li class="di footer-li cp" alt="회사 소개"><a href="http://il-bang.com/pc_renewal/policy.php?tab=1">이용 약관</a></li>
                        <li class="di footer-li cp" alt="개인정보처리방침"><a href="http://il-bang.com/pc_renewal/policy.php?tab=2">개인 정보 취급 방침</a></li>
                        <li class="di footer-li cp" alt="위치기반서비스이용 약관"><a href="http://il-bang.com/pc_renewal/policy.php?tab=3">위치 기반 서비스 이용 약꽌</a></li>
                        <li class="di pl15 cp" alt="직업정보제공사업자준수사"><a href="http://il-bang.com/pc_renewal/policy.php?tab=4">직업 정보 제공 사업자 준수사항</a></li>
                    </ul>
                </div><div class="clear"></div>
                <p class="tc mt20 8copy">Copyright&copy; (주)일방 All Rights Reserved.</p>
            </div>
        </div>
    </div>
<script src="http://il-bang.com/pc_renewal/js/bootstrap.js"></script>  
</body>
</html>