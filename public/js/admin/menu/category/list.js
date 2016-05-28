$(function() {
    // 親カテゴリの取得
    if(!$("div.category-list")[0]) {
        getCategoryList($("div.categories"), null);
    }
    
    $(document) .on("change", "div.category-list select", function() {
        var categoryId = $("option:selected", this).val();
        var $categoryListObj = $(this) .closest("div.category-list");
        $("~ div.category-list", $categoryListObj) .remove();
        $(":input[name='parent_id']") .val($("option:selected", this).val());
        if($("option:selected", this).hasClass("new-create")) return false;
        getCategoryList($("div.categories"), categoryId);
        
        $(".category-view") .fadeOut("fast", function() {
            $(this).text("");
            $(".category-view") .fadeIn("fast", function() {
                getCategory($(".category-view"), categoryId);
            });
        });
    })
    
    
    // ソート順の変更
    .on("click", ".sort-up,.sort-down", function() {
        var def = $.Deferred();
        var path = $(this).hasClass("sort-up") ? "up" : "down";
        var id = $(this).prop("rel");
        var parentIdListName = $("select option[value='"+ id +"']").closest("select").prop("name");
        var parent_id = $("select option[value='"+ id +"']") .attr("parent_id");
        
        $.ajax({
            url             :   "/api/category/list/" + path + "/" + $(this).prop("rel"),
            method          :   "get",
            data            :   {},
            cache           :   false,
            dataType        :   'json',
            error           :   def.reject,
            success         :   def.resolve
        });
        
        def.promise().done(function(json) {
            if(json.status === true) {
                bootbox.alert("<div class='alert alert-success space-top-20'>ソート順を変更しました。</div>");
                var categoryList = $("select[name='"+ parentIdListName +"']") .closest(".category-list");
                $("+.category-list", categoryList) .remove();
                categoryList .remove();
                getCategoryList($("div.categories"), parent_id, function() {
                    $("div.category-list:last select option[value='"+ id +"']") .prop("selected", true);
                });
            }
        }) .fail(function() {
            bootbox.alert("<div class='alert alert-danger space-top-20'>通信エラーにより、ソート順が変更できませんでした。</div>");
        });
        return false;
    });
});

function getCategoryList(categoryListObj, parent_id, fun) {
    var def = $.Deferred();
    categoryListObj .append('<div class="category-list text-center col-md-4" />');
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
            console.log(json);
            if(json.length) {
                $("div.category-list:last") .append("<div class='space-top-10'>【カテゴリ "+ count +"】</div><select size='10' name='parent_id_list" + count + "' class='form-control'></select>");
                $(json) .each(function() {
                    $("select[name='parent_id_list" + count + "']") .append('<option value="' + this.id + '" parent_id="'+ this.parent_id +'">' + escape(this.name) + '</option>');
                });
            }
            $(this) .remove();
            
            if(typeof fun === "function") {
                fun();
            }
        });
    }).fail(function() {
        bootbox.alert("カテゴリが取得できませんでした。", function() {});
    });
}


function getCategory(categoryViewObj, categoryId) {
    $(categoryViewObj) .append("<img src='/images/loader.gif' class='view-loader space-top-10' />");
    var def = $.Deferred();
    $.ajax({
        url: "/api/category/fetch",
        method: "get",
        data: {category_id: categoryId},
        cache: false,
        dataType: 'json',
        error: def.reject,
        success: def.resolve
    });
    
    def.promise().done(function(json) {
        if(json !== null) {
        $(".view-loader") .fadeOut("fast", function() {
            var parentCategoryName = json.parent_id !== null ? json.parent_category.name : "関連カテゴリはありません。(TOPカテゴリ)";
            var img = json.file_id !== null ? "<img src='/api/file/view/"+ json.file.key +"' width='320px' />" : "<img src='/images/no-image.gif' />";
            $(categoryViewObj)
                    .append("<table class='table table-bordered' />")
                    .find(".table")
                    .append('<tr><th class="text-right active" width="20%">カテゴリ名</th><td class="text-left">' + escape(json.name) + '</td></tr>')
                    .append('<tr><th class="text-right active">関連カテゴリ</th><td class="text-left">' + escape(parentCategoryName) + '</td></tr>')
                    .append('<tr><th class="text-right active">メモ</th><td class="text-left">' + escape(json.memo) + '</td></tr>')
                    .append('<tr><th class="text-right active">カテゴリ画像</th><td class="text-left text-center">' + img + '</td></tr>')
                    .append('<tr><th class="text-right active">ソート順移動</th><td><a rel="'+ json.id +'" href="javascript:void(0);" class="btn btn-default sort-up">↑ 上へ</a>&emsp;<a rel="'+ json.id +'" href="javascript:void(0);" class="btn btn-default sort-down">下へ ↓</a></td></tr>')
                    .append('<tr><th class="text-right active">アクション</th><td><a href="form/'+ json.id +'" class="btn btn-info">編集</a>&emsp;<a href="remove/'+ json.id +'" class="alert-confirm btn btn-danger">削除</a></td></tr>')
            $(this) .remove();
        });
        } else {
            bootbox.alert("カテゴリが取得できませんでした。", function() {});
        }
    }).fail(function() {
        bootbox.alert("カテゴリが取得できませんでした。", function() {});
    });
}