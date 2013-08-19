<?php
namespace Storyboard\Model;

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
    	$resultSet = $this->tableGateway->select();
    	$solved=array();
    	foreach ($resultSet as $key=>$value):
    	$solved[$value->id]= json_decode($value->data,true);
    	endforeach;
    	return $solved;
    }
    
    public function getRow($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
    	$row=json_decode($row->data,true);
    	return $row;
    }
    
    public function getSet($id,$value)
    {
    	$row=$this->getRow($id);
    	return $row[$value];
    	
    }
    
    public function editData($data,$id,$value)
    {
    	$oldcell=$this->getSet($id,$value);

		$oldrow=$this->getRow($id);

		$newcell=array();
		$newcell['title']=(isset($data->title)? $data->title: $oldcell['title']);
		$newcell['src']=(($data->src)? $data->src: $oldcell['src']);
    	
		$oldrow[$value]=$newcell;
		$this->tableGateway->update(array('id'=>$id,'data'=>json_encode($oldrow)), array('id' => $id));
		
    }
    
    public function deleteRow($id,$value=0)
    {
    	$id= (int) $id;
    	$value=(int) $value;
    	$data=$this->getRow($id);
    	unset($data[$value]);
		$data=json_encode($data);
    	echo gettype($data);
		$e=array(
				'id'   =>$id,
				'data' =>$data
		);
		
    	$this->tableGateway->update($e, array('id' => $id));
    }
    
    public function addData($data,$id)
    {
    	$id= (int) $id;
    	echo $id . "<br>";
    	$row=$this->getRow($id);
    	$row[]=array(
    			'title' => $data->title,
    			'src'   => $data->src,
    	);
    	$row=json_encode($row);
    	$val=array(
    			'id'   => $id,
    			'data' => $row,
    	);
    	$this->tableGateway->update($val, array('id' => $id));
    }
}