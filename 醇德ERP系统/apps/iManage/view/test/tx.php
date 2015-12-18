<html>
	<head>
		<meta charset="utf-8">
		<title>title</title>
	</head>
	<body>
		<button>更新图片</button>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
		<script type="text/javascript">
			$("button").click(function(){
				$.post("<?=$this->url('goods/updateGoodsImg')?>",{},function(res){
					console.log(res);
				},'json');
			});
		</script>
	</body>
</html>