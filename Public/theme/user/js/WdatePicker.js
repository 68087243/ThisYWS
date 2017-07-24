(function ($) { $.fn.LWJDate = function (condition) { var Dom = this; var LWJDateTime; var NowTimeFormat; var ShowDateTime; if (this == null) { return; } var Options = { Style: 'red', Event: 'click', DateFormat: 'yyyy-MM-dd', Left: 0, Top: 8, IsNeedClickOk: false, MaxDay: 0, MinDay: 0, ZIndex: 9999, Animate: 0, CallBack: function (data) { }, IsAtOnce:false }; var LWJDate; $.extend(Options, condition); var CreateDOM = function () { LWJDate = $("<div></div>"); LWJDate.addClass("lwjdate"); LWJDate.addClass("lwjdate-" + Options.Style); LWJDate.css("z-index", Options.ZIndex); var CreateHead = function () { var HeadBox = $("<div class='lwjdate-head'></div>"); HeadBox.append("<a class='lwjdate-premonth'></a><h3 class='lwjdate-year'>2012 年</h3><h3 class='lwjdate-month'>8 月</h3><a class='lwjdate-nextmonth'></a>"); HeadBox.append("<div class='lwjdate-weekbox'><h4>周日</h4><h4>周一</h4><h4>周二</h4><h4>周三</h4><h4>周四</h4><h4>周五</h4><h4>周六</h4></div>"); LWJDate.append(HeadBox); LWJDate.append("<div class='lwjdate-showtime'>当前选择时间：</div>"); }; var CreateDay = function () { var DayBox = $("<div class='lwjdate-daybox'></div>"); for (var i = 0; i < 35; i++) { DayBox.append("<a class='day'></a>"); } LWJDate.append(DayBox); }; var CreateFoot = function () { LWJDate.append("<div class='lwjdate-button-box'><div class='lwjdate-button-clear'></div><div class='lwjdate-button-today'></div><div class='lwjdate-button-close'></div></div>"); }; var CreateSelect = function () { var SelectYear = $("<div class='lwjdate-select-year'></div>"); var SelectMonth = $("<div class='lwjdate-select-month'></div>"); for (var i = 1; i < 13; i++) { SelectMonth.append("<a class='lwjdate-month-item'>" + i + "</a>"); } SelectYear.append("<div class='lwjdate-pre-selectyear'></div>"); var AllYearBox = $("<div class='lwjdate-allyear-box'></div>"); var YearBoxOne = $("<div class='lwjdate-yearbox-item'></div>"); for (var i = 1901; i < 1941; i++) { YearBoxOne.append("<a class='lwjdate-year-item'>" + i + "</a>"); } var YearBoxTwo = $("<div class='lwjdate-yearbox-item'></div>"); for (var i = 1941; i < 1981; i++) { YearBoxTwo.append("<a class='lwjdate-year-item'>" + i + "</a>"); } var YearBoxThree = $("<div class='lwjdate-yearbox-item'></div>"); for (var i = 1981; i < 2021; i++) { YearBoxThree.append("<a class='lwjdate-year-item'>" + i + "</a>"); } var YearBoxFour = $("<div class='lwjdate-yearbox-item'></div>"); for (var i = 2021; i < 2061; i++) { YearBoxFour.append("<a class='lwjdate-year-item'>" + i + "</a>"); } var YearBoxFive = $("<div class='lwjdate-yearbox-item'></div>"); for (var i = 2061; i < 2101; i++) { YearBoxFive.append("<a class='lwjdate-year-item'>" + i + "</a>"); } var AllyearBoxMove = $("<div class='lwjdata-allyear-box-item'></div>"); AllyearBoxMove.append(YearBoxOne); AllyearBoxMove.append(YearBoxTwo); AllyearBoxMove.append(YearBoxThree); AllyearBoxMove.append(YearBoxFour); AllyearBoxMove.append(YearBoxFive); AllYearBox.append(AllyearBoxMove); SelectYear.append(AllYearBox); SelectYear.append("<div class='lwjdate-next-selectyear'></div>"); LWJDate.append(SelectYear); LWJDate.append(SelectMonth); }; CreateHead(); CreateDay(); CreateFoot(); CreateSelect(); };var AddNum = function () { var FirstDay = new Date(Date.parse(ShowDateTime)); var NextMonth = new Date(Date.parse(ShowDateTime)); var Year = ShowDateTime.getFullYear(); var Month = ShowDateTime.getMonth() + 1; var Day = LWJDateTime.getDate(); LWJDate.find(".lwjdate-year").html(Year + " 年"); LWJDate.find(".lwjdate-month").html(Month + " 月"); FirstDay.setDate(1); NextMonth.setDate(1); NextMonth.setMonth(FirstDay.getMonth() + 1); var WeekDay = FirstDay.getDay(); var AllDay = (NextMonth - FirstDay) / (1000 * 60 * 60 * 24); var NowDay = 1; for (var i = 41; i >= 0; i--) { LWJDate.find(".lwjdate-daybox .day").eq(i).removeClass("day-able"); LWJDate.find(".lwjdate-daybox .day").eq(i).removeClass("lwjdate-dayselect"); LWJDate.find(".lwjdate-daybox .day").eq(i).html(""); } if (Options.MaxDay != 0) { if (Options.MaxDay == 'today') { Options.MaxDay = GetNowTime(); } else if (typeof (Options.MaxDay)=="string") { Options.MaxDay = GetNowTime(Options.MaxDay); } } if (Options.MinDay != 0) { if (Options.MinDay == 'today') { Options.MinDay = GetNowTime(); } else if (typeof (Options.MinDay) == "string") { Options.MinDay = GetNowTime(Options.MinDay); } } for (var i = WeekDay; i < AllDay + WeekDay; i++) { LWJDate.find(".lwjdate-daybox .day").eq(i).html(NowDay); if (NowDay == Day) { LWJDate.find(".lwjdate-daybox .day").eq(i).addClass("lwjdate-dayselect"); } else { if (Options.MaxDay != 0 && Options.MinDay != 0) { if ((Date.parse(Year + "/" + Month + "/" + NowDay) - Date.parse(Options.MaxDay) > 0) || (Date.parse(Year + "/" + Month + "/" + NowDay) - Date.parse(Options.MinDay) < 0)) { } else { LWJDate.find(".lwjdate-daybox .day").eq(i).addClass("day-able"); } } else if (Options.MaxDay != 0&&Options.MinDay==0) { if (Date.parse(Year + "/" + Month + "/" + NowDay) - Date.parse(Options.MaxDay) > 0) { } else { LWJDate.find(".lwjdate-daybox .day").eq(i).addClass("day-able"); } } else if (Options.MinDay != 0 && Options.MaxDay == 0) { if (Date.parse(Year + "/" + Month + "/" + NowDay) - Date.parse(Options.MinDay) < 0) { } else { LWJDate.find(".lwjdate-daybox .day").eq(i).addClass("day-able"); } } else { LWJDate.find(".lwjdate-daybox .day").eq(i).addClass("day-able"); } } NowDay++; } NowTimeFormat = Options.DateFormat.replace("yyyy", Year).replace("MM", Month).replace("dd", Day); LWJDate.find(".lwjdate-showtime").html("当前选择时间：" + NowTimeFormat); }; var ResetTime = function () { var Year = ShowDateTime.getFullYear(); var Month = ShowDateTime.getMonth() + 1; var Day = ShowDateTime.getDate(); NowTimeFormat = Options.DateFormat.replace("yyyy", Year).replace("MM", Month).replace("dd", Day); LWJDate.find(".lwjdate-showtime").html("当前选择时间：" + NowTimeFormat); }; var RePosition = function () { var Left = Dom.offset().left+Options.Left; var Top = Dom.offset().top + Dom.height() + Options.Top; LWJDate.css("left", Left); LWJDate.css("top", Top); }; var GetNowTime = function (timeval) { var Result; if (timeval == null || timeval == "") { Result = new Date(); } else { var OldVal = timeval.replace("/", '-').replace('/', '-'); var OldVal = timeval.replace("年", '-').replace('月', '-').replace('日', ''); var YearOld; YearOld = OldVal.split('-'); if (YearOld.length == 3) { Result = new Date(OldVal); } else { Result = "NaN"; } if (Result == "NaN") { Result = new Date(); if (YearOld.length == 3) { Result.setFullYear(YearOld[0], YearOld[1] - 1, YearOld[2]); } else if (YearOld.length == 2) { Result.setFullYear(new Date().getFullYear(), YearOld[0] - 1, YearOld[1]); } else if (YearOld.length == 1) { Result.setFullYear(new Date().getFullYear(), new Date().getMonth(), YearOld[0]); } else { Result = new Date(); } } } return Result; }; var AddEvent = function () { LWJDate.find(".day-able").on("click", function () { LWJDate.find(".lwjdate-dayselect").addClass("day-able"); LWJDate.find(".lwjdate-dayselect").removeClass("lwjdate-dayselect"); $(this).removeClass("day-able"); $(this).addClass("lwjdate-dayselect"); ShowDateTime.setDate($(this).html()); ResetTime(); if (!Options.IsNeedClickOk) { CloseDate(); } }); LWJDate.find(".lwjdate-premonth").on("click", function () { ShowDateTime.setMonth(ShowDateTime.getMonth() - 1); AddNum(); }); LWJDate.find(".lwjdate-nextmonth").on("click", function () { ShowDateTime.setMonth(ShowDateTime.getMonth() + 1); AddNum(); }); LWJDate.find(".lwjdate-month").on("click", function () { LWJDate.find(".lwjdate-select-month").slideToggle(); var NowShowMonth = ShowDateTime.getMonth() + 1; LWJDate.find(".lwjdate-month-item").each(function () { if ($(this).html() == NowShowMonth) { $(this).addClass("select-month"); } else { $(this).removeClass("select-month"); } }); }); LWJDate.find(".lwjdate-year").on("click", function () { LWJDate.find(".lwjdate-select-year").slideToggle(); var NowShowYear = ShowDateTime.getFullYear(); if (NowShowYear >= 1901 && NowShowYear < 1941) { LWJDate.find(".lwjdate-allyear-box").scrollLeft(0); } else if (NowShowYear >= 1941 && NowShowYear < 1981) { LWJDate.find(".lwjdate-allyear-box").scrollLeft(188); } else if (NowShowYear >= 1981 && NowShowYear < 2021) { LWJDate.find(".lwjdate-allyear-box").scrollLeft(376); } else if (NowShowYear >= 2021 && NowShowYear < 2061) { LWJDate.find(".lwjdate-allyear-box").scrollLeft(564); } else if (NowShowYear >= 2061 && NowShowYear < 2101) { LWJDate.find(".lwjdate-allyear-box").scrollLeft(752); } LWJDate.find(".lwjdate-year-item").each(function () { if ($(this).html() == NowShowYear) { $(this).addClass("select-year"); } else { $(this).removeClass("select-year"); } }); }); LWJDate.find(".lwjdate-next-selectyear").on("click", function () { var NowScroll = LWJDate.find(".lwjdate-allyear-box").scrollLeft(); if (NowScroll < 752) { LWJDate.find(".lwjdate-allyear-box").animate({ scrollLeft: NowScroll + 188 }); } }); LWJDate.find(".lwjdate-pre-selectyear").on("click", function () { var NowScroll = LWJDate.find(".lwjdate-allyear-box").scrollLeft(); if (NowScroll > 0) { LWJDate.find(".lwjdate-allyear-box").animate({ scrollLeft: NowScroll - 188 }); } });LWJDate.find(".lwjdate-month-item").on("click", function () { $(this).parent().slideUp(); ShowDateTime.setMonth($(this).html()-1); AddNum(); }); LWJDate.find(".lwjdate-year-item").on("click", function () { LWJDate.find(".lwjdate-select-year").slideUp(); ShowDateTime.setFullYear($(this).html()); AddNum(); }); LWJDate.find(".lwjdate-button-clear").on("click", function () { CloseDate(true); }); LWJDate.find(".lwjdate-button-close").on("click", function () { CloseDate(); }); LWJDate.find(".lwjdate-button-today").on("click", function () { ShowDateTime = new Date(); ResetTime(); CloseDate(); }); LWJDate.on("mouseleave", function () { CloseDate(false); });}; var CloseDate = function (getval) { if (getval != null) { if (getval == true) { Dom.val(""); } } else { if (Options.MaxDay != 0 && Options.MinDay != 0) { if ((Date.parse(ShowDateTime) - Date.parse(Options.MaxDay) > 0) || (Date.parse(ShowDateTime) - Date.parse(Options.MinDay) < 0)) { } else { Dom.val(NowTimeFormat); } } else if (Options.MaxDay != 0 && Options.MinDay == 0) { if (Date.parse(ShowDateTime) - Date.parse(Options.MaxDay) > 0) { } else { Dom.val(NowTimeFormat); } } else if (Options.MinDay != 0 && Options.MaxDay == 0) { if (Date.parse(ShowDateTime) - Date.parse(Options.MinDay) < 0) { }else { Dom.val(NowTimeFormat); } } else { Dom.val(NowTimeFormat); } }if (Options.Animate == 0) { LWJDate.remove(); LWJDate = null; } else if(Options.Animate==1) { LWJDate.slideUp(function () { LWJDate.remove(); LWJDate = null; }); } else if (Options.Animate == 2) { LWJDate.fadeOut(function () { LWJDate.remove(); LWJDate = null; }); } Options.CallBack(NowTimeFormat); };var CSH = function () { CreateDOM(); RePosition(); $("body").append(LWJDate); LWJDate = $("body .lwjdate").last(); ShowDateTime = GetNowTime($.trim(Dom.val())); LWJDateTime = GetNowTime($.trim(Dom.val())); AddNum(); AddEvent(); if (Options.Animate==0) { LWJDate.show(); } else if(Options.Animate==1) { LWJDate.slideDown(); } else if (Options.Animate == 2) { LWJDate.fadeIn(); } }; if (Options.IsAtOnce) { CSH(); } else { $(Dom).on(Options.Event, function () { if ($(LWJDate).length == 0) { CSH(); } }); } return this; } })(jQuery);function LWJDate(dom) { $(dom).LWJDate(LWJGetJson(dom)); }; function LWJGetJson(e) { var condition = $(e).attr("lref"); if (condition == "" || condition == null) { condition = { Style: 'red' }; } else { condition = eval('(' + condition + ')'); } $.extend(condition, { IsAtOnce: true }); return condition; };$(function () { $("body").on("click", "input.ldate", function () { $(this).LWJDate(LWJGetJson(this)); }); });