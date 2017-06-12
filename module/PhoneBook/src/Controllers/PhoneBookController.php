<?php
/**
 * Created by PhpStorm.
 * User: bengeos
 * Date: 5/5/17
 * Time: 8:22 PM
 */

namespace PhoneBook\Controllers;
use PhoneBook\Services\Services;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class PhoneBookController extends AbstractRestfulController
{
    /**
     * @var Services $ServiceManager
     */
    protected $ServiceManager;

    /**
     * PhoneBookController constructor.
     * @param Services $ServiceManager
     */
    public function __construct(Services $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
    }

    public function getList()
    {
        return new JsonModel(array("API Controller"));
    }
    public function create($data)
    {
        $newProcess = new PhoneBookRequestProcess($this->ServiceManager,$data);
        $newProcess->Process();
        return new JsonModel($newProcess->getMessage());
    }

}