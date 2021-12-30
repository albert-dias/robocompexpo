<script type="text/javascript">
	var base_url = '<?= $this->Url->build('/', true) ?>';
</script>
     <!--Morris Chart-->
    <script src="../"></script>
    <script src="../"></script>
    
<?= $this->Html->script('/assets/js/bootstrap.bundle.min.js') ?>
<?= $this->Html->script('/assets/js/jquery.slimscroll.js') ?>
<?= $this->Html->script('/assets/js/waves.min.js') ?>
<?= $this->Html->script('/assets/plugins/morris/morris.min.js') ?>
<?= $this->Html->script('/assets/plugins/raphael/raphael.min.js') ?>
<?= $this->Html->script('/assets/pages/dashboard.init.js') ?>
<?= $this->Html->script('/assets/js/jQuery-Mask-Plugin-master/src/jquery.mask.js') ?>
<?= $this->Html->script('/assets/plugins/parsleyjs/parsley.min.js') ?>

<?= $this->Html->script('/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>
<?= $this->Html->script('/assets/js/app.js') ?>

<?php
$p = $this->request->params['controller'];
$temp_url = explode('/', $this->Url->build());
if(in_array('upload', $temp_url)):
?>

<?= $this->Html->script('/plugins/jquery-file-upload-master/js/tmpl.min.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/load-image.all.min.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/canvas-to-blob.min.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.blueimp-gallery.min.js') ?>

<?= $this->Html->script('/plugins/jquery-file-upload-master/js/vendor/jquery.ui.widget.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.iframe-transport.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.fileupload.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.fileupload-process.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.fileupload-image.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.fileupload-audio.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.fileupload-video.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.fileupload-validate.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/jquery.fileupload-ui.js') ?>
<?= $this->Html->script('/plugins/jquery-file-upload-master/js/main.js') ?>
<?php
endif;
?>
