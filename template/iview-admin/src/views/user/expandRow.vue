<style scoped>
    .expand-row{
        margin-bottom: 16px;
    }
</style>
<template>
    <div>
        <Row class="expand-row">
            <Col span="8">
                <span class="expand-key">昵称: </span>
                <span class="expand-value">{{ row.userData.nickname }}</span>
            </Col>
            <Col span="8">
                <span class="expand-key">真实性名: </span>
                <span class="expand-value">{{ row.userData.realname }}</span>
            </Col>
            <Col span="8">
                <span class="expand-key">性别: </span>
                <span class="expand-value">{{ row.userData.sex }}</span>
            </Col>
        </Row>
        <Row>
            <Col span="8">
                <span class="expand-key">登录次数: </span>
                <span class="expand-value">{{ row.userData.login_num }}</span>
            </Col>
            <Col span="8">
                <span class="expand-key">最后登录时间: </span>
                <span class="expand-value">{{ row.userData.last_login_time }}</span>
            </Col>
            <Col span="8">
                <span class="expand-key">签名: </span>
                <span class="expand-value">{{ row.userData.signature }}</span>
            </Col>
        </Row>
    </div>
</template>
<script>
    export default {
        props: {
            row: Object
        }
    };
</script>