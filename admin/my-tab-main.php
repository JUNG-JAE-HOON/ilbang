<script>
    $(document).ready(function() {
        var cell = document.getElementById("chartYear");

        while (cell.hasChildNodes()){
            cell.removeChild(cell.firstChild);
        }

        var d = new Date();
        var n = d.getFullYear();

        for(var i=2016; i<=n; i++){
            document.getElementById("chartYear").innerHTML
            += '<option value="'+i+'">'+i+'</option>';
        }

        $("#chartYear").val(n);

        drawChart();
        getMyInfoCounter();
        getNoticeList();
    });

    function refreshAdminMain(){
        drawChart();
        getMyInfoCounter();
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


    function getMyInfoCounter() {
        var adminId = '<?php echo $uid; ?>';

        if(adminId != "") {
            $.ajax({
                type: 'post',
                dataType: 'json',
                url: '../ajax/admin/getMyInfoCounter.php',
                data: {adminId:adminId},
                success: function (data) {
                    new numberCounter("indexMyRecmdCnt", data.myRecmdCnt);
                    new numberCounter("indexTotalGuinCnt", data.totalGuinCnt);
                    new numberCounter("indexTotalGujikCnt", data.totalGujikCnt);
                    
                    new numberCounter("myRecmdCnt", data.myRecmdCnt);
                    new numberCounter("totalGuinCnt", data.totalGuinCnt);
                    new numberCounter("totalGujikCnt", data.totalGujikCnt);
                }
            });
        }
    }

    function drawChart() {
        var adminId = '<?php echo $uid; ?>';
        var year = $("#chartYear option:selected").val();
        
        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/admin/getMainChartData.php',
            data: { adminId: adminId, year: year },
            success: function (data) {
                    var chartData = data.chartData
                  if('<?php echo $uid ?>'=="") {
                       chartData  = [
                                        {
                                            "seriesname": "구인중",
                                            "data": [
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                }
                                            ]
                                        },
                                        {
                                            "seriesname": "구직중",
                                            "data": [
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                },
                                                {
                                                    "value": "0"
                                                }
                                            ]
                                        }
                                    ]
                    }

                FusionCharts.ready(function() {

                 

                    var revenueChart = new FusionCharts({
                        "type": "msline",//msline , column2d
                        "renderAt": "chartContainer",
                        "width": "500",
                        "height": "300",
                        "dataFormat": "json",
                        "dataSource": {
                            "chart": {
                                // "caption": "Harry's SuperMart - Comparison of yearly sales ",
                                // "subcaption": "2015 v 2014",
                                // "numberprefix": "건",
                                "plotgradientcolor": "",
                                "divlinecolor": "CCCCCC",
                                "showvalues": "0",
                                "captionpadding": "30",
                                "palettecolors": "#f8bd19,#008ee4",
                                // "plottooltext": " 파란색: 구인중, 노란색: 구인중",
                                "theme": "zune",
                                "toolTipColor": "#ffffff",
                                "toolTipBorderThickness": "0",
                                "toolTipBgColor": "#000000",
                                "toolTipBgAlpha": "80",
                                "toolTipBorderRadius": "2",
                                "toolTipPadding": "5"        
                            },
                            "categories": [
                                {
                                    "category": [
                                        {
                                            "label": "1월"
                                        },
                                        {
                                            "label": "2월"
                                        },
                                        {
                                            "label": "3월"
                                        },
                                        {
                                            "label": "4월"
                                        },
                                        {
                                            "label": "5월"
                                        },
                                        {
                                            "label": "6월"
                                        },
                                        {
                                            "label": "7월"
                                        },
                                        {
                                            "label": "8월"
                                        },
                                        {
                                            "label": "9월"
                                        },
                                        {
                                            "label": "10월"
                                        },
                                        {
                                            "label": "11월"
                                        },
                                        {
                                            "label": "12월"
                                        }
                                    ]
                                }
                            ],
                            "dataset": chartData
                        }
                    });

                    revenueChart.render();
                }) ;
            }
        });
    }

    function getNoticeList() {
        document.getElementById("noticeContent").style.display = "none";
        document.getElementById("indexContent").style.display = "block";
        document.getElementById("noticeList").innerHTML = '';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/notice/getNoticeList.php',
            success: function(data) {
                for(var i=0; i<data.noticeList.length; i++) {
                    document.getElementById("noticeList").innerHTML
                    += '<li class="bb f10">' + data.noticeList[i].title
                    + '<a href="javascript:noticeView(' + data.noticeList[i].no + ')" class="fr cp">더보기 +</a>'
                    + '</li>';
                }
            }
        });
    }

    function noticeView(no) {
        document.getElementById("indexContent").style.display = "none";
        document.getElementById("noticeContent").style.display = "block";
        document.getElementById("noticeImg").innerHTML = '';

        $.ajax({
            type: 'post',
            dataType: 'json',
            url: '../ajax/notice/getNotice.php',
            data: { no: no },
            success: function(data) {
                document.getElementById("noticeTitle").innerHTML = data.board.title;
                document.getElementById("noticeDay").innerHTML = data.board.day;
                document.getElementById("noticeTime").innerHTML = data.board.time;
                document.getElementById("noticeHit").innerHTML = "조회 " + data.board.hit + "회";
                document.getElementById("noticeComment").innerHTML = "댓글 " + data.board.comment + "건";

                for(var i=0; i<data.board.file; i++) {
                    document.getElementById("noticeImg").innerHTML
                    += '<img src="http://mmcp.co.kr/board2/data/file/notice1/' + data.board.fileList[i] + '" /><br /><br />';
                }

                document.getElementById("noticeText").innerHTML = data.board.content;

                if(data.board.link1 != "") {
                    document.getElementById("noticeLink1").innerHTML
                    = '<br /><a href="' + data.board.link1 + '">'
                    + '<div style="color: #87afeb">' + data.board.link1 + '</div>'
                    + '</a>';
                }

                if(data.board.link2 != "") {
                    document.getElementById("noticeLink2").innerHTML
                    = '<a href="' + data.board.link2 + '">'
                    + '<div style="color: #87afeb">' + data.board.link2 + '</div>'
                    + '</a>';
                }
            }
        });
    }
</script>
<div class="row">
    <div class="bold f16 adminCont mt40" style="color: #606a72;">관리자 메인</div>
    <div class="adminCont mt15 bg_white oh loadArea" style="height: 700px">
        <div id="indexContent">
            <select onchange="drawChart()" id="chartYear" class="lh40 br5 fr mt30 mr50" name="" id="" style="width:100px; height: 40px; border-radius:5px"></select>
            <div class="oh w100 tc">
                <div class="chart center w100 oh" style="width:500px !important;margin-top:20px">
                    <div id="chartContainer" class="di" style="float: left;"></div>
                </div>
            </div>
            <div class="oh mt30 mb30">
                <div class="board_left fl">
                    <ul style="width:500px">
                        <img src="img/admin_btn1.png" alt="" class="mb5" />
                        <div id="noticeList"></div>
                    </ul>
                </div>
                <span class="centerLine fl di ml30 mr30" style="border-right:2px solid #ddd; height: 70px; margin-top: 80px;"></span>
                <div class="board_right fl" style="margin-top: 29px;">
                    <ul style="width:500px; padding-left: 30px;">
                        <li class="bb pr lh35" style="height:35px">
                            <span class="f16 bold">나의 정보</span>
                            <span class="fr cp vm pa" style="line-height: 20px; right:0; top:0" onclick="refreshAdminMain()">
                                <img src="img/admin_btn2.png" alt="" width="70">    
                            </span>
                        </li>
                        <li class="f14">
                            <ul class="mt10" style="padding-left: 0;">
                                <li class="lh25">나의 추천인(명)
                                    <span class="fr">
                                        <span id="myRecmdCnt" class="bold">0</span>(명)
                                    </span>
                                </li>
                                <li class="lh25">총 구인중(명)
                                    <span class="fr">
                                        <span id="totalGuinCnt" class="bold">0</span>(명)
                                    </span>
                                </li>
                                <li class="lh25">총 구직중(명)
                                    <span class="fr">
                                        <span id="totalGujikCnt" class="bold">0</span>(명)
                                    </span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <style>
            .noticeContent{height:1000px;overflow: scroll}
        </style>
        <div id="noticeContent" style="padding: 20px 35px;">
            <div class="bold f16" style="padding: 10px 0;" id="noticeTitle"></div>
            <div class="f14">
                <span class="mr10">작성자 <span class="bold">최고관리자</span></span>
                <span class="c999 mr5" id="noticeDay"></span>
                <span class="c999 mr10" id="noticeTime"></span>
                <span class="c999 mr10" id="noticeHit"></span>
                <span class="c999" id="noticeComment"></span>
            </div>
            <hr style="border: 1px solid #ddd; margin: 15px 0;" />
            <div id="noticeImg" class="mb20"></div>
            <div id="noticeText" class="f14"></div>
            <div id="noticeLink1" class="f14"></div>
            <div id="noticeLink2" class="f14"></div>
            <div class="tc mt40 mb20">
                <a href="javascript:getNoticeList()">
                    <div class="di f14" style="border: 1px solid #eb5f43; padding: 12px 50px; border-radius: 3px; color: #eb5f43;">메인</div>
                </a>
            </div>
        </div>
    </div>
</div>