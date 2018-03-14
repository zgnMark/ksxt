<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        广告列表
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

              </Card>
            </Col>
        </Row>

  
</template>

<script>
  import {adListsAction,adSaveAction,adGetAction,adDelAction} from '../../api/api'
  import {base} from '../../api/index'
  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  export default {
    name: 'ad-lists',
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
                        title: '广告位',
                        key: 'ad_space'
                    },
                    {
                        title: '标题',
                        key: 'title'
                    },
                    {
                        title: '链接',
                        key: 'url'
                    },
                    {
                        title: '封面图',
                        key: 'cover_img',
                        render: (h, params) => {
                          if(params.row.cover_img != ''){
                                return h('Img', {
                                  attrs:{
                                    'src':base + params.row.cover_img
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
                searchParam:{},
                formItem: {},
                adModel:[],
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
                    }
                adListsAction(param).then(response => {
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
            remove (index,id) {
                let param = {id:id}
                adDelAction(param).then(response => {
                  this.$Message.info(response.data.msg);
                  this.data.splice(index, 1);
                }).catch(function (error) {
                  this.$Message.info('删除失败');
                });
            },
            showCreate(id){
              if(id > 0){
                this.$router.push({
                                   name: 'ad-edit',
                                   params: { id: id }
                                 });
              }else{
                this.$router.push({ name: 'ad-edit', params: { id: id }})
              }
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