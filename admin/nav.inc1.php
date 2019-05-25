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
                        <i class="m3"></i>
                        <h4>校友信息管理</h4>
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

            <div class="item <?php if ($FLAG_FIRST_LEFTNAV === 'notice') echo "current" ?>">
                <div class="tit">
                    <a href="javascript:void(0);">
                        <i class="m4"></i>
                        <h4>通知公告</h4>
                    </a>
                </div>
                <div class="sub-menu">
                    <ul>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'notice') echo "curr" ?>">
                            <a href="school_news.php" data_link="table/table2.html">
                                <h5>学校新闻</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'notice') echo "curr" ?>">
                            <a href="alumni_alerts.php" data_link="table/table2.html">
                                <h5>校友快讯</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'notice') echo "curr" ?>">
                            <a href="alumni_activities.php" data_link="table/table2.html">
                                <h5>校友活动</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'notice') echo "curr" ?>">
                            <a href="alumni_donate.php" data_link="table/table2.html">
                                <h5>校友捐赠</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'notice') echo "curr" ?>">
                            <a href="alumni_show.php" data_link="table/table2.html">
                                <h5>校友风采</h5>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="item <?php if ($FLAG_FIRST_LEFTNAV === 'service') echo "current" ?>">
                <div class="tit">
                    <a href="javascript:void(0);">
                        <i class="m5"></i>
                        <h4>校友综合服务</h4>
                    </a>
                </div>
                <div class="sub-menu">
                    <ul>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service') echo "curr" ?>">
                            <a href="address_book.php" data_link="table/table2.html">
                                <h5>校友通讯录</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service') echo "curr" ?>">
                            <a href="donate.php" data_link="table/table2.html">
                                <h5>校友捐赠</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service') echo "curr" ?>">
                            <a href="life_service.php" data_link="table/table2.html">
                                <h5>校友生活服务</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service') echo "curr" ?>">
                            <a href="secondary_market.php" data_link="table/table2.html">
                                <h5>二手乐淘</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'service') echo "curr" ?>">
                            <a href="about_us.php" data_link="table/table2.html">
                                <h5>关于我们</h5>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="item <?php if ($FLAG_FIRST_LEFTNAV === 'bbs') echo "current" ?>">
                <div class="tit">
                    <a href="javascript:void(0);">
                        <i class="m6"></i>
                        <h4>校友论坛</h4>
                    </a>
                </div>
                <div class="sub-menu">
                    <ul>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'bbs') echo "curr" ?>">
                            <a href="new_topic.php" data_link="table/table2.html">
                                <h5>最新话题</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'bbs') echo "curr" ?>">
                            <a href="search_classmates.php" data_link="table/table2.html">
                                <h5>寻找校友</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'bbs') echo "curr" ?>">
                            <a href="alumni_enterprises.php" data_link="table/table2.html">
                                <h5>校友企业</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'bbs') echo "curr" ?>">
                            <a href="alumni_hiring.php" data_link="table/table2.html">
                                <h5>校友招聘</h5>
                            </a>
                        </li>
                        <li class="itemlink <?php if ($FLAG_SECOND_LEFTNAV == 'bbs') echo "curr" ?>">
                            <a href="alumni_marriage.php" data_link="table/table2.html">
                                <h5>校友征婚</h5>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>


        </div>
    </div>
</div>