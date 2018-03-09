<?php
//单例模式的数据库连接
class dbClassManage
{
	protected static $ins=null;
	public static function getIns($hosts,$users,$pwd,$dbname){
		if (self::$ins === null) {
			self::$ins = new self($hosts,$users,$pwd,$dbname);
		}
		return self::$ins;
	}
	public $conn;
	/*
	$hosts:服务器主机地址
	$users:服务器登录用户名
	$pwd:服务器登录密码
	$dbname:数据库名称
	*/
	// final防继承
	final protected function __construct($hosts,$users,$pwd,$dbname)
	{
		//连接mysql数据库
		$this->conn = mysql_connect($hosts,$users,$pwd);
		if($this->conn == false) exit("服务器连接失败");
		//设置编码
		$c = mysql_query("set names utf8",$this->conn);
		if($c == false) exit("编码设置有误");
		$f = mysql_select_db($dbname,$this->conn);
		if($f == false) exit("数据库连接失败");
	}
	//防克隆
	final protected function __clone()
	{

	}
	/*
	 *增、删、改
	 */
	public function exeSql($sql)
	{
		mysql_query($sql,$this->conn);
		return true;
	}
	
	/*
	 *关闭数据库
	 */
	public function close()
	{
		return mysql_close($this->conn);
	}
	/*
	 *查询一条数据
	 */
	public function getOneData($sql,$mode = MYSQL_ASSOC)
	{
		$result = mysql_query($sql,$this->conn);
		$rs = mysql_fetch_array($result,$mode);
		mysql_free_result($result);
		return $rs;
	}
	/*
	 *查询多条数据
	 */
	public function getMoreData($sql,$mode = MYSQL_ASSOC)
	{
		$result = mysql_query($sql,$this->conn);
		while($res = mysql_fetch_array($result,$mode) or false)
		{
			$rs[] = $res;
		}
		mysql_free_result($result);
		return $rs;
	}
}
//$db = new dbClassManage('localhost','root','','dsshop');
$db = dbClassManage::getIns('localhost','root','root','dsshop');
?>