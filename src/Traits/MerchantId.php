<?php
namespace CrowsFeet\HttpLogger\Traits;


trait MerchantId
{
    /**
     * 取得 Merchant ID
     *
     * @param  mixed  $request
     * @return string
     */
    private function getMerchantId($request)
    {
        return $request->input('MerchantID', '9999999');
    }
}