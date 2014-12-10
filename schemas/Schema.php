<?php

namespace Monexclusif;

use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'boot.php';

class Schema
{
    
    private $sqlFiles = array();
    
    private function setSqlFiles($file)
    {
        $this->sqlFiles[] = $file;
        return $this;
    }
    
    public function getSqlFiles()
    {
        return $this->sqlFiles;
    }
    
    private function _getSchemaFiles()
    {
        foreach ($iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(dirname(__FILE__), \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST) as $item)
        {
            if($item->isFile())
            {
                $this->setSqlFiles($item->getPathName());
            }
        }
    }
    
    private function _getScheme()
    {
        $json = json_decode(file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'scheme.json'), true);
        return $json;
    }
    
    private function _initializeDatabaseLock(Model\DatabaseLock $databaseLock)
    {
        try
        {
            $sql = "SELECT * FROM database_lock";
            
            $result = new Resultset(null, $databaseLock, $databaseLock->getReadConnection()->query($sql));
        } catch (\PDOException $e)
        {
            $sql = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'databaselock.sql');
            
            $result = new Resultset(null, $databaseLock, $databaseLock->getReadConnection()->query($sql));
        }
        
    }
    
    public function run()
    {
        $scheme = $this->_getScheme();
        
        $di = \Phalcon\DI::getDefault();
        $databaseLock = new Model\DatabaseLock($di);
        
        $this->_initializeDatabaseLock($databaseLock);
        
        foreach($scheme as $key => $sql_file)
        {
            
            $sql = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . $sql_file);
            
            $result = new Resultset(null, $databaseLock, $databaseLock->getReadConnection()->query($sql));
            
            $profileLock = new Model\DatabaseLock($di);
            $profileLock->key = $key;
            $profileLock->file = $sql_file;
            
            if($profileLock->save() === false)
            {
                continue;
            }
            
        }
    }
}

$schema = New Schema();
$schema->run();

//var_dump($schema->getSqlFiles());