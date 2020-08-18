<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $task_id
 * @property int $label_id
 */
class TaskLabel extends Model
{
    protected $table = 'tasks_labels';
}
