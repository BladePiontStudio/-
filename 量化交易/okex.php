<?php
/**
 * Created by PhpStorm.
 * User: randolfjay
 * Date: 2019-12-07
 * Time: 17:37
 */

namespace App\Lib;


use Exception;

class okex
{
    const API_KEY = "";
    const SECRET_KEY = "";
    const PASSPHRASE = "";
    const URL = 'http://www.okex.com';

    /**
     * 设置header GET
     * @param $path
     * @return array
     */
    public static function getHeader($path)
    {
        $time   = time() . '.021';
        $sign   = base64_encode(hash_hmac('sha256', $time . "GET" . $path, self::SECRET_KEY, true));
        $header = array(
            'contentType: application/json',
            'OK-ACCESS-KEY: ' . self::API_KEY,
            'OK-ACCESS-SIGN: ' . $sign,
            'OK-ACCESS-TIMESTAMP: ' . $time,
            'OK-ACCESS-PASSPHRASE:' . self::PASSPHRASE,
        );
        return $header;
    }

    /**
     * 设置header POST
     * @param $path
     * @param $body
     * @return array
     */
    public static function postHeader($path,$body)
    {
        $time   = time() . '.021';
        $sign   = base64_encode(hash_hmac('sha256', $time . "POST" . $path . json_encode($body), self::SECRET_KEY, true));
        $header = array(
            'contentType: application/json',
            'OK-ACCESS-KEY: ' . self::API_KEY,
            'OK-ACCESS-SIGN: ' . $sign,
            'OK-ACCESS-TIMESTAMP: ' . $time,
            'OK-ACCESS-PASSPHRASE:' . self::PASSPHRASE,
        );
        return $header;
    }

    public static function wallet()
    {
        try {
            $path   = "/api/account/v3/wallet";
            $client = new HttpClient(self::URL . $path);
            $result = $client->GET(array(), self::getHeader($path));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param string $underlying
     * @param null $after
     * @param null $before
     * @param int $limit
     * @param null $type
     * @return mixed|string
     */
    public static function ledger($underlying='btc-usdt',$after=null,$before=null,$limit=100,$type=null){
        try {
            $path   = "/api/futures/v3/accounts/{$underlying}/ledger";
            $client = new HttpClient(self::URL . $path);
            $result = $client->GET(array(), self::getHeader($path));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function futures_all_position()
    {
        try {
            $path   = "/api/futures/v3/position";
            $client = new HttpClient(self::URL . $path);
            $result = $client->GET(array(), self::getHeader($path));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 所有币种合约账户信息
     */
    public static function futures_all_accounts(){
        try {
            $path   = "/api/futures/v3/accounts";
            $client = new HttpClient(self::URL . $path);
            $result = $client->GET(array(), self::getHeader($path));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 获取交割合约k线数据
     * @param $instrument_id
     * @param $start
     * @param $end
     * @param $granularity
     * @return mixed|string
     */
    public static function futures_candles($instrument_id, $start, $end, $granularity)
    {
        try {
            $path   = "/api/futures/v3/instruments/{$instrument_id}/candles";
            $client = new HttpClient(self::URL . $path);
            $params = [
                'instrument_id' => $instrument_id,
                'start'         => $start,
                'end'           => $end,
                'granularity'   => $granularity,
            ];
            $result = $client->GET($params, self::getHeader($path));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 下单
     * @param string $client_oid  由您设置的订单ID来识别您的订单 ,类型为字母（大小写）+数字或者纯字母（大小写），1-32位字符
     * @param string $instrument_id  合约ID，如BTC-USD-180213 ,BTC-USDT-191227
     * @param int $type  1:开多 2:开空 3:平多 4:平空
     * @param int $order_type   0：普通委托（order type不填或填0都是普通委托） 1：只做Maker（Post only）    2：全部成交或立即取消（FOK）  3：立即成交并取消剩余（IOC）
     * @param double $price
     * @param int $size     张数
     * @param int $match_price
     * @return mixed|string
     */
    public static function futures_order($client_oid, $instrument_id, $type, $order_type, $price, $size, $match_price)
    {
        try {
            $path   = "/api/futures/v3/order";
            $client = new HttpClient(self::URL . $path);
            $params = [
                'instrument_id' => (string)$instrument_id,
                'type'          => (string)$type,
                'order_type'    => (string)$order_type,
                'price'         => (string)$price,
                'size'          => (string)$size,
                'match_price'   => (string)$match_price,
            ];
            $result = $client->POST(json_encode($params), self::postHeader($path,$params));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 撤单
     * @param string $instrument_id 合约ID，如BTC-USD-180213 ,BTC-USDT-191227
     * @param string $client_oid 由您设置的订单ID来识别您的订单 ,类型为字母（大小写）+数字或者纯字母（大小写），1-32位字符
     * @param string $order_id
     * @return mixed|string
     */
    public static function futures_cancel_order($instrument_id, $client_oid = '', $order_id = '')
    {
        try {
            if ($order_id != '') {
                $path   = "/api/futures/v3/cancel_order/{$instrument_id}/{$order_id}";
            } else {
                $path   = "/api/futures/v3/cancel_order/{$instrument_id}/{$client_oid}";
            }
            $client = new HttpClient(self::URL . $path);
            $params = [
                'order_id'=>$order_id,
                'instrument_id'=>$instrument_id
            ];
            $result = $client->POST(json_encode($params), self::postHeader($path, $params));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 下单
     * @param string $instrument_id 合约ID，如BTC-USD-180213 ,BTC-USDT-191227
     * @param string $client_oid 由您设置的订单ID来识别您的订单 ,类型为字母（大小写）+数字或者纯字母（大小写），1-32位字符
     * @param string $order_id
     * @return mixed|string
     */
    public static function futures_order_detail($instrument_id, $client_oid = '', $order_id = '')
    {
        try {
            if ($order_id != '') {
                $path   = "/api/futures/v3/orders/{$instrument_id}/{$order_id}";
            } else {
                $path   = "/api/futures/v3/orders/{$instrument_id}/{$client_oid}";
            }
            $client = new HttpClient(self::URL . $path);
            $result = $client->GET(null, self::getHeader($path));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 获取交割合约历史k线数据
     * @param string $instrument_id
     * @param int $resolution
     * @param $start_date
     * @param $end_date
     * @return mixed|string
     */
    public static function futures_history_candles($start_date, $end_date, $instrument_id='futures_okex.ltc.quarter', $resolution=15)
    {
        try {
            $url    = "https://www.quantinfo.com/API/m/history";
            $params = [
                'symbol'     => $instrument_id,
                'resolution' => $resolution,
                'from'       => $start_date,
                'to'         => $end_date,
                'size'       => 500,
            ];
            $client = new HttpClient($url);
            $result = $client->GET($params);
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 获取当前合约的最细信息
     * @param $instrument_id
     * @return mixed|string
     */
    public static function futures_ticker($instrument_id){
        try {
            $path    = "/api/futures/v3/instruments/{$instrument_id}/ticker";
            $client = new HttpClient(self::URL . $path);
            $result = $client->GET();
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 市价全平
     * @param string $instrument_id  合约ID，如BTC-USD-180213 ,BTC-USDT-191227
     * @param string $direction  long:平多 short:平空
     * @return mixed|string
     */
    public static function futures_close_position($instrument_id, $direction)
    {
        try {
            $path   = "/api/futures/v3/close_position";
            $client = new HttpClient(self::URL . $path);
            $params = [
                'instrument_id' => (string)$instrument_id,
                'direction'     => (string)$direction,
            ];
            $result = $client->POST(json_encode($params), self::postHeader($path,$params));
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 普通日期转iso格式日期
     * @param $date
     * @return false|string
     */
    public static function date_iso($date){
        return date('Y-m-d\TH:i:s\Z', strtotime($date) - date('Z'));
    }

    /**
     * ios格式日期转普通格式日期
     * @param $ios_date
     * @param string $format
     * @return false|string
     */
    public static function ios_date($ios_date,$format='Y-m-d H:i:s'){
        return date($format,strtotime($ios_date));
    }

    /**
     * 获取现货价格
     * @param $instrument_id
     * @return mixed|string
     */
    public static function getCoinPrice($instrument_id)
    {
        try {
            $path   = "/api/spot/v3/instruments/{$instrument_id}/ticker";
            $client = new HttpClient(self::URL . $path);
            $result = $client->GET();
            return json_decode($result, true);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}