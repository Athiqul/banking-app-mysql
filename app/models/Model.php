<?php

namespace App\Models;
use App\core\Contracts\Model as ContractsModel;
use App\core\traits\filesystem\FileDbTrait;
use App\core\traits\MySqlSystem\SqlModel;




    class Model implements ContractsModel{

        use FileDbTrait,SqlModel;
        
        public function save(array $user){
              if($this->checkFileType())
              {
               return  $this->fileSave($user);   
              }
              return  $this->sqlSave($user);
              
        }
        public function update($needle,array $data){

            if($this->checkFileType())
              {
                return $this->fileUpdate($needle,$data);   
              }
              return  $this->sqlUpdate($needle,$data);
              

        }
        public function findByEmail($email){
            if($this->checkFileType())
            {
              return $this->fileFindByEmail($email);   
            }
            return  $this->sqlFindByEmail($email);
            
        }
        public function all($column='',$value=''){

            if($this->checkFileType())
              {
                return $this->fileAll($column,$value);   
              }
               return $this->sqlAll($column,$value);
              
        }
        public function where($column, $value){
            if($this->checkFileType())
            {
              return $this->fileWhere($column,$value);   
            }
            return  $this->sqlWhere($column,$value);
            
        }


        private function checkFileType():bool {
            return DB=='file'?true:false;
        }


    }



?>