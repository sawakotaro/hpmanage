$(function() {
    $("#upload") .proggresUpload({ filepath : "#filePath", defaultImage : "/images/no-image.gif"});
    // 親カテゴリの取得
    if(!$("div.category-list")[0]) {
        getCategoryList($("label[for='parent_id']") .closest("div.form-group"), $(":input[name='parent_id']").val());
    }
    
    $(document) .on("change", "div.category-list select", function() {
        var $categoryListObj = $(this) .closest("div.category-list");
        $("~ div.category-list", $categoryListObj) .remove();
        $(":input[name='parent_id']") .val($("option:selected", this).val());
        if($("option:selected", this).hasClass("new-create")) return false;
        getCategoryList($("label[for='parent_id']") .closest("div.form-group"), $("option:selected", this).val());
    });
});

function getCategoryList(categoryListObj, parent_id) {
    var def = $.Deferred();
    categoryListObj .append('<div class="category-list text-center" />');
    $("div.category-list:last") .append("<img src='/images/loader.gif' class='loader space-top-10' />");
    $(".loader") .fadeIn("fast");
    $.ajax({
        url             :   "/api/category/list/fetch",
        method          :   "get",
        data            :   {parent_id : parent_id},
        cache           :   false,
        dataType        :   'json',
        error           :   def.reject,
        success         :   def.resolve
    });
    
    def.promise().done(function(json) {
        var count = $("div.category-list").length;
        $(".loader") .fadeOut("fast", function() {
            $("div.category-list:last") .append("<div class='space-top-10'>【カテゴリ "+ count +"】</div><select name='parent_id_list" + count + "' class='form-control'></select>");
            $("select[name='parent_id_list" + count + "']") .append("<option class='new-create' value='" + parent_id + "'> 新規カテゴリ </option>");
            $(json) .each(function() {
                $("select[name='parent_id_list" + count + "']") .append('<option value="' + this.id + '">' + escape(this.name) + '</option>');
            });
            $(this) .remove();
        });
    }).fail(function() {
        bootbox.alert("カテゴリが取得できませんでした。", function() {});
    });
}