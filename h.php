<!DOCTYPE html>
<html>

<head>
    <title>更新日志 - <?php echo $config['title'];?></title>
    <meta charset="utf-8" />
    <meta name="keywords" content="<?php echo $config['keywords'];?>" />
    <meta name="description" content="<?php echo $config['description'];?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="./assets/css/loading.css"/>
    <link rel="stylesheet" href="./assets/css/mdui.min.css" />
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="/assets/css/loadingr.css" />
    <link rel="stylesheet" href="./assets/css/mdclub.css" />
    <style id="style"></style>
    <style type="text/css">
        #percentageCounter {
            position: fixed;
            left: 0;
            top: 0;
            height: 3px;
            z-index: 99999;
            background-image: linear-gradient(to right, #E8EAF6,#C5CAE9,#9FA8DA,#7986CB,#5C6BC0,#3F51B5,#3949AB,#303F9F,#283593,#1A237E);
            border-radius: 5px;
        }
        .wrapper {
            text-align: center;
        }
        .wrapper .line {
            width: 20%;
            display: inline-block;
            border: 0.4px solid #ddd;
            vertical-align: middle;
        }
        .wrapper .content {
            color: #ccc;
            font-size: 14px;
        }
    </style>
</head>

<body class="mdui-theme-primary-blue-grey mdui-theme-accent-blue">
    <div id="percentageCounter"></div>
<div class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-col-md-3">
            <div class="mdui-card">
                <div class="mdui-card-header">
                    <div class="mdui-card-header-title">更新日志</div>
                </div>
                <div class="mdui-card-content">
                    <nav class="doc-toc mdui-text-color-theme-600">
                        <ul class="mdui-list mdui-list-dense">
                            <?php
                                $data = json_decode(file_get_contents('http://xinnai.521314.love/Data/api.php?type=getAllApi'), true)['data'];
                                $array = [];
                                foreach($data as $v){
                                    if(!isset($array[$v['time']])){
                                        $array[$v['time']][] = $v;
                                    }else{
                                        $array[$v['time']][] = $v;
                                    }
                                }
                                krsort($array);
                                foreach($array as $k=>$val)
                                {
                                    echo "<li class=\"mdui-list-item mdui-subheader\">".$k."</li>\n";
                                    foreach($val as $value){
                                        if($value['status'] == 1)
                                        {
                                            $url = '/?action=doc&id='.$value['id'];
                                            $desc = $value['desc'];
                                            echo "<li class=\"mdui-list-item\"><a class=\"mdui-ripple\" href=\"{$url}\">{$value['name']}</a></li>\n";
                                        }else{
                                            $url = '#';
                                            $desc = '维护中';
                                            echo "<li class=\"mdui-list-item\"><a class=\"mdui-ripple\" href=\"JavaScript:;\" onclick=\"mdui.snackbar('{$desc}')\">{$value['name']}</a></li>\n";
                                        }
                                    }
                                }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="mdui-col-md-9">
            <div class="mdui-shadow-2 mdui-m-y-2" id="doc-content"></div>
        </div>
    </div>
</div>
    <script src="./assets/js/jquery.min.js"></script>
    <script src="./assets/js/jquery.cookie.min.js"></script>
    <script src="./assets/js/sweetalert.min.js"></script>
    <script src="./assets/js/mdui.min.js"></script>
    <script src="./assets/js/index.js"></script>
    <script>
        $(window).scroll(function() {
            var a = $(window).scrollTop(),
                c = $(document).height(),
                b = $(window).height();
            scrollPercent = a / (c - b) * 100;
            scrollPercent = scrollPercent.toFixed(1);
            $("#percentageCounter").css({
                width: scrollPercent + "%"
            });
        }).trigger("scroll");
    </script>
</body>
<div id="back-to-top" class="mdui-fab mdui-fab-fixed mdui-color-theme-accent">
    <i class="mdui-icon material-icons">arrow_upward</i>
</div>

<script>
    // 回到顶部按钮
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 100) {
            $('#back-to-top').fadeIn(500);
        } else {
            $('#back-to-top').fadeOut(500);
        }
    });
    $('#back-to-top').click(function() {
        $('html,body').animate({
            scrollTop: '0px'
        }, 800);
    });
</script>
</html>