<?php include_once "../include/header.php" ?>

	<div class="container mt50">
		<div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
			<ul class="nav nav-tabs" role="tablist" id="myTab">
			  <li role="presentation" class="col-xs-6 col-sm-6 col-md-6 col-lg-6 noPadding text-center active"><a href="#urgentTab1" aria-controls="urgentTab1" role="tab" data-toggle="tab">긴급구인 신청</a></li>
			  <li class="col-xs-6 col-sm-6 col-md-6 col-lg-6 noPadding text-center" role="presentation"><a href="#urgentTab2" aria-controls="urgentTab2" role="tab" data-toggle="tab">긴급구인 내역</a></li>
			</ul>
			<div class="tab-content">
					<!-- 첫 번째 탭 내용 -->
				  <div role="tabpanel" class="tab-pane active mt10" id="urgentTab1">
				    <div class="mt30">
					   	<small class="f14 fl mr5" style="line-height: 24px">일방</small><h4 class="fls"><b>긴급구인</b></h4>			  	
				    </div>
				    <div class="mt30">
					   	<p class="di f16"><b>긴급구인 이란?</b></p>			  	
					   	<div class="fr mt5">
					   		좀더 빠른 구인구직을 원할 땐! <a href="javascript:void(0)" class="sm-btn sm-btn2">상품구매</a>
					   	</div>
				    </div>
          	        <div class="container col-md-12 col-lg-12">
          	        	<div class="border-grey padding" style="padding:30px 50px; line-height: 24px">
          	        		1. 현재 위치하신 위치 기반으로 <font class="fc">5km 반경 내 구직자와 연결해 주는 시스템</font>입니다.<br>
                              2. 보다 빠르고 정확한 <font class="fc">실시간 매칭 시스템</font>으로 즉각적인 서비스를 제공합니다.<br>
                              3. <font class="fc">유료 서비스</font>로 이용하실 수 있으며 <font class="fc">1회 5,000원으로 매칭성공시 유효</font>합니다.<br>
                              4. 구직자가 <font class="fc">최종적으로 수락한 후 매칭이</font> 됩니다.<br>
          	        	</div>
                         <h5 class="mt50 mb20">긴급구인 신청</h5>
          	        	<div class="oh w100 urgentApList">
          	        		<ul class="bg_darkgrey guinInfoTlt oh noPadding">
	          	        		<li class="urgentInfoLiChk fl tc">
	          	        			선택
	          	        		</li>
          	        			<li class="urgentInfoLi1 tc fl">등록일</li>
          	        			<li class="urgentInfoLi2 tc fl tc">신청서 제목</li>
          	        			<li class="urgentInfoLi3 fl tc">신청서 관리</li>
          	        		</ul>
                                
                              <?php 
                              $test=false;
                              if($test){?>
                                   <div class="emptyUrgent tc" style="height: 400px; padding-top:150px">
                                        <p>작성된 <font class="fc bold">긴급우인 신청서</font>가 없습니다</p>
                                        <p>기존에 작성한 신청서를 불러오거나 <font class="fc bold">새로작성</font>해주세요</p>
                                   </div>
                              <?php
                                }else{
                              ?>
          	        		<ul class="oh noPadding guinInfoList bb pdt6">
	          	        		<li class="urgentInfoLiChk fl lh87 tc">
	          	        			<input type="checkbox" class="di">
	          	        		</li>
          	        			<li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
          	        			<li class="urgentInfoLi2 fl" style="padding-left:6%">
          	        				<h5>취업대란! 제게는 오히려 기회입니다.</h5>
          	        				<div class="margin-vertical info2Cont">
          	        					<span class="ilbangBadge"><b>IT일방</b></span>
          	        					<span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
          	        				</div>
          	        				<div>
          	        					<span>경력 :</span>	
          	        					<span class="mr10">1년 ↑↓</span>	
          	        					<span class="border-grey payBedge mr5 f_navy bold">일당</span>	
          	        					<span class="bold f_navy">70,000원</span>	
          	        				</div>
          	        			</li>
          	        			<li class="urgentInfoLi3 lh25 fl tc">
          	        				<a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
          	        				<a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
          	        			</li>
          	        			
          	        		</ul>
          	        		<ul class="oh noPadding guinInfoList bb pdt6">
	          	        		<li class="urgentInfoLiChk fl lh87 tc">
	          	        			<input type="checkbox" class="di">
	          	        		</li>
          	        			<li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
          	        			<li class="urgentInfoLi2 fl" style="padding-left:6%">
          	        				<h5>취업대란! 제게는 오히려 기회입니다.</h5>
          	        				<div class="margin-vertical info2Cont">
          	        					<span class="ilbangBadge"><b>IT일방</b></span>
          	        					<span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
          	        				</div>
          	        				<div>
          	        					<span>경력 :</span>	
          	        					<span class="mr10">1년 ↑↓</span>	
          	        					<span class="border-grey payBedge mr5 f_navy bold">일당</span>	
          	        					<span class="bold f_navy">70,000원</span>	
          	        				</div>
          	        			</li>
          	        			<li class="urgentInfoLi3 lh25 fl tc">
          	        				<a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
          	        				<a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
          	        			</li>
          	        			
          	        		</ul>
          	        		<ul class="oh noPadding guinInfoList bb pdt6">
	          	        		<li class="urgentInfoLiChk fl lh87 tc">
	          	        			<input type="checkbox" class="di">
	          	        		</li>
          	        			<li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
          	        			<li class="urgentInfoLi2 fl" style="padding-left:6%">
          	        				<h5>취업대란! 제게는 오히려 기회입니다.</h5>
          	        				<div class="margin-vertical info2Cont">
          	        					<span class="ilbangBadge"><b>IT일방</b></span>
          	        					<span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
          	        				</div>
          	        				<div>
          	        					<span>경력 :</span>	
          	        					<span class="mr10">1년 ↑↓</span>	
          	        					<span class="border-grey payBedge mr5 f_navy bold">일당</span>	
          	        					<span class="bold f_navy">70,000원</span>	
          	        				</div>
          	        			</li>
          	        			<li class="urgentInfoLi3 lh25 fl tc">
          	        				<a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
          	        				<a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
          	        			</li>
          	        			
          	        		</ul>
          	        		<ul class="oh noPadding guinInfoList bb pdt6">
	          	        		<li class="urgentInfoLiChk fl lh87 tc">
	          	        			<input type="checkbox" class="di">
	          	        		</li>
          	        			<li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
          	        			<li class="urgentInfoLi2 fl" style="padding-left:6%">
          	        				<h5>취업대란! 제게는 오히려 기회입니다.</h5>
          	        				<div class="margin-vertical info2Cont">
          	        					<span class="ilbangBadge"><b>IT일방</b></span>
          	        					<span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
          	        				</div>
          	        				<div>
          	        					<span>경력 :</span>	
          	        					<span class="mr10">1년 ↑↓</span>	
          	        					<span class="border-grey payBedge mr5 f_navy bold">일당</span>	
          	        					<span class="bold f_navy">70,000원</span>	
          	        				</div>
          	        			</li>
          	        			<li class="urgentInfoLi3 lh25 fl tc">
          	        				<a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
          	        				<a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
          	        			</li>
          	        			
          	        		</ul>
          	        		<ul class="oh noPadding guinInfoList bb pdt6">
	          	        		<li class="urgentInfoLiChk fl lh87 tc">
	          	        			<input type="checkbox" class="di">
	          	        		</li>
          	        			<li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
          	        			<li class="urgentInfoLi2 fl" style="padding-left:6%">
          	        				<h5>취업대란! 제게는 오히려 기회입니다.</h5>
          	        				<div class="margin-vertical info2Cont">
          	        					<span class="ilbangBadge"><b>IT일방</b></span>
          	        					<span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
          	        				</div>
          	        				<div>
          	        					<span>경력 :</span>	
          	        					<span class="mr10">1년 ↑↓</span>	
          	        					<span class="border-grey payBedge mr5 f_navy bold">일당</span>	
          	        					<span class="bold f_navy">70,000원</span>	
          	        				</div>
          	        			</li>
          	        			<li class="urgentInfoLi3 lh25 fl tc">
          	        				<a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
          	        				<a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
          	        			</li>
          	        			
          	        		</ul>
                              <?php 
                              }
                               ?>
          	        	</div>
                         <p class="ml30 mt10">
                              <b class="fc">※ 선택 후 긴급매칭 신청 버튼을 누르면 실시간 매칭이 진행 됩니다.</b>
                         </p>    
                         <div class="oh tranBtnWrap2 center mt50 mb40 tc">
                                <input type="submit" class="fl btn-tran btn-tran-3 noMargin di padding-vertical bg_navy f_white border-navy" value="긴급매칭 신청">
                                <input type="submit" class="btn-tran btn-tran-3 noMargin di padding-vertical bg_white border-navy" value="신청서 불러오기">
                                <input type="submit" class="fr btn-tran btn-tran-3 noMargin di padding-vertical bg_white border-navy" value="신청서 신규작성">
                         </div>
				  </div>
                 </div>
				  	<!-- 두 번째 탭 내용 -->
				    <div role="tabpanel" class="tab-pane mt10" id="urgentTab2">
				                                   <div class="mt30">
                                                            <small class="f14 fl mr5" style="line-height: 24px">일방</small><h4 class="fls"><b>긴급구인</b></h4>                
                                                      </div>
                                                      <div class="mt30">
                                                            <p class="di f16"><b>긴급구인 이란?</b></p>                  
                                                            <div class="fr mt5">
                                                                 좀더 빠른 구인구직을 원할 땐! <a href="javascript:void(0)" class="sm-btn sm-btn2">상품구매</a>
                                                            </div>
                                                      </div>
                                                     <div class="container col-md-12 col-lg-12">
                                                       <div class="border-grey padding" style="padding:30px 50px; line-height: 24px">
                                                            1. 현재 위치하신 위치 기반으로 <font class="fc">5km 반경 내 구직자와 연결해 주는 시스템</font>입니다.<br>
                                                             2. 보다 빠르고 정확한 <font class="fc">실시간 매칭 시스템</font>으로 즉각적인 서비스를 제공합니다.<br>
                                                             3. <font class="fc">유료 서비스</font>로 이용하실 수 있으며 <font class="fc">1회 5,000원으로 매칭성공시 유효</font>합니다.<br>
                                                             4. 구직자가 <font class="fc">최종적으로 수락한 후 매칭이</font> 됩니다.<br>
                                                       </div>
                                                        <h5 class="mt50 mb20">긴급구인 신청</h5>
                                                       <div class="oh w100 urgentApList">
                                                            <ul class="bg_darkgrey guinInfoTlt oh noPadding">
                                                                 <li class="urgentInfoLiChk fl tc">
                                                                      선택
                                                                 </li>
                                                                 <li class="urgentInfoLi1 tc fl">등록일</li>
                                                                 <li class="urgentInfoLi2 tc fl tc">신청서 제목</li>
                                                                 <li class="urgentInfoLi3 fl tc">신청서 관리</li>
                                                            </ul>
                                                               
                                                             <?php 
                                                             $test2=true;
                                                             if($test2){?>
                                                                  <div class="emptyUrgent tc" style="height: 400px; padding-top:150px">
                                                                       <p>작성된 <font class="fc bold">긴급우인 신청서</font>가 없습니다</p>
                                                                       <p>기존에 작성한 신청서를 불러오거나 <font class="fc bold">새로작성</font>해주세요</p>
                                                                  </div>
                                                             <?php
                                                               }else{
                                                             ?>
                                                            <ul class="oh noPadding guinInfoList bb pdt6">
                                                                 <li class="urgentInfoLiChk fl lh87 tc">
                                                                      <input type="checkbox" class="di">
                                                                 </li>
                                                                 <li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
                                                                 <li class="urgentInfoLi2 fl" style="padding-left:6%">
                                                                      <h5>취업대란! 제게는 오히려 기회입니다.</h5>
                                                                      <div class="margin-vertical info2Cont">
                                                                           <span class="ilbangBadge"><b>IT일방</b></span>
                                                                           <span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
                                                                      </div>
                                                                      <div>
                                                                           <span>경력 :</span>   
                                                                           <span class="mr10">1년 ↑↓</span>    
                                                                           <span class="border-grey payBedge mr5 f_navy bold">일당</span>     
                                                                           <span class="bold f_navy">70,000원</span>     
                                                                      </div>
                                                                 </li>
                                                                 <li class="urgentInfoLi3 lh25 fl tc">
                                                                      <a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
                                                                      <a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
                                                                 </li>
                                                                 
                                                            </ul>
                                                            <ul class="oh noPadding guinInfoList bb pdt6">
                                                                 <li class="urgentInfoLiChk fl lh87 tc">
                                                                      <input type="checkbox" class="di">
                                                                 </li>
                                                                 <li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
                                                                 <li class="urgentInfoLi2 fl" style="padding-left:6%">
                                                                      <h5>취업대란! 제게는 오히려 기회입니다.</h5>
                                                                      <div class="margin-vertical info2Cont">
                                                                           <span class="ilbangBadge"><b>IT일방</b></span>
                                                                           <span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
                                                                      </div>
                                                                      <div>
                                                                           <span>경력 :</span>   
                                                                           <span class="mr10">1년 ↑↓</span>    
                                                                           <span class="border-grey payBedge mr5 f_navy bold">일당</span>     
                                                                           <span class="bold f_navy">70,000원</span>     
                                                                      </div>
                                                                 </li>
                                                                 <li class="urgentInfoLi3 lh25 fl tc">
                                                                      <a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
                                                                      <a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
                                                                 </li>
                                                                 
                                                            </ul>
                                                            <ul class="oh noPadding guinInfoList bb pdt6">
                                                                 <li class="urgentInfoLiChk fl lh87 tc">
                                                                      <input type="checkbox" class="di">
                                                                 </li>
                                                                 <li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
                                                                 <li class="urgentInfoLi2 fl" style="padding-left:6%">
                                                                      <h5>취업대란! 제게는 오히려 기회입니다.</h5>
                                                                      <div class="margin-vertical info2Cont">
                                                                           <span class="ilbangBadge"><b>IT일방</b></span>
                                                                           <span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
                                                                      </div>
                                                                      <div>
                                                                           <span>경력 :</span>   
                                                                           <span class="mr10">1년 ↑↓</span>    
                                                                           <span class="border-grey payBedge mr5 f_navy bold">일당</span>     
                                                                           <span class="bold f_navy">70,000원</span>     
                                                                      </div>
                                                                 </li>
                                                                 <li class="urgentInfoLi3 lh25 fl tc">
                                                                      <a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
                                                                      <a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
                                                                 </li>
                                                                 
                                                            </ul>
                                                            <ul class="oh noPadding guinInfoList bb pdt6">
                                                                 <li class="urgentInfoLiChk fl lh87 tc">
                                                                      <input type="checkbox" class="di">
                                                                 </li>
                                                                 <li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
                                                                 <li class="urgentInfoLi2 fl" style="padding-left:6%">
                                                                      <h5>취업대란! 제게는 오히려 기회입니다.</h5>
                                                                      <div class="margin-vertical info2Cont">
                                                                           <span class="ilbangBadge"><b>IT일방</b></span>
                                                                           <span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
                                                                      </div>
                                                                      <div>
                                                                           <span>경력 :</span>   
                                                                           <span class="mr10">1년 ↑↓</span>    
                                                                           <span class="border-grey payBedge mr5 f_navy bold">일당</span>     
                                                                           <span class="bold f_navy">70,000원</span>     
                                                                      </div>
                                                                 </li>
                                                                 <li class="urgentInfoLi3 lh25 fl tc">
                                                                      <a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
                                                                      <a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
                                                                 </li>
                                                                 
                                                            </ul>
                                                            <ul class="oh noPadding guinInfoList bb pdt6">
                                                                 <li class="urgentInfoLiChk fl lh87 tc">
                                                                      <input type="checkbox" class="di">
                                                                 </li>
                                                                 <li class="urgentInfoLi1 lh87 tc fl"><b class="ml10">2016.11.18</b></li>
                                                                 <li class="urgentInfoLi2 fl" style="padding-left:6%">
                                                                      <h5>취업대란! 제게는 오히려 기회입니다.</h5>
                                                                      <div class="margin-vertical info2Cont">
                                                                           <span class="ilbangBadge"><b>IT일방</b></span>
                                                                           <span class="di text-cut guinDesc margin-verti ml5">희망지역 : 경상북도 > OO면 OO리</span>
                                                                      </div>
                                                                      <div>
                                                                           <span>경력 :</span>   
                                                                           <span class="mr10">1년 ↑↓</span>    
                                                                           <span class="border-grey payBedge mr5 f_navy bold">일당</span>     
                                                                           <span class="bold f_navy">70,000원</span>     
                                                                      </div>
                                                                 </li>
                                                                 <li class="urgentInfoLi3 lh25 fl tc">
                                                                      <a class="modiBtn mr5 f14" href="javascript/void(0)">수정</a>
                                                                      <a class="deleteBtn f14" href="javascript/void(0)">삭제</a>
                                                                 </li>
                                                                 
                                                            </ul>
                                                             <?php 
                                                             }
                                                              ?>
                                                       </div>
                                                        <p class="ml30 mt10">
                                                             <b class="fc">※ 선택 후 긴급매칭 신청 버튼을 누르면 실시간 매칭이 진행 됩니다.</b>
                                                        </p>    
                                                        <div class="oh tranBtnWrap2 center mt50 mb40 tc">
                                                               <input type="submit" class="fl btn-tran btn-tran-3 noMargin di padding-vertical bg_navy f_white border-navy" value="긴급매칭 신청">
                                                               <input type="submit" class="btn-tran btn-tran-3 noMargin di padding-vertical bg_white border-navy" value="신청서 불러오기">
                                                               <input type="submit" class="fr btn-tran btn-tran-3 noMargin di padding-vertical bg_white border-navy" value="신청서 신규작성">
                                                        </div>
                                                    </div>

				    </div>
			 </div>
		 </div>
	</div>
     </div>
<?php include_once "../include/footer.php" ?>