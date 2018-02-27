<?php
	function ft_exe_sql_rqt($name, $connection, $sql_rqt)
	{
		//tester avec $prep=$db->prepare(rqt);$prep->execute();
		$rqt_data = $connection->query($sql_rqt);
		return ($rqt_data);
	}

	function ft_data_is_exist($con, $table, $data_type, $data)
	{
		echo ("table : ".$table."<br/>data_type : ".$data_type."<br/>data : ".$data."<br/>");
		//$rqt = "SELECT pseudo FROM camagru.users WHERE pseudo = 'billy'";
		$rqt = "SELECT '".$data_type."' FROM '".$table."' WHERE '".$data_type."' = '".$data."'";
		$rqt_data = ft_exe_sql_rqt("", $con, $rqt);
		$la = mysqli_fetch_array($rqt_data);
		echo ($la['pseudo']."\n");
	}
?>
