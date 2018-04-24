# ////////////////// HOW TO USE IT ////////////////////////
# //SANI: Create object

> $photo = new  Photographs();

# SANI: Uploading Image from file
> $photo->file_allowed 	= "jpg|jpeg|png|gif";
> $photo->uploading_path 	= "images/";

> $singleFile    = $photo->upload_file('sani'); print_r($file);
> $myltipleFiles = $photo->upload_file('hyne'); print_r($file2);

# SANI: Resizing image
> $photo->resize_image    = true;
> $photo->resize_max_size = 800;
> $source_file 			= "images/"."152456375283615245637529987.png";
> $target_file            = "images/"."thumb_152456375283615245637529987.png";
> echo $photo->resizing_image($source_file, $target_file);

#SANI: Watermark image
> SANI: Make sure water mark image is smaller than original image in dimension
> $photo->create_watermark= true;
> $photo->watermark_file  = "images/watermark.png";
> $source_file 			= "images/b.jpg";
> $target_file            = "images/watermark_b.jpg";
> echo $photo->watermark_image($source_file, $target_file);


# SANI: Uploading Image & resize from file
> $photo->file_allowed 	= "jpg|jpeg|png|gif";
> $photo->uploading_path 	= "images/";

> $singleFile    = $photo->upload_file('sani'); 
> if(isset($singleFile) && is_array($singleFile))
> {	
> 	foreach($singleFile as $file)
> 	{
> 		$photo->resize_image    = true;
> 		$photo->resize_max_size = 800;
> 		$photo->resizing_image($photo->uploading_path.$file, $photo->uploading_path.$file);
> 		$photo->create_watermark= true;
> 		$photo->watermark_file  = "images/watermark.png";
> 		$photo->watermark_image($photo->uploading_path.$file, $photo->uploading_path.$file);
> 	}
> }

> $myltipleFiles = $photo->upload_file('hyne'); 
> if(isset($myltipleFiles) && is_array($myltipleFiles))
> {   
> 	foreach($myltipleFiles as $file)
> 	{
> 		$photo->resize_image    = true;
> 		$photo->resize_max_size = 800;
> 		$photo->resizing_image($photo->uploading_path.$file, $photo->uploading_path.$file);
> 		$photo->create_watermark= true;
> 		$photo->watermark_file  = "images/watermark.png";
> 		$photo->watermark_image($photo->uploading_path.$file, $photo->uploading_path.$file);
> 	}
> }

# HTML example
<hr />
<br />
<form enctype="multipart/form-data" method="post">
	<label>File to upload</label><input type="file" name="sani" /><br />
    
    <label>Array File</label><br />
    <input type="file" name="hyne[]" /><br />
    <input type="file" name="hyne[]" /><br />
    <input type="file" name="hyne[]" /><br />
    
    <input type="submit" value="Upload file"  />
</form>
