// $(document).ready(function() {
//     $(".slider").bxSlider({
//         auto: true,
//         pause: 5000
//     });
// });

$(function() {
    var showFlag = false;
    var topBtn = $("#page-top");
    topBtn.css("bottom", "-100px");
    var showFlag = false;
    //スクロールが100に達したらボタン表示
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            if (showFlag == false) {
                showFlag = true;
                topBtn.stop().animate({ bottom: "20px" }, 200);
            }
        } else {
            if (showFlag) {
                showFlag = false;
                topBtn.stop().animate({ bottom: "-100px" }, 200);
            }
        }
    });
    //スクロールしてトップ
    topBtn.click(function() {
        $("body,html").animate(
            {
                scrollTop: 0
            },
            500
        );
        return false;
    });
});

$(function() {
    $(".zdo_drawer_button").click(function() {
        $(this).toggleClass("active");
        $(".zdo_drawer_bg").fadeToggle();
        $("nav").toggleClass("open");
    });
    $(".zdo_drawer_bg").click(function() {
        $(this).fadeOut();
        $(".zdo_drawer_button").removeClass("active");
        $("nav").removeClass("open");
    });
});

function getValue(idname) {
    // value値を取得する
    var obj = document.getElementById(idname);
    var result = obj.value;

    // Alertで表示する
    alert("value値は" + result + "です。");
}

function gate() {
    // ▼ユーザの入力を求める
    var UserInput = prompt("パスワードを入力して下さい:", "");
    // ▼入力内容をチェック
    if (/\W+/g.test(UserInput)) {
        // ▼半角英数字以外の文字が存在したらエラー
        alert("半角英数字のみを入力して下さい．");
    }
    // ▼キャンセルをチェック
    else if (UserInput == "satreps") {
        // ▼入力内容からファイル名を生成して移動
        location.href = "/services";
    } else if (UserInput != "satreps") {
        alert("パスワードが間違っています．");
    }
}
