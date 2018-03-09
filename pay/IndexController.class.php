<?php
namespace Mobile\Controller;
use Think\Controller;
class IndexController extends Controller
{
    //验证码
    public function verify()
    {
        $Verify = new \Think\Verify();
        $Verify->length = 4;
        $Verify->fontSize = 50;
        $Verify->useImgBg = true;
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }

    public function index()
    {
        $configM = M('Config');
        $configArr = $configM->select();
        $this->store_name = '天上西域';
        $this->site_url = '';
        if(!empty($configArr))
        {
            foreach($configArr as $key=>$val)
            {
                if($val['name']=='store_name')
                {
                    $this->store_name = $val['value'];
                }
                if($val['name']=='site_url')
                {
                    $this->site_url = $val['value'];
                }
            }
        }
        $this->display();
    }

    public function login()
    {
        $Verify = new \Think\Verify();
        $code = I('post.verifycode');
        if(!$Verify->check($code))
        {
            $this->error('验证码错误',U('Index/index',array('td'=>time())));
        }
        if(!IS_POST)
        {
            $this->error('非法访问',U('Index/index',array('td'=>time())));
        }
        if(!isset($_POST['hynumber'])||empty($_POST['hynumber']))
        {
            $this->error('用户名不能为空',U('Index/index',array('td'=>time())));
        }
        if(!isset($_POST['loginpwd'])||empty($_POST['loginpwd']))
        {
            $this->error('密码不能为空',U('Index/index',array('td'=>time())));
        }
        $where['hynumber'] = $_POST['hynumber'];
        $where['loginpwd'] = md5($_POST['loginpwd']);

        $memberArr = M('Member')->where($where)->find();
        if(empty($memberArr)||$memberArr['isdel']==1)
        {
            $this->error('用户名或密码不正确',U('Index/index',array('td'=>time())));
        }
        if($memberArr['isreserved']==1)
        {
            $this->error('用户被冻结,有疑问请联系客服处理',U('Index/index',array('td'=>time())));
        }
        if($memberArr['islock']==1)
        {
            $this->error('用户被锁定,有疑问请联系客服处理',U('Index/index',array('td'=>time())));
        }
        if($memberArr['isapproved']==0)
        {
            $this->error('代理商未开通,请联系客服申请解锁',U('Index/index',array('td'=>time())));
        }

        $pre = C('SESSION_PRE');
        session($pre.'id',$memberArr['id']);
        session($pre.'jionindt',date('Y-m-d',$memberArr['regtime']));
        session($pre.'username',$memberArr['hynumber']);
        session($pre.'hyname',$memberArr['username']);
        $this->success('登录成功',U('Main/index'));
    }

    public function loginOut()
    {
        session(null);
        if(!isset($_SESSION)||empty($_SESSION))
        {
            $this->success('退出成功',U('Index/index',array('td'=>time())));
        }else
        {
            $this->error('退出失败');
        }
    }

    //用户自行注册开通
    public function reg()
    {
//        $_SESSION['openId'] = 9527;
        if(!isset($_SESSION['openId'])||empty($_SESSION['openId']))
        {
            vendor('Wxpay.JsApiPay');
            //①、获取用户openid
            $tools = new \JsApiPay();
            $openId = $tools->GetOpenid();
            session('openId',$openId);
        }else
        {
            $openId = $_SESSION['openId'];
        }
        if(IS_POST)
        {
            if(!isset($_POST['gid'])||empty($_POST['gid']))
            {
                $this->error('请先选择您购买的商品');
            }
            $goodsM = M('Goods');
            $gid = intval($_REQUEST['gid']);
            $goodsArr = $goodsM->find($gid);
            if(empty($goodsArr)||$goodsArr['isdel']==1||$goodsArr['selnum']>=$goodsArr['num'])
            {
                $this->error('您购买的商品已售馨');
            }

            $selflistM = M('Selflist');

            $tjnumber = $_POST['recommendNO'];
            $jdnumber = $_POST['jdNO'];
            if(empty($tjnumber)||empty($jdnumber))
            {
                $this->error('推荐人或接点人信息填写有误');
            }

            $memberM = M('Member');
            $w['hynumber'] = $tjnumber;
            $w['isdel'] = 0;
            $tjArr = $memberM->where($w)->find();
            $w['hynumber'] = $jdnumber;
            $jdArr = $memberM->where($w)->find();

            if(empty($tjArr)||empty($jdArr))
            {
                $this->error('推荐人或接点人不存在');
            }

            unset($w);
            $hasFull_jd = $memberM->where('pid='.$jdArr['id'])->count();

            if($jdArr['id']!=1 && $hasFull_jd>=2)
            {
                $this->error('您的节点人已经满员,请核对后再注册');
            }

            $maxgetmoney = 0;
            $configM = M('Config');
            $configArr = $configM->select();
            if(!empty($configArr))
            {
                foreach($configArr as $key=>$val)
                {
                    if($val['name']=='maxgetmoney')
                    {
                        $maxgetmoney = $val['value'];
                    }
                }
            }

            if($selflistM->create())
            {
                $selflistM->openid = $openId;
                $selflistM->loginpwd = md5($_POST['loginpwd']);
                $selflistM->paypwd = md5($_POST['paypwd']);
                $selflistM->tjnumber = $tjnumber;
                $selflistM->jdnumber = $jdnumber;
                $selflistM->tjmid = $tjArr['id'];
                $selflistM->jdmid = $jdArr['id'];
                $selflistM->paymoney = $goodsArr['price'];
                $selflistM->maxgetmoney = $maxgetmoney;

                M()->startTrans();
                $res = $selflistM->add();
                $goodsres = $goodsM->where('id='.$gid)->setInc('selnum',1);

                if($res && $goodsres)
                {
                    M()->commit();
                    session('oid',$res);
                    $jurl = "http://mp.dscyt.com/tsxy/index.php/Mobile/Index/wxpay";
                    unset($_POST);
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
                    echo "<script type='text/javascript'>window.location.href='".$jurl."';</script>";
                    exit;
                }else
                {
                    M()->rollback();
                    $this->error('服务器维护中...错误代码：01');
                }
            }else
            {
                $this->error('服务器维护中...错误代码：02');
            }
        }else
        {
            $this->goodsArr = M('Goods')->where('isdel=0')->field('id,goodnum,gtitle,num,selnum,price')->select();
            $this->display();
        }

    }

    public function wxpay()
    {
        if(!isset($_SESSION['oid'])||empty($_SESSION['oid']))
        {
            $this->error('参数错误',U('Index/reg'));
        }

        $selfM = M('Selflist');
        $orderArr = $selfM->find($_SESSION['oid']);
        if(empty($orderArr))
        {
            $this->error('您支付的订单不存在');
        }
        if($orderArr['paystsc']==1)
        {
            $this->error('您支付的订单已支付');
        }
        if($orderArr['paystsc']==2)
        {
            $this->error('您支付的订单已取消');
        }
        $goodsM = M('Goods');
        $goodsArr = $goodsM->find($orderArr['gid']);
        if(!isset($orderArr['gid'])||empty($orderArr['gid']))
        {
            $saveData['paystsc'] = 2;
            $saveData['sysmemo'] = '用户选购的商品不存在参数id,系统自动取消订单';
            $selfM->where('id='.$orderArr['id'])->save($saveData);
            if($goodsArr['selnum']>0)
            {
                $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
            }
            $this->error('您选购的商品参数异常,系统将自动取消您的订单,请重新下单',U('Index/reg'));
        }

        if(empty($goodsArr)||$goodsArr['isdel']==1||$goodsArr['selnum']>=$goodsArr['num'])
        {
            $saveData['paystsc'] = 2;
            if(empty($goodsArr))
            {
                $saveData['sysmemo'] = '用户选购的商品不存在,系统自动取消订单';
            }elseif($goodsArr['isdel']==1)
            {
                $saveData['sysmemo'] = '用户选购的商品已下架,系统自动取消订单';
            }elseif ($goodsArr['selnum']>=$goodsArr['num'])
            {
                $saveData['sysmemo'] = '用户选购的商品已售完,系统自动取消订单';
            }
            $selfM->where('id='.$orderArr['id'])->save($saveData);
            if($goodsArr['selnum']>0)
            {
                $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
            }
            $this->error('您购买的商品已售馨,请重新下单',U('Index/reg'));
        }

        $memberM = M('Member');
        $w['id'] = $orderArr['jdmid'];
        $w['isdel'] = 0;
        $jdArr = $memberM->where($w)->find();

        if(empty($jdArr))
        {
            $saveData['paystsc'] = 2;
            $saveData['sysmemo'] = '接点人不存在,系统自动取消订单';
            $selfM->where('id='.$orderArr['id'])->save($saveData);
            if($goodsArr['selnum']>0)
            {
                $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
            }
            $this->error('接点人不存在,系统将自动取消订单,请核实后重新下单',U('Index/reg'));
        }

        $hasFull_jd = $memberM->where('isdel=0 and isapproved=1 and pid='.$jdArr['id'])->count();

        if($jdArr['id']!=1 && $hasFull_jd>=2)
        {
            $saveData['paystsc'] = 2;
            $saveData['sysmemo'] = '节点人已经满员,系统自动取消订单';
            $selfM->where('id='.$orderArr['id'])->save($saveData);
            if($goodsArr['selnum']>0)
            {
                $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
            }
            $this->error('您的节点人已经满员,请核对后再注册',U('Index/reg'));
        }
        $this->oderID = $orderArr['id']+C('ORDER_NUM');
        $this->goodsArr = $goodsArr;

        unset($_SESSION['oid']);
        vendor('Wxpay.JsApiPay');
        //①、获取用户openid
        $tools = new \JsApiPay();
        $openId = $_SESSION['openId'];

        if($openId!=$orderArr['openid'])
        {
            $this->error('您没有权限支付该比订单');
        }

        //增加自己的内容： 向数据库添加记录等等
        $payUrl = "http://mp.dscyt.com/tsxy/index.php/Mobile/Index/dowxpay.html";
        $Out_trade_no = $orderArr['id'];
        if(!$Out_trade_no)
        {
            $this->error('支付失败,稍后重试');
        }

        $tje = $orderArr['paymoney']*100;
        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("支付");
        $input->SetAttach("帮助支付信息");
        $input->SetOut_trade_no($Out_trade_no);
        $input->SetTotal_fee($tje);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("支付");
        $input->SetNotify_url($payUrl);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        //echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
         // printf_info($order);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        
        $this->assign('jsApiParameters',$jsApiParameters);

        //获取共享收货地址js函数参数
//            $editAddress = $tools->GetEditAddressParameters();

        //③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
        /**
         * 注意：
         * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
         * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
         * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
         */
        $this->display();
    }

    protected function object_to_array($obj){
        if(!is_array($obj)){
            $obj = (array)$obj;
        }

        foreach($obj as $k => $v){
            if(is_object($v)){
                $obj[$k] = (array)$v;
            }
        }

        return $obj;
    }

    public function cancelPay()
    {
        $selfM = M('Selflist');
        $oid = $_POST['oderID']-C('ORDER_NUM');
        $orderArr = $selfM->find($oid);
        if(empty($orderArr))
        {
            $this->error('您支付的订单不存在');
        }
        if($orderArr['paystsc']==1)
        {
            $this->error('您支付的订单已支付');
        }
        if($orderArr['paystsc']==2)
        {
            $this->error('您支付的订单已取消');
        }

        $goodsM = M('Goods');
        $goodsArr = $goodsM->find($orderArr['gid']);

        $saveData['paystsc'] = 2;
        $saveData['sysmemo'] = '用户取消订单';
        $selfM->where('id='.$orderArr['id'])->save($saveData);
        if($goodsArr['selnum']>0)
        {
            $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
        }
        $this->success('您已取消您的订单支付',U('Index/reg'));
    }

    public function dowxpay()
    {
        $tms = time();
        ini_set('date.timezone','Asia/Shanghai');
        error_reporting(E_ERROR);
        Vendor('Wxpay.Log1');
        Vendor('Wxpay.WxpayServerPub');
        Vendor('Wxpay.CommonUtilPub');
        Vendor('Wxpay.Config');

        //初始化日志
        $log = new \Log1();


        //使用通用通知接口
        $notify = new \WxpayServerPub();
        //存储微信的回调
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $notify->saveData($xml);
        $logName="./logs/notify".date('Y-m-d').'.log';//log文件路径
        $log->log_result($logName,"【接收到的notify通知】:\n".$xml."\n");
        //验证签名，并回应微信。
        //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
        //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
        //尽可能提高通知的成功率，但微信不保证通知最终能成功。
        if($notify->checkSign() == FALSE){
            $returnXml = $notify->returnXml();
            $log->log_result($logName,"【业务出错".$returnXml."】:\n".$xml."\n");
            $notify->setReturnParameter("return_code","FAIL");//返回状态码
            $notify->setReturnParameter("return_msg","签名失败");//返回信息
        }else{
            $notify->setReturnParameter("return_code","SUCCESS");//设置返回码
        }
        $returnXml = $notify->returnXml();
        echo $returnXml;
        if($notify->checkSign() == TRUE)
        {
            if ($notify->data["return_code"] == "FAIL") {
                //此处应该更新一下订单状态，商户自行增删操作
                $log->log_result($logName,"【通信出错】:\n".$xml."\n");
            }
            elseif($notify->data["result_code"] == "FAIL"){
                //此处应该更新一下订单状态，商户自行增删操作
                $log->log_result($logName,"【业务出错】:\n".$xml."\n");
            }
            else
            {
                //此处应该更新一下订单状态，商户自行增删操作
                //操作数据库，修改支付情况
                $selflistM = M('Selflist');
                $memberM = M('Member');
                $translogM = M('Translog');
                $orderlistM = M('Orderlist');
                $addressM = M('Addresslist');

                $orderArr = $selflistM->find($notify->data["out_trade_no"]);
                if(empty($orderArr))
                {
                    $log->log_result($logName,"【您支付的订单不存在】:\n".$xml."\n");
                    exit;
                }
                if($orderArr['paystsc']==1)
                {
                    $log->log_result($logName,"【您支付的订单已支付】:\n".$xml."\n");
                    exit;
                }
                if($orderArr['paystsc']==2)
                {
                    $log->log_result($logName,"【您支付的订单已取消】:\n".$xml."\n");
                    exit;
                }
                $goodsM = M('Goods');
                $goodsArr = $goodsM->find($orderArr['gid']);
                if(!isset($orderArr['gid'])||empty($orderArr['gid']))
                {
                    $saveData['paystsc'] = 2;
                    $saveData['sysmemo'] = '用户选购的商品不存在参数id,系统自动取消订单';
                    $selflistM->where('id='.$orderArr['id'])->save($saveData);
                    if($goodsArr['selnum']>0)
                    {
                        $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
                    }
                    $log->log_result($logName,"【您选购的商品参数异常,系统将自动取消您的订单,请重新下单】:\n".$xml."\n");
                    exit;
                }

                if(empty($goodsArr)||$goodsArr['isdel']==1||$goodsArr['selnum']>=$goodsArr['num'])
                {
                    $saveData['paystsc'] = 2;
                    if(empty($goodsArr))
                    {
                        $saveData['sysmemo'] = '用户选购的商品不存在,系统自动取消订单';
                    }elseif($goodsArr['isdel']==1)
                    {
                        $saveData['sysmemo'] = '用户选购的商品已下架,系统自动取消订单';
                    }elseif ($goodsArr['selnum']>=$goodsArr['num'])
                    {
                        $saveData['sysmemo'] = '用户选购的商品已售完,系统自动取消订单';
                    }
                    $selflistM->where('id='.$orderArr['id'])->save($saveData);
                    if($goodsArr['selnum']>0)
                    {
                        $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
                    }
                    $log->log_result($logName,"【您购买的商品已售馨,请重新下单】:\n".$xml."\n");
                    exit;
                }

                $memberM = M('Member');
                $w['jdmid'] = $orderArr['jdmid'];
                $w['isdel'] = 0;
                $jdArr = $memberM->where($w)->find();

                if(empty($jdArr))
                {
                    $saveData['paystsc'] = 2;
                    $saveData['sysmemo'] = '接点人,系统自动取消订单';
                    $selflistM->where('id='.$orderArr['id'])->save($saveData);
                    if($goodsArr['selnum']>0)
                    {
                        $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
                    }
                    $log->log_result($logName,"【接点人不存在,系统将自动取消订单,请核实后重新下单】:\n".$xml."\n");
                    exit;
                }

                $hasFull_jd = $memberM->where('pid='.$jdArr['id'])->count();

                if($jdArr['id']!=1 && $hasFull_jd>=2)
                {
                    $saveData['paystsc'] = 2;
                    $saveData['sysmemo'] = '节点人已经满员,系统自动取消订单';
                    $selflistM->where('id='.$orderArr['id'])->save($saveData);
                    if($goodsArr['selnum']>0)
                    {
                        $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
                    }
                    $log->log_result($logName,"【您的节点人已经满员,请核对后再注册】:\n".$xml."\n");
                    exit;
                }


                $selflistArr = $selflistM->find($notify->data["out_trade_no"]);

                if($notify->data["openid"]!=$selflistArr['openid'])
                {
                    $saveData['paystsc'] = 2;
                    $saveData['sysmemo'] = 'openID不匹配,支付出错,系统自动取消订单';
                    $selflistM->where('id='.$orderArr['id'])->save($saveData);
                    if($goodsArr['selnum']>0)
                    {
                        $goodsM->where('id='.$orderArr['gid'])->setDec('selnum',1);
                    }
                    $log->log_result($logName,"【openID不匹配,支付出错】:\n".$xml."\n");
                    exit;
                }else
                {
                    $res1 = 1;//修改支付表支付时间
                    $res2 = 1;//修改支付表支付状态
                    $res3 = 1;//会员表添加会员
                    $res4 = 1;//会员报单交易记录
                    $res5 = 1;//会员收货地址记录
                    $res6 = 1;//订单记录
                    $res7 = 1;//推荐人奖励交易记录
                    $res8 = 1;//推荐人奖励
                    $res9 = 1;//分润
                    $res10 = 1;//分润
                    $res11 = 1;//分润
                    M()->startTrans();
                    //修改支付状态
                    $res1 = $selflistM->where('id='.$selflistArr['id'])->setField('paytime',$tms);
                    $res2 = $selflistM->where('id='.$selflistArr['id'])->setField('paystsc',1);
                    //添加会员
                    $saveData2['pid'] = $orderArr['jdmid'];
                    $saveData2['keystring'] = $jdArr['id'].'.'.$jdArr['keystring'];
                    $saveData2['rid'] = $orderArr['tjmid'];
                    $saveData2['hynumber'] = $orderArr['hynumber'];
                    $saveData2['loginpwd'] = $orderArr['loginpwd'];
                    $saveData2['paypwd'] = $orderArr['paypwd'];
                    $saveData2['username'] = $orderArr['username'];
                    $saveData2['phone'] = $orderArr['phone'];
                    $saveData2['isapproved'] = 1;
                    $saveData2['maxgetmoney'] = $orderArr['maxgetmoney'];
                    $saveData2['applytm'] = $tms;
                    $saveData2['systememo'] = '自助开通';
                    $saveData2['regtime'] = $tms;
                    $saveData2['mkd'] = 1;
                    $res3 = $memberM->add($saveData2);
                    //添加报单交易记录
                    $saveData3['mid'] = $res3;//系统报单默认100001交易
                    $saveData3['typeid'] = 3;
                    $saveData3['tmoney'] = $orderArr['paymoney'];
                    $saveData3['prebalance'] = 0;
                    $saveData3['memo'] = '会员【'.$orderArr["hynumber"].'】自助报单产生的交易费用';
                    $saveData3['regtime'] = $tms;

                    $res4 = $translogM->add($saveData3);
                    //添加收货地址
                    $saveData4['mid'] = $res3;//系统报单默认100001交易
                    $saveData4['username'] = $orderArr['pickname'];
                    $saveData4['usephone'] = $orderArr['pickphone'];
                    $saveData4['province'] = $orderArr['province'];
                    $saveData4['city'] = $orderArr['city'];
                    $saveData4['area'] = $orderArr['area'];
                    $saveData4['address'] = $orderArr['address'];
                    $saveData4['isselected'] = 1;
                    $saveData4['regtime'] = $tms;

                    $res5 = $addressM->add($saveData4);
                    //添加订单
                    unset($saveData);
                    unset($saveData2);
                    unset($saveData3);
                    unset($saveData4);
                    //获取分润参数
                    $fenRun = getFrConfig();

                    //推荐人奖励
                    $outmoneyss = 0;
                    $w['tjmid'] = $orderArr['tjmid'];
                    $w['isdel'] = 0;
                    $tjMember = $memberM->where($w)->find();
                    if(!empty($tjMember)&&$tjMember['isreserved']==0&&$fenRun['tjmoney']>0)
                    {
                        $saveData['mid'] = $tjMember['id'];
                        $saveData['typeid'] = 9;
                        $saveData['tmoney'] = $fenRun['tjmoney'];
                        $saveData['prebalance'] = $tjMember['balance'];
                        $saveData['memo'] = '推荐会员【'.$orderArr["hynumber"].'】开通产生的推荐奖励';
                        $saveData['regtime'] = $tms;

                        $res7 = $translogM->add($saveData);

                        $res8 = $memberM->where('id='.$tjMember['id'])->setInc('balance',$fenRun['tjmoney']);
                        $outmoneyss += $fenRun['tjmoney'];
                        unset($saveData);
                    }

                    //分润
                    $frnum = $fenRun['treenum'];
                    $beginPID = $orderArr['jdmid'];
                    if($frnum > 0)
                    {
                        for ($x=1;$x<=$frnum;$x++)
                        {
                            if($x>20)
                            {
                                break;
                            }
                            if($beginPID > 0)
                            {
                                $tempTj = $memberM->field('id,hynumber,pid,rid,keystring,coinbalance,maxgetmoney,getmoney')->find($beginPID);
                                if(empty($tempTj))
                                {
                                    M()->rollback();
                                    $log->log_result($logName,"【执行分润时因接点人不存在，终止开通操作】:\n".$xml."\n");
                                    exit;
                                }

                                $frmoney = $goodsArr['profit'.$x];
                                $iffr = getNodeNum3j($tempTj['id'],$tempTj['keystring']);

                                if($frmoney > 0 && $tempTj['isreserved']==0  && $tempTj['maxgetmoney']>0 && $tempTj['getmoney']<$tempTj['maxgetmoney'])
                                {
                                    $saveData['mid'] = $tempTj['id'];
                                    $saveData['typeid'] = 16;
                                    $saveData['tmoney'] = $frmoney;
                                    $saveData['prebalance'] = $tempTj['coinbalance'];
                                    $saveData['memo'] = '会员【'.$orderArr["hynumber"].'】开通产生的'.$x.'级分红收益';
                                    $saveData['regtime'] = $tms;

                                    $res9 = $translogM->add($saveData);

                                    $outmoneyss += $frmoney;
                                    $res10 = $memberM->where('id='.$tempTj['id'])->setInc('coinbalance',$frmoney);
                                    $res11 = $memberM->where('id='.$tempTj['id'])->setInc('getmoney',$frmoney);

                                    if(!$res8 || !$res9 || !$res10)
                                    {
                                        M()->rollback();
                                        $log->log_result($logName,"【执行分润时因发放分润时服务器错误，终止开通操作】:\n".$xml."\n");
                                        exit;
                                    }
                                }
                                $beginPID = $tempTj['pid'];
                            }else
                            {
                                break;
                            }
                        }
                        unset($saveData);
                    }

                    //添加订单
                    $saveData4['order_sn'] = $orderArr['id']+C('ORDER_NUM');
                    $saveData4['aid'] = $res5;
                    $saveData4['gid'] = $orderArr['gid'];
                    $saveData4['mid'] = $res3;
                    $saveData4['order_status'] = 1;
                    $saveData4['pay_status'] = 1;
                    $saveData4['consignee'] = $orderArr['pickname'];
                    $saveData4['province'] = $orderArr['province'];
                    $saveData4['city'] = $orderArr['city'];
                    $saveData4['district'] = $orderArr['area'];
                    $saveData4['address'] = $orderArr['address'];
                    $saveData4['mobile'] = $orderArr['pickphone'];
                    $saveData4['pay_kind'] = 1;
                    $saveData4['buynum'] = 1;
                    $saveData4['goods_price'] = $orderArr['paymoney'];
                    $saveData4['total_amount'] = $orderArr['paymoney'];
                    $saveData4['order_amount'] = $orderArr['paymoney'];
                    $saveData4['regtime'] = $tms;
                    $saveData4['pay_time'] = $tms;
                    $saveData4['user_note'] = $orderArr['memo'];
                    $saveData4['systemMoney'] = $orderArr['paymoney']-$outmoneyss;
                    $res6 = $orderlistM->add($saveData4);
                    unset($saveData4);
                    $msg = '失败代码：'.$res1.'_'.$res2.'_'.$res3.'_'.$res4.'_'.$res5.'_'.$res6.'_'.$res7.'_'.$res8;
                    $log->log_result($logName,"【支付失败： $msg 】:\n".$xml."\n");
                    if($res1 && $res2 && $res3 && $res4 && $res5 && $res6 && $res7 && $res8)
                    {
                        M()->commit();
                        $log->log_result($logName,"【支付成功】:\n".$xml."\n");
                    }else
                    {
                        M()->rollback();
                        $msg = '失败代码：'.$res1.'_'.$res2.'_'.$res3.'_'.$res4.'_'.$res5.'_'.$res6.'_'.$res7.'_'.$res8;
                        $log->log_result($logName,"【支付失败： $msg 】:\n".$xml."\n");
                    }
                }
            }
        }
        //商户自行增加处理流程,
        //例如：更新订单状态
        //例如：数据库操作
        //例如：推送支付完成信息
    }


    /**
     * 会员账号ajax校验
     * kd=0:会员账号校验
     * kd=1:推荐人校验
     */
    public function checkHy()
    {
        $data['stsc'] = 0;
        $data['msg'] = '未知错误';
        if(!isset($_POST['kd'])||$_POST['kd']=='')
        {
            $data['msg'] = '丢失重要参数';
            $this->ajaxReturn($data);
        }
        if(!isset($_POST['hynumber'])||empty($_POST['hynumber']))
        {
            $data['msg'] = '账号为空';
            $this->ajaxReturn($data);
        }
        $kd = $_POST['kd'];
        $hynumber = $_POST['hynumber'];

        $mM = M('Member');
        $w['hynumber'] = $hynumber;
        if($kd==3)
        {
            unset($w['hynumber']);
            $w['phone'] = $hynumber;
        }

        $menberArr = $mM->where($w)->find();
        if($kd==0)
        {
            if(!empty($menberArr)&&$menberArr['isdel']==0)
            {
                $data['msg'] = '账号已存在,请更换账号名';
                $this->ajaxReturn($data);
            }
            $data['stsc'] = 1;
            $data['msg'] = '可以注册';
        }elseif ($kd==1)
        {
            if(empty($menberArr)||$menberArr['isdel']==1)
            {
                $data['msg'] = '接点人不存在,请更换推接点人';
                $this->ajaxReturn($data);
            }

            //校验当前会员接点是否满员
            $condition['isdel'] = 0;
            $condition['pid'] = $menberArr['id'];
            $isMax = $mM->where($condition)->count();
            if($menberArr['id']!=1 && $isMax>=2)
            {
                $data['msg'] = '当前接点人数已满额,请更换接点人';
                $this->ajaxReturn($data);
            }

            $data['stsc'] = 1;
            $data['msg'] = '存在账号为'.$hynumber.'的接点人：'.$menberArr['username'];
        }elseif ($kd==3)
        {
            if(!empty($menberArr)&&$menberArr['isdel']==0)
            {
                $data['msg'] = '当前手机已被注册,有疑问请致电客服申诉';
                $this->ajaxReturn($data);
            }
            $data['stsc'] = 1;
            $data['msg'] = '当前手机未被注册,可以使用';
        }elseif ($kd==4)
        {
            if(empty($menberArr)||$menberArr['isdel']==1)
            {
                $data['msg'] = '推荐人不存在,请更换推推荐人';
                $this->ajaxReturn($data);
            }

            $data['stsc'] = 1;
            $data['msg'] = '存在账号为'.$hynumber.'的推荐人：'.$menberArr['username'];
        }
        $this->ajaxReturn($data);
    }
}