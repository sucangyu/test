<?php
/**
 * Created by PhpStorm.
 * User: huyh
 * Date: 2017/5/16
 * Time: 14:32
 * Use:公共类库
 */

/* 根据标识获取配置信息或更新配置信息 */
function getConfig($inc_type,$data = array())
{
    $config = array();
    $res = M('Config')->where("inc_type='$inc_type'")->select();
    if($res)
    {
        foreach($res as $k=>$val)
        {
            $config[$val['name']] = $val['value'];
        }
    }

    if(!empty($data))
    {
        if($config){
            foreach ($data as $k=>$v)
            {
                $newArr = array('name'=>$k,'value'=>trim($v),'inc_type'=>$inc_type);
                if(!isset($config[$k]))
                {
                    M('Config')->add($newArr);//缓存key存在且值有变更新此项
                }else
                {
                    if($data[$k]!=$config[$k])
                    {
                        M('Config')->where("name='$k'")->save($newArr);//缓存key存在且值有变更新此项
                    }
                }
            }
            //更新后的数据库记录
            $newRes = M('Config')->where("inc_type='$inc_type'")->select();
            foreach ($newRes as $rs)
            {
                $config[$rs['name']] = $rs['value'];
            }
        }
    }

    return $config;
}

/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to,$subject='',$content=''){
    require_once THINK_PATH.'Library/Vendor/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $config = getConfig('smtp');
    $mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //调试输出格式
    //$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];

    if($mail->Port === 465) $mail->SMTPSecure = 'ssl';// 使用安全协议
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //用户名
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if(is_array($to)){
        foreach ($to as $v){
            $mail->addAddress($v);
        }
    }else{
        $mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';
    //添加附件
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    return $mail->send();
}

/**
 * 记录帐户变动
 * @param   int     $user_id        用户id
 * @param   float   $user_money     可用余额变动
 * @param   int     $pay_points     消费积分变动
 * @param   string  $desc    变动说明
 * @param   float   distribut_money 分佣金额
 * @return  bool
 */
function accountLog($user_id, $user_money = 0,$pay_points = 0, $desc = '',$distribut_money = 0)
{
    /* 插入帐户变动记录 */
    $account_log = array(
        'mid'       => $user_id,
        'user_money'    => $user_money,
        'pay_points'    => $pay_points,
        'regtime'   => time(),
        'memo'   => $desc,
    );
    /* 更新用户信息 */
    $sql = "UPDATE __PREFIX__member SET user_money = user_money + $user_money," .
        " pay_points = pay_points + $pay_points, distribut_money = distribut_money + $distribut_money WHERE id = $user_id";

    M()->startTrans();
    $res1 = 1;
    $res2 = 1;

    $res1 =  M('Member')->execute($sql);
    if($res1)
    {
        $res2 = M('Translog')->add($account_log);
    }

    if($res1 && $res2)
    {
        M()->commit();
        return 1;
    }else
    {
        M()->rollback();
        return 0;
    }
}

/**
 * 获取某个商品分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
function getCatGrandson ($cat_id)
{
    $GLOBALS['catGrandson'] = array();
    $GLOBALS['category_id_arr'] = array();
    // 先把自己的id 保存起来
    $GLOBALS['catGrandson'][] = $cat_id;
    // 把整张表找出来
    $GLOBALS['category_id_arr'] = M('GoodsCategory')->cache(true,DSSHOP_CACHE_TIME)->getField('id,parent_id');
    // 先把所有儿子找出来
    $son_id_arr = M('GoodsCategory')->where("parent_id = $cat_id")->cache(true,TPSHOP_CACHE_TIME)->getField('id',true);
    foreach($son_id_arr as $k => $v)
    {
        getCatGrandson2($v);
    }
    return $GLOBALS['catGrandson'];
}

/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
function getCatGrandson2($cat_id)
{
    $GLOBALS['catGrandson'][] = $cat_id;
    foreach($GLOBALS['category_id_arr'] as $k => $v)
    {
        // 找到孙子
        if($v == $cat_id)
        {
            getCatGrandson2($k); // 继续找孙子
        }
    }
}

/**
 * 刷新商品库存, 如果商品有设置规格库存, 则商品总库存 等于 所有规格库存相加
 * @param type $goods_id  商品id
 */
function refresh_stock($goods_id){
    $count = M("SpecGoodsPrice")->where("goods_id = $goods_id")->count();
    if($count == 0) return false; // 没有使用规格方式 没必要更改总库存

    $store_count = M("SpecGoodsPrice")->where("goods_id = $goods_id")->sum('store_count');
    M("Goods")->where("goods_id = $goods_id")->save(array('store_count'=>$store_count)); // 更新商品的总库存
}

/**
 * 计算订单金额
 * @param type $user_id  用户id
 * @param type $order_goods  购买的商品
 * @param type $shipping  物流code
 * @param type $shipping_price 物流费用, 如果传递了物流费用 就不在计算物流费
 * @param type $province  省份
 * @param type $city 城市
 * @param type $district 县
 * @param type $pay_points 积分
 * @param type $user_money 余额
 * @param type $coupon_id  优惠券
 * @param type $couponCode  优惠码
 */

function calculate_price($user_id=0,$order_goods,$shipping_code='',$shipping_price=0,$province=0,$city=0,$district=0,$pay_points=0,$user_money=0,$coupon_id=0,$couponCode='')
{
    $cartLogic = new \Home\Logic\CartLogic();
    $user = M('Member')->where("id = $user_id")->find();// 找出这个用户

    if(empty($order_goods))
        return array('status'=>-9,'msg'=>'商品列表不能为空','result'=>'');

    $goods_id_arr = get_arr_column($order_goods,'goods_id');
    $goods_arr = M('Goods')->where("goods_id in(".  implode(',',$goods_id_arr).")")->getField('goods_id,weight,market_price,is_free_shipping'); // 商品id 和重量对应的键值对

    foreach($order_goods as $key => $val)
    {
        // 如果传递过来的商品列表没有定义会员价
        if(!array_key_exists('member_goods_price',$val))
        {
            $user['discount'] = $user['discount'] ? $user['discount'] : 1; // 会员折扣 不能为 0
            $order_goods[$key]['member_goods_price'] = $val['member_goods_price'] = $val['goods_price'] * $user['discount'];
        }
        //如果商品不是包邮的
        if($goods_arr[$val['goods_id']]['is_free_shipping'] == 0)
            $goods_weight += $goods_arr[$val['goods_id']]['weight'] * $val['goods_num']; //累积商品重量 每种商品的重量 * 数量

        $order_goods[$key]['goods_fee'] = $val['goods_num'] * $val['member_goods_price'];    // 小计
        $order_goods[$key]['store_count']  = getGoodNum($val['goods_id'],$val['spec_key']); // 最多可购买的库存数量
        if($order_goods[$key]['store_count'] <= 0)
            return array('status'=>-10,'msg'=>$order_goods[$key]['goods_name']."库存不足,请重新下单",'result'=>'');

        $goods_price += $order_goods[$key]['goods_fee']; // 商品总价
        $cut_fee     += $val['goods_num'] * $val['market_price'] - $val['goods_num'] * $val['member_goods_price']; // 共节约
        $anum        += $val['goods_num']; // 购买数量
    }

    // 优惠券处理操作
    $coupon_price = 0;
    if($coupon_id && $user_id)
    {
        $coupon_price = $cartLogic->getCouponMoney($user_id, $coupon_id,1); // 下拉框方式选择优惠券
    }
    if($couponCode && $user_id)
    {
        $coupon_result = $cartLogic->getCouponMoneyByCode($couponCode,$goods_price); // 根据 优惠券 号码获取的优惠券
        if($coupon_result['status'] < 0)
            return $coupon_result;
        $coupon_price = $coupon_result['result'];
    }
    $conF = getConfig('shopping');
    // 处理物流
    if($shipping_price == 0)
    {
        $shipping_price = $cartLogic->cart_freight2($shipping_code,$province,$city,$district,$goods_weight);

        $freight_free = $conF['freight_free']; // 全场满多少免运费
        if($freight_free > 0 && $goods_price >= $freight_free)
            $shipping_price = 0;
    }

    if($pay_points && ($pay_points > $user['pay_points']))
        return array('status'=>-5,'msg'=>"你的账户可用积分为:".$user['pay_points'],'result'=>''); // 返回结果状态
    if($user_money  && ($user_money > $user['user_money']))
        return array('status'=>-6,'msg'=>"你的账户可用余额为:".$user['user_money'],'result'=>''); // 返回结果状态

    $order_amount = $goods_price + $shipping_price - $coupon_price; // 应付金额 = 商品价格 + 物流费 - 优惠券

    $pay_points = ($pay_points / $conF['point_rate']); // 积分支付 100 积分等于 1块钱
    $pay_points = ($pay_points > $order_amount) ? $order_amount : $pay_points; // 假设应付 1块钱 而用户输入了 200 积分 2块钱, 那么就让 $pay_points = 1块钱 等同于强制让用户输入1块钱
    $order_amount = $order_amount - $pay_points; //  积分抵消应付金额

    $user_money = ($user_money > $order_amount) ? $order_amount : $user_money;  // 余额支付原理等同于积分
    $order_amount = $order_amount - $user_money; //  余额支付抵应付金额

    $total_amount = $goods_price + $shipping_price;
    //订单总价  应付金额  物流费  商品总价 节约金额 共多少件商品 积分  余额  优惠券
    $result = array(
        'total_amount'      => $total_amount, // 商品总价
        'order_amount'      => $order_amount, // 应付金额
        'shipping_price'    => $shipping_price, // 物流费
        'goods_price'       => $goods_price, // 商品总价
        'cut_fee'           => $cut_fee, // 共节约多少钱
        'anum'              => $anum, // 商品总共数量
        'integral_money'    => $pay_points,  // 积分抵消金额
        'user_money'        => $user_money, // 使用余额
        'coupon_price'      => $coupon_price,// 优惠券抵消金额
        'order_goods'       => $order_goods, // 商品列表 多加几个字段原样返回
    );
    return array('status'=>1,'msg'=>"计算价钱成功",'result'=>$result); // 返回结果状态
}

/**
 * 获取商品库存
 * @param type $goods_id 商品id
 * @param type $key  库存 key
 */
function getGoodNum($goods_id,$key)
{
    if(!empty($key))
        return  M("SpecGoodsPrice")->where("goods_id = $goods_id and `key` = '$key'")->getField('store_count');
    else
        return  M("Goods")->where("goods_id = $goods_id")->getField('store_count');
}

/**
 * 支付完成修改订单
 * $order_sn 订单号
 * $pay_status 默认1 为已支付
 */
function update_pay_status($order_sn,$pay_status = 1)
{
    if(stripos($order_sn,'recharge') !== false)
    {
        //用户在线充值
        $count = M('Recharge')->where("order_sn = '$order_sn' and pay_status = 0")->count();   // 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
        if($count == 0) return false;
        $order = M('Recharge')->where("order_sn = '$order_sn'")->find();
        M('Recharge')->where("order_sn = '$order_sn'")->save(array('pay_status'=>1,'pay_time'=>time()));
        accountLog($order['user_id'],$order['account'],0,'会员在线充值');
    }else{
        // 如果这笔订单已经处理过了
        $count = M('Order')->where("order_sn = '$order_sn' and pay_status = 0")->count();   // 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
        if($count == 0) return false;
        // 找出对应的订单
        $order = M('Order')->where("order_sn = '$order_sn'")->find();
        // 修改支付状态  已支付
        M('Order')->where("order_sn = '$order_sn'")->save(array('pay_status'=>1,'pay_time'=>time()));
        // 减少对应商品的库存
        minus_stock($order['order_id']);
        // 给他升级, 根据order表查看消费记录 给他会员等级升级 修改他的折扣 和 总金额
        update_user_level($order['user_id']);
        // 记录订单操作日志
        logOrder($order['order_id'],'订单付款成功','付款成功',$order['user_id']);
        //分销设置
        M('Rebate_log')->where("order_id = {$order['order_id']}")->save(array('status'=>1));
        // 成为分销商条件
        $conF = getConfig('distribut');
        $distribut_condition = $conF['condition'];
        if($distribut_condition == 1)  // 购买商品付款才可以成为分销商
            M('Member')->where("id = {$order['user_id']}")->save(array('is_distribut'=>1));
    }
}

/**
 * 订单确认收货
 * @param $id   订单id
 */
function confirm_order($id,$user_id = 0){

    $where = "order_id = $id";
    $user_id && $where .= " and user_id = $user_id ";

    $order = M('Order')->where($where)->find();
    if($order['order_status'] != 1)
        return array('status'=>-1,'msg'=>'该订单不能收货确认');

    $data['order_status'] = 2; // 已收货
    $data['pay_status'] = 1; // 已付款
    $data['confirm_time'] = time(); // 收货确认时间
    if($order['pay_code'] == 'cod'){
        $data['pay_time'] = time();
    }
    $row = M('Order')->where(array('order_id'=>$id))->save($data);
    if(!$row)
        return array('status'=>-3,'msg'=>'操作失败');

    order_give($order);// 调用送礼物方法, 给下单这个人赠送相应的礼物

    //分销设置
    M('Rebate_log')->where("order_id = $id")->save(array('status'=>2,'confirm'=>time()));

    return array('status'=>1,'msg'=>'操作成功');
}

/**
 * 给订单送券送积分 送东西
 */
function order_give($order)
{
    $order_goods = M('Order_goods')->where("order_id=".$order['order_id'])->cache(true)->select();
    //查找购买商品送优惠券活动
    foreach ($order_goods as $val)
    {
        if($val['prom_type'] == 3)
        {
            $prom = M('Prom_goods')->where('type=3 and id='.$val['prom_id'])->find();
            if($prom){
                $coupon = M('Coupon')->where("id=".$prom['expression'])->find();//查找优惠券模板
                if($coupon && $coupon['createnum']>0){
                    $remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
                    if($remain > 0)
                    {
                        $data = array('cid'=>$coupon['id'],'type'=>$coupon['type'],'uid'=>$order['user_id'],'send_time'=>time());
                        M('Coupon_list')->add($data);
                        M('Coupon')->where("id = {$coupon['id']}")->setInc('send_num'); // 优惠券领取数量加一
                    }
                }
            }
        }
    }

    //查找订单满额送优惠券活动
    $pay_time = $order['pay_time'];
    $prom = M('Prom_order')->where("type>1 and end_time>$pay_time and start_time<$pay_time and money<=".$order['order_amount'])->order('money desc')->find();
    if($prom){
        if($prom['type']==3){
            $coupon = M('Coupon')->where("id=".$prom['expression'])->find();//查找优惠券模板
            if($coupon){
                if($coupon['createnum']>0){
                    $remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
                    if($remain > 0)
                    {
                        $data = array('cid'=>$coupon['id'],'type'=>$coupon['type'],'uid'=>$order['user_id'],'send_time'=>time());
                        M('Coupon_list')->add($data);
                        M('Coupon')->where("id = {$coupon['id']}")->setInc('send_num'); // 优惠券领取数量加一
                    }
                }
            }
        }else if($prom['type']==2){
            accountLog($order['user_id'], 0 , $prom['expression'] ,"订单活动赠送积分");
        }
    }
    $points = M('Order_goods')->where("order_id = {$order[order_id]}")->sum("give_integral * goods_num");
    $points && accountLog($order['user_id'], 0,$points,"下单赠送积分");
}


/**
 * 查看商品是否有活动
 * @param goods_id 商品ID
 */

function get_goods_promotion($goods_id,$user_id=0){
    $now = time();
    $goods = M('Goods')->where("goods_id=$goods_id")->find();
    $where = "end_time>$now and start_time<$now and id=".$goods['prom_id'];

    $prom['price'] = $goods['shop_price'];
    $prom['prom_type'] = $goods['prom_type'];
    $prom['prom_id'] = $goods['prom_id'];
    $prom['is_end'] = 0;

    if($goods['prom_type'] == 1)
    {//抢购
        $prominfo = M('Flash_sale')->where($where)->find();
        if(!empty($prominfo))
        {
            if($prominfo['goods_num'] == $prominfo['buy_num'])
            {
                $prom['is_end'] = 2;//已售馨
            }else
            {
                //核查用户购买数量
                $where = "user_id = $user_id and order_status!=3 and  add_time>".$prominfo['start_time']." and add_time<".$prominfo['end_time'];
                $order_id_arr = M('Order')->where($where)->getField('order_id',true);
                if($order_id_arr){
                    $goods_num = M('Order_goods')->where("prom_id={$goods['prom_id']} and prom_type={$goods['prom_type']} and order_id in (".implode(',', $order_id_arr).")")->sum('goods_num');
                    if($goods_num < $prominfo['buy_limit'])
                    {
                        $prom['price'] = $prominfo['price'];
                    }
                }else
                {
                    $prom['price'] = $prominfo['price'];
                }
            }
        }
    }

    if($goods['prom_type']==2)
    {//团购
        $prominfo = M('Group_buy')->where($where)->find();
        if(!empty($prominfo))
        {
            if($prominfo['goods_num'] == $prominfo['buy_num'])
            {
                $prom['is_end'] = 2;//已售馨
            }else
            {
                $prom['price'] = $prominfo['price'];
            }
        }
    }
    if($goods['prom_type'] == 3){//优惠促销
        $parse_type = array('0'=>'直接打折','1'=>'减价优惠','2'=>'固定金额出售','3'=>'买就赠优惠券','4'=>'买M件送N件');
        $prominfo = M('Prom_goods')->where($where)->find();
        if(!empty($prominfo))
        {
            if($prominfo['type'] == 0)
            {
                $prom['price'] = $goods['shop_price']*$prominfo['expression']/100;//打折优惠
            }elseif($prominfo['type'] == 1)
            {
                $prom['price'] = $goods['shop_price']-$prominfo['expression'];//减价优惠
            }elseif($prominfo['type']==2)
            {
                $prom['price'] = $prominfo['expression'];//固定金额优惠
            }
        }
    }

    if(!empty($prominfo))
    {
        $prom['start_time'] = $prominfo['start_time'];
        $prom['end_time'] = $prominfo['end_time'];
    }else
    {
        $prom['prom_type'] = $prom['prom_id'] = 0 ;//活动已过期
        $prom['is_end'] = 1;//已结束
    }

    if($prom['prom_id'] == 0)
    {
        M('Goods')->where("goods_id=$goods_id")->save($prom);
    }
    return $prom;
}

/**
 * 更新会员等级,折扣，消费总额
 * @param $user_id  用户ID
 * @return boolean
 */
function update_user_level($user_id)
{
    $level_info = M('Member_level')->order('id')->select();
    $total_amount = M('Order')->where("user_id=$user_id AND pay_status=1 and order_status not in (3,5)")->sum('order_amount');
    if($level_info)
    {
        foreach($level_info as $k=>$v)
        {
            if($total_amount >= $v['amount']){
                $level = $level_info[$k]['level_id'];
                $discount = $level_info[$k]['discount']/100;
            }
        }
//        $user = session('user');
        $user = M('Member')->find($user_id);
        $updata['total_amount'] = $total_amount;//更新累计修复额度
        //累计额度达到新等级，更新会员折扣
        if(isset($level) && $level>$user['level'])
        {
            $updata['level'] = $level;
            $updata['discount'] = $discount;
        }
        M('Member')->where("id=$user_id")->save($updata);
    }
}

/**
 * 订单操作日志
 * 参数示例
 * @param type $order_id  订单id
 * @param type $action_note 操作备注
 * @param type $status_desc 操作状态  提交订单, 付款成功, 取消, 等待收货, 完成
 * @param type $user_id  用户id 默认为管理员
 * @return boolean
 */
function logOrder($order_id,$action_note,$status_desc,$user_id = 0)
{
    $status_desc_arr = array('提交订单', '付款成功', '取消', '等待收货', '完成','退货');
    // if(!in_array($status_desc, $status_desc_arr))
    // return false;

    $order = M('Order')->where("order_id = $order_id")->find();
    $action_info = array(
        'order_id'        =>$order_id,
        'action_user'     =>$user_id,
        'order_status'    =>$order['order_status'],
        'shipping_status' =>$order['shipping_status'],
        'pay_status'      =>$order['pay_status'],
        'action_note'     => $action_note,
        'status_desc'     =>$status_desc, //''
        'log_time'        =>time(),
    );
    return M('Order_action')->add($action_info);
}

/**
 * 根据 order_goods 表扣除商品库存
 * @param type $order_id  订单id
 */
function minus_stock($order_id)
{
    $orderGoodsArr = M('OrderGoods')->where("order_id = $order_id")->select();
    foreach($orderGoodsArr as $key => $val)
    {
        // 有选择规格的商品
        if(!empty($val['spec_key']))
        {   // 先到规格表里面扣除数量 再重新刷新一个 这件商品的总数量
            M('SpecGoodsPrice')->where("goods_id = {$val['goods_id']} and `key` = '{$val['spec_key']}'")->setDec('store_count',$val['goods_num']);
            refresh_stock($val['goods_id']);
        }else{
            M('Goods')->where("goods_id = {$val['goods_id']}")->setDec('store_count',$val['goods_num']); // 直接扣除商品总数量
        }
        M('Goods')->where("goods_id = {$val['goods_id']}")->setInc('sales_sum',$val['goods_num']); // 增加商品销售量
        //更新活动商品购买量
        if($val['prom_type']==1 || $val['prom_type']==2){
            $prom = get_goods_promotion($val['goods_id']);
            if($prom['is_end']==0){
                $tb = $val['prom_type']==1 ? 'flash_sale' : 'group_buy';
                M($tb)->where("id=".$val['prom_id'])->setInc('buy_num',$val['goods_num']);
                M($tb)->where("id=".$val['prom_id'])->setInc('order_num');
            }
        }
    }
}

/**
 * 将二维数组以元素的某个值作为键 并归类数组
 * array( array('name'=>'aa','type'=>'pay'), array('name'=>'cc','type'=>'pay') )
 * array('pay'=>array( array('name'=>'aa','type'=>'pay') , array('name'=>'cc','type'=>'pay') ))
 * @param $arr 数组
 * @param $key 分组值的key
 * @return array
 */
function group_same_key($arr,$key)
{
    $new_arr = array();
    foreach($arr as $k=>$v ){
        $new_arr[$v[$key]][] = $v;
    }
    return $new_arr;
}

/**
 * 获取用户信息
 * @param $user_id_or_name  用户id 邮箱 手机 第三方id
 * @param int $type  类型 0 user_id查找 1 邮箱查找 2 手机查找 3 第三方唯一标识查找
 * @param string $oauth  第三方来源
 * @return mixed
 */
function get_user_info($user_id_or_name,$type = 0,$oauth=''){
    $map = array();
    if($type == 0)
        $map['id'] = $user_id_or_name;
    if($type == 1)
        $map['email'] = $user_id_or_name;
    if($type == 2)
        $map['mobile'] = $user_id_or_name;
    if($type == 3){
        $map['openid'] = $user_id_or_name;
        $map['oauth'] = $oauth;
    }
    $user = M('Member')->where($map)->find();
    return $user;
}

/**
 * 获取商品一二三级分类
 * @return type
 */
function get_goods_category_tree(){
    $result = array();
    $cat_list = M('Goods_category')->where("is_show = 1")->order('sort_order')->cache(true)->select();//所有分类

    foreach ($cat_list as $val){
        if($val['level'] == 2){
            $arr[$val['parent_id']][] = $val;
        }
        if($val['level'] == 3){
            $crr[$val['parent_id']][] = $val;
        }
        if($val['level'] == 1){
            $tree[] = $val;
        }
    }

    foreach ($arr as $k=>$v){
        foreach ($v as $kk=>$vv){
            $arr[$k][$kk]['sub_menu'] = empty($crr[$vv['id']]) ? array() : $crr[$vv['id']];
        }
    }

    foreach ($tree as $val){
        $val['tmenu'] = empty($arr[$val['id']]) ? array() : $arr[$val['id']];
        $result[$val['id']] = $val;
    }
    return $result;
}

/**
 *  商品缩略图 给于标签调用 拿出商品表的 original_img 原始图来裁切出来的
 * @param type $goods_id  商品id
 * @param type $width     生成缩略图的宽度
 * @param type $height    生成缩略图的高度
 */
function goods_thum_images($goods_id,$width,$height){

    if(empty($goods_id))
        return 'abc';
    //判断缩略图是否存在
    $path = "/Public/upload/goods/thumb/$goods_id/";
    $goods_thumb_name ="goods_thumb_{$goods_id}_{$width}_{$height}";

    // 这个商品 已经生成过这个比例的图片就直接返回了
    if(file_exists($path.$goods_thumb_name.'.jpg'))  return '/'.$path.$goods_thumb_name.'.jpg';
    if(file_exists($path.$goods_thumb_name.'.jpeg')) return '/'.$path.$goods_thumb_name.'.jpeg';
    if(file_exists($path.$goods_thumb_name.'.gif'))  return '/'.$path.$goods_thumb_name.'.gif';
    if(file_exists($path.$goods_thumb_name.'.png'))  return '/'.$path.$goods_thumb_name.'.png';

    $original_img = M('Goods')->where("goods_id = $goods_id")->getField('original_img');
    if(empty($original_img)) return '';

    $original_img = '.'.$original_img; // 相对路径
    if(!file_exists($original_img)) return '';

    $image = new \Think\Image();
    $image->open($original_img);

    $goods_thumb_name = $goods_thumb_name. '.'.$image->type();
    //生成缩略图
    if(!is_dir($path))
        mkdir($path,0777,true);

    //参考文章 http://www.mb5u.com/biancheng/php/php_84533.html  改动参考 http://www.thinkphp.cn/topic/13542.html
    $image->thumb($width, $height,2)->save($path.$goods_thumb_name,NULL,100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存

    //图片水印处理
    $water = getConfig('water');
    if($water['is_mark']==1){
        $imgresource = './'.$path.$goods_thumb_name;
        if($width>$water['mark_width'] && $height>$water['mark_height']){
            if($water['mark_type'] == 'img'){
                $image->open($imgresource)->water(".".$water['mark_img'],$water['sel'],$water['mark_degree'])->save($imgresource);
            }else{
                //检查字体文件是否存在
                if(file_exists('./zhjt.ttf')){
                    $image->open($imgresource)->text($water['mark_txt'],'./zhjt.ttf',20,'#000000',$water['sel'])->save($imgresource);
                }
            }
        }
    }
    return '/'.$path.$goods_thumb_name;
}

function getGoodsImg($goods_id)
{
    return M('Goods')->where("goods_id = $goods_id")->getField('original_img');
}

