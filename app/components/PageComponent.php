<?php

class PageComponent
{
	private $pageSize;
	private $total;
	private $pageNums;
	private $current_page;
	private $sub_pages;
	private $page_array = array();
	private $page_type;
	private $base_link;
	private $point;

	public function __construct()
	{
	}

	public function show($base_link, $point, $pageSize, $total, $current_page, $sub_pages = 4, $page_type = 1)
	{
		$this->pageSize = intval($pageSize);
		$this->total = intval($total);
		$this->current_page = intval($current_page);

		if ($this->current_page == 0) {
			$this->current_page = 1;
		}

		$this->sub_pages = intval($sub_pages);
		$this->page_type = intval($page_type);
		$this->base_link = $base_link;

		if (!empty($point)) {
			$this->point = (substr($point, 0, 1) == '#' ? $point : '#' . $point);
		}

		$this->pageNums = ceil($this->total / $this->pageSize);
		return $this->show_pages();
	}

	public function show_pages()
	{
		if ($this->page_type == 1) {
			return $this->pageCss1();
		}
		else {
			return $this->pageCss2();
		}
	}

	protected function pageCss1()
	{
		$pageCss1Str = '';

		if (0 < $this->pageNums) {
			if (4 < $this->current_page) {
				$firstPageUrl = $this->base_link . '1' . $this->point;
				$prewPageUrl = $this->base_link . ($this->current_page - 1) . $this->point;
				$pageCss1Str .= '<a href="' . $prewPageUrl . '" class="prev" title="上一页">&nbsp;</a>' . "\n";
			}

			$pages = $this->construct_num_page();

			for ($i = 0; $i < count($pages); $i++) {
				$page = $pages[$i];

				if ($page == $this->current_page) {
					$pageCss1Str .= '<a href="#" class="a_num on">' . $page . '</a>' . "\n";
				}
				else {
					$url = $this->base_link . $page . $this->point;
					$pageCss1Str .= '<a href="' . $url . '" class="a_num">' . $page . '</a>' . "\n";
				}
			}

			$next_page = end($pages);

			if ($next_page < $this->pageNums) {
				$page = $next_page + $this->sub_pages;

				if ($this->pageNums < $page) {
					$page = $this->pageNums;
				}

				$url = $this->base_link . $page . $this->point;
				$pageCss1Str .= '<span>...</span>' . "\n";
			}

			if ($next_page < $this->pageNums) {
				$lastPageUrl = $this->base_link . $this->pageNums . $this->point;
				$nextPageUrl = $this->base_link . ($this->current_page + 1) . $this->point;
				$pageCss1Str .= '<a href="' . $nextPageUrl . '" class="next" title="下一页">&nbsp;</a>' . "\n";
			}

			$pageCss1Str .= '<span>跳至</span><input type="text" name="page_num" value=""';
			$pageCss1Str .= ' onkeypress="if ( event.keyCode==13 && this.value != \'\') location.href=\'' . $this->base_link . '\' + this.value;"';
			$pageCss1Str .= ' >' . "\n";
			$pageCss1Str .= '<span>页</span>' . "\n";
		}
		else {
			$pageCss1Str .= '<span>暂无记录</span>' . "\n";
		}

		$pageCss1Str .= '<span> 共' . $this->pageNums . '页 </span><span>记录数' . $this->total . '条</span>' . "\n";
		return $pageCss1Str;
	}

	protected function pageCss2()
	{
		$pageCss2Str = '';
		return $pageCss2Str;
	}

	public function initArray()
	{
		for ($i = 0; $i < $this->sub_pages; $i++) {
			$this->page_array[$i] = $i;
		}

		return $this->page_array;
	}

	protected function construct_num_page()
	{
		if ($this->pageNums < $this->sub_pages) {
			$current_array = array();

			for ($i = 0; $i < $this->pageNums; $i++) {
				$current_array[$i] = $i + 1;
			}
		}
		else {
			$current_array = $this->initArray();

			if ($this->current_page <= $this->sub_pages) {
				for ($i = 0; $i < count($current_array); $i++) {
					$current_array[$i] = $i + 1;
				}
			}
			else {
				if (($this->current_page <= $this->pageNums) && ((($this->pageNums - $this->sub_pages) + 1) < $this->current_page)) {
					for ($i = 0; $i < count($current_array); $i++) {
						$current_array[$i] = ($this->pageNums - $this->sub_pages) + 1 + $i;
					}
				}
				else {
					for ($i = 0; $i < count($current_array); $i++) {
						$current_array[$i] = ($this->current_page - 2) + $i;
					}
				}
			}
		}

		return $current_array;
	}
}


?>
