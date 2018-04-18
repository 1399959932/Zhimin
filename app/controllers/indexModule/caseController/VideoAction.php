<?php

class VideoAction extends Action
{
	protected $units = array();
	protected $module_sn = '10031';
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	public function _main()
	{
		$action = Zhimin::param('action', 'get');
		$this->url_base = Zhimin::buildUrl() . '&action=' . $action;
		$auth = Zhimin::getComponent('auth');
		$user_auth = array('view' => 0, 'add' => 0, 'edit' => 0, 'del' => 0, 'ok' => 0);

		if ($auth->checkPermitView($this->module_sn)) {
			$user_auth['view'] = 1;
		}

		if ($auth->checkPermitAdd($this->module_sn)) {
			$user_auth['add'] = 1;
		}

		if ($auth->checkPermitEdit($this->module_sn)) {
			$user_auth['edit'] = 1;
		}

		if ($auth->checkPermitDel($this->module_sn)) {
			$user_auth['del'] = 1;
		}

		if ($auth->checkPermitOk($this->module_sn)) {
			$user_auth['ok'] = 1;
		}

		$this->_data['user_auth'] = $user_auth;
		$casetaxon_m = new CasetaxonModel();
		$casetaxons = $casetaxon_m->readAll();
		$this->_data['casetaxons'] = $casetaxons;

		switch ($action) {
		case 'edit':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveEdit();
			}
			else {
				$this->edit();
			}

			break;

		case 'add':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->saveAdd();
			}
			else {
				$this->add();
			}

			break;

		case 'del':
			if (!is_null(Zhimin::request('saveflag'))) {
				$this->savedel();
			}
			else {
				$this->del();
			}

			break;

		case 'nextsn':
			$this->getNextSn();
			break;

		case 'videolist':
			$this->videolist();
			break;

		case 'search':
			$this->search();
			break;

		default:
			$this->mlist();
			break;
		}
	}

	protected function mlist()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitView($this->module_sn)) {
			$this->_hasError = true;
			$this->_error[0] = 'error.info';
			$this->_error[1] = array('message' => '您没有浏览此模块的权限！', 'url' => Zhimin::buildUrl('main', 'index'));
			return;
		}

		$lines = Zhimin::param('lines', 'get');
		$page = Zhimin::param('page', 'get');
		$casetopic_m = new CasetopicModel();
		$casetaxon_m = new CasetaxonModel();
		$unit_m = new UnitModel();
		$where = '1=1';
		$sql = 'SELECT COUNT(*) as count FROM `' . $casetopic_m->table() . '` cp WHERE ' . $where;
		$rs = $casetopic_m->dquery($sql);
		$count = $rs[0]['count'];

		if ($count == 0) {
		}
		else {
			if (!is_numeric($lines)) {
				$lines = 24;
			}

			(!is_numeric($page) || ($page < 1)) && ($page = 1);
			$pageNums = ceil($count / $lines);
			if ($pageNums && ($pageNums < $page)) {
				$page = $pageNums;
			}

			$start = ($page - 1) * $lines;
			$limit = 'LIMIT ' . $start . ',' . $lines;
			$sql = 'SELECT pcp.*, pct.gname as casetaxon_name, pd.dname as unitname FROM `' . $casetopic_m->table() . '` pcp ';
			$sql .= ' LEFT JOIN `' . $casetaxon_m->table() . '` pct ON pct.bh=pcp.casetaxon';
			$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pcp.danwei';
			$sql .= ' WHERE ' . $where . ' order by pcp.createtime desc ' . $limit;
			$casetopics = $casetopic_m->dquery($sql);
			$this->_data['datas'] = $casetopics;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function search()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitQuery($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}

		$not_found = false;
		$bfilename = Zhimin::request('bfilename');
		$hostname = Zhimin::request('hostname');
		$hostcode = Zhimin::request('hostcode');
		$hostbody = Zhimin::request('hostbody');
		$danwei = Zhimin::request('danwei');
		$casetaxon = Zhimin::request('casetaxon');
		$subject = Zhimin::request('subject');
		$creater = Zhimin::request('creater');
		$start_date = Zhimin::request('start_date');
		$end_date = Zhimin::request('end_date');
		$casetopic_m = new CasetopicModel();
		$casetaxon_m = new CasetaxonModel();
		$media_m = new MediaModel();
		$unit_m = new UnitModel();
		$where = '1=1';
		$media_join = array();

		if ($bfilename != '') {
			$media_join[] = ' pvl.bfilename like \'%' . $bfilename . '%\'';
		}

		if ($hostname != '') {
			$media_join[] = ' pvl.hostname like \'%' . $hostname . '%\'';
		}

		if ($hostcode != '') {
			$media_join[] = ' pvl.hostcode   like \'%' . $hostcode . '%\'';
		}

		if ($hostbody != '') {
			$media_join[] = ' pvl.hostbody  like  \'%' . $hostbody . '%\'';
		}

		if (!empty($media_join)) {
			$sql = ' SELECT DISTINCT(casetopic) FROM `' . $media_m->table() . '` pvl WHERE ' . join(' and ', $media_join);
			$medias = $media_m->fetchAll('', $sql);

			if (!empty($medias)) {
				$mcasetopics = array();

				foreach ($medias as $data ) {
					if (empty($data['casetopic'])) {
						continue;
					}

					$mcasetopics[] = $data['casetopic'];
				}
			}
			else {
				$not_found = true;
			}

			$where .= ' and pcp.sn in (\'' . join('\',\'', $mcasetopics) . '\')';
		}

		if (!empty($casetaxon)) {
			$where .= ' and pcp.casetaxon= \'' . $casetaxon . '\'';
		}

		if (!empty($danwei)) {
			$units = array();
			$unit_m->get_subs_by_sn($units, $danwei);
			$where .= ' and pcp.danwei in(\'' . join('\',\'', array_keys($units)) . '\')';
		}

		if ($subject != '') {
			$where .= ' and pcp.subject  like  \'%' . $subject . '%\'';
		}

		if (!empty($creater)) {
			$where .= ' and pcp.creater= \'' . $creater . '\'';
		}

		if (($start_date != '') && ($end_date != '')) {
			if (isset($start_date)) {
				$start_date = $start_date . ' 00:00:00';
			}

			if (isset($end_date)) {
				$end_date = $end_date . ' 23:59:59';
			}

			$where .= ' and pcp.createtime between \'' . strtotime($start_date) . '\' and  \'' . strtotime($end_date) . '\' ';
		}

		$sql = 'SELECT COUNT(*) as count FROM `' . $casetopic_m->table() . '` pcp ';
		$sql .= ' WHERE ' . $where;
		$rs = $casetopic_m->dquery($sql);
		$count = $rs[0]['count'];

		if ($count == 0) {
		}
		else {
			if (!is_numeric($lines)) {
				$lines = 24;
			}

			(!is_numeric($page) || ($page < 1)) && ($page = 1);
			$pageNums = ceil($count / $lines);
			if ($pageNums && ($pageNums < $page)) {
				$page = $pageNums;
			}

			$start = ($page - 1) * $lines;
			$limit = 'LIMIT ' . $start . ',' . $lines;
			$sql = 'SELECT pcp.*, pct.gname as casetaxon_name, pd.dname as unitname FROM `' . $casetopic_m->table() . '` pcp ';
			$sql .= ' LEFT JOIN `' . $casetaxon_m->table() . '` pct ON pct.bh=pcp.casetaxon';
			$sql .= ' LEFT JOIN `' . $unit_m->table() . '` pd ON pd.bh=pcp.danwei ';
			$sql .= ' WHERE ' . $where . ' order by pcp.createtime desc ' . $limit;
			$casetopics = $casetopic_m->dquery($sql);
			$this->_data['datas'] = $casetopics;
			$this->_data['page'] = array('total' => $count, 'page' => $page, 'pages' => $pageNums, 'lines' => $lines, 'base_url' => $this->url_base);
		}
	}

	protected function add()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}
	}

	protected function saveAdd()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitAdd($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}

		$casetopic_m = new CasetopicModel();
		$media_m = new MediaModel();
		$pnumber = Zhimin::request('pnumber');
		$title = Zhimin::request('ptitle');
		$danwei = Zhimin::request('danwei');
		$casetaxon = Zhimin::request('casetaxon');
		$subject = Zhimin::request('subject');
		$note = Zhimin::request('note');
		$medias = Zhimin::request('medias');
		$loginuser = $_SESSION['username'];
		$sn = $casetopic_m->get_next_sn($danwei);
		$casetopicsn = $sn;
		$casetopic_m->insertRow(array('sn' => $casetopicsn, 'danwei' => $danwei, 'pnumber' => $pnumber, 'casetaxon' => $casetaxon, 'title' => $title, 'note' => $note, 'subject' => $subject, 'note' => $note, 'creater' => $loginuser, 'createtime' => time()));

		if (!empty($medias)) {
			$media_m->updateRow('id in (\'' . join('\',\'', $medias) . '\')', array('casetopic' => $casetopicsn));
		}

		$log_m = new LogModel();
		$log_m->writeLog('添加案件专题,编号为:' . $casetopicsn);
		echo '<script language="javascript">alert("添加修改案件专题!");location.href=\'' . Zhimin::buildUrl() . '\';</script>';
		exit();
	}

	protected function edit()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}

		$casetopic_m = new CasetopicModel();
		$media_m = new MediaModel();
		$id = intval(Zhimin::request('id'));
		$casetopic = $casetopic_m->read($id);
		$media_sql = 'select pvl.id, pvl.bfilename, pvl.filetype, pvl.filelen,pvl.thumb from `' . $media_m->table() . '` pvl where pvl.casetopic=\'' . $casetopic['sn'] . '\'';
		$medias = $media_m->fetchAll('', $media_sql);
		$casetopic['medias'] = $medias;
		$this->_data['data'] = $casetopic;
	}

	protected function saveEdit()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitEdit($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}

		$casetopic_m = new CasetopicModel();
		$media_m = new MediaModel();
		$id = intval(Zhimin::request('id'));
		$pnumber = Zhimin::request('pnumber');
		$title = Zhimin::request('title');
		$casetaxon = Zhimin::request('casetaxon');
		$subject = Zhimin::request('subject');
		$note = Zhimin::request('note');
		$medias = Zhimin::request('medias');
		$loginuser = $_SESSION['username'];

		if ($id <= 0) {
			echo '<script language=\'javascript\'>alert(\'提交了非法的参数\');history.back(-1);</script>';
			exit();
		}

		if ($id) {
			$casetopic = $casetopic_m->read($id);

			if (empty($casetopic)) {
				echo '<script language=\'javascript\'>alert(\'非法操作！\');history.back(-1);</script>';
				exit();
			}

			$casetopicsn = $casetopic['sn'];
			$casetopic_m->updateRow('id=' . $id, array('pnumber' => $pnumber, 'casetaxon' => $casetaxon, 'title' => $title, 'note' => $note, 'subject' => $subject, 'note' => $note, 'moder' => $loginuser, 'modtime' => time()));
			$media_m->updateRow('casetopic=\'' . $casetopicsn . '\'', array('casetopic' => ''));

			if (!empty($medias)) {
				$media_m->updateRow('id in (\'' . join('\',\'', $medias) . '\')', array('casetopic' => $casetopicsn));
			}

			$log_m = new LogModel();
			$log_m->writeLog('修改案件专题,编号为:' . $casetopicsn);
			echo '<script language="javascript">alert("成功修改案件专题!");location.href=\'' . Zhimin::buildUrl() . '\';</script>';
			exit();
		}
		else {
			echo '<script language=\'javascript\'>alert(\'参数错误\');history.back(-1);</script>';
			exit();
		}
	}

	protected function del()
	{
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitDel($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}

		$casetopic_m = new CasetopicModel();
		$media_m = new MediaModel();
		$id = intval(Zhimin::request('id'));

		if ($id <= 0) {
			echo '<script language=\'javascript\'>alert(\'提交了非法的参数\');history.back(-1);</script>';
			exit();
		}

		if ($id) {
			$casetopic = $casetopic_m->read($id);

			if (empty($casetopic)) {
				echo '<script language=\'javascript\'>alert(\'该案件专题已被删除，请返回！\');history.back(-1);</script>';
				exit();
			}

			$casetopicsn = $casetopic['sn'];
			$media_m->updateRow('casetopic=\'' . $casetopicsn . '\'', array('casetopic' => ''));
			$casetopic_m->deleteRow('id=\'' . $id . '\'');
			$log_m = new LogModel();
			$log_m->writeLog('删除案件专题,编号为:' . $casetopicsn);
			echo '<script language="javascript">alert("成功删除案件专题!");location.href=\'' . Zhimin::buildUrl() . '\';</script>';
			exit();
		}
		else {
			echo '<script language=\'javascript\'>alert(\'参数错误\');history.back(-1);</script>';
			exit();
		}
	}

	protected function getNextSn()
	{
		$this->_hasView = false;
		$danwei = Zhimin::request('danwei');

		if (empty($danwei)) {
			exit();
		}

		$casetopic_m = new CasetopicModel();
		echo $casetopic_m->get_next_sn($danwei);
	}

	protected function videolist()
	{
		$this->_hasView = false;
		$auth = Zhimin::getComponent('auth');

		if (!$auth->checkPermitQuery($this->module_sn)) {
			echo '<script>alert(\'对不起，您所在的用户组没有权限，请返回\');history.back(-1);</script>';
			exit();
		}

		$media_m = new MediaModel();
		$unit_m = new UnitModel();
		$danwei = Zhimin::request('danwei');
		$resultType = addslashes(Zhimin::request('resultType'));
		$maxRows = intval(Zhimin::request('maxRows'));
		$startsWith = addslashes(Zhimin::request('startsWith'));
		$callback = Zhimin::request('callback');
		$where = ' (pvl.casetopic is null or pvl.casetopic = \'\')';
		$units = array();
		$unit_m->get_subs_by_sn($units, $danwei);
		$where .= ' and pvl.danwei in(\'' . join('\',\'', array_keys($units)) . '\')';
		$where .= ' and pvl.bfilename like \'' . $startsWith . '%\'';
		$limit = ' limit 0, ' . $maxRows;
		$sql = 'Select pvl.id, pvl.bfilename, pvl.filetype, pvl.filelen,pvl.thumb from `' . $media_m->table() . '` pvl';
		$sql .= ' where ' . $where . ' order by pvl.createdate ' . $limit;
		$medias = $media_m->fetchAll('', $sql);
		$datas = array('totals' => count($medias), 'datas' => $medias);
		echo $callback . '(';
		echo json_encode($datas);
		echo ')';
	}
}


?>
