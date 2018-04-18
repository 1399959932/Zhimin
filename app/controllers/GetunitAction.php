<?php

class GetunitAction extends Action
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
		write_log('请求单位数据,第' . $page . '页', $flg = '1');
		$unit_m = new UnitModel();
		$sql = 'select `id`,`bh` as `unit_no`,`dname` as `unit_name`,`parentid`,`orderby` from `zm_danwei` order by `parentid` asc,`orderby` asc,`id` asc ' . $limit;
		write_log('请求单位数据,sql【' . $sql . '】', $flg = '1');
		$unit = $unit_m->fetchAll('', $sql);
		$total = count($unit);
		write_log('请求单位数据,此次请求总条数【' . $total . '】', $flg = '1');
		$unit_json = json_encode($unit);
		return_log('success', $total, $unit_json);
	}
}


?>
