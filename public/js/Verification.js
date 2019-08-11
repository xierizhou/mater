// 给 A 标签 加上 class='yz'   data-href ="下载链接"

window.NVC_Opt = {
    //无痕配置 && 滑动验证、刮刮卡、问答验证码通用配置
    appkey:'FFFF0N1N00000000117B',
    scene:'nvc_other',
    isH5:false,
    popUp:false,
    renderTo:'#hd',
    nvcCallback:function(data){
        // data为getNVCVal()的值，此函数为二次验证滑动或者刮刮卡通过后的回调函数
        // data跟业务请求一起上传，由后端请求AnalyzeNvc接口，接口会返回100或者900
    },
    //trans:{"nvcCode":400, "key1": "code300"},
    language: "cn",
    //滑动验证长度配置
    customWidth: 70,
}

function yourRegisterRequest(url, params,src){
    var callbackName = ('jsonp_' + Math.random()).replace('.', '')
    params += '&callback=' + callbackName
    var o_scripts = document.getElementsByTagName("script")[0]
    var o_s = document.createElement('script')
    o_scripts.parentNode.insertBefore(o_s, o_scripts);
    //您注册请求的业务回调
    window[callbackName] = function(json) {
         console.log(json)

        /*if(json.code == 400) {
            //唤醒滑动验证
            getNC().then(function(){
                _nvc_nc.upLang('cn', {
                    _startTEXT: "请完成滑动验证,继续下载",
                    _yesTEXT: "验证通过",
                })
                _nvc_nc.reset()
            })
        } else if (json.code == 100 || json.code == 200) {
            //console.log('验证通过')
            //alert('验证通过');
            //self.location.href = src
        } else if (json.code == 800 || json.code == 900) {
            nvcReset()
            alert("操作异常，请关闭网页重新打开")
        }*/
    }
    //o_s.src = url + '&' + params
    $.ajax({
        url: url + '&' + params,
        type: "GET",
        headers: {
            Cookie: "auth_id=22949972%7C%E4%B8%80%E9%9D%92%7C1565491470%7C7454523437564794d927ae773ca0181a;"
        },
        dataType:'jsonp',
        success: function(json) {
            if(json.code == 400) {
                //唤醒滑动验证
                getNC().then(function(){
                    _nvc_nc.upLang('cn', {
                        _startTEXT: "请完成滑动验证,继续下载",
                        _yesTEXT: "验证通过",
                    })
                    _nvc_nc.reset()
                })
            } else if (json.code == 100 || json.code == 200) {
                //console.log('验证通过')
                //alert('验证通过');
                //self.location.href = src
            } else if (json.code == 800 || json.code == 900) {
                nvcReset()
                alert("操作异常，请关闭网页重新打开")
            }
        }
    })

}

