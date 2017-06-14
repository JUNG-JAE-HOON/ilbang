<?php include_once "../../include/header.php"; ?>
<div>
	<div class="container center wdfull bb mb15">
	    <div class="pg_rp"> 
	        <div class="c999 fl subTitle"><a href="../index.php" class="c999">HOME</a><span class="plr5">></span><a href="../gujik/gujik.php" class="bold">구직자</a></div>
	        <div class="c999 fr padding-vertical">
	            <span class="mr5 br15 subNotice">공지</span>일방 PC버전이 정식 오픈되었습니다.
	        </div>
	    </div><div class="clear"></div>
	</div>  
	<div class="container pl30"> 
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
		<div class="col-xs-5 col-sm-5 col-md-5 col-lg-5 oh mt20">
			<a href="" class="linkImg di w100" style="height: 105px;"></a>
		</div>
		<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 border-grey border-box gujikTopBox oh">
			<div class="gujikCount padding-vertical count1 fl tc padding-vertical; margin-vertical">
				<h4 class="margin-vertical">2,333건</h4>
				<p class="margin-vertical">신규신청서</p>	
			</div>
			<div class="gujikCount padding-vertical count2 fl tc padding-vertical; margin-vertical">
				<h4 class="margin-vertical">2,333건</h4>
				<p class="margin-vertical">전체 신청서</p>	
			</div>
			<div class="gujikCount padding-vertical count3 fl tc padding-vertical; margin-vertical">
				<h4 class="margin-vertical">2,333건</h4>
				<p class="margin-vertical">신규매칭</p>	
			</div>
			<div class="gujikCount padding-vertical count4 fl tc padding-vertical; margin-vertical">
				<h4 class="margin-vertical">2,333건</h4>
				<p class="margin-vertical">전체매칭</p>	
			</div>
			<a href="#" class="gujikCount count5 fl tc f14 f_white" style="background-color: black">
				<span class="glyphicon glyphicon-plus f22"></span>
				<p class="margin-vertical">신청서 작성</p>
			</a>
		</div><div class="clear"></div>			
	</div>
</div>
<div>
	<div class="guingujikTabWrap fl">
	  <ul class="nav nav-tabs mt10" role="tablist" id="myTab">
	    <li role="presentation" class="noPadding guingujikTabLi text-center active"><a href="#guingujikTab1" aria-controls="guingujikTab1" role="tab" data-toggle="tab">전체</a></li>
	    <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="#guingujikTab2" aria-controls="guingujikTab2" role="tab" data-toggle="tab">구직신청서</a></li>
	    <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="#guingujikTab3" aria-controls="guingujikTab3" role="tab" data-toggle="tab">매칭리스트</a></li>
	    <li class="noPadding guingujikTabLi text-center" role="presentation"><a href="#guingujikTab4" aria-controls="guingujikTab4" role="tab" data-toggle="tab">매칭완료</a></li>
	  </ul>
	  <div class="tab-content container">
	  <!-- 첫번째 탭 내용 -->
	    <div role="tabpanel" class="tab-pane active mt10 container pl30" id="guingujikTab1">
	      
			<div class="gujikDetSect1 mt50">
				<div class="border-navy">
					<h4 class="bg_navy f_white padding-vertical tc noMargin">백만불짜리 열정으로 능력을 보여드리겠습니다!</h4>
					<ul class="detailInfoUl_gujik pr">
						<li class="bb padding">
							<span class="di w10">이름</span><span class="">마OO</span>
						</li>
						<li class="bb padding">
							<span class="di w10">거주지</span><span class="">경기도 OO시 OO구 OO동</span>
						</li>
						<li class="padding">
							<span class="di w10">희망근무지</span><span class="">경기도 부천시 오정구 오정동</span>
						</li>
						<li class="pa tc" style="left:0; top:0; width:18%">
							<img src="../../images/profile.png" alt="" width="50%" style="margin-top:8%">
						</li>
					</ul>
				</div>
			</div>
				
			<h4 class="mt30 f16 mb10">
			  
			  희망조건 및 구직자 정보
			</h4>

			<div class="gujikDetSect2 oh">
				<div class="oh">
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">희망직종</p>
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">성별</p>
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">나이</p>
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">경력</p>
					<p class="fl w20 noMargin sect2head di bg_grey lh40 f14 tc">장애여부</p>
				</div>
				<div class="oh">
					<p class="w20 fl sect2Table di lh70 f14 tc">IT일방</p>
					<p class="w20 fl sect2Table di lh70 f14 tc">여자</p>
					<p class="w20 fl sect2Table di lh70 f14 tc">20대 이상</p>
					<p class="w20 fl sect2Table di lh70 f14 tc">1년 이상</p>
					<p class="w20 fl sect2Table di lh70 f14 tc">비장애</p>
				</div>
			</div>

			<h4 class="mt30 mb10 f16">
				  
				  구직자정보
				</h4>
			<div class="gujikDetSect3 oh mb30">

				<div class="oh">
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">E-메일</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20">전반적인 웹개발업무</p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">연락처</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20">010 - 1234 - 5678</p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 근무일자</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20">2016.11.23 / 2016.11.24 / 2016.11.25 / 2016.11.26</p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 근무시간</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20">오전, 오후</p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 금액(일당)</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20"><b class="fc">70,000</b></p></div>
					<div class="oh"><p class="fl w100 noMargin sect2head di bg_grey lh40 f14 pl15 tl">자기소개</p></div>
					<div class="padding sect3Inner tc">
						<div class="di mb20">
							<p class="bold">마OO님은 총<font class="fc">2078자</font>의 자기소개서를 작성하였습니다.</p>
							<p class="mb15">아이템SHOP에서 열람서비스 상품을 구매하실 시 자기소개서를 열람하실 수 있습니다.</p>	
							<a href="#" class="info-page-prdBtn">상품구매</a>
						</div>
					</div>
				</div>
			</div>
			<div class="tc">
				<a href="../review.php" class="info-review-btn">평가보기</a>
				<a href="" class="info-guin-btn">구인하기</a>
			</div>
	      	<div class="botWarn mt30 mb60">
				<div class="botWarnImg fl"><img src="http://il-bang.com/pc_renewal/images/top_left_logo.png" alt="로고" class="wh95"></div>
	      		<div class="botWarnTxt ml25">
	      			본 구인정보는 게시자가 제공한 자료이며, (주)엠엠씨피플 일방은 기재된 내용에 대한 오류와 지연에 사용자가 이를 신뢰하여 취한 조치에 대해<br>
	      			책임을 지지 않습니다. 본 정보의 저작권은 (주)엠엠씨피플 일방에 있으며, 동의없이 무단개제 및 재배포 할 수 없습니다. 
	      		</div>
	      	</div><div class="clear"></div>

	    </div>
	    <!-- 두번째 탭 내용 -->
	    <div role="tabpanel" class="tab-pane mt10" id="guingujikTab2">
	        asidjaskasldkjasdkasdkj2
	    </div>
	    <div role="tabpanel" class="tab-pane mt10" id="guingujikTab3">
	        asidjaskasldkjasdkasdkj3
	    </div>
	    <div role="tabpanel" class="tab-pane mt10" id="guingujikTab4">
	        asidjaskasldkjasdkasdkj4
	    </div>
	  </div>
	</div>
</div>
<div class="clear"></div>
<?php include_once "../../include/footer.php"; ?>