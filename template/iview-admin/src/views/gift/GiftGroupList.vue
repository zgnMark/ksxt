<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        礼物组列表
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
                      v-model="groupFlag"
                      :title="groupTitle"
                      @on-ok="save"
                      @on-cancel="cancel">
                      <Form ref="group" :model="group"  :label-width="80" class="form">
                        <Form-item label="组名" prop="name">
                          <Input v-model="group.name" placeholder="请输入组名"></Input>
                        </Form-item>
                        <Form-item label="状态" prop="type">
                          <Select v-model="group.status">
                              <Option :value="0">正常</Option>
                              <Option :value="1">关闭</Option>
                          </Select>
                        </Form-item>
                        <Form-item label="备注" prop="remarks">
                          <Input v-model="group.remarks" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="请输入备注"></Input>
                        </Form-item>
                      </Form>
                    </Modal>
              </Card>
            </Col>
        </Row>

  
</template>

<script>
 
  import {giftGroupListsAction,giftGroupSaveAction,giftGroupGetAction,giftGroupDelAction} from '../../api/api'
  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  export default {
    name: 'gift-group-list',
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
                        title: '组名称',
                        key: 'name'
                        
                    },
                    {
                        title: '备注',
                        key: 'remarks'
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
                                }, '未启用')
                          }
                        }
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
                searchParam:{},


                //管理员
                groupFlag:false,
                groupTitle:'新增',
                group:{
                      id:0,
                      name:'',
                      remarks:'',
                      status:0
                }
      }
    },
    //加载完成自动执行
    mounted() {
      //获取列表数据
      this.getDataList()
    },
    methods: {
            //获取数据
            getDataList() {
                this.loading = true
                let param = {
                        page:this.current
                    }
                giftGroupListsAction(param).then(response => {
                    this.loading = false
                    this.data =  response.data.list;
                    this.tableTotal = response.data.total;
                    console.log(this.data)
                }).catch(function (error) {
                  console.log(error)
                });
            },
            save(){
                let param = this.group
                giftGroupSaveAction(param).then(response => {
                  this.$Message.info(response.data.msg);
                  this.getDataList()
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
            showCreate (index) {
              this.groupFlag=true
              if(index > 0){
                  this.groupTitle = "更改"
                  let param = {id:index}
                  giftGroupGetAction(param).then(response => {
                    this.group = Object.assign({},this.group,{
                        id:response.data.info.id,
                        name:response.data.info.name,
                        remarks:response.data.info.remarks,
                        status:response.data.info.status,
                    })
                  }).catch(function (error) {
                    console.log(error)
                  });
              }else{
                this.title = "新增"
                this.group = {}
              }
            },
            remove (index,id) {
                let param = {id:id}
                giftGroupDelAction(param).then(response => {
                  this.$Message.info(response.data.msg);
                  this.data.splice(index, 1);
                }).catch(function (error) {
                  this.$Message.info('删除失败');
                });
            },

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

</style>