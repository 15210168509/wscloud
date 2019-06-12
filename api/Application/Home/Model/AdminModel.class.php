<?php
/**
 * Created by 李文起
 * User: 01
 * Date: 2018/5/3
 * Time: 13:39
 */

namespace Home\Model;


use Think\Model;

class AdminModel extends Model
{
    protected $connection = 'DB_CONFIG1';
    protected $tableName  = "admin";
    protected $_auto = array(
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function')
    );
}