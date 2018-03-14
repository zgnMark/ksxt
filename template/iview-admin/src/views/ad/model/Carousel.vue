<!--轮播图-->
<template>
<div>
        <Form-item label="封面图" prop="type">
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
        </Form-item>
        <FormItem label="跳转链接" prop="url">
            <Input v-model="formData.url" placeholder="请输入跳转链接"></Input>
        </FormItem>
        <FormItem label="跳转类型" prop="ad_space">
            <Select v-model="formData.url_type">
                <Option :value="0">HTTP</Option>
                <Option :value="1">原生跳转</Option>
            </Select>
        </FormItem>
</div>
</template>

<script>
  import {uploadApiAction,adGetAction} from '../../../api/api'
  import {base} from '../../../api/index'
  export default {
    name: 'carousel',
    data(){
        return{
          
          formData:{
            url_type:0,
            url:'',
            cover_img:'',
          },
          //上传
          uploadApiAction:uploadApiAction,
          defaultList: [],
          imgName: '',
          uploadList: []
        }
    },

    //创建组件对外提供的事件
    mounted() {

        //对外提供数据
        let _this = this
        this.$on('get-data', function(){
          return _this.formData
        });
        //编辑情况，获取外面数据
        this.$on('init', function(param){
           this.formData = Object.assign({},{
            url_type:param.url_type,
            url:param.url,
            cover_img:param.cover_img,
           })
            //设置封面图片
            if(param.cover_img != ''){
                this.defaultList = [];
                this.defaultList = this.defaultList.concat(
                                  [
                                      {
                                          'name': '图片',
                                          'url': base + param.cover_img,
                                          'status':'finished'
                                      }
                                  ]
                );
                this.uploadList  = [Object.assign({},this.defaultList[0])]
            }else{
                this.uploadList  = []
            }
        });


        //上传
        this.uploadList = this.$refs.upload.fileList;
    },


    methods: {
            //上传
            //上传成功
            handleSuccess (res, file) {
                file.url = base + res.data.info;
                file.name = "图片";
                this.formData.cover_img = res.data.info
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
            }
    },
    destroyed () {
    }
  }
</script>


