<?php
    include_once "../include/session.php";

    $tab = $_GET["tab"];
?>
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>   
    <script>
        var id = "<?php echo $uid; ?>";

        if(id != "") {
            alert("로그아웃 후 이용해주세요.");
            history.back();
        }

        function findMember(val) {
            var id, name, phone1, phone2, phone3 = "";

            if(val == 0) {
                name = document.getElementById("id_name").value;
                phone1 = document.getElementById("id_phone1").value;
                phone2 = document.getElementById("id_phone2").value;
                phone3 = document.getElementById("id_phone3").value;
            } else {
                id = document.getElementById("id").value;
                name = document.getElementById("pwd_name").value;
                phone1 = document.getElementById("pwd_phone1").value;
                phone2 = document.getElementById("pwd_phone2").value;
                phone3 = document.getElementById("pwd_phone3").value;
            }
            
            var phone = phone1 + "-" + phone2 + "-" + phone3;

            if(val == 1 && id == "") {
                alert("아이디를 입력해주세요.");
                document.getElementById("id").focus();
            } else if(name == "") {
                alert("이름을 입력해주세요.");
            } else if(phone1 == "") {
                alert("휴대폰 번호를 입력해주세요.");
            } else if(phone2 == "") {
                alert("휴대폰 번호를 입력해주세요.");
            } else if(phone3 == "") {
                alert("휴대폰 번호를 입력해주세요.");
            } else {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '../ajax/member/findMember.php',
                    data: { id: id, name: name, phone: phone, val: val },
                    success: function(data) {
                        if(val == 0) {
                            if(data.findInfo == null) {
                                alert("회원 정보가 없습니다.");
                            } else {
                                document.getElementById("findInfoView").innerHTML
                                = '<div class="tc">'
                                + '<div id="idList" class="f14"></div>'
                                + '</div>';

                                document.getElementById("findIdBtn").innerHTML
                                = '<a href="pwidFind.php?tab=2" class="btn-tran di padding-vertical pwidBtn mr10">비밀번호 찾기</a>'
                                + '<a href="../index.php" class="btn-tran di padding-vertical fff pwidBtn2">메인으로</a>';

                                document.getElementById("infoNum").innerHTML
                                = '<span class="c999">01.정보 입력 > </span>'
                                + '<span class="c666 bold">02.아이디 찾기 완료</span>';

                                document.getElementById("idList").innerHTML = '<div class="mb5">회원님의 일방 계정 목록입니다.</div>';

                                for(var i=0; i<data.findInfo.length; i++) {
                                    document.getElementById("idList").innerHTML
                                    += '<div class="bold">' + data.findInfo[i].id + ' <span class="f12">(가입일 : ' + data.findInfo[i].date + ')</span></div>';
                                }
                            }
                        } else {
                            if(data.findPwd == null || data.findPwd == 0) {
                                alert("회원 정보가 없습니다.");
                            } else {
                                document.getElementById("findInfoView2").innerHTML
                                = '<div class="tc">'
                                + '<div id="pwdChange" class="f14"></div>'
                                + '</div>';

                                document.getElementById("infoNum2").innerHTML
                                = '<span class="c999">01.정보 입력 > </span>'
                                + '<span class="c666 bold">02. 비밀번호 변경</span>'
                                + '<span class="c999"> > 03.비밀번호 찾기 완료</span>';

                                document.getElementById("pwdChange").innerHTML
                                = '<div class="f14 mb10">비밀번호를 변경하실 아이디는 <span class="bold">' + id + '</span> 입니다.</div>'
                                + '<div class="row mb5">'
                                + '<div class="di col-sm-3 tl mr10 pwidCol2" for="changePwd1">비밀번호 입력 <span class="c-red">*</span></div>'
                                + '<div class="di col-sm-9 pwidCol9 pt5 pb5">'
                                + '<input type="password" class="form-control pwidInputs2" id="changePwd1" placeholder="비밀번호 입력" />'
                                + '</div>'
                                + '</div>'
                                + '<div class="row mb5">'
                                + '<div class="di col-sm-3 tl mr10 pwidCol2" for="changePwd2">비밀번호 재입력 <span class="c-red">*</span></div>'
                                + '<div class="di col-sm-9 pwidCol9 pt5 pb5">'
                                + '<input type="password" class="form-control pwidInputs2" id="changePwd2" placeholder="비밀번호 재입력" />'
                                + '</div>'
                                + '</div>';

                                document.getElementById("findPwdBtn").innerHTML
                                = '<a href="" id="pwdChangeBtn" class="btn-tran di padding-vertical fff pwidBtn2">비밀번호 변경하기</a>';

                                document.getElementById("pwdChangeBtn").href = "javascript:changePwd('" + id + "')";
                            }
                        }
                    }
                });
            }
        }

        function changePwd(id) {
            var pwd1 = document.getElementById("changePwd1").value;
            var pwd2 = document.getElementById("changePwd2").value;

            if(pwd1 == "") {
                alert("비밀번호를 입력해주세요.");
                document.getElementById("changePwd1").focus();
            } else if(pwd2 == "") {
                alert("비밀번호를 입력해주세요.");
                document.getElementById("changePwd2").focus();
            } else if(pwd1.length < 6) {
                alert("비밀번호가 너무 짧습니다. (6자 이상)");
                document.getElementById("changePwd1").focus();
            } else if(pwd1 != pwd2) {
                alert("비밀번호가 맞지 않습니다.");
            } else {
                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: '../ajax/member/changePwd.php',
                    data: { id: id, pwd: pwd1 },
                    success: function(data) {
                        alert(data.message);

                        if(data.check == 1) {
                            document.getElementById("findInfoView2").innerHTML
                            = '<div class="tc">'
                            + '<div id="pwdChange" class="f14"></div>'
                            + '</div>';

                            document.getElementById("findPwdBtn").innerHTML = '<a href="../index.php" class="btn-tran di padding-vertical fff pwidBtn2">메인으로</a>';
                            document.getElementById("infoNum2").innerHTML
                            = '<span class="c999">01.정보 입력 > </span>'
                            + '<span class="c999">02. 비밀번호 변경 > </span>'
                            + '<span class="c666 bold">03.비밀번호 찾기 완료</span>';

                            document.getElementById("pwdChange").innerHTML
                            = '<div class="tc">'
                            + '<div class="f18 bold mb5">비밀번호가 변경되었습니다.</div>'
                            + '<div class="f14">감사합니다.</div>'
                            + '</div>';
                        }
                    }
                });
            }
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
                                    <a href="http://il-bang.com/pc_renewal/index.php"><img src="./../images/signUp/logo_03.png" alt="logo"/></a>
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
    <!-- nav end! -->
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
    <div class="signupWrap center signOutWrap mb30 mt15 tc">
        <h3 class="di c666 f25 mr10 mb15">일방 <b>회원 정보 찾기</b></h3>
        <h4 class="mb40 f12">회원님의 아이디 또는 비밀번호를 분실하셨을 경우 아래의 아이디/비밀번호 찾기를 진행해 주십시오.</h4>
    </div>
    <div class="pwidTabWrap">
        <ul class="nav nav-tabs mt10" role="tablist" id="myTab">
            <?php if($tab == 1) { ?>
            <li role="presentation" class="noPadding pwidTabLi text-center active"><a href="#pwidTap1" aria-controls="pwidTap1" role="tab" data-toggle="tab">아이디 찾기</a></li>
            <li class="noPadding pwidTabLi text-center" role="presentation"><a href="#pwidTap2" aria-controls="pwidTap2" role="tab" data-toggle="tab">비밀번호 찾기</a></li>
            <?php } else { ?>
            <li role="presentation" class="noPadding pwidTabLi text-center"><a href="#pwidTap1" aria-controls="pwidTap1" role="tab" data-toggle="tab">아이디 찾기</a></li>
            <li class="noPadding pwidTabLi text-center active" role="presentation"><a href="#pwidTap2" aria-controls="pwidTap2" role="tab" data-toggle="tab">비밀번호 찾기</a></li>
            <?php } ?>
        </ul>
        <div class="tab-content container">
            <!-- 첫번째 탭 내용 -->
            <?php if($tab == 1) { ?>
            <div role="tabpanel" class="tab-pane active mt40" id="pwidTap1">
            <?php } else { ?>
            <div role="tabpanel" class="tab-pane mt40" id="pwidTap1">
            <?php } ?>
                <!-- 아이디 찾기 01 -->
                <div class="signupWrap center signOutWrap">
                    <p class="bold f16 fl">아이디 찾기</p>
                    <p class="fr" id="infoNum">
                        <span class="c666 bold">01.정보 입력</span>
                        <span class="c999"> > 02.아이디 찾기 완료</span>
                    </p>
                    <div class="clear"></div>
                    <div class="form-horizontal">
                        <div class="pwidFormWrap" id="findInfoView">
                            <div class="row mb10">
                                <div class="di col-sm-3 tl mr10 pwidCol2" for="name">이름 입력 <span class="c-red">*</span></div>
                                <div class="di col-sm-9 pwidCol9 pt5 pb5">
                                    <input type="text" class="form-control pwidInputs2" id="id_name" name="name" placeholder="이름을 입력해주세요." />
                                </div>
                            </div><!-- 이름 end! -->
                            <div class="row">
                                <div class="di col-sm-3 tl f14 mr10 pwidCol2">휴대폰 번호 입력 <span class="c-red">*</span></div>
                                <div class="di col-sm-9 pwidW pt5 pb5">                              
                                    <input class="form-control di tc pwidInputs" id="id_phone1" name="phone1" type="text" placeholder="010" />-
                                    <input class="form-control di tc pwidInputs" id="id_phone2" name="phone2" type="text" />-
                                    <input class="form-control di tc pwidInputs" id="id_phone3" name="phone3" type="text" />
                                </div> 
                            </div><!-- 전화번호 end! -->                                             
                        </div>
                        <p class="pl20 pt20 pb20 bold tc border-bottom c999">
                            <span class="c-red">*</span> 이용시 불편한 사항이나 궁금한 사항이 있으시면 <a href="../cs/cs.php" class="underline">고객센터</a>를 이용해 주시기 바랍니다.
                        </p>
                        <div class="oh tc w100 pwidBottom mt30 mb70" id="findIdBtn">
                            <a href="../index.php" class="btn-tran di padding-vertical pwidBtn mr5">메인으로</a>
                            <a href="javascript:findMember(0)" class="btn-tran di padding-vertical fff pwidBtn2">다음</a>
                        </div>
                    </div>
                </div><!-- 아이디 01 end! -->                
            </div>
            <!-- 두번째 탭 내용 -->
            <?php if($tab == 2) { ?>
            <div role="tabpanel" class="tab-pane active mt40" id="pwidTap2">
            <?php } else { ?>
            <div role="tabpanel" class="tab-pane mt40" id="pwidTap2">
            <?php } ?>
                <!-- 비밀번호찾기 01 -->
                <div class="signupWrap center signOutWrap">
                    <p class="bold f16 fl">비밀번호 찾기</p>
                    <p class="fr" id="infoNum2">
                        <span class="c666 bold">01.정보입력</span>
                        <span class="c999"> > 02.비밀번호 변경</span>
                        <span class="c999"> > 03.비밀번호 찾기 완료</span>
                    </p>
                    <div class="clear"></div>
                    <div class="form-horizontal">
                        <div class="pwidFormWrap" id="findInfoView2">
                            <div class="row mb10">
                                <div class="di col-sm-3 tl mr10 pwidCol2" for="id">아이디 입력 <span class="c-red">*</span></div>
                                <div class="di col-sm-9 pwidCol9 pt5 pb5">
                                    <input class="form-control pwidInputs2" id="id" type="text" placeholder="아이디를 입력해주세요." />
                                </div>
                            </div><!-- 이름 end! -->
                            <div class="row mb10">
                                <div class="di col-sm-3 tl mr10 pwidCol2" for="name">이름 입력 <span class="c-red">*</span></div>
                                <div class="di col-sm-9 pwidCol9 pt5 pb5">
                                    <input class="form-control pwidInputs2" id="pwd_name" name="name" type="text" placeholder="이름을 입력해주세요." />
                                </div>
                            </div><!-- 아이디 end! -->
                            <div class="row">
                                <div class="di col-sm-3 tl f14 mr10 pwidCol2">휴대폰 번호 입력 <span class="c-red">*</span></div>
                                <div class="di col-sm-9 pwidW pt5 pb5">                              
                                    <input class="form-control di tc pwidInputs" id="pwd_phone1" name="phone1" type="text" placeholder="010" />-
                                    <input class="form-control di tc pwidInputs" id="pwd_phone2" name="phone2" type="text" />-
                                    <input class="form-control di tc pwidInputs" id="pwd_phone3" name="phone3" type="text" />
                                </div>
                            </div><!-- 휴대폰번호 end! -->                                             
                        </div>
                        <p class="pl20 pt20 pb20 bold tc border-bottom c999">
                            <span class="c-red">*</span> 이용시 불편한 사항이나 궁금한 사항이 있으시면 <a href="../cs/cs.php" class="underline">고객센터</a>를 이용해 주시기 바랍니다.
                        </p>
                        <div class="oh tc w100 pwidBottom mt30 mb70" id="findPwdBtn">
                            <a href="../index.php" class="btn-tran di padding-vertical pwidBtn">메인으로</a>
                            <a href="javascript:findMember(1)" class="btn-tran di padding-vertical fff pwidBtn2">다음</a>
                        </div>
                    </div>
                </div><!-- 비밀번호찾기 01 end! -->
            </div>
        </div>
    </div>        
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