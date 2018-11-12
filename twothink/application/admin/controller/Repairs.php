<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Db;
use think\Request;
use think\Validate;

class Repairs extends Admin {

    protected $rule =   [
        'name'  => 'require|max:4',
        'tel'   => 'require|max:11',
        'address' => 'require',
    ];

    //新增字段
    public function add(){

        if(request()->isPost()){
            $Repairs = model('repairs');//获得model下面的channel还是validate下面的channel
            $post_data=\think\Request::instance()->post();
           // var_dump($post_data);//提交的post值？
            //自动验证



            $validate = new \app\admin\validate\Repairs($this->rule);
          //  dump($validate);
            $result = $validate->scene('add')->check($post_data);

            if(!$result){
                return $this->error($validate->getError());
            }

            $data = $Repairs->create([
               'name'=>Request::instance()->post('name'),
               'tel'=>Request::instance()->post('tel'),
               'address'=>Request::instance()->post('address'),
               'info'=>Request::instance()->post('info'),
               'sn'=>date('Ymd',time()).mt_rand('1000','9999'),
            ]);

            if($data){
                $this->success('新增成功', url('index'));
                //记录行为
                action_log('update_repairs', 'repairs', $data->id, UID);
            } else {
                $this->error($Repairs->getError());
            }
        } else {

            return $this->fetch('add');
        }
    }

    //查询要修改的字段
    public function edit(){

        if($this->request->isPost()){
            //dump(\think\Request::instance()->post('id'));
           // exit;
           // dump(Request::instance()->post());
            // 实例化模型
            $repairs = \app\admin\model\Repairs::get(\think\Request::instance()->post('id'));
            //dump($repairs);

            // 显式指定更新数据操作
            $end=$repairs->isUpdate(true)
                ->save([
                    'name' => Request::instance()->post('name'),
                    'tel' => Request::instance()->post('tel'),
                    'address' => Request::instance()->post('address'),
                    'info' => Request::instance()->post('info'),
                ]);

            //dump('successful');


            if($end !== false){
                $this->success('编辑成功', url('index'));
            } else {
                $this->error('编辑失败');
            }
        } else {

            $info=array();
            /* 获取数据 */
            $info = \think\Db::name('Repairs')->find(Request::instance()->param());
            //dump($info);


            if(false === $info){
                $this->error('获取配置信息错误');
            }

            $this->assign('info', $info);
           // $this->meta_title = '编辑导航';
            return $this->fetch();
        }

    }

    //显示所有的数据到页面中
    public function index(){
        //$repairs=\app\admin\model\Repairs::all();
        $repairs=Db::name('repairs')->Paginate(1);
        //dump($repairs);
        $this->assign('repairs',$repairs);
        return $this->fetch();
    }

    //删除指定的数据
    public function del(){
       // dump(Request::instance()->param());

        $id = array_unique((array)input('id/a',0));

       if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $repairs = \app\admin\model\Repairs::get($id);//查询到指定的数据


       // dump(111);exit;
        if($repairs->delete()){
            //记录行为
            action_log('update_repairs', 'repairs', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }

    }

}