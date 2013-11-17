						<div id="picture" class="form-body modify-face">
                            <div class="form-info">
							<p><?php LO('modules__userHeaderEdit__choosePic');?></p>
                            </div>
							<script type="text/javascript">
                            var imageSize = '<?php echo MAX_UPLOAD_FILE_SIZE;?>';
                            var flashvars={
                                        uidUrl:_userInfo.avatar,
                                        tmpUrl:_userInfo._uploadPicApi,
                                        imgUrl:_userInfo._savePicApi,
                                        imageSize:imageSize,
                                        _PHPSESSID:'<?php echo session_id();?>',
                                        _PHPSESSUID:_userInfo.sina_uid,
                                        uploadField:'avatarFile',
                                        jsFunc:"jsFun",
                                        background:"0xffffff"
                                        };
                            var params = {
                                        AllowScriptAccess:"always",
                                        wmode:"opaque"
                                        };
                            swfobject.embedSWF("<?php echo W_BASE_URL;?>flash/face.swf", "avatarSwf", "650", "450", "9.0.0", "<?php echo W_BASE_URL;?>flash/expressInstall.swf",flashvars,params);
                            function jsFun(returnCode){
                                var errText = '';
                                switch(+returnCode) {
                                    case 40012:
										errText = '<?php LO('modules__userHeaderEdit__imageSize1');?>'+imageSize+'<?php LO('modules__userHeaderEdit__imageSize2');?>';
                                        break;
                                    case 40013:
										errText = '<?php LO('modules__userHeaderEdit__imageTypeError');?>';
                                        break;
                                    case 40001:
                                    case 40002:
                                    case 40003:
                                    case 40050:
										errText = '<?php LO('modules__userHeaderEdit__saveHeaderError');?>';
                                        break;
                                    case 40010:
										errText = '<?php LO('modules__userHeaderEdit__DamageImage');?>';
                                        break;
                                    case 40051:
                                        // 开始上传
                                        Xwb.ui.MsgBox.getTipBox().autoHide = false;
										Xwb.ui.MsgBox.tipWarn('<?php LO('modules__userHeaderEdit__imageUploading');?>');
                                        break;
									case 1040016:
										errText = '<?php LO('modules__userHeaderEdit__notAllowModify');?>';
										break;
                                    case 0:
										errText = '<?php LO('modules__userHeaderEdit__modifySuccess');?>';
                                        Xwb.ui.MsgBox.success('', errText, function(){
                                            Xwb.ui.MsgBox.getTipBox().display(false);
                                            location.href = Xwb.request.mkUrl('index');
                                        });
                                        
                                        // 按不按确定都跳转
                                        setTimeout(function() {
                                            location.href = Xwb.request.mkUrl('index');
                                        },3000);
                                        return;
                                }
                                if(errText){
                                    Xwb.ui.MsgBox.getTipBox().display(false);
                                    Xwb.ui.MsgBox.alert('', errText);
                                }
                            }
                            function requestLanguage_xweibo_flash(){
                    			var language = new Object();
								language["CX0182"] = "<?php LO('modules__userHeaderEdit__chooseHeaderPic');?>";
								language["CX0184"] = "<?php LO('modules__userHeaderEdit__loadingPicWaitFor');?>";
								language["CX0186"] = "<?php LO('common__template__cancel');?>";
								language["CX0187"] = "<?php LO('modules__userHeaderEdit__browse');?>";
								language["CX0188"] = "<?php LO('common__template__save');?>";
								language["CX0189"] = "<?php LO('modules__userHeaderEdit__imageUploadNotice1');?>";
								language["CX0190"] = "<?php LO('modules__userHeaderEdit__imageUploadNotice2');?>";
								language["CX0191"] = "<?php LO('modules__userHeaderEdit__imageUploadNotice3');?>";
								language["CX0192"] = "<?php LO('modules__userHeaderEdit__imageUploadNotice4');?>";
								language["CX0194"] = "<?php LO('modules__userHeaderEdit__rotate');?>";
								language["CX0195"] = "<?php LO('modules__userHeaderEdit__rotateLeft');?>";
								language["CX0196"] = "<?php LO('modules__userHeaderEdit__imageTypeLimit');?>";
								language["CX0197"] = "<?php LO('modules__userHeaderEdit__editor');?>";
								language["CX0198"] = "<?php LO('modules__userHeaderEdit__previewArea');?>";
                    			language["CX0197"] = "<?php LO('modules__userHeaderEdit__editor');?>";
                    			language["CX0198"] = "<?php LO('modules__userHeaderEdit__previewArea');?>";

                    			return language;
                    		}
                            </script>
                            <div id='avatarSwf'></div>
                        </div>
