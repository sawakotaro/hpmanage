@extends('layout.admin')


@section('title')
@parent
サイト設定の編集
@stop

@section('content')
<script type="text/javascript">
$(function() {
    $(":input.apply") .click(function(){
        var siteName = "<strong style='color: #0000ff;'>"+ $(this).closest("tr").find("td:first-child").text() +"</strong> ";
        var form = $(this).closest("form");
        bootbox.confirm(siteName + " のサイト設定を適用します。<br />よろしいですか？", function(result) {
            if(result === true) {
                $(":input[name='apply']", form) .click();
            }
        }); 
    });
    
    $(":input.delete") .click(function(){
        var siteName = "<strong style='color: #ff0000;'>"+ $(this).closest("tr").find("td:first-child").text() +"</strong> ";
        var form = $(this).closest("form");
        bootbox.confirm(siteName + " のサイト設定を削除します。<br />よろしいですか？", function(result) {
            if(result === true) {
                $(":input[name='delete']", form) .click();
            }
        }); 
    });
    
})    
</script>
<div class="row">
    
    @if(!is_null($siteStatus))
    <div class="col-md-12">
        @if($siteStatus === "delete")
        <div class="alert alert-warning">
            サイト設定を削除しました
        </div>
        @elseif($siteStatus === "apply")
        <div class="alert alert-success">
            サイト設定を適用しました
        </div>
        @endif
    </div>
    @endif
    
    <div class="col-md-5">
        <fieldset>
            <legend>現在適用中のサイト設定</legend>
            
            @if(!is_null($useSite))
            <table class="table table-bordered">
                <tr>
                    <th class="active text-right" style="width: 40%;">サイト名</th>
                    <td>{{{$useSite['name']}}}</td>
                </tr>

                <tr>
                    <th class="active text-right">ドメイン</th>
                    <td>{{{$useSite['domain']}}}</td>
                </tr>
                
                <tr>
                    <th class="active text-right">運営会社</th>
                    <td>{{{!is_null($useSite['company']) ? $useSite['company']['name'] : "未設定"}}}</td>
                </tr>
                
                <tr>
                    <th class="active text-right">タイトル</th>
                    <td>{{{$useSite['title']}}}</td>
                </tr>
                
                <tr>
                    <th class="active text-right">キーワード</th>
                    <td>{{{$useSite['keyword']}}}</td>
                </tr>
                
                <tr>
                    <th class="active text-right">ディスクリプション</th>
                    <td>{{{$useSite['description']}}}</td>
                </tr>
                
                <tr>
                    <th class="active text-right">サイト情報作成日時</th>
                    <td>{{{$useSite['created_at']}}}</td>
                </tr>
                
                @if(!is_null($useSite['file']))
                <tr>
                    <th colspan='2' class="active">ロゴ画像</th>
                </tr>
                <tr>
                    <td class='text-center' colspan='2'>
                        <img src='{{ FileUtil::showResizeFile($useSite['file']['key'], array("width" => 240, "extension" => $useSite['file']['extension'])) }}' />
                    </td>
                </tr>
                @endif
                
                <tr>
                    <td colspan="2" class="text-center">
                        {{Form::open(array("url"=>"/admin/setting/site/execute"))}}
                        <input type="submit" class="btn btn-success" name="update" value="編集">
                        {{Form::hidden("id", $useSite['id'])}}
                        {{Form::close()}}
                    </td>
                </tr>
                
            </table>
            @else
            <div class="alert alert-warning">
                現在、サイト情報が適用されていません。
            </div>
            @endif
        </fieldset>
    </div>

    <div class='col-md-7'>
        
        <legend>登録済みサイト設定リスト</legend>
        @if(count($siteList) > 0)
        <table class="table table-striped">
            <tr>
                <th class="text-center">サイト名</th>
                <th class="text-center">ドメイン</th>
                <th class="text-center">アクション</th>
            </tr>
        @foreach($siteList as $site)
        <tr>
            <td class="text-center">{{{$site['name']}}}</td>
            <td class="text-center">{{{$site['domain']}}}</td>
            <td class="text-center">
                {{Form::open(array("url"=>"/admin/setting/site/execute"))}}
                <input type="button" class="btn btn-info apply" value="適用">
                <input type="submit" name="apply" class="hidden">
                &emsp;
                <input type="submit" class="btn btn-success" name="update" value="編集">
                &emsp;
                <input type="button" class="btn btn-danger delete" value="削除">
                <input type="submit" name="delete" class="hidden">
                {{Form::hidden("id", $site['id'])}}
                {{Form::close()}}
            </td>
        </tr>
        @endforeach
        </table>
        @else
        <div class="alert alert-warning">
            現在、適用済みではないサイト情報が１件もありません。<br />
            {{link_to('/admin/setting/site/form', 'サイト情報を追加')}}してください
        </div>
        @endif
    </div>

    
    
    <div class="col-md-12 well">
        現在稼動中の番組に設定を当て込みます。<br />
        タイトルやキーワード、ディスクリプションなどはSEOにとって大事な要素になるので<br />
        慎重に決定してください。<br />
        <br />
        
        リストの <span style="color: #5bc0de; font-weight: bold;">[適用]</span> ボタンを押すことで、そのサイト設定を適用することができます。
    </div>
    
</div>

@stop