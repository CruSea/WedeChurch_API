<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/6/17
 * Time: 12:58 AM
 */

namespace NegaritSMS\Controllers;


use NegaritSMS\Services\Service;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class APIController extends AbstractRestfulController
{
    /**
     * @var Service $ServiceManager
     */
    protected $ServiceManager;

    /**
     * APIController constructor.
     * @param Service $ServiceManager
     */
    public function __construct(Service $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
    }

    public function getList()
    {
        return new JsonModel(array("API Controller"));
    }
    public function create($data){
        $process = new APIProcessRequest($this->ServiceManager,$data);
        $process->Process();
        return new JsonModel($process->getMessage());
    }

}