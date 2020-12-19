<?php

namespace App\Exceptions\API;

use Exception;

class ShiftDateRangeIntersectFound extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        $msg = "Для указзанного диапазона дат существуют пересекающиеся смены";
        return response()->json([
            'message'   =>  $this->message,
            'errors'    => array(                
                'date_begin'    =>  array($msg),
                'date_end'      =>  array($msg)
            )
        ], 422);    
    }
}
