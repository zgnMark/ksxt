<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        礼物列表
                  </p>
                  <Row>
                    <Col span="16">
                      <Row   justify="center" align="bottom" style="margin-bottom:15px;" >    
                        <Col span="3">
                            <Button type="primary" shape="circle" class="btn" icon="plus-round" @click="showCreate()">新增</Button>
                        </Col>
                      </Row>
                    </Col>
                  </Row>

                  <Row>
                    <Col span="24" class="main-inner-content">
                      <Table stripe :columns="columns" :data="data"></Table>
                    </Col>
                  </Row>

                  <Row>
                    <Col span="24" class="pages">
                    <Page :total="tableTotal" :page-size="20" :current="1" @on-change="changePage" show-elevator></Page>
                    </Col>
                  </Row>

                    <Modal
                      v-model="giftFlag"
                      :title="giftTitle"
                      @on-ok="save"
                      @on-cancel="cancel">
                      <Form ref="gift" :model="gift"  :label-width="80" class="form">
                        <Form-item label="礼物名称" prop="name">
                          <Input v-model="gift.name" placeholder="请输入礼物名称"></Input>
                        </Form-item>
                        <Form-item label="所属组" prop="type">
                          <Select v-model="gift.group_id">
                              <Option v-for="item in group" :key="item.id" :value="item.id">{{item.name}}</Option>
                          </Select>
                        </Form-item>
                        <Form-item label="图标" prop="type">
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
                        <Form-item label="等值金币" prop="currency">
                          <Input v-model="gift.currency" placeholder="请输入等值金币"></Input>
                        </Form-item>
                        <Form-item label="状态" prop="type">
                          <Select v-model="gift.status">
                              <Option :value="0">正常</Option>
                              <Option :value="1">关闭</Option>
                          </Select>
                        </Form-item>
                        <Form-item label="备注" prop="remarks">
                          <Input v-model="gift.remarks" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="请输入备注"></Input>
                        </Form-item>
                      </Form>
                    </Modal>
              </Card>
            </Col>
        </Row>

  
</template>

<script>
 
  import {uploadApiAction,giftGroupGetAllsAction,giftListsAction,giftSaveAction,giftGetAction,giftDelAction} from '../../api/api'
  import {base} from '../../api/index'
  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  export default {
    name: 'gift-lists',
    data () {
      return {
                tableTotal: 20,
                current: 1,
                loading:true,
                columns: [
                    {
                        title: '编号',
                        key: 'id',
                        width:100
                    },
                    {
                        title: '所属组',
                        key: 'group_id'
                    },
                    {
                        title: '礼物名称',
                        key: 'name'
                    },
                    {
                        title: '兑换星币',
                        key: 'currency'
                    },
                    {
                        title: '图标',
                        key: 'gift_url',
                        render: (h, params) => {
                          if(params.row.gift_url != ''){
                                return h('Img', {
                                  attrs:{
                                    'src':base + params.row.gift_url
                                  },
                                  style: {
                                    width: '100px',
                                    'margin-top':'5px',
                                    height:'100px'
                                  }
                                })
                          }else{
                               return 'null'
                          }
                        }
                    },
                    {
                        title: '状态',
                        key: 'status',
                        render: (h, params) => {
                          if(params.row.status == 0){
                                return '正常'
                          }else{
                               return h('Font', {
                                  style: {
                                    color: 'red'
                                  }
                                }, '关闭')
                          }
                        }
                    },
                    {
                        title: '备注',
                        key: 'remarks'
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 300,
                        align: 'center',
                        render: (h, params) => {
                          return h('div', [
                            editButton(
                              ()=>{
                                this.showCreate(params.row.id)
                              },h
                            ),
                            deleteButton(()=>{this.remove(params.index,params.row.id)},h)
                          ]);
                        }
                    }
                ],
                data: [],

                group:[],
                //管理员
                giftFlag:false,
                giftTitle:'新增',
                gift:{
                    'id':0,
                    'group_id':0,
                    'name':'',
                    'gift_url':'',
                    'currency':'',
                    'status':0,
                    'remarks':''
                },

                //上传
                uploadApiAction:uploadApiAction,
                defaultList: [],
                imgName: '',
                uploadList: []
      }
    },
    //加载完成自动执行
    mounted() {
      //获取列表数据
      this.getDataList()
      this.getGroup()

      this.uploadList = this.$refs.upload.fileList;
    },
    methods: {
            //获取数据
            getDataList() {
                this.loading = true
                let param = {
                        page:this.current,
                    }
                giftListsAction(param).then(response => {
                    this.loading = false
                    this.data =  response.data.list;
                    this.tableTotal = response.data.total;
                    console.log(this.data)
                }).catch(function (error) {
                  console.log(error)
                });
            },
            cancel(){},
            changePage (page) {
                console.log(page)
                this.current = page
                this.data = this.getDataList();
            },
            search (){
                this.current = 1
                this.getDataList()
            },
            save(){
                let param = this.gift
                giftSaveAction(param).then(response => {
                  console.log(response)
                  this.$Message.info(response.data.msg);
                  this.getDataList()
                }).catch(function (error) {
                  console.log(error)
                });
            },
            getGroup(){
                let param = {}
                giftGroupGetAllsAction(param).then(response => {
                  this.group = response.data.list
                }).catch(function (error) {
                  console.log(error)
                });
            },

            showCreate (index) {
              this.giftFlag=true
              if(index > 0){
                  this.giftTitle = "更改"
                  let param = {id:index}
                  giftGetAction(param).then(response => {
                    this.gift = Object.assign({},this.gift,{
                        id:response.data.info.id,
                        group_id:response.data.info.group_id,
                        name:response.data.info.name,
                        gift_url:response.data.info.gift_url,
                        remarks:response.data.info.remarks,
                        status:response.data.info.status,
                        currency:response.data.info.currency,
                    })

                    if(response.data.info.gift_url != ''){
                        this.defaultList = [];
                        this.defaultList = this.defaultList.concat(
                                          [
                                              {
                                                  'name': '图片',
                                                  'url': base + response.data.info.gift_url,
                                                  'status':'finished'
                                              }
                                          ]
                        );
                        this.uploadList  = [Object.assign({},this.defaultList[0])]
                    }else{
                        this.uploadList  = []
                    }
                  }).catch(function (error) {
                    console.log(error)
                  });
              }else{
                this.giftTitle = "新增"
                this.gift = {}
              }
            },
            remove (index,id) {
                let param = {id:id}
                giftDelAction(param).then(response => {
                  this.$Message.info(response.data.msg);
                  this.data.splice(index, 1);
                }).catch(function (error) {
                  this.$Message.info('删除失败');
                });
            },

            //上传
            //上传成功
            handleSuccess (res, file) {
                file.url = base + res.data.info;
                file.name = "图片";
                this.gift.gift_url = res.data.info
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