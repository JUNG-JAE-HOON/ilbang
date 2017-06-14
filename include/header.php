<?php include_once "session.php"; ?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width,user-scalable=no, initial-scale=0.5"> -->
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no” />
    <title>일방 - 구인/구직(일당제) 서비스</title>
    <meta name="description" content="아르바이트,알바,일일알바,주말알바,단기알바,하루알바,AD머니,채용정보,인재정보" />
    <meta name="keywords" content="일빵,하루일자리,일일일자리,일일일자리일방,알바,아르바이트,단기알바,주말알바,일일알바,하루알바,꿀알바,여성알바">
    <link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/bootstrap.css?ver=1.1.1">
    <link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/main.css">
    <link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/hwajin.css?ver=1.0.7">
    <link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/slick.css">
    <link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/slick-theme.css">
    <link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/yeojin.css"> 
    <link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/jquery.rateyo.min.css"> 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 
    <link rel="stylesheet" href="http://il-bang.com/pc_renewal/css/mdp.css?ver=1.0.2">
     <script src="http://il-bang.com/pc_renewal/js/prefixfree.min.js"></script> 
    <script src="http://apis.daum.net/maps/maps3.js?apikey=721aff1257b519a5cffe6cc6cbed8aa6&libraries=services"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://il-bang.com/pc_renewal/js/slick.js"></script>
    <script type="text/javascript" src="http://il-bang.com/pc_renewal/js/jquery.rateyo.min.js"></script>
    <script>
        // iframe resize
        // function autoResize(i)
        // {
        //     var iframeHeight=
        //     (i).contentWindow.document.body.scrollHeight;
        //     (i).height=iframeHeight+20;

        //     document.getElementById('targetFrame').contentWindow.targetFunction();
        //     // this option does not work in most of latest versions of chrome and Firefox
        //     window.frames[0].frameElement.contentWindow.targetFunction();
        //     // if (document.location.protocol == 'https:') {
        //     //     document.location.href = document.location.href.replace('https:', 'http:');
        //     // }

        // }
        

        $(document).ready(function() {
            indexGuinCheck(0);

            $("#ceo").keyup(function() {
                $(this).val($(this).val().replace(/[ 0-9 | \{\}\[\]\/?.,;:|\)*~`!^\-_+┼<>@\#$%&\'\"\\\(\=]/gi, ''));
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
        });

        function addFavorite() {
            var url = window.location.href;
            var title = document.title;
            var browser = navigator.userAgent.toLowerCase();

            if(window.sidebar && window.sidebar.addPanel) {
                window.sidebar.addPanel(title, url, "");
            } else if(window.external) {
                if(browser.indexOf('chrome') == -1) {
                    window.external.AddFavorite(url, title);
                } else {
                    alert("CTRL + D 또는 Command + D를 눌러 즐겨찾기에 추가해주세요.");
                }
            } else if(window.opera && window.print) {
                return true;
            } else if(browser.indexOf('konqueror') != -1) {
                alert("CTRL + B를 눌러 즐겨찾기에 추가해주세요.");
            } else if(browser.indexOf('webkit') != -1) {
                alert("CTRL + B 또는 Command + B를 눌러 즐겨찾기에 추가해주세요.");
            } else {
                alert("사용하고 계시는 브라우저는 이 버튼으로 즐겨찾기를 추가하실 수 없습니다.\n수동으로 링크를 추가해주세요.");
            }
        }

        function indexGuinCheck(val) {
            var id = "<?php echo $uid; ?>";

            if(id == "") {
                if(val == 1) {
                    alert("로그인 후 이용해주세요.");
                }
            } else {
                if(val == 0) {
                    $.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: 'http://il-bang.com/pc_renewal/ajax/guin/guinCheck.php',
                        success: function(data) {
                            if(data == 0) {
                                document.getElementById("index_guinCheck").innerHTML
                                = '<a href="#" data-toggle="modal" data-target="#guinTabModal">'
                                + '<img src="http://il-bang.com/pc_renewal/images/person.png" alt="구인 신청 아이콘" class="navIcon" />구인 신청'
                                + '</a>';
                            }
                        }
                    });
                } else {
                    applicationCheck(1);
                }
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

        function addCompData() {
            var company = document.getElementById("company").value;
            var ceo = document.getElementById("ceo").value;
            var number1 = document.getElementById("number1").value;
            var number2 = document.getElementById("number2").value;
            var number3 = document.getElementById("number3").value;
            var sumNumber = number1 + number2 + number3;
            var numberCheck = checkBizID(sumNumber);
            var types = $("#types option:selected").val();
            var status = $("#status option:selected").val();
            var content = document.getElementById("content").value;
            var flotation = $("#flotation option:selected").val();

            if(company == "") {
                alert("회사 / 점포명을 입력해주세요.");
                document.getElementById("company").focus();
            } else if(ceo == "") {
                alert("대표자 이름을 입력해주세요.");
                document.getElementById("ceo").focus();
            } else if(number1 == "") {
                alert("사업자 등록 번호를 입력해주세요.");
                document.getElementById("number1").focus();
            } else if(number2 == "") {
                alert("사업자 등록 번호를 입력해주세요.");
                document.getElementById("number2").focus();
            } else if(number3 == "") {
                alert("사업자 등록 번호를 입력해주세요.");
                document.getElementById("number3").focus();
            } else if(!numberCheck) {
                alert("사업자 등록 번호를 똑바로 입력해주세요.");
            } else if(types == "" || status == "") {
                alert("업종 / 기업 형태를 선택해주세요.");
            } else if(content == "") {
                alert("주요 사업 내용을 입력해주세요.");
                document.getElementById("content").focus();
            } else if(flotation == "") {
                alert("설립연도를 선택해주세요.");
                document.getElementById("flotation").focus();
            } else {
                var number = number1 + "-" + number2 + "-" + number3;

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: 'http://il-bang.com/pc_renewal/ajax/guin/addCompData.php',
                    data: { company: company, ceo: ceo, number: number, types: types, status: status, content: content, flotation: flotation },
                    success: function(data) {
                        alert(data.message);

                        if(data.check == 1) {
                            document.location.href = data.url;
                        }
                    }
                });
            }
        }

        function applicationCheck(val) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'http://il-bang.com/pc_renewal/ajax/applicationCheck.php',
                data: { val: val },
                success: function(data) {
                    if(data.count == 0) {
                        alert(data.message);
                    } else {
                        document.location.href = data.url;
                    }
                }
            });
        }

        function enterKey(event, type) {
            if(event.keyCode == 13) {
                if(type == "login") {
                    modalLogin();
                } else if(type == "search") {
                    searchKeyword();
                }
            }
        }

        function adminOpen() {
            window.open("http://il-bang.com/pc_renewal/admin/index.php", "_blank", "width=1200px, height=" + screen.height);
        }
    </script>
</head>
<body>
    <div class="container center full">
        <div class="pg_rp">
            <nav class="navbar-default">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="bd_left1 bd_right">
                                <a href="javascript:addFavorite()" title="즐겨찾기 추가">즐겨찾기 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="bd_right"><a href="http://il-bang.com/pc_renewal/cs/cs.php?tab=1">FAQ</a></li>
                            <li class="bd_right"><a href="http://il-bang.com/pc_renewal/cs/cs.php?tab=2">Q&A</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <?php if($uid != "" && $kind == "jijeom") { ?>
                            <li class="bd_left1">
                                <a href="javascript:adminOpen()">관리자 페이지</a>
                            </li>
                            <?php } ?>
                            <li class="bd_left1 bd_right">
                                <?php if($uid == "") { ?>
                                <a href="#" data-toggle="modal" data-target="#loginModal">로그인</a>
                                <?php
                                    } else {
                                        if($kind == "general") {
                                ?>
                                <a href="http://il-bang.com/pc_renewal/my-page/myInfo-general.php">
                                <?php } else { ?>
                                <a href="http://il-bang.com/pc_renewal/my-page/myInfo-comp.php">
                                <?php } ?>
                                    <img src="http://il-bang.com/pc_renewal/images/cog.png" alt="마이페이지" class="navTopIcon"/>마이 페이지
                                </a>
                                <?php } ?>
                            </li>
                            <li class="bd_right">
                                <?php if($uid == "") { ?>
                                <a href="http://il-bang.com/pc_renewal/signup/step1.php">회원가입</a>
                                <?php } else { ?>
                                <a href="http://il-bang.com/pc_renewal/log/logout.php">로그아웃</a>
                                <?php } ?>
                            </li>
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
                    <div class="mb5"><input type="text" class="form-control" id="user_id" name="user_id" placeholder="아이디 입력" onkeypress="enterKey(event, 'login')" /></div>
                    <div class="mb10"><input type="password" class="form-control" id="user_pwd" name="user_pwd" placeholder="비밀번호 입력" onkeypress="enterKey(event, 'login')" /></div>
                    <a href="javascript:modalLogin()" class="f16">
                        <div class="margin-auto active-btn padding-vertical mb20">로그인</div>
                    </a>
                    <div class="f12">혹시
                        <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=1" class="underline"><span>아이디</span></a> 또는 
                        <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=2" class="underline"><span>비밀번호</span></a>를 잊으셨나요?
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function modalLogin() {
            var user_id = document.getElementById("user_id").value;
            var user_pwd = document.getElementById("user_pwd").value;
            var url = "<?php echo $url; ?>";

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
                    url: 'http://il-bang.com/pc_renewal/log/modalLogin.php',
                    data: { user_id: user_id, user_pwd: user_pwd, url: url },
                    success: function(data) {
                        if(data.login.val) {
                            document.location.href = data.login.url;
                        } else {
                            alert(data.login.message);
                        }
                    }
                });
            }
        }


        function searchKeyword() {
            $("#headerSearchForm").attr("action", "http://il-bang.com/pc_renewal/search/guingujik-info-search.php");
            
            document.getElementById("headerSearchForm").submit();
        }
    </script>
    <!-- logo -->
    <div class="container center">
        <div class="row">
            <div class="col-sm-3 top_logo">
                    <!-- 이 주소는 절대경로로 하기 -->
                <a href="http://il-bang.com/pc_renewal/index.php">
                    <img src="http://il-bang.com/pc_renewal/images/top_left_logo.png" onerror="this.src='http://il-bang.com/pc_renewal/images/144x38.png'"  alt="로고"/>
                </a>
            </div>
            <form class="col-sm-5 top_search" id="headerSearchForm" >
                <div class="input-group">
                    <input type="text" class="form-control bc br11 pl20 ha padding-vertical" name="searchKeyword" id="searchKeyword" placeholder="검색을 입력해주세요. ex) 디자이너" onkeypress="enterKey(event, 'search')" />
                    <span class="input-group-addon bg bc br11 pdtb0 padding-horizontal">
                        <a href="javascript:searchKeyword();">
                            <img src="http://il-bang.com/pc_renewal/images/top_search.png" alt="검색"/>검색
                        </a>
                    </span>
                </div>
                <div class="search_lang mt10 pdl20">
                    <span>검색어 : </span>
                    <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=IT"><span>IT 일방</span></a>
                    <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=서비스"><span>서비스 일방</span>
                    <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=서빙"><span>서빙</span></a>
                    <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=MMC 피플"><span>MMC 피플</span></a>
                    <a href="http://il-bang.com/pc_renewal/search/guingujik-info-search.php?searchKeyword=일방"><span>일방</span></a>
                </div>
             </form>
            <div class="col-sm-4 top_right_logo">
                <!-- <a href="http://il-bang.com/pc_renewal/index.php"><img src="http://il-bang.com/pc_renewal/images/top_rightLogo.png" alt="모델 장나라" /></a> -->
            </div>
        </div>
    </div>			
    <!-- gnb -->
    <div class="container bb ht50 bg center wdfull">
        <div class="pg_rp">
            <ul class="nav nav-tabs ml35 fl mTopNav">
                <li class="dropdown ht46">
                    <a class="dropdown-toggle nav_top_txt dropbtn" href="http://il-bang.com/pc_renewal/guin.php?tab=1">구인자 <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-content">
                        <li><a href="http://il-bang.com/pc_renewal/guin.php?tab=1">전체 이력서 정보</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/guin.php?tab=2">나의 채용 공고</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/guin.php?tab=3">매칭 리스트</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/guin.php?tab=4">매칭 완료</a></li>
                    </ul>
                </li>
                <li class="dropdown ht46">
                    <a class="dropdown-toggle nav_top_txt dropbtn"  href="http://il-bang.com/pc_renewal/gujik.php?tab=1">구직자 <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-content">
                        <li><a href="http://il-bang.com/pc_renewal/gujik.php?tab=1">전체 채용 정보</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/gujik.php?tab=2">나의 이력서</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/gujik.php?tab=3">매칭 리스트</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/gujik.php?tab=4">매칭 완료</a></li>                   
                    </ul>
                </li>
                <li class="dropdown ht46">
                    <a class="dropdown-toggle nav_top_txt dropbtn" href="http://il-bang.com/pc_renewal/ad/adMoney.php">AD머니 <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-content">
                        <li><a href="http://il-bang.com/pc_renewal/ad/adMoney.php">전체</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/ad/adReserve.php">AD머니 적립</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/ad/adUseList.php">AD머니 사용 내역</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/ad/adProposal.php">광고 신청</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/ad/adRegulations.php">AD머니 광고 규정</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/ad/hanaMembers.php">하나 멤버십 카드</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/pointmall/pointmall.php">포인트몰</a></li>
                    </ul>
                </li>
                <li class="dropdown ht46">
                    <a class="dropdown-toggle nav_top_txt dropbtn" href="http://il-bang.com/pc_renewal/ad/cost-info.php">이용 요금 안내 <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-content">
                        <li><a href="http://il-bang.com/pc_renewal/ad/cost-info.php">이용 요금 안내</a></li>
                    </ul>
                </li>
                <li class="dropdown ht46">
                    <a class="nav_top_txt" href="http://il-bang.com/pc_renewal/pointmall/pointmall.php">포인트몰 </a>
                </li>
                <li class="dropdown ht46">
                    <a class="dropdown-toggle nav_top_txt dropbtn" href="http://il-bang.com/pc_renewal/notice/news.php">고객센터 <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-content">
                        <li><a href="http://il-bang.com/pc_renewal/notice/news.php">공지사항</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/cs/cs.php?tab=1">FAQ</a></li>
                        <li><a href="http://il-bang.com/pc_renewal/cs/cs.php?tab=2">Q&A</a></li> 
                    </ul>
                </li>
                <li class="dropdown ht46">
                    <a class="nav_top_txt" href="http://il-bang.com/pc_renewal/jijeom/jijeomApply.php">지점 신청</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right nav_right_apply  mtopNav-right">
                <li><a href="javascript:applicationCheck(0)" class="bold"><img src="http://il-bang.com/pc_renewal/images/person.png" alt="구직신청아이콘" class="navIcon img-responsive" />구직 신청</a></li>
                <li id="index_guinCheck">
                    <a href="#" onclick="indexGuinCheck(1); return false;" class="bold">
                        <img src="http://il-bang.com/pc_renewal/images/person.png" alt="구직신청아이콘" class="navIcon img-responsive" />구인 신청
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="guinTabModal" role="dialog">
        <div class="modal-dialog mt50">                    
            <!-- Modal content-->
            <div class="modal-content noBorder" style="background-color: transparent;">
                <div class="modal-header noBorder oh">
                    <a href="#" class="fr" data-dismiss="modal"><img src="http://il-bang.com/pc_renewal/images/exit.png" /></a>                
                </div>
            </div>
            <div class="modal-body f14 tc bg_white noPadding oh" style="padding-bottom: 10px;">
                <div class="mt50 mb50 tc">
                    <h3>추가 정보 입력</h3>
                    <h4 class="tc f12 c555 mt15 lh20">구인 신청서를 작성하기 위해서는 기업 정보를 추가로 입력하셔야 합니다.<br />
                        <span class="c-red">*은 필수 입력 사항입니다.</span>
                    </h4>
                    <div class="signupFormWrap" style="padding: 0 14%;">
                        <hr align="center" class="step3Hr2">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label col-sm-4 tl f14 mr10" for="company">회사 / 점포명 <span class="c-red">*</span></label>
                                <div class="col-sm-10 guinModalCol10">
                                    <input class="form-control singupInputs" id="company" name="company" type="text" placeholder="회사 / 점포명을 입력해주세요." />
                                </div>
                            </div><!-- 회사/점포명 end! -->
                            <div class="form-group">
                                <label class="control-label col-sm-4 tl f14 mr10" for="ceo">대표자 이름 <span class="c-red">*</span></label>
                                <div class="col-sm-10 guinModalCol10">
                                    <input class="form-control singupInputs" id="ceo" name="ceo" type="text" placeholder="대표자 이름을 입력해주세요." />
                                </div>
                            </div><!-- 대표자 이름 end! -->
                            <div class="form-group">
                                <label class="control-label col-sm-4 tl f14 mr10">사업자 등록 번호 <span class="c-red">*</span></label>
                                <div class="col-sm-10 guinModalCol10">
                                    <input class="form-control singupInputs di col-sm-4 w30" id="number1" name="number1" type="text" />
                                    <div class="fl f14 mt10 tc" style="width: 4.5%;">-</div>
                                    <input class="form-control singupInputs di col-sm-4 w30" id="number2" name="number2" type="text" />
                                    <div class="fl f14 mt10 tc" style="width: 4.5%;">-</div>
                                    <input class="form-control singupInputs di col-sm-4 w31" id="number3" name="number3" type="text" />
                                </div>
                            </div><!-- 사업자등록번호 end! -->
                            <div class="form-group">
                                <label class="control-label col-sm-4 tl f14 mr10">업종 / 기업 형태 <span class="c-red">*</span></label>
                                <div class="col-sm-10 guinModalCol10">
                                    <select id="types" name="types" class="di h40p mr1p" style="width: 48.2%;">
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
                                    <select id="status" name="status" class="di h40p" style="width: 48.2%;">
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
                                <label class="control-label col-sm-4 tl f14 mr10" for="content">주요 사업 내용 <span class="c-red">*</span></label>
                                <div class="col-sm-10 guinModalCol10">
                                    <input class="form-control singupInputs" id="content" name="content" type="text" placeholder="주요 사업 내용을 입력해주세요." />
                                </div>
                            </div><!-- 주요사업내용 end! -->
                            <div class="form-group">
                                <label class="control-label col-sm-4 tl f14 mr10">설립연도 <span class="c-red">*</span></label>
                                <div class="col-sm-10 guinModalCol10">
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
                            <div class="tc mt60 ">
                                <a href="javascript:addCompData()">
                                    <div class="cp di gujikWrtBtn lh1 f14" style="padding: 12px 25px;">작성 완료</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                      
    </div>