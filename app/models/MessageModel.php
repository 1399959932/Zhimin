<?php

class MessageModel extends BaseModel
{
	protected $_tbname = 'zm_message';
	protected $_p_k = 'msgid';

	public function getCount($condition = '')
	{
		$statement = 'SELECT `' . $this->_p_k . '` FROM `' . $this->_tbname . '`';

		if (!empty($condition)) {
			$statement .= ' WHERE ' . $condition;
		}

		$rows = $this->fetchAll('', $statement);
		$this->_rowCount = count($rows);
		return $this->_rowCount;
	}
}


?>
