<?php
class Core {

	private $currentController;
	private $currentAction;

	public function run() {
        /**
         * No apache, quando acessamos: localhost/fbTeste/home,
         * estamos acessando a página:  localhost/fbTeste/home/index.php
         *
         * $_SERVER['PHP_SELF'], retorna este endereço.
         */
		//echo $_SERVER['PHP_SELF'];
		//echo "<br/>";

        /*
         * Na linha abaixo, explode vai retornar um novo arranjo,
         * ele vai pegar o string em $_SERVER['PHP_SELF'], e criar um
         * elemento cada vez que ele encontrar a palavra 'index.php',
         * ou seja, index.php, separa os elementos no string.
         * No nosso caso, como sempre haverá somente um único index.php
         * Haverá um arranjo de 2 elementos.
         */
		$url = explode('index.php', $_SERVER['PHP_SELF']);

        /**
         * Aqui, iremos pega o último elemento do arranjo, pois estamos
         * preocupados qual controle foi chamado.
         */
		$url = end($url);

		//echo $url;
		$params = array();
		if (!empty($url) &&
			$url != '/') {

			$url = explode('/', $url);

			// Desloca após a barra.
			array_shift($url);
			//print_r($url);
			//exit;

			//$this->currentController = $url[0].'Controller';
			// Os controllers começam com letra minúscula.
			//$this->currentController = lcfirst($this->currentController);

			// Usaremos a função 'lcfirst' pois o padrão do nosso projeto
			// é ter a primeira letra do nome do arquivo minúsculo.
			$currentController = lcfirst($url[0].'Controller');
			array_shift($url);

			if (isset($url[0])) {
				$currentAction = $url[0];

				// Ao explodir com o caractere '/', se a url após o nome do controller
				// termina em '/', o nome da action retorna vazio, então devemos considerar
				// como o controller padrão.
				if (empty($currentAction)) {
					$currentAction = 'index';
				}

				array_shift($url);

			} else {
				$currentAction = 'index';
			}

			if (count($url) > 0) {
				$params = $url;
			}

		} else {

			$currentController = 'homeController';
			$currentAction     = 'index';
			$params            = array();

		}

		/*
		echo "<br/>";
		echo "Controller: ".$currentController;
		echo "<br/>Action: ".$currentAction;
		echo "<br/>";
		echo "Params: ";
		print_r($params);
		*/

		require_once ('core/controller.php');

		$c = new $currentController();
		//$c->$currentAction();

		call_user_func_array(array($c, $currentAction), $params);
	}
}