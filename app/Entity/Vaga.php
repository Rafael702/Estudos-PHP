<?php

namespace App\Entity;

use App\Db\Database;

use \PDO;


class Vaga {

    /**
    *Identificador unico da Vaga
    *@var integer
    */
    public $id;

    /**
    *Titulo da vaga
    *@var string
    */
    public $titulo;

    /**
    *Descrição da vaga (pode conter html)
    *@var string
    */
    public $descricao;

     /**
     *Define se a vaga está ativa
     *@var string(s/n)
     */
     public $ativo;

      /**
      *Data de publicação da vaga
      *@var string
      */
      public $data;

      /**
      *Método responsável por cadastrar uma nova vaga
      *@return boolean
      */

      /**
       * Método responsável por executar queries dentro do banco de dados
       * @param [type] $query
       * @param array $params
       * @return PDOStatement
       */

      public function cadastrar(){
          //Definir A Data

          $this->data = date('Y-m-d H:i:s');

          //Inserir a vaga no banco 
            $obDatabase = new DataBase('vagas');
          //Atribuir o ID Da vaga na instancia
            $this->id = $obDatabase->insert([
                'titulo' => $this->titulo,
                'descricao' => $this->descricao,
                'ativo' => $this->ativo,
                'data' => $this->data
            ]);


          //Retornar Sucesso
        return true;
      }
      
      /**
       *Método Responsável por atualizar a vaga no banco
       *  @return boolean 
       */
      public function atualizar(){
        return(new Database('vagas'))->update('id = '.$this->id,[
                'titulo'    => $this->titulo,
                'descricao' => $this->descricao,
                'ativo'     => $this->ativo,
                'data'      => $this->data
        ]);
      }

      /**
       * Método responsável por excluir a vaga do banco
       * @return boolean
       */
      public function excluir(){
        return (new Database('vagas'))->delete('id = '.$this->id);

      }

      /**
       * Método responsável por obter as vagas do banco de dados
       * @param string $where
       * @param string $order
       * @param string $limit
       * @return array
       */
      public static function getVagas($where = null, $order = null, $limit = null){
        return (new Database('vagas'))->select($where,$order,$limit)
                                ->fetchAll(PDO::FETCH_CLASS,self::class);
      }

      /**
       * Método Responsável por buscar uma vaga com base em seu ID
       * @param integer $id
       * @return Vaga
       * 
       */
      public static function getVaga($id){
          return (new Database('vagas'))->select('id = '.$id)
                        ->fetchObject(self::class);
      }
}