<?php
/**********************************************************************
*  Created:  2010-12-6
*
*  xwbdebug调试类
*
*  @Xweibo (C)1996-2099 SINA Inc.
*  @Author liwen <liwen2@staff.sina.com.cn>
*
**********************************************************************/

class xwbDebugCtrl {
    var $dbg_Enabled;

	var $type				= array('api', 'sql', 'cache');
    var $dbg_Show_default 	= '';
    var $DivSets			= array();
    function __construct(){

		foreach($this->type as $value) {
			$this->$value = array();
		}

		$this->DivSets[0] = "<tr><td style='cursor:hand;' onclick=\"javascript:if (document.getElementById('data#sectname#').style.display=='none'){document.getElementById('data#sectname#').style.display='block';}else{document.getElementById('data#sectname#').style.display='none';}\"><div id=sect#sectname# style=\"font-weight:bold;cursor:hand;background:#7EA5D7;color:white;padding-left:4;padding-right:4;padding-bottom:2;\">|#title#| <div id=data#sectname# style=\"cursor:text;display:none;background:#FFFFFF;padding-left:8;\" onclick=\"close(event);\">|#data#| </div>|</div>|";
		$this->DivSets[1] = "<tr><td><div id=sect#sectname# style=\"font-weight:bold;cursor:hand;background:#7EA5D7;color:white;padding-left:4;padding-right:4;padding-bottom:2;\" onclick=\"javascript:if (document.getElementById('data#sectname#').style.display=='none'){document.getElementById('data#sectname#').style.display='block';}else{document.getElementById('data#sectname#').style.display='none';}\">|#title#| <div id=data#sectname# style=\"cursor:text;display:block;background:#FFFFFF;padding-left:8;\" onclick=\"close(event);\">|#data#| </div>|</div>|";
		$this->dbg_Show_default = "0,0";

	}

	/*
	 * 调试数据输入
	 * @param array $out	需要调试的数据
	 * @param string $type	数据类型
	 */
	function out($out, $type) {
		if(in_array($type, $this->type)) {
			$this->{$type}[] = $out;
		}
	}

	/*
	 * 调试结果输出
	 */
	function display() {
		if($this->dbg_Enabled) {		//debug 输出
			$this->DivSet = split(",",$this->dbg_Show_default) ;
			echo "<table width=100% cellspacing=0 border=0 style=\"font-family:arial;font-size:9pt;font-weight:normal;\"><tr><td><div style=\"background:#005A9E;color:white;padding:4;font-size:12pt;font-weight:bold;\">xwbDebug-控制器:</div>";
			echo "<script>function close(event){event.cancelBubble = true;}</script>";
			foreach($this->type as $value) {
				if($this->$value) {
					$this->_printCollection($value, $this->$value, $this->DivSet[1], ""); 	//$api 是调试获取的值
				}else{
					$this->_printCollection($value, array(), $this->DivSet[1], ""); 	//$api 是调试获取的值
				}
			}
			echo "</table>";
		}
	}

	//addrow
	function _addRow($t,$vars,$val) {
		$t .="|<tr valign=top>|<td>|".$vars."|<td>= ".$val."|</tr>";
		return $t;
	}

	function _makeTable($tdata) {
		$tdata = "|<table border=0 style=\"font-size:10pt;font-weight:normal;\">" . $tdata . "</table>|" ;
		return $tdata;
	}

	function _printCollection($Name,$v,$DivSetNo,$ExtraInfo){
		foreach($v as $Collection) {
			foreach($Collection as $key => $val) {
				if(is_array($val) || is_object($val)) {
					$val = json_encode($val);
				}
				$tbl = $this->_addRow($tbl,$key,$val);
			}
			$tbl .= "|<tr valign=top><td><br /></td></tr>|<tr valign=top><td><br /></td></tr>|";
		}

		$tbl = $this->_makeTable($tbl);
		$tmp = str_replace("#sectname#",$Name,$this->DivSets[$DivSetNo]);
		if (count($Collection)==0) {
			$tmp =	str_replace("#title#",'<font color=gray>'.$Name.'</font>',$tmp);
		}else{
			$tmp =	str_replace("#title#",$Name,$tmp);
		}
		$tbl = str_replace("#data#",$tbl,$tmp);
		echo str_replace("|", "\n",$tbl);
	}

}
