<?php
	session_start();
	include "inc/chec.php";
	include "conn/conn.php";
	include "inc/func.php";
	$p_type = array("jpg","jpeg","bmp","gif");
	$f_type = array("avi","rm","rmvb","wav","mp3","mpg");
	$audio_path = "../upfiles\\audio";
	$video_path = "../upfiles\\video";
	$picture_path ="";
	$file_path = "";
	/*  �ж��ϴ�ͼƬ���ͺ��ļ���С���ϴ�ͼƬ */
	if($_FILES[picture][size] > 0 and $_FILES[picture][size] < 700000){
		if(($postf = f_postfix($p_type,$_FILES[picture][name])) != false){
			$picture_path = time().".".$postf;
			if($_POST[action] == "a"){
				if($_FILES[picture][tmp_name])
					move_uploaded_file($_FILES[picture][tmp_name],$audio_path."\\".$picture_path);
				else{
					echo "<script>alert('�ϴ�ͼƬʧ�ܣ�');history.go(-1);</script>";
					exit();
				}
			}else if($_POST[action] == "v"){
				if($_FILES[picture][tmp_name])
					move_uploaded_file($_FILES[picture][tmp_name],$video_path."\\".$picture_path);
				else{
					echo "<script>alert('�ϴ�ͼƬʧ�ܣ�');history.go(-1);</script>";
					exit();
				}
			}
		}else{
			echo "<script>alert('�ϴ�ͼƬ��ʽ����111');history.go(-1);</script>";
			exit();
		}
	}else if($_FILES[picture][size] > 700000){
			echo "<script>alert('�ϴ�ͼƬ��С������Χ��');history.go(-1);</script>";
			exit();
	}
	else{
		$picture = "";
	}
	/******************************/
	/*  �ж��ϴ��ļ��������С���ϴ��ļ�  */
	if($_FILES[address][size] > 0){
		//�������Ƶ�ļ�
		if($_POST[action] == "a"){
			if($_FILES[address][size] < 300000000){
				if(($postf = f_postfix($f_type,$_FILES[address][name])) != false){
					$file_path = time().".".$postf;
					if($_FILES[address][tmp_name])
						move_uploaded_file($_FILES[address][tmp_name],$audio_path."\\".$file_path);
					else{
						echo "<script>alert('�ϴ��ļ�����');history.go(-1);</script>";
						exit();
					}
				}
				else{
					echo "<script>alert('�ϴ��ļ���ʽ����');history.back(-1);</script>";
					exit();
				}
			}else{
				echo "<script>alert('�ϴ��ļ���С����');history.go(-1);</script>";
				exit();
			}
		}
		//�������Ƶ�ļ�
		else if($_POST[action] == "v"){
			if($_FILES[address][size] < 10000000){
				if(($postf = f_postfix($f_type,$_FILES[address][name])) != false){
					$file_path = time().".".$postf;
					if($_FILES[address][tmp_name])
						move_uploaded_file($_FILES[address][tmp_name],$video_path."\\".$file_path);
					else{
						echo "<script>alert('�ϴ��ļ�����');history.go(-1);</script>";
						exit();
					}
				}
				else{
					echo "<script>alert('�ϴ��ļ���ʽ����');history.back(-1);</script>";
					exit();
				}
			}else{
				echo "<script>alert('�ϴ��ļ���С����');history.go(-1);</script>";
				exit();
			}
		}
	}else{
		echo "<script>alert('û���ϴ��ļ����ļ�����300M');history.go(-1);</script>";
		exit();
	}
	/****************/
	/*  ��ͬ����Ϣ  */
	$names = $_POST[names];					//��Ƶ����
	$grade = $_POST[grade];					//����
	$sizes = $_FILES[address][size];
	$publisher = $_POST[publisher];			
	$actor = $_POST[actor];
	$language = $_POST[language];
	$style = $_POST[style];
	$types = $_POST[types];
	$froms = $_POST[from];
	$publishtime = $_POST[publishtime];
	$news = $_POST[news];
	$remark = $_POST[remark];
	
	/*****************/
	if($_POST[action] == "a"){
		/*  ȷ�ϸ���Ŀ¼  */
		//����·��
		//��ֵ
		$director = $_POST[director];
		$marker = $_POST[marker];
		$a_sqlstr = "insert into tb_audio (name,picture,sizes,grade,publisher,actor,director,marker,languages,type,style,froms,publishtime,bool,remark,property,address,username,issueDate)  values('$names','$picture_path','$sizes','$grade','$publisher','$actor','$director','$marker','$language','$types','$style','$from','$publishtime','$news','$remark','����Ա','$file_path','$_SESSION[admin]','".date("Y-m-d H:i:s")."')";
	}
	else if($_POST[action] == "v"){
		//����·��
		$actortype = $_POST[actortype];
		$ci = $_POST[ci];
		$qu = $_POST[qu];
		$a_sqlstr = "insert into tb_video (name,picture,actor,ci,qu,actortype,type,style,publisher,froms,sizes,languages,publishTime,remark,property,address,userName,issueDate) values('$names','$picture_path','$actor','$ci','$qu','$actortype','$types','$style','$publisher','$froms','$sizes','$language','$publishtime','$remark','����Ա','$file_path','$_SESSION[admin]','".date("Y-m-d H:i:s")."')";
	}
	else
	{
		echo "<script>alert('����');window.close();</script>";
		exit();
	}
	$a_rst = $conn->execute($a_sqlstr);
	if(!($a_rst == false))
		echo "<script>top.opener.location.reload();alert('��ӳɹ�');window.close();</script>";
	else
		echo "<script>alert('���ʧ��');history.go(-1);</script>";
?>