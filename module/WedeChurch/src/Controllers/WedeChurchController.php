<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 6/12/17
 * Time: 2:12 PM
 */

namespace WedeChurch\Controllers;


use WedeChurch\Services\Service;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class WedeChurchController extends AbstractRestfulController
{
    /**
     * @var Service $ServiceManager
     */
    protected $ServiceManager;

    /**
     * WedeChurchController constructor.
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
    public function create($data)
    {
        $process = new APIProcess1($this->ServiceManager,$data);
        $process->Process();
        return new JsonModel($process->getMessage());
    }
}