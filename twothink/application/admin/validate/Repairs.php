<?php

namespace app\admin\validate;
use think\Validate;
/**
 *  模型验证模型
 */
class Repairs extends Validate{

    protected $rule =   [
        'name'  => 'require|max:10',
        'tel'   => 'number|max:11',
        'address' => 'required',
    ];

    protected $message  =   [
        'name.require' => '名称不能为空',
        'name.max'     => '名称最多不能超过4个字符',
        'tel.require'   => '电话号码不能为空',
        'tel.max'  => '电话号码只能在11以下间',
        'address'        => '地址不能为空',
    ];

    protected $scene = [
        'add'  =>  ['name','tel','address'],
    ];




}