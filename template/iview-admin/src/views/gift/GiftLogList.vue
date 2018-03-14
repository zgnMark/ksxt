<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        礼物日志列表
                  </p>

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
 
  import {giftLogListsAction} from '../../api/api'
  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  export default {
    name: 'gift-log-lists',
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
                        title: '发出用户',
                        key: 'user_id'
                    },
                    {
                        title: '接收用户',
                        key: 'receive_user_id'
                    },
                    {
                        title: '礼物',
                        key: 'gift_id'
                    },
                    {
                        title: '数量',
                        key: 'num'
                    },
                    {
                        title: '直播频道',
                        key: 'live_id'
                    }
                ],
                data: []
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
                giftLogListsAction(param).then(response => {
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
</style>