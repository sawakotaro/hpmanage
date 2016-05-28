// 必ずAPC_UPLOAD_PROGRESSがnameのprogress_keyのhiddenタグを埋め込んでください。
// bootboxを必ず読み込んでください。
// このJSファイルは、bootstrap3を利用することを前提としています。

var uploadUrl = "/admin/api/file/upload";
var progressUrl = "/admin/api/file/progress";
var defaultFilePathName = 'filePath';

var timer = null;
var progressMeter = 0;
var regexExtension = /^.+\.(jpg|jpeg|gif|png)$/i;
//var regexExtension = /^.+$/i;


$.fn.proggresUpload = function(option) {
    trigger = $(this);
    option = defaultOptions(option);
    
    trigger .change(function() {
        
        $("#uploaded img") .hide();
        
        // 削除ボタンの表示
        toggleDeleteArea();
        
        if(!$("#progress")[0]) {
            $('#progress') .remove();
            trigger .after("<div id='progress'></div>");
        }
        
        // すでにアップロード済みのものがあれば、表示のみ削除
        $('#progress') .fadeIn("fast");
        $('#loading') .show();

        if($(this).val() !== '' && !regexExtension.test($(this).val())) {
            $('#progress') .hide();
            $('#loading') .hide();
            bootbox.alert("画像ファイルのみ選択してください", function() {});
            return false;
        }

        if($(this).val() === '') {
            $('#progress') .hide();
            $('#loading') .hide();
            return false;
        }

        $('#loading').text("0%");
        $(this) .prop("disabled", true);
        $('#progress').progressbar({
            value: false,
            change: function () {
              $('#loading').text($('#progress').progressbar('value') + '%');
            },
        });

        var def = $.Deferred();
        var formData = new FormData();
        formData.append('APC_UPLOAD_PROGRESS', $('#progress_key').val());
        formData.append("tmpDir", "images/tmp/" + $(":input[name='tmpDir']").val());
        if (trigger.val() !== '' ) {
            formData.append("image", trigger.prop("files")[0]);
        }

        timer = setInterval('progressBar()', 500);

        $.ajax({
            url             :   uploadUrl,
            method          :   "post",
            contentType     :   false,
            processData     :   false,
            data            :   formData,
            cache           :   false,
            dataType        :   'json',
            error           :   def.reject,
            success         :   def.resolve
        });

        def.promise().done(function(result) {
           clearInterval(timer);
            if (result.status === false) {
            // Uploadしたファイルのエラー内容を受信・出力
              $('#progress').progressbar("destroy");
            } else {
              $('#progress').progressbar('value', 100) .fadeOut("fast", function() {
                  $('#loading') .hide();
                  $("#uploaded img") .prop("src", result.filepath) .fadeIn("fast");
                  $(option.filepath).val(result.filepath);
                  $(":input[name='remove']") .val("false");
                  toggleDeleteArea();
              });
            }

            trigger .prop("disabled", false);
        }) .fail(function(XMLHttpRequest, errorText) {
            clearInterval(timer);
            console.log(errorText);
            trigger .prop("disabled", false);
            bootbox.alert("正常にアップロードできませんでした。", function() {});
        });
    });
    
    // ロゴ画像の削除
    $(".deleteLogo") .click(function() {
        $('#uploaded img') .prop("src", option.defaultImage) .prop("width", option.showWidth);
        trigger.val("");
        $(option.filepath) .val("");
        $(":input[name='remove']") .val("true");
        $("#deleteArea") .hide();
    });
    
    if($(":input[name='remove']") .val() === "true") {
        $(".deleteLogo") .click();
    } else if($(option.filepath).val()) {
        $('#uploaded img') .prop("src", $(option.filepath).val());
    }
    
    // 削除ボタンの表示
    toggleDeleteArea();
    
    function toggleDeleteArea() {
        $(option.filepath).val() ? $("#deleteArea") .show() : $("#deleteArea") .hide();
    }
};



var progressBar = function () {
  jqxhr = $.ajax({
        url             :   progressUrl,
        method          :   'post',
        data            :   { APC_UPLOAD_PROGRESS : $('#progress_key').val() },
        dataType        :   "text",
        cache           :   false,
    }) .done(function(progressMeter) {
        $('#progress').progressbar('value', parseInt(progressMeter));
    });
}







var defaultOptions = function(option) {
    if(!option.filepath)        option.filepath     = ":input[name='"+ defaultFilePathName +"']";
    if(!option.showWidth)       option.showWidth    = "260px";
    if(!option.defaultImage)    option.defaultImage = "/images/no-image.gif";
    
    return option;
}

