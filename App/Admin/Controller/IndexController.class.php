<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends PublicController{
	//***********************************
	// iframe式显示菜单和index页
	//**********************************
	public function index(){

		//版权
		$copy=M('web')->where('id=5')->getField('concent');

		$this->assign('copy',$copy);
		$this->display();
	}	
}