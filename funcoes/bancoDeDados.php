<?php

/**
 * Responsável por realizar a conexão com o banco de dados.
 * @return Object conexão como banco de dados.
 */
function bd_conecta(){
	return mysqli_connect("localhost", "public_haus", 'Teste1234567890', "haus");
}

/**
 * Responsável por realizar o tratamento dos valores imputados nas querys que serão executadas no banco de dados.
 * @param String $valor string a ser tratada
 * @return String retorna o valor informado com os devidos tratamentos para serem inseridos no banco de dados.
 */
function bd_mysqli_real_escape_string($valor){
	$conexao = bd_conecta();
	return mysqli_real_escape_string($conexao, $valor);
}

/**
 * Responsável por executar as querys de inserção no banco de dados.
 * @param String $sql query que será executada para a inserção.
 * @param Boolean $relacionamento informa se a inserção é para criação de um relacionamento entre entidades N-N
 * @return Int em caso de falha retorna 0 ou o erro na execução da query, em caso e sucesso retorna o ultimo id inserido.
 */
function bd_insere($sql, $relacionamento = false){
	$retorno = 0;
	$conexao = bd_conecta();

	if(!$conexao)
	{
		return $retorno;
	}

	if(mysqli_query($conexao, $sql))
	{
		$retorno = mysqli_insert_id($conexao);

		if($relacionamento)
		{
			$retorno = 1;
		}
	}
	else
	{
		$retorno = mysqli_error($conexao);
	}

	return $retorno;
}

/**
 * Responsável por executar as querys e atualização no banco de dados.
 * @param String $sql query que será executada para a atualização.
 * @return Boolean em caso de falha retorna false ou o erro na execução da query, em caso e sucesso retorna o true.
 */
function bd_atualiza($sql){
	$retorno = false;
	$conexao = bd_conecta();

	if(!$conexao)
	{
		return $retorno;
	}

	if(mysqli_query($conexao, $sql))
	{
		$retorno = true;
	}
	else
	{
		$retorno = mysqli_error($conexao);
	}

	return $retorno;
}

/**
 * Responsável por executar as querys de consulta no banco de dados.
 * @param String $sql query que será executada para a consulta.
 * @return Array em caso de falha retorna o erro ocorrido, em caso de sucesso um array nomeado com os dados da consulta.
 */
function bd_consulta($sql){
	$retorno = array();
	$conexao = bd_conecta();

	if(!$conexao)
	{
		return $retorno;
	}

	$executaQuery = mysqli_query($conexao, $sql);

	if($executaQuery)
	{
		while($linha = mysqli_fetch_assoc($executaQuery)){
			$retorno[] = $linha;
		}
	}
	else
	{
		$retorno = mysqli_error($conexao);
	}

	return $retorno;
}

/**
 * Responsável por executar as querys de exclusão no banco de dados.
 * @param String $sql query que será executada para a exclusão.
 * @return Int em caso de falha retorna false ou o erro na execução da query, em caso e sucesso retorna true.
 */
function bd_exclui($sql){
	$retorno = false;
	$conexao = bd_conecta();

	if(!$conexao)
	{
		return $retorno;
	}

	if(mysqli_query($conexao, $sql))
	{
		$retorno = true;
	}
	else
	{
		$retorno = mysqli_error($conexao);
	}

	return $retorno;
}