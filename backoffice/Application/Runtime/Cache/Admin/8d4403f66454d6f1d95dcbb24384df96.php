<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="background-color: #f2f2f2;color: #666;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>微视云监控平台</title>
    <link rel="icon" href="/Public/Images/office/logo.png" type="image/x-icon"/>
    <link rel="stylesheet" href="/Public/layui/css/layui.css">
    <link rel="stylesheet" href="/Public/CSS/global.css">
    <!--<link rel="stylesheet" href="/Public/CSS/base.css">-->

    <?php if(isset($css_files)): if(is_array($css_files)): foreach($css_files as $css_file_path=>$media): ?><link href='/Public/CSS/<?php echo ($css_file_path); ?>?version=<?php echo ($version); ?>' rel="stylesheet" type="text/css" /><?php endforeach; endif; endif; ?>

</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <input type="hidden" id="baseUrl" value="<?php echo ($baseUrl); ?>">
    <input type="hidden" id="warningDialog" value="<?php echo ($warningDialog); ?>">
    <input type="hidden" value="<?php echo ($adminTopic); ?>" id="adminTopic" />
    <input type="hidden" value="<?php echo ($mqttServer); ?>" id="mqttServer" />
    <input type="hidden" value="<?php echo ($mqttServerPort); ?>" id="mqttServerPort" />
    <div class="layui-header">
    <div class="layui-logo" style="width: 190px;"><img style="width: 24%;margin: 5px;" src="/Public/Images/office/web-logo.png">微视云监控平台</div>

        <?php echo ($topMenu); ?>
        <!--头部menu end-->
        <ul class="layui-nav layui-layout-right">

            <li class="layui-nav-item">
                <a href="<?php echo ($baseUrl); ?>/Admin/adminMsg">
                    <i class="layui-icon layui-icon-reply-fill"><span  class="layui-badge" id="msgNum"><?php echo ($msgNum); ?></span></i>
                </a>

            </li>

            <li class="layui-nav-item">
                <a href="javascript:;">管理员：<?php echo ($username); ?></a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo ($baseUrl); ?>/Admin/adminInfo">个人信息</a></dd>
                    <dd><a href="<?php echo ($baseUrl); ?>/Logout/index">退出</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <?php echo ($menu); ?>
        </div>
    </div>

    <div class="layui-body">
        <div style="background-color: #f5f5f5;min-height: 40px;line-height: 40px;padding: 0 12px 0;">
            <span class="layui-breadcrumb" lay-separator=">">

                <?php if(is_array($breadcrumb)): foreach($breadcrumb as $name=>$url): if(!empty($url)): ?><a href="<?php echo ($url); ?>"><?php echo ($name); ?></a>

                                <?php else: ?>
                                <a href="#"><?php echo ($name); ?></a><?php endif; endforeach; endif; ?>
            </span>
        </div>

        <!-- 内容主体区域 -->
        <div class="layui-fluid">
            

    <div class="layui-card">
        <div class="layui-card-body">

                <div class="layui-card">
                    <div class="layui-card-header"><a href="<?php echo ($baseUrl); ?>/Behavior/lists/companyId/<?php echo ($companyInfo['id']); ?>/company/<?php echo ($companyInfo['name']); ?>">预警信息(查看列表)</a></div>
                    <div class="layui-card-body">
                        <div class="layui-carousel layadmin-carousel layadmin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%;">
                            <ul class="layui-row layui-col-space10 layui-this">
                                <li class="layui-col-xs4">
                                        <span class="layadmin-backlog-body">
                                        <h3>当日警报次数</h3>
                                        <p><cite><?php echo ($monitor['today']); ?></cite></p>
                                    </span>
                                </li>
                                <li class="layui-col-xs4">
                                        <span class="layadmin-backlog-body">
                                        <h3>总警报次数</h3>
                                        <p><cite><?php echo ($monitor['all']); ?></cite></p>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


            <div class="layui-tab layui-tab-card">
                <ul class="layui-tab-title">
                    <li class="layui-this">基本信息</li>
                    <li>公司数据</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <form class="layui-form layui-form-pane" action="">

                            <div class="layui-form-item">
                                <label class="layui-form-label">公司名称</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly autocomplete="off" class="layui-input" value="<?php echo ($companyInfo['name']); ?>">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">联系方式</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly class="layui-input" value="<?php echo ($companyInfo['phone']); ?>">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">邮箱</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly class="layui-input" value="<?php echo ($companyInfo['email']); ?>">
                                </div>
                            </div>

                            <div class="layui-form-item">
                                <label class="layui-form-label">注册时间</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly class="layui-input" value="<?php echo ($companyInfo['create_time_str']); ?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <?php if($companyInfo['package']): ?><div class="layui-inline">
                                        <label class="layui-form-label">套餐时间</label>
                                        <div class="layui-input-inline" style="width: 100px;">
                                            <input readonly type="text" autocomplete="off" class="layui-input" value="<?php echo ($companyInfo['package']['start_time_str']); ?>">
                                        </div>
                                        <div class="layui-form-mid">至</div>
                                        <div class="layui-input-inline" style="width: 100px;">
                                            <input readonly type="text" autocomplete="off" class="layui-input" value="<?php echo ($companyInfo['package']['end_time_str']); ?>">
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <label class="layui-form-label">套餐</label>
                                    <div class="layui-input-inline">
                                        <input type="text" readonly class="layui-input" value="暂无">
                                    </div><?php endif; ?>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">套餐设备数</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly class="layui-input" value="<?php echo ($companyInfo['package']['devices']); ?>">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">已用设备数</label>
                                <div class="layui-input-inline">
                                    <input type="text" readonly class="layui-input" value="<?php echo ($companyInfo['package']['device_use']); ?>">
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="layui-tab-item">

                        <div class="layui-card">
                            <div class="layui-card-header"><a href="<?php echo ($baseUrl); ?>/Device/lists/companyId/<?php echo ($companyInfo['id']); ?>/company/<?php echo ($companyInfo['name']); ?>">设备数据(查看列表)</a></div>
                            <div class="layui-card-body">
                                <div class="layui-carousel layadmin-carousel layadmin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%;">
                                    <ul class="layui-row layui-col-space10 layui-this">
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>总数量</h3><p><cite><?php echo $baseData['device_enable']+$baseData['device_disable']; ?></cite></p></span>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>未删设备数</h3><p><cite><?php echo ($baseData['device_enable']); ?></cite></p></span>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>已删设备数</h3><p><cite><?php echo ($baseData['device_disable']); ?></cite></p></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="layui-card">
                            <div class="layui-card-header"><a href="<?php echo ($baseUrl); ?>/Driver/lists/companyId/<?php echo ($companyInfo['id']); ?>/company/<?php echo ($companyInfo['name']); ?>">司机数据(查看列表)</a></div>
                            <div class="layui-card-body">
                                <div class="layui-carousel layadmin-carousel layadmin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%;">
                                    <ul class="layui-row layui-col-space10 layui-this">
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>总数量</h3><p><cite><?php echo $baseData['driver_enable']+$baseData['driver_disable']; ?></cite></p></span>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>未删司机数</h3><p><cite><?php echo ($baseData['driver_enable']); ?></cite></p></span>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>已删司机数</h3><p><cite><?php echo ($baseData['driver_disable']); ?></cite></p></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="layui-card">
                            <div class="layui-card-header"><a href="<?php echo ($baseUrl); ?>/Vehicle/lists/companyId/<?php echo ($companyInfo['id']); ?>/company/<?php echo ($companyInfo['name']); ?>">车辆数据(查看列表)</a> </div>
                            <div class="layui-card-body">
                                <div class="layui-carousel layadmin-carousel layadmin-backlog" lay-anim="" lay-indicator="inside" lay-arrow="none" style="width: 100%;">
                                    <ul class="layui-row layui-col-space10 layui-this">
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>总数量</h3><p><cite><?php echo $baseData['vehicle_enable']+$baseData['vehicle_disable']; ?></cite></p></span>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>未删车辆数</h3><p><cite><?php echo ($baseData['vehicle_enable']); ?></cite></p></span>
                                        </li>
                                        <li class="layui-col-xs4">
                                            <span class="layadmin-backlog-body"><h3>已删车辆数</h3><p><cite><?php echo ($baseData['vehicle_disable']); ?></cite></p></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>


        </div>

    </div>

    <div class="site-tree-mobile layui-hide"><i class="layui-icon"></i></div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->

    </div>
</div>
<div class="warning-pop"></div>
<div class="site-mobile-shade"></div>
<script src="/Public/Js/jquery.min.js"></script>
<script src="/Public/layui/layui.js"></script>
<script src="/Public/Js/admin/mqttws31.js?version=<?php echo ($version); ?>"></script>
<script src="/Public/Js/admin/getNews.js?version=<?php echo ($version); ?>"></script>
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;
        var treeMobile = $('.site-tree-mobile'),
                shadeMobile = $('.site-mobile-shade');

        treeMobile.on('click', function(){
            $('body').addClass('site-mobile');
        });

        shadeMobile.on('click', function(){
            $('body').removeClass('site-mobile');
        });
    });

</script>
<!-- add page js-->
<?php if(isset($js_all_files)): if(is_array($js_all_files)): foreach($js_all_files as $key=>$js_file_path): ?><script src="<?php echo ($js_file_path); ?>" type="text/javascript"></script><?php endforeach; endif; endif; ?>
<!-- end of add js-->

<!-- add page js-->
<?php if(isset($js_files)): if(is_array($js_files)): foreach($js_files as $key=>$js_file_path): ?><script src="/Public/Js/<?php echo ($js_file_path); ?>?version=<?php echo ($version); ?>" type="text/javascript"></script><?php endforeach; endif; endif; ?>



<!-- end of add js-->
</body>
</html>