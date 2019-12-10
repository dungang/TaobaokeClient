<?php
namespace Dungang\TaobaokeClient;

/**
 * 阿里妈妈淘宝客最简洁的API客户端
 *
 * @author dungang<dungang@126.com>
 * @since 2019年12月10日
 *       
 * @link https://open.taobao.com/api.htm?docId=24515&docType=2
 *      
 * @method array taobaoTbkItemRecommendGet(array $params) 淘宝客商品关联推荐查询
 * @method array taobaoTbkItemInfoGet(array $params) 淘宝客商品详情（简版）
 * @method array taobaoTbkShopGet(array $params) 淘宝客店铺查询
 * @method array taobaoTbkShopRecommendGet(array $params) 淘宝客店铺关联推荐查询
 * @method array taobaoTbkUatmFavoritesItemGet(array $params) 获取淘宝联盟选品库的宝贝信息
 * @method array taobaoTbkUatmFavoritesGet(array $params) 获取淘宝联盟选品库列表
 * @method array taobaoTbkJuTqgGet(array $params) 淘抢购api 获取淘抢购的数据，淘客商品转淘客链接，非淘客商品输出普通链接
 * @method array taobaoTbkItemClickExtract(array $params) 从长链接或短链接中解析出open_iid
 * @method array taobaoTbkItemGuessLike(array $params) 淘宝客猜你喜欢商品API
 * @method array taobaoTbkCouponGet(array $params) 阿里妈妈推广券信息查询
 * @method array taobaoTbkTpwdCreate(array $params) 提供淘客生成淘口令接口，淘客提交口令内容、logo、url等参数，生成淘口令关键key如：￥SADadW￥，后续进行文案包装组装用于传播
 * @method array taobaoTbkDgItemCouponGet(array $params) 好券清单API【导购】
 * @method array taobaoTbkDgNewuserOrderGet(array $params) 淘宝客新用户订单API--导购
 * @method array taobaoTbkDgNewuserOrderSum(array $params) 拉新活动汇总API--导购
 * @method array taobaoTbkDgMaterialOptional(array $params) 通用物料搜索API（导购）
 * @method array taobaoTbkDgOptimusMaterial(array $params) 淘宝客物料下行-导购
 * @method array taobaoTbkDgPunishOrderGet(array $params) 处罚订单查询 -导购-私域用户管理专用
 * @method array taobaoTbkScNewuserOrderGet(array $params) 淘宝客新用户订单API--社交
 * @method array taobaoTbkScNewuserOrderSum(array $params) 拉新活动汇总API--社交
 * @method array taobaoTbkScOptimusMaterial(array $params) 淘宝客擎天柱通用物料API - 社交 ,通用物料推荐，传入官方公布的物料id，可获取指定物料
 * @method array taobaoTbkScActivitylinkToolget(array $params) 淘宝联盟官方活动推广API-工具，从官方活动列表页取出活动页面链接，支持二方、三方
 * @method array taobaoTbkActivitylinkGet(array $params) 淘宝联盟官方活动推广API-媒体，从官方活动列表页取出活动页面链接，支持二方、三方
 */
class Client
{

    /**
     * 公共请求参数
     *
     * @var array
     */
    private $commonParams;

    /**
     * 最后一次请求的地址
     *
     * @var string
     */
    private $lastRequestUrl;

    /**
     * 应用SECRET秘钥
     *
     * @var string
     */
    private $app_secret;

    /**
     * 淘宝客API网关
     *
     * @var string
     */
    private $gateway;

    /**
     * 构造方法
     *
     * @param string $app_key
     *            应用KEY
     * @param string $app_secret
     *            应用SECRET秘钥
     * @param string $gateway
     *            API网关 默认是官方的生成环境地址：http://gw.api.taobao.com/router/rest
     */
    public function __construct($app_key, $app_secret, $gateway = 'http://gw.api.taobao.com/router/rest')
    {
        // $this->app_key = $app_key;
        $this->app_secret = $app_secret;
        $this->gateway = $gateway;
        $this->commonParams = array(
            'app_key' => $app_key,
            'timestamp' => date('Y-m-d H:i:s'),
            'format' => 'json',
            'sign_method' => 'md5',
            'v' => '2.0'
        );
    }

    /**
     * 获取本次请求的url地址
     *
     * @return string
     */
    public function getLastRequestUrl()
    {
        return $this->lastRequestUrl;
    }

    /**
     * 签名参数，再参数列表中添加sign的值
     *
     * @param array $params
     *            待签名的参数
     * @return array
     */
    protected function sign($params)
    {
        unset($params['sign']);
        $params = \array_filter($params, function ($v, $k) {
            return null != $v && '' != $v;
        }, ARRAY_FILTER_USE_BOTH);
        \ksort($params);
        $kvs = array();
        foreach ($params as $k => $v) {
            $kvs[] = $k . $v;
        }
        $params['sign'] = strtoupper(md5($this->app_secret . implode('', $kvs) . $this->app_secret));
        return $params;
    }

    /**
     * 执行Http Get 请求
     * 应为API的都是读取数据，则主要是GET请求
     *
     * @param array $params
     *            请求的所有参数数组
     * @throws \Exception
     * @return NULL|array
     */
    protected function execute($params)
    {
        $params = $this->sign(\array_merge($this->commonParams, $params));
        if ($data = $this->requestGet($params)) {
            if (isset($data['error_response'])) {
                $error = $data['error_response'];
                $msg = isset($error['sub_msg']) ? $error['msg'] . '[' . $error['sub_msg'] . ']' : $error['msg'];
                throw new \Exception($msg);
            } else {
                $key = \str_replace('.', '_', \str_replace('taobao.', '', $params['method'])) . '_response';
                if (isset($data[$key])) {
                    return $data[$key];
                }
            }
        }
        return null;
    }

    /**
     * 魔法调用具体的淘客api
     *
     * @param string $name
     * @param string $params
     * @return mixed
     */
    public function __call($name, $params)
    {
        $params[0]['method'] = \strtolower(preg_replace("/([A-Z])/", ".\\1", $name));
        return \call_user_func_array(array(
            $this,
            'execute'
        ), $params);
    }

    private function requestGet($data = array(), $headers = array())
    {
        $headers = array_merge(array(
            'Accept' => 'application/json',
            'Content-Type' => 'application/json;charset=utf-8'
        ), $headers);
        $this->lastRequestUrl = $this->gateway . '?' . http_build_query($data);
        $result = null;
        $httpCode = 500;
        if (! function_exists("curl_init")) {
            $ch = curl_init($this->lastRequestUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } else {
            $_headers = array();
            foreach ($headers as $key => $val) {
                $_headers[] = $key . ': ' . $val . "\r\n";
            }
            $http_response_header = null;
            $result = @file_get_contents($this->lastRequestUrl, false, stream_context_create(array(
                'http' => array(
                    'method' => 'GET',
                    'header' => $_headers
                )
            )));
            if (substr($http_response_header[0], - 2) == 'OK') {
                $httpCode = 200;
            }
        }
        if ($httpCode == 200) {
            return json_decode($result, true);
        }
        return $result;
    }
}

