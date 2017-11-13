<?php
// 本类由系统自动生成，仅供测试用途
namespace Api\Controller;
use Think\Controller;
class CategoryController extends PublicController {
	//***************************
	// 产品分类
	//***************************
    public function index(){
    	$list = M('category')->where('tid=1')->field('id,tid,name')->select();
        $catList = M('category')->where('tid='.intval($list[0]['id']))->field('id,name,bz_1')->select();
        foreach ($catList as $k => $v) {
            $catList[$k]['bz_1'] = __DATAURL__.$v['bz_1'];
        }
        //父分类数据
        $cateInfo = M('category')->where('id='.intval($list[0]['id']))->field('id,name,bz_1')->find();
        $cateInfo['bz_1'] = __DATAURL__.$cateInfo['bz_1'];

    	//json加密输出
		//dump($json);
		echo json_encode(array('status'=>1,'list'=>$list,'catList'=>$catList,'cateInfo'=>$cateInfo));
        exit();
    }

    //***************************
    // 产品分类
    //***************************
    public function getcat(){
        $catid = intval($_REQUEST['cat_id']);
        if (!$catid) {
            echo json_encode(array('status'=>0,'err'=>'没有找到产品数据.'));
            exit();
        }
        //父分类数据
        $cateInfo = M('category')->where('id='.intval($catid))->field('id,name,bz_1')->find();
        $cateInfo['bz_1'] = __DATAURL__.$cateInfo['bz_1'];

        //父分类下的子分类数据
        $catList = M('category')->where('tid='.intval($catid))->field('id,name,bz_1')->select();
        foreach ($catList as $k => $v) {
            $catList[$k]['bz_1'] = __DATAURL__.$v['bz_1'];
        }

        //json加密输出
        //dump($json);
        echo json_encode(array('status'=>1,'catList'=>$catList,'cateInfo'=>$cateInfo));
        exit();
    }

}