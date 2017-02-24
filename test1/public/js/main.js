/**
 * Created by Administrator on 2016/5/10.
 */

$(function(){
    interleave_set();
    navs();
    datetime();
});

function interleave_set(){
    $(".tb_list table tbody tr:nth-child(2n)").css("background","#f2f2f2");
    $(".tb_list table tbody tr:nth-child(2n+1)").css("background","#fff");
}

//遮罩层
function Mask(dom,callback1,callback2){
    var body = $("body");
    var mask = $("<div class='mask'></div>");
    var mskcont = $(dom);
    body.append(mask);
    body.append(mskcont);
    var focusipt = body.find("input:focus");
    if(focusipt.length){focusipt.blur();}
    body.addClass("over_hidden");
    mskcont.css("margin","-"+(mskcont.height()/2)+"px -"+(mskcont.width()/2)+"px");
    mskcont.hide().fadeIn(300);
    var times = mskcont.find(".title .close");
    times.click(close);
    //mask.click(function(){times.click();});
    mskcont.find(".nobtn").click(function(){times.click();});
    mskcont.find(".okbtn").click(function(){rttrue();});
    function close(){
        mask.remove();
        mskcont.remove();
        body.removeClass("over_hidden");
        if(callback1){callback1();}
        return false;
    }
    function rttrue(){
        mask.remove();
        mskcont.remove();
        body.removeClass("over_hidden");
        if(callback2){callback2();}
        return false;
    }
}
Mask.alert = function(str,callback,title){
    var title = title?title:"提示"
    var dom = "<div class=\"maskcontent\">"+
        "<div class=\"title\"><span>"+title+"</span><a class=\"close\">&times;</a></div>"+
        "<div class=\"cont\">"+str+"</div>"+
        "<div class=\"foot\"><input type=\"button\" class=\"yesbtn okbtn\" value=\"确定\"/></div>"+
        "</div>";
    Mask(dom,callback,callback);
};
Mask.confirm1 = function(str,callback1,callback2){
    var dom = "<div class=\"maskcontent\">"+
        "<div class=\"title\"><span>提示</span><a class=\"close\">&times;</a></div>"+
        "<div class=\"tip_bg\"></div>"+
        "<div class=\"cont\">"+str+"</div>"+
        "<div class=\"foot\">"+
        "<input type=\"button\" class=\"yesbtn okbtn\" value=\"确定\"/>"+
        "<input type=\"button\" class=\"nobtn clbtn\" value=\"取消\"/>"+
        "</div>"+
        "</div>";
    Mask(dom,callback1,callback2);
};
Mask.confirm = function(str,callback1,callback2){
    var dom = "<div class=\"maskcontent\">"+
        "<div class=\"title\"><span>提示</span><a class=\"close\">&times;</a></div>"+
        "<div class=\"cont\">"+str+"</div>"+
        "<div class=\"foot\">"+
        "<input type=\"button\" class=\"yesbtn okbtn\" value=\"确定\"/>"+
        "<input type=\"button\" class=\"nobtn clbtn\" value=\"取消\"/>"+
        "</div>"+
        "</div>";
    Mask(dom,callback1,callback2);
};
Mask.confirm2 = function(str,callback1,callback2){
    var dom = "<div class=\"maskcontent\">"+
        "<div class=\"title\"><span>提示</span><a class=\"close\">&times;</a></div>"+
        "<div class=\"cont cont2\">"+str+"</div>"+
        "<div class=\"foot\">"+
        "<input type=\"button\" class=\"yesbtn okbtn\" value=\"去授权\"/>"+
        "<input type=\"button\" class=\"nobtn clbtn\" value=\"取消\"/>"+
        "</div>"+
        "</div>";
    Mask(dom,callback1,callback2);
};

Mask.load =  function(url,title,callback,onload){
    $.get(url,{},function(data){
        if(!title){title="";}
        if(title == "notitle"){
            var dom = "<div class=\"maskcontent\"><div class=\"notitle\"><a class=\"close_btn\">&times;</a></div>"+data+"</div>";
        }else{
            var dom = "<div class=\"maskcontent\"><div class=\"title\"><span>"+title+"</span><a class=\"close\">&times;</a></div>"+data+"</div>";
        }
        Mask(dom,callback,false);
        if(onload){onload();}
    });
};
Mask.close = function(){
    var mask = $(".mask:last");
    var maskcontent = $(".maskcontent:last");
    if(mask&&mask.length){
        mask.remove();
        if(maskcontent.find("iframe").length){maskcontent.find("iframe").remove();};
        if(window.CollectGarbage){CollectGarbage();};
        maskcontent.remove();
    }
}
Mask.alertPlaint = function (str){
    return  "<img src='/Public/image/plaint.png' style='vertical-align:middle;margin-right:10px;width:70px;height:63px;' />" +
        "<span style='display:inline-block;vertical-align:middle;'>"+str+"</span>";
};



//二级菜单
function navs(){
    var ul = $("#nav .navul>li>a");
    ul.click(function(){
        var ts = $(this).parent();
        if(ts.hasClass("active")){return false;}
        var acnav = ts.parent().children(".active").removeClass("active").find(".sonnav");
        var acnavh = acnav.height();
        acnav.animate({"height":0},350,function(){$(this).hide().height(acnavh);});
        ts.addClass("active");
        var sonnav = ts.find(".sonnav");
        if(sonnav){sonnav.show();var h = sonnav.height();sonnav.height(0).animate({height:h+"px"},350);}
    });
    if(typeof menu != 'undefined'){
        menu[0]?$("#nav .navul ."+menu[0]+">a").click():"";
        menu[0]&&menu[1]?$("#nav .navul ."+menu[0]+" .sonnav ."+menu[1]).addClass("active"):"";
    }
}


//气泡框
function addBubble(jqdom,str){
    if(!jqdom.mouseover){return false;}
    var dom = $("<div class='bubble'>"+str+"<i></i></div>");
    jqdom.mouseover(function(e){
        $("body").append(dom);
        setTimeout(function(){jqdom.mouseout(msout);},5);
        var bubble = dom;
        var bx = e.pageX-10;
        var by = e.pageY-bubble.height()-62;
        if(bx+bubble.width()+35>$(window).width()){
            bubble.find("i").css({"left":"auto","right":"10px","background-position-x":"0"});
            bubble.css({"top":by+"px","left":"auto","right":($(window).width()-bx-20)+"px"});
        }else{
            bubble.find("i").css({"left":"10px","right":"auto","background-position-x":"-30px"});
            bubble.css({"top":by+"px","left":bx+"px","right":"auto"});
        }
    }).mousemove(function(e){
        var bubble = dom;
        var bx = e.pageX-10;
        var by = e.pageY-bubble.height()-62;
        if(bx+bubble.width()+35>$(window).width()){
            bubble.find("i").css({"left":"auto","right":"10px","background-position-x":"0"});
            bubble.css({"top":by+"px","left":"auto","right":($(window).width()-bx-20)+"px"});
        }else{
            bubble.find("i").css({"left":"10px","right":"auto","background-position-x":"-30px"});
            bubble.css({"top":by+"px","left":bx+"px","right":"auto"});
        }
    });
    function msout(){
        dom.remove();
        return false;
    }
}

/**** 时间  start*****/
function datetime() {
    var ymdhis = $(".ymdhis");
    var ymd = $(".ymd");
    var ym = $(".ym");
    var hi = $(".hi");
    if(ymdhis.length||ymd.length||hi.length||ym.length){
        $("head").append('<link rel="stylesheet" href="/public/js/datetimepicker-master/jquery.datetimepicker.css">');
        $("head").append('<script src="/public/js/datetimepicker-master/jquery.datetimepicker.js"></script>');
        inttime();
    }
    function inttime(){
        if (ymdhis.length) {if(!ymdhis.datetimepicker){inttime()};ymdhis.datetimepicker({format: 'Y-m-d H:i:s', timepicker: true});}
        if (ymd.length) {if(!ymd.datetimepicker){inttime()};ymd.datetimepicker({format: 'Y-m-d', timepicker: false});}
        if (ym.length) {if(!ym.datetimepicker){inttime()};ym.datetimepicker({format: 'Y-m'});}
        if (hi.length) {if(!hi.datetimepicker){inttime()};hi.datetimepicker({format: 'H:i', datepicker: false, timepicker: true});}
    }
    $(".ymdhis,.ymd,.ym,.hi").attr("autocomplete","off");
}
/**** 时间  end*****/