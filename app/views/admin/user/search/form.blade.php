@extends('layout.admin')

@section('title')
@parent
会員検索フォーム
@stop

@section('content')
<script type="text/javascript" src="/js/admin/user/search/form.js"></script>
<div class="row">
<div class="col-md-2"></div>

<div class="col-md-8">
    
    {{ Form::open(array('url' => '/admin/user/search/search','class' => '')) }}<legend>会員検索</legend>
    
    <fieldset class="row">
        <div class="col-md-12 space-bottom-20">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('user_id', '会員ID', array("class" => "control-label")) }}&nbsp;<label>{{ Form::checkbox('not_user_id', true, Input::get("not_user_id", false) ? true : false) }}除外</label></div>
                    <div class="panel-body">{{ Form::textarea('user_id', Input::get('user_id'), array('class' => 'form-control input-sm', 'rows' => 5)) }}</div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('login_id', 'ログインID', array("class" => "control-label")) }}&nbsp;<label>{{ Form::checkbox('not_login_id', true, Input::get("not_login_id", false) ? true : false) }}除外</label></div>
                    <div class="panel-body">{{ Form::textarea('login_id', Input::get('login_id'), array('class' => 'form-control input-sm', 'rows' => 5)) }}</div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ Form::label('email', 'E-Mail', array("class" => "control-label")) }}&nbsp;
                        <label>{{ Form::checkbox('not_email', true, Input::get("not_email", false) ? true : false) }}除外</label>&nbsp;
                        <label>{{ Form::checkbox('like_email', true, Input::get("like_email", false) ? true : false) }}曖昧</label>
                    </div>
                    <div class="panel-body">{{ Form::textarea('email', Input::get('email'), array('class' => 'form-control input-sm', 'rows' => 5)) }}</div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 space-bottom-20">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('last_name', '姓', array("class" => "control-label")) }}</div>
                    <div class="panel-body">{{ Form::text('last_name', e(Input::get('last_name')), array('class' => 'form-control input-sm', 'maxlength' => '85')) }}</div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('first_name', '名', array("class" => "control-label")) }}</div>
                    <div class="panel-body">{{ Form::text('first_name', e(Input::get('first_name')), array('class' => 'form-control input-sm', 'maxlength' => '85')) }}</div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('tel', '電話番号', array("class" => "control-label")) }}</div>
                    <div class="panel-body">{{ Form::text('tel', e(Input::get('tel')), array('class' => 'form-control input-sm', 'maxlength' => '11')) }}</div>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 space-bottom-20">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('gender', '性別', array("class" => "control-label")) }}</div>
                    <div class="panel-body">
                        <label class="male">{{ Form::checkbox('gender[]', '1', in_array('1', Input::get('gender', array())) ? true : false) }}&nbsp;男性</label>&nbsp;
                        <label class="female">{{ Form::checkbox('gender[]', '2', in_array('2', Input::get('gender', array())) ? true : false) }}&nbsp;女性</label>&nbsp;
                        <label>{{ Form::checkbox('gender[]', '0', in_array('0', Input::get('gender', array())) ? true : false) }}&nbsp;不明</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('registered_status', '登録ステータス', array("class" => "control-label")) }}</div>
                    <div class="panel-body">
                        <label class="formal">{{ Form::checkbox('registered_status[]', 'formal', in_array('formal', Input::get('registered_status', array())) ? true : false) }}&nbsp;本登録</label>&nbsp;
                        <label class="interim">{{ Form::checkbox('registered_status[]', 'interim', in_array('interim', Input::get('registered_status', array())) ? true : false) }}&nbsp;仮登録</label>&nbsp;
                        <label class="withdraw">{{ Form::checkbox('registered_status[]', 'withdraw', in_array('withdraw', Input::get('registered_status', array())) ? true : false) }}&nbsp;退会</label>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('blood_type', '血液型', array("class" => "control-label")) }}</div>
                    <div class="panel-body">
                        <label>{{ Form::checkbox('blood_type[]', 'A', in_array('A', Input::get('blood_type', array())) ? true : false) }}&nbsp;A</label>&nbsp;
                        <label>{{ Form::checkbox('blood_type[]', 'B', in_array('B', Input::get('blood_type', array())) ? true : false) }}&nbsp;B</label>&nbsp;
                        <label>{{ Form::checkbox('blood_type[]', 'O', in_array('O', Input::get('blood_type', array())) ? true : false) }}&nbsp;O</label>&nbsp;
                        <label>{{ Form::checkbox('blood_type[]', 'AB', in_array('AB', Input::get('blood_type', array())) ? true : false) }}&nbsp;AB</label>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-12 space-bottom-20">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ Form::label('datetime1', '日時検索1', array("class" => "control-label")) }}
                        <span class="quickhelp">バッチ検索の[日前] [週間前] [ヶ月前]は<br />開始日時の場合、<strong>0時0分0秒</strong><br />終了日時の場合、<strong>23時59分59秒</strong>に<br />自動的に設定されます。</span>
                    </div>
                    <div class="panel-body">
                        {{ Form::select('datetime1_unit', array('' => '利用しない', 'in' => '絞込み', 'not_in' => '除外'), Input::get('datetime1_unit'), array('class' => 'form-control input-sm')) }}
                        {{ Form::select('datetime1_category', $datetimeList, Input::get('datetime1_category'), array('class' => 'form-control input-sm')) }}
                        <div class="space-top-10">
                            <div class="space-bottom-10">
                                【開始】<label>{{ Form::checkbox('is_batch1_begin', true, Input::get("is_batch1_begin", false) ? true : false) }}&nbsp;バッチ検索</label><br />
                                <div class="datetime">
                                {{ Form::text('datetime1_begin', Input::get('datetime1_begin'), array('class' => 'form-control input-sm datetimepicker')) }}
                                </div>
                                <div class="batch">
                                    {{ Form::text('batch1_begin', Input::get('batch1_begin'), array('class' => 'form-control input-sm inline', 'size' => '3')) }}
                                    {{ Form::select('batch1_unit_begin', array('minutes' => '分前', 'hours' => '時間前', 'days' => '日前', 'weeks' => '週間前', 'months' => 'ヶ月前'), Input::get('batch1_unit_begin'), array('class' => 'form-control input-sm inline')) }}
                                </div>
                            </div>
                            
                            <div class="space-bottom-10">
                                【終了】<label>{{ Form::checkbox('is_batch1_end', true, Input::get("is_batch_end1", false) ? true : false) }}&nbsp;バッチ検索</label><br />
                                <div class="datetime">
                                {{ Form::text('datetime1_end', Input::get('datetime1_end'), array('class' => 'form-control input-sm datetimepicker')) }}
                                </div>
                                <div class="batch">
                                    {{ Form::text('batch1_end', Input::get('batch1_begin'), array('class' => 'form-control input-sm', 'size' => '3', 'style' => 'width: auto; display: inline;')) }}
                                    {{ Form::select('batch1_unit_end', array('minutes' => '分前', 'hours' => '時間前', 'days' => '日前', 'weeks' => '週間前', 'months' => 'ヶ月前'), Input::get('batch1_unit_end'), array('class' => 'form-control input-sm inline')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ Form::label('datetime2', '日時検索2', array("class" => "control-label")) }}
                        <span class="quickhelp">バッチ検索の[日前] [週間前] [ヶ月前]は<br />開始日時の場合、<strong>0時0分0秒</strong><br />終了日時の場合、<strong>23時59分59秒</strong>に<br />自動的に設定されます。</span>
                    </div>
                    <div class="panel-body">
                        {{ Form::select('datetime2_unit', array('' => '利用しない', 'in' => '絞込み', 'not_in' => '除外'), Input::get('datetime2_unit'), array('class' => 'form-control input-sm')) }}
                        {{ Form::select('datetime2_category', $datetimeList, Input::get('datetime2_category'), array('class' => 'form-control input-sm')) }}
                        <div class="space-top-10">
                            <div class="space-bottom-10">
                                【開始】<label>{{ Form::checkbox('is_batch2_begin', true, Input::get("is_batch2_begin", false) ? true : false) }}&nbsp;バッチ検索</label><br />
                                <div class="datetime">
                                {{ Form::text('datetime2_begin', Input::get('datetime2_begin'), array('class' => 'form-control input-sm datetimepicker')) }}
                                </div>
                                <div class="batch">
                                    {{ Form::text('batch2_begin', Input::get('batch2_begin'), array('class' => 'form-control input-sm', 'size' => '3', 'style' => 'width: auto; display: inline;')) }}
                                    {{ Form::select('batch2_unit_begin', array('minutes' => '分前', 'hours' => '時間前', 'days' => '日前', 'weeks' => '週間前', 'months' => 'ヶ月前'), Input::get('batch2_unit_begin'), array('class' => 'form-control input-sm inline')) }}
                                </div>
                            </div>
                            
                            <div class="space-bottom-10">
                                【終了】<label>{{ Form::checkbox('is_batch2_end', true, Input::get("is_batch_end2", false) ? true : false) }}&nbsp;バッチ検索</label><br />
                                <div class="datetime">
                                {{ Form::text('datetime2_end', Input::get('datetime2_end'), array('class' => 'form-control input-sm datetimepicker')) }}
                                </div>
                                <div class="batch">
                                    {{ Form::text('batch2_end', Input::get('batch2_begin'), array('class' => 'form-control input-sm', 'size' => '3', 'style' => 'width: auto; display: inline;')) }}
                                    {{ Form::select('batch2_unit_end', array('minutes' => '分前', 'hours' => '時間前', 'days' => '日前', 'weeks' => '週間前', 'months' => 'ヶ月前'), Input::get('batch2_unit_end'), array('class' => 'form-control input-sm inline')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ Form::label('datetime3', '日時検索3', array("class" => "control-label")) }}
                        <span class="quickhelp">バッチ検索の[日前] [週間前] [ヶ月前]は<br />開始日時の場合、<strong>0時0分0秒</strong><br />終了日時の場合、<strong>23時59分59秒</strong>に<br />自動的に設定されます。</span>
                    </div>
                    <div class="panel-body">
                        {{ Form::select('datetime3_unit', array('' => '利用しない', 'in' => '絞込み', 'not_in' => '除外'), Input::get('datetime3_unit'), array('class' => 'form-control input-sm')) }}
                        {{ Form::select('datetime3_category', $datetimeList, Input::get('datetime3_category'), array('class' => 'form-control input-sm')) }}
                        <div class="space-top-10">
                            <div class="space-bottom-10">
                                【開始】<label>{{ Form::checkbox('is_batch3_begin', true, Input::get("is_batch3_begin", false) ? true : false) }}&nbsp;バッチ検索</label><br />
                                <div class="datetime">
                                {{ Form::text('datetime3_begin', Input::get('datetime3_begin'), array('class' => 'form-control input-sm datetimepicker')) }}
                                </div>
                                <div class="batch">
                                    {{ Form::text('batch3_begin', Input::get('batch3_begin'), array('class' => 'form-control input-sm', 'size' => '3', 'style' => 'width: auto; display: inline;')) }}
                                    {{ Form::select('batch3_unit_begin', array('minutes' => '分前', 'hours' => '時間前', 'days' => '日前', 'weeks' => '週間前', 'months' => 'ヶ月前'), Input::get('batch3_unit_begin'), array('class' => 'form-control input-sm inline')) }}
                                </div>
                            </div>
                            
                            <div class="space-bottom-10">
                                【終了】<label>{{ Form::checkbox('is_batch3_end', true, Input::get("is_batch_end3", false) ? true : false) }}&nbsp;バッチ検索</label><br />
                                <div class="datetime">
                                {{ Form::text('datetime3_end', Input::get('datetime3_end'), array('class' => 'form-control input-sm datetimepicker')) }}
                                </div>
                                <div class="batch">
                                    {{ Form::text('batch3_end', Input::get('batch3_begin'), array('class' => 'form-control input-sm', 'size' => '3', 'style' => 'width: auto; display: inline;')) }}
                                    {{ Form::select('batch3_unit_end', array('minutes' => '分前', 'hours' => '時間前', 'days' => '日前', 'weeks' => '週間前', 'months' => 'ヶ月前'), Input::get('batch3_unit_end'), array('class' => 'form-control input-sm inline')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="col-md-12 space-bottom-20">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('birthday', '生年月日', array("class" => "control-label")) }}</div>
                    <div class="panel-body">
                        <a href="javascript:void(0)" class="birthday_of_today">今日が誕生日の会員</a><br />
                        {{ Form::select('birth_year', DateUtil::generateBirthYearArray(date('Y') - 1, 100, true), Input::get('birth_year'), array('class' => 'form-control input-sm inline'))}}年&nbsp;
                        {{ Form::select('birth_month', DateUtil::generateMonthArray(1, true), Input::get('birth_month'), array('class' => 'form-control input-sm inline'))}}月&nbsp;
                        {{ Form::select('birth_day', DateUtil::generateDayArray(1, true), Input::get('birth_day'), array('class' => 'form-control input-sm inline'))}}日
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ Form::label('manager_note', '管理者メモ', array("class" => "control-label")) }}<span class="quickhelp">改行区切りで or 検索を実行します。</span></div>
                    <div class="panel-body">
                        <label>{{ Form::textarea('manager_note', Input::get('manager_note', null), array('class' => 'form-control input-sm', 'rows' => 5)) }}</label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group col-md-12" style="text-align:center;">
            <div>表示件数：{{ Form::text('limit', Input::get('limit', 100), array('class' => 'form-control input-sm inline', 'size' => '5')) }}件</div>
            <div class="space-top-10">
                {{ Form::select('order_type', array('user_id' => '会員ID', 'last_logged_in_at' => '最終ログイン日時', 'last_reserved_at' => '最終予約日時'), Input::get('order_type'), array('class' => 'form-control input-sm inline')) }}
                {{ Form::select('order', array('desc' => '新しい順', 'asc' => '古い順'), Input::get('order'), array('class' => 'form-control input-sm inline')) }}
            </div>
            {{ Form::submit('検索実行',array('class'=>'btn btn-primary space-top-20')) }}
        </div>
    </fieldset>

    {{ Form::close() }}
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>

<div class="col-md-2"></div>
</div>
@stop
