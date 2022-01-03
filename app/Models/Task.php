<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    const STATUS = [
        1 => ["label" => "未着手", "class" => "label-danger"],
        2 => ["label" => "着手中", "class" => "label-info"],
        3 => ["label" => "完了", "class" => ""],
    ];
    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        $status = $this->attributes["status"];
        // if not defined, return empty.
        if(!isset(self::STATUS[$status])) {
            return "";
        }
        return self::STATUS[$status]['label'];
    }
    /**
     * @return string
     */
    public function getStatusClassAttribute() {
        $status = $this->attributes["status"];
        if(!isset(self::STATUS[$status])) {
            return "";
        }
        return self::STATUS[$status]["class"];
    }
    /**
     * @return string
     */
    public function getFormattedDueDateAttribute() {
        return Carbon::createFromFormat("Y-m-d", $this->attributes["due_date"])
            ->format("Y/m/d");
    }
}
