<?php
namespace Image\Model;

use Zend\Db\TableGateway\TableGateway;

class ImageTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($paginated=false)
    {
        $resultSet = $this->tableGateway->select();

        return $resultSet;
    }
    
    public function saveImage(Image $image)
    {
    	$data = array(
    			'src' => $image->src,
    			'title'  => $image->title,
    	);
    	
    	$id = (int)$image->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    	} else {
    		if ($this->getImage($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    }
    public function deleteImage($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }

}