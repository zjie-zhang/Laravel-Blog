<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = false;

    // lst页面 -- 获取所有分类信息
    public function getCategorys(){
        $categorys = $this->orderBy('id','asc')->get();
        $tree_arr = Category::getTreeStatic($categorys);
        return $tree_arr;
    }

    //将数组按树结构排序（一维数组） 这个用了静态方法，调用时注意
    public static function getTreeStatic($data,$pid=0,$level=0){
        static $mid_arr = array();
        foreach ($data as $k => $v){
            if($v['cate_pid'] == $pid){
                $v['level'] = $level;
                $mid_arr[] = $v;
                self::getTreeStatic($data,$v['id'],$level+1);
            }
        }
        return $mid_arr;
    }

    //将数组按树结构排序（一维数组） 非静态方法，调用时注意
    public static function getTree($data,$pid=0,$level=0){
        $mid_arr = array();   // 不加static
        foreach ($data as $k => $v){
            if($v['cate_pid'] == $pid){
                $v['level'] = $level;
                $mid_arr[] = $v;
                $mid_arr = array_merge($mid_arr,self::getTree($data,$v['id'],$level+1)); // 不加static需要将新数组与初始化数组合并
            }
        }
        return $mid_arr;
    }

    //将数组按树结构（多维数组）
    public function getTreeMulti($data,$pid=0,$level=0){
        $mid_arr = array();
        foreach ($data as $k => $v){
            if($v['cate_pid'] == $pid){
                $v['level'] = $level;
                foreach ($data as $item) {
                    if($item['cate_pid'] == $v['id']){
                        $v['child'] = $this->getTreeMulti($data,$v['id'],$level+1);
                    }
                }
                $mid_arr[] = $v;
            }
        }
        return $mid_arr;
    }

    // 获取一个ID的子分类
    public function getChilds($data,$pid){
        static $childs_arr = array();
        foreach ($data as $v){
            if($v['cate_pid'] == $pid){
                $childs_arr[] = $v;
                $this -> getChilds($data,$v['id']);
            }
        }
        return $childs_arr;
    }

    // 获取一个ID的父类
    public function getParents($data,$id){
        static $parent_arr = array();
        foreach ($data as $v){
            if($v['id'] == $id){
                $parent_arr[] = $v;
                $this->getParents($data,$v['cate_pid']);
            }
        }
        return $parent_arr;
    }

    public function getTreeNew($data,$pid=0,$level=0){
        $a = 0;
        $mid_arr = array();   // 不加static
        foreach ($data as $k => $v){
            if($a == 0){
                $v['a'] = '┏';
            }else{
                $v['a'] = '┣';
            }
            if($v['cate_pid'] == $pid){
                $v['level'] = $level;
                $mid_arr[] = $v;
                $mid_arr = array_merge($mid_arr,$this->getTreeNew($data,$v['id'],$level+1)); // 不加static需要将新数组与初始化数组合并
            }
            $a++;
        }
        return $mid_arr;
    }

}
