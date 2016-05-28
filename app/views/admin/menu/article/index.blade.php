@extends('layout.admin')


@section('title')
@parent
記事管理 取得済み記事一覧
@stop

@section('content')


<script type="text/javascript">
    $(function() {
        $(".fetch-news") .click(function() {
            
            bootbox.confirm("最新記事を取得します。<br />(登録済みの記事は除外されます)", function(result) {
                if(result) {
                    fetchArticle();
                }
            });
        });
    });
    
    function fetchArticle() {
        readWait("記事を取得しています");
        var def = $.Deferred();
        $.ajax({
            url :   "/admin/api/menu/article/register",
            method:   "get",
            dataType:   "json",
            cache   :   false,
            success :   def.resolve,
            error   :   def.reject
        });

        def.promise().done(function(json) {
            $.unblockUI({
                onUnblock   :   function() {
                    alertSuccess("登録済み記事サイトの、最新記事の取得が完了しました。");
                }
            });
        }) .fail(function() {
            $.unblockUI({
                onUnblock   :   function() {
                    alertDanger("最新記事の取得に失敗しました。<br />ページを更新後、再度お試しください。");
                }
            });
        });
    }
</script>

<div class="row">
    <div class="col-md-12">
        <legend>取得済み記事一覧</legend>
        
        <div class="well">
            記事を閲覧したいサイトを選択してください。
        </div>
        
        <button class="btn btn-primary fetch-news space-bottom-10"> 全サイトの最新記事を取得 </button>
        
        <table class="table table-bordered table-striped">
                @if(count($articleSites))
        <tr>
            <th class="active text-center">ID</th>
            <th class="active text-center">記事サイト名</th>
            <th class="active text-center">URL</th>
            <th class="active text-center">RSS稼動状況</th>
            <th class="active text-center" style="width: 120px;">アクション</th>
        </tr>
        @foreach($articleSites as $site)
        <tr>
            <td class="text-center primaryId">{{$site->id}}</td>
            <td>{{{$site->name}}}</td>
            <td>{{link_to($site->site_url, $site->site_url, array('target' => '_blank'))}}</td>
            <td class="text-center">{{$site->rss_suspended == 0 ? "<span class='font-success'>稼働中</span>" : "<span class='font-error'>停止中</span>"}}</td>
            <td class="text-center">
               {{link_to('/admin/menu/article/list/' . $site->id, '記事一覧', array("class" => "btn btn-info btn-sm"))}}
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="5">
                <div class="alert alert-warning">
                    現在、記事サイト情報が１件もありません。<br />
                    {{link_to('/admin/menu/article/site/form', '記事サイト情報を追加')}}してください
                </div>
            </td>
        </tr>
        @endif
        </table>
    </div>
</div>
@stop