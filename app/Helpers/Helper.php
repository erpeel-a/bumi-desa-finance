<?php 
namespace App\Helpers;
use DB;
class Helper{

  protected static $response = [
    'meta' => [
      'code' => 200,
      'status' => 'success',
      'message' => null
    ],
    'data' => null
  ];

  public static function number_to_price($value)
  {
      if (!$value) {
          return 0;
      }
      $value  = number_format($value, 2, ',', '.');
      return   $value;
  }

  public static function price_to_number($value)
  {
      if (!$value) {
          return 0;
      }
      $value = preg_replace('/[^0-9,]/', '', $value);
      $value = str_replace(',', '.', $value);
      $v = floatval($value);
      return $value;
  }

  public static function indonesian_date($date){
    $month = [
         1 =>   'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'November',
      'Desember'
    ];
    $split = explode('-', $date);
    // variabel split 0 = tanggal
    // variabel split 1 = bulan
    // variabel split 2 = tahun
    return $split[0] . ' ' . $month[ (int)$split[1] ] . ' ' . $split[2];
  }

  public static function IndoCurrency($request)
  {
    if ($request == '') {
        $number = 0;
    }
    $result = str_replace('.', '', $request);
    return number_format($result, 0, ".", ".");
  }

  public static  function FetchOneField($table, $field, $condition)			
  {				 
        $query = "select ". $field ." as item from ".$table." where ".$condition;						 
        $results = DB::select($query);			 
        $data = '';
        if (count($results) > 0) {					 				
         $data = $results[0]->item ;
        } 			 
        return $data; 
  } 
  	
  public static  function FetchSelectData($table, $condition)
  {	 
    $where = '';
    if ($condition != '') {
      $where = " where " . $condition;
    }
    $query = "select * from " . $table . $where;
    $results = DB::select($query);			 
    $data = '';
    if (count($results) > 0) {					 				
      $data = $results;
    } 			 
    return $data; 
  }

  public static function FetchDataToCombo($table, $condition, $field, $field_id, $choice = '')
  {
      $where = '';
      if ($condition != '') {
          $where = " where " . $condition;
      }
      $query = "select " . $field . " as nama," . $field_id . " as id from " . $table . $where;
      $execute = DB::select($query);
      $result = '<option value="" selected="true">' . $choice . '</option>';
      if (count($execute) > 0) {
          foreach ($execute as $item) {
              $result .= "<option value='" . $item->id . "'>" . $item->nama . "</option>";
          }
      }
      return $result;
  }

  public static function success($data = null, $message = null)
  {
    self::$response['meta']['message'] = $message;
    self::$response['data'] = $data;

    return response()->json(self::$response, self::$response['meta']['code']);
  }

  public static function error($data = null, $message = null, $code = 400)
  {
    self::$response['meta']['status'] = 'error';
    self::$response['meta']['code'] = $code;
    self::$response['meta']['message'] = $message;
    self::$response['data'] = $data;
    return response()->json(self::$response, self::$response['meta']['code']);
  }

}

?>
