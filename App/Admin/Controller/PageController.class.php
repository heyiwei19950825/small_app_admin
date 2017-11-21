<?php
namespace Admin\Controller;
use Think\Controller;
class PageController extends PublicController{
	public function adminindex(){	
		//查询用户数据
		// $userData['sum'] = M('user')->count();
		$sql = 'select COUNT(id) AS sum where DateDiff(dd,addtime,getdate())=0';
		$userData['sum'] = M('user')->query($sql);
		var_dump($userData);die;
		$this->display();
	}
}