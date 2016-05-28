@extends('layout.admin')


@section('title')
@parent
運営会社 {{ (Input::get('id') ? "編集" : "新規登録") }}フォーム
@stop

@section('content')

<!-- 郵便番号ライブラリの読み込み -->
{{HTML::script('http://ajaxzip3.googlecode.com/svn/trunk/ajaxzip3/ajaxzip3.js')}}
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/setting/company/confirm','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>運営会社 {{ (Input::get('id') ? "編集" : "新規登録") }}</legend>
                        
            <div class="alert alert-warning"><span class="important">※</span>は必須項目</div>
            <div class="form-group">
                {{ Form::label('company_name', '運営会社名', array("class" => "control-label")) }}<span class="important"> ※</span>
                {{ Form::text('company_name', e(Input::get('company_name')), array('class' => 'form-control', 'placeholder' => '運営会社名を入力')) }}
                @if($errors->has('company_name'))
                <div class="alert alert-danger">
                    {{ $errors->first('company_name') }}
                </div>
                @endif
            </div>
            
            
            
            <div class="form-group">
                {{ Form::label('company_kana', '運営会社名 フリガナ', array("class" => "control-label")) }}<span class="important"> ※</span>
                {{ Form::text('company_kana', e(Input::get('company_kana')), array('class' => 'form-control', 'placeholder' => '運営会社名のフリガナを入力')) }}
                @if($errors->has('company_kana'))   
                <div class="alert alert-danger">
                    {{ $errors->first('company_kana') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('zipcode', '郵便番号', array('class' => 'control-label')) }}
                {{ Form::text('zipcode', e(Input::get('zipcode')), array('class' => 'form-control', 'placeholder' => 'ハイフンは含めずに入力', 'style' => 'width: 200px;', 'onKeyUp' => 'AjaxZip3.zip2addr(this,\'\',\'addr1\',\'addr1\');')) }}
                @if($errors->has('zipcode'))
                <div class="alert alert-danger">
                    {{ $errors->first('zipcode') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('addr1', '住所　都道府県・番地', array("class" => "control-label")) }}
                {{ Form::text('addr1', e(Input::get('addr1')), array('class' => 'form-control', 'placeholder' => '都道府県・番地を入力')) }}
                @if($errors->has('addr1'))
                <div class="alert alert-danger">
                    {{ $errors->first('addr1') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('addr2', '住所　ビル・アパート・マンション名など', array("class" => "control-label")) }}
                {{ Form::text('addr2', e(Input::get('addr2')), array('class' => 'form-control', 'placeholder' => 'ビル・アパート・マンション名などを入力')) }}
                @if($errors->has('addr2'))
                <div class="alert alert-danger">
                    {{ $errors->first('addr2') }}
                </div>
                @endif
            </div>
            
            
            
            <div class="form-group">
                {{ Form::label('email', 'Eメールアドレス', array("class" => "control-label")) }}
                {{ Form::text('email', e(Input::get('email')), array('class' => 'form-control', 'placeholder' => 'Eメールアドレスを入力')) }}
                @if($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('tel', '電話番号', array("class" => "control-label")) }}
                {{ Form::text('tel', e(Input::get('tel')), array('class' => 'form-control', 'placeholder' => '電話番号を入力', 'style' => 'width: 300px;')) }}
                @if($errors->has('tel'))
                <div class="alert alert-danger">
                    {{ $errors->first('tel') }}
                </div>
                @endif
            </div>
            
            
            
            <div class="form-group">
                {{ Form::label('detail', '会社詳細', array("class" => "control-label")) }}
                {{ Form::textarea('detail', e(Input::get('detail')), array('class' => 'form-control', 'placeholder' => '運営会社の詳細情報を入力')) }}
                @if($errors->has('detail'))
                <div class="alert alert-danger">
                    {{ $errors->first('detail') }}
                </div>
                @endif
            </div>

            
            <div class="form-actions" style="text-align:center;">
                {{ Form::submit('入力した内容の確認',array('class'=>'btn btn-primary')) }}
            </div>
        </fieldset>
    {{ Form::hidden('id', Input::get('id')) }}
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop