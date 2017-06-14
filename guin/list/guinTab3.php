<script>
    $(document).ready(function() {
        getMatchingList(1, 10);
        getNewGujikList();
    });

    function getNewGujikList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/guin/getNewGujikList.php',
            success: function(data) {
                var cell = document.getElementById("newGujikListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                for (var i=0; i<data.listData.length; i++) {
                    if(data.listData[i].img_url == null) {
                        if(data.listData[i].sex=="male"){
                            data.listData[i].img_url = "images/71x71-m.png";
                        }else if(data.listData[i].sex=="female"){
                            data.listData[i].img_url = "images/71x71-f.png";
                        }else{
                            data.listData[i].img_url = "images/71x71-q.png";
                        }
                    } else {
                        data.listData[i].img_url = 'gujikImage/' + data.listData[i].img_url;
                    }

                    document.getElementById("newGujikListArea").innerHTML
                    += '<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 border-grey h125p">'
                    // +      '<a class="di pa plusIcon-grey plusIconPadding f23 bold f_grey" href="./guin/view/guinTab1.php?resumeNo='+data.listData[i].no+'" align="center" onfocus=this.blur();></a>'
                    +      '<a class="di pa plusIcon-grey plusIconPadding f23 bold f_grey" href="javascript:itemCheck(' + data.listData[i].no + ')" align="center" onfocus=this.blur();></a>'
                    +      '<div style="padding:15px 24px 0 10px">'
                    +      '<img class="profileImg fl wh71 mr15" src=' + data.listData[i].img_url + ' alt="">'
                    +      '<div class="fl">'
                    // +      '<h5 class="f_grey f13 gujikText-overflow cp" onclick=location.href="./guin/view/guinTab1.php?resumeNo='+data.listData[i].no+'">'+data.listData[i].title+'</h5>'
                    +      '<h5 class="f_grey f13 gujikText-overflow cp" onclick="itemCheck(' + data.listData[i].no + ')">' + data.listData[i].title + '</h5>'
                    +      '<p class="f12">' + data.listData[i].work_1st_nm + '<span> > </span>' + data.listData[i].work_2nd_nm + '</p>'
                    +      '<p class="f12"><b>지역</b> : ' + data.listData[i].area_1st_nm + '<span> > </span>' + data.listData[i].area_2nd_nm + ' ' + data.listData[i].area_3rd_nm + '</p>'
                    +      '</div>'
                    +      '</div>'
                    +      '<div class="clear pt10 pl10 pr24">'
                    +      '<span class="ilbangBadge mr10">' + data.listData[i].work_2nd_nm + '</span>'
                    +      '<span class="pr10 border-right"> ' +data.listData[i].career + '</span>'
                    +      '<span class="ml10">' + data.listData[i].time + ' 근무 희망</span> '
                    +      '<span class="fr"><b class="fc">**,***</b>원</span>'
                    +      '</div>'
                    +      '</div>';
                }
            }
        });
    }
    
     function setTab3OnePage(){
        var onePage = $("#tab3OnePage option:selected").val();
        var page = 1;

        getMatchingList(page, onePage);
      }


    function getMatchingList(page, onePage){
        var uid = '<?php echo $uid?>';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: './ajax/guin/getMatchingList.php',
            data: {uid:uid,page:page,onePage:onePage},
            success: function (data) {
                var cell = document.getElementById("matchingListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("matchingListArea").innerHTML
                +=  '<ul class="bg_darkgrey guinInfoTlt oh noPadding bb">'
                +       '<li class="guinInfoLi1 tc fl">이름</li>'
                +       '<li class="guinInfoLi2 tc fl">이력서 정보</li>'
                +       '<li class="guinInfoLi3 fl">경력 / 희망 근무 시간</li>'
                +       '<li class="guinInfoLi4 fl"><p class="tc">등록일</p></li>'
                +   '</ul>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("matchingListArea").innerHTML
                    += '<ul class="oh noPadding guinInfoList bb pdt6">'
                    +   '<li class="guinInfoLi1 lh87 fl"><b class="ml10">'+data.listData[i].name+' ('+data.listData[i].sex+','+data.listData[i].age+'대)</b></li>'
                    +   '<li class="guinInfoLi2 fl">'
                    +   '<h5>'+data.listData[i].title+'</h5>'
                    +   '<div class="margin-vertical info2Cont">'
                    +       '<span class="ilbangBadge"><b>'+data.listData[i].work_2nd_nm+'</b></span>'
                    +       '<span class="di text-cut guinDesc margin-verti ml5">'+data.listData[i].content+'</span>'
                    +   '</div>'
                    +   '<div>'
                    +       '<span>'+data.listData[i].career+'</span>'
                    +       '<span class="margin-horizontal"></span>'   
                    +       '<span class="border-grey payBedge mr5 f_navy bold">일당</span>'  
                    +       '<span class="bold f_navy">'+data.listData[i].pay+'원</span>'    
                    +   '</div>'
                    +   '</li>'
                    +   '<li class="guinInfoLi3 lh25 fl">'
                    +   '<p>'+data.listData[i].career+'</p>'
                    +   '<p>'+data.listData[i].time+'</p>'
                    +   '</li>'
                    +   '<li class="guinInfoLi4 fl tc">'
                    +   '<p class="lh25 mb10">'+data.listData[i].wdate+'</p>'   
                    +   '<p><form action="guin/accept.php" method="POST">'
                    +   '<input type="hidden" name="eno" value="'+data.listData[i].work_employ_data_no+'">'
                    +   '<input type="hidden" name="rno" value="'+data.listData[i].work_resume_data_no+'">'  
                    +       '<input type="submit"  class="direct sm-btn sm-btn3 f12" value="열람하기"></a>'
                    +   '</form></p>'
                    +   '<p>'
                    +       '<a href="./guin/resumeReview.php?resumeNo='+data.listData[i].resumeNo+'" class="viewEsti sm-btn sm-btn2 f12">평가보기</a>'
                    +   '</p>'
                    +   '</li>'
                    +   '</ul>';
                }

                var cell = document.getElementById("matchingPagingArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("matchingPagingArea").innerHTML = data.paging;

                $("#tab3OnePage").val(data.onePage);
            }
        });
    }

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
<div class="container mt30 pr30">
    <h4 class="fl f16 mb10">최신 이력서 정보</h4>
    <p class="fr f12 mt10">* 신청시 바로 매칭 서비스를 받으실 수 있습니다.
        <a href="itemShop/itemshop.php" class="sm-btn sm-btn2 f12 ml10">상품 구매</a>
    </p>           
    <div class="normalWrap oh w100" id="newGujikListArea"></div>  
</div>
<div class="container mt30 pr30">
    <div class="oh">
        <h4 class="fl f16 mb10">매칭 리스트</h4>
        <div class="form-group oh noMargin">
            <div class="fr">
                <select name="tab3OnePage" id="tab3OnePage" onchange="setTab3OnePage()" class="smallSelect">
                    <option value="10">10개씩</option>
                    <option value="20">20개씩</option>
                    <option value="30">30개씩</option>
                    <option value="40">40개씩</option>
                    <option value="50">50개씩</option>
                </select>
            </div>
        </div>
    </div>
    <div class="bt2 oh w100 guinInfo" id="matchingListArea"></div>
    <div class="container center tc pb5" >
        <ul class="pagination" id="matchingPagingArea"></ul>
    </div>
</div>