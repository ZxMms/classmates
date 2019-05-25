<div class="mainLeft">
    <div class="mainLogo">
        <a href="index.php"><img src="static/images/xsyu.png"/></a>
    </div>
    <div class="admin_nav">
        <div class="navLeftTab">

            <div class="item <?php if ($FLAG_FIRST_LEFTNAV === 'index') echo "current" ?> ">
                <div class="tit">
                    <a href="index.php">
                        <i class="m1"></i>
                        <h4>首页</h4>
                    </a>
                </div>
            </div>

            <div class="item <?php if ($FLAG_FIRST_LEFTNAV === 'accout') echo "current" ?>">
                <div class="tit">
                    <a href="account_manage.php">
                        <i class="m2"></i>
                        <h4>账号管理</h4>
                    </a>
                </div>

            </div>

            <div class="item <?php if ($FLAG_FIRST_LEFTNAV === 'classmates') echo "current" ?>">
                <div class="tit">
                    <a href="javascript:void(0);">
                        <i class="m6"></i>
                        <h4>校友信息</h4>
                    </a>
                </div>
                <div class="sub-menu">
                    <ul>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'classmates_list') echo "curr" ?>">
                            <a href="classmates_list.php" data_link="table/table2.html">
                                <h5>校友信息维护</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'see_info') echo "curr" ?>">
                            <a href="see_info.php" data_link="table/table2.html">
                                <h5>信息可视化</h5>
                            </a>
                        </li>


                    </ul>
                </div>
            </div>
            <div class="item <?php if ($FLAG_FIRST_LEFTNAV === 'service') echo "current" ?>">
                <div class="tit">
                    <a href="javascript:void(0);">
                        <i class="m6"></i>
                        <h4>校友综合服务</h4>
                    </a>
                </div>
                <div class="sub-menu">
                    <ul>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service_news') echo "curr" ?>">
                            <a href="service_news.php" data_link="table/table2.html">
                                <h5>校友新闻动态</h5>
                            </a>
                        </li>
<!--                        <li class="itemlink --><?php //if ($FLAG_SECOND_LEFTNAV == 'service_job') echo "curr" ?><!--">-->
<!--                            <a href="classmates_list.php" data_link="table/table2.html">-->
<!--                                <h5>校友论坛（复议）</h5>-->
<!--                            </a>-->
<!--                        </li>-->
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service_job') echo "curr" ?>">
                            <a href="service_job.php" data_link="table/table2.html">
                                <h5>校友企业招聘</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service_people') echo "curr" ?>">
                            <a href="service_people.php" data_link="table/table2.html">
                                <h5>部分杰出校友</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service_paper') echo "curr" ?>">
                            <a href="service_paper.php" data_link="table/table2.html">
                                <h5>校友文苑</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service_meeting') echo "curr" ?>">
                            <a href="service_meeting.php" data_link="table/table2.html">
                                <h5>校友聚会服务</h5>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="item <?php if ($FLAG_FIRST_LEFTNAV === 'donate') echo "current" ?>">
                <div class="tit">
                    <a href="javascript:void(0);">
                        <i class="m6"></i>
                        <h4>校友捐赠</h4>
                    </a>
                </div>
                <div class="sub-menu">
                    <ul>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'donate_record') echo "curr" ?>">
                            <a href="donate_record.php" data_link="table/table2.html">
                                <h5>校友捐赠记录</h5>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>