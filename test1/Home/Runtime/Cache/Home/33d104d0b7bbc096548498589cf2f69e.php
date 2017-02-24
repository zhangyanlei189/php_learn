<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" >
    <meta name="renderer" content="webkit">
    <title></title>
    <link rel="stylesheet" href="../../../../public/css/style.css"/>
    <link rel="stylesheet" href="../../../../public/css/main.css"/>
    <link rel="stylesheet" href="../../../../public/css/jquery-ui.min.css"/>
    <script src="../../../../public/js/jquery.js"></script>
    <script src="../../../../public/js/chart/echarts.js"></script>
    <script src="../../../../public/js/jquery-ui.min.js"></script>
    <style>

        .content .area{margin:15px 0;}
        .content .area .area-c{position:relative;height: 180px;width: 32%;margin-left: 2%;color: #2e2e2e;font-size: 16px;}
        .content .area .area-c.fans{margin-left: 0;}
        .content .area .area-c .bg{position: absolute;width: 230px;height: 52px;top: 50%;left: 50%;margin-top: -26px;margin-left: -115px;background:url("../../../../public/images/sprite.png") no-repeat; }
        .content .area .area-c.fans .bg{background-position: 5px -462px;}
        .content .area .area-c.money .bg{background-position: 2px -562px;}
        .content .area .area-c.suttle .bg{background-position: -272px -558px;}
        .content .area .area-c.public .bg{background-position: -275px -450px;}
        .content .area .area-c .num{position: absolute;left: 15px;top: 15px;}
        .content .area .area-c .num span{font-size: 30px;}
        .content .area .area-c .des{position: absolute;right: 15px;bottom: 15px;}
        .content .area .area-c.fans .num span{color: #db2929;}
        .content .area .area-c.money .num span{color: #197be2;}
        .content .area .area-c.suttle .num span{color: #ff7800;}
        .content .area .area-c.public .num span{color: #27c657;}

        .content .chart{height: 300px;}

        .loading{position:absolute;top:0;left:0;right:0;bottom:0;width: 100%;height: 100%;background: #fff;z-index: 9;}
    </style>
</head>
<body>
<div class="content">
    <div class="loading">...</div>
    <script>
        var a = setTimeout(function(){
            $(".loading").remove();
        },1000);
    </script>
    <div class="title block"><span>推广概况</span>&gt;<span>效果统计</span></div>
    <div class="title block clearfix" style="padding: 11px 15px;margin-top: 15px;line-height: 22px;">
        <div class="fl"><span>投放公众号</span>：<span class="font-red">快连无线</span></div>
        <div class="right date_sel fr"><span class="active seven" val="7">近7天</span><span class="fifteen" val="15">近15天</span><span class="month" val="30">近一个月</span><span class="three_m" val="90">近三个月</span>
            <div class="sel_date"><input class="ymdstart starttime" id="from" placeholder="开始时间">-<input id="to" class="ymdend endtime" placeholder="结束时间"><span class="time_btn">日期查询</span></div>
        </div>
    </div>
    <div class="clearfix area">
        <div class="fans area-c block fl">
            <div class="bg"></div>
            <div class="num"><span>123456</span>(个)</div>
            <div class="des">总数<i class="icon red"></i></div>
        </div>
        <div class="money area-c block fl">
            <div class="bg"></div>
            <div class="num"><span>123456</span>(个)</div>
            <div class="des">新增<i class="icon red"></i></div>
        </div>
        <div class="suttle area-c block fl">
            <div class="bg"></div>
            <div class="num"><span>123456</span>(个)</div>
            <div class="des">删除<i class="icon red"></i></div>
        </div>
    </div>

    <div class="chart area block">
        <div id="chart_area" style="height: 300px;"></div>
    </div>
    <div class="tb_list area block">
        <div class="tit"><span>效果明细表</span>
            <div class="btns"><a class="btn" href="#"></a></div>
        </div>
        <table>
            <thead>
            <tr>
                <th>时间</th>
                <th>总数</th>
                <th>新增</th>
                <th>删除</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
<script>
    function zero(s){
        return s < 10 ? '0' + s: s;
    }
    var time1,time2;
    function date(a){
        var date1 = new Date();
        time1=date1.getFullYear()+"-"+(date1.getMonth()+1)+"-"+date1.getDate();
        var date2 = new Date(date1);
        date2.setDate(date1.getDate()-a);
        time2 = date2.getFullYear()+"-"+(date2.getMonth()+1)+"-"+date2.getDate();
    }

    function  cc(a,b) {
        $.get("/Index/effect",{start:a,end:b},function (r) {
            console.log(r);
            /*$(".fans .num span").html(r.total);
            $(".money .num span").html(r.new);
            $(".suttle .num span").html(r.del);
            $(r.data).each(function (i,item) {
                var nowT=new Date(item.time).getTime(),aT=new Date(a).getTime(),bT=new Date(b).getTime();
                if(nowT >= aT && nowT <= bT){
                    var  td1="<tr><td>"+item.time+"</td><td>"+item.total+"</td><td>"+item.new+"</td><td>"+item.del+"</td></tr>";
                    $(".tb_list tbody").html();
                    $(td1).appendTo($(".tb_list tbody"));
                }
            })*/
            $(".tb_list tbody").html("");
            $(r.data).each(function (i,item) {
                var nowT=new Date(item.time).getTime(),aT=new Date(a).getTime(),bT=new Date(b).getTime();
                if(nowT >= aT && nowT <= bT){
                    $(".fans .num span").html(r.total);
                    $(".money .num span").html(r.new);
                    $(".suttle .num span").html(r.del);
                    var td1="<tr><td>"+item.time+"</td><td>"+item.total+"</td><td>"+item.new+"</td><td>"+item.del+"</td></tr>";
                    $(td1).appendTo($(".tb_list tbody"));

                }
            })

        },"json");
    }
    $(".date_sel>span").on("click",function () {
        $(this).addClass("active").siblings().removeClass("active")
        var $this=$(this);
        if($this.hasClass("seven")){
            date(7);

        }else if($this.hasClass("fifteen")){
            date(15);
        }else if($this.hasClass("month")){
            date(30);
        }else{
            date(90);
        }
        $("#from").val(time2);
        $("#to").val(time1);
        cc(time2,time1);
    });
    $(".time_btn").on("click",function () {
        var $from=$("#from").val();
        var $to=$("#to").val();
        console.log($from,$to);
        if($from == ""||$to== ""){
            alert("请选择日期！")
        }else{
            cc($from,$to)
        }
    })
    require.config({
        paths:{
            echarts:"../../../../public/js/chart"
        }
    });
    require([
        'echarts',
        'echarts/chart/line'
    ],function(ec){
        /*cc("2017-01-08","2017-01-12");*/
        date(7);
        cc(time2,time1);

        var json = {
            data:[
                {
                    color:"#fa8003",
                    name:"总数  ",
                    val:["5454","151","46546","5445"]
                },
                {
                    color:"#fa8003",
                    name:"新增 ",
                    val:["6543","8778","37","56"]
                },
                {
                    color:"#fa8003",
                    name:"删除",
                    val:["546","78","897","234"]
                },
            ],
            ele_id:"chart_area",
            x_val:["20161219","20161218","20161217","20161216"]
        }

        set_bothY(json);
        function set_bothY(param){
            var option = {
                title:{show:false,text:"日期",x:"right",y:"top",padding:[20,290,0,0],textStyle:{fontSize:14,color:"#333"}},
                tooltip: {show: true,trigger: 'axis',
                    axisPointer:{//鼠标悬停
                        type: 'line',
                        lineStyle: {
                            color: '#48b',
                            width: 1,
                            type: 'solid'
                        }
                    }
                },//鼠标悬停弹出提示
                legend: {"x":"right","y":"top","padding":[20,75,0,0],
                    "textStyle":{
                        "color":"#000"
                    }
                },//图例
                xAxis : [{type : 'category',data : param.x_val,"splitLine":false,axisTick:{show:false},axisLine:{show:false}}],//X轴数据
                yAxis : [{name:'数量',type : 'value'}],//y轴数据
            };

            var legend_val = [];
            for(var i = 0;i<param['data'].length;i++){
                legend_val.push(param['data'][i]['name']);
            }
            option.legend.data = legend_val;
            option.series = [
                {
                    name:param['data'][0]['name'],
                    type:'line',
                    data:param['data'][0]['val'],
                    yAxisIndex: 0,
                    itemStyle:{
                        normal:{
                            color:param['data'][0]['color']
                        }
                    }
                },
                {
                    name:param['data'][1]['name'],
                    type:'line',
                    yAxisIndex: 0,
                    data:param['data'][1]['val'],
                    itemStyle:{
                        normal:{
                            color:param['data'][1]['color']
                        }
                    }
                },
                {
                    name:param['data'][2]['name'],
                    type:'line',
                    yAxisIndex: 0,
                    data:param['data'][2]['val'],
                    itemStyle:{
                        normal:{
                            color:param['data'][2]['color']
                        }
                    }
                }
            ];

            var user_line = ec.init(document.getElementById(param.ele_id));
            user_line.setOption(option);
            window.onresize = user_line.resize;
        }

    });
    $(function() {

        /* $( "#from" ).datepicker({
         defaultDate: "+1w",
         changeMonth: true,
         numberOfMonths: 1,
         onClose: function( selectedDate ) {
         $( "#to" ).datepicker( "option", "minDate", selectedDate );
         }
         });*/
        $("#from").datepicker({//添加日期选择功能
            numberOfMonths:1,//显示几个月
            showButtonPanel:true,//是否显示按钮面板
            dateFormat: 'yy-mm-dd',//日期格式
            clearText:"清除",//清除日期的按钮名称
            closeText:"关闭",//关闭选择框的按钮名称
            yearSuffix: '年', //年的后缀
            currentText: '今天',
            changeYear:true,//通过select选择年
            //changeMonth:true,
            showMonthAfterYear:true,//是否把月放在年的后面
            // defaultDate:'2011-03-10',//默认日期
            //minDate:'2011-03-05',//最小日期
            // maxDate:'2011-03-20',//最大日期
            monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
            dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
            dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
            dayNamesMin: ['日','一','二','三','四','五','六'],
            // onSelect: function(selectedDate) {//选择日期后执行的操作
            //    alert(selectedDate);
            // }
            onSelect: function( startDate ) {
                var $startDate = $( "#from" );
                var $endDate = $('#to');
                var endDate = $endDate.datepicker( 'getDate' );
                if(endDate < startDate){
                    $endDate.datepicker('setDate', startDate - 3600*1000*24);
                }
                $endDate.datepicker( "option", "minDate", startDate );
            }
        });
        $( "#to" ).datepicker({
            numberOfMonths:1,//显示几个月
            showButtonPanel:true,//是否显示按钮面板
            dateFormat: 'yy-mm-dd',//日期格式
            clearText:"清除",//清除日期的按钮名称
            closeText:"关闭",//关闭选择框的按钮名称
            yearSuffix: '年', //年的后缀
            currentText: '今天',
            changeYear:true,//通过select选择年
            showMonthAfterYear:true,//是否把月放在年的后面
            // defaultDate:'2011-03-10',//默认日期
            //minDate:'2011-03-05',//最小日期
            //maxDate:'2011-03-20',//最大日期
            monthNames: ['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
            dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
            dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
            dayNamesMin: ['日','一','二','三','四','五','六'],
            //onSelect: function(selectedDate) {//选择日期后执行的操作
            //    alert(selectedDate);
            // }
            onSelect: function( endDate ) {
                var $startDate = $( "#from" );
                var $endDate = $('#to');
                var startDate = $startDate.datepicker( "getDate" );
                if(endDate < startDate){
                    $startDate.datepicker('setDate', startDate + 3600*1000*24);
                }
                $startDate.datepicker( "option", "maxDate", endDate );
            }
        });
        //点击今日  自动输入日期
        $.datepicker._gotoToday = function (id) {
            var target = $(id);
            var inst = this._getInst(target[0]);
            if (this._get(inst, 'gotoCurrent') && inst.currentDay) {
                inst.selectedDay = inst.currentDay;
                inst.drawMonth = inst.selectedMonth = inst.currentMonth;
                inst.drawYear = inst.selectedYear = inst.currentYear;
            }
            else {
                var date = new Date();
                inst.selectedDay = date.getDate();
                inst.drawMonth = inst.selectedMonth = date.getMonth();
                inst.drawYear = inst.selectedYear = date.getFullYear();
                this._setDateDatepicker(target, date);
                this._selectDate(id, this._getDateDatepicker(target));
            }
            this._notifyChange(inst);
            this._adjustDate(target);
        }
    });
</script>
</body>
</html>