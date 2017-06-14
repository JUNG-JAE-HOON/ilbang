<script>
    $(document).ready(function() {
        var uid = "<?php echo $uid; ?>";

        if(uid == "") {  // 로그인 안한상태
            $("#insertCnt").text(0);
            $("#enableCnt").text(0);
            $("#myReviewCnt").text(0);
            $("#matchingCnt").text(0);
        } else {        // 로그인 한 상태
            getMyGuinCounter();
            getMyGuinList(1);
            getLogoImage();
        }
    });

    function getMyGuinCounter(){
        var uid = "<?php echo $uid; ?>";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getMyGuinCounter.php',
            data: { uid: uid },
            success: function (data) {
                $("#insertCnt").text(data.listData[0].insertCnt);
                $("#enableCnt").text(3); //data.listData[0].enableCnt
                $("#myReviewCnt").text(data.listData[0].myReviewCnt);
                $("#matchingCnt").text(data.listData[0].matchingCnt);
            }
        });
    }

    function getMyGuinList(page) {
         var uid = "<?php echo $uid; ?>";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/getMyGuinList.php',
            data: { page: page, uid:uid },
            success: function (data) {        
                var cell = document.getElementById("myGuinListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("myGuinListArea").innerHTML
                += '<ul class="bg_darkgrey guinInfoTlt oh noPadding bb tc">'
                +  '<li class="guinInfoLi1 fl">등록일</li>'
                +  '<li class="guinInfoLi2 fl">채용 제목</li>'
                +  '<li class="guinInfoLi3 fl">채용 관리</li>'
                +  '<li class="guinInfoLi4 fl">'
                +  '<p>매칭 건수</p>'
                +  '</li>'
                +  '</ul>';

                for (var i=0; i<data.listData.length; i++) {
                    if(data.listData[i].work_2nd_nm == '') {
                        data.listData[i].work_2nd_nm = '일방';
                    }
                    
                    document.getElementById("myGuinListArea").innerHTML
                    += '<ul class="oh noPadding guinInfoList bb pdt6 tc lh1">'
                    +  '    <li class="guinInfoLi1 fl">'
                    +  '      <div class="gujikLitable">'
                    +  '        <div class="f16 bold mb10">' + data.listData[i].delegate + '</div>'
                    +  '        <div class="ml10">' + data.listData[i].wdate + '</div>'
                    +  '      </div>'
                    +  '    </li>'
                    +  '    <li class="guinInfoLi2 fl tl">'
                    +  '        <h5>[' + data.listData[i].company + '] <span class="bold">' + data.listData[i].title + '</span></h5>'
                    +  '        <div class="margin-vertical info2Cont">'
                    +  '            <div class="fl bold f11 ilbangBadge">' + data.listData[i].work_2nd_nm + '</div>'
                    +  '            <div class="di text-cut guinDesc margin-verti ml5" style="margin-top: 1px;">' + data.listData[i].business + '</div>'
                    +  '        </div>'
                    +  '        <div>'
                    +  '            <span>' + data.listData[i].career + '</span>'   
                    // +  '            <span class="margin-horizontal">12.6km</span>'  
                    +  '            <span class="border-grey payBedge mr5 f_navy bold">일당</span>'   
                    +  '            <span class="bold f_navy">' + data.listData[i].pay + '원</span>' 
                    +  '        </div>'
                    +  '    </li>'
                    +  '    <li class="guinInfoLi3 lh25 fl">'
                    +  '        <a class="modiBtn mr5 f14" href="guin/view/tab2.php?tab=2&employNo=' + data.listData[i].no + '">보기</a>'
                    +  '        <a class="modiBtn mr5 f14" href="guin/form/modify.php?no=' + data.listData[i].no + '">수정</a>'
                    +  '        <a class="deleteBtn f14" href="javascript:delMyEmploy(' + data.listData[i].no + ', ' + page + ')">삭제</a>'
                    +  '    </li>'
                    +  '    <li class="guinInfoLi4 fl tc">'
                    +  '        <span class="f14"><b class="underline fc countSmall">' + data.listData[i].matchingCnt + '</b>건</span>'
                    +  '    </li>'
                    +  '</ul>';
                }

                var cell = document.getElementById("myGuinListPagingArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("myGuinListPagingArea").innerHTML = data.paging;
            }                        
        });
    }

    function delMyEmploy(no, page) {
        if(confirm("정말 삭제하시겠습니까?")) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'ajax/guin/deleteGuin.php',
                data: { no: no },
                success: function(data) {
                    alert(data);
                    getMyGuinCounter();
                    getMyGuinList(page);
                }
            })
        }
    }

    function getLogoImage() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/guin/getLogoImage.php',
            success: function(data) {
                var img_url=data.logoData.img_url;

                if(img_url != null) {
                    var company_logo= document.getElementById("company_logo");
                    company_logo.src="http://il-bang.com/pc_renewal/guinImage/"+img_url;
                }
            }
        });
    }

    function imageUpLoad() {
        var id = "<?php echo $uid; ?>";
        var type = "<?php echo $kind; ?>";

        if(id == "") {
            alert("로그인 후 이용해주세요.");
        } else {
            if(type == "general") {
                alert("기업 회원만 이용할 수 있습니다.");
            } else {
                var formData = new FormData();

                for(var i=0; i<$('#ex_file')[0].files.length; i++){
                    formData.append('upload', $('#ex_file')[0].files[i]);
                }
                
                $.ajax({
                    url: 'ajax/guin/uploadGuinImage.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data) {
                        if( data.logoData.image != null ){
                            var company_logo= document.getElementById("company_logo");

                            company_logo.src="http://il-bang.com/pc_renewal/guinImage/"+data.logoData.image;
                        }
                        
                        alert(data.logoData.message);
                    }
                });
            }
        }
    }
</script>
<div class="container pr30">
    <div class="mt30">
        <h4 class="di f16 mb10">나의 채용 공고</h4>
        <small class="ml5 f12 f_grey">채용 공고를 작성 및 관리 하실 수 있습니다.</small>
        <p class="fr f12 mt10">여러 개의 채용 공고를 작성하고 싶을 때!
            <a href="itemShop/itemshop.php" class="sm-btn sm-btn2 f12 ml5">상품 구매</a>
        </p>
    </div>
    <div class="sec2TopArea oh border-navy w100">
        <div class="topInner1 w20 fl bg_navy tc">
            <img src="http://il-bang.com/pc_renewal/images/144x38.png" id="company_logo"  class="w144 mt50" />
            <div class="filebox mt30">
                <label for="ex_file" class="mb0">찾아보기</label> 
                <input type="file" id="ex_file" onchange="imageUpLoad()"> 
                <!-- <a href="javascript:imageUpLoad();" class="f_white imgChangeBtn2">프로필 사진 변경</a> -->
                <p class="f10 imgUploadTxt mt10">※ 144x38 png 파일만 업로드 가능합니다.</p>
            </div>
        </div>
        <div class="topInner2 border-right w20 fl tc f12">
            <p class="mt30 mb5 f14">등록된 채용 공고 수</p>
            <span class="di w10 short-bar"></span>
            <h4 class="mt20"><span id="insertCnt"></span>개</h4>                        
            <div style="margin-top:25px" id="guinCheck2">
                <a href="javascript:guinCheck(1);" class="underline f12">채용 공고 등록</a>
                <span class="margin-horizontal">|</span>
                <a href="javascript:guinCheck(1);" class="underline f12">긴급 구인 등록</a>
            </div>
        </div>
        <div class="topInner3 w20 fl tc f12 border-right">
            <p class="mt30 mb5 f14">등록할 수 있는 횟수</p>
            <span class="di w10 short-bar"></span>
            <h4 class="mt20"><span id="enableCnt"></span>개</h4>
            <a href="itemShop/itemshop.php" class="mt20 mb20 di underline tl f12">- 아이템을 구입하시면 더 많은<br>채용 공고 작성이 가능합니다.</a>
        </div>
        <div class="topInner4 w20 fl tc f12 border-right">
            <p class="mt30 mb5 f14">나의 평가</p>
            <span class="di w10 short-bar"></span>
            <h4 class="mt20"><span id="myReviewCnt"></span>개</h4>
            <div style="margin-top:22px">
                <!-- <a href="" class="f12 underline">평가보기 ></a> -->
            </div>
        </div>
        <div class="topInner5 w20 fl tc f12 bg_grey">
            <p class="mt30 mb5 f14">현재 매칭 건수</p>
            <span class="di w10 short-bar"></span>
            <h4 class="mt20"><span id="matchingCnt"></span>건</h4>
        </div>
    </div>
    <h4 class="mt30 f16 mb10">채용 공고 관리
        <p class="fr f10 mb10" id="guinCheck3">
            <a href="#" class="formWriteBtn f12 f_white" onclick="guinCheck(1); return false;">채용 공고 작성</a>
        </p>
    </h4>
</div>
<div class="bt2 oh w100 guinInfo" id="myGuinListArea"></div>
<div class="container center tc pb5">
    <ul class="pagination" id="myGuinListPagingArea"></ul>
</div>
            
