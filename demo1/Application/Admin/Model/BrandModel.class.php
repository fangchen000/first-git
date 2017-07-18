<?php
namespace Admin\Model;
use Think\Model;
class BrandModel extends Model {
	//定义验证规则
	protected $_validate=array(
                array('group_id','require','类型必填!'),
		array('brand_name','require','品牌名称必填!'),
		array('site_url','require','品牌官网地址必填'),
                array('sort','require','排序必填'),
		//新增的时候验证name 是否是唯一的
		array('brand_name','','品牌名称已经存在!','0','unique',1),
		//验证官网的地址是否合法
		//array('site_url','','地址不规范'),
	);
}