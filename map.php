<?php include_once "include/header.php" ?>

	<section id="mapSection">
	          
	          <div class="container-fluid">
	          <!-- 1번  -->
          		<div class="padding">
          			작정하신 구인신청서에 대한 매칭결과입니다.
          		</div>
	              <div class="row mb10">
	              		<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 noPadding">
	              		  <?php include "map/map_inc.php" ?>
	              		</div>
	                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 noPadding listWrap">
	                 
	                      <div class="list_title lt_active">검색결과 <span id="searchCnt"></span>개</div>
	                      
	                      <ul class="addr_ul matching_tab display">
	                      <!-- 토탈카운트 -->
	                      
	                               



	                          

	                       </ul>

	                       <div class="row text-center">
	                          <ul class="pagination di" id="libangListPagingArea">

	                          </ul>
	                        </div>
	                 </div>
	                 

	              </div>
	          </div>
	      </section>
<?php include_once "include/footer.php" ?>