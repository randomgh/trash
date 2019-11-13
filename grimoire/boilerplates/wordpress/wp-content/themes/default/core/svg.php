<?php

class SVG {

	private $id;
	private $path;

	public function __construct($id) {
		$this->id = $id;
	}

	public function __toString() {
        return $this->id ? file_get_contents(get_attached_file($this->id)) : '';
    }

}