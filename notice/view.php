<?php include_once "../include/header.php"; ?>
<script>
    var no = <?php echo $_GET["no"]; ?>;

    $.ajax({
        type: 'post',
        dataType: 'json',
        url: '../ajax/notice/getNotice.php',
        data: { no: no },
        success: function(data) {
            document.getElementById("boardTitle").innerHTML = data.board.title;
            document.getElementById("boardDate").innerHTML = data.board.date;
            document.getElementById("boardHit").innerHTML = '조회수 ' + data.board.hit;

            for(var i=0; i<data.board.file; i++) {
                document.getElementById("boardContent").innerHTML
                += '<img src="http://mmcp.co.kr/board2/data/file/notice1/' + data.board.fileList[i] + '" /><br /><br />';
            }

            document.getElementById("boardContent").innerHTML += data.board.content;

            if(data.board.link1 != "") {
                document.getElementById("boardContent").innerHTML
                += '<br /><a href="' + data.board.link1 + '">'
                + '<div style="color: #87afeb">' + data.board.link1 + '</div>'
                + '</a>';
            }

            if(data.board.link2 != "") {
                document.getElementById("boardContent").innerHTML
                += '<a href="' + data.board.link2 + '">'
                + '<div style="color: #87afeb">' + data.board.link2 + '</div>'
                + '</a>';
            }

            if(data.board.nextNo == "") {
                document.getElementById("nextBtn").onclick = function() {
                    alert("다음 글이 없습니다.");
                    return false;
                }

                document.getElementById("nextTitle").innerHTML = '다음 글이 없습니다.';
            } else {
                var nextUrl = "view.php?no=" + data.board.nextNo;

                document.getElementById("nextBtn").setAttribute('href', nextUrl);
                document.getElementById("nextTitle").innerHTML = '<a href="view.php?no=' + data.board.nextNo + '">' + data.board.next + '</a>';
            }

            if(data.board.prevNo == "") {
                document.getElementById("prevTtile").innerHTML = "이전 글이 없습니다.";
            } else {
                document.getElementById("prevTtile").innerHTML = '<a href="view.php?no=' + data.board.prevNo + '">' + data.board.prev + '</a>';
            }
        }
    });
</script>
<div class="container center wdfull bb">
    <div class="pg_rp"> 
        <div class="c999 fl subTitle">HOME > <b class="c555">공지사항</b></div>
    </div>
</div>
<div class="bannerArea">
    <img src="../images/news-banner.png" width="100%" />
</div>
<div class="pdtb30 oa margin-auto wdfull lh1 f12">
    <div class="margin-auto c666 mb10 container pl25">
        <div class="mb5">
            <span class="f16 bold mr5">공지사항</span>
            <span class="c888">일방 서비스의 새로운 소식을 확인하세요.</span>
        </div>
        <div class="mt10 adListBorder bg_eee bold" style="padding: 12px 15px;" id="boardTitle"></div>
        <div class="oh bb" style="padding: 5px 15px;">
            <div class="fl" style="padding: 5px 0;">
                <span class="bold mr15">관리자</span>
                <span class="c888 mr15" id="boardDate"></span>
                <span class="c888" id="boardHit"></span>                
            </div>
            <div class="fr oh f10">
                <a href="news.php"><div class="fl mr5 noticeViewBtn">목록</div></a>
                <a href="#" id="nextBtn"><div class="fl noticeViewBtn">다음</div></a>
            </div>
        </div>
        <div class="tc" style="padding: 30px 15px; line-height: 18px;" id="boardContent"></div>
        <div class="noticeNextPrev">
            <div class="bb" style="padding: 12px 15px;">
                <span class="bold">다음 글</span>
                <span style="margin: 0 15px;">|</span>
                <span id="nextTitle"></span>
            </div>
            <div style="padding: 12px 15px;">
                <span class="bold">이전 글</span>
                <span style="margin: 0 15px;">|</span>
                <span id="prevTtile"></span>
            </div>
        </div>
    </div>    
</div>
<?php include_once "../include/footer.php" ?>   