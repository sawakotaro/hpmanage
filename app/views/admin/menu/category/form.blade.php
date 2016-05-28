@extends('layout.admin')


@section('title')
@parent
カテゴリ設定 {{ (Input::get('id', "") !== "" ? "編集" : "新規登録") }}フォーム
@stop

@section('content')

{{ HTML::style('http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css') }}
{{ HTML::script('http://code.jquery.com/ui/1.10.3/jquery-ui.min.js') }}
{{ HTML::script('/js/progress.js') }}
{{ HTML::script('/js/admin/menu/category/form.js') }}

<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/menu/category/confirm','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>カテゴリ設定の{{ (Input::get('id') ? "編集" : "新規登録") }}</legend>
            <div class="alert alert-warning"><span class="important">※</span>は必須項目</div>
            
            @if(Input::get("id", "") === "")
            <div class="form-group">
                {{ Form::label('parent_id', '関連カテゴリ', array("class" => "control-label")) }}<span class="important"> ※</span>
                @if(count($categories) !== 0)
                @foreach($categories as $key1 => $val)
                <div class="category-list text-center">
                    <div class="space-top-10">【カテゴリ {{++$key1}}】</div>
                    <select name="parent_id_list{{$key1}}" class="form-control">
                    
                    @foreach($val as $key2 => $category)
                    @if($key2 === 0)
                    {{-- */$status = false/* --}}
                    <option value="{{$category['parent_id']}}" class="new-create"> 新規カテゴリ </option>
                    @endif
                    @if($category['selected'])
                    {{-- */$status = true/* --}}
                    {{-- */$selected = "selected='selected'"/* --}}
                    @else
                    {{-- */$selected = ""/* --}}
                    @endif
                    <option value="{{$category['id']}}" {{$selected}}>{{{$category['name']}}}</option>
                    @endforeach
                    </select>
                </div>
                @endforeach
                
                @if($status)
                <div class="category-list text-center">
                    <div class='space-top-10'>【カテゴリ {{++$key1}}】</div>
                    <select name="parent_id_list{{$key1}}" class="form-control">
                        <option value="" class="new-create"> 新規カテゴリ </option>
                    </select>
                </div>
                @endif
                @endif
                {{ Form::hidden('parent_id', Input::get('parent_id', "")) }}
            </div>
            @else
            <div class="alert alert-danger">
                関連カテゴリは編集できません
            </div>
            {{ Form::hidden('parent_id', Input::get('parent_id')) }}
            @endif
            
            
            
            <div class="form-group">
                {{ Form::label('category_name', 'カテゴリ名', array("class" => "control-label")) }}<span class="important"> ※</span>
                {{ Form::text('category_name', e(Input::get('category_name')), array('class' => 'form-control', 'placeholder' => 'カテゴリ名を入力')) }}
                @if($errors->has('category_name'))
                <div class="alert alert-danger">
                    {{ $errors->first('category_name') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('memo', 'カテゴリ詳細 (メモ)', array('class' => 'control-label')) }}
                {{ Form::textarea('memo', e(Input::get('memo')), array('class' => 'form-control', 'placeholder' => 'カテゴリ詳細を入力')) }}
                @if($errors->has('memo'))
                <div class="alert alert-danger">
                    {{ $errors->first('memo') }}
                </div>
                @endif
            </div>
            
            
            
            <div class="form-group">
                {{ Form::label('image', 'カテゴリ画像', array("class" => "control-label")) }}
                {{ Form::file('image', array("id" => "upload")) }}
                <div id='loading' class="text-center space-top-10"></div>
                <div id="uploaded" class="text-center">
                
                {{ $filePath = Input::get("filePath"); }}
                @if(!empty($filePath))
                    <img src="{{ Input::get("filePath") }}" style="width: 240px;" />
                @elseif(!is_null($image))
                <img src="{{ FileUtil::showFile($image['key']) }}" style="width: 240px;" />
                <script type="text/javascript">$(function() { $("#deleteArea") .show(); })</script>
                @else
                    <img src="/images/no-image.gif" style="width: 240px;" />
                @endif
                </div>
                <div id="progress"></div>
                
                <div class="text-center space-top-10 space-bottom-10" id="deleteArea">
                    <input type="button" class="btn btn-warning deleteLogo" value="カテゴリ画像の削除" />
                </div>
            </div>
            
            <div class="form-actions" style="text-align:center;">
                {{ Form::submit('入力した内容の確認', array('class'=>'btn btn-primary')) }}
            </div>
        </fieldset>
    {{ Form::hidden('filePath', '', array("id" => 'filePath')) }}
    {{ Form::hidden('remove', 'false') }}
    {{ Form::hidden('tmpDir', sha1(Auth::user()->id)) }}
    {{ Form::hidden('APC_UPLOAD_PROGRESS', md5(Auth::user()->id), array("id" => "progress_key")) }}
    {{ Form::hidden('id', Input::get('id')) }}
    @if(!is_null($image))
    {{ Form::hidden('file_id', $image['id']) }}
    @endif
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop