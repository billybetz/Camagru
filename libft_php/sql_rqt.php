<?php
	function ft_exe_sql_rqt($name, $connection, $sql_rqt)
	{
		//tester avec $prep=$db->prepare(rqt);$prep->execute();
		$rqt_status = $connection->query($sql_rqt);
		if ($rqt_status == FALSE)
		{
			echo ("sql_requete:".$name." error : ".$connection->error);
			return (-1);
		}
		return (0);
	}
?>
