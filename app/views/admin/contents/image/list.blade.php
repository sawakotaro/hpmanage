@extends('layout.admin')


@section('title')
@parent
コンテンツ管理 画像コンテンツの一覧
@stop

@section('content')

<script type="text/javascript">
$(function() {
    $(".cb-enable,.cb-disable") .click(function() {
        if($(this).hasClass("selected") === true) {
            var suspended = $(this).attr("suspended");
            var id = $(this) .closest("tr").find(".primaryId", this).text();
            var df = $.Deferred();
            $.ajax({
                url     :   "/admin/api/contents/image/suspended",
                type    :   "post",
                dataType:   "json",
                data    :   {id : id, suspended : suspended},
                cache   :   false,
                success :   df.resolve,
                error   :   df.reject
            });
            df.promise().done(function(json) {
                if(json.result === true) {
                    var message = json.rssSuspended === 0 ? "画像コンテンツを有効にしました。" : "画像コンテンツを無効にしました。";
                    bootbox.alert("<div class='alert alert-success space-top-20'>"+ message +"</div>");
                } else {
                    bootbox.alert("<div class='alert alert-danger space-top-20'>通信エラーが発生したため、状態を変更できませんでした。</div>");
                }
            }) .fail(function(json) {
                bootbox.alert("<div class='alert alert-danger space-top-20'>通信エラーが発生したため、状態を変更できませんでした。</div>");
            });
        }
    });
});
</script>

<div class="row">
    <div class="col-md-12">
        <legend>画像コンテンツの一覧</legend>

        
        <table class="table table-bordered table-striped">
        @if(count($imageContentList))
        <tr>
            <th class="active text-center">ID</th>
            <th class="active text-center">タイトル</th>
            <th class="active text-center" style="width: 250px;">画像ファイル</th>
            <th class="active text-center">枚数</th>
            <th class="active text-center" style="width: 200px;">登録日時</th>
            <th class="active text-center" style="width: 130px;">表示状態</th>
            <th class="active text-center" style="width: 120px;">アクション</th>
        </tr>
        @foreach($imageContentList as $image)
        <tr>
            <td class="text-center primaryId">{{$image->id}}</td>
            <td>{{{$image->title}}}</td>
            <td class="text-center"><img src='{{ FileUtil::showResizeFile($image['file']['key'], array("width" => 140, "extension" => $image['file']['extension'])) }}' /></td>
            <td class="text-right">{{number_format($image['fileNum'])}}枚</td>
            <td class="text-right">{{{substr($image->created_at, 0, -3)}}}</td>
            <td>
                <p class="field switch">
                    <label for="radio1" suspended="0" class="cb-enable {{$image->rss_suspended == 0 ? 'selected' : ''}}"><span>表示</span></label>
                    <label for="radio2" suspended="1" class="cb-disable {{$image->rss_suspended != 0 ? 'selected' : ''}}"><span>非表示</span></label>
                </p>
            </td>
            <td class="text-center">
               {{link_to('/admin/contents/image/form/' . $image->id, '編集', array("class" => "btn btn-info btn-sm"))}}
               {{link_to('/admin/contents/image/remove/' . $image->id, '削除', array("class" => "btn btn-danger btn-sm"))}}
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="8">
                <div class="alert alert-warning">
                    現在、画像コンテンツの登録がありません。<br />
                    {{link_to('/admin/contents/image/form', '画像コンテンツを追加')}}してください
                </div>
            </td>
        </tr>
        @endif
        </table>
    </div>
</div>
@stop