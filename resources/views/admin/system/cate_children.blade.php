@extends('app')
@section('content')
<div class="container">
	<div class="form-group gallery photo-border" id="gallery_div" style="display: block">
		<ul id="gallery" class="house-photo">
			@if(isset($gallery_list))
				@foreach($gallery_list as $gallery)
					<li>
						<img data-original="{{$gallery}}" src="{{$gallery}}">
					</li>
				@endforeach
			@endif
		</ul>

		<div class="weui_uploader_input_wrp">
			@foreach($gallery_list as $img)
				<input name="new_gallery[]" type="hidden" value="{{ $img }}"/>
			@endforeach
			<input class="weui_uploader_input layui-upload-file" type="file" name="file" id="file" accept="image/jpg,image/jpeg,image/png,image/gif"/>
		</div>
	</div>
	<div class="form-group do" style="display: block;">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn btn-primary" id="saveImage">保存</button>
		</div>
	</div>

	<script>
		$('#saveImage').click(function(){
			var img = '';
			$('img').each(function() {
				img += $(this).attr('src') + ',';
			});
			var id = "{{$id}}";
			$.ajax({
				url: '/admin/system/cates/images',
				type: 'post',
				dataType:'json',
				data:{id:id,images:img,_token:"{{csrf_token()}}"},
				success: function(result) {
					if(result.code==1){
						alert(result.msg);
						setTimeout(function(){
							window.location.reload();
						},500);
					}else{
						alert(result.msg);
					}
				},
				error:function(jqXHR,textStatus, errorThrown ){
					alert(errorThrown);
				}
			});
		});
	</script>
</div>
@endsection
