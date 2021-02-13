<?php 

	//O autoload vai chamar o vendor autoload no composer (as dependências). Sempre vai ter. Traz o que o projeto precisa
	require_once("vendor/autoload.php");

	//Estes são namespaces. Eu tenho dezenas de classes dentro do vendor e aqui eu digo quais eu quero usar
	use \Slim\Slim;
	use \Hcode\Page;

	$app = new Slim(); //Aqui é por causa das rotas. Antes chamava index.php, default.php, cadastro.php
	//Agora por causa de SEO e rankeamento é tudo rota. Passa o nome na URL e o Slim manda para algum lugar

	$app->config('debug', true);

	$app->get('/', function() //Aqui é a rota que estamos chamando. Quando uma chamada via get (padrão) sem nenhum tipo de rota chamar, carrega isto aqui (executa esta função).
	{
		$page = new Page(); //Neste momento (new) ele chama o construct que irá adicinar o header na tela

		$page->setTpl("index"); //Neste momento ele chama o arquivo index.html (o corpo da página)

		//Aqui ele acaba a execução e o PHP vai limpar a memória, chamando o método destruct, que irá incluir o footer
	});

	$app->run(); //É quem faz tudo acima rodar

 ?>