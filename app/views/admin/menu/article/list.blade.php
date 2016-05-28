@extends('layout.admin')


@section('title')
@parent
記事管理 取得済み記事一覧
@stop

@section('content')

<script type="text/javascript">
    $(function() {
        $(".article-delete") .click(function() {
            var thisRow = $(this) .closest("tr");
            var id      =   $(".article-id", thisRow) .text();
            var title   =   $(".article-title", thisRow) .text();
            bootbox.confirm("<span class='font-error'>ID: "+ id +"<br />" + title + "</span><br /><br />この記事を削除しますか？", function(result) {
                if(result) {
                    var def = $.Deferred();
                    $.ajax({
                        url     :   "/admin/api/menu/article/delete",
                        method  :   "post",
                        dataType:   "json",
                        data    :   {id : id},
                        cache   :   false,
                        error   :   def.reject,
                        success :   def.resolve
                    });
                    
                    def.promise().done(function(json) {
                        if(json.status === true) {
                            alertSuccess("[ID] "+ id +" の記事を削除しました。");
                            thisRow.fadeOut("slow", function() { thisRow.remove() });
                        } else {
                            alertDanger("通信エラーが発生しました。<br />もう一度やり直してください。");
                        }
                    }) .fail(function() {
                        alertDanger("通信エラーが発生しました。<br />もう一度やり直してください。");
                    });
                }
            });
        });
    });
</script>
<div class="row">
    <div class="col-md-12">
        <legend>{{{$articleSite->name}}} - 取得済み記事一覧</legend>
        
        <div class="well">
        </div>
        
        <table class="table table-bordered table-striped">
            <tr>
                <th class="text-center" style="width: 100px;">記事ID</th>
                <th class="text-center">タイトル</th>
                <th class="text-center">リンク</th>
                <th class="text-center">記事詳細 (一部)</th>
                <th class="text-center" style="width: 100px;">アクション</th>
            </tr>
            @if(count($articles))
            @foreach($articles as $article)
            <tr>
                <td class="text-center article-id">{{$article->id}}</td>
                <td class="article-title">{{{$article->title}}}</td>
                <td>{{link_to($article->link, $article->link, array("target" => "_blank"))}}</td>
                <td>{{mb_strimwidth(e($article->description), 0, 150, "....", "UTF-8")}}</td>
                <td class="text-center">
                    <button class="btn btn-danger article-delete"> 削除 </button>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td class="text-center" colspan="5">
                    <div class="alert alert-warning">
                        現在、記事情報が１件もありません。
                    </div>
                </td>
            </tr>
            @endif
        </table>
    </div>
</div>
@stop