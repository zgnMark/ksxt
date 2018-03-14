import Main from '@/views/Main.vue';

// 不作为Main组件的子页面展示的页面单独写，如下
export const loginRouter = {
    path: '/login',
    name: 'login',
    meta: {
        title: 'Login - 登录'
    },
    component: resolve => { require(['@/views/login.vue'], resolve); }
};

export const page404 = {
    path: '/*',
    name: 'error-404',
    meta: {
        title: '404-页面不存在'
    },
    component: resolve => { require(['@/views/error-page/404.vue'], resolve); }
};

export const page403 = {
    path: '/403',
    meta: {
        title: '403-权限不足'
    },
    name: 'error-403',
    component: resolve => { require(['@//views/error-page/403.vue'], resolve); }
};

export const page500 = {
    path: '/500',
    meta: {
        title: '500-服务端错误'
    },
    name: 'error-500',
    component: resolve => { require(['@/views/error-page/500.vue'], resolve); }
};

export const preview = {
    path: '/preview',
    name: 'preview',
    component: resolve => { require(['@/views/form/article-publish/preview.vue'], resolve); }
};

export const locking = {
    path: '/locking',
    name: 'locking',
    component: resolve => { require(['@/views/main-components/lockscreen/components/locking-page.vue'], resolve); }
};

// 作为Main组件的子页面展示但是不在左侧菜单显示的路由写在otherRouter里
export const otherRouter = {
    path: '/',
    name: 'otherRouter',
    redirect: '/home',
    component: Main,
    children: [
        { path: 'home', title: {i18n: 'home'}, name: 'home_index', component: resolve => { require(['@/views/home/home.vue'], resolve); } },
        { path: 'ownspace', title: '个人中心', name: 'ownspace_index', component: resolve => { require(['@/views/own-space/own-space.vue'], resolve); } },
       // { path: 'order/:order_id', title: '订单详情', name: 'order-info', component: resolve => { require(['@/views/advanced-router/component/order-info.vue'], resolve); } }, // 用于展示动态路由
        { path: 'shopping', title: '购物详情', name: 'shopping', component: resolve => { require(['@/views/advanced-router/component/shopping-info.vue'], resolve); } }, // 用于展示带参路由
        { path: 'message', title: '消息中心', name: 'message_index', component: resolve => { require(['@/views/message/message.vue'], resolve); } },
        //下面是自定义
        { path: 'group/auth', title: '编辑权限', name: 'groupAuth', component: resolve => { require(['@/views/auth/GroupAuth.vue'], resolve); } },
        { path: 'system-schedule-log-list', title: '执行日志', name: 'system-schedule-log-list', component: resolve => { require(['@/views/system/ScheduleLogList.vue'], resolve); } },
        { path: 'activity-publish/:id', title: '活动编辑', name: 'activity-publish', component: resolve => { require(['@/views/activity/activity-publish/article-publish.vue'], resolve); } },
        { path: 'ad-edit/:id', title: '编辑', name: 'ad-edit', component: resolve => { require(['@/views/ad/AdEdit.vue'], resolve); } }
    ]
};

// 作为Main组件的子页面展示并且在左侧菜单显示的路由写在appRouter里
export const appRouter = [
    {
        path: '/access',
        icon: 'key',
        name: 'access',
        title: '权限管理',
        component: Main,
        children: [
            { path: 'index', title: '权限管理', name: 'access_index', component: resolve => { require(['@/views/access/access.vue'], resolve); } }
        ]
    },
    {
        path: '/access-test',
        icon: 'lock-combination',
        title: '权限测试页',
        name: 'accesstest',
        access: 0,
        component: Main,
        children: [
            { path: 'index', title: '权限测试页', name: 'accesstest_index', access: 0, component: resolve => { require(['@/views/access/access-test.vue'], resolve); } }
        ]
    },
    {
        path: '/international',
        icon: 'earth',
        title: {i18n: 'international'},
        name: 'international',
        component: Main,
        children: [
            { path: 'index', title: {i18n: 'international'}, name: 'international_index', component: resolve => { require(['@/views/international/international.vue'], resolve); } }
        ]
    },
    {
        path: '/component',
        icon: 'social-buffer',
        name: 'component',
        title: '组件',
        component: Main,
        children: [
            {
                path: 'text-editor',
                icon: 'compose',
                name: 'text-editor',
                title: '富文本编辑器',
                component: resolve => { require(['@/views/my-components/text-editor/text-editor.vue'], resolve); }
            },
            {
                path: 'md-editor',
                icon: 'pound',
                name: 'md-editor',
                title: 'Markdown编辑器',
                component: resolve => { require(['@/views/my-components/markdown-editor/markdown-editor.vue'], resolve); }
            },
            {
                path: 'image-editor',
                icon: 'crop',
                name: 'image-editor',
                title: '图片预览编辑',
                component: resolve => { require(['@/views/my-components/image-editor/image-editor.vue'], resolve); }
            },
            {
                path: 'draggable-list',
                icon: 'arrow-move',
                name: 'draggable-list',
                title: '可拖拽列表',
                component: resolve => { require(['@/views/my-components/draggable-list/draggable-list.vue'], resolve); }
            },
            {
                path: 'area-linkage',
                icon: 'ios-more',
                name: 'area-linkage',
                title: '城市级联',
                component: resolve => { require(['@/views/my-components/area-linkage/area-linkage.vue'], resolve); }
            },
            {
                path: 'file-upload',
                icon: 'android-upload',
                name: 'file-upload',
                title: '文件上传',
                component: resolve => { require(['@/views/my-components/file-upload/file-upload.vue'], resolve); }
            },
            {
                path: 'count-to',
                icon: 'arrow-graph-up-right',
                name: 'count-to',
                title: '数字渐变',
                component: resolve => { require(['@/views/my-components/count-to/count-to.vue'], resolve); }
            }
            // {
            //     path: 'clipboard-page',
            //     icon: 'clipboard',
            //     name: 'clipboard-page',
            //     title: '一键复制',
            //     component: resolve => { require(['@/views/my-components/clipboard/clipboard.vue'], resolve); }
            // }
        ]
    },
    {
        path: '/form',
        icon: 'android-checkbox',
        name: 'form',
        title: '表单编辑',
        component: Main,
        children: [
            { path: 'artical-publish', title: '文章发布', name: 'artical-publish', icon: 'compose', component: resolve => { require(['@/views/form/article-publish/article-publish.vue'], resolve); } },
            { path: 'workflow', title: '工作流', name: 'workflow', icon: 'arrow-swap', component: resolve => { require(['@/views/form/work-flow/work-flow.vue'], resolve); } }

        ]
    },
    // {
    //     path: '/charts',
    //     icon: 'ios-analytics',
    //     name: 'charts',
    //     title: '图表',
    //     component: Main,
    //     children: [
    //         { path: 'pie', title: '饼状图', name: 'pie', icon: 'ios-pie', component: resolve => { require('@/views/access/access.vue') },
    //         { path: 'histogram', title: '柱状图', name: 'histogram', icon: 'stats-bars', component: resolve => { require('@/views/access/access.vue') }

    //     ]
    // },
    {
        path: '/tables',
        icon: 'ios-grid-view',
        name: 'tables',
        title: '表格',
        component: Main,
        children: [
            { path: 'dragableTable', title: '可拖拽排序', name: 'dragable-table', icon: 'arrow-move', component: resolve => { require(['@/views/tables/dragable-table.vue'], resolve); } },
            { path: 'editableTable', title: '可编辑表格', name: 'editable-table', icon: 'edit', component: resolve => { require(['@/views/tables/editable-table.vue'], resolve); } },
            { path: 'searchableTable', title: '可搜索表格', name: 'searchable-table', icon: 'search', component: resolve => { require(['@/views/tables/searchable-table.vue'], resolve); } },
            { path: 'exportableTable', title: '表格导出数据', name: 'exportable-table', icon: 'code-download', component: resolve => { require(['@/views/tables/exportable-table.vue'], resolve); } },
            { path: 'table2image', title: '表格转图片', name: 'table-to-image', icon: 'images', component: resolve => { require(['@/views/tables/table-to-image.vue'], resolve); } }
        ]
    },
    {
        path: '/advanced-router',
        icon: 'ios-infinite',
        name: 'advanced-router',
        title: '高级路由',
        component: Main,
        children: [
            { path: 'mutative-router', title: '动态路由', name: 'mutative-router', icon: 'link', component: resolve => { require(['@/views/advanced-router/mutative-router.vue'], resolve); } },
            { path: 'argument-page', title: '带参页面', name: 'argument-page', icon: 'android-send', component: resolve => { require(['@/views/advanced-router/argument-page.vue'], resolve); } }
        ]
    },
    {
        path: '/error-page',
        icon: 'android-sad',
        title: '错误页面',
        name: 'errorpage',
        component: Main,
        children: [
            { path: 'index', title: '错误页面', name: 'errorpage_index', component: resolve => { require(['@/views/error-page/error-page.vue'], resolve); } }
        ]
    },

    {
        path: '/user',
        icon: 'person-stalker',
        name: 'user',
        title: '用户管理',
        component: Main,
        children: [
            {
                path: 'user-lists',
                icon: 'document-text',
                name: 'user-lists',
                title: '用户管理',
                component: resolve => { require(['@/views/user/UserList.vue'], resolve); }
            },
            {
                path: 'singer-lists',
                icon: 'document-text',
                name: 'singer-lists',
                title: '歌手管理',
                component: resolve => { require(['@/views/user/SingerList.vue'], resolve); }
            }
        ]
    },
    {
        path: '/activity',
        icon: 'planet',
        name: 'activity',
        title: '活动管理',
        component: Main,
        children: [
            {
                path: 'activity-list',
                icon: 'document-text',
                name: 'activity-list',
                title: '活动列表',
                component: resolve => { require(['@/views/activity/ActivityList.vue'], resolve); }
            }
        ]
    },
    {
        path: '/live',
        icon: 'ios-videocam',
        name: 'live',
        title: '直播管理',
        component: Main,
        children: [
            {
                path: 'live-lists',
                icon: 'ios-videocam-outline',
                name: 'live-lists',
                title: '直播列表',
                component: resolve => { require(['@/views/live/LiveList.vue'], resolve); }
            }
        ]
    },
    {
        path: '/order',
        icon: 'android-cart',
        name: 'order',
        title: '订单管理',
        component: Main,
        children: [
            {
                path: 'order-lists',
                icon: 'document-text',
                name: 'order-lists',
                title: '支付订单管理',
                component: resolve => { require(['@/views/order/OrderList.vue'], resolve); }
            }
        ]
    },
    {
        path: '/ad',
        icon: 'planet',
        name: 'ad',
        title: '广告管理',
        component: Main,
        children: [
            {
                path: 'ad-list',
                icon: 'document-text',
                name: 'ad-list',
                title: '广告管理',
                component: resolve => { require(['@/views/ad/AdLists.vue'], resolve); }
            },
            {
                path: 'ad-space-list',
                icon: 'document-text',
                name: 'ad-space-list',
                title: '广告位管理',
                component: resolve => { require(['@/views/ad/AdSpaceLists.vue'], resolve); }
            }
        ]
    },

    {
        path: '/gift',
        icon: 'happy',
        name: 'gift',
        title: '礼物管理',
        component: Main,
        children: [
            {
                path: 'gift-group-list',
                icon: 'document-text',
                name: 'gift-group-list',
                title: '礼物组管理',
                component: resolve => { require(['@/views/gift/GiftGroupList.vue'], resolve); }
            },
            {
                path: 'gift-list',
                icon: 'document-text',
                name: 'gift-list',
                title: '礼物管理',
                component: resolve => { require(['@/views/gift/GiftList.vue'], resolve); }
            },
            {
                path: 'gift-log-list',
                icon: 'document-text',
                name: 'gift-log-list',
                title: '礼物日志',
                component: resolve => { require(['@/views/gift/GiftLogList.vue'], resolve); }
            },
        ]
    },

    {
        path: '/auth',
        icon: 'key',
        name: 'auth',
        title: '权限管理',
        component: Main,
        children: [
            {
                path: 'admin-lists',
                icon: 'person',
                name: 'admin-lists',
                title: '管理员',
                component: resolve => { require(['@/views/auth/AdminLists.vue'], resolve); }
            },
            {
                path: 'auth-group',
                icon: 'person-stalker',
                name: 'auth-group',
                title: '组管理',
                component: resolve => { require(['@/views/auth/AuthGroup.vue'], resolve); }
            },
            {
                path: 'auth-rule',
                icon: 'key',
                name: 'auth-rule',
                title: '规则管理',
                component: resolve => { require(['@/views/auth/AuthRule.vue'], resolve); }
            },
        ]
    },

    {
        path: '/system',
        icon: 'android-settings',
        name: 'system',
        title: '系统',
        component: Main,
        children: [
            {
                path: 'system-log',
                icon: 'document-text',
                name: 'system-log',
                title: '系统日志',
                component: resolve => { require(['@/views/system/SystemList.vue'], resolve); }
            },
            {
                path: 'schedule-list',
                icon: 'document-text',
                name: 'schedule-list',
                title: '定时计划',
                component: resolve => { require(['@/views/system/ScheduleList.vue'], resolve); }
            },
            {
                path: 'country-list',
                icon: 'document-text',
                name: 'country-list',
                title: '国家管理',
                component: resolve => { require(['@/views/system/CountryList.vue'], resolve); }
            },
            {
                path: 'action-log',
                icon: 'document-text',
                name: 'action-log',
                title: '行为日志',
                component: resolve => { require(['@/views/system/ActionList.vue'], resolve); }
            },
        ]
    }


];

// 所有上面定义的路由都要写在下面的routers里
export const routers = [
    loginRouter,
    otherRouter,
    preview,
    locking,
    ...appRouter,
    page500,
    page403,
    page404
];
