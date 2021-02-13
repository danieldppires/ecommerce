<?php 
	//Inicia as sessões
	session_start();
	
	//O autoload vai chamar o vendor autoload no composer (as dependências). Sempre vai ter. Traz o que o projeto precisa
	require_once("vendor/autoload.php");

	//Estes são namespaces. Eu tenho dezenas de classes dentro do vendor e aqui eu digo quais eu quero usar
	use \Slim\Slim;
	use \Hcode\Page;
	use \Hcode\PageAdmin;
	use \Hcode\Model\User;

	$app = new Slim(); //Aqui é por causa das rotas. Antes chamava index.php, default.php, cadastro.php
	//Agora por causa de SEO e rankeamento é tudo rota. Passa o nome na URL e o Slim manda para algum lugar

	$app->config('debug', true);

	$app->get('/', function() //Aqui é a rota que estamos chamando. Quando uma chamada via get (padrão) sem nenhum tipo de rota chamar, carrega isto aqui (executa esta função).
	{
		$page = new Page(); //Neste momento (new) ele chama o construct que irá adicinar o header na tela

		$page->setTpl("index"); //Neste momento ele chama o arquivo index.html (o corpo da página)

		//Aqui ele acaba a execução e o PHP vai limpar a memória, chamando o método destruct, que irá incluir o footer
	});

	$app->get('/admin', function() //Rota para o admin
	{
		User::verifyLogin(); //Vamos criar um método que valida se o usuário está logado

		$page = new PageAdmin();
		$page->setTpl("index"); 
	});

	$app->get('/admin/login', function() //No caso do login precisamos desabilitar a chamada do header e do footer (só nesta página), pois ela já tem um header e um footer diferente das demais páginas
	{
		$page = new PageAdmin([
			"header"=>false,
			"footer"=>false
		]);
		
		$page->setTpl("login");
	});

	$app->post('/admin/login', function()
	{
		User::login($_POST["login"], $_POST["password"]);

		header("Location: /admin");
		exit;
	});

	$app->get('/admin/logout', function()
	{
		User::logout();

		header("Location: /admin/login");
		exit;
	});

	$app->run(); //É quem faz tudo acima rodar

 ?>