<?php include_once "../../include/header.php"; ?>
<?
?>
<script>

 $( document ).ready(function() {

	var onePage               = '<?php echo $_GET["HguinOnePage"];?>';
	var guinArea1st           = '<?php echo $_GET["HguinArea1st"];?>';
	var guinArea2nd           = '<?php echo $_GET["HguinArea2nd"];?>';
	var guinArea3rd           = '<?php echo $_GET["HguinArea3rd"];?>';
	var guinWork1st           = '<?php echo $_GET["HguinWork1st"];?>';
	var guinWork2nd           = '<?php echo $_GET["HguinWork2nd"];?>';
	var guinAge               = '<?php echo $_GET["HguinAge"];?>';
	var guinPay               = '<?php echo $_GET["HguinPay"];?>';
	//var guinPayIsUnrelated    = '<?php echo $_GET["HguinPayIsUnrelated"];?>';
	var guinTime              = '<?php echo $_GET["HguinTime"];?>';
	var guinGender            = '<?php echo $_GET["HguinGender"];?>';
	var guinCareer            = '<?php echo $_GET["HguinCareer"];?>';
	//var guinCareerIsUnrelated = '<?php echo $_GET["HguinCareerIsUnrelated"];?>';



	$("#HguinArea1st"           ).val(guinArea1st);
	$("#HguinArea2nd"           ).val(guinArea2nd);     
	$("#HguinArea3rd"           ).val(guinArea3rd);        
	$("#HguinWork1st"           ).val(guinWork1st);        
	$("#HguinWork2nd"           ).val(guinWork2nd);   
	$("#HguinAge"               ).val(guinAge);       
	$("#HguinPay"               ).val(guinPay);            
	//$("#HguinPayIsUnrelated"    ).val(guinPayIsUnrelated); 
	$("#HguinTime"              ).val(guinTime);  
	$("#HguinGender"            ).val(guinGender);
	$("#HguinCareer"            ).val(guinCareer); 


	getGuinCounter();

	getViewGuinTab4Data();
 })


 function getViewGuinTab4Data(){
 	
 	var resumeNo	= '<?php echo $resumeNo ?>';
 	var uid			= '<?php echo $uid ?>';
    $.ajax({
             type: 'post',
             dataType: 'json',
             url: '../../ajax/guin/getViewGuinTab4Data.php',
             data: {resumeNo:resumeNo, uid:uid},
             success: function (data) {
             	//alert(JSON.stringify(data));

             	for(var i=0; i<data.resumeData.length; i++){
             		//alert(data.resumeData[i].name);
             		//alert(data.resumeData[i].img_url);

             		if(data.resumeData[i].img_url == null || data.resumeData[i].img_url == ''){
             			$("#imgUrl"	).attr("src", "../../images/profile.png" );
             		} else {
             			$("#imgUrl"	).attr("src", "../../gujikImage/" + data.resumeData[i].img_url );
             		}

             		$("#title"		).text(data.resumeData[i].title);
             		$("#name"		).text(data.resumeData[i].name);
             		$("#address"	).text(data.resumeData[i].area_1st_nm + ' ' + data.resumeData[i].area_2nd_nm + ' ' + data.resumeData[i].area_3rd_nm);
             		$("#hopeAddress").text(data.resumeData[i].area_1st_nm + ' ' + data.resumeData[i].area_2nd_nm + ' ' + data.resumeData[i].area_3rd_nm);
             		$("#work_2nd_nm").text(data.resumeData[i].work_2nd_nm );
             		$("#sex"		).text(data.resumeData[i].sex );
             		$("#age"		).text(data.resumeData[i].age );
             		$("#career"		).text(data.resumeData[i].career );
             		$("#obstacle"	).text(data.resumeData[i].obstacle );
             		$("#email"		).text(data.resumeData[i].email );
             		$("#phone"		).text(data.resumeData[i].phone );
             		$("#time"		).text(data.resumeData[i].time );
             		$("#pay"		).text(data.resumeData[i].pay );
             		$("#content"	).text(data.resumeData[i].content );
             		$("#birthday"	).text(data.resumeData[i].birthday );

             		$("#reviewLink"	).attr("href","../resumeReview.php?resumeNo="+resumeNo+"");
             		
             		
             		

             	}

                var cell = document.getElementById("workDate");
                while (cell.hasChildNodes()){
                    cell.removeChild(cell.firstChild);
                }
             	//$("#workDate")
             	for(var i=0; i<data.workDateList.length; i++){
             		document.getElementById("workDate").innerHTML
             		+= '<input name="workDate" class="vm mr5 ml10" type="checkbox" value="'+data.workDateList[i].work_join_list_no+'"/>'+data.workDateList[i].work_date;
             	}
            }
     })
 }

 function getGuinCounter(){
    $.ajax({
             type: 'post',
             dataType: 'json',
             url: '../../ajax/getGuinCounter.php',
             data: {},
             success: function (data) {
               new numberCounter("newEmploy"    , data.listData[0].newEmploy);
               new numberCounter("allEmploy"    , data.listData[0].allEmploy);
               new numberCounter("newMatching"  , data.listData[0].newMatching);
               new numberCounter("allMatching"  , data.listData[0].allMatching);
            }
     })
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

	function goPage(addr,tab){
	  $("#tab").val(tab);
  	  $("#viewForm").attr("action", addr);
      document.getElementById("viewForm").submit();
	}    

	function cancelApproval(){
		var work_join_list_no_arr = [];		 	
	  	$("input[name=workDate]:checked").each(function() {
			work_join_list_no_arr.push($(this).val());
		});

		if (work_join_list_no_arr.length == 0){
			alert("승인 취소할 근무일자를 선택해주세요.");
			return ;
		}

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: '../../ajax/guin/cancelApproval.php',
			data: {work_join_list_no_arr:work_join_list_no_arr},
			success: function (data) {
		 	
		 		if(data.result == "1")
		 		{
		 			alert(data.msg);
		 			getViewGuinTab4Data();
		 		}
			}
			
		})

	}
</script>
  <form method="get" id="viewForm">

	         <input type="hidden" name="tab"                 id="tab"              value="">
            <input type="hidden" name="HguinPage"              id="HguinPage"              value="<?php echo $page?>">
            <input type="hidden" name="HguinOnePage"           id="HguinOnePage"           value="<?php echo $onePage?>">
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
       </form>
<div class="wdfull">
    <div class="container center wdfull bb mb15">
        <div class="pg_rp"> 
            <div class="c999 fl subTitle">
                <a href="index.php" class="c999">HOME</a>
                <span class="plr5">&gt;</span>
                <a href="gujik.php" class="bold">구인자</a>
            </div>
            <div class="c999 fr padding-vertical">
                <span class="mr5 br15 subNotice">공지</span>
                <span id="adNotice">(주)MMC피플의 연말인사</span>
            </div>
        </div>
    </div>
</div>
<div class="container pl20">		
	<!-- 상단 카운트 영역 -->
    <div class="guingujikTabWrap fl pr">
       <div class="quick pa" style="left: -145px;">  
          <p class="di">
            <!-- 내 정보 -->
            <a href="my-page/myInfo-comp.php">
              <img src="http://il-bang.com/pc_renewal/images/ggQuick1.png" alt="" class="db"> 
            </a> 

            <a href="guin.php?tab=2"">
              <img src="http://il-bang.com/pc_renewal/images/ggQuick2.png" alt="" class="db"> 
            </a>
            <a href="javascript:alert('준비중입니다.');">
              <img src="http://il-bang.com/pc_renewal/images/ggQuick3.png" alt="" class="db"> 
            </a>
          </p>   
      </div>
	</div>
<script>
   	/* quick menu */
    $(".quick").animate( { "top": $(document).scrollTop() + 0 +"px" }, 500 ); // 빼도 된다.
     $(window).scroll(function(){
      $(".quick").stop();
      if($(document).scrollTop()==0){
      $(".quick").animate( { "top": $(document).scrollTop() + 0  + "px" }, 500 );
    }else{
      $(".quick").animate( { "top": $(document).scrollTop() + -50 + "px" }, 500 );
    }
     });
</script>			
			<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 oh">
				<a href="" class="linkImg di w100" style="height: 105px;"></a>
			</div>
			<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 border-grey border-box gujikTopBox oh">
				<div class="gujikCount padding-vertical count1 fl tc padding-vertical; margin-vertical">
					<h4 class="margin-vertical"><span id="newEmploy"></span>건</h4>
					<p class="margin-vertical">신규신청서</p>	
				</div>
				<div class="gujikCount padding-vertical count2 fl tc padding-vertical; margin-vertical">
					<h4 class="margin-vertical"><span id="allEmploy"></span>건</h4>
					<p class="margin-vertical">전체 신청서</p>	
				</div>
				<div class="gujikCount padding-vertical count3 fl tc padding-vertical; margin-vertical">
					<h4 class="margin-vertical"><span id="newMatching"></span>건</h4>
					<p class="margin-vertical">신규매칭</p>	
				</div>
				<div class="gujikCount padding-vertical count4 fl tc padding-vertical; margin-vertical">
					<h4 class="margin-vertical"><span id="allMatching"></span>건</h4>
					<p class="margin-vertical">전체매칭</p>	
				</div>
				<a href="#" class="gujikCount count5 fl tc f14" style="background-color: black">
				<span class="glyphicon glyphicon-plus f22 fff"></span>
					<p class="margin-vertical fff">채용공고 작성</p>
				</a>
			</div>
		
	
</div>
<div class="wdfull">	
	<div class="guingujikTabWrap">
	  <ul class="nav nav-tabs mt10" role="tablist" id="myTab">
	    <li role="presentation" class="noPadding guingujikTabLi text-center active"><a href="javascript:goPage('../../guin.php',1)" >전체</a></li>
	    <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="javascript:goPage('../../guin.php',2)" >나의 이력서</a></li>
	    <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="javascript:goPage('../../guin.php',3)" >매칭리스트</a></li>
	    <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="#gujikTab4" aria-controls="gujikTab4" role="tab" data-toggle="tab">매칭완료</a></li>
	  </ul>
	  <div class="tab-content">
	  <!-- 첫번째 탭 내용 -->
	    <div role="tabpanel" class="tab-pane active mt10" id="gujikTab1">
	    </div>
	    <!-- 두번째 탭 내용 -->
	    <div role="tabpanel" class="tab-pane mt10" id="gujikTab2">
	    </div>
	    <div role="tabpanel" class="tab-pane mt10" id="gujikTab3">
	    </div>
	    <div role="tabpanel" class="tab-pane mt10 container pl20" id="gujikTab4">
	        <div class="gujikDetSect1 mt50">
				<div class="border-navy">
					<h4 class="bg_navy f_white padding-vertical tc noMargin" id="title"></h4>
					<ul class="detailInfoUl_gujik pr">
						<li class="bb padding">
							<span class="di w10">이름</span><span class="" id="name"></span>
						</li>
						<li class="bb padding">
							<span class="di w10">생년월일</span><span class="" id="birthday"></span> <!-- id="address" -->
						</li>
						<li class="padding">
							<span class="di w10">희망근무지</span><span class="" id="hopeAddress"></span>
						</li>
						<li class="pa tc" style="left:0; top:0; width:18%">
							<img src="" id="imgUrl" alt="" width="50%" style="margin-top:8%">
						</li>
					</ul>
				</div>
			</div>
				
			<h4 class="mt30 f16 mb10">
			  
			  희망조건 및 구직자 정보
			</h4>

			<div class="gujikDetSect2 oh mt10">
				<div class="oh">
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">희망직종</p>
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">성별</p>
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">나이</p>
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">경력</p>
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">장애여부</p>
				</div>
				<div class="oh">
					<p class="w20 fl sect2Table di lh70 f14 tc" id="work_2nd_nm"></p>
					<p class="w20 fl sect2Table di lh70 f14 tc" id="sex"></p>
					<p class="w20 fl sect2Table di lh70 f14 tc" id="age"></p>
					<p class="w20 fl sect2Table di lh70 f14 tc" id="career"></p>
					<p class="w20 fl sect2Table di lh70 f14 tc" id="obstacle"></p>
				</div>
			</div>

			<h4 class="mt30 f16 mb10">
				  
				  구직자정보
				</h4>
			<div class="gujikDetSect3 oh mb30">

				<div class="oh">
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">E-메일</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20" id="email"></p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">연락처</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20" id="phone"></p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 근무일자</p><p class="fl sect2Table di lh40 f12 tc noMargin pl10" id="workDate"></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 근무시간</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20" id="time"></p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 금액(일당)</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20" ><b class="fc" id="pay"></b></p></div>
					<div class="oh"><p class="fl w100 noMargin sect2head di bg_grey lh40 f14 pl15 tl">자기소개</p></div>
					<div class="padding sect3Inner tc">
						<div class="di mb20" id="content">
							<!--
							<p class="bold">마OO님은 총<font class="fc">2078자</font>의 자기소개서를 작성하였습니다.</p>
							<p class="mb15">아이템SHOP에서 열람서비스 상품을 구매하실 시 자기소개서를 열람하실 수 있습니다.</p>	
							<a href="#" class="info-page-prdBtn">상품구매</a>
							-->
						</div>
					</div>
				</div>
			</div>
			<div class="tc">
				<a href="#" id="reviewLink" class="info-review-btn">평가보기</a>
				<a href="javascript:cancelApproval()" class="info-guin-btn">승인취소</a>
			</div>
	      	<div class="botWarn mt30 mb60">
				<div class="botWarnImg fl"><img src="http://il-bang.com/pc_renewal/images/top_left_logo.png" alt="로고" class="wh95"></div>
	      		<div class="botWarnTxt ml25">
	      			본 구인정보는 게시자가 제공한 자료이며, (주)엠엠씨피플 일방은 기재된 내용에 대한 오류와 지연에 사용자가 이를 신뢰하여 취한 조치에 대해<br>
	      			책임을 지지 않습니다. 본 정보의 저작권은 (주)엠엠씨피플 일방에 있으며, 동의없이 무단개제 및 재배포 할 수 없습니다. 
	      		</div>
	      	</div><div class="clear"></div>

	    </div>
	  </div>
	</div>
</div>
<script>
// 파라미터 가져오는 펑션 - 정재            --> 에러나서 주석 처리함
        function getQuerystring(paramName){

          var _tempUrl = window.location.search.substring(1); //url에서 처음부터 '?'까지 삭제
          var _tempArray = _tempUrl.split('&'); // '&'을 기준으로 분리하기                
          
          if(_tempArray != null && _tempArray != "") {
            for(var i = 0; _tempArray.length; i++) {
              var _keyValuePair = _tempArray[i].split('='); // '=' 을 기준으로 분리하기
              
              if(_keyValuePair[0] == paramName){ // _keyValuePair[0] : 파라미터 명
                // _keyValuePair[1] : 파라미터 값
                return _keyValuePair[1];
              }
            }
          }
        }
        

    // param 변수에 파라미터값을 저장합니다.
      var param=getQuerystring('tab');
      // $(".guingujikTabLi").removeClass("active");
      // $(".guingujikTabLi").removeClass("db");
      if(param=='1'){
        $(".guingujikTabLi,.tab-pane").removeClass('active')
        $(".guingujikTabLi").eq(0).addClass('active')
        $("#gujikTab1").addClass('active')
      } else if(param=='2'){
          $(".guingujikTabLi,.tab-pane").removeClass('active')
          $(".guingujikTabLi").eq(1).addClass('active')
          $("#gujikTab2").addClass('active')

        // alert();
      } else if(param=='3'){
          $(".guingujikTabLi,.tab-pane").removeClass('active')
          $(".guingujikTabLi").eq(2).addClass('active')
          $("#gujikTab3").addClass('active')
      } else if(param=='4'){
          $(".guingujikTabLi,.tab-pane").removeClass('active')
          $(".guingujikTabLi").eq(3).addClass('active')
          $("#gujikTab4").addClass('active')
      }
    
</script>

<?php include_once "../../include/footer.php"; ?>