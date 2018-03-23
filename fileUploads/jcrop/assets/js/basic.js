$(function () {

    var picName;

    $(document).delegate('input[name=head_img]', 'change', function () {
        $('.mask').css('display', 'block');
        $.ajaxFileUpload({
            url: 'upload.php',
            fileElementId: 'head_img',
            dataType: "json",
            success: function(data) {

                if (1 == data.code) {
                    picName = data.name;

                    $('#origi-img').prop('src', data.url);
                    $('#origi-img').on('load', function () {

                        var whObj = cutImage($(".jcrop_w>img")); //默认图像居中显示

                        $('.jcrop_w').css({width: whObj.w, height: whObj.h});

                        var _Jw = ($("#target").width() - 100) / 2,
                            _Jh = ($("#target").height() - 100) / 2,
                            _Jw2 = _Jw + 100,
                            _Jh2 = _Jh + 100;

                        $('#target').Jcrop({
                            setSelect: [_Jw, _Jh, _Jw2, _Jh2],
                            onChange: showPreview,
                            onSelect: showPreview,
                            bgFade: true,
                            bgColor: '#e2e2e2',
                            aspectRatio: 1,
                            bgOpacity: .2
                        });

                        var holderW = (400 - whObj.w) / 2;
                        var holderH = (300 - whObj.h) / 2;
                        $('.jcrop-holder').css({left: holderW, top: holderH});
                    });
                    $('#big-img').prop('src', data.url);
                    $('#small-img').prop('src', data.url);
                } else {
                    alert(data.message);
                }
            }
        });
        return false;
    });

    $('#save_btn').on('click', function () {
        var data = {
            x1: $('#x1').val(),
            y1: $('#y1').val(),
            w: $('#w').val(),
            h: $('#h').val(),
            scale: $('#scale').val(),
            picName: picName
        };

        $.post('crop.php', data, function (data) {

            data = JSON.parse(data);

            $("#headimg").prop("src", data.body);
            quit();
        })
    })
});

function quit() {
    $(".mask").css('display', 'none');
}

//默认图像位置
function cutImage(obj) {
    var w = 400,
        h = 300,
        iw = obj.width(),
        ih = obj.height();
    var f_w,
        f_h;
    if (iw <= w && ih <= h) { // 图片宽和高均小于容器
        $('#scale').val(1);
        f_w = iw;
        f_h = ih;
    } else if (iw > w && ih <= h) { // 图片宽大于容器，高小于容器
        obj.css({
            width: w,
            height: w * ih / iw
        });
        $('#scale').val(w / iw);
        f_w = w;
        f_h = w * ih / iw;
    } else if (iw > w && ih > h) { // 图片宽和高均大于容器
        var iwh = iw / ih,
            wh = w / h;
        if (iwh > wh) {
            obj.css({
                width: w,
                height: w * ih / iw
            });
            $('#scale').val(w / iw);
            f_w = w;
            f_h = w * ih / iw;
        } else {
            obj.css({
                width: h * iw / ih,
                height: h
            });
            $('#scale').val(h / ih);
            f_w = h * iw / ih;
            f_h = h;
        }
    } else {
        obj.css({
            width: h * iw / ih,
            height: h
        });
        $('#scale').val(h / ih);
        f_w = h * iw / ih;
        f_h = h;
    }

    return {w: f_w, h: f_h};
}

function pre_img2(obj, rx, iw, ry, ih, cx, cy, ow, oh) {
    obj.css({
        width: Math.round(rx * iw) + 'px',
        height: Math.round(ry * ih) + 'px'
    });

    if (cy >= oh && cx >= ow) {
        obj.css({
            marginLeft: '-' + Math.round(rx * (cx - ow)) + 'px',
            marginTop: '-' + Math.round(ry * (cy - oh)) + 'px'
        });
    } else if (cy <= oh && cx >= ow) {
        obj.css({
            marginLeft: "-" + Math.round(rx * (cx - ow)) + 'px',
            marginTop: Math.round(ry * (oh - cy)) + 'px'
        });
    } else if (cy >= oh && cx <= ow) {
        obj.css({
            marginLeft: Math.round(rx * (ow - cx)) + 'px',
            marginTop: '-' + Math.round(ry * (cy - oh)) + 'px'
        });
    } else if (cy <= oh && cx <= ow) {
        obj.css({
            marginLeft: Math.round(rx * (ow - cx)) + 'px',
            marginTop: Math.round(ry * (oh - cy)) + 'px'
        });
    }
}

function showPreview(c) {
    var iw = $('.jcrop_w>img').width(),
        ih = $('.jcrop_w>img').height(),
        ow = 0,
        oh = 0,
        rx1 = 100 / c.w,
        ry1 = 100 / c.h,
        rx2 = 55 / c.w,
        ry2 = 55 / c.h,
        _data = $(".jc-demo-box").attr("data");
    if (($.browser.version == 8.0 || $.browser.version == 7.0 || $.browser.version == 6.0) && (_data == 90 || _data == 270)) {
        pre_img2($('.pre-2 img'), rx1, ih, ry1, iw, c.x, c.y, ow, oh);
        pre_img2($('.pre-3 img'), rx2, ih, ry2, iw, c.x, c.y, ow, oh);
    } else {
        pre_img2($('.pre-2 img'), rx1, iw, ry1, ih, c.x, c.y, ow, oh);
        pre_img2($('.pre-3 img'), rx2, iw, ry2, ih, c.x, c.y, ow, oh);
    }
    $('#x1').val(c.x);
    $('#y1').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
}