<?php

class AuthComponent
{
	protected $view_f = 'view_f';
	protected $play_f = 'play_f';
	protected $query_f = 'query_f';
	protected $down_f = 'down_f';
	protected $add_f = 'add_f';
	protected $edit_f = 'edit_f';
	protected $del_f = 'del_f';
	protected $ok_f = 'ok_f';
	protected $all_f = 'all_v';
	protected $all_v = 1;
	protected $backdoor_f = 'backdoor_v';
	protected $backdoor_v = 1;
	static 	protected $permit_value = array('view_f' => 1, 'play_f' => 2, 'query_f' => 4, 'down_f' => 8, 'add_f' => 16, 'edit_f' => 32, 'del_f' => 64, 'ok_f' => 128);
	static 	protected $permit_name = array(1 => '浏览', 2 => '播放', 4 => '查找', 8 => '下载', 16 => '添加', 32 => '编辑', 64 => '删除', 128 => '管理范围');

	public function __construct($params)
	{
	}

	static public function getPermitVal($index)
	{
		if (is_string($index) && isset(self::$permit_value[$index])) {
			return self::$permit_value[$index];
		}
	}

	static public function getPermitName($index)
	{
		if (isset(self::$permit_name[$index])) {
			return self::$permit_name[$index];
		}
	}

	public function checkLogin()
	{
		if (isset($_SESSION['ishight']) && ($_SESSION['ishight'] == 1)) {
			return 1;
		}

		if (isset($_SESSION['username']) && isset($_SESSION['userid'])) {
			return 1;
		}
		else {
			return 0;
		}
	}

	public function isSuperAdmin()
	{
		if (isset($_SESSION['level']) && ($_SESSION['level'] == 1)) {
			return true;
		}

		return false;
	}

	public function isLogin()
	{
		if (isset($_SESSION['ishight']) && ($_SESSION['ishight'] == 1)) {
			return true;
		}

		if (!isset($_SESSION['username']) || !isset($_SESSION['groupid']) || (@$_SESSION['username'] == '') || (@$_SESSION['groupid'] == '')) {
			return false;
		}

		return true;
	}

	public function checkIndexPurview($dotype, $done)
	{
		if (!$this->isLogin()) {
			echo '<script>alert(\'你未登录，请先登录再进行后续操作\');top.location.href=\'' . Zhimin::buildUrl('login', 'index', 'index') . '\';</script>';
			exit();
		}

		if ($this->isSuperAdmin()) {
			return true;
		}

		$group_m = new GroupModel();
		$d_row = $group_m->get_by_sn($_SESSION['groupid']);

		if ($this->getPermitVal($done) & $d_row[$dotype]) {
			return true;
		}
		else {
			return false;
		}
	}

	public function canViewStair()
	{
		return $this->checkIndexPurview('qx_only', $this->view_f);
	}

	public function hasBackgroundPermit()
	{
		if (!$this->isLogin()) {
			echo '<script>alert(\'你未登录，请先登录再进行后续操作\');top.location.href=\'' . Zhimin::buildUrl('login', 'index', 'index') . '\';</script>';
			exit();
		}

		if ($this->isSuperAdmin()) {
			return true;
		}

		$group_m = new GroupModel();
		$group = $group_m->get_by_sn($_SESSION['groupid']);

		if ($group['qx_backdoor'] != 1) {
			return false;
		}

		return true;
	}

	private function checkPermitBefore($bh)
	{
		$module_m = new ModuleModel();
		$module = $module_m->read($bh, 'note');

		if (empty($module)) {
			return false;
		}

		return $module['note'];
	}

	public function checkPermitView($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, $this->view_f)) {
			return true;
		}

		return false;
	}

	public function checkPermitEdit($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, $this->edit_f)) {
			return true;
		}

		return false;
	}

	public function checkPermitAdd($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, $this->add_f)) {
			return true;
		}

		return false;
	}

	public function checkPermitDel($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, $this->del_f)) {
			return true;
		}

		return false;
	}

	public function checkPermitQuery($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, $this->query_f)) {
			return true;
		}

		return false;
	}

	public function checkPermitPlay($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, $this->play_f)) {
			return true;
		}

		return false;
	}

	public function checkPermitDown($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, $this->down_f)) {
			return true;
		}

		return false;
	}

	public function checkPermitOk($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, $this->ok_f)) {
			return true;
		}

		return false;
	}

	public function checkPermitAll($bh)
	{
		if (($note = $this->checkPermitBefore($bh)) === false) {
			return false;
		}

		if ($this->checkPermit($note, 'all')) {
			return true;
		}

		return false;
	}

	private function checkPermit($note, $done)
	{
		if (!$this->isLogin()) {
			echo '<script>alert(\'你未登录，请先登录再进行后续操作\');top.location.href=\'' . Zhimin::buildUrl('login', 'index', 'index') . '\';</script>';
			exit();
		}

		if ($this->isSuperAdmin()) {
			return true;
		}

		$group_m = new GroupModel();
		$d_row = $group_m->get_by_sn($_SESSION['groupid']);

		if (empty($d_row)) {
			return false;
		}

		if ($done == 'all') {
			if ($d_row[$note] == 0) {
				return false;
			}

			return true;
		}
		else {
			if ($this->getPermitVal($done) & $d_row[$note]) {
				return true;
			}

			return false;
		}
	}

	public function checkValView($permit)
	{
		return $this->checkVal($this->view_f, $permit);
	}

	public function checkValEdit($permit)
	{
		return $this->checkVal($this->edit_f, $permit);
	}

	public function checkValAdd($permit)
	{
		return $this->checkVal($this->add_f, $permit);
	}

	public function checkValDel($permit)
	{
		return $this->checkVal($this->del_f, $permit);
	}

	public function checkValQuery($permit)
	{
		return $this->checkVal($this->query_f, $permit);
	}

	public function checkValPlay($permit)
	{
		return $this->checkVal($this->play_f, $permit);
	}

	public function checkValDown($permit)
	{
		return $this->checkVal($this->down_f, $permit);
	}

	public function checkValOk($permit)
	{
		return $this->checkVal($this->ok_f, $permit);
	}

	public function checkValAll($permit)
	{
		$val = $this->all_v;

		if ($val & $permit) {
			return true;
		}

		return false;
	}

	public function checkValBackdoor($permit)
	{
		$val = $this->backdoor_v;

		if ($val & $permit) {
			return true;
		}

		return false;
	}

	public function checkValStair($permit)
	{
		$val = 1;

		if ($val & $permit) {
			return true;
		}

		return false;
	}

	private function checkVal($type, $permit)
	{
		if ($type == 'all') {
			if ($permit != 0) {
				return true;
			}

			return false;
		}

		$val = $this->getPermitVal($type);

		if ($val & $permit) {
			return true;
		}

		return false;
	}

	public function getQueryName()
	{
		$val = $this->getQueryVal();
		return $this->getPermitName($val);
	}

	public function getQueryVal()
	{
		return $this->getPermitVal($this->query_f);
	}

	public function getViewName()
	{
		$val = $this->getViewVal();
		return $this->getPermitName($val);
	}

	public function getViewVal()
	{
		return $this->getPermitVal($this->view_f);
	}

	public function getAddName()
	{
		$val = $this->getAddVal();
		return $this->getPermitName($val);
	}

	public function getAddVal()
	{
		return $this->getPermitVal($this->add_f);
	}

	public function getEditName()
	{
		$val = $this->getEditVal();
		return $this->getPermitName($val);
	}

	public function getEditVal()
	{
		return $this->getPermitVal($this->edit_f);
	}

	public function getDelName()
	{
		$val = $this->getDelVal();
		return $this->getPermitName($val);
	}

	public function getDelVal()
	{
		return $this->getPermitVal($this->del_f);
	}

	public function getPlayName()
	{
		$val = $this->getPlayVal();
		return $this->getPermitName($val);
	}

	public function getPlayVal()
	{
		return $this->getPermitVal($this->play_f);
	}

	public function getDownName()
	{
		$val = $this->getDownVal();
		return $this->getPermitName($val);
	}

	public function getDownVal()
	{
		return $this->getPermitVal($this->down_f);
	}

	public function getOkName()
	{
		$val = $this->getOkVal();
		return $this->getPermitName($val);
	}

	public function getOkVal()
	{
		return $this->getPermitVal($this->ok_f);
	}
}


?>
