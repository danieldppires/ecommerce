<?php

	namespace Hcode\Model;

	use \Hcode\DB\Sql;
	use \Hcode\Model;

	class User extends Model
	{
		const SESSION = "User";

		public static function login($login, $password)
		{
			$sql = new Sql();

			$results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
				":LOGIN"=>$login
			));

			if (count($results) === 0)
			{
				throw new \Exception("Usuário inexistente ou senha inválida.");
			}

			$data = $results[0];

			if (password_verify($password, $data["despassword"]) === true)
			{
				$user = new User();

				$user->setData($data);

				//Após validar o login (existe usuario e senha), precisamos criar uma sessão. Iremos sempre verificar se existe uma sessão e se não houver, redireciona para a página de login
				$_SESSION[User::SESSION] = $user->getValues();//O nome da sessão está em uma constante que definimos acima, chamada SESSION

				return $user;
			}
			else
			{
				throw new \Exception("Usuário inexistente ou senha inválida."); //Estamos criando uma instância dentro da própria classe, já que ele é static
			}
		}

		public static function verifyLogin($inadmin = true)
		{
			if (
				!isset($_SESSION[User::SESSION]) //Se a Session não foi definida
				||
				!$_SESSION[User::SESSION] //Se a Session foi definida mas está vazia (ela é falsa)
				||
				!(int)$_SESSION[User::SESSION]["iduser"] > 0 //Se o iduser estiver vazio, ao converter para int ele vira zero
				||
				(bool)$_SESSION[User::SESSION]["inadmin"] !== $inadmin //Não tem permissão para acessar a administração
				
				)
			{
				header("Location: /admin/login");
				exit;
			}
		}

		public static function logout()
		{
			$_SESSION[User::SESSION] = NULL;
		}
	}

?>