<?php
namespace app\admin\controller;

class Index extends controller
{
    public function index()
    {
        return $this->redirect(url('admin/v1.index/index'));
    }
}

?>