<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Index extends  Controller
{
    //前台首页
    public function index()
    {
        $url=config('api_url');//请求接口的域名地址
        // dump($url);exit
        //请求首页的分类接口
        $category=httpCurl($url."/api/shop/home/category",'post');
        //获取首页banner图的广告
        $banner=httpCurl($url."/api/shop/home/ad","post",['position_id'=>1,'nums'=>5]);
        // var_dump($banner);exit;
        //首页顶部广告
        $homeTop=httpCurl($url."/api/shop/home/ad","post",['position_id'=>6,'nums'=>1]);
        //商品类型
        //热卖
        $hot=httpCurl($url."/api/shop/home/goods","post",['type'=>1,'nums'=>5]);
        //推荐
        $recommand=httpCurl($url."/api/shop/home/goods","post",['type'=>2,'nums'=>5]);
        //新品
        $news=httpCurl($url."/api/shop/home/goods","post",['type'=>3,'nums'=>5]);
        //品牌列表
        $brand=httpCurl($url."/api/shop/home/brand","post",['nums'=>9]);
        //最新文章
        $articles=httpCurl($url."/api/shop/home/newsArticle","post",['nums'=>5]);
        //首页底部广告
        $homeBottom=httpCurl($url."/api/shop/home/ad","post",['position_id'=>5,'nums'=>1]);
        //模板复制
        $this->assign([
            'category'=>$category['data'],//首页商品分类
            'banner'=>$banner['data'],//首页banner图
            'home_top'=>$homeTop['data'],//首页顶部广告
            'hot'=>$hot['data'],//热卖
            'recommand'=>$recommand['data'],//推荐
            'news'=> $news['data'],//新品
            'brand'=>$brand['data'],//品牌
            'articles'=>$articles['data'],//最新
            'botton'=>$homeBottom['data'],
        ]);
        return $this->fetch('index');
    }
}
