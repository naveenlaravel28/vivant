<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use App\Models\Packing;
use Setting;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function sentResponse($code, $data, $message = null)
    {
        $response_array = [
            'code' => $code,
            'message' => $message,
            'data' => (!empty($data)) ? $data : [],
        ];

        return response()->json(self::convertNullsAsEmpty($response_array), $code);
    }

    public static function convertNullsAsEmpty($response_array)
    {
        array_walk_recursive($response_array, function (&$value, $key) {
            $value = is_int($value) ? (string) $value : $value;
            $value = $value === null ? '' : $value;
        });

        return $response_array;
    }

    public static function PlNoGenerate($master, $finYear = '')
    {
        $financialYear = $finYear;

        if(empty($fin_year)) {
            $financialYear = self::financialYear();
        }

        if(!empty($master)) {
            $financialYear .= '/'.$master->from.'/'.$master->to;
        }

        // $financialYear .= '/DC';

        $financialYear .= '/'.self::generateNumber(new Packing, 'pl_no', $financialYear, $master->starting_number);

        return $financialYear;
    }

    public static function financialYear()
    {
        $financialYearStartMonth = 4;
        $currentDate = Carbon::now();

        if ($currentDate->month >= $financialYearStartMonth) {

            $financialYear = $currentDate->year % 100 . '-' . ($currentDate->year + 1) % 100;
        } else {

            $financialYear = ($currentDate->year - 1) % 100 . '-' . $currentDate->year % 100;
        }

        return $financialYear;
    }

    public static function generateNumber($model, $column, $prev = '', $start_no = 1, $length = 4)
    {
        $count = $start_no;
        do {
            // $checkCount = $model->count();
            // $number = $checkCount + $count;
            // $number = (string)$number;
            // $number = str_pad($number, $length, '0', STR_PAD_LEFT);
            // $number = str_pad($count, $length, '0', STR_PAD_LEFT);
            $column_value = $count;
            if(!empty($prev)) {
                $column_value = $prev.'/'.$count;
            }
            $exists = $model->where($column, $column_value)->exists();
            if($exists) {
                $count++;
            }
        } while ($exists);
        return $count;
    }
}
