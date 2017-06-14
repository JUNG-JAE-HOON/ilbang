<script>
    $(document).ready(function() {
        getMatchingCompleList(1, 10);
    });

    function getMatchingCompleList(page, onePage) {
        var uid = '<?php echo $uid?>';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: './ajax/gujik/getMatchingCompleList.php',
            data: {uid:uid,page:page,onePage:onePage},
            success: function (data) {
                var cell = document.getElementById("matchingCompleListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("matchingCompleListArea").innerHTML
                +=  '<ul class="bg_darkgrey guinInfoTlt oh noPadding bb ">'
                +       '<li class="guinInfoLi1 tc fl">회사 위치</li>'
                +       '<li class="guinInfoLi2 tc fl">채용 내용</li>'
                +       '<li class="guinInfoLi3 fl tc">근무 조건</li>'
                +       '<li class="guinInfoLi4 fl tc">등록일</li>'
                +   '</ul>';

                for (var i=0; i<data.listData.length; i++ ){
                    document.getElementById("matchingCompleListArea").innerHTML
                    += '<ul class="oh noPadding guinInfoList bb pdt6">'
                    +   '<li class="guinInfoLi1 lh87 fl"><div class="bold">'+data.listData[i].area_1st_nm+' '+data.listData[i].area_2nd_nm+'</div></li>'
                    +   '<li class="guinInfoLi2 fl">'
                    +   '<h5>'+data.listData[i].title+'</h5>'
                    +   '<div class="margin-vertical info2Cont">'
                    +       '<span class="ilbangBadge"><b>'+data.listData[i].work_2nd_nm+'</b></span>'
                    +       '<span class="di text-cut guinDesc margin-verti ml5">'+data.listData[i].business+'</span>'
                    +   '</div>'
                    +   '<div>'
                    +       '<span>'+data.listData[i].career+'</span>'
                    +       '<span class="margin-horizontal"></span>'   
                    +       '<span class="border-grey payBedge mr5 f_navy bold">일당</span>'  
                    +       '<span class="bold f_navy">'+data.listData[i].pay+'원</span>'    
                    +   '</div>'
                    +   '</li>'
                    +   '<li class="guinInfoLi3 lh25 fl">'
                    +   '<p>' + data.listData[i].sex + '</p>'
                    +   '<p>' + data.listData[i].career + '</p>'
                    +   '<p>' + data.listData[i].time + '</p>'
                    +   '</li>'
                    +   '<li class="guinInfoLi4 fl tc">'
                    +   '<p class="lh25 mb10">'+data.listData[i].wdate+'</p>'   
                    +       '<a href="gujik/employReview.php?employNo='+data.listData[i].work_employ_data_no+'"  class="direct sm-btn sm-btn3" >평가하기</a>'
                    +   '</p>'
                    +   '<p>'
                    +       '<a href="javascript:void(0)" class="viewEsti sm-btn sm-btn2">평가보기</a>'
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
<div class="container mt30">
    <div>
        <h4 class="fl f16 mb10">매칭 완료 리스트</h4>
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
                </select>
            </div>
        </div>
    </div>
    <div class="bt2 oh w100 guinInfo" id="matchingCompleListArea"></div>
    <div class="container center tc pb5">
        <ul class="pagination" id="matchingComplePagingArea"></ul>
    </div>
</div>