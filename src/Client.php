<?php
namespace Dungang\TaobaokeClient;

/**
 * 阿里妈妈淘宝客最简洁的API客户端
 *
 * 淘宝客pid组成介绍：pid=mm_1_2_3（其中1/2/3分别代表一串数字，举例pid=mm_98836808_12970065_68140878）
 * 说明：
 * 1这串数字对应淘宝客的账户id(通常称member)；
 * 2这串数字对应媒体管理中备案的网站或APP(统称site，包含网站ID、APPID)；
 * 3这串数字对应网站或APP中的具体推广位(通常称adzone)。
 * 
 * 每一个网站(网站ID)或APP(APPID)，均可申请自己的appkey，供对应网站/APP使用，
 * 调用api时系统会校验是否应用于对应网站ID或APPID。
 * 如果appkey不匹配或传递参数错误，会不算淘客交易，切记!
 * 
 * @author dungang<dungang@126.com>
 * @since 2019年12月10日
 *       
*
 * @link https://tbk.bbs.taobao.com/detail.html?appId=45301&postId=8127005
 * @link https://tbk.bbs.taobao.com/detail.html?postId=9239853&page=0&rndId=3382#M_1
 * @link https://tbk.bbs.taobao.com/detail.html?appId=45301&postId=8576096
 *      
 * @method array taobaoTbkItemInfoGet( array $params ) 
 * 输入批量商品id，查询对应淘宝客商品的详情页详细字段（简版）
 * 
 * @method array taobaoTbkCouponGet( array $params ) 
 * 输入商品ID+券ID，或者传入me参数，查询对应阿里妈妈推广券信息
 * 
 * @method array taobaoTbkItemRecommendGet( array $params ) 
 * 输入商品id，查询与此商品关联或相近的商品及商品详情页详细字段信息
 * 
 * @method array taobaoTbkShopRecommendGet( array $params ) 
 * 输入店铺id，查询与此店铺关联或相近的店铺及店铺店铺详情信息
 * 
 * @method array taobaoTbkDgMaterialOptional( array $params ) 
 * 输入pid(必选)、物料id或各种筛选字段，输出对应商品的店铺/商品/类目/券/拼团等详细字段信息
 * 
 * @method array taobaoTbkShopGet( array $params ) 
 * 淘宝客店铺查询
 * 
 * @method array taobaoTbkDgOptimusMaterial( array $params ) 
 * 输入pid、物料id，输出对应物料库的店铺/商品/类目/券/拼团等详细字段信息。
 * 【看material_id请点击】(聚划算/淘抢购/智能/好券直播/品牌券等物料均在此)
 * @link https://tbk.bbs.taobao.com/detail.html?appId=45301&postId=8576096
 * 
 * @method array taobaoTbkUatmFavoritesItemGet( array $params ) 
 * 指定选品库id，获取该选品库的宝贝信息
 * 
 * @method array taobaoTbkUatmFavoritesGet( array $params ) 
 * 枚举出淘宝客在淘宝联盟超级搜索、特色频道中，通过选品所创建的选品库列表
 * 
 * @method array taobaoTbkContentGet( array $params )
 * 图文物料获取和投放。输入adzoneid，输出达人和内容相关字段
 * 
 * @method array taobaoTbkContentEffectGet( array $params )
 * 图文物料的投放数据统计
 * 
 * @method array taobaoTbkItemWordGet( array $params )
 * 商品出词API，提供搜索结果页。
 * 
 * @method array taobaoTbkActivitylinkGet( array $params )
 * 从官方活动列表页取出“官方活动ID”，支持二方、三方
 * 
 * @method array taobaoTbkTpwdCreat( array $params )
 * 提供淘客生成淘口令接口，淘客输入口令内容、logo、url等参数，生成淘口令关键key
 * 如：￥SADadW￥，后续进行文案包装组装用于传播。输入商品信息，广告位信息，转成淘口令。
 * 目前淘口令的有效期是30天，我们的API没有做特殊逻辑，有效期等同于淘口令有效期
 * 
 * @method array taobaoTbkSpreadGet( array $params )
 * 输入一个原始的链接，转换得到指定的传播方式，
 * 如二维码，淘口令，短连接；现阶段只支持短连接。短连接有效期300天
 * 
 * @method array taobaoTbkCouponConvert( array $params )
 * 根据商品ID，Me参数，可查询最高佣金比例，券的相关数据，也可直接输出转链的二合一页面
 * 邀约制
 * 
 * @method array taobaoTbkItemConvert( array $params )
 * 普通商品转链，营销/定向/通用。媒体可以指定走什么计划，
 * 如果不传指定参数1进来，走营销，
 * 如果指定参数1，就走定向（若有关系）或通用
 * 邀约制
 * 
 * @method array taobaoTbkShopConvert( array $params )
 * 店铺转链接，通用计划
 * 邀约制
 * 
 * @method array taobaoTbkItemShareConvert( array $params )
 * 三方分成商品通用类链接或营销类链接
 * 邀约制
 * 
 * @method array taobaoTbkShopShareConvert( array $params )
 * 三方分成店铺转链接
 * 邀约制
 * 
 * @method array taobaoTbkScInviteCodeGet( array $params )
 * 邀请码生成功能
 * 
 * @method array taobaoTbkScPublisherInfoSave( array $params )
 * 根据邀请码，查询相应的渠道关系id或会员运营id
 * 
 * @method array taobaoTbkScPublisherInfoGet( array $params )
 * 输入渠道类型/会员类型，或再输入渠道关系id/会员运营id，查询对应各id备案填写的信息
 * 
 * @method array taobaoTbkDgNewuserOrderGet( array $params )
 * 查询拉新新人手机号、时间、订单、推广者等信息
 * 
 * @method array taobaoTbkDgNewuserOrderSum( array $params )
 * 输入pid和活动id，查看每个拉新活动对应的数据
 * 
 * @method array taobaoTbkOrderDetailsGet( array $params )
 * 输入查询时间，返回对应订单卖家、商品、金额、佣金、媒体等详细数据
 * 申请私域用户管理功能中开放。其他为邀约制
 * 
 * @method array taobaoTbkRelationRefund( array $params )
 * 维权退款的订单，支持二方和三方的渠道or会员订单
 * 申请私域用户管理功能中开放。其他为邀约制
 * 
 * @method array taobaoTbkPunishOrderGet( array $params )
 * 新增处罚订单查询API，提供媒体调用查询能力。
 * 申请私域用户管理功能中开放。其他为邀约制
 * 
 * @method array taobaoTbkDgVegasTljCreate( array $params )
 * 淘礼金创建,默认可申请，但需先申请淘礼金权限才可使用API
 * 
 * @method array taobaoTbkDgVegasTljInstanceReport( array $params )
 * 淘礼金引导的效果报表,默认可申请，但需先申请淘礼金权限才可使用API
 * 
  * @method array taobaoTbkJuTqgGet( array $params )
 * 获取淘抢购的数据，淘客商品转淘客链接，非淘客商品输出普通链接
 * 此接口并不在官方功能申请的列表中，但是可以用
 * 
  * @method array taobaoJuItemsSearch( array $params )
 * 聚划算商品搜索接口。此接口不在官方的功能申请列表中，可以调用但是一直没有结果
 * 文档提示默认可以使用
 * 提示 App Call Limited[This ban will last for 22238 more seconds
 * 先放着，也许可以用，不确定
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
     * @param array $params
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

