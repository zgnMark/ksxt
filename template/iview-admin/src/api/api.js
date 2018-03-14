/**
 * @Author     SuJun (351699382@qq.com)
 * @time       2017-12-04
 * @link       https://github.com
 * @copyright  Copyright (c) 2017
 */
import {api,base} from './index';
import Cookies from 'js-cookie';
import qs from 'qs';
let commonParam = {
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded',
    'X-Auth-Token' : localStorage.getItem('token'),
  },
};
//延迟执行
export const delayAction = () => {
	 commonParam = {
	  headers: {
	    'Content-Type': 'application/x-www-form-urlencoded',
	    'X-Auth-Token' : localStorage.getItem('token'),
	  },
	};
}
//上传API
export const uploadApiAction = base + '/v1.0.0/backstage/publicity/upload'

                     
//系统
export const getSystemLogAction = (params) => {return api.post('/v1.0.0/backstage/getSystemLog',qs.stringify(params),commonParam).then(res => (res?res.data:res))};//系统日志列表
//定时计划列表
export const getScheduleListAction = (params) => {return api.post('/v1.0.0/backstage/getScheduleList',qs.stringify(params),commonParam).then(res => (res?res.data:res))};//定时计划列表
//执行日志列表
export const getScheduleLogListAction = (params) => {return api.post('/v1.0.0/backstage/getScheduleLogList',qs.stringify(params),commonParam).then(res => (res?res.data:res))};//定时计划执行列表
export const getActionLogListAction = (params) => {return api.post('/v1.0.0/backstage/getActionLogList',qs.stringify(params),commonParam).then(res => (res?res.data:res))};//定时计划执行列表


//后台用户管理
export const adminListsAction = (params) => {return api.post('/v1.0.0/backstage/admin/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//新增或更新
export const adminSaveAdminAction = (params) => {return api.post('/v1.0.0/backstage/admin/saveAdmin',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adminGetAction = (params) => {return api.post('/v1.0.0/backstage/admin/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adminDeleteAction = (params) => {return api.post('/v1.0.0/backstage/admin/delete',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adminGetAllsAction = (params) => {return api.post('/v1.0.0/backstage/admin/getAlls',qs.stringify(params),commonParam).then(res => (res?res.data:res))};

export const adminGroupListAction = (params) => {return api.post('/v1.0.0/backstage/admin/adminGroupList',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//
export const saveAdminGroupAction = (params) => {return api.post('/v1.0.0/backstage/admin/saveAdminGroup',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//管理组列表
export const groupListsAction = (params) => {return api.post('/v1.0.0/backstage/group/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条管理组
export const groupGetAction = (params) => {return api.post('/v1.0.0/backstage/group/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条管理组
export const groupAddAction = (params) => {return api.post('/v1.0.0/backstage/group/add',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条管理组
export const groupDelAction = (params) => {return api.post('/v1.0.0/backstage/group/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条管理组
export const groupRuleListsAction = (params) => {return api.post('/v1.0.0/backstage/group/ruleLists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条管理组
export const ruleAddAction = (params) => {return api.post('/v1.0.0/backstage/rule/add',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条管理组
export const ruleDelAction = (params) => {return api.post('/v1.0.0/backstage/rule/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条管理组
export const ruleGetAction = (params) => {return api.post('/v1.0.0/backstage/rule/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条管理组
export const ruleListsAction = (params) => {return api.post('/v1.0.0/backstage/rule/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取当前拥有的权限
export const userRuleListsAction = (params) => {return api.post('/v1.0.0/backstage/rule/accessLists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};


//保存国家
export const countrySaveAction = (params) => {return api.post('/v1.0.0/backstage/country/save',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取一条国家信息
export const countryGetAction = (params) => {return api.post('/v1.0.0/backstage/country/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取国家列表
export const countryListAction = (params) => {return api.post('/v1.0.0/backstage/country/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//获取所有国家列表
export const countryGetAllsAction = (params) => {return api.post('/v1.0.0/backstage/country/getAlls',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//删除一条国家信息
export const countryDelAction = (params) => {return api.post('/v1.0.0/backstage/country/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};


//前端用户管理
export const userListsAction = (params) => {return api.post('/v1.0.0/backstage/user/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const userGetSingerListAction = (params) => {return api.post('/v1.0.0/backstage/user/getSingerList',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const userDelAction = (params) => {return api.post('/v1.0.0/backstage/user/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const userSetSingerAction = (params) => {return api.post('/v1.0.0/backstage/user/setSinger',qs.stringify(params),commonParam).then(res => (res?res.data:res))};


//活动管理
export const activitySaveActivityAction = (params) => {return api.post('/v1.0.0/backstage/activity/saveActivity',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const activityListsAction = (params) => {return api.post('/v1.0.0/backstage/activity/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const activityDelAction = (params) => {return api.post('/v1.0.0/backstage/activity/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const activityGetAction = (params) => {return api.post('/v1.0.0/backstage/activity/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};

//语言管理
export const languageGetAllsAction = (params) => {return api.post('/v1.0.0/backstage/language/getAlls',qs.stringify(params),commonParam).then(res => (res?res.data:res))};

//广告位管理
export const adSpaceListsAction = (params) => {return api.post('/v1.0.0/backstage/adSpace/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adSpaceSaveAction = (params) => {return api.post('/v1.0.0/backstage/adSpace/save',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adSpaceGetAction = (params) => {return api.post('/v1.0.0/backstage/adSpace/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adSpaceDelAction = (params) => {return api.post('/v1.0.0/backstage/adSpace/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adSpaceGetAdModelAction = (params) => {return api.post('/v1.0.0/backstage/adSpace/getAdModel',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adSpaceGetAllsAction = (params) => {return api.post('/v1.0.0/backstage/adSpace/getAlls',qs.stringify(params),commonParam).then(res => (res?res.data:res))};

//广告管理
export const adListsAction = (params) => {return api.post('/v1.0.0/backstage/ad/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adSaveAction = (params) => {return api.post('/v1.0.0/backstage/ad/save',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adGetAction = (params) => {return api.post('/v1.0.0/backstage/ad/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const adDelAction = (params) => {return api.post('/v1.0.0/backstage/ad/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};

//订单管理
export const orderListsAction = (params) => {return api.post('/v1.0.0/backstage/order/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const orderDelAction = (params) => {return api.post('/v1.0.0/backstage/order/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};


//直播管理
export const liveListsAction = (params) => {return api.post('/v1.0.0/backstage/live/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const liveDelAction = (params) => {return api.post('/v1.0.0/backstage/live/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};

//礼物组管理
export const giftGroupListsAction = (params) => {return api.post('/v1.0.0/backstage/giftGroup/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const giftGroupSaveAction = (params) => {return api.post('/v1.0.0/backstage/giftGroup/save',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const giftGroupGetAction = (params) => {return api.post('/v1.0.0/backstage/giftGroup/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const giftGroupDelAction = (params) => {return api.post('/v1.0.0/backstage/giftGroup/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const giftGroupGetAllsAction = (params) => {return api.post('/v1.0.0/backstage/giftGroup/getAlls',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//礼物管理
export const giftListsAction = (params) => {return api.post('/v1.0.0/backstage/gift/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const giftSaveAction = (params) => {return api.post('/v1.0.0/backstage/gift/save',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const giftGetAction = (params) => {return api.post('/v1.0.0/backstage/gift/get',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
export const giftDelAction = (params) => {return api.post('/v1.0.0/backstage/gift/del',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
//礼物日志管理
export const giftLogListsAction = (params) => {return api.post('/v1.0.0/backstage/giftLog/lists',qs.stringify(params),commonParam).then(res => (res?res.data:res))};



//用户登录
export const publicityLoginAction = (params) => {return api.post('/v1.0.0/backstage/publicity/login',qs.stringify(params),commonParam).then(res => (res?res.data:res))};
