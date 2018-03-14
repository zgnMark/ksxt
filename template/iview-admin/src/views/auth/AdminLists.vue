<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        管理员列表
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
                      title="编辑组"
                      @on-ok="updateGroup"
                      @on-cancel="cancel">
                      <Form ref="roleId" :label-width="80" class="form">
                        <FormItem label="角色" >
                            <CheckboxGroup v-model="groups">
                                <Checkbox  :label="item.id"  v-for="item in groupData" :key="item.id" >
                                  {{item.title}}
                                </Checkbox>
                            </CheckboxGroup>
                        </FormItem>
                      </Form>
                    </Modal>

                    <Modal
                      v-model="adminFlag"
                      :title="adminTitle"
                      @on-ok="updateAdmin"
                      @on-cancel="cancel">
                      <Form ref="admin" :model="admin"  :label-width="80" class="form">
                        <Form-item label="用户名" prop="username">
                          <Input v-model="admin.username" placeholder="请输入用户名"></Input>
                        </Form-item>
                        <Form-item label="邮件" prop="email">
                          <Input v-model="admin.email" placeholder="请输入英文名称"></Input>
                        </Form-item>
                        <Form-item label="手机" prop="mobile">
                          <Input v-model="admin.mobile" placeholder="请输入手机号"></Input>
                        </Form-item>
                        <Form-item label="密码" prop="password">
                          <Input v-model="admin.password" placeholder="请输入密码"></Input>
                        </Form-item>
                        <Form-item label="状态" prop="type">
                          <Select v-model="admin.status">
                              <Option :value="0">正常</Option>
                              <Option :value="1">冻结</Option>
                          </Select>
                        </Form-item>
                        <Form-item label="备注" prop="remark">
                          <Input v-model="admin.remark" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="请输入备注"></Input>
                        </Form-item>
                      </Form>
                    </Modal>
              </Card>
            </Col>
        </Row>

  
</template>

<script>
 
  import {adminListsAction,adminGroupListAction,saveAdminGroupAction,adminGetAction,adminSaveAdminAction,adminDeleteAction} from '../../api/api'
  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  export default {
    name: 'admin-lists',
  
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
                        title: '用户名',
                        key: 'username'
                        
                    },
                    {
                        title: '邮箱',
                        key: 'email'
                       
                    },
                    {
                        title: '手机',
                        key: 'mobile'
                        
                    },
                    {
                        title: '状态',
                        key: 'status'
                    },
                    {
                        title: '备注',
                        key: 'remark'
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
                            h('Button', {
                              props: {
                                type: 'primary',
                                icon:"",
                                size: 'small'
                              },
                              style: {
                                marginRight: '5px'
                              },
                              on: {
                                click: () => {
                                  this.showCreateGroup(params.row.id)
                                }
                              }
                            }, '编辑组'),

                            deleteButton(()=>{this.remove(params.index,params.row.id)},h)
                          ]);
                        }
                    }
                ],
                data: [],
                searchParam:{},
                formItem: {
                    username: '',
                    email:'',
                    mobile:'',
                    status:''
                },
                //编辑角色
                groupFlag:false,
                //所有角色
                groupData:[],
                //选中的角色
                groups:[],
                //当前弹窗选中的用户
                groupId:0,

                //管理员
                adminFlag:false,
                adminTitle:'新增用户',
                admin:{
                      username:'',
                      password:'',
                      nickname:'',
                      email:'',
                      mobile:'',
                      remark:'',
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
                        page:this.current,
                        username:this.searchParam.username,
                        email:this.searchParam.email,
                        mobile:this.searchParam.mobile,
                        status:this.searchParam.status
                    }
                adminListsAction(param).then(response => {
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
                this.searchParam = this.formItem
                this.current = 1
                this.getDataList()
            },
            updateGroup (){
                let param = {
                  id:this.groupId,
                  groups:this.groups.join(",")
                }
                saveAdminGroupAction(param).then(response => {
                  console.log(response)
                  this.$Message.info(response.data.msg);
                }).catch(function (error) {
                  console.log(error)
                });
            },
            showCreateGroup(index) {
                this.groupFlag=true
                this.groupId = index
                let param = {id:index}
                adminGroupListAction(param).then(response => {
                  this.groupData = response.data.list
                  this.groups = response.data.selectData
                }).catch(function (error) {
                  console.log(error)
                });
            },
            updateAdmin(){
                let param = this.admin
                adminSaveAdminAction(param).then(response => {
                  console.log(response)
                  this.$Message.info(response.data.msg);
                  this.getDataList()
                }).catch(function (error) {
                  console.log(error)
                });
            },
            showCreate (index) {
              this.adminFlag=true
              if(index > 0){
                  this.adminTitle = "更改"
                  let param = {id:index}
                  adminGetAction(param).then(response => {
                    this.admin = Object.assign({},this.group,{
                        id:response.data.info.id,
                        username:response.data.info.username,
                        password:'',
                        nickname:response.data.info.nickname,
                        email:response.data.info.email,
                        mobile:response.data.info.mobile,
                        remark:response.data.info.remark,
                        status:response.data.info.status,
                    })
                  }).catch(function (error) {
                    console.log(error)
                  });
              }else{
                this.title = "新增"
                this.admin = {}
              }
            },
            remove (index,id) {
                let param = {id:id}
                adminDeleteAction(param).then(response => {
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