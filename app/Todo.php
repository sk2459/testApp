<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [       //書き換えられるのはtitleカラムだけ　protected　同じクラス、派生したクラスでも使える
        'title','user_id'
    ];
// ここから
    public function getByUserId($id)
    {
    return $this->where('user_id', $id)->get();
    }
}
// ここまで追記
