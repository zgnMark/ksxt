<?php
use think\Route;

Route::group('v1.0.0', function () {
    //注册
    Route::post('/passport/register', 'api/v1.Passport/register');
    //登录
    Route::post('/passport/login', 'api/v1.Passport/login');
    Route::post('/passport/loginout', 'api/v1.Passport/logOut');
    //首页
    Route::post('/index/list', 'api/v1.Index/lists');
    //考场列表
    Route::post('/examroom/list', 'api/v1.ExamRoom/lists');   
    //考场试卷详情
    Route::post('/examroom/info', 'api/v1.ExamRoom/get');      
    //课程列表 
    Route::post('/subject/list', 'api/v1.Subject/lists');
    //资讯列表 
    Route::post('/new/list', 'api/v1.LatestNews/lists');
    //资讯详情 
    Route::post('/new/about', 'api/v1.LatestNews/get');       
    //题目
    Route::post('/question/list', 'api/v1.Question/lists');
    Route::post('/question/add', 'api/v1.Question/add');
    Route::post('/question/commit','api/v1.Question/commit');
    Route::post('/question/confirm','api/v1.Question/confirm');
    Route::post('/question/test','api/v1.Question/test');
    Route::post('/question/continue','api/v1.Question/continues');
    //我的
    Route::post('/home/get', 'api/v1.Home/get');
    Route::post('/home/save', 'api/v1.Home/save');    
    Route::post('/home/exam', 'api/v1.Home/exam');    
    Route::post('/home/subject', 'api/v1.Home/subject');    
    Route::post('/home/pass', 'api/v1.Home/updatePass');    
    //意见
    Route::post('/advice/list', 'api/v1.Advice/lists');
    Route::post('/advice/commit', 'api/v1.Advice/commit');
    //视频播放
    Route::post('/video/play', 'api/v1.Video/play');

    //发送
    Route::post('/news/send','push/Events/send');
});
