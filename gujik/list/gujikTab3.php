<script>
    $(document).ready(function() {
        getMatchingList(1,10);
        // getEmergencyList();
    });

    function getEmergencyList() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/gujik/getEmergencyList.php',
            success: function (data) {
                document.getElementById("emergencyList").innerHTML+='<div class="urgentWrap oh w100">';

                for (var i=0; i<data.listData.length; i++ ){
                    if(i == 4) {
                        document.getElementById("emergencyList").innerHTML
                        += '</div>'
                        + '<div class="urgentWrap">';
                    }

                    if(data.listData[i].img_url == null) data.listData[i].img_url = "http://il-bang.com/pc_renewal/images/144x38.png";
                    else                                 data.listData[i].img_url = 'http://il-bang.com/pc_renewal/guinImage/' + data.listData[i].img_url ;
                    
                    document.getElementById("emergencyList").innerHTML
                    += '    <div class="di urgentList2 pr mt10" align="center">'
                    +      '<a class="di pa plusIcon glyphicon glyphicon-plus f25 bold fc"'
                    +      'href="http://il-bang.com/pc_renewal/guin/view/tab1.php?employNo='+data.listData[i].no+'" align="center"></a>'
                    +      '<p class="mt30"><img src="'+data.listData[i].img_url+'" alt=""></p> '
                    +      '<div align="left" class="col-md-offset-1 col-lg-offset-1">'
                    +      '<h5 class="f_grey">'+data.listData[i].company+'</h5>'
                    +      '<p>특성별<span>></span>'+data.listData[i].work_2nd_nm+'</p>'
                    +      '<p><b>지역</b>:'+data.listData[i].area_1st_nm+'<span>></span>'+data.listData[i].area_2nd_nm+'</p>'
                    +      '<p><b><span class="fc">'+data.listData[i].pay+'</span>원</b> '
                    +      '</div>'
                    // +      '<span class="fr dist">1.23km</span></p>'
                    +      '</div>'
                    +      '';
                }
                
                document.getElementById("emergencyList").innerHTML += '</div>';
            }
        });
    }

    function getMatchingList(page, onePage) {
        var uid = '<?php echo $uid?>';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/gujik/getMatchingList.php',
            data: {uid:uid,page:page,onePage:onePage},
            success: function (data) {
                var cell = document.getElementById("matchingListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("matchingListArea").innerHTML
                +=  '<ul class="bg_darkgrey guinInfoTlt oh noPadding bb">'
                +       '<li class="guinInfoLi1 tc fl">회사 위치</li>'
                +       '<li class="guinInfoLi2 tc fl">채용 내용</li>'
                +       '<li class="guinInfoLi3 fl tc">근무 조건</li>'
                +       '<li class="guinInfoLi4 fl tc">등록일</li>'
                +   '</ul>';

                for (var i=0; i<data.listData.length; i++ ){ 
                    document.getElementById("matchingListArea").innerHTML
                    += '<ul class="oh noPadding guinInfoList bb pdt6">'
                    +   '<li class="guinInfoLi1 lh87 fl"><div class="bold">'+data.listData[i].area_1st_nm+' '+data.listData[i].area_2nd_nm+'</div></li>'
                    +   '<li class="guinInfoLi2 fl">'
                    +   '<h5>'+data.listData[i].title+'</h5>'
                    +   '<div class="margin-vertical info2Cont">'
                    +       '<span class="ilbangBadge"><b>'+data.listData[i].work_2nd_nm+'</b></span>'
                    +       '<span class="di text-cut guinDesc margin-verti ml5">'+data.listData[i].business+'</span>'
                    +   '</div>'
                    +   '<div>'
                    +       '<span>' + data.listData[i].career + '</span>'
                    +       '<span class="margin-horizontal"></span>'   
                    +       '<span class="border-grey payBedge mr5 f_navy bold">일당</span>'  
                    +       '<span class="bold f_navy">' + data.listData[i].pay + '원</span>'    
                    +   '</div>'
                    +   '</li>'
                    +   '<li class="guinInfoLi3 lh25 fl">'
                    +   '<p>' + data.listData[i].sex + '</p>'
                    +   '<p>' + data.listData[i].career + '</p>'
                    +   '<p>' + data.listData[i].time + '</p>'
                    +   '</li>'
                    +   '<li class="guinInfoLi4 fl tc">'
                    +   '<p class="lh25 mb10">'+data.listData[i].wdate+'</p>'   
                    +       '<a href="gujik/view/tab3.php?eno='+data.listData[i].work_employ_data_no+'"  class="direct sm-btn sm-btn3" >즉시 지원</a>'
                    +   '</p>'
                    +   '<p>'
                    +       '<a href="javascript:void(0)" class="viewEsti sm-btn sm-btn2">평가보기</a>'
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
    
    function setTab3OnePage() {
        var onePage = $("#tab3OnePage option:selected").val();
        var page = 1;

        getMatchingList(page, onePage);
    }
</script>
<div class="container mt30">
    <!-- <h4 class="fl f16 noMargin">긴급 채용 정보</h4>
    <p class="fr f12 noMargin">* 신청시 바로 매칭 서비스를 받으실 수 있습니다.
        <a href="javascript:alert('준비중 입니다.')" class="sm-btn sm-btn2 f12 ml10">상품 구매</a>
    </p>
    <div id="emergencyList"> </div> -->
    <div class="container">
        <div>
            <h4 class="fl f16 mb10">채용 정보</h4>
            <div class="form-group oh noMargin">
                <div class="fr">
                    <select name="sortCount1" id="sortCount1" class="smallSelect">
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="35">35</option>
                    </select>
                    <select name="sortStandard1" id="sortStandard1" class="smallSelect">
                        <option value="20">최신순</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="35">35</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="bt2 oh w100 guinInfo" id="matchingListArea"></div>
        <div class="container center tc pb5">
            <ul class="pagination" id="matchingPagingArea"></ul>
        </div>
    </div>
</div>