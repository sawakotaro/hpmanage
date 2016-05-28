<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
 <title>
 @section('title')
 @show
まとめサイト
 </title>
<meta name="viewport" content="width=device-width">
<meta name="copyright" content="Template Party">
<meta name="description" content="ここにサイト説明を入れます">
<meta name="keywords" content="キーワード１,キーワード２,キーワード３,キーワード４,キーワード５">
{{HTML::style("/css/front.css")}}
{{HTML::style("/css/style-m.css", array("media" => "only screen and (max-width:480px)"))}}
{{HTML::style("/css/style-s.css")}}
<link href="" rel="stylesheet" type="text/css" media="only screen and (max-width:480px)">
<link href="" rel="stylesheet" type="text/css" media="only screen and (min-width:481px) and (max-width:800px)">
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
{{HTML::script("/js/openclose.js")}}
</head>

<body id="top">

<header>
<div class="inner">
<h1><a href="index.html"><img src="images/logo.png" width="250" height="40" alt="SAMPLE CLUB"></a></h1>
<address><span class="tel">Tel：03-0000-0000</span>受付：17：00～24：00　休業日：月曜日</address>
</div>
</header>

<nav id="menu">
<ul id="menubar">
<li><a href="index.html">HOME<span>ホーム</span></a></li>
<li><a href="cast.html">CAST<span>キャスト</span></a></li>
<li><a href="schedule.html">SCHEDULE<span>スケジュール</span></a></li>
<li><a href="system.html">SYSTEM<span>システム</span></a></li>
<li><a href="access.html">ACCESS<span>アクセス</span></a></li>
<li><a href="recruit.html">RECRUIT<span>キャスト募集</span></a></li>
</ul>
</nav>

<div id="contents">

<div id="contents-in">

<div id="main">

<section>

<h2>無料テンプレートのご利用前に必ずお読み下さい</h2>
<p>このテンプレートは、<a href="http://template-party.com/">Template Party</a>及び<a href="http://girl-staff.com/">girl-staff</a>にて無料配布している『水商売(クラブ,キャバクラ等)サイト向け無料ホームページテンプレート tp_108』です。必ずダウンロード先のサイトの利用規約をご一読の上でご利用下さい。</p>
<p><span class="color1">■<strong>HP最下部の著作表示『Web Design:Template-Party＆Girl-Staff』は無断で削除しないで下さい。</strong></span><br>
わざと見えなく加工する事も禁止します。お守りいただけない場合、テンプレートの利用を中止し、違反金を請求いたします。</p>
<p><span class="color1">■<strong>どうしても下部の著作を外したい場合は</strong></span><br>
<a href="http://template-party.com/">Template-Party</a>の<a href="http://template-party.com/member.html">ライセンス契約</a>を行う事でHP下部の著作を外す事ができます。おまけ特典として、制作時Photoshopファイルももらえます。</p>

    <section>
    <h3>当テンプレートはhtml5+CSS3(レスポンシブWEBデザイン)です</h3>
    <p>パソコン、タブレット、スマートフォンに対応しています。各デバイスごとの設定変更はcssフォルダ内にある各cssファイルで行って下さい。<br>
    尚、新しいブラウザ(IEならIE10以降)でないと全ての効果を確認する事はできません。マークアップなどはご自身の判断で変更してご利用下さい。</p>
    </section>
    
    <section>
    <h3>当テンプレートの詳しい使い方</h3>
    <p><a href="cast.html#about">当テンプレートの詳しい使い方はこちらをご覧下さい。</a></p>
    </section>

</section>

<section>
<h2>スタッフ管理用プログラム販売中</h2>
<p>スタッフ一覧やスケジュール、簡易予約フォームなどが装備されたCMSを販売中。<br>
<a href="http://template-party.com/staff_program/index2.html">詳しくはこちらをご覧下さい。</a><br>
<a href="http://template-party.com/staff_program/index2.html"><img src="http://template-party.com/staff_program/img_temp600.jpg" width="550" height="231" alt="スタッフ管理用プログラム好評発売中" class="wa"></a></p>
</section>

<section id="new">
<h2 id="newinfo_hdr" class="close">更新情報・お知らせ</h2>
<dl id="newinfo">
<dt><time datetime="2014-11-23">2014/11/23</time></dt>
<dd>html側にtime要素が入っています。必要に応じて設定して下さい。分からない場合は外して頂いても構いません。<img src="images/icon_new.gif" alt="NEW" width="30" height="11"></dd>
<dt><time datetime="2014-00-00">2014/00/00</time></dt>
<dd>当ブロックは480px以下のウィンドウサイズの環境で開閉ブロックに変わります。<img src="images/icon_up.gif" alt="UP" width="30" height="11"></dd>
<dt><time datetime="2014-00-00">2014/00/00</time></dt>
<dd>ホームページリニューアル</dd>
<dt><time datetime="2014-00-00">2014/00/00</time></dt>
<dd>ホームページリニューアル</dd>
<dt><time datetime="2014-00-00">2014/00/00</time></dt>
<dd>ホームページリニューアル</dd>
<dt><time datetime="2014-00-00">2014/00/00</time></dt>
<dd>ホームページリニューアル</dd>
<dt><time datetime="2014-00-00">2014/00/00</time></dt>
<dd>ホームページリニューアル</dd>
</dl>
</section>

<section>

<h2 class="mb15">CAST</h2>

	<section class="list">
	
	<h3 class="mb15">本日出勤のキャスト</h3>
	
	    <section>
	    <a href="staff.html">
	    <h4>sample name</h4>
	    <figure><img src="images/photo1.gif" alt="" width="100" height="100"></figure>
	    <figcaption>アイコンのimgタグにclass=&quot;icon&quot;を指定すれば右下に配置されます。</figcaption>
	    <img src="images/icon_no1.gif" alt="" width="28" height="28" class="icon">
	    </a>
	    </section>
        
	    <section>
	    <a href="staff.html">
	    <h4>sample name</h4>
    	<figure><img src="images/photo1.gif" alt="" width="100" height="100"></figure>
    	<figcaption>簡単な説明を入れます。</figcaption>
    	<img src="images/icon_check.gif" alt="" width="28" height="28" class="icon">
    	</a>
    	</section>
        
    	<section>
    	<a href="staff.html">
    	<h4>sample name</h4>
    	<figure><img src="images/photo1.gif" alt="" width="100" height="100"></figure>
    	<figcaption>文字をつめこみすぎるとボックスから飛び出た部分が非表示になります。余裕をもって入力して下さい。</figcaption>
    	</a>
    	</section>
        
    	<section>
    	<a href="staff.html">
    	<h4>sample name</h4>
    	<figure><img src="images/photo1.gif" alt="" width="100" height="100"></figure>
    	<figcaption>簡単な説明を入れます。</figcaption>
    	</a>
    	</section>
	
	</section>
	<!--/list-->
	
	<section class="list">
	
	<h3 class="mb15">New Face !</h3>
	
	    <section>
	    <a href="staff.html">
	    <h4>sample name</h4>
	    <figure><img src="images/photo1.gif" alt="" width="100" height="100"></figure>
	    <figcaption>アイコンのimgタグにclass=&quot;icon&quot;を指定すれば右下に配置されます。</figcaption>
	    <img src="images/icon_no1.gif" alt="" width="28" height="28" class="icon">
	    </a>
	    </section>
        
	    <section>
	    <a href="staff.html">
	    <h4>sample name</h4>
    	<figure><img src="images/photo1.gif" alt="" width="100" height="100"></figure>
    	<figcaption>簡単な説明を入れます。</figcaption>
    	<img src="images/icon_check.gif" alt="" width="28" height="28" class="icon">
    	</a>
    	</section>
        
    	<section>
    	<a href="staff.html">
    	<h4>sample name</h4>
    	<figure><img src="images/photo1.gif" alt="" width="100" height="100"></figure>
    	<figcaption>文字をつめこみすぎるとボックスから飛び出た部分が非表示になります。余裕をもって入力して下さい。</figcaption>
    	</a>
    	</section>
        
    	<section>
    	<a href="staff.html">
    	<h4>sample name</h4>
    	<figure><img src="images/photo1.gif" alt="" width="100" height="100"></figure>
    	<figcaption>簡単な説明を入れます。</figcaption>
    	</a>
    	</section>
	
	</section>
	<!--/list-->

</section>

</div>
<!--/main-->

<div id="sub">

<nav class="box1">
<h2>SUB MENU</h2>
<ul>
<li><a href="#">主要リンクサンプル</a></li>
<li><a href="#">主要リンクサンプル</a></li>
<li><a href="#">主要リンクサンプル</a></li>
<li><a href="#">主要リンクサンプル</a></li>
<li><a href="#">主要リンクサンプル</a></li>
</ul>
</nav>

<nav class="box1">
<ul>
<li><a href="#">主要リンクサンプル</a></li>
<li><a href="#">主要リンクサンプル</a></li>
<li><a href="#">主要リンクサンプル</a></li>
<li><a href="#">主要リンクサンプル</a></li>
<li><a href="#">主要リンクサンプル</a></li>
</ul>
</nav>

<section class="box1">
<h2 class="mb5">アクセス</h2>
<p class="mini1">東京都XX区XXXXビル３F<br>
TEL：03-0000-0000<br>
受付：9:00～16:00<br>
定休日：土日祝</p>
</section>

<section class="box1">
<h2>このボックスは</h2>
<p>class=&quot;box1&quot;<br>
とすると出ます。ここに画像を置く場合、188px（※PC環境）まで。</p>
</section>

<section>
<h2>ボックスの外も</h2>
<p>使えます。ここは幅200px（※PC環境）まで。</p>
</section>

</div>
<!--/sub-->

</div>
<!--/contents in-->

<div id="side">

<aside>
<h2>関連情報</h2>
<ul>
<li><a href="#">関連情報リンク</a></li>
<li><a href="#">関連情報リンク</a></li>
<li><a href="#">関連情報リンク</a></li>
<li><a href="#">関連情報リンク</a></li>
<li><a href="#">関連情報リンク</a></li>
</ul>
</aside>

<section class="box1">
<h2>サンプル見出し</h2>
<p>サンプルテキスト。サンプルテキスト。サンプルテキスト。サンプルテキスト。サンプルテキスト。サンプルテキスト。</p>
</section>

<section>
<h2>サンプル見出し</h2>
<p class="box1">サンプルテキスト。サンプルテキスト。サンプルテキスト。サンプルテキスト。サンプルテキスト。サンプルテキスト。</p>
</section>

<aside>
<a href="recruit.html"><img src="images/sample_banner1.jpg" width="200" height="130" alt="採用情報"></a>
</aside>

</div>
<!--/side-->

<p id="pagetop"><a href="#">↑ PAGE TOP</a></p>

</div>
<!--/contents-->

<footer>
<small>Copyright&copy; 2014 <a href="index.html">SAMPLE CLUB</a> All Rights Reserved.</small>
<span class="pr"><a href="http://template-party.com/" target="_blank">Web Design:Template-Party</a>＆<a href="http://girl-staff.com/">Girl-Staff</a></span>
</footer>

<!--スマホ用メニューバー-->
<img src="images/icon_bar.png" width="20" height="16" alt="" id="menubar_hdr" class="open">

<!--スマホ用更新情報-->
<script type="text/javascript">
if (OCwindowWidth() < 480) {
	open_close("newinfo_hdr", "newinfo");
}
</script>

</body>
</html>
