<?php
/**
 * api地址
 */
return [
    //--------------------------------直播API-------------------------------
    //创建频道
    'app.channel.create'          => 'https://vcloud.163.com/app/channel/create',
    //修改频道
    'app.channel.update'          => 'https://vcloud.163.com/app/channel/update',
    //删除频道
    'app.channel.delete'          => 'https://vcloud.163.com/app/channel/delete',
    //获取频道状态
    'app.channelstats'            => 'https://vcloud.163.com/app/channelstats',
    //获取频道列表
    'app.channellist'             => 'https://vcloud.163.com/app/channellist',
    //重新获取推流地址
    'app.address'                 => 'https://vcloud.163.com/app/address',
    //设置频道为录制状态
    'app.channel.setAlwaysRecord' => 'https://vcloud.163.com/app/channel/setAlwaysRecord',
    //禁用频道
    'app.channel.pause'           => 'https://vcloud.163.com/app/channel/pause',
    //批量禁用频道
    'app.channellist.pause'       => 'https://vcloud.163.com/app/channellist/pause',
    //恢复频道
    'app.channel.resume'          => 'https://vcloud.163.com/app/channel/resume',
    //批量恢复频道
    'app.channellist.resume'      => 'https://vcloud.163.com/app/channellist/resume',
    //获取录制视频文件列表
    'app.videolist'               => 'https://vcloud.163.com/app/videolist',
    //获取某一时间范围的录制视频文件列表
    'app.vodvideolist'            => 'https://vcloud.163.com/app/vodvideolist',
    //设置视频录制回调地址
    'app.record.setcallback'      => 'https://vcloud.163.com/app/record/setcallback',
    //设置回调的加签秘钥
    'app.callback.setSignKey'     => 'https://vcloud.163.com/app/callback/setSignKey',
    //录制文件合并
    'app.video.merge'             => 'https://vcloud.163.com/app/video/merge',
    //录制重置
    'app.channel.resetRecord'     => 'https://vcloud.163.com/app/channel/resetRecord',
    //直播实时转码地址
    'app.transcodeAddress'        => 'https://vcloud.163.com/app/transcodeAddress',
    //视频录制回调地址查询
    'app.record.callbackQuery'    => 'https://vcloud.163.com/app/record/callbackQuery',
    //设置录制信息
    'app.channel.setupRecordInfo' => 'https://vcloud.163.com/app/channel/setupRecordInfo',
    //--------------------------------直播API结束-------------------------------

    //--------------------------------IM-api------------------------------------
    
    /*<----网易云通信id---->*/
    //创建网易云通信ID
    'nimserver.user.create'       => 'https://api.netease.im/nimserver/user/create.action',
    //更新网易云通信ID
    'nimserver.user.update'       => 'https://api.netease.im/nimserver/user/update.action',
     //获取新Token
    'nimserver.user.refreshToken' => 'https://api.netease.im/nimserver/user/refreshToken.action',
     //封禁网易云通信ID
    'nimserver.user.block'        => 'https://api.netease.im/nimserver/user/block.action',
     //解禁网易云通信ID
    'nimserver.user.unblock'      => 'https://api.netease.im/nimserver/user/unblock.action',

    /*<----用户名片设置---->*/
    //更新用户名片
    'nimserver.user.updateUinfo'  => 'https://api.netease.im/nimserver/user/updateUinfo.action',
    //获取用户名片
    'nimserver.user.getUinfos'    => 'https://api.netease.im/nimserver/user/getUinfos.action',


    //设置桌面端在线时，移动端是否需要推送
    'nimserver.user.setDonnop'    => 'https://api.netease.im/nimserver/user/setDonnop.action',

    /*<----用户关系托管---->*/
    //加好友
    'nimserver.friend.add'        => 'https://api.netease.im/nimserver/friend/add.action',
    //更新好友关系
    'nimserver.friend.update'     => 'https://api.netease.im/nimserver/friend/.action',
    //删除好友关系
    'nimserver.friend.delete'     => 'https://api.netease.im/nimserver/friend/delete.action',    
    //获取好友关系
    'nimserver.friend.get'        => 'https://api.netease.im/nimserver/friend/get.action',
    //设置黑名单
    'nimserver.user.setSpecialRelation'     => 'https://api.netease.im/nimserver/user/setSpecialRelation.action',
    //查看指定用户的黑名单和静音列表
    'nimserver.user.listBlackAndMuteList'   => 'https://api.netease.im/nimserver/user/listBlackAndMuteList.action',

    /*<----消息功能---->*/
    //发送普通消息
    'nimserver.msg.sendMsg'              => 'https://api.netease.im/nimserver/msg/sendMsg.action',
    //批量发送点对点普通消息
    'nimserver.msg.sendBatchMsg'         => 'https://api.netease.im/nimserver/msg/sendBatchMsg.action',
    //发送自定义系统通知
    'nimserver.msg.sendAttachMsg'        => 'https://api.netease.im/nimserver/msg/sendAttachMsg.action',
    //批量发送自定义系统通知
    'nimserver.msg.sendBatchAttachMsg'   => 'https://api.netease.im/nimserver/msg/sendBatchAttachMsg.action',
    //文件上传
    'nimserver.msg.upload'               => 'https://api.netease.im/nimserver/msg/upload.action',  
    //文件上传（multipart方式）
    'nimserver.msg.fileUpload'           => 'https://api.netease.im/nimserver/msg/fileUpload.action',    
    //消息撤回
    'nimserver.msg.recall'               => 'https://api.netease.im/nimserver/msg/recall.action',    
    //发送广播消息
    'nimserver.msg.broadcastMsg'         => 'https://api.netease.im/nimserver/msg/broadcastMsg.action',    

    /*<----群组功能---->*/
    //创建群
    'nimserver.team.create'              => 'https://api.netease.im/nimserver/team/create.action',  
    //拉人入群
    'nimserver.team.add'                 => 'https://api.netease.im/nimserver/team/add.action',  
    //踢人出群
    'nimserver.team.kick'                => 'https://api.netease.im/nimserver/team/kick.action',  
    //解散群
    'nimserver.team.remove'              => 'https://api.netease.im/nimserver/team/remove.action',  
    //编辑群资料
    'nimserver.team.update'              => 'https://api.netease.im/nimserver/team/update.action',    
    //群信息与成员列表查询
    'nimserver.team.query'               => 'https://api.netease.im/nimserver/team/query.action',   
    //移交群主
    'nimserver.team.changeOwner'         => 'https://api.netease.im/nimserver/team/changeOwner.action',
    //任命管理员
    'nimserver.team.addManager'          => 'https://api.netease.im/nimserver/team/addManager.action',
    //移除管理员
    'nimserver.team.removeManager'       => 'https://api.netease.im/nimserver/team/removeManager.action',
    //获取某用户所加入的群信息
    'nimserver.team.joinTeams'           => 'https://api.netease.im/nimserver/team/joinTeams.action',
    //修改群昵称
    'nimserver.team.updateTeamNick'      => 'https://api.netease.im/nimserver/team/updateTeamNick.action',       
    //修改消息提醒开关
    'nimserver.team.muteTeam'            => 'https://api.netease.im/nimserver/team/muteTeam.muteTeam',    
    //修改群昵称
    'nimserver.team.muteTlist'           => 'https://api.netease.im/nimserver/team/muteTlist.action',    
    //禁言群成员
    'nimserver.team.updateTeamNick'      => 'https://api.netease.im/nimserver/team/updateTeamNick.action',    
    //主动退群
    'nimserver.team.leave'               => 'https://api.netease.im/nimserver/team/leave.action',
    //将群组整体禁言
    'nimserver.team.muteTlistAll'        => 'https://api.netease.im/nimserver/team/muteTlistAll.action',
    //获取群组禁言列表
    'nimserver.team.listTeamMute'        => 'https://api.netease.im/nimserver/team/listTeamMute.action',

    /*<----聊天室---->*/
    //创建聊天室
    'nimserver.chatroom.create'             => 'https://api.netease.im/nimserver/chatroom/create.action',
    //查询聊天室信息
    'nimserver.chatroom.get'                => 'https://api.netease.im/nimserver/chatroom/get.action',
    //更新聊天室信息
    'nimserver.chatroom.update'             => 'https://api.netease.im/nimserver/chatroom/update.action',
    //修改聊天室开/关闭状态
    'nimserver.chatroom.toggleCloseStat'    => 'https://api.netease.im/nimserver/chatroom/toggleCloseStat.action',
    //设置聊天室内用户角色
    'nimserver.chatroom.setMemberRole'      => 'https://api.netease.im/nimserver/chatroom/setMemberRole.action',
    //请求聊天室地址
    'nimserver.chatroom.requestAddr'        => 'https://api.netease.im/nimserver/chatroom/requestAddr.action',
    //发送聊天室消息
    'nimserver.chatroom.sendMsg'            => 'https://api.netease.im/nimserver/chatroom/sendMsg.action',
    //往聊天室内添加机器人
    'nimserver.chatroom.addRobot'           => 'https://api.netease.im/nimserver/chatroom/addRobot.action',
    //从聊天室内删除机器人
    'nimserver.chatroom.removeRobot'        => 'https://api.netease.im/nimserver/chatroom/removeRobot.action',
    //设置临时禁言状态
    'nimserver.chatroom.temporaryMute'      => 'https://api.netease.im/nimserver/chatroom/temporaryMute.action',
    //往聊天室有序队列中新加或更新元素
    'nimserver.chatroom.queueOffer'         => 'https://api.netease.im/nimserver/chatroom/queueOffer.action',
    //从队列中取出元素
    'nimserver.chatroom.queuePoll'          => 'https://api.netease.im/nimserver/chatroom/queuePoll.action',
    //排序列出队列中所有元素
    'nimserver.chatroom.queueList'          => 'https://api.netease.im/nimserver/chatroom/queueList.action',
    //删除清理整个队列
    'nimserver.chatroom.queueInit'          => 'https://api.netease.im/nimserver/chatroom/queueInit.action',
    //初始化队列
    'nimserver.chatroom.queueDrop'          => 'https://api.netease.im/nimserver/chatroom/queueDrop.action',
    //将聊天室整体禁言
    'nimserver.chatroom.muteRoom'           => 'https://api.netease.im/nimserver/chatroom/muteRoom.action',
    //查询聊天室统计指标TopN
    'nimserver.chatroom.topn'               => 'https://api.netease.im/nimserver/chatroom/topn.action',
    //分页获取成员列表
    'nimserver.chatroom.membersByPage'      => 'https://api.netease.im/nimserver/chatroom/membersByPage.action',
    //批量获取在线成员信息
    'nimserver.chatroom.queryMembers'       => 'https://api.netease.im/nimserver/chatroom/queryMembers.action',
    //变更聊天室内的角色信息
    'nimserver.chatroom.updateMyRoomRole'   => 'https://api.netease.im/nimserver/chatroom/updateMyRoomRole.action',

    /*<----历史记录---->*/

    //单聊云端历史消息查询
    'nimserver.history.querySessionMsg'         => 'https://api.netease.im/nimserver/history/querySessionMsg.action',
    //群聊云端历史消息查询
    'nimserver.history.queryTeamMsg'            => 'https://api.netease.im/nimserver/history/queryTeamMsg.action',
    //聊天室云端历史消息查询
    'nimserver.history.queryChatroomMsg'        => 'https://api.netease.im/nimserver/history/queryChatroomMsg.action',
    //删除聊天室云端历史消息
    'nimserver.chatroom.deleteHistoryMessage'   => 'https://api.netease.im/nimserver/chatroom/deleteHistoryMessage.action',
    //用户登录登出事件记录查询
    'nimserver.history.queryUserEvents'         => 'https://api.netease.im/nimserver/history/queryUserEvents.action',
    //删除音视频/白板服务器录制文件
    'nimserver.history.deleteMediaFile'         => 'https://api.netease.im/nimserver/history/deleteMediaFile.action',
    //批量查询广播消息
    'nimserver.history.queryBroadcastMsg'       => 'https://api.netease.im/nimserver/history/queryBroadcastMsg.action',
    //查询单条广播消息
    'nimserver.history.queryBroadcastMsgById'   => 'https://api.netease.im/nimserver/history/queryBroadcastMsgById.action',


    /*<----在线状态---->*/
    
    //订阅在线状态事件
    'nimserver.event.subscribe.add'             => 'https://api.netease.im/nimserver/event/subscribe/add.action',    
    //取消在线状态事件订阅
    'nimserver.event.subscribe.delete'          => 'https://api.netease.im/nimserver/event/subscribe/delete.action',    
    //取消全部在线状态事件订阅
    'nimserver.event.subscribe.batchdel'        => 'https://api.netease.im/nimserver/event/subscribe/batchdel.action',    
    //查询在线状态事件订阅关系
    'nimserver.event.subscribe.query'           => 'https://api.netease.im/nimserver/event/subscribe/query.action',

    /*<----消息抄送--->*/


    //--------------------------------IM-api结束--------------------------------


    //--------------------------------payssion-api开始--------------------------------

    //付钱请求
    'payment.create'                            => 'http://sandbox.payssion.com/api/v1/payment/create',



    //--------------------------------payssion-api结束--------------------------------

];
