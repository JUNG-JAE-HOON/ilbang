<?php include_once "../include/header.php"; 
?>
<?php
/*
	$employNo = $_GET["employNo"];


	$sql  = " SELECT A.company, B.age, C.name, B.sex  	";
	$sql .= " FROM work_employ_data A 					";
	$sql .= "    , member_extend B 						";
	$sql .= "    , member C 							";
	$sql .= " WHERE A.no = '$employNo'					";
	$sql .= " AND A.member_no = B.member_no				";
	$sql .= " AND A.member_no = C.no 					";


   $result = mysql_query($sql, $ilbang_con);
        
    while($row = mysql_fetch_array($result)){
             $comapny	= $row["company"];
             $age		= $row["age"];
             $sex		= $row["sex"];

            
             $age = substr($age, 0, 1) . "0"; 

                 if ($sex == "male")    $sex = "남자";
            else if ($sex == "female")  $sex = "여자";
            else if ($sex == "nothing") $sex = "무관";  
    }


	$sql  = " SELECT no as work_join_list_no			";
	$sql .= " 		, work_date							";
	$sql .= " 		, euid								";
	$sql .= "		, ruid 								";
	$sql .= "	FROM work_join_list 					";
	$sql .= "	WHERE 1=1 								";
	$sql .= "	AND ruid = '$uid' 						";
	$sql .= "	AND work_employ_data_no = '$employNo'	";

	$result = mysql_query($sql, $ilbang_con);
    
    $work_join_list_no	= array();
    $work_date			= array();
        
    while($row = mysql_fetch_array($result)){
             $work_join_list_no[]	= $row["work_join_list_no"];
             $work_date[]			= $row["work_date"];
             $euid					= $row["euid"];
             $ruid					= $row["ruid"];  
    }
*/
?>

  echo json_encode(array('company' => $company, 'age'=>$age ,'sex'=>$sex, 'work_join_list_no' => $work_join_list_no, 'work_date'=> $work_date , 'euid' => $euid , 'ruid' => $ruid));
<script>

  	$(document).ready(function() {
       getEmployReviewInfo();
    });

	function getEmployReviewInfo(){

		var uid		 = '<?php echo $uid?>';
		var employNo = '<?php echo $_GET["employNo"]?>';

   		$.ajax({
	             type: 'post',
	             dataType: 'json',
	             url: '../ajax/guin/getEmployReviewInfo.php',
	             data: {uid:uid,employNo:employNo},
	             success: function (data) {

					if(data.img_url == null || data.img_url == ''){
	             		data.img_url = "../images/profile.png";
	             	}

	             	$("#company"	).text(data.company);
	             	$("#sexNage"	).text(data.sex + ", " + data.age+"대");
	             	$("#totalScore"	).text(data.totalScore +"점");
	             	$("#Heuid"		).val(data.euid);
	             	$("#Hruid"		).val(data.ruid);           	
	             	$("#profileImg" ).attr('src',data.img_url);

	              var cell = document.getElementById("workDate");

                  while (cell.hasChildNodes()){
                      cell.removeChild(cell.firstChild);
                  }

                  document.getElementById("workDate").innerHTML
                    +=  '<option value="">근무일자</option>';

                  for (var i=0; i<data.listData.length; i++ ){
                      document.getElementById("workDate").innerHTML
                        += '<option value="'+data.listData[i].work_join_list_no+'">'+data.listData[i].work_date+'</option>';

                  }

    			  var cell = document.getElementById("reviewListArea");

                  while (cell.hasChildNodes()){
                      cell.removeChild(cell.firstChild);
                  }

                  document.getElementById("reviewListArea").innerHTML
                    +=  '<h4 class="di mt30">평가보기</h4>'
					+ 	'<h5 class="di c999 f10">총 <strong class="fc">'+data.reviewList.length+'</strong>개의 평가가 있습니다.</h5>'

                  for (var i=0; i<data.reviewList.length; i++ ){

						  var starCnt = Number(data.reviewList[i].score);
						  console.log(starCnt);

                  document.getElementById("reviewListArea").innerHTML

		                  += '<div class="reviewContentWrap border-top">'
						  +	  '<div>'
						  +	  '<div class="reviewLine border-bottom p25">'
						  +	  '<div class="di w10">'
						  +	  	'<img src="http://il-bang.com/pc_renewal/images/review01.png" alt="리뷰"/>'
						  +	  '</div>'
						  +	  '<div class="di w78p">'
						  +	  	'<p class="bold fl">익명입니다.</p>'
						  +		'<div id="rateYo'+i+'" class="fl"></div>'	
						  +	  	'<a href="#"><img src="http://il-bang.com/pc_renewal/images/review02.png" alt="삭제"/></a>'
						  +	  		'<div class="clear"></div>'
						  +	  		'<p>'+data.reviewList[i].content+'</p>'
						  +	  		'</div>'
						  +	  		'<div class="c999 di w10">'
						  +	  			'<img src="" /><span>'+data.reviewList[i].wdate+'</span>'
						  +	  		'</div>'
						  +	  	'</div><div class="clear"></div>'
						  +	  '</div>';

						   
						    $("#rateYo"+i).rateYo({						      
						      starWidth:"10px",
						      rating:starCnt
						    });
						  	console.log("#rateYo"+i);
					}

	            }
	     })
	}
	function insertReview(){
		var work_join_list_no	= $("#workDate option:selected").val();	
		var reviewContent 		= $("#reviewContent").val();
		var euid				= $("#Heuid").val();
		var ruid				= $("#Hruid").val();
		var score				= $("#Hscore").val();

		if (work_join_list_no == ''){
			alert('리뷰를 작성할 근무일자를 선택해주세요.');
			return ;
		}

		if (reviewContent == ''){
			alert('리뷰를 작성하세요.');
			$("#reviewContent").focus();
			return ;
		}

		$.ajax({
	             type: 'post',
	             dataType: 'json',
	             url: '../ajax/guin/insertEmployReview.php',
	             data: {work_join_list_no:work_join_list_no,reviewContent:reviewContent,euid:euid,ruid:ruid,score:score},
	             success: function (data) {
	             	if(data.result == 1){
	             		alert("리뷰가 등록되었습니다.");
	             		getEmployReviewInfo();
	             	} else {
	             		alert("리뷰 등록 실패하였습니다.")
	             	}

	            }
	     })
	

	}

	function setScore(score){
		$("#Hscore").val(score);
	}

</script>
<input type="hidden" id="Hscore">
<input type="hidden" id="Heuid">
<input type="hidden" id="Hruid">

<div class="container">	
	<div class="guinjikTabWrap">
	  <div class="tab-content">

	  <!-- 첫번째 탭 내용 -->
	    <div role="tabpanel" class="tab-pane active mt10" id="gujikTab1">
	      
			<div class="gujikDetSect1 mt50">
				<div class="border-navy">
					<h4 class="bg_navy f_white padding-vertical tc noMargin f16">평가보기</h4>
					<ul class="detailInfoUl_gujik pr">
						<li class="bb padding">
							<span class="di w10">구인자</span><span id="company"><?php echo $comapny ?></span>
						</li>
						<li class="bb padding">
							<span class="di w10">성별/나이</span><span id="sexNage"><?php echo $sex ?>, <?php echo $age ?></span>
						</li>
						<li class="padding">
							<span class="di w10">평점</span>
							<span class="star-input3">
								<span class="input">
								  <input type="radio" name="star-input3" id="stAvg1" value="1"><label for="stAvg1">1</label>
								  <input type="radio" name="star-input3" id="stAvg2" value="2"><label for="stAvg2">2</label>
								  <input type="radio" name="star-input3" id="stAvg3" value="3"><label for="stAvg3">3</label>
								  <input type="radio" name="star-input3" id="stAvg4" value="4"><label for="stAvg4">4</label>
								  <input type="radio" name="star-input3" id="stAvg5" value="5"><label for="stAvg5">5</label>
								  <input type="radio" name="star-input3" id="stAvg6" value="6"><label for="stAvg6">6</label>
								  <input type="radio" name="star-input3" id="stAvg7" value="7"><label for="stAvg7">7</label>
								  <input type="radio" name="star-input3" id="stAvg8" value="8"><label for="stAvg8">8</label>
								  <input type="radio" name="star-input3" id="stAvg9" value="9"><label for="stAvg9">9</label>
								  <input type="radio" name="star-input3" id="stAvg10" value="10"><label for="stAvg10">10</label>
								</span>
							</span>
							<span class="fc" id="totalScore">3.0점</span>/<span>5.0점 (총 <span>04</span>명의 구직자가 평가했습니다.)</span>
						</li>
						<li class="pa tc" style="left:0; top:0; width:18%">
							<img id="profileImg"  alt="" width="50%" style="margin-top:8%">
						</li>
					</ul>
				</div>
			</div> 
			<div class="reviewWrap" id="reviewListArea">
				<!--
				<h4 class="di mt30">평가보기</h4>
				<h5 class="di c999 f10">총 <strong class="fc">4</strong>개의 평가가 있습니다.</h5>
				-->
				<!--
				<div class="reviewContentWrap border-top">
					<div>
						<div class="reviewLine border-bottom p25">
							<div class="di w10">
								<img src="http://il-bang.com/pc_renewal/images/review01.png" alt="리뷰"/>
							</div>
							<div class="di w78p">
								<p class="bold fl">익명입니다.</p>
								<span class="star-input2">
								  <span class="input">
								    <input type="radio" name="star-input2" id="st1" value="1"><label for="st1">1</label>
								    <input type="radio" name="star-input2" id="st2" value="2"><label for="st2">2</label>
								    <input type="radio" name="star-input2" id="st3" value="3"><label for="st3">3</label>
								    <input type="radio" name="star-input2" id="st4" value="4"><label for="st4">4</label>
								    <input type="radio" name="star-input2" id="st5" value="5"><label for="st5">5</label>
								    <input type="radio" name="star-input2" id="st6" value="6"><label for="st6">6</label>
								    <input type="radio" name="star-input2" id="st7" value="7"><label for="st7">7</label>
								    <input type="radio" name="star-input2" id="st8" value="8"><label for="st8">8</label>
								    <input type="radio" name="star-input2" id="st9" value="9"><label for="st9">9</label>
								    <input type="radio" name="star-input2" id="st10" value="10"><label for="st10">10</label>
								  </span>
								</span>
								<a href="#"><img src="http://il-bang.com/pc_renewal/images/review02.png" alt="삭제"/></a>
								<div class="clear"></div>
								<p>다들 불경기다 불경기다 하는데 구인자는 좋은 인재를 구하기가 힘들고 구직자는 좋은 일자리를 구하기가 힘이든 거 같습니다.ㅜㅜㅜ그래도 성실하게 일 마쳐주세서 안심이 되네요.</p>
							</div>
							<div class="c999 di w10">
								<img src="" /><span>2016. 12. 07</span>
							</div>
						</div><div class="clear"></div>
					</div>
					<div>
						<div class="reviewLine border-bottom p25">
							<div class="di w10">
								<img src="http://il-bang.com/pc_renewal/images/review01.png" alt="리뷰"/>
							</div>
							<div class="di w78p">
								<p class="bold fl">익명입니다.</p>
								<span class="star-input2">
								  <span class="input">
								    <input type="radio" name="star-input2" id="st1" value="1"><label for="st1">1</label>
								    <input type="radio" name="star-input2" id="st2" value="2"><label for="st2">2</label>
								    <input type="radio" name="star-input2" id="st3" value="3"><label for="st3">3</label>
								    <input type="radio" name="star-input2" id="st4" value="4"><label for="st4">4</label>
								    <input type="radio" name="star-input2" id="st5" value="5"><label for="st5">5</label>
								    <input type="radio" name="star-input2" id="st6" value="6"><label for="st6">6</label>
								    <input type="radio" name="star-input2" id="st7" value="7"><label for="st7">7</label>
								    <input type="radio" name="star-input2" id="st8" value="8"><label for="st8">8</label>
								    <input type="radio" name="star-input2" id="st9" value="9"><label for="st9">9</label>
								    <input type="radio" name="star-input2" id="st10" value="10"><label for="st10">10</label>
								  </span>
								</span>	
								<a href="#"><img src="http://il-bang.com/pc_renewal/images/review02.png" alt="삭제"/></a>
								<div class="clear"></div>
								<p>다들 불경기다 불경기다 하는데 구인자는 좋은 인재를 구하기가 힘들고 구직자는 좋은 일자리를 구하기가 힘이든 거 같습니다.ㅜㅜㅜ그래도 성실하게 일 마쳐주세서 안심이 되네요.</p>
							</div>
							<div class="c999 di w10">
								<img src="" /><span>2016. 12. 07</span>
							</div>
						</div><div class="clear"></div>
					</div>
					<div>
						<div class="reviewLine border-bottom p25">
							<div class="di w10">
								<img src="http://il-bang.com/pc_renewal/images/review01.png" alt="리뷰"/>
							</div>
							<div class="di w78p">
								<p class="bold fl">익명입니다.</p>
								<span class="star-input2">
								  <span class="input">
								    <input type="radio" name="star-input2" id="st1" value="1"><label for="st1">1</label>
								    <input type="radio" name="star-input2" id="st2" value="2"><label for="st2">2</label>
								    <input type="radio" name="star-input2" id="st3" value="3"><label for="st3">3</label>
								    <input type="radio" name="star-input2" id="st4" value="4"><label for="st4">4</label>
								    <input type="radio" name="star-input2" id="st5" value="5"><label for="st5">5</label>
								    <input type="radio" name="star-input2" id="st6" value="6"><label for="st6">6</label>
								    <input type="radio" name="star-input2" id="st7" value="7"><label for="st7">7</label>
								    <input type="radio" name="star-input2" id="st8" value="8"><label for="st8">8</label>
								    <input type="radio" name="star-input2" id="st9" value="9"><label for="st9">9</label>
								    <input type="radio" name="star-input2" id="st10" value="10"><label for="st10">10</label>
								  </span>
								</span>
								<a href="#"><img src="http://il-bang.com/pc_renewal/images/review02.png" alt="삭제"/></a>
								<div class="clear"></div>
								<p>다들 불경기다 불경기다 하는데 구인자는 좋은 인재를 구하기가 힘들고 구직자는 좋은 일자리를 구하기가 힘이든 거 같습니다.ㅜㅜㅜ그래도 성실하게 일 마쳐주세서 안심이 되네요.</p>
							</div>
							<div class="c999 di w10">
								<img src="" /><span>2016. 12. 07</span>
							</div>
						</div><div class="clear"></div>
					</div>
					<div>
						<div class="reviewLine border-bottom p25">
							<div class="di w10">
								<img src="http://il-bang.com/pc_renewal/images/review01.png" alt="리뷰"/>
							</div>
							<div class="di w78p">
								<p class="bold fl">익명입니다.</p>
								<span class="star-input2">
								  <span class="input">
								    <input type="radio" name="star-input2" id="st1" value="1"><label for="st1">1</label>
								    <input type="radio" name="star-input2" id="st2" value="2"><label for="st2">2</label>
								    <input type="radio" name="star-input2" id="st3" value="3"><label for="st3">3</label>
								    <input type="radio" name="star-input2" id="st4" value="4"><label for="st4">4</label>
								    <input type="radio" name="star-input2" id="st5" value="5"><label for="st5">5</label>
								    <input type="radio" name="star-input2" id="st6" value="6"><label for="st6">6</label>
								    <input type="radio" name="star-input2" id="st7" value="7"><label for="st7">7</label>
								    <input type="radio" name="star-input2" id="st8" value="8"><label for="st8">8</label>
								    <input type="radio" name="star-input2" id="st9" value="9"><label for="st9">9</label>
								    <input type="radio" name="star-input2" id="st10" value="10"><label for="st10">10</label>
								  </span>
								</span>	
								<a href="#"><img src="http://il-bang.com/pc_renewal/images/review02.png" alt="삭제"/></a>
								<div class="clear"></div>
								<p>다들 불경기다 불경기다 하는데 구인자는 좋은 인재를 구하기가 힘들고 구직자는 좋은 일자리를 구하기가 힘이든 거 같습니다.ㅜㅜㅜ그래도 성실하게 일 마쳐주세서 안심이 되네요.</p>
							</div>
							<div class="c999 di w10">
								<img src="" /><span>2016. 12. 07</span>
							</div>
						</div><div class="clear"></div>
					</div>
					-->
				</div>
			</div>

			<select id="workDate">
			</select> 근무일자를 선택하여 리뷰를 남겨주세요.

	      	<div class="reviewWrtWrap mt30 mb50">
					
					<div class="starWrap fl">
						<div id="rateYo2" class="fl"></div>
					  <div class="rating noPadding fr" style="width:57px; text-align: right"><b>0</b>/5.0</div>
											<script>
												$(function () {
												 
												  $("#rateYo2").rateYo({
												    	onChange: function (rating, rateYoInstance) {
												          $(".rating b").text(rating);
												        },
												        halfStar: true,
												        starWidth:'15px'
												  });
												  	var userRating = $("#rateYo2").rateYo();
												  	
												  	 $(".toto").click(function () {
												  	
												  	   /* get rating */
												  	   var rating = userRating.rateYo("rating");
												  	
												  	   
												  	   $("#Hscore").val(rating);
												  	 });
												  	
												});
												

												  
											</script>
	                </div>
	                <input type="text" class="form-control fl reviewTextarea" id="reviewContent" rows="3" placeholder="솔직한 후기를 남겨주세요. (매칭완료자만 리뷰를 작성하실 수 있습니다.) " />
	                <button onclick="javascript:insertReview()" class="btn btn-primary reviewWrtBtn fl">리뷰등록</button>
	            <div class="clear"></div>		
	      	</div>

	    </div>
	    <!-- 두번째 탭 내용 -->
	    <div role="tabpanel" class="tab-pane mt10" id="gujikTab2">
	        
	    </div>
	    <div role="tabpanel" class="tab-pane mt10" id="gujikTab3">
	       
	    </div>
	    <div role="tabpanel" class="tab-pane mt10" id="gujikTab4">
	       
	    </div>
	  </div>
	</div>
</div>

<script>

</script>
<?php include_once "../include/footer.php"; ?>