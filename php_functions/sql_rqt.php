<?php
	function ft_exe_sql_rqt($name, $connection, $sql_rqt)
	{
		//tester avec $prep=$db->prepare(rqt);$prep->execute();
		$rqt_data = $connection->query($sql_rqt);
		return ($rqt_data);
	}
?>
