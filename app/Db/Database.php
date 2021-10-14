<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database{
    
    /**
     * Host de conexão com o banco de dados
     * @var string
     */ 
    const LOCALHOST = 'db';

    /*
    *Nome do Banco de dados
    *@var string 
    */

    const NAME = 'wdev_vagas';

    /**
     * Usuário do banco
     * @var string 
     */

     const USER = 'root';

     /**
      * Senha de acesso ao Banco de Dados
      *@var string
      */
      const PASS = '';

      /**
       * Nome da tabela a ser manipulada
       * @var [type]
       */
      private $table;

      /**
       * Instancia de conexão com o banco de dados
       * @var PDO
       */
      private $connection;


      /**
       * Define a tabela e instancia e conexão
       * @param string $table
       */
        public function __construct($table = null){
            $this->table = $table; 
            $this->setConnection();
        }

        private function setConnection(){
            try{
                $this->connection = new PDO('mysql:localhost=' .self::LOCALHOST.';dbname='.self::NAME,self::USER,self::PASS);  
                $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
            }catch(PDOException $e){
                die('ERROR:' .$e->getMessage());
            }
        }

        public function execute($query,$params = []){
            try{
                $statement = $this->connection->prepare($query);
                $statement->execute($params);
                return $statement;
            }catch(PDOException $e){
                die('ERROR: '.$e->getMessage());
            }
      }

        /**
         * Método responsável por inserir métodos no banco
         * @param array $values [ field => value]
         * @return integer
         */
        public function insert($values){
            //DADOS DA QUERY
            $fields = array_keys($values);
            $binds = array_pad([], count($fields),'?');
           
            //MONTA QUERY
             $query = 'INSERT INTO ' .$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
           
             //EXECUTA O INSERT
             $this->execute($query,array_values($values));
             return $this->connection->lastInsertId();
         }

         /**
          * Método Responsável por Executar a consulta no Banco
          * @param string $where 
          * @param string $order
          * @param string $limit
          * @param string $fields
          * @return PDOStatement
          */

         public function select($where = null, $order = null, $limit = null, $fields = '*'){
                //DADOS DA QUERY
                $where  = strlen($where) ? 'WHERE '.$where : '';
                $order  = strlen($order) ? 'ORDER BY '.$order : '';
                $limit  = strlen($limit) ? 'LIMIT'.$limit : '';
                
                //MONTA A QUERY
                $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

                //EXECUTA A QUERY
                return $this->execute($query);
         }

         /**
          * Método Responsável por executar atualizações no Banco de Dados
          *@param string $where
          *@param array $values  [field => values ]
          *@return boolean
          */
         public function update($where,$values){
            //DADOS DA QUERY
            $fields = array_keys($values);

            //MONTAR A QUERY
            $query = 'UPDATE '.$this->table.' SET '.implode('=?, ',$fields).'=? WHERE '.$where;

            //EXECUTAR A QUERY
            $this->execute($query,array_values($values));
            
            //RETORNA SUCESSO
            return true;
         }      

         /**
          * @param string $where
          * @return boolean 
          */
         public function delete($where){
            //MONTA A QUERY
            $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
            
            //EXECUTA A QUERY
            $this->execute($query);

            //RETORNA SUCESSO
            return true;           
         }
    }