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
            getFrofileImage();
        }
    });

    function getMyGuinCounter(){
        var uid = "<?php echo $uid; ?>";

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/gujik/getMyGujikCounter.php',
            data: { uid: uid },
            success: function (data) {
                $("#insertCnt").text(data.listData[0].insertCnt);
                $("#enableCnt").text(data.listData[0].enableCnt);
                $("#myReviewCnt").text(data.listData[0].myReviewCnt);
                $("#matchingCnt").text(data.listData[0].matchingCnt);
            }
        });
    }

    function getMyGuinList(page) {    
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/gujik/getMyGujikList.php',
            data: { page: page },
            success: function (data) {                          
                var cell = document.getElementById("myGujikListArea");

                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }

                document.getElementById("myGujikListArea").innerHTML
                += '<ul class="bg_darkgrey guinInfoTlt oh noPadding bb tc">'
                +  '<li class="guinInfoLi1 fl">등록일 / 공개 여부</li>'
                +  '<li class="guinInfoLi2 fl">이력서 제목</li>'
                +  '<li class="guinInfoLi3 fl">이력서 관리</li>'
                +  '<li class="guinInfoLi4 fl">매칭 건수</li>'
                +  '</ul>';

                for (var i=0; i<data.listData.length; i++) {
                    if(data.listData[i].work_2nd_nm == '') {
                        data.listData[i].work_2nd_nm = '일방';
                    }
                    
                    document.getElementById("myGujikListArea").innerHTML
                    += '<ul class="oh noPadding guinInfoList bb pdt6">'
                    +  '    <li class="guinInfoLi1 fl tc">'
                    +  '      <div class="gujikLitable">'
                    +  '        <div class="f16 bold mb5">' + data.listData[i].delegate + '</div>'
                    +  '        <div class="ml10 mr5">'+data.listData[i].wdate+'</div>'
                    +  '      </div>'
                    +  '    </li>'
                    +  '    <li class="guinInfoLi2 fl">'
                    +  '        <h5><span class="bold">' + data.listData[i].title + '</span></h5>'
                    +  '        <div class="margin-vertical info2Cont">'
                    +  '            <div class="fl bold f11 ilbangBadge">' + data.listData[i].work_2nd_nm + '</div>'
                    +  '            <span class="di text-cut guinDesc margin-verti ml5">희망 지역 : '+ data.listData[i].area_1st_nm + ' > ' +data.listData[i].area_2nd_nm + '</span>'
                    +  '        </div>'
                    +  '        <div>'
                    +  '            <span>경력 : ' + data.listData[i].career + '</span>'
                    +  '            <span class="border-grey payBedge mr5 f_navy bold">일당</span>'   
                    +  '            <span class="bold f_navy">' + data.listData[i].pay + '원</span>' 
                    +  '        </div>'
                    +  '    </li>'
                    +  '    <li class="guinInfoLi3 lh25 fl tc">'
                    +  '        <a class="modiBtn mr5 f14" href="gujik/form/modify.php?no=' + data.listData[i].no + '">수정</a>'
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
                url: 'ajax/gujik/deleteGujik.php',
                data: { no: no },
                success: function(data) {
                    alert(data);
                    getMyGuinCounter();
                    getMyGuinList(page);
                }
            })
        }
    }

    function getFrofileImage() {
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: 'ajax/gujik/getProfileImage.php',
            success: function(data) {
                var img_url=data.logoData.img_url;

                if(img_url != null) {
                    var company_logo= document.getElementById("profile_img");

                    company_logo.src="http://il-bang.com/pc_renewal/gujikImage/"+img_url;
                }
            }
        });
    }

    function imageUpLoad() {
        var id = "<?php echo $uid; ?>";

        if(id == "") {
            alert("로그인 후 이용해주세요.");
        } else {
            var formData = new FormData();

            if($('#ex_file')[0].files.length != 0) {
                for(var i=0; i<$('#ex_file')[0].files.length; i++) {
                    formData.append('upload', $('#ex_file')[0].files[i]);
                }

                $.ajax({
                    url: 'ajax/gujik/uploadGujikImage.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data) {
                        if(data.logoData.image != null) {
                            var profile= document.getElementById("profile_img");

                            profile.src="http://il-bang.com/pc_renewal/gujikImage/" + data.logoData.image;
                        }

                        alert(data.logoData.message);
                    }
                });
            } else {
                alert("취소 되었습니다.");
            }
        }
    }
</script>
<div class="container pr30">
    <div class="mt30">
        <h4 class="di f16 mb10">나의 이력서</h4>
        <small class="ml5 f12 f_grey">이력서를 작성 및 관리 하실 수 있습니다.</small>
        <p class="fr f12 mt10">여러 개의 이력서를 작성하고 싶을 때!
            <a href="itemShop/itemshop.php" class="sm-btn sm-btn2 f12 ml5">상품 구매</a>
        </p>
    </div>
    <div class="sec2TopArea oh border-navy w100">
        <div class="topInner1 w20 fl bg_navy tc">
            <img src="http://il-bang.com/pc_renewal/images/86x86.png" alt="" id="profile_img" name="profile_img" class="img-circle br50 wh100" />
            <div class="filebox mt10">
                <label for="ex_file" class="mb0">파일 선택</label> 
                <input type="file" id="ex_file" onchange="imageUpLoad()"> 
                <!-- <button onclick="imageUpLoad()" class="imgChangeBtn">프로필 사진 변경</button> -->
                <p class="f10 imgUploadTxt mt10">※ 100x100 png 파일만 업로드 가능합니다.</p>
            </div>
        </div>
        <div class="topInner2 border-right w20 fl tc f12">
            <p class="mt30 mb5 f14">등록된 이력서 수</p>
            <span class="di w10 short-bar"></span>
            <h4 class="mt20"><span id="insertCnt"></span>개</h4>
            <a href="javascript:applicationCheck(0)" class="mt30 di underline f12">이력서 작성 ></a>
        </div>
        <div class="topInner3 w20 fl tc f12 border-right">
            <p class="mt30 mb5 f14">등록할 수 있는 횟수</p>
            <span class="di w10 short-bar"></span>
            <h4 class="mt20"><span id="enableCnt"></span>개</h4>
            <a href="itemShop/itemshop.php" class="mt20 mb20 di underline tc f12">- 아이템을 구입하시면 더 많은<br>이력서 작성이 가능합니다.</a>
        </div>
        <div class="topInner4 w20 fl tc f12 border-right">
            <p class="mt30 mb5 f14">나의 평가</p>
            <span class="di w10 short-bar"></span>
            <h4 class="mt20"><span id="myReviewCnt"></span>개</h4>
            <!-- <a href="#" class="mt30 di underline f12">나의 평가보기</a> -->
        </div>
        <div class="topInner5 w20 fl tc f12 bg_grey">
            <p class="mt30 mb5 f14">현재 매칭 건수</p>
            <span class="di w10 short-bar"></span>
            <h4 class="mt20"><span id="matchingCnt">0</span>건</h4> 
        </div>
    </div>
    <h4 class="mt30 f16 mb10">이력서 관리
        <p class="fr f10 mb10">
            <a href="javascript:applicationCheck(0)" class="formWriteBtn f12 f_white">이력서 작성</a>
        </p>
    </h4>
    <div class="bt2 oh w100 guinInfo">
        <div id="myGujikListArea"></div>
    </div> 
    <div class="container center tc pb5">
        <ul class="pagination" id="myGuinListPagingArea"></ul>
    </div> 
</div>