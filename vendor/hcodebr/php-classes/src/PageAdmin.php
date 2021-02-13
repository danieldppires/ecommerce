<?php

	namespace Hcode;

	class PageAdmin extends Page
	{
		public function __construct($opts = array(), $tpl_dir = "/views/admin/") //Pasta diferente da do site para não dar conflitos. 
		{
			parent::__construct($opts, $tpl_dir); //Chamando o método construtor da classe pai (Page)
		}
	}
?>