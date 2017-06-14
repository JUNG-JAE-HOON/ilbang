<?php
    require_once('libs/INIStdPayUtil.php');
    require_once('libs/sha256.inc.php');

    $payBtnYn = "Y"; // 결제 버튼 
    $SignatureUtil = new INIStdPayUtil();

    include_once "../include/header.php";
    include_once "../db/connect.php";

    $item_no    = $_GET["item_id"];
    $amount     = $_GET["amount"];
    $employ_no  = $_GET["employ_no"];
    $msg        = "";
   
    if(!is_numeric($item_no)) {
        $msg = "구매가 취소되었습니다.";     //아이템 아이디가 잘못 되었습니다
    } else if ($item_no < 0) {
        $msg = "구매가 취소되었습니다.";     // 아이템 아이디가 잘못 되었습니다.
    }

    $sql = "SELECT id, item_id, item_name, item_price, item_amount, content, item_term, item_type, kind, image, discount_rate, item_kind
                 FROM item_data WHERE id = '$item_no'";
    $result = mysql_query($sql);

    while($arr = mysql_fetch_array($result)) {
        $item_number = $arr["id"];
        $item_id = $arr["item_id"];
        $item_name = $arr["item_name"];
        $item_price = $arr["item_price"];
        $item_amount =  $arr["item_amount"];
        $content = $arr["content"];
        $item_term = $arr["item_term"];
        $item_type = $arr["item_type"];
        $discount_rate = $arr["discount_rate"];
        $image = $arr["image"];
        $item_kind = $arr["item_kind"];
        $item_kind2 = $arr["kind"];
        $order_code = date("YmdHis",time()).$memberNo;
    }

    if ($item_kind == "grand" || $item_kind == "platinum" || $item_kind == "vip" || $item_kind == "special" || $item_type == "term") $amount = 1;

    if ( $item_type == "consume" && !is_numeric($amount)) {
        $msg = "구매가 취소되었습니다.";//수량이 숫자가 아닙니다. 
    } else if ($item_type == "consume" && $amount < 0) {
        $msg = "구매가 취소되었습니다."; //수량은 양수만 가능합니다.
    } else if ($item_kind=="grand" || $item_kind=="platinum" || $item_kind=="vip" || $item_kind=="special") {
        if ($uid == "") {
            $msg = "로그인 하세요.";
        } else if (!isset($employ_no)) {
            $msg = "채용 공고를 선택하세요.";
        } else if ($employ_no == "") {
            $msg = "채용 공고를 선택하세요.";
        } else if (!is_numeric($employ_no)) {
            $msg = "존재하지 않는 채용 공고 입니다.";
        } else if (is_numeric($employ_no)) {
            $sql = "SELECT COUNT(*) as employ_cnt
                         FROM work_employ_data
                         WHERE 1=1
                         AND view = 'yes'
                         AND uid = '$uid'
                         AND no = '$employ_no'";
            $result = mysql_query($sql);
            
            while($row = mysql_fetch_array($result)) {
                $employ_cnt = $row["employ_cnt"];
            }

            if ($employ_cnt == "0") {
                $msg = "존재하지 않는 채용 공고 입니다.";
            }
        }
    }

    if ($msg != "") {
        $txt = '<div class="signupWrap tc">
                        <div class="mt50 mb50">
                            <h3 class="mb20 tl">주문 / 결제</h3>
                            <div class="itemshopPayWrap tc f20">'.$msg.'</div>
                        </div>
                        <div class="center tc mb100 f14">
                            <a href="itemshop.php" class="fff nextBtn">아이템샵 가기</a>
                        </div>
                        <div class="beforeBtn tc di f14 mb100 lh33">
                            <div>이니시스 결제 화면에서 [취소] 버튼을 누르신 경우에는 페이지를 새로고침 하셔야 합니다.</div>
                            <div>주소창에서 [Enter] 키를 누르시면 됩니다.</div><br />
                            <div class="fc">[단축키]</div>
                            <div>- 인터넷 익스플로러 : F5 키를 누르세요.</div>
                            <div>- 크롬 브라우저 : CTRL + SHIFT + R 키를 누르세요.</div>
                        </div>
                    </div>';
            
        echo $txt;
        echo include_once "../include/footer.php" ;
        
        return ;
    }

    $sql = "SELECT phone, email FROM member_extend WHERE uid = '$uid'";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);

    $email = $row["email"];
    $phone = $row["phone"];

    $order_price = $amount * $item_price;
    $discount_price = $order_price - ($order_price * $discount_rate);
    $vat_price = ($discount_price) * 0.1;
    $total_price = $discount_price + $vat_price;
    $orderNumber = date("YmdHis",time()).$memberNo;  
    $order_time = date("Y-m-d H:i:s", time());

    if(strcmp($item_kind2, "company") == 0) {
        $imageLink = '<img src="../images/itemshopPay_guin.png" alt="구인용" />';
    } else if(strcmp($item_kind2,"general") == 0) {
        $imageLink = '<img src="../images/itemshopPay_gujik.png" alt="구직용" />';
    } else if(strcmp($item_kind2,"common") == 0) {
        $imageLink = '<img src="../images/itemshopPay_common.png" alt="공통" />';
    }

    //############################################
    // 1.전문 필드 값 설정(***가맹점 개발수정***)
    //############################################
    // 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
    $mid = "ilbangcom0";  // 가맹점 ID(가맹점 수정후 고정) //INIpayTest
    
    //인증
    $signKey = "RFVtRS9DY0lzNmNEK3JpZ1h1WlhXUT09"; // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지 // SU5JTElURV9UUklQTEVERVNfS0VZU1RS
    $timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성

    // $orderNumber = $mid . "_" . $timestamp; // 가맹점 주문번호(가맹점에서 직접 설정)
    $price = $total_price;        // 상품가격(특수기호 제외, 가맹점에서 직접 설정)

    $cardNoInterestQuota = "11-2:3:,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
    $cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정

    //###################################
    // 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
    //###################################
    $mKey = hash("sha256", $signKey);

    /*
        //*** 위변조 방지체크를 signature 생성 ***
        oid, price, timestamp 3개의 키와 값을
        key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값
        ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004
        * key기준 알파벳 정렬
        * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그데로 사용하여야함
    */
    //$params = "oid=" . $orderNumber . "&price=" . $price . "&timestamp=" . $timestamp;

    $params = array(
        "oid" => $orderNumber,
        "price" => $price,
        "timestamp" => $timestamp
    );

    //$sign = $SignatureUtil->makeSignature($params, "sha256");
    $sign = $SignatureUtil->makeSignature($params);

    /* 기타 */
    $siteDomain = "http://il-bang.com/pc_renewal/itemShop/"; //가맹점 도메인 입력
    // 페이지 URL에서 고정된 부분을 적는다.
    // Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
    // http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.
?>
<!-- 이니시스 표준결제 js -->
<script language="javascript" type="text/javascript" src="https://stdpay.inicis.com/stdjs/INIStdPay.js" charset="UTF-8"></script>
<script>
    function paybtn() {
        var uid = '<?php echo $uid?>';

        if (uid == "") {
            alert("로그인 하세요.");
            return;
        }

        INIStdPay.pay('ilbangcom0'); //INIpayTest
    }
</script>
<div class="signupWrap">
    <div class="mt50">
        <h3 class="mb20">주문 / 결제</h3>
        <div class="itemshopPayWrap">
            <div class="fl mr35" style="margin-top: 5px;"><?php echo $imageLink; ?></div>
            <div class="bold f22 fl w33" style="margin-top: 9px;"><?php echo $item_name; ?></div>
            <div class="di" style="max-width: 400px;">
                <p class="f18"><strong class="fc underline" ><?php echo $item_name; ?></strong> 상품을 주문합니다.</p>
                <p class="c999 f14"><?php echo $content; ?></p>
            </div>
        </div>
    </div>
    <form id="ilbangcom0" name="" method="POST" ><!-- INIpayTest-->
        <input type="hidden" name="gopaymethod" value="Card" />
        <input type="hidden" name="closeUrl" value="http://il-bang.com/pc_renewal/itemShop/itemshopPay.php" />
        <input type="hidden" name="version" value="1.0" />
        <input type="hidden" name="mid" value="<?php echo $mid; ?>" />
        <input type="hidden" name="goodname" value="<?php echo $item_name; ?>" />
        <input type="hidden" name="oid" value="<?php echo $orderNumber; ?>" />
        <input type="hidden" name="price" value="<?php echo $total_price; ?>" />
        <input type="hidden" name="currency" value="WON" />
        <input type="hidden" name="buyername" value="<?php echo $name; ?>" />
        <input type="hidden" name="buyertel" value="<?php echo $phone; ?>" />
        <input type="hidden" name="buyeremail" value="<?php echo $email; ?>" />
        <input type="hidden" name="merchantData" value="item_id=<?php echo $item_id; ?>&amount=<?php echo $amount; ?>&employ_no=<?php echo $employ_no; ?>" />
        <input type="hidden" name="timestamp" type="text" value="<?php echo $timestamp; ?>" />
        <input type="hidden" name="signature" value="<?php echo $sign ?>" />
        <input type="hidden" name="returnUrl" value="<?php echo $siteDomain; ?>/payResult.php" />
        <input type="hidden" name="mKey" value="<?php echo $mKey; ?>" />
        <div class="mt40">
            <h4 class="f18">주문 상품 정보</h4>
            <div class="gujikDetSect2 oh mt10">
                <div class="oh bold bb">
                    <p class="fl w45 noMargin di lh40 f14 tc">상품 정보</p>
                    <p class="fl w10 noMargin di lh40 f14 tc">수량</p>
                    <p class="fl itemshopline noMargin di lh40 f14 tc">상품 금액</p>
                    <p class="fl itemshopline noMargin di lh40 f14 tc">주문 금액</p>
                </div>
                <div class="oh bg_grey itemshopPrdInfoBox">
                    <div class="w45 fl">
                        <div class="fl sect2Table f14 tl mr45"><?php echo $image; ?></div>
                        <div class="fl sect2Table f14 tl" style="padding-top: 12px;">
                            <p class="bold"><?php echo $item_name; ?></p>
                            <p class="f13" style="width: 210px;"><?php echo $content; ?></p>
                        </div>
                    </div>
                    <p class="w10 di sect2Table di lh70 f14 tc bold"><?php echo number_format($amount); ?></p>
                    <p class="itemshopline di sect2Table di lh70 f14 tc bold"><?php echo number_format($item_price); ?>원</p>
                    <p class="itemshopline di sect2Table di lh70 f14 tc fc"><?php echo number_format($amount * $item_price); ?>원</p>
                </div>
            </div>
            <div class="oh mt10 itemshopPrdInfoBox2">
                <div class="oh bold bb bg_grey row">
                    <p class="fl col-sm-3 noMargin di lh40 f14 tc">상품 금액</p>
                    <p class="fl col-sm-3 noMargin di lh40 f14 tc">할인 금액</p>
                    <p class="fl col-sm-3 noMargin di lh40 f14 tc">부과세</p>
                    <p class="fl col-sm-3 noMargin di lh40 f14 tc">결제 금액</p>
                </div>
                <div class="oh bold row">
                    <p class="di sect2Table lh70 f14 tc bold col-sm-3"><strong class="f18"><?php echo number_format($order_price); ?></strong>원</p>
                    <p class="di sect2Table lh70 f14 tc bold col-sm-3"><strong class="f18"><?php echo number_format($discount_price); ?></strong>원 (<?php echo $discount_rate * 100; ?>% 할인)</p>
                    <p class="di sect2Table lh70 f14 tc bold col-sm-3"><strong class="f18"><?php echo number_format($vat_price); ?></strong>원</p>
                    <p class="di sect2Table lh70 f14 tc bold fc col-sm-3"><strong class="f18"><?php echo number_format($total_price); ?></strong>원 (VAT 포함)</p>
                </div>
            </div>
        </div>
        <div class="mt40 mb100">
            <h4 class="f18">구매자 정보</h4>
            <div class="itemshopPay oh mt10">
                <div class="oh border-bottom">
                    <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">주문 번호</div>
                    <div class="sect2Table di lh40 f12 tc noMargin pdl20" ><?php echo $orderNumber; ?></div>
                </div>
                <div class="oh border-bottom">
                    <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">주문 일시</div>
                    <div class="sect2Table di lh40 f12 tc noMargin pdl20"><?php echo $order_time; ?></div>
                </div>
                <div class="oh border-bottom">
                    <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">구매자</div>
                    <div class="sect2Table di lh40 f12 tc noMargin pdl20"><?php echo $name; ?></div>
                </div>
                <div class="oh border-bottom">
                    <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">전화번호</div>
                    <div class="sect2Table di lh40 f12 tc noMargin pdl20"><?php echo $phone; ?></div>
                </div>
                <div class="oh border-bottom">
                    <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">이메일</div>
                    <div class="sect2Table di lh40 f12 tc noMargin pdl20"><?php echo $email; ?></div>
                </div>
            </div>
        </div>
        <?php
            if ($item_kind== "grand" || $item_kind == "platinum" || $item_kind == "vip" || $item_kind == "special") {
                $sql = "SELECT title as employ_title
                             FROM work_employ_data
                             WHERE 1=1
                             AND no = '$employ_no'";
                $result = mysql_query($sql);

                while($row = mysql_fetch_array($result)) {
                    $employ_title = $row["employ_title"];
                }
        ?>
        <div class="mt40 mb100">
            <h4 class="f16"><?php echo strtoupper($item_kind)?> 영역에 보여질 채용공고</h4>
            <div class="itemshopPay oh mt10">
                <div class="oh border-bottom">
                    <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">제목</div>
                    <div class="sect2Table di lh40 f12 tc noMargin pdl20">
                        <a href="../guin/view/tab2.php?tab=2&employNo=1027"><?php echo $employ_title; ?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            }



            if($uid != "" && ($item_id == "inis.reading1weekbuy" || $item_id == "inis.reading1monthbuy")) { // 이력서 열람 7일 무제한, 이력서 열람 한달 무제한
                $sql = "SELECT A.start_date as open_start_date, A.end_date as open_end_date
                             , B.item_name as open_item_name, B.charge_type as open_charge_type
                             FROM work_item A, item_data B
                             WHERE 1=1 AND A.item_id IN (4,8,12,3,7,11) AND A.end_date > SYSDATE()
                             AND A.uid = '$uid' AND A.item_id = B.id ";
                $result = mysql_query($sql);

                while($row = mysql_fetch_array($result)) {
                    $open_start_date    = $row["open_start_date"];
                    $open_end_date      = $row["open_end_date"];
                    $open_item_name     = $row["open_item_name"];
                    $open_charge_type   =  $row["open_charge_type"];
                
                    if($open_charge_type == "P") {
                        $open_charge_type = "PC";
                    } else if($open_charge_type == "A") {
                        $open_charge_type = "안드로이드";
                    } else if($open_charge_type == "I") {
                        $open_charge_type = "아이폰";
                    }
                }


                if ( mysql_num_rows($result) > 0) {
                    $payBtnYn = "N";
                
            ?>
            <div class="mt40 mb100">
                <h4 class="f16">이력서 열람 아이템 구매 내역</h4>
                <div class="itemshopPay oh mt10">
                    <div class="oh border-bottom">
                        <div class="di w15 noMargin sect2head bg_grey lh40 f14 tc bold">결제 불가</div>
                        <div class="sect2Table di lh40 f12 tc noMargin pdl20" >
                        <a href="../guin/view/tab2.php?tab=2&employNo=1027">
                            <?php echo $open_charge_type; ?>에서 구매한 <?php echo $open_item_name; ?> 아이템이 있습니다.
                            (<?php echo $open_start_date; ?> ~ <?php echo $open_end_date; ?>)
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php }
        } ?>
    </form>
    <div class="center tc mb100">
        <a href="itemshop.php" class="c-red beforeBtn">취소하기</a>
        <?php if($payBtnYn == "Y") { ?>
        <a href="javascript:paybtn()" class="fff nextBtn">결제하기</a>
        <?php } ?>
    </div>
</div>
<?php include_once "../include/footer.php" ?>