<?php
namespace Picture\Model;

use Zend\Db\TableGateway\TableGateway;

class PictureTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated=false)
    {
        $resultSet = $this->tableGateway->select(array('id' => 58))->current();
        return $resultSet;
    }
    
    public function getPicture($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
    	return $row;
    }
    
    public function savePicture(Picture $image)
    {
    	
    	
    	$data = $this->fetchAll();
    	$data = unserialize($data->src);
    	
    	$data[] = array(
    			'title' => $image->title,
    			'src'  => $image->src,
    	);
    	$data=array(
    			'title' => 'qqq',
    			'src'   => serialize($data)
    	);
    	
    	//$id = (int)$image->id;
    	$id= 58;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getPicture($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    }
    public function deletePicture($id)
    {
    	$data=$this->fetchAll();
    	$dataid=58;
    	$datatitle='asd';
    	//echo $data->title;
    	
    	$data=unserialize($data->src);
    	unset($data[$id]);
    	$data=array(
    			'title' => $datatitle,
    			'src'   => serialize($data)
    	);
    	print_r($data);
    	$this->tableGateway->update($data, array('id' => $dataid));
    	
    	//$this->tableGateway->delete(array('id' => $id));
    }

}