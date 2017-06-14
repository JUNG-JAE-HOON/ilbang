<?php
    include_once "../include/session.php";
    include_once "../db/connect.php";
    
    // ====================================================================================================================================================================================
    // ▽  ... 구인 정보 검색 ... ▽
    // ====================================================================================================================================================================================
    
    $searchKeyword = $_GET["searchKeyword"];

    if(isset($_GET['HsearchGuinPage'])) {
        $HsearchGuinPage = $_GET['HsearchGuinPage'];
    } else {
        $HsearchGuinPage = 1;
    }
    
    if(isset($_GET['HsearchGuinOnePage'])) {
        $HsearchGuinOnePage = $_GET['HsearchGuinOnePage']; // 한 페이지에 보여줄 게시글의 수.
    } else {
        $HsearchGuinOnePage = 10;
    }

    $sql  = " SELECT count(*)  as cnt                   ";
    $sql .= " FROM   work_employ_data                   ";
    $sql .= " WHERE  1=1                                ";
    $sql .= " AND   view = 'yes'                        ";
    $sql .= " AND   keyword   LIKE '%$searchKeyword%'   ";
    $sql .= " OR    title     LIKE '%$searchKeyword%'   ";
    $sql .= " OR    business  LIKE '%$searchKeyword%'   ";
        

    $result = mysql_query($sql, $ilbang_con);
        
    while($row = @mysql_fetch_array($result)){
             $HsearchGuinAllPost = $row["cnt"];    // 전체 게시글 수
    }

    $HsearchGuinAllPage = ceil($HsearchGuinAllPost / $HsearchGuinOnePage); //전체 페이지의 수
    $HsearchGuinOneSection = 5; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
    $HsearchGuinCurrentSection = ceil($HsearchGuinPage / $HsearchGuinOneSection); //현재 섹션
    $HsearchGuinAllSection = ceil($HsearchGuinAllPage / $HsearchGuinOneSection); //전체 섹션의 수
    $HsearchGuinFirstPage = ($HsearchGuinCurrentSection * $HsearchGuinOneSection) - ($HsearchGuinOneSection - 1); //현재 섹션의 처음 페이지

    if ($HsearchGuinAllPost == 0){
        $HsearchGuinLastPage = 1;
        $HsearchGuinCurrentSection = 1;
        $HsearchGuinAllSection = 1;
    
    } else if($HsearchGuinCurrentSection == $HsearchGuinAllSection) {
        $HsearchGuinLastPage = $HsearchGuinAllPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
    } else {
        $HsearchGuinLastPage = $HsearchGuinCurrentSection * $HsearchGuinOneSection; //현재 섹션의 마지막 페이지
    }

    $HsearchGuinPrevPage = (($HsearchGuinCurrentSection - 1) * $HsearchGuinOneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
    $HsearchGuinNextPage = (($HsearchGuinCurrentSection + 1) * $HsearchGuinOneSection) - ($HsearchGuinOneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.
    $HsearchGuinCurrentLimit = ($HsearchGuinOnePage * $HsearchGuinPage) - $HsearchGuinOnePage; //몇 번째의 글부터 가져오는지
    $HsearchGuinSqlLimit = ' limit ' . $HsearchGuinCurrentLimit . ', ' . $HsearchGuinOnePage;

    $sql  = " SELECT keyword                ";
    $sql .= "     ,  title                  ";
    $sql .= "     ,  business               ";
    $sql .= "     ,  career                 ";
    $sql .= "     ,  pay                    ";
    $sql .= "     ,  sex                    ";
    $sql .= "     ,  age_1st                ";
    $sql .= "     ,  age_2nd                ";
    $sql .= "     ,  time                   ";
    $sql .= "     ,  wdate                  ";
    $sql .= "     ,  no                     ";
    $sql .= " FROM   work_employ_data                   ";
    $sql .= " WHERE  1=1                                ";
    $sql .= " AND   view = 'yes'                        ";
    $sql .= " AND   keyword   LIKE '%$searchKeyword%'   ";
    $sql .= " OR    title     LIKE '%$searchKeyword%'   ";
    $sql .= " OR    business  LIKE '%$searchKeyword%'   ";
    $sql .= " ORDER BY wdate desc $HsearchGuinSqlLimit  ";

    $result = mysql_query($sql, $ilbang_con);
    
    // ====================================================================================================================================================================================
    // △  ... 구인 정보 검색 ... △
    // ====================================================================================================================================================================================
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no” />
    <title>PC버전 리뉴얼</title>
    <link rel="stylesheet" href="../css/bootstrap.css?ver=1.0.9">
    <link rel="stylesheet" href="../css/default.css?ver=1.1.3">
    <link rel="stylesheet" href="../css/default1.css?ver=1.0.4">
    <link rel="stylesheet" href="../css/hwajin.css?ver=1.0.3">
    <link rel="stylesheet" href="../css/slick.css">
    <link rel="stylesheet" href="../css/slick-theme.css">
    <link rel="stylesheet" href="../css/yeojin.css">    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <style>
        .active{ display: block !important; }
    </style>
    <script>
        $(document).ready(function() {
            $("#searchKeyword").val('<?php echo $searchKeyword ?>');
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

        function guinSearch(page) {
            $("#HsearchGuinPage").val(page);
            $("#HsearchGuinOnePage").val(10);
            $("#HsearchGujikOnePage").val(10);
            $("#totalSearchForm").attr("action", "./guingujik-info-search.php");

            document.getElementById("totalSearchForm").submit();

            $("#tab").val(1);
            $("#totalSearchForm").attr("action", "./guingujik-info-search.php?tab=1");
        }

        function setGuinSearchCount(){
            var guinSearchCount = $("#guinSearchCount option:selected").val();

            $("#HsearchGuinOnePage").val(guinSearchCount);
            $("#HsearchGuinPage").val(1);

            document.getElementById("totalSearchForm").submit();
        }

        function gujikSearch(page) {
            $("#HsearchGujikPage").val(page);
            $("#HsearchGuinOnePage").val(10);
            $("#HsearchGujikOnePage").val(10);
            $("#tab").val(2);
            $("#totalSearchForm").attr("action", "./guingujik-info-search.php?tab=2");

            document.getElementById("totalSearchForm").submit();        
        }

        function setGujikSearchCount(){
            var gujikSearchCount = $("#gujikSearchCount option:selected").val();

            $("#HsearchGujikOnePage").val(gujikSearchCount);
            $("#HsearchGujikPage").val(1);

            document.getElementById("totalSearchForm").submit();
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
                                <a href="javascript:addFavorite()">즐겨찾기 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="bd_right"><a href="http://il-bang.com/pc_renewal/cs/cs.php?tab=1">FAQ</a></li>
                            <li class="bd_right"><a href="http://il-bang.com/pc_renewal/cs/cs.php?tab=2">Q&A</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
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
                    url: '../log/modalLogin.php',
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
    
        function searchKeyword(){
            document.getElementById("headerSearchForm").submit();
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
    </script>
    <!-- logo -->
    <div class="container center">
        <div class="row">
            <div class="col-sm-3 top_logo">
                    <!-- 이 주소는 절대경로로 하기 -->
                <a href="http://il-bang.com/pc_renewal/index.php"><img src="http://il-bang.com/pc_renewal/images/top_left_logo.png" alt="로고"/></a>
            </div>
            <form class="col-sm-5 top_search" id="headerSearchForm" action="http://il-bang.com/pc_renewal/search/guingujik-info-search.php">
                <div class="input-group">
                    <input type="text" class="form-control bc br11 pl20 ha padding-vertical" name="searchKeyword" id="searchKeyword" placeholder="검색을 입력해주세요. ex) 디자이너" onkeypress="enterKey(event, 'search')" />
                    <span class="input-group-addon bg bc br11 pdtb0 padding-horizontal">
                        <a href="javascript:searchKeyword()">
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
                <img src="http://il-bang.com/pc_renewal/images/top_rightLogo.png" alt="모델 장나라" />
            </div>
        </div>
    </div>      
    <!-- gnb -->
    <div class="container border-top ht50  center wdfull guingujikSearchWrap">
        <div class="wdfull border-bottom-red">
            <ul class="nav nav-tabs pg_rp noBorder">
                <li class="active searchTabLi">
                    <a data-toggle="tab" href="#searchTab1" aria-controls="searchTab1" role="tab">구인 정보</a>
                </li>
                <li class="searchTabLi">
                    <a data-toggle="tab" href="#searchTab2" aria-controls="searchTab2" role="tab">구직 정보</a>
                </li>
            </ul>
        </div>
        <div class="tab-content pg_rp mt20">
            <div id="searchTab1" class="tab-pane fade in active pl10">
                <h3 class="di f18">구인 정보</h3>
                <h4 class="di f12">
                    <span class="fc"><?php echo $HsearchGuinAllPost?></span>건
                </h4>
                <div class="form-group di fr oh noMargin"></div>
                <div class="clear"></div><!--  상단 text end! -->
                <div class="bt2 oh w100 guinInfo pt10">
                <?php
                    $oneData = array();

                    while($row = mysql_fetch_array($result)) {
                        $oneData["no"]     = $row["no"];
                        $keyword  = explode(",", $row["keyword"]);
                        $oneData["area_1st_nm"] = $keyword[0];
                        $oneData["area_2nd_nm"] = $keyword[1];
                        $oneData["area_3rd_nm"] = $keyword[2];
                        $oneData["work_1st_nm"] = $keyword[3];
                        $oneData["work_2nd_nm"] = $keyword[4];
                        $oneData["title"]     = $row["title"];
                        $oneData["business"]  = $row["business"];
                        $oneData["career"]    = $row["career"];
                        $oneData["pay"]       = $row["pay"];
                        $oneData["sex"]       = $row["sex"];
                        $oneData["age_1st"]   = $row["age_1st"];
                        $oneData["age_2nd"]   = $row["age_2nd"];
                        $oneData["time"]      = $row["time"];
                        $oneData["wdate"]     = $row["wdate"];

                        if ($oneData["career"] == "-1")  $oneData["career"] = "무관";
                        else if ($oneData["career"] == "0")   $oneData["career"] = "신입";
                        else if ($oneData["career"] == "1")   $oneData["career"] = "1년 미만";  
                        else if ($oneData["career"] == "3")   $oneData["career"] = "3년 미만";  
                        else if ($oneData["career"] == "5")   $oneData["career"] = "5년 미만";  
                        else if ($oneData["career"] == "6")   $oneData["career"] = "5년 이상";  

                        if ($oneData["sex"] == "man")     $oneData["sex"] = "남자";
                        else if ($oneData["sex"] == "woman")   $oneData["sex"] = "여자";
                        else if ($oneData["sex"] == "nothing") $oneData["sex"] = "무관";  

                        if ($oneData["time"] == "1")  $oneData["time"] = "오전";
                        else if ($oneData["time"] == "2")  $oneData["time"] = "오후";
                        else if ($oneData["time"] == "3")  $oneData["time"] = "저녁";
                        else if ($oneData["time"] == "4")  $oneData["time"] = "새벽";
                        else if ($oneData["time"] == "5")  $oneData["time"] = "오전~오후";
                        else if ($oneData["time"] == "6")  $oneData["time"] = "오후~저녁";
                        else if ($oneData["time"] == "7")  $oneData["time"] = "저녁~새벽";
                        else if ($oneData["time"] == "8")  $oneData["time"] = "새벽~오전";
                        else if ($oneData["time"] == "9")  $oneData["time"] = "풀타임";
                        else if ($oneData["time"] == "10")  $oneData["time"] = "무관/협의";         

                        if (empty($oneData["area_1st_nm"])) $oneData["area_1st_nm"] = "회사 위치 정보가 없습니다.";
                        if (empty($oneData["area_2nd_nm"])) $oneData["area_2nd_nm"] = "";
                        if (empty($oneData["area_3rd_nm"])) $oneData["area_3rd_nm"] = "";
                        if (empty($oneData["work_1st_nm"])) $oneData["work_1st_nm"] = "";
                        if (empty($oneData["work_2nd_nm"])) $oneData["work_2nd_nm"] = "일방";
                        if (empty($oneData["company"]))     $oneData["company"]     = "";
                        if (empty($oneData["title"]))       $oneData["title"]       = "제목";
                        if (empty($oneData["business"]))    $oneData["business"]    = "";
                        if (empty($oneData["sex"]))         $oneData["sex"]         = "";
                        if (empty($oneData["age_1st"]))     $oneData["age_1st"]     = "";
                        if (empty($oneData["age_2nd"]))     $oneData["age_2nd"]     = "";
                        if (empty($oneData["time"]))        $oneData["time"]        = "";
                        if (empty($oneData["wdate"]))       $oneData["wdate"]       = "";
                    ?>
                    <ul class="oh noPadding gujikInfoList bb pdt6">
                        <li class="guinInfoLi1 lh87 fl tc">
                            <span class="bold"><?php echo $oneData["area_1st_nm"]?> <?php echo $oneData["area_2nd_nm"]?> <?php echo $oneData["area_3rd_nm"]?></span>
                        </li>
                        <li class="gujikInfoLi2 fl">
                            <h5><?php echo $oneData["title"]?></h5>
                            <div class="margin-vertical info2Cont">
                                <span class="ilbangBadge"><b><?php echo $oneData["work_2nd_nm"]?></b></span>
                                <span class="di text-cut guinDesc margin-verti ml5"><?php echo $oneData["business"]?></span>
                            </div>
                            <div>
                                <span>경력<?php echo $oneData["career"]?></span>   
                                <span class="margin-horizontal"></span>   
                                <span class="border-grey payBedge">일당</span>    
                                <span><?php echo number_format($oneData["pay"])?>원</span>    
                            </div>
                        </li>
                        <li class="gujikInfoLi3 lh25 fl tc">
                            <p><?php echo $oneData["sex"]?></p>
                            <p><?php echo $oneData["age_1st"]?> ~ <?php echo $oneData["age_2nd"]?>대</p>
                            <p><?php echo $oneData["time"]?></p>
                        </li>
                        <li class="gujikInfoLi4 fl tc">
                            <p class="lh25 mb10"><?php echo $oneData["wdate"]?></p> 
                            <p class="mb10">
                                <a href="../guin/view/tab1.php?employNo=<?php echo $oneData["no"]?>" class="direct sm-btn sm-btn1 f12" style="border: 1px solid #eb5f43;">열람하기</a>
                            </p>
                            <p>
                                <a href="../guin/review.php?employNo=<?php echo $oneData["no"] ?>" class="viewEsti sm-btn sm-btn2 f12">평가보기</a>
                            </p>
                        </li>
                    </ul>
                    <?php } ?>
                </div>
                <?php
                    $HsearchGuinPaging .=  '<ul class="pagination pagination_guin">';
    
                    //첫 페이지가 아니라면 처음 버튼을 생성
                    if($HsearchGuinPage != 1) {
                        $HsearchGuinPaging .= '<li><a href="javascript:guinSearch(1)"> << 첫페이지 </a></li>';
                    }
    
                    //첫 섹션이 아니라면 이전 버튼을 생성
                    if($HsearchGuinCurrentSection != 1) {
                        $HsearchGuinPaging .= '<li><a href="javascript:guinSearch('.$HsearchGuinPrevPage.')">이전</a></li>';
                    }

                    for($i = $HsearchGuinFirstPage; $i <= $HsearchGuinLastPage; $i++) {
                        if($i == $HsearchGuinPage) {
                            $HsearchGuinPaging .= '<li class="bg-light-gray"><a href="javascript:guinSearch('. $i .')" class="bg-light-gray">'.$i.'</a></li>';
                        } else {
                            $HsearchGuinPaging .= '<li><a href="javascript:guinSearch('. $i .')">'.$i.'</a></li>'; 
                        }
                    }

                    //마지막 섹션이 아니라면 다음 버튼을 생성
                    if($HsearchGuinCurrentSection != $HsearchGuinAllSection) {
                        $HsearchGuinPaging .= '<li><a href="javascript:guinSearch('.$HsearchGuinNextPage.')">다음</a></li>';
                    }

                    //마지막 페이지가 아니라면 끝 버튼을 생성
                    if($HsearchGuinPage != $HsearchGuinAllPage && $HsearchGuinAllPage != 0) {
                        $HsearchGuinPaging .= '<li><a href="javascript:guinSearch('.$HsearchGuinAllPage.')">끝페이지 >> </a></li>';
                    }
                    
                    $HsearchGuinPaging .=  '</ul>';
                ?>
                <div class="container center tc pb5">
                    <ul class="pagination">
                        <?php echo $HsearchGuinPaging ?>
                    </ul>
                </div>
            </div><!-- 첫번째 tab end! -->
            <?php
                // ====================================================================================================================================================================================
                // ▽  ... 구직 정보 검색 ... ▽
                // ====================================================================================================================================================================================
                $searchKeyword = $_GET["searchKeyword"];

                if(isset($_GET['HsearchGujikPage'])) {
                    $HsearchGujikPage = $_GET['HsearchGujikPage'];
                } else {
                    $HsearchGujikPage = 1;
                }

                if(isset($_GET['HsearchGujikOnePage'])) {
                    $HsearchGujikOnePage = $_GET['HsearchGujikOnePage']; // 한 페이지에 보여줄 게시글의 수.
                } else {
                    $HsearchGujikOnePage = 10;
                }

                $sql  = " SELECT count(*) as cnt                 ";
                $sql .= " FROM work_resume_data A                ";
                $sql .= "     ,member B                          ";
                $sql .= "     ,member_extend C                   "; 
                $sql .= " WHERE 1=1                              ";
                $sql .= " AND A.member_no = B.no                 ";
                $sql .= " AND A.member_no = C.member_no          ";
                $sql .= " AND                                    "; 
                $sql .= " (    A.title   LIKE '%$searchKeyword%' ";
                $sql .= "  OR  A.keyword LIKE '%$searchKeyword%' ";   
                $sql .= "  OR  A.pay     LIKE '%$searchKeyword%' ";
                $sql .= " )                                      ";

                $result = mysql_query($sql, $ilbang_con);

                while($row = @mysql_fetch_array($result)){
                    $HsearchGujikAllPost = $row["cnt"];    // 전체 게시글 수
                }

                $HsearchGujikAllPage = ceil($HsearchGujikAllPost / $HsearchGujikOnePage); //전체 페이지의 수
                $HsearchGujikOneSection = 5; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
                $HsearchGujikCurrentSection = ceil($HsearchGujikPage / $HsearchGujikOneSection); //현재 섹션
                $HsearchGujikAllSection = ceil($HsearchGujikAllPage / $HsearchGujikOneSection); //전체 섹션의 수
                $HsearchGujikFirstPage = ($HsearchGujikCurrentSection * $HsearchGujikOneSection) - ($HsearchGujikOneSection - 1); //현재 섹션의 처음 페이지

                if ($HsearchGujikAllPost == 0){
                    $HsearchGujikLastPage = 1;
                    $HsearchGujikCurrentSection = 1;
                    $HsearchGujikAllSection = 1;
                } else if($HsearchGujikCurrentSection == $HsearchGujikAllSection) {
                    $HsearchGujikLastPage = $HsearchGujikAllPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
                } else {
                    $HsearchGujikLastPage = $HsearchGujikCurrentSection * $HsearchGujikOneSection; //현재 섹션의 마지막 페이지
                }

                $HsearchGujikPrevPage = (($HsearchGujikCurrentSection - 1) * $HsearchGujikOneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
                $HsearchGujikNextPage = (($HsearchGujikCurrentSection + 1) * $HsearchGujikOneSection) - ($HsearchGujikOneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.        
                $HsearchGujikCurrentLimit = ($HsearchGujikOnePage * $HsearchGujikPage) - $HsearchGujikOnePage; //몇 번째의 글부터 가져오는지
                $HsearchGujikSqlLimit = ' limit ' . $HsearchGujikCurrentLimit . ', ' . $HsearchGujikOnePage;

                $sql  = " SELECT B.name                          ";
                $sql .= "     ,  C.sex                           ";
                $sql .= "     ,  C.age                           ";
                $sql .= "     ,  A.title                         ";
                $sql .= "     ,  A.keyword                       ";
                $sql .= "     ,  A.pay                           ";
                $sql .= "     ,  A.career                        ";
                $sql .= "     ,  A.time                          ";
                $sql .= "     ,  A.title                         ";
                $sql .= "     ,  A.no                            ";
                $sql .= "     ,  A.wdate          ";
                $sql .= " FROM work_resume_data A                ";
                $sql .= "     ,member B                          ";
                $sql .= "     ,member_extend C                   "; 
                $sql .= " WHERE 1=1                              ";
                $sql .= " AND A.member_no = B.no                 ";
                $sql .= " AND A.member_no = C.member_no          ";
                $sql .= " AND                                    "; 
                $sql .= " (    A.title   LIKE '%$searchKeyword%' ";
                $sql .= "  OR  A.keyword LIKE '%$searchKeyword%' ";   
                $sql .= "  OR  A.pay     LIKE '%$searchKeyword%' ";
                $sql .= " )                                      ";
                $sql .= " ORDER BY A.wdate desc  $HsearchGujikSqlLimit  ";

                $result = mysql_query($sql, $ilbang_con);
                // ====================================================================================================================================================================================
                // △  ... 구직 정보 검색 ... △
                // ====================================================================================================================================================================================
            ?>            
            <!-- 두번째 tab시작 -->
            <div id="searchTab2" class="tab-pane pl10">
                <h3 class="di f18">구직 정보</h3>
                <h4 class="di f12">
                    <span class="fc"><?php echo number_format($HsearchGujikAllPost); ?></span>건
                </h4>        
                <div class="form-group di fr oh noMargin"></div>
                <div class="clear"></div><!--  상단 text end! -->
                <div class="bt2 oh w100 guinInfo pt10">
                    <?php
                        $oneData = array();
                        
                        while($row = mysql_fetch_array($result)){
                            $oneData["no"]      = $row["no"];
                            $oneData["name"]    = $row["name"];
                            $oneData["sex"]     = $row["sex"];
                            $oneData["age"]     = $row["age"];
                            $oneData["title"]   = $row["title"];
                            $keyword  = explode(",", $row["keyword"]);
                            $oneData["area_1st_nm"] = $keyword[0];
                            $oneData["area_2nd_nm"] = $keyword[1];
                            $oneData["area_3rd_nm"] = $keyword[2];
                            $oneData["work_1st_nm"] = $keyword[3];
                            $oneData["work_2nd_nm"] = $keyword[4];
                            $oneData["pay"]       = number_format($row["pay"]);
                            $oneData["career"]    = $row["career"];
                            $oneData["time"]      = $row["time"];
                            $oneData["title"]     = $row["title"];
                            $oneData["wdate"]      = $row["wdate"];
                            $oneData["name"] = mb_substr($oneData["name"], 0, 1, 'utf-8') . "OO"; 
                            $oneData["age"] = substr($oneData["age"], 0, 1) . "0";     

                            if ($oneData["sex"] == "male")     $oneData["sex"] = "남자";
                            else if ($oneData["sex"] == "female")   $oneData["sex"] = "여자";

                            if ($oneData["career"] == "-1")  $oneData["career"] = "무관";
                            else if ($oneData["career"] == "0")   $oneData["career"] = "신입";
                            else if ($oneData["career"] == "1")   $oneData["career"] = "1년 미만";  
                            else if ($oneData["career"] == "3")   $oneData["career"] = "3년 미만";  
                            else if ($oneData["career"] == "5")   $oneData["career"] = "5년 미만";  
                            else if ($oneData["career"] == "6")   $oneData["career"] = "5년 이상";  

                            if ($oneData["time"] == "1")  $oneData["time"] = "오전";
                            else if ($oneData["time"] == "2")  $oneData["time"] = "오후";
                            else if ($oneData["time"] == "3")  $oneData["time"] = "저녁";
                            else if ($oneData["time"] == "4")  $oneData["time"] = "새벽";
                            else if ($oneData["time"] == "5")  $oneData["time"] = "오전~오후";
                            else if ($oneData["time"] == "6")  $oneData["time"] = "오후~저녁";
                            else if ($oneData["time"] == "7")  $oneData["time"] = "저녁~새벽";
                            else if ($oneData["time"] == "8")  $oneData["time"] = "새벽~오전";
                            else if ($oneData["time"] == "9")  $oneData["time"] = "풀타임";
                            else if ($oneData["time"] == "10")  $oneData["time"] = "무관/협의";

                            if (empty($oneData["area_1st_nm"])) $oneData["area_1st_nm"] = "회사 위치 정보가 없습니다.";
                            if (empty($oneData["area_2nd_nm"])) $oneData["area_2nd_nm"] = "";
                            if (empty($oneData["area_3rd_nm"])) $oneData["area_3rd_nm"] = "";
                            if (empty($oneData["work_1st_nm"])) $oneData["work_1st_nm"] = "";
                            if (empty($oneData["work_2nd_nm"])) $oneData["work_2nd_nm"] = "일방";
                            if (empty($oneData["company"]))     $oneData["company"]     = "";
                            if (empty($oneData["title"]))       $oneData["title"]       = "타이틀";
                            if (empty($oneData["business"]))    $oneData["business"]    = "";
                            if (empty($oneData["sex"]))         $oneData["sex"]         = "";
                            if (empty($oneData["age_1st"]))     $oneData["age_1st"]     = "";
                            if (empty($oneData["age_2nd"]))     $oneData["age_2nd"]     = "";
                            if (empty($oneData["time"]))        $oneData["time"]        = "";
                            if (empty($oneData["wdate"]))       $oneData["wdate"]       = "";
                    ?>                
                    <ul class="oh noPadding guinInfoList bb pdt6">
                        <li class="guinInfoLi1 lh87 fl tc">
                            <span class="bold"><?php echo $oneData["name"]?> (<?php echo $oneData["sex"]?>, <?php echo $oneData["age"]?>대)</span>
                        </li>
                        <li class="guinInfoLi2 fl">
                            <h5><?php echo $oneData["title"]?></h5>
                            <div class="margin-vertical info2Cont">
                                <span class="ilbangBadge"><b><?php echo $oneData["work_2nd_nm"]?></b></span>
                                <span class="text-cut guinDesc margin-verti ml5">희망 지역 : 
                                    <span class="c999"><?php echo $oneData["area_1st_nm"]?> > <?php echo $oneData["area_2nd_nm"]?> <?php echo $oneData["area_3rd_nm"]?></span>
                                </span>
                            </div>
                            <div>  
                                <span class="border-grey payBedge mr5 f_navy bold">일당</span>    
                                <span class="bold f_navy"><?php echo $oneData["pay"]?>원</span>    
                            </div>
                        </li>
                        <li class="guinInfoLi3 lh25 fl tc">
                            <p><?php echo $oneData["career"]?></p>
                            <p><?php echo $oneData["time"]?></p>
                        </li>
                        <li class="guinInfoLi4 fl tc">
                            <p class="lh25 mb10"><?php echo $oneData["wdate"]; ?></p> 
                            <p class="mb10">
                                <a href="../guin/view/guinTab1.php?tab=1&resumeNo=<?php echo $oneData['no']?>" class="direct sm-btn sm-btn3 f12">열람하기</a>
                            </p>
                            <p>
                                <a href="../guin/resumeReview.php?resumeNo=<?php echo $oneData['no']?>"  class="viewEsti sm-btn sm-btn2 f12">평가보기</a>
                            </p>
                        </li>
                    </ul>
                    <?php } ?>
                </div>
                <?php
                    $HsearchGujikPaging .=  '<ul class="pagination pagination_guijk">';
    
                    //첫 페이지가 아니라면 처음 버튼을 생성
                    if($HsearchGujikPage != 1) {
                        $HsearchGujikPaging .= '<li><a href="javascript:gujikSearch(1)"> << 첫페이지 </a></li>';
                    }

                    //첫 섹션이 아니라면 이전 버튼을 생성
                    if($HsearchGujikCurrentSection != 1) {
                        $HsearchGujikPaging .= '<li><a href="javascript:gujikSearch('.$HsearchGujikPrevPage.')">이전</a></li>';
                    }

                    for($i = $HsearchGujikFirstPage; $i <= $HsearchGujikLastPage; $i++) {
                        if($i == $HsearchGujikPage) {
                            $HsearchGujikPaging .= '<li class="bg-light-gray"><a href="javascript:gujikSearch('. $i .')" class="bg-light-gray">'.$i.'</a></li>';
                        } else {
                            $HsearchGujikPaging .= '<li><a href="javascript:gujikSearch('. $i .')">'.$i.'</a></li>';
                        }
                    }

                    //마지막 섹션이 아니라면 다음 버튼을 생성
                    if($HsearchGujikCurrentSection != $HsearchGujikAllSection) {
                        $HsearchGujikPaging .= '<li><a href="javascript:gujikSearch('.$HsearchGujikNextPage.')">다음</a></li>';
                    }

                    //마지막 페이지가 아니라면 끝 버튼을 생성
                    if($HsearchGujikPage != $HsearchGujikAllPage && $HsearchGujikAllPage != 0) {
                        $HsearchGujikPaging .= '<li><a href="javascript:gujikSearch('.$HsearchGujikAllPage.')">끝페이지 >> </a></li>';
                    }
    
                    $HsearchGujikPaging .=  '</ul>';
                ?>                
                <div class="container center tc pb5">
                    <ul class="pagination">
                        <?php echo $HsearchGujikPaging ?>
                    </ul>
                </div>
            </div><!-- 두번째 tab end! -->
        </div><!-- tab END -->
    </div>
    <form id="totalSearchForm">
        <input type="hidden" id="HsearchGuinPage"     name="HsearchGuinPage"        value="<?php echo $HsearchGuinPage?>" />
        <input type="hidden" id="HsearchGuinOnePage"  name="HsearchGuinOnePage"     value="<?php echo $HsearchGuinOnePage?>" />
        <input type="hidden" id="HsearchGujikOnePage" name="HsearchGujikOnePage"    value="<?php echo $HsearchGujikOnePage?>" />
        <input type="hidden" id="HsearchGujikPage"    name="HsearchGujikPage"       value="<?php echo $HsearchGujikPage?>" />
        <input type="hidden" id="tab"                 name="tab"                    value="1" />
        <input type="hidden" id="searchKeyword"       name="searchKeyword"          value="<?php echo $searchKeyword?>" />
</form>
<script>
    // 파라미터 가져오는 펑션 - 정재            --> 에러나서 주석 처리함
    function getQuerystring(paramName) {
        var _tempUrl = window.location.search.substring(1); //url에서 처음부터 '?'까지 삭제
        var _tempArray = _tempUrl.split('&'); // '&'을 기준으로 분리하기                
          
        if(_tempArray != null && _tempArray != "") {
            for(var i = 0; i<_tempArray.length; i++) {
                var _keyValuePair = _tempArray[i].split('='); // '=' 을 기준으로 분리하기
              
                if(_keyValuePair[0] == paramName){ // _keyValuePair[0] : 파라미터 명
                    return _keyValuePair[1];
                }
            }
        }
    }        

    // param 변수에 파라미터값을 저장합니다.
    var param=getQuerystring('tab');
    
    if(param=='') {
    } else if(param=='1') {
        $('#searchTab1').addClass("active");
        $('#searchTab2').removeClass("active");
        $('.searchTabLi').eq(0).addClass("active");
        $('.searchTabLi').eq(1).removeClass("active");
      } else if(param=='2') {
        $('#searchTab2').addClass("active");
        $('#searchTab1').removeClass("active");
        $('.searchTabLi').eq(1).addClass("active");
        $('.searchTabLi').eq(0).removeClass("active");
    }
</script>
<?php include_once "../include/footer.php"; ?>