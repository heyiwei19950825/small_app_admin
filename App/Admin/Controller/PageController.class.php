<?php
namespace Admin\Controller;
use Think\Controller;
class PageController extends PublicController{

	public function adminindex(){	
		//当天减一天[昨天]
		$time = strtotime(date("Y-m-d",strtotime("-1 day")));

		//查询用户数据
		$userData['sum'] = M('user')->count();
		$userTimeWhere['addtime'] = array('GT',$time);
		//当天注册用户
		$userData['new_sum'] = M('user')->where($userTimeWhere)->count();
		$orderData = M('order')->select();

		// 订单状态0,已取消10未付款20代发货30待收货40待评价50交易完成51交易关闭 52退款中 53 已退款
		$orderNum['0'] = 0;
		$orderNum['10'] = 0;
		$orderNum['20'] = 0;
		$orderNum['30'] = 0;
		$orderNum['40'] = 0;
		$orderNum['50'] = 0;
		$orderNum['51'] = 0;
		$orderNum['52'] = 0;
		$orderNum['53'] = 0;

		//交易金额
		$moneyData['num'] = 0.00;
		$moneyData['new_num'] = 0.00;

		//交易商品数量
		$sellData['num'] = 0;
		$sellData['new_num'] = 0;

		foreach ($orderData as $key => $value) {
			switch ($value['status']) {
				case '0':
					$orderNum['0']++;
					break;
				case '10':
					$orderNum['10']++;
					break;
				case '20':
					$orderNum['20']++;
					break;
				case '30':
					$orderNum['30']++;
					break;
				case '40':
					$orderNum['40']++;
					break;
				case '50':
					$orderNum['50']++;
					// var_dump($value);die;
					//统计资金统计
					$moneyData['num'] = $moneyData['num'] + $value['price_h'];
					//销售数量统计 
					$sellData['num'] = $value['product_num'] + $sellData['num'];
					if($value['addtime'] > $time){
						$sellData['new_num'] = $value['product_num'] + $sellData['new_num'];
						$moneyData['new_num'] = $moneyData['new_num'] + $value['price_h'];
					}
					break;
				case '51':
					$orderNum['51']++;
					break;
				default:
					$orderNum['0']++;
					break;
			}
			//统计退款
			if($value['back'] == 1){
				$orderNum['52']++;
			}elseif($value['back'] == 2){
				$orderNum['53']++;
			}
			
		}
		$this->assign('userData',$userData);
		$this->assign('orderData',$orderNum);
		$this->assign('moneyData',$moneyData);
		$this->assign('sellData',$sellData);
		$this->display();
	}
}