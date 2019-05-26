<?php

namespace App\Http\Controllers;

use App\Lib\alipay\AlipayFundTransOrderQueryRequest;
use App\Lib\alipay\AlipayFundTransToaccountTransferRequest;
use App\Lib\alipay\AopClient;
use Illuminate\Http\Request;

class AlipayController extends Controller
{
    //单笔转账的接口
    public function toaccountTransfer()
    {
        $aop = new AopClient();
        $aop->gatewayUrl = env('ALI_PAY_URL');
        $aop->appId = env('APP_ID');
        $aop->rsaPrivateKey = env('RSA_PRIVATE_KEY');
        $aop->alipayrsaPublicKey= env('ALI_PAY_RSA_PUBLIC_KEY');
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='utf-8';
        $aop->format='json';
        $request = new AlipayFundTransToaccountTransferRequest();

        #沙箱测试需要是沙箱账户
        #https://openhome.alipay.com/platform/appDaily.htm?tab=account
        $order = uniqid().'88888';
        $biz_content = json_encode(['out_biz_no'=>$order,'payee_type'=>'ALIPAY_LOGONID',
            'payee_account'=>'abfsaj8041@sandbox.com','amount'=>"1"]);
        $request->setBizContent($biz_content);
        var_dump($request);
        $result = $aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            var_dump($result);
        }
    }

    //单笔转账查询接口
    public function orderQuery()
    {
        $aop = new AopClient ();
        $aop->gatewayUrl = env('ALI_PAY_URL');
        $aop->appId = env('APP_ID');
        $aop->rsaPrivateKey = env('RSA_PRIVATE_KEY');
        $aop->alipayrsaPublicKey= env('ALI_PAY_RSA_PUBLIC_KEY');
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='utf-8';
        $aop->format='json';
        $request = new AlipayFundTransOrderQueryRequest();
//        "{" .
//        "\"out_biz_no\":\"3142321423432\"," .
//        "\"order_id\":\"20160627110070001502260006780837\"" .
//        "  }"
        $order = '转账完接收的参数值自己定义的单号' ;
        $biz_content = json_encode(['out_biz_no'=>$order,'order_id'=>'可选值']);
        $request->setBizContent($biz_content);
        $result = $aop->execute ( $request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            echo "失败";
        }
    }
}
