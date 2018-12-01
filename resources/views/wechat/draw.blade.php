<?php

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover">
<title>翻牌抽奖领红包</title>
<link href="css/weui.min.css" rel="stylesheet" />
<style>
body {
    background: #E7244B;
}

	.top {
    width: 100%;
}

	.weui-grid {
    padding: 0;
}

		.weui-grid:before {
    border: 0;
}

		.weui-grid:after {
    border: 0;
}

	.weui-grids:before {
    border: 0;
}

	a {
    text-align: center;
	}

	.img {
    width: 90%;
    margin-top: 1vw;
		height: 33.9vw;
	}

	.info {
    display: none;
    margin-top: 1vw;
		width: 0;
		height: 33.9vw;
	}

	.shelter {
    opacity: 0.5;
    filter: alpha(opacity=50);
}

	.bottom {
    width: 100%;
}
</style>
</head>
<body>
<img class="top" src="images/top.jpg" alt="">
<div style="width:100%; height:10vw; line-height:6vw; text-align:center;"><span style="color:#fff; font-size:4vw;">您共有 10 次翻牌机会</span></div>
<div class="weui-grids" id="draw">
	<a href="javascript:;" id="a1" class="weui-grid">
		<img class="img" src="images/fugai/1.png" alt="">
		<img class="info" src="images/jieguo/1.png" alt="">
	</a>
	<a href="javascript:;" id="a2" class="weui-grid">
		<img class="img" src="images/fugai/2.png" alt="">
		<img class="info" src="images/jieguo/2.png" alt="">
	</a>
	<a href="javascript:;" id="a3" class="weui-grid">
		<img class="img" src="images/fugai/3.png" alt="">
		<img class="info" src="images/jieguo/3.png" alt="">
	</a>
	<a href="javascript:;" id="a4" class="weui-grid">
		<img class="img" src="images/fugai/4.png" alt="">
		<img class="info" src="images/jieguo/4.png" alt="">
	</a>
	<a href="javascript:;" id="a5" class="weui-grid">
		<img class="img" src="images/fugai/5.png" alt="">
		<img class="info" src="images/jieguo/5.png" alt="">
	</a>
	<a href="javascript:;" id="a6" class="weui-grid">
		<img class="img" src="images/fugai/6.png" alt="">
		<img class="info" src="images/jieguo/6.png" alt="">
	</a>
	<a href="javascript:;" id="a7" class="weui-grid">
		<img class="img" src="images/fugai/7.png" alt="">
		<img class="info" src="images/jieguo/7.png" alt="">
	</a>
	<a href="javascript:;" id="a8" class="weui-grid">
		<img class="img" src="images/fugai/8.png" alt="">
		<img class="info" src="images/jieguo/8.png" alt="">
	</a>
	<a href="javascript:;" id="a9" class="weui-grid">
		<img class="img" src="images/fugai/9.png" alt="">
		<img class="info" src="images/jieguo/9.png" alt="">
	</a>
</div>
<img class="bottom" src="images/bottom.png" />
<div class="js_dialog" id="iosDialog1" style="display: none;">
	<div class="weui-mask"></div>
	<div class="weui-dialog">
		<div class="weui-dialog__hd"><strong class="weui-dialog__title">恭喜您中奖啦</strong></div>
		<div class="weui-dialog__bd">恭喜您获得了一个<span id="hb"></span>元的现金红包，您可在"会员中心"-"余额"查阅</div>
		<div class="weui-dialog__ft">
			<a href="javascript:;" onclick="TurnMyCenter()" class="weui-dialog__btn weui-dialog__btn_default">去查看</a>
			<a href="javascript:;" onclick="Refresh()" class="weui-dialog__btn weui-dialog__btn_primary">再翻一次</a>
		</div>
	</div>
</div>
<div class="js_dialog" id="iosDialog2" style="display: none;">
	<div class="weui-mask"></div>
	<div class="weui-dialog">
		<div class="weui-dialog__hd"><strong class="weui-dialog__title">很遗憾，您没有中奖</strong></div>
		<div class="weui-dialog__bd">不要气馁，您可以再翻一次</div>
		<div class="weui-dialog__ft">
			<a href="javascript:;" onclick="ClosePage()" class="weui-dialog__btn weui-dialog__btn_default">关闭</a>
			<a href="javascript:;" onclick="Refresh()" class="weui-dialog__btn weui-dialog__btn_primary">再翻一次</a>
		</div>
	</div>
</div>
<br />
<br />

<script src="js/jquery-1.9.1.min.js"></script>
<script>


	var clickstate = 0;
	var turn = function (target, time, opts) {
    target.find('a').click(function () {
        if (clickstate == 1) {
            return;
        }
        var current = $(this);
        $(this).find('.img').stop().animate(opts[0], time, function () {
            $(this).hide().next().show();
            $(this).next().animate(opts[1], time);
            setTimeout(function () {
                $('#' + current[0].id).siblings('a').find('.info').addClass('shelter');
                $('#' + current[0].id).siblings('a').find('.img').stop().animate(opts[0], time, function () {
                    $(this).hide().next().show();
                    $(this).next().animate(opts[1], time);
                });
            }, 1000);
            clickstate = 1;
            setTimeout(function () {
                if ($('#hb').html() != "10") {
                    $('#iosDialog1').show();
                } else {
                    $('#iosDialog2').show();
                }
            }, 3000);
        });
    });
}
	var verticalOpts = [{ 'width': 0 }, { 'width': '90%' }];
	turn($('#draw'), 400, verticalOpts);

	function ClosePage() {
        $('#iosDialog1').hide();
    }
	function Refresh() {
        $('#iosDialog1').hide();
    }
	function TurnMyCenter() {
        $('#iosDialog1').hide();
    }
	//------------------------------------------------
</script>
</body>
</html>

