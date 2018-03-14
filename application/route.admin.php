<?php
use think\Request;
use think\Route;
Route::rule('/', 'admin/v1.Index/index'); //
Route::group('v1.0.0', function () {
    Route::group('backstage', function () {
        //家
        Route::rule('/home/list', 'admin/v1.Home/list'); //登录


        //公共
        Route::rule('/publicity/login', 'admin/v1.Publicity/login'); //登录
        Route::rule('/publicity/upload', 'admin/v1.Publicity/upload'); //上传
        Route::rule('/publicity/test', 'admin/v1.Publicity/test'); //
        //用户
        Route::rule('/user/list', 'admin/v1.User/lists');
        //考场列表
        Route::rule('/examroom/list', 'admin/v1.ExamRoom/lists');   
        Route::post('/examroom/save', 'admin/v1.ExamRoom/save');   
        Route::rule('/examroom/del', 'admin/v1.ExamRoom/del');   
        Route::rule('/examroom/info', 'admin/v1.ExamRoom/info');   
        //考场试卷详情
        Route::rule('/exampaper/info', 'api/v1.ExamPaper/get');
        //历史试卷
        Route::rule('/examhistory/list', 'admin/v1.ExamHistory/lists');
        //课程列表 
        Route::rule('/subject/list', 'admin/v1.Subject/lists');
        Route::rule('/subject/save', 'admin/v1.Subject/save');
        Route::rule('/subject/del', 'admin/v1.Subject/del');
        Route::rule('/subject_resources/list', 'admin/v1.SubjectResources/lists');
        Route::rule('/subject_resources/save','admin/v1.SubjectResources/save');
        Route::rule('/subject_resources/series','admin/v1.SubjectResources/series');
        //资讯列表 
        Route::rule('/new/list', 'admin/v1.LatestNews/lists');
        Route::rule('/new/save', 'admin/v1.LatestNews/save');
        Route::rule('/new/get', 'admin/v1.LatestNews/get');
        Route::rule('/new/del', 'admin/v1.LatestNews/del');
        //意见列表 
        Route::rule('/advice/list', 'admin/v1.Advice/lists');       
        Route::rule('/advice/del', 'admin/v1.Advice/del');       
        Route::rule('/advice/get', 'admin/v1.Advice/get');       
        //题目
        Route::rule('/question/list', 'admin/v1.Question/lists');
        Route::rule('/question/save', 'admin/v1.Question/save');
        Route::post('/question/excel', 'admin/v1.Question/excel');


        //消息
        Route::rule('/home/message', 'admin/v1.Home/message');

        //系统
        Route::rule('/getSystemLog', 'admin/v1.System/getSystemLog'); //获取系统日志
        Route::rule('/getScheduleList', 'admin/v1.System/getScheduleList'); //定时计划列表
        Route::rule('/getScheduleLogList', 'admin/v1.System/getScheduleLogList'); //定时计划执行列表
        Route::rule('/getActionLogList', 'admin/v1.System/getActionLogList'); //后台管理员操作列表
        Route::rule('/cronton/del', 'admin/v1.Cronton/del'); //后台管理员操作列表

        Route::rule('/question/test', 'admin/v1.Question/test');
        Route::rule('/examroom/test', 'admin/v1.ExamRoom/test');

    });
}, ['before_behavior' => function () {
    if (Request::instance()->isOptions()) {
        // exit;
    }
}]);
