<?php include_once "../include/session.php"; ?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no” />
    <title>PC버전 리뉴얼</title>
    <link rel="stylesheet" href="./../css/bootstrap.css?ver=1.0.7">
    <link rel="stylesheet" href="./../css/default.css?ver=1.0.7">
    <link rel="stylesheet" href="./../css/hwajin.css?ver=1.0.1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script>
        var id = "<?php echo $uid; ?>";

        if(id != "") {
            alert("로그아웃 후 이용해주세요.");
            history.back();
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
    <div class="signupWrap center">
        <div>
            <div class="mt50 mb50 tc">
                <div class="tc di mr15">
                    <div class="signupSelectC">
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
                    <div class="signupC">
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
            <!-- step circle end! -->
            <div>
                <p class="tc f20 c555">일당제 구인구직 NO.1 일방 회원가입</p>
                <div class="tc f32 c555">일당제 구인구직 <strong>일방</strong>에 오신것을 <strong>환영</strong>합니다!</div><hr class="signupHr">
            </div>
            <div class="mt40 mb70 tc">
                <div class="tc di signupBox mr10">
                    <div class="mb20"><img src="./../images/signup-general.png" alt="개인회원가입"></div>
                    <p class="c777 f13 mb2">일자리를 찾으세요?</p>
                    <p class="c555 f18 bold mb20">개인회원 가입</p>
                    <a href="step2.php?join=general" class="fff generSignBtn">가입하기</a>
                </div>
                <div class="tc di signupBox">
                    <div class="mb20"><img src="./../images/signup-comp.png" alt="기업회원가입"></div>
                    <p class="c777 f13 mb2">직원을 찾으세요?</p>
                    <p class="c555 f18 bold mb20">기업회원 가입</p>
                    <a href="step2.php?join=company" class="fff compSignBtn">가입하기</a>
                </div>
            </div>
            <!-- <div class="di mt10 mb70 pl21 wdfull">
               <div class="fl tl joinstep1Sns">
                    <div class="mb5">
                        <div class="fl signuploginBtn">
                            <a href="#" class="cp">
                                <span class="pr5 border-right">
                                    <img src="./../images/signUp/icon_09.png" alt="페이스북 로그인">
                                </span>
                                <span class="pl5">페이스북 로그인</span>
                            </a>
                        </div>
                        <div class="fl signuploginBtn">
                            <a href="#" class="cp">
                                <span class="pr5 border-right">
                                    <img src="./../images/signUp/icon_12.png" alt="구글 로그인">
                                </span>
                                <span class="pl5">구글 로그인</span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <div class="fl signuploginBtn">
                            <a href="#" class="cp">
                                <span class="pr5 border-right">
                                    <img src="./../images/signUp/icon_19.png" alt="네이버 로그인" style="padding:6px 4px;">
                                </span>
                                <span class="pl5">네이버 로그인</span>
                            </a>
                        </div>
                        <div class="fl signuploginBtn">
                            <a href="#" class="cp">
                                <span class="pr5 border-right">
                                    <img src="./../images/signUp/icon_16.png" alt="카카오 로그인">
                                </span>
                                <span class="pl5">카카오 로그인</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="fl ml15 c777">※ 구인 하시려는 개인 사업자, 사업체 직원 포함</div>
            </div> --><div class="clear"></div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
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