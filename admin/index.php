<?php include_once "../include/session.php"; ?>
<?php include_once "../db/connect.php";?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 위 3개의 메타 태그는 *반드시* head 태그의 처음에 와야합니다; 어떤 다른 콘텐츠들은 반드시 이 태그들 *다음에* 와야 합니다 -->
    <title>어드민</title>
    <script type="text/javascript" src="../lib/fusioncharts/js/fusioncharts.js"></script>
    <script type="text/javascript" src="../lib/fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
    <!-- 부트스트랩 -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/admin.css?ver=1.0.1" rel="stylesheet">
    <link href="../css/default.css" rel="stylesheet">
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css" />
    <!-- IE8 에서 HTML5 요소와 미디어 쿼리를 위한 HTML5 shim 와 Respond.js -->
    <!-- WARNING: Respond.js 는 당신이 file:// 을 통해 페이지를 볼 때는 동작하지 않습니다. -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="http://apis.daum.net/maps/maps3.js?apikey=721aff1257b519a5cffe6cc6cbed8aa6"></script> 
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="../js/bootstrap.js"></script>    
    <style>
        .tabCont { display: none; }
        .tab-active { display: block; }
    </style>
</head>
<body class="color4">
<div class="container-fluid color1">
    <div class="row">
        <div class="adminCont f_white lh40">
            <?php if($uid == "") { ?>
            <span class="f12">로그인 해주시기 바랍니다.</span>
            <?php } else { ?>
            <span class="f12">안녕하세요. 관리자(<?php echo $uid; ?>)님</span>
            <?php } ?>
                <div class="fr f12">
                    <a href="../index.php" class="fff"><span class="mr10">일방 홈</span></a>
                    <a href="javascript:location.reload();" class="fff"><span class="cp">새로고침</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid color2">
        <div class="row">
            <div class="adminCont f_white lh60">
                <span class="f16">관리자 페이지</span>
                <div class="fr">
                    <p class="di lh18 vm tc oh" style="width:60px">
                        <span class="f12 db"><span id="indexMyRecmdCnt">0</span>명</span>
                        <span class="f12 db" style="">나의 추천인</span>
                    </p>
                    <p class="di lh18 vm tc oh" style="width:40px; margin:0 30px 5px 30px">
                        <span class="f12 db"><span id="indexTotalGuinCnt">0</span>명</span>
                        <span class="f12 db">구인중</span>
                    </p>
                    <p class="di lh18 vm tc oh" style="width:60px">
                        <span class="f12 db"><span id="indexTotalGujikCnt">0</span>명</span>
                        <span class="f12 db">구직중</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid color3">
        <div class="row">
            <div class="adminCont">
                <div class="adminTabWrap f14">
                    <span class="di oh lh50 tc adminNav noMargin active_under">관리자 메인</span>
                    <span class="di oh lh50 tc adminNav noMargin">나의 추천인 관리</span>
                    <span class="di oh lh50 tc adminNav noMargin">구매 현황 관리</span>
                </div>		
            </div>
        </div>
    </div>
    <div class="container-fluid contLast oh tab-content">
        <div class="tabCont tabCont1 tab-active">
            <?php include_once "my-tab-main.php"; ?>
        </div>
        <div class="tabCont tabCont2">
            <?php include_once "my-tab1.php"; ?>
        </div>
        <div class="tabCont tabCont3">
            <?php include_once "my-tab2.php"; ?>
        </div>
    </div>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>	
    <script>
        $(".adminNav").click(function(){
        });

        $(".adminNav").each(function(i){
            $(this).click(function(){
                $(".adminNav").removeClass("active_under");
                $(this).addClass("active_under");
                $(".tabCont").removeClass("tab-active");
                
                if(i == 0) {
                    $(".tabCont1").addClass("tab-active");
                } else if(i == 1) {
                    $(".tabCont2").addClass("tab-active");
                } else {
                    $(".tabCont3").addClass("tab-active");
                }
            });
        });
    </script>
</body>
</html>