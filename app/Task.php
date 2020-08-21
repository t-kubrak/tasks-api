<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $description
 * @property string $status
 * @property int $board_id
 * @property int $user_id
 * @property User $user
 */
class Task extends Model
{
    public const STATUS_BACKLOG = 'backlog';
    public const STATUS_DEVELOPMENT = 'development';
    public const STATUS_DONE = 'done';
    public const STATUS_REVIEW = 'review';

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
