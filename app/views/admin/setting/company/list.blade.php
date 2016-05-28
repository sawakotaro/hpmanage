@extends('layout.admin')


@section('title')
@parent
運営会社の編集
@stop

@section('content')
<script type="text/javascript">
$(function() {
    
    $(":input.delete") .click(function(){
        var siteName = "<strong style='color: #ff0000;'>"+ $(this).closest("tr").find("td:first-child").text() +"</strong> ";
        var form = $(this).closest("form");
        bootbox.confirm(siteName + " の運営会社を削除します。<br />よろしいですか？", function(result) {
            if(result === true) {
                $(":input[name='delete']", form) .click();
            }
        }); 
    });
    
})    
</script>
<div class="row">
    
    @if(!is_null($companyStatus))
    <div class="col-md-12">
        @if($companyStatus === "delete")
        <div class="alert alert-warning">
            運営会社を削除しました
        </div>
        @endif
    </div>
    @endif
    
    <div class='col-md-12'>
        @if(count($companyList) > 0)
        <table class="table table-striped">
            <caption>登録済み運営会社リスト</caption>
            <tr>
                <th class="text-center">運営会社名</th>
                <th class="text-center">フリガナ</th>
                <th class="text-center">Eメールアドレス</th>
                <th class="text-center">電話番号</th>
                <th class="text-center">アクション</th>
            </tr>
        @foreach($companyList as $company)
        <tr>
            <td>{{{$company['name']}}}</td>
            <td>{{{$company['kana']}}}</td>
            <td>{{{$company['email']}}}</td>
            <td>{{{$company['tel']}}}</td>
            
            <td class="text-center">
                {{Form::open(array("url"=>"/admin/setting/company/execute"))}}
                <input type="submit" class="btn btn-success" name="update" value="編集">
                &emsp;
                <input type="button" class="btn btn-danger delete" value="削除">
                <input type="submit" name="delete" class="hidden">
                {{Form::hidden("id", $company['id'])}}
                {{Form::close()}}
            </td>
        </tr>
        @endforeach
        </table>
        @else
        <div class="alert alert-warning">
            現在、運営会社情報が１件もありません。<br />
            {{link_to('/admin/setting/company/form', '運営会社情報を追加')}}してください
        </div>
        @endif
    </div>

</div>

@stop