var verifyObject = {

    returnSafeUrl: function() {

        gy_person.oppWrap.popHidden();

        self.location.href = U('User/Safe/index');

    },

    rethandler: null,

    returnSetPw: function() {
        clearTimeout(verifyObject.rethandler);
        self.location.href = U('Api/User/logout', 'redirect=' + U('User'));
    },

    isTrue: function(ary) {

        var tary = ary,

        len = tary.length,

        i = 0;

        for (; i < len; i++) {

            var val = tary[i]();

            if (!val) return false;

        }

        return true;
    },

    editePassWord: {

        substart: [],

        step1: function() {

            var titles = "修改密码",
            cons = '<div class="pset2">' + '<span class="one">验证密码、填写新密码</span>' + '<span class="two">完成</span>' + '</div>' +

            '<div class="p-pdphone p-hnone">' +

            '<table>' + '<tr>' + '<th>当前密码</th>' + '<td>' + '<input type="password" class="p-alertxt" id="old_pw" class="password"><span id="eorrid1"></span>' + '<p><a target="_blank" href="' + U('Service/ticket/password') + '" class="p-grrenlink" style="float:none;line-height:1.5">忘记当前密码？</a></p>' + '</td>' + '</tr>' + '<tr>' + '<th>新密码</th>' + '<td>' + '<input type="password" class="p-alertxt" id="new_pw" class="password"><span id="eorrid2"></span>' + '<p>密码由6-16个字符组成，区分大小写<br>' + '为了提升您的密码安全性，建议使用英文字母加数字或符号的混合密码</p>' + '</td>' + '</tr>' + '<tr>' + '<th>确认新密码</th>' + '<td>' + '<input  type="password" class="p-alertxt" id="new_pw_re" class="password"><span id="eorrid3"></span>' + '</td>' + '</tr>' + '<tr>' + '<th></th>' + '<td>' + '<span id="pw_step1_sub" class="p-subbtn">提交</span>' + '</td>' + '</tr>' + '</table>' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);

            var old_pw = $("#old_pw"),

            substart = [];

            old_pw[0].focus();

            substart[0] = function() {

                var ele = $("#old_pw"),

                txt = ele.val(),

                eorrid = $("#eorrid1");

                if (/^\s*$/.test(txt)) {

                    eorrid.html('<span class="p-error">原密码不可为空白</span>');

                    //ele[0].focus();
                    return false;

                } else if (txt.length < 6) {

                    eorrid.html('<span class="p-error">密码不能少于 6 个字符</span>');

                    //ele[0].focus();
                    return false;

                } else {

                    eorrid.html('');

                    //$("#new_pw")[0].focus();
                    return true;

                }

            };

            substart[1] = function() {

                var ele = $("#new_pw"),

                txt = ele.val(),

                eorrid = $("#eorrid2");

                if (/^\s*$/.test(txt)) {

                    eorrid.html('<span class="p-error">新密码不可为空白</span>');

                    //ele[0].focus();
                    return false;

                } else if (txt.length < 6) {

                    eorrid.html('<span class="p-error">密码不能少于 6 个字符</span>');

                    //ele[0].focus();
                    return false;

                } else {
                    eorrid.html('');

                    //$("#new_pw_re")[0].focus();
                    return true;
                }

            };

            substart[2] = function() {

                var ele = $("#new_pw_re"),

                txt = ele.val(),

                eorrid = $("#eorrid3");

                if (txt != $("#new_pw").val() || /^\s*$/.test(txt) || txt == '') {

                    eorrid.html('<span class="p-error">两处输入的密码不一致</span>');

                    //ele[0].focus();
                    return false;

                } else {

                    eorrid.html('');

                    return true;
                }

            };

            verifyObject.editePassWord.substart = substart;

            $(document).delegate("#old_pw", "blur",
            function() {

                verifyObject.editePassWord.substart[0]();

            }).delegate("#new_pw", "blur",
            function() {

                verifyObject.editePassWord.substart[1]();

            }).delegate("#new_pw_re", "blur",
            function() {

                verifyObject.editePassWord.substart[2]();
            });

        },

        step2: function() {

            var titles = "修改密码",
            cons = '        <!-- 第二步 -->' + '<div class="pset2 pset2-cur">' + '<span class="one">验证密码、填写新密码</span>' + '<span class="two">完成</span>' + '</div>' +

            '<div class="p-phonend">' + '<i class="p-secio-0"></i>' + '<p>您设置的新密码已生效,3秒后自动跳转</p>' + '<span class="p-grrenlink" onclick="verifyObject.returnSetPw();">点击使用新密码登录</span>' + '</div>';
            gy_person.oppWrap.popShow(titles, cons);
            $(".p-alertclose").remove();

            verifyObject.rethandler = setTimeout(verifyObject.returnSetPw, 3000);

        },

        init: function() {

            var that = verifyObject.editePassWord;

            $(document).delegate("#pw_step1_sub", "click",
            function() {

                var isTrue = verifyObject.isTrue(that.substart);

                if (!isTrue) return;

                var old_pw = $("#old_pw").val(),

                new_pw = $("#new_pw").val(),

                new_pw_re = $("#new_pw_re").val(),

                eorrid = $("#eorrid1");

                $.getJSON(U('User/safe/setnewpw', 'callback=?'), {
                    old_pw: old_pw,
                    new_pw: new_pw,
                    new_pw_re: new_pw_re
                },
                function(result) {
                    if (result.code == 1) {
                        gy_person.oppWrap.popHidden();
                        that.step2();
                    } else {
                        eorrid.html('<span class="p-error">密码错误</span>');
                        return;
                    }
                });

            });

        }

    },

    updateIdCard: {

        substart: [],

        step1: function() {
            var titles = "防沉迷认证",
            cons = '        <!-- 第一步 -->' + '<div class="pset2">' + '<span class="one">填写姓名、身份证号码</span>' + '<span class="two">完成</span>' + '</div>' +

            '<div class="p-pdphone p-edpho">' + '<div class="p-edphonet">' + '<i class="p-secio-1"></i>' + '<p>' + '<em>您的帐户还未进行实名注册</em>您已经可以进入游戏，但我们建议您填写如下的身份资料以免受到防沉迷系统限制' + '</p>' + '</div>' + '<table>' + '<tr>' + '<th width="88px">真实姓名</th>' + '<td>' + '<input id="fullname" class="p-alertxt"><span class="p-important">不可再修改，请您慎重填写</span>' + '</td>' + '</tr>' + '<tr>' + '<th>身份证号码</th>' + '<td>' + '<input id="id_card" class="p-alertxt"><span class="p-important"></span>' + '</td>' + '</tr>' + '<tr>' + '<th></th>' + '<td>' + '<span id="sfz_step1_sub" class="p-subbtn">提交</span>' + '</td>' + '</tr>' + '</table>' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);

            var captcha_code = $("#fullname"),
            substart = [];

            captcha_code[0].focus();

            substart[0] = function() {

                var _this = $("#fullname"),

                txt = _this.val(),

                ele = _this.next();

                if (/^\s*$/.test(txt)) {

                    ele.html('姓名不能为空');

                    _this[0].focus();

                    return false;

                } else {

                    ele.html('不可再修改，请您慎重填写');
                    $("#id_card")[0].focus();
                    return true;

                }

            };

            substart[1] = function() {

                var vcity = {
                    11 : "北京",
                    12 : "天津",
                    13 : "河北",
                    14 : "山西",
                    15 : "内蒙古",
                    21 : "辽宁",
                    22 : "吉林",
                    23 : "黑龙江",
                    31 : "上海",
                    32 : "江苏",
                    33 : "浙江",
                    34 : "安徽",
                    35 : "福建",
                    36 : "江西",
                    37 : "山东",
                    41 : "河南",
                    42 : "湖北",
                    43 : "湖南",
                    44 : "广东",
                    45 : "广西",
                    46 : "海南",
                    50 : "重庆",
                    51 : "四川",
                    52 : "贵州",
                    53 : "云南",
                    54 : "西藏",
                    61 : "陕西",
                    62 : "甘肃",
                    63 : "青海",
                    64 : "宁夏",
                    65 : "新疆",
                    71 : "台湾",
                    81 : "香港",
                    82 : "澳门",
                    91 : "国外"
                },
                id_card = $("#id_card"),
                _this = id_card[0],
                card = id_card.val(),
                errorwrap = id_card.next();
                if (card === '') { //是否为空
                    errorwrap.html('身份证号不能为空');
                    _this.focus();
                    return false;
                }

                if (isCardNo(card) === false) { //校验长度，类型
                    errorwrap.html('您输入的身份证号码不正确');
                    _this.focus();
                    return false;
                }

                if (checkProvince(card) === false) { //检查省份
                    errorwrap.html('您输入的身份证号码不正确');
                    _this.focus;
                    return false;
                }
                if (checkBirthday(card) === false) { //校验生日
                    errorwrap.html('您输入的身份证号码生日不正确');
                    _this.focus();
                    return false;
                }

                if (checkParity(card) === false) { //检验位的检测
                    errorwrap.html('您的身份证校验位不正确');
                    _this.focus();
                    return false;
                }
                errorwrap.html('');
                return true;

                //检查号码是否符合规范，包括长度，类型
                function isCardNo(card) { //身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X
                    var reg = /(^\d{15}$)|(^\d{17}(\d|X)$)/;
                    if (reg.test(card) === false) {
                        return false;
                    }
                    return true;
                }

                //检查生日是否正确
                function checkBirthday(card) {
                    var len = card.length;
                    //身份证15位时，次序为省（3位）市（3位）年（2位）月（2位）日（2位）校验位（3位），皆为数字
                    if (len == '15') {
                        var re_fifteen = /^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/,
                        arr_data = card.match(re_fifteen),
                        year = arr_data[2],
                        month = arr_data[3],
                        day = arr_data[4],
                        birthday = new Date('19' + year + '/' + month + '/' + day);
                        return verifyBirthday('19' + year, month, day, birthday);
                    }
                    //身份证18位时，次序为省（3位）市（3位）年（4位）月（2位）日（2位）校验位（4位），校验位末尾可能为X
                    if (len == '18') {
                        var re_eighteen = /^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/,
                        arr_data = card.match(re_eighteen),
                        year = arr_data[2],
                        month = arr_data[3],
                        day = arr_data[4],
                        birthday = new Date(year + '/' + month + '/' + day);
                        return verifyBirthday(year, month, day, birthday);
                    }

                    return false;

                }
                //校验日期
                function verifyBirthday(year, month, day, birthday) {
                    var now = new Date();
                    var now_year = now.getFullYear();
                    //年月日是否合理
                    if (birthday.getFullYear() == year && (birthday.getMonth() + 1) == month && birthday.getDate() == day) {
                        //判断年份的范围（3岁到100岁之间)
                        var time = now_year - year;
                        if (time >= 3 && time <= 100) {
                            return true;
                        }
                        return false;
                    }
                    return false;
                }

                //取身份证前两位,校验省份
                function checkProvince(card) {
                    var province = card.substr(0, 2);
                    if (vcity[province] == undefined) {
                        return false;
                    }
                    return true;
                }

                //校验位的检测
                function checkParity(card) {
                    //15位转18位
                    card = changeFivteenToEighteen(card);
                    var len = card.length;
                    if (len == '18') {
                        var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2),
                        arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'),
                        cardTemp = 0,
                        i,
                        valnum;
                        for (i = 0; i < 17; i++) {
                            cardTemp += card.substr(i, 1) * arrInt[i];
                        }
                        valnum = arrCh[cardTemp % 11];
                        if (valnum == card.substr(17, 1)) {
                            return true;
                        }
                        return false;
                    }
                    return false;
                }

                //15位转18位身份证号
                function changeFivteenToEighteen(card) {
                    if (card.length == '15') {
                        var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2),
                        arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'),
                        cardTemp = 0,
                        i;
                        card = card.substr(0, 6) + '19' + card.substr(6, card.length - 6);
                        for (i = 0; i < 17; i++) {
                            cardTemp += card.substr(i, 1) * arrInt[i];
                        }
                        card += arrCh[cardTemp % 11];
                        return card;
                    }
                    return card;
                }

            };

            verifyObject.updateIdCard.substart = substart;

            $(document).delegate("#fullname", "blur",
            function() {

                verifyObject.updateIdCard.substart[0]();

            }).delegate("#id_card", "blur",
            function() {

                verifyObject.updateIdCard.substart[1]();

            });

        },

        step2: function(fullname, id_card, age) {
            var titles = "防沉迷认证",
            cons = '        <!-- 第二步 -->' + '<div class="pset2 pset2-cur">' + '<span class="one">安全验证</span>' + '<span class="two">完成</span>' + '</div>' +

            '<div class="p-pdphone p-edpho">' + '<div class="p-edphonet">' + '<i class="p-secio-1"></i>' + '<p>' + '<em>您的帐户已进行实名注册</em>您已经可以进入游戏，您不会受到防沉迷系统的限制' + '</p>' + '</div>' + '<table>' + '<tr>' + '<th>真实姓名</th>' + '<td>' + '<input id="fullname_val" class="p-alertxt" value="' + fullname + '" readonly disabled>' + '</td>' + '</tr>' + '<tr>' + '<th>身份证号码</th>' + '<td>' + '<input id="sfz_val" class="p-alertxt" value="' + id_card + '" readonly disabled>' + '</td>' + '</tr>' + '<tr>' + '<th>年龄：</th>' + '<td>' + '<div class="pf14">' + age + '18岁</div>' + '</td>' + '</tr>' + '</table>' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);
            $(".p-alertclose").attr('v', 1);
        },

        init: function() {

            var that = verifyObject.updateIdCard;

            $(document).delegate("#sfz_step1_sub", "click",
            function() {

                var isTrue = verifyObject.isTrue(that.substart);

                if (!isTrue) return;

                var id_card = $("#id_card").val(),

                fullname = $("#fullname").val(),

                myDate = new Date(),

                year = myDate.getFullYear(),

                age = (year - id_card.substr(6, 4)) >= 18 ? "已满": "未满";

                $.getJSON(U('User/safe/sfz', 'callback=?'), {
                    fullname: fullname,
                    id_card: id_card
                },
                function(result) {
                    if (result.code == 1) {
                        gy_person.oppWrap.popHidden();
                        that.step2(fullname, id_card, age);
                    } else {
                        alert(result.msg);
                        return;
                    }
                });

            });
        }
    },

    bindEmail: {

        substart: [],

        step1: function() {
            var titles = "密保邮箱",
            cons = '        <!-- 第一步 -->' + '<div class="pset3">' + '<span class="one">填写邮箱</span>' + '<span class="two">登录激活</span>' + '<span class="three">完成</span>' + '</div>' +

            '<div class="p-pdphone">' + '<table>' + '<tr>' + '<th width="118px">填写邮箱</th>' + '<td>' + '<input id="new_email" class="p-alertxt"><span id="pusheoor"></span>' + '</td>' + '</tr>' +

            '<tr>' + '<th></th>' + '<td>' + '<span id="email_div_step1_sub" class="p-subbtn">确定</span>' + '</td>' + '</tr>' + '</table>' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);

            var captcha_code = $("#new_email"),

            substart = [];

            captcha_code[0].focus();

            substart[0] = function() {

                var txt = captcha_code.val(),

                ele = $("#pusheoor");

                if (!txt.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)) {

                    ele.html('<span class="p-error">请填写正确的邮箱</span>');

                    captcha_code[0].focus();

                    return false;

                } else {

                    ele.html('');

                    return true;

                }

            };

            verifyObject.bindEmail.substart = substart;

            $(document).delegate("#new_email", "blur",
            function() {

                verifyObject.bindEmail.substart[0]();

            });

        },

        step2: function() {
            var titles = "密保邮箱",
            cons = '        <!-- 第二步 -->' + '<div class="pset3 pset3-2">' + '<span class="one">填写邮箱</span>' + '<span class="two">登录激活</span>' + '<span class="three">完成</span>' + '</div>' +

            '<div class="p-pdphone">' + '<div class="p-mbemail">' + '<em>验证邮件已发送至您的邮箱：<span id="user_email"></span></em>请您尽快登录邮箱，按邮箱中指示完成验证<br><a target="_blank" id="login_email" href="#" class="p-subbtn">登录邮箱</a>' + '</div>' + '</div>' +

            '<div class="p-alertbs">' + '提示：系统已向该邮箱发送了一封验证激活邮件，请查收邮件并进行激活，如果没有收到验证邮件，请检查邮箱的反垃圾箱设置，并到垃圾邮箱查看是否收到，或者更换一个邮箱重新验证' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);
        },

        step3: function() {
            var titles = "密保邮箱",
            cons = '        <!-- 第三步 -->' + '<div class="pset3 pset3-cur">' + '<span class="one">填写邮箱</span>' + '<span class="two">登录激活</span>' + '<span class="three">完成</span>' + '</div>' +

            '<div class="p-phonend">' + '<i class="p-secio-2"></i>' + '<p>您已经绑定邮箱：' + email + '</p>' + '<span id="returnsafeurl" class="p-grrenlink">点击返回帐号安全页面</span>' + '</div>';
            gy_person.oppWrap.popShow(titles, cons);

            $(".p-alertclose").attr('v', 1);

        },

        init: function() {

            var that = verifyObject.bindEmail;
            var email_div_step1_sub_status = false;
            $(document).delegate("#email_div_step1_sub", "click",
            function() {

                var isTrue = verifyObject.isTrue(that.substart);
                if (!isTrue) return;
                if (email_div_step1_sub_status) {
                    return;
                }
                var new_email = $("#new_email").val();
                email_div_step1_sub_status = true;
                $.getJSON(U('User/Safe/sendemail', 'callback=?'), {
                    email: new_email,
                    type: 'safe'
                },
                function(result) {
                    email_div_step1_sub_status = false;
                    if (result.code == 1) {
                        gy_person.oppWrap.popHidden();
                        that.step2();
                        var mail_ext = new_email.split('@');
                        $("#user_email").text(new_email);
                        $('#login_email').attr("href", 'http://mail.' + mail_ext[1]);
                        return;
                    } else {
                        alert(result.msg);
                        return;
                    }
                });

            });
        }

    },

    modifyEmail: {

        substart: [],

        step1: function() {
            var titles = "更改邮箱",
            cons = '        <!-- 第一步 -->' + '<div class="pset4">' + '<span class="one">安全验证</span>' + '<span class="two">填写邮箱</span>' + '<span class="three">登录激活</span>' + '<span class="four">完成</span>' + '</div>' +

            '<div class="p-pdphone p-edpho">' +

            '<div class="p-edphonet">' + '<i class="p-secio-2"></i>' + '<p>' + '<em>您的密保邮箱：' + view_email + '</em>密码忘记可通过密保邮箱快速自助找回密码' + '</p>' + '</div>' + '<table>' + '<tr>' + '<th>请输入右侧验证码</th>' + '<td>' + '<input id="captcha_code" class="p-alertxt"><span class="p-yzm">' + ccaptcha + '</span><p class="p-eorrfont" style="padding-top:0;height:25px;line-height:25px;"></p>' + '</td>' + '</tr>' +

            '<tr>' + '<th style="padding-top:0"></th>' + '<td style="padding-top:0">' + '<span id="modify_email_div_step1_sub" class="p-subbtn">确定</span>' + '</td>' + '</tr>' + '</table>' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);

            var captcha_code = $("#captcha_code"),

            substart = [];

            captcha_code[0].focus();

            substart[0] = function() {

                var txt = captcha_code.val(),

                ele = $(".p-eorrfont");

                if (/^\s*$/.test(txt)) {

                    ele.html('验证码不能为空');

                    captcha_code[0].focus();

                    return false;

                } else {

                    ele.html('');

                    return true;

                }

            };

            verifyObject.modifyEmail.substart = substart;

            $(document).delegate("#captcha_code", "blur",
            function() {

                verifyObject.modifyEmail.substart[0]();

            });

        },

        step2: function() {

            var titles = "更改邮箱",
            cons = '        <!-- 第一步的第二个操作-->' + '<div class="pset4">' + '<span class="one">安全验证</span>' + '<span class="two">填写邮箱</span>' + '<span class="three">登录激活</span>' + '<span class="four">完成</span>' + '</div>' +

            '<div class="p-pdphone">' + '<div class="p-mbemail">' + '<em>验证邮件已发送至您的邮箱：' + email + '</em>请您尽快登录邮箱，按邮箱中指示完成验证<br><a target="_blank" id="g_login_email" href="" class="p-subbtn">登录邮箱</a>' + '</div>' + '</div>' +

            '<div class="p-alertbs">' + '提示：系统已向该邮箱发送了一封验证激活邮件，请查收邮件并进行激活，如果没有收到验证邮件，请检查邮箱的反垃圾箱设置，并到垃圾邮箱查看是否收到，或者更换一个邮箱重新验证' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);
            var mail_ext = email.split('@');
            $('#g_login_email').attr("href", 'http://mail.' + mail_ext[1]);

        },

        step3: function() {
            var titles = "更改邮箱",
            cons = '        <!-- 第二步-->' + '<div class="pset4 pset4-2">' + '<span class="one">安全验证</span>' + '<span class="two">填写邮箱</span>' + '<span class="three">登录激活</span>' + '<span class="four">完成</span>' + '</div>' +

            '<div class="p-pdphone">' + '<table>' + '<tr>' + '<th width="88px">填写邮箱</th>' + '<td>' + '<input id="modify_new_email" class="p-alertxt"><span id="pusheoor"></span>' + '</td>' + '</tr>' +

            '<tr>' + '<th></th>' + '<td>' + '<span id="modify_email_div_step2_sub" class="p-subbtn">确定</span>' + '</td>' + '</tr>' + '</table>' + '</div>';
            gy_person.oppWrap.popShow(titles, cons);

            var captcha_code = $("#modify_new_email"),

            substart = [];

            captcha_code[0].focus();

            substart[0] = function() {

                var txt = captcha_code.val(),

                ele = $("#pusheoor");

                if (!txt.match(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/)) {

                    ele.html('<span class="p-error">请填写正确的邮箱</span>');

                    captcha_code[0].focus();

                    return false;

                } else {

                    ele.html('');
                    return true;

                }

            };

            verifyObject.modifyEmail.substart = substart;

            $(document).delegate("#modify_new_email", "blur",
            function() {

                verifyObject.modifyEmail.substart[0]();

            });

        },

        step4: function() {

            var titles = "更改邮箱",
            cons = '        <!-- 第三步-->' + '<div class="pset4 pset4-3">' + '<span class="one">安全验证</span>' + '<span class="two">填写邮箱</span>' + '<span class="three">登录激活</span>' + '<span class="four">完成</span>' + '</div>' +

            '<div class="p-pdphone">' + '<div class="p-mbemail">' + '<em>验证邮件已发送至您的邮箱：<span id="modify_user_email"></span></em>请您尽快登录邮箱，按邮箱中指示完成验证<br><a target="_blank" href="" id="modify_login_email" class="p-subbtn">登录邮箱</a>' + '</div>' + '</div>' +

            '<div class="p-alertbs">' + '提示：系统已向该邮箱发送了一封验证激活邮件，请查收邮件并进行激活，如果没有收到验证邮件，请检查邮箱的反垃圾箱设置，并到垃圾邮箱查看是否收到，或者更换一个邮箱重新验证' + '</div>';
            gy_person.oppWrap.popShow(titles, cons);

        },

        step5: function() {

            var titles = "更改邮箱",
            cons = '        <!-- 第四步 -->' + '<div class="pset4 pset4-cur">' + '<span class="one">安全验证</span>' + '<span class="two">填写邮箱</span>' + '<span class="three">登录激活</span>' + '<span class="four">完成</span>' + '</div>' +

            '<div class="p-phonend">' + '<i class="p-secio-2"></i>' + '<p>您已经绑定邮箱：' + email + '</p>' + '<span id="returnsafeurl" class="p-grrenlink">点击返回帐号安全页面</span>' + '</div>';
            gy_person.oppWrap.popShow(titles, cons);
            $(".p-alertclose").attr('v', 1);

        },

        init: function() {

            var that = verifyObject.modifyEmail;

            $(document).delegate("#modify_email_div_step1_sub", "click",
            function() {

                var isTrue = verifyObject.isTrue(that.substart);

                if (!isTrue) return;

                var captcha_code = $("#captcha_code"),

                txt = captcha_code.val();

                $.getJSON(U('User/safe/VerifyCaptcha', 'callback=?'), {
                    captcha_code: txt
                },
                function(result) {
                    if (result.code == 1) {
                        gy_person.oppWrap.popHidden();
                        that.step2();
                        $.getJSON(U('User/safe/sendemail', 'callback=?'), {
                            email: email,
                            type: 'check'
                        },
                        function(result) {});
                    } else {
                        $(".p-eorrfont").html('请填写正确的验证码');
                        return;
                    }
                });

            }).delegate("#modify_email_div_step2_sub", "click",
            function() {

                var isTrue = verifyObject.isTrue(that.substart);

                if (!isTrue) return;

                that.step4();

                var modify_new_email = $("#modify_new_email").val();

                var modify_mail_ext = modify_new_email.split('@');

                $("#modify_user_email").text(modify_new_email);

                $('#modify_login_email').attr("href", 'http://mail.' + modify_mail_ext[1]);

                var modify_new_email = $("#modify_new_email").val();

                $.getJSON(U('User/safe/sendemail', 'callback=?'), {
                    email: modify_new_email,
                    type: 'modify'
                },
                function(result) {});
                gy_person.oppWrap.popHidden();

            });

        }

    },

    bindPhone: {

        substart: [],

        step1: function() {
            var titles = "绑定手机",
            cons = '        <!-- 第一步 -->' + '<div class="pset2">' + '<span class="one">安全验证</span>' + '<span class="two">完成</span>' + '</div>' +

            '<div class="p-pdphone">' + '<table>' + '<tr>' + '<th width="88px">手机号码</th>' + '<td>' + '<input maxlength="11" id="sj_step1_number" class="p-alertxt"><span id="pusheoor"></span>' + '</td>' + '</tr>' + '<tr>' + '<th>短信验证码</th>' + '<td>' + '<input id="sj_step1_code" class="p-alertxt"><span id="send_message_one" class="p-sendyzm">发送验证码</span><p class="p-eorrfont" style="padding-top:0;height:25px;line-height:25px;"></p>' + '</td>' + '</tr>' + '<tr>' + '<th style="padding-top:0"></th>' + '<td style="padding-top:0">' + '<a target="_blank" href="http://news.t3t2.com/index.php/read/43.html" class="p-grrenlink">无法通过验证？获取解决方案</a>' + '<span id="sj_div_step1_sub" class="p-subbtn">确定</span>' + '</td>' + '</tr>' + '</table>' + '</div>' +

            '<div class="p-alertbs">' + '如果您没有收到验证码，请等待2分钟后重新点击“获取验证码”。停机、欠费以及开启屏蔽系统短信或安装拦截陌生短信的软件，可能导致您无法正常接收验证码。' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);

            var curinput = $("#sj_step1_number"),

            substart = [];

            curinput[0].focus();

            substart[0] = function() {

                var txt = curinput.val(),

                reg0 = /^(13[0-9]|15[0-9]|18[01235,idErr6789]|16[0-9]|14[0-9]|17[0-9]|19[0-9])[0-9]{8}$/,

                ele = $("#pusheoor"),

                str = '<span class="p-error">请填写正确的手机号码</span>';

                if (! (reg0.test(txt))) {

                    ele.html(str);

                    curinput[0].focus();

                    $("#send_message_one").removeAttr("v");

                    return false;

                } else {

                    ele.html('');

                    $("#send_message_one").attr("v", 1);

                    $("#sj_step1_code")[0].focus();

                    return true;

                }

            };

            substart[1] = function() {

                var step1_code = $("#sj_step1_code"),

                txt = step1_code.val(),

                ele = $(".p-eorrfont");

                if (/^\s*$/.test(txt)) {

                    ele.html('验证码不能为空');

                    return false;

                } else {

                    ele.html('');

                    return true;
                }
            };

            verifyObject.bindPhone.substart = substart;

            $(document).delegate("#sj_step1_number", "blur",
            function() {

                verifyObject.bindPhone.substart[0]();

            }).delegate("#sj_step1_code", "blur",
            function() {

                verifyObject.bindPhone.substart[1]();

            });

        },

        step2: function() {
            var titles = "绑定手机",
            cons = '<div class="pset2 pset2-cur">' + '<span class="one">安全验证</span>' + '<span class="two">完成</span>' + '</div>' +

            '<div class="p-phonend">' + '<i class="p-secio-1"></i>' + '<p>您已成功绑定安全手机<strong><span id="bind_phone"></span></strong></p>' + '<span id="returnsafeurl" class="p-grrenlink">点击返回帐号安全页面</span>' + '</div>';
            gy_person.oppWrap.popShow(titles, cons);
            $(".p-alertclose").attr('v', 1);
        },

        init: function() {

            var that = verifyObject.bindPhone,

            t = 60000,

            timeHand = null,

            forTime = function() {

                if (t) {

                    if (t == 1000) {

                        $("#timetxt").remove();

                        $("#send_message_one").show();

                        t = 60000;

                        return;

                    }

                    t -= 1000;

                    $("#timetxt").find('i').html(t / 1000);

                    timeHand = setTimeout(forTime, 1000);

                } else {

                    clearTimeout(timeHand);

                }

            };

            $(document).delegate("#sj_div_step1_sub", "click",
            function() {

                var isTrue = verifyObject.isTrue(that.substart);

                if (!isTrue) return;

                var phone_code = $("#sj_step1_code").val();

                $.getJSON(U('User/safe/VerifyMessage', 'callback=?'), {
                    code: phone_code
                },
                function(result) {
                    var btn = $("#send_message_one");
                    if (result.code == 1) {
                        var bind_phone = $("#sj_step1_number").val();
                        gy_person.oppWrap.popHidden();
                        that.step2();
                        $("#bind_phone").text(bind_phone);
                    } else {
                        $(".p-eorrfont").html('请输入正确的验证码');
                        return;
                    }
                });
            }).delegate("#send_message_one", "click",
            function() {

                if ($(this).attr('v')) {
                    var phone = $("#sj_step1_number").val();
                    $.getJSON(U('User/safe/sendsms', 'callback=?'), {
                        phone: phone
                    },
                    function(result) {
                        var btn = $("#send_message_one");
                        if (result.code == 1) {
                            btn.next().html('');
                            if ($('#timetxt').length) return;
                            btn.after('<span class="p-graytip"  id="timetxt"><i>60</i>秒后重新发送</span>');
                            btn.hide();
                            timeHand = setTimeout(forTime, 1000);
                        } else {
                            btn.next().html('发送失败，可能是您的号码错误或发送过于频繁，请重新尝试。');
                            return;
                        }
                    });
                }
            });
        }

    },

    modifyPhone: {

        substart: [],

        step1: function() {
            var titles = "更改安全手机",
            cons = '        <!-- 第一步 -->' + '<div class="pset3">' + '<span class="one">安全验证</span>' + '<span class="two">绑定新手机</span>' + '<span class="three">完成</span>' + '</div>' +

            '<div class="p-pdphone p-edpho">' +

            '<div class="p-edphonet">' + '<i class="p-secio-1"></i>' + '<p>' + '<em v="' + phone + '" id="pv">您绑定的手机是：' + view_phone + '</em>绑定手机让帐号更安全，游戏隐私和充值记录更受保护' + '</p>' + '</div>' + '<div class="p-edphoneb">' + '<a target="_blank" href="http://news.t3t2.com/index.php/read/43.html" class="p-grrenlink">无法通过验证？</a>' + '为了您的帐号安全，更改手机需要先验证您的已绑定手机' + '</div>' +

            '<table>' + '<tr>' + '<th width="114px">已绑定手机号码</th>' + '<td>' + '<input maxlength="11" id="sj_step1_number" class="p-alertxt"><span id="pusheoor"></span>' + '</td>' + '</tr>' + '<tr>' + '<th>短信验证码</th>' + '<td>' + '<input id="sj_step1_code" class="p-alertxt"><span id="send_message_one" class="p-sendyzm">发送验证码</span><p class="p-eorrfont" style="padding-top:0;height:18px;line-height:18px"></p>' + '</td>' + '</tr>' + '<tr>' + '<th style="padding-top:0"></th>' + '<td style="padding-top:0">' + '<span id="sj_div_step1_sub" class="p-subbtn">确定</span>' + '</td>' + '</tr>' + '</table>' + '</div>' +

            '<div class="p-alertbs">' + '如果您没有收到验证码，请等待1分钟后重新点击“获取验证码”。停机、欠费以及开启屏蔽系统短信或安装拦截陌生短信的软件，可能导致您无法正常接收验证码。' + '</div>';

            gy_person.oppWrap.popShow(titles, cons);

            var curinput = $("#sj_step1_number"),

            substart = [];

            curinput[0].focus();

            substart[0] = function() {

                var txt = curinput.val(),

                reg0 = /^(13[0-9]|15[0-9]|18[01235,idErr6789]|16[0-9]|14[0-9]|17[0-9]|19[0-9])[0-9]{8}$/,

                ele = $("#pusheoor"),

                pv = $("#pv").attr('v'),

                str = '<span class="p-error">请填写正确的手机号码</span>';

                if (! (reg0.test(txt)) || txt != pv) {

                    ele.html(str);

                    $("#send_message_one").removeAttr("v");

                    return false;

                } else {

                    ele.html('');

                    $("#send_message_one").attr("v", 1);

                    $("#sj_step1_code")[0].focus();

                    return true;
                }

            };

            substart[1] = function() {

                var step1_code = $("#sj_step1_code"),

                txt = step1_code.val(),

                ele = $(".p-eorrfont");

                if (/^\s*$/.test(txt)) {

                    ele.html('验证码不能为空');

                    return false;

                } else {

                    ele.html('');

                    return true;
                }
            };

            verifyObject.modifyPhone.substart = substart;

            $(document).delegate("#sj_step1_number", "blur",
            function() {

                verifyObject.modifyPhone.substart[0]();

            }).delegate("#sj_step1_code", "blur",
            function() {

                verifyObject.modifyPhone.substart[1]();

            });

        },

        step2: function() {
            var titles = "更改安全手机",
            cons = '        <!-- 第二步 -->' + '<div class="pset3 pset3-2">' + '<span class="one">安全验证</span>' + '<span class="two">绑定新手机</span>' + '<span class="three">完成</span>' + '</div>' +

            '<div class="p-pdphone">' + '<table>' + '<tr>' + '<th width="88px">新手机号码</th>' + '<td>' + '<input maxlength="11" id="sj_step2_number" class="p-alertxt"><span id="pusheoor"></span>' + '</td>' + '</tr>' + '<tr>' + '<th>短信验证码</th>' + '<td>' + '<input id="sj_step2_code" class="p-alertxt"><span id="send_message_two" class="p-sendyzm">发送验证码</span><p class="p-eorrfont"  style="padding-top:0;height:25px;line-height:25px;"></p>' + '</td>' + '</tr>' + '<tr>' + '<th style="padding-top:0"></th>' + '<td style="padding-top:0">' + '<span id="sj_div_step2_sub" class="p-subbtn">确定</span>' + '</td>' + '</tr>' + '</table>' + '</div>' +

            '<div class="p-alertbs">' + '如果您没有收到验证码，请等待1分钟后重新点击“获取验证码”。停机、欠费以及开启屏蔽系统短信或安装拦截陌生短信的软件，可能导致您无法正常接收验证码。' + '</div>';
            gy_person.oppWrap.popShow(titles, cons);

            var curinput = $("#sj_step2_number"),

            substart = [];

            curinput[0].focus();

            substart[0] = function() {

                var txt = curinput.val(),
                reg0 = /^(13[0-9]|15[0-9]|18[01235,idErr6789]|16[0-9]|14[0-9]|17[0-9]|19[0-9])[0-9]{8}$/,
                ele = $("#pusheoor"),
                str = '<span class="p-error">请填写正确的手机号码</span>';
                if (! (reg0.test(txt))) {

                    ele.html(str);

                    $("#send_message_two").removeAttr("v");

                    $("#send_message_two").css("color", "#999");

                    return false;

                } else {

                    ele.html('');

                    $("#send_message_two").css("color", "#333");

                    $("#send_message_two").attr("v", 1);

                    $("#sj_step2_code")[0].focus();

                    return true;

                }
            };

            substart[1] = function() {

                var step1_code = $("#sj_step2_code"),

                txt = step1_code.val(),

                ele = $(".p-eorrfont");

                if (/^\s*$/.test(txt)) {

                    ele.html('验证码不能为空');

                    return false;

                } else {

                    ele.html('');

                    return true;
                }
            };

            verifyObject.modifyPhone.substart = substart;

            $(document).delegate("#sj_step2_number", "blur",
            function() {

                verifyObject.modifyPhone.substart[0]();

            }).delegate("#sj_step2_code", "blur",
            function() {

                verifyObject.modifyPhone.substart[1]();

            });

        },

        step3: function() {
            var titles = "更改安全手机",
            cons = '        <div class="pset3 pset3-cur">' + '<span class="one">安全验证</span>' + '<span class="two">绑定新手机</span>' + '<span class="three">完成</span>' + '</div>' +

            '<div class="p-phonend">' + '<i class="p-secio-1"></i>' + '<p>您已成功绑定安全手机<strong><span id="bind_phone"></span></strong></p>' + '<span class="p-grrenlink" id="returnsafeurl">点击返回帐号安全页面</span>' + '</div>';
            gy_person.oppWrap.popShow(titles, cons);
            $(".p-alertclose").attr('v', 1);
        },

        init: function() {

            var that = verifyObject.modifyPhone,

            t = 60000,

            timeHand = null,

            forTime = function() {

                if (t) {

                    if (t == 1000) {

                        $("#timetxt").remove();
                        $("#send_message_one").show();
                        $("#send_message_two").show();
                        t = 60000;
                        return;

                    }

                    t -= 1000;
                    $("#timetxt").find('i').html(t / 1000);
                    timeHand = setTimeout(forTime, 1000);

                } else {

                    clearTimeout(timeHand);

                }

            };

            $(document).delegate("#sj_div_step1_sub", "click",
            function() {

                var isTrue = verifyObject.isTrue(that.substart);

                if (!isTrue) return;

                var phone_code = $("#sj_step1_code").val();
                $.getJSON(U('User/safe/VerifyMessage', 'callback=?'), {
                    code: phone_code
                },
                function(result) {
                    var btn = $("#send_message_one");
                    if (result.code == 1) {
                        gy_person.oppWrap.popHidden();
                        that.step2();
                    } else {
                        $(".p-eorrfont").html('请输入正确的验证码');
                        return;
                    }
                });

            }).delegate("#sj_div_step2_sub", "click",
            function() {

                var isTrue = verifyObject.isTrue(that.substart);

                if (!isTrue) return;

                var phone_code = $("#sj_step2_code").val();
                var phone = $("#sj_step2_number").val();
                $.getJSON(U('User/safe/VerifyMessage', 'callback=?'), {
                    code: phone_code
                },
                function(result) {
                    var btn = $("#send_message_one");
                    if (result.code == 1) {
                        gy_person.oppWrap.popHidden();
                        that.step3();
                        $("#bind_phone").text(phone);
                    } else {
                        $(".p-eorrfont").html('请输入正确的验证码');
                        return;
                    }
                });

            }).delegate("#send_message_one", "click",
            function() {

                if ($(this).attr('v')) {

                    var phone = $("#sj_step1_number").val();
                    $.getJSON(U('User/safe/sendsms', 'callback=?'), {
                        phone: phone
                    },
                    function(result) {
                        var btn = $("#send_message_one");
                        if (result.code == 1) {
                            btn.next().html('');
                            if ($('#timetxt').length) return;
                            btn.after('<span class="p-graytip"  id="timetxt"><i>60</i>秒后重新发送</span>');
                            btn.hide();
                            t = 60000;
                            timeHand = setTimeout(forTime, 1000);
                        } else {
                            btn.next().html('发送失败，可能是您的号码错误或发送过于频繁，请重新尝试。');
                            return;
                        }
                    });
                }

            }).delegate("#send_message_two", "click",
            function() {

                if ($(this).attr('v')) {
                    var phone = $("#sj_step2_number").val();

                    $.getJSON(U('User/safe/sendsms', 'callback=?'), {
                        phone: phone
                    },
                    function(result) {
                        var btn = $("#send_message_two");
                        if (result.code == 1) {
                            $("#peor").remove();
                            btn.after('<span class="p-graytip"  id="timetxt"><i>60</i>秒后重新发送</span>');
                            btn.hide();
                            t = 60000;
                            timeHand = setTimeout(forTime, 1000);
                        } else {
                            btn.after('<p class="p-eorrfont" id="peor">发送失败，可能是您的号码错误或发送过于频繁，请重新尝试。</p>');
                            return;
                        }
                    });

                }

            });

        }

    },

    init: function() {

        $(document).delegate(".p-alertclose", "click",
        function() {

            if ($(this).attr('v')) {
                verifyObject.returnSafeUrl();
            } else {
                gy_person.oppWrap.popHidden();
            }

        }).delegate("#xgmm", "click",
        function() {

            verifyObject.editePassWord.init();

            verifyObject.editePassWord.step1();

        }).delegate("#sfyz", "click",
        function() {

            verifyObject.updateIdCard.init();

            verifyObject.updateIdCard.step1();

        }).delegate("#yxyz", "click",
        function() {

            verifyObject.bindEmail.init();
            verifyObject.bindEmail.step1();

        }).delegate("#ggyx", "click",
        function() {

            verifyObject.modifyEmail.init();
            verifyObject.modifyEmail.step1();

        }).delegate("#sjbd", "click",
        function() {

            verifyObject.bindPhone.init();
            verifyObject.bindPhone.step1();

        }).delegate("#ggsj", "click",
        function() {

            verifyObject.modifyPhone.init();
            verifyObject.modifyPhone.step1();

        }).delegate("#returnsafeurl", "click",
        function() {

            verifyObject.returnSafeUrl();
        });

    }

};

verifyObject.init();

if (check_mail == 1) {
    verifyObject.modifyEmail.init();
    verifyObject.modifyEmail.step3();
}
if (modify_mail == 1) {
    verifyObject.modifyEmail.init();
    verifyObject.modifyEmail.step5(email);
}

if (save_mail == 1) {
    verifyObject.bindEmail.init();
    verifyObject.bindEmail.step3(email);
}

if (t) {
    if (t == 'sjbd') {
        verifyObject.bindPhone.init();
        verifyObject.bindPhone.step1();
    } else if (t == 'ggsj') {
        verifyObject.modifyPhone.init();
        verifyObject.modifyPhone.step1();
    } else if (t == 'ggyx') {
        verifyObject.modifyEmail.init();
        verifyObject.modifyEmail.step1();
    } else if (t == 'yxyz') {
        verifyObject.bindEmail.init();
        verifyObject.bindEmail.step1();
    } else if (t == 'sfyz') {
        verifyObject.updateIdCard.init();
        verifyObject.updateIdCard.step1();
    }
}