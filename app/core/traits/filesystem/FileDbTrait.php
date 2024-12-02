<?php

namespace App\core\traits\filesystem;

use Exception;

trait FileDbTrait
{

    public function fileSave(array $arrayData)
    {
        $file = storage_path($this->schema);

        $existingData=$this->loadFile($file);
        //merge existingData with parameter arrayData
        if(!isset($arrayData['created_at']))
        {
            $arrayData['created_at']=date('Y-m-d H:i:s');

        }

        if(!isset($arrayData['updated_at']))
         {
            $arrayData['updated_at']=date('Y-m-d H:i:s');
         }
        $existingData[] = $arrayData;
        //convert added new parameter data with existing data
        
        return $this->saveFile($existingData, $file);
    }
    public function fileUpdate($userEmail, array $arrayData)
    {
        $file = storage_path($this->schema);
        
        $existingData=$this->loadFile($file);

        //Search Useremail
        $index = null;
       // dd($existingData[0]['email']);
        foreach ($existingData as $key => $value) {
            //dd(strlen($value['email']).' '.strlen($userEmail));
            if ($value['email'] == $userEmail) {
                
                $index = $key;
                //dd($index);
                break;
            }
        }

        //dd($index);

        if ($index === null) {
            throw new Exception("No data found for $userEmail in this :" . $this->schema);
        }
        $arrayData['updated_at']=date('Y-m-d H:i:s');
        $existingData[$index] = $arrayData;
        return $this->saveFile($existingData,$file);
    }
   
    public function fileFindByEmail($email)
    {
        $file = storage_path($this->schema);

        
        $existingData =$this->loadFile($file);
        //merge existingData with parameter arrayData
        $find = array_filter($existingData, function ($item) use ($email) {
            return $item["email"] == $email;
        });
        return reset($find) ?: null;
    }
    public function fileAll($column = '', $value = '')
    {
        
        $file = storage_path($this->schema);        
        $users = $this->loadFile($file);
        $users = array_map(function ($user) use ($column, $value) {
            if ($column == '' || $value == '') {
                return $user;
            } else {

                if ($user[$column] == $value) {
                    return $user;
                }
            }
            return null;
        }, $users);

        $users = array_values(array_filter($users));




        return $users ?? null;
    }
  
    public function fileWhere($column, $value)
    {

        $file = storage_path($this->schema);
        $users =$this->loadFile($file);

        $user = array_values(array_filter($users, function ($user) use ($column, $value) {
            return $user[$column] == $value;
        }));

        return reset($user) ?: null;
    }


    private function loadFile($file) {
        
        //check is file is exist 
        if (!file_exists($file) || !is_readable($file)) {
            throw new Exception("$this->schema not found or not readable");
        }
        //Get existing file
        $data = file_get_contents($file);
        $existingData = json_decode($data, true);
        return $existingData;
    }

    private function saveFile(array $existingData,$file) {
        $data = json_encode($existingData, JSON_PRETTY_PRINT);
        //save to json file
        if (file_put_contents($file, $data) === false) {
            throw new Exception('Failed to update or write data to tile' . $this->schema);
        }

        return true;
    }
}
