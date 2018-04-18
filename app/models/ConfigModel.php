<?php

class ConfigModel extends BaseModel
{
	protected $_tbname = 'zm_config';
	protected $_p_k = 'id';

	public function data_by_config($db_config, $fetchStyle = Model::FETCH_ASSOC)
	{
		$statement = 'SELECT `id`,`db_config`,`db_value` FROM `' . $this->_tbname . '` WHERE `db_config`=\'' . $db_config . '\'';
		return $this->fetchOne('', $statement, $fetchStyle);
	}

	public function data_array_config($data, $fetchStyle = Model::FETCH_ASSOC)
	{
		if (empty($data)) {
			return false;
		}

		$statement = 'SELECT `id`,`db_config`,`db_value` FROM `' . $this->_tbname . '` WHERE `db_config` in (\'' . join('\',\'', $data) . '\')';
		$data_array = $this->dquery($statement, $fetchStyle);
		$result = array();

		foreach ($data_array as $k => $v ) {
			$result[$v['db_config']] = $v;
		}

		return $result;
	}

	//modify
	//��ȡ�������ϼ�¼��db_configֵΪzfz_type(ִ������������)��Ӧ��db_valueֵ
	public function getZfzType()
	{
		$statement = 'SELECT db_value FROM ' . $this->_tbname . ' WHERE db_config = \'zfz_type\'';
		$ZfzCfg = $this->fetchOne('', $statement, $fetchStyle);
		return $ZfzCfg['db_value'];
	}

}


?>
