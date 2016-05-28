@extends('layout.admin')

@section('title')
@parent
会員{{ (Input::get('id') ? "編集" : "新規登録") }}フォーム
@stop



@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class="col-md-6">
    {{ Form::open(array('url' => '/admin/user/entry/confirm','class' => '')) }}
    <fieldset class="row">
        <legend>会員{{ (Input::get('id') ? "編集" : "新規登録") }}</legend>
        <div class="form-group" class="col-md-12">
            <div class="col-md-6">
                {{ Form::label('last_name', '姓', array("class" => "control-label")) }}
                {{ Form::text('last_name', e(Input::get('last_name')), array('class' => 'form-control input-sm', 'maxlength' => '85')) }}
                @if($errors->has('last_name'))
                <div class="alert alert-danger">
                    {{ $errors->first('last_name') }}
                </div>
                @endif
            </div>
            <div class="col-md-6">
                {{ Form::label('first_name', '名', array("class" => "control-label")) }}
                {{ Form::text('first_name', e(Input::get('first_name')), array('class' => 'form-control input-sm', 'maxlength' => '85')) }}
                @if($errors->has('first_name'))
                <div class="alert alert-danger">
                    {{ $errors->first('first_name') }}
                </div>
                @endif
            </div>
        </div>
        
        <div class="form-group" class="col-md-12">
            <div class="col-md-6">
                {{ Form::label('last_kana', '姓 (フリガナ)', array("class" => "control-label")) }}
                {{ Form::text('last_kana', e(Input::get('last_kana')), array('class' => 'form-control input-sm', 'placeholder' => '全角カナ', 'maxlength' => '85')) }}
                @if($errors->has('last_kana'))
                <div class="alert alert-danger">
                    {{ $errors->first('last_kana') }}
                </div>
                @endif
            </div>
            <div class="col-md-6">
                {{ Form::label('first_kana', '名 (フリガナ)', array("class" => "control-label")) }}
                {{ Form::text('first_kana', e(Input::get('first_kana')), array('class' => 'form-control input-sm', 'placeholder' => '全角カナ', 'maxlength' => '85')) }}
                @if($errors->has('first_kana'))
                <div class="alert alert-danger">
                    {{ $errors->first('first_kana') }}
                </div>
                @endif
            </div>
        </div>
        
        
        <div class="form-group" class="col-md-12">
            <div class="col-md-12 space-top-20">
                {{ Form::label('gender', '性別', array("class" => "control-label")) }}<br />
                <label class="male">{{Form::radio('gender', 1, intval(Input::get('gender')) === 1 ? true : false)}}男性</label>&emsp;
                <label class="female">{{Form::radio('gender', 2, intval(Input::get('gender')) === 2 ? true : false)}}女性</label>
            </div>
        </div>
        
        
        <div class="form-group" class="col-md-12">
            <div class="col-md-12 space-top-20">
                {{ Form::label('birthday', '生年月日', array("class" => "control-label")) }}<br />
                {{ Form::select('birth_year', DateUtil::generateBirthYearArray(date('Y') - 1, 100), Input::get('birth_year', date('Y') - 1), array('class' => 'form-control input-sm', "style" => "width: auto; display: inline;"))}}年&emsp;
                {{ Form::select('birth_month', DateUtil::generateMonthArray(1), Input::get('birth_month', 1), array('class' => 'form-control input-sm', "style" => "width: auto; display: inline;"))}}月&emsp;
                {{ Form::select('birth_day', DateUtil::generateDayArray(1), Input::get('birth_day', 1), array('class' => 'form-control input-sm', "style" => "width: auto; display: inline;"))}}日
            </div>
            
            @if($errors->has('birthday'))
            <div class="col-md-12">
                <div class="alert alert-danger">
                    {{ $errors->first('birthday') }}
                </div>
            </div>
            @endif
        </div>
        
        
        <div class="form-group" class="col-md-12">
            <div class="col-md-12 space-top-20">
                {{ Form::label('blood_type', '血液型', array("class" => "control-label")) }}<br />
                <label>{{Form::radio('blood_type', 'A', Input::get('blood_type') === 'A' ? true : false)}}A型</label>&emsp;
                <label>{{Form::radio('blood_type', 'B', Input::get('blood_type') === 'B' ? true : false)}}B型</label>&emsp;
                <label>{{Form::radio('blood_type', 'O', Input::get('blood_type') === 'O' ? true : false)}}O型</label>&emsp;
                <label>{{Form::radio('blood_type', 'AB', Input::get('blood_type') === 'AB' ? true : false)}}AB型</label>
            </div>
        </div>
        
        
        <div class="form-group" class="col-md-12">
            <div class="col-md-12 space-top-20">
                {{ Form::label('tel', '電話番号', array("class" => "control-label")) }}<br />
                {{ Form::text('tel', e(Input::get('tel')), array('class' => 'form-control input-sm', 'maxlength' => '11', 'placeholder' => 'ハイフンは含めず、半角数字のみでご入力ください。')) }}
                @if($errors->has('tel'))
                <div class="alert alert-danger">
                    {{ $errors->first('tel') }}
                </div>
                @endif
            </div>
        </div>
        
        
        <div class="form-group" class="col-md-12">
            <div class="col-md-12 space-top-20">
                {{ Form::label('email', 'E-Mail', array("class" => "control-label")) }}<br />
                {{ Form::email('email', e(Input::get('email')), array('class' => 'form-control input-sm', 'maxlength' => '100')) }}
                @if($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-md-12 space-top-20">
                @if(Input::get('id', null) !== null)
                <script type="text/javascript">
                    $(function() {
                        togglePasswordArea();
                        $(":input[name='is_edit_password']") .change(function() { togglePasswordArea() });
                    });
                    function togglePasswordArea() {
                        if($(":input[name='is_edit_password']") .prop("checked")) {
                            $(".passwordForm") .show();
                        } else {
                            $(".passwordForm") .hide();
                        }
                    }
                </script>
                <label>{{ Form::checkbox('is_edit_password', true) }}&nbsp;パスワードを変更する</label>
                
                @endif
                <div class="passwordForm">
                    {{ Form::label('password', 'パスワード', array("class" => "control-label")) }}<br />
                    {{ Form::password('password', array('class' => 'form-control input-sm', 'placeholder' => '半角英数字・アンダースコアのみで8～32文字以内', 'maxlength' => '32')) }}
                    @if($errors->has('password'))
                    <div class="alert alert-danger">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-md-12 space-top-20">
                {{ Form::label('registered_status', '登録ステータス', array("class" => "control-label")) }}<br />
                <label class="formal">{{Form::radio('registered_status', 'formal', Input::get('registered_status') === 'formal' ? true : false)}}本登録</label>&emsp;
                <label class="interim">{{Form::radio('registered_status', 'interim', Input::get('registered_status') === 'interim' ? true : false)}}仮登録</label>&emsp;
                <label class="withdraw">{{Form::radio('registered_status', 'withdraw', Input::get('registered_status') === 'withdraw' ? true : false)}}退会</label>
                @if($errors->has('registered_status'))
                <div class="alert alert-danger">
                    {{ $errors->first('registered_status') }}
                </div>
                @endif
            </div>
        </div>
        
        
        <div class="form-group">
            <div class="col-md-12 space-top-20">
                {{ Form::label('manager_note', '管理者メモ', array("class" => "control-label")) }}<br />
                {{ Form::textarea('manager_note', Input::get('manager_note', null), array('class' => 'form-control', 'cols' => '80', 'rows' => '10')) }}
            </div>
        </div>
        
        
            
        <div class="form-group col-md-12" style="text-align:center;">
            {{ Form::submit('入力した内容の確認',array('class'=>'btn btn-primary space-top-20')) }}
        </div>
        
    </fieldset>
    {{ Form::hidden('id', Input::get('id')) }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop
