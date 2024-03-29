# TaobaokeClient

最简洁的淘宝客API客户端

## 安装

```sh
composer require dungang/taobaoke-client

```

## 使用

> 淘宝客pid组成介绍：pid=mm_1_2_3（其中1/2/3分别代表一串数字，举例pid=mm_98836808_12970065_68140878）
> 说明：
> 1这串数字对应淘宝客的账户id(通常称member)；
> 2这串数字对应媒体管理中备案的网站或APP(统称site，包含网站ID、APPID)；
> 3这串数字对应网站或APP中的具体推广位(通常称adzone)。
> 
> 每一个网站(网站ID)或APP(APPID)，均可申请自己的appkey，供对应网站/APP使用，
> 调用api时系统会校验是否应用于对应网站ID或APPID。
> 如果appkey不匹配或传递参数错误，会不算淘客交易，切记!

* 只用传递业务参数
* 方法参数不用传递，客户端自动识别，比如 获取商品详情的api为taobao.tbk.item.info.get,则执行的方法就是为taobaoTbkItemInfoGet
* 接口中的true和false都必须字符串，如：`'true'` `'false'` 而不是 `true` `false`

```php
$client = new Client('你的APP_KEY', '你的APP_SECRET');
try {
    $data = $client->taobaoTbkItemInfoGet(array(
        'num_iids' => '563889454088'
    ));
    echo "最后执行的完整的URL：" . $client->getLastRequestUrl() . "\n";
    echo "获取的数据：\n";
    print_r($data);
} catch (Exception $e) {
    echo $e->getMessage();
}
```

返回的结果

```sh

http://gw.api.taobao.com/router/rest?app_key=你的APP_KEY&format=json&method=taobao.tbk.item.info.get&num_iids=563889454088&sign_method=md5&timestamp=2019-12-10+13%3A43%3A18&v=2.0&sign=F8E64AE2D822B981C3445873C747E223
Array
(
    [results] => Array
        (
            [n_tbk_item] => Array
                (
                    [0] => Array
                        (
                            [cat_leaf_name] => 沐浴露
                            [cat_name] => 洗护清洁剂/卫生巾/纸/香薰
                            [item_url] => https://detail.tmall.com/item.htm?id=563889454088
                            [material_lib_type] => 1,2
                            [nick] => 阿迪达斯洗护旗舰店
                            [num_iid] => 563889454088
                            [pict_url] => https://img.alicdn.com/bao/uploaded/i3/3608420627/O1CN01aDLobQ1GVCuQXNfDX_!!0-item_pic.jpg
                            [presale_deposit] => 0
                            [presale_end_time] => 0
                            [presale_start_time] => 0
                            [presale_tail_end_time] => 0
                            [presale_tail_start_time] => 0
                            [provcity] => 广东 广州
                            [reserve_price] => 68
                            [seller_id] => 3608420627
                            [small_images] => Array
                                (
                                    [string] => Array
                                        (
                                            [0] => https://img.alicdn.com/i2/3608420627/O1CN011lYTFo1GVCuBI5EZc_!!3608420627.jpg
                                            [1] => https://img.alicdn.com/i4/3608420627/O1CN01h8SeXx1GVCpB36zUc_!!3608420627.jpg
                                            [2] => https://img.alicdn.com/i4/3608420627/O1CN01rx9Q261GVCrW3xQRq_!!3608420627.jpg
                                            [3] => https://img.alicdn.com/i4/3608420627/O1CN01zPfqcp1GVCrT7eNme_!!3608420627.jpg
                                        )

                                )

                            [title] => adidas/阿迪达斯男士激情沐浴露男薄荷香体持久留香家庭装沐浴液
                            [tmall_play_activity_end_time] => 0
                            [tmall_play_activity_start_time] => 0
                            [user_type] => 1
                            [volume] => 11315
                            [zk_final_price] => 35
                        )

                )

        )

    [request_id] => 107bswftpr56i
)

```


