<template>
<Row :gutter="10">
    <Col span="24">
      <Card>
        <p slot="title">
              <Icon type="pinpoint"></Icon>
              广告编辑
        </p>


    <Form ref="formData" :model="formData"  :label-width="80">
        <FormItem label="广告位" prop="ad_space">
            <Select v-model="formData.ad_space" @on-change="onChange" :disabled="adDisabled">
                <Option v-for="item in adSpace" :key="item.id" :value="item.id">{{item.title}}</Option>
            </Select>
        </FormItem>
        <FormItem label="标题" prop="title">
            <Input v-model="formData.title" placeholder="请输入广告标题"></Input>
        </FormItem>
        <FormItem label="有效期">
            <Row>
                <Col span="3">
                    <FormItem prop="date">
                        <DatePicker type="datetime" format="yyyy-MM-dd HH:mm" placeholder="开始" v-model="formData.start_time"></DatePicker>
                    </FormItem>
                </Col>
                <Col span="1" style="text-align: center">-</Col>
                <Col span="3">
                    <FormItem prop="time">
                        <DatePicker type="datetime" format="yyyy-MM-dd HH:mm" placeholder="结束" v-model="formData.end_time"></DatePicker>
                    </FormItem>
                </Col>
            </Row>
        </FormItem>


        <template>
          <!-- 扩展模型 -->
          <carousel  ref="carousel" v-show="modelList.carousel"></carousel>
          <singer  ref="singer" v-show="modelList.singer"></singer>

        </template>

        <FormItem label="状态" prop="status">
                <Select v-model="formData.status">
                    <Option :value="0">正常</Option>
                    <Option :value="1">冻结</Option>
                </Select>
        </FormItem>
        <FormItem label="备注" prop="desc">
            <Input v-model="formData.remarks" type="textarea" :autosize="{minRows: 5,maxRows: 10}" placeholder="备注"></Input>
        </FormItem>
        <FormItem>
            <Button type="primary" @click="handleSubmit()">提交</Button>
        </FormItem>
    </Form>

      </Card>
    </Col>
</Row>

  
</template>





<script>
  import {adSpaceGetAllsAction,adGetAction,adSaveAction,adSpaceGetAction} from '../../api/api'
  import {base} from '../../api/index'
  import {deleteButton,detailsButton,editButton} from '../../libs/common'

  import carousel from './model/Carousel.vue'
  import singer from './model/Singer.vue'

export default {
    name: 'ad-edit-page',
    components:{carousel,singer},
    data () {
        return {
            adId:0,
            //广告位
            adSpace:[],
            //设置是否可以切换广告位
            adDisabled:false,
            //模型的显示
            modelList:{
                carousel:false,
                singer:false,
            },
            formData: {
                    'id':0,
                    'ad_space':0,
                    'title':'',
                    'url':'',
                    'url_type':0,
                    'cover_img':'',
                    'val':'',
                    'extend':'',
                    'sort':'',
                    'start_time':'',
                    'end_time':'',
                    'remarks':'',
                    'status':0,
            },
        }
    },
    //加载完成自动执行
    mounted() {
      //获取列表数据
      this.getAdSpaces()
      //获取原数据
      if(this.$route.params.id != undefined){
          this.adId = parseInt(this.$route.params.id.toString())
          if(this.adId > 0){
            this.getDataInfo(this.adId)
          }
      }

    },
    methods: {
        
        //获取所有广告位
        getAdSpaces(){
                let param = {}
                adSpaceGetAllsAction(param).then(response => {
                    this.adSpace =  response.data.list;
                }).catch(function (error) {
                  console.log(error)
                });
        },
        //编辑情况获取编辑数据
        getDataInfo(id){
                let param = {id:id}
                adGetAction(param).then(response => {
                    this.formData =  Object.assign({},this.formData,{
                      'id':response.data.info.id,
                      'ad_space':response.data.info.ad_space,
                      'title':response.data.info.title,
                      'url':response.data.info.url,
                      'url_type':response.data.info.url_type,
                      'cover_img':response.data.info.cover_img,
                      'val':response.data.info.val,
                      'extend':response.data.info.extend,
                      'sort':response.data.info.sort,
                      'start_time':response.data.info.start_time,
                      'end_time':response.data.info.end_time,
                      'remarks':response.data.info.remarks,
                      'status':response.data.info.status,
                    })

                    //设置广告位不可编辑
                    this.adDisabled = true
                    //设置模型里的数据
                    this.$refs.carousel.$emit('init',this.formData);
                    this.$refs.singer.$emit('init',this.formData);
                    
                }).catch(function (error) {
                  console.log(error)
                });
        },
        //改变广告位
        onChange(){
          if(this.formData.ad_space != ''){
                //获取当前选中的广告位模型
                let param = {id:this.formData.ad_space}
                adSpaceGetAction(param).then(response => {
                      for (let i in this.modelList) {  
                          if(i == response.data.info.model){
                             this.modelList[i] = true
                          }else{
                             this.modelList[i] = false
                          }
                      }
                }).catch(function (error) {
                  console.log(error)
                });
          }
        },
        handleSubmit () {
            //获取模型里面的数据
            let modelData 
            if(this.modelList.singer){
               modelData = this.$refs.singer.$emit('get-data');
            }else if(this.modelList.carousel){
               modelData = this.$refs.carousel.$emit('get-data');
            }

            let param = Object.assign({},this.formData,modelData.formData)
            adSaveAction(param).then(response => {
                this.$Message.info(response.data.msg);
            }).catch(function (error) {
              console.log(error)
            });
        }
    },
    destroyed () {
    }
}



</script>

<style scope>

  .top {
    margin-top: 15px
  }



  .pages {
    text-align: right;
    margin-top: 10px;
    padding-right: 10px;
  }

  .form {
    margin-right: 20px;
  }

  .be-inline-block {
    /*display: inline-block;*/
    /*line-height: 50px;*/
    vertical-align: middle;
  }
  .button-warp{
   /* margin-bottom: 15px;*/
  }
  .be-inline-block .btn{
    margin-right: 15px;
  }

  .be-inline-block  .searth-input .ivu-input{
    border-radius: 32px;
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