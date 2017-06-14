<?php
    include_once "include/header.php";
    include_once "ajax/executeLog.php";
?>
<script>
    $(document).ready(function() {
        getNotice();
        getMainCounter();       
        //getEmergencyGuinList(); 
        getGeneralGuinList();
        getGeneralGujikList();
        getGuinWork1stList(); 
        getGujikWork1stList();
        guinClear();
        gujikClear();
       
        // indexGuinCheck2(0);
    });

    function getNotice() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/notice/getNoticeList.php',
            success: function(data) {
                for(var i=0; i<1; i++) {
                    document.getElementById("adNotice").innerHTML
                    = '<a href="notice/view.php?no=' + data.noticeList[i].no + '" class="c999">' + data.noticeList[i].title + '</a>';
                }
            }
        });
    }

    // function indexGuinCheck2(val) {
    //     var id = "<?php echo $uid; ?>";

    //     if(id == "") {
    //         if(val == 1) {
    //             alert("로그인 후 이용해주세요.");
    //         }
    //     } else {
    //         if(val == 0) {
    //             $.ajax({
    //                 type: 'post',
    //                 dataType: 'json',
    //                 url: 'ajax/guin/guinCheck.php',
    //                 success: function(data) {
    //                     if(data == 0) {
    //                         document.getElementById("index_guinCheck2").innerHTML
    //                         = '<a class="mainLogout bold" href="#" data-toggle="modal" data-target="#guinTabModal">긴급 구인</a>';

    //                         document.getElementById("index_guinCheck3").innerHTML
    //                         = '<a href="#" class="border-grey bg_white p5 f11 ml5 br2" data-toggle="modal" data-target="#guinTabModal">긴급 구인 신청하기</a>';
    //                     }
    //                 }
    //             });
    //         } else {
    //             // document.location.href = "guin/form/form.php";
    //             document.location.href = "#";
    //         }
    //     }
    // }

    function getGeneralGujikCounter() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getMainCounter.php',
            success: function (data) {
                new numberCounter("_curGujikCnt" , data.listData[0].gujikIng);
                new numberCounter("_gujikFormCnt", data.listData[0].gujikIng);
                new numberCounter("_newEmployCnt"  , data.listData[0].guinIng);
            }
        });
    }

    function getGeneralGujikList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getGeneralGujikList.php',
            success: function (data) {
                var cell = document.getElementById("generalGujikListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }
                           
                // 위아래 합친 넓은 영역
                document.getElementById("generalGujikListArea").innerHTML
                += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 normalGujikList oh padding tc bg_white" style="border: 2px solid #ef473a;">'
                +        '<div class="mt30">'
                +            '<h5 class="bold f16">현재 구직중인 신청서</h5>'
                +            '<div class="w100 oh tc">' 
                +                '<span class="noMargin mr5 bold fc" style="font-size:30px;" id="_curGujikCnt">2,334</span><span class="f14" style="line-height:35px">건</span>'
                +            '</div>'
                +            '<hr class="csHr mt10">'
                +            '<p class="mb25" style="font-size: 12px !important;">'
                +                '현재 총 <font color="#ef473a" id="_gujikFormCnt" class="bold">33,656</font>건의 구직 신청서가 작성되었으며<br>'
                +                '<font color="#ef473a" id="_newEmployCnt" class="bold">20,343</font>건의 신규 채용이 완료되었습니다.'
                +            '</p>'
                +            '<a href="guin.php" class="gujikInfoMoreBtn">구직자 정보 더보기</a>'
                +         '</div>'
                +     '</div>';

                for (var i=0; i<data.listData.length; i++ ) {
                    if(data.listData[i].img_url == null || data.listData[i].img_url == '' ) {
                        data.listData[i].img_url = './images/71x71.png';
                    } else {
                        data.listData[i].img_url = './gujikImage/'+data.listData[i].img_url;
                    }

                    document.getElementById("generalGujikListArea").innerHTML
                    += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 border-grey h125p bg_white">'
                    // +        '<a class="di pa plusIcon-grey plusIconPadding f23 bold f_grey" onfocus="this.blur();" href="./guin/view/guinTab1.php?resumeNo='+data.listData[i].no+'"   align="center"></a>'
                    +        '<a class="di pa plusIcon-grey plusIconPadding f23 bold f_grey" onfocus="this.blur();" href="javascript:itemCheck(' + data.listData[i].no + ')" align="center"></a>'
                    +        '<div style="padding: 15px 24px 0px 15px;">'
                    +            '<img class="profileImg fl wh71 mr15" src="' + data.listData[i].img_url + '" alt="">'
                    +            '<div class="fl mgeneralGujikTxt cp" onclick="itemCheck(' + data.listData[i].no + ')">'
                    // +                '<h6 class="f_grey f13 gujikText-overflow cp" onclick=location.href="./guin/view/guinTab1.php?resumeNo='+data.listData[i].no+'">'+data.listData[i].title+'</h6>'
                    // +                '<h6 class="f_grey f13 gujikText-overflow cp" onclick="itemCheck(' + data.listData[i].no + ')">'+data.listData[i].title+'</h6>'
                    +                '<h6 class="f_grey f13 gujikText-overflow">' + data.listData[i].title + '</h6>'
                    +                '<p class="f12">' + data.listData[i].work_1st_nm + '<span> > </span>' + data.listData[i].work_2nd_nm + '</p>'
                    +                '<p class="f12"><b>지역</b> : ' + data.listData[i].area_1st_nm + '<span> > </span>' + data.listData[i].area_2nd_nm + ' '+data.listData[i].area_3rd_nm + '</p>'
                    +            '</div>'
                    +        '</div>'
                    +        '<div class="clear f12 pl15 pr24" style="padding-top: 10px;">'
                    +            '<span class="mr5">' + data.listData[i].name + '</span>'
                    +            '<span>' + data.listData[i].sex + ' / ' + data.listData[i].age + '대</span>'
                    +            '<span class="ml10"><b class="fc">**,***</b>원</span>'
                    +            '<span class="fr">' + data.listData[i].career + '</span>'
                    +        '</div>'
                    +    '</div>';
                }

                getGeneralGujikCounter();
            }
        });
    }

    function getGeneralGuinList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getGeneralGuinList.php',
            success: function (data) {
                var cell = document.getElementById("generalGuinListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ) {
                    if(data.listData[i].img_url == null || data.listData[i].img_url == '' ) {
                        data.listData[i].img_url = 'images/C144x38.png';
                    } else {
                        data.listData[i].img_url = 'guinImage/' + data.listData[i].img_url;
                    }

                    document.getElementById("generalGuinListArea").innerHTML
                    += '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border normalGuinList cp" onclick=location.href="./guin/view/tab1.php?employNo=' + data.listData[i].no + '">'
                    +  '<a class="di pa plusIcon-grey2 plusIconPadding bold f_grey" onfocus="this.blur();" href="./guin/view/tab1.php?employNo=' + data.listData[i].no + '"></a>'
                    +  '<img src="' + data.listData[i].img_url + '" alt="" class="vm mormalLogo fl" style="width: 144px; height:38px;">'
                    +  '<div class="fl pl30 normalInfo">'
                    +  '<h5 class="f_grey">' + data.listData[i].company + '</h5>'
                    +  '<p>' + data.listData[i].work_1st_nm + '<span> > </span>' + data.listData[i].work_2nd_nm + '</p>'
                    +  '<p><b>지역</b> : ' + data.listData[i].area_1st_nm + '<span> > </span>' + data.listData[i].area_2nd_nm + ' ' + data.listData[i].area_3rd_nm + '</p>'
                    +  '</div>'
                    +  '</div>';
                }
            }
        });
    }

  // function getEmergencyGuinList(){
  //     $.ajax({
  //                        type: 'post',
  //                        dataType: 'json',
  //                        url: 'ajax/getEmergencyGuinList.php',
  //                        data: {},
  //                        success: function (data) {
                          
  //                           var cell = document.getElementById("emergencyGuinListArea1");

  //                           while (cell.hasChildNodes()){
  //                               cell.removeChild(cell.firstChild);
  //                           }


  //                           for (var i=0; i<4; i++ ){
  //                               if(data.listData.length <= i ) continue;

  //                               if(data.listData[i].img_url == null || data.listData[i].img_url == '' ) {
  //                                 data.listData[i].img_url = './images/C144x38.png';
  //                               } else {
  //                                 data.listData[i].img_url = './guinImage/'+data.listData[i].img_url;
  //                               }
  //                               document.getElementById("emergencyGuinListArea1").innerHTML
  //                               += '<div class="di urgentList pr cp" align="center" onclick=location.href="./guin/view/tab1.php?employNo='+data.listData[i].no+'">' 
  //                               +  '<a class="di pa plusIcon glyphicon glyphicon-plus f25 bold fc" href="./guin/view/tab1.php?employNo='+data.listData[i].no+'" align="center"></a>'
  //                               +  '<p class="mt30"><img src="'+data.listData[i].img_url+'" alt="" class="wh144"></p>'
  //                               +  '<div align="left" class="col-md-offset-1 col-lg-offset-1">'
  //                               +  '<h5 class="f_grey">'+data.listData[i].company+'</h5>'
  //                               +  '<p>'+data.listData[i].work_1st_nm+'<span>></span>'+data.listData[i].work_2nd_nm+'</p>'
  //                               +  '<p><b>지역</b>:'+data.listData[i].area_1st_nm+'<span>></span>'+data.listData[i].area_2nd_nm+' '+data.listData[i].area_3rd_nm+'</p>'
  //                               +  '<p><b><span class="fc">'+data.listData[i].pay+'</span>원</b> <span class="fr dist"></span></p>' // 1.32km
  //                               +  '</div>' 
  //                               +  '</div>';
                                
  //                           }

  //                           var cell = document.getElementById("emergencyGuinListArea2");

  //                           while (cell.hasChildNodes()){
  //                               cell.removeChild(cell.firstChild);
  //                           }

  //                           for (var i=4; i<6; i++ ){
  //                             if(data.listData.length <= i ) continue;

  //                              if(data.listData[i].img_url == null || data.listData[i].img_url == '' ) {
  //                                 data.listData[i].img_url = './images/C144x38.png';
  //                               } else {
  //                                 data.listData[i].img_url = './guinImage/'+data.listData[i].img_url;
  //                               }
                                

  //                               document.getElementById("emergencyGuinListArea2").innerHTML
  //                               += '<div class="fl di urgentList pr cp" align="center" onclick=location.href="./guin/view/tab1.php?employNo='+data.listData[i].no+'">' 
  //                               +  '<a class="di pa plusIcon glyphicon glyphicon-plus f25 bold fc" href="./guin/view/tab1.php?employNo='+data.listData[i].no+'" align="center"></a>'
  //                               +  '<p class="mt30"><img src="'+data.listData[i].img_url+'" alt="" class="wh144"></p>'
  //                               +  '<div align="left" class="col-md-offset-1 col-lg-offset-1">'
  //                               +  '<h5 class="f_grey">'+data.listData[i].company+'</h5>'
  //                               +  '<p>'+data.listData[i].work_1st_nm+'<span>></span>'+data.listData[i].work_2nd_nm+'</p>'
  //                               +  '<p><b>지역</b>:'+data.listData[i].area_1st_nm+'<span>></span>'+data.listData[i].area_2nd_nm+' '+data.listData[i].area_3rd_nm+'</p>'
  //                               +  '<p><b><span class="fc">'+data.listData[i].pay+'</span>원</b> <span class="fr dist"></span></p>'
  //                               +  '</div>'
  //                               +  '</div>';
  //                           }

  //                           document.getElementById("emergencyGuinListArea2").innerHTML
  //                           +=  '<a href="#" class="di urgentListIndex pr" align="center" id="itemShopImg">' 
  //                               +  '<img src="http://il-bang.com/pc_renewal/images/emergencyBanner01.png" alt="아이템샵으로 바로가기" style="height:200px;" />'
  //                               +  '</av>'
  //                               +  '<a href="ad/adMoney.php" class="di urgentListIndex pr" align="center">' 
  //                               +  '<img src="http://il-bang.com/pc_renewal/images/emergencyBanner02.png" alt="일방 AD머니로 바로가기" style="height:200px;" />'
  //                               +  '</a>'
  //                               +  '<div class="clear"></div>';

  //                           document.getElementById("itemShopImg").href = 'javascript:alert("준비중 입니다.")';
  //                       }
  //     })
  // }

  
    function getMainCounter() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getMainCounter.php',
            success: function (data) {
                new numberCounter("resumeCnt" , data.listData[0].resumeCnt);
                new numberCounter("employCnt", data.listData[0].employCnt);
                new numberCounter("totalMatching"  , data.listData[0].totalMatching);
                // new numberCounter("guinIng"    , data.listData[0].guinIng);
                // new numberCounter("gujikIng"   , data.listData[0].gujikIng);
                // new numberCounter("guinIng2"   , data.listData[0].guinIng);
                // new numberCounter("gujikIng2"  , data.listData[0].gujikIng);
            }
        });
    }

    function numberCounter(target_frame, target_number) {
        this.count = 0; this.diff = 0;
        this.target_count = parseInt(target_number);
        this.target_frame = document.getElementById(target_frame);
        this.timer = null;
        this.counter();
    };
  
    numberCounter.prototype.counter = function() {
        var self = this;
        this.diff = this.target_count - this.count;
  
        if(this.diff > 0) {
            self.count += Math.ceil(this.diff / 5);
        }
  
        this.target_frame.innerHTML = this.count.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  
        if(this.count < this.target_count) {
            this.timer = setTimeout(function() { self.counter(); }, 20);
        } else {
            clearTimeout(this.timer);
        }
    };

    function setGuinArea1st(area_1st) {
        // $("input#guinArea1st").val(area_1st);
        // $("input#guinArea2nd").val("");
        // $("input#guinArea3rd").val("");
        $("input#HguinArea1st").val(area_1st);
        $("input#HguinArea2nd").val("");
        $("input#HguinArea3rd").val("");

        
        $(this).addClass("active-btn");
        getGuinArea2ndList(area_1st);
    }

    function getGuinArea2ndList(area_1st) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea2ndList.php',
            data: {area_1st:area_1st},
            success: function (data) {
                var cell = document.getElementById("guinArea2ndListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ) {
                    document.getElementById("guinArea2ndListArea").innerHTML
                    += '<a href="javascript:setGuinArea2nd('+data.listData[i].area_2nd+')" class="local1Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_2nd_nm+'</a>';
                }
            }
        });
    }

    function setGuinArea2nd(area_2nd) {
        // $("input#guinArea2nd").val(area_2nd);
        // $("input#guinArea3rd").val("");
        $("input#HguinArea2nd").val(area_2nd);
        $("input#HguinArea3rd").val("");

        getGuinArea3rdList(area_2nd);
    }

    function getGuinArea3rdList(area_2nd) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea3rdList.php',
            data: {area_2nd:area_2nd},
            success: function (data) {
                var cell = document.getElementById("guinArea3rdListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinArea3rdListArea").innerHTML
                    += '<a href="javascript:setGuinArea3rd('+data.listData[i].area_3rd+')" class="local2Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_3rd_nm+'</a>';
                }
            }
        });
    }

    function setGuinArea3rd (area_3rd) {
        // $("input#guinArea3rd").val(area_3rd);
        $("input#HguinArea3rd").val(area_3rd);
    }

    function setGujikArea1st(area_1st) {
        // $("input#gujikArea1st").val(area_1st);
        // $("input#gujikArea2nd").val("");
        // $("input#gujikArea3rd").val("");
        $("input#HgujikArea1st").val(area_1st);
        $("input#HgujikArea2nd").val("");
        $("input#HgujikArea3rd").val("");

        $(this).addClass("active-btn");
        getGujikArea2ndList(area_1st);
    }

    function getGujikArea2ndList(area_1st) {
        $(this).addClass("active-btn");

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea2ndList.php',
            data: {area_1st:area_1st},
            success: function (data) {
                var cell = document.getElementById("gujikArea2ndListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikArea2ndListArea").innerHTML
                    += '<a href="javascript:setGujikArea2nd('+data.listData[i].area_2nd+')" class="local1Inner'+(i+1)+' di w12_5 tc fl">'+data.listData[i].area_2nd_nm+'</a>';
                }
            }
        });
    }

    function setGujikArea2nd(area_2nd) {
        $("input#HgujikArea2nd").val(area_2nd);
        $("input#HgujikArea3rd").val("");

        getGujikArea3rdList(area_2nd);
    }

    function getGujikArea3rdList (area_2nd) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getArea3rdList.php',
            data: {area_2nd:area_2nd},
            success: function (data) {
                var cell = document.getElementById("gujikArea3rdListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikArea3rdListArea").innerHTML
                    += '<a href="javascript:setGujikArea3rd('+data.listData[i].area_3rd+')" class="local2Inner1 di w12_5 tc fl">'+data.listData[i].area_3rd_nm+'</a>';
                }
            }
        });
    }

    function setGujikArea3rd (area_3rd) {
        $("input#HgujikArea3rd").val(area_3rd);
    }

    function getGuinWork1stList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork1stList.php',
            success: function (data) {
                var cell = document.getElementById("guinWork1st");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("guinWork1st").innerHTML = '<option value="">1차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ) {
                    document.getElementById("guinWork1st").innerHTML
                    += '<option value='+data.listData[i].work_1st+'>'+data.listData[i].work_1st_nm+'</option>';
                }
            }
        });
    }

    function getGuinWork2ndList() {
        var work_1st = $("#guinWork1st option:selected").val();
    
        $("#HguinWork1st").val(work_1st);

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork2ndList.php',
            data: {work_1st:work_1st},
            success: function (data) {
                var cell = document.getElementById("guinWork2nd");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("guinWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("guinWork2nd").innerHTML
                    += '<option value='+data.listData[i].work_2nd+'>'+data.listData[i].work_2nd_nm+'</option>';
                }
            }
        });
    }

    function getGujikWork1stList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork1stList.php',
            success: function (data) {
                var cell = document.getElementById("gujikWork1st");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("gujikWork1st").innerHTML = '<option value="">1차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikWork1st").innerHTML
                    += '<option value='+data.listData[i].work_1st+'>'+data.listData[i].work_1st_nm+'</option>';
                }
            }
        });
    }

    function getGujikWork2ndList() {
        var work_1st = $("#gujikWork1st option:selected").val();
        
        $("#HgujikWork1st").val(work_1st);

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getWork2ndList.php',
            data: {work_1st:work_1st},
            success: function (data) {
                var cell = document.getElementById("gujikWork2nd");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("gujikWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("gujikWork2nd").innerHTML
                    += '<option value='+data.listData[i].work_2nd+'>'+data.listData[i].work_2nd_nm+'</option>';
                }
            }
        });
    }

    function setGuinWork2nd() {
        var work_2nd = $("#guinWork2nd option:selected").val();

        $("#HguinWork2nd").val(work_2nd);
    }   
  
    function setGuinAge(age) {
        $("#HguinAge").val(age);
    }

    function setGuinPay() {
        var guinPay = $("#guinPay option:selected").val();

        $("#HguinPay").val(guinPay);
    }

    function setGuinTime(time) {
        $("#HguinTime").val(time);
    }

    function setGuinGender(sex) {
        $("#HguinGender").val(sex);
    }

    function guinSearch() {
        $("#HguinOnePage").val(10);
        $("#HguinPage").val(1);

        document.getElementById("guinSearchForm").submit();
    }

    function setGuinCareer() {
        var guinCareer = $("#guinCareer option:selected").val();

        $("#HguinCareer").val(guinCareer);
    }

    function guinClear() {
        $("#HguinPage"              ).val(1);
        $("#HguinOnePage"           ).val(10);
        $("#HguinArea1st"           ).val("");
        $("#HguinArea2nd"           ).val("");     
        $("#HguinArea3rd"           ).val("");        
        $("#HguinWork1st"           ).val("");        
        $("#HguinWork2nd"           ).val("");        
        $("#HguinPay"               ).val("");            
        $("#HguinPayIsUnrelated"    ).val(""); 
        $("#HguinTime"              ).val("");  
        $("#HguinGender"            ).val("");
        $("#HguinCareer"            ).val("");
        $("#HguinCareerIsUnrelated" ).val("");
        $("#HguinAge"               ).val("");
        $("#guingujikTab1 > ul > li > a"  ).removeClass("active-btn")    ; 
        $("#guinArea2ndListArea > a").removeClass("active-btn2")   ;
        $("#guinArea3rdListArea > a").removeClass("active-btn2")   ;
        $("#guinArea1st").val("");
        $("#guinArea2nd").val("");
        $("#guinArea3rd").val("");
        $("#guinWork1st").val("");
        //$("#guinWork2nd").val("");

        var cell = document.getElementById("guinWork2nd");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        document.getElementById("guinWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

        //$('input:radio[name=guinAge]').filter('[value=unrelated]').prop('checked', true);
        $('input:radio[name=guinAge]').prop('checked', false);
        $("#guinPay").val("");
        //$("#guinPayIsUnrelated").();
        $("#guinPayIsUnrelated").attr('checked', false);
        //$('input:radio[name=guinTime]').filter('[value=unrelated]').prop('checked', true);
        //$('input:radio[name=guinGender]').filter('[value=nothing]').prop('checked', true);
        $('input:radio[name=guinTime]').prop('checked', false);
        $('input:radio[name=guinGender]').prop('checked', false);
        $("#guinCareer").val("");
        $("#guinCareerIsUnrelated").attr('checked', false);

        var cell = document.getElementById("guinArea2ndListArea");
    
        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        var cell = document.getElementById("guinArea3rdListArea");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        $("#guinArea2ndListArea").hide();
        $("#guinArea3rdListArea").hide();
    }

    function gujikSearch() {
        $("#HgujikOnePage").val(10);
        $("#HgujikPage").val(1);

        document.getElementById("gujikSearchForm").submit();
    }

    function gujikClear() {
        $("#HgujikPage"              ).val(1);
        $("#HgujikOnePage"           ).val(10);
        $("#HgujikArea1st"           ).val("");
        $("#HgujikArea2nd"           ).val("");     
        $("#HgujikArea3rd"           ).val("");        
        $("#HgujikWork1st"           ).val("");        
        $("#HgujikWork2nd"           ).val("");        
        $("#HgujikPay"               ).val("");            
        $("#HgujikPayIsUnrelated"    ).val(""); 
        $("#HgujikTime"              ).val("");  
        $("#HgujikGender"            ).val("");
        $("#HgujikCareer"            ).val("");
        $("#HgujikCareerIsUnrelated" ).val("");
        $("#HgujikAge"               ).val("");
        $("#guingujikTab1 > ul > li > a"  ).removeClass("active-btn")    ; 
        $("#guinArea2ndListArea > a").removeClass("active-btn2")   ;
        $("#guinArea3rdListArea > a").removeClass("active-btn2")   ;
        $("#guinArea1st").val("");
        $("#guinArea2nd").val("");
        $("#guinArea3rd").val("");
        $("#gujikWork1st").val("");
        //$("#guinWork2nd").val("");

        var cell = document.getElementById("gujikWork2nd");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        document.getElementById("gujikWork2nd").innerHTML = '<option value="">2차 분류 선택</option>';

        //$('input:radio[name=guinAge]').filter('[value=unrelated]').prop('checked', true);
        $('input:radio[name=gujikAge]').prop('checked', false);
        $("#gujikPay").val("");
        //$("#guinPayIsUnrelated").();
        //$("#guinPayIsUnrelated").attr('checked', false);
        //$('input:radio[name=guinTime]').filter('[value=unrelated]').prop('checked', true);
        //$('input:radio[name=guinGender]').filter('[value=nothing]').prop('checked', true);
        $('input:radio[name=gujikTime]').prop('checked', false);
        $('input:radio[name=gujikGender]').prop('checked', false);
        $("#gujikCareer").val("");
        //$("#gujikCareerIsUnrelated").attr('checked', false);

        var cell = document.getElementById("gujikArea2ndListArea");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        var cell = document.getElementById("gujikArea3rdListArea");
    
        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        $("#gujikArea2ndListArea").hide();
        $("#gujikArea3rdListArea").hide();
    }

    function setGujikWork2nd() {
        var work_2nd = $("#gujikWork2nd option:selected").val();

        $("#HgujikWork2nd").val(work_2nd);
    } 

    function setGujikPay() {
        var gujikPay = $("#gujikPay option:selected").val();
        
        $("#HgujikPay").val(gujikPay);
    }

    function setGujikTime(time) {
        $("#HgujikTime").val(time);
    }

    function setGujikGender(sex) {
        $("#HgujikGender").val(sex);
    }

    function setGujikCareer() {
        var gujikCareer = $("#gujikCareer option:selected").val();

        $("#HgujikCareer").val(gujikCareer);
    }

    function setGujikAge(age) {
        $("#HgujikAge").val(age);
    }

    function closePopupNotToday(name, val, day) {
        var expire = new Date();

        expire.setDate(expire.getDate() + day);
        cookies = name + '=' + escape(val) + '; path=/ ';

        if(typeof day != "undefined") {
            cookies += '; expires=' + expire.toGMTString() + ';';
        }

        document.cookie = cookies;
        $("#myQRmodal").modal('hide');
    }

    $(document).ready(function() {
        var name = "QR" + '=';
        var cookieData = document.cookie;
        var start = cookieData.indexOf(name);
        var val = '';

        if(start != -1) {
            start += name.length;

            var end = cookieData.indexOf(';', start);

            if(end == -1) {
                end  = cookieData.length;
                val = cookieData.substring(start, end);
            }
        }

        if(!val) {
            $("#myQRmodal").modal('show');
        }
    });

    function itemCheck(no) {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/item/itemCheck.php',
            data: { no: no },
            success: function(data) {
                if(data.url == "") {
                  alert(data.message);
                    // if(confirm(data.message)) {
                    //     document.location.href = "itemShop/itemshop.php";
                    // }
                } else {
                    if(data.message == "") {
                        document.location.href = data.url;
                    } else {
                        if(confirm(data.message)) {
                            document.location.href = data.url;
                        }
                    }
                }
            }
        });
    }
</script>
<!-- Modal -->
<div id="myQRmodal" class="modal fade">
    <div class="modal-dialog" style="width: 670px; margin: 90px auto;">
        <a href="javascript:closeMainPopup();" class="fr mb10" data-dismiss="modal" aria-hidden="true">
            <img src="http://il-bang.com/pc_renewal/images/qrCodeX.png" alt="닫힘" />
        </a>
        <div class="qrModalWrap clear">
            <a href="https://play.google.com/store/apps/details?id=net.saltfactory.il_bang" class="bg_darkdarkgrey fff f12 fr qrModal">구글 스토어 웹으로 확인하기</a>
            <!-- <a href="https://itunes.apple.com/kr/app/ilbang/id1136479101?mt=8" class="bg_darkdarkgrey fff f12 fr qrModal">앱스토어웹으로 확인하기</a> -->
        </div>
        <a href="javascript:closePopupNotToday('QR', 'QR', 1)" style="font-size: 14px;">
            <div class="tr" style="width: 100%; background-color: #fff; padding: 15px;">오늘 하루 그만보기</div>
        </a>
    </div>
</div>
<!-- Modal END! -->
<div class="clear"></div>
<div class="container center wdfull bb pt5 pb5">
    <div class="pg_rp"> 
        <div class="c999 fl pl35">
            <span class="mr5 br15 subNotice">공지</span>
            <span id="adNotice"></span>
        </div>
        <!-- <div class="fr bold mr20">
            <span class="mr20">현재 <span id="guinIng2" class="fc"></span>명 구인중</span>
            <span>현재 <span id="gujikIng2" class="fc"></span>명 구직중</span>
        </div> -->
    </div>
</div>
<div class="clear"></div>    
</div>
<!-- 섹션1 -->
<!-- col-md-10 col-lg-10 -->
<div class="container center pl20 pr">
    <!-- 퀵배너 -->
    <!-- <div class="quick di pa" style="right:-200px;">
        <a href="ad/adMoney.php">
            <img src="images/quick.png" alt="" width="70%" class="hidden-xs hidden-md">
        </a>
    </div>  -->
    <!-- 퀵배너 -->
    <div class="sctInner1 oh mt20 mb35">
        <!-- 탭 -->
        <div class="count fl oh bg_darkgrey real_time_status mainBackground">
            <p class="tc mt40 mb20">
                <span class="real_time_top_txt f16">일방 실시간 현황</span>
            </p>
            <div class="countWrap mt10 tc">
                <ul class="oh noPadding di" style="width: 80%">
                    <li class="cnt1 fl real_time_circle mr5p">
                        <p class="real_time_txt tc">구직자</p>
                        <p class="real_time_num tc"><strong id="resumeCnt"></strong></p>   
                    </li>
                    <li class="cnt1 fl mr5p"><hr class="h10"></li>
                    <li class="cnt2 fl real_time_circle mr5p tc">
                        <p class="real_time_txt">채용 공고</p>
                        <p class="real_time_num tc"><strong id="employCnt"></strong></p>   
                    </li>
                    <li class="cnt2 fl mr5p"><hr class="h10"></li>
                    <li class="cnt3 fl real_time_circle">
                        <p class="real_time_txt tc">전체 매칭</p>
                        <p class="real_time_num tc"><strong id="totalMatching"></strong></p>   
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
            <p class="fr mt20 mr15 mb10 f13">&nbsp;
                <!-- <span class="fff mr10">현재 <span id="guinIng"></span>명 구인중</span>
                <span class="fff mr10">/</span>
                <span class="fff">현재 <span id="gujikIng"></span>명 구직중</span> -->
            </p>
        </div>
        <div class="iconNav iconNavC fl pt3">
            <div class="oh">
                <a href="service-intro.php" class="icon1 di fl pt9">
                    <img src="images/icon1.png" alt="서비스안내">
                    <p class="c777 mt3">서비스 안내</p>
                </a>
                <a href="pointmall/pointmall.php" class="icon2 di fl">
                    <img src="images/icon2.png" alt="친구보기">
                    <p class="c777 mt3">포인트몰</p>
                </a>
            </div>
            <div class="oh">
                <a href="ad/cooperation.php" class="icon3 di fl pt15">
                    <img src="images/icon36.png" class="ml10" alt="업무제휴">
                    <p class="c777 mt3">업무 제휴</p>
                </a>
                <a href="ad/adProposal.php" class="icon4 di fl">
                    <img src="images/icon6.png" alt="긴급구인">
                    <p class="c777 mt3">광고 신청</p>
                </a>
            </div>
            <div class="oh pt3">
                <a href="javascript:alert('준비중입니다.');" class="icon5 di fl pt15 bbn">
                    <img src="images/icon5.png" alt="아이템샵">
                    <p class="c777 mt3">아이템샵</p>
                </a>
                <a href="ad/adMoney.php" class="icon6 di fl">
                    <img src="images/icon4.png" alt="ad머니">
                    <p class="c777 mt3">AD머니</p>
                </a>
            </div>
        </div>
        <div class="tabWrap tabWrap1 fl loginTab">
            <?php if($uid == "") { ?>
            <ul class="nav nav-tabs" role="tablist" id="myTab">
                <li role="presentation" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 noPadding text-center active">
                    <a href="#topTab1" aria-controls="topTab1" role="tab" data-toggle="tab" class="no-border-left">기업 회원</a>
                </li>
                <li class="col-xs-4 col-sm-4 col-md-4 col-lg-4 noPadding text-center" role="presentation">
                    <a href="#topTab2" aria-controls="topTab2" role="tab" data-toggle="tab">일반 회원</a>
                </li>
                <li class="col-xs-4 col-sm-4 col-md-4 col-lg-4 noPadding text-center" role="presentation">
                    <a href="#topTab3" aria-controls="topTab3" role="tab" data-toggle="tab" class="no-border-right">지점</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- 첫번째 탭 내용 -->
                <!-- 로그인시 -->
                <div role="tabpanel" class="tab-pane active mt40 p10 mloginTab" id="topTab1">
                    <form action="log/memberCheck.php" method="post" onsubmit="return loginCheck(0)">
                        <input type="hidden" name="loginType" value="company" />
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <input type="hidden" name="url" value="<?php echo $url; ?>" />
                            <input type="text" class="loginInput mb2 pl5" id="company_id" name="user_id" />
                            <input type="password" class="loginInput pl5" id="company_passwd" name="user_passwd" />
                        </div>                
                        <input type="submit" class="btn btn-danger col-xs-4 col-sm-4 col-md-4 col-lg-4" style="height: 62px" value="로그인" />
                    </form>
                    <ul class="oh w100 f11 p15" style="padding-top: 25px;">
                        <li class="fl">
                            <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=1">아이디 찾기</a>
                            <span class="margin-horizontal">|</span>
                        </li>
                        <li class="fl">
                            <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=2">비밀번호 찾기</a>
                            <span class="margin-horizontal">|</span>
                        </li>
                        <li class="fl">
                            <a href="signup/step1.php">회원가입</a>
                        </li>
                    </ul>
                </div>
                <div class="clear"></div>          
                <!-- 두번째 탭 내용 -->
                <div role="tabpanel" class="tab-pane mt40 p10 mloginTab" id="topTab2">
                    <form action="log/memberCheck.php" method="post" onsubmit="return loginCheck(1)">
                        <input type="hidden" name="loginType" value="general" />
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <input type="hidden" name="url" value="<?php echo $url; ?>" />
                            <input type="text" class="loginInput mb2 pl5" id="general_id" name="user_id" />
                            <input type="password" class="loginInput pl5" id="general_passwd" name="user_passwd" />
                        </div>              
                        <input type="submit" class="btn btn-danger col-xs-4 col-sm-4 col-md-4 col-lg-4" style="height: 62px" value="로그인" />
                    </form>
                    <ul class="oh w100 f11 p15" style="padding-top: 25px;">
                        <li class="fl">
                            <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=1">아이디 찾기</a>
                            <span class="margin-horizontal">|</span>
                        </li>
                        <li class="fl">
                            <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=2">비밀번호 찾기</a>
                            <span class="margin-horizontal">|</span>
                        </li>
                        <li class="fl">
                            <a href="signup/step1.php">회원가입</a>
                        </li>
                    </ul>
                </div>
                <!-- 세번째 탭 내용 -->
                <div role="tabpanel" class="tab-pane mt40 p10 mloginTab" id="topTab3">
                    <form action="log/memberCheck.php" method="post" onsubmit="return loginCheck(2)">
                        <input type="hidden" name="loginType" value="jijeom" />
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                            <input type="hidden" name="url" value="<?php echo $url; ?>" />
                            <input type="text" class="loginInput mb2 pl5" id="jijeom_id" name="user_id" />
                            <input type="password" class="loginInput pl5" id="jijeom_passwd" name="user_passwd" />
                        </div>              
                        <input type="submit" class="btn btn-danger col-xs-4 col-sm-4 col-md-4 col-lg-4" style="height: 62px" value="로그인" />
                    </form>
                    <ul class="oh w100 f11 p15" style="padding-top: 25px;">
                        <li class="fl">
                            <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=1">아이디 찾기</a>
                            <span class="margin-horizontal">|</span>
                        </li>
                        <li class="fl">
                            <a href="http://il-bang.com/pc_renewal/signup/pwidFind.php?tab=2">비밀번호 찾기</a>
                            <span class="margin-horizontal">|</span>
                        </li>
                        <li class="fl">
                            <a href="signup/step1.php">회원가입</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php } else { ?>
            <div class="logoutWrap" id="logoutWrap">
                <div class="w100 tc">
                    <script>
                        <?php if($kind=="general") { ?>
                        function getImage() {
                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                url: 'ajax/gujik/getProfileImage.php',
                                success: function(data) {
                                    var img_url=data.logoData.img_url;
                                    
                                    if(img_url != null) {
                                        var company_logo= document.getElementById("mainImage");

                                        company_logo.src="http://il-bang.com/pc_renewal/gujikImage/"+img_url;
                                        company_logo.style.borderRadius = "50%";
                                    }
                                }
                            });
                        }
                        <?php } else { ?>
                        function getImage() {
                            $.ajax({
                                type: 'post',
                                dataType: 'json',
                                url: 'ajax/guin/getLogoImage.php',
                                success: function(data) {
                                    var img_url=data.logoData.img_url;
                                    
                                    if(img_url != null) {
                                        var company_logo= document.getElementById("mainImage");

                                        company_logo.src="http://il-bang.com/pc_renewal/guinImage/"+img_url;
                                        document.getElementById("logoutWrap").style.marginTop = "26px";
                                    }
                                }
                            });
                        }
                        <?php } ?>
                        
                        getImage();
                    </script>
                    <img src="images/loginProfile.png" alt="" id="mainImage" class="mr15">
                </div>
                <div class="tc">
                    <div class="di mr20 tc di">
                        <strong><?php echo $uid; ?>님</strong>
                    </div>                
                    <a href="log/logout.php" class="logoutBtn tc border-grey di" style="height: 30px; margin-top: 16px">로그아웃</a>
                </div> 
                <hr style="margin:20px 0 0">  
                <div class="w100 oh tc mt5 padding-vertical">
                    <a class="mainLogout bold" href="ad/adProposal.php">광고 신청</a>
                    <span class="margin-horizontal">|</span>
                    <span id="index_guinCheck2">
                        <a class="mainLogout bold" href="javascript: alert('준비중 입니다.');">긴급 구인</a>
                    </span>
                    <span class="margin-horizontal">|</span>
                    <?php if($kind == "general") { ?>
                    <a class="mainLogout bold" href="my-page/myInfo-general.php">마이 페이지</a>
                    <?php } else { ?>
                    <a class="mainLogout bold" href="my-page/myInfo-comp.php">마이 페이지</a>
                    <?php } ?>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <script>
            function loginCheck(val) {
                if(val == 0) {
                    var id = document.getElementById("company_id").value;
                    var pwd = document.getElementById("company_passwd").value;
                } else if(val == 1) {
                    var id = document.getElementById("general_id").value;
                    var pwd = document.getElementById("general_passwd").value;
                } else if(val == 2) {
                    var id = document.getElementById("jijeom_id").value;
                    var pwd = document.getElementById("jijeom_passwd").value;
                }

                if(id == "") {
                    alert("아이디를 입력해주세요.");
                    return false;
                } else if(pwd == "") {
                    alert("비밀번호를 입력해주세요.");
                    return false;
                }

                return true;
            }
        </script>
        <h5 class="mb10">
            <img src="images/search-icon.png" alt="">
            <b>일자리 구하기 / 사람 구하기 상세 검색 <small>상세 검색으로 보다 빠르게 찾으실 수 있습니다.</small></b>
        </h5>
        <div class="sctInner2">
            <div>
                <ul class="nav nav-tabs border-grey" role="tablist" id="myTab">
                    <li role="presentation" class="guingujikTab noPadding col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center active f16 bold">
                        <a class="di" href="#botTab1" aria-controls="botTab1" role="tab" data-toggle="tab">일자리 구하기</a>
                    </li>
                    <li role="presentation" class="guingujikTab noPadding col-xs-6 col-sm-6 col-md-6 col-lg-6 text-center f16 bold">
                        <a class="di" href="#botTab2" aria-controls="botTab2" role="tab" data-toggle="tab">사람 구하기</a>
                    </li>
                </ul>
                <!-- 구인정보 탭 내용 -->
                <div class="tab-content" class="height: 168px;">
                    <div role="tabpanel" class="tab-pane active" id="botTab1">
                        <ul class="noPadding w100 oh mt30 mb0 border-top-ilbang">
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si10000" href="javascript:setGuinArea1st('10000')">전국</a> <!-- javascript:setGuinArea1st('10000')-->
                            </li>                  
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si1" href="javascript:setGuinArea1st('1')">서울</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si907" href="javascript:setGuinArea1st('907')">인천</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si1164" href="javascript:setGuinArea1st('1164')">광주</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si1420" href="javascript:setGuinArea1st('1420')">대전</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si1631" href="javascript:setGuinArea1st('1631')">대구</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si1923" href="javascript:setGuinArea1st('1923')">부산</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si2314" href="javascript:setGuinArea1st('2314')">울산</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si2422" href="javascript:setGuinArea1st('2422')">경기</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si3312" href="javascript:setGuinArea1st('3312')">강원</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si3641" href="javascript:setGuinArea1st('3641')">충남</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si3950" href="javascript:setGuinArea1st('3950')">충북</a>
                            </li>
                            <li class="border local guin_local fl text-center">
                                <a class="di w100 padding-vertical" id="si4219" href="javascript:setGuinArea1st('4219')">전남</a>
                            </li>
                            <li class="border local guin_local fl text-center" id="si4687">
                                <a class="di w100 padding-vertical" href="javascript:setGuinArea1st('4687')">전북</a>
                            </li>
                            <li class="border local guin_local fl text-center" id="si5128">
                                <a class="di w100 padding-vertical" href="javascript:setGuinArea1st('5128')">경남</a>
                            </li>
                            <li class="border local guin_local fl text-center" id="si5709">
                                <a class="di w100 padding-vertical" href="javascript:setGuinArea1st('5709')">경북</a>
                            </li>
                            <li class="border local guin_local fl text-center" id="si7700">
                                <a class="di w100 padding-vertical" href="javascript:setGuinArea1st('7700')">세종</a>
                            </li>
                            <li class="border local guin_local fl text-center border-right-ilbang" id="si6296">
                                <a class="di w100 padding-vertical" href="javascript:setGuinArea1st('6296')">제주</a>
                            </li>
                        </ul>
                        <ul class="guinLocal1 padding oh border-grey noMargin" id="guinArea2ndListArea"></ul>
                        <ul class="guinLocal2 padding oh border-grey" id="guinArea3rdListArea"></ul>
                        <!-- 폼 영역 -->
                        <form class="form-horizontal bg_grey f_grey padding oh border-grey" id="guinSearchForm" name="guinSearchForm" method="GET" action="./gujik.php">
                            <input type="hidden" name="guinArea1st" id="guinArea1st" value="">
                            <input type="hidden" name="guinArea2nd" id="guinArea2nd" value="">
                            <input type="hidden" name="guinArea3rd" id="guinArea3rd" value="">
                            <input type="hidden" name="HguinPage"              id="HguinPage"              value="<?php echo $page?>">
                            <input type="hidden" name="HguinOnePage"           id="HguinOnePage"           value="">
                            <input type="hidden" name="HguinArea1st"           id="HguinArea1st"           value="">
                            <input type="hidden" name="HguinArea2nd"           id="HguinArea2nd"           value="">
                            <input type="hidden" name="HguinArea3rd"           id="HguinArea3rd"           value="">
                            <input type="hidden" name="HguinWork1st"           id="HguinWork1st"           value="">
                            <input type="hidden" name="HguinWork2nd"           id="HguinWork2nd"           value="">
                            <input type="hidden" name="HguinAge"               id="HguinAge"               value="">
                            <input type="hidden" name="HguinPay"               id="HguinPay"               value="">
                            <!--<input type="hidden" name="HguinPayIsUnrelated"    id="HguinPayIsUnrelated"    value="">-->
                            <input type="hidden" name="HguinTime"              id="HguinTime"              value="">
                            <input type="hidden" name="HguinGender"            id="HguinGender"            value="">
                            <input type="hidden" name="HguinCareer"            id="HguinCareer"            value="">
                            <!-- 1 -->
                            <div class="form-group guin-form padding mt30">
                                <label for="inputEmail3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">업직종</label>
                                <div class="col-sm-10">
                                    <select name="guinWork1st" onchange="getGuinWork2ndList()" id="guinWork1st" class="form-control fl" style="width:20%">
                                        <option value="">1차분류 선택</option>
                                    </select>
                                    <span class="fl vm di f16 arrow-right margin-horizontal mt4"><b>></b></span>
                                    <select name="guinWork2nd" id="guinWork2nd" onchange="setGuinWork2nd()" class="form-control fl" style="width:20%">
                                        <option value="">2차분류 선택</option>
                                    </select>
                                </div>
                            </div>
                            <!-- 2 -->
                            <div class="form-group guin-form padding">
                                <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">연령대</label>
                                <div class="col-sm-10 lh12">
                                    <div class="radio fl">
                                        <label>
                                            <input type="radio" name="guinAge" value="10" onclick="setGuinAge('10')"><span class="ml5">10대</span>
                                        </label>
                                    </div>
                                    <div class="radio fl">
                                        <label class="ml15">
                                            <input type="radio" name="guinAge" value="20" onclick="setGuinAge('20')"><span class="ml5">20대</span>
                                        </label>
                                    </div>
                                    <div class="radio fl">
                                        <label class="ml15">
                                            <input type="radio" name="guinAge" value="30" onclick="setGuinAge('30')"><span class="ml5">30대</span>
                                        </label>
                                    </div>
                                    <div class="radio fl">
                                        <label class="ml15">
                                            <input type="radio" name="guinAge" value="40" onclick="setGuinAge('40')"><span class="ml5">40대</span>
                                        </label>
                                    </div>
                                    <div class="radio fl">
                                        <label class="ml15">
                                            <input type="radio" name="guinAge" value="50" onclick="setGuinAge('50')"><span class="ml5">50대</span>
                                        </label>
                                    </div>
                                    <div class="radio fl">
                                        <label class="ml15">
                                            <input type="radio" name="guinAge" value="60" onclick="setGuinAge('60')"><span class="ml5">60대</span>
                                        </label>
                                    </div>
                                    <div class="radio fl">
                                        <label class="ml15">
                                            <input type="radio" name="guinAge" value="70" onclick="setGuinAge('70')"><span class="ml5">70대</span>
                                        </label>
                                    </div>
                                    <div class="radio fl">
                                        <label class="ml15">
                                            <input type="radio" name="guinAge" value="80" onclick="setGuinAge('80')"><span class="ml5">80대</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group guin-form padding">
                                <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">급여 조건</label>
                                <div class="col-sm-10">
                                    <select name="guinPay" id="guinPay" onchange="setGuinPay()" class="form-control fl" style="width:20%">
                                        <option value="">일당</option>
                                        <option value="0">0</option>
                                        <option value="50000">50,000</option>
                                        <option value="100000">100,000</option>
                                        <option value="150000">150,000</option>
                                        <option value="200000">200,000</option>
                                        <option value="250000">250,000</option>
                                        <option value="300000">300,000</option>
                                        <option value="350000">350,000</option>
                                        <option value="350000">350,000</option>
                                        <option value="400000">400,000</option>
                                        <option value="450000">450,000</option>
                                        <option value="500000">500,000</option>
                                    </select>
                                    <div class="checkbox fl ml15"></div>
                                </div>
                            </div>
                            <div class="form-group guin-form padding">
                                <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">근무 시간</label>
                                <div class="col-sm-10 lh12">
                                    <div class="radio fl">
                                        <label>
                                            <input type="radio" name="guinTime" value="1" onclick="setGuinTime('1')"><span class="ml5">오전</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="2" onclick="setGuinTime('2')"><span class="ml5">오후</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="3" onclick="setGuinTime('3')"><span class="ml5">저녁</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="4" onclick="setGuinTime('4')"><span class="ml5">새벽</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="5" onclick="setGuinTime('5')"><span class="ml5">오전 ~ 오후</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="6" onclick="setGuinTime('6')"><span class="ml5">오후 ~ 저녁</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="7" onclick="setGuinTime('7')"><span class="ml5">저녁 ~ 새벽</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="8" onclick="setGuinTime('8')"><span class="ml5">새벽 ~ 오전</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="9" onclick="setGuinTime('9')"><span class="ml5">종일</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinTime" value="10" onclick="setGuinTime('10')"><span class="ml5">무관/협의</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group guin-form padding">
                                <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">성별</label>
                                <div class="col-sm-10 lh12">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="guinGender" value="nothing" onclick="setGuinGender('nothing')"><span class="ml5">무관</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinGender" value="man" onclick="setGuinGender('man')"><span class="ml5">남자</span>
                                        </label>
                                        <label class="ml15">
                                            <input type="radio" name="guinGender" value="woman" onclick="setGuinGender('woman')"><span class="ml5">여자</span>
                                        </label>                            
                                    </div>
                                </div>
                            </div>
                            <div class="form-group guin-form padding">
                                <label for="inputEmail3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">경력</label>
                                <div class="col-sm-10">
                                    <select name="guinCareer" id="guinCareer" onchange="setGuinCareer()" class="form-control fl" style="width:20%">
                                        <option value="">필요 경력</option>
                                        <option value="0">신입</option>
                                        <option value="1">1년 미만</option>
                                        <option value="3">3년 미만</option>
                                        <option value="5">5년 미만</option>
                                        <option value="6">5년 이상</option>
                                    </select>
                                    <div class="checkbox fl ml15">
                                </div>
                            </div>
                        </div>
                        <div class="formBtnWrap">
                            <ul class="pager">
                                <li><a class="f14 bg_navy border-navy fff" href="javascript:guinSearch()">검색</a></li>
                                <li><a class="white-btn f14 border-navy" style="color: #545975;" href="javascript:guinClear()">초기화</a></li>
                            </ul>
                        </div>  
                    </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="botTab2">
                    <ul class="noPadding w100 oh mt30 border-top-ilbang mb0">
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('10000')">전국</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('1')">서울</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('907')">인천</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('1164')">광주</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('1420')">대전</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('1631')">대구</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('1923')">부산</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('2314')">울산</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('2422')">경기</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('3312')">강원</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('3641')">충남</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('3950')">충북</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('4219')">전남</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('4687')">전북</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('5128')">경남</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('5709')">경북</a>
                        </li>
                        <li class="border local gujik_local fl text-center">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('7700')">세종</a>
                        </li>
                        <li class="border local gujik_local fl text-center border-right-ilbang">
                            <a class="di w100 padding-vertical" href="javascript:setGujikArea1st('6296')">제주</a>
                        </li>
                    </ul>
                    <ul class="gujikLocal1 padding oh border-grey noMargin" id="gujikArea2ndListArea"></ul>
                    <ul class="gujikLocal2 padding oh border-grey" id="gujikArea3rdListArea"></ul>
                    <!-- 폼 영역-->
                    <form class="form-horizontal bg_grey f_grey padding oh border-grey" id="gujikSearchForm" name="gujikSearchForm" method="get" action="./guin.php">
                        <input type="hidden" name="HgujikPage"             id="HgujikPage"              value="<?php echo $page?>">
                        <input type="hidden" name="HgujikOnePage"          id="HgujikOnePage"           value="<?php echo $onePage?>">
                        <input type="hidden" name="HgujikArea1st"          id="HgujikArea1st"           value="">
                        <input type="hidden" name="HgujikArea2nd"          id="HgujikArea2nd"           value="">
                        <input type="hidden" name="HgujikArea3rd"          id="HgujikArea3rd"           value="">
                        <input type="hidden" name="HgujikWork1st"          id="HgujikWork1st"           value="">
                        <input type="hidden" name="HgujikWork2nd"           id="HgujikWork2nd"           value="">
                        <input type="hidden" name="HgujikAge"               id="HgujikAge"               value="">
                        <input type="hidden" name="HgujikPay"               id="HgujikPay"               value="">
                        <input type="hidden" name="HgujikTime"              id="HgujikTime"              value="">
                        <input type="hidden" name="HgujikGender"            id="HgujikGender"            value="">
                        <input type="hidden" name="HgujikCareer"            id="HgujikCareer"            value="">
                        <!-- 1 -->
                        <div class="form-group gujik-form mt30 padding">
                            <label for="inputEmail3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">업직종</label>
                            <div class="col-sm-10">
                                <select name="gujikWork1st" id="gujikWork1st" onchange="getGujikWork2ndList()" class="form-control fl" style="width:20%">
                                    <option value="">1차 분류 선택</option>
                                </select>
                                <span class="fl vm di f16 arrow-right margin-horizontal mt4"><b> > </b></span>
                                <select name="gujikWork2nd" id="gujikWork2nd" onchange="setGujikWork2nd()" class="form-control fl" style="width:20%">
                                    <option value="">2차 분류 선택</option>
                                </select>
                            </div>
                        </div>
                        <!-- 2 -->
                        <div class="form-group gujik-form padding">
                            <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">연령대</label>
                            <div class="col-sm-10 lh12">
                                <div class="radio fl">
                                    <label>
                                        <input type="radio" name="gujikAge" value="10" onclick="setGujikAge('10')" ><span class="ml5">10대</span>
                                    </label>
                                </div>
                                <div class="radio fl">
                                    <label class="ml15">
                                        <input type="radio" name="gujikAge" value="20" onclick="setGujikAge('20')"><span class="ml5">20대</span>
                                    </label>
                                </div>
                                <div class="radio fl">
                                    <label class="ml15">
                                        <input type="radio" name="gujikAge" value="30" onclick="setGujikAge('30')"><span class="ml5">30대</span>
                                    </label>
                                </div>
                                <div class="radio fl">
                                    <label class="ml15">
                                        <input type="radio" name="gujikAge" value="40" onclick="setGujikAge('40')"><span class="ml5">40대</span>
                                    </label>
                                </div>
                                <div class="radio fl">
                                    <label class="ml15">
                                        <input type="radio" name="gujikAge" value="50" onclick="setGujikAge('50')"><span class="ml5">50대</span>
                                    </label>
                                </div>
                                <div class="radio fl">
                                    <label class="ml15">
                                        <input type="radio" name="gujikAge" value="60" onclick="setGujikAge('60')"><span class="ml5">60대</span>
                                    </label>
                                </div>
                                <div class="radio fl">
                                    <label class="ml15">
                                        <input type="radio" name="gujikAge" value="70" onclick="setGujikAge('70')"><span class="ml5">70대</span>
                                    </label>
                                </div>
                                <div class="radio fl">
                                    <label class="ml15">
                                        <input type="radio" name="gujikAge" value="80" onclick="setGujikAge('80')"><span class="ml5">80대</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group gujik-form padding">
                            <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">급여 조건</label>
                            <div class="col-sm-10">
                                <select name="gujikPay" id="gujikPay" onchange="setGujikPay()" class="form-control fl" style="width:20%">
                                    <option value="">일당</option>
                                    <option value="0">0</option>
                                    <option value="50000">50,000</option>
                                    <option value="100000">100,000</option>
                                    <option value="150000">150,000</option>
                                    <option value="200000">200,000</option>
                                    <option value="250000">250,000</option>
                                    <option value="300000">300,000</option>
                                    <option value="350000">350,000</option>
                                    <option value="350000">350,000</option>
                                    <option value="400000">400,000</option>
                                    <option value="450000">450,000</option>
                                    <option value="500000">500,000</option>
                                </select>
                                <div class="checkbox fl ml15"></div>
                            </div>
                        </div>
                        <div class="form-group gujik-form padding">
                            <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">근무 시간</label>
                            <div class="col-sm-10 lh12">
                                <div class="radio fl">
                                    <label>
                                        <input type="radio" name="gujikTime" value="1" onclick="setGujikTime('1')"><span class="ml5">오전</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="2" onclick="setGujikTime('2')"><span class="ml5">오후</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="3" onclick="setGujikTime('3')"><span class="ml5">저녁</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="4" onclick="setGujikTime('4')"><span class="ml5">새벽</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="5" onclick="setGujikTime('5')"><span class="ml5">오전 ~ 오후</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="6" onclick="setGujikTime('6')"><span class="ml5">오후 ~ 저녁</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="7" onclick="setGujikTime('7')"><span class="ml5">저녁 ~ 새벽</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="8" onclick="setGujikTime('8')"><span class="ml5">새벽 ~ 오전</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="9" onclick="setGujikTime('9')"><span class="ml5">종일</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikTime" value="10" onclick="setGujikTime('10')"><span class="ml5">무관/협의</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group gujik-form padding">
                            <label for="inputPassword3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">성별</label>
                            <div class="col-sm-10 lh12">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="gujikGender" value="male" onclick="setGujikGender('male')"><span class="ml5">남자</span>
                                    </label>
                                    <label class="ml15">
                                        <input type="radio" name="gujikGender" value="female" onclick="setGujikGender('female')"><span class="ml5">여자</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group gujik-form padding">
                            <label for="inputEmail3" class="col-xs-1 col-sm-1 col-md-1 col-lg-1 control-label tl">경력</label>
                            <div class="col-sm-10">
                                <select name="gujikCareer" id="gujikCareer" onchange="setGujikCareer()" class="form-control fl" style="width:20%">
                                    <option value="">필요 경력</option>
                                    <option value="0">신입</option>
                                    <option value="1">1년 미만</option>
                                    <option value="3">3년 미만</option>
                                    <option value="5">5년 미만</option>
                                    <option value="6">5년 이상</option>
                                </select>
                                <div class="checkbox fl ml15"></div>
                            </div>
                        </div>
                        <div class="formBtnWrap">
                            <ul class="pager">
                                <li><a class="f14 bg_navy border-navy fff" href="javascript:gujikSearch()">검색</a></li>
                                <li><a class="wwhite-btn f14 border-navy" style="color: #545975;" href="javascript:gujikClear()">초기화</a></li>
                            </ul>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
<!-- 배너 스와이퍼 -->
<div class="container-fluid bg_darkgrey mt50 vm mb35" style="height: 50px;">
    <div class="midBanner center mt10"> 
        <div class="tc">
            <img class="di center" src="images/mainLogo1.png" alt="">
        </div>
        <div class="tc">
            <img class="di center" src="images/mainLogo2.png" alt="">  
        </div>
        <div class="tc">
            <img class="di center" src="images/mainLogo3.png" alt="">  
        </div>
        <div class="tc">
            <img class="di center" src="images/mainLogo4.png" alt="">  
        </div>
        <div class="tc">
            <img class="di center" src="images/mainLogo5.png" alt="">  
        </div>
        <div class="tc">
            <img class="di center" src="images/mainLogo6.png" alt="">  
        </div>
        <div class="tc">
            <img class="di center" src="images/mainLogo7.png" alt="">  
        </div>
        <div class="tc">
            <img class="di center" src="images/mainLogo8.png" alt="">  
        </div>
    </div>
</div>    
<script>
    $(document).ready(function(){
        $('.midBanner').slick({
            slidesToShow: 5,
            slidesToScroll: 2,
            autoplay: true,
            autoplaySpeed: 2000,
            centerMode: true,
        });
    });
</script>
<!-- 섹션2 -->
<!-- <div class="container center pl20">    
    <h5 class="fl bold mb10">
        <img src="images/search-icon.png" alt="">긴급 구인
    </h5>
    <p class="fr f12">* 신청시 바로 매칭 서비스를 받으실 수 있습니다.
        <span id="index_guinCheck3">
            <a href="javascript:alert('준비중 입니다.');" class="border-grey bg_white p5 f11 ml5 br2">긴급 구인 신청하기</a>
            <a href="javascript:alert('준비중입니다.');" class="border-grey bg_white p5 f11 ml5 br2" onclick="indexGuinCheck2(1); return false;">긴급 구인 신청하기</a>
        </span>
    </p>
    <div class="clear"></div>
    <div class="urgentWrap mb10" id="emergencyGuinListArea1"></div>
    <div class="guinWrap" id="emergencyGuinListArea2"></div>
</div> -->
<!-- 섹션3 -->
<div class="container center pl20 mt30 mb35">      
    <h5 class="fl bold mb10">
        <img src="images/search-icon.png" alt="">일반 구인
    </h5>
    <p class="fr f12">* 다양한 상품을 사용해 보세요.
        <button type="button" class="border-grey bg_white p5 f11 ml5 br2" onclick="alert('준비중 입니다.');">아이템샵 가기</button>
    </p><div class="clear"></div>
    <div class="normalWrap" id="generalGuinListArea"></div>
</div>  
<!-- 일반 구직 -->
<div class="container-fluid bg_f8">
    <div class="container center pl20 mb50 pt35">
        <h5 class="fl bold">
            <img src="images/search-icon.png" alt="">일반 구직
        </h5>
        <p class="fr f12">* 다양한 상품을 사용해 보세요.
            <a href="javascript:alert('준비중 입니다.');" class="border-grey bg_white p5 f11 ml5 br2">아이템샵 가기</a>
        </p>
        <div class="clear"></div>
        <div class="normalWrap oh generalGujikListWrap" id="generalGujikListArea"></div>
    </div>
</div>
<script>
    // 구인
    $(".guin_local a").each(function(i){
        $(this).click(function(){
            $(".guinLocal2").hide()
            $(".guin_local a").removeClass("active-btn");
            $(this).addClass("active-btn");
            $(".guinLocal1").show();
        });
    });

    $(".guinLocal1").each(function(){
        $(".guinLocal1").click(function(){
              $(".guinLocal2").css('display','block');
        });
    });

    $(".guinLocal2").each(function(i){
        $(this).click(function(){      
        });
    });
        
    $(document).on('click','.guinLocal1 a',function(){
        $(".guinLocal1 a").removeClass("active-btn2");
        $(this).addClass("active-btn2");
    });
    
    $(document).on('click','.guinLocal2 a',function(){
        $(".guinLocal2 a").removeClass("active-btn2");
        $(this).addClass("active-btn2");
    });

    // 구직
    $(".gujik_local a").each(function(i){
        $(this).click(function(){
            $(".gujikLocal2").hide()
            $(".gujik_local a").removeClass("active-btn");
            $(this).addClass("active-btn");
            $(".gujikLocal1").show();
        });
    });

    $(".gujikLocal1").each(function(){
        $(".gujikLocal1").click(function(){
            $(".gujikLocal2").css('display','block');
        });
    });

    $(".gujikLocal2").each(function(i){
        $(this).click(function(){
        });
    });
      
    $(document).on('click','.gujikLocal1 a',function(){
        $(".gujikLocal1 a").removeClass("active-btn2");
        $(this).addClass("active-btn2");
    });

    $(document).on('click','.gujikLocal2 a',function(){
        $(".gujikLocal2 a").removeClass("active-btn2");
        $(this).addClass("active-btn2");
    });
       
    $(document).ready(function() {
        /* quick menu */
        $(".quick").animate( { "top": $(document).scrollTop() + 20 +"px" }, 500 ); // 빼도 된다.
        
        $(window).scroll(function() {
            $(".quick").stop();
            $(".quick").animate( { "top": $(document).scrollTop() + 20 + "px" }, 500 );
        });
    });
</script>
<?php include_once "include/footer.php" ?>