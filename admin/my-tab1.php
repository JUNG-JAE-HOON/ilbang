<style>
    .active a { background: none; }
</style>
<div class="row">
    <div class="adminCont lh40 mt50 bg_white oh loadArea" style="height: 700px">
        <ul class="nav nav-tabs color4 noBorder" role="tablist" id="myTab">
            <li role="presentation" class="active"><a href="#comp" class="color5 noBorder mr5 tc" aria-controls="comp" role="tab" data-toggle="tab"><b>기업</b></a></li>
            <li role="presentation"><a href="#general" class="color5 noBorder tc" aria-controls="general" role="tab" data-toggle="tab"><b>개인</b></a></li>
        </ul>
        <div class="tab-content" style="padding:20px 50px">
            <div role="tabpanel" class="tab-pane active" id="comp">
                <?php include_once "company/myRecmndMng.php"; ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="general">
                <?php include_once "general/myRecomndMng.php"; ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade c666" id="recomndModal">
    <div class="modal-dialog mt50" style="width: 1000px;">
        <div class="modal-content noBorder" style="background-color: transparent;">
            <div class="modal-header noBorder oh" style="padding: 15px 0;">
                <a href="" class="fl" style="display: none;" id="backImg"><img src="../images/back.png" /></a>
                <a href="#" class="fr" data-dismiss="modal"><img src="../images/exit.png" /></a>                
            </div>
            <div class="modal-body f14 tc bg_white noPadding c666 adminScroll">
                <div class="wdfull fff f16" style="background-color: #4c5366; padding: 20px 0;" id="modalTitle"></div>
                <div style="padding: 30px 25px;">
                    <div class="bb bg_eee oh bold" style="border-top: 2px solid #ccc; padding: 10px 0;" id="parentContent">
                        <div class="fl" style="width: 170px;" id="li1"></div>
                        <div class="fl" style="width: 540px;" id="li2"></div>
                        <div class="fl" style="width: 120px;" id="li3"></div>
                        <div class="fl" style="width: 120px;" id="li4"></div>
                    </div>
                    <div id="contentList"></div>
                    <div id="contentSubList" style="display: none;">
                        <div class="oh">
                            <div class="border-navy">
                                <div class="wdfull tc fff f16" style="background-color: #2a3243; padding: 10px 0;" id="title"></div>
                                <div class="fl mr10" style="padding: 10px 0; height: 122px;" id="imgWrap">
                                    <img src="" id="logoImg" />
                                </div>
                                <div class="di oh" id="subBlock1"></div>
                            </div>
                            <div class="clear wdfull" style="padding-top: 25px;" id="subBlock2"></div>
                            <div class="wdfull tl" style="padding-top: 25px;" id="subBlock3"></div>
                        </div>
                    </div>
                    <div class="clear text-center mt10" id="paging">
                        <ul id="contentPage" class="pagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function getGeneralCSS() {
        document.getElementById("logoImg").style.marginTop = 10 + "px";
        document.getElementById("imgWrap").style.marginLeft = 25 + "px";
        document.getElementById("imgWrap").style.marginRight = 25 + "px";
        document.getElementById("imgWrap").style.width = 100 + "px";
        document.getElementById("subBlock1").style.width = 796 + "px";
    }

    function getCompanyCSS() {
        document.getElementById("imgWrap").style.width = 144 + "px";
        document.getElementById("logoImg").style.marginTop = 30 + "px";
        document.getElementById("imgWrap").style.marginLeft = 0;
        document.getElementById("imgWrap").style.marginRight = 0;
        document.getElementById("subBlock1").style.width = 802 + "px";
    }
</script>