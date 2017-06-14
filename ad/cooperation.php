<?php include_once "../include/header.php"; ?>
<script>
    $.ajax({
        type: 'post',
        dataType: 'json',
        url: '../ajax/notice/getNoticeList.php',
        success: function(data) {
            for(var i=0; i<1; i++) {
                document.getElementById("adNotice").innerHTML
                = '<a href="../notice/view.php?no=' + data.noticeList[i].no + '" class="c999">' + data.noticeList[i].title + '</a>';
            }
        }
    });
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > <b class="c555">업무 제휴</b></div>
        <div class="c999 fr padding-vertical">
            <span class="mr5 br15 subNotice">공지</span>
            <span id="adNotice"></span></a>
        </div>
    </div>
</div>
<div class="adbg mt15 wdfull oh" style="border-bottom: 1px solid #bbb;">
    <div class="margin-auto container pl25 pdt40 pb10"> 
        <img src="../images/cooperation1.png" />
        <img src="../images/cooperation2.png" class="fr pr15"/>
    </div><div class="clear"></div>
</div>
<div class="wdfull c666 tc">
    <div class="margin-auto mt50" style="width: 218px;">
        <img src="../images/cooperation3.png" />
    </div>
    <div class="f14 mt20">
        <div>신청서를 작성해주시면 확인 후 빠른 시일 내에</div>
        <div class="mt5">연락 드리겠습니다.</div>
    </div>
    <div class="margin-auto container pl20">
        <form action="cooperationProcess.php" method="post" class="mt50 w80 margin-auto" onsubmit="return formCheck()" style="border-top: 3px solid #4a5470;">
            <div class="oa bb">
                <div class="adFormTitle bg_eee w15 fl">제목 <span class="fc">*</span></div>
                <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="title" name="title" placeholder="제목을 입력하세요." /></div>
                <div class="adFormTitle bg_eee w15 fl">이름 <span class="fc">*</span></div>
                <div class="w35 pdtb1p fl"><input type="text" class="adForminput" id="name" name="adName" placeholder="이름을 입력하세요." /></div>
            </div>
            <div class="oa bb">
                <div class="adFormTitle bg_eee w15 fl">전화번호 <span class="fc">*</span></div>
                <div class="w85 pdtb1p fl">
                    <div class="fl">
                        <input type="text" class="adForminput" id="phone1" name="phone1" placeholder="010" style="width: 80px;" />
                        <span>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                        <input type="text" class="adForminput" id="phone2" name="phone2" style="width: 80px;" />
                        <span>&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                        <input type="text" class="adForminput" id="phone3" name="phone3" style="width: 80px;" />                        
                    </div>
                </div>
            </div>
            <div class="oa bb">
                <div class="adFormTitle bg_eee w15 fl">이메일 <span class="fc">*</span></div>
                <div class="w85 pdtb1p fl">
                    <div class="fl">
                        <input type="text" class="adForminput" id="email1" name="email1" placeholder="이메일 주소 입력" style="width: 150px;" />
                        <span>&nbsp;&nbsp;@&nbsp;&nbsp;</span>
                        <input type="text" class="adForminput" id="email2" name="email2" placeholder="naver.com" style="width: 150px;" />
                    </div>
                </div>
            </div>
            <div class="oa bb">
                <div class="adFormTitle bg_eee w15 fl">회사명 <span class="fc">*</span></div>
                <div class="w85 pdtb1p fl"><input type="text" id="company" class="adForminput" name="company" placeholder="회사명을 입력하세요." /></div>
            </div>
            <div class="bb" style="height: 213px;">
                <div class="adFormTitle bg_eee w15 fl" style="height: 212px;">내용 <span class="fc">*</span></div>
                <div class="w85 pdtb1p fl">
                    <textarea class="adForminput" id="content" name="content" placeholder="내용을 입력하세요." style="height: 200px; padding-top: 5px;"></textarea>
                </div>
            </div>
            <div class="oa margin-auto mt50" style="width: 150px;">
                <input type="submit" class="adBtn fl fff f14" style="background-color: #4a5470;" value="업무 제휴 신청" />
            </div>
        </form>
        <div class="pb10 mt100 tl">
            <div class="border-bottom bc_darkgrey pb10">
                <span class="f16 bold mr5 c666">업무 제휴</span>
                <span class="c888">업무 제휴 신청을 하시면 일방의 제휴 업체가 되실 수 있습니다.</span>
                <!-- <a href="cooperation.php"><span class="fr adMore">더보기 +</span></a> -->
            </div>
            <div class="slider">
                <!-- This will be considered one slide -->
                <div class="adPartnerWrap mt15">    
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                        <a href="http://www.goodtv.co.kr/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner01.png" class="mt20"/>
                        <span class="db mt40 mb20">굿티비</span>  
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                        <a href="http://tshome.co.kr/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner02.png" class="mt20"/>
                        <span class="db mt40 mb20">TS 솔루션</span>  
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                        <!-- <a href="javascript:void(0);"><span class="db tr p5">바로가기 +</span></a> -->
                        <img src="http://il-bang.com/pc_renewal/images/adPartner03.png" class="pt47"/>
                        <span class="db mt40 mb20">텐플러스</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                        <a href="http://www.caa.or.kr/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner04.png" class="mt20"/>
                        <span class="db mt40 mb20">대한 팔씨름협회</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc">
                        <a href="http://maj.fgtv.com/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner05.png" class="mt20"/>
                        <span class="db mt40 mb20">순복음취업박람회</span>
                    </div>
                    <br class="clearboth" style="clear: both;">

                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href="http://www.911tv.co.kr/DF0001.php"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner06.png" class="mt20"/>
                        <span class="db mt55 mb20">시민학생 구조단</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href="http://homepy.korean.net/~kazkorean/www/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner07.png" class="mt20"/>
                        <span class="db mt55 mb20">카자흐스탄교민협회</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href="http://www.gigaad.co.kr/index.php"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner08.png" class="mt20"/>
                        <span class="db mt55 mb20">기가애드</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href="http://homepy.korean.net/~srilanka/www/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner09.png" class="mt20"/>
                        <span class="db mt40 mb20">스리랑카 한인회</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mt10">
                        <!-- <a href="javascript:void(0);"><span class="db tr p5">바로가기 +</span></a> -->
                        <img src="http://il-bang.com/pc_renewal/images/adPartner10.png" class="pt47"/>
                        <span class="db mt40 mb20">한국대중문회예술인기념사업회</span>
                    </div>

                    <br class="clearboth" style="clear: both;">

                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <!-- <a href="javascript:void(0);"><span class="db tr p5">바로가기 +</span></a> -->
                        <img src="http://il-bang.com/pc_renewal/images/adPartner11.png" class="pt47"/>
                        <span class="db mt40 mb20">한국웃음운동 청소년진흥회</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href="http://www.babytimes.co.kr/n_news/main/index.html"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner12.png" class="mt20"/>
                        <span class="db mt40 mb20">베이비타임즈</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href="http://challengekorea.or.kr/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner13.png" class="mt20"/>
                        <span class="db mt40 mb20">도전한국인운동본부 </span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href="http://www.kbu.ac.kr/index.html"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner14.png" class="mt20"/>
                        <span class="db mt40 mb20">경복대학교</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mt10">
                        <!-- <a href="javascript:void(0);"><span class="db tr p5">바로가기 +</span></a> -->
                        <img src="http://il-bang.com/pc_renewal/images/adPartner15.png" class="pt47"/>
                        <span class="db mt40 mb20">DM몰</span>
                    </div>

                </div>

                <!-- The second slide -->
                <div class="adPartnerWrap mt15">    
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                        <!-- <a href="javascript:void(0);"><span class="db tr p5">바로가기 +</span></a> -->
                        <img src="http://il-bang.com/pc_renewal/images/adPartner16.png" class="pt47"/>
                        <span class="db mt40 mb20">명익</span>  
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                        <a href="http://www.dcwnews.com/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner17.png" class="mt20"/>
                        <span class="db mt40 mb20">장애인문화복지신문</span>  
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                        <a href="http://www.kpu.ac.kr/index.do"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner18.png" class="mt20"/>
                        <span class="db mt40 mb20">한국산업기술대학교</span>
                    </div>
                     <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10">
                        <a href="https://www.facebook.com/%EC%9E%A5%EB%B9%84%EB%B0%98%EC%9E%A5-850665301743322/"><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner19.png" class="mt20" width="55%"/>
                        <span class="db mt40 mb20">장비반장</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc">
                        <a href="http://csbn.co.kr/ "><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner20.png" class="mt20"/>
                        <span class="db mt40 mb20">한국안전방송</span>
                    </div>
                    <br class="clearboth" style="clear: both;">
                    <!--
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner01.png" class="mt20"/>
                        <span class="db mt40 mb20">굿티비</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner02.png" class="mt20"/>
                        <span class="db mt40 mb20">TS 솔루션</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner03.png" class="mt20"/>
                        <span class="db mt40 mb20">텐플러스</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner04.png" class="mt20"/>
                        <span class="db mt40 mb20">대한 팔씨름협회</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner05.png" class="mt20"/>
                        <span class="db mt40 mb20">순복음취업박람회</span>
                    </div>

                    <br class="clearboth" style="clear: both;">

                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner01.png" class="mt20"/>
                        <span class="db mt40 mb20">굿티비</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner02.png" class="mt20"/>
                        <span class="db mt40 mb20">TS 솔루션</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner03.png" class="mt20"/>
                        <span class="db mt40 mb20">텐플러스</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mr10 mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner04.png" class="mt20"/>
                        <span class="db mt40 mb20">대한 팔씨름협회</span>
                    </div>
                    <div class="grandchild col-sm-4 w19_2 border-grey bg_f8 tc mt10">
                        <a href=""><span class="db tr p5">바로가기 +</span></a>
                        <img src="http://il-bang.com/pc_renewal/images/adPartner05.png" class="mt20"/>
                        <span class="db mt40 mb20">순복음취업박람회</span>
                    </div> -->


                </div>
            </div>
 

            <script type="text/javascript">
                $(document).ready(function() {
                    $('.slider').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    });
                });

            </script>

        </div>
    </div>
</div>
<script>
    function formCheck() {
        var id = "<?php echo $uid; ?>";
        var title = document.getElementById("title").value;
        var name = document.getElementById("name").value;
        var phone1 = document.getElementById("phone1").value;
        var phone2 = document.getElementById("phone2").value;
        var phone3 = document.getElementById("phone3").value;
        var email1 = document.getElementById("email1").value;
        var email2 = document.getElementById("email2").value;
        var company = document.getElementById("company").value;
        var content = document.getElementById("content").value;

        if(id == "") {
            alert("로그인 후 이용해주세요.");
            return false;
        } else if(title == "") {
            alert("제목을 입력해주세요.");
            return false;
        } else if(name == "") {
            alert("이름을 입력해주세요.");
            return false;
        } else if(phone1 == "" || phone2 == "" || phone3 == "") {
            alert("전화번호를 입력해주세요.");
            return false;
        } else if(email1 == "" || email2 == "") {
            alert("이메일을 입력해주세요.");
            return false;
        } else if(company == "") {
            alert("회사명을 입력해주세요.");
            return false;
        } else if(content == "") {
            alert("내용을 입력해주세요.");
            return false;
        }

        return true;
    }
</script>
<div class="pdtb30 oa margin-auto" style="width: 1100px;" >
    <?php include_once "adFooter.php"; ?>
</div>
<?php include_once "../include/footer.php"; ?>