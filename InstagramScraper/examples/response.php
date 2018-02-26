<?php
/**
 * Created by PhpStorm.
 * User: shinji
 * Date: 2018/2/25
 * Time: 下午11:00
 */


/**
 * @SWG\Definition(type="object", @SWG\Xml(name="Response"))
 */
class Response
{
    /**
     * @SWG\Property(example=true)
     * @var boolean
     */
    public $success;

    /**
     * @SWG\Property(example="错误信息")
     * @var string
     */
    public $error;
}