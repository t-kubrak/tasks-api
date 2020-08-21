<?php


namespace App;


class Log extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $connection = 'mongodb';
    protected $collection = 'logs';
}
