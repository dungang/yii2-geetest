/**
 * Created by dungang@126.com on 2017/1/16.
 */
+function ($) {

    $.fn.geetest = function (options) {
        var opts = $.extend({},$.fn.geetest.Default,options);
        return this.each(function () {
            var _this = $(this);
            $.ajax({
                // 获取id，challenge，success（是否启用failback）
                url: opts.url, // 加随机数防止缓存
                type: "get",
                data:{
                    type:opts.type,
                    t:(new Date()).getTime()
                },
                dataType: "json",
                success: function (data) {
                    // 使用initGeetest接口
                    // 参数1：配置参数
                    // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
                    initGeetest({
                        gt: data.gt,
                        challenge: data.challenge,
                        product: opts.showType, // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                        offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                        // 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
                    }, function (captchaObj) {
                        $(opts.submitButton).click(function (e) {
                            var validate = captchaObj.getValidate();
                            if (!validate) {
                                _this.find(".gt-notice").show();
                                setTimeout(function () {
                                    _this.find(".gt-notice").hide();
                                }, 2000);
                                e.preventDefault();
                                $(opts.inputId).val('');
                            } else {
                                $(opts.inputId).val('success');
                            }
                        });
                        // 将验证码加到id为captcha的元素里，同时会有三个input的值：geetest_challenge, geetest_validate, geetest_seccode
                        captchaObj.appendTo(_this.find('.gt-container'));
                        captchaObj.onReady(function () {
                            _this.find(".gt-wait").hide();
                        });
                        // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
                    });
                }
            });
        });
    };
    $.fn.geetest.Default = {
        submitButton:'#submit',
        type:'pc',
        showType: 'popup', //float，embed，popup
        url:'',
        inputId:'geetest'
    };
}(jQuery);
