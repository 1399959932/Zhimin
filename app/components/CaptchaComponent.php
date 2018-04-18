<?php

class CaptchaComponent
{
	private $width;
	private $height;
	private $length;
	private $bgColor;
	private $fontColor;
	private $fontSize;
	private $dotNoise;
	private $lineNoise;
	private $im;

	public function __construct()
	{
		$this->dotNoise = 20;
		$this->lineNoise = 2;
	}

	public function setLength($length)
	{
		$this->length = $length;
	}

	public function setBgColor($bgColor)
	{
		$this->bgColor = sscanf($bgColor, '#%2x%2x%2x');
	}

	public function setFontColor($fontColor)
	{
		$this->fontColor = sscanf($fontColor, '#%2x%2x%2x');
	}

	public function setDotNoise($num)
	{
		$this->dotNoise = $num;
	}

	public function setLineNoise($num)
	{
		$this->lineNoise = $num;
	}

	private function randString()
	{
		$string = strtoupper(md5(microtime() . mt_rand(0, 9)));
		return substr($string, 0, $this->length);
	}

	private function drawDot()
	{
		for ($i = 0; $i < $this->dotNoise; $i++) {
			$color = imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imagesetpixel($this->im, mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
		}
	}

	private function drawLine()
	{
		for ($i = 0; $i < $this->lineNoise; $i++) {
			$color = imagecolorallocate($this->im, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imageline($this->im, mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), $color);
		}
	}

	public function paint()
	{
		if (empty($this->length)) {
			$this->length = 4;
		}

		$this->width = ($this->length * 12) + 4;
		$this->height = 28;
		$this->fontSize = 16;
		$this->im = imagecreate($this->width, $this->height);
		if (empty($this->bgColor) || empty($this->fontColor)) {
			imagecolorallocate($this->im, mt_rand(0, 130), mt_rand(0, 130), mt_rand(0, 130));
			$randString = $this->randString();

			for ($i = 0; $i < $this->length; $i++) {
				$fontColor = imagecolorallocate($this->im, mt_rand(131, 255), mt_rand(131, 255), mt_rand(131, 255));
				imagestring($this->im, 3, ($i * 10) + 8, mt_rand(0, 8), $randString[$i], $fontColor);
			}
		}
		else {
			imagecolorallocate($this->im, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);
			$randString = $this->randString();
			$fontColor = imagecolorallocate($this->im, $this->fontColor[0], $this->fontColor[1], $this->fontColor[2]);

			for ($i = 0; $i < $this->length; $i++) {
				imagestring($this->im, 3, ($i * 10) + 8, mt_rand(0, 8), $randString[$i], $fontColor);
			}
		}

		$this->drawDot();
		ob_clean();
		header('Content-type:image/jpeg');
		imagepng($this->im);
		imagedestroy($this->im);
		return md5(strtolower($randString));
	}
}


?>
