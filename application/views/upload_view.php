<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Upload Multiple Thumnail.</title>
    <link href="<?php echo base_url().'assets/css/bootstrap.css'?>" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      
      <div class="row">
          <form class="form-horizontal" action="<?php echo site_url('upload/do_upload');?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
              <label for="FormControlTitle">Title:</label>
              <input type="text" name="title" class="form-control" id="FormControlTitle" required>
            </div>

            <div class="form-group">
              <label for="FormControlFile">File Image:</label>
              <input type="file" name="filefoto" class="form-control-file" id="FormControlFile" required>
            </div>

            <button type="submit" class="btn btn-primary">Upload</button>
          </form>
      </div>

    </div>
    <script src="<?php echo base_url().'assets/js/jquery-3.3.1.min.js'?>"></script>
    <script src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
  </body>
</html>
