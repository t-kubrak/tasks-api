<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $description
 * @property string $status
 * @property int $board_id
 */
class Task extends Model
{
    public const STATUS_BACKLOG = 'backlog';
    public const STATUS_DEVELOPMENT = 'development';
    public const STATUS_DONE = 'done';
    public const STATUS_REVIEW = 'review';
}
