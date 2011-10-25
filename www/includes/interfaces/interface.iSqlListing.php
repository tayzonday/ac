<?php

interface iSqlListing {

	public function setup();

	public function select($type, $debug = FALSE);

	public function afterSelect();

}

?>