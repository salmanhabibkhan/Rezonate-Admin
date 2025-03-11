<?php 
namespace App\Models;
use CodeIgniter\Model;

class Seo extends Model
{
	protected $table      = 'seo';
    protected $primaryKey = 'id';
    protected $returnType     = 'array';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    public $default = ['id'=>1,
    				   'slug'=>'default',
    				   'title'=>'SocioPoint',
    				   'description'=>'Socio Point',
    				   'keywords'=>'Socio Point, sociopoint,point socio,pointsocio'];

    /*function get_book_by_id(){
        return $userModel->where('deleted', 0)->first();
    }*/

    public function get_currentpage_tags(){
    	$siteurl = current_url();
		$arr = explode('/', $siteurl);
		$urlstring = array_pop($arr);
		if(!empty($urlstring)){
			$result = $this->where('slug', $urlstring)->first();
			if(empty($result)){
				return $this->default;
			}
			return $result;
		}
    }

}