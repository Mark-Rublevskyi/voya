<?php
	include 'config.php';

	$opt=[
	    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
	    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC
    ];


	$dbh=new PDO("mysql:host=localhost;dbname=cnmatzvg_voya;charset=utf8","cnmatzvg_mark","Bigbagyou3434343",$opt);