<?php

	namespace Hcode;

	class Model //Essa classe vai gerar dinâmicamente os getters and setters
	{
		private $values = [];

		public function __call($name, $args) //Este é um método mágico que é chamado TODA VEZ que um método é chamado. $name é o nome do método e $args é o valor passado
		{
			//Vamos identificar se foi chamado um método get ou set
			$method = substr($name, 0, 3); //Pega o inicio do nome do método. Ex: getIdusuario - "get" / setDeslogin - "set"
			$fieldName = substr($name, 3, strlen($name)); //Pega o restante do nome do método. Ex: getIdusuario - "Idusuario"

			switch ($method)
			{
				case "get":
					return $this->values[$fieldName];
					break;

				case "set":
					$this->values[$fieldName] = $args[0];
					break;
			}
		}

		//Este método vai criar cada um dos atributos para as colunas retornadas do banco de dados de forma dinâmica
		public function setData($data = array())
		{
			foreach ($data as $key => $value)
			{
				$this->{"set".$key}($value); //Chamando um método com o nome criado dinamicamente. Ex: "setiduser('joao');"
			}
		}

		public function getValues()
		{
			return $this->values;
		}
	}

?>