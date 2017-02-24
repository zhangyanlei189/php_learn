<?php
namespace Home\Controller;
use Think\Controller;
use Think\Page;
use Think\Upload;
use Think\Image;
class IndexController extends Controller {
    public function index(){
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
		$m = D("fans");

		$evPage = 20;
		$p = $_GET["p"]?((int)$_GET["p"]-1):0;
		$count = $m->where("status=1")->count();
		$Page = new Page($count,$evPage);
		$show = $Page->show();

		$d = $m->where("status=1")->order("time")->limit($Page->firstRow.','.$Page->listRows)->select();
        $data = array();
        foreach ($d as $i){
            $data[] = array("id"=>$i["id"],"name"=>$i["name"],"date"=>date("Y-m-d",$i["time"]));
        }
        $this->assign("indx",$p*$evPage);
        $this->assign('page',$show);
        $this->assign('data',$data);
		$this->display();
	}
	public function del(){
		$id = $_GET["id"];
		$m = M("fans");
        $info = $m->where("id=".$id)->save(array("status"=>2));
        if($info){
            $res["flag"] = true;
            $res["mess"] = "删除成功";
        }else{
            $res["flag"] = false;
            $res["mess"] = "删除失败";
        }
        echo json_encode($res);

	}
	
	public function add(){
		if(isset($_POST)&&!empty($_POST)){
			$data['name'] = $_POST["name"];
			if (empty($data['name'])){
			    echo json_encode(array("flag"=>false,"mess"=>"名称不正确"));
			    die();
            }
			$data['time'] = time();
			$data['status'] = 1;
			$m = M("fans");
			$info = $m->add($data);
			if($info){
				$res["flag"] = true;
				$res["mess"] = "添加成功";
			}else{
                $res["flag"] = false;
                $res["mess"] = "添加失败";
			}
            echo json_encode($res);
		}else{
			$this->display();
		}
	}
	
	public function update(){
		$m = M("fans");
		if(isset($_POST)&&!empty($_POST)){
			$val = $_POST["name"];
			$id = $_POST["id"];
			if($m->create()){
				$info = $m->where("id=".$id)->save(array("name"=>$val));
                if($info){
                    $res["flag"] = true;
                    $res["mess"] = "编辑成功";
                }else{
                    $res["flag"] = false;
                    $res["mess"] = "编辑失败";
                }
                echo json_encode($res);
			}
		}else{
			$id = $_GET["id"];
			$this->d = $m->find($id);
			$this->display();
		}
	}




	//效果统计
    public function effect(){
	    $start = $_GET["start"];
	    $end = $_GET["end"];
	    if (!empty($start)&&!empty($end)){
	        $s = strtotime($start);//转时间戳
	        $e = strtotime($end);
            $m = M();
            //总数
            $sql_all = "select count(*) total from think_fans WHERE date_format(from_unixtime(time),'%Y-%m-%d')>=date_format(from_unixtime(".$s."),'%Y-%m-%d') and date_format(from_unixtime(time),'%Y-%m-%d')<=date_format(from_unixtime(".$e."),'%Y-%m-%d')";
            $all = $m->query($sql_all);
            //新增总数
            $sql_allnew = "select count(*) new from think_fans where status=1 and date_format(from_unixtime(time),'%Y-%m-%d')>=date_format(from_unixtime(".$s."),'%Y-%m-%d') and date_format(from_unixtime(time),'%Y-%m-%d')<=date_format(from_unixtime(".$e."),'%Y-%m-%d')";
            $all_new = $m->query($sql_allnew);
            //不同日期的总数
            $sql_total = "select count(*) num,date_format(from_unixtime(time),'%Y-%m-%d') d from think_fans where date_format(from_unixtime(time),'%Y-%m-%d')>=date_format(from_unixtime(".$s."),'%Y-%m-%d') and date_format(from_unixtime(time),'%Y-%m-%d')<=date_format(from_unixtime(".$e."),'%Y-%m-%d') group by date_format(from_unixtime(time),'%Y-%m-%d')";
            $total = $m->query($sql_total);
            //不同日期的新增数
            $sql_new = "select count(*) num,date_format(from_unixtime(time),'%Y-%m-%d') d from think_fans where date_format(from_unixtime(time),'%Y-%m-%d')>=date_format(from_unixtime(".$s."),'%Y-%m-%d') and date_format(from_unixtime(time),'%Y-%m-%d')<=date_format(from_unixtime(".$e."),'%Y-%m-%d') and status=1 group by date_format(from_unixtime(time),'%Y-%m-%d')";
            $new = $m->query($sql_new);
            $result = array("total"=>$all[0]["total"],"new"=>$all_new[0]["new"],"del"=>(string)($all[0]["total"]-$all_new[0]["new"]));
            foreach ($total as $i){
                $t = $i["num"];
                $n = 0;
                foreach($new as $j){
                    if($i["d"] == $j["d"]){
                       $n = $j["num"];
                    }
                }
                $n = $n?$n:0;
                $result["data"][] = array("total"=>$t,"new"=>$n,"del"=>(string)($t-$n),"time"=>$i["d"]);
            }
            $callback = $_GET['jsoncallback'];
            if (isset($callback)&&!empty($callback)){
                echo $callback."(".json_encode($result).")";
            }else{
                echo json_encode($result);
            }
        }else{
	        $this->display();
        }
    }

    public function upload(){

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      './public/uploads'; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES['photo']);
        var_dump($info);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            echo $info['savepath'].$info['savename'];

            $model = M('Photo');
// 保存当前数据对象
            $data['image'] = $info['savepath'].$info['savename'];
            $data['create_time'] = NOW_TIME;
            $model->add($data);
            header("Content-type:text/html;charset=utf-8");
            echo "<script>alert('上传成功');</script><a href='/Index/showImg'>查看所有图片</a>";
        }
    }


    public function to_upload(){
        $this->display();
    }
    function showImg(){
        $m = M("photo");
        $d = $m->select();
        var_dump($d);
        $this->assign("imgs",$d);
        $this->display();
    }



		
}