<div id="eventfrm" class="form-area">
		<div class="form-item">
		<input type="hidden" name="id" value="<?php echo isset($event['id'])? $event['id']:'';?>"/>
		<label for="evt-tit"><em>*</em><?php LO('modules__evnetForm__title');?></label>
			<input class="input style-normal" type="text" warntip="#titleTip" vrel="_f=ch:1|ne=m:<?php LO('modules__evnetForm__titleMsg');?>|sz=max:40,ww,m:<?php LO('modules__evnetForm__titleLengthMsg');?>" value="<?php echo isset($event['title']) ? F('escape', $event['title']) : '';?>" name="title" id="evt-tit">
			<span id="titleTip" class="tips-wrong hidden" style=""><?php LO('modules__evnetForm__titleMsg');?></span>
            <span class="tips-ok hidden"></span>
		</div>
		<div class="form-item">
		<label for="evt-way"><?php LO('modules__evnetForm__phone');?></label>
            <input class="input style-normal" type="text" warntip="#phoneTip" vrel="_f=ch:1" value="<?php echo isset($event['phone']) ? F('escape', $event['phone']) : '';?>" name="phone" id="evt-way">
			<span id="phoneTip" class="tips-wrong hidden" style=""><?php LO('modules__evnetForm__phoneMsg');?></span>
            <span class="tips-ok hidden"></span>
		</div>
		<div class="form-item">
		<label for="evt-contact"><?php LO('modules__eventForm__realname');?></label>
            <input class="input style-normal" type="text" warntip="#realTip" vrel="_f=ch:1" value="<?php echo isset($event['realname']) ? F('escape', $event['realname']) : '';?>" name="realname" id="evt-contact">
			<span id="realTip" class="tips-wrong  hidden" style=""><?php LO('modules__eventForm__realnameMsg');?></span>
            <span class="tips-ok hidden"></span>
		</div>
		<div class="form-item">
		<label for="evt-spot"><em>*</em><?php LO('modules__evnetForm__addr');?></label>
			<input class="input style-normal" type="text" warntip="#addrTip" vrel="_f=ch:1|ne=m:<?php LO('modules__evnetForm__addrMsg');?>|sz=max:60,ww,m:<?php LO('modules__evnetForm__addrTooLongMsg');?>" value="<?php echo isset($event['addr']) ? F('escape', $event['addr']) : '';?>" name="addr" id="evt-spot">
			<span id="addrTip" class="tips-wrong hidden" style=""><?php LO('modules__evnetForm__addrMsg');?></span>
            <span class="tips-ok hidden"></span>
		</div>

		<div class="form-item">
		<label for="start_date"><em>*</em><?php LO('modules__evnetForm__startTime');?></label>
			<input class="input start style-normal" type="text" warntip="#startTip" vrel="_f=ch:1|ne=m:<?php LO('modules__eventForm__startTimeMsg');?>|chkdate" value="<?php echo date('Y-m-j',isset($event['start_time'])?$event['start_time']:time());?>" id="start_date" name="start_date">
			 <select class="hour" id="start_h" name="start_h">
			<?php
				$start_h = '';
				$start_m = '';
				if(isset($event['start_time'])){
					$start_h = date('G',$event['start_time']);
					$start_m = date('i',$event['start_time']);
				}

				for($i=0; $i < 24; $i++):
			?>

				<option value="<?php echo $i;?>"<?php if($start_h==$i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
			<?php endfor;?>

			</select>
			<select class="min" id="start_m" name="start_m">
			<?php
				for($i=0; $i < 60; $i++):
			?>
				<option value="<?php echo $i;?>"<?php if($start_m == $i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
			<?php
				endfor;
			?>
			</select>
<span id="startTip" class="tips-wrong hidden"></span>
</div>
<div class="form-item">
<label for="end_date"><em>*</em><?php LO('modules__eventForm__endTime');?></label>
	<input class="input start style-normal" type="text" warntip="#endTip" vrel="_f=ch:1|ne=m:<?php LO('modules__eventForm__endTimeMsg');?>" value="<?php echo date('Y-m-j',isset($event['end_time'])?$event['end_time']:time()+86400);?>" id="end_date" name="end_date">
			<select class="hour" id="end_h" name="end_h">
				<?php
					$end_h = '';
					$end_m = '';
					if(isset($event['end_time'])){
						$end_h = date('G',$event['end_time']);
						$end_m = date('i',$event['end_time']);
					}
					for($i=0; $i < 24; $i++):
				?>
					<option value="<?php echo $i;?>"<?php if($end_h==$i):?> selected<?php endif;?>><?php echo sprintf('%02d', $i);?></option>
				<?php endfor;?>
			</select>
			<select class="min" id="end_m" name="end_m">
				<?php
					for($i=0; $i < 60; $i++):
				?>
					<option value="<?php echo $i;?>"<?php if ($end_m==$i):?> selected<?php endif;?>><?php echo sprintf("%02d", $i);?></option>
				<?php
					endfor;
				?>
			</select>
			<span id="endTip" class="tips-wrong hidden"></span>
		</div>
		<div class="form-item">
		<label for="cost"><?php LO('modules__eventForm__cost');?></label>
			<div class="money">
			<span class="f-radio">
			<label class="free" for="s1"><input type="radio" <?php if(!isset($event['cost']) || !$event['cost']){ echo 'checked="checked"';}?> value="0" name="a1" id="s1"><?php LO('modules__eventForm__freeCost');?></label>
				<input type="radio" value="1" <?php if(isset($event['cost']) && $event['cost']>0){ echo 'checked="checked"';}?> vrel="cost" name="a1" id="s2">
				<input vrel="_f=ch:1" type="text" value="<?php echo isset($event['cost']) && $event['cost']>0 ? $event['cost'] : '';?>" name="cost" id="cost" class="input input-sort style-normal <?php if (isset($event['cost']) && $event['cost'] > 0):?>style-disabled<?php endif;?>" >
<?php LO('modules__eventForm__cost__units');?>	
			</span>
			</div>
			<span id="costTip" class="tips-wrong hidden"><?php LO('modules__eventForm__cost__units');?></span>
		</div>
		<div class="form-item">
		<label for="cost"><?php LO('modules__eventForm__other');?></label>
		<span class="f-check f-checks"><input name="other" value="2" <?php if (isset($event['other']) && $event['other'] == 2):?>checked="checked"<?php endif;?> type="checkbox"/><?php LO('modules__eventForm__otherTip');?></span>
		</div>
		<div class="form-item">
		<label for="evt-intro"><em>*</em><?php LO('modules__eventForm__desc');?></label>
			<textarea warntip="#descTip" vrel="_f=ch:1|ne=m:<?php LO('modules__eventForm__descMsg');?>|sz=max:2000,m:<?php LO('modules__eventForm__descLengthMsg');?>" rows="" cols="" name="desc" class="input input-area style-normal" id="evt-intro"><?php echo isset($event['desc']) ? F('escape', $event['desc']) : '';?></textarea>
			<span id="descTip" class="tips-wrong hidden" style=""><?php LO('modules__eventForm__descMsg');?></span>
            <span class="tips-ok hidden"></span>
		</div>
		<div class="form-item">
		<label><?php LO('modules__eventForm__pic');?></label>
			<div class="cover-area">
				<div class="cover-pic">
				<span class="hidden" id="uploading"><?php LO('modules__eventForm__uploading');?></span>
						<img id="cover_img" src="<?php if (isset($event['pic'])):?><?php echo F('fix_url',$event['pic']); else: echo W_BASE_URL;?>img/event_cover.jpg<?php endif;?>">
					<span class="loading hidden" id="pic_loading"></span>
				</div>
				<input type="hidden" id="event_pic" name="event_pic">
				<form target="xwb_upload_frame_5" method="post" enctype="multipart/form-data" id="uploadImg" name="uploadImg">
					<input type="file" id="upload_pic" name="pic">
				<input type="hidden" name="callback"></form>
				<p><?php LO('modules__eventForm__picReq');?></p>
			</div>
		</div>


		<div class="operate-area">
		<a id="create" href="#" class="btn-ffirm"><?php LO('modules__eventForm__submit');?></a>
		</div>

</div>
