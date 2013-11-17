<?php
class interface_adapter {
	var $class_name = null;

	function interface_adapter() {
		$this->class_name = get_class($this);
	}

	function log(){
		echo $this->class_name;
	}
}
