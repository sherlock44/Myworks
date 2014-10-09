<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>管理页面</title>
        
		<!-- Maniac stylesheets -->
        <link rel="stylesheet" href="css/bootstrap.min.css" tppabs="http://demo.yakuzi.eu/maniac/css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/font-awesome.min.css" tppabs="http://demo.yakuzi.eu/maniac/css/font-awesome.min.css" />
        <link rel="stylesheet" href="css/animate/animate.min.css" tppabs="http://demo.yakuzi.eu/maniac/css/animate/animate.min.css" />
        <link rel="stylesheet" href="css/style.css" tppabs="http://demo.yakuzi.eu/maniac/css/style.css" />
	</head>
	<body class="fixed">
        <!-- Header -->
        <header>
			<a href="index.html" tppabs="http://demo.yakuzi.eu/maniac/index.html" class="logo"><i class="fa fa-bolt"></i> <span>投票管理</span></a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="navbar-btn sidebar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown widget-user">
                            <ul class="dropdown-menu">
								<li>
									<a href="#"><i class="fa fa-cog"></i>Settings</a>
								</li>
								<li>
									<a href="javascript:if(confirm(%27http://demo.yakuzi.eu/maniac/profile.html  \n\nThis file was not retrieved by Teleport Ultra, because the server reports that this file cannot be found.  \n\nDo you want to open it from the server?%27))window.location=%27http://demo.yakuzi.eu/maniac/profile.html%27" tppabs="http://demo.yakuzi.eu/maniac/profile.html"><i class="fa fa-user"></i>Profile</a>
								</li>
								<li class="footer">
									<a href="#"><i class="fa fa-power-off"></i>Logout</a>
								</li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
		<!-- /.header -->
		 
		<!-- 菜单栏 -->
        <div class="wrapper">
            <div class="leftside">
                <div class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="sub-nav">
                            <a href="#">
                                <i class="fa fa-briefcase"></i>
                                <span>投票管理</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sub-menu">
                                <li><a href="javascript:allscore();">所有选手分数</a></li>
								<li><a href="javascript:groupscore();">分组查看</a></li>
                            </ul>
                        </li>
                        <li class="sub-nav">
                            <a href="#">
                                <i class="fa fa-pencil"></i>
                                <span>选手管理</span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                            <ul class="sub-menu">
								<li><a href="javascript:addhero();">添加</a></li>
								<li><a href="javascript:updatehero();">编辑</a></li>
                            </ul>
                        </li>
                    </ul>
						
					</div>
				 </div>
            </div><!--菜单栏-->


			<!--自定义页面-->
            <div class="rightside">
                <div class="page-head">
					<iframe style="border:none;height:650px;width:100%;" src="allscore.php">
					</iframe>
                </div>

                <div class="content">
                <!-- Main row -->
					<div class="row">
					</div><!-- /.row -->
				</div>
			</div><!-- /.自定义页面 -->
		</div>
		
        <!-- Javascript -->
        <script src="js/plugins/jquery/jquery-1.10.2.min.js" tppabs="http://demo.yakuzi.eu/maniac/js/plugins/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jquery-ui/jquery-ui-1.10.4.min.js" tppabs="http://demo.yakuzi.eu/maniac/js/plugins/jquery-ui/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
		
		<!-- Bootstrap -->
        <script src="js/plugins/bootstrap/bootstrap.min.js" tppabs="http://demo.yakuzi.eu/maniac/js/plugins/bootstrap/bootstrap.min.js" type="text/javascript"></script>
		
		<!-- Interface -->
        <script src="js/plugins/slimScroll/jquery.slimscroll.min.js" tppabs="http://demo.yakuzi.eu/maniac/js/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="js/plugins/pace/pace.min.js" tppabs="http://demo.yakuzi.eu/maniac/js/plugins/pace/pace.min.js" type="text/javascript"></script>
		
		<!-- Forms -->
		<script src="js/custom.js" tppabs="http://demo.yakuzi.eu/maniac/js/custom.js" type="text/javascript"></script>
		<script type="text/javascript">
			function allscore(){
				$('iframe').attr({src:"allscore.php"});
			}
			function updatehero(){
				$('iframe').attr({src:"updatehero.php"});
			}
			function addhero(){
				$('iframe').attr({src:"addhero.php"});
			}
			function groupscore(){
				$('iframe').attr({src:"groupscore.php?word=a"});
			}
		</script>
    </body>
</html>