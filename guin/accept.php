<?php include_once "../include/header.php"; ?>
<script type="text/javascript">
var no = '<?php echo $_POST["rno"]; ?>';
var eno ='<?php echo $_POST["eno"]; ?>';
 $(document).ready(function() {

	if(no!=null){
		  $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/guin/getResume.php',
            data: { rno: no , eno:eno},
            success: function(data) {
             var resume = data.resume;
            
           	 $("#title").text(resume[0].title);
           	 $("#name").text(resume[0].name);
           	 $("#birthday").text(resume[0].birthday);
           	 $("#juso").text(resume[0].area_1st_nm+"-"+resume[0].area_2nd_nm);
           	 $("#work").text(resume[0].work_2nd_nm);
           	 $("#sex").text(resume[0].sex);
           	 $("#age").text(resume[0].age);
           	 $("#career").text(resume[0].career);
           	 $("#obstacle").text(resume[0].obstacle);
           	 $("#emails").text(resume[0].email);
           	 $("#phone").text(resume[0].phone);
           	 $("#content").text(resume[0].content);
           	 $("#pay").text(resume[0].pay+"원");
           	 $("#time").text(resume[0].time);
           	 if(resume[0].img_url !=null){
           	 var profile_img= document.getElementById("profile_img");
           	 profile_img.src="http://il-bang.com/pc_renewal/gujikImage/"+resume[0].img_url;
           	 }
           	 //초기화 날짜
           	 document.getElementById("date").innerHTML="";
	           	  	 
           	  var date = data.date;
           	  for(var i=0; i<date.length; i++){
           	  	var checked="";
           	  	  if(date[i].choice=='yes'){
			      	
			      }else{
	           	  document.getElementById("date").innerHTML
	           	  	 +='<div class="checkbox di pl20 mb0 mt15">'
				      +'<label><input type="checkbox" name="date" '
				      +checked
				      +'value="'+date[i].date+'">'+date[i].date+'</label>'
					  +'</div>';
				}
           	  }           	 

            }
        });

	}
});


function join(){
	  var chked_val = "";
	  $(":checkbox[name='date']:checked").each(function(pi,po){
	    chked_val += ","+po.value;
	  });
	  if(chked_val!="")chked_val = chked_val.substring(1);
		
	if(chked_val!=""){
		  $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/guin/joinGuin.php',
            data: { rno:no, eno:eno , chked_val:chked_val },
            success: function(data) {
            	var message="";
            	for(var i=0; i<data.join.length; i++){
            		message+=data.join[i].message+"\n";

            		var choice = data.join[i].choice;
            		var work_date = data.join[i].work_date;;
            		// var chked_date =  chked_val.split(',');//선택한날
            		var date = document.getElementsByName("date");

            		for(var j=0; j<date.length; j++){
            		 if(date[j].value == work_date){
            		 	
	            		if(choice=='yes'){
	            			date[j].checked=true;
	            		}else{
	            			date[j].checked=false;
	            		}
	            	 }//if(chked_date) 
            		}
            	}
            	alert(message);
            }
        });
	}
 	

}

	function cancelGuin(){
		var rno = '<?php echo $_POST["rno"]; ?>';
		var eno = '<?php echo $_POST["eno"]; ?>';
		var work_date = [] ;
		//var work_join_list_no	= $("#date option:selected").val();	
		$("input[name=date]:checked").each(function() {
            work_date.push($(this).val());
        });

		//alert(rno);
		//alert(eno);
		//alert(work_date);

		$.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/guin/cancelGuin.php',
            data: {rno:rno, eno:eno, work_date:work_date },
            success: function (data) {
                if(data.result=="0"){
                    alert(data.msg);
                } else if (data.result=="1"){
                    alert(data.msg);
                }
            }
        });

	}

</script>


<div class="container pl30">
	
	<div class="guinjikTabWrap">
	   
	  <!-- 첫번째 탭 내용 -->
	    <div role="tabpanel" class="tab-pane active mt10" id="gujikTab1">
	      
			<div class="gujikDetSect1 mt50">
				<div class="border-navy">
					<h4 class="bg_navy f_white padding-vertical tc noMargin" id="title"></h4>
					<ul class="detailInfoUl_gujik pr">
						<li class="bb padding">
							<span class="di w10">이름</span><span class="" id="name"></span>
						</li>
						<li class="bb padding">
							<span class="di w10">생년월일</span><span class="" id="birthday"></span>
						</li>
						<li class="padding">
							<span class="di w10">희망근무지</span><span class="" id="juso" ></span>
						</li>
						<li class="pa tc" style="left:0; top:0; width:18%">
							<img src="http://il-bang.com/pc_renewal/images/profile.png" alt="" id="profile_img" width="50%" style="margin-top:8%">
						</li>
					</ul>
				</div>
			</div>
				
			<h4 class="mt30 f16">
			  
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
					<p class="w20 fl sect2Table di lh70 f14 tc" id="work" ></p>
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
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">E-메일</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20"  id="emails"></p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">연락처</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20" id="phone"></p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 근무일자</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20">
						<div id="date">
							
						</div>
						   
						
					</p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 근무시간</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20" id="time"></p></div>
					<div class="oh cont"><p class="fl w20 noMargin sect2head di bg_grey lh40 f14 pl15 tl">희망 금액(일당)</p><p class="fl sect2Table di lh40 f12 tc noMargin pdl20"><b class="fc" id="pay"></b></p></div>
					<div class="oh"><p class="fl w100 noMargin sect2head di bg_grey lh40 f14 pl15 tl">자기소개</p></div>
					<div class="padding sect3Inner tc">
						<div class="di mb20">
							<p class="bold" id="content"></p>
						</div>
					</div>
				</div>
			</div>
			<div class="tc">
				<!-- <a href="" class="info-review-btn">이전으로</a> -->
				<a href="javascript:join();" class="info-guin-btn">승인</a>
				<a href="javascript:cancelGuin();" class="info-guin-btn">채용신청 취소</a>
			</div>
	      	<div class="botWarn mt30 mb60">
                <div class="botWarnImg fl"><img class="wh95" alt="로고" src="http://il-bang.com/pc_renewal/images/top_left_logo.png"></div>
                <div class="botWarnTxt ml25">
                    본 구인정보는 게시자가 제공한 자료이며, (주)엠엠씨피플 일방은 기재된 내용에 대한 오류와 지연에 사용자가 이를 신뢰하여 취한 조치에 대해<br>
                    책임을 지지 않습니다. 본 정보의 저작권은 (주)엠엠씨피플 일방에 있으며, 동의없이 무단개제 및 재배포 할 수 없습니다. 
                </div>
            </div>

	    </div>
	    
	</div>
</div>

<?php include_once "../include/footer.php"; ?>