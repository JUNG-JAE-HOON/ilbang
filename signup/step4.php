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
    <link rel="stylesheet" href="./../css/hwajin.css">
    <link rel="stylesheet" href="./../css/yeojin.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>   
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
                                    <a href="http://il-bang.com/pc_renewal/index.php"><img src="./../images/signUp/logo_03.png" alt="logo" /></a>
                                </div>
                            </li>
                            <li class="c-red pt40 pb10 f16">회원가입</li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="pt40 pb10"><a href="../index.php" class="signNav">Home</a></li>
                            <?php if($uid == "") { ?>
                            <li class="pt40 pb10"><a href="#" class="signNav" data-toggle="modal" data-target="#loginModal">로그인</a></li>
                            <?php } else { ?>
                            <li class="pt40 pb10"><a href="../log/logout.php" class="signNav">로그아웃</a></li>
                            <?php } ?>
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
                        <a href="#" class="underline"><span>아이디</span></a> 또는 
                        <a href="#" class="underline"><span>비밀번호</span></a>를 잊으셨나요?
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            validCheck();
        });

        function enterKey(event, type) {
            if(event.keyCode == 13) {
                modalLogin();
            }
        }

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
                    url: 'log/modalLogin.php',
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

        function valid_btn() {
            var winHeight = document.body.clientHeight;
            var winWidth = document.body.clientWidth;
            var winX = window.screenLeft;
            var winY = window.scrrenTop;
            var popX = winX + (winWidth - 408)/2;
            var popY = winY + (winHeight - 650)/2;
            window.open("../in/in.php?id=<?php echo $uid; ?>", "valid", "width=408, height=650, top=" + popY + ", left=" + popX);
        }

        function validCheck() {
            var uid = "<?php echo $_GET['id']; ?>";

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/member/getMyInfo.php',
                data: { uid: uid },
                success: function(data) {
                    if(data.memberInfo.valid == 'no') {
                        document.getElementById("validBtn").innerHTML
                        = '<span class="bold">본인 인증</span>을 원하시면 아래의 버튼을 눌러주세요.'
                        + '<a href="javascript:valid_btn()">'
                        + '<div class="active-btn margin-auto lh1 mt10 f13" style="width: 120px; padding: 8px 0; border-radius: 2px;">본인 인증하기</div>'
                        + '</a>';
                    } else {
                        document.getElementById("validBtn").innerHTML = '본인 인증이 <span class="fc bold">완료</span>되었습니다.<br />감사합니다.';
                    }
                }
            });
        }
    </script>
    <div class="signupWrap center">
        <div class="mb50">
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
                    <div class="signupC">
                        <p class="f14 mb0">step<strong class="f20">3</strong></p>
                        <p class="bold">정보 입력</p>
                    </div>
                </div>
                <div class="tc di mr15">
                    <img src="./../images/next.png" alt="next" class="pb20"/>
                </div>
                <div class="tc di mr15">
                    <div class="signupSelectC">
                        <p class="f14 mb0">step<strong class="f20">4</strong></p>
                        <p class="bold">가입 완료</p>
                    </div>
                </div>
            </div><div class="clear"></div>
            <!-- step circle end! -->
            <div class="signupFormWrap">
                <div>
                    <img src="./../images/signUp/signUpOk_03.png" alt="일방 회원가입을 축하드립니다."/>
                </div>
                <div class="tc border-grey">
                    <div class="pt35 pb35 bg-fafafa f14">
                        회원님의 아이디는 <span class="bold"><?php echo $_GET["id"]; ?></span> 입니다.<br />
                        <p class="bold">(가입일 : <?php echo $_SESSION["wdate"]; ?>)</p><br />
                        <div id="validBtn"></div>
                    </div>
                </div>
                <div class="mt10">
                    <div class="di step4iconBox mr5">
                        <a href="../index.php">
                            <img src="./../images/signUp/signUpOk_07.png" alt="일방 홈으로가기"/>
                        </a>
                    </div>
                    <div class="di step4iconBox mr5">
                        <a href="../ad/adMoney.php">
                            <img src="./../images/signUp/signUpOk_09.png" alt="일방 AD머니로 가기"/>
                        </a>
                    </div>
                    <div class="di step4iconBox">
                        <a href="../cs/cs.php?tab=2">
                            <img src="./../images/signUp/signUpOk_11.png" alt="고객센터로 가기"/>
                        </a>
                    </div>
                </div>
            </div><!-- boxWrap end! -->
        </div>
    </div>
    <!-- 상단 공통 end! -->
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