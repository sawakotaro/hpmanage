<!DOCTYPE html>
<html lang="ja">
 <head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <title>
 @section('title')
HP-Manager
 @show
 </title>
<!-- Bootstrap -->
 <link media="all" type="text/css" rel="stylesheet" href="/lib/bootstrap/bootstrap.min.css" />
 <link media="all" type="text/css" rel="stylesheet" href="/css/style.css" />
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 {{HTML::script("http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js")}}
 {{HTML::script("https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js")}}
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script type="text/javascript" src="/lib/bootstrap/bootstrap.min.js"></script>
 <script type="text/javascript" src="/lib/bootbox/bootbox.js"></script>
 <script type="text/javascript" src="/lib/BlockUI/source.js"></script>
 <script type="text/javascript" src="/js/common.js"></script>
 <script type="text/javascript" src="/js/quickhelp.js"></script>
 
 <!-- load datetimepicker -->
 <link media="all" type="text/css" rel="stylesheet" href="/lib/datetimepicker/jquery.datetimepicker.css" />
 <script type="text/javascript" src="/lib/datetimepicker/jquery.datetimepicker.full.min.js"></script>
 
 
 <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
 <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
 <!--[if lt IE 9]>
 <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
 <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
 <![endif]-->
 

 <!-- Switch Button -->
<script type="text/javascript">
$(document).ready( function(){ 
    $(".cb-enable").click(function(){
        var parent = $(this).parents('.switch');
        $('.cb-disable',parent).removeClass('selected');
        $(this).addClass('selected');
        $('.checkbox',parent).attr('checked', true);
    });
    $(".cb-disable").click(function(){
        var parent = $(this).parents('.switch');
        $('.cb-enable',parent).removeClass('selected');
        $(this).addClass('selected');
        $('.checkbox',parent).attr('checked', false);
    });
    
    // setting the DateTimePicker
    $.datetimepicker.setLocale('ja');
    $(".datetimepicker") .datetimepicker({
         format: 'Y-m-d H:i',
         allowTimes: createTimeList(5)
    });
});


</script>
 </head>
 <body>
 @section('navbar')
 <div class="navbar navbar-inverse navbar-fixed-top" role='navigation'>
 <div class="navbar-header">
 <button type='button' class="navbar-toggle" data-toggle='collapse' data-target='.navbar-collapse'>
 <span class="sr-only">Toggle navigation</span>
 <span class="icon-bar"></span>
 <span class="icon-bar"></span>
 <span class="icon-bar"></span>
 </button>
 <a class="navbar-brand" href="#">システム管理画面</a>
 </div>
 <div class="collapse navbar-collapse">
 <ul class="nav navbar-nav">
  <li  class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown">サイト管理 <b class="caret"></b></a>
     <ul class="dropdown-menu">
         <li class="dropdown-header">サイト設定</li>
        <li>{{link_to('/admin/setting/site/form','新規作成')}}</li>
        <li>{{link_to('/admin/setting/site/list','登録リスト一覧')}}</li>
        <li class="divider"></li>
        <li class="dropdown-header">運営会社</li>
        <li>{{link_to('/admin/setting/company/form', '新規作成')}}</li>
        <li>{{link_to('/admin/setting/company/list', '登録リスト一覧')}}</li>
     </ul>
 </li>
 
  <li  class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown">ユーザー管理 <b class="caret"></b></a>
     <ul class="dropdown-menu">
        <li>{{link_to('/admin/user/search/form','会員検索')}}</li>
        <li>{{link_to('/admin/user/entry/form','ユーザー手動登録')}}</li>
        <li class="divider"></li>
        <li class="dropdown-header">運営会社</li>
        <li>{{link_to('/admin/setting/company/form', '新規作成')}}</li>
        <li>{{link_to('/admin/setting/company/list', '登録リスト一覧')}}</li>
     </ul>
 </li>
 
 <li  class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown">管理アカウント管理 <b class="caret"></b></a>
     <ul class="dropdown-menu">
        <li>{{link_to('/admin/auth/form','新規作成')}}</li>
        <li>{{link_to('/admin/auth/list','登録リスト 一覧')}}</li>
        <li class="divider"></li>
        <li class="dropdown-header">Nav header</li>
        <li><a href="#">Separated link</a></li>
     </ul>
 </li>
 <!--
  <li  class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown">メニュー管理 <b class="caret"></b></a>
     <ul class="dropdown-menu">
         <li class="dropdown-header">カテゴリ設定</li>
        <li>{{link_to('/admin/menu/category/form','新規作成')}}</li>
        <li>{{link_to('/admin/menu/category/list','登録リスト 一覧')}}</li>
        <li class="divider"></li>
     </ul>
 </li>

 
  <li  class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown">記事管理 <b class="caret"></b></a>
     <ul class="dropdown-menu">
        <li class="dropdown-header">記事サイト</li>
        <li>{{link_to('/admin/menu/article/site/form','新規作成')}}</li>
        <li>{{link_to('/admin/menu/article/site/list','登録リスト 一覧')}}</li>
        <li class="divider"></li>
        <li class="dropdown-header">記事</li>
        <li>{{link_to('/admin/menu/article','記事 一覧')}}</li>
     </ul>
 </li>

 
  <li  class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown">コンテンツ管理 <b class="caret"></b></a>
     <ul class="dropdown-menu">
        <li class="dropdown-header">動画</li>
        <li>{{link_to('/admin/contents/movie/form','新規作成')}}</li>
        <li>{{link_to('/admin/contents/movie/list','動画 一覧')}}</li>
        <li class="divider"></li>
        <!--
        <li class="dropdown-header">画像</li>
        <li>{{link_to('/admin/contents/image/form','新規作成')}}</li>
        <li>{{link_to('/admin/contents/image/list','画像 一覧')}}</li>
        -->
     </ul>
 </li>
   --> 
 
 
  <li>{{link_to('/admin/signout','サインアウト')}}</li>
 </ul>
 </div>
 </div>
 @show
 <div class='container'>
 @yield('content')
</div>
 <div id="footer">
 <div class="container">
 <p class="text-muted">
 @section('footer')
 winroad.jp
 @show
 </p>
 </div>
 </div>

 </body>
</html>