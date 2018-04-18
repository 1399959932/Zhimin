<?php

class TopAction extends Action
{
	protected $url_base = '';

	public function init()
	{
		$this->layout('');
		return $this;
	}

	protected function _main()
	{
		$user_m = new UserModel();
		$unit_m = new UnitModel();
		$unitbyuser = $unit_m->get_by_sn($_SESSION['unitcode']);
		$data['unit_name'] = ($unitbyuser['dname'] == '' ? $_SESSION['unitcode'] : $unitbyuser['dname']);
		$data['groupname'] = $_SESSION['groupname'];
		$data['realname'] = ($_SESSION['realname'] == '' ? $_SESSION['username'] : $_SESSION['realname']);
		$settings = Zhimin::a()->getData('settings');
		$data['title'] = $settings['site'];
		if (($settings['main_file_logo'] != '') && file_exists(Zhimin::g('document_root') . 'upload/zm_config/' . $settings['main_file_logo'])) {
			$data['logo'] = Zhimin::g('assets_uri') . 'upload/zm_config/' . $settings['main_file_logo'];
		}
		else {
			$data['logo'] = 'images/logo/login_file_logo_' . Zhimin::g('rowcustertype') . '.png';
		}

		$data['message_count'] = 0;
		if (isset($_SESSION['username']) && ($_SESSION['username'] != '')) {
			$message_m = new MessageModel();
			$message_count = intval($message_m->getCount('tousername=\'' . $_SESSION['username'] . '\'  and is_new=1'));
			$data['message_count'] = $message_count;
		}

		$this->_data['data'] = $data;
	}
}


?>
