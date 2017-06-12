<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 11:04 AM
 */

namespace NegaritSMS\Controllers;


use NegaritSMS\Services\Service;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class PhoneController extends AbstractRestfulController
{
    /**
     * @var Service $ServiceManager
     */
    protected $ServiceManager;

    /**
     * PhoneController constructor.
     * @param Service $ServiceManager
     */
    public function __construct(Service $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
    }

    public function getList()
    {
        $this->writelog("Get List");
//        $this->writelog("Get Request: -> ".json_encode($_GET));
        return new JsonModel(array("New Get Request"));
    }
    public function create($data){
        $this->writelog("POST Request");
        $this->writelog("POST Request: -> ".json_encode($data));
        $process = new PhoneProcessRequest($this->ServiceManager,$data);
        $process->ProcessPOSTRequest();
        return new JsonModel($process->getMessage());
    }
    public function get($data){
        $data = $_GET;
        $this->writelog("GET Request");
        $this->writelog("GET Request: -> ".json_encode($data));
        $process = new PhoneProcessRequest($this->ServiceManager,$data);
        $process->ProcessGETRequest();
        return new JsonModel($process->getMessage());
    }
    function writelog($txt_data){
        file_put_contents("log.txt","\n".json_encode($txt_data),FILE_APPEND | LOCK_EX);
    }
}