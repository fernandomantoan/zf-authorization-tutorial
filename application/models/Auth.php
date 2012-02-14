<?php

class Model_Auth
{
	public static function login($login, $senha)
	{
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		//Inicia o adaptador Zend_Auth para banco de dados
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		$authAdapter->setTableName('usuario')
		->setIdentityColumn('login')
		->setCredentialColumn('senha')
		->setCredentialTreatment('SHA1(?)');
		//Define os dados para processar o login
		$authAdapter->setIdentity($login)
		->setCredential($senha);
		//Faz inner join dos dados do perfil no SELECT do Auth_Adapter
		$select = $authAdapter->getDbSelect();
		$select->join( array('p' => 'perfil'), 'p.id = usuario.perfil_id', array('nome_perfil' => 'nome') );
		//Efetua o login
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($authAdapter);
		//Verifica se o login foi efetuado com sucesso
		if ( $result->isValid() ) {
			//Recupera o objeto do usuário, sem a senha
			$info = $authAdapter->getResultRowObject(null, 'senha');
	
			$usuario = new Model_Usuario();
			$usuario->setFullName( $info->nome_completo );
			$usuario->setUserName( $info->login );
			$usuario->setRoleId( $info->nome_perfil );
	
			$storage = $auth->getStorage();
			$storage->write($usuario);
	
			return true;
		}
		throw new Exception('Nome de usuário ou senha inválida');
	}
}