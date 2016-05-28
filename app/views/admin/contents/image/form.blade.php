@extends('layout.admin')


@section('title')
@parent
画像コンテンツ {{ (Input::get('id') ? "編集" : "新規登録") }}フォーム
@stop

@section('content')

{{HTML::style("/lib/tagit/jquery.tagit.css")}}
{{HTML::style("/lib/tagit/tagit.ui-zendesk.css")}}
{{HTML::script("/lib/tagit/tagit.min.js")}}

<script type="text/javascript">
$(function() {
    // tagit
    $('#tags').tagit();
    var count = 0;
    $(".image-add") .bind({
        click       :   function () {
            $(":input[type='file']:last", $(this) .closest(".upload")) .after("<input type='file' name='image[]' class='form-control space-top-10 num"+ count +"' /> ");
        }
    });

    $(".image-remove") .bind({
        click       :   function () {
            if($(":input[type='file']", $(this) .closest(".upload")) .length === 1) return false;
            $(":input[type='file']:last", $(this) .closest(".upload")) .remove();
        }
    });
    $(".submit") .click(function() {
        var aceppt = true;
        var imageCount = 0;
        imageCount += $(".uploads").size();
        $(":input[name='image[]']") .each(function() {
            if(this.value) imageCount++;
        });
        
        if(imageCount === 0) {
            alertWarning("アップロードする画像を選択してください。");
            aceppt = false;
        }
        
        if(aceppt) $("form") .submit();
        return false;
    });
    
    $(":input[name*='removeImage']") .click(function() {
        var thisObj = $(this);
        var fileId = $(this) .attr("name").split("-")[1];
        bootbox.confirm("選択した画像を削除してもよろしいですか？", function(result) {
            if(result === true) {
                readWait("画像データを削除しています、しばらくお待ちください。");

                var def = $.Deferred();
                $.ajax({
                    url     :   '/admin/api/file/delete/' + fileId,
                    type    :   'post',
                    dataType:   'json',
                    cache   :   false,
                    success :   def.resolve,
                    error   :   def.reject
                });

                def.promise().done(function(json) {
                    if(json.result === true) {
                        $.unblockUI({
                            onUnblock   :   function() {
                                alertSuccess("画像データの削除が成功しました。");
                                $(thisObj).closest("div.block").fadeOut("fast", function() {
                                    $(this) .remove();
                                });
                            }
                        });
                    } else {
                        $.unblockUI({
                            onUnblock   :   function() {
                                alertDanger("画像データの削除に失敗しました。<br />ページを更新し、再度お試しください。");
                            }
                        });
                    }
                }) .fail(function() {
                    $.unblockUI({
                        onUnblock   :   function() {
                            alertDanger("画像データの削除に失敗しました。<br />ページを更新し、再度お試しください。");
                        }
                    });
                });
            }
        });
    });
})
</script>

<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/contents/image/confirm', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) }}
        <fieldset>
            <legend>画像コンテンツ {{ (Input::get('id') ? "編集" : "新規登録") }}</legend>
            <div class="alert alert-warning">
                <span class="important">※</span>は必須項目<br />
                タグにカンマは含めないでください。
            </div>
            
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    <span class="important">※ </span>
                    {{Form::label('tag', 'タグ', array('class' => 'control-label'))}}
                </div>
                
                <div class="col-sm-9">
                    {{Form::text("tag", Input::get('tag', null), array('class' => 'form-control', 'id' => 'tags'))}}
                    @if($errors->has('tag'))
                    <div class="alert alert-danger">
                        {{ $errors->first('tag') }}
                    </div>
                    @endif
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    <span class="important">※ </span>
                    {{ Form::label('title', 'タイトル', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    {{ Form::text('title', e(Input::get('title')), array('class' => 'form-control', 'placeholder' => 'タイトルを入力')) }}
                    @if($errors->has('title'))
                    <div class="alert alert-danger">
                        {{ $errors->first('title') }}
                    </div>
                    @endif
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    {{ Form::label('description', '記事詳細', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    {{ Form::textarea('description', e(Input::get('description')), array('class' => 'form-control')) }}
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                {{ Form::label('suspended', '表示状態', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    <label>{{ Form::radio('suspended', 0, intval(Input::get('suspended')) === 0 ? true : false) }} 公開</label>
                    &emsp;
                    <label>{{ Form::radio('suspended', 1, intval(Input::get('suspended')) === 1 ? true : false) }} 非公開</label>
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                {{ Form::label('posted_at', '投稿日時', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    <div>
                        {{ Form::select("year", $dateList['year'], $postedValueList['year'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}年
                        {{ Form::select("month", $dateList['month'], $postedValueList['month'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}月
                        {{ Form::select("day", $dateList['day'], $postedValueList['day'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}日<br />
                    </div>
                    <div class="space-top-10">
                        {{ Form::select("hour", $dateList['hour'], $postedValueList['hour'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}時
                        {{ Form::select("minute", $dateList['minute'], $postedValueList['minute'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}分
                    </div>
                </div>
            </div>
            
            
            
            
            
            <div class="form-group">
                
                <div class="col-sm-3 text-right">
                    {{ Form::label('image', 'アップロード', array("class" => "control-label")) }}
                </div>
                
                @if($errors->has('imageLength'))
                <div class="col-sm-12">
                    <div class="alert alert-danger">{{ $errors->first('imageLength') }}</div>
                </div>
                @endif
                
                <div class="col-sm-9 text-left upload">
                    
                    <div class="space-top-20 text-left space-bottom-10">
                        {{ Form::button('画像を追加', array('class' => 'btn btn-info image-add')) }}
                        &emsp;
                        {{ Form::button('画像を減らす', array('class' => 'btn btn-warning image-remove')) }}
                    </div>
                    
                    {{ Form::file('image[]', array("class" => "form-control")) }}
                    @if($errors->has('image'))
                    <div class="alert alert-danger">
                        {{ $errors->first('image') }}
                    </div>
                    @endif
                </div>
                
                <div class="col-sm-3"></div>
                <div class="col-sm-9 space-top-10">
                    @if(!is_null(Input::get('id', null)))
                    @foreach($files as $image)
                    <div class="col-sm-4 block text-center" style="margin-top: 10px;">
                        <div class="text-center space-bottom-10">
                            <input type="button" name="removeImage-{{$image['id']}}" class="btn btn-danger btn-sm" value="削除"/>
                        </div>
                        <a href="{{ FileUtil::showFile($image['key']) }}" target="_blank">
                            <img class="uploads" src="{{ FileUtil::showResizeFile($image['key'], array("width" => 70, "extension" => $image['extension'])) }}" />
                        </a>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            

            <div class="form-actions text-center" style="clear: both; padding-top: 30px;">
                {{ Form::submit('入力した内容の確認', array('class'=>'btn btn-primary submit')) }}
            </div>

        </fieldset>
    {{ Form::hidden('id', Input::get('id')) }}
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop