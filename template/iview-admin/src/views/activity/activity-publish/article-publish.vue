<style lang="less">
    @import '../../../styles/common.less';
    @import './article-publish.less';
</style>
<template>
    <div>
        <Row>
            <Col span="18">
                <Card>
                    <Form :label-width="80" class="margin-top-20">
                        <FormItem label="文章标题">
                            <Input v-model="formItem.title" placeholder="请输入文章标题" icon="android-list"/>
                        </FormItem>

                        <FormItem label="封面图">
                              <template>
                                  <div class="demo-upload-list" v-for="item in uploadList">
                                      <template v-if="item.status === 'finished'">
                                          <img :src="item.url">
                                      </template>
                                      <template v-else>
                                          <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
                                      </template>
                                  </div>
                                  <Upload
                                      ref="upload"
                                      :show-upload-list="false"
                                      :default-file-list="defaultList"
                                      :on-success="handleSuccess"
                                      :format="['jpg','jpeg','png']"
                                      :max-size="2048"
                                      :on-format-error="handleFormatError"
                                      :on-exceeded-size="handleMaxSize"
                                      :before-upload="handleBeforeUpload"
                                      type="drag"
                                      :action="uploadApiAction"
                                      style="display: inline-block;width:58px;">
                                      <div style="width: 58px;height:58px;line-height: 58px;">
                                          <Icon type="camera" size="20"></Icon>
                                      </div>
                                  </Upload>
                              </template>
                        </FormItem>

                        <FormItem label="语言">
                           <Select   v-model="formItem.language_id" value="">
                            <Option v-for="item in languages" :value="item.id" :key="item.id">{{ item.name }}</Option>
                           </Select>
                        </FormItem>

                        <FormItem label="国家">
                           <Select  v-model="formItem.country_id" value="语言">
                            <Option v-for="item in countrys" :value="item.id" :key="item.id">{{ item.name }}</Option>
                           </Select>
                        </FormItem>

                        <FormItem label="歌手">
                            <Input v-model="formItem.singer" placeholder="请输入歌手" />
                        </FormItem>
                        <FormItem label="详细地址">
                            <Input v-model="formItem.address" placeholder="请输入详细地址" />
                        </FormItem>
                        <FormItem label="活动时间">
                            <Row>
                                <Col span="3">
                                    <FormItem prop="date">
                                        <DatePicker type="datetime" format="yyyy-MM-dd HH:mm" placeholder="开始" v-model="formItem.start_time"></DatePicker>
                                    </FormItem>
                                </Col>
                                <Col span="1" style="text-align: center">-</Col>
                                <Col span="3">
                                    <FormItem prop="time">
                                        <DatePicker type="datetime" format="yyyy-MM-dd HH:mm" placeholder="结束" v-model="formItem.end_time"></DatePicker>
                                    </FormItem>
                                </Col>
                            </Row>
                        </FormItem>


                    </Form>

             
                    <div class="margin-top-20">
                        <div id="editorElem"></div>
                    </div>
                </Card>
            </Col>
            <Col span="6" class="padding-left-10">
                <Card>
                    <p slot="title">
                        <Icon type="paper-airplane"></Icon>
                        发布
                    </p>
                    <p class="margin-top-10">
                        <Icon type="android-time"></Icon>&nbsp;&nbsp;状&nbsp;&nbsp;&nbsp; 态：
                        <Select size="small" style="width:90px" v-model="formItem.status">
                            <Option :value="0">上线</Option>
                            <Option :value="1">下线</Option>
                        </Select>
                    </p>

                    <p class="margin-top-10">
                        <Icon type="ios-calendar-outline"></Icon>&nbsp;&nbsp;
                        <span v-if="publishTimeType === 'immediately'">立即发布</span><span v-else>定时：{{ this.formItem.publish_time }}</span>
                        <Button v-show="!editPublishTime" size="small" @click="handleEditPublishTime" type="text">修改</Button>
                        <transition name="publish-time">
                            <div v-show="editPublishTime" class="publish-time-picker-con">
                                <div class="margin-top-10">
                                    <DatePicker @on-change="setPublishTime" type="datetime" style="width:200px;" placeholder="选择日期和时间" >
                                    </DatePicker>                          
                                </div>
                                <div class="margin-top-10">
                                    <Button type="primary" @click="handleSavePublishTime">确认</Button>
                                    <Button type="ghost" @click="cancelEditPublishTime">取消</Button>
                                </div>
                            </div>
                        </transition>
                    </p>
                    <Row class="margin-top-20 publish-button-con">
                        <!--
                        <span class="publish-button">
                          <Button @click="handlePreview">预览</Button>
                        </span>
                        -->
                        <span class="publish-button"><Button @click="handleSaveDraft">保存草稿</Button></span>
                        <span class="publish-button"><Button @click="handlePublish" :loading="publishLoading" icon="ios-checkmark" style="width:90px;" type="primary">发布</Button></span>
                    </Row>
                </Card>


            </Col>
        </Row>
    </div>
</template>

<script>
  import E from 'wangeditor'
  import {base} from '../../../api/index'
  import {uploadApiAction,activitySaveActivityAction,languageGetAllsAction,countryGetAllsAction,activityGetAction} from '../../../api/api'

export default {
    name: 'artical-publish',
    data () {
        return {
            editPathButtonText: '编辑',
            articleStateList: [{value: '草稿'}, {value: '等待复审'}],

            //
            publishTime: '',
            publishTimeType: 'immediately',
            editPublishTime: false, // 是否正在编辑发布时间
            publishLoading: false,

            //当前编辑活动ID
            activityId:0,

            //语言列表
            languages:[],
            //国家列表
            countrys:[],
            //封面图上传
            uploadApiAction:uploadApiAction,
            defaultList: [],
            imgName: '',
            uploadList: [],

            //提交表单
            formItem:{
                id:0,
                language_id:'',
                title:'',
                cover_img:'',
                content:'',
                country_id:'',
                singer:'',
                address:'',
                status:0,
                start_time:'',
                end_time:'',
                publish_time:'',
            }
        };
    },
    methods: {

        //显示发布时间筛选
        handleEditPublishTime () {
            this.editPublishTime = !this.editPublishTime;
        },
        //确认发布时间
        handleSavePublishTime () {
            this.publishTimeType = 'timing';
            this.editPublishTime = false;
        },
        //编辑发布时间
        cancelEditPublishTime () {
            this.publishTimeType = 'immediately';
            this.editPublishTime = false;
        },
        //设置发布时间
        setPublishTime (datetime) {
            this.formItem.publish_time = datetime;
        },
        handleSaveDraft () {
            if (!this.canPublish()) {
                //
            }
        },

        //获取所有语言
        getLanguages(){
                let param = {}
                languageGetAllsAction(param).then(response => {
                    this.languages = response.data.list 
                }).catch(function (error) {
                  console.log(error)
                });
        },
        //获取所有国家
        getCountrys(){
                let param = {}
                countryGetAllsAction(param).then(response => {
                    this.countrys = response.data.list 
                }).catch(function (error) {
                  console.log(error)
                });
        },

        //-----------封面图上传---------
        //上传成功
        handleSuccess (res, file) {
            file.url = base + res.data.info;
            file.name = "图片";
            this.formItem.cover_img = res.data.info
            this.uploadList  = [Object.assign({},file)]
        },
        //格式
        handleFormatError (file) {
            this.$Notice.warning({
                title: '格式',
                desc: '目前支持jpg、jpeg、png格式图片'
            });
        },
        //大小
        handleMaxSize (file) {
            this.$Notice.warning({
                title: '超出大小',
                desc: '最大为2M.'
            });
        },
        //上传前
        handleBeforeUpload () {
            
            const check = this.uploadList.length < 2;
            if (!check) {
                this.$Notice.warning({
                    title: '最多只能上传一张.'
                });
            }
            return check;
        },
       //-----------封面图上传---------

        //提交发布
        handlePublish () {
          
                this.publishLoading = true;
                let param = Object.assign({},this.formItem)
                activitySaveActivityAction(param).then(response => {
                  this.publishLoading = false;
                  this.$Notice.success({
                        title: response.data.msg,
                        desc: '文章《' + this.formItem.title + '》' + response.data.msg
                  });
                }).catch(function (error) {
                  console.log(error)
                });

        }
    },

    mounted () {
        //获取所有语言
        this.getLanguages()
        //获取所有国家
        this.getCountrys()
        //封面图上传
        this.uploadList = this.$refs.upload.fileList;
        //创建编辑器
        var editor = new E('#editorElem')

        //判断是编辑还是创建
        if(this.$route.params.id != undefined){

            this.activityId = parseInt(this.$route.params.id.toString())
            //获取原数据
            let param = {id:this.activityId}
            activityGetAction(param).then(response => {
                    this.formItem = Object.assign({},this.formItem,{
                        id:response.data.info.id,
                        language_id:response.data.info.language_id,
                        title:response.data.info.title,
                        cover_img:response.data.info.cover_img,
                        content:response.data.info.content,
                        country_id:response.data.info.country_id,
                        singer:response.data.info.singer,
                        address:response.data.info.address,
                        status:response.data.info.status,
                        start_time:response.data.info.start_time,
                        end_time:response.data.info.end_time,
                        publish_time:response.data.info.publish_time,
                    })
                    //设置发布时间
                    if(this.formItem.publish_time != ''){
                      this.publishTimeType = 'timing';
                      this.editPublishTime = false;
                    }
                    
                    //设置封面图片
                    if(response.data.info.cover_img != ''){
                        this.defaultList = [];
                        this.defaultList = this.defaultList.concat(
                                          [
                                              {
                                                  'name': '图片',
                                                  'url': base + response.data.info.cover_img,
                                                  'status':'finished'
                                              }
                                          ]
                        );
                        this.uploadList  = [Object.assign({},this.defaultList[0])]
                    }else{
                        this.uploadList  = []
                    }

                    //设置编辑器内容
                    editor.txt.html(this.formItem.content)
            })
        }

        //设置编辑器属性
        editor.customConfig.onchange = (html) => {
          this.formItem.content = html
        }
        editor.customConfig.zIndex = 100
        editor.customConfig.height = '500'
        //上传地址
        editor.customConfig.uploadImgServer = this.uploadApiAction
        // 将图片大小限制为 5M
        editor.customConfig.uploadImgMaxSize = 5 * 1024 * 1024
        // 限制一次最多上传 5 张图片
        editor.customConfig.uploadImgMaxLength = 5
        //自定义上传参数
        editor.customConfig.uploadImgParams = {
            editor:true
        }
        //自定义字段
        editor.customConfig.uploadFileName = 'file'
        editor.customConfig.uploadImgHooks = {
            // 如果服务器端返回的不是 {errno:0, data: [...]} 这种格式，可使用该配置
            // （但是，服务器端返回的必须是一个 JSON 格式字符串！！！否则会报错）
            customInsert: function (insertImg, result, editor) {
                if(result.data.code != 0){

                }else{
                   insertImg(base + result.data.info)
                }
            }
        }
        editor.create()
        
    },
    destroyed () {
        
    }
};
</script>
<style>
    .w-e-text-container{
        height: 450px !important;
    }

    .demo-upload-list{
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0,0,0,.2);
    margin-right: 4px;
}
.demo-upload-list img{
    width: 100%;
    height: 100%;
}
</style>
