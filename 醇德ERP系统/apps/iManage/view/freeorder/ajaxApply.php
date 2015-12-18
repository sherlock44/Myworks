<?foreach ($re as $value) {?>
<?foreach($value['timenum'] as $k=>$val){?>
<tr>
	<?if($k==0){?>
	<td  rowspan="<?=count($value['timenum'])?>"><?=$value['fctitle']?></td>
	<td rowspan="<?=count($value['timenum'])?>"><?=$value['title']?></td>
	<td  rowspan="<?=count($value['timenum'])?>">
	<?if(empty($value["imgpath"])){?>
		<img width=25 height=25   src="/public/assets/sysadmin/img/default.png">
		<?}else{?>
		<a href="<?=$value["imgpath"]?>" target="_black">
		<img width=25 height=25   src="<?=$value["imgpath"]?>">
		</a>
		<?}?>
	</td>
	<td  rowspan="<?=count($value['timenum'])?>"><?=$value['barcode']?></td>
	<td  rowspan="<?=count($value['timenum'])?>" ><?=!empty($value['shelflife'])?$value['shelflife']:'--'?></td>
	<td   rowspan="<?=count($value['timenum'])?>"><?=$value['weight']?>g/<?=$value['specs']?></td>
	<?}?>
	<td>¥ <?=$val['price']?>/<?=$value['specs']?></td>
	<td><?if(empty($value['shelflife'])){echo '--';}else{echo date("Y-m-d",empty($val['productontime'])?time():$val['productontime']);}?></td>
	<td  ><?=$value['boxnum']?><?=$value['specs']?>/箱</td>
	<td >
	<div class="input-group input-group-sm">
		<input type="text" id="goodsnum_<?=$value['id']?>_<?=$val['tag']?>" name="goodsnum_<?=$value['id']?>_<?=$val['tag']?>" onchange="changenum(this.value,<?=$value['id']?>,<?=$val['tag']?>)" value="" class="form-control" data-rule-required="false" data-rule-number="true" data-rule-minlength="1" placeholder="限数字">
		<span class="input-group-btn">
          <button class="btn btn-success" style="font-weight: bold;" type="button">箱</button>
        </span>
		<!-- <span class="input-group-addon">箱</span> -->
   	</div>
	<input type="hidden" name="tag[]" value="<?=$val['tag']?>">
	<input type="hidden" name="hasnum[]" id="hasnum_<?=$value['id']?>" value="<?=$val['number']?>">
	<input type="hidden" name="productontimeid[]" value="<?=$val['productontimeid']?>">
	<input type="hidden" name="goodsid[]" value="<?=$value['id']?>">
	<input type="hidden" id="boxnum_<?=$value['id']?>" name="boxnum_<?=$value['id']?>"  value="<?=$value['boxnum']?>">
	</td>
</tr>
<?}?>
<?}?>