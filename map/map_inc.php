
<?php
  $userAgent = $_SERVER['HTTP_USER_AGENT']; 

  if ( preg_match("/MSIE*/", $userAgent)){
    // 익스플로러
    if ( preg_match("/MSIE 6.0[0-9]*/", $userAgent)) {
      $browser = "Explorer 6";
    } else if ( preg_match("/MSIE 7.0*/", $userAgent)){
      $browser = "Explorer 7";
    } else if ( preg_match("/MSIE 8.0*/", $userAgent)){
      $browser = "Explorer 8";
    } else if ( preg_match("/MSIE 9.0*/", $userAgent)){
      $browser = "Explorer 9";
    } else if ( preg_match("/MSIE 10.0*/", $userAgent)){
      $browser = "Explorer 10";
    }else {
      $browser = "Explorer ETC";
    }
  } else if ( preg_match("/Trident*/", $userAgent && preg_match("/rv:11.0*/", $userAgent && preg_match("/Gecko*/", $userAgent)))){
      $browser = "Explorer 11";
  } else if ( preg_match("/Chrome*/", $userAgent)) {
    // 크롬
    $browser = "chrome";
  } else if ( preg_match("/Safari*/", $userAgent)) {
    // 사파리
    $browser = "safari";    
  } else if ( preg_match("/(Mozilla)*/", $userAgent)) {
    // 모질라 (파이어폭스)
    $browser = "mozilla";
  } else if ( preg_match("/(Nav|Gold|X11|Mozilla|Nav|Netscape)*/", $userAgent)) {
    // 네스케이프, 모질라(파이어폭스)
    $browser = "Netscape/mozilla";
  } else if ( preg_match("/Opera*/", $userAgent)) {
    // 오페라
    $browser = "Opera";
  } else {
    $browser = "Other";
  }
?>

<div id="map_update" style="width:100%;height:590px;"></div>


<script type="text/javascript" src="//apis.daum.net/maps/maps3.js?apikey=a71a80444aab6a1aa80838b60e25c418&libraries=services"></script>
<script>
var lat =37.5615367;
var lng = 126.9795475;





// 마커를 클릭하면 장소명을 표출할 인포윈도우 입니다
var infowindow = new daum.maps.InfoWindow({zIndex:1});

var mapContainer = document.getElementById('map_update'), // 지도를 표시할 div 
    mapOption = {
        // center: new daum.maps.LatLng(lat, lng), // 지도의 중심좌표
         center: new daum.maps.LatLng(lat, lng),
        level: 5 // 지도의 확대 레벨
    };  

// 지도를 생성합니다    
var map_update = new daum.maps.Map(mapContainer, mapOption); 


// 주소-좌표 변환 객체를 생성합니다
var geocoder = new daum.maps.services.Geocoder();

var marker = new daum.maps.Marker(), // 클릭한 위치를 표시할 마커입니다
    infowindow = new daum.maps.InfoWindow({zindex:1}); // 클릭한 위치에 대한 주소를 표시할 인포윈도우입니다


// 장소 검색 객체를 생성합니다


// 키워드 검색 완료 시 호출되는 콜백함수 입니다
function loadIlbangList(data){
 


    
    if(data.no != null){
     var bounds = new daum.maps.LatLngBounds();
      for (var i=0; i<data.no.length; i++ ){   
        // alert(data.no[i]+'='+data.subject[i]+'='+data.lat[i]+'='+data.lng[i]);
         displayMarker(data.no[i],data.subject[i],data.lat[i], data.lng[i], data.company[i], data.address2[i], data.pay[i]);
           bounds.extend(new daum.maps.LatLng(data.lat[i], data.lng[i]));
      }

       map_update.setBounds(bounds);
    }
}

// 지도에 마커를 표시하는 함수입니다
function displayMarker(no,title,lat,lng,company, address2, pay) {
    
    // 마커를 생성하고 지도에 표시합니다
    var marker = new daum.maps.Marker({
        map: map_update,
        position: new daum.maps.LatLng(lat, lng) 
    });

    // 마커에 클릭이벤트를 등록합니다
    daum.maps.event.addListener(marker, 'click', function() {
        // 마커를 클릭하면 장소명이 인포윈도우에 표출됩니다
        //infowindow.setContent('<a class="mapTooltip" href="../job/form05.php?no='+no+'"><span class="di PlTlt">'+ no +'</span>'+title+'<br><span class="di plInfo">'+lng+'<br></span></a>');
        infowindow.setContent('<a class="mapTooltip" href="http://il-bang.com/ilbang_pc/form05.php?no='+no+'"><span class="di PlTlt" style="padding-left:10px; width:90%">'+ title +'</span><br><span class="di plComp" style="padding-left:10px">상호:'+company+'</span> <br><span class="di plPay" style="padding-left:10px">일당:'+pay+'</span> <br><span class="di plAddr" style="padding-left:10px">주소:'+address2+'</span></a>');
        infowindow.open(map_update, marker);
        
    });
}
// 현재 지도 중심좌표로 주소를 검색해서 지도 좌측 상단에 표시합니다
searchAddrFromCoords(map_update.getCenter(), displayCenterInfo);

    

// 중심 좌표나 확대 수준이 변경됐을 때 지도 중심 좌표에 대한 주소 정보를 표시하도록 이벤트를 등록합니다
daum.maps.event.addListener(map_update, 'idle', function() {
    searchAddrFromCoords(map_update.getCenter(), displayCenterInfo);
});

function searchAddrFromCoords(coords, callback) {
    // 좌표로 행정동 주소 정보를 요청합니다
    geocoder.coord2addr(coords, callback);         
}

function searchDetailAddrFromCoords(coords, callback) {
    // 좌표로 법정동 상세 주소 정보를 요청합니다
    geocoder.coord2detailaddr(coords, callback);
}

// 지도 좌측상단에 지도 중심좌표에 대한 주소정보를 표출하는 함수입니다
function displayCenterInfo(status, result) {
    if (status === daum.maps.services.Status.OK) {
        var infoDiv = document.getElementById('centerAddr');
        //infoDiv.innerHTML = result[0].fullName;
    }    
}

//alert();

        

</script>

<style>
  .mapTooltip{font-size:12px;}  
  .mapTooltip span{width:100%;}  
  .PlTlt{font-size:14px; font-weight:bold; color:#ff8647; margin:0 auto; overflow: hidden; text-overflow: ellipsis; white-space: nowrap}
  .plInfo{color:black;}
  </style>
