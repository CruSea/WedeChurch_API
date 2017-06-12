<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/24/17
 * Time: 11:33 AM
 */

namespace NegaritSMS\Controllers;

use NegaritSMS\Services\Service;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class MainController extends AbstractRestfulController
{
    /**
     * @var Service $ServiceManager
     */
    protected $ServiceManager;

    /**
     * MainController constructor.
     * @param Service $ServiceManager
     */
    public function __construct(Service $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
    }


    public function getList()
    {
        return new JsonModel(array("New Get Request"));
    }
    public function create($data){
        $process = new ProcessRequest($this->ServiceManager,$data);
        $process->Process();
        return new JsonModel($process->getMessage());
    }
}