<?php

class HTMLUtils
{
	static public function single_options($arr, $val_def = '', $val_sel = '')
	{
		$optionsStr = '';

		foreach ($arr as $key => $val ) {
			$optionsStr .= '<option value=\'' . $key . '\'';

			if ($key == $val_sel) {
				$optionsStr .= ' selected';
			}

			$optionsStr .= '>' . ($val != '' ? $val : $val_def) . '</option>' . "\n" . '';
		}

		return $optionsStr;
	}

	static public function options($arr, $key_field = 'id', $val_field = 'name', $val_def = '', $val_sel = '')
	{
		$optionsStr = '';

		foreach ($arr as $option ) {
			$optionsStr .= '<option value=\'' . $option[$key_field] . '\'';

			if ($option[$key_field] == $val_sel) {
				$optionsStr .= ' selected';
			}

			$optionsStr .= '>' . ($option[$val_field] != '' ? $option[$val_field] : $val_def) . '</option>' . "\n" . '';
		}

		return $optionsStr;
	}

	static public function options_stair(&$optionsStr, $arr, $key_field, $val_field, $stair_field = 'child', $val_def = '', $val_sel = '', $fg = '┝ ')
	{
		if (is_array($arr)) {
			foreach ($arr as $option ) {
				$optionsStr .= '<option value=\'' . $option[$key_field] . '\'';

				if ($option[$key_field] == $val_sel) {
					$optionsStr .= ' selected';
				}

				$optionsStr .= '>' . $fg . ($option[$val_field] != '' ? $option[$val_field] : $val_def) . '</option>' . "\n" . '';

				if (isset($option[$stair_field])) {
					self::options_stair($optionsStr, $option[$stair_field], $key_field, $val_field, $stair_field, $val_def, $val_sel, '　' . $fg);
				}
			}
		}
	}

	static public function options_stair_unitpage(&$optionsStr, $arr, $key_field, $val_field, $stair_field = 'child')
	{
		if (is_array($arr)) {
			foreach ($arr as $option ) {
				if (isset($option[$stair_field])) {
					$optionsStr .= '<li class="li_child li_on">';
				}
				else {
					$optionsStr .= '<li>';
				}

				if (isset($option[$stair_field])) {
					$optionsStr .= '  <span></span>';
				}

				$optionsStr .= '  <p class="check_span">';
				$optionsStr .= '    <i></i>';
				$optionsStr .= '    <span>' . $option[$val_field] . '<font color=#0033CC>【'. $option[$key_field] . '】</font></span>';
				$optionsStr .= '    <span class="action_span action_part">';
				$optionsStr .= '      <a class="a_look" href="javascript:sendEdit(\'' . $option[$key_field] . '\')" >查看</a>';
				$optionsStr .= '      <a class="a_del" href="javascript:sendDel(\'' . $option[$key_field] . '\')" class="a_del action_del">删除</a>';
				$optionsStr .= '    </span>';
				$optionsStr .= '  </p>';

				if (isset($option[$stair_field])) {
					$optionsStr .= '<ul>';
					self::options_stair_unitpage($optionsStr, $option[$stair_field], $key_field, $val_field, $stair_field);
					$optionsStr .= '</ul>';
				}
			}
		}
	}

	static public function options_stair_userpage(&$optionsStr, $arr, $key_field, $val_field, $stair_field = 'children')
	{
		if (is_array($arr)) {
			foreach ($arr as $option ) {
				if (!empty($option[$stair_field])) {
					$optionsStr .= '<li class="li_child">';
				}
				else {
					$optionsStr .= '<li>';
				}

				$optionsStr .= '  <span></span>';
				$optionsStr .= '  <p class="check_span">';
				$optionsStr .= '    <input type="checkbox" name="manager_unit[\'' . $option[$key_field] . '\']" class="ipt-hide" id="manager_unit_' . $option[$key_field] . '" value="1" date="' . $option[$key_field] . '">';
				$optionsStr .= '    <label class="checkbox"></label>' . $option[$val_field];
				$optionsStr .= '   </p>';

				if (!empty($option[$stair_field])) {
					$optionsStr .= '<ul>';
					self::options_stair_userpage($optionsStr, $option[$stair_field], $key_field, $val_field, $stair_field);
					$optionsStr .= '</ul>';
				}

				$optionsStr .= '</li>';
			}
		}
	}

	static public function options_stair_unitsearch(&$optionsStr, $arr, $key_field, $val_field, $stair_field = 'child', $deep = 1)
	{
		if (is_array($arr)) {
			foreach ($arr as $option ) {
				$deep_tree = $deep;

				if (isset($option[$stair_field])) {
					$optionsStr .= '<li date="' . $option[$key_field] . '" class="li_child">';
				}
				else {
					$optionsStr .= '<li date="' . $option[$key_field] . '">';
				}

				if (isset($option[$stair_field])) {
					$optionsStr .= '<span></span><font>' . $option[$val_field] . '</font>';
				}
				else {
					$optionsStr .= '<span></span><font>' . $option[$val_field] . '</font>';
				}

				if (isset($option[$stair_field])) {
					$class = 'child_' . $deep_tree;
					$optionsStr .= '<ul class="' . $class . '">';
					self::options_stair_unitsearch($optionsStr, $option[$stair_field], $key_field, $val_field, $stair_field, $deep_tree = $deep_tree + 1);
					$optionsStr .= '</ul>';
				}

				$optionsStr .= '</li>';
			}
		}
	}
}


?>
