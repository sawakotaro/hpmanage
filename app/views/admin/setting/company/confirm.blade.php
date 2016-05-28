@extends('layout.admin')

@section('title')
@parent
運営会社 {{ (Input::get('id') ? "編集" : "新規登録") }}フォーム 入力内容のご確認
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/setting/company/register','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>運営会社の{{ (Input::get('id') ? "編集" : "新規登録") }} 入力内容のご確認</legend>
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('company_name', '運営会社名', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{Input::get('company_name')}}}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('company_kana', '運営会社名 フリガナ', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{Input::get('company_kana')}}}</div>
            </div>
            
            
            @if(Input::get('zipcode'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('zipcode', '郵便番号', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{substr(Input::get('zipcode'), 0, 3) . '-' . substr(Input::get('zipcode'), 3)}}}</div>
            </div>
            @endif
            
            
            @if(Input::get('addr1'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('addr1', '住所 都道府県・番地', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('addr1')}}}</div>
            </div>
            @endif
            
            
            @if(Input::get('addr2'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('addr2', '住所 ビル・アパート・マンション名など', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('addr2')}}}</div>
            </div>
            @endif
            
            
            @if(Input::get('email'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('email', 'Eメールアドレス', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('email')}}}</div>
            </div>
            @endif
            
            
            @if(Input::get('tel'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('tel', '電話番号', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('tel')}}}</div>
            </div>
            @endif
            
            
            @if(Input::get('detail'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('detail', '会社詳細', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('detail')}}}</div>
            </div>
            @endif
            
            <div class="form-actions" style="text-align:center;">
                <input type="submit" name="execute" value="この内容で登録" class="btn btn-primary" />
                &emsp;
                <input type="submit" name="cancel" value="キャンセル" class="btn btn-default" />
            </div>
        </fieldset>
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop