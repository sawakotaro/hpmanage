
$(function() {
    // 更新前の確認アラート
    $(document).on("click", ".alert-confirm", function() {
        var $href = $(this) .prop("href");
        bootbox.confirm("紐付くカテゴリも全て削除されます。<br />本当によろしいですか？", function(result){
            if(result === true) {
                window.location = $href;
            }
        });
        return false;
    });
});

function escape(ch) {
    ch = ch.replace(/&/g,"&amp;") ;
    ch = ch.replace(/"/g,"&quot;") ;
    ch = ch.replace(/'/g,"&#039;") ;
    ch = ch.replace(/</g,"&lt;") ;
    ch = ch.replace(/>/g,"&gt;") ;
    return ch ;
}


function readWait(message) {
    $.blockUI({
      message: '<img src="/images/loader.gif"/>&emsp;' + message,
      css: {
        border: 'none',
        padding: '10px',
        backgroundColor: '#333',
        opacity: .5,
        color: '#fff'
      },
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });
}




function alertSuccess(message) {
    bootbox.alert("<div class='alert alert-success space-top-20'>"+ message +"</div>");
}

function alertDanger(message) {
    bootbox.alert("<div class='alert alert-danger space-top-20'>"+ message +"</div>");
}

function alertWarning(message) {
    bootbox.alert("<div class='alert alert-warning space-top-20'>"+ message +"</div>");
}

function alertInfo(message) {
    bootbox.alert("<div class='alert alert-info space-top-20'>"+ message +"</div>");
}



/**
 * datetimepickerで使用する時間リストを作成します。
 * time変数には、時間の間隔を分単位で指定します。
 * @param time
 * @returns Array
 */
function createTimeList(time) {
    var hour = 0;
    var minute = 0;
    var list = [];
    if(time <= 0) {
        return list;
    }
    
    while(true) {
        if(hour >= 24) {
            break;
        }
        list.push(("0" + hour) .slice(-2) + ":" + ("0" + minute) .slice(-2));
        minute += time;
        if(minute >= 60) {
            minute = minute % 60;
            hour++;
        }
    }
    
    return list;
}
