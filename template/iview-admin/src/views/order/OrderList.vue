<template>
          <Row :gutter="10">
            <Col span="24">
                <Card>
                  <p slot="title">
                        <Icon type="pinpoint"></Icon>
                        支付订单列表
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
 
  import {orderListsAction,orderDelAction} from '../../api/api'
  import {deleteButton,detailsButton,editButton} from '../../libs/common'
  export default {
    name: 'order-lists',
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
                      title: '用户',
                      key: 'user_id'
                  },
                  {
                      title: '订单号',
                      key: 'order_no'
                  },
                  {
                      title: '支付金额',
                      key: 'amount'
                  },
                  {
                      title: '交易状态',
                      key: 'status'
                  },
                  {
                      title: '备注',
                      key: 'remarks'
                  },
                  {
                      title: '订单创建时间',
                      key: 'create_time'
                  },
                  {
                    title: '操作',
                    key: 'action',
                    width: 300,
                    align: 'center',
                    render: (h, params) => {
                      return h('div', [
                        deleteButton(()=>{this.remove(params.index,params.row.id)},h)
                      ]);
                    }
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
                        page:this.current
                    }
                orderListsAction(param).then(response => {
                    this.loading = false
                    this.data =  response.data.list;
                    this.tableTotal = response.data.total;
                    console.log(this.data)
                }).catch(function (error) {
                  console.log(error)
                });
            },
            changePage (page) {
                console.log(page)
                this.current = page
                this.data = this.getDataList();
            },

            remove (index,id) {
                let param = {id:id}
                orderDelAction(param).then(response => {
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
