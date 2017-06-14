<?php include_once "../include/header.php" ?>
<script>
    $(document).ready(function() {
        getNotice();
        //getItemList();
        getPCItemList();
        getMainItemList();
    });

    function getNotice() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/notice/getNoticeList.php',
            success: function(data) {
                for(var i=0; i<1; i++) {
                    document.getElementById("adNotice").innerHTML
                    = '<a href="../notice/view.php?no=' + data.noticeList[i].no + '" class="c999">' + data.noticeList[i].title + '</a>';
                }
            }
        });
    }

    function getItemList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/shop/itemList.php',
            success: function(data) {
                var itemList = data.itemList;
                var itemHtml = '';
                var imageLink = "";
                    
                for(var i =0; i<itemList.length ; i++) {
                    var selectTxt = '';
                    
                    for (var j=0; j<data.employList.length; j++) {
                        selectTxt += '<option value="' + data.employList[j].employ_no + '">' + data.employList[j].title + '</option>';
                    }
                    
                    var kind        = itemList[i].kind;    
                    var item_name   = itemList[i].item_name;
                    var content     = itemList[i].content;
                    var item_price  = itemList[i].item_price;
                    var item_id     = itemList[i].id;
                    var item_type   = itemList[i].item_type;
                    var discount_amt= itemList[i].discount_amt;
                    var discount_rate= itemList[i].discount_rate;
                    var item_kind   = itemList[i].item_kind;

                    if(discount_rate == "0") {
                        discount_txt = '<p class="bold f16">' + item_name + ' (' + item_price + '원) </p>';
                    } else {
                        discount_txt = '<p class="bold f16">' + item_name + ' (<del>' + item_price + '원</del>) ' + discount_amt + '원</p>';
                    }

                    switch(kind) {
                        case 'company': imageLink="../images/itemshopGuin.png";
                        break;
                        
                        case 'general': imageLink="../images/itemshopGujik.png";
                        break;
                        
                        case 'common': imageLink="../images/itemshopCommon.png";
                        break;
                    }

                    if(i % 3 == 0) {
                        if(i == 0) {
                            itemHtml += '<div class="row">';
                        } else {
                            itemHtml += '</div><div class="row">';
                        }
                    }
                        
                    itemHtml += '<div class="col-sm-4 border-grey itemshopBoxWrap">'
                    + '<div class="tc"><img src="' + imageLink + '" alt=""></div>'
                    + '<div class="p20 oh">'
                    + '<hr align="center">'
                    + discount_txt
                    + '<p class="f1 c999 mb10 prdContent">' + content + '<br /><br /></p>'
                    + '<form name="item' + i + '" action="itemshopPay.php" method="GET">'
                    + '<input type="hidden" name="item_id" value="' + item_id + '" />';
                    
                    if(item_type == 'consume') {
                       itemHtml += '<div class="input-group number-spinner">'
                       + '<input type="text" class="form-control text-center itsFromControl" id="amount' + i + '" name="amount"  value="1" />'  
                       + '<span class="input-group-btn itemshopMinusBtn">'
                       + '<button class="btn btn-default itsSnippetBtn" type="button" onclick="amountCountroller(\'' + "amount" + i + '\',\'' + "-" + '\')">'
                       + '<span class="glyphicon glyphicon-minus"></span></button>'
                       + '</span>'
                       + '<span class="input-group-btn itemshopPlusBtn">'
                       + '<button class="btn btn-default itsSnippetBtn" type="button" onclick="amountCountroller(\'' + "amount" + i + '\',\'' + "+" + '\')">'
                       + '<span class="glyphicon glyphicon-plus"></span></button>'
                       + '</span>'
                       + '<a href="javascript:item' + i + '.submit()" class="btn btn-default itsBuyBtn">구매하기</a>'
                       + '</div>'
                       + '</div>';
                    } else if(item_kind == 'resumeMonth' || item_kind == 'resumeWeek') {
                        itemHtml += '<a href="javascript:item' + i + '.submit()" class="btn btn-default itsBuyBtn ml25p mr25p mt1">구매하기</a></div>';
                    } else if(item_kind == 'vip' || item_kind == 'platinum' || item_kind == 'grand' || item_kind == 'special') {
                        itemHtml += '<select class="fl mt1 mr1p" style="width: 64%;" name="employ_no">'
                        + '<option value="" selected>채용 공고를 선택하세요.</option>'
                        + selectTxt
                        + '</select>'
                        + '<a href="javascript:item' + i + '.submit()" class="btn btn-default itsBuyBtn fl mt1 w35" style="padding: 3px 0;">구매하기</a>'
                        + '</div>';
                    }
                    
                    itemHtml += '</form></div>';
                }

                itemHtml += '</div>';
                
                document.getElementById("itemList").innerHTML = itemHtml;
            }
        });
    }

    function amountCountroller(id, type) {
        var amount = document.getElementById(id).value;
       
        if(amount >= 1) {
            if(type == "+") {
                amount++;
            } else {
                if(amount != 1) {
                    amount--;
                }
            }
       }

       document.getElementById(id).value = amount;
    }

    function getPCItemList() {
        //alert('t');
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/shop/getPCItemList.php',
            success: function(data) {
                //alert(JSON.stringify(data));
                var itemList = data.itemList;
                var itemHtml = '';
                var imageLink = "";
                    
                for(var i =0; i<itemList.length ; i++) {

                    var kind        = itemList[i].kind;    
                    var item_name   = itemList[i].item_name;
                    var content     = itemList[i].content;
                    var item_price  = itemList[i].item_price;
                    var item_id     = itemList[i].id;
                    var item_type   = itemList[i].item_type;
                    var discount_amt= itemList[i].discount_amt;
                    var discount_rate= itemList[i].discount_rate;
                    var item_kind   = itemList[i].item_kind;

                    if(discount_rate == "0") {
                        discount_txt = '<p class="bold f16">' + item_name + ' (' + item_price + '원) </p>';
                    } else {
                        discount_txt = '<p class="bold f16">' + item_name + ' (<del>' + item_price + '원</del>) ' + discount_amt + '원</p>';
                    }


                    switch(kind) {
                        case 'company': imageLink="../images/itemshopGuin.png";
                        break;
                        
                        case 'general': imageLink="../images/itemshopGujik.png";
                        break;
                        
                        case 'common': imageLink="../images/itemshopCommon.png";
                        break;
                    }

                    var item_desc_nm;

                           if (item_name == "긴급 구인 1회")       {  item_desc_nm = "긴급구인";
                    } else if (item_name == "이력서 열람 1회")      {  item_desc_nm = "이력서 열람";
                    } else if (item_name == "이력서 열람 7일 무제한") {  item_desc_nm = "이력서 열람";
                    } else if (item_name == "이력서 열람 한달 무제한") {  item_desc_nm = "이력서 열람";
                    } else if (item_name == "악평 지우기 1회")       {  item_desc_nm = "악평 지우기";
                    }


            itemHtml
                +=     '<div class="col-sm-4 border-grey itemshopBoxWrap new-itemshopBoxWrap">'
                 +         '<div class="tc">'
                 +         '<img src="' + imageLink + '" alt="">'
                 +         '</div>'
                 +         '<div class="p20 oh">'
                 +           '<p class="bold f16">' + item_name + ' ('+discount_amt+'원) </p>'
                 +           '<hr align="center">'
                 +           '<p class="bold f16">'+item_desc_nm+'</p>'
                 +         '<p class="f1 c999 mb10 prdContent">'+ content +''
                 +              '<br>'
                 +              '<br>'
                 +         '</p>'
                 +         '<form id="pcItem'+i+'" action="itemshopPay.php" method="GET">'
                 +              '<input type="hidden" name="item_id" value="' + item_id + '">'
                 +             '<div class="input-group number-spinner">';

        if(item_kind == 'resumeMonth' || item_kind == 'resumeWeek') {
               itemHtml 
                 +=            '<input type="hidden" name="amount" value="1">';
        }
                 
        if(item_type == 'consume') {
            
            itemHtml     

                   
                 +=              '<input type="text" class="form-control text-center itsFromControl" id="amount' + i + '" name="amount" value="1">'
                 +              '<span class="input-group-btn itemshopMinusBtn">'
                 +                  '<button class="btn btn-default itsSnippetBtn" type="button" onclick="amountCountroller(\'' + "amount" + i + '\',\'' + "-" + '\')">'
                 +                      '<span class="glyphicon glyphicon-minus">'
                 +                      '</span>'
                 +                   '</button>'
                 +              '</span>'
                 +              '<span class="input-group-btn itemshopPlusBtn">'
                 +                  '<button class="btn btn-default itsSnippetBtn" type="button" onclick="amountCountroller(\'' + "amount" + i + '\',\'' + "+" + '\')">'
                 +                       '<span class="glyphicon glyphicon-plus">'
                 +                       '</span>'
                 +                   '</button>'
                 +              '</span>';
                
        }

            itemHtml


                 +=             '<a href="javascript:goPCItemPay('+i+')" class="btn btn-default itsBuyBtn">구매하기'
                 +              '</a>'
                 +              '</div>'
                 +         '</form>'
                 +         '</div>'
                 +      '</div>';
                    
                }

                
                document.getElementById("PCitemList").innerHTML = itemHtml;
            }
        });
    }

    function goPCItemPay(i){

        $("#pcItem"+i).submit();

    }

    function getMainItemList() {
        //alert('t');
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/shop/getMainItemList.php',
            success: function(data) {
                //alert(JSON.stringify(data));
                var itemList     = data.itemList;
                var vipList      = data.vipList;
                var platinumList = data.platinumList;
                var grandList    = data.grandList;
                var specialList  = data.specialList;
                var itemHtml     = '';
                var imageLink    = "";
                    
                var employTxt = '<option value="">채용 공고를 선택하세요</option>';
                for(var i =0; i<data.employList.length ; i++) {
                    employTxt += '<option value="'+data.employList[i].employ_no+'">'+data.employList[i].title+'</option>';                    
                }

                    var kind        = vipList[0].kind;    
                    var item_name   = vipList[0].item_name;
                    var content     = vipList[0].content;
                    var item_price  = vipList[0].item_price;
                    var item_id     = vipList[0].id;
                    var item_type   = vipList[0].item_type;
                    var discount_amt= vipList[0].discount_amt;
                    var discount_rate= vipList[0].discount_rate;
                    var item_kind   = vipList[0].item_kind;

                

                    itemHtml
                     += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border-grey pc-product">'
                     +  '<div class="p20 oh">'
                     +       '<div class="bb oh">'
                     +         '<div class="oh fl w100">'
                     +               '<p class="bold f18">VIP 채용 정보</p>'
                     +               '<p class="f1 c999 f14 oh w100 mt10 mb10">홈 첫번째 VIP 채용 정보</p>'
                     +               '<form class="pc-item-select oh fl" id="vipItem" name="vipItem" action="itemshopPay.php" method="GET">'
                     +                   '<input type="hidden" id="amount" name="amount" value="1">'
                     +                   '<select class="di pc-item-inner1" name="employ_no" id="employ_no">'
                     +                       employTxt
                     +                   '</select>'
                     +                   '<select class="di pc-item-inner2" name="item_id" id="vip_item_id" onchange="changeVipPrice()">'
                     +                       '<option value="'+vipList[0].id+'">1일</option>'
                     +                       '<option value="'+vipList[1].id+'">7일</option>'
                     +                       '<option value="'+vipList[2].id+'">15일</option>'
                     +                       '<option value="'+vipList[3].id+'">30일</option>'
                     +                   '</select>'                                
                     +               '</form>'
                     +           '</div>'
                     +           '<div class="w100 oh pt10 mb10">'
                     +               '<p class="fr di">'
                     +                   '<span class="f18 fc" id="vip_price"><del>150,000원</del> 16,500</span>원'
                     +               '</p>'
                     +           '</div>'  
                     +      '</div>'
                     +      '<div class="oh mt20">'
                     +           '<p class="f1 c999 pc-cont fl">'
                     +               '<br>'
                     +               '<br>'
                     +           '</p>'
                     +           '<p class="di oh">'
                     +               '<a href="javascript:goVipPay()" class="btn btn-default itsBuyBtn">구매하기'
                     +               '</a>'
                     +           '</p>'
                     +       '</div>'
                     +   '</div>'
                     + '</div>';



                    itemHtml
                     += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border-grey pc-product">'
                     +  '<div class="p20 oh">'
                     +       '<div class="bb oh">'
                     +         '<div class="oh fl w100">'
                     +               '<p class="bold f18">플래티넘 채용 정보</p>'
                     +               '<p class="f1 c999 f14 oh w100 mt10 mb10">홈 두번째 플래티넘 채용 정보</p>'
                     +               '<form class="pc-item-select oh fl" name="platinumItem" id="platinumItem" action="itemshopPay.php" method="GET">'
                     +                   '<input type="hidden" id="amount" name="amount" value="1">'
                     +                   '<select class="di pc-item-inner1" name="employ_no" id="employ_no">'
                     +                       employTxt
                     +                   '</select>'
                     +                   '<select class="di pc-item-inner2" name="item_id" id="platinum_item_id" onchange="changePlatinumPrice()">'
                     +                       '<option value="'+data.platinumList[0].id+'">1일</option>'
                     +                       '<option value="'+data.platinumList[1].id+'">7일</option>'
                     +                       '<option value="'+data.platinumList[2].id+'">15일</option>'
                     +                       '<option value="'+data.platinumList[3].id+'">30일</option>'
                     +                   '</select>'                                
                     +               '</form>'
                     +           '</div>'
                     +           '<div class="w100 oh pt10 mb10">'
                     +               '<p class="fr di">'
                     +                   '<span class="f18 fc" id="platinum_price"><del>100,000원</del> 10,000</span>원'
                     +               '</p>'
                     +           '</div>'  
                     +      '</div>'
                     +      '<div class="oh mt20">'
                     +           '<p class="f1 c999 pc-cont fl">'
                     +               '<br>'
                     +               '<br>'
                     +           '</p>'
                     +           '<p class="di oh">'
                     +               '<a href="javascript:goPlatinumPay()" class="btn btn-default itsBuyBtn">구매하기'
                     +               '</a>'
                     +           '</p>'
                     +       '</div>'
                     +   '</div>'
                     + '</div>';


                    itemHtml
                     += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border-grey pc-product">'
                     +  '<div class="p20 oh">'
                     +       '<div class="bb oh">'
                     +         '<div class="oh fl w100">'
                     +               '<p class="bold f18">그랜드 채용 정보</p>'
                     +               '<p class="f1 c999 f14 oh w100 mt10 mb10">홈 세번째 그랜드 채용 정보</p>'
                     +               '<form class="pc-item-select oh fl" name="grandItem" id="grandItem" action="itemshopPay.php" method="GET">'
                     +                   '<input type="hidden" id="amount" name="amount" value="1">'
                     +                   '<select class="di pc-item-inner1" name="employ_no" id="employ_no">'
                     +                       employTxt
                     +                   '</select>'
                     +                   '<select class="di pc-item-inner2" name="item_id" id="grand_item_id" onchange="changeGrandPrice()">'
                     +                       '<option value="'+data.grandList[0].id+'">1일</option>'
                     +                       '<option value="'+data.grandList[1].id+'">7일</option>'
                     +                       '<option value="'+data.grandList[2].id+'">15일</option>'
                     +                       '<option value="'+data.grandList[3].id+'">30일</option>'
                     +                   '</select>'                                
                     +               '</form>'
                     +           '</div>'
                     +           '<div class="w100 oh pt10 mb10">'
                     +               '<p class="fr di">'
                     +                   '<span class="f18 fc" id="grand_price"><del>60,000원</del> 6,000</span>원'
                     +               '</p>'
                     +           '</div>'  
                     +      '</div>'
                     +      '<div class="oh mt20">'
                     +           '<p class="f1 c999 pc-cont fl">'
                     +               '<br>'
                     +               '<br>'
                     +           '</p>'
                     +           '<p class="di oh">'
                     +               '<a href="javascript:goGrandPay()" class="btn btn-default itsBuyBtn">구매하기'
                     +               '</a>'
                     +           '</p>'
                     +       '</div>'
                     +   '</div>'
                     + '</div>';


                    itemHtml
                     += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border-grey pc-product">'
                     +  '<div class="p20 oh">'
                     +       '<div class="bb oh">'
                     +         '<div class="oh fl w100">'
                     +               '<p class="bold f18">스페셜 채용 정보</p>'
                     +               '<p class="f1 c999 f14 oh w100 mt10 mb10">홈 네번째 스페별 채용 정보</p>'
                     +               '<form class="pc-item-select oh fl" name="specialItem" id="specialItem" action="itemshopPay.php" method="GET">'
                     +                   '<input type="hidden" id="amount" name="amount" value="1">'
                     +                   '<select class="di pc-item-inner1" name="employ_no" id="employ_no">'
                     +                       employTxt
                     +                   '</select>'
                     +                   '<select class="di pc-item-inner2" name="item_id" id="special_item_id" onchange="changeSpecialPrice()">'
                     +                       '<option value="'+data.specialList[0].id+'">1일</option>'
                     +                       '<option value="'+data.specialList[1].id+'">7일</option>'
                     +                       '<option value="'+data.specialList[2].id+'">15일</option>'
                     +                       '<option value="'+data.specialList[3].id+'">30일</option>'
                     +                   '</select>'                                
                     +               '</form>'
                     +           '</div>'
                     +           '<div class="w100 oh pt10 mb10">'
                     +               '<p class="fr di">'
                     +                   '<span class="f18 fc" id="special_price"><del>30,000원</del> 3,000</span>원'
                     +               '</p>'
                     +           '</div>'  
                     +      '</div>'
                     +      '<div class="oh mt20">'
                     +           '<p class="f1 c999 pc-cont fl">'
                     +               '<br>'
                     +               '<br>'
                     +           '</p>'
                     +           '<p class="di oh">'
                     +               '<a href="javascript:goSpecialPay()" class="btn btn-default itsBuyBtn">구매하기'
                     +               '</a>'
                     +           '</p>'
                     +       '</div>'
                     +   '</div>'
                     + '</div>';

 

                document.getElementById("mainItemList").innerHTML = itemHtml;

                for(var i =0; i<platinumList.length ; i++) {
                }
            }
        });
    }

    function changeVipPrice(){
        //alert($("#item_id").val());
        var id = $("#vip_item_id").val();

               if (id == "16") { $("#vip_price").html("<del>150,000원</del> 15,000");
        } else if (id == "17") { $("#vip_price").html("<del>1,050,000원</del> 105,000");
        } else if (id == "18") { $("#vip_price").html("<del>2,250,000원</del> 225,000");
        } else if (id == "19") { $("#vip_price").html("<del>4,500,000원</del> 450,000");
        }
    }

    function changePlatinumPrice(){
        var id = $("#platinum_item_id").val();

               if (id == "20") { $("#platinum_price").html("<del>100,000원</del> 10,000");
        } else if (id == "21") { $("#platinum_price").html("<del>700,000원</del> 70,000");
        } else if (id == "22") { $("#platinum_price").html("<del>1,500,000원</del> 165,000");
        } else if (id == "23") { $("#platinum_price").html("<del>3,000,000원</del> 300,000");
        }
    }

    function changeGrandPrice(){
        var id = $("#grand_item_id").val();

               if (id == "24") { $("#grand_price").html("<del>60,000원</del> 6,000");
        } else if (id == "25") { $("#grand_price").html("<del>420,000원</del> 42,000");
        } else if (id == "26") { $("#grand_price").html("<del>900,000원</del> 90,000");
        } else if (id == "27") { $("#grand_price").html("<del>1,800,000원</del> 180,000");
        }   
    }

    function changeSpecialPrice() {
         var id = $("#special_item_id").val();

               if (id == "28") { $("#special_price").html("<del>30,000원</del> 3,000");
        } else if (id == "29") { $("#special_price").html("<del>210,000원</del> 21,000");
        } else if (id == "30") { $("#special_price").html("<del>450,000원</del> 45,000");
        } else if (id == "31") { $("#special_price").html("<del>900,000원</del> 90,000");
        }   
    }

    function goVipPay() {

        $("#vipItem").submit();

    }


    function goPlatinumPay() {

        $("#platinumItem").submit();

    }

    function goGrandPay(){
        $("#grandItem").submit();

    }

    function goSpecialPay(){
        $("#specialItem").submit();
    }
</script>
<div class="container center pl30">
    <div class="c999 fl pt10 pb10">
    <a href="../index.php" class="c999">HOME</a>
    <span class="plr5">&gt;</span>
    <a href="#" class="bold">아이템 SHOP</a>
</div>
<div class="c999 fr padding-vertical">
        <span class="mr5 br15 subNotice">공지</span>
        <span id="adNotice"></span>
    </div>
    <hr class="bc-grey noMargin clear" />
</div>
<div class="container pl30">
    <h5 class="f16 bold mt25 mb15">아이템 SHOP</h5>
    <!--  배너 -->
    <div class="itemBannerWrap" id="generalGujikListArea"></div>
    <div class="itemSubTitleWrap">
        <h6 class="itemSubtxt">아이템 SHOP</h6>
    </div>
    <div class="itemRowWrap">
        <div id="itemList"></div>
        <div class="webAndPc oh">
            <h3><b class="fc">일방앱+PC웹</b> 결합 상품</h3>
            <div id="PCitemList">
            <!--<script>
             $(".webAndPc").load("test.html");
            </script>-->
            </div>
        </div>  
        <div class="pc oh">
            <?php
            if ($kind == "" || $kind == "company"){
            ?> 
            <h3 class="mt40 mb20"><b class="fc">PC웹</b>구인자 전용 상품</h3>
            <?php
            }
            ?>
            <div id="mainItemList" class="row">
            <!--<script>
                $(".pc").load("pc.html");   
            </script>-->
            </div>
        </div>
    </div><!-- rowWrap end! -->
</div>
<?php include_once "../include/footer.php" ?>