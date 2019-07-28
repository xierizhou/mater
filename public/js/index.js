$(function() {
    tk.gotoLogin = function() {
        page.showLogin();
    };

    var page = {
        getProfile: function() {
            tk.post("/user/profile", {}, function(data) {
                if (data['status'] == 0) {
                    page.getNotice();
                    var userData = data["data"];
                    page.showMain();
                    $(".unbox").html(userData["username"]);
                    if (userData["email"]) {
                        $(".embox").html('(' + userData["email"] + ')');
                    }
                    var utimetxt = '';
                    if (userData['typ'] != 99) {
                        $('.taobao-upgrade').hide();
                        var sitestxt = '';
                        if (userData["websites"]) {
                            var htmlarr = [];
                            for(var i=0;i<userData["websites"].length;i++) {
                                var d = userData["websites"][i];
                                htmlarr.push(d['website'] + '/' + d['expiretime'])
                            }
                            sitetxt = '权限: ' + htmlarr.join(' | ');
                        } else {
                            utimetxt = '到期时间: '
                            sitetxt = '权限: ' + userData["sites"];
                            $(".user-time").html(utimetxt + userData["expiretime"]);
                        }
                        upgradetxt = '增加权限/时间';
                        $(".sites").html(sitetxt);
                    } else {
                        sitetxt = '权限: ' + userData["sites"];
                        upgradetxt = '增加权限/次数';
                        $('.taobao-upgrade').show();
                        $(".user-time").html(utimetxt + userData["expiretime"]);
                        $(".sites").html(sitetxt);
                    }
                    $('#upgrade').html(upgradetxt);
                    $('#upgrade').show();
                } else {
                    tk.showMessage(data["description"]);
                }
            });
        },
        logout: function() {
            tk.post("/user/logout", {}, function(data) {
                if (data['status'] == 0) {
                    page.showLogin();
                } else {
                    tk.showMessage(data["description"]);
                }
            })
        },
        showLogin: function() {
            $(".container").hide();
            $('.modal').hide();
            $('#top').hide();
            $('.login').show();
        },
        showMain: function() {
            $(".container").hide();
            $('.modal').hide();
            $('.main').show();
            $('#top').show();
        },
        showChangePwd: function() {
            $(".modal").hide();
            $('#changepwd_dialog').show();
        },
        showChangeUn: function() {
            $(".modal").hide();
            $('#changeun_dialog').show();
        },
        showBindemail: function() {
            $(".modal").hide();
            $('#bindemail_dialog').show();
        },
        showFindPwd: function() {
            $(".modal").hide();
            $('#findpwd_dialog').show();
        },
        getNotice: function() {
            tk.post("/user/notice", {}, function(data) {
                if (data['status'] == 0) {
                    var notice = data["data"];
                    $('.notice').html(notice);
                    if (data['banners']) {
                        for(var i=0;i<data['banners'].length;i++) {
                            $('#banner').append('<img src="'+data['banners'][i]['url']+'" width="100%" />')
                        }
                    }
                }
            });
        }
    }
    //判断登录
    page.getProfile();
    $("#login-button").on('click', function() {
        tk.blockUI();
        var post_data = {};
        post_data["username"] = $("input[name='username']").val();
        post_data["pwd"] = $("input[name='password']").val();
        tk.post("/user/login", post_data, function(data) {
            tk.unblockUI();
            if (data["status"] == 0) {
                page.getProfile();
            } else {
                tk.showMessage(data["description"]);
            }
        });
    });
    $("#logout").on("click", function () {
        page.logout();
    });

    $("#download-button").on("click", function () {
        tk.blockUI();
        var post_data = {};
        post_data["url"] = $("input[name='url']").val();
        $(".downloading").show();
        $(".download-list").hide();
        $(".download-list").attr("surl", post_data["url"]);
        $('.preview .title').html('')
        $('.preview .pic').html('')
        tk.post("/download/check", post_data, function(data) {
            if (data['nvc']) {
                var params = 'a=' + getNVCVal();
                tk.nvcRequest('/api/download/valid', params);
            }
            tk.unblockUI();
            $(".downloading").hide();
            $('#showsite').hide();
            $(".download-list").show();
            $('.download-kid').remove();
            $('.download-list .newbutton').remove();
            if(data["status"] == 0) {
                var success = false;
                if (data['buttons']) {
                    for (var i=0;i<data['buttons'].length;i++) {
                        var button = $('<button class="download-pic newbutton"><span>'+data['buttons'][i]['name']+'</span><i class="icon-d"></i></button>')
                        if(data["picid"]) {
                            button.attr("typ", "picid");
                            button.attr("picid", data["picid"]);
                            button.attr("filetype", data['buttons'][i]["filetype"]);
                            if (data['model']) {
                                button.attr("model", data["model"]);
                            }
                            if(data["byso"]) {
                                button.attr("byso", data["byso"]);
                            }
                            if(data["bycat"]) {
                                button.attr("bycat", data["bycat"]);
                            }
                            if(data["typ"]) {
                                button.attr("typ", data["typ"]);
                            }
                            if (data["cat"]) {
                                button.attr("cat", data["cat"]);
                            } else {
                                button.attr("cat", '');
                            }
                        }
                        $('.download-list').append(button);
                    }
                    return true;
                }
                if (data["url"]) {
                    $(".download-list").attr("surl", data["url"]);
                }
                if(data["img"]) {
                    $('.download-img').show();
                    $('.download-img').attr("typ", "img");
                    $('.download-img').attr("picid", data["img"]);
                    if (data["cat"]) {
                        $('.download-img').attr("cat", data["cat"]);
                    } else {
                        $('.download-img').attr("cat", '');
                    }
                    if (data['model']) {
                        $('.download-img').attr("model", data["model"]);
                    }
                    if(data["typ"]) {
                        $('.download-img').attr("typ", data["typ"]);
                    }
                    if (data["hs"]) {
                        $('.download-img').attr("hs", data["hs"]);
                    } else {
                        $('.download-img').attr("hs", '');
                    }
                    success = true;
                } else {
                    $('.download-img').hide()
                }
                if(data["psd"]) {
                    $('.download-psd').show()
                    $('.download-psd').attr("typ", "psd");
                    $('.download-psd').attr("picid", data["psd"]);
                    if (data["cat"]) {
                        $('.download-psd').attr("cat", data["cat"]);
                    } else {
                        $('.download-psd').attr("cat", '');
                    }
                    if (data['model']) {
                        $('.download-psd').attr("model", data["model"]);
                    }
                    if(data["typ"]) {
                        $('.download-psd').attr("typ", data["typ"]);
                    }
                    if (data["hs"]) {
                        $('.download-psd').attr("hs", data["hs"]);
                    } else {
                        $('.download-psd').attr("hs", '');
                    }
                    success = true;
                } else {
                    $('.download-psd').hide()
                }
                if(data["suitepsd"]) {
                    $('.download-suitepsd').show()
                    $('.download-suitepsd').attr("typ", "suitepsd");
                    $('.download-suitepsd').attr("picid", data["suitepsd"]);
                    if (data["cat"]) {
                        $('.download-suitepsd').attr("cat", data["cat"]);
                    } else {
                        $('.download-suitepsd').attr("cat", '');
                    }
                    if (data['model']) {
                        $('.download-suitepsd').attr("model", data["model"]);
                    }
                    if(data["typ"]) {
                        $('.download-suitepsd').attr("typ", data["typ"]);
                    }
                    if (data["hs"]) {
                        $('.download-suitepsd').attr("hs", data["hs"]);
                    } else {
                        $('.download-suitepsd').attr("hs", '');
                    }
                    success = true;
                } else {
                    $('.download-suitepsd').hide()
                }
                if(data["moban"] || data["office"]) {
                    $('.download-moban').show()
                    if (data["moban"]) {
                        $('.download-moban').attr("typ", "moban");
                        $('.download-moban').attr("picid", data["moban"]);
                    }
                    if(data["office"]) {
                        $('.download-moban').attr("typ", "office");
                        $('.download-moban').attr("picid", data["office"]);
                        if (data["vip"]) {
                            $('.download-moban').attr("vip", data["vip"]);
                        }
                    }
                    if (data['model']) {
                        $('.download-moban').attr("model", data["model"]);
                    }
                    if(data["typ"]) {
                        $('.download-moban').attr("typ", data["typ"]);
                    }
                    if (data["cat"]) {
                        $('.download-moban').attr("cat", data["cat"]);
                    } else {
                        $('.download-moban').attr("cat", '');
                    }
                    if (data["hs"]) {
                        $('.download-moban').attr("hs", data["hs"]);
                    } else {
                        $('.download-moban').attr("hs", '');
                    }
                    success = true;
                } else {
                    $('.download-moban').hide()
                }
                if(data["58pic"] || data["90sheji"] || data["picid"]) {
                    if (data["site"] && data["site"] == "昵图网") {
                        $('.download-line').show();
                        $('.download-pic').hide()
                        if(data["picid"]) {
                            $('.download-line').attr("typ", "picid");
                            $('.download-line').attr("picid", data["picid"]);
                            if(data["typ"]) {
                                $('.download-line').attr("typ", data["typ"]);
                            }
                            if (data["cat"]) {
                                $('.download-line').attr("cat", data["cat"]);
                            } else {
                                $('.download-line').attr("cat", '');
                            }
                        }
                    } else {
                        $('.download-line').hide();
                        $('.download-pic').show()
                        if (data["58pic"]) {
                            $('.download-pic').attr("typ", "58pic");
                            $('.download-pic').attr("picid", data["58pic"]);
                        }
                        if(data["90sheji"]) {
                            $('.download-pic').attr("typ", "90sheji");
                            $('.download-pic').attr("picid", data["90sheji"]);
                        }
                        if(data["picid"]) {
                            $('.download-pic').attr("typ", "picid");
                            $('.download-pic').attr("picid", data["picid"]);
                            if (data['model']) {
                                $('.download-pic').attr("model", data["model"]);
                            }
                            if(data["byso"]) {
                                $('.download-pic').attr("byso", data["byso"]);
                            }
                            if(data["bycat"]) {
                                $('.download-pic').attr("bycat", data["bycat"]);
                            }
                            if(data["filetype"]) {
                                $('.download-pic').attr("filetype", data["filetype"]);
                            }
                            if(data["typ"]) {
                                $('.download-pic').attr("typ", data["typ"]);
                            }
                            if (data["cat"]) {
                                $('.download-pic').attr("cat", data["cat"]);
                            } else {
                                $('.download-pic').attr("cat", '');
                            }
                        }
                    }
                    success = true;
                } else {
                    $('.download-pic').hide()
                }
                if(data["title"]) {
                    $('.preview .title').html(data["title"])
                }
                if(data["imgurl"]) {
                    $('.preview .pic').html('<img src="'+data["imgurl"]+'" />')
                }
                if(data["site"]) {
                    $('#showsite').html(data["site"])
                    if (success) {
                        $('#showsite').css('background-color', '#16AC35');
                    } else {
                        $('#showsite').css('background-color', '#ef5858');
                    }
                    $('#showsite').show()
                }
            } else if (data["status"] == 408){
                tk.confirm(data["description"], function() {
                    window.location.href="/upgrade.html"
                })
            } else {
                $(".download-list").hide();
                tk.showMessage(data["description"]);
            }
        }, function(e) {
            tk.unblockUI();
            tk.showMessage("下载失败");
        });
    });
    $(".download-line").on("click", function(data) {
        tk.blockUI();
        var typ = $(this).attr("typ");
        var picid = $(this).attr("picid");
        var url = $(".download-list").attr("surl");
        var post_data = {"typ": typ, "picid": picid};
        if (url) {
            post_data["url"] = url;
        }
        $(".downloading").show();
        tk.post("/download/checkline", post_data, function(data) {
            tk.unblockUI();
            $('.download-kid').remove();
            if(data["status"] == 0) {
                if(data["url"]) {
                    $(".download-list").hide();
                    tk.downloadURL(data["url"]);
                } else {
                    if (data["kids"]) {
                        for (var i=0;i<data["kids"].length;i++) {
                            var kid = data["kids"][i];
                            $('.download-list').append('<button class="download-kid" data-line="'+kid["kid"]+'"><span>'+kid["name"]+'</span><i class="icon-d"></i></button>')
                        }
                        $('.download-kid').attr("typ", "picid");
                        $('.download-kid').attr("picid", picid);
                        $('.download-kid').attr("typ", typ);
                    } else {
                        tk.showMessage("下载失败");
                    }
                }
            } else {
                tk.showMessage(data["description"]);
            }
        }, function(e) {
            tk.unblockUI();
            tk.showMessage("下载失败");
        });
        return false;
    });
    $('body').on("click", ".download-list button", function(data) {
        if ($(this).hasClass('download-line')) {
            return true;
        }
        tk.blockUI();
        var typ = $(this).attr("typ");
        var picid = $(this).attr("picid");
        var cat = $(this).attr("cat");
        var hs = $(this).attr("hs");
        var vip = $(this).attr("vip");
        var model = $(this).attr("model");
        var byso = $(this).attr("byso");
        var bycat = $(this).attr("bycat");
        var filetype = $(this).attr("filetype");
        var kid = $(this).data("line");
        var post_data = {"typ": typ, "picid": picid};
        var url = $(".download-list").attr("surl");
        if (cat) {
            post_data["cat"] = cat;
        }
        if (url) {
            post_data["url"] = url;
        }
        if (hs) {
            post_data["hs"] = hs;
        }
        if (vip) {
            post_data["vip"] = vip;
        }
        if (model) {
            post_data["model"] = model;
        }
        if (byso) {
            post_data["byso"] = byso;
        }
        if (bycat) {
            post_data["bycat"] = bycat;
        }
        if (filetype) {
            post_data["filetype"] = filetype;
        }
        if (kid) {
            post_data["kid"] = kid
        }
        $(".downloading").show();
        try {
            tk.post("/download/download", post_data, function(data) {
                tk.unblockUI();
                $(".downloading").hide();
                if (data) {
                    if(data["status"] == 0) {
                        if (data["once"]) {
                            window.open(data["url"])
                        } else {
                            if(data["url"]) {
                                $(".download-list").hide();
                                tk.downloadURL(data["url"]);
                            } else {
                                tk.showMessage("下载失败");
                            }
                        }
                    } else {
                        tk.showMessage(data["description"]);
                    }
                } else {
                    tk.showMessage("系统繁忙，请重试");
                }
            }, function(e) {
                tk.unblockUI();
                tk.showMessage("下载失败");
            });
        } catch(err) {
            tk.showMessage("系统繁忙，请重试");
        }
    });
    $("#changepwd").on('click', function() {
        page.showChangePwd();
    });
    $("#changepwd-button").on('click', function() {
        var post_data = {};
        post_data["oldpwd"] = $("input[name='oldpwd']").val();
        post_data["pwd"] = $("input[name='pwd']").val();
        post_data["pwd1"] = $("input[name='pwd1']").val();
        tk.post("/user/changepwd", post_data, function(data) {
            if (data["status"] == 0) {
                page.logout();
            } else {
                tk.showMessage(data["description"]);
            }
        });
    });
    $("#changeun").on('click', function() {
        page.showChangeUn()
    });
    $("#changeun-button").on('click', function() {
        var post_data = {};
        post_data["username"] = $("input[name='nusername']").val();
        tk.post("/user/changeusername", post_data, function(data) {
            if (data["status"] == 0) {
                page.logout();
            } else {
                tk.showMessage(data["description"]);
            }
        });
    });
    $('.close').on('click', function() {
        $('.modal').hide();
        return false;
    });
    $("#bindemail").on('click', function() {
        page.showBindemail();
    });
    $("#checkemail").on('click', function() {
        var post_data = {};
        post_data["email"] = $("input[name='email']").val();
        tk.post("/user/checkemail", post_data, function(data) {
            if (data["status"] == 0) {
                tk.showMessage('验证码发送成功，请检查邮件');
            } else {
                tk.showMessage(data["description"]);
            }
        });
    });
    $("#bindemail-button").on('click', function() {
        var post_data = {};
        post_data["email"] = $("input[name='email']").val();
        post_data["code"] = $("input[name='code']").val();
        tk.post("/user/bindemail", post_data, function(data) {
            if (data["status"] == 0) {
                tk.showMessage('绑定邮箱成功，您可以使用邮箱登录');
                page.showMain();
            } else {
                tk.showMessage(data["description"]);
            }
        });
    });
    $("#findpwd").on('click', function() {
        page.showFindPwd();
    });
    $("#findpwdemail").on('click', function() {
        var post_data = {};
        post_data["email"] = $("input[name='findpwdemail']").val();
        tk.post("/user/findpwdcheckemail", post_data, function(data) {
            if (data["status"] == 0) {
                tk.showMessage('验证码发送成功，请检查邮件');
            } else {
                tk.showMessage(data["description"]);
            }
        });
    });
    $("#findpwd-button").on('click', function() {
        var post_data = {};
        post_data["email"] = $("input[name='findpwdemail']").val();
        post_data["code"] = $("input[name='findpwdcode']").val();
        post_data["pwd"] = $("input[name='findpwd']").val();
        post_data["pwd1"] = $("input[name='findpwd1']").val();
        tk.post("/user/findpwd", post_data, function(data) {
            if (data["status"] == 0) {
                tk.showMessage('找回密码成功');
                page.showLogin();
            } else {
                tk.showMessage(data["description"]);
            }
        });
    });
});