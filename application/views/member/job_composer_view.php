<!--<link rel="stylesheet" href="/tools/fontawesome/css/font-awesome.min.css">//-->
<!--<link rel="stylesheet" href="/tools/summernote/summernote.css">//-->
<!--<script src="/tools/summernote/summernote.min.js"></script>//-->
<!--<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>//-->

<!-- <script src="/tools/geocomplete/jquery.geocomplete.js"></script> -->


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places&language=en"></script>


<script>	
	$(document).ready(function(){

	// Create the autocomplete object, restricting the search
	// to geographical location types.
	var input = document.getElementById('autocomplete');
	var options = {
		types: ['(cities)'],
	};

	autocomplete = new google.maps.places.Autocomplete(input,options);

	// When the user selects an address from the dropdown,
	// populate the address fields in the form.
	google.maps.event.addListener(autocomplete, 'place_changed', function() {
		fillInAddress();
	});


	});

	var geolocation;
	var autocomplete;
	var componentForm = {
		locality: 'long_name',
		administrative_area_level_1: 'long_name',
		country: 'long_name',
	};



	// The START and END in square brackets define a snippet for our documentation:
	// [START region_fillform]
	function fillInAddress() {
		// Get the place details from the autocomplete object.
		var place = autocomplete.getPlace();
		console.log(place);
		// console.log(place);
		for (var component in componentForm) {
			document.getElementById(component).value = '';
			document.getElementById(component).disabled = false;
		}

		// Get each component of the address from the place details
		// and fill the corresponding field on the form.
		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
				document.getElementById(addressType).value = val;
			}
		}
		document.getElementById("lat").value = place.geometry.location.lat();
		document.getElementById("lng").value = place.geometry.location.lng();

	}
	// [END region_fillform]

	// [START region_geolocation]
	// Bias the autocomplete object to the user's geographical location,
	// as supplied by the browser's 'navigator.geolocation' object.
	function geolocate() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
				geolocation = new google.maps.LatLng(
					position.coords.latitude, position.coords.longitude);
				autocomplete.setBounds(new google.maps.LatLngBounds(geolocation,
					geolocation));
			});
		}
	}
	// [END region_geolocation]



</script>

<script src="/tools/tinymce/tinymce.min.js"></script>

<script>
tinymce.init({
//	mode : "textareas"
    selector: '#editor',
	menubar:    false,
	statusbar:  false,
	height:     300,
	plugins: "paste"
});
</script>

<!-- Setting up variables for add or update -->
<?php 
	if($function === 'add'){
		$form_action = 'addPostToDataBase';
		$page_title = lang('zhidian_member_addpost');
	}elseif($function === 'update'){
		$form_action = 'updatePostFromDataBase';
		$page_title = lang('zhidian_member_editpost');
	}else{
		redirect('/');
	}
?>

<style type="text/css">
	.btn-default.active{
		/*background-color: #000;*/
	}
</style>

<div><h4>&nbsp;&nbsp;<?=$page_title?>
<a class="btn btn-info btn-sm pull-right" href="/member" style="margin-right:10px;"><span class="glyphicon glyphicon-arrow-left"></span> <?=lang('zhidian_back_to_dashboard')?> </a>
</h4></div><hr />
<div id="right_container" class="col-sm-8 col-sm-offset-2">
<?php if($this->session->flashdata('pid')):?>
		<div class="alert alert-success small_msg">
			<a href='/postdetail/<?=$this->session->flashdata('pid')?>'><?=lang('zhidian_postjob_succ')?></a>
		</div>
<?php endif;?>
<?php echo validation_errors('<p class="alert alert-warning small_msg" >');?>
<form method="post" accept-charset="utf-8" id="addPostForm" role="form" action="/member/<?=$form_action?>" onSubmit="save();" novalidate>

	<div class="form-group">
		<label><?=lang('zhidian_jobtitle')?></label>
		<input type="text" class="form-control" name="jobtitle" value="<?php echo isset($jobtitle)? set_value('jobtitle',$jobtitle): set_value('jobtitle');?>" required>
	</div>
	<div class="form-group">
		<label><?=lang('zhidian_jobcompany')?></label>
		<input type="text" class="form-control" name="company" value="<?php echo isset($company)?set_value('company',$company): set_value('company'); ?>" required>
	</div>

	<?php 
		$filter_industry_array = array(
					"Finance",
					"Technology",
					"Marketing",
					"Language",
					"Media",
					"Resturant",
					"Management",
					"Design",
					"Entertainment",
					"Service",
					"Sports",
					"Consulting",
					"International Commerce",
					"Engineering",
					"Law",
					"Art"
					);
	?>


	<div class="form-group">
		<label><?=lang('zhidian_jobindustry')?></label>
		<div data-toggle="buttons">
			<?php foreach($filter_industry_array as $fitler_industry_item):?>
				<label class="btn btn-default">
					<input type="radio" name="industry" value="<?=$fitler_industry_item?>"; 
						<?php echo isset($industry)? 
							set_radio('industry',$fitler_industry_item,$industry===$fitler_industry_item): 
							set_radio('industry',$fitler_industry_item); ?>
					>
					<?=lang('zhidian_filter_'.strtolower(str_replace(' ','_',$fitler_industry_item))) ?>
				</label>
			<?php endforeach;?>
		</div>
	</div>

	<div class="form-group">
		<label><?=lang('zhidian_joblocationsearch')?></label>
		<input id="autocomplete" name="user_entered_location" onFocus="geolocate()" type="text" class="form-control" placeholder="<?=lang('zhidian_jobenterlocation')?>"
		value="<?php echo isset($user_entered_location)?set_value('user_entered_location',$user_entered_location): set_value('user_entered_location'); ?>">
	</div>
		 
	<div class="form-inline">
		<div class="form-group">
			 <label for="locality"><?=lang('zhidian_jobcity')?></label>
			 <input type="text" class="form-control" id="locality" name="city"  readonly required
					value="<?php echo isset($city)? set_value('city',$city): set_value('city');?>"
			 >
		</div>	
		<div class="form-group">
			 <label  for="administrative_area_level_1"><?=lang('zhidian_jobstate')?></label>
			 <input type="text" class="form-control" id="administrative_area_level_1" name="state"  readonly required
					value="<?php echo isset($state)? set_value('state',$state): set_value('state');?>"
			 >
		</div>
		<div class="form-group">			 
			 <label  for="country"><?=lang('zhidian_jobcountry')?></label>
			 <input type="text" class="form-control" id="country" name="country"  readonly required
					value="<?php echo isset($country)? set_value('country',$country): set_value('country');?>"
			 >	 
		</div>	
	</div>
	
	<div class="form-group">
		 <input type="hidden" class="form-control" id="lat" name="latitude"  readonly required 
				value="<?php echo isset($latitude)? set_value('latitude',$latitude): set_value('latitude');?>"
		 >
		 
		 <input type="hidden" class="form-control" id="lng" name="longitude"  readonly required
				value="<?php echo isset($longitude)? set_value('longitude',$longitude): set_value('longitude');?>"
		 >
	</div>
	
	<div class="form-group">
		<label><?=lang('zhidian_jobsponsor')?></label>
		<div data-toggle="buttons">
			<label class="btn btn-default"><input type="radio" name="sponsor" value="None" <?php echo isset($sponsor)?set_radio('sponsor','None',$sponsor==='None'): set_radio('sponsor','None'); ?> ><?=lang('zhidian_jobnone')?></label>
			<label class="btn btn-default"><input type="radio" name="sponsor" value="H1B" <?php echo isset($sponsor)?set_radio('sponsor','H1B',$sponsor==='H1B'): set_radio('sponsor','H1B'); ?> ><?=lang('zhidian_filter_h1b')?></label>
		</div>
	</div>
	<div class="form-group">
		<label><?=lang('zhidian_jobmploymenttype')?></label>
		<div data-toggle="buttons">
			<label class="btn btn-default"><input type="radio" name="employment_type" value="Full Time" <?php echo isset($employment_type)?set_radio('employment_type','Full Time',$employment_type==='Full Time'):set_radio('employment_type','Full Time'); ?> ><?=lang('zhidian_filter_full_time')?></label>
			<label class="btn btn-default"><input type="radio" name="employment_type" value="Part Time" <?php echo isset($employment_type)?set_radio('employment_type','Part Time',$employment_type==='Part Time'):set_radio('employment_type','Part Time'); ?> ><?=lang('zhidian_filter_part_time')?></label>
			<label class="btn btn-default"><input type="radio" name="employment_type" value="Internship" <?php echo isset($employment_type)?set_radio('employment_type','Internship',$employment_type==='Internship'):set_radio('employment_type','Internship'); ?> ><?=lang('zhidian_filter_internship')?></label>
		</div>
	</div>
	<div class="form-group">
		<label><?=lang('zhidian_jobdescription')?></label>
		<textarea id="editor" class="form-control" rows="10" name="description"><?php echo isset($description)?set_value('description',$description):set_value('description'); ?></textarea>
	</div>
	<div class="form-group">
		<span class="help-block"><?=lang('zhidian_job_helpblock')?></span>
		<label><?=lang('zhidian_jobemail')?></label>
		<input type="email" class="form-control" name="email" value="<?php echo isset($email)?set_value('email',$email):set_value('email'); ?>" required>
		<label><?=lang('zhidian_joblink')?></label>
		<input type="url" class="form-control" name="link" value="<?php echo isset($link)?set_value('link',$link):set_value('link'); ?>">
	</div>


	<?php if($function === 'add'):?>
		<button type="submit" class="btn btn-primary btn-sm"><?=lang('zhidian_jobdsubmit')?></button>
	<?php elseif($function === 'update'):?>
		<input type="hidden" name="updatepid" value="<?php echo isset($updatepid)?$updatepid:'';?>"/>		
		<button type="button" class="btn btn-default" onclick="location.href='/member/viewpost'"><?=lang('zhidian_cancel')?></button>
		<button type="submit" class="btn btn-primary"><?=lang('zhidian_update')?></button>
	<?php endif;?>
</form>
<script type="text/javascript">
	$('input:checked').parent().addClass('active');

	/*$(document).ready(function() {
		$('textarea').summernote({
			height: 300,
			toolbar: [
			  ['font', ['bold', 'italic', 'underline', 'clear']],
			  ['color', ['color']],
			  ['para', ['ul', 'ol', 'paragraph']],
			  ['height', ['height']],
			  ['table', ['table']],
			  ['insert', ['link']],
			  ['view', ['fullscreen']]
			  ]
  		});
	});
	function save(){
		$('textarea').each( function() {
			$(this).val($(this).code());
		});
	}*/
</script>
</div>