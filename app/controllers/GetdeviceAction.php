<?php

class GetdeviceAction extends Action
{
	public $lines = 50;

	public function __construct()
	{
		$this->_hasView = 0;
	}

	protected function _main()
	{
		$page = trim(Zhimin::request('page'));
		(!is_numeric($page) || ($page < 1)) && ($page = 1);
		$start = ($page - 1) * $this->lines;
		$limit = ' LIMIT ' . $start . ',' . $this->lines;
		write_log('请求设备数据,第' . $page . '页', $flg = '1');
		$unit_m = new UnitModel();
		$sql = 'select `id`,`hostname`,`hostcode`,`hostbody`,`danwei` as `unit_no`,`state` from `zm_device` order by `danwei` asc,`id` desc ' . $limit;
		write_log('请求设备数据,sql【' . $sql . '】', $flg = '1');
		$unit = $unit_m->fetchAll('', $sql);
		$total = count($unit);
		write_log('请求设备数据,此次请求总条数【' . $total . '】', $flg = '1');
		$unit_json = json_encode($unit);
		return_log('success', $total, $unit_json);
	}
}


?>
