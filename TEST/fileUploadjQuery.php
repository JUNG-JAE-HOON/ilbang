<script src="../js/jquery-1.10.2.min.js"></script>
<script>
    function imageUpLoad() {
        var id = "<?php echo $uid; ?>";
        var type = "<?php echo $kind; ?>";

                var formData = new FormData();

                for(var i=0; i<$('#ex_file')[0].files.length; i++){
                    formData.append('fileToUpload', $('#ex_file')[0].files[i]);
                }
                
                $.ajax({
                    url: 'FileUploadAjax.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (data) {
                        if( data.logoData.image != null ){
                            var company_logo= document.getElementById("company_logo");

                            company_logo.src="http://il-bang.com/pc_renewal/guinImage/"+data.logoData.image;
                        }
                        
                        alert(data.logoData.message);
                    }
                });

    }
</script>

<div class="topInner1 w20 fl bg_navy tc">
    <img src="http://il-bang.com/pc_renewal/images/144x38.png" id="company_logo"  class="w144 mt50" />
    <div class="filebox mt30">
        <label for="ex_file" class="mb0">찾아보기</label> 
        <input type="file" id="ex_file" onchange="imageUpLoad()"> 
        <!-- <a href="javascript:imageUpLoad();" class="f_white imgChangeBtn2">프로필 사진 변경</a> -->
        <p class="f10 imgUploadTxt mt10">※ 144x38 png 파일만 업로드 가능합니다.</p>
    </div>
</div>