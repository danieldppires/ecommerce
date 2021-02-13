<?php

	namespace Hcode;

	use Rain\Tpl;

	class Page
	{
		private $tpl;
		private $options = [];
		private $defaults = [
			"header"=>true,
			"footer"=>true,
			"data"=>[]
		];

		public function __construct($opts = array(), $tpl_dir = "/views/")
		{
			$this->options = array_merge($this->defaults, $opts); //Se passar informação no segundo parâmetro e ele der conflito com o defaults ele sobreescreve o defaults e usa o opts. O merge vai mesclar as duas paginas dentro deste atributo

			$config = array(
				"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir, //Pasta onde está o template /views/
				"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/", //
				"debug"         => false
		   	);

			Tpl::configure($config);

			$this->tpl = new Tpl;

			//As variáveis vão vir de acordo com a rota no Slim
			$this->setData($this->options["data"]);

			if ($this->options["header"] === true) $this->tpl->draw("header"); //Esse arquivo vai repetir em todas as páginas
		}

		private function setData($data = array())
		{
			foreach ($data as $key => $value)
			{
				$this->tpl->assign($key, $value); 
			}
		}

		//Este é o HTML do conteúdo (corpo que será pagina de login, pagina de cadastro, etc)
		//Recebe o nome do template, as variaveis e se retorna HTML ou já joga na tela
		public function setTpl($name, $data = array(), $returnHTML = false)
		{
			$this->setData($data);
			return $this->tpl->draw($name, $returnHTML);
		}
		

		public function __destruct()
		{
			//Quando esta classe sair da memória do PHP, vamos adicionar o footer
			//Aqui podemos colocar javascripts e tudo que quisermos que repita em todas as telas
			if ($this->options["footer"] === true) $this->tpl->draw("footer");
		}
	}

?>