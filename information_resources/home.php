<?php include 'db_connect.php' ?>
<style>
   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    color: #ffffff96;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}

    .tm-site-header {
    position: relative;
    overflow: hidden;
    margin: -15px; 
}

.background-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('img/rise-of-the-YA-novel1.jpg') no-repeat;
    background-size: cover;
    opacity: 0.3; /* Adjust the opacity as desired */
    z-index: -1;
    background-color:red;
}

.text-container {
    position: relative;
    z-index: 1;
    padding: 80px;
}

.tm-site-name {
    /* Styles for the site name text */
}


</style>

<div class="tm-site-header">
    <!-- Background image with opacity -->
    <div class="background-image"></div>

    <!-- Text container -->
    <div class="text-container">
        <h1 class="tm-site-name">WASP Information and Resources Repository</h1>
    </div>
</div>

<div class="container-fluid">
    <div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
	</div>
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body bg-primary">
                                    <a href="index.php?page=information_resources/articles">
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="bi bi-newspaper"></i></span>
                                        <div style='width:90%;'>
                                            <h4><b class="whole-words">
                                                Articles
                                            </b></h4>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body bg-info">
                                    <a href="index.php?page=information_resources/medias">   
                                    <div class="card-body text-white">
                                        <span class="float-right summary_icon"><i class="bi bi-image"></i></span>
                                        <div style='width:90%;'>
                                            <h4><b class="whole-words">
                                                Media Contents
                                            </b></h4>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
             
                        
                    </div>	
<!--
                    <hr class="divider" style="max-width: 100%">
                    <h4><i class="fa fa-tags text-primary"></i> Tags</h4>
                    <div class="row">
                    <?php
                     $tags = $conn->query("SELECT * FROM categories order by name asc");
                     while($row=$tags->fetch_assoc()):
                    ?>
                        <div class="col-md-3">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p>
                                    <large><i class="fa fa-tag text-primary"></i> <b><?php echo $row['name'] ?></b></large>
                                </p>
                                <hr class="divider" style="max-width: 100%">
                                <p><small><i><?php echo $row['description'] ?></i></small></p>
                            </div>
                        </div>
                        </div>
                    <?php endwhile; ?>
                    </div> -->
                </div>
            </div>      			
        </div>
    </div>
</div>
<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>