<?php
namespace Picture\Model;

use Zend\Db\TableGateway\TableGateway;

class StoryboardTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
    	$resultSet = $this->tableGateway->select(array('id' => 1))->current();
    	return $resultSet;
    }
}