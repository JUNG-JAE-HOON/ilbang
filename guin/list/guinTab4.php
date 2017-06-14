<script>
    $(document).ready(function() {
        getMatchingCompleList(1, 10);
    });

    function getMatchingCompleList(page, onePage) {
        var uid = '<?php echo $uid?>';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/guin/getMatchingCompleList.php',
            data: { uid: uid, page: page, onePage: onePage },
            success: function(data) {
                var cell = document.getElementById("matchingCompleListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("matchingCompleListArea").innerHTML
                +=  '<ul class="bg_darkgrey guinInfoTlt oh noPadding bb">'
                +       '<li class="guinInfoLi1 tc fl">이름</li>'
                +       '<li class="guinInfoLi2 tc fl">이력서 정보</li>'
                +       '<li class="guinInfoLi3 fl">경력 / 희망 근무 시간</li>'
                +       '<li class="guinInfoLi4 fl"> <p class="tc">등록일</p> </li>'
                +   '</ul>';

                for (var i=0; i<data.listData.length; i++) {
                    document.getElementById("matchingCompleListArea").innerHTML
                    += '<ul class="oh noPadding guinInfoList bb pdt6">'
                    +   '<li class="guinInfoLi1 lh87 fl"><b class="ml10">'+data.listData[i].name+' ('+data.listData[i].sex+','+data.listData[i].age+'세)</b></li>'
                    +   '<li class="guinInfoLi2 fl">'
                    +   '<h5 class="cp" onclick=location.href="./guin/view/tab4.php?resumeNo='+data.listData[i].resumeNo+'&tab=4">'+data.listData[i].title+'</h5>'
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
                    +   '<p class="mb10">'
                    +       '<a href="./guin/view/tab4.php?resumeNo='+data.listData[i].resumeNo+'&tab=4" class="direct sm-btn sm-btn3 f12">열람하기</a>'
                    +   '</p>'
                    +   '<p>'
                    +       '<a href="./guin/resumeReview.php?resumeNo='+data.listData[i].resumeNo+'" class="viewEsti sm-btn sm-btn2 f12">평가보기</a>'
                    +   '</p>'
                    +   '</li>'
                    +   '</ul>';
                }

                var cell = document.getElementById("matchingComplePagingArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("matchingComplePagingArea").innerHTML = data.paging;

                $("#tab4OnePage").val(data.onePage);
            }
        });
    }

    function setTab4OnePage() {
        var onePage = $("#tab4OnePage option:selected").val();
        var page = 1;

        getMatchingCompleList(page, onePage);
    }
</script>
<div class="container mt30 pr30">
    <div class="oh">
        <h4 class="fl f16 mb10">매칭 완료 리스트</h4>
        <div class="form-group oh noMargin">
            <div class="fr">
                <select name="tab4OnePage" id="tab4OnePage" onchange="setTab4OnePage()" class="smallSelect">
                    <option value="10">10개씩</option>
                    <option value="20">20개씩</option>
                    <option value="30">30개씩</option>
                    <option value="40">40개씩</option>
                    <option value="50">50개씩</option>
                </select>
            </div>
        </div>
    </div>
    <div class="bt2 oh w100 guinInfo" id="matchingCompleListArea"></div>
    <div class="container center tc pb5">
        <ul class="pagination" id="matchingComplePagingArea"></ul>
    </div>
</div>