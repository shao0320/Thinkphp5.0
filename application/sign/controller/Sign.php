<?php 
	namespace app\Sign\controller;

	use think\Controller;
	use think\Request;
	use think\Db;

	class Sign extends Controller
	{
		/*
		*签到接口
		*user_id  ini  用户的id
		*
		*/
		public function kk(Request $request){
			//接受所有传递的参数
			$params = $request -> param();

			//接口返回的格式
			$return = [
				'code' => 2000,
				'msg' => '成功',
				'data' => []
			];

			if(!isset($params['user_id']) || empty($params['user_id'])){
				$return = [
					'code' => 4001,
					'msg' =>'用户id不能为空'
				];
				return json($return);
			}

			$user_id = $params['user_id'];

			$total_days =date("Y-m-d");

			$data = Db::query('select * from lx3_user where user_id =?',[$user_id]);
			// dump($data);die;
			//重复签到
			if(!empty($data) && $data[0]['last_date'] == $total_days){
				$return =[
					'code' => 4002,
					'msg' => '今天已签到，请明天再来'
				];

				return json($return);
			}
			// die;
			//第一次签到的时候
			if(empty($data)){
				Db::query('insert into lx3_user (user_id,c_days,total_scores,total_days,last_date)
					values(?,?,?,?,?)',[$user_id,1,1,1,$total_days]);
				
				$return['data']['score']=1;

				return json($return);
			}else{
				//昨天的日期
				$last_days = date("Y-m-d",time()-3600*24);
				//dump($last_day);die;
				if($last_days == $data[0]['last_date']){//连续签到
					//连续签到的天数

					$c_days = $data[0]['c_days']+1;

				}else{
					$c_days=1;
				}

				$total_scores = $data[0]['total_scores'] + $c_days;

				$total_days2 = $data[0]['total_days'] + 1;

				Db::query('update lx3_user set c_days =?,total_scores=?,total_days = ?
					,last_date= ? where user_id =?',[$c_days,$total_scores,$total_days2,$total_days,$user_id]);

				$return['date']['score'] = $c_days;

				return json($return);
			}
		}



		//签名的列表
		public function getList(){

			$sign = Db::query("select * from sign_info");

			$return = [
				'code' => 2000,
				'msg' => '签到成功',
				'data' => $sign
			];

			return json($return);
		}





























	}



 ?>