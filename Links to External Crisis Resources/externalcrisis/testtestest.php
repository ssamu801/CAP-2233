<?php include('db_connect.php');
 include('./header.php'); 
?>

<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Custom CSS for navbar */
        .navbar-color {
            background-color: #0b5523; /* Navbar background color */
            overflow: hidden;
        }

        .nav-link {
            color: #ffffff; /* Text color for links */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
            border-radius: 30px;
            
        }

        .dropdown-item {
            color: #ffffff; /* Text color for links */
            transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
            padding-right: 100px;
        }

        /* Active link color */
        .nav-link.active-link{
            color: #0b5523; /* Text color for active links */
            background-color: #ffffff; /* Background color for active links */
            border-radius: 30px;
        }

        @media (min-width: 768px) {

            ul{
                margin-left: -10px;
            }

            .nav li.submenu {
                width:500%;
                border-radius: 30px;
            }

            .nav li:hover {
                background-color: #ffffff; /* Background color for links on hover */
                border-radius: 30px;
                transition: background-color 0.3s, color 0.3s;
                color: #0b5523;
            }

            .nav-link:hover{
                color: #0b5523; /* Text color for links on hover */
                border-radius: 30px;
            }
            .dropdown-item:hover {
                color: #0b5523; /* Text color for links on hover */
                background-color: #ffffff; /* Background color for links on hover */
                transition: background-color 0.3s, color 0.3s;
            }
        }

        /* Hover effect for smaller screens */
        @media (max-width: 767px) {
            .nav-link:hover,
            .dropdown-item:hover {
                color: #0b5523; /* Text color for links on hover */
                background-color: #ffffff; /* Background color for links on hover */
            }
        }

        .bi {
            color: #ffffff; /* Color for icons */
        }

        input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  transform: scale(1.5);
  padding: 10px;
}
.list-group-item +  .list-group-item {
    border-top-width: 1px !important;
}

td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height:150px;
	}
    </style>
</head>
<body>

<div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
        <div class="col-12 col-sm-3 col-xl-2 px-sm-2 navbar-color px-0 d-flex sticky-top ">
            <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                <a href="/" class="d-flex align-items-center pb-sm-3 px-sm-2 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5">B<span class="d-none d-sm-inline">rand</span></span>
                </a>
                <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item submenu">
                        <a href="#" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    <li class="submenu">
                        <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-speedometer2"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                    </li>
                    <li class="submenu">
                        <a href="#" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-table"></i><span class="ms-1 d-none d-sm-inline">Orders</span></a>
                    </li>
                    <li class="dropdown submenu">
                        <a href="#" class="nav-link dropdown-toggle px-sm-3 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fs-5 bi-bootstrap"></i><span class="ms-1 d-none d-sm-inline">Bootstrap</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-grid"></i><span class="ms-1 d-none d-sm-inline">Products</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#" class="nav-link px-sm-3 px-2">
                            <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Customers</span> </a>
                    </li>
                </ul>
                <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="28" height="28" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">Joe</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col d-flex flex-column h-sm-100">
            <main class="row overflow-auto">
                <div class="col pt-4">
                <div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Topic List</b>
						<span class="">

							<button class="btn btn-primary btn-block btn-sm col-sm-2 float-right" type="button" id="new_topic">
					<i class="fa fa-plus"></i> Create Topic</button>
				</span>
					</div>
					<div class="card-body">
						<ul class="w-100 list-group" id="topic-list">
							<?php
							$tag = $conn->query("SELECT * FROM categories order by name asc");
							while($row= $tag->fetch_assoc()):
								$tags[$row['id']] = $row['name'];
							endwhile;
							$topic = $conn->query("SELECT t.*,u.name FROM topics t inner join users u on u.id = t.user_id order by unix_timestamp(date_created) desc");
							while($row= $topic->fetch_assoc()):
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						        $desc = strtr(html_entity_decode($row['content']),$trans);
						        $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
						        $view = $conn->query("SELECT * FROM forum_views where topic_id=".$row['id'])->num_rows;
						        $comments = $conn->query("SELECT * FROM comments where topic_id=".$row['id'])->num_rows;
						        $replies = $conn->query("SELECT * FROM replies where comment_id in (SELECT id FROM comments where topic_id=".$row['id'].")")->num_rows;
							?>
							<li class="list-group-item mb-4">
								<div>
									<?php if($_SESSION['login_id'] == $row['user_id'] || $_SESSION['login_type'] == 1): ?>
					                    <div class="dropleft float-right mr-4">
					                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					                        <span class="fa fa-ellipsis-v"></span>
					                      </a>
					                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					                        <a class="dropdown-item edit_topic" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Edit</a>
					                        <a class="dropdown-item delete_topic" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Delete</a>
					                      </div>
					                    </div> 	
									<?php else: ?>	
										<div class="dropleft float-right mr-4">
					                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					                        <span class="fa fa-ellipsis-v"></span>
					                      </a>
					                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					                        <a class="dropdown-item report_topic" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Report Post</a>
					                      </div>
					                    </div> 	
				                    <?php endif; ?>
				                    <span class="float-right mr-4"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($row['date_created'])) ?></i></small></span>
									<a href="index.php?page=view_forum&id=<?php echo $row['id'] ?>"
									 class=" filter-text"><?php echo $row['title'] ?></a>

								</div>
								<hr>
								<p class="truncate filter-text"><?php echo strip_tags($desc) ?></p>
								<?php if($row['isAnonymous'] == 1): ?>
    								<p class="row justify-content-left"><span class="badge badge-success text-white"><i>Posted anonymously</i></span></p>
								<?php else: ?>    
    								<p class="row justify-content-left"><span class="badge badge-success text-white"><i>Posted By: <?php echo $row['name'] ?></i></span></p>
								<?php endif; ?>

								<hr>
								
								<span class="float-left badge badge-secondary text-white"><?php echo number_format($view) ?> view/s</span>
								<span class="float-left badge badge-primary text-white ml-2"><i class="fa fa-comments"></i> <?php echo number_format($comments) ?> comment/s <?php echo $replies > 0 ? " and ".number_format($replies).' replies':'' ?> </span>
								<span class="float-right">
									<span>Tags: </span>
								<?php 
								foreach(explode(",",$row['category_ids']) as $cat):
								?>
								<span class="badge badge-info text-white ml-2"><?php echo $tags[$cat] ?></span>
							<?php endforeach; ?>
								</span>
							</li>
						<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
                </div>
            </main>
           
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
		$('table').dataTable()
	})
	$('#topic-list').JPaging({
	    pageSize: 15,
	    visiblePageSize: 10

	  });

	$('#new_topic').click(function(){
		uni_modal("New Entry","manage_topic.php",'mid-large')
	})
	
	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","manage_topic.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.delete_topic').click(function(){
		_conf("Are you sure to delete this topic?","delete_topic",[$(this).attr('data-id')],'mid-large')
	})

	$('.report_topic').click(function(){
		uni_modal("Report Post","manage_report_post.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	function delete_topic($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_topic',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
    // JavaScript to toggle active class on navbar items
    const navbarItems = document.querySelectorAll('.nav-link');
    navbarItems.forEach(item => {
        item.addEventListener('click', () => {
            navbarItems.forEach(item => item.classList.remove('active-link'));
            item.classList.add('active-link');
        });
    });
</script>
</body>
</html>
